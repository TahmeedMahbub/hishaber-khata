-- =====================================================================
-- Hishabiz Database Update
-- Date: 2026-10-03
-- Feature: Per-Tenant Atomic Sequential Numbering (tenant_sequences)
-- Safe for Production Execution: YES
-- Safe for Existing Data: YES
-- =====================================================================

SET NAMES utf8mb4;

-- 1. Create tenant_sequences table
CREATE TABLE IF NOT EXISTS `tenant_sequences` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id`      BIGINT UNSIGNED NOT NULL,
    `entity_type`    VARCHAR(50)  NOT NULL,
    `last_number`    BIGINT UNSIGNED NOT NULL DEFAULT 0,
    `created_at`     TIMESTAMP NULL DEFAULT NULL,
    `updated_at`     TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenant_entity_unique` (`tenant_id`, `entity_type`),
    CONSTRAINT `tenant_sequences_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Initial Data Backfill (Safe for Existing Data)
-- Populates last_number for existing tenants from highest current serial suffixes,
-- so future numbers continue seamlessly (e.g., after INV-00045, next is INV-00046).

-- Sales sequence initialization
INSERT INTO `tenant_sequences` (`tenant_id`, `entity_type`, `last_number`, `created_at`, `updated_at`)
SELECT 
    s.tenant_id, 
    'sale', 
    COALESCE(MAX(CAST(SUBSTRING_INDEX(s.invoice_no, '-', -1) AS UNSIGNED)), 0),
    NOW(), 
    NOW()
FROM `sales` s
WHERE s.invoice_no IS NOT NULL AND s.invoice_no != ''
GROUP BY s.tenant_id
ON DUPLICATE KEY UPDATE `last_number` = GREATEST(`tenant_sequences`.`last_number`, VALUES(`last_number`));

-- Purchases sequence initialization
INSERT INTO `tenant_sequences` (`tenant_id`, `entity_type`, `last_number`, `created_at`, `updated_at`)
SELECT 
    p.tenant_id, 
    'purchase', 
    COALESCE(MAX(CAST(SUBSTRING_INDEX(p.invoice_no, '-', -1) AS UNSIGNED)), 0),
    NOW(), 
    NOW()
FROM `purchases` p
WHERE p.invoice_no IS NOT NULL AND p.invoice_no != ''
GROUP BY p.tenant_id
ON DUPLICATE KEY UPDATE `last_number` = GREATEST(`tenant_sequences`.`last_number`, VALUES(`last_number`));

-- Sale returns sequence initialization (if table exists)
SET @exist_tbl := (SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'sale_returns');
SET @sqlstmt := IF(@exist_tbl > 0, 
    'INSERT INTO `tenant_sequences` (`tenant_id`, `entity_type`, `last_number`, `created_at`, `updated_at`) SELECT sr.tenant_id, "sale_return", COALESCE(MAX(CAST(SUBSTRING_INDEX(sr.return_no, "-", -1) AS UNSIGNED)), 0), NOW(), NOW() FROM `sale_returns` sr WHERE sr.return_no IS NOT NULL AND sr.return_no != "" GROUP BY sr.tenant_id ON DUPLICATE KEY UPDATE `last_number` = GREATEST(`tenant_sequences`.`last_number`, VALUES(`last_number`))',
    'SELECT "sale_returns table not present; skipping backfill"'
);
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Purchase returns sequence initialization (if table exists)
SET @exist_tbl := (SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'purchase_returns');
SET @sqlstmt := IF(@exist_tbl > 0, 
    'INSERT INTO `tenant_sequences` (`tenant_id`, `entity_type`, `last_number`, `created_at`, `updated_at`) SELECT pr.tenant_id, "purchase_return", COALESCE(MAX(CAST(SUBSTRING_INDEX(pr.return_no, "-", -1) AS UNSIGNED)), 0), NOW(), NOW() FROM `purchase_returns` pr WHERE pr.return_no IS NOT NULL AND pr.return_no != "" GROUP BY pr.tenant_id ON DUPLICATE KEY UPDATE `last_number` = GREATEST(`tenant_sequences`.`last_number`, VALUES(`last_number`))',
    'SELECT "purchase_returns table not present; skipping backfill"'
);
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 3. Add composite indexes for per-tenant serial number lookup performance

-- Sales tenant invoice index
SET @exist := (SELECT COUNT(*) FROM information_schema.statistics 
               WHERE table_schema = DATABASE() AND table_name = 'sales' AND index_name = 'sales_tenant_invoice_index');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `sales` ADD INDEX `sales_tenant_invoice_index` (`tenant_id`, `invoice_no`)', 'SELECT "index sales_tenant_invoice_index already exists"');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Purchases tenant invoice index
SET @exist := (SELECT COUNT(*) FROM information_schema.statistics 
               WHERE table_schema = DATABASE() AND table_name = 'purchases' AND index_name = 'purchases_tenant_invoice_index');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `purchases` ADD INDEX `purchases_tenant_invoice_index` (`tenant_id`, `invoice_no`)', 'SELECT "index purchases_tenant_invoice_index already exists"');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Sale returns tenant number index
SET @exist := (SELECT COUNT(*) FROM information_schema.statistics 
               WHERE table_schema = DATABASE() AND table_name = 'sale_returns' AND index_name = 'sale_returns_tenant_no_index');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `sale_returns` ADD INDEX `sale_returns_tenant_no_index` (`tenant_id`, `return_no`)', 'SELECT "index sale_returns_tenant_no_index already exists"');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Purchase returns tenant number index
SET @exist := (SELECT COUNT(*) FROM information_schema.statistics 
               WHERE table_schema = DATABASE() AND table_name = 'purchase_returns' AND index_name = 'purchase_returns_tenant_no_index');
SET @sqlstmt := IF(@exist = 0, 'ALTER TABLE `purchase_returns` ADD INDEX `purchase_returns_tenant_no_index` (`tenant_id`, `return_no`)', 'SELECT "index purchase_returns_tenant_no_index already exists"');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
