CREATE TABLE IF NOT EXISTS `produk` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` VARCHAR(100) NOT NULL,
  `kategori` VARCHAR(50) NOT NULL,
  `harga` INT(11) NOT NULL,
  `stok` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `produk` (`id`, `nama_produk`, `kategori`, `harga`, `stok`) VALUES
(1, 'Teh Botol Sosro RGB 220ml', 'Minuman', 4000, 120),
(2, 'Fruit Tea Apple 350ml', 'Minuman', 6000, 85),
(3, 'TEBS Sparkling 500ml', 'Minuman', 7500, 45);