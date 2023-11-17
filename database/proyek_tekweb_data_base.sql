-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 02:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek_tekweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(30) DEFAULT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `gambar_deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`game_id`, `game_name`, `deskripsi`, `logo`, `gambar_deskripsi`) VALUES
(1, 'Clash Of Clans', 'Ayo isi gems mu di website kami karena website kami paling bagus blawbelawelab', '/Proyek tekweb/assets/clash of clans/clash_of_clans_logo.png', '/Proyek tekweb/assets/clash of clans/clash_of_clans_detail_image.png'),
(2, 'Mobile Legends', 'Segera beli diamond mu agar dapat menggunakan skin epic fanny aoweiawoenawokaok', '/Proyek tekweb/assets/mobile legends/mobile_legends_logo.png', '/Proyek tekweb/assets/mobile legends/mobile_legends_detail_image.jpg'),
(3, 'PUBG Mobile', 'Pabji', '/Proyek tekweb/assets/pubg/pubg_mobile_logo.png', '/Proyek tekweb/assets/pubg/pubg_detail_image.jpg'),
(4, 'Stumble Guys', 'Ini stumble', '/Proyek tekweb/assets/stumble guys/stumble_guys_logo.png', '/Proyek tekweb/assets/stumble guys/stumble_guys_detail_image.png'),
(5, 'Valorant', 'ini deskripsi nya valorant', '/Proyek tekweb/assets/valorant/valorant_logo.jpg', '/Proyek tekweb/assets/valorant/valorant_detail_image.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `history_isi_saldo`
--

CREATE TABLE `history_isi_saldo` (
  `history_id` int(11) NOT NULL,
  `nominal_isi_saldo` int(11) NOT NULL,
  `tanggal_request` date NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `status_isi_saldo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_isi_saldo`
--

INSERT INTO `history_isi_saldo` (`history_id`, `nominal_isi_saldo`, `tanggal_request`, `member_id`, `status_isi_saldo`) VALUES
(1, 100000, '2023-11-06', 1, -1),
(2, 100000, '2023-11-06', 2, -1),
(3, 15000, '2023-11-08', 4, 1),
(4, 50000, '2023-11-08', 4, 1),
(5, 50000, '2023-11-08', 4, 1),
(6, 15000, '2023-11-08', 4, 1),
(7, 50000, '2023-11-08', 4, 1),
(8, 50000, '2023-11-08', 4, 0),
(9, 50000, '2023-11-08', 4, 0),
(10, 50000, '2023-11-08', 4, 0),
(11, 1000, '2023-11-11', 4, 0),
(12, 50000, '2023-11-11', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `uid_game` varchar(50) NOT NULL,
  `status_transaksi` int(10) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `tanggal_transaksi`, `uid_game`, `status_transaksi`, `item_id`, `member_id`) VALUES
(1, '2023-11-01', '#7G7UJKUR0', 1, 2, 1),
(2, '2023-11-01', '#7G7UJKUR0', 0, 2, 2),
(3, '2023-11-01', '#7G7UJKUR0', 0, 2, 1),
(4, '2023-11-01', '#4R5TJQUR1', 0, 2, 1),
(5, '2023-11-07', '#4R5TJQUR1', -1, 2, 4),
(6, '2023-11-07', '#7G7UJKUR0', 0, 2, 4),
(7, '2023-11-07', '#7G7UJKUR0', 0, 2, 4),
(8, '2023-11-07', '#7G7UJKUR0', 0, 2, 4),
(15, '2023-11-08', '#7G7UJKUR0', 0, 2, 4),
(17, '2023-11-08', '#7G7UJKUR1', 0, 2, 4),
(19, '2023-11-08', '#7G7UJKUR0', 0, 2, 4),
(20, '2023-11-08', '#7G7UJKUR0', 0, 2, 4),
(21, '2023-11-08', '#8G7GHUUR0', 0, NULL, 4),
(22, '2023-11-09', '#7G7UJKUR0', 0, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `status_stok` int(11) NOT NULL DEFAULT 1,
  `nominal_topup` int(10) NOT NULL,
  `harga_satuan` int(10) NOT NULL,
  `resource_image` varchar(255) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `status_stok`, `nominal_topup`, `harga_satuan`, `resource_image`, `game_id`) VALUES
(2, 1, 500, 8000, '/Proyek tekweb/assets/clash of clans/coc_500_gems.png', 1),
(3, 1, 1000, 25000, '', 2),
(4, 1, 100, 2000, '', 3),
(5, 1, 1000, 10000, '', 4),
(6, 0, 2000, 30000, 'hjk', NULL),
(7, 0, 2000, 30000, 'hjk', NULL),
(8, 0, 2000, 30000, 'hjk', NULL),
(9, 1, 2000, 30000, 'hjk', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `member_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(25) NOT NULL,
  `no_telepon` varchar(25) NOT NULL,
  `username` varchar(20) NOT NULL,
  `saldo` int(100) NOT NULL,
  `admin_access` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`member_id`, `email`, `password`, `no_telepon`, `username`, `saldo`, `admin_access`) VALUES
(1, 'C14220311@john.petra.ac.id', 'bowo', '087855325567', 'Wibowo1577', 100000, NULL),
(2, 'C14220322@john.petra.ac.id', 'yaya', '081934607193', 'User123', 100000, NULL),
(3, 'C14220328@john.petra.ac.id', 'admin123', '081908199089', 'admin123', 0, 1),
(4, 'C14220299@john.petra.ac.id', '1234', '081908199089', 'jason123', 257000, NULL),
(5, 'C14220298@john.petra.ac.id', '12345', '081908199000', 'seren123', 0, NULL),
(6, 'C142200001@john.petra.ac.id', '12345', '081908199000', 'ya', 0, NULL),
(7, 'C14220328@john.petra.ac.id', '12345', '081908199089', 'fefe', 0, NULL),
(8, 'C14220338@john.petra.ac.id', '12345', '081908199089', 'jess', 0, NULL),
(9, 'C14220273@john.petra.ac.id', '12345', '087853621210', 'leonard', 0, NULL),
(10, 'admin345@gmail.com', 'admin345', '087812345678', 'admin345', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `history_isi_saldo`
--
ALTER TABLE `history_isi_saldo`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `history_isi_saldo_ibfk_1` (`member_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `fk_item_id` (`item_id`),
  ADD KEY `fk_member_id` (`member_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_game_id` (`game_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `history_isi_saldo`
--
ALTER TABLE `history_isi_saldo`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_isi_saldo`
--
ALTER TABLE `history_isi_saldo`
  ADD CONSTRAINT `history_isi_saldo_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `users` (`member_id`) ON DELETE SET NULL;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_member_id` FOREIGN KEY (`member_id`) REFERENCES `users` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_game_id` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
