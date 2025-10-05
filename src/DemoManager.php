<?php

/**
 * Demo AddOn Manager Class
 * 
 * Zentrale Verwaltungsklasse für das Demo AddOn
 */

namespace Klxm\RedaxoComposerDemoAddon;

use rex;
use rex_config;
use rex_i18n;
use rex_logger;

class DemoManager
{
    /**
     * AddOn Schlüssel
     */
    public const ADDON_KEY = 'redaxo_composer_demo_addon';

    /**
     * Konfiguration abrufen
     */
    public static function getConfig(?string $key = null, $default = null)
    {
        if ($key === null) {
            return rex_config::get(self::ADDON_KEY, []);
        }
        
        return rex_config::get(self::ADDON_KEY, $key, $default);
    }

    /**
     * Konfiguration setzen
     */
    public static function setConfig(string $key, $value): bool
    {
        return rex_config::set(self::ADDON_KEY, $key, $value);
    }

    /**
     * Standard-Konfiguration initialisieren
     */
    public static function initDefaultConfig(): void
    {
        $defaults = [
            'demo_setting' => 'Hallo REDAXO Composer!',
            'show_debug' => false,
            'install_date' => date('Y-m-d H:i:s'),
            'version' => '1.0.0'
        ];

        foreach ($defaults as $key => $value) {
            if (!rex_config::has(self::ADDON_KEY, $key)) {
                self::setConfig($key, $value);
            }
        }
    }

    /**
     * Demo-Daten generieren
     */
    public static function generateDemoData(): array
    {
        return [
            'timestamp' => time(),
            'date' => date('Y-m-d H:i:s'),
            'random_number' => rand(1, 1000),
            'demo_text' => self::getConfig('demo_setting', 'Demo Text'),
            'php_version' => PHP_VERSION,
            'redaxo_version' => rex::getVersion()
        ];
    }

    /**
     * AddOn-Status prüfen
     */
    public static function getStatus(): array
    {
        return [
            'installed' => true,
            'activated' => true,
            'config_count' => count(self::getConfig()),
            'install_date' => self::getConfig('install_date'),
            'version' => self::getConfig('version', '1.0.0')
        ];
    }

    /**
     * Log-Nachricht schreiben
     */
    public static function log(string $message, string $level = 'info'): void
    {
        $logData = [
            'addon' => self::ADDON_KEY,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        rex_logger::factory()->log($level, 'REDAXO Composer Demo AddOn: ' . $message, $logData);
    }

    /**
     * Demo-Funktionalität ausführen
     */
    public static function runDemo(): string
    {
        $demoData = self::generateDemoData();
        $output = "REDAXO Composer Demo AddOn Funktionalität ausgeführt:\n";
        
        foreach ($demoData as $key => $value) {
            $output .= "- {$key}: {$value}\n";
        }
        
        self::log('Composer Demo-Funktionalität ausgeführt');
        
        return $output;
    }
}