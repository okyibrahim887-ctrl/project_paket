-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 02:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_paket`
--

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `nama_penerima` varchar(100) DEFAULT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `nama_satpam` varchar(100) DEFAULT NULL,
  `status_cod` varchar(1) DEFAULT NULL,
  `harga_cod` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status_paket` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id`, `nama_penerima`, `no_wa`, `nama_satpam`, `status_cod`, `harga_cod`, `catatan`, `tanggal`, `status_paket`) VALUES
(1, 'adul', '62895329615900', 'ha', '1', 1, 'f', '2026-02-12 09:33:15', '0'),
(2, 'adul', '62895329615900', 'ha', '0', 1, 'f', '2026-02-12 09:35:01', '0'),
(3, 'suuu', '62895329615900', 'ha', '1', 0, 'f', '2026-02-12 09:36:54', '0'),
(4, 'suuu', '62895329615900', 'ha', '1', 0, 'f', '2026-02-12 09:44:25', '1'),
(5, 'wwwww', '62895329615900', 'ha', '1', 4646, 'fe', '2026-02-14 11:53:44', '1'),
(6, 'lll', '62895329615900', 'has', '1', 122222, '', '2026-02-18 08:23:07', '1'),
(7, 'ica', '088279040942', 'ha', '1', 250, 'y', '2026-02-18 09:15:00', '1'),
(8, 'afdal zikri', '62895329615900', 'bujang', '1', 50000, 'paket sudah di lobby', '2026-02-18 09:20:01', '1'),
(9, 'mhd yovi andra', '62895329615900', 'bujang', '1', 67890, '', '2026-02-18 09:50:38', '0'),
(10, 'adul', '0895329615900', 'has', '1', 50000, '', '2026-02-20 16:18:57', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
