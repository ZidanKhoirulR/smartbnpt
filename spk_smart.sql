-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 05:35 PM
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
-- Database: `spk_smart`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(6) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `alternatif` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id`, `kode`, `nik`, `alternatif`, `keterangan`, `created_at`, `updated_at`) VALUES
(32, 'A00001', '3201234567890001', 'Budi Santoso', NULL, '2025-08-23 20:23:01', '2025-08-23 20:23:01'),
(33, 'A00002', '3201234567890002', 'Siti Aminah', NULL, '2025-08-23 20:23:17', '2025-08-23 20:23:17'),
(34, 'A00003', '3201234567890003', 'Rina Wati', NULL, '2025-08-23 20:23:35', '2025-08-23 20:23:35'),
(35, 'A00004', '3201234567890004', 'Joko Widodo', NULL, '2025-08-23 20:23:51', '2025-08-23 20:23:51'),
(36, 'A00005', '3201234567890005', 'Dewi Sari', NULL, '2025-08-23 20:24:05', '2025-08-23 20:24:05'),
(37, 'A00006', '3201234567890006', 'Ahmad Fauzi', NULL, '2025-08-23 20:24:18', '2025-08-23 20:24:18'),
(38, 'A00007', '3201234567890007', 'Bambang Tri', NULL, '2025-08-23 20:24:31', '2025-08-23 20:24:31'),
(39, 'A00008', '3201234567890008', 'Sari Indah', NULL, '2025-08-23 20:24:46', '2025-08-23 20:24:46'),
(40, 'A00009', '3201234567890009', 'Hendra Gunawan', NULL, '2025-08-23 20:25:00', '2025-08-23 20:25:00'),
(41, 'A00010', '3201234567890010', 'Lestari Ningrum', NULL, '2025-08-23 20:25:17', '2025-08-23 20:25:17'),
(42, 'A00011', '3201234567890011', 'Agus Salim', NULL, '2025-08-23 20:25:31', '2025-08-23 20:25:31'),
(43, 'A00012', '3201234567890012', 'Yuni Astuti', NULL, '2025-08-23 20:25:47', '2025-08-23 20:25:47'),
(44, 'A00013', '3201234567890013', 'Dedi Kurniawan', NULL, '2025-08-23 20:26:03', '2025-08-23 20:26:03'),
(45, 'A00014', '3201234567890014', 'Eka Putri', NULL, '2025-08-23 20:26:20', '2025-08-23 20:26:20'),
(46, 'A00015', '3201234567890015', 'Fahmi Rahman', NULL, '2025-08-23 20:26:34', '2025-08-23 20:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admind@gmail.com|127.0.0.1', 'i:1;', 1755280556),
('admind@gmail.com|127.0.0.1:timer', 'i:1755280556;', 1755280556);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) NOT NULL,
  `ranking` int(11) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `jenis_kriteria` enum('cost','benefit') NOT NULL DEFAULT 'benefit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bobot` decimal(6,4) DEFAULT NULL,
  `roc_weight` decimal(8,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `kode`, `ranking`, `kriteria`, `jenis_kriteria`, `created_at`, `updated_at`, `bobot`, `roc_weight`) VALUES
(18, 'K00001', 1, 'Pendapatan Keluarga', 'cost', '2025-08-20 09:12:51', '2025-08-20 09:12:51', NULL, NULL),
(19, 'K00002', 2, 'Jumlah Anggota Keluarga', 'benefit', '2025-08-20 09:13:14', '2025-08-20 09:13:14', NULL, NULL),
(20, 'K00003', 3, 'Status Kepemilikan Rumah', 'cost', '2025-08-20 09:13:37', '2025-08-20 09:13:37', NULL, NULL),
(21, 'K00004', 4, 'Tingkat Pendidikan Kepala Keluarga', 'cost', '2025-08-20 09:14:04', '2025-08-20 09:14:04', NULL, NULL),
(22, 'K00005', 5, 'Status Pekerjaan', 'cost', '2025-08-20 09:14:22', '2025-08-20 09:14:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `matriks_ternormalisasi`
--

CREATE TABLE `matriks_ternormalisasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif_id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matriks_ternormalisasi`
--

INSERT INTO `matriks_ternormalisasi` (`id`, `alternatif_id`, `kriteria_id`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 32, 18, 0.4567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(2, 32, 19, 0.1711, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(3, 32, 20, 0.1567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(4, 32, 21, 0.0675, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(5, 32, 22, 0.0300, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(6, 33, 18, 0.3425, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(7, 33, 19, 0.0856, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(8, 33, 20, 0.1175, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(9, 33, 21, 0.0450, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(10, 33, 22, 0.0200, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(11, 34, 18, 0.4567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(12, 34, 19, 0.2567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(13, 34, 20, 0.1567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(14, 34, 21, 0.0900, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(15, 34, 22, 0.0400, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(16, 35, 18, 0.2284, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(17, 35, 19, 0.0856, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(18, 35, 20, 0.0784, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(19, 35, 21, 0.0225, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(20, 35, 22, 0.0100, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(21, 36, 18, 0.3425, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(22, 36, 19, 0.1711, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(23, 36, 20, 0.1175, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(24, 36, 21, 0.0675, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(25, 36, 22, 0.0300, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(26, 37, 18, 0.0000, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(27, 37, 19, 0.0000, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(28, 37, 20, 0.0000, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(29, 37, 21, 0.0000, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(30, 37, 22, 0.0000, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(31, 38, 18, 0.4567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(32, 38, 19, 0.2567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(33, 38, 20, 0.1567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(34, 38, 21, 0.0450, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(35, 38, 22, 0.0200, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(36, 39, 18, 0.3425, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(37, 39, 19, 0.0856, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(38, 39, 20, 0.0784, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(39, 39, 21, 0.0225, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(40, 39, 22, 0.0100, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(41, 40, 18, 0.4567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(42, 40, 19, 0.1711, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(43, 40, 20, 0.1175, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(44, 40, 21, 0.0675, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(45, 40, 22, 0.0300, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(46, 41, 18, 0.1142, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(47, 41, 19, 0.0856, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(48, 41, 20, 0.0392, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(49, 41, 21, 0.0225, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(50, 41, 22, 0.0100, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(51, 42, 18, 0.3425, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(52, 42, 19, 0.2567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(53, 42, 20, 0.1567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(54, 42, 21, 0.0225, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(55, 42, 22, 0.0100, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(56, 43, 18, 0.3425, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(57, 43, 19, 0.0856, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(58, 43, 20, 0.0784, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(59, 43, 21, 0.0450, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(60, 43, 22, 0.0100, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(61, 44, 18, 0.4567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(62, 44, 19, 0.2567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(63, 44, 20, 0.1567, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(64, 44, 21, 0.0675, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(65, 44, 22, 0.0400, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(66, 45, 18, 0.2284, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(67, 45, 19, 0.0856, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(68, 45, 20, 0.0392, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(69, 45, 21, 0.0225, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(70, 45, 22, 0.0100, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(71, 46, 18, 0.3425, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(72, 46, 19, 0.1711, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(73, 46, 20, 0.1175, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(74, 46, 21, 0.0450, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(75, 46, 22, 0.0300, '2025-08-23 20:36:10', '2025-08-23 20:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_20_160225_create_kriterias_table', 1),
(5, '2025_01_20_160234_create_sub_kriterias_table', 1),
(6, '2025_01_20_160258_create_alternatifs_table', 1),
(7, '2025_01_20_160500_create_penilaians_table', 1),
(8, '2025_01_22_125314_create_normalisasi_bobots_table', 1),
(9, '2025_01_22_125339_create_nilai_utilities_table', 1),
(15, '2025_01_22_125659_create_nilai_akhirs_table', 2),
(16, '2025_08_02_144659_add_nik_to_alternatif_table', 2),
(17, '2025_08_04_000001_add_ranking_to_kriteria_table', 2),
(18, '2025_08_09_020507_update_kriteria_table_for_roc', 2),
(19, '2025_08_09_145554_add_roc_weight_to_kriteria_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_akhir`
--

CREATE TABLE `nilai_akhir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif_id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nilai` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_akhir`
--

INSERT INTO `nilai_akhir` (`id`, `alternatif_id`, `kriteria_id`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 32, NULL, 0.882, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(2, 33, NULL, 0.6106, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(3, 34, NULL, 1.0001, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(4, 35, NULL, 0.4249, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(5, 36, NULL, 0.7286, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(6, 37, NULL, 0, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(7, 38, NULL, 0.9351, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(8, 39, NULL, 0.539, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(9, 40, NULL, 0.8428, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(10, 41, NULL, 0.2715, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(11, 42, NULL, 0.7884, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(12, 43, NULL, 0.5615, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(13, 44, NULL, 0.9776, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(14, 45, NULL, 0.3857, '2025-08-23 20:36:11', '2025-08-23 20:36:11'),
(15, 46, NULL, 0.7061, '2025-08-23 20:36:11', '2025-08-23 20:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_utility`
--

CREATE TABLE `nilai_utility` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif_id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_utility`
--

INSERT INTO `nilai_utility` (`id`, `alternatif_id`, `kriteria_id`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 32, 18, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(2, 32, 19, 0.6667, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(3, 32, 20, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(4, 32, 21, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(5, 32, 22, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(6, 33, 18, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(7, 33, 19, 0.3333, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(8, 33, 20, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(9, 33, 21, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(10, 33, 22, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(11, 34, 18, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(12, 34, 19, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(13, 34, 20, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(14, 34, 21, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(15, 34, 22, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(16, 35, 18, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(17, 35, 19, 0.3333, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(18, 35, 20, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(19, 35, 21, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(20, 35, 22, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(21, 36, 18, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(22, 36, 19, 0.6667, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(23, 36, 20, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(24, 36, 21, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(25, 36, 22, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(26, 37, 18, 0.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(27, 37, 19, 0.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(28, 37, 20, 0.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(29, 37, 21, 0.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(30, 37, 22, 0.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(31, 38, 18, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(32, 38, 19, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(33, 38, 20, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(34, 38, 21, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(35, 38, 22, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(36, 39, 18, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(37, 39, 19, 0.3333, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(38, 39, 20, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(39, 39, 21, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(40, 39, 22, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(41, 40, 18, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(42, 40, 19, 0.6667, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(43, 40, 20, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(44, 40, 21, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(45, 40, 22, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(46, 41, 18, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(47, 41, 19, 0.3333, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(48, 41, 20, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(49, 41, 21, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(50, 41, 22, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(51, 42, 18, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(52, 42, 19, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(53, 42, 20, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(54, 42, 21, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(55, 42, 22, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(56, 43, 18, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(57, 43, 19, 0.3333, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(58, 43, 20, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(59, 43, 21, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(60, 43, 22, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(61, 44, 18, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(62, 44, 19, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(63, 44, 20, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(64, 44, 21, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(65, 44, 22, 1.0000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(66, 45, 18, 0.5000, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(67, 45, 19, 0.3333, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(68, 45, 20, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(69, 45, 21, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(70, 45, 22, 0.2500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(71, 46, 18, 0.7500, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(72, 46, 19, 0.6667, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(73, 46, 20, 0.7500, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(74, 46, 21, 0.5000, '2025-08-23 20:36:10', '2025-08-23 20:36:10'),
(75, 46, 22, 0.7500, '2025-08-23 20:36:10', '2025-08-23 20:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `normalisasi_bobot`
--

CREATE TABLE `normalisasi_bobot` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `normalisasi` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `normalisasi_bobot`
--

INSERT INTO `normalisasi_bobot` (`id`, `kriteria_id`, `normalisasi`, `created_at`, `updated_at`) VALUES
(1, 18, 0.4567, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(2, 19, 0.2567, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(3, 20, 0.1567, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(4, 21, 0.0900, '2025-08-23 20:36:09', '2025-08-23 20:36:09'),
(5, 22, 0.0400, '2025-08-23 20:36:09', '2025-08-23 20:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif_id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `sub_kriteria_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id`, `alternatif_id`, `kriteria_id`, `sub_kriteria_id`, `created_at`, `updated_at`) VALUES
(173, 32, 18, 84, '2025-08-23 20:23:01', '2025-08-23 20:27:18'),
(174, 32, 19, 92, '2025-08-23 20:23:01', '2025-08-23 20:27:18'),
(175, 32, 20, 94, '2025-08-23 20:23:01', '2025-08-23 20:27:18'),
(176, 32, 21, 101, '2025-08-23 20:23:01', '2025-08-23 20:27:18'),
(177, 32, 22, 106, '2025-08-23 20:23:01', '2025-08-23 20:27:18'),
(178, 33, 18, 85, '2025-08-23 20:23:17', '2025-08-23 20:27:51'),
(179, 33, 19, 91, '2025-08-23 20:23:17', '2025-08-23 20:27:51'),
(180, 33, 20, 99, '2025-08-23 20:23:17', '2025-08-23 20:27:51'),
(181, 33, 21, 102, '2025-08-23 20:23:17', '2025-08-23 20:27:51'),
(182, 33, 22, 107, '2025-08-23 20:23:17', '2025-08-23 20:27:51'),
(183, 34, 18, 84, '2025-08-23 20:23:35', '2025-08-23 20:28:25'),
(184, 34, 19, 93, '2025-08-23 20:23:35', '2025-08-23 20:28:25'),
(185, 34, 20, 94, '2025-08-23 20:23:35', '2025-08-23 20:28:25'),
(186, 34, 21, 100, '2025-08-23 20:23:35', '2025-08-23 20:28:25'),
(187, 34, 22, 105, '2025-08-23 20:23:35', '2025-08-23 20:28:25'),
(188, 35, 18, 86, '2025-08-23 20:23:51', '2025-08-23 20:28:58'),
(189, 35, 19, 91, '2025-08-23 20:23:51', '2025-08-23 20:28:58'),
(190, 35, 20, 96, '2025-08-23 20:23:51', '2025-08-23 20:28:58'),
(191, 35, 21, 103, '2025-08-23 20:23:51', '2025-08-23 20:28:58'),
(192, 35, 22, 108, '2025-08-23 20:23:51', '2025-08-23 20:28:58'),
(193, 36, 18, 85, '2025-08-23 20:24:05', '2025-08-23 20:29:29'),
(194, 36, 19, 92, '2025-08-23 20:24:05', '2025-08-23 20:29:29'),
(195, 36, 20, 99, '2025-08-23 20:24:05', '2025-08-23 20:29:29'),
(196, 36, 21, 101, '2025-08-23 20:24:05', '2025-08-23 20:29:29'),
(197, 36, 22, 106, '2025-08-23 20:24:05', '2025-08-23 20:29:29'),
(198, 37, 18, 88, '2025-08-23 20:24:18', '2025-08-23 20:30:12'),
(199, 37, 19, 90, '2025-08-23 20:24:18', '2025-08-23 20:30:12'),
(200, 37, 20, 98, '2025-08-23 20:24:18', '2025-08-23 20:30:12'),
(201, 37, 21, 104, '2025-08-23 20:24:18', '2025-08-23 20:30:12'),
(202, 37, 22, 109, '2025-08-23 20:24:18', '2025-08-23 20:30:12'),
(203, 38, 18, 84, '2025-08-23 20:24:31', '2025-08-23 20:31:07'),
(204, 38, 19, 93, '2025-08-23 20:24:31', '2025-08-23 20:31:07'),
(205, 38, 20, 94, '2025-08-23 20:24:31', '2025-08-23 20:31:07'),
(206, 38, 21, 102, '2025-08-23 20:24:31', '2025-08-23 20:31:07'),
(207, 38, 22, 107, '2025-08-23 20:24:31', '2025-08-23 20:31:07'),
(208, 39, 18, 85, '2025-08-23 20:24:46', '2025-08-23 20:31:43'),
(209, 39, 19, 91, '2025-08-23 20:24:46', '2025-08-23 20:31:43'),
(210, 39, 20, 96, '2025-08-23 20:24:46', '2025-08-23 20:31:43'),
(211, 39, 21, 103, '2025-08-23 20:24:46', '2025-08-23 20:31:43'),
(212, 39, 22, 108, '2025-08-23 20:24:46', '2025-08-23 20:31:43'),
(213, 40, 18, 84, '2025-08-23 20:25:00', '2025-08-23 20:32:20'),
(214, 40, 19, 92, '2025-08-23 20:25:00', '2025-08-23 20:32:20'),
(215, 40, 20, 99, '2025-08-23 20:25:00', '2025-08-23 20:32:20'),
(216, 40, 21, 101, '2025-08-23 20:25:00', '2025-08-23 20:32:20'),
(217, 40, 22, 106, '2025-08-23 20:25:00', '2025-08-23 20:32:20'),
(218, 41, 18, 87, '2025-08-23 20:25:17', '2025-08-23 20:33:07'),
(219, 41, 19, 91, '2025-08-23 20:25:17', '2025-08-23 20:33:07'),
(220, 41, 20, 97, '2025-08-23 20:25:17', '2025-08-23 20:33:07'),
(221, 41, 21, 103, '2025-08-23 20:25:17', '2025-08-23 20:33:07'),
(222, 41, 22, 108, '2025-08-23 20:25:17', '2025-08-23 20:33:07'),
(223, 42, 18, 85, '2025-08-23 20:25:31', '2025-08-23 20:33:50'),
(224, 42, 19, 93, '2025-08-23 20:25:31', '2025-08-23 20:33:50'),
(225, 42, 20, 94, '2025-08-23 20:25:31', '2025-08-23 20:33:50'),
(226, 42, 21, 103, '2025-08-23 20:25:31', '2025-08-23 20:33:50'),
(227, 42, 22, 108, '2025-08-23 20:25:31', '2025-08-23 20:33:50'),
(228, 43, 18, 85, '2025-08-23 20:25:47', '2025-08-23 20:34:26'),
(229, 43, 19, 91, '2025-08-23 20:25:47', '2025-08-23 20:34:26'),
(230, 43, 20, 96, '2025-08-23 20:25:47', '2025-08-23 20:34:26'),
(231, 43, 21, 102, '2025-08-23 20:25:47', '2025-08-23 20:34:26'),
(232, 43, 22, 108, '2025-08-23 20:25:47', '2025-08-23 20:34:26'),
(233, 44, 18, 84, '2025-08-23 20:26:03', '2025-08-23 20:34:57'),
(234, 44, 19, 93, '2025-08-23 20:26:03', '2025-08-23 20:34:57'),
(235, 44, 20, 94, '2025-08-23 20:26:03', '2025-08-23 20:34:57'),
(236, 44, 21, 101, '2025-08-23 20:26:03', '2025-08-23 20:34:57'),
(237, 44, 22, 105, '2025-08-23 20:26:03', '2025-08-23 20:34:57'),
(238, 45, 18, 86, '2025-08-23 20:26:20', '2025-08-23 20:35:26'),
(239, 45, 19, 91, '2025-08-23 20:26:20', '2025-08-23 20:35:26'),
(240, 45, 20, 97, '2025-08-23 20:26:20', '2025-08-23 20:35:26'),
(241, 45, 21, 103, '2025-08-23 20:26:20', '2025-08-23 20:35:26'),
(242, 45, 22, 108, '2025-08-23 20:26:20', '2025-08-23 20:35:26'),
(243, 46, 18, 85, '2025-08-23 20:26:34', '2025-08-23 20:35:52'),
(244, 46, 19, 92, '2025-08-23 20:26:34', '2025-08-23 20:35:52'),
(245, 46, 20, 99, '2025-08-23 20:26:34', '2025-08-23 20:35:52'),
(246, 46, 21, 102, '2025-08-23 20:26:34', '2025-08-23 20:35:52'),
(247, 46, 22, 106, '2025-08-23 20:26:34', '2025-08-23 20:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9CVLovmrR5ouxy48qoeo9yzgVfJpJlplOTx6eyRN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib3lHT1A1NFJXU2tJY0kzVVVtallzVVlLOXNvTG9pTlVudjhhbW9JdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wdWJsaWMvaGFzaWwtYWtoaXIiO319', 1756328911),
('dQ1g2LoTDvrywu4SMPHQcOR0ftRYYxBAR3MeWPwG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYU5ZSm16b0s0MGw2VWVpczA1YlVDcThzZEhCZ3pUY3dxVzk4cFVjVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1756312167),
('lG30cu4GWoIgQfYrJ7AgZfQvoOftaRDLI50dP9Hk', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaFNrM3RrS01SZTZTRk1HbUdxV2tJdTJybzZuWmRpR2wyaG9VMUNTcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zbWFydGVyL3BlcmhpdHVuZ2FuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1756345105);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_kriteria` varchar(50) NOT NULL,
  `bobot` decimal(8,2) NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id`, `sub_kriteria`, `bobot`, `kriteria_id`, `created_at`, `updated_at`) VALUES
(84, '<Rp 500.000', 10.00, 18, '2025-08-20 09:35:33', '2025-08-20 09:35:33'),
(85, 'Rp 500.000 - Rp 1.000.000', 15.00, 18, '2025-08-20 09:36:05', '2025-08-20 09:36:05'),
(86, 'Rp 1.000.000 - Rp 1.500.000', 20.00, 18, '2025-08-20 09:36:41', '2025-08-20 09:36:41'),
(87, 'Rp 1.500.000 - Rp 2.000.000', 25.00, 18, '2025-08-20 09:37:11', '2025-08-20 09:37:11'),
(88, '>Rp 2.000.000', 30.00, 18, '2025-08-20 09:37:35', '2025-08-20 09:38:10'),
(89, '1 orang', 10.00, 19, '2025-08-20 09:38:32', '2025-08-20 09:38:32'),
(90, '2 orang', 15.00, 19, '2025-08-20 09:39:04', '2025-08-20 09:39:04'),
(91, '3 - 4 orang', 20.00, 19, '2025-08-20 09:39:39', '2025-08-20 09:40:21'),
(92, '5 - 6 orang', 25.00, 19, '2025-08-20 09:40:05', '2025-08-20 09:40:05'),
(93, '>6 orang', 30.00, 19, '2025-08-20 09:41:26', '2025-08-20 09:41:26'),
(94, 'Menumpang / Numpang', 10.00, 20, '2025-08-20 09:42:21', '2025-08-20 09:42:21'),
(96, 'Rumah Warisan', 20.00, 20, '2025-08-20 09:43:14', '2025-08-20 09:43:14'),
(97, 'Rumah Kredit', 25.00, 20, '2025-08-20 09:43:42', '2025-08-20 09:43:42'),
(98, 'Rumah Pribadi', 30.00, 20, '2025-08-20 09:44:04', '2025-08-20 09:44:04'),
(99, 'Rumah Kontrak', 15.00, 20, '2025-08-20 09:44:52', '2025-08-20 09:44:52'),
(100, 'Tidak Bersekolah', 10.00, 21, '2025-08-20 09:45:21', '2025-08-20 09:45:21'),
(101, 'SD / Sederajat', 15.00, 21, '2025-08-20 09:45:43', '2025-08-20 09:45:43'),
(102, 'SMP / Sederajat', 20.00, 21, '2025-08-20 09:46:03', '2025-08-20 09:46:03'),
(103, 'SMA / Sederajat', 25.00, 21, '2025-08-20 09:46:24', '2025-08-20 09:46:24'),
(104, 'D3 / S1 / S2 / S3', 30.00, 21, '2025-08-20 09:46:51', '2025-08-20 09:46:51'),
(105, 'Pengangguran', 10.00, 22, '2025-08-20 09:47:11', '2025-08-20 09:47:11'),
(106, 'Buruh Harian Lepas', 15.00, 22, '2025-08-20 09:47:35', '2025-08-20 09:47:35'),
(107, 'Petani / Nelayan Kecil', 20.00, 22, '2025-08-20 09:47:58', '2025-08-20 09:47:58'),
(108, 'Pedagang Kecil', 25.00, 22, '2025-08-20 09:48:22', '2025-08-20 09:48:22'),
(109, 'PNS / Pegawai Tetap', 30.00, 22, '2025-08-20 09:48:41', '2025-08-20 09:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Linjamsos', 'admin@gmail.com', '2025-07-27 04:21:08', '$2y$12$HbFeH3EW/T2.yyBGhiBWLuwimmfY.exuQr9iLyhK8tx1y4rFcyyJ6', '9YTjOazags7pqQVbOdvu3iPu8qJ2IAuDsKsHkn3OYffS0iWbXt2BsQTyJek6', '2025-07-27 04:21:09', '2025-07-27 04:21:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alternatif_kode_unique` (`kode`),
  ADD UNIQUE KEY `alternatif_nik_unique` (`nik`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kriteria_kode_unique` (`kode`);

--
-- Indexes for table `matriks_ternormalisasi`
--
ALTER TABLE `matriks_ternormalisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matriks_ternormalisasi_alternatif_id_foreign` (`alternatif_id`),
  ADD KEY `matriks_ternormalisasi_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_akhir_alternatif_id_foreign` (`alternatif_id`),
  ADD KEY `nilai_akhir_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `nilai_utility`
--
ALTER TABLE `nilai_utility`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_utility_alternatif_id_foreign` (`alternatif_id`),
  ADD KEY `nilai_utility_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `normalisasi_bobot`
--
ALTER TABLE `normalisasi_bobot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `normalisasi_bobot_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penilaian_alternatif_id_foreign` (`alternatif_id`),
  ADD KEY `penilaian_sub_kriteria_id_foreign` (`sub_kriteria_id`),
  ADD KEY `penilaian_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_kriteria_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `matriks_ternormalisasi`
--
ALTER TABLE `matriks_ternormalisasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nilai_utility`
--
ALTER TABLE `nilai_utility`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `normalisasi_bobot`
--
ALTER TABLE `normalisasi_bobot`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matriks_ternormalisasi`
--
ALTER TABLE `matriks_ternormalisasi`
  ADD CONSTRAINT `matriks_ternormalisasi_alternatif_id_foreign` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`id`),
  ADD CONSTRAINT `matriks_ternormalisasi_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`);

--
-- Constraints for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  ADD CONSTRAINT `nilai_akhir_alternatif_id_foreign` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`id`),
  ADD CONSTRAINT `nilai_akhir_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`);

--
-- Constraints for table `nilai_utility`
--
ALTER TABLE `nilai_utility`
  ADD CONSTRAINT `nilai_utility_alternatif_id_foreign` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`id`),
  ADD CONSTRAINT `nilai_utility_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`);

--
-- Constraints for table `normalisasi_bobot`
--
ALTER TABLE `normalisasi_bobot`
  ADD CONSTRAINT `normalisasi_bobot_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`);

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_alternatif_id_foreign` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`id`),
  ADD CONSTRAINT `penilaian_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_sub_kriteria_id_foreign` FOREIGN KEY (`sub_kriteria_id`) REFERENCES `sub_kriteria` (`id`);

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
