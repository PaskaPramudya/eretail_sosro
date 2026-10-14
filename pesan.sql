CREATE TABLE `pesan` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_pemesan` VARCHAR(100) NOT NULL,
  `no_wa` VARCHAR(20) NOT NULL,
  `metode_pengiriman` VARCHAR(50) NOT NULL,
  `alamat` TEXT NOT NULL,
  `total_bayar` INT(11) NOT NULL,
  `tanggal` DATE NOT NULL,
  `status_bayar` VARCHAR(20) DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;