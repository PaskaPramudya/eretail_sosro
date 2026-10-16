<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');
    $password = mysqli_real_escape_string($koneksi, $_POST['password'] ?? '');

    // 1. Cek Kredensial ke Database
    $query  = "SELECT * FROM pengguna WHERE (email='$username' OR nama_lengkap='$username') AND password='$password' AND role='admin'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        
        // Samakan variabel session
        $_SESSION['admin_id']   = $admin['id'];
        $_SESSION['admin_nama'] = $admin['nama_lengkap'];
        $_SESSION['role']       = 'admin';

        header("Location: admin.php");
        exit();
    } 
    // 2. Fallback jika username 'admin' (Kredensial Default)
    else if (($username === 'admin' || $username === 'admin@sosro.com') && ($password === 'admin123' || $password === 'SosroAdmin2026!')) {
        $_SESSION['admin_id']   = 1;
        $_SESSION['admin_nama'] = 'Administrator Sosro';
        $_SESSION['role']       = 'admin';

        header("Location: admin.php");
        exit();
    } 
    // 3. Jika Kredensial Salah
    else {
        header("Location: pelanggan.php?status=admin_login_failed");
        exit();
    }
} else {
    header("Location: pelanggan.php");
    exit();
}
?>