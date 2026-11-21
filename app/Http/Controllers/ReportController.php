<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Laporan Penjualan (Admin & Staff Distributor)
    public function laporanPenjualan()
    {
        if (!in_array(session('role'), ['admin', 'staff'], true)) {
            return redirect('/pelanggan?status=akses_ditolak');
        }

        $laporan = DB::table('pesan')
            ->whereIn('status_bayar', ['Lunas', 'Selesai'])
            ->orderByDesc('id')
            ->get();

        return view('admin', compact('laporan'));
    }
}
