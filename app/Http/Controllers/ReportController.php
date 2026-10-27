<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Laporan Penjualan (Admin & Staff Distributor)
    public function laporanPenjualan()
    {
        $laporan = DB::table('pesanan')
            ->where('status', 'Selesai')
            ->get();

        return view('admin', compact('laporan'));
    }
}