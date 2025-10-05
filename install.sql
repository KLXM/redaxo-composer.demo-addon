-- Demo AddOn Installation SQL
-- Wird automatisch bei Installation ausgeführt

-- Beispiel-Tabelle für Demo-Daten
CREATE TABLE IF NOT EXISTS `rex_demo_addon_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Beispiel-Daten einfügen
INSERT INTO `rex_demo_addon_data` (`name`, `value`, `created_at`) VALUES
('welcome', 'Willkommen beim REDAXO Composer Demo AddOn!', NOW()),
('version', '1.4.0', NOW()),
('status', 'installed', NOW());
