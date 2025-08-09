-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2025 at 05:20 PM
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
(11, 'A00001', '3201234567890011', 'Keluarga Pak Andino', NULL, '2025-08-08 22:33:40', '2025-08-09 04:41:41'),
(12, 'A00002', '3201234567890012', 'Keluarga Pak Joko', NULL, '2025-08-08 22:38:16', '2025-08-08 22:38:16'),
(13, 'A00003', '3201234567890013', 'Keluarga Bu Siti', NULL, '2025-08-08 22:38:27', '2025-08-08 22:38:27'),
(14, 'A00004', '3201234567890014', 'Keluarga Bu Rendra', NULL, '2025-08-08 22:38:49', '2025-08-08 22:38:49'),
(15, 'A00005', '3201234567890015', 'Keluarga Pak Handoyo', NULL, '2025-08-08 22:39:08', '2025-08-08 22:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(13, 'K00001', 1, 'Pendapatan per Bulan', 'cost', '2025-08-09 04:37:50', '2025-08-09 08:13:54', 0.4567, NULL),
(14, 'K00002', 2, 'Jumlah Tanggungan', 'benefit', '2025-08-09 04:38:44', '2025-08-09 08:13:54', 0.2567, NULL),
(15, 'K00003', 3, 'Kepemilikan Aset', 'cost', '2025-08-09 04:39:01', '2025-08-09 08:13:54', 0.1567, NULL),
(16, 'K00004', 4, 'Tempat Tinggal', 'cost', '2025-08-09 04:39:47', '2025-08-09 08:13:54', 0.0900, NULL),
(17, 'K00005', 5, 'Pekerjaan', 'cost', '2025-08-09 04:40:16', '2025-08-09 08:13:54', 0.0400, NULL);

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
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 11, 13, 0.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(2, 11, 14, 0.2500, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(3, 11, 15, 0.7500, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(4, 11, 16, 0.5000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(5, 11, 17, 0.7500, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(6, 12, 13, 0.5000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(7, 12, 14, 1.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(8, 12, 15, 0.2500, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(9, 12, 16, 0.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(10, 12, 17, 1.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(11, 13, 13, 0.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(12, 13, 14, 0.5000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(13, 13, 15, 0.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(14, 13, 16, 1.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(15, 13, 17, 0.5000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(16, 14, 13, 1.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(17, 14, 14, 0.2500, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(18, 14, 15, 1.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(19, 14, 16, 1.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(20, 14, 17, 0.2500, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(21, 15, 13, 0.7500, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(22, 15, 14, 0.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(23, 15, 15, 0.5000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(24, 15, 16, 0.5000, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(25, 15, 17, 0.0000, '2025-08-09 05:03:25', '2025-08-09 05:03:25');

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
(1, 13, 0.4567, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(2, 14, 0.2567, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(3, 15, 0.1567, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(4, 16, 0.0900, '2025-08-09 05:03:25', '2025-08-09 05:03:25'),
(5, 17, 0.0400, '2025-08-09 05:03:25', '2025-08-09 05:03:25');

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
(68, 11, 13, 37, '2025-08-09 04:37:50', '2025-08-09 05:00:55'),
(69, 12, 13, 39, '2025-08-09 04:37:50', '2025-08-09 05:01:14'),
(70, 13, 13, 37, '2025-08-09 04:37:50', '2025-08-09 05:02:53'),
(71, 14, 13, 41, '2025-08-09 04:37:50', '2025-08-09 05:03:09'),
(72, 15, 13, 40, '2025-08-09 04:37:50', '2025-08-09 05:02:25'),
(73, 11, 14, 43, '2025-08-09 04:38:44', '2025-08-09 05:00:55'),
(74, 12, 14, 47, '2025-08-09 04:38:44', '2025-08-09 05:01:14'),
(75, 13, 14, 44, '2025-08-09 04:38:44', '2025-08-09 05:02:53'),
(76, 14, 14, 43, '2025-08-09 04:38:44', '2025-08-09 05:03:09'),
(77, 15, 14, 42, '2025-08-09 04:38:44', '2025-08-09 05:02:25'),
(78, 11, 15, 49, '2025-08-09 04:39:02', '2025-08-09 05:00:55'),
(79, 12, 15, 51, '2025-08-09 04:39:02', '2025-08-09 05:01:14'),
(80, 13, 15, 52, '2025-08-09 04:39:02', '2025-08-09 05:02:53'),
(81, 14, 15, 48, '2025-08-09 04:39:02', '2025-08-09 05:03:09'),
(82, 15, 15, 50, '2025-08-09 04:39:02', '2025-08-09 05:02:25'),
(83, 11, 16, 54, '2025-08-09 04:39:47', '2025-08-09 05:00:55'),
(84, 12, 16, 53, '2025-08-09 04:39:47', '2025-08-09 05:01:14'),
(85, 13, 16, 55, '2025-08-09 04:39:47', '2025-08-09 05:02:53'),
(86, 14, 16, 55, '2025-08-09 04:39:47', '2025-08-09 05:03:09'),
(87, 15, 16, 54, '2025-08-09 04:39:47', '2025-08-09 05:02:25'),
(88, 11, 17, 59, '2025-08-09 04:40:16', '2025-08-09 05:00:55'),
(89, 12, 17, 60, '2025-08-09 04:40:16', '2025-08-09 05:01:14'),
(90, 13, 17, 58, '2025-08-09 04:40:16', '2025-08-09 05:02:53'),
(91, 14, 17, 57, '2025-08-09 04:40:16', '2025-08-09 05:03:09'),
(92, 15, 17, 56, '2025-08-09 04:40:16', '2025-08-09 05:02:25');

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
('YLCrEKeDyFbcmx9tLNoJAidREPUlhRgRF6WcK0jG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUUY2V1hoa1lXQ1JTY0xLS1h6aE1yS3J1UkFYYTE2N01MdXFFdlNvNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rcml0ZXJpYSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1754752830);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_kriteria` varchar(255) NOT NULL,
  `bobot` decimal(8,2) NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id`, `sub_kriteria`, `bobot`, `kriteria_id`, `created_at`, `updated_at`) VALUES
(37, '< 300.000', 30.00, 13, '2025-08-09 04:43:06', '2025-08-09 04:45:38'),
(38, '350.000 - 600.000', 25.00, 13, '2025-08-09 04:43:50', '2025-08-09 04:45:49'),
(39, '650.000 - 1250.000', 20.00, 13, '2025-08-09 04:44:47', '2025-08-09 04:45:59'),
(40, '1.250.000 - 3.000.000', 15.00, 13, '2025-08-09 04:45:24', '2025-08-09 04:46:38'),
(41, '> 3.000.000', 10.00, 13, '2025-08-09 04:46:59', '2025-08-09 04:46:59'),
(42, '1 - 2 orang', 10.00, 14, '2025-08-09 04:47:30', '2025-08-09 04:47:30'),
(43, '2 - 4 orang', 15.00, 14, '2025-08-09 04:48:40', '2025-08-09 04:48:40'),
(44, '5 - 6 orang', 20.00, 14, '2025-08-09 04:49:09', '2025-08-09 04:49:09'),
(45, '6  - 8 orang', 25.00, 14, '2025-08-09 04:49:43', '2025-08-09 04:49:43'),
(47, '< 8 orang', 30.00, 14, '2025-08-09 04:51:13', '2025-08-09 04:51:13'),
(48, 'Mobil', 10.00, 15, '2025-08-09 04:51:43', '2025-08-09 04:51:43'),
(49, 'Motor', 15.00, 15, '2025-08-09 04:52:14', '2025-08-09 04:52:14'),
(50, 'Sepeda', 20.00, 15, '2025-08-09 04:52:35', '2025-08-09 04:52:35'),
(51, 'Televisi', 25.00, 15, '2025-08-09 04:52:53', '2025-08-09 04:52:53'),
(52, 'Tidak ada yang beharga', 30.00, 15, '2025-08-09 04:53:16', '2025-08-09 04:53:16'),
(53, 'Numpang Tetangga', 30.00, 16, '2025-08-09 04:53:52', '2025-08-09 04:53:52'),
(54, 'Ngontrak', 25.00, 16, '2025-08-09 04:54:25', '2025-08-09 04:54:25'),
(55, 'Kost', 20.00, 16, '2025-08-09 04:55:10', '2025-08-09 04:55:10'),
(56, 'Buruh Harian', 30.00, 17, '2025-08-09 04:57:36', '2025-08-09 04:57:36'),
(57, 'Petani, Peternak,dst', 25.00, 17, '2025-08-09 04:58:18', '2025-08-09 04:58:18'),
(58, 'Tukang Pijet', 20.00, 17, '2025-08-09 04:59:05', '2025-08-09 04:59:05'),
(59, 'Wirausahawan', 15.00, 17, '2025-08-09 04:59:24', '2025-08-09 04:59:24'),
(60, 'Pegawai BUMN?Swasta', 10.00, 17, '2025-08-09 04:59:49', '2025-08-09 04:59:49');

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
(1, 'Admin Linjamsos', 'admin@gmail.com', '2025-07-27 04:21:08', '$2y$12$HbFeH3EW/T2.yyBGhiBWLuwimmfY.exuQr9iLyhK8tx1y4rFcyyJ6', 'puUG0UOOq1dKpKsdzARa1D6lAZNHgiinFc289OJGRjP6cRBL12bsTUT62nFU', '2025-07-27 04:21:09', '2025-07-27 04:21:09');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nilai_utility`
--
ALTER TABLE `nilai_utility`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `normalisasi_bobot`
--
ALTER TABLE `normalisasi_bobot`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

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
