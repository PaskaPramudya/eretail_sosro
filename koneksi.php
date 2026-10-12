<?php
$host     = "localhost";
$user     = "root";
$password = ""; // Kosongkan jika standar XAMPP
$database = "ecommers_sosro"; // Sesuaikan dengan nama di SQLyog

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>