-- Example users import
-- Safe to run against an existing Laravel users table.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @add_name = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'name'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `name` varchar(255) NOT NULL DEFAULT '''' AFTER `id`'
  )
);
PREPARE stmt FROM @add_name;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_is_admin = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'is_admin'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `is_admin` tinyint(1) NOT NULL DEFAULT 0 AFTER `email`'
  )
);
PREPARE stmt FROM @add_is_admin;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_email_verified_at = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'email_verified_at'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `email_verified_at` timestamp NULL DEFAULT NULL AFTER `is_admin`'
  )
);
PREPARE stmt FROM @add_email_verified_at;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_password = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'password'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `password` varchar(255) NOT NULL DEFAULT '''' AFTER `email_verified_at`'
  )
);
PREPARE stmt FROM @add_password;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_remember_token = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'remember_token'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `remember_token` varchar(100) DEFAULT NULL AFTER `password`'
  )
);
PREPARE stmt FROM @add_remember_token;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_created_at = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'created_at'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `created_at` timestamp NULL DEFAULT NULL AFTER `remember_token`'
  )
);
PREPARE stmt FROM @add_created_at;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_updated_at = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'updated_at'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `updated_at` timestamp NULL DEFAULT NULL AFTER `created_at`'
  )
);
PREPARE stmt FROM @add_updated_at;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_username = (
  SELECT IF(
    EXISTS(
      SELECT 1
      FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'users'
        AND COLUMN_NAME = 'username'
    ),
    'SELECT 1',
    'ALTER TABLE `users` ADD COLUMN `username` varchar(255) DEFAULT NULL AFTER `updated_at`'
  )
);
PREPARE stmt FROM @add_username;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE `users`
SET `name` = COALESCE(NULLIF(`name`, ''), NULLIF(`username`, ''), `email`)
WHERE `name` IS NULL OR `name` = '';

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`) VALUES
(1, 'Test User', 'test@example.com', 0, '2026-03-23 00:16:12', '$2y$12$iraqZ0gnSNdTciVO96FL8.WkZirPfV/oEeLMMV53rRpG6fX0BJ3im', 'lm2ln0BsME3FKX1JVAL26utzrhxcH7mmnslFhqeV60lyiMNH4oeJK3BWsLrm', '2026-03-23 00:16:12', '2026-03-23 00:16:12', NULL),
(2, 'Admin', 'admin@admin.com', 1, '2026-03-23 00:16:12', '$2y$12$TkBEUYz37aEAXj6Stk5CN.Vj/dMeNaavpAfdPZBHF4KQnvem17MRu', NULL, '2026-03-23 00:16:12', '2026-03-23 00:16:12', NULL),
(3, 'user test', 'usertest1@gmail.com', 0, NULL, '$2y$12$ggGqwRZES.L4Gfpj0xRMLuBGATRJ5QRlb2hqGDfRtnYsQmITcJvhO', NULL, '2026-03-23 00:18:19', '2026-03-23 00:18:19', NULL)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `is_admin` = VALUES(`is_admin`),
  `email_verified_at` = VALUES(`email_verified_at`),
  `password` = VALUES(`password`),
  `remember_token` = VALUES(`remember_token`),
  `created_at` = VALUES(`created_at`),
  `updated_at` = VALUES(`updated_at`),
  `username` = VALUES(`username`);

ALTER TABLE `users`
  AUTO_INCREMENT = 4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
