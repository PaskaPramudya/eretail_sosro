<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    // Operasional Penjualan & Pengiriman (Staff Distributor)
    public function kelolaPenjualan()
    {
        if (!session()->has('staff') && !session()->has('admin')) {
            return redirect('/pelanggan?status=admin_login_failed');
        }

        $pesanan = DB::table('pesanan')->get();

        // Diubah dari return view('admin', ...) menjadi view('staff', ...)
        return view('staff', compact('pesanan'));
    }

    public function prosesPesanan($id)
    {
        // Jika nama kolom primary key di phpMyAdmin id_pesanan, sesuaikan 'id' di bawah
        DB::table('pesanan')->where('id', $id)->update(['status' => 'Diproses']);
        return redirect()->back()->with('success', 'Pesanan sedang diproses!');
    }

    public function aturPengiriman(Request $request, $id)
    {
        DB::table('pesanan')->where('id', $id)->update([
            'status'     => 'Dalam Pengiriman',
            'resi_kurir' => $request->resi_kurir ?? 'ARMADA-SOSRO-' . rand(100, 999),
        ]);

        return redirect()->back()->with('success', 'Pengiriman berhasil diatur!');
    }
}