<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EretailController extends Controller
{
    public function pelanggan()
    {
        // Mengambil seluruh data produk dari tabel 'produk'
        $data_produk = DB::table('produk')->get();

        return view('pelanggan', compact('data_produk'));
    }

    public function admin()
    {
        $data_produk = DB::table('produk')->get();

        return view('admin', compact('data_produk'));
    }
}