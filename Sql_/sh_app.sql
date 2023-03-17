-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table sch_project_app.all_sessions
CREATE TABLE IF NOT EXISTS `all_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.all_sessions: ~7 rows (approximately)
INSERT INTO `all_sessions` (`id`, `name`) VALUES
	(3, '2020/2021'),
	(4, '2021/2022'),
	(5, '2022/2023'),
	(6, '2023/2024'),
	(7, '2024/2025'),
	(8, '2025/2026'),
	(9, '2026/2027');

-- Dumping structure for table sch_project_app.all_terms
CREATE TABLE IF NOT EXISTS `all_terms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.all_terms: ~3 rows (approximately)
INSERT INTO `all_terms` (`id`, `name`) VALUES
	(5, 'First Term'),
	(6, 'Second Term'),
	(7, 'Third Term');

-- Dumping structure for table sch_project_app.arms
CREATE TABLE IF NOT EXISTS `arms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.arms: ~5 rows (approximately)
INSERT INTO `arms` (`id`, `school_id`, `name`, `created_at`, `updated_at`) VALUES
	(48, 3, 'Blue-bell', '2022-01-13 09:11:10', '2022-01-13 09:11:10'),
	(50, 3, 'Canalily', '2022-01-13 09:12:58', '2022-01-13 09:12:58'),
	(51, 3, 'Lantana', '2022-01-13 09:13:33', '2022-01-13 09:13:33'),
	(53, 3, 'Carnation', '2022-01-13 09:14:10', '2022-01-13 09:14:10'),
	(54, 3, 'Hibiscus', '2022-01-13 09:14:26', '2022-01-13 09:14:26');

-- Dumping structure for table sch_project_app.class_final_results
CREATE TABLE IF NOT EXISTS `class_final_results` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) DEFAULT NULL,
  `student_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_score` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_students` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_subjects` int(11) DEFAULT 0,
  `average_score` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_comment` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teachers_comment` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_attendance` tinyint(4) NOT NULL DEFAULT 1,
  `show_class_position` tinyint(4) NOT NULL DEFAULT 0,
  `show_student_portal_id` tinyint(4) NOT NULL DEFAULT 1,
  `admin_custom_comment` tinyint(4) NOT NULL DEFAULT 0,
  `teacher_custom_comment` tinyint(4) NOT NULL DEFAULT 0,
  `promoted` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.class_final_results: ~2 rows (approximately)
INSERT INTO `class_final_results` (`id`, `school_id`, `student_id`, `term`, `sessions`, `classes`, `arms`, `total_score`, `total_students`, `total_subjects`, `average_score`, `class_position`, `principal_comment`, `teachers_comment`, `show_attendance`, `show_class_position`, `show_student_portal_id`, `admin_custom_comment`, `teacher_custom_comment`, `promoted`, `created_at`, `updated_at`) VALUES
	(73, 3, '20219', 'Second Term', '2021/2022', 'Sss 2', NULL, '99.00', '2', 1, '99.00', '1st', 'Satisfactory', NULL, 1, 0, 1, 0, 0, 0, '2022-09-23 08:36:24', '2022-09-23 08:36:24'),
	(74, 3, '20220', 'Second Term', '2021/2022', 'Sss 2', NULL, '320.00', '2', 4, '80.00', '2nd', 'Satisfactory', NULL, 1, 0, 1, 0, 0, 0, '2022-09-23 08:36:24', '2022-09-23 08:36:24');

-- Dumping structure for table sch_project_app.fee_allocations
CREATE TABLE IF NOT EXISTS `fee_allocations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fee_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_type_item` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(30,2) DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.fee_allocations: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.fee_discounts
CREATE TABLE IF NOT EXISTS `fee_discounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `student_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `classes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(30,2) DEFAULT NULL,
  `fee_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.fee_discounts: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.fee_expenses
CREATE TABLE IF NOT EXISTS `fee_expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(30,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.fee_expenses: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.fee_net_revenues
CREATE TABLE IF NOT EXISTS `fee_net_revenues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) NOT NULL,
  `total_revenue` decimal(30,2) DEFAULT 0.00,
  `total_expenses` decimal(30,2) DEFAULT 0.00,
  `net_revenue` decimal(30,2) DEFAULT 0.00,
  `term` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.fee_net_revenues: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.fee_revenues
CREATE TABLE IF NOT EXISTS `fee_revenues` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` bigint(20) NOT NULL,
  `student_id` bigint(20) DEFAULT NULL,
  `student_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_amount` decimal(30,2) DEFAULT NULL,
  `amount_due` decimal(30,2) DEFAULT NULL,
  `amount_paid` decimal(30,2) DEFAULT NULL,
  `updated_amount` decimal(30,2) DEFAULT NULL,
  `discount_amount` decimal(30,2) DEFAULT NULL,
  `balance` decimal(30,2) DEFAULT NULL,
  `classes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_mode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_status` tinyint(4) DEFAULT 0,
  `balance_updated` tinyint(4) DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ref_no` (`ref_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.fee_revenues: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.fee_transaction_balances
CREATE TABLE IF NOT EXISTS `fee_transaction_balances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `fee_revenue_id` bigint(20) unsigned NOT NULL,
  `new_amount_paid` decimal(30,2) unsigned DEFAULT NULL,
  `initial_amount_paid` decimal(30,2) unsigned DEFAULT NULL,
  `balance` decimal(30,2) unsigned DEFAULT NULL,
  `received_by` varchar(191) DEFAULT NULL,
  `payment_mode` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sch_project_app.fee_transaction_balances: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.fee_types
CREATE TABLE IF NOT EXISTS `fee_types` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.fee_types: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.fee_type_items
CREATE TABLE IF NOT EXISTS `fee_type_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `fee_type` varchar(191) NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sch_project_app.fee_type_items: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.form_teachers
CREATE TABLE IF NOT EXISTS `form_teachers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.form_teachers: ~2 rows (approximately)
INSERT INTO `form_teachers` (`id`, `school_id`, `user_id`, `name`, `classes`, `arms`, `created_at`, `updated_at`) VALUES
	(1, 3, 20218, 'Admin Chidi', 'Sss 2', NULL, '2022-09-21 11:49:54', '2022-09-21 11:49:54'),
	(2, 3, 20209, 'Sub Admin', 'Jss 2', NULL, '2022-09-21 12:25:38', '2022-09-21 12:25:38');

-- Dumping structure for table sch_project_app.grades
CREATE TABLE IF NOT EXISTS `grades` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grade` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_score` decimal(10,2) DEFAULT NULL,
  `max_score` decimal(10,2) DEFAULT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.grades: ~6 rows (approximately)
INSERT INTO `grades` (`id`, `grade`, `min_score`, `max_score`, `comment`, `school_id`, `created_at`, `updated_at`) VALUES
	(3, 'A', 80.00, 100.00, 'Excellent', 3, '2021-02-27 19:42:54', '2021-02-27 19:42:54'),
	(4, 'B', 60.00, 79.00, 'V.GOOD', 3, '2021-02-27 19:43:12', '2021-02-27 19:43:12'),
	(6, 'D', 45.00, 49.00, 'PASS', 3, '2021-02-27 19:44:27', '2021-02-27 19:44:27'),
	(7, 'E', 40.00, 44.00, 'FAIR', 3, '2021-02-27 19:45:02', '2021-02-27 19:45:02'),
	(8, 'F', 0.00, 39.00, 'FAIL', 3, '2021-02-27 19:45:18', '2021-02-27 19:45:18'),
	(10, 'C', 50.00, 59.00, 'CREDIT', 3, '2021-05-21 23:09:21', '2021-05-21 23:09:21');

-- Dumping structure for table sch_project_app.schools
CREATE TABLE IF NOT EXISTS `schools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result_template` tinyint(4) DEFAULT 1,
  `lga` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(10) unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.schools: ~1 rows (approximately)
INSERT INTO `schools` (`id`, `name`, `type`, `email`, `logo`, `motto`, `website`, `address`, `phone`, `result_template`, `lga`, `state`, `country`, `sms_link`, `sms_password`, `sms_username`, `created_by`, `active`, `created_at`, `updated_at`) VALUES
	(3, 'Reality Model School', 'Secondary', 'realityngu@gmail.com', NULL, 'Education is the Light of Life', 'www.realityngu.ng', 'Low-Cost Estate, Nguru, Yobe State', '08065480460', 1, 'Nguru', 'Yobe State', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);

-- Dumping structure for table sch_project_app.sch_classes
CREATE TABLE IF NOT EXISTS `sch_classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sch_classes_schools_id_index` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.sch_classes: ~14 rows (approximately)
INSERT INTO `sch_classes` (`id`, `school_id`, `name`, `created_at`, `updated_at`) VALUES
	(8, 3, 'Sss 1', '2022-01-13 09:14:56', '2022-01-13 09:14:56'),
	(9, 3, 'Sss 2', '2022-01-13 09:15:10', '2022-01-13 09:15:10'),
	(10, 3, 'Sss 3', '2022-01-13 09:15:24', '2022-01-13 09:15:24'),
	(11, 3, 'Jss 1', '2022-01-13 09:15:43', '2022-01-13 09:15:43'),
	(12, 3, 'Jss 2', '2022-01-13 09:15:57', '2022-01-13 09:15:57'),
	(13, 3, 'Jss 3', '2022-01-13 09:16:09', '2022-01-13 09:16:09'),
	(14, 3, 'Pre-nursery', '2022-01-13 09:17:54', '2022-01-13 09:17:54'),
	(15, 3, 'Nursery 1', '2022-01-13 09:18:08', '2022-01-13 09:18:08'),
	(16, 3, 'Nursery 2', '2022-01-13 09:18:22', '2022-01-13 09:18:22'),
	(17, 3, 'Primary 1', '2022-01-13 09:18:36', '2022-01-13 09:18:36'),
	(18, 3, 'Primary 2', '2022-01-13 09:18:50', '2022-01-13 09:18:50'),
	(19, 3, 'Primary 3', '2022-01-13 09:19:04', '2022-01-13 09:19:04'),
	(20, 3, 'Primary 4', '2022-01-13 09:19:18', '2022-01-13 09:19:18'),
	(21, 3, 'Primary 5', '2022-01-13 09:19:32', '2022-01-13 09:19:32');

-- Dumping structure for table sch_project_app.sch_sessions
CREATE TABLE IF NOT EXISTS `sch_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(10) DEFAULT 0,
  `result_published` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.sch_sessions: ~1 rows (approximately)
INSERT INTO `sch_sessions` (`id`, `school_id`, `term`, `sessions`, `active`, `result_published`, `created_at`, `updated_at`) VALUES
	(6, 3, 'Second Term', '2021/2022', 1, 0, '2022-01-13 09:00:57', '2022-01-13 09:01:14');

-- Dumping structure for table sch_project_app.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `subject_group_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sch_subjects_schools_id_index` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.subjects: ~5 rows (approximately)
INSERT INTO `subjects` (`id`, `name`, `classes`, `school_id`, `subject_group_id`, `created_at`, `updated_at`) VALUES
	(1, 'Maths', 'Sss 2', 3, NULL, '2022-09-21 12:22:21', '2022-09-21 12:22:21'),
	(2, 'English', 'Sss 2', 3, NULL, '2022-09-21 12:22:32', '2022-09-21 12:22:32'),
	(3, 'Physics', 'Sss 2', 3, NULL, '2022-09-21 12:22:45', '2022-09-21 12:22:45'),
	(4, 'Chemistry', 'Sss 2', 3, NULL, '2022-09-21 12:23:25', '2022-09-21 12:23:25'),
	(5, 'Biology', 'Sss 2', 3, NULL, '2022-09-21 12:23:36', '2022-09-21 12:23:36');

-- Dumping structure for table sch_project_app.subject_results
CREATE TABLE IF NOT EXISTS `subject_results` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) DEFAULT NULL,
  `student_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subjects` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teachers_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field1` decimal(10,2) DEFAULT NULL,
  `field2` decimal(10,2) DEFAULT NULL,
  `field3` decimal(10,2) DEFAULT NULL,
  `field4` decimal(10,2) DEFAULT NULL,
  `exam_score` decimal(10,2) DEFAULT NULL,
  `total_score` decimal(10,2) DEFAULT NULL,
  `class_average` decimal(10,2) DEFAULT NULL,
  `lowest_score` decimal(10,2) DEFAULT NULL,
  `highest_score` decimal(10,2) DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teachers_comment` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_comment` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sch_project_app.subject_results: ~5 rows (approximately)
INSERT INTO `subject_results` (`id`, `school_id`, `student_name`, `student_id`, `classes`, `arms`, `subjects`, `sessions`, `term`, `teachers_name`, `grade`, `comment`, `field1`, `field2`, `field3`, `field4`, `exam_score`, `total_score`, `class_average`, `lowest_score`, `highest_score`, `position`, `teachers_comment`, `custom_comment`, `created_at`, `updated_at`) VALUES
	(3, 3, NULL, '20220', 'Sss 2', NULL, 'English', '2021/2022', 'Second Term', NULL, 'A', 'Excellent', 7.00, 9.00, NULL, NULL, 67.00, 83.00, 83.00, 83.00, 83.00, '1st', NULL, 0, '2022-09-22 05:08:30', '2022-09-23 08:16:25'),
	(4, 3, NULL, '20220', 'Sss 2', NULL, 'Maths', '2021/2022', 'Second Term', NULL, 'A', 'Excellent', 9.00, 15.00, NULL, NULL, 68.00, 92.00, 92.00, 92.00, 92.00, '1st', NULL, 0, '2022-09-22 05:08:43', '2022-09-22 05:08:43'),
	(6, 3, NULL, '20220', 'Sss 2', NULL, 'Chemistry', '2021/2022', 'Second Term', NULL, 'C', 'CREDIT', 10.00, -2.00, NULL, NULL, 50.00, 58.00, 41.00, 24.00, 58.00, '1st', NULL, 0, '2022-09-22 17:13:46', '2022-09-23 08:37:34'),
	(7, 3, NULL, '20220', 'Sss 2', NULL, 'Physics', '2021/2022', 'Second Term', NULL, 'A', 'Excellent', 1.00, 1.00, NULL, NULL, 85.00, 87.00, 87.00, 87.00, 87.00, '1st', NULL, 0, '2022-09-23 08:17:46', '2022-09-23 08:19:22'),
	(8, 3, NULL, '20219', 'Sss 2', NULL, 'Chemistry', '2021/2022', 'Second Term', NULL, 'F', 'FAIL', 1.00, 10.00, NULL, NULL, 13.00, 24.00, 41.00, 24.00, 58.00, '2nd', NULL, 0, '2022-09-23 08:36:22', '2022-09-23 08:37:34');

-- Dumping structure for table sch_project_app.subject_teachers
CREATE TABLE IF NOT EXISTS `subject_teachers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `classes` varchar(191) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `arms` varchar(191) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sch_project_app.subject_teachers: ~0 rows (approximately)

-- Dumping structure for table sch_project_app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `other_name` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `target_class` varchar(50) DEFAULT NULL,
  `target_arm` varchar(50) DEFAULT NULL,
  `target_session` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `parent_name` varchar(250) DEFAULT NULL,
  `parent_phone_number` varchar(250) DEFAULT NULL,
  `religion` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `health_problem` text DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `accountant` tinyint(4) DEFAULT 0,
  `student` tinyint(4) DEFAULT 0,
  `admin` tinyint(4) DEFAULT 0,
  `staff` tinyint(4) DEFAULT 0,
  `sub_admin` tinyint(6) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20222 DEFAULT CHARSET=latin1;

-- Dumping data for table sch_project_app.users: ~7 rows (approximately)
INSERT INTO `users` (`id`, `school_id`, `first_name`, `last_name`, `other_name`, `gender`, `photo`, `email`, `phone`, `target_class`, `target_arm`, `target_session`, `dob`, `password`, `parent_name`, `parent_phone_number`, `religion`, `address`, `health_problem`, `remember_token`, `status`, `accountant`, `student`, `admin`, `staff`, `sub_admin`, `created_at`, `updated_at`, `deleted`) VALUES
	(20206, 3, 'Admin', 'Admin', '', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ariUFi7rosxSmVXN3O53PuKabtwkmmhAuzM3vDKx9jOdprz5/GwNG', NULL, NULL, NULL, NULL, NULL, '8la0YUC2MXrLXi778sjVJxKMSY11uuXCBq58CAVrPWKJ2ZfD1cNB2wlz0qyn', 0, 1, 0, 1, 1, 0, '2022-01-13 09:04:20', '2022-01-14 09:50:56', 0),
	(20207, 3, 'Account', 'Account', '', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$8o/Z3QDn9QpGun0GiNJGoeEBvhM6yTR0bC9oaWREx0O597RNVfnvm', NULL, NULL, NULL, NULL, NULL, 'mFnQv3w2j9YHiNfxgpfGg71BUg3Ui2eaW2koztnJ4z3tf58gPF9lynhF8p0G', 0, 1, 0, 0, 1, 0, '2022-01-13 09:21:42', '2022-01-14 09:48:08', 0),
	(20209, 3, 'Admin', 'Sub', '', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$aqZqgPF6M/bpulyVUl88Jexd7Dl8qkL8OTraX318B9vUEORa1phpK', NULL, NULL, NULL, NULL, NULL, 'wmHk2u8Z0Rnz8OQ48pl31iJBTWYxaSNzOBVCBhJ0Cgkd1KSecGDD4ZDejvII', 0, 0, 0, 0, 1, 1, '2022-01-14 09:43:36', '2022-01-14 09:46:04', 0),
	(20218, 3, 'Chidi', 'Admin', NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$uQLLGGQ9jZJoAlByd0BZV.m11YsTxt8OdO.UxtSLStWiev6KFIfMa', NULL, NULL, NULL, NULL, NULL, 'LwNc3qYjpHuuQmPUyhkvVJkRtH67KSGuZXVSmh06mR2NroqZZ9JulrEdfvzV', 0, 0, 0, 1, 1, 0, '2022-09-21 06:53:47', '2022-09-21 06:53:47', 0),
	(20219, 3, 'Bola', 'Ahmed-amoda', '', 'male', 'qNStk5G5IllUwQfo66ruOegiV_1663761874.jpg', NULL, NULL, 'Sss 2', NULL, '2021/2022', NULL, '$2y$10$.IEBvHtmMYtrPRQuvm233epCt6MW7Lw3/BPcZInErPBvQETyd7QNy', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, '2022-09-21 07:23:41', '2022-09-21 12:24:24', 0),
	(20220, 3, 'Ada', 'Jane', 'Okoli', 'female', '4IKJunIawMev2kp7RBdbyGunT_1663764379.jpg', NULL, NULL, 'Sss 2', NULL, '2021/2022', '2021-12-30', '$2y$10$FBVbX/1iMJTsNf/gloL6l.NUinjJhKcvkRfx6ik2RhQmnY7Cbg3bS', 'mr. chuma', '090899', 'Islam', '67 bode road', 'eye defect', NULL, 0, 0, 1, 0, 0, 0, '2022-09-21 11:19:20', '2022-09-21 12:24:24', 0),
	(20221, 3, 'Jane', 'Doe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$h0tA2cVKh3pe01dOTjAdle/LJHN6Rd2Nx66sIKgINsQCBk/t/88q2', NULL, NULL, NULL, NULL, NULL, 'F7X9TQEz55dL9lryPJQhMlX4h1yWUHXLVeYiktz2JlfAnmY4lXElfqGFYfzX', 0, 0, 0, 1, 1, 0, '2022-09-23 07:16:01', '2022-09-23 07:16:01', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
