<?php
session_start();

// Mencegah akses tanpa login admin
if (empty($_SESSION['admin_login']) && ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin.php");
    exit;
}

require 'koneksi.php';

$nama = trim($_POST['nama_produk'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga = filter_input(INPUT_POST, 'harga', FILTER_VALIDATE_INT);
$stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);

$kategoriValid = [
    'Teh Botol Sosro',
    'Fruit Tea',
    'TEBS Sparkling',
    'Minuman'
];

if (
    $nama === '' ||
    !in_array($kategori, $kategoriValid, true) ||
    $harga === false || $harga === null || $harga < 0 ||
    $stok === false || $stok === null || $stok < 0
) {
    exit("Data produk tidak valid. <a href='admin.php'>Kembali</a>");
}

// Menggunakan $koneksi sesuai file koneksi.php
$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO produk (nama_produk, kategori, harga, stok) VALUES (?, ?, ?, ?)"
);

if (!$stmt) {
    exit("Gagal menyiapkan penyimpanan produk: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, "ssii", $nama, $kategori, $harga, $stok);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: admin.php?status=sukses");
    exit;
}

mysqli_stmt_close($stmt);
exit("Produk gagal disimpan. Periksa struktur tabel produk.");
?>