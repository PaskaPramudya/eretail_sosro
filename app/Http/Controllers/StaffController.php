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

        // Mengambil data dari tabel 'pesan' yang digunakan di database
        $pesanan = DB::table('pesan')->get();

        return view('staff', compact('pesanan'));
    }

    public function prosesPesanan($id)
    {
        // Update status di tabel 'pesan'
        DB::table('pesan')->where('id', $id)->update(['status_bayar' => 'Diproses']);
        return redirect()->back()->with('success', 'Pesanan sedang diproses!');
    }

    public function aturPengiriman(Request $request, $id)
    {
        // Update status pengiriman di tabel 'pesan'
        DB::table('pesan')->where('id', $id)->update([
            'status_bayar' => 'Dalam Pengiriman',
        ]);

        return redirect()->back()->with('success', 'Pengiriman berhasil diatur!');
    }
}