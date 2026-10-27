<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Nama tabel di MySQL phpMyAdmin

    public $timestamps = false; // Mematikan fitur timestamps otomatis Laravel

    protected $fillable = [
        'nama_produk',
        'kategori',
        'harga',
        'stok',
        'gambar',
    ];
}