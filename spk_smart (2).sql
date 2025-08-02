-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2025 at 04:29 PM
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
  `alternatif` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id`, `kode`, `alternatif`, `keterangan`, `created_at`, `updated_at`) VALUES
(6, 'A00001', 'Keluarga Pak Andi', NULL, '2025-07-30 04:11:21', '2025-07-30 04:19:34'),
(7, 'A00002', 'Keluarga Pak Budi', NULL, '2025-07-30 04:11:36', '2025-07-30 04:19:48'),
(8, 'A00003', 'Keluarga Bu Citra', NULL, '2025-07-30 04:11:55', '2025-07-30 04:20:07');

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
('manda@gmail.com|127.0.0.1', 'i:1;', 1753898423),
('manda@gmail.com|127.0.0.1:timer', 'i:1753898423;', 1753898423);

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
  `kriteria` varchar(50) NOT NULL,
  `bobot` decimal(8,2) NOT NULL,
  `jenis_kriteria` enum('cost','benefit') NOT NULL DEFAULT 'benefit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `kode`, `kriteria`, `bobot`, `jenis_kriteria`, `created_at`, `updated_at`) VALUES
(1, 'K00001', 'Pendapatan', 40.00, 'cost', '2025-07-27 04:21:07', '2025-07-30 21:08:16'),
(2, 'K00002', 'Jumlah Tanggungan', 30.00, 'benefit', '2025-07-27 04:21:07', '2025-07-30 04:04:31'),
(3, 'K00003', 'Kondisi Rumah', 20.00, 'benefit', '2025-07-27 04:21:07', '2025-07-30 04:04:47'),
(5, 'K00005', 'Status Kepemilikan Rumah', 10.00, 'benefit', '2025-07-27 04:21:07', '2025-07-30 04:05:34');

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
(10, '2025_01_22_125659_create_nilai_akhirs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_akhir`
--

CREATE TABLE `nilai_akhir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif_id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_akhir`
--

INSERT INTO `nilai_akhir` (`id`, `alternatif_id`, `kriteria_id`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 0.4000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(2, 6, 2, 3.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(3, 6, 3, 2.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(4, 6, 5, 0.5500, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(5, 7, 1, 4.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(6, 7, 2, 0.3000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(7, 7, 3, 0.2000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(8, 7, 5, 0.1000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(9, 8, 1, 2.2000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(10, 8, 2, 1.6500, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(11, 8, 3, 0.2000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(12, 8, 5, 1.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01');

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
(1, 6, 1, 1.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(2, 6, 2, 10.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(3, 6, 3, 10.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(4, 6, 5, 5.5000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(5, 7, 1, 10.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(6, 7, 2, 1.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(7, 7, 3, 1.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(8, 7, 5, 1.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(9, 8, 1, 5.5000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(10, 8, 2, 5.5000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(11, 8, 3, 1.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(12, 8, 5, 10.0000, '2025-07-30 04:25:01', '2025-07-30 04:25:01');

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
(1, 1, 0.4000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(2, 2, 0.3000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(3, 3, 0.2000, '2025-07-30 04:25:01', '2025-07-30 04:25:01'),
(4, 5, 0.1000, '2025-07-30 04:25:01', '2025-07-30 04:25:01');

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
(26, 6, 1, 4, '2025-07-30 04:11:21', '2025-07-30 04:22:29'),
(27, 6, 2, 8, '2025-07-30 04:11:21', '2025-07-30 04:22:29'),
(28, 6, 3, 14, '2025-07-30 04:11:21', '2025-07-30 04:22:29'),
(29, 6, 5, 22, '2025-07-30 04:11:21', '2025-07-30 04:22:29'),
(30, 7, 1, 5, '2025-07-30 04:11:36', '2025-07-30 04:24:27'),
(31, 7, 2, 10, '2025-07-30 04:11:36', '2025-07-30 04:24:27'),
(32, 7, 3, 15, '2025-07-30 04:11:36', '2025-07-30 04:24:27'),
(33, 7, 5, 25, '2025-07-30 04:11:36', '2025-07-30 04:24:27'),
(34, 8, 1, 1, '2025-07-30 04:11:55', '2025-07-30 04:15:57'),
(35, 8, 2, 9, '2025-07-30 04:11:55', '2025-07-30 04:15:57'),
(36, 8, 3, 15, '2025-07-30 04:11:55', '2025-07-30 04:15:57'),
(37, 8, 5, 24, '2025-07-30 04:11:55', '2025-07-30 04:15:57');

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
('EPbjnKoeM6mrz07BhLtZ2Mm1oL9wjytcRvMVOphA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQXhtSWNPVHZSRWxRSGZWeGg1SFJCU2R0TGpxdjNMNk80OGFPcElDQyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3ViLWtyaXRlcmlhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1753938474),
('qiVug4Vcr1WzEdDbCMd8pnIL2Cm2eVc1YmYA20Dl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnFZbnZDQ21MZ1hCWmFKWGNKRThBaDJMeXdWUFV6T1VtdmROcHMwaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1754144838);

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
(1, 'Rp 1.000.000 - Rp 1.500.000', 3.00, 1, '2025-07-27 04:21:07', '2025-07-29 23:44:45'),
(2, '> Rp 2.000.000', 1.00, 1, '2025-07-27 04:21:07', '2025-07-29 23:45:49'),
(3, '< Rp 500.000', 5.00, 1, '2025-07-27 04:21:07', '2025-07-29 23:46:16'),
(4, 'Rp 500.000 - Rp 1.000.000', 4.00, 1, '2025-07-27 04:21:07', '2025-07-29 23:44:12'),
(5, 'Rp 1.500.000 - Rp 2.000.000', 2.00, 1, '2025-07-27 04:21:07', '2025-07-29 23:45:10'),
(6, '1-2 orang', 1.00, 2, '2025-07-27 04:21:07', '2025-07-29 23:46:36'),
(7, '3-4 orang', 2.00, 2, '2025-07-27 04:21:07', '2025-07-29 23:47:05'),
(8, '> 8 orang', 5.00, 2, '2025-07-27 04:21:07', '2025-07-29 23:47:56'),
(9, '7-8 orang', 4.00, 2, '2025-07-27 04:21:07', '2025-07-29 23:47:40'),
(10, '5-6 orang', 3.00, 2, '2025-07-27 04:21:07', '2025-07-29 23:47:25'),
(11, 'Sangat Layak', 1.00, 3, '2025-07-27 04:21:07', '2025-07-29 23:48:20'),
(14, 'Tidak Layak', 5.00, 3, '2025-07-27 04:21:07', '2025-07-29 23:49:35'),
(15, 'Cukup Layak', 3.00, 3, '2025-07-27 04:21:07', '2025-07-29 23:48:53'),
(22, 'Kontrak', 3.00, 5, '2025-07-27 04:21:07', '2025-07-30 04:08:01'),
(24, 'Menumpang', 5.00, 5, '2025-07-27 04:21:07', '2025-07-30 04:07:49'),
(25, 'Milik Sendiri', 1.00, 5, '2025-07-27 04:21:07', '2025-07-30 04:08:13');

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
(1, 'Admin Linjamsos', 'admin@gmail.com', '2025-07-27 04:21:08', '$2y$12$HbFeH3EW/T2.yyBGhiBWLuwimmfY.exuQr9iLyhK8tx1y4rFcyyJ6', 'JLcuanDf56ibP9SdpCEOfGDZ3NfIaMJSDMnvPtil5126tbRRaU34xkJObrzl', '2025-07-27 04:21:09', '2025-07-27 04:21:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alternatif_kode_unique` (`kode`);

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
  ADD KEY `penilaian_kriteria_id_foreign` (`kriteria_id`),
  ADD KEY `penilaian_sub_kriteria_id_foreign` (`sub_kriteria_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nilai_utility`
--
ALTER TABLE `nilai_utility`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `normalisasi_bobot`
--
ALTER TABLE `normalisasi_bobot`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  ADD CONSTRAINT `penilaian_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`),
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
