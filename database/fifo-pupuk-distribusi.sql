-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2025 at 03:59 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.1

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
  `harga_distribusi` decimal(15,2) NOT NULL,
  `harga_total` decimal(15,2) NOT NULL,
  `jumlah_keluar` int NOT NULL,
  `tanggal_distribusi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distribusi`
--

INSERT INTO `distribusi` (`id_distribusi`, `id_pupuk`, `id_pengecer`, `satuan`, `tujuan`, `harga_distribusi`, `harga_total`, `jumlah_keluar`, `tanggal_distribusi`, `dokumentasi`) VALUES
(6, 2, 1, 'pcs', 'Gudang', '10000.00', '10000.00', 1, '29 January 2025', '1738241478_tes.png');

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
(1, 'Budi', 'Laki-laki', '2025-01-30', '082165443677', 'Padang');

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
(2, 'Urea', 'Pcs', '10000.00');

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
(2, 2, 1, '2025-01-30', '2025-01-31', '1738236879_tes.png');

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
(2, 2, 3, '30000.00');

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
  MODIFY `id_distribusi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengecer`
--
ALTER TABLE `pengecer`
  MODIFY `id_pengecer` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pupuk`
--
ALTER TABLE `pupuk`
  MODIFY `id_pupuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pupuk_masuk`
--
ALTER TABLE `pupuk_masuk`
  MODIFY `id_pupuk_masuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
