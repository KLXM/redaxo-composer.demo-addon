<?php

/**
 * Demo AddOn Boot Class
 * 
 * Wird automatisch vom Composer AddOn Discovery System geladen
 */

namespace Klxm\RedaxoComposerDemoAddon;

use rex;
use rex_config;
use rex_extension;
use rex_extension_point;
use rex_i18n;
use rex_url;
use rex_view;

class Boot
{
    /**
     * AddOn Boot-Prozess
     */
    public static function boot(): void
    {
        // Standard-Konfiguration setzen falls nicht vorhanden
        if (!rex_config::has('redaxo_composer_demo_addon')) {
            rex_config::set('redaxo_composer_demo_addon', [
                'demo_setting' => 'Hallo REDAXO Composer!',
                'show_debug' => false
            ]);
        }

        // Extension Points registrieren
        rex_extension::register('OUTPUT_FILTER', [self::class, 'addDemoComment']);
        
        // Backend Assets hinzufügen (nur im Backend)
        if (rex::isBackend()) {
            rex_view::addCssFile(rex_url::addonAssets('redaxo_composer_demo_addon', 'demo.css'));
            rex_view::addJsFile(rex_url::addonAssets('redaxo_composer_demo_addon', 'demo.js'));
        }
    }

    /**
     * Fügt einen Demo-Kommentar zum HTML-Output hinzu
     */
    public static function addDemoComment(rex_extension_point $ep): string
    {
        $content = $ep->getSubject();
        
        if (rex_config::get('redaxo_composer_demo_addon', 'show_debug', false)) {
            $comment = "\n<!-- REDAXO Composer Demo AddOn aktiv - " . date('Y-m-d H:i:s') . " -->\n";
            $content = str_replace('</head>', $comment . '</head>', $content);
        }
        
        return $content;
    }

    /**
     * Hilfsfunktion für AddOn-Assets
     */
    public static function getAssetUrl(string $file): string
    {
        return rex_url::addonAssets('redaxo_composer_demo_addon', $file);
    }

    /**
     * Debug-Information ausgeben
     */
    public static function getDebugInfo(): array
    {
        return [
            'addon_name' => 'REDAXO Composer Demo AddOn',
            'version' => '1.0.0',
            'loaded_via' => 'Composer Discovery System',
            'config' => rex_config::get('redaxo_composer_demo_addon', []),
            'boot_time' => date('Y-m-d H:i:s')
        ];
    }
}