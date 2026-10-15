<?php
// Mengambil koneksi dari file koneksi.php bawaan proyek Anda
include 'koneksi.php';

class ProsesPesanan {
    private $db;

    public function __construct($koneksi) {
        $this->db =$koneksi;
    }

    public function simpanData($data) {
        // Amankan data dari SQL Injection
        $nama_pemesan = mysqli_real_escape_string($this->db, $data['nama_pemesan'] ?? '');$no_wa        = mysqli_real_escape_string($this->db,$data['no_wa'] ?? '');
        $metode       = mysqli_real_escape_string($this->db, $data['metode'] ?? '');$alamat       = mysqli_real_escape_string($this->db,$data['alamat'] ?? '');
        
        // Ambil total bayar dari form (atau gunakan default 118000 jika kosong)
        $total_bayar  = (isset($data['total_bayar']) && (int)$data['total_bayar'] > 0) ? (int)$data['total_bayar'] : 118000; 
        $tanggal      = date("Y-m-d");

        // Query disesuaikan dengan struktur kolom asli di tabel `pesan`
        $query = "INSERT INTO pesan (nama_pemesan, no_wa, metode_pengiriman, alamat, total_bayar, tanggal, status_bayar) 
                  VALUES ('$nama_pemesan', '$no_wa', '$metode', '$alamat', '$total_bayar', '$tanggal', 'Pending')";

        if (mysqli_query($this->db,$query)) {
            return "sukses"; 
        } else {
            $error = mysqli_error($this->db);
            if (empty($error)) {$error = "Gagal mengeksekusi query ke database.";
            }
            return $error; 
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pesananBaru = new ProsesPesanan($koneksi);$hasil = $pesananBaru->simpanData($_POST);
    
    if ($hasil === "sukses") {
        header("Location: pesanan_sukses.html");
        exit();
    } else {
        echo "<h3>Gagal Menyimpan Database!</h3>";
        echo "<p>Detail Kesalahan: <b>" . htmlspecialchars($hasil) . "</b></p>";
    }
}
?>