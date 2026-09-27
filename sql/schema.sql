-- Marketing Attribution Tracking Table
-- Run manually: mysql -u root -p hishaber_khata < sql/schema.sql

CREATE TABLE IF NOT EXISTS `marketing_attributions` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `batch`      BIGINT UNSIGNED NOT NULL,
    `key`        VARCHAR(100) NOT NULL,
    `value`      TEXT NULL,
    `ip`         VARCHAR(45) NULL,
    `user_id`    BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `marketing_attributions_batch_key_unique` (`batch`, `key`),
    KEY `marketing_attributions_batch_index` (`batch`),
    KEY `marketing_attributions_key_index` (`key`),
    KEY `marketing_attributions_user_id_index` (`user_id`),
    CONSTRAINT `marketing_attributions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;