-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_attendance_monitoring
CREATE DATABASE IF NOT EXISTS `db_attendance_monitoring` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_attendance_monitoring`;

-- Dumping structure for table db_attendance_monitoring.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db_attendance_monitoring.login_logs
CREATE TABLE IF NOT EXISTS `login_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `login_time` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logout_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.login_logs: ~44 rows (approximately)
INSERT INTO `login_logs` (`id`, `user_id`, `ip_address`, `user_agent`, `login_time`, `created_at`, `updated_at`, `logout_time`) VALUES
	(1, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:44:10', '2024-09-29 10:44:10', '2024-09-29 10:44:10', NULL),
	(2, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:44:28', '2024-09-29 10:44:28', '2024-09-29 10:44:28', NULL),
	(3, 2, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:52:50', '2024-09-29 10:52:50', '2024-09-29 10:52:50', NULL),
	(4, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:53:41', '2024-09-29 10:53:41', '2024-09-29 10:53:41', NULL),
	(5, 2, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:54:02', '2024-09-29 10:54:02', '2024-09-29 10:54:02', NULL),
	(6, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:55:27', '2024-09-29 10:55:27', '2024-09-29 10:55:27', NULL),
	(7, 2, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:56:16', '2024-09-29 10:56:16', '2024-09-29 10:56:16', NULL),
	(8, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-09-29 18:59:01', '2024-09-29 10:59:01', '2024-09-29 10:59:01', NULL),
	(9, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-29 19:07:55', '2024-09-29 11:07:55', '2024-09-29 11:07:55', NULL),
	(10, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-29 21:43:14', '2024-09-29 13:43:14', '2024-09-29 13:43:14', NULL),
	(11, 2, '111.90.194.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 03:05:46', '2024-09-29 19:05:46', '2024-09-29 19:05:46', NULL),
	(12, 1, '111.90.194.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 03:06:31', '2024-09-29 19:06:31', '2024-09-29 19:06:31', NULL),
	(13, 4, '111.90.194.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 03:08:05', '2024-09-29 19:08:05', '2024-09-29 19:08:05', NULL),
	(14, 4, '111.90.194.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 03:08:58', '2024-09-29 19:08:58', '2024-09-29 19:08:58', NULL),
	(15, 1, '112.198.114.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 04:02:12', '2024-09-29 20:02:12', '2024-09-29 20:02:12', NULL),
	(16, 2, '112.198.114.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 04:09:35', '2024-09-29 20:09:35', '2024-09-29 20:09:35', NULL),
	(17, 1, '112.198.114.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 04:24:18', '2024-09-29 20:24:18', '2024-09-29 20:24:18', NULL),
	(18, 1, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-09-30 07:14:46', '2024-09-29 23:14:46', '2024-09-29 23:14:46', NULL),
	(19, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-01 03:53:17', '2024-09-30 19:53:17', '2024-09-30 19:53:17', NULL),
	(20, 2, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-01 03:54:56', '2024-09-30 19:54:56', '2024-09-30 19:54:56', NULL),
	(21, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-01 12:17:04', '2024-10-01 04:17:04', '2024-10-01 04:17:04', NULL),
	(22, 2, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-01 12:17:24', '2024-10-01 04:17:24', '2024-10-01 04:17:24', NULL),
	(23, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-01 12:31:04', '2024-10-01 04:31:04', '2024-10-01 04:31:04', NULL),
	(24, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-01 17:32:49', '2024-10-01 09:32:49', '2024-10-01 09:32:49', NULL),
	(25, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-01 17:33:05', '2024-10-01 09:33:05', '2024-10-01 09:33:05', NULL),
	(26, 2, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-01 22:42:29', '2024-10-01 14:42:29', '2024-10-01 14:42:29', NULL),
	(27, 1, '110.54.152.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-02 04:21:35', '2024-10-01 20:21:35', '2024-10-01 20:21:35', NULL),
	(28, 2, '180.191.36.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-02 04:46:33', '2024-10-01 20:46:33', '2024-10-01 20:46:33', NULL),
	(29, 1, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-02 04:50:15', '2024-10-01 20:50:15', '2024-10-01 20:50:15', NULL),
	(30, 2, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-02 04:51:24', '2024-10-01 20:51:24', '2024-10-01 20:51:24', NULL),
	(31, 1, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-02 04:52:36', '2024-10-01 20:52:36', '2024-10-01 20:52:36', NULL),
	(32, 2, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-02 04:53:25', '2024-10-01 20:53:25', '2024-10-01 20:53:25', NULL),
	(33, 1, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-02 05:02:46', '2024-10-01 21:02:46', '2024-10-01 21:02:46', NULL),
	(34, 1, '180.191.36.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-02 05:42:54', '2024-10-01 21:42:54', '2024-10-01 21:42:54', NULL),
	(35, 2, '180.191.36.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-02 06:04:45', '2024-10-01 22:04:45', '2024-10-01 22:04:45', NULL),
	(36, 1, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-02 06:06:43', '2024-10-01 22:06:43', '2024-10-01 22:06:43', NULL),
	(37, 2, '143.44.225.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-02 06:20:31', '2024-10-01 22:20:31', '2024-10-01 22:20:31', NULL),
	(38, 1, '180.191.36.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-02 06:26:36', '2024-10-01 22:26:36', '2024-10-01 22:26:36', NULL),
	(39, 1, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:05:34', '2024-10-02 19:05:34', '2024-10-02 19:05:34', NULL),
	(40, 1, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:05:34', '2024-10-02 19:05:34', '2024-10-02 19:05:34', NULL),
	(41, 1, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:05:34', '2024-10-02 19:05:34', '2024-10-02 19:05:34', NULL),
	(42, 1, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:05:34', '2024-10-02 19:05:34', '2024-10-02 19:05:34', NULL),
	(43, 2, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:08:28', '2024-10-02 19:08:28', '2024-10-02 19:08:28', NULL),
	(44, 1, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:09:54', '2024-10-02 19:09:54', '2024-10-02 19:09:54', NULL),
	(45, 4, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:11:27', '2024-10-02 19:11:27', '2024-10-02 19:11:27', NULL),
	(46, 5, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:14:29', '2024-10-02 19:14:29', '2024-10-02 19:14:29', NULL),
	(47, 6, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:17:33', '2024-10-02 19:17:33', '2024-10-02 19:17:33', NULL),
	(48, 2, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:20:34', '2024-10-02 19:20:34', '2024-10-02 19:20:34', NULL),
	(49, 2, '112.198.113.84', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 03:20:54', '2024-10-02 19:20:54', '2024-10-02 19:20:54', NULL),
	(50, 1, '110.54.138.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 07:27:07', '2024-10-02 23:27:07', '2024-10-02 23:27:07', NULL),
	(51, 4, '110.54.138.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-03 07:33:25', '2024-10-02 23:33:25', '2024-10-02 23:33:25', NULL),
	(52, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-04 00:58:32', '2024-10-03 16:58:32', '2024-10-03 16:58:32', NULL),
	(53, 1, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-06 02:42:46', '2024-10-05 18:42:46', '2024-10-05 18:42:46', NULL),
	(54, 4, '119.94.237.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-06 02:45:07', '2024-10-05 18:45:07', '2024-10-05 18:45:07', NULL),
	(55, 4, '111.90.194.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-07 05:02:12', '2024-10-06 21:02:12', '2024-10-06 21:02:12', NULL),
	(56, 4, '111.90.194.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-07 06:01:41', '2024-10-06 22:01:41', '2024-10-06 22:01:41', NULL),
	(57, 4, '216.247.88.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-08 04:03:35', '2024-10-07 20:03:35', '2024-10-07 20:03:35', NULL),
	(58, 1, '216.247.88.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-08 04:58:33', '2024-10-07 20:58:33', '2024-10-07 20:58:33', NULL),
	(59, 4, '216.247.88.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-08 05:08:38', '2024-10-07 21:08:38', '2024-10-07 21:08:38', NULL),
	(60, 1, '216.247.88.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-08 05:19:31', '2024-10-07 21:19:31', '2024-10-07 21:19:31', NULL),
	(61, 1, '143.44.145.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-19 22:56:34', '2024-10-19 14:56:34', '2024-10-19 14:56:34', NULL),
	(62, 4, '143.44.145.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2024-10-19 22:59:20', '2024-10-19 14:59:20', '2024-10-19 14:59:20', NULL),
	(63, 1, '143.44.145.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '2024-11-04 08:03:59', '2024-11-04 00:03:59', '2024-11-04 00:03:59', NULL),
	(64, 4, '143.44.145.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '2024-11-04 08:06:51', '2024-11-04 00:06:51', '2024-11-04 00:06:51', NULL);

-- Dumping structure for table db_attendance_monitoring.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_04_12_084029_table_students', 1),
	(6, '2024_04_12_084034_table_logs', 1),
	(7, '2024_04_12_084040_table_text_logs', 1),
	(8, '2024_04_13_080624_sms_apis', 1),
	(9, '2024_09_16_140758_create_login_logs_table', 1),
	(10, '2024_09_16_141923_add_logout_time_to_login_logs_table', 1),
	(11, '2024_09_16_142245_add_last_active_to_users_table', 1),
	(12, '2024_09_28_024504_create_subject_table', 1),
	(13, '2024_09_28_083742_create_subject_logs_table', 1);

-- Dumping structure for table db_attendance_monitoring.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db_attendance_monitoring.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table db_attendance_monitoring.sms_apis
CREATE TABLE IF NOT EXISTS `sms_apis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `api` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.sms_apis: ~0 rows (approximately)
INSERT INTO `sms_apis` (`id`, `api`, `account_id`, `account_name`, `status`, `credit_balance`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'c1d909607695c49ac323271b916f864d', '37823', 'Landogz Web Solutions', 'Active', '957', 'Active', '2024-09-29 10:37:46', '2024-09-29 10:55:35');

-- Dumping structure for table db_attendance_monitoring.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Student_Number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Parent_Name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Parent_Number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.students: ~38 rows (approximately)
INSERT INTO `students` (`id`, `Student_Number`, `Name`, `Parent_Name`, `Email`, `Parent_Number`, `Grade`, `Address`, `Image`, `created_at`, `updated_at`) VALUES
	(5, '21-1-3405', 'Carbonell, Mark Jordan M.', 'Mr. Carbonell', 'markjordan@gmail.com', '09674579506', '7', 'Sta. Cruz', '1727805137.png', '2024-10-01 09:52:17', '2024-10-01 20:42:11'),
	(6, '21-1-1324', 'Pantaleon Marc Yvan', 'Ms. Pantaleon', 'marcyvan@gmail.com', '09567155803', '8', 'Candelaria', '1727805351.png', '2024-10-01 09:55:51', '2024-10-01 09:55:51'),
	(7, '21-1-1442', 'Arandia, Jerick C.', 'Mr. Arandia', 'jerick@gmail.com', '09939246497', '10', 'Botolan', '1727805552.png', '2024-10-01 09:59:12', '2024-10-01 09:59:12'),
	(44, '21-1-2652', 'Busa, Joevanie II V.', 'Ms. Busa', 'joevaniebusa@gmail.com', '09318598861', '9', 'Olongapo City', '1727845555.png', '2024-10-01 21:05:56', '2024-10-01 21:05:56'),
	(45, '21-1-1443', 'Delacruz, Juan C.', 'Mr. Delacruz', 'juan@gmail.com', '09567155803', '8', 'Iba', '1728004307.webp', '2024-10-01 21:07:51', '2024-10-03 17:11:47'),
	(46, '21-1-1452', 'Dean, Roco', 'Mr. Dean', 'roco@gmail.com', '09674579506', '7', 'Iba', '1728004079.jpg', '2024-10-01 21:09:58', '2024-10-03 17:07:59'),
	(47, '21-1-3342', 'Whitehead, Aaron', 'Ms. Whitehead', 'aaron@gmail.com', '09939246497', '10', 'Iba', '1728005218.webp', '2024-10-01 21:13:21', '2024-10-03 17:26:58'),
	(48, '21-1-4423', 'Lamb, Inaya', 'Mr. Lamb', 'inaya@gmail.com', '09674579506', '7', 'Palauig', '1728004105.jpg', '2024-10-01 21:14:29', '2024-10-03 17:08:25'),
	(49, '21-1-4424', 'Durham, Mathew', 'Ms. Durham', 'mathew@gmail.com', '09939246497', '10', 'Cabangan', '1728005237.jpg', '2024-10-01 21:15:45', '2024-10-03 17:27:17'),
	(50, '21-1-1465', 'Pierce, Stephen', 'Mr. Pierce', 'stephen@gmail.com', '09567155803', '8', 'Candelaria', '1728004328.jpg', '2024-10-01 21:16:39', '2024-10-03 17:12:08'),
	(51, '21-3-6266', 'Nielsen, Omar', 'Ms. Nielsen', 'omar@gmail.com', '09674579506', '7', 'MANILA', '1728004062.jpg', '2024-10-01 21:59:34', '2024-10-03 17:07:42'),
	(52, '26-1-6262', 'Garrison, Allisa', 'Mr. Garrison', 'allisa@gmail.com', '09318598861', '9', 'london', '1728004542.jpeg', '2024-10-01 22:02:22', '2024-10-03 17:15:42'),
	(53, '23-1-1232', 'Pole, Jordan', 'jords', 'jordanp@gmail.com', '09674579506', '7', 'CANDELARIA', '1727849359.png', '2024-10-01 22:09:19', '2024-10-03 17:09:47'),
	(54, '23-4-3346', 'Santiago, Rohan', 'Mr. Santiago', 'rohan@gmail.com', '09567155803', '8', 'IBA', '1728004368.jpg', '2024-10-01 22:13:14', '2024-10-03 17:12:48'),
	(55, '23-8-5639', 'Parker, Katrina', 'Mr. Parker', 'katrina@gmail.com', '09318598861', '9', 'gapo', '1728004580.jpg', '2024-10-01 22:14:51', '2024-10-03 17:16:20'),
	(56, '73-8-6873', 'Monkey, Luffy', 'Mr. Dragon', 'luffy@gmail.com', '09939246497', '10', 'davao', '1728004802.webp', '2024-10-01 22:17:29', '2024-10-03 17:21:17'),
	(57, '21-2-2344', 'Magalona, Francis', 'francis M', 'francis@gmail.com', '09674579506', '7', 'iba', '1727850487.png', '2024-10-01 22:28:07', '2024-10-03 17:09:19'),
	(58, '21-2-4444', 'Bowen, Ismaeel', 'Mr. Bowen', 'ismaeel@gmail.com', '09567155803', '8', 'San Felipe', '1727850583.png', '2024-10-01 22:29:43', '2024-10-03 17:15:06'),
	(59, '21-1-2342', 'Doncic, Looka', 'Ms. Doncic', 'lookaa@gmail.com', '09318598861', '9', 'Cabangan', '1727850641.png', '2024-10-01 22:30:41', '2024-10-03 17:16:48'),
	(60, '21-2-3445', 'Tado, Tharan', 'Mr. Tado', 'tharan@gmail.com', '09318598861', '9', 'San Antonio', '1727850715.png', '2024-10-01 22:31:55', '2024-10-03 17:17:12'),
	(61, '23-1-1441', 'Bright, Chris', 'Ms. Bright', 'chris@gmail.com', '09567155803', '8', 'Palauig', '1727850897.png', '2024-10-01 22:34:57', '2024-10-03 17:14:29'),
	(62, '23-3-1145', 'David, Amir', 'pala', 'amir@gmail.com', '09318598861', '9', 'Masinloc', '1727850947.png', '2024-10-01 22:35:47', '2024-10-03 17:17:54'),
	(63, '21-4-4432', 'Portgas, Ace', 'Mr. Gol', 'ace@gmail.com', '09939246497', '10', 'Cabangan', '1728004843.jpg', '2024-10-01 22:36:48', '2024-10-03 17:20:43'),
	(64, '23-2-2213', 'Midoriya, Izuku', 'Ms. Midoriya', 'izuku@gmail.com', '09939246497', '10', 'Sta. Cruz', '1728004919.avif', '2024-10-01 22:37:43', '2024-10-03 17:21:59'),
	(65, '23-3-1134', 'Domingo, Christian', 'Mr. Domingo', 'christian@gmail.com', '09674579506', '7', 'Sta. Cruz', '1727926343.png', '2024-10-02 19:32:24', '2024-10-02 19:32:24'),
	(66, '21-2-3323', 'Brenio, John Vincent', 'mr brenio', 'incent@gmail.com', '09674579506', '7', 'sabang', '1727929418.png', '2024-10-02 20:23:39', '2024-10-03 17:10:18'),
	(67, '21-3-4432', 'Aldea, Julian', 'mr aldea', 'aldea@gmail.com', '09674579506', '7', 'Iba', '1727929496.png', '2024-10-02 20:24:56', '2024-10-03 17:10:52'),
	(68, '21-7-8765', 'Amiel, Rovince', 'mr amiel', 'amil@gmail.com', '09674579506', '7', 'Botolan', '1727929558.png', '2024-10-02 20:25:58', '2024-10-03 17:11:15'),
	(69, '21-2-1245', 'Belliocelo, Banjo', 'mr. Belliocelo', 'banjo@gmail.om', '09674579506', '8', 'Cabangan', '1727929620.png', '2024-10-02 20:27:00', '2024-10-03 17:13:55'),
	(70, '21-3-3322', 'Forger, Anya', 'Mr. Forger', 'anya@gmail.com', '09939246497', '10', 'Sta. Cruz', '1728004963.jpg', '2024-10-02 20:30:10', '2024-10-03 17:22:43'),
	(71, '22-1-1221', 'Sin, Meliodas', 'Ms. Sin', 'meliodas@gmail.com', '09939246497', '10', 'Sta. Cruz', '1728005108.jpg', '2024-10-02 20:31:22', '2024-10-03 17:25:08'),
	(72, '21-2-3343', 'Kamado, Tanjiro', 'Mr. Tamado', 'tanjiro@gmail.com', '09939246497', '10', 'Palauig', '1728005193.jpg', '2024-10-02 20:32:42', '2024-10-03 17:26:33'),
	(73, '21-2-2221', 'Romio, Terence', 'Ms. Romio', 'terence@gmail.com', '09567155803', '8', 'Palauig', '1727930052.png', '2024-10-02 20:34:12', '2024-10-03 17:13:23'),
	(74, '23-1-1442', 'Katori, Yuutarou', 'Ms. Katori', 'yuutarou@gmail.com', '09674579506', '8', 'Botolan', '1728005968.jpg', '2024-10-03 17:39:28', '2024-10-03 17:39:51'),
	(75, '23-1-3424', 'OPM, Saitama', 'Ms. OPM', 'saitama@gmail.com', '09674579506', '8', 'Olongapo City', '1728006039.jpg', '2024-10-03 17:40:39', '2024-10-03 17:40:39'),
	(76, '23-3-1441', 'Uchiha, Sasuke', 'Mr. Uchiha', 'sasuke@gmail.com', '09318598861', '9', 'Botolan', '1728006393.jpg', '2024-10-03 17:46:33', '2024-10-03 17:46:33'),
	(77, '23-1-4423', 'Tentacles, Squidward', 'Ms. Tentacles', 'squidward@gmail.com', '09318598861', '9', 'Bikini Bottom', '1728006468.jpg', '2024-10-03 17:47:48', '2024-10-03 17:47:48'),
	(78, '23-1-4421', 'Chan, Jackie', 'Ms. Chan', 'jackie@gmail.com', '09318598861', '9', 'Palauig', '1728006515.gif', '2024-10-03 17:48:35', '2024-10-03 17:48:35'),
	(79, '21-3-4141', 'Sakata, Gintoki', 'Mr. Sakata', 'gintoki@gmail.com', '09318598861', '9', 'San Felipe', '1728006592.jpg', '2024-10-03 17:49:52', '2024-10-03 17:49:52'),
	(80, '23-1-4414', 'Tendou, Akira', 'Ms. Tendou', 'akira@gmail.com', '09939246497', '10', 'Castillejos', '1728006660.jpg', '2024-10-03 17:51:00', '2024-10-03 17:51:00'),
	(81, '23-1-3342', 'Jordan Malakas', 'jord', 'malakas@gmail.com', '09674579506', '7', 'Iba', '1728360138.png', '2024-10-07 20:02:18', '2024-10-07 20:02:18');

-- Dumping structure for table db_attendance_monitoring.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Subject_Name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `Grade` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.subject: ~7 rows (approximately)
INSERT INTO `subject` (`id`, `Subject_Name`, `start_time`, `end_time`, `Grade`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'TLE', '07:30:00', '08:30:00', 10, 2, '2024-09-29 10:53:19', '2024-10-02 19:21:06'),
	(2, 'Science', '09:00:00', '10:00:00', 10, 2, '2024-09-29 17:30:01', '2024-09-29 17:30:01'),
	(3, 'Math', '09:00:00', '10:00:00', 7, 4, '2024-09-29 19:08:32', '2024-09-29 19:08:32'),
	(4, 'English 7', '11:00:00', '12:00:00', 7, 4, '2024-10-02 19:13:11', '2024-10-02 19:13:11'),
	(5, 'Filipino', '09:00:00', '10:00:00', 8, 5, '2024-10-02 19:16:29', '2024-10-02 19:16:29'),
	(6, 'ESP', '11:00:00', '12:00:00', 8, 5, '2024-10-02 19:16:42', '2024-10-02 19:16:42'),
	(7, 'Gen Ad', '09:00:00', '10:00:00', 9, 6, '2024-10-02 19:17:52', '2024-10-02 19:17:52'),
	(8, 'MAPEH', '11:00:00', '12:00:00', 9, 6, '2024-10-02 19:18:06', '2024-10-02 19:18:06');

-- Dumping structure for table db_attendance_monitoring.subject_logs
CREATE TABLE IF NOT EXISTS `subject_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `In` time DEFAULT NULL,
  `Out` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.subject_logs: ~25 rows (approximately)
INSERT INTO `subject_logs` (`id`, `subject_id`, `student_id`, `Date`, `In`, `Out`, `created_at`, `updated_at`) VALUES
	(2, 3, 2, '2024-09-30', '11:09:43', NULL, '2024-09-29 19:09:43', '2024-09-29 19:09:43'),
	(4, 1, 4, '2024-10-02', '12:46:55', '13:00:06', '2024-10-01 20:46:55', '2024-10-01 21:00:06'),
	(5, 1, 5, '2024-10-02', '12:47:23', '15:49:12', '2024-10-01 20:47:23', '2024-10-01 23:49:12'),
	(6, 2, 5, '2024-10-02', '12:48:31', NULL, '2024-10-01 20:48:31', '2024-10-01 20:48:31'),
	(7, 2, 4, '2024-10-02', '12:49:42', '13:01:14', '2024-10-01 20:49:42', '2024-10-01 21:01:14'),
	(8, 1, 6, '2024-10-02', '12:51:34', '15:49:55', '2024-10-01 20:51:34', '2024-10-01 23:49:55'),
	(10, 2, 6, '2024-10-02', '12:56:34', NULL, '2024-10-01 20:56:34', '2024-10-01 20:56:34'),
	(11, 1, 51, '2024-10-02', '14:04:55', '14:05:40', '2024-10-01 22:04:55', '2024-10-01 22:05:40'),
	(12, 1, 52, '2024-10-02', '14:05:03', '14:05:11', '2024-10-01 22:05:03', '2024-10-01 22:05:11'),
	(13, 1, 44, '2024-10-02', '14:06:14', '15:48:47', '2024-10-01 22:06:14', '2024-10-01 23:48:47'),
	(14, 1, 53, '2024-10-02', '14:20:50', '14:21:01', '2024-10-01 22:20:50', '2024-10-01 22:21:01'),
	(15, 1, 56, '2024-10-02', '14:22:07', NULL, '2024-10-01 22:22:07', '2024-10-01 22:22:07'),
	(16, 1, 7, '2024-10-02', '15:49:33', NULL, '2024-10-01 23:49:33', '2024-10-01 23:49:33'),
	(17, 1, 62, '2024-10-03', '11:08:41', '11:09:02', '2024-10-02 19:08:41', '2024-10-02 19:09:02'),
	(18, 1, 47, '2024-10-03', '11:08:44', '11:09:05', '2024-10-02 19:08:44', '2024-10-02 19:09:05'),
	(19, 1, 6, '2024-10-03', '11:08:45', '11:09:11', '2024-10-02 19:08:45', '2024-10-02 19:09:11'),
	(20, 4, 46, '2024-10-03', '11:13:28', '11:13:36', '2024-10-02 19:13:28', '2024-10-02 19:13:36'),
	(21, 6, 6, '2024-10-03', '11:16:52', '11:17:03', '2024-10-02 19:16:52', '2024-10-02 19:17:03'),
	(22, 7, 62, '2024-10-03', '11:19:53', '11:19:58', '2024-10-02 19:19:53', '2024-10-02 19:19:58'),
	(23, 3, 5, '2024-10-03', '15:33:40', NULL, '2024-10-02 23:33:40', '2024-10-02 23:33:40'),
	(24, 4, 5, '2024-10-07', '13:08:40', '13:08:58', '2024-10-06 21:08:40', '2024-10-06 21:08:58'),
	(25, 3, 53, '2024-10-07', '13:15:04', '13:15:41', '2024-10-06 21:15:04', '2024-10-06 21:15:41'),
	(26, 3, 66, '2024-10-07', '13:25:19', '13:25:52', '2024-10-06 21:25:19', '2024-10-06 21:25:52'),
	(27, 3, 68, '2024-10-07', '13:36:39', '13:37:14', '2024-10-06 21:36:39', '2024-10-06 21:37:14'),
	(28, 3, 57, '2024-10-07', '13:53:40', '13:54:10', '2024-10-06 21:53:40', '2024-10-06 21:54:10'),
	(29, 4, 48, '2024-10-07', '14:07:46', NULL, '2024-10-06 22:07:46', '2024-10-06 22:07:46'),
	(30, 4, 81, '2024-10-08', '12:03:46', '12:04:10', '2024-10-07 20:03:46', '2024-10-07 20:04:10'),
	(31, 3, 48, '2024-10-08', '13:11:08', '13:12:09', '2024-10-07 21:11:08', '2024-10-07 21:12:09'),
	(32, 3, 48, '2024-10-08', '13:11:08', NULL, '2024-10-07 21:11:08', '2024-10-07 21:11:08'),
	(33, 3, 67, '2024-10-08', '13:11:35', NULL, '2024-10-07 21:11:35', '2024-10-07 21:11:35');

-- Dumping structure for table db_attendance_monitoring.table_logs
CREATE TABLE IF NOT EXISTS `table_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Student_ID` int DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `AM_in` time DEFAULT NULL,
  `AM_out` time DEFAULT NULL,
  `PM_in` time DEFAULT NULL,
  `PM_out` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.table_logs: ~34 rows (approximately)
INSERT INTO `table_logs` (`id`, `Student_ID`, `Date`, `AM_in`, `AM_out`, `PM_in`, `PM_out`, `created_at`, `updated_at`) VALUES
	(1, 1, '2024-09-29', '02:55:42', '02:58:02', NULL, NULL, '2024-09-29 10:55:42', '2024-09-29 10:58:02'),
	(2, 2, '2024-09-30', '11:10:25', NULL, NULL, NULL, '2024-09-29 19:10:25', '2024-09-29 19:10:25'),
	(3, 3, '2024-09-30', NULL, NULL, '12:29:44', NULL, '2024-09-29 20:29:44', '2024-09-29 20:29:44'),
	(4, 4, '2024-10-01', '06:43:25', NULL, NULL, NULL, '2024-10-01 14:43:25', '2024-10-01 14:43:25'),
	(5, 4, '2024-10-02', NULL, NULL, '12:23:19', '12:24:26', '2024-10-01 20:23:20', '2024-10-01 20:24:26'),
	(6, 5, '2024-10-02', NULL, NULL, '12:25:52', '12:44:14', '2024-10-01 20:25:52', '2024-10-01 20:44:14'),
	(7, 7, '2024-10-02', NULL, NULL, NULL, '12:59:13', '2024-10-01 20:59:13', '2024-10-01 20:59:13'),
	(8, 50, '2024-10-02', NULL, NULL, '13:20:44', '13:23:30', '2024-10-01 21:20:44', '2024-10-01 21:23:30'),
	(9, 48, '2024-10-02', NULL, NULL, '13:22:20', NULL, '2024-10-01 21:22:20', '2024-10-01 21:22:20'),
	(10, 47, '2024-10-02', NULL, NULL, '13:23:07', NULL, '2024-10-01 21:23:07', '2024-10-01 21:23:07'),
	(11, 51, '2024-10-02', NULL, NULL, '14:00:23', '14:03:06', '2024-10-01 22:00:23', '2024-10-01 22:03:06'),
	(12, 52, '2024-10-02', NULL, NULL, '14:02:43', '14:03:03', '2024-10-01 22:02:43', '2024-10-01 22:03:03'),
	(13, 53, '2024-10-02', NULL, NULL, '14:09:57', '14:10:35', '2024-10-01 22:09:57', '2024-10-01 22:10:35'),
	(14, 55, '2024-10-02', NULL, NULL, '14:15:15', '14:15:27', '2024-10-01 22:15:15', '2024-10-01 22:15:27'),
	(15, 56, '2024-10-02', NULL, NULL, '14:17:58', '14:18:06', '2024-10-01 22:17:58', '2024-10-01 22:18:06'),
	(16, 59, '2024-10-02', NULL, NULL, '14:31:03', NULL, '2024-10-01 22:31:03', '2024-10-01 22:31:03'),
	(17, 62, '2024-10-03', '11:05:48', '11:06:49', '15:29:39', NULL, '2024-10-02 19:05:48', '2024-10-02 23:29:39'),
	(18, 6, '2024-10-03', '11:06:00', '11:07:08', NULL, NULL, '2024-10-02 19:06:00', '2024-10-02 19:07:08'),
	(19, 47, '2024-10-03', '11:06:20', '11:07:14', NULL, NULL, '2024-10-02 19:06:20', '2024-10-02 19:07:14'),
	(20, 64, '2024-10-03', '11:19:14', NULL, NULL, NULL, '2024-10-02 19:19:14', '2024-10-02 19:19:14'),
	(21, 65, '2024-10-03', '11:32:54', '11:33:06', NULL, NULL, '2024-10-02 19:32:54', '2024-10-02 19:33:06'),
	(22, 59, '2024-10-03', NULL, NULL, '15:30:51', NULL, '2024-10-02 23:30:51', '2024-10-02 23:30:51'),
	(23, 53, '2024-10-07', NULL, NULL, '13:16:23', '13:16:38', '2024-10-06 21:16:24', '2024-10-06 21:16:38'),
	(24, 66, '2024-10-07', NULL, NULL, '13:26:34', '13:26:18', '2024-10-06 21:26:18', '2024-10-06 21:26:34'),
	(25, 68, '2024-10-07', NULL, NULL, '13:37:39', NULL, '2024-10-06 21:37:39', '2024-10-06 21:37:39'),
	(26, 57, '2024-10-07', NULL, NULL, '13:54:37', NULL, '2024-10-06 21:54:37', '2024-10-06 21:54:37'),
	(27, 48, '2024-10-07', NULL, NULL, '14:06:40', '14:07:14', '2024-10-06 22:06:40', '2024-10-06 22:07:14'),
	(28, 76, '2024-10-07', '07:05:32', '07:10:22', NULL, NULL, '2024-10-07 15:05:32', '2024-10-07 15:10:22'),
	(29, 81, '2024-10-08', NULL, NULL, '12:02:49', '12:03:20', '2024-10-07 20:02:49', '2024-10-07 20:03:20'),
	(30, 5, '2024-10-08', NULL, NULL, '13:23:50', NULL, '2024-10-07 21:23:50', '2024-10-07 21:23:50'),
	(31, 7, '2024-10-08', NULL, NULL, '13:24:04', NULL, '2024-10-07 21:24:04', '2024-10-07 21:24:04'),
	(32, 44, '2024-10-08', NULL, NULL, '13:24:07', NULL, '2024-10-07 21:24:07', '2024-10-07 21:24:07'),
	(33, 6, '2024-10-08', NULL, NULL, '13:24:09', NULL, '2024-10-07 21:24:09', '2024-10-07 21:24:09'),
	(34, 72, '2024-10-08', NULL, NULL, '13:27:13', NULL, '2024-10-07 21:27:13', '2024-10-07 21:27:13'),
	(35, 51, '2024-10-08', NULL, NULL, '13:27:14', NULL, '2024-10-07 21:27:14', '2024-10-07 21:27:14'),
	(36, 70, '2024-10-08', NULL, NULL, '13:28:06', NULL, '2024-10-07 21:28:06', '2024-10-07 21:28:06'),
	(37, 46, '2024-10-08', NULL, NULL, '13:28:08', NULL, '2024-10-07 21:28:08', '2024-10-07 21:28:08');

-- Dumping structure for table db_attendance_monitoring.table_text_logs
CREATE TABLE IF NOT EXISTS `table_text_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Student_ID` int DEFAULT NULL,
  `Message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.table_text_logs: ~0 rows (approximately)

-- Dumping structure for table db_attendance_monitoring.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `Grade` int DEFAULT NULL,
  `privilege` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Administrator',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_active` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_attendance_monitoring.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `Grade`, `privilege`, `password`, `remember_token`, `created_at`, `updated_at`, `last_active`) VALUES
	(1, 'Test User', 'admin@gmail.com', '2024-09-29 10:37:46', NULL, 'Administrator', '$2y$12$r5GoBXSl50qoQkrMRwohfORERh7F3AvEwUauLRI9CjnXqOqCJaoke', '1l0v4f8VlwYAbxNt1uaT0zvtvyu6CQzK7K1QfBeUkeNcOC6XyRJEaMLmATex', '2024-09-29 10:37:46', '2024-11-04 00:06:43', '2024-11-04 00:06:43'),
	(2, 'Jerick', 'jerick@gmail.com', '2024-09-29 10:37:46', 10, 'Teacher', '$2y$12$g1JKC3czUQgIZFUpcQzad.N0DS4mfmyqqXOar6OXaTdHvycBs88nW', 'IVaaIjD71LEybkwDU8DhbkyYyr80Ok7ZmXjlOaksD8t0AseahreAJ2x4r629', '2024-09-29 10:37:46', '2024-10-02 19:22:18', '2024-10-02 19:21:12'),
	(4, 'jordan', 'jordan@gmail.com', NULL, 7, 'Teacher', '$2y$12$Wdqb/FEbMBMv68eNZq7gwegKWBayX4fQnYDFcB1NnQ5RShlpuXphK', NULL, '2024-09-29 19:07:28', '2024-10-07 21:19:20', '2024-10-07 21:19:20'),
	(5, 'Yvan', 'yvan@gmail.com', NULL, 8, 'Teacher', '$2y$12$1mosEOqFwznWe8zGlLQhke6dw2L7p0lHaKu6w7LredC2Yec/K2I9i', NULL, '2024-10-02 19:10:37', '2024-10-02 19:17:14', '2024-10-02 19:17:14'),
	(6, 'joevanie', 'joevanie@gmail.com', NULL, 9, 'Teacher', '$2y$12$W6hdVfwMmceMcelZf1pXde/U94P7oAFWb/fWO57hkGMmy0TmR0jSi', NULL, '2024-10-02 19:11:12', '2024-10-02 19:22:04', '2024-10-02 19:20:26');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
