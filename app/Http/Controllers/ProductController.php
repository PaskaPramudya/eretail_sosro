<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Impor Facade DB agar tidak error "Class DB not found"

class ProductController extends Controller
{
    // Halaman Katalog Pelanggan
    public function index()
    {
        $data_produk = Product::orderBy('id', 'desc')->get();
        return view('pelanggan.pelanggan', compact('data_produk'));
    }

    // Dashboard Manajemen Produk Admin
    public function adminIndex()
    {
        // Cek session admin
        if (!session()->has('admin')) {
            return redirect('/pelanggan?status=admin_login_failed');
        }

        $data_produk = Product::orderBy('id', 'desc')->get();
        return view('admin', compact('data_produk'));
    }

    // Simpan produk baru (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = $file->getClientOriginalName();
            $file->move(public_path('images'), $namaGambar);
        }

        // Disesuaikan dengan nama kolom file_gambar pada tabel produk
        DB::table('produk')->insert([
            'nama_produk' => $request->nama_produk,
            'kategori'    => $request->kategori,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'file_gambar' => $namaGambar
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // Update stok produk (Admin)
    public function updateStok(Request $request)
    {
        $request->validate([
            'id'     => 'required',
            'mode'   => 'required|in:tambah,set',
            'jumlah' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->id);

        if ($request->mode == 'tambah') {
            $product->stok += $request->jumlah;
        } else {
            $product->stok = $request->jumlah;
        }

        $product->save();

        return redirect()->back()->with('success', 'Stok barang berhasil diperbarui!');
    }

    // Edit nama gambar (Admin)
    // Edit nama gambar (Admin)
    public function editGambar(Request $request)
    {
        $request->validate([
            'id'     => 'required',
            'gambar' => 'required|string',
        ]);

        // Menggunakan nama kolom 'gambar' sesuai struktur tabel produk di MySQL
        DB::table('produk')
            ->where('id', $request->id)
            ->update([
                'gambar' => $request->gambar
            ]);

        return redirect()->back()->with('success', 'Gambar berhasil diperbarui!');
    }

    // Hapus produk (Admin)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}