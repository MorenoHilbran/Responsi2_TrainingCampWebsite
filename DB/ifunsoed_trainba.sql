-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2024 at 10:55 PM
-- Server version: 8.0.33-cll-lve
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ifunsoed_trainba`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `email`, `password`) VALUES
('renggo', 'renggo@gmail.com', 'renggo123');

-- --------------------------------------------------------

--
-- Table structure for table `detailcamp`
--

CREATE TABLE `detailcamp` (
  `id_jadwal` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `username` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailcamp`
--

INSERT INTO `detailcamp` (`id_jadwal`, `id_user`, `username`, `email`) VALUES
(4, 4, 'sasa', 'sasa123@gmail.com'),
(4, 1, 'kafah', 'kafah123@gmail.com'),
(6, 6, 'nero', 'renshin@gmail.com'),
(7, 4, 'sasa', 'sasa123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int NOT NULL,
  `nama_latihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `gambar` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `nama_latihan`, `deskripsi`, `tempat`, `tanggal`, `waktu`, `gambar`) VALUES
(4, 'Kumpul Santai', 'Perdana kumpul dulu adik adik', 'Rumah Sasa', '2024-11-30', '07:00:00', 'uploads/6749c9652ca64.jpg'),
(6, 'Sparing dengan SMA N 1 Purwokerto', 'Latih tanding dengan tim basket SMAN 1 Purwokerto', 'Rajawali Arena', '2024-12-20', '13:00:00', 'uploads/675d73cece429.jpeg'),
(7, 'Summer Training Camp', 'Latihan basket pada saat musim panas bersama dengan coach profesional', 'Gedung KongKwan', '2024-12-20', '08:05:00', 'uploads/675d749e61b7c.jpeg'),
(8, 'Latih Tanding Informatics Championship', 'sparring antar angkatan persiapan turnamen informatics championship', 'Defron', '2024-12-31', '14:15:00', 'uploads/675d79b699b51.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`) VALUES
(1, 'kafah', 'kafah123@gmail.com', 'kafah123'),
(4, 'sasa', 'sasa123@gmail.com', 'sasa123'),
(5, 'beni', 'beni@unsoed.com', 'beni123'),
(6, 'nero', 'renshin@gmail.com', 'nero123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `detailcamp`
--
ALTER TABLE `detailcamp`
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailcamp`
--
ALTER TABLE `detailcamp`
  ADD CONSTRAINT `detailcamp_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`),
  ADD CONSTRAINT `detailcamp_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
