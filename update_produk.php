<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = (int)($_POST['id'] ?? 0);
    $stok  = (int)($_POST['stok'] ?? 0);
    $harga = (int)($_POST['harga'] ?? 0);

    if ($id > 0) {
        $query = "UPDATE produk SET stok = '$stok', harga = '$harga' WHERE id = '$id'";
        
        if (mysqli_query($koneksi, $query)) {
            header("Location: admin.php?status=update_sukses");
            exit();
        } else {
            header("Location: admin.php?status=update_gagal");
            exit();
        }
    }
}

header("Location: admin.php");
exit();
?>