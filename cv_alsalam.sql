-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 05 Agu 2024 pada 01.51
-- Versi server: 8.2.0
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cv_alsalam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detil_pembelian`
--

DROP TABLE IF EXISTS `detil_pembelian`;
CREATE TABLE IF NOT EXISTS `detil_pembelian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pembelian_id` int DEFAULT NULL,
  `produk_id` int DEFAULT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pembelian_id` (`pembelian_id`),
  KEY `produk_id` (`produk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `detil_pembelian`
--

INSERT INTO `detil_pembelian` (`id`, `pembelian_id`, `produk_id`, `jumlah`, `harga_satuan`) VALUES
(1, 1, 1, 10, 100000.00),
(2, 2, 2, 20, 20000.00),
(3, 3, 3, 30, 10000.00);

--
-- Trigger `detil_pembelian`
--
DROP TRIGGER IF EXISTS `update_stok_after_pembelian`;
DELIMITER $$
CREATE TRIGGER `update_stok_after_pembelian` AFTER INSERT ON `detil_pembelian` FOR EACH ROW BEGIN
    UPDATE produk
    SET stok = stok + NEW.jumlah
    WHERE id = NEW.produk_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `help_desk`
--

DROP TABLE IF EXISTS `help_desk`;
CREATE TABLE IF NOT EXISTS `help_desk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `help_desk`
--

INSERT INTO `help_desk` (`id`, `nama`, `email`, `telepon`, `pesan`, `tanggal`) VALUES
(1, 'Ali Rahman', 'ali@example.com', '081234567890', 'Saya ingin mengetahui lebih lanjut tentang kain sutra yang tersedia.', '2024-05-01 08:00:00'),
(2, 'Nur Hidayah', 'nur@example.com', '082345678901', 'Apakah ada diskon untuk pembelian kain katun dalam jumlah besar?', '2024-05-02 09:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_produk`
--

DROP TABLE IF EXISTS `kategori_produk`;
CREATE TABLE IF NOT EXISTS `kategori_produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Sutra', 'Kategori untuk kain sutra berkualitas tinggi.'),
(2, 'Katun', 'Kategori untuk kain katun nyaman.'),
(3, 'Linen', 'Kategori untuk kain linen tahan lama.'),
(7, 'Batik', 'Kain tradisional dengan motif batik'),
(55, 'Tenun', 'Kain tenun dibuat dengan cara menenun benang secara manual atau dengan alat tenun.'),
(8, 'Wol', 'Kain tebal dan hangat, ideal untuk musim dingin'),
(9, 'Denim', 'Kain yang kuat dan tahan lama, biasa digunakan untuk jeans'),
(10, 'Flanel', 'Kain lembut dan hangat, sering digunakan untuk pakaian kasual'),
(11, 'Brokat', 'Kain dengan pola bordir yang rumit, sering digunakan untuk pakaian formal'),
(12, 'Chiffon', 'Kain ringan dan transparan, cocok untuk gaun malam'),
(13, 'Jersey', 'Kain elastis yang nyaman, sering digunakan untuk pakaian olahraga'),
(14, 'Rayon', 'Kain yang lembut dan nyaman, terbuat dari serat selulosa'),
(15, 'Poliester', 'Kain sintetis yang tahan lama dan mudah dirawat'),
(16, 'Nilon', 'Kain sintetis yang kuat dan tahan lama'),
(17, 'Spandex', 'Kain sangat elastis, sering digunakan untuk pakaian olahraga'),
(18, 'Taffeta', 'Kain dengan kilauan yang indah, sering digunakan untuk gaun malam'),
(19, 'Organza', 'Kain tipis dan kaku, sering digunakan untuk gaun dan dekorasi'),
(20, 'Velvet', 'Kain dengan tekstur lembut dan mewah, sering digunakan untuk pakaian formal'),
(21, 'Tweed', 'Kain yang kuat dan tahan lama, sering digunakan untuk jas dan mantel'),
(22, 'Crepe', 'Kain dengan tekstur berkerut, sering digunakan untuk gaun dan blus'),
(23, 'Georgette', 'Kain ringan dengan tekstur berpasir, sering digunakan untuk gaun dan blus'),
(24, 'Satin', 'Kain dengan permukaan yang berkilau, sering digunakan untuk gaun malam'),
(25, 'Damask', 'Kain dengan pola tenunan yang rumit, sering digunakan untuk taplak meja dan gorden'),
(26, 'Lurex', 'Kain yang mengandung serat logam, memberikan efek berkilau'),
(27, 'Tulle', 'Kain tipis dan ringan, sering digunakan untuk rok tutu dan dekorasi'),
(28, 'Lace', 'Kain dengan pola renda yang rumit, sering digunakan untuk pakaian formal dan aksesoris'),
(29, 'Chambray', 'Kain ringan yang mirip dengan denim, sering digunakan untuk pakaian kasual'),
(30, 'Gabardine', 'Kain yang kuat dan tahan lama, sering digunakan untuk jas dan celana'),
(31, 'Boucle', 'Kain dengan tekstur berkerut, sering digunakan untuk jaket dan mantel'),
(32, 'Herringbone', 'Kain dengan pola tulang ikan, sering digunakan untuk jas dan mantel'),
(33, 'Seersucker', 'Kain dengan tekstur berkerut, sering digunakan untuk pakaian musim panas'),
(34, 'Corduroy', 'Kain dengan tekstur bergaris, sering digunakan untuk celana dan jaket'),
(35, 'Fleece', 'Kain lembut dan hangat, sering digunakan untuk pakaian musim dingin'),
(36, 'Terry', 'Kain yang tebal dan menyerap, sering digunakan untuk handuk dan pakaian olahraga'),
(37, 'Viscose', 'Kain yang lembut dan nyaman, terbuat dari serat selulosa'),
(38, 'Modal', 'Kain yang sangat lembut dan nyaman, terbuat dari serat selulosa'),
(39, 'Lyocell', 'Kain yang kuat dan lembut, terbuat dari serat selulosa'),
(40, 'Bamboo', 'Kain yang lembut dan ramah lingkungan, terbuat dari serat bambu'),
(41, 'Hemp', 'Kain yang kuat dan ramah lingkungan, terbuat dari serat rami'),
(42, 'Jute', 'Kain yang kuat dan ramah lingkungan, sering digunakan untuk tas dan dekorasi'),
(43, 'Acetate', 'Kain yang lembut dan berkilau, sering digunakan untuk gaun malam'),
(44, 'Triacetate', 'Kain yang kuat dan tahan lama, sering digunakan untuk pakaian formal'),
(45, 'Cupro', 'Kain yang lembut dan nyaman, terbuat dari serat selulosa'),
(46, 'Pashmina', 'Kain yang sangat lembut dan hangat, sering digunakan untuk syal'),
(47, 'ViscoseRayon', 'Kain yang lembut dan nyaman, terbuat dari campuran viscose dan rayon'),
(48, 'Polyamide', 'Kain sintetis yang kuat dan tahan lama'),
(49, 'Elastane', 'Kain sangat elastis, sering digunakan untuk pakaian olahraga'),
(50, 'Microfiber', 'Kain yang sangat halus dan lembut, sering digunakan untuk pakaian olahraga dan handuk'),
(51, 'Melton', 'Kain yang tebal dan tahan lama, sering digunakan untuk mantel'),
(52, 'Poplin', 'Kain yang kuat dan serbaguna, sering digunakan untuk kemeja dan pakaian formal'),
(53, 'Ottoman', 'Kain dengan tekstur bergaris, sering digunakan untuk pakaian formal dan dekorasi'),
(54, 'Chintz', 'Kain dengan permukaan yang mengkilap, sering digunakan untuk dekorasi rumah'),
(56, 'Kasa', 'Kain kasa sering digunakan untuk perban atau tujuan medis karena sifatnya yang berpori.'),
(57, 'Balotelli', 'Kain balotelli dikenal karena teksturnya yang halus dan cocok untuk pakaian formal.'),
(58, 'Maxmara', 'Kain maxmara adalah kain satin yang lembut dan berkilau, sering digunakan untuk gaun pesta.'),
(59, 'Arabesque', 'Kain arabesque biasanya memiliki pola dekoratif yang rumit dan elegan.'),
(60, 'Jacquard', 'Kain jacquard memiliki pola yang ditenun langsung ke dalam kain, bukan dicetak atau diwarnai.'),
(61, 'Embroidery', 'Kain embroidery dihiasi dengan bordir untuk menambah desain dan tekstur.'),
(62, 'Bemberg', 'Kain bemberg adalah serat regenerasi selulosa yang sering digunakan untuk pelapis pakaian.'),
(63, 'Twill', 'Kain twill dikenal karena pola garis miringnya dan sering digunakan untuk pakaian luar dan celana.'),
(64, 'Drill', 'Kain drill adalah jenis twill yang kuat, sering digunakan untuk seragam dan pakaian kerja.'),
(65, 'Cambric', 'Kain cambric adalah kain ringan yang halus, sering digunakan untuk baju dan blus.'),
(66, 'Organdi', 'Kain organdi adalah kain katun yang sangat halus dan tipis, sering digunakan untuk pakaian musim panas.'),
(67, 'Mikado', 'Kain mikado adalah kain yang kuat dan berkilau, sering digunakan untuk gaun pengantin dan gaun pesta.'),
(68, 'Shantung', 'Kain shantung adalah kain sutra dengan tekstur kasar yang khas, sering digunakan untuk pakaian formal.'),
(69, 'Dobby', 'Kain dobby memiliki pola kecil yang ditenun ke dalam kain, menambah tekstur dan desain.'),
(70, 'Ripstop', 'Kain ripstop dirancang untuk tahan robek dan sering digunakan untuk pakaian outdoor dan peralatan.'),
(71, 'Crinkle', 'Kain crinkle memiliki tekstur berkerut yang dibuat dengan teknik khusus selama proses produksi.'),
(72, 'Lame', 'Kain lame adalah kain berkilau yang sering digunakan untuk pakaian pesta dan kostum.'),
(73, 'Pointelle', 'Kain pointelle adalah kain rajut dengan pola lubang kecil, sering digunakan untuk pakaian bayi dan wanita.'),
(74, 'Plisse', 'Kain plisse memiliki tekstur lipit yang dibuat dengan teknik khusus, sering digunakan untuk gaun dan blus.'),
(75, 'Pique', 'Kain pique memiliki pola bertekstur yang biasanya digunakan untuk pakaian olahraga dan kasual.'),
(76, 'Matelassé', 'Kain matelassé adalah kain tebal yang terlihat seperti memiliki lapisan quilted, sering digunakan untuk pakaian luar dan dekorasi rumah.'),
(77, 'Polos', 'Kain polos adalah kain tanpa pola atau desain, cocok untuk berbagai macam pakaian.'),
(78, 'Motif', 'Kain motif adalah kain dengan desain atau pola yang dicetak atau ditenun ke dalam kain.'),
(79, 'Seragam', 'Kain seragam adalah kain yang dirancang untuk pembuatan seragam, sering kali kuat dan tahan lama.'),
(80, 'Songket', 'Kain songket adalah kain tradisional yang ditenun dengan benang emas atau perak, sering digunakan untuk pakaian adat dan acara formal.'),
(81, 'Ikat', 'Kain ikat adalah kain yang dibuat dengan teknik ikat celup, menciptakan pola unik yang bervariasi.'),
(82, 'Sifon', 'Kain sifon adalah kain ringan dan tipis yang sering digunakan untuk gaun dan blus karena jatuhnya yang indah.'),
(83, 'Rajut', 'Kain rajut adalah kain yang dibuat dengan teknik merajut, memberikan elastisitas dan kenyamanan yang baik.'),
(84, 'Parasut', 'Kain parasut adalah kain ringan dan tahan air yang sering digunakan untuk pakaian outdoor dan jaket.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_penjualan`
--

DROP TABLE IF EXISTS `laporan_penjualan`;
CREATE TABLE IF NOT EXISTS `laporan_penjualan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal_laporan` date NOT NULL,
  `total_transaksi` int NOT NULL,
  `total_pendapatan` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `laporan_penjualan`
--

INSERT INTO `laporan_penjualan` (`id`, `tanggal_laporan`, `total_transaksi`, `total_pendapatan`) VALUES
(1, '2024-05-01', 3, 1700000.00),
(2, '2024-05-02', 5, 2000000.00),
(3, '2024-05-03', 2, 1300000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `alamat` text,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `alamat`, `telepon`, `email`) VALUES
(1, 'Ahmad Fauzi', 'Jl. Merdeka No. 10, Jakarta', '0812345678991', 'ahmad@example.com'),
(2, 'Siti Aminah', 'Jl. Sudirman No. 20, Bandung', '082345678901', 'siti@example.com'),
(3, 'Budi Santoso', 'Jl. Thamrin No. 30, Surabaya', '083456789012', 'budi@example.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE IF NOT EXISTS `pembelian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier_id` int DEFAULT NULL,
  `tanggal_pembelian` datetime NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id`, `supplier_id`, `tanggal_pembelian`, `total_harga`) VALUES
(1, 1, '2024-05-01 09:00:00', 1000000.00),
(2, 2, '2024-05-02 10:00:00', 400000.00),
(3, 3, '2024-05-03 11:00:00', 300000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_toko`
--

DROP TABLE IF EXISTS `pengaturan_toko`;
CREATE TABLE IF NOT EXISTS `pengaturan_toko` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(255) NOT NULL,
  `alamat` text,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengaturan_toko`
--

INSERT INTO `pengaturan_toko` (`id`, `nama_toko`, `alamat`, `telepon`, `email`, `deskripsi`) VALUES
(1, 'CV Al Salam', 'Jl. Raya No. 10, Jakarta', '081234567891', 'info@cvassalam.com', 'Toko kain terpercaya dengan berbagai macam pilihan kain berkualitas.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `role` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', 'admin', 'Admin CV Assalam', '1'),
(3, 'manager', 'manager', 'Manager CV Assalam', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produk_id` int NOT NULL,
  `pelanggan_id` int DEFAULT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pesanan` datetime NOT NULL,
  `status` enum('masuk','diproses','dikirim','selesai') NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pelanggan_id` (`pelanggan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `produk_id`, `pelanggan_id`, `jumlah`, `tanggal_pesanan`, `status`, `total_harga`) VALUES
(2, 2, 2, 3, '2024-05-02 11:00:00', 'diproses', 400000.00),
(44, 6, 2, 2, '2024-08-05 01:35:15', 'masuk', 200000.00),
(4, 1, 1, 3, '2024-05-01 00:00:00', 'selesai', 300000.00),
(5, 2, 2, 1, '2024-05-02 00:00:00', 'selesai', 150000.00),
(6, 3, 3, 2, '2024-05-03 00:00:00', 'diproses', 200000.00),
(7, 2, 1, 5, '2024-05-04 00:00:00', 'selesai', 750000.00),
(8, 1, 2, 4, '2024-05-05 00:00:00', 'selesai', 400000.00),
(9, 3, 3, 2, '2024-05-06 00:00:00', 'diproses', 250000.00),
(10, 2, 1, 3, '2024-05-07 00:00:00', 'selesai', 450000.00),
(11, 1, 2, 1, '2024-05-08 00:00:00', 'dikirim', 100000.00),
(12, 2, 3, 6, '2024-05-09 00:00:00', 'selesai', 900000.00),
(13, 3, 1, 2, '2024-05-10 00:00:00', 'diproses', 300000.00),
(14, 3, 1, 3, '2024-05-11 00:00:00', 'selesai', 500000.00),
(15, 2, 2, 2, '2024-05-12 00:00:00', 'selesai', 350000.00),
(16, 1, 3, 4, '2024-05-13 00:00:00', 'diproses', 600000.00),
(17, 2, 1, 2, '2024-05-14 00:00:00', 'diproses', 400000.00),
(18, 3, 2, 5, '2024-05-15 00:00:00', 'selesai', 800000.00),
(19, 1, 3, 3, '2024-05-16 00:00:00', 'diproses', 450000.00),
(20, 2, 1, 4, '2024-05-17 00:00:00', 'selesai', 600000.00),
(21, 1, 2, 2, '2024-05-18 00:00:00', 'dikirim', 300000.00),
(22, 1, 3, 3, '2024-05-19 00:00:00', 'selesai', 550000.00),
(23, 1, 1, 1, '2024-05-20 00:00:00', 'selesai', 200000.00),
(24, 1, 1, 3, '2024-05-01 00:00:00', 'selesai', 500000.00),
(25, 2, 2, 2, '2024-05-02 00:00:00', 'selesai', 350000.00),
(26, 2, 3, 4, '2024-05-03 00:00:00', 'masuk', 600000.00),
(27, 4, 1, 2, '2024-05-04 00:00:00', 'diproses', 400000.00),
(28, 5, 2, 5, '2024-05-05 00:00:00', 'selesai', 800000.00),
(29, 6, 3, 3, '2024-05-06 00:00:00', 'diproses', 450000.00),
(30, 7, 1, 4, '2024-05-07 00:00:00', 'selesai', 600000.00),
(31, 8, 2, 2, '2024-05-08 00:00:00', '', 300000.00),
(32, 9, 3, 3, '2024-05-09 00:00:00', 'selesai', 550000.00),
(33, 10, 1, 1, '2024-05-10 00:00:00', 'selesai', 200000.00),
(34, 11, 2, 3, '2024-05-11 00:00:00', 'selesai', 450000.00),
(35, 12, 3, 2, '2024-05-12 00:00:00', 'dikirim', 350000.00),
(36, 13, 1, 5, '2024-05-13 00:00:00', 'selesai', 700000.00),
(37, 14, 2, 4, '2024-05-14 00:00:00', '', 600000.00),
(38, 15, 3, 2, '2024-05-15 00:00:00', 'selesai', 300000.00),
(39, 16, 1, 3, '2024-05-16 00:00:00', 'selesai', 400000.00),
(40, 17, 2, 3, '2024-05-17 00:00:00', 'diproses', 550000.00),
(41, 18, 3, 4, '2024-05-18 00:00:00', 'selesai', 600000.00),
(42, 19, 1, 2, '2024-05-19 00:00:00', 'masuk', 300000.00),
(43, 20, 2, 4, '2024-05-20 00:00:00', 'selesai', 500000.00),
(45, 94, 2, 2, '2024-08-05 01:35:51', 'masuk', 200000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE IF NOT EXISTS `produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) NOT NULL,
  `kategori_id` int DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id`),
  KEY `kategori_id` (`kategori_id`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `kategori_id`, `harga`, `stok`, `deskripsi`) VALUES
(94, 'Kain Babi', 2, 100000.00, 0, 'Babi guling'),
(3, 'Linen Eropa', 3, 300000.00, 104, 'Kain linen impor dari Eropa.'),
(5, 'Batik Parang', 7, 150000.00, 10, 'Kain batik dengan motif parang khas Jawa'),
(6, 'Sutra Premium', 1, 300000.00, 5, 'Kain sutra kualitas premium'),
(7, 'Katun Jepang', 2, 75000.00, 20, 'Kain katun Jepang dengan motif bunga-bunga'),
(8, 'Wol Hangat', 9, 200000.00, 15, 'Kain tebal dan hangat, ideal untuk musim dingin'),
(9, 'Wol Hangat', 8, 200000.00, 8, 'Kain yang kuat dan tahan lama, biasa digunakan untuk jeans'),
(10, 'Denim Kasual', 9, 90000.00, 25, 'Kain denim untuk pakaian kasual'),
(11, 'Flanel Kotak', 10, 85000.00, 30, 'Kain flanel dengan motif kotak-kotak'),
(12, 'Brokat Mewah', 11, 250000.00, 7, 'Kain brokat dengan bordir mewah'),
(13, 'Chiffon Ringan', 12, 110000.00, 18, 'Kain chiffon ringan dan transparan'),
(14, 'Jersey Elastis', 13, 95000.00, 22, 'Kain jersey elastis untuk pakaian olahraga'),
(15, 'Rayon Adem', 14, 70000.00, 25, 'Kain rayon yang adem dan nyaman'),
(16, 'Poliester Serbaguna', 15, 60000.00, 40, 'Kain poliester serbaguna dan mudah dirawat'),
(17, 'Nilon Tahan Lama', 16, 80000.00, 35, 'Kain nilon yang kuat dan tahan lama'),
(18, 'Spandex Stretch', 17, 95000.00, 28, 'Kain spandex yang sangat elastis'),
(19, 'Taffeta Kilap', 18, 200000.00, 10, 'Kain taffeta dengan kilauan indah'),
(20, 'Organza Transparan', 19, 150000.00, 15, 'Kain organza yang tipis dan kaku'),
(21, 'Velvet Mewah', 20, 220000.00, 12, 'Kain velvet dengan tekstur lembut dan mewah'),
(22, 'Tweed Klasik', 21, 180000.00, 20, 'Kain tweed yang kuat dan klasik'),
(23, 'Crepe Berkerut', 22, 120000.00, 18, 'Kain crepe dengan tekstur berkerut'),
(24, 'Georgette Halus', 23, 130000.00, 25, 'Kain georgette ringan dan halus'),
(25, 'Satin Kilau', 24, 210000.00, 14, 'Kain satin dengan permukaan berkilau'),
(26, 'Damask Mewah', 25, 200000.00, 10, 'Kain damask dengan pola tenunan rumit'),
(27, 'Lurex Berkilau', 26, 160000.00, 20, 'Kain lurex dengan serat logam berkilau'),
(28, 'Tulle Tipis', 27, 90000.00, 25, 'Kain tulle yang tipis dan ringan'),
(29, 'Lace Renda', 28, 170000.00, 20, 'Kain lace dengan pola renda rumit'),
(30, 'Chambray Denim', 9, 85000.00, 30, 'Kain chambray ringan mirip denim'),
(31, 'Gabardine Kuat', 30, 190000.00, 15, 'Kain gabardine yang kuat dan tahan lama'),
(32, 'Boucle Bertekstur', 31, 140000.00, 18, 'Kain boucle dengan tekstur berkerut'),
(33, 'Herringbone Jas', 32, 180000.00, 10, 'Kain herringbone dengan pola tulang ikan'),
(34, 'Seersucker Musim Panas', 33, 110000.00, 25, 'Kain seersucker untuk pakaian musim panas'),
(35, 'Corduroy Garis', 34, 120000.00, 20, 'Kain corduroy dengan tekstur bergaris'),
(36, 'Fleece Hangat', 35, 100000.00, 30, 'Kain fleece yang lembut dan hangat'),
(37, 'Terry Handuk', 36, 90000.00, 40, 'Kain terry tebal dan menyerap'),
(38, 'Viscose Nyaman', 37, 70000.00, 35, 'Kain viscose yang lembut dan nyaman'),
(39, 'Modal Lembut', 38, 95000.00, 28, 'Kain modal yang sangat lembut dan nyaman'),
(40, 'Lyocell Kuat', 39, 120000.00, 20, 'Kain lyocell yang kuat dan lembut'),
(41, 'Bamboo Ramah Lingkungan', 40, 110000.00, 22, 'Kain bamboo yang lembut dan ramah lingkungan'),
(42, 'Hemp Kuat', 41, 130000.00, 18, 'Kain hemp yang kuat dan ramah lingkungan'),
(43, 'Jute Dekoratif', 42, 85000.00, 25, 'Kain jute untuk tas dan dekorasi'),
(44, 'Acetate Kilau', 43, 140000.00, 15, 'Kain acetate yang lembut dan berkilau'),
(45, 'Triacetate Formal', 43, 150000.00, 12, 'Kain triacetate yang kuat untuk pakaian formal'),
(46, 'Cupro Lembut', 45, 130000.00, 18, 'Kain cupro yang lembut dan nyaman'),
(47, 'Pashmina Syal', 46, 200000.00, 10, 'Kain pashmina yang sangat lembut dan hangat'),
(48, 'Viscose Rayon', 14, 75000.00, 20, 'Kain viscose rayon yang lembut dan nyaman'),
(49, 'Polyamide Tahan Lama', 48, 85000.00, 25, 'Kain polyamide yang kuat dan tahan lama'),
(50, 'Elastane Stretch', 49, 95000.00, 22, 'Kain elastane yang sangat elastis'),
(51, 'Microfiber Halus', 50, 90000.00, 28, 'Kain microfiber yang sangat halus dan lembut'),
(52, 'Melton Mantel', 51, 180000.00, 15, 'Kain melton yang tebal dan tahan lama'),
(53, 'Poplin Serbaguna', 52, 85000.00, 30, 'Kain poplin yang kuat dan serbaguna'),
(54, 'Ottoman Bergaris', 53, 120000.00, 18, 'Kain ottoman dengan tekstur bergaris'),
(55, 'Chintz Dekoratif', 54, 140000.00, 20, 'Kain chintz dengan permukaan mengkilap'),
(56, ' Tenun', 55, 75000.00, 35, 'Kain tenun tradisional dengan motif unik'),
(57, ' Kasa', 56, 85000.00, 28, 'Kain kasa yang tipis dan ringan'),
(58, ' Balotelli', 57, 95000.00, 22, 'Kain balotelli dengan tekstur unik'),
(59, ' Satin Velvet', 20, 210000.00, 10, 'Kain satin velvet yang lembut dan mewah'),
(60, ' Maxmara', 58, 150000.00, 20, 'Kain maxmara yang lembut dan berkilau'),
(61, ' Arabesque', 59, 170000.00, 15, 'Kain arabesque dengan motif elegan'),
(62, ' Jacquard', 60, 190000.00, 12, 'Kain jacquard dengan pola tenunan rumit'),
(63, ' Embroidery', 61, 160000.00, 18, 'Kain embroidery dengan bordir yang rumit'),
(64, ' Bemberg', 62, 130000.00, 25, 'Kain bemberg yang halus dan nyaman'),
(65, ' Twill', 63, 95000.00, 30, 'Kain twill dengan tekstur diagonal'),
(66, ' Drill', 64, 120000.00, 20, 'Kain drill yang kuat dan tahan lama'),
(67, ' Cambric', 65, 75000.00, 35, 'Kain cambric yang ringan dan halus'),
(68, ' Organdi', 66, 140000.00, 15, 'Kain organdi yang tipis dan transparan'),
(69, ' Crepe de Chine', 22, 180000.00, 18, 'Kain crepe de chine yang lembut dan berkerut'),
(70, ' Mikado', 67, 200000.00, 12, 'Kain mikado yang kaku dan mengkilap'),
(71, ' Shantung', 68, 170000.00, 20, 'Kain shantung dengan tekstur berpasir'),
(72, ' Dobby', 69, 85000.00, 28, 'Kain dobby dengan pola tenunan kecil'),
(73, ' Ripstop', 70, 120000.00, 25, 'Kain ripstop yang kuat dan tahan robek'),
(74, ' Crinkle', 71, 95000.00, 30, 'Kain crinkle dengan tekstur berkerut'),
(75, ' Lame', 72, 160000.00, 18, 'Kain lame dengan serat logam mengkilap'),
(76, ' Pointelle', 73, 140000.00, 22, 'Kain pointelle dengan pola berlubang'),
(77, ' Plisse', 74, 130000.00, 25, 'Kain plisse dengan tekstur berlipat'),
(78, ' Pique', 75, 85000.00, 35, 'Kain pique dengan tekstur berkerut'),
(79, ' Matelasse', 76, 180000.00, 15, 'Kain matelasse dengan tekstur empuk'),
(80, ' Terrycloth', 36, 75000.00, 40, 'Kain terrycloth yang tebal dan menyerap'),
(81, ' Polos', 77, 60000.00, 50, 'Kain polos tanpa motif untuk berbagai kebutuhan'),
(82, ' Motif', 78, 75000.00, 35, 'Kain dengan berbagai motif menarik'),
(83, ' Seragam', 79, 90000.00, 30, 'Kain khusus untuk seragam sekolah dan kerja'),
(84, ' Batik Modern', 7, 150000.00, 15, 'Kain batik dengan desain modern'),
(85, ' Songket', 80, 200000.00, 10, 'Kain songket tradisional dengan motif emas dan perak'),
(86, ' Ikat', 81, 130000.00, 20, 'Kain ikat dengan motif unik'),
(87, ' Tenun NTT', 55, 170000.00, 18, 'Kain tenun khas NTT dengan motif tradisional'),
(88, ' Sifon', 82, 110000.00, 22, 'Kain sifon yang ringan dan transparan'),
(89, ' Rajut', 83, 85000.00, 30, 'Kain rajut untuk pakaian hangat'),
(90, ' Katun Paris', 2, 75000.00, 35, 'Kain katun Paris dengan kualitas terbaik'),
(91, ' Parasut', 84, 100000.00, 25, 'Kain parasut yang tahan air'),
(92, ' Denim Stretch', 9, 95000.00, 20, 'Kain denim yang elastis dan nyaman'),
(93, '123', 1, 123.00, 0, '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_pembelian`
--

DROP TABLE IF EXISTS `riwayat_pembelian`;
CREATE TABLE IF NOT EXISTS `riwayat_pembelian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pelanggan_id` int DEFAULT NULL,
  `produk_id` int DEFAULT NULL,
  `tanggal_pembelian` datetime NOT NULL,
  `jumlah` int NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  KEY `produk_id` (`produk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `riwayat_pembelian`
--

INSERT INTO `riwayat_pembelian` (`id`, `pelanggan_id`, `produk_id`, `tanggal_pembelian`, `jumlah`, `total_harga`) VALUES
(1, 1, 1, '2024-05-01 10:00:00', 2, 1000000.00),
(2, 2, 2, '2024-05-02 11:00:00', 2, 400000.00),
(3, 3, 3, '2024-05-03 12:00:00', 1, 300000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` text,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `alamat`, `telepon`, `email`) VALUES
(1, 'PT. Kain Sutra', 'Jl. Pabrik No. 1, Jakarta', '081234567890', 'kainsutra@example.com'),
(2, 'PT. Kain Katun', 'Jl. Pabrik No. 2, Bandung', '082345678901', 'kainkatun@example.com'),
(3, 'PT. Kain Linen', 'Jl. Pabrik No. 3, Surabaya', '083456789012', 'kainlinen@example.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
