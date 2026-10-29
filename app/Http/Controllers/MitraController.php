<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MitraController extends Controller
{
    // Kelola Data Mitra (Admin Distributor)
    public function index()
    {
        $mitra = DB::table('mitra')->get();
        return view('admin', compact('mitra'));
    }

    public function store(Request $request)
    {
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
        DB::table('mitra')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data Mitra berhasil dihapus!');
    }
}