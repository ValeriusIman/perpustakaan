-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2020 at 06:55 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `nama_anggota` varchar(30) NOT NULL,
  `no_mahasiswa` int(11) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `nomor` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `no_anggota`, `nama_anggota`, `no_mahasiswa`, `telp`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `is_active`, `nomor`, `date_created`) VALUES
(11, 2006300001, 'Budi', 2020201234, '1212-1212-1212', '1999-09-24', 'Laki-Laki', 'Yogyakarta', 1, 1, '2020-06-30'),
(12, 2006300002, 'Andi', 2020209876, '3333-3333-3333', '1999-10-27', 'Laki-Laki', 'Yogyakarta', 1, 2, '2020-06-30'),
(13, 2006300003, 'Santi', 20207654, '6666-6666-6666', '2020-06-09', 'Perempuan', 'Yogyakarta', 1, 3, '2020-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `kode_buku` varchar(10) NOT NULL,
  `judul_buku` varchar(40) NOT NULL,
  `jumlah_buku` int(11) NOT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `penerbit_id` int(11) NOT NULL,
  `penulis_id` int(11) NOT NULL,
  `rak_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul_buku`, `jumlah_buku`, `tahun_terbit`, `penerbit_id`, `penulis_id`, `rak_id`, `jenis_id`, `is_active`) VALUES
(9, 'A001', 'Belajar CodeIgniter', 100, 2019, 6, 5, 5, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_kembali`
--

CREATE TABLE `item_kembali` (
  `id_item_kembali` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `kembali_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_kembali`
--

INSERT INTO `item_kembali` (`id_item_kembali`, `buku_id`, `qty`, `kembali_id`) VALUES
(27, 9, 1, 20),
(28, 9, 1, 21),
(29, 9, 1, 22),
(30, 9, 1, 23),
(31, 9, 1, 24);

--
-- Triggers `item_kembali`
--
DELIMITER $$
CREATE TRIGGER `tambah_jumlah_buku` BEFORE INSERT ON `item_kembali` FOR EACH ROW BEGIN
	UPDATE buku SET jumlah_buku = jumlah_buku + NEW.qty
	WHERE id_buku = NEW.buku_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `item_pinjam`
--

CREATE TABLE `item_pinjam` (
  `id_item` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `pinjam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_pinjam`
--

INSERT INTO `item_pinjam` (`id_item`, `buku_id`, `qty`, `pinjam_id`) VALUES
(43, 9, 1, 36),
(44, 9, 1, 37),
(45, 9, 1, 38),
(46, 9, 1, 40),
(47, 9, 1, 41);

--
-- Triggers `item_pinjam`
--
DELIMITER $$
CREATE TRIGGER `kurang_jumlah_buku` BEFORE INSERT ON `item_pinjam` FOR EACH ROW BEGIN
	UPDATE buku SET jumlah_buku = jumlah_buku - NEW.qty
	WHERE id_buku = NEW.buku_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `jenis_buku` varchar(30) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `jenis_buku`, `is_active`) VALUES
(7, 'Modul', 1);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(30) NOT NULL,
  `level` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `user_name`, `password`, `nama_karyawan`, `no_telp`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `level`, `is_active`, `date_created`) VALUES
(2, 'admin', '$2y$10$hu7x6hYg6OMTcROIUfJ19eXIQAeUVhfBOg0t1by.8lrXZxIwpBw7m', 'Rudi', '1212-1212-1212', 'Laki-Laki', '1998-09-17', 'Cupuwatu 2', 1, 1, '2020-06-23'),
(10, 'iman', '$2y$10$Zz0.dbMVlmJVXCCBLNCb6.aJ8w5LAX5m5EPxyDtbE40u.g.LW3RUm', 'Iman', '2222-2222-2222', 'Laki-Laki', '1998-12-28', 'Yogyakarta', 2, 1, '2020-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `penerbit` varchar(30) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `alamat` varchar(40) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `penerbit`, `telp`, `email`, `alamat`, `is_active`) VALUES
(6, 'Andi', '1212-1212-1212', 'andi@gmail.com', 'Yogyakarta', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` int(11) NOT NULL,
  `nama_kampus` text NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `nama_kampus`, `alamat`, `no_telp`) VALUES
(1, 'UNIVERSITAS CODING CI', 'Jl. Solo Km. 11,1 Yogyakarta', '01234567890');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id_penulis` int(11) NOT NULL,
  `penulis` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `alamat` varchar(40) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id_penulis`, `penulis`, `email`, `alamat`, `is_active`) VALUES
(5, 'Anjas', 'anjas@gmail.com', 'Yogyakarta', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE `rak` (
  `id_rak` int(11) NOT NULL,
  `kode_rak` varchar(10) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rak`
--

INSERT INTO `rak` (`id_rak`, `kode_rak`, `is_active`) VALUES
(5, 'A1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_kembali`
--

CREATE TABLE `transaksi_kembali` (
  `id_kembali` int(11) NOT NULL,
  `no_pengembalian` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `terlambat` int(11) NOT NULL,
  `denda` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `nomor` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_kembali`
--

INSERT INTO `transaksi_kembali` (`id_kembali`, `no_pengembalian`, `tanggal`, `terlambat`, `denda`, `total`, `bayar`, `kembalian`, `nomor`, `anggota_id`, `karyawan_id`) VALUES
(20, 'KMB/2006300001', '2020-06-30', 0, 0, 0, 0, 0, 1, 11, 2),
(21, 'KMB/2006300002', '2020-06-30', 5, 1500, 7500, 10000, 2500, 2, 11, 2),
(22, 'KMB/2006300003', '2020-06-30', 0, 0, 0, 0, 0, 3, 11, 2),
(23, 'KMB/2006300004', '2020-06-30', 0, 0, 0, 0, 0, 4, 13, 2),
(24, 'KMB/2006300005', '2020-06-30', 6, 1500, 9000, 10000, 1000, 5, 11, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pinjam`
--

CREATE TABLE `transaksi_pinjam` (
  `id_peminjaman` int(11) NOT NULL,
  `no_peminjaman` varchar(20) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `nomor` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_pinjam`
--

INSERT INTO `transaksi_pinjam` (`id_peminjaman`, `no_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`, `anggota_id`, `karyawan_id`, `nomor`, `is_active`) VALUES
(36, 'PMJ/2006300001', '2020-06-23', '2020-06-25', 11, 2, 1, 0),
(37, 'PMJ/2006300002', '2020-06-30', '2020-07-02', 11, 2, 2, 0),
(38, 'PMJ/2006300003', '2020-06-16', '2020-06-24', 11, 2, 3, 0),
(40, 'PMJ/2006300004', '2020-06-30', '2020-06-30', 11, 2, 4, 0),
(41, 'PMJ/2006300005', '2020-06-30', '2020-07-02', 13, 2, 5, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `penerbit_id` (`penerbit_id`),
  ADD KEY `penulis_id` (`penulis_id`),
  ADD KEY `rak_id` (`rak_id`),
  ADD KEY `jenis_id` (`jenis_id`);

--
-- Indexes for table `item_kembali`
--
ALTER TABLE `item_kembali`
  ADD PRIMARY KEY (`id_item_kembali`),
  ADD KEY `buku_id` (`buku_id`),
  ADD KEY `kembali_id` (`kembali_id`);

--
-- Indexes for table `item_pinjam`
--
ALTER TABLE `item_pinjam`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `buku_id` (`buku_id`),
  ADD KEY `pinjam_id` (`pinjam_id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id_penulis`);

--
-- Indexes for table `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indexes for table `transaksi_kembali`
--
ALTER TABLE `transaksi_kembali`
  ADD PRIMARY KEY (`id_kembali`),
  ADD KEY `anggota_id` (`anggota_id`),
  ADD KEY `karyawan_id` (`karyawan_id`);

--
-- Indexes for table `transaksi_pinjam`
--
ALTER TABLE `transaksi_pinjam`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `anggota_id` (`anggota_id`),
  ADD KEY `karyawan_id` (`karyawan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item_kembali`
--
ALTER TABLE `item_kembali`
  MODIFY `id_item_kembali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `item_pinjam`
--
ALTER TABLE `item_pinjam`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id_penulis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rak`
--
ALTER TABLE `rak`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi_kembali`
--
ALTER TABLE `transaksi_kembali`
  MODIFY `id_kembali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `transaksi_pinjam`
--
ALTER TABLE `transaksi_pinjam`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit` (`id_penerbit`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`penulis_id`) REFERENCES `penulis` (`id_penulis`),
  ADD CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`rak_id`) REFERENCES `rak` (`id_rak`),
  ADD CONSTRAINT `buku_ibfk_4` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id_jenis`);

--
-- Constraints for table `item_kembali`
--
ALTER TABLE `item_kembali`
  ADD CONSTRAINT `item_kembali_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `item_kembali_ibfk_2` FOREIGN KEY (`kembali_id`) REFERENCES `transaksi_kembali` (`id_kembali`);

--
-- Constraints for table `item_pinjam`
--
ALTER TABLE `item_pinjam`
  ADD CONSTRAINT `item_pinjam_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `item_pinjam_ibfk_2` FOREIGN KEY (`pinjam_id`) REFERENCES `transaksi_pinjam` (`id_peminjaman`);

--
-- Constraints for table `transaksi_kembali`
--
ALTER TABLE `transaksi_kembali`
  ADD CONSTRAINT `transaksi_kembali_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id_anggota`),
  ADD CONSTRAINT `transaksi_kembali_ibfk_2` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id_karyawan`);

--
-- Constraints for table `transaksi_pinjam`
--
ALTER TABLE `transaksi_pinjam`
  ADD CONSTRAINT `transaksi_pinjam_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id_anggota`),
  ADD CONSTRAINT `transaksi_pinjam_ibfk_2` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
