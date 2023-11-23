-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2023 at 05:51 PM
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
(1, 'Clash Of Clans', 'Ayo isi gems mu di website kami karena website kami paling bagus blawbelawelab', 'assets/clash of clans/clash_of_clans_logo.png', 'assets/clash of clans/clash_of_clans_detail_image.png'),
(2, 'Mobile Legends', 'Segera beli diamond mu agar dapat menggunakan skin epic fanny aoweiawoenawokaok', 'assets/mobile legends/mobile_legends_logo.png', 'assets/mobile legends/mobile_legends_detail_image.jpg'),
(3, 'PUBG Mobile', 'Pabji', 'assets/pubg/pubg_mobile_logo.png', 'assets/pubg/pubg_detail_image.jpg'),
(4, 'Stumble Guys', 'Ini stumble', 'assets/stumble guys/stumble_guys_logo.png', 'assets/stumble guys/stumble_guys_detail_image.png'),
(5, 'Valorant', 'ini deskripsi nya valorant', 'assets/valorant/valorant_logo.jpg', 'assets/valorant/valorant_detail_image.jpg'),
(6, 'Pulsa XL', 'ini pulsa pulsa pulsaaaaa', 'assets/xl/pulsa_xl_logo.png', 'assets/xl/Pulsa_xl_detail_image.jpg'),
(7, 'Pulsa Telkomsel', 'ini pulsa ttelkomselllll', 'assets/telkomsel/pulsa_telkomsel_logo.png', 'assets/telkomsel/Pulsa_telkomsel_detail_image.png'),
(8, 'Pulsa Indosat', 'ini pulsa kaum missqueen yahaha hayukk', 'assets/im3/pulsa_im3_logo.png', 'assets/im3/Pulsa_im3_detail_image.jpg'),
(9, 'Pulsa Tri', 'ini pulsa apa jir awokawokawok', 'assets/tri/pulsa_tri_logo.png', 'assets/tri/Pulsa_tri_detail_image.png'),
(10, 'Pulsa Smartfren', 'ya ini adalah pulsa', 'assets/smartfren/pulsa_smartfren_logo.png', 'assets/smartfren/Pulsa_smartfren_detail_image.jpg');

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
(4, 50000, '2023-11-08', 4, -1),
(5, 50000, '2023-11-08', 4, 1),
(6, 15000, '2023-11-08', 4, 1),
(7, 50000, '2023-11-08', 4, 1),
(8, 50000, '2023-11-08', 4, 0),
(9, 50000, '2023-11-08', 4, 0),
(10, 50000, '2023-11-08', 4, 0),
(11, 1000, '2023-11-11', 4, 0),
(12, 50000, '2023-11-11', 4, 0),
(13, 123000, '2023-11-13', 8, 1),
(14, 123000, '2023-11-13', 8, 1),
(15, 121212, '2023-11-18', 12, -1),
(16, 100000, '2023-11-19', 3, 0),
(17, 6789990, '2023-11-20', 4, 0),
(18, 100000, '2023-11-20', 4, 0),
(19, 100000, '2023-11-20', 4, 0),
(20, 50000, '2023-11-20', 4, 0),
(21, 12000, '2023-11-23', 3, 0);

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
(33, '2023-11-18', '123123', 1, 20, 8),
(34, '2023-11-18', '12345', 1, 17, 4),
(35, '2023-11-18', '12345', 1, 32, 4),
(36, '2023-11-18', '12345', 1, 32, 4),
(37, '2023-11-18', '12345', 1, 27, 4),
(38, '2023-11-18', '123123', 1, 32, 1),
(39, '2023-11-18', '12345', 1, 2, 1),
(40, '2023-11-18', '12345', 1, 27, 1),
(41, '2023-11-18', '123123', -1, 17, 12),
(42, '2023-11-19', '12345', 0, 10, 12),
(43, '2023-11-20', '123123', 0, 17, 4);

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
(2, 1, 500, 8000, 'assets/clash of clans/coc_500_gems.png', 1),
(9, 1, 1000, 170000, 'assets\\clash of clans\\coc_1000_gems.png', 1),
(10, 1, 25000, 350000, 'assets/clash of clans/coc_2500_gems.png', 1),
(17, 1, 53, 17000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/50ormore_MLBB_Diamonds.png', 2),
(19, 1, 154, 51000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/150orMore_MLBB_Diamonds.png', 2),
(20, 1, 217, 68500, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/150orMore_MLBB_Diamonds.png', 2),
(21, 1, 256, 84500, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/150orMore_MLBB_Diamonds.png', 2),
(22, 1, 367, 115000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/150orMore_MLBB_Diamonds.png', 2),
(23, 1, 503, 156000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/500orMore_MLBB_Diamonds.png', 2),
(24, 1, 774, 240000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/500orMore_MLBB_Diamonds.png', 2),
(25, 1, 1708, 525000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/1500orMore_MLBB_Diamonds.png', 2),
(26, 1, 4003, 1270000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/5000orMore_MLBB_Diamonds.png', 2),
(27, 1, 60, 17800, 'https://cdn1.codashop.com/S/content/common/images/denom-image/PUBG/60_PUBG_UC.png', 3),
(28, 1, 325, 81500, 'https://cdn1.codashop.com/S/content/common/images/denom-image/PUBG/325_PUBG_UC.png', 3),
(29, 1, 1800, 398000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/PUBG/660_PUBG_UC.png', 3),
(30, 1, 3850, 796000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/PUBG/3850_PUBG_UC.png', 3),
(31, 1, 8100, 1590000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/PUBG/8100_PUBG_UC.png', 3),
(32, 1, 80, 17600, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Supercell/ClashOfClans/new/CoC_80_Gems.png', 1),
(33, 1, 6500, 799000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Supercell/ClashOfClans/new/CoC_6500_Gems.png', 1),
(34, 1, 14000, 1600000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Supercell/ClashOfClans/new/CoC_14000_Gems.png', 1),
(35, 1, 33, 10900, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Supercell/ClashOfClans/new/CoC_80_Gems.png', 1),
(40, 1, 250, 14200, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Stumble_Guys/transparent/StumbleGuys-Denom-1-250g.png', 4),
(41, 1, 800, 34500, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Stumble_Guys/transparent/StumbleGuys-Denom-4-800g.png', 4),
(42, 1, 1600, 56595, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Stumble_Guys/transparent/StumbleGuys-Denom-6-1600g.png', 4),
(43, 1, 5000, 137500, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Stumble_Guys/transparent/StumbleGuys-Denom-2-5000g.png', 4),
(44, 1, 120, 39700, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Stumble_Guys/transparent/StumbleGuys-Denom-5-120t.png', 4),
(45, 1, 1300, 315000, 'https://cdn1.codashop.com/S/content/common/images/denom-image/Stumble_Guys/transparent/StumbleGuys-Denom-3-1300t.png', 4),
(46, 1, 125, 16500, 'assets/valorant/valorant_points.jpg', 5),
(47, 1, 420, 52000, 'assets/valorant/valorant_points.jpg', 5),
(48, 1, 700, 80000, 'assets/valorant/valorant_points.jpg', 5),
(49, 1, 1375, 150000, 'assets/valorant/valorant_points.jpg', 5),
(50, 1, 2400, 250000, 'assets/valorant/valorant_points.jpg', 5),
(51, 1, 4000, 400000, 'assets/valorant/valorant_points.jpg', 5),
(52, 1, 8150, 800000, 'assets/valorant/valorant_points.jpg', 5),
(77, 1, 15000, 16500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(78, 1, 25000, 26500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(79, 1, 30000, 31500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(80, 1, 40000, 41500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(81, 1, 50000, 51500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(82, 1, 75000, 76500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(83, 1, 100000, 100000, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(84, 1, 150000, 151000, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(85, 1, 200000, 201500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(86, 1, 300000, 301500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(87, 1, 500000, 501500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(88, 1, 1000000, 1001500, 'http://localhost/assets/tri/pulsa_tri_logo.png', 9),
(89, 1, 5000, 6750, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(90, 1, 10000, 11500, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(91, 1, 15000, 15500, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(92, 1, 25000, 25000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(93, 1, 30000, 30000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(94, 1, 50000, 50000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(95, 1, 100000, 100000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(96, 1, 150000, 150500, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(97, 1, 200000, 201000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(98, 1, 300000, 301000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(99, 1, 500000, 501000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(100, 1, 1000000, 1000000, 'http://localhost/assets/xl/pulsa_xl_logo.png', 6),
(101, 1, 10000, 11500, 'assets/im3/pulsa_im3_logo.png', 8),
(102, 1, 12000, 12000, 'assets/im3/pulsa_im3_logo.png', 8),
(103, 1, 15000, 15000, 'assets/im3/pulsa_im3_logo.png', 8),
(104, 1, 20000, 20300, 'assets/im3/pulsa_im3_logo.png', 8),
(105, 1, 25000, 25000, 'assets/im3/pulsa_im3_logo.png', 8),
(106, 1, 30000, 30000, 'assets/im3/pulsa_im3_logo.png', 8),
(107, 1, 50000, 50000, 'assets/im3/pulsa_im3_logo.png', 8),
(108, 1, 100000, 100000, 'assets/im3/pulsa_im3_logo.png', 8),
(109, 1, 115000, 115500, 'assets/im3/pulsa_im3_logo.png', 8),
(110, 1, 125000, 125000, 'assets/im3/pulsa_im3_logo.png', 8),
(111, 1, 150000, 150000, 'assets/im3/pulsa_im3_logo.png', 8),
(112, 1, 200000, 200000, 'assets/im3/pulsa_im3_logo.png', 8),
(113, 1, 15000, 16500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(114, 1, 25000, 26500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(115, 1, 30000, 31500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(116, 1, 40000, 41500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(117, 1, 50000, 51500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(118, 1, 75000, 76500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(119, 1, 100000, 100000, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(120, 1, 150000, 151000, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(121, 1, 200000, 201500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(122, 1, 300000, 301500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(123, 1, 500000, 501500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(124, 1, 1000000, 1001500, 'assets/telkomsel/pulsa_telkomsel_logo.png', 7),
(125, 1, 5000, 6700, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(126, 1, 10000, 11500, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(127, 1, 20000, 21000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(128, 1, 25000, 25000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(129, 1, 30000, 30000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(130, 1, 50000, 50000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(131, 1, 60000, 60000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(132, 1, 100000, 101000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(133, 1, 150000, 151500, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(134, 1, 200000, 200000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(135, 1, 300000, 300000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(136, 1, 500000, 500000, 'assets/smartfren/pulsa_smartfren_logo.png', 10),
(137, 1, 1000000, 1000000, 'assets/smartfren/pulsa_smartfren_logo.png', 10);

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
(1, 'C14220311@john.petra.ac.id', 'bowo', '087855325567', 'Wibowo1577', 56600, NULL),
(2, 'C14220322@john.petra.ac.id', 'yaya', '081934607193', 'User123', 100000, NULL),
(3, 'C14220328@john.petra.ac.id', 'admin123', '081908199089', 'admin123', 0, 1),
(4, 'C14220299@john.petra.ac.id', '1234', '081908199089', 'jason123', 98000, NULL),
(5, 'C14220298@john.petra.ac.id', '12345', '081908199000', 'seren123', 0, NULL),
(6, 'C142200001@john.petra.ac.id', '12345', '081908199000', 'ya', 0, NULL),
(7, 'C14220328@john.petra.ac.id', '12345', '081908199089', 'fefe', 0, NULL),
(8, 'C14220338@john.petra.ac.id', '12345', '081908199089', 'jess', 4500, NULL),
(9, 'C14220273@john.petra.ac.id', '12345', '087853621210', 'leonard', 0, NULL),
(10, 'admin345@gmail.com', 'admin345', '087812345678', 'admin345', 0, 1),
(11, 'admin1211@gmail.com', 'admin1211', '123123123123', 'admin1211', 0, NULL),
(12, 'ezra@gmail.com', 'ezra123', '081231231', 'ezra', 2147483647, 1);

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
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `history_isi_saldo`
--
ALTER TABLE `history_isi_saldo`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
