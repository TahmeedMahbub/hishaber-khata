-- =====================================================================
-- Hishaber Khata - Seed Data
-- Apply AFTER schema.sql:
--   mysql -u root -p hishaber_khata < database/seeders.sql
-- =====================================================================

SET NAMES utf8mb4;

-- =====================================================================
-- Plans
-- Feature matrix:
--   sales, purchase, profit_report  -> all plans
--   customers                       -> starter, dreamer, enterprise (core, not premium)
--   expenses                        -> all plans
--   stock                           -> starter, dreamer, enterprise
--   online_delivery                 -> dreamer, enterprise
--   campaign                        -> enterprise
--   advanced_reports                -> enterprise
--   pos                             -> enterprise
-- =====================================================================
INSERT INTO `plans`
    (`name`, `slug`, `price`, `branch_limit`, `employee_limit`, `features_json`, `is_active`, `created_at`, `updated_at`)
VALUES
    ('Free', 'free', 0.00, 1, 0,
        JSON_OBJECT(
            'sales', true, 'purchase', true, 'profit_report', true,
            'expenses', true, 'customers', false, 'stock', false,
            'online_delivery', false, 'campaign', false,
            'advanced_reports', false, 'pos', false
        ), 1, NOW(), NOW()),

    ('Starter', 'starter', 500.00, 1, 0,
        JSON_OBJECT(
            'sales', true, 'purchase', true, 'profit_report', true,
            'expenses', true, 'customers', true, 'stock', true,
            'online_delivery', false, 'campaign', false,
            'advanced_reports', false, 'pos', false
        ), 1, NOW(), NOW()),

    ('Dreamer', 'dreamer', 1000.00, 2, 4,
        JSON_OBJECT(
            'sales', true, 'purchase', true, 'profit_report', true,
            'expenses', true, 'customers', true, 'stock', true,
            'online_delivery', true, 'campaign', false,
            'advanced_reports', false, 'pos', false
        ), 1, NOW(), NOW()),

    ('Enterprise', 'enterprise', 2000.00, 4, 12,
        JSON_OBJECT(
            'sales', true, 'purchase', true, 'profit_report', true,
            'expenses', true, 'customers', true, 'stock', true,
            'online_delivery', true, 'campaign', true,
            'advanced_reports', true, 'pos', true
        ), 1, NOW(), NOW());

-- =====================================================================
-- Demo Tenant (optional - remove in production)
-- =====================================================================
INSERT INTO `tenants`
    (`name`, `owner_name`, `phone`, `email`, `business_type`, `status`, `created_at`, `updated_at`)
VALUES
    ('Demo Store', 'Demo Owner', '01700000000', 'demo@hishaberkhata.test', 'grocery', 'active', NOW(), NOW());

SET @tenant_id = LAST_INSERT_ID();

-- Subscribe demo tenant to Free plan
INSERT INTO `subscriptions`
    (`tenant_id`, `plan_id`, `status`, `starts_at`, `ends_at`, `created_at`, `updated_at`)
SELECT @tenant_id, `id`, 'active', CURDATE(), NULL, NOW(), NOW()
FROM `plans` WHERE `slug` = 'free' LIMIT 1;

-- Main branch
INSERT INTO `branches`
    (`tenant_id`, `name`, `address`, `phone`, `is_main`, `created_at`, `updated_at`)
VALUES
    (@tenant_id, 'Main Branch', NULL, '01700000000', 1, NOW(), NOW());

SET @branch_id = LAST_INSERT_ID();

-- Owner user (password = "password", bcrypt hash)
INSERT INTO `users`
    (`tenant_id`, `branch_id`, `name`, `phone`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`)
VALUES
    (@tenant_id, @branch_id, 'Demo Owner', '01700000000', 'demo@hishaberkhata.test',
     '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
     'owner', 'active', NOW(), NOW());

-- Default categories for the demo (grocery) tenant
INSERT INTO `categories` (`tenant_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
    (@tenant_id, 'Rice', 'active', NOW(), NOW()),
    (@tenant_id, 'Oil', 'active', NOW(), NOW()),
    (@tenant_id, 'Biscuit', 'active', NOW(), NOW()),
    (@tenant_id, 'Beverage', 'active', NOW(), NOW());

-- =====================================================================
-- Default Category Reference by Business Type
-- (Used by TenantRegistrationService at signup; kept here for documentation.
--  These INSERTs are commented out because they require a real @tenant_id.)
-- =====================================================================
-- GROCERY            : Rice, Oil, Biscuit, Beverage, Spices
-- PHARMACY           : Medicine, Syrup, Injection, Cosmetics, Devices
-- COSMETICS          : Skin Care, Hair Care, Makeup, Perfume
-- STATIONERY         : Pen, Notebook, Paper, Office Supplies
-- MOBILE_ACCESSORIES : Charger, Earphone, Cover, Cable, Power Bank
-- WHOLESALE          : General
-- OTHER              : General
