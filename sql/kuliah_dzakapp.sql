-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2021 at 11:37 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kuliah_dzakapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat_tukar`
--

CREATE TABLE `alat_tukar` (
  `id_alatTukar` int(11) NOT NULL,
  `alatTukar` varchar(11) NOT NULL,
  `nominal_rupiah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alat_tukar`
--

INSERT INTO `alat_tukar` (`id_alatTukar`, `alatTukar`, `nominal_rupiah`) VALUES
(1, 'emas', 827599),
(2, 'perak', 14486);

-- --------------------------------------------------------

--
-- Table structure for table `biodata`
--

CREATE TABLE `biodata` (
  `id_biodata` int(11) NOT NULL,
  `nama` varchar(155) NOT NULL,
  `emails` varchar(155) NOT NULL,
  `pass` varchar(155) NOT NULL,
  `kode_pos` int(11) NOT NULL,
  `rt` int(11) NOT NULL,
  `rw` int(11) NOT NULL,
  `nomor_rumah` int(11) NOT NULL,
  `alamat_lengkap` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biodata`
--

INSERT INTO `biodata` (`id_biodata`, `nama`, `emails`, `pass`, `kode_pos`, `rt`, `rw`, `nomor_rumah`, `alamat_lengkap`) VALUES
(5, 'Saya Admin', 'admin@admin.com', 'admin', 70128, 123, 122, 12, 'Jl.Admin Dekat Sini Saja Semoga Membantu'),
(9, 'User', 'user@user.com', 'useruser', 70128, 1, 1, 1, 'Jl.rumah alamt lengkap');

-- --------------------------------------------------------

--
-- Table structure for table `biodata_penerima`
--

CREATE TABLE `biodata_penerima` (
  `id_penerima` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `alamat_lengkap` varchar(100) NOT NULL,
  `kode_pos` int(11) NOT NULL,
  `foto_penerima` varchar(200) NOT NULL,
  `foto_tempatTinggal` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biodata_penerima`
--

INSERT INTO `biodata_penerima` (`id_penerima`, `nama`, `reason`, `alamat_lengkap`, `kode_pos`, `foto_penerima`, `foto_tempatTinggal`) VALUES
(4, 'Orang satu', 'Musafir', 'Jl.Kesna kemari, tidak menemukan nya', 70128, 'ant-201604-003977.jpg', 'ektptsunami281218.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `biodata_pj`
--

CREATE TABLE `biodata_pj` (
  `id_pj` int(11) NOT NULL,
  `id_biodata` int(11) NOT NULL,
  `status_active` int(11) NOT NULL,
  `ktp_foto` varchar(200) NOT NULL,
  `ktp_and_user` varchar(200) NOT NULL,
  `phone_no` varchar(200) NOT NULL,
  `debit_card` varchar(200) NOT NULL,
  `no_rek` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biodata_pj`
--

INSERT INTO `biodata_pj` (`id_pj`, `id_biodata`, `status_active`, `ktp_foto`, `ktp_and_user`, `phone_no`, `debit_card`, `no_rek`) VALUES
(4, 5, 1, 'WIN_20210615_18_10_44_Pro.jpg', 'WIN_20210615_18_10_52_Pro.jpg', '082143883436', 'BRI', 2147483647),
(7, 9, 1, 'bukti bbayrr.jpg', 'rumah orang.jpg', '123132123', 'BNI', 1232124142);

-- --------------------------------------------------------

--
-- Table structure for table `incomes_user`
--

CREATE TABLE `incomes_user` (
  `id_incomes` int(11) NOT NULL,
  `id_biodata` int(11) NOT NULL,
  `emas_amount` int(11) NOT NULL,
  `date_pay` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incomes_user`
--

INSERT INTO `incomes_user` (`id_incomes`, `id_biodata`, `emas_amount`, `date_pay`) VALUES
(4, 5, 99, '2022-06-15'),
(6, 9, 85, '2021-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `zakat_history`
--

CREATE TABLE `zakat_history` (
  `id_zakatHist` int(11) NOT NULL,
  `id_zakatReq` int(11) NOT NULL,
  `id_pj` int(11) NOT NULL,
  `id_penerima` int(11) NOT NULL,
  `bukti_pembayaran` varchar(155) DEFAULT NULL,
  `bukti_pemberian` varchar(155) DEFAULT NULL,
  `tanggal_pembayaran` varchar(155) DEFAULT NULL,
  `tanggal_pemberian` varchar(155) DEFAULT NULL,
  `tahun_hijri` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zakat_history`
--

INSERT INTO `zakat_history` (`id_zakatHist`, `id_zakatReq`, `id_pj`, `id_penerima`, `bukti_pembayaran`, `bukti_pemberian`, `tanggal_pembayaran`, `tanggal_pemberian`, `tahun_hijri`) VALUES
(10, 12, 4, 4, 'bukti pembayaan.jpg', 'ektptsunami281218.jpg', '2021-06-15', '2021-06-15', 1442),
(11, 13, 4, 4, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zakat_req`
--

CREATE TABLE `zakat_req` (
  `id_zakatReq` int(11) NOT NULL,
  `id_biodataPemberi` int(11) NOT NULL,
  `zakat_type` varchar(100) NOT NULL,
  `zakat_amount` float NOT NULL,
  `status_lunas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zakat_req`
--

INSERT INTO `zakat_req` (`id_zakatReq`, `id_biodataPemberi`, `zakat_type`, `zakat_amount`, `status_lunas`) VALUES
(12, 9, 'Fitrah', 40000, 'lunas'),
(13, 9, 'Mal', 2.125, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat_tukar`
--
ALTER TABLE `alat_tukar`
  ADD PRIMARY KEY (`id_alatTukar`);

--
-- Indexes for table `biodata`
--
ALTER TABLE `biodata`
  ADD PRIMARY KEY (`id_biodata`);

--
-- Indexes for table `biodata_penerima`
--
ALTER TABLE `biodata_penerima`
  ADD PRIMARY KEY (`id_penerima`);

--
-- Indexes for table `biodata_pj`
--
ALTER TABLE `biodata_pj`
  ADD PRIMARY KEY (`id_pj`),
  ADD KEY `id_biodata` (`id_biodata`);

--
-- Indexes for table `incomes_user`
--
ALTER TABLE `incomes_user`
  ADD PRIMARY KEY (`id_incomes`),
  ADD UNIQUE KEY `id_biodata` (`id_biodata`);

--
-- Indexes for table `zakat_history`
--
ALTER TABLE `zakat_history`
  ADD PRIMARY KEY (`id_zakatHist`),
  ADD UNIQUE KEY `id_zakatReq` (`id_zakatReq`),
  ADD KEY `id_pj` (`id_pj`),
  ADD KEY `id_penerima` (`id_penerima`);

--
-- Indexes for table `zakat_req`
--
ALTER TABLE `zakat_req`
  ADD PRIMARY KEY (`id_zakatReq`),
  ADD KEY `id_biodataPemberi` (`id_biodataPemberi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat_tukar`
--
ALTER TABLE `alat_tukar`
  MODIFY `id_alatTukar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `biodata`
--
ALTER TABLE `biodata`
  MODIFY `id_biodata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `biodata_penerima`
--
ALTER TABLE `biodata_penerima`
  MODIFY `id_penerima` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `biodata_pj`
--
ALTER TABLE `biodata_pj`
  MODIFY `id_pj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `incomes_user`
--
ALTER TABLE `incomes_user`
  MODIFY `id_incomes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zakat_history`
--
ALTER TABLE `zakat_history`
  MODIFY `id_zakatHist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `zakat_req`
--
ALTER TABLE `zakat_req`
  MODIFY `id_zakatReq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biodata_pj`
--
ALTER TABLE `biodata_pj`
  ADD CONSTRAINT `biodata_pj_ibfk_1` FOREIGN KEY (`id_biodata`) REFERENCES `biodata` (`id_biodata`);

--
-- Constraints for table `incomes_user`
--
ALTER TABLE `incomes_user`
  ADD CONSTRAINT `incomes_user_ibfk_1` FOREIGN KEY (`id_biodata`) REFERENCES `biodata` (`id_biodata`);

--
-- Constraints for table `zakat_history`
--
ALTER TABLE `zakat_history`
  ADD CONSTRAINT `zakat_history_ibfk_1` FOREIGN KEY (`id_pj`) REFERENCES `biodata_pj` (`id_pj`),
  ADD CONSTRAINT `zakat_history_ibfk_2` FOREIGN KEY (`id_penerima`) REFERENCES `biodata_penerima` (`id_penerima`),
  ADD CONSTRAINT `zakat_history_ibfk_3` FOREIGN KEY (`id_zakatReq`) REFERENCES `zakat_req` (`id_zakatReq`);

--
-- Constraints for table `zakat_req`
--
ALTER TABLE `zakat_req`
  ADD CONSTRAINT `zakat_req_ibfk_1` FOREIGN KEY (`id_biodataPemberi`) REFERENCES `biodata` (`id_biodata`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
