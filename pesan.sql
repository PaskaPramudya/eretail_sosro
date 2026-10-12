CREATE TABLE IF NOT EXISTS `pesan` (
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

INSERT INTO `pesan` (`id`, `nama_pemesan`, `no_wa`, `metode_pengiriman`, `alamat`, `total_bayar`, `tanggal`, `status_bayar`) VALUES
(1, 'Toko Kelontong Berkah', '081299887766', 'Armada Sosro (Grosir)', 'Jl. Merdeka No. 12', 1200000, '2026-10-12', 'Lunas');