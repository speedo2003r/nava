-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2022 at 11:32 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nava`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_reports`
--

CREATE TABLE `admin_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `assign_deadline` int NOT NULL DEFAULT '0',
  `city_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `title`, `assign_deadline`, `city_id`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0627\\u0644\\u0641\\u0631\\u0639 \\u0627\\u0644\\u0627\\u0648\\u0644\",\"en\":\"branch1\",\"ur\":\"\\u0627\\u0644\\u0641\\u0631\\u0639 \\u0627\\u0644\\u0627\\u0648\\u0644\"}', 0, 1, '2021-10-05 10:49:46', NULL),
(2, '{\"ar\":\"\\u0627\\u0644\\u0641\\u0631\\u0639 \\u0627\\u0644\\u062a\\u0627\\u0646\\u064a\",\"en\":\"second branch\",\"ur\":\"\\u0627\\u0644\\u0641\\u0631\\u0639 \\u0627\\u0644\\u062a\\u0627\\u0646\\u064a\"}', 0, 2, '2021-10-10 11:23:08', NULL),
(3, '{\"ar\":\"\\u0627\\u0644\\u0641\\u0631\\u0639 \\u0627\\u0644\\u062a\\u0627\\u0644\\u062a\",\"en\":\"tabok\",\"ur\":\"\\u0627\\u0644\\u0641\\u0631\\u0639 \\u0627\\u0644\\u062a\\u0627\\u0644\\u062a\"}', 0, 3, '2021-10-10 11:23:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch_regions`
--

CREATE TABLE `branch_regions` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `region_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_regions`
--

INSERT INTO `branch_regions` (`id`, `branch_id`, `region_id`) VALUES
(1, 1, 1),
(3, 2, 3),
(4, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guarantee_days` int NOT NULL DEFAULT '0' COMMENT 'عدد أيام الضمان',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `icon`, `guarantee_days`, `parent_id`, `status`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0643\\u0647\\u0631\\u0628\\u0627\\u0621\",\"en\":\"Electricity\",\"ur\":\"\\u0643\\u0647\\u0631\\u0628\\u0627\"}', '16402730605340376.png', 30, NULL, 1, '2021-09-21 22:10:03', NULL),
(2, '{\"ar\":\"\\u0627\\u0646\\u0627\\u0631\\u0647\",\"en\":\"lighting\"}', '16404406966181930.png', 0, 1, 1, '2021-09-21 22:10:33', NULL),
(3, '{\"ar\":\"\\u062f\\u0647\\u0627\\u0646\\u0627\\u062a\",\"en\":\"paints\",\"ur\":\"\\u067e\\u06cc\\u0646\\u0679\"}', '16368081842621618.png', 30, NULL, 1, '2021-10-10 11:06:44', '2021-11-21 17:14:08'),
(4, '{\"ar\":\"\\u0633\\u0628\\u0627\\u0643\\u0647\",\"en\":\"plumber\",\"ur\":\"\\u067e\\u0644\\u0645\\u0628\\u0631\"}', '16338604616501490.png', 30, NULL, 1, '2021-10-10 11:07:41', '2021-11-21 17:14:37'),
(5, '{\"ar\":\"\\u0646\\u062c\\u0627\\u0631\\u0647\",\"en\":\"Carpentry\",\"ur\":\"\\u0628\\u0691\\u06be\\u0626\\u06cc\"}', '16338605017934484.png', 30, NULL, 1, '2021-10-10 11:08:21', '2021-11-21 17:14:44'),
(6, '{\"ar\":\"\\u062a\\u0628\\u0631\\u064a\\u062f \\u0648\\u062a\\u0643\\u064a\\u064a\\u0641\",\"en\":\"Refrigeration & Air Conditioning\",\"ur\":\"\\u0631\\u06cc\\u0641\\u0631\\u06cc\\u062c\\u0631\\u06cc\\u0634\\u0646 \\u0627\\u0648\\u0631 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u06af\"}', '16338605458669760.png', 30, NULL, 1, '2021-10-10 11:09:05', '2021-11-21 17:14:49'),
(7, '{\"ar\":\"\\u0627\\u0646\\u062a\\u0631\\u0646\\u062a \\u0648\\u0634\\u0628\\u0643\\u0627\\u062a\",\"en\":\"Internet and networks\",\"ur\":\"\\u0627\\u0646\\u0679\\u0631\\u0646\\u06cc\\u0679 \\u0627\\u0648\\u0631 \\u0646\\u06cc\\u0679 \\u0648\\u0631\\u06a9\\u0633\\u06d4\"}', '16338605783787408.png', 30, NULL, 1, '2021-10-10 11:09:38', '2021-11-21 17:14:53'),
(8, '{\"ar\":\"\\u0643\\u0627\\u0645\\u064a\\u0631\\u0627\\u062a \\u0645\\u0631\\u0627\\u0642\\u0628\\u0629\",\"en\":\"security cameras\",\"ur\":\"\\u0633\\u06cc\\u06a9\\u0648\\u0631\\u0679\\u06cc \\u06a9\\u06cc\\u0645\\u0631\\u06d2\"}', '16338606236881022.png', 30, NULL, 1, '2021-10-10 11:10:23', '2021-11-21 17:14:56'),
(9, '{\"ar\":\"\\u0645\\u0641\\u0627\\u062a\\u064a\\u062d \\u0648 \\u0627\\u0641\\u064a\\u0627\\u0634 \\u0627\\u0644\\u0643\\u0647\\u0631\\u0628\\u0627\\u0621\",\"en\":\"Electrical Switches and keys\"}', '16405196602595213.png', 0, 1, 1, '2021-10-10 11:11:45', NULL),
(10, '{\"ar\":\"\\u0637\\u0628\\u0644\\u0648\\u0646\",\"en\":\"Main Electrical Panel\"}', '16405195802464188.png', 0, 1, 1, '2021-10-10 11:12:22', NULL),
(11, '{\"ar\":\"\\u062f\\u0647\\u0627\\u0646\\u0627\\u062a\",\"en\":\"paints\"}', '16338607802969550.png', 0, 3, 1, '2021-10-10 11:13:00', NULL),
(12, '{\"ar\":\"\\u0627\\u0635\\u0644\\u0627\\u062d \\u062d\\u0646\\u0641\\u064a\\u0627\\u062a\",\"en\":\"faucets repair\"}', '16338608164840019.png', 0, 4, 1, '2021-10-10 11:13:36', NULL),
(13, '{\"ar\":\"\\u0627\\u062c\\u0631\\u0627\\u0633\",\"en\":\"Door Bells\"}', '16404406465445233.png', 0, 1, 1, '2021-10-25 16:17:10', NULL),
(14, '{\"ar\":\"\\u0627\\u0644\\u0646\\u0638\\u0627\\u0641\\u0629\",\"en\":\"cleaning\",\"ur\":\"cleaning\"}', '16368065738840291.png', 30, NULL, 1, '2021-11-08 13:31:41', '2021-11-21 17:15:01'),
(15, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0634\\u0642\\u0629\",\"en\":\"apartement\"}', '16368072867084450.jpeg', 0, 14, 1, '2021-11-08 13:32:30', NULL),
(16, '{\"ar\":\"\\u0633\\u0628\\u0627\\u0643\\u0629\",\"en\":\"Plumbing\",\"ur\":\"Plumbing\"}', '16402730516214584.png', 30, NULL, 1, '2021-11-21 17:16:16', NULL),
(17, '{\"ar\":\"\\u0627\\u0644\\u0645\\u0637\\u0628\\u062e\",\"en\":\"Kitchen\"}', NULL, 0, 16, 1, '2021-11-21 17:18:21', '2021-12-08 12:45:54'),
(18, '{\"ar\":\"\\u062a\\u0643\\u064a\\u064a\\u0641\",\"en\":\"Air Conditioner\",\"ur\":\"\\u0627\\u06d2 \\u0633\\u06cc\"}', '16402730697576771.png', 30, NULL, 1, '2021-11-21 17:23:45', NULL),
(19, '{\"ar\":\"\\u0645\\u0643\\u064a\\u0641 \\u0633\\u0628\\u0644\\u064a\\u062a\",\"en\":\"Split air conditioner\"}', '16405183196749087.png', 0, 18, 1, '2021-11-21 17:24:40', NULL),
(20, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629\",\"en\":\"Cleaning\",\"ur\":\"\\u0635\\u0641\\u0627\\u0626\\u064a\"}', '16402730775354995.png', 30, NULL, 1, '2021-11-21 17:27:58', NULL),
(21, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0639\\u0645\\u064a\\u0642\\u0629\",\"en\":\"Deep Cleaning\"}', '16405199343093476.png', 0, 20, 1, '2021-11-21 17:29:34', NULL),
(22, '{\"ar\":\"\\u062a\\u0645\\u062f\\u064a\\u062f\\u0627\\u062a \\u0643\\u0647\\u0631\\u0628\\u0627\\u0626\\u064a\\u0647\",\"en\":\"Electrical Extensions\"}', '16405196135524289.png', 0, 1, 1, '2021-12-07 16:13:09', NULL),
(23, '{\"ar\":\"\\u0645\\u0631\\u0627\\u0648\\u062d \\u0627\\u0644\\u0634\\u0641\\u0637\",\"en\":\"Exhaust Fans\"}', '16405181089496511.png', 0, 1, 1, '2021-12-07 16:14:17', NULL),
(24, '{\"ar\":\"\\u062f\\u0648\\u0631\\u0627\\u062a \\u0627\\u0644\\u0645\\u064a\\u0627\\u0647\",\"en\":\"Toilets\"}', '16405181514414090.png', 0, 16, 1, '2021-12-08 12:47:41', NULL),
(25, '{\"ar\":\"\\u0645\\u062c\\u0627\\u0631\\u064a \\u0648\\u0627\\u0644\\u0627\\u0646\\u0633\\u062f\\u0627\\u062f\\u0627\\u062a\",\"en\":\"Drain and Blockages\"}', '16405197337127507.png', 0, 16, 1, '2021-12-08 12:49:10', NULL),
(26, '{\"ar\":\"\\u062f\\u064a\\u0646\\u0645\\u0648  \\u0648 \\u062e\\u0632\\u0627\\u0646\\u0627\\u062a\",\"en\":\"Water Motor and Tanks\"}', '16405197565868251.png', 0, 16, 1, '2021-12-08 12:50:23', NULL),
(27, '{\"ar\":\"\\u062a\\u0645\\u062f\\u064a\\u062f\\u0627\\u062a \\u0627\\u0644\\u0633\\u0628\\u0627\\u0643\\u0629\",\"en\":\"Plumber Extensions\"}', '16405206237412796.png', 0, 16, 1, '2021-12-08 12:52:43', NULL),
(28, '{\"ar\":\"\\u0633\\u062e\\u0627\\u0646 \\u0627\\u0644\\u0645\\u064a\\u0627\\u0647\",\"en\":\"Water Heater\"}', '16405182219271137.png', 0, 16, 1, '2021-12-08 12:54:16', NULL),
(29, '{\"ar\":\"\\u0645\\u063a\\u0627\\u0633\\u0644\",\"en\":\"Wash basins\"}', '16405182437612772.png', 0, 16, 1, '2021-12-08 12:58:54', NULL),
(30, '{\"ar\":\"\\u0643\\u0634\\u0641 \\u0648 \\u0627\\u0635\\u0644\\u0627\\u062d \\u0627\\u0644\\u062a\\u0633\\u0631\\u064a\\u0628\\u0627\\u062a\",\"en\":\"Leak detection and repair\"}', '16405206062153641.png', 0, 16, 1, '2021-12-08 13:00:45', NULL),
(31, '{\"ar\":\"\\u0634\\u0642\\u0629\",\"en\":\"Apartment\"}', '16405199906019061.png', 0, 20, 1, '2021-12-08 17:11:09', NULL),
(32, '{\"ar\":\"\\u0641\\u064a\\u0644\\u0627\",\"en\":\"Villa\"}', '16405200154510492.png', 0, 20, 1, '2021-12-08 17:18:32', NULL),
(33, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0639\\u0627\\u0645\\u0629\",\"en\":\"Normal Cleaning\"}', '16405199557116909.png', 0, 20, 1, '2021-12-08 17:22:29', NULL),
(34, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u0645\",\"en\":\"Sanitization\"}', '16405183601175537.png', 0, 20, 1, '2021-12-08 17:26:27', NULL),
(35, '{\"ar\":\"\\u0645\\u0643\\u064a\\u0641 \\u0634\\u0628\\u0627\\u0643\",\"en\":\"Window AC\"}', '16405182851091216.png', 0, 18, 1, '2021-12-14 13:24:56', NULL),
(36, '{\"ar\":\"\\u0641\\u0643 \\u0648 \\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0644\\u0645\\u0643\\u064a\\u064a\\u0641\",\"en\":\"Dismantling and installing the air conditioner\"}', '16405198644655777.png', 0, 18, 1, '2021-12-14 13:41:05', NULL),
(37, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u0645\",\"en\":\"Sanitization\",\"ur\":\"\\u0633\\u064a\\u0646\\u064a\\u062a\\u0627\\u064a\\u0632\"}', '16420821975255744.png', 0, NULL, 1, '2022-01-09 13:47:05', NULL),
(38, '{\"ar\":\"\\u0645\\u0628\\u064a\\u062f\\u0627\\u062a \\u062d\\u0634\\u0631\\u064a\\u0629\",\"en\":\"Pest Control\",\"ur\":\"\\u06a9\\u06cc\\u0691\\u0648\\u06ba \\u067e\\u0631 \\u0642\\u0627\\u0628\\u0648\"}', NULL, 0, NULL, 1, '2022-01-09 13:48:13', NULL),
(39, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u0645 \\u0634\\u0642\\u0629\",\"en\":\"Flat Sanitation\"}', NULL, 0, 37, 1, '2022-01-13 13:56:20', NULL),
(40, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u0645 \\u0641\\u064a\\u0644\\u0627\",\"en\":\"Villa Sanitation\"}', NULL, 0, 37, 1, '2022-01-13 13:56:52', NULL),
(41, '{\"ar\":\"\\u0634\\u0642\\u0629\",\"en\":\"Flat\"}', NULL, 0, 38, 1, '2022-01-13 13:57:21', NULL),
(42, '{\"ar\":\"\\u0641\\u064a\\u0644\\u0627\",\"en\":\"Villa\"}', NULL, 0, 38, 1, '2022-01-13 13:57:50', NULL),
(43, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u0645 \\u0639\\u0627\\u0645\\u0629\",\"en\":\"Normal Sanitation\"}', NULL, 0, 37, 1, '2022-01-13 14:02:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `country_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `title`, `country_id`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0627\\u0644\\u0631\\u064a\\u0627\\u0636\",\"en\":\"alriyad\",\"ordu\":\"\\u0627\\u0644\\u0631\\u064a\\u0627\\u0636\"}', 1, '2021-09-07 08:38:33', NULL),
(2, '{\"ar\":\"\\u062c\\u062f\\u0647\",\"en\":\"jedah\",\"ur\":\"\\u062c\\u062f\\u0647\"}', 1, '2021-10-10 11:20:27', NULL),
(3, '{\"ar\":\"\\u062a\\u0628\\u0648\\u0643\",\"en\":\"tabok\",\"ur\":\"\\u062a\\u0628\\u0648\\u0643\"}', 1, '2021-10-10 11:20:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `manager_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'رقم البطاقه',
  `commercial_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'حساب بنكي',
  `commercial_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'سجل الشركه التجاري',
  `tax_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'الشهاده الضريبيه',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `manager_name`, `id_number`, `commercial_num`, `acc_bank`, `commercial_image`, `tax_certificate`, `user_id`, `created_at`, `deleted_at`) VALUES
(1, 'شركة العريفي', '4324234', NULL, '324234234', NULL, NULL, 17, '2021-10-27 19:44:37', NULL),
(2, 'محمد طلعت', '123123123123123', NULL, '123123123123123123', NULL, NULL, 25, '2021-11-27 22:14:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `seen` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `title`, `code`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0627\\u0644\\u0633\\u0639\\u0648\\u062f\\u064a\\u0647\",\"en\":\"saudi arabia\"}', NULL, '2021-08-18 10:52:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `kind` enum('percent','fixed') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double(9,2) DEFAULT NULL,
  `max_use` int DEFAULT NULL,
  `count` int NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guarantee_visits`
--

CREATE TABLE `guarantee_visits` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `order_guarantee_id` bigint UNSIGNED DEFAULT NULL,
  `technician_id` bigint UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_id` bigint UNSIGNED NOT NULL,
  `media_type` enum('image','video','audio') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `income` double(8,2) NOT NULL DEFAULT '0.00',
  `debtor` double(8,2) NOT NULL DEFAULT '0.00',
  `creditor` double(8,2) NOT NULL DEFAULT '0.00',
  `status` tinyint NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'credit',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`id`, `name`, `lang`, `deleted_at`, `created_at`) VALUES
(1, 'العربيه', 'ar', NULL, '2021-08-18 10:33:41'),
(2, 'english', 'en', NULL, '2021-08-18 10:33:41'),
(3, 'أوردو', 'ur', NULL, '2021-08-20 16:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_notifications`
--

CREATE TABLE `message_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `message_id` bigint UNSIGNED DEFAULT NULL,
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `is_seen` int NOT NULL DEFAULT '0',
  `is_sender` int NOT NULL DEFAULT '0',
  `flagged` int NOT NULL DEFAULT '0',
  `is_delete` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_09_30_203844_create_langs_table', 1),
(2, '2012_09_31_203844_create_roles_table', 1),
(3, '2014_02_27_122602_create_countries_table', 1),
(4, '2014_02_27_122634_create_cities_table', 1),
(5, '2014_02_27_122635_create_regions_table', 1),
(6, '2014_09_27_115147_create_categories_table', 1),
(7, '2014_10_11_145823_create_admin_reports_table', 1),
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_resets_table', 1),
(10, '2014_10_26_122635_create_companies_table', 1),
(11, '2014_10_27_122635_create_technicians_table', 1),
(12, '2014_10_28_122635_create_branches_table', 1),
(13, '2014_10_29_122635_create_branch_regions_table', 1),
(14, '2014_10_30_122635_create_users_branches_table', 1),
(15, '2014_11_30_122635_create_user_categories_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2019_10_27_100945_create_rooms_table', 1),
(18, '2019_10_27_101529_create_room_users_table', 1),
(19, '2019_10_27_101912_create_messages_table', 1),
(20, '2019_10_27_102219_create_message_notifications_table', 1),
(21, '2020_10_31_203224_create_permissions_table', 1),
(22, '2020_12_14_205024_create_visits_table', 1),
(23, '2021_02_27_114644_create_jobs_table', 1),
(24, '2021_02_27_114807_create_pages_table', 1),
(25, '2021_02_27_114912_create_devices_table', 1),
(26, '2021_02_27_114958_create_notifications_table', 1),
(27, '2021_02_27_115135_create_images_table', 1),
(28, '2021_02_27_115201_create_contacts_table', 1),
(29, '2021_02_27_115205_create_coupons_table', 1),
(30, '2021_02_27_115237_create_settings_table', 1),
(31, '2021_02_27_115247_create_services_table', 1),
(32, '2021_02_27_115247_create_sliders_table', 1),
(33, '2021_02_27_115250_create_parts_table', 1),
(34, '2021_02_27_115303_create_orders_table', 1),
(35, '2021_02_27_115314_create_order_bills_table', 1),
(36, '2021_02_27_115314_create_order_parts_bills_table', 1),
(37, '2021_02_27_115314_create_order_services_bills_table', 1),
(38, '2021_02_27_115314_create_socials_table', 1),
(39, '2021_02_27_115343_create_review_rates_table', 1),
(40, '2021_02_28_115314_create_user_socials_table', 1),
(41, '2021_02_28_174332_create_refuse_orders_table', 1),
(42, '2021_03_23_220144_create_questions_table', 1),
(44, '2021_10_28_120712_create_table_complaints', 1),
(45, '2021_10_28_120712_create_incomes_table', 2),
(46, '2021_02_28_115314_create_order_technicians_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `to_id` bigint UNSIGNED NOT NULL,
  `from_id` bigint UNSIGNED NOT NULL,
  `message_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_num` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `technician_id` bigint UNSIGNED DEFAULT NULL,
  `city_id` bigint UNSIGNED DEFAULT NULL,
  `region_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `total_services` int NOT NULL DEFAULT '0',
  `coupon_id` bigint UNSIGNED DEFAULT NULL,
  `coupon_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_amount` double(9,2) NOT NULL DEFAULT '0.00',
  `vat_per` double(9,2) NOT NULL DEFAULT '0.00',
  `vat_amount` double(9,2) NOT NULL DEFAULT '0.00',
  `final_total` double(9,2) NOT NULL DEFAULT '0.00',
  `status` enum('created','accepted','on-way','arrived','in-progress','finished','user_cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'created',
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `canceled_by` bigint UNSIGNED DEFAULT NULL,
  `payment_method` enum('balance','cod') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_type` enum('cash','visa','master','apple','stc','wallet','mada') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_status` enum('pending','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `pay_data` json DEFAULT NULL,
  `lat` double(15,8) NOT NULL DEFAULT '24.68773000',
  `lng` double(15,8) NOT NULL DEFAULT '46.72185000',
  `map_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'الرياض',
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_notes` text COLLATE utf8mb4_unicode_ci,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_date` timestamp NULL DEFAULT NULL,
  `estimated_time` int NOT NULL DEFAULT '0',
  `progress_start` int NOT NULL DEFAULT '0',
  `progress_time` int NOT NULL DEFAULT '0',
  `progress_end` timestamp NULL DEFAULT NULL,
  `progress_type` enum('progress','finish') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'progress',
  `live` int NOT NULL DEFAULT '0',
  `oper_notes` text COLLATE utf8mb4_unicode_ci,
  `user_delete` tinyint(1) NOT NULL DEFAULT '0',
  `provider_delete` tinyint(1) NOT NULL DEFAULT '0',
  `admin_delete` tinyint(1) NOT NULL DEFAULT '0',
  `increased_price` double(8,2) NOT NULL DEFAULT '0.00',
  `increase_tax` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_bills`
--

CREATE TABLE `order_bills` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `price` double(8,2) DEFAULT NULL,
  `vat_per` double(9,2) NOT NULL DEFAULT '0.00',
  `vat_amount` double(9,2) NOT NULL DEFAULT '0.00',
  `payment_method` enum('balance','cod') COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_id` bigint UNSIGNED DEFAULT NULL,
  `coupon_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `pay_type` enum('cash','visa','master','apple','stc','wallet') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_status` enum('pending','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `pay_data` json DEFAULT NULL,
  `type` enum('service','parts') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `refuse_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_guarantees`
--

CREATE TABLE `order_guarantees` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `technical_id` bigint UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `solved` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_parts`
--

CREATE TABLE `order_parts` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `count` int NOT NULL DEFAULT '0',
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_parts_bills`
--

CREATE TABLE `order_parts_bills` (
  `id` bigint UNSIGNED NOT NULL,
  `order_bill_id` bigint UNSIGNED NOT NULL,
  `order_part_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_services`
--

CREATE TABLE `order_services` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `count` int NOT NULL DEFAULT '1',
  `preview_request` tinyint NOT NULL DEFAULT '0',
  `price` double(8,2) DEFAULT NULL,
  `tax` double(8,2) DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `type` enum('fixed','pricing') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_services_bills`
--

CREATE TABLE `order_services_bills` (
  `id` bigint UNSIGNED NOT NULL,
  `order_bill_id` bigint UNSIGNED NOT NULL,
  `order_service_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_technicians`
--

CREATE TABLE `order_technicians` (
  `id` bigint UNSIGNED NOT NULL,
  `technician_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `desc`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0639\\u0646\\u0627\",\"en\":\"about us\"}', '{\"ar\":\"\\u062a\\u0637\\u0628\\u064a\\u0642 \\u0646\\u0627\\u0641\\u0627 \\u0647\\u0648 \\u0627\\u0644\\u0627\\u0648\\u0644 \\u0641\\u064a \\u0627\\u0644\\u0645\\u0645\\u0644\\u0643\\u0629 \\u0627\\u0644\\u0639\\u0631\\u0628\\u064a\\u0629 \\u0627\\u0644\\u0633\\u0639\\u0648\\u062f\\u064a\\u0629 \\u0627\\u0644\\u0630\\u064a \\u064a\\u0642\\u062f\\u0645 \\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u0627\\u0639\\u0645\\u0627\\u0644 \\u0627\\u0644\\u0645\\u0646\\u0632\\u0644\\u064a\\u0647 \\u0628\\u0634\\u0643\\u0644 \\u0645\\u0646\\u062a\\u0638\\u0645 \\u0648 \\u0628\\u0633\\u064a\\u0637 \\u0648 \\u0628\\u0627\\u0642\\u0644 \\u062a\\u0643\\u0627\\u0644\\u064a\\u0641\",\"en\":\"NAFA is the first in the Kingdom of Saudi Arabia that provides home business services on a regular basis, simple and at the lowest costs\"}', '2021-10-05 11:04:52', NULL),
(2, '{\"ar\":\"\\u0627\\u0644\\u0634\\u0631\\u0648\\u0637 \\u0648\\u0627\\u0644\\u0623\\u062d\\u0643\\u0627\\u0645\",\"en\":\"Policy\"}', '{\"ar\":\"\\u0627\\u0644\\u0634\\u0631\\u0648\\u0637 \\u0648\\u0627\\u0644\\u0623\\u062d\\u0643\\u0627\\u0645 \\u0627\\u0644\\u062e\\u0627\\u0635\\u0629 \\u0628\\u062a\\u0637\\u0628\\u064a\\u0642 \\u0646\\u0627\\u0641\\u0627\\r\\n\\u0627\\u0644\\u0623\\u0633\\u0639\\u0627\\u0631 \\u0627\\u0644\\u0645\\u0630\\u0643\\u0648\\u0631\\u0629 \\u0623\\u0639\\u0644\\u0627\\u0647 \\u0644\\u0627 \\u062a\\u0634\\u0645\\u0644 \\u0636\\u0631\\u064a\\u0628\\u0629 \\u0627\\u0644\\u0642\\u064a\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0636\\u0627\\u0641\\u0629 \\u0648\\u062a\\u0634\\u0645\\u0644 \\u062a\\u0643\\u0644\\u0641\\u0629\\r\\n, \\u0627\\u0644\\u0639\\u0645\\u0627\\u0644\\u0629 \\u0641\\u0642\\u0637 , \\u0625\\u0630\\u0627 \\u0643\\u0627\\u0646 \\u0647\\u0646\\u0627\\u0643 \\u0645\\u0632\\u064a\\u062f \\u0645\\u0646 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0623\\u0648 \\u0627\\u0644\\u0645\\u0648\\u0627\\u062f \\u0627\\u0644\\u0645\\u0637\\u0644\\u0648\\u0628\\u0629\\r\\n, \\u0641\\u0633\\u064a\\u062a\\u0645 \\u062a\\u062d\\u0631\\u064a\\u0631 \\u0641\\u0648\\u0627\\u062a\\u064a\\u0631 \\u0628\\u0647\\u0627 \\u0628\\u0634\\u0643\\u0644 \\u0645\\u0646\\u0641\\u0635\\u0644\\r\\n\\u0636\\u0645\\u0627\\u0646 30 \\u064a\\u0648\\u0645 \\u0639\\u0644\\u064a \\u0627\\u0644\\u0639\\u0645\\u0644\",\"en\":\"The above prices do not include VAT and include cost\\r\\n, Labor only, if there is more work or materials required\\r\\n, It will be billed separately\\r\\n30 day work guarantee\"}', '2021-10-05 11:04:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `service_id` bigint UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`, `role_id`, `created_at`, `deleted_at`) VALUES
(664, 'admin.dashboard', 2, '2021-10-27 19:21:33', NULL),
(665, 'admin.financial', 2, '2021-10-27 19:21:33', NULL),
(666, 'admin.settings.index', 2, '2021-10-27 19:21:33', NULL),
(667, 'admin.settings.update', 2, '2021-10-27 19:21:33', NULL),
(668, 'admin.socials.store', 2, '2021-10-27 19:21:33', NULL),
(669, 'admin.socials.update', 2, '2021-10-27 19:21:33', NULL),
(670, 'admin.admin.statistics', 2, '2021-10-27 19:21:33', NULL),
(671, 'admin.statistics.visits', 2, '2021-10-27 19:21:33', NULL),
(672, 'admin.statistics.almostOrder', 2, '2021-10-27 19:21:33', NULL),
(673, 'admin.statistics.getdata', 2, '2021-10-27 19:21:33', NULL),
(674, 'admin.country', 2, '2021-10-27 19:21:33', NULL),
(675, 'admin.countries.index', 2, '2021-10-27 19:21:33', NULL),
(676, 'admin.countries.store', 2, '2021-10-27 19:21:33', NULL),
(677, 'admin.countries.update', 2, '2021-10-27 19:21:33', NULL),
(678, 'admin.countries.destroy', 2, '2021-10-27 19:21:33', NULL),
(679, 'admin.cities.index', 2, '2021-10-27 19:21:33', NULL),
(680, 'admin.cities.store', 2, '2021-10-27 19:21:33', NULL),
(681, 'admin.cities.update', 2, '2021-10-27 19:21:33', NULL),
(682, 'admin.cities.destroy', 2, '2021-10-27 19:21:33', NULL),
(683, 'admin.regions.index', 2, '2021-10-27 19:21:33', NULL),
(684, 'admin.regions.store', 2, '2021-10-27 19:21:33', NULL),
(685, 'admin.regions.update', 2, '2021-10-27 19:21:33', NULL),
(686, 'admin.regions.destroy', 2, '2021-10-27 19:21:33', NULL),
(687, 'admin.branches.index', 2, '2021-10-27 19:21:33', NULL),
(688, 'admin.branches.create', 2, '2021-10-27 19:21:33', NULL),
(689, 'admin.branches.store', 2, '2021-10-27 19:21:33', NULL),
(690, 'admin.branches.edit', 2, '2021-10-27 19:21:33', NULL),
(691, 'admin.branches.update', 2, '2021-10-27 19:21:33', NULL),
(692, 'admin.branches.destroy', 2, '2021-10-27 19:21:33', NULL),
(693, 'admin.categories.index', 2, '2021-10-27 19:21:33', NULL),
(694, 'admin.categories.index', 2, '2021-10-27 19:21:33', NULL),
(695, 'admin.categories.view', 2, '2021-10-27 19:21:33', NULL),
(696, 'admin.categories.store', 2, '2021-10-27 19:21:33', NULL),
(697, 'admin.categories.update', 2, '2021-10-27 19:21:33', NULL),
(698, 'admin.categories.destroy', 2, '2021-10-27 19:21:33', NULL),
(699, 'admin.subcategories.index', 2, '2021-10-27 19:21:33', NULL),
(700, 'admin.subcategories.store', 2, '2021-10-27 19:21:33', NULL),
(701, 'admin.subcategories.update', 2, '2021-10-27 19:21:33', NULL),
(702, 'admin.subcategories.destroy', 2, '2021-10-27 19:21:33', NULL),
(703, 'admin.categories.changeCategoryAppear', 2, '2021-10-27 19:21:33', NULL),
(704, 'admin.services.index', 2, '2021-10-27 19:21:33', NULL),
(705, 'admin.services.getFilterData', 2, '2021-10-27 19:21:33', NULL),
(706, 'admin.services.store', 2, '2021-10-27 19:21:33', NULL),
(707, 'admin.services.update', 2, '2021-10-27 19:21:33', NULL),
(708, 'admin.services.destroy', 2, '2021-10-27 19:21:33', NULL),
(709, 'admin.services.changeStatus', 2, '2021-10-27 19:21:33', NULL),
(710, 'admin.orders.index', 2, '2021-10-27 19:21:33', NULL),
(711, 'admin.orders.show', 2, '2021-10-27 19:21:33', NULL),
(712, 'admin.orders.assignTech', 2, '2021-10-27 19:21:33', NULL),
(713, 'admin.orders.servicesUpdate', 2, '2021-10-27 19:21:33', NULL),
(714, 'admin.orders.partsDestroy', 2, '2021-10-27 19:21:33', NULL),
(715, 'admin.orders.rejectOrder', 2, '2021-10-27 19:21:33', NULL),
(716, 'admin.orders.destroy', 2, '2021-10-27 19:21:33', NULL),
(717, 'admin.sliders.index', 2, '2021-10-27 19:21:33', NULL),
(718, 'admin.sliders.index', 2, '2021-10-27 19:21:33', NULL),
(719, 'admin.sliders.store', 2, '2021-10-27 19:21:33', NULL),
(720, 'admin.sliders.update', 2, '2021-10-27 19:21:33', NULL),
(721, 'admin.sliders.destroy', 2, '2021-10-27 19:21:33', NULL),
(722, 'admin.sliders.changeActive', 2, '2021-10-27 19:21:33', NULL),
(723, 'admin.pages.index', 2, '2021-10-27 19:21:33', NULL),
(724, 'admin.pages.index', 2, '2021-10-27 19:21:33', NULL),
(725, 'admin.pages.update', 2, '2021-10-27 19:21:33', NULL),
(726, 'admin.questions.index', 2, '2021-10-27 19:21:33', NULL),
(727, 'admin.questions.index', 2, '2021-10-27 19:21:33', NULL),
(728, 'admin.questions.store', 2, '2021-10-27 19:21:33', NULL),
(729, 'admin.questions.update', 2, '2021-10-27 19:21:33', NULL),
(730, 'admin.questions.destroy', 2, '2021-10-27 19:21:33', NULL),
(731, 'admin.complaints.index', 2, '2021-10-27 19:21:33', NULL),
(732, 'admin.complaints.index', 2, '2021-10-27 19:21:33', NULL),
(733, 'admin.complaints.update', 2, '2021-10-27 19:21:33', NULL),
(734, 'admin.complaints.destroy', 2, '2021-10-27 19:21:33', NULL),
(735, 'admin.contacts.index', 2, '2021-10-27 19:21:33', NULL),
(736, 'admin.contacts.index', 2, '2021-10-27 19:21:33', NULL),
(737, 'admin.contacts.update', 2, '2021-10-27 19:21:33', NULL),
(738, 'admin.contacts.destroy', 2, '2021-10-27 19:21:33', NULL),
(739, 'admin.coupons.index', 2, '2021-10-27 19:21:33', NULL),
(740, 'admin.coupons.index', 2, '2021-10-27 19:21:33', NULL),
(741, 'admin.coupons.store', 2, '2021-10-27 19:21:33', NULL),
(742, 'admin.coupons.update', 2, '2021-10-27 19:21:33', NULL),
(743, 'admin.coupons.destroy', 2, '2021-10-27 19:21:33', NULL),
(744, 'admin.deductions.index', 2, '2021-10-27 19:21:33', NULL),
(745, 'admin.deductions.index', 2, '2021-10-27 19:21:33', NULL),
(3160, 'admin.dashboard', 1, '2022-02-12 14:21:37', NULL),
(3161, 'admin.financial', 1, '2022-02-12 14:21:37', NULL),
(3162, 'admin.roles.index', 1, '2022-02-12 14:21:37', NULL),
(3163, 'admin.roles.create', 1, '2022-02-12 14:21:37', NULL),
(3164, 'admin.roles.store', 1, '2022-02-12 14:21:38', NULL),
(3165, 'admin.roles.edit', 1, '2022-02-12 14:21:38', NULL),
(3166, 'admin.roles.update', 1, '2022-02-12 14:21:38', NULL),
(3167, 'admin.roles.delete', 1, '2022-02-12 14:21:38', NULL),
(3168, 'admin.settings.index', 1, '2022-02-12 14:21:38', NULL),
(3169, 'admin.settings.update', 1, '2022-02-12 14:21:38', NULL),
(3170, 'admin.socials.store', 1, '2022-02-12 14:21:38', NULL),
(3171, 'admin.socials.update', 1, '2022-02-12 14:21:38', NULL),
(3172, 'admin.users', 1, '2022-02-12 14:21:38', NULL),
(3173, 'admin.admins.index', 1, '2022-02-12 14:21:38', NULL),
(3174, 'admin.admins.store', 1, '2022-02-12 14:21:38', NULL),
(3175, 'admin.admins.update', 1, '2022-02-12 14:21:38', NULL),
(3176, 'admin.admins.delete', 1, '2022-02-12 14:21:38', NULL),
(3177, 'admin.clients.index', 1, '2022-02-12 14:21:38', NULL),
(3178, 'admin.clients.store', 1, '2022-02-12 14:21:38', NULL),
(3179, 'admin.clients.update', 1, '2022-02-12 14:21:38', NULL),
(3180, 'admin.clients.delete', 1, '2022-02-12 14:21:38', NULL),
(3181, 'admin.technicians.index', 1, '2022-02-12 14:21:38', NULL),
(3182, 'admin.technicians.store', 1, '2022-02-12 14:21:38', NULL),
(3183, 'admin.technicians.update', 1, '2022-02-12 14:21:38', NULL),
(3184, 'admin.technicians.delete', 1, '2022-02-12 14:21:38', NULL),
(3185, 'admin.technicians.decreaseVal', 1, '2022-02-12 14:21:38', NULL),
(3186, 'admin.technicians.selectCategories', 1, '2022-02-12 14:21:38', NULL),
(3187, 'admin.technicians.accounts', 1, '2022-02-12 14:21:38', NULL),
(3188, 'admin.technicians.accountsDelete', 1, '2022-02-12 14:21:38', NULL),
(3189, 'admin.technicians.settlement', 1, '2022-02-12 14:21:38', NULL),
(3190, 'admin.companies.index', 1, '2022-02-12 14:21:38', NULL),
(3191, 'admin.companies.store', 1, '2022-02-12 14:21:38', NULL),
(3192, 'admin.companies.update', 1, '2022-02-12 14:21:38', NULL),
(3193, 'admin.companies.delete', 1, '2022-02-12 14:21:38', NULL),
(3194, 'admin.companies.images', 1, '2022-02-12 14:21:38', NULL),
(3195, 'admin.companies.storeImages', 1, '2022-02-12 14:21:38', NULL),
(3196, 'admin.companies.technicians', 1, '2022-02-12 14:21:38', NULL),
(3197, 'admin.companies.storeTechnicians', 1, '2022-02-12 14:21:38', NULL),
(3198, 'admin.companies.updateTechnicians', 1, '2022-02-12 14:21:38', NULL),
(3199, 'admin.companies.deleteTechnicians', 1, '2022-02-12 14:21:38', NULL),
(3200, 'admin.sendnotifyuser', 1, '2022-02-12 14:21:38', NULL),
(3201, 'admin.changeStatus', 1, '2022-02-12 14:21:38', NULL),
(3202, 'admin.addToWallet', 1, '2022-02-12 14:21:38', NULL),
(3203, 'admin.admin.statistics', 1, '2022-02-12 14:21:38', NULL),
(3204, 'admin.statistics.visits', 1, '2022-02-12 14:21:38', NULL),
(3205, 'admin.statistics.almostOrder', 1, '2022-02-12 14:21:38', NULL),
(3206, 'admin.statistics.getdata', 1, '2022-02-12 14:21:38', NULL),
(3207, 'admin.country', 1, '2022-02-12 14:21:38', NULL),
(3208, 'admin.countries.index', 1, '2022-02-12 14:21:38', NULL),
(3209, 'admin.countries.store', 1, '2022-02-12 14:21:38', NULL),
(3210, 'admin.countries.update', 1, '2022-02-12 14:21:38', NULL),
(3211, 'admin.countries.destroy', 1, '2022-02-12 14:21:38', NULL),
(3212, 'admin.cities.index', 1, '2022-02-12 14:21:38', NULL),
(3213, 'admin.cities.store', 1, '2022-02-12 14:21:38', NULL),
(3214, 'admin.cities.update', 1, '2022-02-12 14:21:38', NULL),
(3215, 'admin.cities.destroy', 1, '2022-02-12 14:21:38', NULL),
(3216, 'admin.regions.index', 1, '2022-02-12 14:21:38', NULL),
(3217, 'admin.regions.store', 1, '2022-02-12 14:21:38', NULL),
(3218, 'admin.regions.update', 1, '2022-02-12 14:21:38', NULL),
(3219, 'admin.regions.destroy', 1, '2022-02-12 14:21:38', NULL),
(3220, 'admin.branches.index', 1, '2022-02-12 14:21:38', NULL),
(3221, 'admin.branches.create', 1, '2022-02-12 14:21:38', NULL),
(3222, 'admin.branches.store', 1, '2022-02-12 14:21:38', NULL),
(3223, 'admin.branches.edit', 1, '2022-02-12 14:21:38', NULL),
(3224, 'admin.branches.update', 1, '2022-02-12 14:21:38', NULL),
(3225, 'admin.branches.destroy', 1, '2022-02-12 14:21:38', NULL),
(3226, 'admin.categories.index', 1, '2022-02-12 14:21:38', NULL),
(3227, 'admin.categories.index', 1, '2022-02-12 14:21:38', NULL),
(3228, 'admin.categories.view', 1, '2022-02-12 14:21:38', NULL),
(3229, 'admin.categories.store', 1, '2022-02-12 14:21:38', NULL),
(3230, 'admin.categories.update', 1, '2022-02-12 14:21:38', NULL),
(3231, 'admin.categories.destroy', 1, '2022-02-12 14:21:38', NULL),
(3232, 'admin.subcategories.index', 1, '2022-02-12 14:21:38', NULL),
(3233, 'admin.subcategories.store', 1, '2022-02-12 14:21:38', NULL),
(3234, 'admin.subcategories.update', 1, '2022-02-12 14:21:38', NULL),
(3235, 'admin.subcategories.destroy', 1, '2022-02-12 14:21:38', NULL),
(3236, 'admin.categories.changeCategoryAppear', 1, '2022-02-12 14:21:38', NULL),
(3237, 'admin.services.index', 1, '2022-02-12 14:21:38', NULL),
(3238, 'admin.services.getFilterData', 1, '2022-02-12 14:21:38', NULL),
(3239, 'admin.services.store', 1, '2022-02-12 14:21:38', NULL),
(3240, 'admin.services.update', 1, '2022-02-12 14:21:38', NULL),
(3241, 'admin.services.destroy', 1, '2022-02-12 14:21:38', NULL),
(3242, 'admin.services.changeStatus', 1, '2022-02-12 14:21:38', NULL),
(3243, 'admin.orders', 1, '2022-02-12 14:21:38', NULL),
(3244, 'admin.orders.index', 1, '2022-02-12 14:21:38', NULL),
(3245, 'admin.orders.onWayOrders', 1, '2022-02-12 14:21:38', NULL),
(3246, 'admin.orders.finishedOrders', 1, '2022-02-12 14:21:38', NULL),
(3247, 'admin.orders.canceledOrders', 1, '2022-02-12 14:21:38', NULL),
(3248, 'admin.orders.guaranteeOrders', 1, '2022-02-12 14:21:38', NULL),
(3249, 'admin.orders.guaranteeShow', 1, '2022-02-12 14:21:38', NULL),
(3250, 'admin.orders.guaranteeDestroy', 1, '2022-02-12 14:21:38', NULL),
(3251, 'admin.orders.show', 1, '2022-02-12 14:21:38', NULL),
(3252, 'admin.orders.operationNotes', 1, '2022-02-12 14:21:38', NULL),
(3253, 'admin.orders.changeStatus', 1, '2022-02-12 14:21:38', NULL),
(3254, 'admin.orders.changeAddress', 1, '2022-02-12 14:21:38', NULL),
(3255, 'admin.orders.changePayType', 1, '2022-02-12 14:21:38', NULL),
(3256, 'admin.orders.changeAllAddress', 1, '2022-02-12 14:21:38', NULL),
(3257, 'admin.orders.changeTime', 1, '2022-02-12 14:21:38', NULL),
(3258, 'admin.orders.changeDate', 1, '2022-02-12 14:21:38', NULL),
(3259, 'admin.orders.assignTech', 1, '2022-02-12 14:21:38', NULL),
(3260, 'admin.orders.servicesUpdate', 1, '2022-02-12 14:21:38', NULL),
(3261, 'admin.orders.partsDestroy', 1, '2022-02-12 14:21:38', NULL),
(3262, 'admin.orders.rejectOrder', 1, '2022-02-12 14:21:38', NULL),
(3263, 'admin.orders.destroy', 1, '2022-02-12 14:21:38', NULL),
(3264, 'admin.chats.index', 1, '2022-02-12 14:21:38', NULL),
(3265, 'admin.chats.index', 1, '2022-02-12 14:21:38', NULL),
(3266, 'admin.chats.store', 1, '2022-02-12 14:21:38', NULL),
(3267, 'admin.chats.users', 1, '2022-02-12 14:21:38', NULL),
(3268, 'admin.chats.room', 1, '2022-02-12 14:21:38', NULL),
(3269, 'admin.chats.destroy', 1, '2022-02-12 14:21:38', NULL),
(3270, 'admin.chats.privateRoom', 1, '2022-02-12 14:21:38', NULL),
(3271, 'admin.financial', 1, '2022-02-12 14:21:38', NULL),
(3272, 'admin.financial.statistics', 1, '2022-02-12 14:21:38', NULL),
(3273, 'admin.financial.orders', 1, '2022-02-12 14:21:38', NULL),
(3274, 'admin.financial.dailyOrders', 1, '2022-02-12 14:21:38', NULL),
(3275, 'admin.financial.orderShow', 1, '2022-02-12 14:21:38', NULL),
(3276, 'admin.financial.catServ', 1, '2022-02-12 14:21:38', NULL),
(3277, 'admin.sliders.index', 1, '2022-02-12 14:21:38', NULL),
(3278, 'admin.sliders.index', 1, '2022-02-12 14:21:38', NULL),
(3279, 'admin.sliders.store', 1, '2022-02-12 14:21:38', NULL),
(3280, 'admin.sliders.update', 1, '2022-02-12 14:21:38', NULL),
(3281, 'admin.sliders.destroy', 1, '2022-02-12 14:21:38', NULL),
(3282, 'admin.sliders.changeActive', 1, '2022-02-12 14:21:38', NULL),
(3283, 'admin.pages.index', 1, '2022-02-12 14:21:38', NULL),
(3284, 'admin.pages.index', 1, '2022-02-12 14:21:38', NULL),
(3285, 'admin.pages.update', 1, '2022-02-12 14:21:38', NULL),
(3286, 'admin.questions.index', 1, '2022-02-12 14:21:38', NULL),
(3287, 'admin.questions.index', 1, '2022-02-12 14:21:38', NULL),
(3288, 'admin.questions.store', 1, '2022-02-12 14:21:38', NULL),
(3289, 'admin.questions.update', 1, '2022-02-12 14:21:38', NULL),
(3290, 'admin.questions.destroy', 1, '2022-02-12 14:21:38', NULL),
(3291, 'admin.complaints.index', 1, '2022-02-12 14:21:38', NULL),
(3292, 'admin.complaints.index', 1, '2022-02-12 14:21:38', NULL),
(3293, 'admin.complaints.update', 1, '2022-02-12 14:21:38', NULL),
(3294, 'admin.complaints.destroy', 1, '2022-02-12 14:21:38', NULL),
(3295, 'admin.contacts.index', 1, '2022-02-12 14:21:38', NULL),
(3296, 'admin.contacts.index', 1, '2022-02-12 14:21:38', NULL),
(3297, 'admin.contacts.update', 1, '2022-02-12 14:21:38', NULL),
(3298, 'admin.contacts.destroy', 1, '2022-02-12 14:21:38', NULL),
(3299, 'admin.coupons.index', 1, '2022-02-12 14:21:38', NULL),
(3300, 'admin.coupons.index', 1, '2022-02-12 14:21:38', NULL),
(3301, 'admin.coupons.store', 1, '2022-02-12 14:21:38', NULL),
(3302, 'admin.coupons.update', 1, '2022-02-12 14:21:38', NULL),
(3303, 'admin.coupons.destroy', 1, '2022-02-12 14:21:38', NULL),
(3304, 'admin.reports.index', 1, '2022-02-12 14:21:38', NULL),
(3305, 'admin.reports.index', 1, '2022-02-12 14:21:38', NULL),
(3306, 'admin.reports.delete', 1, '2022-02-12 14:21:38', NULL),
(3307, 'admin.deductions.index', 1, '2022-02-12 14:21:38', NULL),
(3308, 'admin.deductions.index', 1, '2022-02-12 14:21:38', NULL),
(3309, 'admin.trans.index', 1, '2022-02-12 14:21:38', NULL),
(3310, 'admin.trans.getLangDetails', 1, '2022-02-12 14:21:38', NULL),
(3311, 'admin.trans.transInput', 1, '2022-02-12 14:21:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint UNSIGNED NOT NULL,
  `key` text COLLATE utf8mb4_unicode_ci,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `key`, `value`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0645\\u0627 \\u0647\\u0648 \\u062a\\u0637\\u0628\\u064a\\u0642 \\u0646\\u0627\\u0641\\u0627\",\"en\":\"what is nava app\"}', '{\"ar\":\"\\u062a\\u0637\\u0628\\u064a\\u0642 \\u0646\\u0627\\u0641\\u0627 \\u062a\\u0637\\u0628\\u064a\\u0642 \\u0644\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u0645\\u0646\\u0632\\u0644\\u064a\\u0629 \\u064a\\u0645\\u0643\\u0646\\u0643 \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644\\u0647 \\u0637\\u0644\\u0628 \\u0641\\u0646\\u064a \\u0644\\u0627\\u064a \\u0646\\u0648\\u0639 \\u0645\\u0646 \\u0627\\u0646\\u0648\\u0627\\u0639 \\u0627\\u0644\\u0627\\u0639\\u0645\\u0627\\u0644 \\u0644\\u0644\\u062a\\u062c\\u0647\\u064a\\u0632\\u0627\\u062a \\u0648 \\u0627\\u0644\\u062a\\u0634\\u0637\\u064a\\u0628\\u0627\\u062a \\u0648 \\u0627\\u0639\\u0645\\u0627\\u0644 \\u0627\\u0644\\u0635\\u064a\\u0627\\u0646\\u0647\",\"en\":\"nava home service app for technical works\"}', '2021-10-10 11:35:57', NULL),
(2, '{\"ar\":\"xzczxxc\",\"en\":\"zxcczx\"}', '{\"ar\":\"zxcczx\",\"en\":\"zxcczx\"}', '2021-12-19 20:48:10', '2021-12-19 20:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `refuse_orders`
--

CREATE TABLE `refuse_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `city_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `title`, `city_id`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0627\\u0644\\u0631\\u064a\\u0627\\u0636\",\"en\":\"Riyadh\",\"ordu\":\"\\u0627\\u0644\\u0645\\u0646\\u0637\\u0642\\u0647 \\u0627\\u0644\\u0627\\u0648\\u0644\\u064a\",\"ur\":\"Riyadh\"}', 1, '2021-09-07 08:39:18', NULL),
(2, '{\"ar\":\"\\u0627\\u0644\\u0645\\u0646\\u0637\\u0642\\u0647 \\u0627\\u0644\\u062a\\u0627\\u0646\\u064a\\u0647\",\"en\":\"second region\",\"ur\":\"\\u0627\\u0644\\u0645\\u0646\\u0637\\u0642\\u0647 \\u0627\\u0644\\u062a\\u0627\\u0646\\u064a\\u0647\"}', 1, '2021-10-10 11:21:19', '2021-11-21 14:26:28'),
(3, '{\"ar\":\"\\u0645\\u0646\\u0637\\u0642\\u0647 \\u0628\\u062c\\u062f\\u0647\",\"en\":\"region in jedah\",\"ur\":\"\\u0645\\u0646\\u0637\\u0642\\u0647 \\u0628\\u062c\\u062f\\u0647\"}', 2, '2021-10-10 11:21:48', NULL),
(4, '{\"ar\":\"\\u0645\\u0646\\u0637\\u0642\\u0647 \\u0628\\u062a\\u0628\\u0648\\u0643\",\"en\":\"region in tabok\",\"ur\":\"\\u0645\\u0646\\u0637\\u0642\\u0647 \\u0628\\u062a\\u0628\\u0648\\u0643\"}', 3, '2021-10-10 11:22:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review_rates`
--

CREATE TABLE `review_rates` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `rateable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rateable_id` bigint UNSIGNED NOT NULL,
  `rate` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name_ar`, `name_en`, `name_ur`, `deleted_at`, `created_at`) VALUES
(1, 'ادمن', 'admin', 'ادمن', NULL, '2021-08-18 10:33:41'),
(2, 'موظفين', 'employes', NULL, NULL, '2021-10-27 19:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `private` int NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'order',
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` int NOT NULL,
  `other_user_id` int DEFAULT NULL,
  `last_message_id` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_users`
--

CREATE TABLE `room_users` (
  `id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('fixed','hourly','pricing') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `category_id`, `price`, `image`, `type`, `active`, `created_at`, `deleted_at`) VALUES
(1, '{\"ar\":\"\\u0627\\u0635\\u0644\\u0627\\u062d \\u0645\\u0641\\u062a\\u0627\\u062d \\u0627\\u0646\\u0627\\u0631\\u0647\",\"en\":\"Light switch repair\",\"ur\":\"\\u0644\\u0627\\u0626\\u0679 \\u0633\\u0648\\u0626\\u0686 \\u06a9\\u06cc \\u0645\\u0631\\u0645\\u062a\\u06d4\"}', '{\"ar\":\"\\u0627\\u0635\\u0644\\u0627\\u062d \\u0645\\u0641\\u062a\\u0627\\u062d \\u0627\\u0646\\u0627\\u0631\\u0647\",\"en\":\"Light switch repair\",\"ur\":\"\\u0644\\u0627\\u0626\\u0679 \\u0633\\u0648\\u0626\\u0686 \\u06a9\\u06cc \\u0645\\u0631\\u0645\\u062a\\u06d4\"}', 2, 100.00, '16338609603619094.png', 'fixed', 1, '2021-10-10 11:16:00', '2021-12-07 16:22:01'),
(2, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0644\\u0645\\u0628\\u0629 \\u0645\\u0633\\u0645\\u0627\\u0631\",\"en\":\"stud bulb installation\",\"ur\":\"\\u0633\\u0679\\u0688 \\u0628\\u0644\\u0628 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0644\\u0645\\u0628\\u0629 \\u0645\\u0633\\u0645\\u0627\\u0631\",\"en\":\"stud bulb installation\",\"ur\":\"\\u0633\\u0679\\u0688 \\u0628\\u0644\\u0628 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 2, 150.00, '16338610365630645.png', 'fixed', 1, '2021-10-10 11:17:16', '2021-12-07 16:22:01'),
(3, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 5 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0646\\u062c\\u0641\\u0647\",\"en\":\"Installing 5 chandeliers\",\"ur\":\"5 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u0644\\u06af\\u0627\\u0646\\u0627\\u06d4\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 5 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0646\\u062c\\u0641\\u0647\",\"en\":\"Installing 5 chandeliers\",\"ur\":\"5 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u0644\\u06af\\u0627\\u0646\\u0627\\u06d4\"}', 2, 300.00, '16338610975530011.png', 'fixed', 1, '2021-10-10 11:18:17', '2021-12-07 16:22:01'),
(4, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0641\\u0627\\u062a\\u064a\\u062d \\u0643\\u0647\\u0631\\u0628\\u0627\",\"en\":\"Installing electrical switches\",\"ur\":\"\\u0627\\u0644\\u06cc\\u06a9\\u0679\\u0631\\u06cc\\u06a9\\u0644 \\u0633\\u0648\\u0626\\u0686\\u0632 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0641\\u0627\\u062a\\u064a\\u062d \\u0643\\u0647\\u0631\\u0628\\u0627\",\"en\":\"Installing electrical switches\",\"ur\":\"\\u0627\\u0644\\u06cc\\u06a9\\u0679\\u0631\\u06cc\\u06a9\\u0644 \\u0633\\u0648\\u0626\\u0686\\u0632 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 9, 300.00, '16338611423155150.png', 'fixed', 1, '2021-10-10 11:19:02', '2021-12-07 16:22:01'),
(5, '{\"ar\":\"\\u062f\\u0647\\u0627\\u0646 \\u0627\\u0644\\u0635\\u0627\\u0644\\u0647\",\"en\":\"hall paint\",\"ur\":\"\\u06c1\\u0627\\u0644 \\u067e\\u06cc\\u0646\\u0679\"}', '{\"ar\":\"\\u062f\\u0647\\u0627\\u0646 \\u0627\\u0644\\u0635\\u0627\\u0644\\u0647\",\"en\":\"hall paint\",\"ur\":\"\\u06c1\\u0627\\u0644 \\u067e\\u06cc\\u0646\\u0679\"}', 11, 500.00, '16338616967609644.png', 'fixed', 1, '2021-10-10 11:28:16', '2021-12-07 16:22:01'),
(6, '{\"ar\":\"\\u0627\\u0641\\u064a\\u0627\\u0634\",\"ur\":null}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0641\\u064a\\u0627\\u0634\",\"ur\":null}', 13, 10.00, NULL, 'fixed', 1, '2021-10-25 16:18:28', '2021-12-07 16:22:01'),
(7, '{\"ar\":\"\\u0634\\u0642\\u0629 \\u0661\\u0660\\u0660 \\u0645\\u062a\\u0631\",\"en\":\"apt 100m\",\"ur\":\"apt 100m\"}', '{\"ar\":\"kkjjkk\",\"en\":\"jjhhk\",\"ur\":\"hgugjh\"}', 15, 200.00, '16368067018269019.jpeg', 'fixed', 1, '2021-11-08 13:34:52', '2021-12-07 16:22:01'),
(8, '{\"ar\":\"\\u0627\\u0646\\u0633\\u062f\\u0627\\u062f \\u0645\\u063a\\u0633\\u0644\\u0629\",\"en\":\"clogged washbasin\",\"ur\":null}', '{\"ur\":null}', 17, 75.00, NULL, 'fixed', 1, '2021-11-21 17:19:09', '2021-12-07 16:22:01'),
(9, '{\"ar\":\"\\u062a\\u0646\\u0638\\u064a\\u0641 \\u0633\\u0628\\u0644\\u064a\\u062a\",\"en\":\"Split cleaning\",\"ur\":\"Split cleaning\"}', '{\"ur\":null}', 19, 115.00, NULL, 'fixed', 1, '2021-11-21 17:25:54', '2021-12-07 16:22:01'),
(10, '{\"ar\":\"\\u0643\\u0646\\u0628\",\"en\":\"sofa\",\"ur\":\"sofa\"}', '{\"ur\":null}', 21, 50.00, NULL, 'fixed', 1, '2021-11-21 17:32:29', '2021-12-07 16:22:01'),
(11, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0648 \\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u0628\\u0648\\u062a \\u0644\\u0627\\u064a\\u062a - \\u0627\\u0644\\u062d\\u062c\\u0645 \\u0627\\u0644\\u0635\\u063a\\u064a\\u0631\",\"en\":\"Install or change Spotlight - Small\",\"ur\":\"\\u0627\\u0633\\u067e\\u0627\\u0679 \\u0644\\u0627\\u0626\\u0679 \\u0644\\u06af\\u0627\\u0646\\u0627 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u064a\\u0644 \\u0643\\u0631\\u0646\\u0627 - \\u0686\\u06be\\u0648\\u0679\\u06cc\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0648 \\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u0628\\u0648\\u062a \\u0644\\u0627\\u064a\\u062a\",\"en\":\"Install or change spotlight small\",\"ur\":\"\\u0627\\u0633\\u067e\\u0627\\u0679 \\u0644\\u0627\\u0626\\u0679 \\u0644\\u06af\\u0627\\u0646\\u0627 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u064a\\u0644 \\u0643\\u0631\\u0646\\u0627\"}', 2, 10.00, NULL, 'fixed', 1, '2021-12-07 16:32:09', NULL),
(12, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0648 \\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u0628\\u0648\\u062a \\u0644\\u0627\\u064a\\u062a - \\u062d\\u062c\\u0645 \\u0643\\u0628\\u064a\\u0631\",\"en\":\"Install or change Spotlight Big\",\"ur\":\"\\u0627\\u0633\\u067e\\u0627\\u0679 \\u0644\\u0627\\u0626\\u0679 \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u06cc\\u06ba\\u06d4 \\u0628\\u0691\\u064a\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0648 \\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u0628\\u0648\\u062a \\u0644\\u0627\\u064a\\u062a\",\"en\":\"Install or change Spotlight Big\",\"ur\":\"\\u0627\\u0633\\u067e\\u0627\\u0679 \\u0644\\u0627\\u0626\\u0679 \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u06cc\\u06ba\\u06d4\"}', 2, 10.00, NULL, 'fixed', 1, '2021-12-07 16:52:07', NULL),
(13, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u0628\\u0648\\u062a \\u0644\\u0627\\u064a\\u062a \\u0645\\u0639 \\u0627\\u0644\\u062a\\u062e\\u0631\\u064a\\u0645\",\"en\":\"Spotlight installation with perforation\",\"ur\":\"\\u0633\\u0648\\u0631\\u0627\\u062e \\u0643\\u0631 \\u06a9\\u06d2 \\u0627\\u0633\\u067e\\u0627\\u0679 \\u0644\\u0627\\u0626\\u0679 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u0628\\u0648\\u062a \\u0644\\u0627\\u064a\\u062a \\u0645\\u0639 \\u0627\\u0644\\u062a\\u062e\\u0631\\u064a\\u0645\",\"en\":\"Spotlight installation with perforation\",\"ur\":\"\\u0633\\u0648\\u0631\\u0627\\u062e \\u0643\\u0631 \\u06a9\\u06d2 \\u0627\\u0633\\u067e\\u0627\\u0679 \\u0644\\u0627\\u0626\\u0679 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 2, 10.00, NULL, 'fixed', 1, '2021-12-07 16:55:51', NULL),
(14, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0634\\u0631\\u064a\\u0637 \\u0644\\u064a\\u062f \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Install Hidden led light strip\",\"ur\":\"\\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0642\\u06cc\\u0627\\u062f\\u062a \\u0648\\u0627\\u0644\\u06cc \\u0631\\u0648\\u0634\\u0646\\u06cc \\u06a9\\u06cc \\u067e\\u0679\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u06cc\\u06ba\\u06d4\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0634\\u0631\\u064a\\u0637 \\u0644\\u064a\\u062f \\u0645\\u062e\\u0641\\u064a \\u0628\\u0627\\u0644\\u0645\\u062a\\u0631\",\"en\":\"Install hidden led light strip per meter\",\"ur\":\"\\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0642\\u06cc\\u0627\\u062f\\u062a \\u0648\\u0627\\u0644\\u06cc \\u0631\\u0648\\u0634\\u0646\\u06cc \\u06a9\\u06cc \\u067e\\u0679\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u06cc\\u06ba\\u06d4 \\u0641\\u064a \\u0645\\u062a\\u0631\"}', 2, 5.00, NULL, 'fixed', 1, '2021-12-07 16:58:28', NULL),
(15, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0646\\u062c\\u0641 \\u0639\\u0627\\u062f\\u064a \\u062c\\u062f\\u064a\\u062f - \\u0635\\u063a\\u064a\\u0631\",\"en\":\"Installing a new normal chandelier - small\",\"ur\":\"\\u0646\\u06cc\\u0627 \\u0639\\u0627\\u0645 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u0646\\u0635\\u0628 \\u06a9\\u0631\\u0646\\u0627 - \\u0686\\u06be\\u0648\\u0679\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0646\\u062c\\u0641 \\u0639\\u0627\\u062f\\u064a \\u062c\\u062f\\u064a\\u062f - \\u0627\\u0644\\u062d\\u062c\\u0645 \\u0627\\u0644\\u0635\\u063a\\u064a\\u0631\",\"en\":\"Installing a new normal chandelier - small\",\"ur\":\"\\u0627\\u06cc\\u06a9 \\u0646\\u06cc\\u0627 \\u0639\\u0627\\u0645 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u0646\\u0635\\u0628 \\u06a9\\u0631\\u0646\\u0627 - \\u0686\\u06be\\u0648\\u0679\\u0627\"}', 2, 30.00, NULL, 'fixed', 1, '2021-12-07 17:01:43', NULL),
(16, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0646\\u062c\\u0641 \\u0627\\u0645\\u0631\\u064a\\u0643\\u064a \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Install American Chandelier New\",\"ur\":\"\\u0646\\u06cc\\u0627 \\u0627\\u0645\\u0631\\u064a\\u0643\\u064a \\u0641\\u0627\\u0646\\u0648\\u0633 \\u0646\\u0635\\u0628 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0646\\u062c\\u0641 \\u0627\\u0645\\u0631\\u064a\\u0643\\u064a \\u062c\\u062f\\u064a\\u062f \\u062d\\u062c\\u0645 1\",\"en\":\"Install American Chandelier New\",\"ur\":\"\\u0646\\u06cc\\u0627 \\u0627\\u0645\\u0631\\u064a\\u0643\\u064a \\u0641\\u0627\\u0646\\u0648\\u0633 \\u0646\\u0635\\u0628 \\u06a9\\u0631\\u0646\\u0627\"}', 2, 20.00, NULL, 'fixed', 1, '2021-12-07 17:03:26', NULL),
(17, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0627\\u0644\\u0646\\u062c\\u0641\",\"en\":\"Changing chandelier bulbs\",\"ur\":\"\\u0646\\u062c\\u0641 \\u06a9\\u06d2 \\u0628\\u0644\\u0628 \\u0628\\u062f\\u0644\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0627\\u0644\\u0646\\u062c\\u0641 \\u0644\\u0644\\u062d\\u0628\\u0647\",\"en\":\"Changing chandelier bulbs piece\",\"ur\":\"\\u0646\\u062c\\u0641 \\u06a9\\u06d2 \\u0628\\u0644\\u0628 \\u0628\\u062f\\u0644\\u0646\\u0627\"}', 2, 5.00, NULL, 'fixed', 1, '2021-12-07 17:07:12', NULL),
(18, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0627\\u0644\\u0633\\u0637\\u062d\",\"en\":\"Change roof lights\",\"ur\":\"\\u0686\\u06be\\u062a \\u06a9\\u06cc \\u0644\\u0627\\u0626\\u0679\\u0633 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0627\\u0644\\u0633\\u0637\\u062d\",\"en\":\"Change roof lights\",\"ur\":\"\\u0686\\u06be\\u062a \\u06a9\\u06cc \\u0644\\u0627\\u0626\\u0679\\u0633 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 2, 20.00, NULL, 'fixed', 1, '2021-12-07 17:21:37', NULL),
(19, '{\"ar\":\"\\u0641\\u0643 \\u0627\\u0648 \\u062a\\u0631\\u0643\\u064a\\u064a\\u0628 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0627\\u0644\\u0633\\u0637\\u062d\",\"en\":\"Install or Remove roof light\",\"ur\":\"\\u0686\\u06be\\u062a \\u06a9\\u06d2 \\u0628\\u0644\\u0628 \\u06a9\\u0648 \\u0647\\u0679\\u0627\\u0646\\u0627 \\u06cc\\u0627 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0641\\u0643 \\u0627\\u0648 \\u062a\\u0631\\u0643\\u064a\\u064a\\u0628 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0627\\u0644\\u0633\\u0637\\u062d\",\"en\":\"Install or Remove roof light\",\"ur\":\"\\u0686\\u06be\\u062a \\u06a9\\u06d2 \\u0628\\u0644\\u0628 \\u06a9\\u0648 \\u0647\\u0679\\u0627\\u0646\\u0627 \\u06cc\\u0627 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 2, 30.00, NULL, 'fixed', 1, '2021-12-07 17:25:11', NULL),
(20, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0646\\u064a\\u0648\\u0646\",\"en\":\"Change Neon Bulb\",\"ur\":\"\\u0646\\u06cc\\u0648\\u0646 \\u0628\\u0644\\u0628 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0646\\u064a\\u0648\\u0646 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Change Neon Bulb price per piece\",\"ur\":\"\\u0646\\u06cc\\u0648\\u0646 \\u0628\\u0644\\u0628 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 2, 5.00, NULL, 'fixed', 1, '2021-12-07 17:27:29', NULL),
(21, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0641\\u0644\\u0648\\u0631\\u0633\\u0646\\u062a \\u0645\\u0639 \\u0627\\u0644\\u0642\\u0627\\u0639\\u062f\\u0647\",\"en\":\"Change florescent lights with base\",\"ur\":\"\\u0641\\u0644\\u0648\\u0631\\u0633\\u0646\\u0679 \\u0644\\u0627\\u0626\\u0679\\u0633 \\u06a9\\u0648 \\u0628\\u06cc\\u0633 \\u06a9\\u06d2 \\u0633\\u0627\\u062a\\u06be \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0645\\u0628\\u0627\\u062a \\u0641\\u0644\\u0648\\u0631\\u0633\\u0646\\u062a \\u0645\\u0639 \\u0627\\u0644\\u0642\\u0627\\u0639\\u062f\\u0647 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Change florescent lights with base\",\"ur\":\"\\u0641\\u0644\\u0648\\u0631\\u0633\\u0646\\u0679 \\u0644\\u0627\\u0626\\u0679\\u0633 \\u06a9\\u0648 \\u0628\\u06cc\\u0633 \\u06a9\\u06d2 \\u0633\\u0627\\u062a\\u06be \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 2, 20.00, NULL, 'fixed', 1, '2021-12-07 17:29:59', NULL),
(22, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0646\\u0648\\u0627\\u0631  \\u062e\\u0627\\u0631\\u062c\\u064a\\u0629\",\"en\":\"Install Outdoor Lights\",\"ur\":\"\\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u0644\\u0627\\u0626\\u0679\\u0633 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0646\\u0648\\u0627\\u0631 \\u062e\\u0627\\u0631\\u062c\\u064a\\u0629 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Install outdoor lights price per piece\",\"ur\":\"\\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u0644\\u0627\\u0626\\u0679\\u0633 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', 2, 30.00, NULL, 'fixed', 1, '2021-12-07 17:54:26', NULL),
(23, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0646\\u0648\\u0627\\u0631  \\u062f\\u0627\\u062e\\u0644\\u064a\\u0629\",\"en\":\"Install indoor lights\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u0644\\u0627\\u0626\\u0679\\u0633 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0646\\u0648\\u0627\\u0631 \\u062f\\u0627\\u062e\\u0644\\u064a\\u0629 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Install indoor lights price per piece\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u0644\\u0627\\u0626\\u0679\\u0633 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', 2, 20.00, NULL, 'fixed', 1, '2021-12-07 17:56:06', NULL),
(24, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062b\\u0631\\u064a\\u0629 \\u0635\\u063a\\u064a\\u0631\\u0629\",\"en\":\"Install fancy Chandelier Small\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06d2 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062b\\u0631\\u064a\\u0629 \\u0635\\u063a\\u064a\\u0631\\u0629\",\"en\":\"Install fancy Chandelier Small\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06d2 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 2, 80.00, NULL, 'fixed', 1, '2021-12-07 17:58:05', NULL),
(25, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062b\\u0631\\u064a\\u0629 \\u0645\\u062a\\u0648\\u0633\\u0637\\u0629\",\"en\":\"Install fancy Chandelier medium\",\"ur\":\"\\u062f\\u0631\\u0645\\u06cc\\u0627\\u0646\\u06d2 \\u0633\\u0627\\u0626\\u0630 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062b\\u0631\\u064a\\u0629 \\u0645\\u062a\\u0648\\u0633\\u0637\\u0629\",\"en\":\"Install fancy Chandelier medium\",\"ur\":\"\\u062f\\u0631\\u0645\\u06cc\\u0627\\u0646\\u06d2 \\u0633\\u0627\\u0626\\u0630 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 2, 120.00, NULL, 'fixed', 1, '2021-12-07 18:00:02', NULL),
(26, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062b\\u0631\\u064a\\u0629 \\u0643\\u0628\\u064a\\u0631\\u0629\",\"en\":\"Install fancy Chandelier Big\",\"ur\":\"\\u0628\\u0691\\u06d2 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062b\\u0631\\u064a\\u0629 \\u0643\\u0628\\u064a\\u0631\\u0629\",\"en\":\"Install fancy Chandelier Big\",\"ur\":\"\\u0628\\u0691\\u06d2 \\u0641\\u0627\\u0646\\u0648\\u0633 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 2, 150.00, NULL, 'fixed', 1, '2021-12-07 18:01:24', NULL),
(27, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062c\\u0631\\u0633 \\u0628\\u0627\\u0628\",\"en\":\"Install Door Bell\",\"ur\":\"\\u0688\\u0648\\u0631 \\u0628\\u06cc\\u0644 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062c\\u0631\\u0633 \\u0628\\u0627\\u0628\",\"en\":\"Install Door Bell\",\"ur\":\"\\u0688\\u0648\\u0631 \\u0628\\u06cc\\u0644 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 13, 150.00, NULL, 'fixed', 1, '2021-12-07 18:17:09', NULL),
(28, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062c\\u0631\\u0633 \\u0627\\u0646\\u062a\\u0631\\u0643\\u0648\\u0645\",\"en\":\"Install Intercom Bell\",\"ur\":\"\\u0627\\u0646\\u0679\\u0631\\u06a9\\u0627\\u0645 \\u0628\\u064a\\u0644 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u062c\\u0631\\u0633 \\u0627\\u0646\\u062a\\u0631\\u0643\\u0648\\u0645\",\"en\":\"Install Intercom Bell\",\"ur\":\"\\u0627\\u0646\\u0679\\u0631\\u06a9\\u0627\\u0645 \\u0628\\u064a\\u0644 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 13, 250.00, NULL, 'fixed', 1, '2021-12-07 18:31:26', NULL),
(29, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0646\\u062a\\u0631\\u0643\\u0645 \\u062c\\u062f\\u064a\\u062f\",\"en\":\"New Intercom Installation\",\"ur\":\"\\u0646\\u06cc\\u0627 \\u0627\\u0646\\u0679\\u0631\\u06a9\\u0627\\u0645 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u0643\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0646\\u062a\\u0631\\u0643\\u0645 \\u062c\\u062f\\u064a\\u062f\",\"en\":\"New Intercom Installation\",\"ur\":\"\\u0646\\u06cc\\u0627 \\u0627\\u0646\\u0679\\u0631\\u06a9\\u0627\\u0645 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u0643\\u0631\\u0646\\u0627\"}', 13, 150.00, NULL, 'fixed', 1, '2021-12-07 18:34:21', NULL),
(30, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0641\\u062a\\u0627\\u062d \\u0637\\u0628\\u0644\\u0648\\u0646\",\"en\":\"Installing or changing main panel key\",\"ur\":\"\\u0645\\u062a\\u0631 \\u06a9\\u06cc \\u0686\\u0627\\u0628\\u06cc \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0641\\u062a\\u0627\\u062d \\u0637\\u0628\\u0644\\u0648\\u0646\",\"en\":\"Installing or changing main panel key\",\"ur\":\"\\u0645\\u062a\\u0631 \\u06a9\\u06cc \\u0686\\u0627\\u0628\\u06cc \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 10, 30.00, NULL, 'fixed', 1, '2021-12-07 18:39:14', NULL),
(31, '{\"ar\":\"\\u062a\\u062d\\u0648\\u064a\\u0644 \\u0643\\u0647\\u0631\\u0628\\u0627\\u0621 \\u0645\\u0646 110-220 \\u0634\\u0642\\u0647 \\u0643\\u0627\\u0645\\u0644\\u0629\",\"en\":\"Electricity conversion from 110-220 complete apartment\",\"ur\":\"110-220 \\u0645\\u06a9\\u0645\\u0644 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679 \\u0633\\u06d2 \\u0628\\u062c\\u0644\\u06cc \\u06a9\\u06cc \\u062a\\u0628\\u062f\\u06cc\\u0644\\u06cc\"}', '{\"ar\":\"\\u062a\\u062d\\u0648\\u064a\\u0644 \\u0643\\u0647\\u0631\\u0628\\u0627\\u0621 \\u0645\\u0646 110-220 \\u0634\\u0642\\u0647 \\u0643\\u0627\\u0645\\u0644\\u0629\",\"en\":\"Electricity conversion from 110-220 complete apartment\",\"ur\":\"110-220 \\u0645\\u06a9\\u0645\\u0644 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679 \\u0633\\u06d2 \\u0628\\u062c\\u0644\\u06cc \\u06a9\\u06cc \\u062a\\u0628\\u062f\\u06cc\\u0644\\u06cc\"}', 10, 300.00, NULL, 'fixed', 1, '2021-12-07 18:41:02', NULL),
(32, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u0634\\u0641\\u0637\",\"en\":\"Install or change Exhaust Fan\",\"ur\":\"\\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u0634\\u0641\\u0637\",\"en\":\"Install or change Exhaust Fan\",\"ur\":\"\\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 23, 35.00, NULL, 'fixed', 1, '2021-12-07 18:44:09', NULL),
(33, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u0634\\u0641\\u0637 \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Install or change hidden exhaust fan\",\"ur\":\"\\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u0634\\u0641\\u0637 \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Install or change hidden exhaust fan\",\"ur\":\"\\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 23, 55.00, NULL, 'fixed', 1, '2021-12-07 18:46:32', NULL),
(34, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0623\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u0634\\u0641\\u0627\\u0637\\u0629 \\u0645\\u0637\\u0628\\u062e \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Change or Install hidden exhaust kitchen fan\",\"ur\":\"\\u0628\\u0627\\u0648\\u0631\\u0686\\u06cc \\u062e\\u0627\\u0646\\u06d2 \\u06a9\\u06d2 \\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0623\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u0634\\u0641\\u0627\\u0637\\u0629 \\u0645\\u0637\\u0628\\u062e \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Change or Install hidden exhaust kitchen fan\",\"ur\":\"\\u0628\\u0627\\u0648\\u0631\\u0686\\u06cc \\u062e\\u0627\\u0646\\u06d2 \\u06a9\\u06d2 \\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 23, 50.00, NULL, 'fixed', 1, '2021-12-07 18:51:22', NULL),
(35, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u064a\\u0628 \\u0645\\u0641\\u062a\\u0627\\u062d \\u0633\\u062e\\u0627\\u0646\",\"en\":\"Install Water Heater Switch\",\"ur\":\"\\u0647\\u06cc\\u0679\\u0631 \\u06a9\\u0627 \\u0633\\u0648\\u0626\\u0686 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u064a\\u0628 \\u0645\\u0641\\u062a\\u0627\\u062d \\u0633\\u062e\\u0627\\u0646\",\"en\":\"Install Water Heater Switch\",\"ur\":\"\\u0647\\u06cc\\u0679\\u0631 \\u06a9\\u0627 \\u0633\\u0648\\u0626\\u0686 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', 9, 25.00, NULL, 'fixed', 1, '2021-12-08 12:28:03', NULL),
(36, '{\"ar\":\"\\u062a\\u0635\\u0644\\u064a\\u062d \\u0645\\u0641\\u062a\\u0627\\u062d \\u0645\\u0643\\u064a\\u0641 -\\u0641\\u0631\\u0646 - \\u0633\\u062e\\u0627\\u0646\",\"en\":\"Fix switch for air conditioner,oven and water heater\",\"ur\":\"\\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646 \\u06c1\\u06cc\\u0679\\u0631 \\u06cc\\u0627 \\u0627\\u0648\\u0646 \\u06a9\\u06d2 \\u0633\\u0648\\u0626\\u0686 \\u06a9\\u064a \\u0645\\u0631\\u0645\\u062a\"}', '{\"ar\":\"\\u062a\\u0635\\u0644\\u064a\\u062d \\u0645\\u0641\\u062a\\u0627\\u062d \\u0645\\u0643\\u064a\\u0641 -\\u0641\\u0631\\u0646 - \\u0633\\u062e\\u0627\\u0646 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Fix switch for air conditioner,oven and water heater price per piece\",\"ur\":\"\\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646 \\u06c1\\u06cc\\u0679\\u0631 \\u06cc\\u0627 \\u0627\\u0648\\u0646 \\u06a9\\u06d2 \\u0633\\u0648\\u0626\\u0686 \\u06a9\\u064a \\u0645\\u0631\\u0645\\u062a\"}', 9, 30.00, NULL, 'fixed', 1, '2021-12-08 12:35:07', NULL),
(37, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0623\\u0641\\u064a\\u0627\\u0634 \\u0643\\u0647\\u0631\\u0628\\u0627\\u0621\",\"en\":\"Install electrical sockets\",\"ur\":\"\\u0628\\u062c\\u0644\\u06cc \\u06a9\\u06d2 \\u0633\\u0627\\u06a9\\u0679 \\u06a9\\u064a \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0623\\u0641\\u064a\\u0627\\u0634 \\u0643\\u0647\\u0631\\u0628\\u0627\\u0621 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Install electrical sockets price per piece\",\"ur\":\"\\u0628\\u062c\\u0644\\u06cc \\u06a9\\u06d2 \\u0633\\u0627\\u06a9\\u0679 \\u06a9\\u064a \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 9, 15.00, NULL, 'fixed', 1, '2021-12-08 12:37:22', NULL),
(38, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0641\\u064a\\u0634 \\u0643\\u0647\\u0631\\u0628\\u0627\\u0621 \\u0639\\u0627\\u062f\\u064a\",\"en\":\"Change electric socket - Normal\",\"ur\":\"\\u0628\\u062c\\u0644\\u06cc \\u06a9\\u06d2 \\u0639\\u0627\\u0645 \\u0633\\u0627\\u06a9\\u0679 \\u06a9\\u064a \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0641\\u064a\\u0634 \\u0643\\u0647\\u0631\\u0628\\u0627\\u0621 \\u0639\\u0627\\u062f\\u064a \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Change electric socket - Normal price per piece\",\"ur\":\"\\u0628\\u062c\\u0644\\u06cc \\u06a9\\u06d2 \\u0639\\u0627\\u0645 \\u0633\\u0627\\u06a9\\u0679 \\u06a9\\u064a \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 9, 20.00, NULL, 'fixed', 1, '2021-12-08 12:39:52', NULL),
(39, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0641\\u062a\\u0627\\u062d \\u062e\\u0644\\u064a\\u0629 \\u0636\\u0648\\u0626\\u064a\\u0629 - \\u0641\\u0648\\u062a\\u0648\\u0633\\u064a\\u0644\",\"en\":\"Install Switch - Photocell\",\"ur\":\"\\u0641\\u0648\\u0679\\u0648 \\u0633\\u06cc\\u0644 \\u0633\\u0648\\u0626\\u0686 \\u0643\\u064a \\u062a\\u0646\\u0635\\u064a\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0641\\u062a\\u0627\\u062d \\u062e\\u0644\\u064a\\u0629 \\u0636\\u0648\\u0626\\u064a\\u0629 - \\u0641\\u0648\\u062a\\u0648\\u0633\\u064a\\u0644\",\"en\":\"Install Switch - Photocell\",\"ur\":\"\\u0641\\u0648\\u0679\\u0648 \\u0633\\u06cc\\u0644 \\u0633\\u0648\\u0626\\u0686 \\u0643\\u064a \\u062a\\u0646\\u0635\\u064a\\u0628\"}', 9, 30.00, NULL, 'fixed', 1, '2021-12-08 12:42:21', NULL),
(40, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0647\\u0631\\u0627\\u0628 \\u0645\\u063a\\u0633\\u0644\\u0629\",\"en\":\"Change Drain for Wash basin\",\"ur\":\"\\u0648\\u0627\\u0634 \\u0628\\u06cc\\u0633\\u0646 \\u06a9\\u0627 \\u0688\\u0631\\u06cc\\u0646 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0647\\u0631\\u0627\\u0628 \\u0645\\u063a\\u0633\\u0644\\u0629 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Change Drain for Wash basin price per piece\",\"ur\":\"\\u0648\\u0627\\u0634 \\u0628\\u06cc\\u0633\\u0646 \\u06a9\\u0627 \\u0688\\u0631\\u06cc\\u0646 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 29, 40.00, NULL, 'fixed', 1, '2021-12-08 13:06:58', NULL),
(41, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u063a\\u0633\\u0644\\u0629 \\u0639\\u0627\\u062f\\u064a\",\"en\":\"Install or change normal washbasin\",\"ur\":\"\\u0646\\u0627\\u0631\\u0645\\u0644 \\u0648\\u0627\\u0634 \\u0628\\u06cc\\u0633\\u0646 \\u06a9\\u064a \\u062a\\u0646\\u0635\\u06cc\\u0628 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u064a\\u0644\\u064a\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u063a\\u0633\\u0644\\u0629 \\u0639\\u0627\\u062f\\u064a\",\"en\":\"Install or change normal washbasin\",\"ur\":\"\\u0646\\u0627\\u0631\\u0645\\u0644 \\u0648\\u0627\\u0634 \\u0628\\u06cc\\u0633\\u0646 \\u06a9\\u064a \\u062a\\u0646\\u0635\\u06cc\\u0628 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u064a\\u0644\\u064a\"}', 29, 75.00, NULL, 'fixed', 1, '2021-12-08 13:09:46', NULL),
(42, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u063a\\u0633\\u0644\\u0629 \\u062f\\u0648\\u0644\\u0627\\u0628\",\"en\":\"Install or change cupboard type Sink\",\"ur\":\"\\u0627\\u0644\\u0645\\u0627\\u0631\\u06cc \\u0633\\u0646\\u06a9 \\u0643\\u064a \\u062a\\u0646\\u0635\\u064a\\u0628 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u064a\\u0644\\u064a\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u063a\\u0633\\u0644\\u0629 \\u062f\\u0648\\u0644\\u0627\\u0628\",\"en\":\"Install or change cupboard type Sink\",\"ur\":\"\\u0627\\u0644\\u0645\\u0627\\u0631\\u06cc \\u0633\\u0646\\u06a9 \\u0643\\u064a \\u062a\\u0646\\u0635\\u064a\\u0628 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u064a\\u0644\\u064a\"}', 29, 140.00, NULL, 'fixed', 1, '2021-12-08 13:11:36', NULL),
(43, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u062d\\u0628\\u0633 \\u0632\\u0627\\u0648\\u064a\\u0629 \\u0645\\u0639 \\u0644\\u064a\",\"en\":\"Change angle valve with pipe\",\"ur\":\"\\u067e\\u0627\\u0626\\u067e \\u06a9\\u06d2 \\u0633\\u0627\\u062a\\u06be \\u0632\\u0627\\u0648\\u06cc\\u06c1 \\u0648\\u0627\\u0644\\u0648 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u062d\\u0628\\u0633 \\u0632\\u0627\\u0648\\u064a\\u0629 \\u0645\\u0639 \\u0644\\u064a\",\"en\":\"Change angle valve with pipe\",\"ur\":\"\\u067e\\u0627\\u0626\\u067e \\u06a9\\u06d2 \\u0633\\u0627\\u062a\\u06be \\u0632\\u0627\\u0648\\u06cc\\u06c1 \\u0648\\u0627\\u0644\\u0648 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 29, 50.00, NULL, 'fixed', 1, '2021-12-08 13:12:53', NULL),
(44, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062e\\u0644\\u0627\\u0637 \\u0639\\u0627\\u062f\\u064a\",\"en\":\"Change normal water tap\",\"ur\":\"\\u0646\\u0627\\u0631\\u0645\\u0644 \\u0646\\u0644\\u06a9\\u06d2 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062e\\u0644\\u0627\\u0637 \\u0639\\u0627\\u062f\\u064a\",\"en\":\"Change normal water tap\",\"ur\":\"\\u0646\\u0627\\u0631\\u0645\\u0644 \\u0646\\u0644\\u06a9\\u06d2 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 29, 20.00, NULL, 'fixed', 1, '2021-12-08 13:15:51', '2021-12-08 15:21:23'),
(45, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u062d\\u0627\\u0628\\u0633\",\"en\":\"Change or install angle valve\",\"ur\":\"\\u0632\\u0627\\u0648\\u06cc\\u06c1 \\u0648\\u0627\\u0644\\u0648 \\u06a9\\u0648 \\u0644\\u06af\\u0627\\u0646\\u0627 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u062d\\u0627\\u0628\\u0633\",\"en\":\"Change or install angle valve\",\"ur\":\"\\u0632\\u0627\\u0648\\u06cc\\u06c1 \\u0648\\u0627\\u0644\\u0648 \\u06a9\\u0648 \\u0644\\u06af\\u0627\\u0646\\u0627 \\u064a\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 29, 50.00, NULL, 'fixed', 1, '2021-12-08 13:18:46', NULL),
(46, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\/ \\u062a\\u063a\\u064a\\u064a\\u0631 \\u062d\\u0646\\u0641\\u064a\\u0629\",\"en\":\"Install or change Faucet\",\"ur\":\"\\u0679\\u0648\\u0646\\u0679\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\/ \\u062a\\u063a\\u064a\\u064a\\u0631 \\u062d\\u0646\\u0641\\u064a\\u0629\",\"en\":\"Install or change Faucet\",\"ur\":\"\\u0679\\u0648\\u0646\\u0679\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 29, 15.00, NULL, 'fixed', 1, '2021-12-08 14:01:35', '2021-12-08 15:21:02'),
(47, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u062e\\u0644\\u0627\\u0637\",\"en\":\"Install or change Water tap\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06d2 \\u0646\\u0644 \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u062e\\u0644\\u0627\\u0637\",\"en\":\"Install or change Water tap\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06d2 \\u0646\\u0644 \\u06a9\\u0648 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 29, 50.00, NULL, 'fixed', 1, '2021-12-08 15:20:41', NULL),
(48, '{\"ar\":\"\\u0627\\u0635\\u0644\\u0627\\u062d \\u0627\\u0644\\u0623\\u0646\\u0633\\u062f\\u0627\\u062f\\u0627\\u062a \\u0648\\u0627\\u0644\\u062a\\u0633\\u0631\\u064a\\u0628\\u0627\\u062a \\u0641\\u064a \\u0627\\u0644\\u0645\\u063a\\u0627\\u0633\\u0644\",\"en\":\"Fix leakages and blockages in wash basin\",\"ur\":\"\\u0648\\u0627\\u0634 \\u0628\\u06cc\\u0633\\u0646 \\u0645\\u06cc\\u06ba \\u0644\\u06cc\\u06a9\\u06cc\\u062c \\u0627\\u0648\\u0631 \\u0628\\u0644\\u0627\\u06a9\\u06cc\\u062c\\u0632 \\u06a9\\u0648 \\u0679\\u06be\\u06cc\\u06a9 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0627\\u0635\\u0644\\u0627\\u062d \\u0627\\u0644\\u0623\\u0646\\u0633\\u062f\\u0627\\u062f\\u0627\\u062a \\u0648\\u0627\\u0644\\u062a\\u0633\\u0631\\u064a\\u0628\\u0627\\u062a \\u0641\\u064a \\u0627\\u0644\\u0645\\u063a\\u0627\\u0633\\u0644\",\"en\":\"Fix leakages and blockages in wash basin\",\"ur\":\"\\u0648\\u0627\\u0634 \\u0628\\u06cc\\u0633\\u0646 \\u0645\\u06cc\\u06ba \\u0644\\u06cc\\u06a9\\u06cc\\u062c \\u0627\\u0648\\u0631 \\u0628\\u0644\\u0627\\u06a9\\u06cc\\u062c\\u0632 \\u06a9\\u0648 \\u0679\\u06be\\u06cc\\u06a9 \\u06a9\\u0631\\u0646\\u0627\"}', 29, 80.00, NULL, 'fixed', 1, '2021-12-08 15:23:28', NULL),
(49, '{\"ar\":\"\\u0631\\u0628\\u0637 \\u0644\\u064a\\u0627\\u062a \\u0648 \\u0635\\u0631\\u0641 - \\u063a\\u0633\\u0627\\u0644\\u0629 \\u0645\\u0644\\u0627\\u0628\\u0633\",\"en\":\"Install washing machine drain and water lines\",\"ur\":\"\\u0648\\u0627\\u0634\\u0646\\u06af \\u0645\\u0634\\u06cc\\u0646 \\u0688\\u0631\\u06cc\\u0646 \\u0627\\u0648\\u0631 \\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06cc \\u0644\\u0627\\u0626\\u0646\\u06cc\\u06ba \\u0644\\u06af\\u0627\\u0646\\u0627\"}', '{\"ar\":\"\\u0631\\u0628\\u0637 \\u0644\\u064a\\u0627\\u062a \\u0648 \\u0635\\u0631\\u0641 - \\u063a\\u0633\\u0627\\u0644\\u0629 \\u0645\\u0644\\u0627\\u0628\\u0633\",\"en\":\"Install washing machine drain and water lines\",\"ur\":\"\\u0648\\u0627\\u0634\\u0646\\u06af \\u0645\\u0634\\u06cc\\u0646 \\u0688\\u0631\\u06cc\\u0646 \\u0627\\u0648\\u0631 \\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06cc \\u0644\\u0627\\u0626\\u0646\\u06cc\\u06ba \\u0644\\u06af\\u0627\\u0646\\u0627\"}', 27, 50.00, NULL, 'fixed', 1, '2021-12-08 15:26:17', NULL),
(50, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0628\\u0627\\u0646\\u064a\\u0648 \\u0642\\u062f\\u064a\\u0645\",\"en\":\"Change old bath tub\",\"ur\":\"\\u067e\\u0631\\u0627\\u0646\\u06d2 \\u0628\\u0627\\u062a\\u06be \\u0679\\u0628 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0628\\u0627\\u0646\\u064a\\u0648 \\u0642\\u062f\\u064a\\u0645\",\"en\":\"Change old bath tub\",\"ur\":\"\\u067e\\u0631\\u0627\\u0646\\u06d2 \\u0628\\u0627\\u062a\\u06be \\u0679\\u0628 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 130.00, NULL, 'fixed', 1, '2021-12-08 15:29:15', NULL),
(51, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0643\\u0631\\u0633\\u064a \\u0639\\u0631\\u0628\\u064a\",\"en\":\"Change eastern style WC\",\"ur\":\"\\u0639\\u0631\\u0628\\u06cc \\u0637\\u0631\\u0632 \\u06a9\\u06d2 WC \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0643\\u0631\\u0633\\u064a \\u0639\\u0631\\u0628\\u064a\",\"en\":\"Change eastern style WC\",\"ur\":\"\\u0639\\u0631\\u0628\\u06cc \\u0637\\u0631\\u0632 \\u06a9\\u06d2 WC \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 160.00, NULL, 'fixed', 1, '2021-12-08 15:44:51', NULL),
(52, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u063a\\u0637\\u0627\\u0621 \\u0643\\u0631\\u0633\\u064a \\u0627\\u0641\\u0631\\u0646\\u062c\\u064a\",\"en\":\"Change WC chair cover\",\"ur\":\"WC \\u06a9\\u0631\\u0633\\u06cc \\u06a9\\u0627 \\u06a9\\u0648\\u0648\\u0631 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u063a\\u0637\\u0627\\u0621 \\u0643\\u0631\\u0633\\u064a \\u0627\\u0641\\u0631\\u0646\\u062c\\u064a\",\"en\":\"Change WC chair cover\",\"ur\":\"WC \\u06a9\\u0631\\u0633\\u06cc \\u06a9\\u0627 \\u06a9\\u0648\\u0648\\u0631 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 30.00, NULL, 'fixed', 1, '2021-12-08 15:47:10', NULL),
(53, '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0643\\u0631\\u0633\\u064a \\u0627\\u0641\\u0631\\u0646\\u062c\\u064a \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Remove and install new WC chair\",\"ur\":\"\\u067e\\u0631\\u0627\\u0646\\u06cc WC \\u06a9\\u0631\\u0633\\u06cc \\u0643\\u0648 \\u0627\\u062a\\u0627\\u0631 \\u06a9\\u0631 \\u0646\\u0626\\u06cc \\u0643\\u0631\\u0633\\u064a \\u06a9\\u0648 \\u062a\\u0646\\u0635\\u06cc\\u0628 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0643\\u0631\\u0633\\u064a \\u0627\\u0641\\u0631\\u0646\\u062c\\u064a \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Remove and install new WC chair\",\"ur\":\"\\u067e\\u0631\\u0627\\u0646\\u06cc WC \\u06a9\\u0631\\u0633\\u06cc \\u0643\\u0648 \\u0627\\u062a\\u0627\\u0631 \\u06a9\\u0631 \\u0646\\u0626\\u06cc \\u0643\\u0631\\u0633\\u064a \\u06a9\\u0648 \\u062a\\u0646\\u0635\\u06cc\\u0628 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 110.00, NULL, 'fixed', 1, '2021-12-08 15:50:14', NULL),
(54, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0643\\u0631\\u0633\\u064a \\u0627\\u0641\\u0631\\u0646\\u062c\\u064a \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Install New WC chair\",\"ur\":\"\\u0646\\u0626\\u06cc WC \\u06a9\\u0631\\u0633\\u06cc \\u06a9\\u0648 \\u062a\\u0646\\u0635\\u06cc\\u0628 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0643\\u0631\\u0633\\u064a \\u0627\\u0641\\u0631\\u0646\\u062c\\u064a \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Install New WC chair\",\"ur\":\"\\u0646\\u0626\\u06cc WC \\u06a9\\u0631\\u0633\\u06cc \\u06a9\\u0648 \\u062a\\u0646\\u0635\\u06cc\\u0628 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 100.00, NULL, 'fixed', 1, '2021-12-08 15:51:57', NULL),
(55, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u064a\\u0641\\u0648\\u0646 WC\",\"en\":\"WC Siphon Installation\",\"ur\":\"WC \\u0633\\u06cc\\u0641\\u0648\\u0646 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0633\\u064a\\u0641\\u0648\\u0646 WC\",\"en\":\"WC Siphon Installation\",\"ur\":\"WC \\u0633\\u06cc\\u0641\\u0648\\u0646 \\u06a9\\u06cc \\u062a\\u0646\\u0635\\u06cc\\u0628\"}', 24, 50.00, NULL, 'fixed', 1, '2021-12-08 15:54:01', NULL),
(56, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0634\\u0637\\u0627\\u0641\",\"en\":\"Change Hand shower\",\"ur\":\"\\u0634\\u0637\\u0627\\u0641 \\u0643\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0634\\u0637\\u0627\\u0641\",\"en\":\"Change Hand shower\",\"ur\":\"\\u0634\\u0637\\u0627\\u0641 \\u0643\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 20.00, NULL, 'fixed', 1, '2021-12-08 15:56:06', NULL),
(57, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062e\\u0644\\u0627\\u0637 \\u062d\\u0648\\u0636 \\u0623\\u0648 \\u062c\\u062f\\u0627\\u0631\",\"en\":\"Change basin or wall mixer\",\"ur\":\"\\u0628\\u06cc\\u0633\\u0646 \\u06cc\\u0627 \\u0648\\u0627\\u0644 \\u0645\\u06a9\\u0633\\u0631 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062e\\u0644\\u0627\\u0637 \\u062d\\u0648\\u0636 \\u0623\\u0648 \\u062c\\u062f\\u0627\\u0631\",\"en\":\"Change basin or wall mixer\",\"ur\":\"\\u0628\\u06cc\\u0633\\u0646 \\u06cc\\u0627 \\u0648\\u0627\\u0644 \\u0645\\u06a9\\u0633\\u0631 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 40.00, NULL, 'fixed', 1, '2021-12-08 16:02:19', NULL),
(58, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0627\\u0643\\u064a\\u0646\\u0629 \\u0633\\u064a\\u0641\\u0648\\u0646\",\"en\":\"Change Siphon machine\",\"ur\":\"\\u0633\\u06cc\\u0641\\u0648\\u0646 \\u0645\\u0634\\u06cc\\u0646 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0627\\u0643\\u064a\\u0646\\u0629 \\u0633\\u064a\\u0641\\u0648\\u0646\",\"en\":\"Change Siphon machine\",\"ur\":\"\\u0633\\u06cc\\u0641\\u0648\\u0646 \\u0645\\u0634\\u06cc\\u0646 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 50.00, NULL, 'fixed', 1, '2021-12-08 16:04:08', NULL),
(59, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0635\\u0641\\u0627\\u064a\\u0629\",\"en\":\"Install or change filter\",\"ur\":\"\\u0641\\u0644\\u0679\\u0631 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0635\\u0641\\u0627\\u064a\\u0629\",\"en\":\"Install or change filter\",\"ur\":\"\\u0641\\u0644\\u0679\\u0631 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 24, 50.00, NULL, 'fixed', 1, '2021-12-08 16:06:04', NULL),
(60, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u062f\\u064a\\u0646\\u0645\\u0648\",\"en\":\"Install or change water motor\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06cc \\u0645\\u0648\\u0679\\u0631 \\u0644\\u06af\\u0627\\u0646\\u0627 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u062f\\u064a\\u0646\\u0645\\u0648\",\"en\":\"Install or change water motor\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06cc \\u0645\\u0648\\u0679\\u0631 \\u0644\\u06af\\u0627\\u0646\\u0627 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 26, 60.00, NULL, 'fixed', 1, '2021-12-08 16:07:44', NULL),
(61, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0639\\u0648\\u0627\\u0645\\u0629 \\u0627\\u0644\\u062e\\u0632\\u0627\\u0646\",\"en\":\"Change tank overflow stopper\",\"ur\":\"\\u0639\\u0648\\u0627\\u0645\\u0647 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0639\\u0648\\u0627\\u0645\\u0629 \\u0627\\u0644\\u062e\\u0632\\u0627\\u0646\",\"en\":\"Change tank overflow stopper\",\"ur\":\"\\u0639\\u0648\\u0627\\u0645\\u0647 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 26, 50.00, NULL, 'fixed', 1, '2021-12-08 16:09:52', NULL),
(62, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0644\\u062a\\u0631\\u0645\\u0633\\u062a\\u0627\\u062a \\u0627\\u0644\\u062e\\u0632\\u0627\\u0646\",\"en\":\"Change water tank thermostat\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06d2 \\u0679\\u06cc\\u0646\\u06a9 \\u06a9\\u0627 \\u062a\\u06be\\u0631\\u0645\\u0648\\u0633\\u0679\\u06cc\\u0679 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0644\\u062a\\u0631\\u0645\\u0633\\u062a\\u0627\\u062a \\u0627\\u0644\\u062e\\u0632\\u0627\\u0646\",\"en\":\"Change water tank thermostat\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u06d2 \\u0679\\u06cc\\u0646\\u06a9 \\u06a9\\u0627 \\u062a\\u06be\\u0631\\u0645\\u0648\\u0633\\u0679\\u06cc\\u0679 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 26, 200.00, NULL, 'fixed', 1, '2021-12-08 16:11:35', NULL),
(63, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0631\\u062f\\u0627\\u062f \\u0627\\u0644\\u0633\\u062e\\u0627\\u0646\",\"en\":\"Change Water heater responder\",\"ur\":\"\\u06af\\u06cc\\u0632\\u0631 \\u0643\\u0627 \\u0631\\u062f\\u0627\\u062f \\u062a\\u0628\\u062f\\u064a\\u0644 \\u0643\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0631\\u062f\\u0627\\u062f \\u0627\\u0644\\u0633\\u062e\\u0627\\u0646\",\"en\":\"Change Water heater responder\",\"ur\":\"\\u06af\\u06cc\\u0632\\u0631 \\u0643\\u0627 \\u0631\\u062f\\u0627\\u062f \\u062a\\u0628\\u062f\\u064a\\u0644 \\u0643\\u0631\\u0646\\u0627\"}', 28, 50.00, NULL, 'fixed', 1, '2021-12-08 16:29:23', NULL),
(64, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u064a\\u0628 \\u0633\\u062e\\u0627\\u0646 \\u0639\\u0627\\u062f\\u064a\",\"en\":\"Install normal water heater\",\"ur\":\"\\u0639\\u0627\\u0645 \\u0648\\u0627\\u0679\\u0631 \\u0647\\u06cc\\u0679\\u0631 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u064a\\u0628 \\u0633\\u062e\\u0627\\u0646 \\u0639\\u0627\\u062f\\u064a\",\"en\":\"Install normal water heater\",\"ur\":\"\\u0639\\u0627\\u0645 \\u0648\\u0627\\u0679\\u0631 \\u0647\\u06cc\\u0679\\u0631 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', 28, 50.00, NULL, 'fixed', 1, '2021-12-08 16:31:18', NULL),
(65, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0623\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0633\\u062e\\u0627\\u0646 \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Install or change hidden water heater\",\"ur\":\"\\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0648\\u0627\\u0679\\u0631 \\u0647\\u06cc\\u0679\\u0631 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0623\\u0648 \\u062a\\u063a\\u064a\\u064a\\u0631 \\u0633\\u062e\\u0627\\u0646 \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Install or change hidden water heater\",\"ur\":\"\\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0648\\u0627\\u0679\\u0631 \\u0647\\u06cc\\u0679\\u0631 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06cc\\u0627 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 28, 100.00, NULL, 'fixed', 1, '2021-12-08 16:51:50', NULL);
INSERT INTO `services` (`id`, `title`, `description`, `category_id`, `price`, `image`, `type`, `active`, `created_at`, `deleted_at`) VALUES
(66, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0642\\u0644\\u0628 \\u0633\\u062e\\u0627\\u0646 \\u0639\\u0627\\u062f\\u064a \\u0627\\u0648 \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Change heating rod for normal or hidden water heater\",\"ur\":\"\\u0646\\u0627\\u0631\\u0645\\u0644 \\u06cc\\u0627 \\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0648\\u0627\\u0679\\u0631 \\u0647\\u06cc\\u0679\\u0631 \\u06a9\\u06d2 \\u0644\\u06cc\\u06d2 \\u0647\\u06cc\\u0679\\u0646\\u06af \\u0631\\u0627\\u0688 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0642\\u0644\\u0628 \\u0633\\u062e\\u0627\\u0646 \\u0639\\u0627\\u062f\\u064a \\u0627\\u0648 \\u0645\\u062e\\u0641\\u064a\",\"en\":\"Change heating rod for normal or hidden water heater\",\"ur\":\"\\u0646\\u0627\\u0631\\u0645\\u0644 \\u06cc\\u0627 \\u067e\\u0648\\u0634\\u06cc\\u062f\\u06c1 \\u0648\\u0627\\u0679\\u0631 \\u0647\\u06cc\\u0679\\u0631 \\u06a9\\u06d2 \\u0644\\u06cc\\u06d2 \\u0647\\u06cc\\u0679\\u0646\\u06af \\u0631\\u0627\\u0688 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 28, 50.00, NULL, 'fixed', 1, '2021-12-08 16:55:02', NULL),
(67, '{\"ar\":\"\\u0645\\u0631\\u0627\\u0648\\u062d \\u0634\\u0641\\u0637 \\u0633\\u0642\\u0641\",\"en\":\"Install Exhaust fan on roof\",\"ur\":\"\\u0686\\u06be\\u062a \\u067e\\u0631 \\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', '{\"ar\":\"\\u0645\\u0631\\u0627\\u0648\\u062d \\u0634\\u0641\\u0637 \\u0633\\u0642\\u0641\",\"en\":\"Install Exhaust fan on roof\",\"ur\":\"\\u0686\\u06be\\u062a \\u067e\\u0631 \\u0627\\u06cc\\u06af\\u0632\\u0627\\u0633\\u0679 \\u0641\\u06cc\\u0646 \\u0644\\u06af\\u0627\\u0646\\u0627\"}', 23, 100.00, NULL, 'fixed', 1, '2021-12-08 17:00:29', NULL),
(68, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0634\\u0642\\u0629 \\u0635\\u063a\\u064a\\u0631\\u0629\",\"en\":\"Cleaning small apartment\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06d2 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679 \\u06a9\\u06d2 \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0627\\u0644\\u062e\\u062f\\u0645\\u0629 \\u064a\\u0634\\u0645\\u0644 ( 2\\u063a\\u0631\\u0641\\u0629+ \\u0645\\u0637\\u0628\\u062e+ \\u0635\\u0627\\u0644\\u0629+ 2 \\u062d\\u0645\\u0627\\u0645 )\",\"en\":\"The service includes ( 2 rooms + kitchen + lounge + 2 toilets )\",\"ur\":\"\\u0627\\u0633 \\u0633\\u0631\\u0648\\u0633 \\u0645\\u06cc\\u06ba \\u0634\\u0627\\u0645\\u0644 \\u06c1\\u06cc\\u06ba ( 2 \\u0631\\u0648\\u0645\\u0632 + \\u06a9\\u0686\\u0646 + \\u0644\\u0627\\u0624\\u0646\\u062c + 2 \\u0679\\u0627\\u06cc\\u0644\\u06cc\\u0679 )\"}', 31, 600.00, NULL, 'fixed', 1, '2021-12-08 17:56:39', NULL),
(69, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0634\\u0642\\u0629 \\u0645\\u062a\\u0648\\u0633\\u0637\\u0629\",\"en\":\"Cleaning Medium apartment\",\"ur\":\"\\u0645\\u06cc\\u0688\\u06cc\\u0645 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0627\\u0644\\u062e\\u062f\\u0645\\u0629 \\u064a\\u0634\\u0645\\u0644 \\u062a\\u0646\\u0638\\u064a\\u0641 (  3 \\u063a\\u0631\\u0641\\u0629 + \\u0645\\u062c\\u0644\\u0633 + \\u0635\\u0627\\u0644\\u0629 + \\u0645\\u0637\\u0628\\u062e + 3 \\u062d\\u0645\\u0627\\u0645\\u0627\\u062a )\",\"en\":\"The service includes cleaning for ( 3 rooms + drawing room + Lounge + kitchen + 3 toilets )\",\"ur\":\"\\u0633\\u0631\\u0648\\u0633 \\u0645\\u06cc\\u06ba (3 \\u06a9\\u0645\\u0631\\u06d2 + \\u0688\\u0631\\u0627\\u0626\\u0646\\u06af \\u0631\\u0648\\u0645 + \\u0644\\u0627\\u0624\\u0646\\u062c + \\u06a9\\u0686\\u0646 + 3 \\u0628\\u06cc\\u062a \\u0627\\u0644\\u062e\\u0644\\u0627\\u0621) \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0634\\u0627\\u0645\\u0644 \\u06c1\\u06d2\\u06d4\"}', 31, 800.00, NULL, 'fixed', 1, '2021-12-08 18:00:27', NULL),
(70, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0641\\u064a\\u0644\\u0627 \\u0635\\u063a\\u064a\\u0631\",\"en\":\"Cleaning small villa\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06d2 \\u0628\\u0646\\u06af\\u0644\\u06d2 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0641\\u064a\\u0644\\u0627 \\u0635\\u063a\\u064a\\u0631 \\u0645\\u0633\\u0627\\u062d\\u0629 250 \\u0645\",\"en\":\"Cleaning small villa (250 meters)\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06d2 \\u0628\\u0646\\u06af\\u0644\\u06d2 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc (250 \\u0645\\u06cc\\u0679\\u0631)\"}', 32, 1500.00, NULL, 'fixed', 1, '2021-12-08 18:04:23', NULL),
(71, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0641\\u064a\\u0644\\u0627 \\u0645\\u062a\\u0648\\u0633\\u0637\\u0629\",\"en\":\"Cleaning medium villa\",\"ur\":\"\\u0645\\u06cc\\u0688\\u06cc\\u0645 \\u0628\\u0646\\u06af\\u0644\\u06d2 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0641\\u064a\\u0644\\u0627 \\u0645\\u062a\\u0648\\u0633\\u0637\\u0629 \\u0645\\u0633\\u0627\\u062d\\u0629 ( 300 \\u0645 \\u0627\\u0644\\u064a 400 \\u0645 )\",\"en\":\"Cleaning medium villa ( 300 m to 400 m )\",\"ur\":\"\\u0645\\u06cc\\u0688\\u06cc\\u0645 \\u0628\\u0646\\u06af\\u0644\\u06d2 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc (300 \\u0645\\u06cc\\u0679\\u0631 \\u0633\\u06d2 400 \\u0645\\u06cc\\u0679\\u0631)\"}', 32, 2000.00, NULL, 'fixed', 1, '2021-12-08 18:08:09', NULL),
(72, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0641\\u064a\\u0644\\u0627 \\u0643\\u0628\\u064a\\u0631\",\"en\":\"Cleaning large villa\",\"ur\":\"\\u0628\\u0691\\u06d2 \\u0628\\u0646\\u06af\\u0644\\u06d2 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0641\\u064a\\u0644\\u0627 \\u0643\\u0628\\u064a\\u0631 \\u0645\\u0633\\u0627\\u062d\\u0629 ( 500 \\u0645 \\u0627\\u0644\\u064a 700 \\u0645 )\",\"en\":\"Cleaning large villa ( 500 m to 700 m )\",\"ur\":\"\\u0628\\u0691\\u06d2 \\u0628\\u0646\\u06af\\u0644\\u06d2 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc (500 \\u0645\\u06cc\\u0679\\u0631 \\u0633\\u06d2 700 \\u0645\\u06cc\\u0679\\u0631)\"}', 32, 2500.00, NULL, 'fixed', 1, '2021-12-08 18:10:54', NULL),
(73, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u062f\\u0648\\u0631 \\u0627\\u0631\\u0636\\u064a \\u0645\\u0639 \\u062d\\u0648\\u0634\",\"en\":\"Ground floor cleaning with front yard\",\"ur\":\"\\u0633\\u0627\\u0645\\u0646\\u06d2 \\u06a9\\u06d2 \\u0635\\u062d\\u0646 \\u06a9\\u06d2 \\u0633\\u0627\\u062a\\u06be \\u06af\\u0631\\u0627\\u0624\\u0646\\u0688 \\u0641\\u0644\\u0648\\u0631 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u062f\\u0648\\u0631 \\u0627\\u0631\\u0636\\u064a \\u0645\\u0639 \\u062d\\u0648\\u0634\",\"en\":\"Ground floor cleaning with front yard\",\"ur\":\"\\u0633\\u0627\\u0645\\u0646\\u06d2 \\u06a9\\u06d2 \\u0635\\u062d\\u0646 \\u06a9\\u06d2 \\u0633\\u0627\\u062a\\u06be \\u06af\\u0631\\u0627\\u0624\\u0646\\u0688 \\u0641\\u0644\\u0648\\u0631 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', 33, 1000.00, NULL, 'fixed', 1, '2021-12-08 18:14:49', NULL),
(74, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0637\\u0642\\u0645 \\u0643\\u0646\\u0628\",\"en\":\"Cleaning sofa set\",\"ur\":\"\\u0635\\u0648\\u0641\\u06c1 \\u0633\\u06cc\\u0679 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0637\\u0642\\u0645 \\u0643\\u0646\\u0628 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0639\\u0644\\u064a \\u0645\\u062a\\u0631\",\"en\":\"Cleaning sofa set amount per meter\",\"ur\":\"\\u0635\\u0648\\u0641\\u06c1 \\u0633\\u06cc\\u0679 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 21, 55.00, NULL, 'fixed', 1, '2021-12-08 18:18:41', NULL),
(75, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0643\\u0646\\u0628 \\u0645\\u062a\\u0635\\u0644\",\"en\":\"Cleaning connected sofa set\",\"ur\":\"\\u0645\\u0646\\u0633\\u0644\\u06a9 \\u0635\\u0648\\u0641\\u06c1 \\u0633\\u06cc\\u0679 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0643\\u0646\\u0628 \\u0645\\u062a\\u0635\\u0644 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0639\\u0644\\u064a \\u0645\\u062a\\u0631\",\"en\":\"Cleaning connected sofa set price per meter\",\"ur\":\"\\u0645\\u0646\\u0633\\u0644\\u06a9 \\u0635\\u0648\\u0641\\u06c1 \\u0633\\u06cc\\u0679 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 21, 50.00, NULL, 'fixed', 1, '2021-12-08 18:21:36', '2021-12-28 14:05:26'),
(76, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0645\\u062c\\u0644\\u0633 \\u0639\\u0631\\u0628\\u064a\",\"en\":\"Cleaning Arabic Majlis\",\"ur\":\"\\u0639\\u0631\\u0628\\u06cc \\u0645\\u062c\\u0644\\u0633 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0645\\u062c\\u0644\\u0633 \\u0639\\u0631\\u0628\\u064a \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0641\\u064a \\u0645\\u062a\\u0631\",\"en\":\"Cleaning Arabic Majlis price per meter\",\"ur\":\"\\u0639\\u0631\\u0628\\u06cc \\u0645\\u062c\\u0644\\u0633 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 21, 45.00, NULL, 'fixed', 1, '2021-12-08 18:24:23', NULL),
(77, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0645\\u0648\\u0643\\u064a\\u062a\",\"en\":\"Cleaning rugs\",\"ur\":\"\\u0642\\u0627\\u0644\\u06cc\\u0646 \\u0643\\u064a \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0645\\u0648\\u0643\\u064a\\u062a \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0641\\u064a \\u0645\\u062a\\u0631\",\"en\":\"Cleaning rugs price per meter\",\"ur\":\"\\u0642\\u0627\\u0644\\u06cc\\u0646 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 21, 8.00, NULL, 'fixed', 1, '2021-12-08 18:26:56', NULL),
(78, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0633\\u062a\\u0627\\u0631\\u0629\",\"en\":\"Cleaning curtains\",\"ur\":\"\\u067e\\u0631\\u062f\\u0648\\u06ba \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0633\\u062a\\u0627\\u0631\\u0629 \\u0633\\u0639\\u0631 \\u0627\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Cleaning curtains price per piece\",\"ur\":\"\\u067e\\u0631\\u062f\\u0648\\u06ba \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u067e\\u064a\\u0633\"}', 21, 65.00, NULL, 'fixed', 1, '2021-12-08 18:30:02', NULL),
(79, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0645\\u0631\\u062a\\u0628\\u0629 \\u0627\\u0644\\u0633\\u0631\\u064a\\u0631\",\"en\":\"Cleaning mattress\",\"ur\":\"\\u06af\\u062f\\u062f\\u06d2 \\u0643\\u064a \\u0635\\u0641\\u0627\\u0626\\u064a\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0645\\u0631\\u062a\\u0628\\u0629 \\u0627\\u0644\\u0633\\u0631\\u064a\\u0631 \\u0633\\u0639\\u0631 \\u0644\\u0644\\u062d\\u0628\\u0629\",\"en\":\"Cleaning mattress price per piece\",\"ur\":\"\\u06af\\u062f\\u062f\\u06d2 \\u0643\\u064a \\u0635\\u0641\\u0627\\u0626\\u064a \\u0642\\u064a\\u0645\\u062a \\u0641\\u064a \\u067e\\u06cc\\u0633\"}', 21, 90.00, NULL, 'fixed', 1, '2021-12-08 18:36:08', NULL),
(80, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0634\\u0628\\u0627\\u0643 \\u0627\\u0644\\u0635\\u063a\\u064a\\u0631\",\"en\":\"Cleaning small window\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06cc \\u06a9\\u06be\\u0691\\u06a9\\u06cc \\u0643\\u064a \\u0635\\u0641\\u0627\\u0626\\u064a\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0634\\u0628\\u0627\\u0643 \\u0627\\u0644\\u0635\\u063a\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0633\\u0627\\u062d\\u0629 ( 1\\u0645 * 1.20 \\u0645 )\",\"en\":\"Cleaning small window size ( 1m * 1.20m )\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06cc \\u06a9\\u06be\\u0691\\u06a9\\u06cc \\u0643\\u064a \\u0635\\u0641\\u0627\\u0626\\u064a \\u0633\\u0627\\u0626\\u0632 (1m*1.20m)\"}', 21, 40.00, NULL, 'fixed', 1, '2021-12-08 18:39:54', NULL),
(81, '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0634\\u0628\\u0627\\u0643 \\u0627\\u0644\\u0643\\u0628\\u064a\\u0631\",\"en\":\"Cleaning large window\",\"ur\":\"\\u0628\\u0691\\u06cc \\u06a9\\u06be\\u0691\\u06a9\\u06cc \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u0646\\u0638\\u0627\\u0641\\u0629 \\u0634\\u0628\\u0627\\u0643 \\u0627\\u0644\\u0643\\u0628\\u064a\\u0631 \\u0645\\u0633\\u0627\\u062d\\u0629 ( 2\\u0645 * 1.5\\u0645 )\",\"en\":\"Cleaning large window size ( 2m * 1.5m )\",\"ur\":\"\\u0628\\u0691\\u06cc \\u06a9\\u06be\\u0691\\u06a9\\u06cc \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0633\\u0627\\u0626\\u0632 (2m * 1.5m)\"}', 21, 60.00, NULL, 'fixed', 1, '2021-12-08 18:44:13', NULL),
(82, '{\"ar\":\"\\u062a\\u0644\\u0645\\u064a\\u0639 \\u0627\\u0644\\u0623\\u0631\\u0636\\u064a\\u0627\\u062a\",\"en\":\"Floor polishing\",\"ur\":\"\\u0641\\u0631\\u0634 \\u067e\\u0627\\u0644\\u0634 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0644\\u0645\\u064a\\u0639 \\u0627\\u0644\\u0623\\u0631\\u0636\\u064a\\u0627\\u062a \\u0633\\u0639\\u0631 \\u0641\\u064a \\u0645\\u062a\\u0631\",\"en\":\"Floor polishing price per meter\",\"ur\":\"\\u0641\\u0631\\u0634 \\u067e\\u0627\\u0644\\u0634 \\u06a9\\u0631\\u0646\\u0627 \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 21, 5.00, NULL, 'fixed', 1, '2021-12-08 18:46:50', NULL),
(83, '{\"ar\":\"\\u062a\\u0646\\u0638\\u064a\\u0641 \\u0645\\u0633\\u0628\\u062d\",\"en\":\"Pool Cleaning\",\"ur\":\"\\u067e\\u0648\\u0644 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u062a\\u0646\\u0638\\u064a\\u0641 \\u0645\\u0633\\u0628\\u062d \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0628\\u0627\\u0644\\u0645\\u062a\\u0631\",\"en\":\"Pool Cleaning price per meter\",\"ur\":\"\\u067e\\u0648\\u0644 \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 33, 30.00, NULL, 'fixed', 1, '2021-12-08 18:48:13', NULL),
(84, '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u062d\\u0648\\u0634\",\"en\":\"Cleaning front yard\",\"ur\":\"\\u0633\\u0627\\u0645\\u0646\\u06d2 \\u06a9\\u0627 \\u0635\\u062d\\u0646 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u062d\\u0648\\u0634 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0628\\u0627\\u0644\\u0645\\u062a\\u0631\",\"en\":\"Cleaning front yard price per meter\",\"ur\":\"\\u0633\\u0627\\u0645\\u0646\\u06d2 \\u06a9\\u0627 \\u0635\\u062d\\u0646 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627 \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 33, 5.00, NULL, 'fixed', 1, '2021-12-13 16:39:07', NULL),
(85, '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0633\\u0637\\u062d\",\"en\":\"Roof Cleaning\",\"ur\":\"\\u0686\\u06be\\u062a \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc\"}', '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0633\\u0637\\u062d \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0628\\u0627\\u0644\\u0645\\u062a\\u0631\",\"en\":\"Roof Cleaning price per meter\",\"ur\":\"\\u0686\\u06be\\u062a \\u06a9\\u06cc \\u0635\\u0641\\u0627\\u0626\\u06cc \\u0642\\u06cc\\u0645\\u062a \\u0641\\u06cc \\u0645\\u06cc\\u0679\\u0631\"}', 33, 5.00, NULL, 'fixed', 1, '2021-12-13 16:43:17', NULL),
(86, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u064a\\u0645 \\u0634\\u0642\\u0629 \\u0635\\u063a\\u064a\\u0631\\u0629\",\"en\":\"Sanitize small apartment\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06d2 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679 \\u0643\\u0648 \\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u0643\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u064a\\u0645 \\u0634\\u0642\\u0629 \\u0635\\u063a\\u064a\\u0631\\u0629 \\u064a\\u0634\\u0645\\u0644 ( 2\\u063a\\u0631\\u0641\\u0629+ \\u0645\\u0637\\u0628\\u062e+ \\u0635\\u0627\\u0644\\u0629+ 2 \\u062d\\u0645\\u0627\\u0645 )\",\"en\":\"Sanitize small apartment contains (2 rooms + 2 toilets + lounge + kitchen)\",\"ur\":\"\\u0686\\u06be\\u0648\\u0679\\u06d2 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679 \\u0643\\u0648 \\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u0643\\u0631\\u0646\\u0627 \\u062c\\u0633 \\u0645\\u06cc\\u06ba \\u0645\\u0634\\u062a\\u0645\\u0644 \\u06c1\\u06d2 (2 \\u06a9\\u0645\\u0631\\u06d2 + 2 \\u0628\\u06cc\\u062a \\u0627\\u0644\\u062e\\u0644\\u0627 + \\u0644\\u0627\\u0624\\u0646\\u062c + \\u06a9\\u0686\\u0646)\"}', 34, 370.00, NULL, 'fixed', 1, '2021-12-13 17:22:15', NULL),
(87, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u064a\\u0645 \\u0634\\u0642\\u0629 \\u0645\\u062a\\u0648\\u0633\\u0637\\u0629\",\"en\":\"Sanitize medium apartment\",\"ur\":\"\\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u0645\\u06cc\\u0688\\u06cc\\u0645 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679\"}', '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u064a\\u0645 \\u0634\\u0642\\u0629 \\u0645\\u062a\\u0648\\u0633\\u0637\\u0629 \\u064a\\u0634\\u0645\\u0644 ( 3\\u063a\\u0631\\u0641\\u0629+ \\u0645\\u062c\\u0644\\u0633+ \\u0635\\u0627\\u0644\\u0629+ \\u0645\\u0637\\u0628\\u062e+3 \\u062d\\u0645\\u0627\\u0645\\u0627\\u062a)\",\"en\":\"Sanitize medium apartment contains (3 rooms + drawing room + lounge + kitchen + 3 toilets)\",\"ur\":\"\\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u0645\\u06cc\\u0688\\u06cc\\u0645 \\u0627\\u067e\\u0627\\u0631\\u0679\\u0645\\u0646\\u0679 \\u0645\\u06cc\\u06ba \\u0645\\u0634\\u062a\\u0645\\u0644 \\u06c1\\u06d2 (3 \\u06a9\\u0645\\u0631\\u06d2 + \\u0688\\u0631\\u0627\\u0626\\u0646\\u06af \\u0631\\u0648\\u0645 + \\u0644\\u0627\\u0624\\u0646\\u062c + \\u06a9\\u0686\\u0646 + 3 \\u0628\\u06cc\\u062a \\u0627\\u0644\\u062e\\u0644\\u0627)\"}', 39, 420.00, NULL, 'fixed', 1, '2021-12-13 17:28:55', NULL),
(88, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u064a\\u0645 \\u062f\\u0648\\u0631\",\"en\":\"Sanitize floor\",\"ur\":\"\\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u0641\\u0644\\u0648\\u0631\"}', '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u064a\\u0645 \\u062f\\u0648\\u0631\",\"en\":\"Sanitize floor\",\"ur\":\"\\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u0641\\u0644\\u0648\\u0631\"}', 43, 500.00, NULL, 'fixed', 1, '2021-12-13 17:33:13', NULL),
(89, '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u0645 \\u0641\\u064a\\u0644\\u0627\",\"en\":\"Sanitize villa\",\"ur\":\"\\u0648\\u0644\\u0627 \\u06a9\\u0648 \\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u06a9\\u0631\\u06cc\\u06ba\\u06d4\"}', '{\"ar\":\"\\u062a\\u0639\\u0642\\u064a\\u0645 \\u0641\\u064a\\u0644\\u0627 \\u0645\\u0633\\u0627\\u062d\\u0629 500\\u0645 \\u0623\\u0648 \\u0627\\u0642\\u0644\",\"en\":\"Sanitize Villa dimensions 500 meter or less\",\"ur\":\"500 \\u0645\\u06cc\\u0679\\u0631 \\u06cc\\u0627 \\u0627\\u0633 \\u0633\\u06d2 \\u06a9\\u0645 \\u0648\\u0644\\u0627 \\u06a9\\u06d2 \\u0637\\u0648\\u0644 \\u0648 \\u0639\\u0631\\u0636 \\u06a9\\u0648 \\u0633\\u06cc\\u0646\\u06cc\\u0679\\u0627\\u0626\\u0632 \\u06a9\\u0631\\u0646\\u0627\"}', 40, 700.00, NULL, 'fixed', 1, '2021-12-13 17:37:04', NULL),
(90, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0643\\u064a\\u0641 \\u0634\\u0628\\u0627\\u0643 - \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Install Window AC - New\",\"ur\":\"\\u0648\\u0646\\u0688\\u0648 \\u0627\\u06d2 \\u0633\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 - \\u0646\\u06cc\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0643\\u064a\\u0641 \\u0634\\u0628\\u0627\\u0643 - \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Install Window AC - New\",\"ur\":\"\\u0648\\u0646\\u0688\\u0648 \\u0627\\u06d2 \\u0633\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 - \\u0646\\u06cc\\u0627\"}', 36, 110.00, NULL, 'fixed', 1, '2021-12-14 13:27:18', NULL),
(91, '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0633\\u0628\\u0644\\u062a \\u062c\\u062f\\u064a\\u062f\",\"en\":\"Installing Split AC - New\",\"ur\":\"\\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06d2 \\u0633\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 - \\u0646\\u06cc\\u0627\"}', '{\"ar\":\"\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0627\\u0633\\u0628\\u0644\\u062a \\u062c\\u062f\\u064a\\u062f \\u0628\\u062f\\u0648\\u0646 \\u062a\\u0645\\u062f\\u064a\\u062f \\u062f\\u0627\\u062e\\u0644\\u064a\",\"en\":\"Installing split ac new without extensions\",\"ur\":\"\\u0627\\u06cc\\u06a9\\u0633\\u0679\\u06cc\\u0646\\u0634\\u0646 \\u06a9\\u06d2 \\u0628\\u063a\\u06cc\\u0631 \\u0646\\u06cc\\u0627 \\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06d2 \\u0633\\u06cc \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 36, 250.00, NULL, 'fixed', 1, '2021-12-14 13:44:48', NULL),
(92, '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0648\\u0646\\u0642\\u0644 \\u0645\\u0643\\u064a\\u0641 \\u0627\\u0633\\u0628\\u0644\\u062a\",\"en\":\"Dismantling, installing and transferring split air conditioner\",\"ur\":\"\\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u0631 \\u06a9\\u0648 \\u0627\\u062a\\u0627\\u0631\\u0646\\u0627\\u060c \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u0627\\u0648\\u0631 \\u0645\\u0646\\u062a\\u0642\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0648\\u0646\\u0642\\u0644 \\u0645\\u0643\\u064a\\u0641 \\u0627\\u0633\\u0628\\u0644\\u062a \\u0645\\u0646 \\u062f\\u0648\\u0646 \\u0627\\u0644\\u062a\\u0645\\u062f\\u064a\\u062f\\u0627\\u062a\",\"en\":\"Dismantling, installing and transferring split air conditioner without extensions\",\"ur\":\"\\u0628\\u063a\\u06cc\\u0631 \\u06a9\\u0633\\u06cc \\u062a\\u0648\\u0633\\u06cc\\u0639 \\u06a9\\u06d2 \\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u0631 \\u06a9\\u0648 \\u062e\\u062a\\u0645 \\u06a9\\u0631\\u0646\\u0627\\u060c \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u0627\\u0648\\u0631 \\u0645\\u0646\\u062a\\u0642\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 36, 250.00, NULL, 'fixed', 1, '2021-12-14 13:47:32', NULL),
(93, '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0648\\u0646\\u0642\\u0644 \\u0645\\u0643\\u064a\\u0641 \\u0627\\u0633\\u0628\\u0644\\u062a\",\"en\":\"Dismantling, installing and transferring a split air conditioner\",\"ur\":\"\\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u0631 \\u06a9\\u0648 \\u0627\\u062a\\u0627\\u0631\\u0646\\u0627\\u060c \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u0627\\u0648\\u0631 \\u0645\\u0646\\u062a\\u0642\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0648\\u0646\\u0642\\u0644 \\u0645\\u0643\\u064a\\u0641 \\u0627\\u0633\\u0628\\u0644\\u062a \\u0645\\u0639 \\u0627\\u0644\\u062a\\u0645\\u062f\\u064a\\u062f\\u0627\\u062a (\\u0645\\u0627 \\u064a\\u0634\\u0645\\u0644 \\u0642\\u0637\\u0639 \\u0627\\u0644\\u063a\\u064a\\u0627\\u0631)\",\"en\":\"Dismantling, installing and transferring a split air conditioner with extensions\",\"ur\":\"\\u0627\\u06cc\\u06a9\\u0633\\u0679\\u06cc\\u0646\\u0634\\u0646 \\u06a9\\u06d2 \\u0633\\u0627\\u062a\\u06be \\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u0631 \\u06a9\\u0648 \\u0627\\u062a\\u0627\\u0631\\u0646\\u0627\\u060c \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u0627\\u0648\\u0631 \\u0645\\u0646\\u062a\\u0642\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 36, 350.00, NULL, 'fixed', 1, '2021-12-14 13:51:35', NULL),
(94, '{\"ar\":\"\\u0641\\u0643 \\u0645\\u0643\\u064a\\u0641 \\u0627\\u0633\\u0628\\u0644\\u062a\",\"en\":\"Dismantle Split AC\",\"ur\":\"\\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u0631 \\u06a9\\u0648 \\u0627\\u062a\\u0627\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0641\\u0643 \\u0645\\u0643\\u064a\\u0641 \\u0627\\u0633\\u0628\\u0644\\u062a\",\"en\":\"Dismantle Split AC\",\"ur\":\"\\u0627\\u0633\\u067e\\u0644\\u0679 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u0631 \\u06a9\\u0648 \\u0627\\u062a\\u0627\\u0631\\u0646\\u0627\"}', 36, 110.00, NULL, 'fixed', 1, '2021-12-14 13:53:18', NULL),
(95, '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0645\\u0643\\u064a\\u0641\",\"en\":\"Clean Window AC\",\"ur\":\"\\u0648\\u0646\\u0688\\u0648 \\u0627\\u06d2 \\u0633\\u06cc \\u06a9\\u0648 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0645\\u0643\\u064a\\u0641 \\u0641\\u0642\\u0637\",\"en\":\"Clean Window AC\",\"ur\":\"\\u0648\\u0646\\u0688\\u0648 \\u0627\\u06d2 \\u0633\\u06cc \\u06a9\\u0648 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627\"}', 35, 70.00, NULL, 'fixed', 1, '2021-12-14 13:57:07', NULL),
(96, '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0645\\u0643\\u064a\\u0646\\u0647 \\u062f\\u0627\\u062e\\u0644\\u064a\\u0647 \\u0648 \\u062e\\u0627\\u0631\\u062c\\u064a\\u0647\",\"en\":\"Clean Indoor and Outdoor Unit\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u0627\\u0648\\u0631 \\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u06cc\\u0648\\u0646\\u0679 \\u06a9\\u0648 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0645\\u0643\\u064a\\u0646\\u0647 \\u062f\\u0627\\u062e\\u0644\\u064a\\u0647 \\u0648 \\u062e\\u0627\\u0631\\u062c\\u064a\\u0647\",\"en\":\"Clean Indoor and Outdoor Unit\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u0627\\u0648\\u0631 \\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u06cc\\u0648\\u0646\\u0679 \\u06a9\\u0648 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627\"}', 19, 120.00, NULL, 'fixed', 1, '2021-12-14 14:06:25', NULL),
(97, '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0645\\u0643\\u064a\\u0646\\u0647 \\u062f\\u0627\\u062e\\u0644\\u064a\\u0647 \\u0623\\u0648 \\u062e\\u0627\\u0631\\u062c\\u064a\\u0647\",\"en\":\"Clean Indoor or Outdoor Unit\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u06cc\\u0627 \\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u06cc\\u0648\\u0646\\u0679 \\u06a9\\u0648 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u063a\\u0633\\u064a\\u0644 \\u0645\\u0643\\u064a\\u0646\\u0647 \\u062f\\u0627\\u062e\\u0644\\u064a\\u0647 \\u0623\\u0648 \\u062e\\u0627\\u0631\\u062c\\u064a\\u0647\",\"en\":\"Clean Indoor or Outdoor Unit\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u06cc\\u0627 \\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u06cc\\u0648\\u0646\\u0679 \\u06a9\\u0648 \\u0635\\u0627\\u0641 \\u06a9\\u0631\\u0646\\u0627\"}', 19, 100.00, NULL, 'fixed', 1, '2021-12-14 14:07:46', NULL),
(98, '{\"ar\":\"\\u062a\\u0633\\u0631\\u064a\\u0628 \\u0645\\u0648\\u064a\\u0647\",\"en\":\"Water Leakage\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u0627 \\u0644\\u064a\\u0643\\u064a\\u062c\"}', '{\"ar\":\"\\u062a\\u0633\\u0631\\u064a\\u0628 \\u0645\\u0648\\u064a\\u0647\",\"en\":\"Water Leakage\",\"ur\":\"\\u067e\\u0627\\u0646\\u06cc \\u06a9\\u0627 \\u0644\\u064a\\u0643\\u064a\\u062c\"}', 19, 120.00, NULL, 'fixed', 1, '2021-12-14 14:10:07', NULL),
(99, '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0647\\u0646\\u062f\\u064a\",\"en\":\"Indian Freon Filling\",\"ur\":\"\\u0627\\u0646\\u0688\\u06cc\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0647\\u0646\\u062f\\u064a\",\"en\":\"Indian Freon Filling\",\"ur\":\"\\u0627\\u0646\\u0688\\u06cc\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', 35, 180.00, NULL, 'fixed', 1, '2021-12-14 14:11:27', NULL),
(100, '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0623\\u0645\\u0631\\u064a\\u0643\\u064a\",\"en\":\"American Freon Filling\",\"ur\":\"\\u0627\\u0645\\u0631\\u06cc\\u06a9\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0623\\u0645\\u0631\\u064a\\u0643\\u064a\",\"en\":\"American Freon Filling\",\"ur\":\"\\u0627\\u0645\\u0631\\u06cc\\u06a9\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', 35, 260.00, NULL, 'fixed', 1, '2021-12-14 14:12:29', NULL),
(101, '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0647\\u0646\\u062f\\u064a\",\"en\":\"Indian Freon Filling\",\"ur\":\"\\u0627\\u0646\\u0688\\u06cc\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0647\\u0646\\u062f\\u064a - \\u0646\\u0635 \\u062a\\u0639\\u0628\\u0626\\u0629\",\"en\":\"Indian Freon Filling - half filling\",\"ur\":\"\\u0627\\u0646\\u0688\\u06cc\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af - \\u0622\\u062f\\u06be\\u06cc \\u0641\\u0644\\u0646\\u06af\"}', 19, 90.00, NULL, 'fixed', 1, '2021-12-14 14:15:32', NULL),
(102, '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0647\\u0646\\u062f\\u064a\",\"en\":\"Indian Freon Filling\",\"ur\":\"\\u0627\\u0646\\u0688\\u06cc\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0647\\u0646\\u062f\\u064a - \\u062a\\u0639\\u0628\\u0626\\u0629 \\u0643\\u0627\\u0645\\u0644\\u0629\",\"en\":\"Indian Freon Filling - full filling\",\"ur\":\"\\u0627\\u0646\\u0688\\u06cc\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af - \\u0641\\u0644 \\u0641\\u0644\\u0646\\u06af\"}', 19, 180.00, NULL, 'fixed', 1, '2021-12-14 14:16:49', NULL),
(103, '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0623\\u0645\\u0631\\u064a\\u0643\\u064a\",\"en\":\"American Freon Filling\",\"ur\":\"\\u0627\\u0645\\u0631\\u06cc\\u06a9\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0623\\u0645\\u0631\\u064a\\u0643\\u064a - \\u0646\\u0635 \\u062a\\u0639\\u0628\\u0626\\u0629\",\"en\":\"American Freon Filling - half filling\",\"ur\":\"\\u0627\\u0645\\u0631\\u06cc\\u06a9\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af \\u0622\\u062f\\u06be\\u06cc \\u0641\\u0644\\u0646\\u06af\"}', 19, 150.00, NULL, 'fixed', 1, '2021-12-14 14:19:27', NULL),
(104, '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0623\\u0645\\u0631\\u064a\\u0643\\u064a\",\"en\":\"American Freon Filling\",\"ur\":\"\\u0627\\u0645\\u0631\\u06cc\\u06a9\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af\"}', '{\"ar\":\"\\u062a\\u0639\\u0628\\u0626\\u0629 \\u0641\\u0631\\u064a\\u0648\\u0646 \\u0623\\u0645\\u0631\\u064a\\u0643\\u064a - \\u062a\\u0639\\u0628\\u0626\\u0629 \\u0643\\u0627\\u0645\\u0644\\u0629\",\"en\":\"American Freon Filling - full filling\",\"ur\":\"\\u0627\\u0645\\u0631\\u06cc\\u06a9\\u0646 \\u0641\\u0631\\u06cc\\u0648\\u0646 \\u0641\\u0644\\u0646\\u06af \\u0641\\u0644 \\u0641\\u0644\\u0646\\u06af\"}', 19, 260.00, NULL, 'fixed', 1, '2021-12-14 14:21:18', NULL),
(105, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062f\\u064a\\u0646\\u0645\\u0648\",\"en\":\"Changing dynamo\",\"ur\":\"\\u0688\\u0627\\u0626\\u0646\\u0645\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062f\\u064a\\u0646\\u0645\\u0648 \\u0645\\u0643\\u064a\\u0646\\u0647 \\u062e\\u0627\\u0631\\u062c\\u064a\",\"en\":\"Changing dynamo for external unit\",\"ur\":\"\\u0688\\u0627\\u0626\\u0646\\u0645\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u0628\\u06cc\\u0631\\u0648\\u0646\\u06cc \\u06cc\\u0648\\u0646\\u0679 \\u0643\\u0627\"}', 19, 150.00, NULL, 'fixed', 1, '2021-12-14 14:23:30', NULL),
(106, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062f\\u064a\\u0646\\u0645\\u0648\",\"en\":\"Change Dynamo\",\"ur\":\"\\u0688\\u0627\\u0626\\u0646\\u0645\\u0648 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u062f\\u064a\\u0646\\u0645\\u0648 \\u0645\\u0643\\u064a\\u0646\\u0647 \\u062f\\u0627\\u062e\\u0644\\u064a\",\"en\":\"Change Dynamo for internal unit\",\"ur\":\"\\u0688\\u0627\\u0626\\u0646\\u0645\\u0648 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u0627\\u0646\\u062f\\u0631\\u0648\\u0646\\u06cc \\u06cc\\u0648\\u0646\\u0679 \\u0643\\u0627\"}', 19, 150.00, NULL, 'fixed', 1, '2021-12-14 14:25:11', NULL),
(107, '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u062e\\u0627\\u0631\\u062c\\u064a\\u0629\",\"en\":\"Open and Reinstall Outdoor Fan\",\"ur\":\"\\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u0641\\u06cc\\u0646 \\u0643\\u0648 \\u062a\\u0628\\u062f\\u064a\\u0644 \\u0643\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0631\\u0648\\u062d\\u0629 \\u062e\\u0627\\u0631\\u062c\\u064a\\u0629\",\"en\":\"Open and Reinstall Outdoor Fan\",\"ur\":\"\\u0622\\u0624\\u0679 \\u0688\\u0648\\u0631 \\u0641\\u06cc\\u0646 \\u0643\\u0648 \\u062a\\u0628\\u062f\\u064a\\u0644 \\u0643\\u0631\\u0646\\u0627\"}', 19, 150.00, NULL, 'fixed', 1, '2021-12-14 14:27:19', NULL),
(108, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0628\\u0644\\u0648\\u0631\",\"en\":\"Change indoor Blower\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u0628\\u0644\\u0648\\u0631 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0628\\u0644\\u0648\\u0631 \\u062f\\u0627\\u062e\\u0644\\u064a\",\"en\":\"Change indoor Blower\",\"ur\":\"\\u0627\\u0646\\u0688\\u0648\\u0631 \\u0628\\u0644\\u0648\\u0631 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 19, 150.00, NULL, 'fixed', 1, '2021-12-14 14:29:11', NULL),
(109, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0648\\u062d\\u0629 \\u0627\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a\\u0629\",\"en\":\"Change Electronic Kit\",\"ur\":\"\\u0627\\u0644\\u06cc\\u06a9\\u0679\\u0631\\u0627\\u0646\\u06a9 \\u06a9\\u0679 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0644\\u0648\\u062d\\u0629 \\u0627\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a\\u0629\",\"en\":\"Change Electronic Kit\",\"ur\":\"\\u0627\\u0644\\u06cc\\u06a9\\u0679\\u0631\\u0627\\u0646\\u06a9 \\u06a9\\u0679 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 19, 130.00, NULL, 'fixed', 1, '2021-12-14 14:30:18', NULL),
(110, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0643\\u062a\\u0646 , \\u0628\\u0648\\u0628\\u064a\\u0646\\u0647 \\u0627\\u0648 \\u0643\\u0648\\u0628\\u0633\\u062a\\u0631\",\"en\":\"Change contactor , capacitor or transformer\",\"ur\":\"\\u06a9\\u0648\\u0646\\u062a\\u06a9\\u0679\\u0648\\u0631 , \\u06a9\\u06cc\\u067e\\u0633\\u06cc\\u0679\\u0631 \\u06cc\\u0627 \\u0679\\u0631\\u0627\\u0646\\u0633\\u0641\\u0627\\u0631\\u0645\\u0631 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0645\\u0643\\u062a\\u0646 , \\u0628\\u0648\\u0628\\u064a\\u0646\\u0647 \\u0627\\u0648 \\u0643\\u0648\\u0628\\u0633\\u062a\\u0631\",\"en\":\"Change contactor , capacitor or transformer\",\"ur\":\"\\u06a9\\u0648\\u0646\\u062a\\u06a9\\u0679\\u0648\\u0631 , \\u06a9\\u06cc\\u067e\\u0633\\u06cc\\u0679\\u0631 \\u06cc\\u0627 \\u0679\\u0631\\u0627\\u0646\\u0633\\u0641\\u0627\\u0631\\u0645\\u0631 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 19, 80.00, NULL, 'fixed', 1, '2021-12-14 14:33:32', NULL),
(111, '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0643\\u064a\\u0641 \\u0634\\u0628\\u0627\\u0643 \\u0648\\u0646\\u0642\\u0644\\u0647 \\u062f\\u0627\\u062e\\u0644 \\u0627\\u0644\\u0645\\u0646\\u0632\\u0644\",\"en\":\"Dismantling and installing a window ac\",\"ur\":\"\\u0648\\u0646\\u0688\\u0648 \\u0627\\u06d2 \\u0633\\u06cc \\u06a9\\u0648 \\u0627\\u062a\\u0627\\u0631\\u0646\\u0627 \\u0627\\u0648\\u0631 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u0641\\u0643 \\u0648\\u062a\\u0631\\u0643\\u064a\\u0628 \\u0645\\u0643\\u064a\\u0641 \\u0634\\u0628\\u0627\\u0643 \\u0648\\u0646\\u0642\\u0644\\u0647 \\u062f\\u0627\\u062e\\u0644 \\u0627\\u0644\\u0645\\u0646\\u0632\\u0644\",\"en\":\"Dismantling and installing a window air conditioner and moving it inside the house\",\"ur\":\"\\u0648\\u0646\\u0688\\u0648 \\u0627\\u06cc\\u0626\\u0631 \\u06a9\\u0646\\u0688\\u06cc\\u0634\\u0646\\u0631 \\u06a9\\u0648 \\u0627\\u062a\\u0627\\u0631\\u0646\\u0627 \\u0627\\u0648\\u0631 \\u0627\\u0646\\u0633\\u0679\\u0627\\u0644 \\u06a9\\u0631\\u0646\\u0627 \\u0627\\u0648\\u0631 \\u0627\\u0633\\u06d2 \\u06af\\u06be\\u0631 \\u06a9\\u06d2 \\u0627\\u0646\\u062f\\u0631 \\u0645\\u0646\\u062a\\u0642\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 36, 150.00, NULL, 'fixed', 1, '2021-12-14 14:36:07', NULL),
(112, '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0646\\u0627\\u0631\\u0629 \\u0646\\u064a\\u0648\\u0646\",\"en\":\"Change neon light\",\"ur\":\"\\u0646\\u06cc\\u06cc\\u0646 \\u0644\\u0627\\u0626\\u0679 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', '{\"ar\":\"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0627\\u0646\\u0627\\u0631\\u0629 \\u0646\\u064a\\u0648\\u0646\",\"en\":\"Change neon light\",\"ur\":\"\\u0646\\u06cc\\u06cc\\u0646 \\u0644\\u0627\\u0626\\u0679 \\u06a9\\u0648 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u0646\\u0627\"}', 2, 6.00, NULL, 'fixed', 1, '2021-12-27 12:39:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`) VALUES
(1, 'meta_desc', NULL, '2021-08-18 10:33:48'),
(2, 'meta_keyword', NULL, '2021-08-18 10:33:48'),
(3, 'sitename', NULL, '2021-08-18 10:33:48'),
(4, 'address', NULL, '2021-08-18 10:33:49'),
(5, 'email', NULL, '2021-08-18 10:33:49'),
(6, 'phone', NULL, '2021-08-18 10:33:49'),
(7, 'site_name', NULL, '2021-08-18 10:47:59'),
(8, 'tax', '15', '2021-08-18 21:22:33'),
(9, 'mini_order_charge', '50', '2021-08-18 21:22:33'),
(10, 'mini_order_charge_paid', '25', '2021-08-18 21:22:33'),
(11, 'preview_value', '30', '2021-08-18 21:22:33'),
(12, 'whatsapp', NULL, '2021-08-18 21:22:33'),
(13, 'phone2', NULL, '2021-08-18 21:22:33'),
(14, 'map_key', 'AIzaSyBg5UMAfG17im_peICbIY9dy442ejYo8ng', '2021-08-18 21:22:33'),
(15, 'lat', NULL, '2021-08-18 21:22:33'),
(16, 'lng', NULL, '2021-08-18 21:22:33'),
(17, 'smtp_type', NULL, '2021-08-18 21:22:33'),
(18, 'smtp_username', NULL, '2021-08-18 21:22:33'),
(19, 'smtp_password', NULL, '2021-08-18 21:22:33'),
(20, 'smtp_sender_email', NULL, '2021-08-18 21:22:33'),
(21, 'smtp_sender_name', NULL, '2021-08-18 21:22:33'),
(22, 'smtp_port', NULL, '2021-08-18 21:22:33'),
(23, 'smtp_host', NULL, '2021-08-18 21:22:33'),
(24, 'smtp_encryption', NULL, '2021-08-18 21:22:33'),
(25, 'token', NULL, '2021-08-18 21:22:33'),
(26, 'googleStore', NULL, '2021-08-24 21:00:16'),
(27, 'appleStore', NULL, '2021-08-24 21:00:16'),
(28, 'into_video', NULL, '2021-08-24 21:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `image`, `city_id`, `active`, `created_at`, `deleted_at`) VALUES
(1, 'home', '16338580763932825.jpeg', 1, 1, '2021-10-10 10:27:56', '2021-10-10 10:28:52'),
(2, 'الصوره الاولي', '16338614772407927.jpg', 1, 0, '2021-10-10 11:24:37', NULL),
(3, 'صوره', '16338615551907746.jpg', 1, 1, '2021-10-10 11:25:55', NULL),
(4, 'صوره', '16369786273861938.jpeg', 1, 1, '2021-10-10 11:26:06', NULL),
(5, 'l;k', '16369786962573016.jpeg', NULL, 1, '2021-11-15 14:18:16', NULL),
(6, 'Banner 1', '16402731907875156.jpeg', 1, 1, '2021-12-23 17:26:30', NULL),
(7, 'Banner 2', '16402732239803772.jpeg', NULL, 1, '2021-12-23 17:27:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `key`, `value`, `created_at`) VALUES
(1, 'facebook', 'https://www.facebook.com', '2021-08-18 09:33:46'),
(2, 'twitter', 'https://twitter.com', '2021-08-18 09:33:46'),
(3, 'youtube', 'https://www.youtube.com', '2021-08-18 09:33:46'),
(4, 'linked', 'https://www.linkedin.com', '2021-08-18 09:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` bigint UNSIGNED NOT NULL,
  `bank_acc_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `bank_acc_id`, `id_number`, `user_id`, `created_at`, `deleted_at`) VALUES
(1, '756756756756', '576567567567', 4, '2021-09-21 22:09:21', NULL),
(2, '123123123', '123123123', 14, '2021-10-27 10:56:53', NULL),
(3, NULL, '123456789', 18, '2021-11-06 12:59:02', NULL),
(4, NULL, '412123121212121212112', 26, '2021-11-27 22:21:04', NULL),
(5, NULL, '5732423423', 53, '2022-03-28 09:54:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/default.png',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet` int NOT NULL DEFAULT '0',
  `commission_status` tinyint NOT NULL DEFAULT '0',
  `income` double DEFAULT '0',
  `balance` double DEFAULT '0',
  `commission` int DEFAULT '0',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `replace_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ar',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile activation',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `accepted` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Admin approval',
  `notify` tinyint(1) NOT NULL DEFAULT '1',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int UNSIGNED DEFAULT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `city_id` bigint UNSIGNED DEFAULT NULL,
  `user_type` enum('admin','client','operation','company','technician','accountant') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `address` text COLLATE utf8mb4_unicode_ci,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socket_id` bigint DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `wallet`, `commission_status`, `income`, `balance`, `commission`, `phone`, `replace_phone`, `v_code`, `password`, `lang`, `active`, `banned`, `accepted`, `notify`, `online`, `role_id`, `country_id`, `city_id`, `user_type`, `address`, `lat`, `lng`, `pdf`, `socket_id`, `email_verified_at`, `remember_token`, `created_at`, `deleted_at`, `company_id`) VALUES
(1, 'المدير العام', '/default.png', 'info@aait.sa', 100, 0, 0, 0, 0, '01007416947', NULL, NULL, '$2y$10$3GcVeedo4ldCkJHaG5OxDe3GGT60pw7DRju6paRyO3R0BgTjvJJp2', 'ar', 1, 0, 1, 1, 1, 1, NULL, NULL, 'admin', 'السعوديه - الرياض', NULL, NULL, NULL, 1, NULL, 'vqGrH5CoPF1EKHayS2tMIueIP0OFtkqo4NZWjLM9xrhEgyyZd0qvVgsfJ0Hk', '2021-08-18 10:33:42', NULL, NULL),
(2, 'المدير العام', '/default.png', 'admin@example.net', 0, 0, 0, 0, 0, '01007416948', NULL, NULL, '$2y$10$myMAW9dPXGT8hgge/UdaDegmMYQHCYZUHPO0jSX7/LRgxlF0kxq92', 'ar', 1, 0, 1, 1, 1, 2, NULL, NULL, 'admin', 'السعوديه - الرياض', NULL, NULL, NULL, 2, NULL, NULL, '2021-08-18 10:33:42', NULL, NULL),
(3, 'khaled', '/default.png', 'speedo2008r@gmail.com', 0, 0, 0, 0, 0, '010074169471', NULL, '1234', '$2y$10$PO25zj/0uER/z38/W9/PoOsTUrIOv4liKCr/Bt1Czo4orvc/H5AZS', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-09-06 21:43:47', NULL, NULL),
(4, 'تقني', '16322585619901426.jpg', 'speedo@gmail.com', 0, 0, 0, 0, 4, '01007416942', NULL, '1234', '$2y$10$cUpei6x3OrA/wVMpJyKPhe1iIFy/MRtMegeGh35X2MDEaa4IJjD2a', 'ar', 0, 0, 1, 1, 0, NULL, 1, 1, 'technician', 'sdfadsfasd-15-15', '24.7135517', '46.67529569999999', NULL, NULL, NULL, NULL, '2021-09-21 22:09:21', NULL, NULL),
(5, 'mmmm', '/default.png', 'gg@gg.com', 0, 0, 0, 0, 0, '1234567890', NULL, '1234', '$2y$10$.i4CvzTCTDDVV5bhnzZRdOXcfCx3d7Y5eIBjmBH0K1NYE.jcVQQvu', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-05 10:46:13', NULL, NULL),
(6, 'محمد طلعتو', '16374830925732446.jpg', 'wff@ffw.com', 0, 0, 0, 0, 0, '1234512345', NULL, '1234', '$2y$10$7V.vbiMfmb5Yfz1QjvrJLOjqLHHgEbbRaKPDtNwqasEwQS3Fy0LM2', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-05 13:02:31', NULL, NULL),
(7, 'محمدين', '/default.png', 'tt@nn.com', 0, 0, 0, 0, 0, '1112223330', NULL, '1234', '$2y$10$pdxVkhGUztlKkjhj3//TX.fmuQvxoEBhoiJZCzwaPhTSsk0fYs93m', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-05 13:08:03', NULL, NULL),
(8, 'محمد السعيد', '/default.png', 'mt@g.com', 0, 0, 0, 0, 0, '1231231233', NULL, '1234', '$2y$10$4/diVyLNAxi30NVFanSzTeUKUKDf6j5D/0VESbSpu858yCz4cIFqm', 'ar', 1, 0, 1, 1, 0, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-19 11:44:22', NULL, NULL),
(9, 'احمد', '/default.png', 'user9@nava.com', 0, 0, 0, 0, 0, '7779224385', NULL, '1234', '$2y$10$3GcVeedo4ldCkJHaG5OxDe3GGT60pw7DRju6paRyO3R0BgTjvJJp2', 'ar', 1, 0, 1, 1, 0, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-21 20:31:18', NULL, NULL),
(10, 'mohammed aldosari', '/default.png', 'mfm135@hotmail.com', 0, 0, 0, 0, 0, '0562295222', NULL, '1234', '$2y$10$jnrvFM1T/Mk7o7XvaSRGTOAfz2Am0Rtnt/hopvkEM5x6xVZR/abba', 'ar', 1, 0, 1, 1, 1, 1, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-25 16:04:40', NULL, NULL),
(11, 'محمد', '/default.png', 'user11@nava.com', 0, 0, 0, 0, 0, '562295222', NULL, '1234', '$2y$10$mwJ5bsQsqUf4aAq/VXY9kuy/Jib/xIvqxVoFbEZdYqScbTFagDbxW', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-25 16:35:00', NULL, NULL),
(12, 'احمد خالد', '16352013954583169.jpg', 'aa@kh.com', 0, 0, 0, 0, 0, '1111122222', NULL, '1234', '$2y$10$cwj3TApzsWt15Z0CZgAq/OMUW47cLUTV7EQC92akVpBfFUFX3LQKC', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-25 23:30:27', NULL, NULL),
(13, 'wesam', '/default.png', 'user13@nava.com', 0, 0, 0, 0, 0, '1234567895', NULL, '1234', '$2y$10$RHEIp2XagjwpgejfuKTb4O1oDFuddMVWSsVfUQHLIFIVcBYsw./ee', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-25 23:31:13', NULL, NULL),
(14, 'طلعت فني', '16358420161495357.jpg', 'yt@t.com', 0, 0, 0, 0, 15, '01007013818', NULL, '1234', '$2y$10$R/r5uE/inToMYw3xEnBSnu4iI9x0QfZKFNqQ2psTCa1eRYO6NcMpC', 'ar', 1, 0, 1, 1, 1, NULL, 1, 1, 'technician', '2077 Al Urubah Rd, Al Olaya, Riyadh 12244 7856, Saudi Arabia', '24.7135517', '46.67529569999999', NULL, NULL, NULL, 'AeDEDPD6O2eucO0pJ75KWkIiAFJFzTnQtYstf5dwWUZESuFxleCqrb0ATII7', '2021-10-27 10:56:53', NULL, NULL),
(15, 'فاطمه حقوي', '/default.png', 'qasimalsgar2@gmail.com', 0, 0, 0, 0, 0, '576492387', NULL, '1234', '$2y$10$1vpWBsnNsRmHabYUu/yV6Or2HZ8NulqHbZU1pJsoLWjSz1EnSIWtK', 'ar', 0, 0, 1, 1, 0, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-27 13:00:32', NULL, NULL),
(16, 'فاطمه يحي ابراهيم حقوي', '/default.png', 'qasimalsgar41@gmail.com', 10, 0, 0, 0, 0, '593738687', NULL, '1234', '$2y$10$FVsB6G72IJwrW76W3YywwuZ.pa6XGxiFCZs7.yAYZ/bt1dfs6xckK', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-27 13:05:55', NULL, NULL),
(17, '‪khaled reda‬‏', '16353602777959086.jpg', 'speedo2055r@gmail.com', 0, 0, 0, 0, 2, '05123456789', NULL, NULL, '$2y$10$Is58Ugw4jFPYUgHjy7Y6iuSiebq9NKImXmYNOmjCOn.pFS3JSIGUC', 'ar', 1, 0, 1, 1, 0, NULL, 1, 1, 'company', '26 Gamal Abd Elnaser St', '24.7135517', '46.67529569999999', NULL, NULL, NULL, NULL, '2021-10-27 19:44:37', NULL, NULL),
(18, 'M.tec', '/default.png', 'navaservices01@gmail.com', 0, 0, 0, 0, 0, '0531626250', NULL, '1234', '$2y$10$L6gxh2v/WBUe9vay4/G9beAd5QpiCEah.gI1w5/GJ45fVKBJWuCWm', 'ar', 1, 0, 1, 1, 1, NULL, 1, 1, 'technician', 'شارع العليا،، Al Olaya, Riyadh 12251, Saudi Arabia', '24.7135517', '46.67529569999999', NULL, NULL, NULL, NULL, '2021-11-06 12:59:02', NULL, NULL),
(19, 'احمد', '/default.png', 'ahmed.alamri.822@gmail.com', 0, 0, 0, 0, 0, '0558373822', NULL, '1234', '$2y$10$Obr9L62xEpCPihLuxS.uPehyJiff1QivW3zOirG7FLqFuhLChd5ge', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 14:03:45', NULL, NULL),
(20, 'ALI', '/default.png', 'mali1571994@gmail.com', 0, 0, 0, 0, 0, '0595426228', NULL, '1234', '$2y$10$cexrt/A/I5E41wQ5AZf4XeUI/CyAYTZNuc.xuKd3ySGkh5lylE/Wq', 'ar', 1, 0, 1, 1, 1, 1, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, 20, NULL, 'BnvFF8BlkRgYBGtpJKg5K0MaidubH4y9pK1SotGWr2qmnEQ3ZTSyMQqrlXUW', '2021-11-10 15:47:46', NULL, NULL),
(21, 'محمد علي', '/default.png', 'user21@nava.com', 0, 0, 0, 0, 0, '595426228', NULL, '1234', '$2y$10$T0qhUdNWN3GH7qxYppB54uSk.vUSjWZgLAMf3WxFzZX3gjAn62RZq', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-16 12:21:47', NULL, NULL),
(22, 'Essa', '/default.png', 'essanava112@gmail.com', 0, 0, 0, 0, 0, '580208274', NULL, '1234', '$2y$10$Dqndkt2V/YPMcqW9xFdP2eWols3sxfAEHvXusx2FENZzQ9ZbPgNHO', 'ar', 0, 0, 1, 1, 0, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-21 00:41:16', NULL, NULL),
(23, 'Essa', '/default.png', 'essanava122@gmail.com', 0, 0, 0, 0, 0, '533842969', NULL, '1234', '$2y$10$efW3HkGxQfLAcZbbERgY3ePh6jzR2euTjKCRg8BrtWTKpEw/f5qC.', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-21 00:46:01', NULL, NULL),
(24, 'Ahmad', '/default.png', 'user24@nava.com', 0, 0, 0, 0, 0, '0777922438', NULL, '1234', '$2y$10$BtDFHsXG9S09DGtPKB2Kgu0Bj6HcePMbC.z.Orvpl9PE4EzhNlf0u', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-22 16:50:02', NULL, NULL),
(25, 'طلعت', '/default.png', 'ttt@g.com', 0, 0, 0, 0, 12, '1111111111', NULL, NULL, '$2y$10$4NN.aPDnT4gs28020CqP.uq6NVpUz80Ybll7qeTsmb0mnze7Hnalm', 'ar', 1, 0, 1, 1, 0, NULL, 1, 1, 'company', 'حي الزعفران', '24.7135517', '46.67529569999999', NULL, NULL, NULL, NULL, '2021-11-27 22:14:05', NULL, NULL),
(26, 'فني دهانات', '16380444648743018.png', 'ttttt@g.com', 0, 0, 0, 0, 0, '1111111100', NULL, NULL, '$2y$10$ZqHqYVIrCU9UyJJ4MPWFoeiiRP6lpSbs8tEYCn6WQRTnjRtkRqO.m', 'ar', 0, 0, 1, 1, 0, NULL, 1, 1, 'technician', 'pdd hhfgbkf', '24.7135517', '46.67529569999999', NULL, NULL, NULL, NULL, '2021-11-27 22:21:04', NULL, 25),
(27, 'fghu', '/default.png', 'saebqasem2022@gmail.com', 0, 0, 0, 0, 0, '510100561', NULL, '1234', '$2y$10$j/LY7giFnHelTljVXRbxQu7zf8b3gCBYnC5p5aID8zhgNi2Vtp0bG', 'ar', 0, 0, 1, 1, 0, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-03 11:58:40', NULL, NULL),
(28, 'khaled reda', '/default.png', 'user28@nava.com', 0, 0, 0, 0, 0, '1591591591', NULL, '1234', '$2y$10$wFr.74F4/K6ab1N4H1EiqOwb2/O1BjHpkqQogru0BrP0zmrBKR6F.', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-06 18:57:17', NULL, NULL),
(29, 'محمد', '/default.png', 'user29@nava.com', 0, 0, 0, 0, 0, '542122769', NULL, '1234', '$2y$10$B/GPqK/jV3nG9ZaUES0bxO/Oz0T.HKY.aXCp7mpOqyQKAJ4AuV/l.', 'ar', 1, 0, 1, 1, 0, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-08 13:58:03', NULL, NULL),
(30, 'abdallah', '/default.png', 'user30@nava.com', 0, 0, 0, 0, 0, '551080168', NULL, '1234', '$2y$10$xz2muR2JTyof8OcquGMDF.ShdJfroPspxVVC5WWZAYz5DZQJN5VkG', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-12 00:00:20', NULL, NULL),
(31, 'Nasser', '/default.png', 'user31@nava.com', 0, 0, 0, 0, 0, '564044458', NULL, '1234', '$2y$10$bJy47abSY6HPgdan3uK01e4wybmpB1YyxX/J1yy5fU4yemWkNgPeK', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-12 19:18:21', NULL, NULL),
(32, 'خالد الدوسري', '/default.png', 'user32@nava.com', 0, 0, 0, 0, 0, '560845398', NULL, '1234', '$2y$10$S2Jr9dw/mGwMLyRLcvCVU.ySEhO.3F3LZYbqrQxgyX/w.JwSc4lnm', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-12 19:19:29', NULL, NULL),
(33, 'ahmed', '/default.png', 'ahmed.alamri.403@gmail.com', 0, 0, 0, 0, 0, '561405006', NULL, '1234', '$2y$10$zRS3LkbABVyoU2P8WK5eu.NYXm0acPh1P1Q8q3.28Jeyi8KnfkFhu', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-12 19:20:21', NULL, NULL),
(34, 'talaaaaat', '/default.png', 'user34@nava.com', 0, 0, 0, 0, 0, '1231231239', NULL, '1234', '$2y$10$Fkk/KEcSvwZ1GqcBBh8aceraLyDmgnVlbp.zYFE72rMdqAjrxMoJu', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-12 23:14:43', NULL, NULL),
(35, 'samia filfilan', '/default.png', 'user35@nava.com', 0, 0, 0, 0, 0, '555854905', NULL, '1234', '$2y$10$R/4jlD9VhKPaFfAPQbT0GuWyABrEldppkJ1lvgLxOx5oj6CZiE9iq', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-24 08:10:14', NULL, NULL),
(36, 'نوف', '/default.png', 'user36@nava.com', 0, 0, 0, 0, 0, '0540029916', NULL, '1234', '$2y$10$qTH7M/bq1a5WPKiOlD/kMeB7A1HMLVtmpeG0fJhkOAq.fVyN5p5IK', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-24 09:05:27', NULL, NULL),
(37, 'نوف', '/default.png', 'ast054002@icloud.com', 0, 0, 0, 0, 0, '540029916', NULL, '1234', '$2y$10$WQY.TxqK.fkz99EPM7336ub/7SzIW951OsqG6xVZwEwT2JizQihcS', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-24 09:09:49', NULL, NULL),
(38, 'Essa', '/default.png', 'essa63501@gmail.com', 0, 0, 0, 0, 0, '0580208274', NULL, '1234', '$2y$10$Bt8mkd9rtAPa63kM3vGIO.aBTTIlI7PskEJGIYOSzmP4b9vF05gJ6', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-28 14:01:24', NULL, NULL),
(39, 'محمد العتمي', '/default.png', 'alromisa96@gmail.com', 0, 0, 0, 0, 0, '506745939', NULL, '1234', '$2y$10$bS9oJvKWdeKDULgreCUvzOnaBEMIR388trvfPlf2Atvyg238.fENK', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-29 11:08:57', NULL, NULL),
(40, 'Row', '/default.png', 'user40@nava.com', 0, 0, 0, 0, 0, '545627022', NULL, '1234', '$2y$10$197fCXosuw85yVpfHb/7p.yW4FacImTeCfNy/b0TcDsA9POEeI8di', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-29 18:33:26', NULL, NULL),
(41, 'mostafa abd elkader', '/default.png', 'user41@nava.com', 0, 0, 0, 0, 0, '0532565214', NULL, '1234', '$2y$10$hWj6AaVHnKWoG8adJ1jaAeAx2CgBWq.tVZCrXukQTyd5vBxd8LrQ.', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-29 19:16:08', NULL, NULL),
(42, 'mostafa abd elkader', '/default.png', 'user42@nava.com', 20, 0, 0, 0, 0, '0512365478', NULL, '1234', '$2y$10$zsP/i5fam7wkpibcHuUU4eXbzFS1Eq0vFNV1U5Fx.DRfESLdWhfxm', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', '34 Blbays- Shahr Al Asal, Al Beitash Gharb, Dekhela, Alexandria Governorate, Egypt', '31.133171899999994', '29.783686700000004', NULL, NULL, NULL, NULL, '2021-12-29 19:19:04', NULL, NULL),
(43, 'ahmeddddd', '/default.png', 'user43@nava.com', 0, 0, 0, 0, 0, '0512365487', NULL, '1234', '$2y$10$r2MUt/3alyZfAmpAot.Q0ebcPpWEyLYaFxH5m9JWSIbvubseKyyt2', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-04 18:04:28', NULL, NULL),
(44, 'sanad', '/default.png', 'user44@nava.com', 0, 0, 0, 0, 0, '777922438', NULL, '1234', '$2y$10$yYoN7wsMdW4IM700PobPSu5Ex0uur9WsUgJThHazm1ujuYfYm.7Q6', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-04 22:47:13', NULL, NULL),
(45, 'جنيد سواس', '/default.png', 'gnedsawas@hotmail.com', 0, 0, 0, 0, 0, '557371666', NULL, '1234', '$2y$10$wvBtyjHKu3b9kdr3ZHq6QubKIxGK6Oc0FeyCCQNquOiyhzFZEo2P6', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-05 15:41:10', NULL, NULL),
(46, 'محمد علي ١١', '/default.png', 'user46@nava.com', 0, 0, 0, 0, 0, '593872254', NULL, '1234', '$2y$10$J1HL0PX.0z6Fy0HCT3puW.zebSMVrgpzkUR/goF7./iH4BcA6B1Di', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', '9 Madraset Al Souri, Al Marghani, Al Attarin, Alexandria Governorate, Egypt', '31.188739714020574', '29.901607089408504', NULL, NULL, NULL, NULL, '2022-01-06 13:59:53', NULL, NULL),
(47, 'mohamed', '/default.png', 'user47@nava.com', 0, 0, 0, 0, 0, '555555555', NULL, '1234', '$2y$10$i0OUzsQWbi/RvkngGy1RieIjdRaiZJWvnN/uuQMjzNG60bXPc2qaG', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-14 13:32:27', NULL, NULL),
(48, 'medo', '/default.png', 'user48@nava.com', 0, 0, 0, 0, 0, '555555551', NULL, '1234', '$2y$10$W/BK5eRRvwqRLG8//u4NPu6okCBMWzFHA/l6l3vhfvpbt0u6AOH4G', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-14 13:38:39', NULL, NULL),
(49, 'medo Helmy', '/default.png', 'user49@nava.com', 10, 0, 0, 0, 0, '555555553', NULL, '1234', '$2y$10$NhzmTBwzsHkyFvBm.ZUC.uS1vscWq7OtqSQNcHgwyQLb52YstJCAy', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-14 21:13:28', NULL, NULL),
(50, 'Khalid Al Dosari', '/default.png', 'K.al-dosari@emdadatalatta.net', 0, 0, 0, 0, 0, '0560845398', NULL, NULL, '$2y$10$VLhbwu9gSUQyqhKl27zFTulbHuJDRI1NWGwrVpd.JM/Chbr9TwEBu', 'ar', 0, 0, 1, 1, 0, 1, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, NULL, '6T5hkcI0vZSUEJOcdpXFH0pcpoWxq0dlgNKQn3xKq068jIxh64l30X8In0g5', '2022-02-05 15:28:45', NULL, NULL),
(51, 'ahmad', '/default.png', 'user51@nava.com', 0, 0, 0, 0, 0, '7779224399', NULL, '1234', '$2y$10$xuqoUFMlmTuka/gAu2U1heNgZ37loaS2ygY6KfvsuWy65eUh6jH4u', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', 'sdfsfdf', '30.7865086', '31.0003757', NULL, NULL, NULL, NULL, '2022-02-10 21:39:45', NULL, NULL),
(52, 'Solomon raja', '/default.png', 'solomonbabloo5@gmail.com', 0, 0, 0, 0, 0, '7842720271', NULL, '1234', '$2y$10$085hl3GLO5r8unHkwL5gDuJLJzzdm797sPSTy3DaIW53MPkgHxn8i', 'ar', 0, 0, 1, 1, 0, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-03-27 07:44:20', NULL, NULL),
(53, 'Zoe Crane', '/default.png', 'jahag@mailinator.com', 0, 0, 0, 0, 20, '1234234234', NULL, '1234', '$2y$10$VkKPRXWbbi/6xB1OSjGtx.4rVnFfHgfY3cnV/ugyu92sOEGGLhIK6', 'ar', 0, 0, 1, 1, 0, NULL, 1, 1, 'technician', 'Qui id accusamus co', '24.7135517', '46.67529569999999', NULL, NULL, NULL, NULL, '2022-03-28 09:54:10', NULL, NULL),
(54, 'Fahad', '/default.png', 'user54@nava.com', 0, 0, 0, 0, 0, '558560305', NULL, '1234', '$2y$10$6hyXWJfUu/fivzlfsNNZMeeOEJfiLtxsqvKp04KIGohv18Y5DY91q', 'ar', 1, 0, 1, 1, 1, NULL, NULL, NULL, 'client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-03-28 11:05:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_branches`
--

CREATE TABLE `users_branches` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_branches`
--

INSERT INTO `users_branches` (`id`, `branch_id`, `user_id`) VALUES
(1, 1, 4),
(2, 1, 14),
(3, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `user_categories`
--

CREATE TABLE `user_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_categories`
--

INSERT INTO `user_categories` (`id`, `category_id`, `user_id`) VALUES
(1, 1, 4),
(2, 1, 14),
(3, 3, 14),
(4, 4, 14),
(5, 5, 14),
(6, 6, 14),
(7, 7, 14),
(8, 8, 14),
(9, 1, 18),
(13, 20, 26),
(14, 1, 26),
(15, 16, 26),
(16, 18, 26),
(17, 16, 18),
(18, 18, 18),
(19, 20, 18);

-- --------------------------------------------------------

--
-- Table structure for table `user_deductions`
--

CREATE TABLE `user_deductions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_deductions`
--

INSERT INTO `user_deductions` (`id`, `user_id`, `admin_id`, `order_id`, `balance`, `notes`, `created_at`, `deleted_at`) VALUES
(1, 4, 1, NULL, 100, 'ffff', '2021-10-25 16:32:00', NULL),
(2, 18, 20, NULL, 50, 'لم ينفذ الطلب', '2021-11-11 13:23:11', NULL),
(3, 18, 20, NULL, 20, 'dddf', '2022-03-17 12:41:10', NULL),
(4, 14, 1, NULL, 150, 'jyh', '2022-03-31 13:21:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_socials`
--

CREATE TABLE `user_socials` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint UNSIGNED NOT NULL,
  `device_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `device_type`, `city_id`, `created_at`, `deleted_at`) VALUES
(1, 'ios', NULL, '2021-10-09 21:44:12', NULL),
(2, 'android', NULL, '2021-10-10 10:21:32', NULL),
(3, 'android', NULL, '2021-10-10 10:22:01', NULL),
(4, 'android', NULL, '2021-10-10 10:22:26', NULL),
(5, 'android', NULL, '2021-10-10 10:26:16', NULL),
(6, 'android', NULL, '2021-10-10 10:26:22', NULL),
(7, 'android', NULL, '2021-10-10 10:28:02', NULL),
(8, 'android', NULL, '2021-10-10 10:29:00', NULL),
(9, 'android', NULL, '2021-10-10 11:25:36', NULL),
(10, 'ios', NULL, '2021-10-10 11:26:30', NULL),
(11, 'ios', NULL, '2021-10-10 11:28:23', NULL),
(12, 'android', NULL, '2021-10-10 11:38:39', NULL),
(13, 'android', NULL, '2021-10-10 11:39:27', NULL),
(14, 'android', NULL, '2021-10-10 11:46:05', NULL),
(15, 'android', NULL, '2021-10-10 12:02:49', NULL),
(16, 'android', NULL, '2021-10-10 12:04:45', NULL),
(17, 'android', NULL, '2021-10-10 16:10:45', NULL),
(18, 'android', NULL, '2021-10-10 17:17:31', NULL),
(19, 'android', NULL, '2021-10-10 17:32:05', NULL),
(20, 'android', NULL, '2021-10-10 17:34:28', NULL),
(21, 'android', NULL, '2021-10-10 17:36:55', NULL),
(22, 'ios', NULL, '2021-10-10 17:40:57', NULL),
(23, 'android', NULL, '2021-10-10 17:43:47', NULL),
(24, 'android', NULL, '2021-10-10 17:47:14', NULL),
(25, 'android', NULL, '2021-10-10 17:47:17', NULL),
(26, 'android', NULL, '2021-10-10 17:47:38', NULL),
(27, 'android', NULL, '2021-10-10 17:49:29', NULL),
(28, 'android', NULL, '2021-10-10 17:49:41', NULL),
(29, 'android', NULL, '2021-10-10 17:49:50', NULL),
(30, 'android', NULL, '2021-10-10 18:04:58', NULL),
(31, 'android', NULL, '2021-10-10 18:11:34', NULL),
(32, 'android', NULL, '2021-10-10 18:11:50', NULL),
(33, 'android', NULL, '2021-10-10 18:17:42', NULL),
(34, 'android', NULL, '2021-10-10 18:19:23', NULL),
(35, 'android', NULL, '2021-10-10 18:19:45', NULL),
(36, 'android', NULL, '2021-10-10 18:20:13', NULL),
(37, 'android', NULL, '2021-10-10 18:21:44', NULL),
(38, 'android', NULL, '2021-10-10 18:21:46', NULL),
(39, 'android', NULL, '2021-10-10 18:22:02', NULL),
(40, 'android', NULL, '2021-10-10 18:22:04', NULL),
(41, 'android', NULL, '2021-10-10 18:22:15', NULL),
(42, 'android', NULL, '2021-10-10 18:22:20', NULL),
(43, 'android', NULL, '2021-10-10 18:22:26', NULL),
(44, 'android', NULL, '2021-10-10 18:22:33', NULL),
(45, 'android', NULL, '2021-10-10 18:23:01', NULL),
(46, 'android', NULL, '2021-10-10 18:23:12', NULL),
(47, 'android', NULL, '2021-10-10 18:23:22', NULL),
(48, 'android', NULL, '2021-10-10 18:23:32', NULL),
(49, 'android', NULL, '2021-10-10 18:23:34', NULL),
(50, 'android', NULL, '2021-10-10 18:23:47', NULL),
(51, 'android', NULL, '2021-10-10 18:23:58', NULL),
(52, 'android', NULL, '2021-10-11 09:43:58', NULL),
(53, 'android', NULL, '2021-10-11 10:08:36', NULL),
(54, 'android', NULL, '2021-10-11 10:10:58', NULL),
(55, 'android', NULL, '2021-10-11 10:17:01', NULL),
(56, 'android', NULL, '2021-10-11 10:19:18', NULL),
(57, 'android', NULL, '2021-10-11 10:37:37', NULL),
(58, 'android', NULL, '2021-10-11 11:04:26', NULL),
(59, 'android', NULL, '2021-10-11 11:06:17', NULL),
(60, 'android', NULL, '2021-10-11 11:19:55', NULL),
(61, 'android', NULL, '2021-10-11 11:20:16', NULL),
(62, 'android', NULL, '2021-10-11 11:20:46', NULL),
(63, 'android', NULL, '2021-10-11 11:21:07', NULL),
(64, 'android', NULL, '2021-10-11 12:14:41', NULL),
(65, 'android', NULL, '2021-10-11 14:04:24', NULL),
(66, 'android', NULL, '2021-10-12 09:14:15', NULL),
(67, 'android', NULL, '2021-10-12 09:20:57', NULL),
(68, 'android', NULL, '2021-10-12 09:38:29', NULL),
(69, 'android', NULL, '2021-10-12 10:31:18', NULL),
(70, 'android', NULL, '2021-10-12 12:08:45', NULL),
(71, 'android', NULL, '2021-10-12 12:35:05', NULL),
(72, 'android', NULL, '2021-10-12 12:36:57', NULL),
(73, 'android', NULL, '2021-10-12 13:04:29', NULL),
(74, 'android', NULL, '2021-10-12 13:48:15', NULL),
(75, 'android', NULL, '2021-10-12 14:22:53', NULL),
(76, 'android', NULL, '2021-10-12 15:22:10', NULL),
(77, 'android', NULL, '2021-10-12 15:37:10', NULL),
(78, 'android', NULL, '2021-10-12 15:45:24', NULL),
(79, 'android', NULL, '2021-10-12 16:07:03', NULL),
(80, 'android', NULL, '2021-10-12 17:13:00', NULL),
(81, 'android', NULL, '2021-10-12 17:14:59', NULL),
(82, 'android', NULL, '2021-10-12 17:19:58', NULL),
(83, 'android', NULL, '2021-10-12 17:31:13', NULL),
(84, 'android', NULL, '2021-10-12 20:01:29', NULL),
(85, 'android', NULL, '2021-10-12 20:02:37', NULL),
(86, 'android', NULL, '2021-10-12 20:15:35', NULL),
(87, 'android', NULL, '2021-10-12 20:40:28', NULL),
(88, 'android', NULL, '2021-10-12 20:42:24', NULL),
(89, 'android', NULL, '2021-10-12 20:44:48', NULL),
(90, 'android', NULL, '2021-10-12 21:51:09', NULL),
(91, 'android', NULL, '2021-10-12 21:51:15', NULL),
(92, 'android', NULL, '2021-10-12 21:59:37', NULL),
(93, 'android', NULL, '2021-10-12 22:01:15', NULL),
(94, 'android', NULL, '2021-10-12 22:03:40', NULL),
(95, 'android', NULL, '2021-10-12 22:05:52', NULL),
(96, 'android', NULL, '2021-10-12 22:06:43', NULL),
(97, 'android', NULL, '2021-10-12 22:08:18', NULL),
(98, 'android', NULL, '2021-10-12 22:09:51', NULL),
(99, 'android', NULL, '2021-10-12 22:10:25', NULL),
(100, 'android', NULL, '2021-10-12 22:11:22', NULL),
(101, 'android', NULL, '2021-10-12 22:11:40', NULL),
(102, 'android', NULL, '2021-10-12 22:13:21', NULL),
(103, 'android', NULL, '2021-10-13 09:44:54', NULL),
(104, 'android', NULL, '2021-10-13 10:34:22', NULL),
(105, 'android', NULL, '2021-10-13 10:35:21', NULL),
(106, 'android', NULL, '2021-10-13 11:05:11', NULL),
(107, 'android', NULL, '2021-10-13 11:25:28', NULL),
(108, 'android', NULL, '2021-10-13 11:33:28', NULL),
(109, 'android', NULL, '2021-10-13 12:06:01', NULL),
(110, 'android', NULL, '2021-10-13 15:26:22', NULL),
(111, 'android', NULL, '2021-10-13 15:34:58', NULL),
(112, 'android', NULL, '2021-10-13 16:09:02', NULL),
(113, 'android', NULL, '2021-10-13 16:15:33', NULL),
(114, 'android', NULL, '2021-10-13 17:44:20', NULL),
(115, 'android', NULL, '2021-10-13 22:10:33', NULL),
(116, 'android', NULL, '2021-10-13 22:11:19', NULL),
(117, 'android', NULL, '2021-10-13 23:01:13', NULL),
(118, 'android', NULL, '2021-10-13 23:02:09', NULL),
(119, 'android', NULL, '2021-10-13 23:02:33', NULL),
(120, 'android', NULL, '2021-10-13 23:09:36', NULL),
(121, 'android', NULL, '2021-10-13 23:14:28', NULL),
(122, 'android', NULL, '2021-10-13 23:18:42', NULL),
(123, 'android', NULL, '2021-10-13 23:26:14', NULL),
(124, 'android', NULL, '2021-10-13 23:35:05', NULL),
(125, 'android', NULL, '2021-10-13 23:43:26', NULL),
(126, 'android', NULL, '2021-10-13 23:50:55', NULL),
(127, 'android', NULL, '2021-10-16 20:42:16', NULL),
(128, 'android', NULL, '2021-10-16 20:50:11', NULL),
(129, 'android', NULL, '2021-10-16 21:07:55', NULL),
(130, 'android', NULL, '2021-10-16 21:18:33', NULL),
(131, 'android', NULL, '2021-10-16 21:18:40', NULL),
(132, 'android', NULL, '2021-10-16 21:21:29', NULL),
(133, 'android', NULL, '2021-10-16 21:35:19', NULL),
(134, 'android', NULL, '2021-10-16 21:39:07', NULL),
(135, 'android', NULL, '2021-10-16 21:41:33', NULL),
(136, 'android', NULL, '2021-10-19 08:47:53', NULL),
(137, 'android', NULL, '2021-10-19 09:26:16', NULL),
(138, 'android', NULL, '2021-10-19 09:38:56', NULL),
(139, 'android', NULL, '2021-10-19 10:40:40', NULL),
(140, 'android', NULL, '2021-10-19 10:44:42', NULL),
(141, 'android', NULL, '2021-10-19 11:14:19', NULL),
(142, 'android', NULL, '2021-10-19 11:14:30', NULL),
(143, 'android', NULL, '2021-10-19 11:17:23', NULL),
(144, 'android', NULL, '2021-10-19 11:18:07', NULL),
(145, 'android', NULL, '2021-10-19 11:18:11', NULL),
(146, 'android', NULL, '2021-10-19 11:19:04', NULL),
(147, 'android', NULL, '2021-10-19 11:19:07', NULL),
(148, 'android', NULL, '2021-10-19 11:20:32', NULL),
(149, 'android', NULL, '2021-10-19 11:20:37', NULL),
(150, 'android', NULL, '2021-10-19 11:20:39', NULL),
(151, 'android', NULL, '2021-10-19 11:31:41', NULL),
(152, 'android', NULL, '2021-10-19 11:31:44', NULL),
(153, 'android', NULL, '2021-10-19 11:31:46', NULL),
(154, 'android', NULL, '2021-10-19 11:31:52', NULL),
(155, 'android', NULL, '2021-10-19 11:40:33', NULL),
(156, 'android', NULL, '2021-10-19 11:42:18', NULL),
(157, 'android', NULL, '2021-10-19 11:44:36', NULL),
(158, 'android', NULL, '2021-10-19 11:44:45', NULL),
(159, 'android', NULL, '2021-10-19 11:44:50', NULL),
(160, 'android', NULL, '2021-10-19 11:45:23', NULL),
(161, 'android', NULL, '2021-10-19 11:47:01', NULL),
(162, 'android', NULL, '2021-10-19 12:46:46', NULL),
(163, 'ios', NULL, '2021-10-19 12:57:36', NULL),
(164, 'ios', NULL, '2021-10-19 13:04:06', NULL),
(165, 'ios', NULL, '2021-10-19 13:11:23', NULL),
(166, 'ios', NULL, '2021-10-19 13:15:37', NULL),
(167, 'ios', NULL, '2021-10-19 13:17:55', NULL),
(168, 'ios', NULL, '2021-10-19 13:21:52', NULL),
(169, 'ios', NULL, '2021-10-19 13:26:44', NULL),
(170, 'ios', NULL, '2021-10-20 12:25:13', NULL),
(171, 'ios', NULL, '2021-10-20 12:25:59', NULL),
(172, 'android', NULL, '2021-10-20 17:01:17', NULL),
(173, 'android', NULL, '2021-10-20 17:01:24', NULL),
(174, 'android', NULL, '2021-10-20 17:01:45', NULL),
(175, 'android', NULL, '2021-10-20 21:45:46', NULL),
(176, 'android', NULL, '2021-10-20 21:51:19', NULL),
(177, 'android', NULL, '2021-10-20 21:53:00', NULL),
(178, 'android', NULL, '2021-10-20 21:54:25', NULL),
(179, 'android', NULL, '2021-10-20 22:01:31', NULL),
(180, 'android', NULL, '2021-10-20 22:02:24', NULL),
(181, 'android', NULL, '2021-10-20 22:02:34', NULL),
(182, 'android', NULL, '2021-10-20 22:36:01', NULL),
(183, 'android', NULL, '2021-10-20 22:39:52', NULL),
(184, 'android', NULL, '2021-10-20 23:01:21', NULL),
(185, 'android', NULL, '2021-10-20 23:04:06', NULL),
(186, 'android', NULL, '2021-10-20 23:13:12', NULL),
(187, 'android', NULL, '2021-10-20 23:15:53', NULL),
(188, 'android', NULL, '2021-10-20 23:30:57', NULL),
(189, 'android', NULL, '2021-10-21 20:31:54', NULL),
(190, 'android', NULL, '2021-10-21 20:32:15', NULL),
(191, 'android', NULL, '2021-10-22 16:12:43', NULL),
(192, 'android', NULL, '2021-10-22 16:13:19', NULL),
(193, 'android', NULL, '2021-10-22 16:41:50', NULL),
(194, 'android', NULL, '2021-10-22 17:27:20', NULL),
(195, 'android', NULL, '2021-10-22 17:51:32', NULL),
(196, 'android', NULL, '2021-10-22 17:55:24', NULL),
(197, 'android', NULL, '2021-10-22 18:00:52', NULL),
(198, 'android', NULL, '2021-10-23 12:43:10', NULL),
(199, 'android', NULL, '2021-10-23 12:43:33', NULL),
(200, 'android', NULL, '2021-10-24 09:55:25', NULL),
(201, 'android', NULL, '2021-10-24 10:15:15', NULL),
(202, 'android', NULL, '2021-10-24 10:20:20', NULL),
(203, 'android', NULL, '2021-10-24 10:22:54', NULL),
(204, 'android', NULL, '2021-10-24 10:24:11', NULL),
(205, 'android', NULL, '2021-10-24 10:29:54', NULL),
(206, 'android', NULL, '2021-10-24 10:31:56', NULL),
(207, 'ios', NULL, '2021-10-24 11:57:14', NULL),
(208, 'ios', NULL, '2021-10-24 12:09:48', NULL),
(209, 'ios', NULL, '2021-10-24 12:20:43', NULL),
(210, 'ios', NULL, '2021-10-24 12:24:38', NULL),
(211, 'ios', NULL, '2021-10-24 12:26:36', NULL),
(212, 'ios', NULL, '2021-10-24 12:26:50', NULL),
(213, 'ios', NULL, '2021-10-24 12:27:41', NULL),
(214, 'ios', NULL, '2021-10-24 12:32:03', NULL),
(215, 'ios', NULL, '2021-10-24 15:04:04', NULL),
(216, 'ios', NULL, '2021-10-24 15:05:34', NULL),
(217, 'ios', NULL, '2021-10-24 15:08:57', NULL),
(218, 'ios', NULL, '2021-10-24 15:10:27', NULL),
(219, 'ios', NULL, '2021-10-24 15:11:01', NULL),
(220, 'ios', NULL, '2021-10-24 15:16:00', NULL),
(221, 'ios', NULL, '2021-10-24 15:17:42', NULL),
(222, 'android', NULL, '2021-10-24 22:12:16', NULL),
(223, 'android', NULL, '2021-10-24 22:16:12', NULL),
(224, 'android', NULL, '2021-10-24 22:23:08', NULL),
(225, 'android', NULL, '2021-10-24 22:27:52', NULL),
(226, 'android', NULL, '2021-10-24 22:28:51', NULL),
(227, 'android', NULL, '2021-10-24 22:30:12', NULL),
(228, 'android', NULL, '2021-10-24 22:34:56', NULL),
(229, 'android', NULL, '2021-10-24 22:35:27', NULL),
(230, 'android', NULL, '2021-10-24 22:36:40', NULL),
(231, 'android', NULL, '2021-10-24 22:44:58', NULL),
(232, 'android', NULL, '2021-10-25 09:23:17', NULL),
(233, 'ios', NULL, '2021-10-25 10:11:25', NULL),
(234, 'ios', NULL, '2021-10-25 10:21:03', NULL),
(235, 'ios', NULL, '2021-10-25 10:21:23', NULL),
(236, 'ios', NULL, '2021-10-25 10:23:35', NULL),
(237, 'ios', NULL, '2021-10-25 10:24:23', NULL),
(238, 'ios', NULL, '2021-10-25 10:26:39', NULL),
(239, 'android', NULL, '2021-10-25 10:36:00', NULL),
(240, 'android', NULL, '2021-10-25 10:50:35', NULL),
(241, 'android', NULL, '2021-10-25 10:58:10', NULL),
(242, 'android', NULL, '2021-10-25 11:00:31', NULL),
(243, 'android', NULL, '2021-10-25 11:00:57', NULL),
(244, 'android', NULL, '2021-10-25 15:16:29', NULL),
(245, 'android', NULL, '2021-10-25 15:20:22', NULL),
(246, 'android', NULL, '2021-10-25 15:27:16', NULL),
(247, 'android', NULL, '2021-10-25 15:42:50', NULL),
(248, 'android', NULL, '2021-10-25 15:58:46', NULL),
(249, 'android', NULL, '2021-10-25 16:09:52', NULL),
(250, 'android', NULL, '2021-10-25 16:10:00', NULL),
(251, 'android', NULL, '2021-10-25 16:10:08', NULL),
(252, 'android', NULL, '2021-10-25 16:11:26', NULL),
(253, 'android', NULL, '2021-10-25 16:43:06', NULL),
(254, 'android', NULL, '2021-10-25 16:44:54', NULL),
(255, 'android', NULL, '2021-10-25 16:47:17', NULL),
(256, 'android', NULL, '2021-10-25 16:49:49', NULL),
(257, 'android', NULL, '2021-10-25 21:20:43', NULL),
(258, 'android', NULL, '2021-10-25 22:18:28', NULL),
(259, 'android', NULL, '2021-10-25 22:28:35', NULL),
(260, 'android', NULL, '2021-10-25 23:05:13', NULL),
(261, 'android', NULL, '2021-10-25 23:05:28', NULL),
(262, 'android', NULL, '2021-10-25 23:05:58', NULL),
(263, 'android', NULL, '2021-10-25 23:06:08', NULL),
(264, 'android', NULL, '2021-10-25 23:21:50', NULL),
(265, 'android', NULL, '2021-10-25 23:24:58', NULL),
(266, 'android', NULL, '2021-10-25 23:31:09', NULL),
(267, 'android', NULL, '2021-10-25 23:31:43', NULL),
(268, 'android', NULL, '2021-10-25 23:34:01', NULL),
(269, 'android', NULL, '2021-10-25 23:34:12', NULL),
(270, 'android', NULL, '2021-10-25 23:34:14', NULL),
(271, 'android', NULL, '2021-10-25 23:35:46', NULL),
(272, 'android', NULL, '2021-10-25 23:35:49', NULL),
(273, 'android', NULL, '2021-10-27 08:39:16', NULL),
(274, 'android', NULL, '2021-10-27 08:42:06', NULL),
(275, 'android', NULL, '2021-10-27 08:42:09', NULL),
(276, 'android', NULL, '2021-10-27 08:44:06', NULL),
(277, 'android', NULL, '2021-10-27 08:44:39', NULL),
(278, 'android', NULL, '2021-10-27 08:45:29', NULL),
(279, 'android', NULL, '2021-10-27 08:54:49', NULL),
(280, 'android', NULL, '2021-10-27 09:33:58', NULL),
(281, 'ios', NULL, '2021-10-27 11:08:01', NULL),
(282, 'android', NULL, '2021-10-27 11:35:13', NULL),
(283, 'ios', NULL, '2021-10-27 11:42:40', NULL),
(284, 'android', NULL, '2021-10-27 11:47:51', NULL),
(285, 'android', NULL, '2021-10-27 11:48:57', NULL),
(286, 'android', NULL, '2021-10-27 11:48:57', NULL),
(287, 'android', NULL, '2021-10-27 11:49:41', NULL),
(288, 'android', NULL, '2021-10-27 11:49:41', NULL),
(289, 'android', NULL, '2021-10-27 11:50:46', NULL),
(290, 'android', NULL, '2021-10-27 11:54:17', NULL),
(291, 'ios', NULL, '2021-10-27 11:55:53', NULL),
(292, 'android', NULL, '2021-10-27 11:59:42', NULL),
(293, 'android', NULL, '2021-10-27 11:59:44', NULL),
(294, 'android', NULL, '2021-10-27 11:59:48', NULL),
(295, 'ios', NULL, '2021-10-27 11:59:54', NULL),
(296, 'android', NULL, '2021-10-27 11:59:58', NULL),
(297, 'android', NULL, '2021-10-27 12:08:51', NULL),
(298, 'android', NULL, '2021-10-27 12:09:01', NULL),
(299, 'android', NULL, '2021-10-27 12:13:57', NULL),
(300, 'android', NULL, '2021-10-27 12:25:43', NULL),
(301, 'android', NULL, '2021-10-27 12:28:04', NULL),
(302, 'android', NULL, '2021-10-27 12:33:47', NULL),
(303, 'android', NULL, '2021-10-27 12:38:35', NULL),
(304, 'android', NULL, '2021-10-27 12:39:34', NULL),
(305, 'android', NULL, '2021-10-27 12:44:47', NULL),
(306, 'android', NULL, '2021-10-27 12:44:57', NULL),
(307, 'android', NULL, '2021-10-27 12:47:40', NULL),
(308, 'ios', NULL, '2021-10-27 19:31:03', NULL),
(309, 'ios', NULL, '2021-10-27 19:31:31', NULL),
(310, 'ios', NULL, '2021-10-27 19:32:21', NULL),
(311, 'ios', NULL, '2021-10-27 19:32:36', NULL),
(312, 'ios', NULL, '2021-10-27 19:32:39', NULL),
(313, 'ios', NULL, '2021-10-27 19:58:11', NULL),
(314, 'ios', NULL, '2021-10-27 19:58:32', NULL),
(315, 'ios', NULL, '2021-10-27 19:59:03', NULL),
(316, 'ios', NULL, '2021-10-27 19:59:30', NULL),
(317, 'ios', NULL, '2021-10-27 20:00:15', NULL),
(318, 'ios', NULL, '2021-10-27 20:00:29', NULL),
(319, 'ios', NULL, '2021-10-27 20:01:39', NULL),
(320, 'ios', NULL, '2021-10-27 20:01:46', NULL),
(321, 'ios', NULL, '2021-10-27 20:13:09', NULL),
(322, 'ios', NULL, '2021-10-27 20:21:51', NULL),
(323, 'android', NULL, '2021-10-27 20:22:42', NULL),
(324, 'android', NULL, '2021-10-27 20:25:48', NULL),
(325, 'ios', NULL, '2021-10-27 21:54:05', NULL),
(326, 'ios', NULL, '2021-10-27 21:54:21', NULL),
(327, 'ios', NULL, '2021-10-27 22:01:47', NULL),
(328, 'ios', NULL, '2021-10-27 22:02:42', NULL),
(329, 'ios', NULL, '2021-10-27 22:02:49', NULL),
(330, 'ios', NULL, '2021-10-27 22:02:51', NULL),
(331, 'ios', NULL, '2021-10-28 04:07:15', NULL),
(332, 'ios', NULL, '2021-10-28 10:44:49', NULL),
(333, 'ios', NULL, '2021-10-28 13:54:47', NULL),
(334, 'ios', NULL, '2021-10-28 13:56:26', NULL),
(335, 'ios', NULL, '2021-10-28 13:58:10', NULL),
(336, 'ios', NULL, '2021-10-28 14:03:53', NULL),
(337, 'android', NULL, '2021-10-28 14:17:15', NULL),
(338, 'android', NULL, '2021-10-28 14:18:12', NULL),
(339, 'android', NULL, '2021-10-28 14:19:42', NULL),
(340, 'android', NULL, '2021-10-28 14:19:45', NULL),
(341, 'android', NULL, '2021-10-28 14:19:48', NULL),
(342, 'android', NULL, '2021-10-28 14:21:24', NULL),
(343, 'android', NULL, '2021-10-28 14:21:34', NULL),
(344, 'android', NULL, '2021-10-28 14:21:43', NULL),
(345, 'android', NULL, '2021-10-28 14:21:52', NULL),
(346, 'android', NULL, '2021-10-28 14:22:01', NULL),
(347, 'ios', NULL, '2021-10-28 14:32:07', NULL),
(348, 'ios', NULL, '2021-10-28 14:34:37', NULL),
(349, 'ios', NULL, '2021-10-28 14:35:46', NULL),
(350, 'ios', NULL, '2021-10-28 14:37:09', NULL),
(351, 'ios', NULL, '2021-10-28 14:39:11', NULL),
(352, 'ios', NULL, '2021-10-28 14:41:33', NULL),
(353, 'ios', NULL, '2021-10-28 14:42:52', NULL),
(354, 'ios', NULL, '2021-10-28 14:45:43', NULL),
(355, 'ios', NULL, '2021-10-28 15:05:51', NULL),
(356, 'ios', NULL, '2021-10-28 15:07:17', NULL),
(357, 'ios', NULL, '2021-10-28 15:07:19', NULL),
(358, 'ios', NULL, '2021-10-28 15:07:33', NULL),
(359, 'ios', NULL, '2021-10-28 15:07:57', NULL),
(360, 'ios', NULL, '2021-10-28 15:08:12', NULL),
(361, 'ios', NULL, '2021-10-28 15:08:27', NULL),
(362, 'ios', NULL, '2021-10-28 15:08:45', NULL),
(363, 'ios', NULL, '2021-10-28 17:46:10', NULL),
(364, 'ios', NULL, '2021-10-28 17:46:35', NULL),
(365, 'ios', NULL, '2021-10-28 19:04:45', NULL),
(366, 'ios', NULL, '2021-10-30 13:08:35', NULL),
(367, 'ios', NULL, '2021-10-30 13:14:38', NULL),
(368, 'ios', NULL, '2021-10-30 13:15:16', NULL),
(369, 'ios', NULL, '2021-10-30 13:16:38', NULL),
(370, 'ios', NULL, '2021-10-30 13:17:33', NULL),
(371, 'ios', NULL, '2021-10-30 13:20:29', NULL),
(372, 'ios', NULL, '2021-10-30 13:20:47', NULL),
(373, 'ios', NULL, '2021-10-30 13:25:13', NULL),
(374, 'ios', NULL, '2021-10-30 13:25:24', NULL),
(375, 'android', NULL, '2021-10-30 15:53:02', NULL),
(376, 'android', NULL, '2021-10-30 15:59:04', NULL),
(377, 'android', NULL, '2021-10-30 21:15:17', NULL),
(378, 'android', NULL, '2021-10-30 21:23:02', NULL),
(379, 'android', NULL, '2021-10-30 21:25:18', NULL),
(380, 'android', NULL, '2021-10-30 21:45:10', NULL),
(381, 'android', NULL, '2021-10-30 21:47:42', NULL),
(382, 'android', NULL, '2021-10-30 21:52:04', NULL),
(383, 'android', NULL, '2021-10-30 21:56:52', NULL),
(384, 'android', NULL, '2021-10-30 21:59:36', NULL),
(385, 'android', NULL, '2021-10-30 22:00:27', NULL),
(386, 'android', NULL, '2021-10-30 22:03:00', NULL),
(387, 'ios', NULL, '2021-10-30 22:11:34', NULL),
(388, 'ios', NULL, '2021-10-30 22:13:40', NULL),
(389, 'ios', NULL, '2021-10-30 22:17:14', NULL),
(390, 'android', NULL, '2021-10-31 10:29:13', NULL),
(391, 'ios', NULL, '2021-10-31 13:47:06', NULL),
(392, 'ios', NULL, '2021-10-31 13:50:27', NULL),
(393, 'ios', NULL, '2021-10-31 13:56:28', NULL),
(394, 'ios', NULL, '2021-10-31 13:56:31', NULL),
(395, 'ios', NULL, '2021-10-31 14:11:25', NULL),
(396, 'ios', NULL, '2021-10-31 14:19:05', NULL),
(397, 'ios', NULL, '2021-10-31 14:26:37', NULL),
(398, 'ios', NULL, '2021-10-31 14:29:21', NULL),
(399, 'ios', NULL, '2021-10-31 15:05:29', NULL),
(400, 'ios', NULL, '2021-10-31 15:06:51', NULL),
(401, 'android', NULL, '2021-10-31 17:14:37', NULL),
(402, 'android', NULL, '2021-10-31 17:14:40', NULL),
(403, 'android', NULL, '2021-10-31 17:14:42', NULL),
(404, 'android', NULL, '2021-10-31 17:14:44', NULL),
(405, 'android', NULL, '2021-11-01 13:44:28', NULL),
(406, 'android', NULL, '2021-11-01 13:44:35', NULL),
(407, 'android', NULL, '2021-11-02 03:30:05', NULL),
(408, 'android', NULL, '2021-11-02 03:30:32', NULL),
(409, 'android', NULL, '2021-11-02 03:31:18', NULL),
(410, 'android', NULL, '2021-11-02 03:31:43', NULL),
(411, 'android', NULL, '2021-11-02 03:32:18', NULL),
(412, 'ios', NULL, '2021-11-02 15:09:03', NULL),
(413, 'android', NULL, '2021-11-05 18:39:21', NULL),
(414, 'android', NULL, '2021-11-05 18:39:34', NULL),
(415, 'ios', NULL, '2021-11-06 13:13:11', NULL),
(416, 'ios', NULL, '2021-11-06 13:13:54', NULL),
(417, 'ios', NULL, '2021-11-06 13:18:39', NULL),
(418, 'ios', NULL, '2021-11-06 14:03:27', NULL),
(419, 'ios', NULL, '2021-11-08 13:29:52', NULL),
(420, 'ios', NULL, '2021-11-08 13:35:19', NULL),
(421, 'ios', NULL, '2021-11-08 13:35:51', NULL),
(422, 'ios', NULL, '2021-11-08 13:49:11', NULL),
(423, 'ios', NULL, '2021-11-08 14:09:40', NULL),
(424, 'android', NULL, '2021-11-08 16:38:54', NULL),
(425, 'android', NULL, '2021-11-08 16:40:43', NULL),
(426, 'android', NULL, '2021-11-08 16:44:08', NULL),
(427, 'android', NULL, '2021-11-08 16:49:59', NULL),
(428, 'android', NULL, '2021-11-08 22:48:25', NULL),
(429, 'android', NULL, '2021-11-08 22:54:00', NULL),
(430, 'android', NULL, '2021-11-08 22:54:53', NULL),
(431, 'android', NULL, '2021-11-08 23:11:34', NULL),
(432, 'android', NULL, '2021-11-08 23:23:54', NULL),
(433, 'android', NULL, '2021-11-08 23:26:46', NULL),
(434, 'android', NULL, '2021-11-08 23:33:03', NULL),
(435, 'ios', NULL, '2021-11-09 13:23:25', NULL),
(436, 'ios', NULL, '2021-11-09 13:23:31', NULL),
(437, 'ios', NULL, '2021-11-09 13:23:35', NULL),
(438, 'ios', NULL, '2021-11-09 13:23:42', NULL),
(439, 'android', NULL, '2021-11-09 21:12:52', NULL),
(440, 'android', NULL, '2021-11-09 21:15:40', NULL),
(441, 'android', NULL, '2021-11-09 21:19:25', NULL),
(442, 'android', NULL, '2021-11-09 21:19:41', NULL),
(443, 'android', NULL, '2021-11-09 21:32:05', NULL),
(444, 'android', NULL, '2021-11-09 21:36:44', NULL),
(445, 'android', NULL, '2021-11-09 21:41:40', NULL),
(446, 'android', NULL, '2021-11-09 21:41:51', NULL),
(447, 'android', NULL, '2021-11-09 21:42:14', NULL),
(448, 'android', NULL, '2021-11-09 21:47:32', NULL),
(449, 'android', NULL, '2021-11-09 21:50:20', NULL),
(450, 'android', NULL, '2021-11-09 21:51:04', NULL),
(451, 'android', NULL, '2021-11-09 21:53:48', NULL),
(452, 'android', NULL, '2021-11-09 21:54:09', NULL),
(453, 'ios', NULL, '2021-11-10 14:04:30', NULL),
(454, 'ios', NULL, '2021-11-10 14:06:50', NULL),
(455, 'ios', NULL, '2021-11-10 14:07:30', NULL),
(456, 'ios', NULL, '2021-11-10 14:08:13', NULL),
(457, 'ios', NULL, '2021-11-10 14:09:14', NULL),
(458, 'ios', NULL, '2021-11-10 14:11:30', NULL),
(459, 'ios', NULL, '2021-11-10 14:13:00', NULL),
(460, 'ios', NULL, '2021-11-10 14:22:46', NULL),
(461, 'ios', NULL, '2021-11-10 14:24:43', NULL),
(462, 'ios', NULL, '2021-11-10 16:00:08', NULL),
(463, 'ios', NULL, '2021-11-10 16:00:13', NULL),
(464, 'ios', NULL, '2021-11-10 16:01:39', NULL),
(465, 'ios', NULL, '2021-11-10 16:03:06', NULL),
(466, 'ios', NULL, '2021-11-10 16:03:25', NULL),
(467, 'ios', NULL, '2021-11-10 16:03:38', NULL),
(468, 'ios', NULL, '2021-11-10 16:05:58', NULL),
(469, 'ios', NULL, '2021-11-10 16:09:05', NULL),
(470, 'ios', NULL, '2021-11-10 20:23:13', NULL),
(471, 'ios', NULL, '2021-11-10 20:23:25', NULL),
(472, 'android', NULL, '2021-11-11 09:52:28', NULL),
(473, 'ios', NULL, '2021-11-11 13:27:39', NULL),
(474, 'ios', NULL, '2021-11-11 13:28:56', NULL),
(475, 'ios', NULL, '2021-11-11 13:29:04', NULL),
(476, 'ios', NULL, '2021-11-11 13:29:15', NULL),
(477, 'ios', NULL, '2021-11-11 13:29:17', NULL),
(478, 'ios', NULL, '2021-11-11 13:29:25', NULL),
(479, 'ios', NULL, '2021-11-11 13:32:14', NULL),
(480, 'android', NULL, '2021-11-12 16:52:57', NULL),
(481, 'android', NULL, '2021-11-12 16:58:58', NULL),
(482, 'android', NULL, '2021-11-12 17:00:01', NULL),
(483, 'android', NULL, '2021-11-12 17:00:43', NULL),
(484, 'android', NULL, '2021-11-12 17:01:24', NULL),
(485, 'android', NULL, '2021-11-12 17:02:33', NULL),
(486, 'android', NULL, '2021-11-12 17:09:19', NULL),
(487, 'android', NULL, '2021-11-12 17:11:38', NULL),
(488, 'android', NULL, '2021-11-12 17:11:57', NULL),
(489, 'android', NULL, '2021-11-12 17:12:13', NULL),
(490, 'android', NULL, '2021-11-12 17:42:54', NULL),
(491, 'android', NULL, '2021-11-12 18:00:35', NULL),
(492, 'android', NULL, '2021-11-12 18:00:55', NULL),
(493, 'android', NULL, '2021-11-12 18:02:05', NULL),
(494, 'android', NULL, '2021-11-12 18:14:17', NULL),
(495, 'android', NULL, '2021-11-12 18:16:37', NULL),
(496, 'android', NULL, '2021-11-12 18:19:19', NULL),
(497, 'android', NULL, '2021-11-12 18:24:54', NULL),
(498, 'android', NULL, '2021-11-12 18:27:45', NULL),
(499, 'android', NULL, '2021-11-12 18:30:47', NULL),
(500, 'android', NULL, '2021-11-12 18:36:49', NULL),
(501, 'android', NULL, '2021-11-12 18:37:32', NULL),
(502, 'android', NULL, '2021-11-12 18:38:45', NULL),
(503, 'android', NULL, '2021-11-13 13:28:47', NULL),
(504, 'android', NULL, '2021-11-13 13:32:02', NULL),
(505, 'android', NULL, '2021-11-13 13:33:00', NULL),
(506, 'android', NULL, '2021-11-13 13:52:42', NULL),
(507, 'android', NULL, '2021-11-13 13:52:56', NULL),
(508, 'android', NULL, '2021-11-13 13:53:00', NULL),
(509, 'android', NULL, '2021-11-13 13:53:09', NULL),
(510, 'android', NULL, '2021-11-13 13:53:14', NULL),
(511, 'android', NULL, '2021-11-13 13:53:59', NULL),
(512, 'android', NULL, '2021-11-13 13:57:30', NULL),
(513, 'android', NULL, '2021-11-13 13:57:36', NULL),
(514, 'android', NULL, '2021-11-13 14:03:58', NULL),
(515, 'android', NULL, '2021-11-13 14:05:23', NULL),
(516, 'android', NULL, '2021-11-13 14:11:20', NULL),
(517, 'android', NULL, '2021-11-13 14:12:30', NULL),
(518, 'android', NULL, '2021-11-13 14:17:38', NULL),
(519, 'android', NULL, '2021-11-13 14:17:47', NULL),
(520, 'android', NULL, '2021-11-13 14:18:23', NULL),
(521, 'android', NULL, '2021-11-13 14:18:25', NULL),
(522, 'android', NULL, '2021-11-13 14:21:21', NULL),
(523, 'android', NULL, '2021-11-13 14:21:29', NULL),
(524, 'android', NULL, '2021-11-13 14:22:34', NULL),
(525, 'android', NULL, '2021-11-13 14:26:49', NULL),
(526, 'android', NULL, '2021-11-13 14:27:02', NULL),
(527, 'android', NULL, '2021-11-13 14:28:45', NULL),
(528, 'android', NULL, '2021-11-13 14:29:35', NULL),
(529, 'android', NULL, '2021-11-13 14:30:04', NULL),
(530, 'android', NULL, '2021-11-13 14:31:43', NULL),
(531, 'android', NULL, '2021-11-13 14:31:49', NULL),
(532, 'android', NULL, '2021-11-13 14:32:10', NULL),
(533, 'android', NULL, '2021-11-13 14:32:42', NULL),
(534, 'android', NULL, '2021-11-13 14:33:53', NULL),
(535, 'android', NULL, '2021-11-13 14:36:58', NULL),
(536, 'android', NULL, '2021-11-13 14:41:14', NULL),
(537, 'android', NULL, '2021-11-13 14:45:28', NULL),
(538, 'android', NULL, '2021-11-13 14:45:34', NULL),
(539, 'android', NULL, '2021-11-13 14:45:39', NULL),
(540, 'android', NULL, '2021-11-13 14:49:50', NULL),
(541, 'android', NULL, '2021-11-13 14:54:42', NULL),
(542, 'android', NULL, '2021-11-13 14:56:25', NULL),
(543, 'android', NULL, '2021-11-13 14:56:44', NULL),
(544, 'android', NULL, '2021-11-13 14:56:46', NULL),
(545, 'android', NULL, '2021-11-13 14:56:48', NULL),
(546, 'android', NULL, '2021-11-13 14:58:40', NULL),
(547, 'android', NULL, '2021-11-13 15:01:55', NULL),
(548, 'ios', NULL, '2021-11-13 15:06:22', NULL),
(549, 'ios', NULL, '2021-11-13 15:06:40', NULL),
(550, 'ios', NULL, '2021-11-13 15:06:48', NULL),
(551, 'ios', NULL, '2021-11-13 15:07:41', NULL),
(552, 'ios', NULL, '2021-11-13 15:07:54', NULL),
(553, 'ios', NULL, '2021-11-13 16:09:22', NULL),
(554, 'ios', NULL, '2021-11-13 16:09:47', NULL),
(555, 'ios', NULL, '2021-11-13 16:09:56', NULL),
(556, 'ios', NULL, '2021-11-13 16:10:16', NULL),
(557, 'ios', NULL, '2021-11-13 16:10:34', NULL),
(558, 'android', NULL, '2021-11-14 18:18:03', NULL),
(559, 'android', NULL, '2021-11-14 18:18:13', NULL),
(560, 'android', NULL, '2021-11-14 18:19:51', NULL),
(561, 'ios', NULL, '2021-11-15 13:31:09', NULL),
(562, 'ios', NULL, '2021-11-15 13:31:38', NULL),
(563, 'ios', NULL, '2021-11-15 13:31:46', NULL),
(564, 'ios', NULL, '2021-11-15 13:37:59', NULL),
(565, 'ios', NULL, '2021-11-15 13:42:42', NULL),
(566, 'ios', NULL, '2021-11-15 13:55:20', NULL),
(567, 'ios', NULL, '2021-11-15 13:55:39', NULL),
(568, 'ios', NULL, '2021-11-15 13:56:44', NULL),
(569, 'ios', NULL, '2021-11-15 14:01:06', NULL),
(570, 'ios', NULL, '2021-11-15 14:01:11', NULL),
(571, 'ios', NULL, '2021-11-15 14:03:04', NULL),
(572, 'ios', NULL, '2021-11-15 14:07:32', NULL),
(573, 'ios', NULL, '2021-11-15 14:08:38', NULL),
(574, 'ios', NULL, '2021-11-15 14:09:37', NULL),
(575, 'ios', NULL, '2021-11-15 14:10:33', NULL),
(576, 'ios', NULL, '2021-11-15 14:15:51', NULL),
(577, 'ios', NULL, '2021-11-15 14:17:17', NULL),
(578, 'ios', NULL, '2021-11-15 14:17:53', NULL),
(579, 'ios', NULL, '2021-11-15 14:18:24', NULL),
(580, 'ios', NULL, '2021-11-15 14:33:36', NULL),
(581, 'ios', NULL, '2021-11-15 14:33:39', NULL),
(582, 'android', NULL, '2021-11-15 16:33:26', NULL),
(583, 'android', NULL, '2021-11-15 16:33:42', NULL),
(584, 'android', NULL, '2021-11-15 16:34:07', NULL),
(585, 'android', NULL, '2021-11-15 16:34:15', NULL),
(586, 'ios', NULL, '2021-11-16 12:25:27', NULL),
(587, 'ios', NULL, '2021-11-16 12:26:10', NULL),
(588, 'android', NULL, '2021-11-17 09:57:31', NULL),
(589, 'android', NULL, '2021-11-17 10:07:35', NULL),
(590, 'android', NULL, '2021-11-17 10:07:49', NULL),
(591, 'android', NULL, '2021-11-17 10:09:57', NULL),
(592, 'android', NULL, '2021-11-17 10:10:02', NULL),
(593, 'android', NULL, '2021-11-17 10:10:12', NULL),
(594, 'android', NULL, '2021-11-17 10:12:30', NULL),
(595, 'android', NULL, '2021-11-17 10:13:01', NULL),
(596, 'android', NULL, '2021-11-17 10:18:46', NULL),
(597, 'android', NULL, '2021-11-17 10:22:22', NULL),
(598, 'android', NULL, '2021-11-17 10:34:10', NULL),
(599, 'android', NULL, '2021-11-17 10:38:11', NULL),
(600, 'android', NULL, '2021-11-17 10:38:14', NULL),
(601, 'android', NULL, '2021-11-17 10:46:39', NULL),
(602, 'android', NULL, '2021-11-17 10:47:44', NULL),
(603, 'android', NULL, '2021-11-17 11:03:08', NULL),
(604, 'android', NULL, '2021-11-17 11:03:34', NULL),
(605, 'android', NULL, '2021-11-17 11:03:49', NULL),
(606, 'android', NULL, '2021-11-17 11:13:40', NULL),
(607, 'android', NULL, '2021-11-17 11:15:09', NULL),
(608, 'android', NULL, '2021-11-17 11:19:16', NULL),
(609, 'android', NULL, '2021-11-17 11:20:02', NULL),
(610, 'android', NULL, '2021-11-17 11:20:06', NULL),
(611, 'android', NULL, '2021-11-17 11:20:17', NULL),
(612, 'android', NULL, '2021-11-17 11:24:44', NULL),
(613, 'android', NULL, '2021-11-17 11:26:54', NULL),
(614, 'android', NULL, '2021-11-17 11:27:09', NULL),
(615, 'android', NULL, '2021-11-17 11:29:45', NULL),
(616, 'android', NULL, '2021-11-17 11:32:13', NULL),
(617, 'android', NULL, '2021-11-17 11:33:46', NULL),
(618, 'android', NULL, '2021-11-17 11:33:50', NULL),
(619, 'android', NULL, '2021-11-17 11:40:39', NULL),
(620, 'android', NULL, '2021-11-17 11:53:39', NULL),
(621, 'android', NULL, '2021-11-17 11:55:07', NULL),
(622, 'android', NULL, '2021-11-17 11:55:11', NULL),
(623, 'android', NULL, '2021-11-17 11:59:56', NULL),
(624, 'android', NULL, '2021-11-17 12:01:04', NULL),
(625, 'android', NULL, '2021-11-17 12:05:17', NULL),
(626, 'ios', NULL, '2021-11-17 15:04:34', NULL),
(627, 'android', NULL, '2021-11-18 09:47:11', NULL),
(628, 'android', NULL, '2021-11-18 09:49:37', NULL),
(629, 'android', NULL, '2021-11-18 09:51:10', NULL),
(630, 'android', NULL, '2021-11-18 09:51:59', NULL),
(631, 'ios', NULL, '2021-11-18 13:38:30', NULL),
(632, 'ios', NULL, '2021-11-18 13:42:20', NULL),
(633, 'android', NULL, '2021-11-19 17:06:42', NULL),
(634, 'android', NULL, '2021-11-19 17:20:58', NULL),
(635, 'ios', NULL, '2021-11-19 18:52:39', NULL),
(636, 'android', NULL, '2021-11-20 20:42:38', NULL),
(637, 'ios', NULL, '2021-11-20 20:57:27', NULL),
(638, 'android', NULL, '2021-11-20 21:05:03', NULL),
(639, 'android', NULL, '2021-11-20 21:29:22', NULL),
(640, 'android', NULL, '2021-11-20 21:36:54', NULL),
(641, 'android', NULL, '2021-11-20 21:39:04', NULL),
(642, 'android', NULL, '2021-11-20 21:41:39', NULL),
(643, 'android', NULL, '2021-11-20 22:27:09', NULL),
(644, 'android', NULL, '2021-11-20 22:28:00', NULL),
(645, 'android', NULL, '2021-11-20 22:28:22', NULL),
(646, 'android', NULL, '2021-11-20 22:28:39', NULL),
(647, 'android', NULL, '2021-11-20 22:28:51', NULL),
(648, 'android', NULL, '2021-11-20 22:28:58', NULL),
(649, 'android', NULL, '2021-11-20 22:29:17', NULL),
(650, 'android', NULL, '2021-11-20 22:29:21', NULL),
(651, 'android', NULL, '2021-11-20 22:29:35', NULL),
(652, 'android', NULL, '2021-11-20 22:29:47', NULL),
(653, 'android', NULL, '2021-11-20 22:31:32', NULL),
(654, 'android', NULL, '2021-11-20 22:31:39', NULL),
(655, 'android', NULL, '2021-11-20 22:31:46', NULL),
(656, 'android', NULL, '2021-11-20 22:46:35', NULL),
(657, 'android', NULL, '2021-11-20 22:47:30', NULL),
(658, 'android', NULL, '2021-11-20 22:47:59', NULL),
(659, 'ios', NULL, '2021-11-20 22:48:03', NULL),
(660, 'ios', NULL, '2021-11-20 22:48:10', NULL),
(661, 'ios', NULL, '2021-11-20 23:26:17', NULL),
(662, 'ios', NULL, '2021-11-20 23:26:27', NULL),
(663, 'ios', NULL, '2021-11-20 23:26:32', NULL),
(664, 'ios', NULL, '2021-11-20 23:26:46', NULL),
(665, 'ios', NULL, '2021-11-20 23:26:59', NULL),
(666, 'ios', NULL, '2021-11-20 23:28:19', NULL),
(667, 'android', NULL, '2021-11-21 00:42:21', NULL),
(668, 'android', NULL, '2021-11-21 00:42:29', NULL),
(669, 'android', NULL, '2021-11-21 00:43:34', NULL),
(670, 'android', NULL, '2021-11-21 00:44:26', NULL),
(671, 'android', NULL, '2021-11-21 00:44:53', NULL),
(672, 'android', NULL, '2021-11-21 00:47:13', NULL),
(673, 'android', NULL, '2021-11-21 00:47:22', NULL),
(674, 'android', NULL, '2021-11-21 00:47:27', NULL),
(675, 'android', NULL, '2021-11-21 00:47:29', NULL),
(676, 'android', NULL, '2021-11-21 10:24:25', NULL),
(677, 'android', NULL, '2021-11-21 10:24:29', NULL),
(678, 'android', NULL, '2021-11-21 11:48:19', NULL),
(679, 'android', NULL, '2021-11-21 11:48:56', NULL),
(680, 'android', NULL, '2021-11-21 11:50:02', NULL),
(681, 'android', NULL, '2021-11-21 11:50:25', NULL),
(682, 'android', NULL, '2021-11-21 11:51:33', NULL),
(683, 'android', NULL, '2021-11-21 11:51:52', NULL),
(684, 'android', NULL, '2021-11-21 11:52:35', NULL),
(685, 'android', NULL, '2021-11-21 11:53:05', NULL),
(686, 'android', NULL, '2021-11-21 11:53:50', NULL),
(687, 'android', NULL, '2021-11-21 11:54:46', NULL),
(688, 'android', NULL, '2021-11-21 11:54:49', NULL),
(689, 'ios', NULL, '2021-11-21 13:11:11', NULL),
(690, 'ios', NULL, '2021-11-21 13:11:41', NULL),
(691, 'ios', NULL, '2021-11-21 13:16:35', NULL),
(692, 'ios', NULL, '2021-11-21 13:20:59', NULL),
(693, 'ios', NULL, '2021-11-21 13:22:14', NULL),
(694, 'ios', NULL, '2021-11-21 13:24:49', NULL),
(695, 'ios', NULL, '2021-11-21 13:36:10', NULL),
(696, 'ios', NULL, '2021-11-21 15:23:26', NULL),
(697, 'ios', NULL, '2021-11-21 15:25:54', NULL),
(698, 'ios', NULL, '2021-11-21 15:37:35', NULL),
(699, 'ios', NULL, '2021-11-21 15:46:12', NULL),
(700, 'ios', NULL, '2021-11-21 15:55:29', NULL),
(701, 'ios', NULL, '2021-11-21 15:59:49', NULL),
(702, 'android', NULL, '2021-11-21 16:01:33', NULL),
(703, 'ios', NULL, '2021-11-21 16:03:24', NULL),
(704, 'ios', NULL, '2021-11-21 16:09:11', NULL),
(705, 'ios', NULL, '2021-11-21 16:39:04', NULL),
(706, 'ios', NULL, '2021-11-21 16:44:42', NULL),
(707, 'ios', NULL, '2021-11-21 17:11:26', NULL),
(708, 'ios', NULL, '2021-11-21 17:13:54', NULL),
(709, 'ios', NULL, '2021-11-21 17:14:19', NULL),
(710, 'ios', NULL, '2021-11-21 17:16:27', NULL),
(711, 'ios', NULL, '2021-11-21 17:20:25', NULL),
(712, 'ios', NULL, '2021-11-21 17:22:15', NULL),
(713, 'ios', NULL, '2021-11-21 17:26:05', NULL),
(714, 'ios', NULL, '2021-11-21 17:31:50', NULL),
(715, 'ios', NULL, '2021-11-21 17:32:38', NULL),
(716, 'ios', NULL, '2021-11-21 17:32:43', NULL),
(717, 'ios', NULL, '2021-11-21 17:32:55', NULL),
(718, 'ios', NULL, '2021-11-21 17:33:04', NULL),
(719, 'ios', NULL, '2021-11-21 19:48:05', NULL),
(720, 'android', NULL, '2021-11-21 19:56:06', NULL),
(721, 'android', NULL, '2021-11-21 19:59:13', NULL),
(722, 'android', NULL, '2021-11-21 23:00:01', NULL),
(723, 'android', NULL, '2021-11-21 23:12:33', NULL),
(724, 'android', NULL, '2021-11-21 23:18:39', NULL),
(725, 'android', NULL, '2021-11-21 23:26:32', NULL),
(726, 'android', NULL, '2021-11-22 08:38:31', NULL),
(727, 'android', NULL, '2021-11-22 08:39:01', NULL),
(728, 'android', NULL, '2021-11-22 08:40:02', NULL),
(729, 'android', NULL, '2021-11-22 08:40:10', NULL),
(730, 'android', NULL, '2021-11-22 08:47:13', NULL),
(731, 'android', NULL, '2021-11-22 10:52:41', NULL),
(732, 'android', NULL, '2021-11-22 11:48:10', NULL),
(733, 'android', NULL, '2021-11-22 11:48:59', NULL),
(734, 'android', NULL, '2021-11-22 11:49:03', NULL),
(735, 'android', NULL, '2021-11-22 12:52:42', NULL),
(736, 'ios', NULL, '2021-11-22 13:57:31', NULL),
(737, 'ios', NULL, '2021-11-22 13:57:38', NULL),
(738, 'ios', NULL, '2021-11-22 13:59:17', NULL),
(739, 'android', NULL, '2021-11-22 13:59:19', NULL),
(740, 'android', NULL, '2021-11-22 13:59:58', NULL),
(741, 'android', NULL, '2021-11-22 14:00:10', NULL),
(742, 'android', NULL, '2021-11-22 14:00:46', NULL),
(743, 'android', NULL, '2021-11-22 14:00:47', NULL),
(744, 'ios', NULL, '2021-11-22 14:02:32', NULL),
(745, 'android', NULL, '2021-11-22 14:04:20', NULL),
(746, 'android', NULL, '2021-11-22 14:05:08', NULL),
(747, 'ios', NULL, '2021-11-22 14:06:44', NULL),
(748, 'android', NULL, '2021-11-22 14:07:50', NULL),
(749, 'android', NULL, '2021-11-22 14:17:36', NULL),
(750, 'ios', NULL, '2021-11-22 14:17:41', NULL),
(751, 'ios', NULL, '2021-11-22 14:18:25', NULL),
(752, 'ios', NULL, '2021-11-22 14:19:54', NULL),
(753, 'ios', NULL, '2021-11-22 14:22:00', NULL),
(754, 'android', NULL, '2021-11-22 14:22:34', NULL),
(755, 'android', NULL, '2021-11-22 14:23:13', NULL),
(756, 'android', NULL, '2021-11-22 14:44:02', NULL),
(757, 'android', NULL, '2021-11-22 14:44:25', NULL),
(758, 'android', NULL, '2021-11-22 16:50:30', NULL),
(759, 'ios', NULL, '2021-11-22 18:19:32', NULL),
(760, 'ios', NULL, '2021-11-22 18:25:55', NULL),
(761, 'ios', NULL, '2021-11-23 18:27:14', NULL),
(762, 'ios', NULL, '2021-11-23 20:33:04', NULL),
(763, 'ios', NULL, '2021-11-23 20:34:25', NULL),
(764, 'ios', NULL, '2021-11-23 20:37:03', NULL),
(765, 'ios', NULL, '2021-11-23 20:37:14', NULL),
(766, 'ios', NULL, '2021-11-23 23:40:42', NULL),
(767, 'ios', NULL, '2021-11-23 23:43:48', NULL),
(768, 'ios', NULL, '2021-11-23 23:48:40', NULL),
(769, 'ios', NULL, '2021-11-23 23:49:06', NULL),
(770, 'ios', NULL, '2021-11-23 23:49:36', NULL),
(771, 'ios', NULL, '2021-11-23 23:56:28', NULL),
(772, 'ios', NULL, '2021-11-24 00:01:27', NULL),
(773, 'ios', NULL, '2021-11-24 00:04:49', NULL),
(774, 'ios', NULL, '2021-11-24 00:09:43', NULL),
(775, 'ios', NULL, '2021-11-24 00:09:48', NULL),
(776, 'android', NULL, '2021-11-24 10:07:41', NULL),
(777, 'ios', NULL, '2021-11-24 13:54:37', NULL),
(778, 'ios', NULL, '2021-11-24 13:54:48', NULL),
(779, 'ios', NULL, '2021-11-24 13:55:58', NULL),
(780, 'ios', NULL, '2021-11-24 13:56:38', NULL),
(781, 'ios', NULL, '2021-11-24 13:57:31', NULL),
(782, 'ios', NULL, '2021-11-24 14:21:36', NULL),
(783, 'ios', NULL, '2021-11-24 14:21:44', NULL),
(784, 'ios', NULL, '2021-11-24 14:24:32', NULL),
(785, 'ios', NULL, '2021-11-24 14:25:02', NULL),
(786, 'ios', NULL, '2021-11-24 14:25:05', NULL),
(787, 'ios', NULL, '2021-11-24 14:25:07', NULL),
(788, 'ios', NULL, '2021-11-24 14:25:08', NULL),
(789, 'ios', NULL, '2021-11-24 14:25:09', NULL),
(790, 'ios', NULL, '2021-11-24 14:25:10', NULL),
(791, 'ios', NULL, '2021-11-24 14:26:41', NULL),
(792, 'ios', NULL, '2021-11-24 14:26:44', NULL),
(793, 'ios', NULL, '2021-11-24 14:29:37', NULL),
(794, 'ios', NULL, '2021-11-24 14:29:50', NULL),
(795, 'ios', NULL, '2021-11-24 14:29:56', NULL),
(796, 'ios', NULL, '2021-11-24 14:30:02', NULL),
(797, 'ios', NULL, '2021-11-24 14:30:18', NULL),
(798, 'android', NULL, '2021-11-24 22:50:49', NULL),
(799, 'android', NULL, '2021-11-24 23:04:39', NULL),
(800, 'android', NULL, '2021-11-24 23:18:20', NULL),
(801, 'android', NULL, '2021-11-24 23:25:19', NULL),
(802, 'android', NULL, '2021-11-24 23:25:33', NULL),
(803, 'android', NULL, '2021-11-24 23:25:45', NULL),
(804, 'android', NULL, '2021-11-24 23:26:13', NULL),
(805, 'android', NULL, '2021-11-24 23:26:37', NULL),
(806, 'android', NULL, '2021-11-24 23:27:14', NULL),
(807, 'android', NULL, '2021-11-24 23:40:27', NULL),
(808, 'android', NULL, '2021-11-24 23:41:31', NULL),
(809, 'android', NULL, '2021-11-27 14:47:55', NULL),
(810, 'android', NULL, '2021-11-27 14:49:04', NULL),
(811, 'android', NULL, '2021-11-27 14:50:03', NULL),
(812, 'android', NULL, '2021-11-27 15:21:27', NULL),
(813, 'android', NULL, '2021-11-27 15:22:24', NULL),
(814, 'android', NULL, '2021-11-27 19:51:18', NULL),
(815, 'android', NULL, '2021-11-27 20:04:36', NULL),
(816, 'android', NULL, '2021-11-27 20:05:56', NULL),
(817, 'android', NULL, '2021-11-27 20:06:03', NULL),
(818, 'android', NULL, '2021-11-27 22:22:51', NULL),
(819, 'android', NULL, '2021-11-27 22:23:40', NULL),
(820, 'android', NULL, '2021-11-27 22:25:48', NULL),
(821, 'android', NULL, '2021-11-27 23:36:32', NULL),
(822, 'android', NULL, '2021-11-27 23:36:42', NULL),
(823, 'android', NULL, '2021-11-27 23:56:28', NULL),
(824, 'android', NULL, '2021-11-28 10:37:29', NULL),
(825, 'android', NULL, '2021-11-28 10:44:32', NULL),
(826, 'android', NULL, '2021-11-28 11:46:07', NULL),
(827, 'android', NULL, '2021-11-28 11:46:27', NULL),
(828, 'android', NULL, '2021-11-28 11:46:58', NULL),
(829, 'android', NULL, '2021-11-28 11:48:13', NULL),
(830, 'android', NULL, '2021-11-28 12:44:54', NULL),
(831, 'ios', NULL, '2021-11-28 17:06:20', NULL),
(832, 'ios', NULL, '2021-11-28 17:06:32', NULL),
(833, 'ios', NULL, '2021-11-28 17:06:53', NULL),
(834, 'ios', NULL, '2021-11-29 12:42:28', NULL),
(835, 'ios', NULL, '2021-11-29 12:42:47', NULL),
(836, 'ios', NULL, '2021-11-29 14:06:10', NULL),
(837, 'ios', NULL, '2021-11-29 14:06:30', NULL),
(838, 'ios', NULL, '2021-11-29 14:08:01', NULL),
(839, 'ios', NULL, '2021-11-29 14:08:49', NULL),
(840, 'ios', NULL, '2021-11-29 14:09:46', NULL),
(841, 'ios', NULL, '2021-11-29 14:10:13', NULL),
(842, 'ios', NULL, '2021-11-29 14:10:52', NULL),
(843, 'android', NULL, '2021-11-29 14:13:31', NULL),
(844, 'android', NULL, '2021-11-29 14:13:48', NULL),
(845, 'android', NULL, '2021-11-29 14:14:15', NULL),
(846, 'android', NULL, '2021-11-29 14:15:11', NULL),
(847, 'android', NULL, '2021-11-29 14:24:05', NULL),
(848, 'android', NULL, '2021-11-29 14:24:09', NULL),
(849, 'android', NULL, '2021-11-29 17:19:14', NULL),
(850, 'android', NULL, '2021-11-29 19:14:14', NULL),
(851, 'ios', NULL, '2021-11-29 19:44:19', NULL),
(852, 'ios', NULL, '2021-11-29 19:44:32', NULL),
(853, 'ios', NULL, '2021-11-29 19:46:15', NULL),
(854, 'ios', NULL, '2021-11-29 19:46:31', NULL),
(855, 'ios', NULL, '2021-11-29 19:56:36', NULL),
(856, 'ios', NULL, '2021-11-29 19:58:29', NULL),
(857, 'ios', NULL, '2021-11-29 19:59:14', NULL),
(858, 'ios', NULL, '2021-11-29 20:05:02', NULL),
(859, 'ios', NULL, '2021-11-29 20:07:49', NULL),
(860, 'ios', NULL, '2021-11-29 20:09:28', NULL),
(861, 'ios', NULL, '2021-11-29 20:09:41', NULL),
(862, 'ios', NULL, '2021-11-29 20:11:16', NULL),
(863, 'ios', NULL, '2021-11-29 20:12:21', NULL),
(864, 'ios', NULL, '2021-11-29 20:14:04', NULL),
(865, 'ios', NULL, '2021-11-29 20:17:18', NULL),
(866, 'ios', NULL, '2021-11-29 20:19:19', NULL),
(867, 'ios', NULL, '2021-11-29 20:23:50', NULL),
(868, 'ios', NULL, '2021-11-29 20:26:02', NULL),
(869, 'ios', NULL, '2021-12-01 11:22:47', NULL),
(870, 'ios', NULL, '2021-12-01 12:56:48', NULL),
(871, 'ios', NULL, '2021-12-01 13:27:44', NULL),
(872, 'ios', NULL, '2021-12-01 13:29:01', NULL),
(873, 'ios', NULL, '2021-12-01 13:29:47', NULL),
(874, 'ios', NULL, '2021-12-01 13:30:19', NULL),
(875, 'ios', NULL, '2021-12-01 13:31:21', NULL),
(876, 'android', NULL, '2021-12-01 17:17:45', NULL),
(877, 'ios', NULL, '2021-12-01 19:13:02', NULL),
(878, 'ios', NULL, '2021-12-01 19:14:11', NULL),
(879, 'ios', NULL, '2021-12-01 19:14:19', NULL),
(880, 'ios', NULL, '2021-12-01 19:15:24', NULL),
(881, 'android', NULL, '2021-12-01 19:16:21', NULL),
(882, 'android', NULL, '2021-12-01 19:18:30', NULL),
(883, 'ios', NULL, '2021-12-01 19:18:30', NULL),
(884, 'android', NULL, '2021-12-01 19:18:42', NULL),
(885, 'ios', NULL, '2021-12-01 19:19:41', NULL),
(886, 'android', NULL, '2021-12-01 19:19:57', NULL),
(887, 'ios', NULL, '2021-12-01 19:20:21', NULL),
(888, 'android', NULL, '2021-12-01 19:20:22', NULL),
(889, 'ios', NULL, '2021-12-01 19:20:34', NULL),
(890, 'android', NULL, '2021-12-01 19:27:34', NULL),
(891, 'ios', NULL, '2021-12-01 19:28:40', NULL),
(892, 'android', NULL, '2021-12-01 19:28:45', NULL),
(893, 'ios', NULL, '2021-12-01 19:28:49', NULL),
(894, 'ios', NULL, '2021-12-01 19:32:10', NULL),
(895, 'android', NULL, '2021-12-01 19:43:01', NULL),
(896, 'android', NULL, '2021-12-01 19:48:50', NULL),
(897, 'android', NULL, '2021-12-01 19:48:52', NULL),
(898, 'android', NULL, '2021-12-01 20:46:05', NULL),
(899, 'android', NULL, '2021-12-02 09:32:14', NULL),
(900, 'android', NULL, '2021-12-02 09:44:06', NULL),
(901, 'android', NULL, '2021-12-02 10:15:12', NULL),
(902, 'android', NULL, '2021-12-02 10:22:33', NULL),
(903, 'android', NULL, '2021-12-02 10:25:52', NULL),
(904, 'android', NULL, '2021-12-02 11:15:56', NULL),
(905, 'android', NULL, '2021-12-02 11:19:38', NULL),
(906, 'android', NULL, '2021-12-02 11:30:02', NULL),
(907, 'android', NULL, '2021-12-02 11:47:00', NULL),
(908, 'android', NULL, '2021-12-02 11:49:58', NULL),
(909, 'android', NULL, '2021-12-02 11:55:25', NULL),
(910, 'android', NULL, '2021-12-02 11:56:35', NULL),
(911, 'android', NULL, '2021-12-02 12:15:30', NULL),
(912, 'android', NULL, '2021-12-02 12:18:41', NULL),
(913, 'android', NULL, '2021-12-02 12:19:25', NULL),
(914, 'android', NULL, '2021-12-02 12:22:32', NULL),
(915, 'android', NULL, '2021-12-02 12:26:37', NULL),
(916, 'android', NULL, '2021-12-02 12:28:52', NULL),
(917, 'android', NULL, '2021-12-02 12:31:38', NULL),
(918, 'android', NULL, '2021-12-02 12:32:09', NULL),
(919, 'android', NULL, '2021-12-02 12:32:56', NULL),
(920, 'android', NULL, '2021-12-02 12:35:17', NULL),
(921, 'android', NULL, '2021-12-02 18:51:38', NULL),
(922, 'android', NULL, '2021-12-03 16:32:47', NULL),
(923, 'android', NULL, '2021-12-03 16:46:43', NULL),
(924, 'android', NULL, '2021-12-03 20:31:59', NULL),
(925, 'android', NULL, '2021-12-03 20:32:32', NULL),
(926, 'android', NULL, '2021-12-04 19:39:13', NULL),
(927, 'android', NULL, '2021-12-04 20:25:45', NULL),
(928, 'android', NULL, '2021-12-04 20:41:55', NULL),
(929, 'android', NULL, '2021-12-04 20:54:21', NULL),
(930, 'ios', NULL, '2021-12-04 21:08:35', NULL),
(931, 'ios', NULL, '2021-12-04 21:10:57', NULL),
(932, 'ios', NULL, '2021-12-04 21:12:44', NULL),
(933, 'ios', NULL, '2021-12-04 21:38:38', NULL),
(934, 'ios', NULL, '2021-12-04 21:58:54', NULL),
(935, 'android', NULL, '2021-12-04 22:02:16', NULL),
(936, 'android', NULL, '2021-12-04 22:07:50', NULL),
(937, 'ios', NULL, '2021-12-04 22:43:07', NULL),
(938, 'ios', NULL, '2021-12-04 22:54:47', NULL),
(939, 'ios', NULL, '2021-12-04 22:54:59', NULL),
(940, 'ios', NULL, '2021-12-04 22:55:18', NULL),
(941, 'ios', NULL, '2021-12-04 22:55:46', NULL),
(942, 'ios', NULL, '2021-12-04 22:56:15', NULL),
(943, 'ios', NULL, '2021-12-04 22:58:19', NULL),
(944, 'ios', NULL, '2021-12-04 22:59:28', NULL),
(945, 'ios', NULL, '2021-12-04 23:02:04', NULL),
(946, 'ios', NULL, '2021-12-04 23:08:27', NULL),
(947, 'ios', NULL, '2021-12-04 23:14:44', NULL),
(948, 'ios', NULL, '2021-12-04 23:28:45', NULL),
(949, 'ios', NULL, '2021-12-04 23:28:54', NULL),
(950, 'ios', NULL, '2021-12-04 23:33:39', NULL),
(951, 'ios', NULL, '2021-12-04 23:38:06', NULL),
(952, 'ios', NULL, '2021-12-04 23:38:49', NULL),
(953, 'ios', NULL, '2021-12-04 23:42:19', NULL),
(954, 'ios', NULL, '2021-12-04 23:43:18', NULL),
(955, 'ios', NULL, '2021-12-04 23:45:57', NULL),
(956, 'ios', NULL, '2021-12-04 23:46:43', NULL),
(957, 'ios', NULL, '2021-12-04 23:47:42', NULL),
(958, 'ios', NULL, '2021-12-04 23:50:01', NULL),
(959, 'android', NULL, '2021-12-05 09:42:24', NULL),
(960, 'android', NULL, '2021-12-05 10:24:40', NULL),
(961, 'ios', NULL, '2021-12-05 14:37:16', NULL),
(962, 'ios', NULL, '2021-12-05 14:49:35', NULL),
(963, 'ios', NULL, '2021-12-05 14:52:17', NULL),
(964, 'ios', NULL, '2021-12-05 15:04:46', NULL),
(965, 'ios', NULL, '2021-12-05 15:06:05', NULL),
(966, 'android', NULL, '2021-12-05 18:09:57', NULL),
(967, 'android', NULL, '2021-12-05 18:15:35', NULL),
(968, 'android', NULL, '2021-12-05 18:19:35', NULL),
(969, 'android', NULL, '2021-12-05 18:20:27', NULL),
(970, 'android', NULL, '2021-12-05 18:39:48', NULL),
(971, 'android', NULL, '2021-12-05 18:40:01', NULL),
(972, 'android', NULL, '2021-12-05 18:40:11', NULL),
(973, 'android', NULL, '2021-12-05 18:40:19', NULL),
(974, 'android', NULL, '2021-12-05 18:40:39', NULL),
(975, 'android', NULL, '2021-12-05 19:09:28', NULL),
(976, 'android', NULL, '2021-12-05 19:23:23', NULL),
(977, 'android', NULL, '2021-12-05 19:42:48', NULL),
(978, 'android', NULL, '2021-12-05 19:43:43', NULL),
(979, 'android', NULL, '2021-12-05 19:43:50', NULL),
(980, 'android', NULL, '2021-12-05 19:44:01', NULL),
(981, 'ios', NULL, '2021-12-05 20:17:02', NULL),
(982, 'ios', NULL, '2021-12-05 20:17:22', NULL),
(983, 'ios', NULL, '2021-12-05 20:17:27', NULL),
(984, 'ios', NULL, '2021-12-05 20:17:38', NULL),
(985, 'ios', NULL, '2021-12-05 20:20:10', NULL),
(986, 'ios', NULL, '2021-12-05 20:20:22', NULL),
(987, 'ios', NULL, '2021-12-05 20:20:27', NULL),
(988, 'ios', NULL, '2021-12-05 20:21:03', NULL),
(989, 'ios', NULL, '2021-12-05 20:21:23', NULL),
(990, 'ios', NULL, '2021-12-05 20:21:28', NULL),
(991, 'android', NULL, '2021-12-05 21:12:34', NULL),
(992, 'android', NULL, '2021-12-05 21:56:14', NULL),
(993, 'android', NULL, '2021-12-06 07:42:57', NULL),
(994, 'android', NULL, '2021-12-06 07:43:08', NULL),
(995, 'android', NULL, '2021-12-06 07:43:15', NULL),
(996, 'android', NULL, '2021-12-06 07:43:15', NULL),
(997, 'android', NULL, '2021-12-06 07:44:31', NULL),
(998, 'android', NULL, '2021-12-06 12:38:18', NULL),
(999, 'android', NULL, '2021-12-06 12:39:15', NULL),
(1000, 'android', NULL, '2021-12-06 12:39:21', NULL),
(1001, 'android', NULL, '2021-12-06 12:40:28', NULL),
(1002, 'android', NULL, '2021-12-06 13:35:57', NULL),
(1003, 'android', NULL, '2021-12-06 13:38:11', NULL),
(1004, 'android', NULL, '2021-12-06 13:41:11', NULL),
(1005, 'android', NULL, '2021-12-06 18:56:10', NULL),
(1006, 'android', NULL, '2021-12-06 18:56:14', NULL),
(1007, 'android', NULL, '2021-12-06 18:56:36', NULL),
(1008, 'android', NULL, '2021-12-06 18:57:35', NULL);
INSERT INTO `visits` (`id`, `device_type`, `city_id`, `created_at`, `deleted_at`) VALUES
(1009, 'android', NULL, '2021-12-06 22:34:41', NULL),
(1010, 'android', NULL, '2021-12-06 22:58:28', NULL),
(1011, 'android', NULL, '2021-12-06 22:59:48', NULL),
(1012, 'android', NULL, '2021-12-06 23:00:03', NULL),
(1013, 'ios', NULL, '2021-12-07 10:45:18', NULL),
(1014, 'ios', NULL, '2021-12-07 10:52:15', NULL),
(1015, 'ios', NULL, '2021-12-07 10:54:19', NULL),
(1016, 'ios', NULL, '2021-12-07 10:57:29', NULL),
(1017, 'ios', NULL, '2021-12-07 14:30:19', NULL),
(1018, 'ios', NULL, '2021-12-07 14:31:33', NULL),
(1019, 'ios', NULL, '2021-12-07 14:33:13', NULL),
(1020, 'ios', NULL, '2021-12-07 15:41:05', NULL),
(1021, 'ios', NULL, '2021-12-07 15:41:15', NULL),
(1022, 'ios', NULL, '2021-12-07 16:23:01', NULL),
(1023, 'ios', NULL, '2021-12-08 10:25:49', NULL),
(1024, 'ios', NULL, '2021-12-08 10:31:21', NULL),
(1025, 'ios', NULL, '2021-12-08 10:49:16', NULL),
(1026, 'ios', NULL, '2021-12-08 10:52:21', NULL),
(1027, 'ios', NULL, '2021-12-08 10:58:04', NULL),
(1028, 'ios', NULL, '2021-12-08 10:58:12', NULL),
(1029, 'ios', NULL, '2021-12-08 11:26:04', NULL),
(1030, 'ios', NULL, '2021-12-08 11:27:36', NULL),
(1031, 'ios', NULL, '2021-12-08 11:28:19', NULL),
(1032, 'ios', NULL, '2021-12-08 12:24:24', NULL),
(1033, 'android', NULL, '2021-12-08 12:36:28', NULL),
(1034, 'ios', NULL, '2021-12-08 12:38:47', NULL),
(1035, 'ios', NULL, '2021-12-08 12:41:43', NULL),
(1036, 'ios', NULL, '2021-12-08 12:42:49', NULL),
(1037, 'ios', NULL, '2021-12-08 12:45:47', NULL),
(1038, 'ios', NULL, '2021-12-08 13:00:14', NULL),
(1039, 'ios', NULL, '2021-12-08 13:02:52', NULL),
(1040, 'ios', NULL, '2021-12-08 13:12:13', NULL),
(1041, 'ios', NULL, '2021-12-08 13:23:30', NULL),
(1042, 'ios', NULL, '2021-12-08 13:23:49', NULL),
(1043, 'ios', NULL, '2021-12-08 13:24:05', NULL),
(1044, 'ios', NULL, '2021-12-08 13:24:13', NULL),
(1045, 'ios', NULL, '2021-12-08 13:38:23', NULL),
(1046, 'ios', NULL, '2021-12-08 13:39:58', NULL),
(1047, 'ios', NULL, '2021-12-08 13:40:15', NULL),
(1048, 'ios', NULL, '2021-12-08 14:13:13', NULL),
(1049, 'ios', NULL, '2021-12-08 14:13:55', NULL),
(1050, 'ios', NULL, '2021-12-08 14:18:37', NULL),
(1051, 'ios', NULL, '2021-12-08 14:28:52', NULL),
(1052, 'ios', NULL, '2021-12-08 14:34:17', NULL),
(1053, 'ios', NULL, '2021-12-08 14:36:44', NULL),
(1054, 'ios', NULL, '2021-12-08 14:40:34', NULL),
(1055, 'ios', NULL, '2021-12-08 14:40:38', NULL),
(1056, 'ios', NULL, '2021-12-08 18:50:58', NULL),
(1057, 'ios', NULL, '2021-12-08 18:51:56', NULL),
(1058, 'ios', NULL, '2021-12-08 18:52:05', NULL),
(1059, 'ios', NULL, '2021-12-08 18:52:53', NULL),
(1060, 'ios', NULL, '2021-12-08 18:53:17', NULL),
(1061, 'android', NULL, '2021-12-08 23:32:14', NULL),
(1062, 'android', NULL, '2021-12-08 23:33:20', NULL),
(1063, 'ios', NULL, '2021-12-09 10:35:57', NULL),
(1064, 'ios', NULL, '2021-12-09 10:36:34', NULL),
(1065, 'ios', NULL, '2021-12-09 10:53:26', NULL),
(1066, 'ios', NULL, '2021-12-09 10:58:45', NULL),
(1067, 'ios', NULL, '2021-12-09 11:01:16', NULL),
(1068, 'ios', NULL, '2021-12-09 11:03:18', NULL),
(1069, 'ios', NULL, '2021-12-09 11:10:16', NULL),
(1070, 'ios', NULL, '2021-12-09 11:11:26', NULL),
(1071, 'ios', NULL, '2021-12-09 19:46:42', NULL),
(1072, 'ios', NULL, '2021-12-09 19:46:57', NULL),
(1073, 'ios', NULL, '2021-12-09 19:47:21', NULL),
(1074, 'ios', NULL, '2021-12-09 20:46:42', NULL),
(1075, 'ios', NULL, '2021-12-10 23:10:34', NULL),
(1076, 'ios', NULL, '2021-12-10 23:13:33', NULL),
(1077, 'ios', NULL, '2021-12-10 23:19:54', NULL),
(1078, 'ios', NULL, '2021-12-10 23:20:27', NULL),
(1079, 'ios', NULL, '2021-12-11 22:09:03', NULL),
(1080, 'android', NULL, '2021-12-11 22:54:02', NULL),
(1081, 'android', NULL, '2021-12-11 23:01:10', NULL),
(1082, 'ios', NULL, '2021-12-11 23:08:22', NULL),
(1083, 'ios', NULL, '2021-12-12 00:01:35', NULL),
(1084, 'ios', NULL, '2021-12-12 00:10:13', NULL),
(1085, 'ios', NULL, '2021-12-12 00:10:51', NULL),
(1086, 'ios', NULL, '2021-12-12 00:41:47', NULL),
(1087, 'ios', NULL, '2021-12-12 01:04:48', NULL),
(1088, 'ios', NULL, '2021-12-12 12:22:05', NULL),
(1089, 'ios', NULL, '2021-12-12 12:24:18', NULL),
(1090, 'ios', NULL, '2021-12-12 12:24:21', NULL),
(1091, 'ios', NULL, '2021-12-12 19:16:33', NULL),
(1092, 'ios', NULL, '2021-12-12 19:16:39', NULL),
(1093, 'ios', NULL, '2021-12-12 19:18:58', NULL),
(1094, 'ios', NULL, '2021-12-12 19:19:40', NULL),
(1095, 'ios', NULL, '2021-12-12 19:20:00', NULL),
(1096, 'android', NULL, '2021-12-12 19:20:04', NULL),
(1097, 'ios', NULL, '2021-12-12 19:20:23', NULL),
(1098, 'android', NULL, '2021-12-12 19:21:56', NULL),
(1099, 'ios', NULL, '2021-12-12 19:45:24', NULL),
(1100, 'ios', NULL, '2021-12-12 19:45:39', NULL),
(1101, 'ios', NULL, '2021-12-12 19:48:55', NULL),
(1102, 'ios', NULL, '2021-12-12 19:49:05', NULL),
(1103, 'ios', NULL, '2021-12-12 19:49:22', NULL),
(1104, 'ios', NULL, '2021-12-12 19:49:31', NULL),
(1105, 'ios', NULL, '2021-12-12 22:07:47', NULL),
(1106, 'ios', NULL, '2021-12-12 22:07:58', NULL),
(1107, 'ios', NULL, '2021-12-12 22:08:01', NULL),
(1108, 'ios', NULL, '2021-12-12 22:08:03', NULL),
(1109, 'ios', NULL, '2021-12-12 22:19:36', NULL),
(1110, 'ios', NULL, '2021-12-12 22:20:53', NULL),
(1111, 'ios', NULL, '2021-12-12 22:28:06', NULL),
(1112, 'ios', NULL, '2021-12-12 22:33:27', NULL),
(1113, 'ios', NULL, '2021-12-12 22:35:58', NULL),
(1114, 'ios', NULL, '2021-12-12 22:54:17', NULL),
(1115, 'ios', NULL, '2021-12-12 22:54:30', NULL),
(1116, 'ios', NULL, '2021-12-12 22:56:08', NULL),
(1117, 'ios', NULL, '2021-12-12 23:00:39', NULL),
(1118, 'ios', NULL, '2021-12-12 23:01:32', NULL),
(1119, 'ios', NULL, '2021-12-12 23:02:11', NULL),
(1120, 'ios', NULL, '2021-12-12 23:02:28', NULL),
(1121, 'ios', NULL, '2021-12-12 23:06:51', NULL),
(1122, 'ios', NULL, '2021-12-12 23:18:13', NULL),
(1123, 'ios', NULL, '2021-12-12 23:18:15', NULL),
(1124, 'ios', NULL, '2021-12-12 23:18:58', NULL),
(1125, 'ios', NULL, '2021-12-12 23:19:12', NULL),
(1126, 'ios', NULL, '2021-12-12 23:19:15', NULL),
(1127, 'ios', NULL, '2021-12-12 23:19:46', NULL),
(1128, 'ios', NULL, '2021-12-12 23:22:34', NULL),
(1129, 'ios', NULL, '2021-12-12 23:24:23', NULL),
(1130, 'ios', NULL, '2021-12-12 23:26:03', NULL),
(1131, 'ios', NULL, '2021-12-12 23:26:57', NULL),
(1132, 'ios', NULL, '2021-12-12 23:27:08', NULL),
(1133, 'ios', NULL, '2021-12-12 23:29:53', NULL),
(1134, 'ios', NULL, '2021-12-12 23:30:53', NULL),
(1135, 'ios', NULL, '2021-12-12 23:31:06', NULL),
(1136, 'ios', NULL, '2021-12-12 23:31:20', NULL),
(1137, 'ios', NULL, '2021-12-12 23:31:49', NULL),
(1138, 'ios', NULL, '2021-12-12 23:33:10', NULL),
(1139, 'ios', NULL, '2021-12-12 23:35:37', NULL),
(1140, 'ios', NULL, '2021-12-12 23:36:07', NULL),
(1141, 'ios', NULL, '2021-12-12 23:36:17', NULL),
(1142, 'ios', NULL, '2021-12-13 00:17:17', NULL),
(1143, 'ios', NULL, '2021-12-13 00:20:18', NULL),
(1144, 'ios', NULL, '2021-12-13 00:21:16', NULL),
(1145, 'ios', NULL, '2021-12-13 00:21:28', NULL),
(1146, 'ios', NULL, '2021-12-13 00:21:41', NULL),
(1147, 'ios', NULL, '2021-12-13 00:25:15', NULL),
(1148, 'ios', NULL, '2021-12-13 00:26:36', NULL),
(1149, 'ios', NULL, '2021-12-13 00:38:29', NULL),
(1150, 'ios', NULL, '2021-12-13 00:38:52', NULL),
(1151, 'ios', NULL, '2021-12-13 00:39:34', NULL),
(1152, 'ios', NULL, '2021-12-13 00:40:27', NULL),
(1153, 'ios', NULL, '2021-12-13 00:41:13', NULL),
(1154, 'ios', NULL, '2021-12-13 00:42:14', NULL),
(1155, 'ios', NULL, '2021-12-13 00:43:10', NULL),
(1156, 'ios', NULL, '2021-12-13 00:45:10', NULL),
(1157, 'ios', NULL, '2021-12-13 00:53:43', NULL),
(1158, 'ios', NULL, '2021-12-13 00:53:58', NULL),
(1159, 'ios', NULL, '2021-12-13 00:54:33', NULL),
(1160, 'ios', NULL, '2021-12-13 00:55:08', NULL),
(1161, 'ios', NULL, '2021-12-13 01:00:58', NULL),
(1162, 'ios', NULL, '2021-12-13 01:05:13', NULL),
(1163, 'ios', NULL, '2021-12-13 01:07:50', NULL),
(1164, 'ios', NULL, '2021-12-13 01:09:54', NULL),
(1165, 'android', NULL, '2021-12-13 05:47:40', NULL),
(1166, 'android', NULL, '2021-12-13 05:51:49', NULL),
(1167, 'android', NULL, '2021-12-13 05:51:54', NULL),
(1168, 'ios', NULL, '2021-12-13 10:54:07', NULL),
(1169, 'ios', NULL, '2021-12-13 10:54:13', NULL),
(1170, 'ios', NULL, '2021-12-13 11:07:16', NULL),
(1171, 'ios', NULL, '2021-12-13 11:08:54', NULL),
(1172, 'ios', NULL, '2021-12-13 11:20:19', NULL),
(1173, 'ios', NULL, '2021-12-13 11:20:24', NULL),
(1174, 'ios', NULL, '2021-12-13 11:20:31', NULL),
(1175, 'ios', NULL, '2021-12-13 11:48:00', NULL),
(1176, 'ios', NULL, '2021-12-13 11:58:53', NULL),
(1177, 'ios', NULL, '2021-12-13 11:59:11', NULL),
(1178, 'ios', NULL, '2021-12-13 12:00:34', NULL),
(1179, 'ios', NULL, '2021-12-13 12:15:47', NULL),
(1180, 'ios', NULL, '2021-12-13 13:57:23', NULL),
(1181, 'ios', NULL, '2021-12-13 13:58:54', NULL),
(1182, 'ios', NULL, '2021-12-13 13:59:14', NULL),
(1183, 'ios', NULL, '2021-12-13 14:44:12', NULL),
(1184, 'ios', NULL, '2021-12-13 14:49:07', NULL),
(1185, 'ios', NULL, '2021-12-13 14:50:03', NULL),
(1186, 'ios', NULL, '2021-12-13 14:50:14', NULL),
(1187, 'ios', NULL, '2021-12-13 14:51:16', NULL),
(1188, 'ios', NULL, '2021-12-13 14:51:27', NULL),
(1189, 'ios', NULL, '2021-12-13 14:51:45', NULL),
(1190, 'ios', NULL, '2021-12-13 14:52:22', NULL),
(1191, 'ios', NULL, '2021-12-13 14:54:44', NULL),
(1192, 'ios', NULL, '2021-12-13 15:01:51', NULL),
(1193, 'ios', NULL, '2021-12-13 17:07:59', NULL),
(1194, 'ios', NULL, '2021-12-13 17:22:58', NULL),
(1195, 'ios', NULL, '2021-12-13 17:35:35', NULL),
(1196, 'ios', NULL, '2021-12-13 17:47:59', NULL),
(1197, 'ios', NULL, '2021-12-13 17:48:12', NULL),
(1198, 'ios', NULL, '2021-12-13 17:55:18', NULL),
(1199, 'ios', NULL, '2021-12-13 18:04:47', NULL),
(1200, 'ios', NULL, '2021-12-13 18:07:19', NULL),
(1201, 'ios', NULL, '2021-12-13 18:08:26', NULL),
(1202, 'ios', NULL, '2021-12-13 18:08:32', NULL),
(1203, 'ios', NULL, '2021-12-13 18:16:27', NULL),
(1204, 'ios', NULL, '2021-12-13 19:13:18', NULL),
(1205, 'ios', NULL, '2021-12-13 21:07:05', NULL),
(1206, 'ios', NULL, '2021-12-13 21:08:05', NULL),
(1207, 'ios', NULL, '2021-12-13 21:08:45', NULL),
(1208, 'ios', NULL, '2021-12-13 21:11:06', NULL),
(1209, 'ios', NULL, '2021-12-13 21:44:19', NULL),
(1210, 'ios', NULL, '2021-12-14 12:58:09', NULL),
(1211, 'ios', NULL, '2021-12-14 12:58:15', NULL),
(1212, 'ios', NULL, '2021-12-14 12:58:24', NULL),
(1213, 'ios', NULL, '2021-12-14 12:58:31', NULL),
(1214, 'ios', NULL, '2021-12-14 12:58:39', NULL),
(1215, 'ios', NULL, '2021-12-14 14:36:48', NULL),
(1216, 'ios', NULL, '2021-12-14 14:36:59', NULL),
(1217, 'ios', NULL, '2021-12-14 14:37:59', NULL),
(1218, 'ios', NULL, '2021-12-14 14:38:07', NULL),
(1219, 'ios', NULL, '2021-12-14 14:38:19', NULL),
(1220, 'ios', NULL, '2021-12-14 14:39:09', NULL),
(1221, 'ios', NULL, '2021-12-14 14:40:00', NULL),
(1222, 'ios', NULL, '2021-12-14 14:40:30', NULL),
(1223, 'ios', NULL, '2021-12-14 14:40:42', NULL),
(1224, 'ios', NULL, '2021-12-14 14:45:49', NULL),
(1225, 'ios', NULL, '2021-12-14 14:49:00', NULL),
(1226, 'ios', NULL, '2021-12-14 14:49:34', NULL),
(1227, 'ios', NULL, '2021-12-14 14:49:40', NULL),
(1228, 'ios', NULL, '2021-12-15 13:50:31', NULL),
(1229, 'ios', NULL, '2021-12-15 13:51:55', NULL),
(1230, 'ios', NULL, '2021-12-16 01:23:13', NULL),
(1231, 'ios', NULL, '2021-12-16 07:26:38', NULL),
(1232, 'ios', NULL, '2021-12-16 07:27:58', NULL),
(1233, 'ios', NULL, '2021-12-16 07:28:48', NULL),
(1234, 'ios', NULL, '2021-12-16 07:29:38', NULL),
(1235, 'ios', NULL, '2021-12-16 13:18:11', NULL),
(1236, 'ios', NULL, '2021-12-16 13:18:38', NULL),
(1237, 'ios', NULL, '2021-12-16 13:18:46', NULL),
(1238, 'ios', NULL, '2021-12-16 13:19:12', NULL),
(1239, 'ios', NULL, '2021-12-16 13:19:27', NULL),
(1240, 'ios', NULL, '2021-12-16 13:19:44', NULL),
(1241, 'android', NULL, '2021-12-17 02:49:08', NULL),
(1242, 'ios', NULL, '2021-12-17 11:50:37', NULL),
(1243, 'android', NULL, '2021-12-18 20:59:10', NULL),
(1244, 'android', NULL, '2021-12-18 21:01:05', NULL),
(1245, 'android', NULL, '2021-12-18 21:04:35', NULL),
(1246, 'android', NULL, '2021-12-18 21:18:34', NULL),
(1247, 'android', NULL, '2021-12-18 21:24:44', NULL),
(1248, 'android', NULL, '2021-12-18 21:24:52', NULL),
(1249, 'android', NULL, '2021-12-18 21:24:54', NULL),
(1250, 'android', NULL, '2021-12-18 21:24:56', NULL),
(1251, 'ios', NULL, '2021-12-19 10:34:51', NULL),
(1252, 'ios', NULL, '2021-12-19 10:37:41', NULL),
(1253, 'ios', NULL, '2021-12-19 10:40:42', NULL),
(1254, 'ios', NULL, '2021-12-19 11:14:19', NULL),
(1255, 'ios', NULL, '2021-12-19 11:15:23', NULL),
(1256, 'ios', NULL, '2021-12-19 11:15:31', NULL),
(1257, 'ios', NULL, '2021-12-19 11:15:41', NULL),
(1258, 'ios', NULL, '2021-12-19 13:17:31', NULL),
(1259, 'ios', NULL, '2021-12-19 13:31:17', NULL),
(1260, 'ios', NULL, '2021-12-19 13:31:24', NULL),
(1261, 'ios', NULL, '2021-12-19 13:31:55', NULL),
(1262, 'ios', NULL, '2021-12-19 13:34:37', NULL),
(1263, 'ios', NULL, '2021-12-20 12:17:06', NULL),
(1264, 'ios', NULL, '2021-12-20 12:17:21', NULL),
(1265, 'ios', NULL, '2021-12-20 12:18:13', NULL),
(1266, 'ios', NULL, '2021-12-20 12:18:44', NULL),
(1267, 'ios', NULL, '2021-12-20 12:19:15', NULL),
(1268, 'android', NULL, '2021-12-21 13:20:02', NULL),
(1269, 'ios', NULL, '2021-12-22 11:13:23', NULL),
(1270, 'ios', NULL, '2021-12-22 11:14:24', NULL),
(1271, 'ios', NULL, '2021-12-22 11:14:51', NULL),
(1272, 'ios', NULL, '2021-12-22 11:15:39', NULL),
(1273, 'ios', NULL, '2021-12-22 11:21:40', NULL),
(1274, 'ios', NULL, '2021-12-22 11:21:54', NULL),
(1275, 'ios', NULL, '2021-12-22 11:23:30', NULL),
(1276, 'ios', NULL, '2021-12-22 11:30:39', NULL),
(1277, 'ios', NULL, '2021-12-22 11:34:15', NULL),
(1278, 'ios', NULL, '2021-12-22 11:47:05', NULL),
(1279, 'ios', NULL, '2021-12-22 11:50:09', NULL),
(1280, 'ios', NULL, '2021-12-22 12:30:55', NULL),
(1281, 'ios', NULL, '2021-12-22 12:31:12', NULL),
(1282, 'ios', NULL, '2021-12-22 12:32:47', NULL),
(1283, 'ios', NULL, '2021-12-22 13:43:39', NULL),
(1284, 'ios', NULL, '2021-12-22 13:43:54', NULL),
(1285, 'ios', NULL, '2021-12-22 13:44:01', NULL),
(1286, 'ios', NULL, '2021-12-22 16:09:40', NULL),
(1287, 'ios', NULL, '2021-12-22 16:16:51', NULL),
(1288, 'ios', NULL, '2021-12-22 16:39:28', NULL),
(1289, 'ios', NULL, '2021-12-22 16:39:50', NULL),
(1290, 'ios', NULL, '2021-12-22 16:39:55', NULL),
(1291, 'ios', NULL, '2021-12-22 17:24:52', NULL),
(1292, 'ios', NULL, '2021-12-22 17:25:46', NULL),
(1293, 'ios', NULL, '2021-12-22 23:32:33', NULL),
(1294, 'ios', NULL, '2021-12-22 23:33:21', NULL),
(1295, 'ios', NULL, '2021-12-22 23:33:51', NULL),
(1296, 'ios', NULL, '2021-12-22 23:38:03', NULL),
(1297, 'ios', NULL, '2021-12-22 23:40:18', NULL),
(1298, 'android', NULL, '2021-12-23 00:49:17', NULL),
(1299, 'android', NULL, '2021-12-23 00:49:38', NULL),
(1300, 'android', NULL, '2021-12-23 00:49:46', NULL),
(1301, 'android', NULL, '2021-12-23 00:49:51', NULL),
(1302, 'android', NULL, '2021-12-23 00:49:57', NULL),
(1303, 'android', NULL, '2021-12-23 00:50:03', NULL),
(1304, 'android', NULL, '2021-12-23 00:51:33', NULL),
(1305, 'android', NULL, '2021-12-23 00:52:19', NULL),
(1306, 'android', NULL, '2021-12-23 00:52:52', NULL),
(1307, 'ios', NULL, '2021-12-23 04:09:32', NULL),
(1308, 'ios', NULL, '2021-12-23 11:09:52', NULL),
(1309, 'android', NULL, '2021-12-23 13:09:44', NULL),
(1310, 'android', NULL, '2021-12-23 13:10:17', NULL),
(1311, 'ios', NULL, '2021-12-23 13:10:52', NULL),
(1312, 'android', NULL, '2021-12-23 13:13:00', NULL),
(1313, 'ios', NULL, '2021-12-23 13:15:31', NULL),
(1314, 'ios', NULL, '2021-12-23 13:17:00', NULL),
(1315, 'ios', NULL, '2021-12-23 13:19:04', NULL),
(1316, 'ios', NULL, '2021-12-23 13:21:42', NULL),
(1317, 'ios', NULL, '2021-12-23 13:21:47', NULL),
(1318, 'ios', NULL, '2021-12-23 13:37:39', NULL),
(1319, 'ios', NULL, '2021-12-23 17:24:55', NULL),
(1320, 'ios', NULL, '2021-12-23 17:27:31', NULL),
(1321, 'ios', NULL, '2021-12-23 17:31:52', NULL),
(1322, 'ios', NULL, '2021-12-24 08:11:04', NULL),
(1323, 'ios', NULL, '2021-12-24 09:11:12', NULL),
(1324, 'ios', NULL, '2021-12-24 09:11:37', NULL),
(1325, 'ios', NULL, '2021-12-25 13:32:10', NULL),
(1326, 'ios', NULL, '2021-12-25 13:33:10', NULL),
(1327, 'android', NULL, '2021-12-25 14:23:19', NULL),
(1328, 'ios', NULL, '2021-12-25 15:57:39', NULL),
(1329, 'ios', NULL, '2021-12-26 13:35:01', NULL),
(1330, 'android', NULL, '2021-12-26 13:47:55', NULL),
(1331, 'android', NULL, '2021-12-26 13:48:11', NULL),
(1332, 'android', NULL, '2021-12-26 13:51:26', NULL),
(1333, 'ios', NULL, '2021-12-26 13:52:19', NULL),
(1334, 'ios', NULL, '2021-12-26 13:53:19', NULL),
(1335, 'ios', NULL, '2021-12-26 13:54:39', NULL),
(1336, 'android', NULL, '2021-12-26 13:58:07', NULL),
(1337, 'android', NULL, '2021-12-26 14:00:57', NULL),
(1338, 'ios', NULL, '2021-12-26 14:01:47', NULL),
(1339, 'android', NULL, '2021-12-26 14:05:50', NULL),
(1340, 'android', NULL, '2021-12-26 14:06:17', NULL),
(1341, 'ios', NULL, '2021-12-26 14:10:34', NULL),
(1342, 'ios', NULL, '2021-12-26 14:14:23', NULL),
(1343, 'ios', NULL, '2021-12-26 14:14:45', NULL),
(1344, 'ios', NULL, '2021-12-26 14:16:47', NULL),
(1345, 'ios', NULL, '2021-12-26 14:19:09', NULL),
(1346, 'ios', NULL, '2021-12-26 14:19:38', NULL),
(1347, 'ios', NULL, '2021-12-26 14:22:40', NULL),
(1348, 'ios', NULL, '2021-12-26 14:45:52', NULL),
(1349, 'ios', NULL, '2021-12-27 05:39:58', NULL),
(1350, 'ios', NULL, '2021-12-27 19:20:34', NULL),
(1351, 'ios', NULL, '2021-12-27 19:22:37', NULL),
(1352, 'ios', NULL, '2021-12-27 19:22:45', NULL),
(1353, 'ios', NULL, '2021-12-27 19:22:52', NULL),
(1354, 'android', NULL, '2021-12-27 20:31:36', NULL),
(1355, 'ios', NULL, '2021-12-28 00:20:47', NULL),
(1356, 'ios', NULL, '2021-12-28 00:21:34', NULL),
(1357, 'android', NULL, '2021-12-28 00:24:00', NULL),
(1358, 'android', NULL, '2021-12-28 13:59:51', NULL),
(1359, 'android', NULL, '2021-12-28 14:02:23', NULL),
(1360, 'android', NULL, '2021-12-28 14:02:29', NULL),
(1361, 'android', NULL, '2021-12-28 14:02:54', NULL),
(1362, 'android', NULL, '2021-12-28 14:05:33', NULL),
(1363, 'android', NULL, '2021-12-28 14:07:54', NULL),
(1364, 'ios', NULL, '2021-12-28 14:08:09', NULL),
(1365, 'android', NULL, '2021-12-28 14:08:14', NULL),
(1366, 'android', NULL, '2021-12-28 14:11:02', NULL),
(1367, 'android', NULL, '2021-12-28 14:11:36', NULL),
(1368, 'android', NULL, '2021-12-28 14:13:00', NULL),
(1369, 'android', NULL, '2021-12-28 14:16:35', NULL),
(1370, 'android', NULL, '2021-12-28 14:18:24', NULL),
(1371, 'ios', NULL, '2021-12-28 14:21:29', NULL),
(1372, 'android', NULL, '2021-12-28 14:32:23', NULL),
(1373, 'android', NULL, '2021-12-28 14:32:31', NULL),
(1374, 'android', NULL, '2021-12-28 14:33:16', NULL),
(1375, 'ios', NULL, '2021-12-29 11:09:24', NULL),
(1376, 'android', NULL, '2021-12-29 13:04:08', NULL),
(1377, 'android', NULL, '2021-12-29 13:04:32', NULL),
(1378, 'android', NULL, '2021-12-29 13:06:44', NULL),
(1379, 'android', NULL, '2021-12-29 13:06:54', NULL),
(1380, 'android', NULL, '2021-12-29 13:07:16', NULL),
(1381, 'android', NULL, '2021-12-29 13:07:23', NULL),
(1382, 'android', NULL, '2021-12-29 13:08:55', NULL),
(1383, 'android', NULL, '2021-12-29 13:11:41', NULL),
(1384, 'ios', NULL, '2021-12-29 18:34:36', NULL),
(1385, 'android', NULL, '2021-12-29 18:37:53', NULL),
(1386, 'android', NULL, '2021-12-29 18:39:26', NULL),
(1387, 'android', NULL, '2021-12-29 18:39:34', NULL),
(1388, 'android', NULL, '2021-12-29 18:39:37', NULL),
(1389, 'android', NULL, '2021-12-29 18:56:50', NULL),
(1390, 'android', NULL, '2021-12-29 18:57:34', NULL),
(1391, 'android', NULL, '2021-12-29 18:57:39', NULL),
(1392, 'android', NULL, '2021-12-29 18:58:25', NULL),
(1393, 'android', NULL, '2021-12-29 19:01:40', NULL),
(1394, 'android', NULL, '2021-12-29 19:03:34', NULL),
(1395, 'android', NULL, '2021-12-29 19:08:28', NULL),
(1396, 'android', NULL, '2021-12-29 19:08:31', NULL),
(1397, 'android', NULL, '2021-12-29 19:08:34', NULL),
(1398, 'android', NULL, '2021-12-29 19:12:05', NULL),
(1399, 'android', NULL, '2021-12-29 19:23:16', NULL),
(1400, 'android', NULL, '2021-12-29 19:28:41', NULL),
(1401, 'android', NULL, '2021-12-30 00:44:01', NULL),
(1402, 'ios', NULL, '2021-12-30 13:12:33', NULL),
(1403, 'ios', NULL, '2021-12-30 15:25:26', NULL),
(1404, 'ios', NULL, '2021-12-30 15:26:00', NULL),
(1405, 'ios', NULL, '2021-12-30 17:22:02', NULL),
(1406, 'android', NULL, '2021-12-30 17:23:51', NULL),
(1407, 'android', NULL, '2021-12-31 15:31:14', NULL),
(1408, 'android', NULL, '2022-01-01 09:34:25', NULL),
(1409, 'android', NULL, '2022-01-01 11:10:22', NULL),
(1410, 'android', NULL, '2022-01-01 11:11:04', NULL),
(1411, 'android', NULL, '2022-01-01 11:11:09', NULL),
(1412, 'android', NULL, '2022-01-01 11:11:29', NULL),
(1413, 'android', NULL, '2022-01-01 11:16:24', NULL),
(1414, 'android', NULL, '2022-01-01 12:27:58', NULL),
(1415, 'android', NULL, '2022-01-02 21:40:55', NULL),
(1416, 'android', NULL, '2022-01-02 21:42:31', NULL),
(1417, 'android', NULL, '2022-01-03 13:42:18', NULL),
(1418, 'android', NULL, '2022-01-03 13:42:53', NULL),
(1419, 'android', NULL, '2022-01-03 13:46:57', NULL),
(1420, 'android', NULL, '2022-01-03 13:47:15', NULL),
(1421, 'ios', NULL, '2022-01-03 14:53:45', NULL),
(1422, 'android', NULL, '2022-01-03 14:59:05', NULL),
(1423, 'android', NULL, '2022-01-03 14:59:21', NULL),
(1424, 'ios', NULL, '2022-01-03 15:35:22', NULL),
(1425, 'ios', NULL, '2022-01-03 15:35:45', NULL),
(1426, 'android', NULL, '2022-01-03 15:50:20', NULL),
(1427, 'android', NULL, '2022-01-03 15:50:39', NULL),
(1428, 'android', NULL, '2022-01-03 15:50:50', NULL),
(1429, 'android', NULL, '2022-01-03 15:50:56', NULL),
(1430, 'android', NULL, '2022-01-03 15:52:59', NULL),
(1431, 'android', NULL, '2022-01-03 15:53:28', NULL),
(1432, 'android', NULL, '2022-01-03 15:53:51', NULL),
(1433, 'android', NULL, '2022-01-03 21:26:27', NULL),
(1434, 'android', NULL, '2022-01-03 21:26:34', NULL),
(1435, 'android', NULL, '2022-01-04 03:53:42', NULL),
(1436, 'android', NULL, '2022-01-04 10:55:47', NULL),
(1437, 'android', NULL, '2022-01-04 11:24:12', NULL),
(1438, 'android', NULL, '2022-01-04 11:24:17', NULL),
(1439, 'android', NULL, '2022-01-04 11:24:37', NULL),
(1440, 'android', NULL, '2022-01-04 11:25:01', NULL),
(1441, 'android', NULL, '2022-01-04 11:28:36', NULL),
(1442, 'android', NULL, '2022-01-04 11:28:41', NULL),
(1443, 'android', NULL, '2022-01-04 11:29:04', NULL),
(1444, 'android', NULL, '2022-01-04 11:29:08', NULL),
(1445, 'android', NULL, '2022-01-04 11:29:21', NULL),
(1446, 'android', NULL, '2022-01-04 11:29:25', NULL),
(1447, 'android', NULL, '2022-01-04 11:33:32', NULL),
(1448, 'android', NULL, '2022-01-04 11:45:02', NULL),
(1449, 'android', NULL, '2022-01-04 11:45:09', NULL),
(1450, 'android', NULL, '2022-01-04 11:45:20', NULL),
(1451, 'android', NULL, '2022-01-04 11:54:42', NULL),
(1452, 'android', NULL, '2022-01-04 11:54:48', NULL),
(1453, 'android', NULL, '2022-01-04 11:54:57', NULL),
(1454, 'android', NULL, '2022-01-04 11:55:36', NULL),
(1455, 'android', NULL, '2022-01-04 11:55:40', NULL),
(1456, 'android', NULL, '2022-01-04 11:56:19', NULL),
(1457, 'android', NULL, '2022-01-04 11:56:32', NULL),
(1458, 'android', NULL, '2022-01-04 11:58:10', NULL),
(1459, 'android', NULL, '2022-01-04 11:58:54', NULL),
(1460, 'android', NULL, '2022-01-04 11:59:10', NULL),
(1461, 'android', NULL, '2022-01-04 12:02:04', NULL),
(1462, 'android', NULL, '2022-01-04 12:02:53', NULL),
(1463, 'android', NULL, '2022-01-04 12:02:59', NULL),
(1464, 'android', NULL, '2022-01-04 15:47:38', NULL),
(1465, 'android', NULL, '2022-01-04 16:09:17', NULL),
(1466, 'android', NULL, '2022-01-04 16:09:25', NULL),
(1467, 'android', NULL, '2022-01-04 16:11:11', NULL),
(1468, 'android', NULL, '2022-01-04 16:12:40', NULL),
(1469, 'android', NULL, '2022-01-04 16:12:44', NULL),
(1470, 'android', NULL, '2022-01-04 16:13:27', NULL),
(1471, 'android', NULL, '2022-01-04 16:13:34', NULL),
(1472, 'android', NULL, '2022-01-04 16:15:18', NULL),
(1473, 'android', NULL, '2022-01-04 16:15:34', NULL),
(1474, 'android', NULL, '2022-01-04 16:15:39', NULL),
(1475, 'android', NULL, '2022-01-04 16:15:52', NULL),
(1476, 'android', NULL, '2022-01-04 16:19:54', NULL),
(1477, 'android', NULL, '2022-01-04 16:20:07', NULL),
(1478, 'android', NULL, '2022-01-04 16:20:19', NULL),
(1479, 'android', NULL, '2022-01-04 16:20:27', NULL),
(1480, 'android', NULL, '2022-01-04 16:20:41', NULL),
(1481, 'android', NULL, '2022-01-04 16:20:51', NULL),
(1482, 'android', NULL, '2022-01-04 16:30:32', NULL),
(1483, 'android', NULL, '2022-01-04 16:31:15', NULL),
(1484, 'android', NULL, '2022-01-04 16:36:38', NULL),
(1485, 'android', NULL, '2022-01-04 16:36:49', NULL),
(1486, 'android', NULL, '2022-01-04 16:36:57', NULL),
(1487, 'android', NULL, '2022-01-04 16:37:01', NULL),
(1488, 'android', NULL, '2022-01-04 16:37:06', NULL),
(1489, 'android', NULL, '2022-01-04 16:40:48', NULL),
(1490, 'android', NULL, '2022-01-04 16:40:59', NULL),
(1491, 'android', NULL, '2022-01-04 16:43:32', NULL),
(1492, 'android', NULL, '2022-01-04 16:43:39', NULL),
(1493, 'android', NULL, '2022-01-04 16:45:50', NULL),
(1494, 'android', NULL, '2022-01-04 16:46:01', NULL),
(1495, 'android', NULL, '2022-01-04 16:46:53', NULL),
(1496, 'android', NULL, '2022-01-04 16:47:01', NULL),
(1497, 'android', NULL, '2022-01-04 16:47:48', NULL),
(1498, 'android', NULL, '2022-01-04 16:48:03', NULL),
(1499, 'android', NULL, '2022-01-04 16:50:16', NULL),
(1500, 'android', NULL, '2022-01-04 16:50:38', NULL),
(1501, 'android', NULL, '2022-01-04 16:50:42', NULL),
(1502, 'android', NULL, '2022-01-04 16:50:53', NULL),
(1503, 'android', NULL, '2022-01-04 16:56:50', NULL),
(1504, 'android', NULL, '2022-01-04 16:57:02', NULL),
(1505, 'android', NULL, '2022-01-04 17:11:32', NULL),
(1506, 'android', NULL, '2022-01-04 17:34:09', NULL),
(1507, 'android', NULL, '2022-01-04 17:46:09', NULL),
(1508, 'android', NULL, '2022-01-04 17:46:15', NULL),
(1509, 'android', NULL, '2022-01-04 17:53:47', NULL),
(1510, 'android', NULL, '2022-01-04 17:54:15', NULL),
(1511, 'android', NULL, '2022-01-04 18:03:23', NULL),
(1512, 'android', NULL, '2022-01-04 18:03:48', NULL),
(1513, 'android', NULL, '2022-01-04 18:03:52', NULL),
(1514, 'android', NULL, '2022-01-04 18:04:50', NULL),
(1515, 'android', NULL, '2022-01-04 18:05:46', NULL),
(1516, 'android', NULL, '2022-01-04 20:58:34', NULL),
(1517, 'android', NULL, '2022-01-04 21:02:00', NULL),
(1518, 'android', NULL, '2022-01-04 21:02:08', NULL),
(1519, 'android', NULL, '2022-01-04 21:02:37', NULL),
(1520, 'android', NULL, '2022-01-04 21:03:34', NULL),
(1521, 'android', NULL, '2022-01-04 21:03:36', NULL),
(1522, 'android', NULL, '2022-01-04 21:03:39', NULL),
(1523, 'android', NULL, '2022-01-04 22:17:26', NULL),
(1524, 'android', NULL, '2022-01-04 22:38:21', NULL),
(1525, 'android', NULL, '2022-01-04 22:38:49', NULL),
(1526, 'android', NULL, '2022-01-04 22:38:57', NULL),
(1527, 'android', NULL, '2022-01-04 22:39:01', NULL),
(1528, 'android', NULL, '2022-01-04 22:40:46', NULL),
(1529, 'android', NULL, '2022-01-04 22:41:22', NULL),
(1530, 'android', NULL, '2022-01-04 22:41:39', NULL),
(1531, 'android', NULL, '2022-01-04 22:42:20', NULL),
(1532, 'android', NULL, '2022-01-04 22:43:03', NULL),
(1533, 'android', NULL, '2022-01-04 22:43:11', NULL),
(1534, 'android', NULL, '2022-01-04 22:44:15', NULL),
(1535, 'android', NULL, '2022-01-04 22:44:25', NULL),
(1536, 'android', NULL, '2022-01-04 22:46:04', NULL),
(1537, 'android', NULL, '2022-01-04 22:46:10', NULL),
(1538, 'android', NULL, '2022-01-04 22:46:15', NULL),
(1539, 'android', NULL, '2022-01-04 22:46:19', NULL),
(1540, 'android', NULL, '2022-01-04 22:46:44', NULL),
(1541, 'android', NULL, '2022-01-04 22:46:49', NULL),
(1542, 'android', NULL, '2022-01-04 22:47:38', NULL),
(1543, 'android', NULL, '2022-01-04 22:47:50', NULL),
(1544, 'android', NULL, '2022-01-04 22:55:17', NULL),
(1545, 'android', NULL, '2022-01-04 22:55:58', NULL),
(1546, 'android', NULL, '2022-01-04 22:56:32', NULL),
(1547, 'android', NULL, '2022-01-04 22:57:44', NULL),
(1548, 'android', NULL, '2022-01-04 23:00:19', NULL),
(1549, 'ios', NULL, '2022-01-05 15:41:43', NULL),
(1550, 'ios', NULL, '2022-01-05 15:42:44', NULL),
(1551, 'ios', NULL, '2022-01-05 15:51:17', NULL),
(1552, 'ios', NULL, '2022-01-05 16:53:12', NULL),
(1553, 'android', NULL, '2022-01-05 18:47:21', NULL),
(1554, 'ios', NULL, '2022-01-05 23:05:42', NULL),
(1555, 'ios', NULL, '2022-01-06 13:47:02', NULL),
(1556, 'android', NULL, '2022-01-06 13:49:58', NULL),
(1557, 'android', NULL, '2022-01-06 13:55:51', NULL),
(1558, 'android', NULL, '2022-01-06 13:56:06', NULL),
(1559, 'android', NULL, '2022-01-06 14:02:43', NULL),
(1560, 'android', NULL, '2022-01-06 14:03:05', NULL),
(1561, 'android', NULL, '2022-01-06 14:03:35', NULL),
(1562, 'android', NULL, '2022-01-06 14:06:26', NULL),
(1563, 'android', NULL, '2022-01-06 14:14:30', NULL),
(1564, 'ios', NULL, '2022-01-09 13:52:08', NULL),
(1565, 'android', NULL, '2022-01-09 14:54:05', NULL),
(1566, 'ios', NULL, '2022-01-09 16:19:07', NULL),
(1567, 'android', NULL, '2022-01-09 18:09:31', NULL),
(1568, 'android', NULL, '2022-01-09 21:23:41', NULL),
(1569, 'ios', NULL, '2022-01-11 14:50:10', NULL),
(1570, 'ios', NULL, '2022-01-11 14:50:18', NULL),
(1571, 'ios', NULL, '2022-01-11 14:50:52', NULL),
(1572, 'ios', NULL, '2022-01-11 14:51:07', NULL),
(1573, 'ios', NULL, '2022-01-11 14:51:16', NULL),
(1574, 'ios', NULL, '2022-01-11 14:54:20', NULL),
(1575, 'ios', NULL, '2022-01-13 15:53:10', NULL),
(1576, 'ios', NULL, '2022-01-13 15:56:02', NULL),
(1577, 'ios', NULL, '2022-01-13 15:56:48', NULL),
(1578, 'ios', NULL, '2022-01-13 16:14:08', NULL),
(1579, 'ios', NULL, '2022-01-13 16:14:12', NULL),
(1580, 'ios', NULL, '2022-01-13 16:14:26', NULL),
(1581, 'ios', NULL, '2022-01-13 16:14:28', NULL),
(1582, 'android', NULL, '2022-01-13 18:46:47', NULL),
(1583, 'android', NULL, '2022-01-13 18:47:41', NULL),
(1584, 'android', NULL, '2022-01-13 18:48:21', NULL),
(1585, 'android', NULL, '2022-01-13 19:03:55', NULL),
(1586, 'android', NULL, '2022-01-13 19:04:21', NULL),
(1587, 'android', NULL, '2022-01-13 19:04:47', NULL),
(1588, 'android', NULL, '2022-01-13 19:05:22', NULL),
(1589, 'android', NULL, '2022-01-13 19:05:41', NULL),
(1590, 'android', NULL, '2022-01-13 21:28:09', NULL),
(1591, 'android', NULL, '2022-01-13 21:28:55', NULL),
(1592, 'android', NULL, '2022-01-13 21:29:24', NULL),
(1593, 'android', NULL, '2022-01-13 21:29:29', NULL),
(1594, 'android', NULL, '2022-01-13 21:33:07', NULL),
(1595, 'android', NULL, '2022-01-13 21:33:42', NULL),
(1596, 'android', NULL, '2022-01-14 02:59:46', NULL),
(1597, 'ios', NULL, '2022-01-14 03:22:16', NULL),
(1598, 'android', NULL, '2022-01-14 07:51:05', NULL),
(1599, 'android', NULL, '2022-01-14 07:51:25', NULL),
(1600, 'android', NULL, '2022-01-14 13:27:48', NULL),
(1601, 'android', NULL, '2022-01-14 13:34:05', NULL),
(1602, 'android', NULL, '2022-01-14 13:34:44', NULL),
(1603, 'android', NULL, '2022-01-14 13:39:01', NULL),
(1604, 'android', NULL, '2022-01-14 14:23:59', NULL),
(1605, 'android', NULL, '2022-01-14 14:29:12', NULL),
(1606, 'android', NULL, '2022-01-14 14:57:07', NULL),
(1607, 'android', NULL, '2022-01-14 15:04:13', NULL),
(1608, 'android', NULL, '2022-01-14 15:05:02', NULL),
(1609, 'android', NULL, '2022-01-14 15:39:12', NULL),
(1610, 'android', NULL, '2022-01-14 15:40:43', NULL),
(1611, 'android', NULL, '2022-01-14 19:01:07', NULL),
(1612, 'android', NULL, '2022-01-14 21:13:44', NULL),
(1613, 'android', NULL, '2022-01-14 21:16:06', NULL),
(1614, 'android', NULL, '2022-01-14 21:35:44', NULL),
(1615, 'android', NULL, '2022-01-14 21:49:58', NULL),
(1616, 'android', NULL, '2022-01-14 21:50:07', NULL),
(1617, 'android', NULL, '2022-01-14 21:51:33', NULL),
(1618, 'android', NULL, '2022-01-14 21:51:39', NULL),
(1619, 'android', NULL, '2022-01-14 21:54:59', NULL),
(1620, 'android', NULL, '2022-01-14 21:55:03', NULL),
(1621, 'android', NULL, '2022-01-14 21:56:07', NULL),
(1622, 'android', NULL, '2022-01-14 22:02:19', NULL),
(1623, 'android', NULL, '2022-01-14 22:02:24', NULL),
(1624, 'android', NULL, '2022-01-14 22:03:57', NULL),
(1625, 'android', NULL, '2022-01-15 13:48:04', NULL),
(1626, 'android', NULL, '2022-01-15 13:49:30', NULL),
(1627, 'android', NULL, '2022-01-15 14:19:58', NULL),
(1628, 'android', NULL, '2022-01-15 19:15:35', NULL),
(1629, 'android', NULL, '2022-01-15 19:18:13', NULL),
(1630, 'android', NULL, '2022-01-15 19:23:08', NULL),
(1631, 'android', NULL, '2022-01-15 19:24:30', NULL),
(1632, 'android', NULL, '2022-01-15 19:31:15', NULL),
(1633, 'android', NULL, '2022-01-15 20:23:17', NULL),
(1634, 'android', NULL, '2022-01-15 20:28:57', NULL),
(1635, 'ios', NULL, '2022-01-16 14:32:57', NULL),
(1636, 'ios', NULL, '2022-01-16 14:33:05', NULL),
(1637, 'ios', NULL, '2022-01-16 14:34:33', NULL),
(1638, 'ios', NULL, '2022-01-16 23:51:41', NULL),
(1639, 'ios', NULL, '2022-01-16 23:53:57', NULL),
(1640, 'ios', NULL, '2022-01-16 23:56:46', NULL),
(1641, 'ios', NULL, '2022-01-16 23:56:58', NULL),
(1642, 'ios', NULL, '2022-01-16 23:57:01', NULL),
(1643, 'ios', NULL, '2022-01-17 06:19:27', NULL),
(1644, 'ios', NULL, '2022-01-17 06:19:47', NULL),
(1645, 'ios', NULL, '2022-01-17 17:11:50', NULL),
(1646, 'ios', NULL, '2022-01-17 17:14:28', NULL),
(1647, 'ios', NULL, '2022-01-17 17:15:46', NULL),
(1648, 'ios', NULL, '2022-01-17 17:26:27', NULL),
(1649, 'ios', NULL, '2022-01-17 17:26:38', NULL),
(1650, 'ios', NULL, '2022-01-17 17:27:21', NULL),
(1651, 'ios', NULL, '2022-01-17 17:27:21', NULL),
(1652, 'ios', NULL, '2022-01-17 17:27:29', NULL),
(1653, 'ios', NULL, '2022-01-17 17:27:49', NULL),
(1654, 'ios', NULL, '2022-01-17 17:27:58', NULL),
(1655, 'ios', NULL, '2022-01-17 17:28:08', NULL),
(1656, 'ios', NULL, '2022-01-17 17:28:12', NULL),
(1657, 'ios', NULL, '2022-01-17 17:28:17', NULL),
(1658, 'ios', NULL, '2022-01-17 17:28:23', NULL),
(1659, 'ios', NULL, '2022-01-17 17:28:59', NULL),
(1660, 'ios', NULL, '2022-01-17 17:29:14', NULL),
(1661, 'ios', NULL, '2022-01-17 17:29:21', NULL),
(1662, 'ios', NULL, '2022-01-17 17:30:43', NULL),
(1663, 'ios', NULL, '2022-01-17 17:31:46', NULL),
(1664, 'ios', NULL, '2022-01-17 18:16:00', NULL),
(1665, 'ios', NULL, '2022-01-17 18:16:09', NULL),
(1666, 'ios', NULL, '2022-01-17 18:16:46', NULL),
(1667, 'ios', NULL, '2022-01-17 18:16:48', NULL),
(1668, 'ios', NULL, '2022-01-17 18:17:51', NULL),
(1669, 'ios', NULL, '2022-01-17 18:19:33', NULL),
(1670, 'ios', NULL, '2022-01-18 13:32:22', NULL),
(1671, 'ios', NULL, '2022-01-18 13:34:55', NULL),
(1672, 'ios', NULL, '2022-01-18 13:35:56', NULL),
(1673, 'ios', NULL, '2022-01-18 13:39:42', NULL),
(1674, 'android', NULL, '2022-01-18 14:00:01', NULL),
(1675, 'android', NULL, '2022-01-18 14:00:42', NULL),
(1676, 'android', NULL, '2022-01-20 21:10:48', NULL),
(1677, 'android', NULL, '2022-01-22 12:58:55', NULL),
(1678, 'android', NULL, '2022-01-23 08:40:06', NULL),
(1679, 'android', NULL, '2022-01-23 08:40:21', NULL),
(1680, 'android', NULL, '2022-01-23 08:41:08', NULL),
(1681, 'android', NULL, '2022-01-23 08:41:17', NULL),
(1682, 'android', NULL, '2022-01-23 08:41:38', NULL),
(1683, 'android', NULL, '2022-01-23 10:35:02', NULL),
(1684, 'android', NULL, '2022-01-23 10:53:27', NULL),
(1685, 'android', NULL, '2022-01-23 10:54:30', NULL),
(1686, 'android', NULL, '2022-01-23 10:56:36', NULL),
(1687, 'android', NULL, '2022-01-23 11:13:03', NULL),
(1688, 'android', NULL, '2022-01-23 11:31:07', NULL),
(1689, 'android', NULL, '2022-01-23 11:38:54', NULL),
(1690, 'android', NULL, '2022-01-23 11:43:44', NULL),
(1691, 'android', NULL, '2022-01-23 11:43:55', NULL),
(1692, 'android', NULL, '2022-01-23 11:56:16', NULL),
(1693, 'android', NULL, '2022-01-23 12:08:29', NULL),
(1694, 'android', NULL, '2022-01-23 12:12:31', NULL),
(1695, 'android', NULL, '2022-01-23 12:13:17', NULL),
(1696, 'android', NULL, '2022-01-25 22:27:53', NULL),
(1697, 'android', NULL, '2022-01-25 22:28:31', NULL),
(1698, 'android', NULL, '2022-01-25 22:29:40', NULL),
(1699, 'android', NULL, '2022-01-25 22:30:03', NULL),
(1700, 'android', NULL, '2022-01-26 08:21:51', NULL),
(1701, 'android', NULL, '2022-01-26 08:22:22', NULL),
(1702, 'android', NULL, '2022-01-26 08:53:41', NULL),
(1703, 'android', NULL, '2022-01-26 08:59:30', NULL),
(1704, 'android', NULL, '2022-01-26 09:00:35', NULL),
(1705, 'android', NULL, '2022-01-26 09:00:40', NULL),
(1706, 'android', NULL, '2022-01-26 09:01:22', NULL),
(1707, 'android', NULL, '2022-01-26 09:27:18', NULL),
(1708, 'android', NULL, '2022-01-26 09:28:30', NULL),
(1709, 'android', NULL, '2022-01-26 09:46:49', NULL),
(1710, 'android', NULL, '2022-01-26 09:46:59', NULL),
(1711, 'android', NULL, '2022-01-26 09:48:39', NULL),
(1712, 'android', NULL, '2022-01-26 09:53:57', NULL),
(1713, 'android', NULL, '2022-01-26 09:54:59', NULL),
(1714, 'android', NULL, '2022-01-26 10:01:43', NULL),
(1715, 'android', NULL, '2022-01-26 23:32:41', NULL),
(1716, 'android', NULL, '2022-01-26 23:33:08', NULL),
(1717, 'android', NULL, '2022-01-26 23:33:19', NULL),
(1718, 'android', NULL, '2022-01-26 23:33:22', NULL),
(1719, 'android', NULL, '2022-01-26 23:33:25', NULL),
(1720, 'android', NULL, '2022-01-26 23:35:46', NULL),
(1721, 'android', NULL, '2022-01-26 23:36:29', NULL),
(1722, 'android', NULL, '2022-01-27 13:16:17', NULL),
(1723, 'android', NULL, '2022-01-28 13:59:20', NULL),
(1724, 'android', NULL, '2022-01-28 13:59:32', NULL),
(1725, 'android', NULL, '2022-01-28 15:15:46', NULL),
(1726, 'android', NULL, '2022-01-31 13:35:53', NULL),
(1727, 'ios', NULL, '2022-01-31 13:37:24', NULL),
(1728, 'ios', NULL, '2022-01-31 13:37:34', NULL),
(1729, 'ios', NULL, '2022-01-31 13:49:02', NULL),
(1730, 'android', NULL, '2022-01-31 13:49:04', NULL),
(1731, 'ios', NULL, '2022-01-31 13:49:06', NULL),
(1732, 'ios', NULL, '2022-01-31 13:49:10', NULL),
(1733, 'ios', NULL, '2022-01-31 13:49:12', NULL),
(1734, 'ios', NULL, '2022-01-31 13:50:18', NULL),
(1735, 'android', NULL, '2022-01-31 13:50:22', NULL),
(1736, 'android', NULL, '2022-01-31 13:50:37', NULL),
(1737, 'android', NULL, '2022-01-31 13:50:52', NULL),
(1738, 'android', NULL, '2022-01-31 13:51:04', NULL),
(1739, 'android', NULL, '2022-01-31 13:51:14', NULL),
(1740, 'android', NULL, '2022-01-31 13:51:23', NULL),
(1741, 'android', NULL, '2022-01-31 13:51:31', NULL),
(1742, 'ios', NULL, '2022-01-31 13:54:27', NULL),
(1743, 'ios', NULL, '2022-01-31 13:54:59', NULL),
(1744, 'ios', NULL, '2022-01-31 13:55:10', NULL),
(1745, 'ios', NULL, '2022-01-31 13:55:37', NULL),
(1746, 'ios', NULL, '2022-01-31 13:55:39', NULL),
(1747, 'ios', NULL, '2022-01-31 13:57:17', NULL),
(1748, 'ios', NULL, '2022-01-31 13:57:43', NULL),
(1749, 'ios', NULL, '2022-01-31 14:00:51', NULL),
(1750, 'ios', NULL, '2022-01-31 14:02:23', NULL),
(1751, 'ios', NULL, '2022-01-31 14:02:54', NULL),
(1752, 'ios', NULL, '2022-01-31 14:26:30', NULL),
(1753, 'ios', NULL, '2022-01-31 14:26:45', NULL),
(1754, 'ios', NULL, '2022-01-31 14:26:50', NULL),
(1755, 'ios', NULL, '2022-01-31 14:26:58', NULL),
(1756, 'ios', NULL, '2022-01-31 14:27:04', NULL),
(1757, 'ios', NULL, '2022-01-31 14:27:15', NULL),
(1758, 'ios', NULL, '2022-01-31 14:27:37', NULL),
(1759, 'ios', NULL, '2022-01-31 14:28:02', NULL),
(1760, 'ios', NULL, '2022-01-31 14:28:55', NULL),
(1761, 'ios', NULL, '2022-01-31 14:29:36', NULL),
(1762, 'ios', NULL, '2022-01-31 14:32:46', NULL),
(1763, 'android', NULL, '2022-01-31 14:34:55', NULL),
(1764, 'ios', NULL, '2022-01-31 14:56:43', NULL),
(1765, 'ios', NULL, '2022-01-31 16:10:12', NULL),
(1766, 'ios', NULL, '2022-01-31 17:02:21', NULL),
(1767, 'android', NULL, '2022-01-31 19:25:37', NULL),
(1768, 'android', NULL, '2022-01-31 19:32:47', NULL),
(1769, 'android', NULL, '2022-01-31 19:33:24', NULL),
(1770, 'android', NULL, '2022-01-31 19:34:02', NULL),
(1771, 'ios', NULL, '2022-01-31 19:38:44', NULL),
(1772, 'ios', NULL, '2022-01-31 19:38:51', NULL),
(1773, 'ios', NULL, '2022-01-31 19:39:14', NULL),
(1774, 'ios', NULL, '2022-01-31 19:39:22', NULL),
(1775, 'ios', NULL, '2022-01-31 19:39:47', NULL),
(1776, 'ios', NULL, '2022-01-31 19:39:56', NULL),
(1777, 'ios', NULL, '2022-01-31 19:40:03', NULL),
(1778, 'ios', NULL, '2022-01-31 19:40:17', NULL),
(1779, 'ios', NULL, '2022-01-31 19:40:24', NULL),
(1780, 'ios', NULL, '2022-01-31 19:40:31', NULL),
(1781, 'ios', NULL, '2022-01-31 19:40:40', NULL),
(1782, 'android', NULL, '2022-01-31 19:40:49', NULL),
(1783, 'ios', NULL, '2022-01-31 19:40:53', NULL),
(1784, 'android', NULL, '2022-01-31 19:41:59', NULL),
(1785, 'ios', NULL, '2022-01-31 19:43:47', NULL),
(1786, 'ios', NULL, '2022-01-31 19:44:31', NULL),
(1787, 'ios', NULL, '2022-01-31 19:44:47', NULL),
(1788, 'ios', NULL, '2022-01-31 19:46:01', NULL),
(1789, 'ios', NULL, '2022-01-31 19:46:24', NULL),
(1790, 'ios', NULL, '2022-01-31 19:46:29', NULL),
(1791, 'android', NULL, '2022-01-31 19:50:30', NULL),
(1792, 'android', NULL, '2022-01-31 19:50:52', NULL),
(1793, 'android', NULL, '2022-01-31 19:52:00', NULL),
(1794, 'android', NULL, '2022-01-31 19:52:42', NULL),
(1795, 'android', NULL, '2022-01-31 19:56:20', NULL),
(1796, 'android', NULL, '2022-01-31 20:07:30', NULL),
(1797, 'android', NULL, '2022-01-31 20:07:40', NULL),
(1798, 'android', NULL, '2022-01-31 20:08:43', NULL),
(1799, 'android', NULL, '2022-01-31 20:27:20', NULL),
(1800, 'android', NULL, '2022-01-31 20:29:42', NULL),
(1801, 'android', NULL, '2022-01-31 20:30:06', NULL),
(1802, 'android', NULL, '2022-01-31 20:33:21', NULL),
(1803, 'android', NULL, '2022-01-31 20:53:40', NULL),
(1804, 'android', NULL, '2022-01-31 20:53:49', NULL),
(1805, 'android', NULL, '2022-01-31 20:59:10', NULL),
(1806, 'android', NULL, '2022-01-31 21:02:05', NULL),
(1807, 'android', NULL, '2022-01-31 21:02:08', NULL),
(1808, 'android', NULL, '2022-01-31 21:02:13', NULL),
(1809, 'android', NULL, '2022-01-31 21:02:19', NULL),
(1810, 'android', NULL, '2022-01-31 21:02:23', NULL),
(1811, 'android', NULL, '2022-01-31 21:02:30', NULL),
(1812, 'android', NULL, '2022-02-01 11:38:10', NULL),
(1813, 'android', NULL, '2022-02-01 11:44:52', NULL),
(1814, 'android', NULL, '2022-02-01 11:45:45', NULL),
(1815, 'android', NULL, '2022-02-01 11:46:01', NULL),
(1816, 'android', NULL, '2022-02-01 11:46:25', NULL),
(1817, 'android', NULL, '2022-02-01 11:46:30', NULL),
(1818, 'android', NULL, '2022-02-01 11:46:42', NULL),
(1819, 'android', NULL, '2022-02-01 11:46:58', NULL),
(1820, 'android', NULL, '2022-02-01 11:47:46', NULL),
(1821, 'android', NULL, '2022-02-01 12:17:56', NULL),
(1822, 'ios', NULL, '2022-02-01 14:11:33', NULL),
(1823, 'ios', NULL, '2022-02-01 14:11:56', NULL),
(1824, 'ios', NULL, '2022-02-01 14:12:10', NULL),
(1825, 'ios', NULL, '2022-02-01 14:12:15', NULL),
(1826, 'ios', NULL, '2022-02-01 14:12:36', NULL),
(1827, 'ios', NULL, '2022-02-01 14:14:38', NULL),
(1828, 'ios', NULL, '2022-02-01 14:15:10', NULL),
(1829, 'ios', NULL, '2022-02-01 14:16:51', NULL),
(1830, 'ios', NULL, '2022-02-01 14:18:30', NULL),
(1831, 'ios', NULL, '2022-02-01 14:19:22', NULL),
(1832, 'ios', NULL, '2022-02-01 14:19:28', NULL),
(1833, 'ios', NULL, '2022-02-01 14:21:20', NULL),
(1834, 'ios', NULL, '2022-02-01 14:21:24', NULL),
(1835, 'android', NULL, '2022-02-01 14:47:05', NULL),
(1836, 'android', NULL, '2022-02-01 15:27:43', NULL),
(1837, 'android', NULL, '2022-02-01 15:27:54', NULL),
(1838, 'android', NULL, '2022-02-01 15:34:51', NULL),
(1839, 'android', NULL, '2022-02-01 15:35:29', NULL),
(1840, 'android', NULL, '2022-02-01 15:37:20', NULL),
(1841, 'android', NULL, '2022-02-01 15:37:39', NULL),
(1842, 'android', NULL, '2022-02-01 15:38:48', NULL),
(1843, 'android', NULL, '2022-02-01 15:52:52', NULL),
(1844, 'android', NULL, '2022-02-01 19:13:05', NULL),
(1845, 'android', NULL, '2022-02-01 19:15:15', NULL),
(1846, 'android', NULL, '2022-02-01 19:15:36', NULL),
(1847, 'android', NULL, '2022-02-01 19:16:20', NULL),
(1848, 'android', NULL, '2022-02-01 19:18:00', NULL),
(1849, 'android', NULL, '2022-02-01 19:22:13', NULL),
(1850, 'android', NULL, '2022-02-01 19:32:35', NULL),
(1851, 'android', NULL, '2022-02-01 19:48:40', NULL),
(1852, 'android', NULL, '2022-02-01 19:50:25', NULL),
(1853, 'android', NULL, '2022-02-01 19:51:21', NULL),
(1854, 'android', NULL, '2022-02-01 19:52:17', NULL),
(1855, 'android', NULL, '2022-02-01 19:54:03', NULL),
(1856, 'android', NULL, '2022-02-01 20:07:50', NULL),
(1857, 'android', NULL, '2022-02-01 20:08:09', NULL),
(1858, 'android', NULL, '2022-02-01 20:08:15', NULL),
(1859, 'android', NULL, '2022-02-01 20:09:35', NULL),
(1860, 'android', NULL, '2022-02-01 20:09:52', NULL),
(1861, 'android', NULL, '2022-02-01 20:23:30', NULL),
(1862, 'android', NULL, '2022-02-01 20:24:00', NULL),
(1863, 'android', NULL, '2022-02-01 20:24:38', NULL),
(1864, 'android', NULL, '2022-02-01 21:47:16', NULL),
(1865, 'android', NULL, '2022-02-01 21:50:02', NULL),
(1866, 'android', NULL, '2022-02-01 21:50:08', NULL),
(1867, 'android', NULL, '2022-02-01 21:54:07', NULL),
(1868, 'android', NULL, '2022-02-01 21:54:33', NULL),
(1869, 'android', NULL, '2022-02-01 21:54:38', NULL),
(1870, 'android', NULL, '2022-02-01 21:55:10', NULL),
(1871, 'android', NULL, '2022-02-01 21:55:31', NULL),
(1872, 'android', NULL, '2022-02-01 21:55:37', NULL),
(1873, 'android', NULL, '2022-02-01 21:56:49', NULL),
(1874, 'android', NULL, '2022-02-02 14:46:00', NULL),
(1875, 'android', NULL, '2022-02-02 14:46:06', NULL),
(1876, 'android', NULL, '2022-02-02 20:17:15', NULL),
(1877, 'android', NULL, '2022-02-02 20:21:44', NULL),
(1878, 'android', NULL, '2022-02-02 20:21:51', NULL),
(1879, 'android', NULL, '2022-02-02 20:24:09', NULL),
(1880, 'android', NULL, '2022-02-02 20:24:11', NULL),
(1881, 'android', NULL, '2022-02-02 20:24:58', NULL),
(1882, 'android', NULL, '2022-02-02 20:30:58', NULL),
(1883, 'android', NULL, '2022-02-02 20:30:58', NULL),
(1884, 'android', NULL, '2022-02-02 20:31:02', NULL),
(1885, 'android', NULL, '2022-02-02 20:31:21', NULL),
(1886, 'android', NULL, '2022-02-02 20:31:28', NULL),
(1887, 'android', NULL, '2022-02-02 20:31:48', NULL),
(1888, 'android', NULL, '2022-02-02 20:32:09', NULL),
(1889, 'android', NULL, '2022-02-02 20:32:49', NULL),
(1890, 'android', NULL, '2022-02-02 20:33:16', NULL),
(1891, 'android', NULL, '2022-02-02 20:33:47', NULL),
(1892, 'android', NULL, '2022-02-02 20:34:04', NULL),
(1893, 'android', NULL, '2022-02-02 20:36:48', NULL),
(1894, 'android', NULL, '2022-02-02 20:38:01', NULL),
(1895, 'android', NULL, '2022-02-02 20:39:04', NULL),
(1896, 'android', NULL, '2022-02-02 20:39:29', NULL),
(1897, 'android', NULL, '2022-02-02 20:41:57', NULL),
(1898, 'android', NULL, '2022-02-02 20:41:57', NULL),
(1899, 'android', NULL, '2022-02-02 20:42:16', NULL),
(1900, 'android', NULL, '2022-02-02 20:45:02', NULL),
(1901, 'android', NULL, '2022-02-02 20:49:07', NULL),
(1902, 'android', NULL, '2022-02-02 20:50:26', NULL),
(1903, 'android', NULL, '2022-02-02 20:51:05', NULL),
(1904, 'android', NULL, '2022-02-02 20:51:28', NULL),
(1905, 'android', NULL, '2022-02-02 20:52:06', NULL),
(1906, 'android', NULL, '2022-02-02 20:53:36', NULL),
(1907, 'android', NULL, '2022-02-02 20:54:10', NULL),
(1908, 'android', NULL, '2022-02-02 20:55:45', NULL),
(1909, 'android', NULL, '2022-02-02 21:07:39', NULL),
(1910, 'android', NULL, '2022-02-02 21:07:57', NULL),
(1911, 'android', NULL, '2022-02-02 21:10:26', NULL),
(1912, 'android', NULL, '2022-02-02 21:11:05', NULL),
(1913, 'android', NULL, '2022-02-02 21:11:11', NULL),
(1914, 'android', NULL, '2022-02-02 21:11:19', NULL),
(1915, 'android', NULL, '2022-02-02 21:11:34', NULL),
(1916, 'android', NULL, '2022-02-03 13:30:02', NULL),
(1917, 'android', NULL, '2022-02-03 13:31:59', NULL),
(1918, 'android', NULL, '2022-02-03 13:32:06', NULL),
(1919, 'android', NULL, '2022-02-03 13:32:08', NULL),
(1920, 'android', NULL, '2022-02-03 13:32:54', NULL),
(1921, 'android', NULL, '2022-02-03 13:33:09', NULL),
(1922, 'android', NULL, '2022-02-03 13:33:27', NULL),
(1923, 'android', NULL, '2022-02-03 13:33:44', NULL),
(1924, 'android', NULL, '2022-02-03 13:39:50', NULL),
(1925, 'android', NULL, '2022-02-03 13:42:21', NULL),
(1926, 'android', NULL, '2022-02-03 13:42:27', NULL),
(1927, 'android', NULL, '2022-02-03 13:42:31', NULL),
(1928, 'android', NULL, '2022-02-03 15:23:06', NULL),
(1929, 'android', NULL, '2022-02-03 15:23:39', NULL),
(1930, 'android', NULL, '2022-02-03 15:23:46', NULL),
(1931, 'android', NULL, '2022-02-03 15:23:54', NULL),
(1932, 'android', NULL, '2022-02-03 22:00:48', NULL),
(1933, 'android', NULL, '2022-02-03 22:00:50', NULL),
(1934, 'android', NULL, '2022-02-03 22:00:51', NULL),
(1935, 'android', NULL, '2022-02-03 22:01:03', NULL),
(1936, 'android', NULL, '2022-02-03 22:02:13', NULL),
(1937, 'android', NULL, '2022-02-03 22:04:13', NULL),
(1938, 'android', NULL, '2022-02-03 22:04:29', NULL),
(1939, 'android', NULL, '2022-02-03 22:04:47', NULL),
(1940, 'android', NULL, '2022-02-03 22:06:04', NULL),
(1941, 'android', NULL, '2022-02-04 14:50:06', NULL),
(1942, 'android', NULL, '2022-02-04 15:48:03', NULL),
(1943, 'android', NULL, '2022-02-04 16:21:26', NULL),
(1944, 'android', NULL, '2022-02-04 16:21:56', NULL),
(1945, 'android', NULL, '2022-02-04 16:22:40', NULL),
(1946, 'android', NULL, '2022-02-04 18:18:45', NULL),
(1947, 'android', NULL, '2022-02-04 18:32:25', NULL),
(1948, 'android', NULL, '2022-02-04 18:34:15', NULL),
(1949, 'android', NULL, '2022-02-04 18:37:59', NULL),
(1950, 'android', NULL, '2022-02-04 18:40:36', NULL),
(1951, 'android', NULL, '2022-02-04 19:10:49', NULL),
(1952, 'android', NULL, '2022-02-04 19:11:08', NULL),
(1953, 'android', NULL, '2022-02-04 19:11:14', NULL),
(1954, 'android', NULL, '2022-02-04 19:38:48', NULL),
(1955, 'android', NULL, '2022-02-04 20:00:14', NULL),
(1956, 'android', NULL, '2022-02-04 20:05:25', NULL),
(1957, 'android', NULL, '2022-02-05 04:30:15', NULL),
(1958, 'android', NULL, '2022-02-05 04:31:48', NULL),
(1959, 'ios', NULL, '2022-02-05 04:32:27', NULL),
(1960, 'android', NULL, '2022-02-05 04:32:40', NULL),
(1961, 'android', NULL, '2022-02-05 04:32:56', NULL),
(1962, 'android', NULL, '2022-02-05 04:33:20', NULL),
(1963, 'ios', NULL, '2022-02-05 04:34:01', NULL),
(1964, 'android', NULL, '2022-02-05 04:34:05', NULL),
(1965, 'ios', NULL, '2022-02-05 04:34:15', NULL),
(1966, 'android', NULL, '2022-02-05 10:48:25', NULL),
(1967, 'android', NULL, '2022-02-05 10:53:05', NULL),
(1968, 'ios', NULL, '2022-02-05 14:31:07', NULL),
(1969, 'ios', NULL, '2022-02-05 14:32:35', NULL),
(1970, 'ios', NULL, '2022-02-05 14:32:44', NULL),
(1971, 'ios', NULL, '2022-02-05 14:32:48', NULL),
(1972, 'ios', NULL, '2022-02-05 14:32:58', NULL),
(1973, 'ios', NULL, '2022-02-05 14:33:25', NULL),
(1974, 'ios', NULL, '2022-02-05 14:33:28', NULL),
(1975, 'ios', NULL, '2022-02-05 14:33:37', NULL),
(1976, 'ios', NULL, '2022-02-05 14:34:04', NULL),
(1977, 'ios', NULL, '2022-02-05 14:34:29', NULL),
(1978, 'ios', NULL, '2022-02-05 14:34:51', NULL),
(1979, 'ios', NULL, '2022-02-05 14:36:21', NULL),
(1980, 'ios', NULL, '2022-02-05 14:40:06', NULL),
(1981, 'ios', NULL, '2022-02-05 14:40:32', NULL),
(1982, 'ios', NULL, '2022-02-05 14:43:27', NULL),
(1983, 'ios', NULL, '2022-02-05 14:43:49', NULL),
(1984, 'ios', NULL, '2022-02-05 14:44:13', NULL),
(1985, 'ios', NULL, '2022-02-05 14:44:18', NULL),
(1986, 'ios', NULL, '2022-02-05 14:44:26', NULL),
(1987, 'ios', NULL, '2022-02-05 14:45:13', NULL),
(1988, 'ios', NULL, '2022-02-05 14:45:18', NULL),
(1989, 'ios', NULL, '2022-02-05 14:45:31', NULL),
(1990, 'ios', NULL, '2022-02-05 14:45:34', NULL),
(1991, 'ios', NULL, '2022-02-05 14:45:43', NULL),
(1992, 'ios', NULL, '2022-02-05 14:46:39', NULL),
(1993, 'ios', NULL, '2022-02-05 15:08:25', NULL),
(1994, 'ios', NULL, '2022-02-05 15:09:18', NULL),
(1995, 'android', NULL, '2022-02-05 15:25:46', NULL),
(1996, 'android', NULL, '2022-02-05 15:30:03', NULL),
(1997, 'android', NULL, '2022-02-05 15:40:31', NULL),
(1998, 'ios', NULL, '2022-02-05 19:03:35', NULL),
(1999, 'ios', NULL, '2022-02-05 19:10:17', NULL),
(2000, 'ios', NULL, '2022-02-05 19:10:36', NULL),
(2001, 'ios', NULL, '2022-02-05 19:10:54', NULL),
(2002, 'ios', NULL, '2022-02-05 19:15:19', NULL),
(2003, 'ios', NULL, '2022-02-05 19:15:25', NULL),
(2004, 'ios', NULL, '2022-02-05 19:16:00', NULL);
INSERT INTO `visits` (`id`, `device_type`, `city_id`, `created_at`, `deleted_at`) VALUES
(2005, 'android', NULL, '2022-02-05 19:16:46', NULL),
(2006, 'ios', NULL, '2022-02-05 19:17:23', NULL),
(2007, 'ios', NULL, '2022-02-05 19:17:48', NULL),
(2008, 'ios', NULL, '2022-02-05 19:18:45', NULL),
(2009, 'ios', NULL, '2022-02-05 19:23:15', NULL),
(2010, 'ios', NULL, '2022-02-05 19:24:21', NULL),
(2011, 'ios', NULL, '2022-02-05 19:25:25', NULL),
(2012, 'android', NULL, '2022-02-06 15:17:19', NULL),
(2013, 'android', NULL, '2022-02-06 17:16:50', NULL),
(2014, 'android', NULL, '2022-02-06 17:17:28', NULL),
(2015, 'android', NULL, '2022-02-06 17:19:15', NULL),
(2016, 'android', NULL, '2022-02-06 17:19:40', NULL),
(2017, 'android', NULL, '2022-02-06 17:32:16', NULL),
(2018, 'android', NULL, '2022-02-06 17:36:26', NULL),
(2019, 'android', NULL, '2022-02-06 17:36:34', NULL),
(2020, 'android', NULL, '2022-02-06 17:37:06', NULL),
(2021, 'android', NULL, '2022-02-06 17:44:30', NULL),
(2022, 'android', NULL, '2022-02-06 17:44:38', NULL),
(2023, 'android', NULL, '2022-02-06 17:56:07', NULL),
(2024, 'ios', NULL, '2022-02-09 17:53:15', NULL),
(2025, 'ios', NULL, '2022-02-09 17:53:23', NULL),
(2026, 'android', NULL, '2022-02-09 22:00:37', NULL),
(2027, 'android', NULL, '2022-02-09 22:02:31', NULL),
(2028, 'android', NULL, '2022-02-09 22:08:35', NULL),
(2029, 'android', NULL, '2022-02-09 22:12:47', NULL),
(2030, 'android', NULL, '2022-02-09 22:13:50', NULL),
(2031, 'android', NULL, '2022-02-09 22:21:08', NULL),
(2032, 'android', NULL, '2022-02-09 22:24:38', NULL),
(2033, 'android', NULL, '2022-02-09 22:26:11', NULL),
(2034, 'android', NULL, '2022-02-09 22:38:18', NULL),
(2035, 'android', NULL, '2022-02-10 07:24:19', NULL),
(2036, 'android', NULL, '2022-02-10 07:25:33', NULL),
(2037, 'android', NULL, '2022-02-10 07:29:07', NULL),
(2038, 'android', NULL, '2022-02-10 07:29:36', NULL),
(2039, 'android', NULL, '2022-02-10 08:14:00', NULL),
(2040, 'android', NULL, '2022-02-10 08:20:20', NULL),
(2041, 'android', NULL, '2022-02-10 08:20:57', NULL),
(2042, 'android', NULL, '2022-02-10 08:21:20', NULL),
(2043, 'android', NULL, '2022-02-10 08:22:35', NULL),
(2044, 'android', NULL, '2022-02-10 08:41:28', NULL),
(2045, 'android', NULL, '2022-02-10 08:42:03', NULL),
(2046, 'android', NULL, '2022-02-10 08:42:12', NULL),
(2047, 'android', NULL, '2022-02-10 08:43:47', NULL),
(2048, 'android', NULL, '2022-02-10 08:44:12', NULL),
(2049, 'android', NULL, '2022-02-10 08:45:48', NULL),
(2050, 'android', NULL, '2022-02-10 08:46:14', NULL),
(2051, 'android', NULL, '2022-02-10 08:46:24', NULL),
(2052, 'android', NULL, '2022-02-10 08:48:40', NULL),
(2053, 'android', NULL, '2022-02-10 09:04:03', NULL),
(2054, 'android', NULL, '2022-02-10 09:04:25', NULL),
(2055, 'android', NULL, '2022-02-10 09:06:02', NULL),
(2056, 'android', NULL, '2022-02-10 09:14:23', NULL),
(2057, 'android', NULL, '2022-02-10 09:15:17', NULL),
(2058, 'android', NULL, '2022-02-10 09:17:49', NULL),
(2059, 'android', NULL, '2022-02-10 09:18:58', NULL),
(2060, 'android', NULL, '2022-02-10 11:17:44', NULL),
(2061, 'android', NULL, '2022-02-10 12:35:13', NULL),
(2062, 'android', NULL, '2022-02-10 12:36:39', NULL),
(2063, 'android', NULL, '2022-02-10 12:37:37', NULL),
(2064, 'android', NULL, '2022-02-10 12:40:21', NULL),
(2065, 'android', NULL, '2022-02-10 12:48:06', NULL),
(2066, 'android', NULL, '2022-02-10 12:49:55', NULL),
(2067, 'android', NULL, '2022-02-10 13:01:06', NULL),
(2068, 'android', NULL, '2022-02-10 13:03:09', NULL),
(2069, 'android', NULL, '2022-02-10 13:05:03', NULL),
(2070, 'android', NULL, '2022-02-10 13:07:48', NULL),
(2071, 'android', NULL, '2022-02-10 13:08:28', NULL),
(2072, 'ios', NULL, '2022-02-10 13:11:54', NULL),
(2073, 'android', NULL, '2022-02-10 13:15:32', NULL),
(2074, 'android', NULL, '2022-02-10 13:16:17', NULL),
(2075, 'android', NULL, '2022-02-10 13:16:21', NULL),
(2076, 'android', NULL, '2022-02-10 13:16:42', NULL),
(2077, 'android', NULL, '2022-02-10 13:19:01', NULL),
(2078, 'android', NULL, '2022-02-10 13:36:01', NULL),
(2079, 'ios', NULL, '2022-02-10 13:52:18', NULL),
(2080, 'android', NULL, '2022-02-10 13:52:42', NULL),
(2081, 'android', NULL, '2022-02-10 14:44:39', NULL),
(2082, 'android', NULL, '2022-02-10 14:47:15', NULL),
(2083, 'android', NULL, '2022-02-10 15:00:19', NULL),
(2084, 'android', NULL, '2022-02-10 15:03:20', NULL),
(2085, 'android', NULL, '2022-02-10 15:13:57', NULL),
(2086, 'android', NULL, '2022-02-10 15:23:11', NULL),
(2087, 'android', NULL, '2022-02-10 15:24:36', NULL),
(2088, 'android', NULL, '2022-02-10 15:30:05', NULL),
(2089, 'android', NULL, '2022-02-10 15:34:26', NULL),
(2090, 'android', NULL, '2022-02-10 15:38:19', NULL),
(2091, 'android', NULL, '2022-02-10 15:41:16', NULL),
(2092, 'android', NULL, '2022-02-10 16:31:36', NULL),
(2093, 'android', NULL, '2022-02-10 20:40:58', NULL),
(2094, 'android', NULL, '2022-02-10 20:41:18', NULL),
(2095, 'android', NULL, '2022-02-10 21:40:13', NULL),
(2096, 'android', NULL, '2022-02-10 21:44:33', NULL),
(2097, 'android', NULL, '2022-02-10 21:57:47', NULL),
(2098, 'android', NULL, '2022-02-10 22:10:42', NULL),
(2099, 'android', NULL, '2022-02-12 20:15:32', NULL),
(2100, 'android', NULL, '2022-02-12 20:15:45', NULL),
(2101, 'android', NULL, '2022-02-12 20:20:41', NULL),
(2102, 'android', NULL, '2022-02-12 20:20:51', NULL),
(2103, 'android', NULL, '2022-02-12 20:24:37', NULL),
(2104, 'android', NULL, '2022-02-12 20:24:43', NULL),
(2105, 'ios', NULL, '2022-02-13 12:34:30', NULL),
(2106, 'ios', NULL, '2022-02-13 12:34:50', NULL),
(2107, 'ios', NULL, '2022-02-13 12:36:18', NULL),
(2108, 'ios', NULL, '2022-02-13 12:38:37', NULL),
(2109, 'ios', NULL, '2022-02-13 12:39:11', NULL),
(2110, 'ios', NULL, '2022-02-13 12:39:39', NULL),
(2111, 'ios', NULL, '2022-02-13 12:43:24', NULL),
(2112, 'ios', NULL, '2022-02-13 12:43:57', NULL),
(2113, 'ios', NULL, '2022-02-13 12:44:09', NULL),
(2114, 'ios', NULL, '2022-02-13 12:47:14', NULL),
(2115, 'ios', NULL, '2022-02-13 12:51:24', NULL),
(2116, 'ios', NULL, '2022-02-13 12:53:26', NULL),
(2117, 'ios', NULL, '2022-02-13 13:01:51', NULL),
(2118, 'ios', NULL, '2022-02-13 13:02:55', NULL),
(2119, 'ios', NULL, '2022-02-13 13:03:07', NULL),
(2120, 'ios', NULL, '2022-02-13 13:03:09', NULL),
(2121, 'ios', NULL, '2022-02-13 13:03:32', NULL),
(2122, 'ios', NULL, '2022-02-13 13:04:52', NULL),
(2123, 'ios', NULL, '2022-02-13 13:05:34', NULL),
(2124, 'ios', NULL, '2022-02-13 13:06:18', NULL),
(2125, 'ios', NULL, '2022-02-13 13:08:17', NULL),
(2126, 'ios', NULL, '2022-02-13 18:05:27', NULL),
(2127, 'ios', NULL, '2022-02-13 18:05:37', NULL),
(2128, 'ios', NULL, '2022-02-14 01:03:33', NULL),
(2129, 'ios', NULL, '2022-02-14 12:32:07', NULL),
(2130, 'ios', NULL, '2022-02-14 12:32:20', NULL),
(2131, 'ios', NULL, '2022-02-14 12:32:35', NULL),
(2132, 'ios', NULL, '2022-02-14 12:32:40', NULL),
(2133, 'ios', NULL, '2022-02-14 12:36:35', NULL),
(2134, 'ios', NULL, '2022-02-14 12:37:39', NULL),
(2135, 'ios', NULL, '2022-02-14 12:42:04', NULL),
(2136, 'ios', NULL, '2022-02-14 12:54:09', NULL),
(2137, 'ios', NULL, '2022-02-14 12:54:17', NULL),
(2138, 'android', NULL, '2022-02-14 17:15:38', NULL),
(2139, 'android', NULL, '2022-02-14 18:12:06', NULL),
(2140, 'android', NULL, '2022-02-14 20:51:58', NULL),
(2141, 'android', NULL, '2022-02-14 20:54:10', NULL),
(2142, 'ios', NULL, '2022-02-14 23:12:23', NULL),
(2143, 'android', NULL, '2022-02-15 22:43:26', NULL),
(2144, 'android', NULL, '2022-02-16 12:40:47', NULL),
(2145, 'android', NULL, '2022-02-16 12:42:50', NULL),
(2146, 'android', NULL, '2022-02-16 12:43:14', NULL),
(2147, 'android', NULL, '2022-02-16 12:45:37', NULL),
(2148, 'android', NULL, '2022-02-16 12:50:15', NULL),
(2149, 'android', NULL, '2022-02-16 19:35:01', NULL),
(2150, 'android', NULL, '2022-02-16 21:05:48', NULL),
(2151, 'android', NULL, '2022-02-20 14:36:13', NULL),
(2152, 'android', NULL, '2022-02-20 14:40:41', NULL),
(2153, 'android', NULL, '2022-02-20 18:24:56', NULL),
(2154, 'ios', NULL, '2022-02-21 19:00:36', NULL),
(2155, 'ios', NULL, '2022-02-23 12:05:37', NULL),
(2156, 'ios', NULL, '2022-02-23 12:11:29', NULL),
(2157, 'ios', NULL, '2022-02-23 12:12:10', NULL),
(2158, 'ios', NULL, '2022-02-23 12:15:22', NULL),
(2159, 'ios', NULL, '2022-02-23 13:29:32', NULL),
(2160, 'ios', NULL, '2022-02-23 14:44:16', NULL),
(2161, 'ios', NULL, '2022-02-23 14:46:47', NULL),
(2162, 'ios', NULL, '2022-02-23 15:35:50', NULL),
(2163, 'ios', NULL, '2022-02-23 15:37:33', NULL),
(2164, 'ios', NULL, '2022-02-23 15:37:46', NULL),
(2165, 'ios', NULL, '2022-02-23 15:39:08', NULL),
(2166, 'ios', NULL, '2022-02-23 15:39:26', NULL),
(2167, 'ios', NULL, '2022-02-23 17:24:39', NULL),
(2168, 'android', NULL, '2022-02-23 23:51:58', NULL),
(2169, 'ios', NULL, '2022-02-24 11:31:01', NULL),
(2170, 'ios', NULL, '2022-02-24 11:31:05', NULL),
(2171, 'ios', NULL, '2022-02-24 11:31:40', NULL),
(2172, 'ios', NULL, '2022-02-24 11:33:07', NULL),
(2173, 'ios', NULL, '2022-02-24 13:43:32', NULL),
(2174, 'ios', NULL, '2022-02-24 13:45:08', NULL),
(2175, 'ios', NULL, '2022-02-24 13:45:31', NULL),
(2176, 'ios', NULL, '2022-02-24 15:03:46', NULL),
(2177, 'ios', NULL, '2022-02-24 15:04:48', NULL),
(2178, 'ios', NULL, '2022-02-24 15:06:09', NULL),
(2179, 'android', NULL, '2022-02-24 15:08:39', NULL),
(2180, 'ios', NULL, '2022-02-24 17:49:06', NULL),
(2181, 'ios', NULL, '2022-02-24 17:49:58', NULL),
(2182, 'ios', NULL, '2022-02-24 17:52:02', NULL),
(2183, 'ios', NULL, '2022-02-24 17:53:50', NULL),
(2184, 'ios', NULL, '2022-02-24 17:54:05', NULL),
(2185, 'ios', NULL, '2022-02-24 17:54:27', NULL),
(2186, 'ios', NULL, '2022-02-24 17:54:44', NULL),
(2187, 'ios', NULL, '2022-02-24 17:58:53', NULL),
(2188, 'ios', NULL, '2022-02-24 18:00:25', NULL),
(2189, 'ios', NULL, '2022-02-24 18:01:53', NULL),
(2190, 'ios', NULL, '2022-02-24 18:02:31', NULL),
(2191, 'android', NULL, '2022-02-24 20:29:19', NULL),
(2192, 'android', NULL, '2022-02-24 20:57:52', NULL),
(2193, 'ios', NULL, '2022-02-24 21:04:45', NULL),
(2194, 'ios', NULL, '2022-02-24 21:05:52', NULL),
(2195, 'ios', NULL, '2022-02-24 21:07:03', NULL),
(2196, 'ios', NULL, '2022-02-24 21:10:53', NULL),
(2197, 'ios', NULL, '2022-02-24 21:12:41', NULL),
(2198, 'ios', NULL, '2022-02-24 21:13:54', NULL),
(2199, 'android', NULL, '2022-02-24 21:22:14', NULL),
(2200, 'android', NULL, '2022-02-24 21:23:09', NULL),
(2201, 'ios', NULL, '2022-02-25 06:09:06', NULL),
(2202, 'ios', NULL, '2022-02-25 06:10:00', NULL),
(2203, 'ios', NULL, '2022-02-25 06:10:30', NULL),
(2204, 'ios', NULL, '2022-02-25 06:10:48', NULL),
(2205, 'android', NULL, '2022-02-25 12:58:49', NULL),
(2206, 'ios', NULL, '2022-02-25 14:11:41', NULL),
(2207, 'ios', NULL, '2022-02-25 14:11:55', NULL),
(2208, 'ios', NULL, '2022-02-25 14:12:08', NULL),
(2209, 'ios', NULL, '2022-02-25 14:12:34', NULL),
(2210, 'ios', NULL, '2022-02-25 14:13:50', NULL),
(2211, 'ios', NULL, '2022-02-25 14:16:30', NULL),
(2212, 'ios', NULL, '2022-02-25 14:16:47', NULL),
(2213, 'ios', NULL, '2022-02-25 14:17:04', NULL),
(2214, 'ios', NULL, '2022-02-25 14:21:08', NULL),
(2215, 'ios', NULL, '2022-02-25 14:23:08', NULL),
(2216, 'ios', NULL, '2022-02-25 14:23:43', NULL),
(2217, 'android', NULL, '2022-02-26 12:55:00', NULL),
(2218, 'android', NULL, '2022-02-26 12:55:13', NULL),
(2219, 'android', NULL, '2022-02-26 12:55:16', NULL),
(2220, 'android', NULL, '2022-02-26 12:55:43', NULL),
(2221, 'android', NULL, '2022-02-26 13:40:32', NULL),
(2222, 'android', NULL, '2022-02-26 13:42:19', NULL),
(2223, 'android', NULL, '2022-02-26 13:43:05', NULL),
(2224, 'android', NULL, '2022-02-26 13:43:17', NULL),
(2225, 'android', NULL, '2022-02-26 13:44:11', NULL),
(2226, 'ios', NULL, '2022-02-26 15:20:20', NULL),
(2227, 'ios', NULL, '2022-02-26 15:23:51', NULL),
(2228, 'ios', NULL, '2022-02-26 15:24:01', NULL),
(2229, 'ios', NULL, '2022-02-26 15:28:39', NULL),
(2230, 'ios', NULL, '2022-02-26 15:29:38', NULL),
(2231, 'ios', NULL, '2022-02-26 15:31:02', NULL),
(2232, 'ios', NULL, '2022-02-26 15:31:50', NULL),
(2233, 'ios', NULL, '2022-02-26 15:32:32', NULL),
(2234, 'ios', NULL, '2022-02-26 15:32:43', NULL),
(2235, 'ios', NULL, '2022-02-26 15:34:50', NULL),
(2236, 'ios', NULL, '2022-02-26 15:36:27', NULL),
(2237, 'ios', NULL, '2022-02-26 15:36:48', NULL),
(2238, 'ios', NULL, '2022-02-26 15:36:55', NULL),
(2239, 'ios', NULL, '2022-02-26 15:38:08', NULL),
(2240, 'ios', NULL, '2022-02-26 15:39:18', NULL),
(2241, 'ios', NULL, '2022-02-26 15:39:25', NULL),
(2242, 'ios', NULL, '2022-02-26 15:39:50', NULL),
(2243, 'ios', NULL, '2022-02-26 15:40:03', NULL),
(2244, 'ios', NULL, '2022-02-26 15:40:40', NULL),
(2245, 'ios', NULL, '2022-02-26 15:42:53', NULL),
(2246, 'ios', NULL, '2022-02-26 15:43:27', NULL),
(2247, 'ios', NULL, '2022-02-26 15:45:06', NULL),
(2248, 'ios', NULL, '2022-02-26 15:45:59', NULL),
(2249, 'ios', NULL, '2022-02-26 15:47:08', NULL),
(2250, 'ios', NULL, '2022-02-26 15:48:55', NULL),
(2251, 'ios', NULL, '2022-02-26 15:56:58', NULL),
(2252, 'ios', NULL, '2022-02-27 15:10:42', NULL),
(2253, 'ios', NULL, '2022-02-27 15:10:53', NULL),
(2254, 'ios', NULL, '2022-02-27 15:12:28', NULL),
(2255, 'android', NULL, '2022-02-27 16:17:32', NULL),
(2256, 'android', NULL, '2022-02-27 17:46:22', NULL),
(2257, 'android', NULL, '2022-02-28 14:25:46', NULL),
(2258, 'android', NULL, '2022-02-28 14:25:57', NULL),
(2259, 'android', NULL, '2022-02-28 14:32:30', NULL),
(2260, 'android', NULL, '2022-02-28 14:52:18', NULL),
(2261, 'android', NULL, '2022-02-28 14:52:33', NULL),
(2262, 'android', NULL, '2022-02-28 15:13:43', NULL),
(2263, 'android', NULL, '2022-02-28 15:16:04', NULL),
(2264, 'android', NULL, '2022-02-28 15:17:37', NULL),
(2265, 'android', NULL, '2022-02-28 15:45:11', NULL),
(2266, 'android', NULL, '2022-02-28 15:50:14', NULL),
(2267, 'android', NULL, '2022-02-28 16:15:46', NULL),
(2268, 'android', NULL, '2022-02-28 16:38:06', NULL),
(2269, 'android', NULL, '2022-02-28 16:55:49', NULL),
(2270, 'android', NULL, '2022-02-28 21:40:51', NULL),
(2271, 'android', NULL, '2022-03-01 01:07:00', NULL),
(2272, 'android', NULL, '2022-03-01 01:15:47', NULL),
(2273, 'android', NULL, '2022-03-01 01:19:08', NULL),
(2274, 'android', NULL, '2022-03-01 01:19:20', NULL),
(2275, 'android', NULL, '2022-03-01 01:33:27', NULL),
(2276, 'android', NULL, '2022-03-01 01:36:15', NULL),
(2277, 'android', NULL, '2022-03-01 01:37:56', NULL),
(2278, 'android', NULL, '2022-03-01 01:45:59', NULL),
(2279, 'android', NULL, '2022-03-01 01:49:51', NULL),
(2280, 'android', NULL, '2022-03-01 01:49:55', NULL),
(2281, 'android', NULL, '2022-03-01 02:03:42', NULL),
(2282, 'android', NULL, '2022-03-01 02:04:56', NULL),
(2283, 'android', NULL, '2022-03-01 02:14:11', NULL),
(2284, 'android', NULL, '2022-03-01 02:19:14', NULL),
(2285, 'android', NULL, '2022-03-01 09:59:41', NULL),
(2286, 'android', NULL, '2022-03-01 10:23:59', NULL),
(2287, 'android', NULL, '2022-03-01 10:38:55', NULL),
(2288, 'android', NULL, '2022-03-01 10:50:29', NULL),
(2289, 'android', NULL, '2022-03-01 11:32:47', NULL),
(2290, 'android', NULL, '2022-03-01 11:37:24', NULL),
(2291, 'android', NULL, '2022-03-01 11:41:23', NULL),
(2292, 'android', NULL, '2022-03-01 11:42:12', NULL),
(2293, 'android', NULL, '2022-03-01 11:42:29', NULL),
(2294, 'android', NULL, '2022-03-01 11:42:43', NULL),
(2295, 'android', NULL, '2022-03-01 11:45:23', NULL),
(2296, 'android', NULL, '2022-03-01 11:45:37', NULL),
(2297, 'android', NULL, '2022-03-01 11:45:54', NULL),
(2298, 'android', NULL, '2022-03-01 12:07:31', NULL),
(2299, 'android', NULL, '2022-03-01 12:19:15', NULL),
(2300, 'android', NULL, '2022-03-01 12:20:21', NULL),
(2301, 'ios', NULL, '2022-03-01 17:10:35', NULL),
(2302, 'ios', NULL, '2022-03-01 17:12:14', NULL),
(2303, 'ios', NULL, '2022-03-01 17:20:32', NULL),
(2304, 'ios', NULL, '2022-03-01 17:21:00', NULL),
(2305, 'ios', NULL, '2022-03-01 17:21:42', NULL),
(2306, 'ios', NULL, '2022-03-01 17:23:58', NULL),
(2307, 'ios', NULL, '2022-03-01 17:24:38', NULL),
(2308, 'ios', NULL, '2022-03-01 17:24:54', NULL),
(2309, 'ios', NULL, '2022-03-01 17:25:20', NULL),
(2310, 'ios', NULL, '2022-03-01 17:48:14', NULL),
(2311, 'ios', NULL, '2022-03-01 17:50:33', NULL),
(2312, 'ios', NULL, '2022-03-01 17:50:46', NULL),
(2313, 'ios', NULL, '2022-03-01 17:52:20', NULL),
(2314, 'ios', NULL, '2022-03-01 17:53:21', NULL),
(2315, 'ios', NULL, '2022-03-01 17:54:08', NULL),
(2316, 'ios', NULL, '2022-03-01 17:54:23', NULL),
(2317, 'ios', NULL, '2022-03-01 17:56:13', NULL),
(2318, 'ios', NULL, '2022-03-01 17:56:24', NULL),
(2319, 'ios', NULL, '2022-03-01 17:56:44', NULL),
(2320, 'android', NULL, '2022-03-01 18:22:13', NULL),
(2321, 'android', NULL, '2022-03-01 18:27:53', NULL),
(2322, 'android', NULL, '2022-03-03 16:53:28', NULL),
(2323, 'ios', NULL, '2022-03-05 21:35:26', NULL),
(2324, 'ios', NULL, '2022-03-05 21:36:05', NULL),
(2325, 'ios', NULL, '2022-03-05 21:36:37', NULL),
(2326, 'ios', NULL, '2022-03-05 21:38:14', NULL),
(2327, 'ios', NULL, '2022-03-05 21:40:12', NULL),
(2328, 'ios', NULL, '2022-03-05 21:45:28', NULL),
(2329, 'ios', NULL, '2022-03-05 21:47:38', NULL),
(2330, 'ios', NULL, '2022-03-05 21:48:16', NULL),
(2331, 'ios', NULL, '2022-03-05 21:48:42', NULL),
(2332, 'ios', NULL, '2022-03-05 21:48:51', NULL),
(2333, 'ios', NULL, '2022-03-05 21:52:37', NULL),
(2334, 'ios', NULL, '2022-03-05 21:52:48', NULL),
(2335, 'ios', NULL, '2022-03-06 09:29:06', NULL),
(2336, 'ios', NULL, '2022-03-06 11:22:49', NULL),
(2337, 'ios', NULL, '2022-03-06 11:23:47', NULL),
(2338, 'ios', NULL, '2022-03-06 11:24:00', NULL),
(2339, 'ios', NULL, '2022-03-06 11:24:06', NULL),
(2340, 'ios', NULL, '2022-03-06 11:27:22', NULL),
(2341, 'ios', NULL, '2022-03-06 11:57:21', NULL),
(2342, 'ios', NULL, '2022-03-06 11:59:03', NULL),
(2343, 'ios', NULL, '2022-03-06 11:59:33', NULL),
(2344, 'ios', NULL, '2022-03-06 12:06:40', NULL),
(2345, 'ios', NULL, '2022-03-06 12:07:08', NULL),
(2346, 'ios', NULL, '2022-03-06 12:21:49', NULL),
(2347, 'ios', NULL, '2022-03-06 12:23:40', NULL),
(2348, 'ios', NULL, '2022-03-06 12:26:12', NULL),
(2349, 'ios', NULL, '2022-03-06 12:26:51', NULL),
(2350, 'android', NULL, '2022-03-06 12:28:44', NULL),
(2351, 'ios', NULL, '2022-03-06 12:34:48', NULL),
(2352, 'ios', NULL, '2022-03-06 12:36:17', NULL),
(2353, 'ios', NULL, '2022-03-06 12:37:11', NULL),
(2354, 'ios', NULL, '2022-03-06 12:37:20', NULL),
(2355, 'ios', NULL, '2022-03-06 12:51:52', NULL),
(2356, 'ios', NULL, '2022-03-06 12:52:04', NULL),
(2357, 'ios', NULL, '2022-03-06 12:52:34', NULL),
(2358, 'ios', NULL, '2022-03-06 12:53:41', NULL),
(2359, 'ios', NULL, '2022-03-06 12:58:47', NULL),
(2360, 'ios', NULL, '2022-03-06 13:00:16', NULL),
(2361, 'ios', NULL, '2022-03-06 13:04:04', NULL),
(2362, 'ios', NULL, '2022-03-06 13:06:15', NULL),
(2363, 'ios', NULL, '2022-03-06 13:06:29', NULL),
(2364, 'ios', NULL, '2022-03-06 13:19:16', NULL),
(2365, 'ios', NULL, '2022-03-06 13:27:32', NULL),
(2366, 'ios', NULL, '2022-03-06 14:02:06', NULL),
(2367, 'ios', NULL, '2022-03-06 14:02:31', NULL),
(2368, 'ios', NULL, '2022-03-06 14:08:00', NULL),
(2369, 'android', NULL, '2022-03-06 14:15:04', NULL),
(2370, 'android', NULL, '2022-03-06 14:16:49', NULL),
(2371, 'android', NULL, '2022-03-06 14:17:37', NULL),
(2372, 'ios', NULL, '2022-03-06 15:25:59', NULL),
(2373, 'ios', NULL, '2022-03-06 15:26:05', NULL),
(2374, 'ios', NULL, '2022-03-06 15:26:55', NULL),
(2375, 'ios', NULL, '2022-03-06 15:27:32', NULL),
(2376, 'ios', NULL, '2022-03-06 15:29:03', NULL),
(2377, 'ios', NULL, '2022-03-06 15:29:16', NULL),
(2378, 'ios', NULL, '2022-03-06 15:44:06', NULL),
(2379, 'ios', NULL, '2022-03-06 15:44:47', NULL),
(2380, 'ios', NULL, '2022-03-06 15:45:12', NULL),
(2381, 'ios', NULL, '2022-03-06 15:45:50', NULL),
(2382, 'ios', NULL, '2022-03-06 15:46:35', NULL),
(2383, 'ios', NULL, '2022-03-06 15:52:57', NULL),
(2384, 'ios', NULL, '2022-03-06 15:53:40', NULL),
(2385, 'ios', NULL, '2022-03-07 12:23:59', NULL),
(2386, 'ios', NULL, '2022-03-07 12:24:14', NULL),
(2387, 'ios', NULL, '2022-03-07 12:32:35', NULL),
(2388, 'ios', NULL, '2022-03-07 12:32:58', NULL),
(2389, 'ios', NULL, '2022-03-07 12:34:27', NULL),
(2390, 'ios', NULL, '2022-03-07 12:35:00', NULL),
(2391, 'ios', NULL, '2022-03-07 12:35:21', NULL),
(2392, 'ios', NULL, '2022-03-07 12:35:40', NULL),
(2393, 'ios', NULL, '2022-03-07 12:35:57', NULL),
(2394, 'ios', NULL, '2022-03-07 12:36:23', NULL),
(2395, 'ios', NULL, '2022-03-07 12:36:53', NULL),
(2396, 'ios', NULL, '2022-03-07 12:37:15', NULL),
(2397, 'ios', NULL, '2022-03-07 12:37:22', NULL),
(2398, 'android', NULL, '2022-03-07 14:27:38', NULL),
(2399, 'android', NULL, '2022-03-07 14:27:46', NULL),
(2400, 'android', NULL, '2022-03-07 14:27:49', NULL),
(2401, 'android', NULL, '2022-03-07 14:28:57', NULL),
(2402, 'android', NULL, '2022-03-07 16:13:04', NULL),
(2403, 'android', NULL, '2022-03-07 16:52:52', NULL),
(2404, 'android', NULL, '2022-03-07 17:35:15', NULL),
(2405, 'android', NULL, '2022-03-07 17:39:31', NULL),
(2406, 'android', NULL, '2022-03-07 17:43:10', NULL),
(2407, 'android', NULL, '2022-03-07 17:46:03', NULL),
(2408, 'android', NULL, '2022-03-07 17:46:19', NULL),
(2409, 'android', NULL, '2022-03-07 17:46:39', NULL),
(2410, 'android', NULL, '2022-03-07 17:47:39', NULL),
(2411, 'android', NULL, '2022-03-07 17:48:28', NULL),
(2412, 'android', NULL, '2022-03-07 17:49:57', NULL),
(2413, 'android', NULL, '2022-03-07 18:07:04', NULL),
(2414, 'android', NULL, '2022-03-07 18:07:52', NULL),
(2415, 'android', NULL, '2022-03-07 18:09:36', NULL),
(2416, 'android', NULL, '2022-03-07 18:11:47', NULL),
(2417, 'android', NULL, '2022-03-07 18:12:21', NULL),
(2418, 'android', NULL, '2022-03-07 18:13:23', NULL),
(2419, 'android', NULL, '2022-03-07 18:13:34', NULL),
(2420, 'android', NULL, '2022-03-07 18:13:41', NULL),
(2421, 'ios', NULL, '2022-03-07 18:19:38', NULL),
(2422, 'android', NULL, '2022-03-07 18:21:17', NULL),
(2423, 'android', NULL, '2022-03-07 18:21:51', NULL),
(2424, 'ios', NULL, '2022-03-07 19:08:41', NULL),
(2425, 'ios', NULL, '2022-03-07 21:06:49', NULL),
(2426, 'ios', NULL, '2022-03-07 21:12:51', NULL),
(2427, 'ios', NULL, '2022-03-07 21:13:29', NULL),
(2428, 'android', NULL, '2022-03-07 21:54:30', NULL),
(2429, 'android', NULL, '2022-03-07 22:42:54', NULL),
(2430, 'ios', NULL, '2022-03-07 23:49:27', NULL),
(2431, 'android', NULL, '2022-03-08 12:56:51', NULL),
(2432, 'android', NULL, '2022-03-08 12:57:23', NULL),
(2433, 'android', NULL, '2022-03-09 04:26:46', NULL),
(2434, 'android', NULL, '2022-03-09 10:24:25', NULL),
(2435, 'android', NULL, '2022-03-09 11:10:12', NULL),
(2436, 'android', NULL, '2022-03-10 14:25:09', NULL),
(2437, 'android', NULL, '2022-03-10 16:33:25', NULL),
(2438, 'android', NULL, '2022-03-11 00:00:35', NULL),
(2439, 'android', NULL, '2022-03-11 11:31:39', NULL),
(2440, 'android', NULL, '2022-03-11 11:32:06', NULL),
(2441, 'ios', NULL, '2022-03-13 15:14:14', NULL),
(2442, 'ios', NULL, '2022-03-13 15:15:36', NULL),
(2443, 'ios', NULL, '2022-03-13 15:18:54', NULL),
(2444, 'ios', NULL, '2022-03-14 12:35:50', NULL),
(2445, 'android', NULL, '2022-03-15 21:51:40', NULL),
(2446, 'android', NULL, '2022-03-16 22:54:06', NULL),
(2447, 'android', NULL, '2022-03-16 22:54:39', NULL),
(2448, 'android', NULL, '2022-03-16 22:55:07', NULL),
(2449, 'android', NULL, '2022-03-17 15:53:15', NULL),
(2450, 'android', NULL, '2022-03-17 15:55:32', NULL),
(2451, 'android', NULL, '2022-03-17 15:55:55', NULL),
(2452, 'android', NULL, '2022-03-19 15:51:31', NULL),
(2453, 'android', NULL, '2022-03-19 15:52:44', NULL),
(2454, 'android', NULL, '2022-03-20 11:23:37', NULL),
(2455, 'android', NULL, '2022-03-20 19:37:50', NULL),
(2456, 'android', NULL, '2022-03-20 19:38:00', NULL),
(2457, 'android', NULL, '2022-03-20 19:39:00', NULL),
(2458, 'android', NULL, '2022-03-21 01:08:17', NULL),
(2459, 'android', NULL, '2022-03-21 01:08:27', NULL),
(2460, 'android', NULL, '2022-03-21 01:09:26', NULL),
(2461, 'android', NULL, '2022-03-21 04:42:23', NULL),
(2462, 'android', NULL, '2022-03-21 04:42:38', NULL),
(2463, 'android', NULL, '2022-03-21 04:45:36', NULL),
(2464, 'android', NULL, '2022-03-21 19:31:23', NULL),
(2465, 'android', NULL, '2022-03-21 19:31:29', NULL),
(2466, 'ios', NULL, '2022-03-21 19:32:24', NULL),
(2467, 'ios', NULL, '2022-03-21 19:32:37', NULL),
(2468, 'ios', NULL, '2022-03-21 19:33:21', NULL),
(2469, 'android', NULL, '2022-03-22 13:00:04', NULL),
(2470, 'android', NULL, '2022-03-22 13:00:22', NULL),
(2471, 'ios', NULL, '2022-03-22 22:01:05', NULL),
(2472, 'ios', NULL, '2022-03-22 22:02:22', NULL),
(2473, 'ios', NULL, '2022-03-22 22:02:25', NULL),
(2474, 'ios', NULL, '2022-03-22 22:02:26', NULL),
(2475, 'ios', NULL, '2022-03-22 22:02:27', NULL),
(2476, 'android', NULL, '2022-03-22 22:22:57', NULL),
(2477, 'android', NULL, '2022-03-22 22:23:11', NULL),
(2478, 'android', NULL, '2022-03-22 22:24:08', NULL),
(2479, 'android', NULL, '2022-03-22 22:26:06', NULL),
(2480, 'android', NULL, '2022-03-22 23:35:43', NULL),
(2481, 'android', NULL, '2022-03-22 23:44:05', NULL),
(2482, 'android', NULL, '2022-03-23 14:34:07', NULL),
(2483, 'ios', NULL, '2022-03-23 18:04:48', NULL),
(2484, 'ios', NULL, '2022-03-23 18:05:00', NULL),
(2485, 'ios', NULL, '2022-03-23 18:05:20', NULL),
(2486, 'ios', NULL, '2022-03-24 11:58:59', NULL),
(2487, 'ios', NULL, '2022-03-24 11:59:04', NULL),
(2488, 'ios', NULL, '2022-03-24 11:59:21', NULL),
(2489, 'ios', NULL, '2022-03-24 19:14:08', NULL),
(2490, 'android', NULL, '2022-03-27 00:12:23', NULL),
(2491, 'android', NULL, '2022-03-27 00:13:31', NULL),
(2492, 'ios', NULL, '2022-03-27 06:18:00', NULL),
(2493, 'android', NULL, '2022-03-27 19:32:44', NULL),
(2494, 'ios', NULL, '2022-03-28 11:03:50', NULL),
(2495, 'ios', NULL, '2022-03-28 11:04:18', NULL),
(2496, 'ios', NULL, '2022-03-28 11:04:33', NULL),
(2497, 'ios', NULL, '2022-03-28 11:06:31', NULL),
(2498, 'ios', NULL, '2022-03-28 11:16:33', NULL),
(2499, 'android', NULL, '2022-03-29 04:16:47', NULL),
(2500, 'ios', NULL, '2022-03-29 17:48:18', NULL),
(2501, 'ios', NULL, '2022-03-29 17:48:32', NULL),
(2502, 'ios', NULL, '2022-03-31 14:31:40', NULL),
(2503, 'ios', NULL, '2022-03-31 14:33:26', NULL),
(2504, 'ios', NULL, '2022-03-31 14:34:34', NULL),
(2505, 'ios', NULL, '2022-03-31 14:35:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_reports`
--
ALTER TABLE `admin_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branches_city_id_foreign` (`city_id`);

--
-- Indexes for table `branch_regions`
--
ALTER TABLE `branch_regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_regions_branch_id_foreign` (`branch_id`),
  ADD KEY `branch_regions_region_id_foreign` (`region_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_user_id_foreign` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_user_id_foreign` (`user_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devices_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guarantee_visits`
--
ALTER TABLE `guarantee_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guarantee_visits_order_id_foreign` (`order_id`),
  ADD KEY `guarantee_visits_order_guarantee_id_foreign` (`order_guarantee_id`),
  ADD KEY `guarantee_visits_technician_id_foreign` (`technician_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_image_type_image_id_index` (`image_type`,`image_id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_user_id_foreign` (`user_id`),
  ADD KEY `incomes_order_id_foreign` (`order_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_room_id_foreign` (`room_id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `message_notifications`
--
ALTER TABLE `message_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_notifications_message_id_foreign` (`message_id`),
  ADD KEY `message_notifications_room_id_foreign` (`room_id`),
  ADD KEY `message_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_to_id_foreign` (`to_id`),
  ADD KEY `notifications_from_id_foreign` (`from_id`),
  ADD KEY `notifications_order_id_foreign` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_technician_id_foreign` (`technician_id`),
  ADD KEY `orders_city_id_foreign` (`city_id`),
  ADD KEY `orders_region_id_foreign` (`region_id`),
  ADD KEY `orders_category_id_foreign` (`category_id`),
  ADD KEY `orders_coupon_id_foreign` (`coupon_id`),
  ADD KEY `orders_canceled_by_foreign` (`canceled_by`);

--
-- Indexes for table `order_bills`
--
ALTER TABLE `order_bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_bills_order_id_foreign` (`order_id`),
  ADD KEY `order_bills_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `order_guarantees`
--
ALTER TABLE `order_guarantees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_guarantees_order_id_foreign` (`order_id`),
  ADD KEY `order_guarantees_technical_id_foreign` (`technical_id`);

--
-- Indexes for table `order_parts`
--
ALTER TABLE `order_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_parts_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_parts_bills`
--
ALTER TABLE `order_parts_bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_parts_bills_order_bill_id_foreign` (`order_bill_id`),
  ADD KEY `order_parts_bills_order_part_id_foreign` (`order_part_id`);

--
-- Indexes for table `order_services`
--
ALTER TABLE `order_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_services_order_id_foreign` (`order_id`),
  ADD KEY `order_services_service_id_foreign` (`service_id`),
  ADD KEY `order_services_category_id_foreign` (`category_id`);

--
-- Indexes for table `order_services_bills`
--
ALTER TABLE `order_services_bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_services_bills_order_bill_id_foreign` (`order_bill_id`),
  ADD KEY `order_services_bills_order_service_id_foreign` (`order_service_id`);

--
-- Indexes for table `order_technicians`
--
ALTER TABLE `order_technicians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_technicians_technician_id_foreign` (`technician_id`),
  ADD KEY `order_technicians_order_id_foreign` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parts_service_id_foreign` (`service_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refuse_orders`
--
ALTER TABLE `refuse_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refuse_orders_user_id_foreign` (`user_id`),
  ADD KEY `refuse_orders_order_id_foreign` (`order_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_city_id_foreign` (`city_id`);

--
-- Indexes for table `review_rates`
--
ALTER TABLE `review_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_rates_user_id_foreign` (`user_id`),
  ADD KEY `review_rates_order_id_foreign` (`order_id`),
  ADD KEY `review_rates_rateable_type_rateable_id_index` (`rateable_type`,`rateable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_users`
--
ALTER TABLE `room_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_users_room_id_foreign` (`room_id`),
  ADD KEY `room_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_city_id_foreign` (`city_id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `technicians_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_email_deleted_at_unique` (`phone`,`email`,`deleted_at`),
  ADD KEY `users_country_id_foreign` (`country_id`),
  ADD KEY `users_city_id_foreign` (`city_id`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- Indexes for table `users_branches`
--
ALTER TABLE `users_branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_branches_branch_id_foreign` (`branch_id`),
  ADD KEY `users_branches_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_categories`
--
ALTER TABLE `user_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_categories_category_id_foreign` (`category_id`),
  ADD KEY `user_categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_deductions`
--
ALTER TABLE `user_deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_deductions_user_id_foreign` (`user_id`),
  ADD KEY `user_deductions_admin_id_foreign` (`admin_id`),
  ADD KEY `user_deductions_order_id_foreign` (`order_id`);

--
-- Indexes for table `user_socials`
--
ALTER TABLE `user_socials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_socials_user_id_foreign` (`user_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_reports`
--
ALTER TABLE `admin_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=773;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch_regions`
--
ALTER TABLE `branch_regions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `guarantee_visits`
--
ALTER TABLE `guarantee_visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1222;

--
-- AUTO_INCREMENT for table `langs`
--
ALTER TABLE `langs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_notifications`
--
ALTER TABLE `message_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=909;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_bills`
--
ALTER TABLE `order_bills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_guarantees`
--
ALTER TABLE `order_guarantees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_parts`
--
ALTER TABLE `order_parts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_parts_bills`
--
ALTER TABLE `order_parts_bills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_services`
--
ALTER TABLE `order_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_services_bills`
--
ALTER TABLE `order_services_bills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_technicians`
--
ALTER TABLE `order_technicians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3312;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `refuse_orders`
--
ALTER TABLE `refuse_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review_rates`
--
ALTER TABLE `review_rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_users`
--
ALTER TABLE `room_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users_branches`
--
ALTER TABLE `users_branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_categories`
--
ALTER TABLE `user_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_deductions`
--
ALTER TABLE `user_deductions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_socials`
--
ALTER TABLE `user_socials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2506;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Constraints for table `branch_regions`
--
ALTER TABLE `branch_regions`
  ADD CONSTRAINT `branch_regions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_regions_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `guarantee_visits`
--
ALTER TABLE `guarantee_visits`
  ADD CONSTRAINT `guarantee_visits_order_guarantee_id_foreign` FOREIGN KEY (`order_guarantee_id`) REFERENCES `order_guarantees` (`id`),
  ADD CONSTRAINT `guarantee_visits_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `guarantee_visits_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `incomes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_notifications`
--
ALTER TABLE `message_notifications`
  ADD CONSTRAINT `message_notifications_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_notifications_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `notifications_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_canceled_by_foreign` FOREIGN KEY (`canceled_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  ADD CONSTRAINT `orders_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_bills`
--
ALTER TABLE `order_bills`
  ADD CONSTRAINT `order_bills_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_bills_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `order_guarantees`
--
ALTER TABLE `order_guarantees`
  ADD CONSTRAINT `order_guarantees_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_guarantees_technical_id_foreign` FOREIGN KEY (`technical_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `order_parts`
--
ALTER TABLE `order_parts`
  ADD CONSTRAINT `order_parts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `order_parts_bills`
--
ALTER TABLE `order_parts_bills`
  ADD CONSTRAINT `order_parts_bills_order_bill_id_foreign` FOREIGN KEY (`order_bill_id`) REFERENCES `order_bills` (`id`),
  ADD CONSTRAINT `order_parts_bills_order_part_id_foreign` FOREIGN KEY (`order_part_id`) REFERENCES `order_parts` (`id`);

--
-- Constraints for table `order_services`
--
ALTER TABLE `order_services`
  ADD CONSTRAINT `order_services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_services_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `order_services_bills`
--
ALTER TABLE `order_services_bills`
  ADD CONSTRAINT `order_services_bills_order_bill_id_foreign` FOREIGN KEY (`order_bill_id`) REFERENCES `order_bills` (`id`),
  ADD CONSTRAINT `order_services_bills_order_service_id_foreign` FOREIGN KEY (`order_service_id`) REFERENCES `order_services` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `order_technicians`
--
ALTER TABLE `order_technicians`
  ADD CONSTRAINT `order_technicians_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_technicians_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `parts_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `refuse_orders`
--
ALTER TABLE `refuse_orders`
  ADD CONSTRAINT `refuse_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `refuse_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `regions_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_rates`
--
ALTER TABLE `review_rates`
  ADD CONSTRAINT `review_rates_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_users`
--
ALTER TABLE `room_users`
  ADD CONSTRAINT `room_users_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sliders`
--
ALTER TABLE `sliders`
  ADD CONSTRAINT `sliders_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Constraints for table `technicians`
--
ALTER TABLE `technicians`
  ADD CONSTRAINT `technicians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `users_branches`
--
ALTER TABLE `users_branches`
  ADD CONSTRAINT `users_branches_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_branches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_categories`
--
ALTER TABLE `user_categories`
  ADD CONSTRAINT `user_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_deductions`
--
ALTER TABLE `user_deductions`
  ADD CONSTRAINT `user_deductions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_deductions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_deductions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_socials`
--
ALTER TABLE `user_socials`
  ADD CONSTRAINT `user_socials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
