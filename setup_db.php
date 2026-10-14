<?php
// Menggunakan koneksi asli milik Anda
include 'koneksi.php';

// 1. Hapus tabel pesan yang lama secara paksa (agar bersih)
mysqli_query($koneksi, "DROP TABLE IF EXISTS `pesan`");

// 2. Buat tabel pesan yang baru dengan kolom yang lengkap
$query = "CREATE TABLE `pesan` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_pemesan` VARCHAR(100) NOT NULL,
  `no_wa` VARCHAR(20) NOT NULL,
  `metode_pengiriman` VARCHAR(50) NOT NULL,
  `alamat` TEXT NOT NULL,
  `total_bayar` INT(11) NOT NULL,
  `tanggal` DATE NOT NULL,
  `status_bayar` VARCHAR(20) DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// 3. Eksekusi dan tampilkan hasil
echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
if (mysqli_query($koneksi,$query)) {
    echo "<h2 style='color: green;'>✅ BERHASIL! Tabel Database Sudah Diperbarui.</h2>";
    echo "<p>Kolom 'nama_pemesan' sudah berhasil ditambahkan ke database Anda.</p>";
    echo "<a href='pelanggan.html' style='display: inline-block; padding: 10px 20px; background: #92400e; color: white; text-decoration: none; border-radius: 5px;'>Kembali ke Web & Coba Pesan Lagi</a>";
} else {
    echo "<h2 style='color: red;'>❌ GAGAL: " . mysqli_error($koneksi) . "</h2>";
    echo "<p>Pastikan file koneksi.php Anda sudah benar.</p>";
}
echo "</div>";
?>