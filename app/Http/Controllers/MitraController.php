<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MitraController extends Controller
{
    // Kelola Data Mitra (Admin Distributor)
    public function index()
    {
        if (session('role') !== 'admin') {
            return redirect('/pelanggan?status=akses_ditolak');
        }

        $mitra = DB::table('mitra')->get();
        return view('admin', compact('mitra'));
    }

    public function store(Request $request)
    {
        if (session('role') !== 'admin') {
            abort(403, 'Hanya admin yang boleh mengelola mitra.');
        }

        $request->validate([
            'nama_mitra' => 'required|string|max:100',
            'pemilik' => 'required|string|max:100',
            'no_hp' => 'required|string|max:30',
            'alamat' => 'required|string|max:1000',
        ]);

        DB::table('mitra')->insert([
            'nama_mitra'   => $request->nama_mitra,
            'pemilik'      => $request->pemilik,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
            'created_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Data Mitra berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        if (session('role') !== 'admin') {
            abort(403, 'Hanya admin yang boleh menghapus mitra.');
        }

        DB::table('mitra')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data Mitra berhasil dihapus!');
    }
}
