

-----------------------------BELOW LINES ARE EXECUTED-------------------------------

ALTER TABLE `tenants`
    ADD COLUMN `source` VARCHAR(50) NULL AFTER `business_type`,
    ADD INDEX `tenants_source_index` (`source`);