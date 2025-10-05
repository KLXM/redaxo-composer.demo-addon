<?php

/**
 * REDAXO Composer Demo AddOn - Install Hook
 * 
 * Diese Datei wird ZUSÄTZLICH zu den Manifest-Lifecycle-Hooks ausgeführt.
 * PHP-Dateien haben Priorität vor Manifest-Hooks.
 * 
 * Verwende PHP-Hooks für:
 * - Komplexe Logik
 * - Datenmigration
 * - API-Calls
 * - Bedingte Operationen
 * 
 * Verwende Manifest-Hooks für:
 * - Einfache Verzeichnis-Operationen
 * - SQL-Dateien
 * - Datei-Kopien
 */

// Beispiel: Logge Installation
$logFile = rex_path::addonData('redaxo_composer_demo_addon', 'logs/install.log');
$logDir = dirname($logFile);

if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

$logEntry = date('Y-m-d H:i:s') . " - Demo AddOn Installation gestartet\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Beispiel: Prüfe Systemvoraussetzungen
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    throw new Exception('PHP 7.4 oder höher erforderlich!');
}

// Beispiel: Setze initiale Config-Werte (zusätzlich zu default_config)
rex_config::set('redaxo_composer_demo_addon', 'installed_at', time());
rex_config::set('redaxo_composer_demo_addon', 'install_method', 'composer');

echo "✅ Demo AddOn erfolgreich installiert!\n";
echo "📁 Verzeichnisse wurden angelegt\n";
echo "📊 Datenbank-Tabellen wurden erstellt\n";
echo "🎉 Lifecycle-System funktioniert!\n";
