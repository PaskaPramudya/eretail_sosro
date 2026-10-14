<?php
// Mengambil koneksi dari file koneksi.php bawaan proyek Anda
include 'koneksi.php';

class ProsesPesanan {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function simpanData($data) {
        // Amankan data dari SQL Injection
        $nama_pemesan = mysqli_real_escape_string($this->db, $data['nama_pemesan']);
        $no_wa        = mysqli_real_escape_string($this->db, $data['no_wa']);
        $metode       = isset($data['metode']) ? mysqli_real_escape_string($this->db, $data['metode']) : '';
        $alamat       = mysqli_real_escape_string($this->db, $data['alamat']);
        
        $total_harga  = 118000; 
        $tanggal_pesanan = date("Y-m-d");
        $id_mitra     = 1; 
        $id_produk    = 1; 
        $keranjang    = $nama_pemesan . " - " . $alamat . " (" . $no_wa . ")";

        $query = "INSERT INTO pesan (id_mitra, id_produk, keranjang, tanggal_pesanan, total_harga) 
                  VALUES ('$id_mitra', '$id_produk', '$keranjang', '$tanggal_pesanan', '$total_harga')";

        if (mysqli_query($this->db, $query)) {
            return "sukses"; 
        } else {
            $error = mysqli_error($this->db);
            // Jika mysqli_error kosong, tampilkan pesan default
            if(empty($error)) {
                $error = "Gagal mengeksekusi query database (kemungkinan masalah Foreign Key ID Mitra/Produk tidak ditemukan).";
            }
            return $error; 
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pesananBaru = new ProsesPesanan($koneksi);
    $hasil = $pesananBaru->simpanData($_POST);
    
    if ($hasil === "sukses") {
        header("Location: pesanan_sukses.html");
        exit();
    } else {
        echo "<h3>Gagal Menyimpan Database!</h3>";
        echo "<p>Detail Kesalahan: <b>" . $hasil . "</b></p>";
    }
}
?>