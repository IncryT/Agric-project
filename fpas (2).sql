-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2026 at 06:00 PM
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
-- Database: `fpas`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `market_prices`
--

CREATE TABLE `market_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `market_prices`
--

INSERT INTO `market_prices` (`id`, `product_id`, `date`, `price`, `created_at`, `updated_at`) VALUES
(139, 70, '2026-04-15', 5.00, '2026-04-15 14:23:00', '2026-04-15 17:31:00'),
(140, 71, '2026-04-15', 0.75, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(141, 72, '2026-04-15', 2.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(142, 73, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(143, 74, '2026-04-15', 2.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(144, 75, '2026-04-15', 2.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(145, 76, '2026-04-15', 7.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(146, 77, '2026-04-15', 20.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(147, 78, '2026-04-15', 2.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(148, 79, '2026-04-15', 1.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(149, 80, '2026-04-15', 15.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(150, 81, '2026-04-15', 2.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(151, 82, '2026-04-15', 2.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(152, 83, '2026-04-15', 9.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(153, 84, '2026-04-15', 3.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(154, 85, '2026-04-15', 12.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(155, 86, '2026-04-15', 18.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(156, 87, '2026-04-15', 12.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(157, 88, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(158, 89, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(159, 90, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(160, 91, '2026-04-15', 9.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(161, 92, '2026-04-15', 4.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(162, 93, '2026-04-15', 3.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(163, 94, '2026-04-15', 3.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(164, 95, '2026-04-15', 12.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(165, 96, '2026-04-15', 5.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(166, 97, '2026-04-15', 15.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(167, 98, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(168, 99, '2026-04-15', 38.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(169, 100, '2026-04-15', 5.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(170, 101, '2026-04-15', 1.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(171, 102, '2026-04-15', 75.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(172, 103, '2026-04-15', 18.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(173, 104, '2026-04-15', 8.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(174, 105, '2026-04-15', 3.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(175, 106, '2026-04-15', 4.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(176, 107, '2026-04-15', 18.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(177, 108, '2026-04-15', 15.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(178, 109, '2026-04-15', 12.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(179, 110, '2026-04-15', 35.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(180, 111, '2026-04-15', 5.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(181, 112, '2026-04-15', 4.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(182, 113, '2026-04-15', 7.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(183, 114, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(184, 115, '2026-04-15', 2.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(185, 116, '2026-04-15', 3.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(186, 117, '2026-04-15', 15.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(187, 118, '2026-04-15', 12.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(188, 119, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(189, 120, '2026-04-15', 9.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(190, 121, '2026-04-15', 8.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(191, 122, '2026-04-15', 4.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(192, 123, '2026-04-15', 2.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(193, 124, '2026-04-15', 3.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(194, 125, '2026-04-15', 7.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(195, 126, '2026-04-15', 12.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(196, 127, '2026-04-15', 4.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(197, 128, '2026-04-15', 25.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(198, 129, '2026-04-15', 8.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(199, 130, '2026-04-15', 20.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(200, 131, '2026-04-15', 13.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(201, 132, '2026-04-15', 0.05, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(202, 133, '2026-04-15', 4.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(203, 134, '2026-04-15', 20.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(204, 135, '2026-04-15', 3.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(205, 136, '2026-04-15', 10.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(206, 137, '2026-04-15', 2.50, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(207, 138, '2026-04-15', 18.00, '2026-04-15 14:23:00', '2026-04-15 14:23:00'),
(208, 70, '2026-04-16', 12.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(209, 71, '2026-04-16', 0.75, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(210, 72, '2026-04-16', 2.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(211, 73, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(212, 74, '2026-04-16', 2.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(213, 75, '2026-04-16', 2.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(214, 76, '2026-04-16', 7.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(215, 77, '2026-04-16', 20.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(216, 78, '2026-04-16', 2.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(217, 79, '2026-04-16', 1.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(218, 80, '2026-04-16', 15.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(219, 81, '2026-04-16', 2.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(220, 82, '2026-04-16', 2.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(221, 83, '2026-04-16', 9.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(222, 84, '2026-04-16', 3.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(223, 85, '2026-04-16', 12.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(224, 86, '2026-04-16', 18.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(225, 87, '2026-04-16', 12.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(226, 88, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(227, 89, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(228, 90, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(229, 91, '2026-04-16', 9.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(230, 92, '2026-04-16', 4.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(231, 93, '2026-04-16', 3.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(232, 94, '2026-04-16', 3.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(233, 95, '2026-04-16', 12.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(234, 96, '2026-04-16', 5.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(235, 97, '2026-04-16', 15.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(236, 98, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(237, 99, '2026-04-16', 38.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(238, 100, '2026-04-16', 5.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(239, 101, '2026-04-16', 1.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(240, 102, '2026-04-16', 75.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(241, 103, '2026-04-16', 18.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(242, 104, '2026-04-16', 8.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(243, 105, '2026-04-16', 3.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(244, 106, '2026-04-16', 4.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(245, 107, '2026-04-16', 18.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(246, 108, '2026-04-16', 15.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(247, 109, '2026-04-16', 12.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(248, 110, '2026-04-16', 35.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(249, 111, '2026-04-16', 5.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(250, 112, '2026-04-16', 4.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(251, 113, '2026-04-16', 7.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(252, 114, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(253, 115, '2026-04-16', 2.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(254, 116, '2026-04-16', 3.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(255, 117, '2026-04-16', 15.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(256, 118, '2026-04-16', 12.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(257, 119, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(258, 120, '2026-04-16', 9.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(259, 121, '2026-04-16', 8.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(260, 122, '2026-04-16', 4.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(261, 123, '2026-04-16', 2.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(262, 124, '2026-04-16', 3.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(263, 125, '2026-04-16', 7.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(264, 126, '2026-04-16', 12.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(265, 127, '2026-04-16', 4.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(266, 128, '2026-04-16', 25.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(267, 129, '2026-04-16', 8.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(268, 130, '2026-04-16', 20.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(269, 131, '2026-04-16', 13.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(270, 132, '2026-04-16', 0.05, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(271, 133, '2026-04-16', 4.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(272, 134, '2026-04-16', 20.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(273, 135, '2026-04-16', 3.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(274, 136, '2026-04-16', 10.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(275, 137, '2026-04-16', 2.50, '2026-04-16 13:55:00', '2026-04-16 13:55:00'),
(276, 138, '2026-04-16', 18.00, '2026-04-16 13:55:00', '2026-04-16 13:55:00');

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
(4, '2026_03_07_162408_create_products_table', 1),
(5, '2026_03_07_162409_create_market_prices_table', 1),
(6, '2026_03_07_162409_create_subscriptions_table', 1),
(7, '2026_03_07_162410_create_audit_logs_table', 1),
(8, '2026_04_13_172309_restructure_market_prices_table', 1),
(9, '2026_04_13_174032_create_system_settings_table', 2);

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit_of_measure` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `unit_of_measure`, `created_at`, `updated_at`, `deleted_at`) VALUES
(70, 'Apples', 'Box (12 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(71, 'Avocado', 'Fruit (Medium )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(72, 'Baby Marrow', 'Punnet or Kaylite (1 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(73, 'Banana', 'Crate (22 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(74, 'Beetroot', 'Bundle (1 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(75, 'Broccoli', 'Packet (1 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(76, 'Broilers', 'Bird (Live)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(77, 'Butternut', 'Pocket (10 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(78, 'Button Mushroom', 'Punnet or Kaylite (300g)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(79, 'Cabbage', 'Head (Large )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(80, 'Carrots', 'Punnet or Kaylite (400 g)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(81, 'Cauliflower', 'Packet (1 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(82, 'Chili Pepper', '5L Gallon (5 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(83, 'Cooked Dried Groundnuts', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(84, 'Covo', 'Bundle (6.5 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(85, 'Cucumber', '50kg Sack (60 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(86, 'Dehulled Traditional Rice', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(87, 'Dried Black Jack', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(88, 'Dried Cabbage', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(89, 'Dried Covo', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(90, 'Dried Cow Peas Leaves', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(91, 'Dried Maize', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(92, 'Eggs', 'Crate (Large )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(93, 'Garlic', 'Packet (1 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(94, 'Ginger', 'Packet (1 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(95, 'Green Beans', '50kg Sack (60 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(96, 'Green Maize', 'Dozen (Medium )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(97, 'Green Pepper', '50kg Sack (60 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(98, 'Guinea Fowl Hanga', 'Bird (Live)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(99, 'Kapenta Matemba', 'Bucket (10kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(100, 'Lemon', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(101, 'Lettuce', 'Head (Large )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(102, 'Mopane Worms Madora', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(103, 'White Sorghum Mapfunde', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(104, 'Sour Fruit Masawu', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(105, 'Snot Apple Matohwe', '5L Gallon (5 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(106, 'Baobab Fruit Mauyu', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(107, 'Pearl Millet Mhunga', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(108, 'Cooked Dried Maize Mumhare', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(109, 'Cow Peas Nyemba', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(110, 'Groundnuts Nzungu', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(111, 'Off Layers', 'Bird (Live)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(112, 'Okra', '5L Gallon (5 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(113, 'Onions', 'Pocket (10 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(114, 'Oranges', 'Pocket (3 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(115, 'Oyster Mushroom', 'Punnet or Kaylite (200 g)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(116, 'Pawpaw', 'Head (Large )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(117, 'Peas', '50kg Sack (60 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(118, 'Pineapples', 'Box (12 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(119, 'Popcorn', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(120, 'Large Potatoes', 'Pocket (15 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(121, 'Medium Potatoes', 'Pocket (15 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(122, 'Rape', 'Bundle (6.5 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(123, 'Pumpkins', 'Each (2.5kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(124, 'Red Pepper', 'Packet (1 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(125, 'Roadrunner Chickens', 'Bird (Live)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(126, 'Soya Beans', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(127, 'Strawberries', 'Punnet or Kaylite (200 g)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(128, 'Sugar Beans', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(129, 'Sugarcane', 'Bundle (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(130, 'Sweet Potatoes', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(131, 'Gogoya Taro', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(132, 'Tomatoes', 'Sandak (30 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(133, 'Tsunga', 'Bundle (6.5 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(134, 'Turkey', 'Bird (Live)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(135, 'Watermelon', 'Head (Large )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(136, 'Yams Madhumbe', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(137, 'Yellow Pepper', 'Packet (1 kg)', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(138, 'Finger Millet Zviyo', 'Bucket (20 kg )', '2026-04-15 14:23:00', '2026-04-15 14:23:00', NULL),
(139, 'LeonB', '10 kg', '2026-04-15 14:25:48', '2026-04-15 14:25:48', NULL);

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
('ErJckOjrP0SMWzj63EEF4ni726Zgnzoz9RzmY2N4', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaDU2emRZeHlDZHF6cDNrSmFzeU54UTVqY3NJdWVGZFYyeHFQU1FESyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9mYXJtZXJzIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5mYXJtZXJzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776354962),
('ZwRabGHBLlVNHLzR2qffJvTv9ELCbcmRE8IAkIAE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnpQNjVJVEUzblI4eUlEdWJUZEtUOGQ4T3NiNTBTU3NjWWoxbk5EaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1776290348);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `frequency` enum('daily_summary','on_demand') NOT NULL,
  `cop` decimal(10,2) UNSIGNED NOT NULL,
  `profit_margin` decimal(5,2) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `product_id`, `frequency`, `cop`, `profit_margin`, `created_at`, `updated_at`) VALUES
(1, 2, 70, 'on_demand', 2.00, 1.00, '2026-04-15 18:16:03', '2026-04-15 18:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `key`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'last_scrape_time', '2026-04-16 15:55:00', NULL, '2026-04-13 15:41:17', '2026-04-16 13:55:00'),
(2, 'last_scrape_count', '74', NULL, '2026-04-13 15:41:17', '2026-04-13 15:41:17'),
(3, 'scrape_schedule_time', '17:55', NULL, '2026-04-13 16:22:14', '2026-04-16 13:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` enum('admin','farmer') NOT NULL DEFAULT 'farmer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', 'admin@fpas.com', NULL, 'admin', '2026-04-13 15:35:31', '$2y$12$lMp4PWl10z5twZUP3XP9E.3RtafMTF4Ua3k2amy708mzj879Eb1da', NULL, '2026-04-13 15:35:31', '2026-04-13 15:35:31'),
(2, 'Test Farmer1', 'farmer@fpas.com', '+27831234567', 'farmer', '2026-04-13 15:35:31', '$2y$12$OMitWLQfHJZKgDxGxG2mgurAEUYOcjAnyPyKKIZ2tSsHX.GeS50/a', NULL, '2026-04-13 15:35:31', '2026-04-15 18:19:21'),
(3, 'farmer2', 'test@famer.co.za', '0717214834', 'farmer', NULL, '$2y$12$QAk9fNOT5qenzOQvjEcBqeIubcDhzm5ym1pFA9.3U4XgPwO5pOcxy', NULL, '2026-04-15 19:41:24', '2026-04-15 19:41:24'),
(4, 'farmer 3', 'farmer3@farmer.co.za', '0717214835', 'farmer', NULL, '$2y$12$Dpw3EucXBu2v/SwMOpc3n.aw2WdI0vIQCVP9GBNZ/g.tab6WCprsW', NULL, '2026-04-15 19:47:58', '2026-04-15 19:47:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

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
-- Indexes for table `market_prices`
--
ALTER TABLE `market_prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `market_prices_product_id_date_unique` (`product_id`,`date`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_product_id_foreign` (`product_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_settings_key_unique` (`key`);

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
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `market_prices`
--
ALTER TABLE `market_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `market_prices`
--
ALTER TABLE `market_prices`
  ADD CONSTRAINT `market_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
