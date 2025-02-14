-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2025 at 03:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fifo-pupuk-distribusi`
--

-- --------------------------------------------------------

--
-- Table structure for table `distribusi`
--

CREATE TABLE `distribusi` (
  `id_distribusi` int NOT NULL,
  `id_pupuk` int NOT NULL,
  `id_pengecer` int NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tujuan` text COLLATE utf8mb4_general_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_distribusi` decimal(15,2) NOT NULL,
  `harga_total` decimal(15,2) NOT NULL,
  `jumlah_keluar` int NOT NULL,
  `tanggal_distribusi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distribusi`
--

INSERT INTO `distribusi` (`id_distribusi`, `id_pupuk`, `id_pengecer`, `satuan`, `tujuan`, `kecamatan`, `harga_distribusi`, `harga_total`, `jumlah_keluar`, `tanggal_distribusi`, `dokumentasi`) VALUES
(8, 3, 1, 'Kg', 'Toko Tani Makmur', 'Padang Timur', '120000.00', '60000000.00', 500, '2025-02-01', 'dist_pupuk1.jpg'),
(9, 4, 2, 'Kg', 'UD Sumber Rejeki', 'Jakarta Pusat', '130000.00', '91000000.00', 700, '2025-02-02', 'dist_pupuk2.jpg'),
(10, 5, 3, 'Kg', 'CV Berkah Tani', 'Bandung Barat', '140000.00', '112000000.00', 800, '2025-02-03', 'dist_pupuk3.jpg'),
(11, 6, 4, 'Kg', 'Kios Pupuk Jaya', 'Surabaya Selatan', '150000.00', '90000000.00', 600, '2025-02-04', 'dist_pupuk4.jpg'),
(12, 7, 5, 'Kg', 'Tani Sejahtera', 'Medan Utara', '160000.00', '144000000.00', 900, '2025-02-05', 'dist_pupuk5.jpg'),
(13, 3, 6, 'Kg', 'Toko Hijau Subur', 'Yogyakarta Barat', '170000.00', '170000000.00', 1000, '2025-02-06', 'dist_pupuk6.jpg'),
(14, 4, 7, 'Kg', 'UD Maju Bersama', 'Semarang Tengah', '180000.00', '216000000.00', 1200, '2025-02-07', 'dist_pupuk7.jpg'),
(15, 5, 8, 'Kg', 'CV Tumbuh Makmur', 'Malang Selatan', '190000.00', '209000000.00', 1100, '2025-02-08', 'dist_pupuk8.jpg'),
(16, 6, 9, 'Kg', 'Kios Tani Mandiri', 'Makassar Timur', '200000.00', '190000000.00', 950, '2025-02-09', 'dist_pupuk9.jpg'),
(17, 7, 10, 'Kg', 'Toko Petani Sukses', 'Pekanbaru Utara', '210000.00', '178500000.00', 850, '2025-02-10', 'dist_pupuk10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pengecer`
--

CREATE TABLE `pengecer` (
  `id_pengecer` int NOT NULL,
  `nama_pengecer` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengecer`
--

INSERT INTO `pengecer` (`id_pengecer`, `nama_pengecer`, `jenis_kelamin`, `tanggal_lahir`, `no_hp`, `alamat`) VALUES
(1, 'Budi', 'Laki-laki', '1990-12-02', '081234567890', 'Padang'),
(2, 'Siti', 'Perempuan', '1985-02-07', '082198765432', 'Jakarta'),
(3, 'Rudi', 'Laki-laki', '1993-11-10', '081276543210', 'Bandung'),
(4, 'Ani', 'Perempuan', '1995-05-05', '085678909876', 'Surabaya'),
(5, 'Joko', 'Laki-laki', '1988-09-18', '083212345678', 'Medan'),
(6, 'Fitri', 'Perempuan', '1992-03-30', '081390987654', 'Yogyakarta'),
(7, 'Dedi', 'Laki-laki', '1980-12-25', '087654321098', 'Semarang'),
(8, 'Lestari', 'Perempuan', '1997-06-15', '081267890123', 'Malang'),
(9, 'Agus', 'Laki-laki', '1983-08-07', '089876543210', 'Makassar'),
(10, 'Wati', 'Perempuan', '1996-04-12', '081323456789', 'Pekanbaru');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `nama_distributor` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_pupuk` int NOT NULL,
  `id_pengecer` int NOT NULL,
  `jumlah` int NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `status` enum('Pending','Diproses','Selesai','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permintaan`
--

INSERT INTO `permintaan` (`id_permintaan`, `tanggal_permintaan`, `nama_distributor`, `id_pupuk`, `id_pengecer`, `jumlah`, `kecamatan`, `dokumentasi`, `keterangan`, `status`) VALUES
(7, '2025-02-01', 'PT Pupuk Indonesia', 3, 1, 500, 'Kecamatan Lima Kaum', 'permintaan1.jpg', 'Permintaan untuk musim tanam', 'Pending'),
(8, '2025-02-02', 'CV Agro Subur', 4, 2, 700, 'Kecamatan Pariangan', 'permintaan2.jpg', 'Stok menipis', 'Diproses'),
(9, '2025-02-03', 'UD Tani Makmur', 5, 3, 800, 'Kecamatan Rambatan', 'permintaan3.jpg', 'Kebutuhan pupuk tambahan', 'Selesai'),
(10, '2025-02-04', 'PT Sumber Tani', 6, 4, 600, 'Kecamatan Lintau Buo', 'permintaan4.jpg', 'Permintaan darurat', 'Ditolak'),
(11, '2025-02-05', 'Koperasi Petani Jaya', 7, 5, 900, 'Kecamatan Batipuh', 'permintaan5.jpg', 'Pengiriman rutin', 'Pending'),
(12, '2025-02-06', 'PT Agro Nusantara', 3, 6, 1000, 'Kecamatan X Koto', 'permintaan6.jpg', 'Permintaan untuk proyek pertanian', 'Diproses'),
(13, '2025-02-07', 'UD Sukses Tani', 4, 7, 1200, 'Kecamatan Sungayang', 'permintaan7.jpg', 'Pesanan musiman', 'Selesai'),
(14, '2025-02-08', 'PT Perkasa Agri', 5, 8, 1100, 'Kecamatan Tanjung Emas', 'permintaan8.jpg', 'Stok awal tahun', 'Ditolak'),
(15, '2025-02-09', 'CV Harapan Tani', 6, 9, 950, 'Kecamatan Padang Ganting', 'permintaan9.jpg', 'Permintaan mendadak dari petani', 'Pending'),
(16, '2025-02-10', 'KUD Tani Maju', 7, 10, 850, 'Kecamatan Salimpaung', 'permintaan10.jpg', 'Distribusi wilayah baru', 'Diproses');

-- --------------------------------------------------------

--
-- Table structure for table `pupuk`
--

CREATE TABLE `pupuk` (
  `id_pupuk` int NOT NULL,
  `nama_pupuk` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupuk`
--

INSERT INTO `pupuk` (`id_pupuk`, `nama_pupuk`, `satuan`, `harga`) VALUES
(3, 'Urea1', 'pcs', '100000.00'),
(4, 'SP-36', 'Pcs', '120000.00'),
(5, 'Zwavelzure Ammoniak', 'Pcs', '130000.00'),
(6, 'KCl (Kalium Klorida) ', 'Pcs', '140000.00'),
(7, 'NPK (Nitrogen, Phosphorus, Potassium)', 'Pcs', '150000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pupuk_masuk`
--

CREATE TABLE `pupuk_masuk` (
  `id_pupuk_masuk` int NOT NULL,
  `id_pupuk` int NOT NULL,
  `jumlah_masuk` int NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupuk_masuk`
--

INSERT INTO `pupuk_masuk` (`id_pupuk_masuk`, `id_pupuk`, `jumlah_masuk`, `tanggal_masuk`, `tanggal_kadaluarsa`, `dokumentasi`) VALUES
(3, 3, 500, '2025-02-01', '2026-02-01', 'doc_pupuk1.jpg'),
(4, 4, 700, '2025-02-02', '2026-02-02', 'doc_pupuk2.jpg'),
(5, 5, 800, '2025-02-03', '2026-02-03', 'doc_pupuk3.jpg'),
(6, 6, 600, '2025-02-04', '2026-02-04', 'doc_pupuk4.jpg'),
(7, 7, 900, '2025-02-05', '2026-02-05', 'doc_pupuk5.jpg'),
(8, 3, 1000, '2025-02-06', '2026-02-06', 'doc_pupuk6.jpg'),
(9, 4, 1200, '2025-02-07', '2026-02-07', 'doc_pupuk7.jpg'),
(10, 5, 1100, '2025-02-08', '2026-02-08', 'doc_pupuk8.jpg'),
(11, 6, 950, '2025-02-09', '2026-02-09', 'doc_pupuk9.jpg'),
(12, 7, 850, '2025-02-10', '2026-02-10', 'doc_pupuk10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id_stok` int NOT NULL,
  `id_pupuk` int NOT NULL,
  `stok` int NOT NULL,
  `harga_total` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id_stok`, `id_pupuk`, `stok`, `harga_total`) VALUES
(4, 3, 1000, '100000000.00'),
(5, 4, 1000, '120000000.00'),
(6, 5, 1000, '130000000.00'),
(7, 6, 1000, '140000000.00'),
(8, 7, 1000, '150000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `email`, `username`, `password`, `level`) VALUES
(1, 'Administrator', 'admin@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD PRIMARY KEY (`id_distribusi`),
  ADD KEY `id_pupuk` (`id_pupuk`),
  ADD KEY `id_pengecer` (`id_pengecer`);

--
-- Indexes for table `pengecer`
--
ALTER TABLE `pengecer`
  ADD PRIMARY KEY (`id_pengecer`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `id_pupuk` (`id_pupuk`),
  ADD KEY `permintaan_ibfk_2` (`id_pengecer`);

--
-- Indexes for table `pupuk`
--
ALTER TABLE `pupuk`
  ADD PRIMARY KEY (`id_pupuk`);

--
-- Indexes for table `pupuk_masuk`
--
ALTER TABLE `pupuk_masuk`
  ADD PRIMARY KEY (`id_pupuk_masuk`),
  ADD KEY `id_pupuk` (`id_pupuk`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_pupuk` (`id_pupuk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `distribusi`
--
ALTER TABLE `distribusi`
  MODIFY `id_distribusi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pengecer`
--
ALTER TABLE `pengecer`
  MODIFY `id_pengecer` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pupuk`
--
ALTER TABLE `pupuk`
  MODIFY `id_pupuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pupuk_masuk`
--
ALTER TABLE `pupuk_masuk`
  MODIFY `id_pupuk_masuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD CONSTRAINT `distribusi_ibfk_1` FOREIGN KEY (`id_pupuk`) REFERENCES `pupuk` (`id_pupuk`) ON DELETE CASCADE,
  ADD CONSTRAINT `distribusi_ibfk_2` FOREIGN KEY (`id_pengecer`) REFERENCES `pengecer` (`id_pengecer`) ON DELETE CASCADE;

--
-- Constraints for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD CONSTRAINT `permintaan_ibfk_1` FOREIGN KEY (`id_pupuk`) REFERENCES `pupuk` (`id_pupuk`) ON DELETE CASCADE,
  ADD CONSTRAINT `permintaan_ibfk_2` FOREIGN KEY (`id_pengecer`) REFERENCES `pengecer` (`id_pengecer`) ON DELETE CASCADE;

--
-- Constraints for table `pupuk_masuk`
--
ALTER TABLE `pupuk_masuk`
  ADD CONSTRAINT `pupuk_masuk_ibfk_1` FOREIGN KEY (`id_pupuk`) REFERENCES `pupuk` (`id_pupuk`) ON DELETE CASCADE;

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_pupuk`) REFERENCES `pupuk` (`id_pupuk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
