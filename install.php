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

// Beispiel: Logge Installation ins REDAXO System-Log
// Für Composer-AddOns IMMER rex_logger verwenden, nicht rex_path::addonData()!
rex_logger::factory()->info('REDAXO Composer Demo AddOn: Installation gestartet', [
    'package' => 'klxm/redaxo-composer-demo-addon',
    'php_version' => PHP_VERSION,
    'timestamp' => date('Y-m-d H:i:s')
]);

// Beispiel: Prüfe Systemvoraussetzungen
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    throw new Exception('PHP 7.4 oder höher erforderlich!');
}

// Beispiel: Setze initiale Config-Werte (zusätzlich zu default_config)
// Config funktioniert auch für Composer-AddOns!
rex_config::set('klxm_redaxo-composer-demo-addon', 'installed_at', time());
rex_config::set('klxm_redaxo-composer-demo-addon', 'install_method', 'composer');

rex_logger::factory()->info('REDAXO Composer Demo AddOn: Installation erfolgreich abgeschlossen', [
    'config_set' => true,
    'requirements_checked' => true
]);

echo "✅ Demo AddOn erfolgreich installiert!\n";
echo "📁 Verzeichnisse wurden angelegt (via Manifest)\n";
echo "📊 Datenbank-Tabellen wurden erstellt (via install.sql)\n";
echo "🎉 Lifecycle-System funktioniert!\n";
echo "📝 Logs findest du im REDAXO System-Log\n";
