-- Adminer 5.2.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_tenant_id_index` (`tenant_id`),
  KEY `activity_logs_user_id_index` (`user_id`),
  KEY `activity_logs_subject_index` (`subject_type`,`subject_id`),
  CONSTRAINT `activity_logs_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branches_tenant_id_index` (`tenant_id`),
  CONSTRAINT `branches_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `branches` (`id`, `tenant_id`, `name`, `address`, `phone`, `is_main`, `created_at`, `updated_at`) VALUES
(3,	3,	'Main Branch',	NULL,	'01700000000',	1,	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(4,	4,	'Main Branch',	NULL,	'01633394589',	1,	'2026-06-06 09:16:08',	'2026-06-06 09:16:08'),
(5,	5,	'Main Branch',	NULL,	'01840208832',	1,	'2026-06-09 11:17:51',	'2026-06-09 11:17:51');

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `cash_transactions`;
CREATE TABLE `cash_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `type` enum('cash_in','cash_out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `reference_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint unsigned DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_transactions_tenant_id_index` (`tenant_id`),
  KEY `cash_transactions_branch_id_index` (`branch_id`),
  KEY `cash_transactions_date_index` (`tenant_id`,`transaction_date`),
  KEY `cash_transactions_reference_index` (`reference_type`,`reference_id`),
  CONSTRAINT `cash_transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_transactions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_tenant_id_index` (`tenant_id`),
  CONSTRAINT `categories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `tenant_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1,	3,	'Rice',	'active',	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(2,	3,	'Oil',	'active',	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(3,	3,	'Biscuit',	'active',	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(4,	3,	'Beverage',	'active',	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(5,	4,	'Grocery',	'active',	'2026-06-06 09:49:36',	'2026-06-06 09:49:36'),
(6,	4,	'Medicines',	'active',	'2026-06-06 09:49:53',	'2026-06-06 09:50:05'),
(7,	5,	'Soap',	'active',	'2026-06-09 11:21:16',	'2026-06-09 11:21:16'),
(8,	5,	'Shampoo',	'active',	'2026-06-09 11:21:43',	'2026-06-09 11:21:43');

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_tenant_id_index` (`tenant_id`),
  KEY `customers_tenant_phone_index` (`tenant_id`,`phone`),
  CONSTRAINT `customers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `customers` (`id`, `tenant_id`, `name`, `phone`, `address`, `due_balance`, `created_at`, `updated_at`) VALUES
(1,	4,	'Rafid',	'01633394589',	NULL,	30.00,	'2026-06-06 10:28:16',	'2026-06-07 11:23:11'),
(2,	4,	'Rehana',	'01678054659',	NULL,	0.00,	'2026-06-06 10:28:30',	'2026-06-06 10:28:30'),
(3,	4,	'tahmeed',	'01633394590',	NULL,	0.00,	'2026-06-06 10:40:31',	'2026-06-06 10:40:31');

DROP TABLE IF EXISTS `damages`;
CREATE TABLE `damages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `type` enum('damage','lost') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'damage',
  `qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `unit_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `damage_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `damages_tenant_id_index` (`tenant_id`),
  KEY `damages_product_id_index` (`product_id`),
  KEY `damages_tenant_date_index` (`tenant_id`,`damage_date`),
  KEY `damages_branch_id_foreign` (`branch_id`),
  CONSTRAINT `damages_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `damages_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `damages_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `due_payments`;
CREATE TABLE `due_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `party_type` enum('customer','supplier') COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `method` enum('cash','bkash','nagad','rocket','bank','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `payment_date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `due_payments_tenant_id_index` (`tenant_id`),
  KEY `due_payments_branch_id_index` (`branch_id`),
  KEY `due_payments_party_index` (`party_type`,`party_id`),
  KEY `due_payments_tenant_date_index` (`tenant_id`,`payment_date`),
  KEY `due_payments_user_id_foreign` (`user_id`),
  CONSTRAINT `due_payments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `due_payments_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `due_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `due_payments` (`id`, `tenant_id`, `branch_id`, `user_id`, `party_type`, `party_id`, `amount`, `method`, `payment_date`, `note`, `created_at`, `updated_at`) VALUES
(1,	4,	4,	4,	'customer',	2,	100.00,	'cash',	'2026-06-07',	NULL,	'2026-06-07 11:22:26',	'2026-06-07 11:22:26'),
(2,	4,	4,	4,	'customer',	1,	5.00,	'cash',	'2026-06-07',	NULL,	'2026-06-07 11:23:11',	'2026-06-07 11:23:11'),
(3,	4,	4,	4,	'supplier',	1,	50.00,	'cash',	'2026-06-07',	NULL,	'2026-06-07 11:25:32',	'2026-06-07 11:25:32');

DROP TABLE IF EXISTS `expense_categories`;
CREATE TABLE `expense_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `expense_categories_tenant_name_unique` (`tenant_id`,`name`),
  KEY `expense_categories_tenant_id_index` (`tenant_id`),
  CONSTRAINT `expense_categories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `expense_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `expense_date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_tenant_id_index` (`tenant_id`),
  KEY `expenses_branch_id_index` (`branch_id`),
  KEY `expenses_expense_category_id_index` (`expense_category_id`),
  KEY `expenses_tenant_date_index` (`tenant_id`,`expense_date`),
  CONSTRAINT `expenses_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `expenses_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `expenses_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('suggestion','bug','complaint','praise','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'suggestion',
  `rating` tinyint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` enum('app','landing') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'app',
  `status` enum('new','reviewed','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedbacks_tenant_id_index` (`tenant_id`),
  KEY `feedbacks_user_id_index` (`user_id`),
  KEY `feedbacks_status_index` (`status`),
  CONSTRAINT `feedbacks_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL,
  CONSTRAINT `feedbacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `feedbacks` (`id`, `tenant_id`, `user_id`, `name`, `phone`, `email`, `type`, `rating`, `message`, `source`, `status`, `created_at`, `updated_at`) VALUES
(1,	4,	4,	'Tahmeed',	'01633394589',	'tahmidmahbub168@gmail.com',	'complaint',	4,	'thanks',	'app',	'new',	'2026-06-09 12:53:13',	'2026-06-09 12:53:13');

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'0001_01_01_000000_create_users_table',	1),
(2,	'0001_01_01_000001_create_cache_table',	1),
(3,	'0001_01_01_000002_create_jobs_table',	1);

DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `branch_limit` smallint unsigned NOT NULL DEFAULT '1',
  `employee_limit` smallint unsigned NOT NULL DEFAULT '0',
  `features_json` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plans_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `plans` (`id`, `name`, `slug`, `price`, `branch_limit`, `employee_limit`, `features_json`, `is_active`, `created_at`, `updated_at`) VALUES
(1,	'Free',	'free',	0.00,	1,	0,	'{\"pos\": false, \"sales\": true, \"stock\": false, \"campaign\": false, \"expenses\": true, \"purchase\": true, \"customers\": false, \"profit_report\": true, \"online_delivery\": false, \"advanced_reports\": false}',	1,	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(2,	'Starter',	'starter',	500.00,	1,	0,	'{\"pos\": false, \"sales\": true, \"stock\": true, \"campaign\": false, \"expenses\": true, \"purchase\": true, \"customers\": true, \"profit_report\": true, \"online_delivery\": false, \"advanced_reports\": false}',	1,	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(3,	'Dreamer',	'dreamer',	1000.00,	2,	4,	'{\"pos\": false, \"sales\": true, \"stock\": true, \"campaign\": false, \"expenses\": true, \"purchase\": true, \"customers\": true, \"profit_report\": true, \"online_delivery\": true, \"advanced_reports\": false}',	1,	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(4,	'Enterprise',	'enterprise',	2000.00,	4,	12,	'{\"pos\": true, \"sales\": true, \"stock\": true, \"campaign\": true, \"expenses\": true, \"purchase\": true, \"customers\": true, \"profit_report\": true, \"online_delivery\": true, \"advanced_reports\": true}',	1,	'2026-06-06 15:15:55',	'2026-06-06 15:15:55');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock_qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `low_stock_alert` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_tenant_id_index` (`tenant_id`),
  KEY `products_category_id_index` (`category_id`),
  KEY `products_tenant_barcode_index` (`tenant_id`,`barcode`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `tenant_id`, `category_id`, `name`, `barcode`, `unit`, `purchase_price`, `sale_price`, `stock_qty`, `low_stock_alert`, `status`, `created_at`, `updated_at`) VALUES
(1,	4,	NULL,	'Miniket Rice',	'mr',	'pcs',	55.00,	80.00,	20.00,	10.00,	'active',	'2026-06-06 09:58:01',	'2026-06-08 11:26:01'),
(3,	4,	NULL,	'bashmati rice',	'br',	'pcs',	100.00,	150.00,	11.00,	0.00,	'active',	'2026-06-06 12:40:55',	'2026-06-06 12:46:48'),
(4,	4,	NULL,	'Mota rice',	'mr',	'pcs',	40.00,	55.00,	10.00,	3.00,	'active',	'2026-06-09 10:20:02',	'2026-06-09 10:20:02'),
(5,	4,	NULL,	'Ata Chaki',	'ATA',	'kg',	48.00,	55.00,	120.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(6,	4,	NULL,	'Miniket Chal',	'MIN',	'kg',	68.00,	75.00,	200.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(7,	4,	NULL,	'Nazirshail Chal',	'NAZ',	'kg',	72.00,	80.00,	150.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(8,	4,	NULL,	'Mug Dal',	'MUG',	'kg',	115.00,	125.00,	80.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(9,	4,	NULL,	'Mosur Dal',	'MOS',	'kg',	105.00,	115.00,	100.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(10,	4,	NULL,	'Chola Dal',	'CHO',	'kg',	95.00,	105.00,	70.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(11,	4,	NULL,	'Soyabean Tel 1L',	'SOY',	'bottle',	165.00,	180.00,	90.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(12,	4,	NULL,	'Mustard Oil',	'MUS',	'bottle',	185.00,	200.00,	40.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(13,	4,	NULL,	'Salt 1kg',	'SAL001',	'packet',	38.00,	45.00,	150.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(14,	4,	NULL,	'Sugar 1kg',	'SUG001',	'packet',	115.00,	125.00,	120.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(15,	4,	NULL,	'Jaggery',	'GUR001',	'kg',	130.00,	145.00,	35.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(16,	4,	NULL,	'Tea 200gm',	't100',	'packet',	85.00,	95.00,	60.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(17,	4,	NULL,	'Coffee 100gm',	'c100',	'jar',	180.00,	200.00,	20.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(18,	4,	NULL,	'Milk Powder',	'mp',	'packet',	420.00,	460.00,	25.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(19,	4,	NULL,	'Fresh Milk',	'fm',	'liter',	75.00,	85.00,	30.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(20,	4,	NULL,	'Eggs Dozen',	'EGG001',	'dozen',	135.00,	150.00,	50.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(21,	4,	NULL,	'Bread Large',	'BRE001',	'pcs',	50.00,	60.00,	40.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(22,	4,	NULL,	'Butter 200gm',	'BUT001',	'pcs',	210.00,	235.00,	15.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(23,	4,	NULL,	'Cheese Slice',	'CHE001',	'packet',	260.00,	290.00,	12.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(24,	4,	NULL,	'Biscuit Toast',	'BIS001',	'packet',	28.00,	35.00,	100.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(25,	4,	NULL,	'Pran Juice',	'PRA001',	'pcs',	22.00,	30.00,	200.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(26,	4,	NULL,	'Coca Cola 250ml',	'COC001',	'bottle',	22.00,	25.00,	250.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(27,	4,	NULL,	'Pepsi 250ml',	'PEP001',	'bottle',	22.00,	25.00,	220.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(28,	4,	NULL,	'7UP 250ml',	'SEV001',	'bottle',	22.00,	25.00,	180.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(29,	4,	NULL,	'Sprite 250ml',	'SPR001',	'bottle',	22.00,	25.00,	170.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(30,	4,	NULL,	'Energy Drink',	'ENE001',	'can',	38.00,	45.00,	90.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(31,	4,	NULL,	'Mineral Water 500ml',	'MIN002',	'bottle',	12.00,	15.00,	300.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(32,	4,	NULL,	'Chanachur',	'CHA001',	'packet',	18.00,	25.00,	120.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(33,	4,	NULL,	'Potato Chips',	'POT001',	'packet',	22.00,	30.00,	150.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(34,	4,	NULL,	'Chocolate Bar',	'CHO002',	'pcs',	35.00,	45.00,	90.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(35,	4,	NULL,	'Candy Mix',	'CAN001',	'pcs',	1.00,	2.00,	1000.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(36,	4,	NULL,	'Instant Noodles',	'INS001',	'packet',	18.00,	25.00,	200.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(37,	4,	NULL,	'Vermicelli',	'VER001',	'packet',	45.00,	55.00,	60.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(38,	4,	NULL,	'Semai Premium',	'SEM001',	'packet',	55.00,	65.00,	50.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(39,	4,	NULL,	'Soap Lux',	'SOA001',	'pcs',	48.00,	60.00,	80.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(40,	4,	NULL,	'Soap Lifebuoy',	'SOA002',	'pcs',	42.00,	55.00,	90.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(41,	4,	NULL,	'Shampoo Sachet',	'SHA001',	'pcs',	3.00,	5.00,	500.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(42,	4,	NULL,	'Shampoo Bottle',	'SHA002',	'pcs',	145.00,	170.00,	35.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(43,	4,	NULL,	'Toothpaste',	'TOO001',	'pcs',	85.00,	100.00,	70.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(44,	4,	NULL,	'Toothbrush',	'TOO002',	'pcs',	25.00,	35.00,	120.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(45,	4,	NULL,	'Detergent Powder',	'DET001',	'packet',	75.00,	90.00,	100.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(46,	4,	NULL,	'Dishwash Liquid',	'DIS001',	'bottle',	95.00,	115.00,	45.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(47,	4,	NULL,	'Tissue Box',	'TIS001',	'pcs',	70.00,	85.00,	40.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(48,	4,	NULL,	'Match Box',	'MAT001',	'pcs',	1.00,	2.00,	600.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(49,	4,	NULL,	'Mosquito Coil',	'MOS002',	'packet',	75.00,	90.00,	50.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(50,	4,	NULL,	'Battery AA',	'BAT001',	'pcs',	18.00,	25.00,	100.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(51,	4,	NULL,	'LED Bulb',	'LED001',	'pcs',	105.00,	130.00,	30.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(52,	4,	NULL,	'Mobile Recharge Card',	'MOB001',	'pcs',	98.00,	100.00,	200.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(53,	4,	NULL,	'Black Pepper',	'BLA001',	'kg',	480.00,	550.00,	10.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(54,	4,	NULL,	'Turmeric Powder',	'TUR001',	'kg',	180.00,	220.00,	20.00,	0.00,	'active',	'2026-06-09 10:51:44',	'2026-06-09 10:51:44'),
(55,	5,	8,	'Sunsilk',	'12345',	'pcs',	200.00,	300.00,	20.00,	5.00,	'active',	'2026-06-09 11:22:54',	'2026-06-09 11:22:54');

DROP TABLE IF EXISTS `purchase_items`;
CREATE TABLE `purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_index` (`purchase_id`),
  KEY `purchase_items_product_id_index` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `qty`, `unit_price`, `total`) VALUES
(1,	1,	1,	5.00,	55.00,	275.00),
(2,	2,	3,	5.00,	100.00,	500.00),
(3,	3,	3,	1.00,	100.00,	100.00),
(4,	4,	3,	5.00,	100.00,	500.00),
(5,	4,	1,	10.00,	55.00,	550.00);

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `invoice_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `due` decimal(12,2) NOT NULL DEFAULT '0.00',
  `purchase_date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_tenant_id_index` (`tenant_id`),
  KEY `purchases_branch_id_index` (`branch_id`),
  KEY `purchases_supplier_id_index` (`supplier_id`),
  KEY `purchases_tenant_date_index` (`tenant_id`,`purchase_date`),
  KEY `purchases_user_id_foreign` (`user_id`),
  CONSTRAINT `purchases_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `purchases_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `purchases` (`id`, `tenant_id`, `branch_id`, `supplier_id`, `user_id`, `invoice_no`, `status`, `total`, `paid`, `due`, `purchase_date`, `note`, `created_at`, `updated_at`) VALUES
(1,	4,	4,	NULL,	4,	'PUR-00001',	'completed',	275.00,	275.00,	0.00,	'2026-06-06',	NULL,	'2026-06-06 12:16:16',	'2026-06-06 12:16:16'),
(2,	4,	4,	1,	4,	'PUR-00002',	'completed',	500.00,	100.00,	400.00,	'2026-06-06',	NULL,	'2026-06-06 12:41:49',	'2026-06-06 12:41:49'),
(3,	4,	4,	NULL,	4,	'PUR-00003',	'completed',	100.00,	100.00,	0.00,	'2026-06-06',	NULL,	'2026-06-06 12:45:15',	'2026-06-06 12:45:15'),
(4,	4,	4,	NULL,	4,	'PUR-00004',	'completed',	1050.00,	1050.00,	0.00,	'2026-06-06',	NULL,	'2026-06-06 12:46:48',	'2026-06-06 12:46:48');

DROP TABLE IF EXISTS `sale_items`;
CREATE TABLE `sale_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `cost_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `sale_items_sale_id_index` (`sale_id`),
  KEY `sale_items_product_id_index` (`product_id`),
  CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `qty`, `unit_price`, `cost_price`, `total`) VALUES
(1,	1,	1,	2.00,	70.00,	60.00,	140.00),
(2,	2,	1,	2.00,	70.00,	60.00,	140.00),
(3,	3,	1,	1.00,	70.00,	60.00,	70.00),
(4,	4,	1,	10.00,	70.00,	55.00,	700.00);

DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `invoice_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `due` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sale_date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_tenant_id_index` (`tenant_id`),
  KEY `sales_branch_id_index` (`branch_id`),
  KEY `sales_customer_id_index` (`customer_id`),
  KEY `sales_tenant_date_index` (`tenant_id`,`sale_date`),
  KEY `sales_user_id_foreign` (`user_id`),
  CONSTRAINT `sales_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sales` (`id`, `tenant_id`, `branch_id`, `customer_id`, `user_id`, `invoice_no`, `status`, `total`, `discount`, `paid`, `due`, `sale_date`, `note`, `created_at`, `updated_at`) VALUES
(1,	4,	4,	NULL,	4,	'INV-00001',	'completed',	140.00,	0.00,	140.00,	0.00,	'2026-06-06',	NULL,	'2026-06-06 10:16:15',	'2026-06-06 10:16:15'),
(2,	4,	4,	1,	4,	'INV-00002',	'completed',	135.00,	5.00,	100.00,	35.00,	'2026-06-06',	NULL,	'2026-06-06 10:58:49',	'2026-06-06 10:58:49'),
(3,	4,	4,	NULL,	4,	'INV-00003',	'completed',	70.00,	0.00,	70.00,	0.00,	'2026-06-06',	NULL,	'2026-06-06 11:23:32',	'2026-06-06 11:23:32'),
(4,	4,	4,	NULL,	4,	'INV-00004',	'completed',	700.00,	0.00,	700.00,	0.00,	'2026-06-08',	NULL,	'2026-06-08 11:25:37',	'2026-06-08 11:25:37');

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5U8qGot8Dz2X5zZpHUbaV5z0h9dRvfCQxbvHgjUJ',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',	'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkhKVjdVQ0xXcVFVR2VvSjdrQ3YxcFNKV1RncE13c0trWGFOMzQ2cyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',	1764963812),
('mqERv6OvWMegNcMLH53hxiT7JgZ8dOhYkZkg3Ivt',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36',	'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1UxbEZ0SlRWSHgwRTdKdmJFWDRRMjJRZEpnaUdBVWNjdkdRREhZeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',	1780752440);

DROP TABLE IF EXISTS `stock_movements`;
CREATE TABLE `stock_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `type` enum('purchase','sale','purchase_return','sale_return','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_in` decimal(12,2) NOT NULL DEFAULT '0.00',
  `qty_out` decimal(12,2) NOT NULL DEFAULT '0.00',
  `unit_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `reference_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint unsigned DEFAULT NULL,
  `movement_date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_tenant_id_index` (`tenant_id`),
  KEY `stock_movements_product_id_index` (`product_id`),
  KEY `stock_movements_lookup_index` (`tenant_id`,`branch_id`,`product_id`,`movement_date`),
  KEY `stock_movements_reference_index` (`reference_type`,`reference_id`),
  KEY `stock_movements_branch_id_foreign` (`branch_id`),
  CONSTRAINT `stock_movements_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_movements_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `plan_id` bigint unsigned NOT NULL,
  `status` enum('active','expired','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `starts_at` date DEFAULT NULL,
  `ends_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_tenant_id_index` (`tenant_id`),
  KEY `subscriptions_plan_id_index` (`plan_id`),
  CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`),
  CONSTRAINT `subscriptions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `subscriptions` (`id`, `tenant_id`, `plan_id`, `status`, `starts_at`, `ends_at`, `created_at`, `updated_at`) VALUES
(1,	3,	1,	'active',	'2026-06-06',	NULL,	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(2,	4,	1,	'active',	'2026-06-06',	NULL,	'2026-06-06 09:16:09',	'2026-06-06 09:16:09'),
(3,	5,	1,	'active',	'2026-06-09',	NULL,	'2026-06-09 11:17:51',	'2026-06-09 11:17:51');

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suppliers_tenant_id_index` (`tenant_id`),
  CONSTRAINT `suppliers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `suppliers` (`id`, `tenant_id`, `name`, `phone`, `address`, `due_balance`, `created_at`, `updated_at`) VALUES
(1,	4,	'tahmeed supplier',	'01633394588',	NULL,	850.00,	'2026-06-06 12:35:16',	'2026-06-07 11:25:32');

DROP TABLE IF EXISTS `tenants`;
CREATE TABLE `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_type` enum('grocery','pharmacy','cosmetics','stationery','mobile_accessories','wholesale','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `status` enum('active','suspended','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenants_phone_unique` (`phone`),
  KEY `tenants_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tenants` (`id`, `name`, `owner_name`, `phone`, `email`, `business_type`, `status`, `created_at`, `updated_at`) VALUES
(3,	'Demo Store',	'Demo Owner',	'01700000000',	'demo@hishaberkhata.test',	'grocery',	'active',	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(4,	'Tahmeed Shop',	'Tahmeed1',	'01633394589',	'tahmidmahbub168@gmail.com',	'grocery',	'active',	'2026-06-06 09:16:08',	'2026-06-09 12:57:56'),
(5,	'Mudi Dokan',	'Mudi bhai',	'01840208832',	'mudi@gmail.com',	'grocery',	'active',	'2026-06-09 11:17:51',	'2026-06-09 11:17:51');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('owner','manager','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'owner',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_tenant_id_index` (`tenant_id`),
  KEY `users_branch_id_index` (`branch_id`),
  CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `tenant_id`, `branch_id`, `name`, `phone`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(3,	3,	3,	'Demo Owner',	'01700000000',	'demo@hishaberkhata.test',	NULL,	'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	'owner',	'active',	NULL,	'2026-06-06 15:15:55',	'2026-06-06 15:15:55'),
(4,	4,	4,	'Tahmeed',	'01633394589',	'tahmidmahbub168@gmail.com',	NULL,	'$2y$12$/yuhjOy0gH2GnJatkWgie.OvvW7RI1BsTY/p9SW.s9EVKoo385Xsa',	'owner',	'active',	'4eCgRvEqchY4Dx9buow9YbPDKbEUwloMKuaSdpqNKL8uKFk6pIl7xIaMs4Jc',	'2026-06-06 09:16:09',	'2026-06-06 09:16:09'),
(5,	5,	5,	'Mudi bhai',	'01840208832',	'mudi@gmail.com',	NULL,	'$2y$12$j.PapJHpPqc1wHyPdZ1k5Oqlhyw.tEZw40eb.Jt9IVMjh1fP67/zS',	'owner',	'active',	NULL,	'2026-06-09 11:17:51',	'2026-06-09 11:17:51');



CREATE TABLE IF NOT EXISTS `notifications` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`  BIGINT UNSIGNED NULL,
    `user_id`    BIGINT UNSIGNED NULL,
    `type`       VARCHAR(50)  NOT NULL DEFAULT 'info',
    `title`      VARCHAR(150) NOT NULL,
    `message`    VARCHAR(500) NULL,
    `url`        VARCHAR(255) NULL,
    `read_at`    TIMESTAMP    NULL DEFAULT NULL,
    `created_at` TIMESTAMP    NULL DEFAULT NULL,
    `updated_at` TIMESTAMP    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `notifications_tenant_id_index` (`tenant_id`),
    KEY `notifications_user_id_index` (`user_id`),
    KEY `notifications_visibility_index` (`tenant_id`, `user_id`, `read_at`),
    CONSTRAINT `notifications_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2026-06-09 19:00:56 UTC

