-- 1. Buat tabel pengguna untuk menyimpan data akun pelanggan
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `no_hp` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('pelanggan', 'admin') DEFAULT 'pelanggan',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tambahkan data contoh/dummy pengguna untuk pengujian login
INSERT INTO `pengguna` (`id`, `nama_lengkap`, `email`, `no_hp`, `password`, `role`) VALUES
(1, 'Ahmad Fauzi', 'ahmad@gmail.com', '081299887766', '123456', 'pelanggan'),
(2, 'Admin Sosro', 'admin@sosro.com', '081122334455', 'admin123', 'admin');