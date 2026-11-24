-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: ecommers_sosro
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mitra`
--

DROP TABLE IF EXISTS `mitra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mitra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mitra` varchar(100) NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `wilayah` varchar(100) NOT NULL,
  `status` varchar(20) DEFAULT 'Aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mitra`
--

LOCK TABLES `mitra` WRITE;
/*!40000 ALTER TABLE `mitra` DISABLE KEYS */;
INSERT INTO `mitra` VALUES (1,'PT. Indomarco Prismatama','0812-3456-7890','DKI Jakarta','Aktif'),(2,'CV. Sumber Makmur Jaya','0857-1122-3344','Jawa Barat','Aktif');
/*!40000 ALTER TABLE `mitra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pelanggan','admin') DEFAULT 'pelanggan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengguna`
--

LOCK TABLES `pengguna` WRITE;
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` VALUES (1,'Ahmad Fauzi','ahmad@gmail.com','081299887766','123456','pelanggan','2026-10-14 08:34:44'),(2,'Admin Sosro','admin@sosro.com','081122334455','admin123','admin','2026-10-14 08:34:44'),(3,'TokoDimas','dimasgalih741@gmail.com','085842623945','123456','pelanggan','2026-10-14 08:38:00'),(4,'dimas','dimas@gmail.com','123456789','12345678','pelanggan','2026-10-14 09:24:44'),(5,'Bima','bimadungu@gmail.com','086353752583','11111111','pelanggan','2026-10-15 17:59:02'),(6,'DEDI','pes06778@gmail.com','085842623945','1111','pelanggan','2026-10-20 12:18:55'),(7,'TokoCleimen','kaisaclemens@gmail.com','0852374623842','1111','pelanggan','2026-11-10 14:47:04'),(8,'Raja Sosro','sosro1@gmail.com','12345678902','sosro1','pelanggan','2026-11-10 16:56:31'),(9,'uzik','uzik123@gmail.com','089898898898','123456','pelanggan','2026-11-21 04:19:01');
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesan`
--

DROP TABLE IF EXISTS `pesan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pesan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pemesan` varchar(100) NOT NULL,
  `no_wa` varchar(20) NOT NULL,
  `metode_pengiriman` varchar(50) NOT NULL,
  `nomor_resi` varchar(100) DEFAULT NULL,
  `alamat` text NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status_bayar` varchar(20) DEFAULT 'Pending',
  `status_pesanan` varchar(30) NOT NULL DEFAULT 'Menunggu Pembayaran',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesan`
--

LOCK TABLES `pesan` WRITE;
/*!40000 ALTER TABLE `pesan` DISABLE KEYS */;
INSERT INTO `pesan` VALUES (1,'TokoDimas','085842623945','Armada Sosro (Grosir)',NULL,'tumut',118000,'2026-10-15','Dalam Pengiriman','Dalam Pengiriman'),(2,'TokoDimas','085842623945','Armada Sosro (Grosir)',NULL,'tumut',118000,'2026-10-15','Dalam Pengiriman','Dalam Pengiriman'),(3,'TokoDimas','085942623945','Armada Sosro (Grosir)',NULL,'Minggir',118000,'2026-10-26','Diproses','Dalam Pengiriman'),(4,'TokoDEDI','085942623945','Armada Sosro (Grosir)',NULL,'MINGGIR',0,'2026-10-27','Dalam Pengiriman','Dalam Pengiriman'),(5,'TokoDEDI','085942623945','Armada Sosro (Grosir)',NULL,'yaya',0,'2026-10-27','Pending','Menunggu Pembayaran'),(6,'TokoDEDI','085942623945','Armada Sosro (Grosir)',NULL,'Tumut',0,'2026-10-28','Pending','Menunggu Pembayaran'),(7,'TokoDEDI','085942623945','Armada Sosro (Grosir)',NULL,'minggir',0,'2026-10-28','Pending','Menunggu Pembayaran'),(8,'TokoKembar','085171939748','Armada Sosro (Grosir)',NULL,'Ndalangan',0,'2026-10-28','Dalam Pengiriman','Dalam Pengiriman'),(9,'Toko DEDI','08573842349238','Armada Sosro (Grosir)',NULL,'Paingan',0,'2026-10-28','Pending','Menunggu Pembayaran'),(10,'Toko Sipno','08642568755','Armada Sosro (Grosir)',NULL,'Paingan Depan USD',0,'2026-10-28','Dalam Pengiriman','Selesai'),(11,'toko paska','08312394248','Armada Sosro (Grosir)',NULL,'Budur',0,'2026-11-06','Pending','Menunggu Pembayaran'),(12,'TokoCleimen','081285802865','Armada Sosro (Grosir)',NULL,'wifdlkb',155000,'2026-11-10','Pending','Menunggu Pembayaran'),(13,'TokoCleimen','08312394248','Armada Sosro (Grosir)',NULL,'wedomartani',310,'2026-11-10','Pending','Menunggu Pembayaran'),(14,'dimas','0851264712834','Armada Sosro (Grosir)',NULL,'diro',620,'2026-11-10','Pending','Menunggu Pembayaran'),(15,'dimas','1496644337','Armada Sosro (Grosir)',NULL,'waterboom',600000,'2026-11-10','Pending','Menunggu Pembayaran'),(16,'dimas','1496644337','Armada Sosro (Grosir)',NULL,'https://maps.app.goo.gl/RCSgxrH7TftykCUC9?g_st=iw',275000,'2026-11-10','Pending','Menunggu Pembayaran'),(17,'dimas','1496644337','Ambil Sendiri di Depot',NULL,'Ambil Sendiri di Depot Sosro - 767J+5G9, Diro, Sendangmulyo, Kec. Minggir, Kabupaten Sleman, DIY 55562',275000,'2026-11-10','Pending','Menunggu Pembayaran'),(19,'dimas','1496644337','Armada Sosro (Grosir)',NULL,'https://maps.app.goo.gl/RCSgxrH7TftykCUC9?g_st=iw',220000,'2026-11-10','Pending','Menunggu Pembayaran'),(20,'uzik','089898898989','Armada Sosro (Grosir)',NULL,'https://maps.app.goo.gl/PusXYkDg8kA7Z7xM8',31000,'2026-11-21','Pending','Menunggu Pembayaran'),(21,'uzik','099999999','Ambil Sendiri di Depot',NULL,'Ambil Sendiri di Depot Sosro - 767J+5G9, Diro, Sendangmulyo, Kec. Minggir, Kabupaten Sleman, DIY 55562',31000,'2026-11-21','Pending','Menunggu Pembayaran');
/*!40000 ALTER TABLE `pesan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesanan`
--

DROP TABLE IF EXISTS `pesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `detail_pesanan` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesanan`
--

LOCK TABLES `pesanan` WRITE;
/*!40000 ALTER TABLE `pesanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produk`
--

LOCK TABLES `produk` WRITE;
/*!40000 ALTER TABLE `produk` DISABLE KEYS */;
INSERT INTO `produk` VALUES (1,'Teh Botol Sosro RGB 220ml','Minuman',4000,120,'teh botol 220ml.jpg'),(2,'Fruit Tea Apple 350ml','Minuman',6000,85,'teh apel.jpg'),(3,'TEBS Sparkling 500ml','Minuman',7500,45,'Tebss.jpg'),(4,'Teh Botol Sosro PET 350ml','Minuman',45000,100,'teh 350ml.jpg'),(5,'Teh Botol Sosro PET 450ml','Minuman',60000,70,'teh pet 450ml.jpg'),(6,'Teh Botol Sosro PET 1 Liter','Minuman',105000,50,'teh 1ltr.jpg'),(7,'Teh Botol Kotak 250ml (Dus)','Minuman',78000,30,'Teh Botol Kotak 250ml (Dus).jpg'),(8,'Fruit Tea Blackcurrant 350ml','Minuman',60000,89,'fruittea250bc.jpg'),(9,'TEBS Sparkling Can 330ml','Minuman',55000,20,'tebs can.jpg'),(10,'Prima 220ml','Minuman',31000,24,'prima220ml.png'),(12,'Prima 220ml','Minuman',31000,18,'prima220ml.png');
/*!40000 ALTER TABLE `produk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_staff` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'admin','admin ','admin@sosro.id','admin'),(2,'staff','Staff','staff@sosro.id','staff');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-24 21:28:35
