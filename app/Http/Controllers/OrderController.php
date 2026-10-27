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
            'alamat'       => 'required|string',
        ]);

        // Menyimpan data ke tabel 'pesan' sesuai nama kolom asli di phpMyAdmin
        DB::table('pesan')->insert([
            'nama_pemesan'      => $request->nama_pemesan,
            'no_wa'             => $request->no_wa,
            'metode_pengiriman' => $request->metode, // Menggunakan kolom metode_pengiriman
            'alamat'            => $request->alamat,
            'total_bayar'       => $request->input('total_bayar', 0),
            'tanggal'           => date('Y-m-d'),
            'status_bayar'      => 'Pending',
        ]);

        return redirect('/pelanggan?status=pesan_success');
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