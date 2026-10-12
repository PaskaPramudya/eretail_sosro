CREATE TABLE IF NOT EXISTS `mitra` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_mitra` VARCHAR(100) NOT NULL,
  `kontak` VARCHAR(30) NOT NULL,
  `wilayah` VARCHAR(100) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `mitra` (`id`, `nama_mitra`, `kontak`, `wilayah`, `status`) VALUES
(1, 'PT. Indomarco Prismatama', '0812-3456-7890', 'DKI Jakarta', 'Aktif'),
(2, 'CV. Sumber Makmur Jaya', '0857-1122-3344', 'Jawa Barat', 'Aktif');