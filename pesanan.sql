  CREATE TABLE pesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
  nomor_telepon VARCHAR(20),
    detail_pesanan TEXT,
    jumlah INT,
    tanggal_pesan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);