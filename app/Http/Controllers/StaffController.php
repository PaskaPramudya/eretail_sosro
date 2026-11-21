<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaffController extends Controller
{
    // Operasional Penjualan & Pengiriman (Staff Distributor)
    public function kelolaPenjualan()
    {
        if (session('role') !== 'staff') {
            return redirect('/pelanggan?status=akses_ditolak');
        }

        $query = DB::table('pesan');
        $statusColumn = Schema::hasColumn('pesan', 'status_pesanan') ? 'status_pesanan' : 'status_bayar';

        // Staff dapat melihat seluruh pesanan untuk kebutuhan operasional.
        // Namun proses hanya boleh dilakukan setelah Admin memverifikasi pembayaran.
        $pesanan = $query
            ->orderByDesc('id')
            ->get();

        $statusColumn = $statusColumn;

        return view('staff', compact('pesanan', 'statusColumn'));
    }

    public function prosesPesanan($id)
    {
        if (session('role') !== 'staff') {
            abort(403, 'Hanya staff yang boleh memproses pesanan.');
        }

        $this->updateOperationalStatus($id, 'Diproses');
        return redirect()->back()->with('success', 'Pesanan sedang diproses!');
    }

    public function aturPengiriman(Request $request, $id)
    {
        if (session('role') !== 'staff') {
            abort(403, 'Hanya staff yang boleh mengatur pengiriman.');
        }

        $request->validate([
            'metode_pengiriman' => 'required|string|max:100',
            'nomor_resi' => 'nullable|string|max:100',
        ]);

        $data = [
            'metode_pengiriman' => $request->metode_pengiriman,
        ];

        if (Schema::hasColumn('pesan', 'nomor_resi')) {
            $data['nomor_resi'] = $request->nomor_resi;
        }

        $statusColumn = Schema::hasColumn('pesan', 'status_pesanan') ? 'status_pesanan' : 'status_bayar';
        $data[$statusColumn] = 'Dalam Pengiriman';
        DB::table('pesan')->where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Pengiriman berhasil diatur!');
    }

    public function selesaikanPesanan($id)
    {
        if (session('role') !== 'staff') {
            abort(403, 'Hanya staff yang boleh menyelesaikan pesanan.');
        }

        $this->updateOperationalStatus($id, 'Selesai');
        return redirect()->back()->with('success', 'Pesanan ditandai selesai.');
    }

    private function updateOperationalStatus($id, string $status): void
    {
        $statusColumn = Schema::hasColumn('pesan', 'status_pesanan') ? 'status_pesanan' : 'status_bayar';
        DB::table('pesan')->where('id', $id)->update([$statusColumn => $status]);
    }
}
