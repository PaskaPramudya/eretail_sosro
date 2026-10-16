<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_or_phone = mysqli_real_escape_string($koneksi, $_POST['email_or_phone']);
    $password       = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query  = "SELECT * FROM pengguna WHERE (email='$email_or_phone' OR no_hp='$email_or_phone') AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Simpan data user ke dalam session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama_lengkap']; // Baris ini wajib ada agar nama muncul di header

        // Redirect ke pelanggan.php
        header("Location: pelanggan.php?status=login_success&nama=" . urlencode($user['nama_lengkap']));
        exit();
    } else {
        header("Location: pelanggan.php?status=login_failed");
        exit();
    }
}
?>