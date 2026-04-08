-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 05:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengajuan_proposal`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `nama_dos` varchar(255) NOT NULL,
  `gelar` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nidn`, `nama_dos`, `gelar`, `user_id`) VALUES
(10, '112345677', 'Bilqis Tsabitah', 'S.Psi', 4),
(11, '123456789', 'Budi Cahyono', 'S.Kom', 5),
(12, '802548915', 'Yayan Suliato', 'M.Ak', 8),
(13, '987654321', 'Sisil Putri Cahyono', 'S.Kom', 9);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nim`, `nama`, `prodi_id`, `user_id`) VALUES
(1, '230101001', 'Valentina Mcphee', 12, NULL),
(2, '250719476', 'Dodi Putra Mahesa', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_proposal`
--

CREATE TABLE `pengajuan_proposal` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `dosen1` int(11) DEFAULT NULL,
  `dosen2` int(11) DEFAULT NULL,
  `dosen3` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_proposal`
--

INSERT INTO `pengajuan_proposal` (`id`, `nim`, `judul`, `link`, `dosen1`, `dosen2`, `dosen3`, `status`, `tanggal`) VALUES
(2, '250719476', 'Dampak Psikologis Penggunaan Gadget Berlebihan terhadap Pola Interaksi Sosial Remaja di Lingkungan Perkotaan', 'https://github.com/Naila33/pengajuan_proposa', 10, 11, 13, 'Disetujui', '2026-04-04 13:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(11) NOT NULL,
  `nama_prodi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `nama_prodi`) VALUES
(1, 'Informatika'),
(2, 'Sistem informasi'),
(3, 'Teknik komputer'),
(4, 'Management'),
(5, 'Akuntansi'),
(6, 'Hukum'),
(7, 'Kedokteran'),
(8, 'Keperawatan'),
(9, 'Farmasi'),
(10, 'Psikologi'),
(11, 'Ilmu komunikasi'),
(12, 'Pertanian'),
(13, 'Peternakan'),
(14, 'Perikanan'),
(15, 'Kehutanan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role_id`, `is_active`) VALUES
(1, 'Dodi Putra Mahesa', 'dodiput@gmail.com', '$2y$10$bnZqqHX0.EbTAdOhLRcfL.vUytYKjM38N7OE8h.S7UB4M2XZO12JW', 2, 1),
(2, 'tsabitah', 'tsabitah@gmail.com', '$2y$10$fHOVtspYZSFp6YzNlBOz/O0JPfQd7FSYi3cKyPZY7xhEr3Seq.VjC', 1, 1),
(3, 'naila', 'wrisninaila@gmail.com', '$2y$10$GIu.aXVtS1Gt/nN4FXYF3eiEO95XS5g0ZV72uTz.0dugiiLWnj2be', 1, 1),
(4, 'Bilqis Tsabitah', 'salsabilla@gmail.com', '$2y$10$9dLfrWAqCcuYsYmxvaRpsusAeB8uN9xESRedShYM0Lv.JPewk.6Ie', 3, 1),
(5, 'Budi Cahyono', 'budicah@gmail.com', '$2y$10$s.//kR3wGseqb5M3L14rs.EkhBmNe3U2uKUEwfJw4LgFFK8p24NOe', 3, 1),
(8, 'Yayan Suliato', 'yayan@gmail.com', '$2y$10$sijCYR5SSqKkhIAJVGmoLezDf6v6UIh0u00rkMfC4sDMSa/jZnpPC', 3, 1),
(9, 'Sisil Putri Cahyono', 'sisil@gmail.com', '$2y$10$47/vvsjQix0IpljJIUuUNeW5nHkhZ.cVux/F90Wqa5l9NCyueGdtq', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `menu_id`, `role_id`) VALUES
(6, 1, 1),
(7, 1, 3),
(8, 4, 3),
(9, 4, 1),
(10, 2, 1),
(11, 3, 1),
(16, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Dashboard '),
(2, 'Data'),
(3, 'Proposal'),
(4, 'Admin'),
(5, 'Role Access');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'mahasiswa'),
(3, 'dosen');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'Data Mahasiswa', 'data/datasiswa', 'fas fa-fw fa-user-graduate', 1),
(3, 3, 'Data Dosen', 'data/datados', 'fas fa-fw fa-chalkboard-teacher', 1),
(4, 4, 'Data Proposal', 'admin/proposal', 'fas fa-fw fa-file-alt', 1),
(5, 5, 'Role Access', 'admin/role_access', 'fas fa-fw fa-user-cog', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `pengajuan_proposal`
--
ALTER TABLE `pengajuan_proposal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dosen1` (`dosen1`),
  ADD KEY `fk_dosen2` (`dosen2`),
  ADD KEY `fk_dosen3` (`dosen3`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pengajuan_proposal`
--
ALTER TABLE `pengajuan_proposal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
