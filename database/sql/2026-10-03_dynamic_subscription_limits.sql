-- =====================================================================
-- Hishabiz Database Update
-- Date: 2026-10-03
-- Feature: Dynamic Admin-Ready Subscription Limits & Feature Flags
-- Safe for Production Execution: YES
-- Safe for Existing Data: YES
-- =====================================================================

SET NAMES utf8mb4;

-- 1. Add product_limit, monthly_sales_limit, monthly_purchase_limit columns to plans table if missing
SET @exist := (SELECT COUNT(*) FROM information_schema.columns 
               WHERE table_schema = DATABASE() AND table_name = 'plans' AND column_name = 'product_limit');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `plans` ADD COLUMN `product_limit` INT UNSIGNED NULL AFTER `price`', 'SELECT "column product_limit already exists"');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist := (SELECT COUNT(*) FROM information_schema.columns 
               WHERE table_schema = DATABASE() AND table_name = 'plans' AND column_name = 'monthly_sales_limit');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `plans` ADD COLUMN `monthly_sales_limit` INT UNSIGNED NULL AFTER `product_limit`', 'SELECT "column monthly_sales_limit already exists"');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist := (SELECT COUNT(*) FROM information_schema.columns 
               WHERE table_schema = DATABASE() AND table_name = 'plans' AND column_name = 'monthly_purchase_limit');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `plans` ADD COLUMN `monthly_purchase_limit` INT UNSIGNED NULL AFTER `monthly_sales_limit`', 'SELECT "column monthly_purchase_limit already exists"');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 2. Modify employee_limit and branch_limit to allow NULL (representing unlimited)
ALTER TABLE `plans` MODIFY COLUMN `employee_limit` SMALLINT UNSIGNED NULL DEFAULT 1;
ALTER TABLE `plans` MODIFY COLUMN `branch_limit` SMALLINT UNSIGNED NULL DEFAULT 1;

-- 3. Upsert default plans configuration (admin-panel ready)

-- Free Plan
INSERT INTO `plans` (`name`, `slug`, `price`, `product_limit`, `monthly_sales_limit`, `monthly_purchase_limit`, `employee_limit`, `branch_limit`, `features_json`, `is_active`, `created_at`, `updated_at`)
VALUES (
    'Free',
    'free',
    0.00,
    30,
    100,
    10,
    1,
    1,
    '{"sales": true, "basic_reports": true, "invoice": false, "customer_management": false, "due_management": false, "cloud_backup": false, "whatsapp_invoice": false, "stock_management": false, "expense_tracking": false, "premium_reports": false, "advanced_reports": false, "custom_reports": false, "role_permission_management": false, "multi_branch": false, "priority_support": false, "dedicated_support": false}',
    1,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `price` = VALUES(`price`),
    `product_limit` = VALUES(`product_limit`),
    `monthly_sales_limit` = VALUES(`monthly_sales_limit`),
    `monthly_purchase_limit` = VALUES(`monthly_purchase_limit`),
    `employee_limit` = VALUES(`employee_limit`),
    `branch_limit` = VALUES(`branch_limit`),
    `features_json` = VALUES(`features_json`),
    `updated_at` = NOW();

-- Basic Plan
INSERT INTO `plans` (`name`, `slug`, `price`, `product_limit`, `monthly_sales_limit`, `monthly_purchase_limit`, `employee_limit`, `branch_limit`, `features_json`, `is_active`, `created_at`, `updated_at`)
VALUES (
    'Basic',
    'basic',
    299.00,
    150,
    NULL,
    100,
    1,
    1,
    '{"sales": true, "basic_reports": true, "invoice": true, "customer_management": true, "due_management": true, "cloud_backup": true, "whatsapp_invoice": false, "stock_management": false, "expense_tracking": false, "premium_reports": false, "advanced_reports": false, "custom_reports": false, "role_permission_management": false, "multi_branch": false, "priority_support": false, "dedicated_support": false}',
    1,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `price` = VALUES(`price`),
    `product_limit` = VALUES(`product_limit`),
    `monthly_sales_limit` = VALUES(`monthly_sales_limit`),
    `monthly_purchase_limit` = VALUES(`monthly_purchase_limit`),
    `employee_limit` = VALUES(`employee_limit`),
    `branch_limit` = VALUES(`branch_limit`),
    `features_json` = VALUES(`features_json`),
    `updated_at` = NOW();

-- Professional Plan
INSERT INTO `plans` (`name`, `slug`, `price`, `product_limit`, `monthly_sales_limit`, `monthly_purchase_limit`, `employee_limit`, `branch_limit`, `features_json`, `is_active`, `created_at`, `updated_at`)
VALUES (
    'Professional',
    'professional',
    599.00,
    500,
    NULL,
    NULL,
    3,
    1,
    '{"sales": true, "basic_reports": true, "invoice": true, "customer_management": true, "due_management": true, "cloud_backup": true, "whatsapp_invoice": true, "stock_management": true, "expense_tracking": true, "premium_reports": true, "priority_support": true, "advanced_reports": false, "custom_reports": false, "role_permission_management": false, "multi_branch": false, "dedicated_support": false}',
    1,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `price` = VALUES(`price`),
    `product_limit` = VALUES(`product_limit`),
    `monthly_sales_limit` = VALUES(`monthly_sales_limit`),
    `monthly_purchase_limit` = VALUES(`monthly_purchase_limit`),
    `employee_limit` = VALUES(`employee_limit`),
    `branch_limit` = VALUES(`branch_limit`),
    `features_json` = VALUES(`features_json`),
    `updated_at` = NOW();

-- Business Plan
INSERT INTO `plans` (`name`, `slug`, `price`, `product_limit`, `monthly_sales_limit`, `monthly_purchase_limit`, `employee_limit`, `branch_limit`, `features_json`, `is_active`, `created_at`, `updated_at`)
VALUES (
    'Business',
    'business',
    1299.00,
    NULL,
    NULL,
    NULL,
    10,
    NULL,
    '{"sales": true, "basic_reports": true, "invoice": true, "customer_management": true, "due_management": true, "cloud_backup": true, "whatsapp_invoice": true, "stock_management": true, "expense_tracking": true, "premium_reports": true, "priority_support": true, "multi_branch": true, "advanced_reports": true, "custom_reports": true, "role_permission_management": true, "dedicated_support": true}',
    1,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `price` = VALUES(`price`),
    `product_limit` = VALUES(`product_limit`),
    `monthly_sales_limit` = VALUES(`monthly_sales_limit`),
    `monthly_purchase_limit` = VALUES(`monthly_purchase_limit`),
    `employee_limit` = VALUES(`employee_limit`),
    `branch_limit` = VALUES(`branch_limit`),
    `features_json` = VALUES(`features_json`),
    `updated_at` = NOW();
