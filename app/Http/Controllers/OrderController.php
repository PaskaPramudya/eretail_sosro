<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Form pemesanan satuan per produk
    public function create($id)
    {
        $product = Product::findOrFail($id);
        return view('pelanggan.order', compact('product'));
    }

    // Process pemesanan dari Modal Checkout pelanggan
    public function prosesPesan(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_wa'        => 'required|string|max:20',
            'metode'       => 'required|string',
            'alamat'       => 'required|string|max:1000', // max diperluas untuk URL Google Maps
        ]);

        $cartItems = [];
        if ($request->filled('keranjang')) {
            $cartItems = json_decode($request->keranjang, true);
        }

        // Hitung total bayar dari keranjang atau dari input
        $totalBayar = 0;
        if (!empty($cartItems) && is_array($cartItems)) {
            foreach ($cartItems as $item) {
                $qty = intval($item['jumlah'] ?? 1);
                $harga = intval($item['harga'] ?? 0);
                $totalBayar += ($qty * $harga);
            }
        }
        if ($totalBayar <= 0) {
            $totalBayar = intval($request->input('total_bayar', 0));
        }

        try {
            DB::beginTransaction();

            // 1. Kurangi stok setiap produk yang dibeli
            if (!empty($cartItems) && is_array($cartItems)) {
                foreach ($cartItems as $item) {
                    $qty = intval($item['jumlah'] ?? 1);
                    $productId = $item['id'] ?? null;
                    $namaProduk = $item['nama'] ?? '';

                    $product = null;
                    if ($productId) {
                        $product = DB::table('produk')->where('id', $productId)->lockForUpdate()->first();
                    }
                    if (!$product && !empty($namaProduk)) {
                        $product = DB::table('produk')->where('nama_produk', $namaProduk)->lockForUpdate()->first();
                    }

                    if ($product) {
                        if ($product->stok < $qty) {
                            DB::rollBack();
                            return redirect('/pelanggan?status=stok_kurang');
                        }

                        DB::table('produk')
                            ->where('id', $product->id)
                            ->decrement('stok', $qty);
                    }
                }
            }

            // 2. Simpan pesanan sebagai Pending sebelum pembayaran Midtrans.
            $orderId = DB::table('pesan')->insertGetId([
                'nama_pemesan'      => $request->nama_pemesan,
                'no_wa'             => $request->no_wa,
                'metode_pengiriman' => $request->metode,
                'alamat'            => $request->alamat,
                'total_bayar'       => $totalBayar,
                'tanggal'           => date('Y-m-d'),
                'status_bayar'      => 'Pending',
            ]);

            if (!config('services.midtrans.server_key') || !Schema::hasColumn('pesan', 'midtrans_order_id')) {
                throw new \RuntimeException('Midtrans belum dikonfigurasi. Jalankan migration dan isi MIDTRANS_SERVER_KEY.');
            }

            $midtransOrderId = 'SOSRO-' . $orderId . '-' . Str::upper(Str::random(8));
            $items = collect($cartItems)->map(function ($item) {
                return [
                    'id' => (string) ($item['id'] ?? Str::slug($item['nama'] ?? 'produk')),
                    'price' => (int) ($item['harga'] ?? 0),
                    'quantity' => (int) ($item['jumlah'] ?? 1),
                    'name' => Str::limit((string) ($item['nama'] ?? 'Produk Sosro'), 50, ''),
                ];
            })->values()->all();

            $response = Http::withBasicAuth(config('services.midtrans.server_key'), '')
                ->acceptJson()
                ->post(config('services.midtrans.is_production')
                    ? 'https://app.midtrans.com/snap/v1/transactions'
                    : 'https://app.sandbox.midtrans.com/snap/v1/transactions', [
                        'transaction_details' => [
                            'order_id' => $midtransOrderId,
                            'gross_amount' => $totalBayar,
                        ],
                        'item_details' => $items,
                        'customer_details' => [
                            'first_name' => $request->nama_pemesan,
                            'phone' => $request->no_wa,
                        ],
                        'callbacks' => [
                            'finish' => url('/pelanggan?status=payment_finish'),
                        ],
                    ]);

            if (!$response->successful() || !$response->json('token')) {
                throw new \RuntimeException('Midtrans gagal membuat transaksi: ' . $response->body());
            }

            DB::table('pesan')->where('id', $orderId)->update([
                'midtrans_order_id' => $midtransOrderId,
                'midtrans_token' => $response->json('token'),
                'midtrans_status' => 'pending',
            ]);

            DB::commit();
            return redirect('/pelanggan?status=payment_pending&snap_token=' . urlencode($response->json('token')));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/pelanggan?status=pesan_failed');
        }
    }

    /** Midtrans HTTP notification/webhook. Jangan percaya status dari browser. */
    public function midtransNotification(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $status = $payload['transaction_status'] ?? null;
        $signature = $payload['signature_key'] ?? '';
        $expected = hash('sha512', ($orderId ?? '') . ($payload['status_code'] ?? '') . ($payload['gross_amount'] ?? '') . config('services.midtrans.server_key'));

        if (!$orderId || !hash_equals($expected, $signature)) {
            return response()->json(['message' => 'Invalid notification'], 403);
        }

        $paid = in_array($status, ['settlement', 'capture'], true);
        $failed = in_array($status, ['deny', 'cancel', 'expire', 'failure'], true);
        $data = ['midtrans_status' => $status];
        if ($paid) {
            $data['status_bayar'] = 'Lunas';
            $data['paid_at'] = now();
        } elseif ($failed) {
            $data['status_bayar'] = 'Gagal';
        }
        if (Schema::hasColumn('pesan', 'status_pesanan') && $paid) {
            $data['status_pesanan'] = 'Lunas';
        }
        DB::table('pesan')->where('midtrans_order_id', $orderId)->update($data);
        return response()->json(['message' => 'OK']);
    }

    // Simpan pesanan produk spesifik (versi Model Order)
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'product_id'       => 'required|exists:produk,id',
            'quantity'         => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stok < $request->quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
        }

        $totalPrice = $product->harga * $request->quantity;

        Order::create([
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'product_id'       => $product->id,
            'quantity'         => $request->quantity,
            'total_price'      => $totalPrice,
            'status'           => 'pending'
        ]);

        $product->decrement('stok', $request->quantity);

        return redirect()->route('pelanggan.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Daftar pesanan di Dashboard Admin
    public function adminOrders()
    {
        $orders = DB::table('pesan')->get();
        return view('admin', compact('orders'));
    }

    // Tracking Pengiriman (Mitra)
    public function trackingPengiriman($id)
    {
        $pesanan = DB::table('pesan')->where('id', $id)->first();
        return view('pelanggan.pelanggan', compact('pesanan'));
    }

    // Faktur Penjualan (Mitra)
    public function fakturPenjualan($id)
    {
        $pesanan = DB::table('pesan')->where('id', $id)->first();
        return view('pelanggan.pelanggan', compact('pesanan'));
    }

    // Verifikasi Pembayaran (Admin & Staff)
    public function verifikasiPembayaran($id)
    {
        if (session('role') !== 'admin') {
            abort(403, 'Hanya admin yang boleh memverifikasi pembayaran.');
        }

        $data = ['status_bayar' => 'Lunas'];
        if (Schema::hasColumn('pesan', 'status_pesanan')) {
            $data['status_pesanan'] = 'Lunas';
        }

        DB::table('pesan')->where('id', $id)->update($data);
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi!');
    }
}
