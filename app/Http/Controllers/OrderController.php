<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            // 2. Simpan data ke tabel 'pesan' sesuai kolom yang ada
            DB::table('pesan')->insert([
                'nama_pemesan'      => $request->nama_pemesan,
                'no_wa'             => $request->no_wa,
                'metode_pengiriman' => $request->metode,
                'alamat'            => $request->alamat,
                'total_bayar'       => $totalBayar,
                'tanggal'           => date('Y-m-d'),
                'status_bayar'      => 'Pending',
            ]);

            DB::commit();
            return redirect('/pelanggan?status=pesan_success');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/pelanggan?status=pesan_failed');
        }
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
        DB::table('pesan')->where('id', $id)->update(['status_bayar' => 'Lunas']);
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi!');
    }
}