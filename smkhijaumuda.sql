-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2025 at 01:51 PM
-- Server version: 10.11.11-MariaDB-cll-lve
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb7395_smk_hijau_muda`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `role_id` int(1) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `fullname`, `role_id`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'dpazliem@gmail.com', '$2y$10$yEF8DMHph4hgn//D2p2v2.Rfoh1SowcBzxvjaDmj6x988cqUflIZC', 'Test', 2, NULL, NULL),
(3, 'nuaink131@gmail.com', '$2y$10$4/H4DsUpmhZmGhzQlj7j..rkXQLesxp4PSmbnVNs2Pr6FjefVpZMC', 'Dika', 2, NULL, NULL),
(4, 'suhenda86@guru.smk.belajar.id', '$2y$10$DRPf2QNbR7m2fIDaIcpk2uLh5Idhn1c4I.nC8diIg2mVwb6oRquaa', 'Suhenda ', 2, NULL, NULL),
(5, 'andikasyaputra818@gmail.com', '$2y$10$NOUlylAaUzledaD3bGZ9QurDGzPujinaWWr4UuiwRAGoMmcau8J2C', 'M. Andika Anjas Syaputra', 2, NULL, NULL),
(6, 'anjasss@gmail.com', '$2y$10$s1q1TAdgMHg5oOoXTKu/EuJKgQDHYBh9g.Y1CqL5wZB9KAj8C.jfm', 'Admin PPDB ', 2, NULL, NULL),
(7, 'jaenudinalit123@gmail.com', '$2y$10$2d53Z40LIb86yOf4JaCseeaMfz7RT/3UYIbBF90V91Q9oWjYtYUBi', 'Alit Jaenudin, S.Pd', 2, NULL, NULL),
(8, 'andikaa@gmail.com', '$2y$10$BfrPka3QWxKex08NPTrhIuB38MqqUGPBt3shSaR6ek5tofmq7EoNG', 'admin', 2, NULL, NULL),
(9, 'fajarhanjairifal91@gmail.com', '$2y$10$Bw4szitxcsrzd9WMVPHCFerqsHl.ZEAY9q7XEs9RuLCBcQ6p2qQ.O', 'Pajar Hanjairifal', 2, NULL, NULL),
(10, 'hendrakusasih129@gmail.com', '$2y$10$XhxV9JZO9UupR./Do.aq6eYVFKuROjs5cz9jQm51E9gK8UglupGHC', 'Hendra Kusasih', 2, NULL, NULL),
(11, 'raisapuspitaa12@gmail.com', '$2y$10$GtvH3zAr1vqbfEZha3YvSO./mNfcnqcvo.TzP5BLcnJkPsKRvp6Eu', 'Raisa Puspita', 2, NULL, NULL),
(12, 'tiwii12@gmail.com', '$2y$10$tiJLJjiJFKgFLg2b9EEoNOSCdRBy9sqyA94a0XWoKHwEcZNldvN1q', 'Tiwi Nurul Khakiki', 2, NULL, NULL),
(13, 'udinali87@gmail.com', '$2y$10$2Z6wSECXPFx.QAl4YXOD0e54yhmYop71b86zTWmETsSUMFvXE3AQS', 'Alifudin', 2, NULL, NULL),
(14, 'wildaazhr09@gmail.com', '$2y$10$AkOls5mqIeZTbx3kPk5Q9emKefklT0DN3LWVGwpUHJxF9tNyjQCL6', 'Wilda Zahara', 2, NULL, NULL),
(15, 'daenurianwar11@gmail.com', '$2y$10$iqDQ0WJNH4qG1eXoFFYqO.aRe52dqX2tA6peBTMpf47KQwNv/NfQ2', 'A. Daenuri', 2, NULL, NULL),
(16, 'ahmadtohirin@admin.belajar.id', '$2y$10$A0Xn1U04c9y07YivKkLmHOSPnR7gs/22ehRLTbgOu8xA29bqR0Xtm', 'Ahmad Tohirin', 2, NULL, NULL),
(17, 'amanulloh@guru.smk.belajar.id', '$2y$10$UaFIyZHPR6sv8pWirWaxweabeOkq4v6.WtBBUZFR.pHej0xRll4B6', 'Amanulloh', 2, NULL, NULL),
(18, 'febyzahira01@gmail.com', '$2y$10$1kUpdo0o1NYQhUdRnMUG8ut8Qgsg../6hB..h2RPvs8tkfIt47la.', 'Feby', 2, NULL, NULL),
(19, 'irhamfahmi2345@gmail.com', '$2y$10$X4bpHCu0K/jbY4tcL3F2cO0UOIzPDcXEKyf6ErGQR.3B8tQPwlirS', 'Irham Fahmiyudin', 2, NULL, NULL),
(20, 'hubin.smkhijaumuda@guru.smk.belajar.co.id', '$2y$10$azk2RZXPyFDV70hklNZdJ.eD536ZNr1KTxy8C6MmHckPQEY/VdJdW', 'Heri Subekti, S.T.', 2, NULL, NULL),
(21, 'azisabdull2217@gmail.com', '$2y$10$SmaK5bfv6xQgjw7MTvZRcOgeYY4rO6lpcACXKjo3Lmz5SeFGn2fl2', 'Abdul Azis', 2, NULL, NULL),
(22, 'ahmadtohirin1@admin.smk.belajar.id', '$2y$10$ss.kgjc10vk77sluhoNra.CJNctKx2EUCAyV5BRC03NNzDcuoUWoy', 'Ahmad Tohirin S.Pd., M.Pd', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gelombang_ppdb`
--

CREATE TABLE `gelombang_ppdb` (
  `gelombang` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gelombang_ppdb`
--

INSERT INTO `gelombang_ppdb` (`gelombang`, `tanggal`, `kuota`) VALUES
('1', '2025-01-01', 100),
('2', '2025-03-01', 100),
('3', '2025-05-01', 100);

-- --------------------------------------------------------

--
-- Table structure for table `informasi_ppdb`
--

CREATE TABLE `informasi_ppdb` (
  `nomor` varchar(100) DEFAULT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `informasi_ppdb`
--

INSERT INTO `informasi_ppdb` (`nomor`, `jenis`, `nominal`) VALUES
(NULL, 'Pendaftaran ', 100000),
(NULL, 'SPP Juli 2025', 250000),
(NULL, 'Seragam', 750000),
(NULL, 'Ekstrakurikuler', 300000),
(NULL, 'Sarana', 2000000),
(NULL, 'MPLS dan MPLP', 350000);

-- --------------------------------------------------------

--
-- Table structure for table `kuota_ppdb`
--

CREATE TABLE `kuota_ppdb` (
  `kuota` int(11) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kuota_ppdb`
--

INSERT INTO `kuota_ppdb` (`kuota`, `tahun_ajaran`, `created_at`) VALUES
(300, '2025/2026', '2025-05-05 08:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_siswa`
--

CREATE TABLE `pembayaran_siswa` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('Transfer Bank','E-Wallet','Tunai') NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_pembayaran` enum('Belum Bayar','Lunas') NOT NULL DEFAULT 'Belum Bayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran_siswa`
--

INSERT INTO `pembayaran_siswa` (`user_id`, `nama`, `jumlah_bayar`, `metode_pembayaran`, `tanggal_bayar`, `bukti_pembayaran`, `created_at`, `status_pembayaran`) VALUES
(1, 'Feby Arfa Z', 3700000.00, 'Transfer Bank', '2025-04-11', 'Gambar WhatsApp 2024-12-30 pukul 16.30.34_a53f7a97.jpg', '2025-04-11 03:05:00', 'Lunas'),
(2, 'Irham Fahmiyudin', 1000000.00, 'Transfer Bank', '2025-04-17', '20200713_smp.jpg', '2025-04-17 05:40:00', 'Lunas'),
(3, 'Heri Subekti ', 1100000.00, 'Transfer Bank', '2025-03-20', 'dokumentasi.jpg', '2025-03-20 02:20:00', 'Lunas'),
(4, 'Aziz Abdul', 1100000.00, 'Transfer Bank', '2025-03-17', 'futsal.jpeg', '2025-03-17 07:50:00', 'Lunas'),
(5, 'Fajar Hanjairipal', 1100000.00, 'Transfer Bank', '2025-04-03', 'DELMAN.jpg', '2025-03-31 17:00:00', 'Lunas'),
(6, 'Alit Jaenudin ', 1100000.00, 'Transfer Bank', '2025-04-03', 'dokumentasi.jpg', '2025-03-31 17:00:00', 'Lunas'),
(7, 'Ahmad tohirin', 1100000.00, 'Transfer Bank', '2025-04-04', 'pramuka-silhouette-wing-beak-png-clipart-royalty-svg-png-22.png', '2025-04-01 17:00:00', 'Lunas'),
(10, 'Wilda Azzahra', 1100000.00, 'Transfer Bank', '2025-04-05', 'Screenshot_22-4-2025_75358_.jpeg', '2025-04-09 17:00:00', 'Lunas'),
(17, 'Iva Nur Handayani', 1100000.00, 'Transfer Bank', '2025-04-09', 'DELMAN.jpg', '2025-04-13 17:00:00', 'Lunas'),
(15, 'Tiwi Nurul Khakiki', 1100000.00, 'Transfer Bank', '2025-04-08', 'Gambar_WhatsApp_2024-07-27_pukul_19.27.22_ad0daed6-removebg-preview.png', '2025-04-12 17:00:00', 'Lunas'),
(14, 'Raisa Puspita ', 1100000.00, 'Transfer Bank', '2025-04-07', 'voli.jpg', '2025-04-12 17:00:00', 'Lunas'),
(8, 'Hendra Kusasih', 1100000.00, 'Transfer Bank', '2025-04-04', 'IMG_20250330_160730_265.jpg', '2025-04-02 17:00:00', 'Lunas'),
(13, 'Hendra Kusasih', 1100000.00, 'Transfer Bank', '2025-04-07', '20200713_smp.jpg', '2025-04-12 17:00:00', 'Lunas'),
(16, 'Dina Januar', 1100000.00, 'Transfer Bank', '2025-04-08', '_MG_0116.JPG', '2025-04-12 17:00:00', 'Lunas'),
(12, 'Alipudin', 1100000.00, 'Transfer Bank', '2025-04-06', 'backiee-238993-landscape.jpg', '2025-04-12 17:00:00', 'Lunas'),
(9, 'A. Daenuri', 1100000.00, 'Transfer Bank', '2025-04-05', 'IMG_20250330_160730_265.jpg', '2025-04-09 17:00:00', 'Lunas'),
(11, 'Amanulloh', 110000.00, 'Transfer Bank', '2025-04-06', 'img10.jpeg', '2025-04-13 17:00:00', 'Lunas'),
(26, 'Adelia Zeaneta', 1100000.00, 'Transfer Bank', '2025-04-05', 'c7836b12-7f75-4836-aa2e-a6d5ae4804ee-removebg-preview.png', '2025-04-24 15:35:46', 'Lunas'),
(27, 'Boy', 110000.00, 'Transfer Bank', '2025-04-06', 'mutasi rekening pembayaran hostinger .jpg', '2025-04-24 15:42:45', 'Lunas'),
(28, 'Abdillah', 1100000.00, 'Transfer Bank', '2025-04-06', 'Gambar WhatsApp 2025-04-24 pukul 20.21.13_fda4af4e.jpg', '2025-04-24 15:47:47', 'Lunas'),
(29, 'Raditya Kevin', 1100000.00, 'Transfer Bank', '2025-04-07', 'Gambar WhatsApp 2025-04-24 pukul 20.21.13_fda4af4e.jpg', '2025-04-24 15:51:07', 'Lunas'),
(30, 'Jaenudin', 1100000.00, 'Transfer Bank', '2025-04-07', 'c7836b12-7f75-4836-aa2e-a6d5ae4804ee.png', '2025-04-24 15:54:38', 'Lunas'),
(31, 'Arsy syaputra', 1100000.00, 'Transfer Bank', '2025-04-08', 'c7836b12-7f75-4836-aa2e-a6d5ae4804ee-removebg-preview.png', '2025-04-24 15:57:58', 'Lunas'),
(19, 'Kelly Aprilla', 1100000.00, 'Transfer Bank', '2025-04-10', 'futsal.jpeg', '2025-04-24 15:59:44', 'Lunas'),
(20, 'Hodijah Indah', 1100000.00, 'Transfer Bank', '2025-04-10', 'mutasi rekening pembayaran hostinger .jpg', '2025-04-24 16:00:46', 'Lunas'),
(23, 'Edi Joe', 1100000.00, 'Transfer Bank', '2025-04-04', 'Blue Modern Futuristic Desktop Wallpaper.png', '2025-04-24 16:01:48', 'Lunas'),
(25, 'Rahmah Adi Putra', 1100000.00, 'Transfer Bank', '2025-04-05', 'ChatGPT_Image_Apr_24__2025__06_32_36_PM-removebg-preview.png', '2025-04-24 16:02:30', 'Lunas'),
(24, 'Muniroh', 1100000.00, 'Transfer Bank', '2025-04-04', 'Gambar WhatsApp 2025-04-24 pukul 20.21.13_fda4af4e.jpg', '2025-04-24 16:03:39', 'Lunas'),
(22, 'Ilham Yudiatmoko', 1100000.00, 'Transfer Bank', '2025-04-03', 'mutasi rekening pembayaran hostinger .jpg', '2025-04-24 16:05:28', 'Lunas'),
(21, 'Yelis Sintanaia', 1100000.00, 'Transfer Bank', '2025-04-03', 'c7836b12-7f75-4836-aa2e-a6d5ae4804ee-removebg-preview.png', '2025-04-24 16:06:06', 'Lunas'),
(32, 'Muhammad Bahar', 1100000.00, 'Transfer Bank', '2025-04-08', 'Gambar WhatsApp 2025-04-24 pukul 20.21.13_fda4af4e.jpg', '2025-04-24 16:24:09', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `user_id` int(11) NOT NULL,
  `gelombang` varchar(255) NOT NULL,
  `rekomendasi` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `anak_ke` int(11) DEFAULT NULL,
  `jumlah_saudara` int(11) DEFAULT NULL,
  `status_keluarga` varchar(50) DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `npsn` varchar(20) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `keluhan` text DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `alamat_orang_tua` text DEFAULT NULL,
  `gaji_orang_tua` decimal(15,2) DEFAULT NULL,
  `status_pendaftaran` varchar(50) DEFAULT 'Diproses',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `nik` varchar(50) DEFAULT NULL,
  `status_pembayaran` enum('Telah Bayar','proses Pengembalian') NOT NULL DEFAULT 'Telah Bayar',
  `foto` varchar(255) DEFAULT NULL,
  `kk` varchar(255) DEFAULT NULL,
  `akta` varchar(255) DEFAULT NULL,
  `skl` varchar(255) DEFAULT NULL,
  `Alamat_Sekolah` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`user_id`, `gelombang`, `rekomendasi`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `agama`, `anak_ke`, `jumlah_saudara`, `status_keluarga`, `asal_sekolah`, `npsn`, `jurusan`, `nisn`, `keluhan`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `alamat_orang_tua`, `gaji_orang_tua`, `status_pendaftaran`, `timestamp`, `nik`, `status_pembayaran`, `foto`, `kk`, `akta`, `skl`, `Alamat_Sekolah`, `email`, `telp`, `admin_id`) VALUES
(1, '1', 'Aliet Jaenudin ', 'Feby Arfa Z', 'Jakarta', '2000-02-03', 'perempuan', 'KP. durian jl soeharto RT001 RW002 ', 'Islam', 1, 3, 'Anak Kandung', 'SMA Negeri 2 Jakarta', '20246570', 'Teknik Komputer Jaringan', '0021784905', 'Tidak Ada', 'Yusuf ', 'Karyawan', 'Junia', 'Ibu Rumah Tangga', 'Jl. kebangsaan timur no.45 Jakarta Barat', 6300000.00, 'Diproses', '2025-04-11 03:00:00', '3216748576832', '', 'uploads/6809caab8d366.jpeg', 'uploads/6809cb61b1370.jpg', 'uploads/6809cb61e577f.jpg', 'uploads/6809cb6208bc7.jpg', 'Jakarta Barat', 'febyzahira01@gmail.com', '12345678910', NULL),
(2, '2', 'Tidak ada rekomendasi', 'Irham Fahmiyudin', 'Bekasi', '2025-04-04', 'laki-laki', 'Jl. Sukatani Rt01 Rw04 rawa bangkong', 'Islam', 1, 2, 'Anak Kandung', 'SMA Negeri 2 Cabang bungin', '34073748', 'Teknik Kendaraan Ringan', '0021245895', 'Tidak Ada', 'Ahmad Mustofa', 'Karyawan', 'Ruminah', 'Ibu Rumah Tangga', 'Jl. sukatani', 3000000.00, 'Diproses', '2025-04-17 05:30:00', '321890349012234', '', '6809ce8530570.jpg', '6809ce85306c3.jpg', '6809ce853077e.jpg', '6809ce8530838.jpg', 'Jl. pebayuran ', 'irhamfahmi2345@gmail.com', '091874589458', NULL),
(3, '1', 'Hendra Kusasih ', 'Heri Subekti ', 'Purwokerto', '1977-06-09', 'laki-laki', 'Jl. Cibarusah blok 3 perum persada cifest', 'Islam', 3, 5, 'Anak Kandung', 'SMP Negeri 12 Purwokerto', '20246570', 'Teknik Kendaraan Ringan', '0012345869', 'Tidak Ada', 'Hasbuan supripto', 'Petani', 'Neni Siti Hasanah', 'Ibu Rumah Tangga', 'Jl, Purwokerto', 1000000.00, 'Diproses', '2025-03-20 02:15:00', '32140907943223', '', '6809d66483a61.jpg', '6809d66483c28.jpg', '6809d66483d40.jpg', '6809d66483e2b.jpg', 'Jl. pakuan kayu ', 'hubin.smkhijaumuda@gmail.com', '088747589392', NULL),
(4, '1', 'Tidak ada rekomendasi', 'Aziz Abdul', 'Bekasi', '2020-05-05', 'laki-laki', 'perum Bumi harapan indah blok A. No 12 ', 'Islam', 2, 2, 'Anak Kandung', 'SMP Negeri 6 Cikarang Utara', '20246570', 'Manajemen Perkantoran', '0021345432', 'Tidak Ada', 'Abu Hanafi', 'Karyawan', 'Rosa ', 'Ibu Rumah Tangga', 'perum Bumi harapan indah blok A. No 12 ', 6000000.00, 'Diproses', '2025-03-17 07:45:00', '3214567898010', '', '6809d8e67998d.jpeg', '6809d8e679af3.jpeg', '6809d8e679beb.jpeg', '6809d8e679ce5.jpeg', 'Perum Puri Mutiara Indah Jl. Kakap no 6 ', 'azisabdull2217@gmail.com', '081234567890', NULL),
(5, '3', 'Alipudin', 'Fajar Hanjairipal', 'Bekasi', '1989-02-02', 'laki-laki', 'Jl. Sukamantri Blok F no.12 perum sukamantri', 'Islam', 1, 2, 'Anak Kandung', 'SMA Negeri 2 Cabang bungin', '20246570', 'Teknik Komputer Jaringan', '0021234505', 'Tidak Ada', 'Muhammad fardani', 'Karyawan', 'Ruminah sari', 'Ibu Rumah Tangga', 'Jl. Sukamantri Blok F no.12 perum sukamantri', 6000000.00, 'Diproses', '2025-04-03 01:15:32', '3127950005569134', '', '6809dd45a9db0.png', '6809dd45a9e86.png', '6809dd45a9eec.png', 'uploads/6809ddc0a9243.png', 'Jl. Cabang bungin', 'fajarhanjairipal91@gmail.com', '081234434564', NULL),
(6, '3', 'Tidak ada rekomendasi', 'Alit Jaenudin, S.Pd', 'Bekasi', '1978-01-01', 'laki-laki', 'Jl. Citarik raya', 'Islam', 1, 3, 'Anak Kandung', 'SMP Negeri 6 Cikarang Utara', '20246570', 'Teknik Kendaraan Ringan', '0910384022', 'Tidak Ada', 'Hasan Basri', 'Karyawan', 'Hanifah fauziah', 'Ibu Rumah Tangga', 'Kp. Walahir RT002/RW002Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 6000000.00, 'Diproses', '2025-04-03 07:42:17', '3123090108010012', '', '680ef0f246cb7_67f7c3e7cc6dd.jpg', '680ef0f246d94_67f7c3e7cc892.jpg', '680ef0f246ecb_67f7c3e7cc9d5.jpg', '680ef0f247011_67f7c3e7ccb3c.jpg', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'jaenudinalit123@gmail.com', '089765654632', NULL),
(7, '1', 'Tiwi Nurul Khakiki', 'Ahmad tohirin', 'Purwokerto', '1970-06-12', 'laki-laki', 'perum bumi citra lestari blok m no 19 ', 'Islam', 3, 7, 'Anak Kandung', 'SMP negeri 01 Purwokerto', '34073748', 'Manajemen Perkantoran', '1234', 'Tidak Ada', 'Abun ', 'Pedagang', 'Kasih', 'Ibu Rumah Tangga', 'perum bumi citra lestari blok m no 19 ', 3000000.00, 'Diproses', '2025-04-04 02:18:53', '3126090101102034', '', '6809e41d59ed7.jpeg', '6809e41d5a0a1.pdf', '6809e41d9d42a.pdf', '6809e41dca5ea.jpg', 'Jl. Purwokerto ', 'ahmadtohirin1@admin.smk.belajar.id', '085878676789', NULL),
(8, '2', 'Aliet Jaenudin ', 'Hendra Kusasih', 'Karawang', '2025-04-11', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 3, 3, 'Anak Kandung', 'SMP Negeri 2 Cabang bungin', '34073748', 'Teknik Komputer Jaringan', '1234093405', 'Tidak Ada', 'Fikri septian', 'Karyawan', 'febiani', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-04 12:03:29', '321674857683212', '', '6809e62063693.png', '6809e620637da.pdf', '6809e6206397a.pdf', '6809e62063b0a.pdf', 'Jl. Cabang bungin', 'hendrakusasih1290@gmail.com', '0213456789485', NULL),
(9, '2', 'Hendra Kusasih ', 'A Daenuri', 'Bekasi', '1998-06-10', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 2, 'Anak Kandung', 'SMP Negeri 6 Cikarang Kulon', '34073748', 'Teknik Kendaraan Ringan', '1234', 'Tidak Ada', 'Casdi', 'Pedagang', 'Mumun febri', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 3000000.00, 'Diproses', '2025-04-05 03:26:11', '321345690163849', '', NULL, '6809e780375be.pdf', '6809e7803a47e.pdf', '6809e7803df10.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'daenurianwar11@gmail.com', '081234567894', NULL),
(10, '2', 'Alipudin', 'Wilda Azzahra', 'Bekasi', '1989-02-02', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 4, 'Anak Kandung', 'SMP Negeri 6 Cikarang Utara', '20246570', 'Teknik Komputer Jaringan', '0008293401', 'Tidak Ada', 'Hadi rohman', 'Pedagang', 'Mulyani', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 3000000.00, 'Diproses', '2025-04-05 15:55:48', '1234567888802301', '', '6809e86b11658.png', '6809e86b1178a.pdf', '6809e86b1181f.pdf', '6809e86b1189f.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'wildaazhr09@gmail.com', '0812343423694', NULL),
(11, '1', 'Tidak ada rekomendasi', 'Amanulloh', 'Bekasi', '1985-04-24', 'laki-laki', 'Jl. Walahir ', 'Islam', 2, 2, 'Anak Kandung', 'SMPN 6 Cikarang barat', '8901278', 'Teknik Komputer Jaringan', '0021193047', 'Tidak ada', 'musodik', 'Karyawan', 'Karmilah', 'Ibu rumah tangga', 'Jl. Walahir', 6000000.00, 'Diproses', '2025-04-06 04:17:05', '321344578590201', '', '6809ea0b01dc9.jpg', NULL, NULL, NULL, 'Cikarang barat', 'amanullooh@guru.smk.belajar.id', '0812345678923', NULL),
(12, '1', 'Aliet Jaenudin ', 'Alipudin', 'Bekasi', '1982-11-23', 'laki-laki', 'Jl. Cibarusah blok 3 perum persada cifest', 'Islam', 1, 4, 'Anak Kandung', 'SMP Negeri 12 Purwokerto', '20246570', 'Teknik Kendaraan Ringan', '1200989667', 'Tidak Ada', 'Hamdan', 'Karyawan', 'Siti Uswatun', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-06 11:40:21', '12345678790', '', '6809eb154537e.jpg', '6809eb15454fd.jpg', '6809eb15455e4.jpg', '6809eb1545710.jpg', 'Kp. Walahir RT001/RW004 ', 'udinali97@gmail.com', '08978475680', NULL),
(13, '1', 'Aliet Jaenudin ', 'Hendra Pratama', 'Bekasi', '1970-10-23', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 3, 'Anak Kandung', 'SMP negeri 01 Purwokerto', '34073748', 'Teknik Kendaraan Ringan', '2110923585', 'Tidak Ada', 'rusdiansyah', 'Karyawan', 'hani', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-07 00:23:44', '0213456901', '', '6809ec3898d9e.png', '6809ec3898ee7.pdf', '6809ec3899089.pdf', '6809ec3899218.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Hendrapratama15@gmail.com', '023134585567', NULL),
(14, '1', 'Aliet Jaenudin ', 'Raisa Puspita ', 'Bekasi', '2003-10-20', 'laki-laki', 'Guru', 'Islam', 1, 2, 'Anak Kandung', 'SMP Negeri 6 Cikarang Kulon', '34073748', 'Teknik Komputer Jaringan', '0021784910', 'Tidak Ada', 'Yusuf hidayat', 'Pedagang', 'Siti Maesaroh', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 3000000.00, 'Diproses', '2025-04-07 16:49:50', '12345666780', '', '6809ed5c84eb9.jpg', '6809ed5c84fee.png', '6809ed5c85069.png', '6809ed5c850d9.png', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Raisapuspitaa12@gmail.com', '082134567891', NULL),
(15, '1', 'Alipudin', 'Tiwi Nurul Khakiki', 'Bekasi', '1982-02-10', 'perempuan', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 2, 'Anak Kandung', 'SMP Negeri 6 Cikarang Kulon', '20246570', 'Teknik Kendaraan Ringan', '0020784905', 'Tidak Ada', 'Khakiki', 'Karyawan', 'Rusminah', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 6000000.00, 'Diproses', '2025-04-07 23:55:07', '32145674892123', '', '6809ee6282eef.png', '6809ee628308a.pdf', '6809ee628313b.pdf', '6809ee62831fe.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Tiwii12@gmail.com', '089765432123', NULL),
(16, '3', 'Tidak ada rekomendasi', 'Dina Januar', 'Bekasi', '1982-11-20', 'perempuan', 'perum bumi citra lestari blok F no 30', 'Islam', 1, 8, 'Anak Kandung', 'SMP Negeri 6 Cikarang Utara', '34073748', 'Manajemen Perkantoran', '0012345299', 'Tidak Ada', 'Hasbuan supripto', 'Petani', 'Suryanih', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 1000000.00, 'Diproses', '2025-04-08 10:01:38', '3217495950320133', '', NULL, NULL, NULL, NULL, 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'dinajanuar106@gmail.co.com', '087623475883', NULL),
(17, '1', 'Aliet Jaenudin ', 'Iva Nur Handayani', 'Bekasi', '1982-10-20', 'perempuan', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 1, 0, 'Anak Kandung', 'SMP Negeri 6 Cikarang Utara', '20246570', 'Teknik Kendaraan Ringan', '1200987656', 'Tidak Ada', 'Muhammad Hadi', 'Pedagang', 'iin solihin', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 1000000.00, 'Diproses', '2025-04-09 05:10:25', '1234567888892030', '', NULL, '6809f18b6173e.pdf', '6809f18b61886.pdf', '6809f18b6193f.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'ivanurhandayani1269@admin.smp.belajar.id', '089789647590', NULL),
(19, '1', 'Tidak Ada Rekomendasi', 'Kelly Aprilla', 'Bekasi', '1980-12-04', 'perempuan', 'Perum Puri Mutiara Indah Jl. Kakap no 12', 'Islam', 1, 4, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '002878932', 'Teknik Kendaraan Ringan', '0021283679', '', 'Abdul Mukhlis', 'Karyawan', 'Halimah', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 6000000.00, 'Diproses', '2025-04-09 22:33:18', '3210987384890210', '', 'uploads/680a3c0a49c37_Gambar_WhatsApp_2025-04-24_pukul_20.21.13_fda4af4e.jpg', 'uploads/680a3c0a49db3_MATERI_PASKIBRA_.pdf', 'uploads/680a3c0a49fcb_MATERI_PASKIBRA.pdf', 'uploads/680a3c0a4a233_MATERI_PASKIBRA_.pdf', 'Kp. Walahir RT001/RW004', 'keillakeyli@gmail.com', '0812394948959', NULL),
(20, '3', 'Tidak Ada Rekomendasi', 'Hodijah Indah', 'Bekasi', '1990-10-09', 'perempuan', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 1, 2, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Teknik Kendaraan Ringan', '1273939320', 'Tidak Ada', 'Heru', 'Karyawan', 'Fitri Ayu', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-10 09:12:42', '3212034850690309', '', '680a48d0d8543_Gambar_WhatsApp_2025-04-24_pukul_20.21.13_fda4af4e.jpg', '', '', '', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'hodijahindahh@gmail.com', '082345678190', NULL),
(21, '1', 'Tidak Ada Rekomendasi', 'Yelis Sintanaia', 'Bekasi', '1990-01-20', 'perempuan', 'Jl. Cagak No 12 Subang', 'Islam', 1, 3, 'Anak Kandung', 'SMP Negeri 2 Subang', '21927838', 'Teknik Kendaraan Ringan', '1273939320', 'Tidak Ada', 'Hadi', 'Karyawan', 'Jamilah', 'Ibu Rumah Tangga', 'Jl. kebangsaan timur no.45 Jakarta Barat', 4000000.00, 'Diproses', '2025-04-03 00:48:14', '3215627389920002', '', '680a50ba6f71d_Gambar_WhatsApp_2024-11-18_pukul_11.09.56_27886f51.jpg', '680a50ba6f915_SUMATIF_TENGAH_SEMESTER_GENAP_TAHUN_AJARAN_2024_2025_-_SMK_HIJAU_MUDA_-_PRODUKTIF_TKR_KELAS_XI_-_Google_Formulir.pdf', '680a50baa50e8_SUMATIF_TENGAH_SEMESTER_GENAP_TAHUN_AJARAN_2024_2025_-_SMK_HIJAU_MUDA_-_PRODUKTIF_TKR_KELAS_XI_-_Google_Formulir.pdf', '680a50bae581d_SUMATIF_TENGAH_SEMESTER_GENAP_TAHUN_AJARAN_2024_2025_-_SMK_HIJAU_MUDA_-_PRODUKTIF_TKR_KELAS_XI_-_Google_Formulir.pdf', 'Jl. Cabang bungin', 'yellisintanaiaa@gmail.com', '081254364758', NULL),
(22, '1', 'Tidak Ada Rekomendasi', 'Ilham Yudiatmoko', 'Bekasi', '2003-12-08', 'laki-laki', 'Jl. Cibarusah blok 3 perum persada cifest', 'Islam', 1, 5, 'Anak Kandung', 'SMPN 5 Cikarang Timur', '12334678', 'Teknik Kendaraan Ringan', '2133647882', 'Tidak Ada', 'Yudi syaputra', 'Karyawan', 'Ruminah', 'Ibu Rumah Tangga', 'Jl. Rengasbandung No 23', 5000000.00, 'Diproses', '2025-04-03 13:29:36', '3245127893002333', '', '680a52a97c277_DELMAN.jpg', '680a52a97c4e6_Gambar_WhatsApp_2025-04-24_pukul_20.21.13_fda4af4e.jpg', '680a52a97c5de_Gambar_WhatsApp_2025-04-24_pukul_20.21.13_fda4af4e.jpg', '680a52a97c6d6_Gambar_WhatsApp_2025-04-24_pukul_20.21.13_fda4af4e.jpg', 'Cikarang Timur Jl. Rengasbandung ', 'yudiatmokoilham@gmail.com', '098912346790', NULL),
(23, '1', 'Tidak Ada Rekomendasi', 'Edi Joe', 'Bekasi', '1978-03-01', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 1, 3, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Teknik Komputer Jaringan', '1273939320', 'Tidak Ada', 'Abdul Mufti', 'Karyawan', 'Saronah maymunah', 'Ibu Rumah Tangga', 'Jl. Sukamantri Blok F no.12 perum sukamantri', 5000000.00, 'Diproses', '2025-04-04 06:15:01', '1234567888290304', '', '680a554859f84_Gambar_WhatsApp_2024-11-18_pukul_11.09.54_5f8e9b0d.jpg', '680a5482068c9_SUMATIF_TENGAH_SEMESTER_GENAP_TAHUN_AJARAN_2024_2025_-_SMK_HIJAU_MUDA_-_PRODUKTIF_TKR_KELAS_XI_-_Google_Formulir.pdf', '680a548245565_SUMATIF_TENGAH_SEMESTER_GENAP_TAHUN_AJARAN_2024_2025_-_SMK_HIJAU_MUDA_-_PRODUKTIF_TKR_KELAS_XI_-_Google_Formulir.pdf', '680a548285cf8_SUMATIF_TENGAH_SEMESTER_GENAP_TAHUN_AJARAN_2024_2025_-_SMK_HIJAU_MUDA_-_PRODUKTIF_TKR_KELAS_XI_-_Google_Formulir.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'edijoe29120@gmail.com', '0858767536467', NULL),
(24, '1', 'Tidak Ada Rekomendasi', 'Muniroh', 'Bekasi', '1987-11-20', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 2, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Teknik Kendaraan Ringan', '1273939320', 'Tidak Ada', 'Hasibuan', 'Karyawan', 'Kusminah ', 'Ibu Rumah Tangga', 'Jl. kebangsaan timur no.45 Jakarta Barat', 4000000.00, 'Diproses', '2025-04-04 14:39:57', '2234123447489949', '', '680a571731dd6_WhatsApp_Image_2024-11-10_at_21.19.31.jpeg', '680a571737013_SOAL_INFORMATIKA.pdf', '680a57173a0a8_SOAL_INFORMATIKA.pdf', '680a57173db37_SOAL_INFORMATIKA.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'muniroh1770@gmail.com', '0987836475884', NULL),
(25, '1', 'Tidak Ada Rekomendasi', 'Rahmah Adi Putra', 'Karawang', '2003-11-11', 'perempuan', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 3, 4, 'Anak Kandung', 'SMP Negeri 2 Subang', '21927838', 'Teknik Kendaraan Ringan', '0021283610', 'Tidak Ada', 'Pratama', 'Karyawan', 'Ayu Lestari', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 5000000.00, 'Diproses', '2025-04-05 02:07:22', '2134657893904111', '', '680a58a55fc39_c7836b12-7f75-4836-aa2e-a6d5ae4804ee-removebg-preview.png', '680a58a55fd92_Bukti_Pendaftaran.pdf', '680a58a55fe70_Bukti_Pendaftaran_(1).pdf', '680a58a55ff3f_Bukti_Pendaftaran_(1).pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'rahmahaadipratama@gmail.com', '08123546789304', NULL),
(26, '2', 'Tidak Ada Rekomendasi', 'Adelia Zeaneta', 'Bekasi', '2000-11-12', 'perempuan', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 3, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Manajemen Perkantoran', '1273939311', 'Tidak Ada', 'Juandi', 'Karyawan', 'hukamah', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-05 11:22:09', '1234884583892921', '', '680a5a8018ffa_ChatGPT_Image_Apr_24__2025__06_32_36_PM-removebg-preview.png', '680a5a3a8833a_Screenshot_22-4-2025_75358_.jpeg', '680a5a3a92700_Screenshot_22-4-2025_75358_.jpeg', '680a5a3a9d6b5_Screenshot_22-4-2025_75358_.jpeg', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'zeanetaadelia@gmail.com', '0123456783099', NULL),
(27, '1', 'Tidak Ada Rekomendasi', 'Boy', 'Karawang', '2003-11-23', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 3, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Manajemen Perkantoran', '1273939309', 'Tidak Ada', 'Jody Pranata', 'Karyawan', 'cucu hodijah', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-06 07:59:41', '20210518', '', '680a5bc7ae591_img7.JPG', '680a5bc80eb47_Bukti_Pendaftaran_(1).pdf', '680a5bc8152fa_Bukti_Pendaftaran_(1).pdf', '680a5bc81c838_Bukti_Pendaftaran_(1).pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'boy040478@gmail.com', '56128373893011', NULL),
(28, '2', 'Tidak Ada Rekomendasi', 'Abdillah', 'Bekasi', '2004-12-17', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 3, 3, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Teknik Kendaraan Ringan', '2133647881', 'Tidak Ada', 'Jaldi', 'Karyawan', 'jessy', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 6000000.00, 'Diproses', '2025-04-06 15:44:03', '3214562788392222', '', '680a5d09ce865_free_(1).png', '680a5d0a18868_Bukti_Lunas_Pembayaran.pdf', '680a5d0a1ef15_Screenshot_22-4-2025_75358_.jpeg', '680a5d0a29b1f_Bukti_Lunas_Pembayaran.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'abdillah164@gmail.com', '0852345672738', NULL),
(29, '2', 'Tidak Ada Rekomendasi', 'Raditya Kevin', 'Bekasi', '2004-01-23', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 2, 2, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Teknik Kendaraan Ringan', '0021240679', 'Tidak Ada', 'Hasibuan', 'Karyawan', 'Saronah maymunah', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 6000000.00, 'Diproses', '2025-04-07 01:18:15', '3215627839902022', '', '680a5dd3a9a48_c7836b12-7f75-4836-aa2e-a6d5ae4804ee.png', '680a5dd3a9ea2_Bukti_Pendaftaran_(2).pdf', '680a5dd3a9f58_pdf-p-classtruncatedtext-module-lineclamped-85ulhh-style-max-lines5akta-lahir-p_compress.pdf', '680a5dd3a9fdf_pdf-contoh-skl-smp_compress.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'radityakev42@gmail.com', '089998475687', NULL),
(30, '2', 'Tidak Ada Rekomendasi', 'Jaenudin', 'Bekasi', '2009-01-23', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 1, 3, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '21927838', 'Manajemen Perkantoran', '1273939320', 'Tidak Ada', 'Abdul Mufti', 'Karyawan', 'Kusminah ', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 5000000.00, 'Diproses', '2025-04-07 12:57:48', '3214562738890211', '', '680a5ea17ecc6_680a3c0a49c37_Gambar_WhatsApp_2025-04-24_pukul_20.21.13_fda4af4e.jpg', '680a5ea17ee4a_c7836b12-7f75-4836-aa2e-a6d5ae4804ee-removebg-preview.png', '680a5ea17ef2e_c7836b12-7f75-4836-aa2e-a6d5ae4804ee.png', '680a5ea17f484_c7836b12-7f75-4836-aa2e-a6d5ae4804ee.png', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'jaenudin20@gmail.com', '098782827378111', NULL),
(31, '3', 'Tidak Ada Rekomendasi', 'Arsy syaputra', 'Bekasi', '2003-01-21', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 1, 2, 'Anak Kandung', 'SMP Negeri 2 Cikarang Utara ', '12334678', 'Teknik Kendaraan Ringan', '1273939309', 'Tidak Ada', 'Heru', 'Karyawan', 'Saronah maymunah', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-08 05:30:06', '12345670088', '', '680a5f676a564_c7836b12-7f75-4836-aa2e-a6d5ae4804ee-removebg-preview.png', '680a5f676a6d0_ChatGPT_Image_Apr_24,_2025,_06_32_36_PM.png', '680a5f676ac78_ChatGPT_Image_Apr_24__2025__06_32_36_PM-removebg-preview.png', '680a5f677000c_ChatGPT_Image_Apr_24,_2025,_06_32_36_PM.png', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Arsysyp189@gmail.com', '08908475687', NULL),
(32, '1', 'Tidak Ada Rekomendasi', 'Muhammad Bahar', 'Bekasi', '2002-01-23', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 1, 3, 'Anak Kandung', 'SMP Negeri 2 Subang', '21927838', 'Teknik Kendaraan Ringan', '1273939320', 'Tidak Ada', 'Heru', 'Karyawan', 'Ayu Lestari', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 5000000.00, 'Diproses', '2025-04-08 09:30:06', '2134567738889222', '', '680a64ac3cd70_backiee-238993-landscape.jpg', '680a64ac3d217_Bukti_Pendaftaran_(1).pdf', '680a64ac3d2f6_Bukti_Pendaftaran_(1).pdf', '680a64ac3d3a0_Bukti_Pendaftaran_(1).pdf', 'Guru', 'Succesforacademic@gmail.com', '1727383901010', NULL),
(35, '3', 'Tidak Ada Rekomendasi', 'Muhammad Andika Anjas Syaputra', 'Bekasi', '2003-07-01', 'laki-laki', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'Islam', 1, 3, 'Anak Kandung', 'SMP Negeri 6 Cikarang Utara', '20246570', 'Teknik Kendaraan Ringan', '0910384022', 'Tidak Ada', 'Jasi Irsan', 'Karyawan', 'Anita Nurfitriyani', 'Ibu Rumah Tangga', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 2000000.00, 'Diproses', '2025-04-28 12:51:04', '3210987182993759', '', '680f79b8496c0_bg.jpg', '680f79b849924_pdf-contoh-kk_compress.pdf', '680f79b849a42_pdf-p-classtruncatedtext-module-lineclamped-85ulhh-style-max-lines5akta-lahir-p_compress.pdf', '680f79b849b8d_pdf-contoh-skl-smp_compress.pdf', 'Kp. Walahir RT001/RW004 Desa Karangraharja Kec. Cikarang Utara Kab. Bekasi', 'andsyptraa@gmail.com', '089678976545', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `role_id` int(1) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `pendaftar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fullname`, `role_id`, `reset_token`, `reset_token_expiry`, `pendaftar_id`) VALUES
(1, 'febyzahira01@gmail.com', '$2y$10$Zo90wP9PwIDotTPkJ/XfOOIr7cVNahUKKRLSdD2njf3Sdj/bH4hja', 'Feby Arfa Z', 1, NULL, NULL, 0),
(2, 'irhamfahmi2345@gmail.com', '$2y$10$ZpJYMTr337fmLTHLGHTU9.7BxuALN09XdSXb1eDsasZ8Pp3W.cxjK', 'Irham Fahmiyudin S.Pd', 1, NULL, NULL, 0),
(3, 'hubin.smkhijaumuda@gmail.com', '$2y$10$kZw.mcb3ALaAVwX2kZIGSeKh3Quc.w0UpAgqQwcw3HYYUQYeHYZ4i', 'Heri Subekti, S.T', 1, NULL, NULL, 0),
(4, 'azisabdull2217@gmail.com', '$2y$10$rv9x/dBU8x7tkqU2/DWt1eO2Q2UBCHaaXQjTaD0PNzMnonoU/wRjS', 'Aziz Abdul S.Pd', 1, NULL, NULL, 0),
(5, 'fajarhanjairipal91@gmail.com', '$2y$10$X0jQm.VsgSgga1tRF0byy.bC8XDbs/8q6RvMET/UUR8x2FxgfIqna', 'Fajar Hanjairipal S.Pd', 1, NULL, NULL, 0),
(6, 'jaenudinalit123@gmail.com', '$2y$10$Cuvbxgr0SxoZwVhPoWbOQOkK9BLr0gPsg.7mASbVyq2kH8pkW2mQG', 'Alit Jaenudin S.Pd', 1, NULL, NULL, 0),
(7, 'ahmadtohirin1@admin.smk.belajar.id', '$2y$10$QfirhsbTKYvltmwHSV7Rdu2ocRJDvyFjKIKbbKQEpnSyS6Na4yvDK', 'Ahmad Tohirin S.Pd., M.Pd', 1, NULL, NULL, 0),
(8, 'hendrakusasih1290@gmail.com', '$2y$10$oSVitE22b8UVGnhTMkZcjekAuryNKyVIDLm8fLBhKG855Xaeyv/NK', 'Hendra Kusasih S.Pd', 1, NULL, NULL, 0),
(9, 'daenurianwar11@gmail.com', '$2y$10$HQ/ViYBRhDH6IstNCIPkDeC6MP8xn.xTmMOW8SXMpXx3B6livH04C', 'A. Daenuri ', 1, NULL, NULL, 0),
(10, 'wildaazhr09@gmail.com', '$2y$10$micIvUOWix9BG3d8aulOeuOcnSnEfKuo2UDOVWxwdYPENNGiW1k/O', 'Wilda Azzahra S.Pd', 1, NULL, NULL, 0),
(11, 'amanullooh@guru.smk.belajar.id', '$2y$10$/yiOuX/rs5DGM6E1/53WiOHllTK4MDFbND86NKukoAvJwfyDlIeqa', 'Amanulloh', 1, NULL, NULL, 0),
(12, 'udinali97@gmail.com', '$2y$10$QJrc5fEJZoSTbrA.bPLNguTCXJLLBOZSiqjv.fUGGXf1mn/dAzTya', 'Alipudin S.Pd', 1, NULL, NULL, 0),
(13, 'Hendrapratama15@gmail.com', '$2y$10$ujkyz5zd7WCwE1GN9whlUO3uT3LlQ.vwGnNfket1Y89D73myWKLZa', 'Hendra Pratama S.Kom', 1, NULL, NULL, 0),
(14, 'Raisapuspitaa12@gmail.com', '$2y$10$je3Raw5t5Ok/o7XYfmh9jea1/UMogFDHeuLaG6fj1c.V6K1EUOHSy', 'Raisa Puspita S.Pd', 1, NULL, NULL, 0),
(15, 'Tiwii12@gmail.com', '$2y$10$apGXrWmNWmmEarqg0PSIbef/SuQzBk.51DVHTWcNycDRT7/kIgDW6', 'Tiwi Nurul Khakiki', 1, NULL, NULL, 0),
(16, 'dinajanuar106@gmail.co.com', '$2y$10$605kW98LDajBjPZh2cVTSuy6MJEnp47y9q2C3Q7QT5t61i8bZh3F6', 'Dina Januar', 1, NULL, NULL, 0),
(17, 'ivanurhandayani1269@admin.smp.belajar.id', '$2y$10$QNbUijuUjbf9TG.yCpfC1uxyyP.5SWU8X5/jy8K6LOT64KJdfJIVu', 'Iva Nur Handayani', 1, NULL, NULL, 0),
(18, 'andikasyaputra818@gmail.com', '$2y$10$nlDOcVpFLCmn2mCU93sXsetGAi3UNvoIB52r/qH6ip4eVFUPC6W3C', 'M. Andika Anjas Syaputra', 1, NULL, NULL, 0),
(19, 'keillakeyli@gmail.com', '$2y$10$TUf5ktQWpL/tLeVzMczUOemvq4m3JoRTVij7Qsd2PPIrc4Vi/uzxG', 'Kelly Aprilla', 1, NULL, NULL, 0),
(20, 'hodijahindahh@gmail.com', '$2y$10$/X5S.WDKLd55WNuz4j2i/uhmQih2eT3Mz.gypU.rvlDI8leYZ51TS', 'Sri Hodijah Indah', 1, NULL, NULL, 0),
(21, 'yellisintanaiaa@gmail.com', '$2y$10$X5Bet9G65oE5O2wVuoefEeeoFMajUhcDhfwNLm9dBJGU8pesbtEna', 'Yelis Sintanaia', 1, NULL, NULL, 0),
(22, 'yudiatmokoilham@gmail.com', '$2y$10$jNRaQ1Uc/D.mKTx9xfGf0.kGqo/pruaEInClgvucRDOhEMc9Ioi8C', 'Ilham Yudiatmoko', 1, NULL, NULL, 0),
(23, 'edijoe29120@gmail.com', '$2y$10$F3dWPJ9klomhJo06wSnp/eKLXrXtuFBuGkWtzMGOKzFBc3n3FyBm2', 'Edi Joe', 1, NULL, NULL, 0),
(24, 'muniroh1770@gmail.com', '$2y$10$fHEj//Rzc2SE06KL/MMxFeos39c6l324hrsC7v5vnDj9H6bNwcdxW', 'Muniroh', 1, NULL, NULL, 0),
(25, 'rahmahaadipratama@gmail.com', '$2y$10$gMe5HxxDdgJ2d6nMJNUE6ept3t37eYrThG50JDOGFfB2El6ruGnau', 'Rahmah Adi Pratama', 1, NULL, NULL, 0),
(26, 'zeanetaadelia@gmail.com', '$2y$10$jIn990KeoYu1COZl6Lp6LuRVLKaAuS/6WgxGqFfCOw7HPlWZtXt0G', 'Adelia Zeaneta', 1, NULL, NULL, 0),
(27, 'boy040478@gmail.com', '$2y$10$6ZeHvmbb28A3gCAdTWkj.eNSFNaoyXn/Qkzi/9xgXVsnJ8KB4dINq', 'Boy', 1, NULL, NULL, 0),
(28, 'abdillah164@gmail.com', '$2y$10$abPYsGkgSI3iu/x75NYGruFeeSgkMRb3FV0oGlQcKfg78fSa9au12', 'Abdillah', 1, NULL, NULL, 0),
(29, 'radityakev42@gmail.com', '$2y$10$9oxawRPnjMrNpFPDWA4hcOy7oyz4b7KVM00K3mt5B.o5KU97kBe7e', 'Raditya Kevin', 1, NULL, NULL, 0),
(30, 'jaenudin20@gmail.com', '$2y$10$kazQUIF1ZjRNyeLO6rPqAervvuXlTrwaUSqwL.MnYCS5fXWislWfm', 'Jaenudin', 1, NULL, NULL, 0),
(31, 'Arsysyp189@gmail.com', '$2y$10$nyD7ydWnR0rWEadnCv3C5eL2P5g/EwfihbqPCKCM8i7p/IfDkXRMi', 'Arsy Syaputra', 1, NULL, NULL, 0),
(32, 'Succesforacademic@gmail.com', '$2y$10$xjOpL/hB217XtNHA6QtB7enFeg4M7J.AzvpKkTj2Sgw4okGsRwqNG', 'Muhammad Bahar', 1, NULL, NULL, 0),
(35, 'andsyptraa@gmail.com', '$2y$10$rVOgvV4aE7IiNhrPBMeFWO8cK6DUr4mRYBg6AxAMmxH3kGtNmOXcK', 'Muhammad Andika Anjas Syaputra', 1, NULL, NULL, 0),
(36, 'azzahrap@gmail.com', '$2y$10$aQl39Vr0G1xolDk6gvtt.udnsnJZkyqfPdPnBmw8UaCrx4rahYAfC', 'Azzahra Putri Maharani', 1, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembayaran_siswa`
--
ALTER TABLE `pembayaran_siswa`
  ADD KEY `fk_pembayaran_user` (`user_id`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD KEY `fk_pendaftar_user` (`user_id`),
  ADD KEY `fk_admin` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran_siswa`
--
ALTER TABLE `pembayaran_siswa`
  ADD CONSTRAINT `fk_pembayaran_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pendaftar_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
