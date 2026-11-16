<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $produk = [
            ['Teh Botol Sosro Original 350ml', 'Teh Botol Sosro', 4500, 120, 'teh 350ml.jpg'],
            ['Teh Botol Sosro Kotak 250ml', 'Teh Botol Sosro', 5000, 100, 'Teh Botol Kotak 250ml (Dus).jpg'],
            ['Teh Botol Sosro 1 Liter', 'Teh Botol Sosro', 11000, 60, 'teh 1ltr.jpg'],
            ['Fruit Tea Apel 350ml', 'Fruit Tea', 5000, 90, 'Fruit Tea Apel 350ml.jpg'],
            ['Fruit Tea 250ml', 'Fruit Tea', 4000, 90, 'fruittea250bc.jpg'],
            ['TEBS Sparkling 500ml', 'TEBS', 7000, 75, 'TEBS Sparkling 500ml.jpg'],
            ['TEBS Can 330ml', 'TEBS', 6500, 75, 'tebs can.jpg'],
            ['Prima Air Mineral 220ml', 'Air Mineral', 2500, 150, 'prima220ml.png'],
        ];
        foreach ($produk as [$nama, $kategori, $harga, $stok, $gambar]) {
            DB::table('produk')->updateOrInsert(['nama_produk' => $nama], ['kategori'=>$kategori, 'harga'=>$harga, 'stok'=>$stok, 'gambar'=>$gambar]);
        }
    }
}
