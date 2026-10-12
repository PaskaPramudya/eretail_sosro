<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_hp        = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $password     = mysqli_real_escape_string($koneksi, $_POST['password']);

    $cek_email = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE email='$email'");

    if (mysqli_num_rows($cek_email) > 0) {
        header("Location: pelanggan.html?status=email_exists");
        exit();
    } else {
        $query = "INSERT INTO pengguna (nama_lengkap, email, no_hp, password, role) VALUES ('$nama_lengkap', '$email', '$no_hp', '$password', 'pelanggan')";
        
        if (mysqli_query($koneksi, $query)) {
            // Langsung redirect ke pelanggan.html dengan pesan sukses
            header("Location: pelanggan.html?status=register_success");
            exit();
        } else {
            header("Location: pelanggan.html?status=register_failed");
            exit();
        }
    }
}
?>