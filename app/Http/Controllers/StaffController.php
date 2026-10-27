<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    // Operasional Penjualan & Pengiriman (Staff Distributor)
    public function kelolaPenjualan()
    {
        $pesanan = DB::table('pesanan')->latest()->get();
        return view('admin', compact('pesanan'));
    }

    public function prosesPesanan($id)
    {
        DB::table('pesanan')->where('id', $id)->update(['status' => 'Diproses']);
        return redirect()->back()->with('success', 'Pesanan sedang diproses!');
    }

    public function aturPengiriman(Request $request, $id)
    {
        DB::table('pesanan')->where('id', $id)->update([
            'status'         => 'Dalam Pengiriman',
            'resi_kurir'     => $request->resi_kurir ?? 'ARMADA-SOSRO-' . rand(100, 999),
        ]);

        return redirect()->back()->with('success', 'Pengiriman berhasil diatur!');
    }
}