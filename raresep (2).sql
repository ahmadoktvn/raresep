-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 04:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `raresep`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `bahan`
--

CREATE TABLE `bahan` (
  `id_bahan` int(11) NOT NULL,
  `id_resep` int(11) DEFAULT NULL,
  `nama_bahan` varchar(255) NOT NULL,
  `jumlah` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan`
--

INSERT INTO `bahan` (`id_bahan`, `id_resep`, `nama_bahan`, `jumlah`) VALUES
(7, 6, 'Nasi Putih', '1 mangkuk'),
(8, 6, 'Telur', '2 butir'),
(9, 7, 'Telur', '4 butir'),
(11, 7, 'Gula Putih', '100 gram'),
(12, 7, 'Blue band', '200 gra,'),
(13, 6, 'Sayur', '1 buah');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(4, 'Dessert');

-- --------------------------------------------------------

--
-- Table structure for table `langkah`
--

CREATE TABLE `langkah` (
  `id_langkah` int(11) NOT NULL,
  `id_resep` int(11) DEFAULT NULL,
  `nomor_langkah` int(11) NOT NULL DEFAULT 1,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `langkah`
--

INSERT INTO `langkah` (`id_langkah`, `id_resep`, `nomor_langkah`, `deskripsi`, `gambar`) VALUES
(19, 7, 1, 'Pertama tama siapkan tepung terigu', '1739606617_terigu.jpg'),
(20, 7, 2, 'Kedua tuangkan dalam mangkuk sebanyak 1 kg edit edit', NULL),
(25, 7, 3, 'ketiga', NULL),
(26, 7, 4, 'ke empat', NULL),
(27, 7, 5, 'kelima', '1739607033_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

CREATE TABLE `resep` (
  `id_resep` int(11) NOT NULL,
  `judul_resep` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `waktu_masak` int(11) DEFAULT NULL,
  `gambar_resep` varchar(255) DEFAULT NULL,
  `tanggal_posting` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resep`
--

INSERT INTO `resep` (`id_resep`, `judul_resep`, `deskripsi`, `id_kategori`, `waktu_masak`, `gambar_resep`, `tanggal_posting`) VALUES
(6, 'Gimbab Telur Gulung', 'Sarapan praktis ini terinspirasi dari Gimbap Korea, namun disederhanakan dengan Nasi putih yang gurih dibalut dengan telur dadar tipis, dengan isian wortel dan bayam rebus yang menyegarkan. Sangat cocok untuk sarapan cepat dan praktis sebelum berangkat kerja.\r\n', 1, 13, '67b09612adc80.webp', '2025-02-15 13:26:42'),
(7, 'Kue Ulang Tahun', 'Kue ulang tahun untu dijual, bikinnya mudah dan tidak ribet untuk pemula🫶🏼 jagbbabi', 4, 59, 'kue-ulang-tahun.webp', '2025-02-14 15:17:32'),
(8, 'Jus Jambu', 'Cara membuat jus jambu yang mudah dan menyegarkan/', 2, 10, 'download.webp', '2025-02-15 12:47:14'),
(9, 'Simple Pancake', 'Yang nyari resep pancake sat set enak fluffy sini yuk kumpul..\r\nResep mbak Farida recommended ya @faridaSulthan_0107 .', 4, 30, 'pancake.webp', '2025-02-15 12:51:33'),
(10, 'Es Kuwut Melon simple', 'Ini es paling seger dan gampang bikinnya, buat biuka puasa cocok banget', 2, 15, 'eskuwut.webp', '2025-02-15 12:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `resep_kategori`
--

CREATE TABLE `resep_kategori` (
  `id` int(11) NOT NULL,
  `id_resep` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `bahan`
--
ALTER TABLE `bahan`
  ADD PRIMARY KEY (`id_bahan`),
  ADD KEY `id_resep` (`id_resep`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `langkah`
--
ALTER TABLE `langkah`
  ADD PRIMARY KEY (`id_langkah`),
  ADD KEY `id_resep` (`id_resep`);

--
-- Indexes for table `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `resep_kategori`
--
ALTER TABLE `resep_kategori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_resep` (`id_resep`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bahan`
--
ALTER TABLE `bahan`
  MODIFY `id_bahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `langkah`
--
ALTER TABLE `langkah`
  MODIFY `id_langkah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `resep`
--
ALTER TABLE `resep`
  MODIFY `id_resep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `resep_kategori`
--
ALTER TABLE `resep_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahan`
--
ALTER TABLE `bahan`
  ADD CONSTRAINT `bahan_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `resep` (`id_resep`);

--
-- Constraints for table `langkah`
--
ALTER TABLE `langkah`
  ADD CONSTRAINT `langkah_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `resep` (`id_resep`);

--
-- Constraints for table `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `resep_kategori`
--
ALTER TABLE `resep_kategori`
  ADD CONSTRAINT `resep_kategori_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `resep` (`id_resep`) ON DELETE CASCADE,
  ADD CONSTRAINT `resep_kategori_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
