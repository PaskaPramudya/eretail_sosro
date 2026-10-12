<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form checkout pelanggan
    $nama_pemesan = mysqli_real_escape_string($koneksi, $_POST['nama_pemesan']);
    $no_wa        = mysqli_real_escape_string($koneksi, $_POST['no_wa']);
    $metode       = mysqli_real_escape_string($koneksi, $_POST['metode']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $total_bayar  = 118000; // Contoh total nominal bayar
    $tanggal      = date("Y-m-d");
    $status_bayar = "Pending";

    // Query simpan data ke tabel 'pesan'
    $query = "INSERT INTO pesan (nama_pemesan, no_wa, metode_pengiriman, alamat, total_bayar, tanggal, status_bayar) 
              VALUES ('$nama_pemesan', '$no_wa', '$metode', '$alamat', '$total_bayar', '$tanggal', '$status_bayar')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Pesanan berhasil dikirim! Tim Sosro akan menghubungi Anda.');
                window.location.href = 'pelanggan.html';
              </script>";
    } else {
        echo "Gagal menyimpan pesanan: " . mysqli_error($koneksi);
    }
}
?>