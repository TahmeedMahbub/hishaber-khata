-- =====================================================================
-- Hishaber Khata - Database Schema
-- Single database, single schema, multi-tenant (tenant_id on every table)
-- Engine: InnoDB | Charset: utf8mb4
-- Apply with: mysql -u root -p hishaber_khata < database/schema.sql
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- Drop existing tables so this script is authoritative.
-- (Removes Laravel's default users/migration tables that lack tenant_id.)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `activity_logs`;
DROP TABLE IF EXISTS `cash_transactions`;
DROP TABLE IF EXISTS `stock_movements`;
DROP TABLE IF EXISTS `damages`;
DROP TABLE IF EXISTS `expenses`;
DROP TABLE IF EXISTS `expense_categories`;
DROP TABLE IF EXISTS `sale_items`;
DROP TABLE IF EXISTS `sales`;
DROP TABLE IF EXISTS `purchase_items`;
DROP TABLE IF EXISTS `purchases`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `suppliers`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `branches`;
DROP TABLE IF EXISTS `subscriptions`;
DROP TABLE IF EXISTS `tenants`;
DROP TABLE IF EXISTS `plans`;
-- Laravel default tables not used in this schema:
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `personal_access_tokens`;
DROP TABLE IF EXISTS `failed_jobs`;

-- =====================================================================
-- 1. plans
-- =====================================================================
CREATE TABLE IF NOT EXISTS `plans` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`           VARCHAR(50)  NOT NULL,
    `slug`           VARCHAR(50)  NOT NULL,
    `price`          DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `branch_limit`   SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    `employee_limit` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `features_json`  JSON         NULL,
    `is_active`      TINYINT(1)   NOT NULL DEFAULT 1,
    `created_at`     TIMESTAMP    NULL DEFAULT NULL,
    `updated_at`     TIMESTAMP    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `plans_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 2. tenants
-- =====================================================================
CREATE TABLE IF NOT EXISTS `tenants` (
    `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(150) NOT NULL,
    `owner_name`    VARCHAR(150) NOT NULL,
    `phone`         VARCHAR(20)  NOT NULL,
    `email`         VARCHAR(150) NULL,
    `business_type` ENUM('grocery','pharmacy','cosmetics','stationery','mobile_accessories','wholesale','other') NOT NULL DEFAULT 'other',
    `status`        ENUM('active','suspended','pending') NOT NULL DEFAULT 'active',
    `created_at`    TIMESTAMP    NULL DEFAULT NULL,
    `updated_at`    TIMESTAMP    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenants_phone_unique` (`phone`),
    KEY `tenants_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 3. subscriptions
-- =====================================================================
CREATE TABLE IF NOT EXISTS `subscriptions` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`  BIGINT UNSIGNED NOT NULL,
    `plan_id`    BIGINT UNSIGNED NOT NULL,
    `status`     ENUM('active','expired','cancelled') NOT NULL DEFAULT 'active',
    `starts_at`  DATE NULL,
    `ends_at`    DATE NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `subscriptions_tenant_id_index` (`tenant_id`),
    KEY `subscriptions_plan_id_index` (`plan_id`),
    CONSTRAINT `subscriptions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 4. branches
-- =====================================================================
CREATE TABLE IF NOT EXISTS `branches` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`  BIGINT UNSIGNED NOT NULL,
    `name`       VARCHAR(150) NOT NULL,
    `address`    VARCHAR(255) NULL,
    `phone`      VARCHAR(20)  NULL,
    `is_main`    TINYINT(1)   NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `branches_tenant_id_index` (`tenant_id`),
    CONSTRAINT `branches_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 5. users
-- =====================================================================
CREATE TABLE IF NOT EXISTS `users` (
    `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`         BIGINT UNSIGNED NULL,
    `branch_id`         BIGINT UNSIGNED NULL,
    `name`              VARCHAR(150) NOT NULL,
    `phone`             VARCHAR(20)  NULL,
    `email`             VARCHAR(150) NULL,
    `email_verified_at` TIMESTAMP    NULL DEFAULT NULL,
    `password`          VARCHAR(255) NOT NULL,
    `role`              ENUM('owner','manager','staff') NOT NULL DEFAULT 'owner',
    `status`            ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `remember_token`    VARCHAR(100) NULL,
    `created_at`        TIMESTAMP NULL DEFAULT NULL,
    `updated_at`        TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`),
    UNIQUE KEY `users_phone_unique` (`phone`),
    KEY `users_tenant_id_index` (`tenant_id`),
    KEY `users_branch_id_index` (`branch_id`),
    CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 6. categories
-- =====================================================================
CREATE TABLE IF NOT EXISTS `categories` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`  BIGINT UNSIGNED NOT NULL,
    `name`       VARCHAR(100) NOT NULL,
    `status`     ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `categories_tenant_id_index` (`tenant_id`),
    CONSTRAINT `categories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 7. products
-- =====================================================================
CREATE TABLE IF NOT EXISTS `products` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`       BIGINT UNSIGNED NOT NULL,
    `category_id`     BIGINT UNSIGNED NULL,
    `name`            VARCHAR(150) NOT NULL,
    `barcode`         VARCHAR(100) NULL,
    `unit`            VARCHAR(20)  NOT NULL DEFAULT 'pcs',
    `purchase_price`  DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `sale_price`      DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `stock_qty`       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `low_stock_alert` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `status`          ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at`      TIMESTAMP NULL DEFAULT NULL,
    `updated_at`      TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `products_tenant_id_index` (`tenant_id`),
    KEY `products_category_id_index` (`category_id`),
    KEY `products_tenant_barcode_index` (`tenant_id`, `barcode`),
    CONSTRAINT `products_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 8. suppliers
-- =====================================================================
CREATE TABLE IF NOT EXISTS `suppliers` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`   BIGINT UNSIGNED NOT NULL,
    `name`        VARCHAR(150) NOT NULL,
    `phone`       VARCHAR(20)  NULL,
    `address`     VARCHAR(255) NULL,
    `due_balance` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `created_at`  TIMESTAMP NULL DEFAULT NULL,
    `updated_at`  TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `suppliers_tenant_id_index` (`tenant_id`),
    CONSTRAINT `suppliers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 9. customers
-- =====================================================================
CREATE TABLE IF NOT EXISTS `customers` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`   BIGINT UNSIGNED NOT NULL,
    `name`        VARCHAR(150) NOT NULL,
    `phone`       VARCHAR(20)  NULL,
    `address`     VARCHAR(255) NULL,
    `due_balance` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `created_at`  TIMESTAMP NULL DEFAULT NULL,
    `updated_at`  TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `customers_tenant_id_index` (`tenant_id`),
    KEY `customers_tenant_phone_index` (`tenant_id`, `phone`),
    CONSTRAINT `customers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 10. purchases
-- =====================================================================
CREATE TABLE IF NOT EXISTS `purchases` (
    `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`     BIGINT UNSIGNED NOT NULL,
    `branch_id`     BIGINT UNSIGNED NULL,
    `supplier_id`   BIGINT UNSIGNED NULL,
    `user_id`       BIGINT UNSIGNED NULL,
    `invoice_no`    VARCHAR(50)  NULL,
    `status`        ENUM('draft','completed','cancelled') NOT NULL DEFAULT 'completed',
    `total`         DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `paid`          DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `due`           DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `purchase_date` DATE NOT NULL,
    `note`          VARCHAR(255) NULL,
    `created_at`    TIMESTAMP NULL DEFAULT NULL,
    `updated_at`    TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `purchases_tenant_id_index` (`tenant_id`),
    KEY `purchases_branch_id_index` (`branch_id`),
    KEY `purchases_supplier_id_index` (`supplier_id`),
    KEY `purchases_tenant_date_index` (`tenant_id`, `purchase_date`),
    CONSTRAINT `purchases_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `purchases_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
    CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 11. purchase_items
-- =====================================================================
CREATE TABLE IF NOT EXISTS `purchase_items` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `purchase_id` BIGINT UNSIGNED NOT NULL,
    `product_id`  BIGINT UNSIGNED NOT NULL,
    `qty`         DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `unit_price`  DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `total`       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (`id`),
    KEY `purchase_items_purchase_id_index` (`purchase_id`),
    KEY `purchase_items_product_id_index` (`product_id`),
    CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
    CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 12. sales
-- =====================================================================
CREATE TABLE IF NOT EXISTS `sales` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`   BIGINT UNSIGNED NOT NULL,
    `branch_id`   BIGINT UNSIGNED NULL,
    `customer_id` BIGINT UNSIGNED NULL,
    `user_id`     BIGINT UNSIGNED NULL,
    `invoice_no`  VARCHAR(50)  NULL,
    `status`      ENUM('draft','completed','cancelled') NOT NULL DEFAULT 'completed',
    `total`       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `discount`    DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `paid`        DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `due`         DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `sale_date`   DATE NOT NULL,
    `note`        VARCHAR(255) NULL,
    `created_at`  TIMESTAMP NULL DEFAULT NULL,
    `updated_at`  TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `sales_tenant_id_index` (`tenant_id`),
    KEY `sales_branch_id_index` (`branch_id`),
    KEY `sales_customer_id_index` (`customer_id`),
    KEY `sales_tenant_date_index` (`tenant_id`, `sale_date`),
    CONSTRAINT `sales_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `sales_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
    CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 13. sale_items
-- =====================================================================
CREATE TABLE IF NOT EXISTS `sale_items` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sale_id`    BIGINT UNSIGNED NOT NULL,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `qty`        DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `unit_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `cost_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `total`      DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (`id`),
    KEY `sale_items_sale_id_index` (`sale_id`),
    KEY `sale_items_product_id_index` (`product_id`),
    CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
    CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 14. expense_categories
-- =====================================================================
CREATE TABLE IF NOT EXISTS `expense_categories` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`  BIGINT UNSIGNED NOT NULL,
    `name`       VARCHAR(100) NOT NULL,
    `status`     ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `expense_categories_tenant_name_unique` (`tenant_id`, `name`),
    KEY `expense_categories_tenant_id_index` (`tenant_id`),
    CONSTRAINT `expense_categories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 15. expenses
-- =====================================================================
CREATE TABLE IF NOT EXISTS `expenses` (
    `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`           BIGINT UNSIGNED NOT NULL,
    `branch_id`           BIGINT UNSIGNED NULL,
    `expense_category_id` BIGINT UNSIGNED NULL,
    `title`               VARCHAR(150) NOT NULL,
    `amount`              DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `expense_date`        DATE NOT NULL,
    `note`                VARCHAR(255) NULL,
    `created_at`          TIMESTAMP NULL DEFAULT NULL,
    `updated_at`          TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `expenses_tenant_id_index` (`tenant_id`),
    KEY `expenses_branch_id_index` (`branch_id`),
    KEY `expenses_expense_category_id_index` (`expense_category_id`),
    KEY `expenses_tenant_date_index` (`tenant_id`, `expense_date`),
    CONSTRAINT `expenses_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `expenses_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `expenses_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 16. stock_movements  (audit trail / ledger)
-- =====================================================================
CREATE TABLE IF NOT EXISTS `stock_movements` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`      BIGINT UNSIGNED NOT NULL,
    `branch_id`      BIGINT UNSIGNED NULL,
    `product_id`     BIGINT UNSIGNED NOT NULL,
    `type`           ENUM('purchase','sale','purchase_return','sale_return','adjustment') NOT NULL,
    `qty_in`         DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `qty_out`        DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `unit_cost`      DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `reference_type` VARCHAR(50)  NULL,
    `reference_id`   BIGINT UNSIGNED NULL,
    `movement_date`  DATE NOT NULL,
    `note`           VARCHAR(255) NULL,
    `created_at`     TIMESTAMP NULL DEFAULT NULL,
    `updated_at`     TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `stock_movements_tenant_id_index` (`tenant_id`),
    KEY `stock_movements_product_id_index` (`product_id`),
    KEY `stock_movements_lookup_index` (`tenant_id`, `branch_id`, `product_id`, `movement_date`),
    KEY `stock_movements_reference_index` (`reference_type`, `reference_id`),
    CONSTRAINT `stock_movements_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `stock_movements_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 17. cash_transactions  (actual cash flow: separate from sales/purchases/expenses)
-- =====================================================================
CREATE TABLE IF NOT EXISTS `cash_transactions` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`        BIGINT UNSIGNED NOT NULL,
    `branch_id`        BIGINT UNSIGNED NULL,
    `type`             ENUM('cash_in','cash_out') NOT NULL,
    `amount`           DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `reference_type`   VARCHAR(50)  NULL,
    `reference_id`     BIGINT UNSIGNED NULL,
    `transaction_date` DATE NOT NULL,
    `note`             VARCHAR(255) NULL,
    `created_at`       TIMESTAMP NULL DEFAULT NULL,
    `updated_at`       TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `cash_transactions_tenant_id_index` (`tenant_id`),
    KEY `cash_transactions_branch_id_index` (`branch_id`),
    KEY `cash_transactions_date_index` (`tenant_id`, `transaction_date`),
    KEY `cash_transactions_reference_index` (`reference_type`, `reference_id`),
    CONSTRAINT `cash_transactions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `cash_transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 18. damages  (damaged / lost stock log)
-- =====================================================================
CREATE TABLE IF NOT EXISTS `damages` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`   BIGINT UNSIGNED NOT NULL,
    `branch_id`   BIGINT UNSIGNED NULL,
    `product_id`  BIGINT UNSIGNED NOT NULL,
    `type`        ENUM('damage','lost') NOT NULL DEFAULT 'damage',
    `qty`         DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `unit_cost`   DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `reason`      VARCHAR(255) NULL,
    `damage_date` DATE NOT NULL,
    `created_at`  TIMESTAMP NULL DEFAULT NULL,
    `updated_at`  TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `damages_tenant_id_index` (`tenant_id`),
    KEY `damages_product_id_index` (`product_id`),
    KEY `damages_tenant_date_index` (`tenant_id`, `damage_date`),
    CONSTRAINT `damages_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `damages_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `damages_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- 19. activity_logs  (system audit trail)
-- =====================================================================
CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`    BIGINT UNSIGNED NOT NULL,
    `user_id`      BIGINT UNSIGNED NULL,
    `action`       VARCHAR(100) NOT NULL,
    `subject_type` VARCHAR(100) NULL,
    `subject_id`   BIGINT UNSIGNED NULL,
    `description`  TEXT NULL,
    `ip_address`   VARCHAR(45) NULL,
    `created_at`   TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `activity_logs_tenant_id_index` (`tenant_id`),
    KEY `activity_logs_user_id_index` (`user_id`),
    KEY `activity_logs_subject_index` (`subject_type`, `subject_id`),
    CONSTRAINT `activity_logs_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

