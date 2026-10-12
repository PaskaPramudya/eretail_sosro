CREATE TABLE IF NOT EXISTS `staff` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_staff` VARCHAR(100) NOT NULL,
  `jabatan` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `staff` (`id`, `nama_staff`, `jabatan`, `email`) VALUES
(1, 'Budi Santoso', 'Manager Gudang', 'budi.s@sosro.id'),
(2, 'Siti Rahma', 'Staff Admin Logistics', 'siti.r@sosro.id');