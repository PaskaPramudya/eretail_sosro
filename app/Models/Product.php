<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Pastikan nama tabel sesuai dengan DB kamu

    protected $fillable = [
        'nama_produk',
        'kategori',
        'harga',
        'stok',
        'gambar',
    ];
}