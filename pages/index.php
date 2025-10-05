<?php

/**
 * Demo AddOn - Hauptseite
 */

// Lade Boot-Klasse manuell falls Autoloading nicht funktioniert
if (!class_exists('Klxm\RedaxoComposerDemoAddon\Boot')) {
    require_once __DIR__ . '/../src/Boot.php';
}

use Klxm\RedaxoComposerDemoAddon\Boot;

$content = '';

// Debug Information anzeigen
$debugInfo = Boot::getDebugInfo();

$fragment = new rex_fragment();
$fragment->setVar('title', 'REDAXO Composer Demo AddOn - Übersicht');
$fragment->setVar('body', '
<div class="panel panel-default">
    <div class="panel-body">
        <h3><i class="rex-icon fa-puzzle-piece"></i> Willkommen beim REDAXO Composer Demo AddOn!</h3>
        <p>Dieses AddOn demonstriert die Funktionalität des neuen REDAXO Composer AddOn Systems.</p>
        
        <h4>Funktionen:</h4>
        <ul>
            <li>✅ Automatische Erkennung durch Composer Discovery System</li>
            <li>✅ PSR-4 Autoloading</li>
            <li>✅ Eigene Backend-Seiten</li>
            <li>✅ Extension Points</li>
            <li>✅ Konfigurationsverwaltung</li>
            <li>✅ Asset-Management</li>
        </ul>

        <h4>Gespeicherte Einstellungen:</h4>
        <div class="well">
            <table class="table table-striped">
                <tr>
                    <td><strong>Demo Text:</strong></td>
                    <td>' . rex_escape(rex_config::get('redaxo_composer_demo_addon', 'demo_setting', 'Nicht gesetzt')) . '</td>
                </tr>
                <tr>
                    <td><strong>Debug anzeigen:</strong></td>
                    <td>' . (rex_config::get('redaxo_composer_demo_addon', 'show_debug', false) ? '✅ Ja' : '❌ Nein') . '</td>
                </tr>
            </table>
        </div>

        <h4>Debug Information:</h4>
        <div class="well">
            <pre>' . rex_escape(print_r($debugInfo, true)) . '</pre>
        </div>

        <div class="alert alert-info">
            <i class="rex-icon fa-info-circle"></i>
            <strong>Hinweis:</strong> Dieses AddOn wurde über das Composer System installiert und aktiviert.
            Es zeigt die moderne Art der REDAXO AddOn-Entwicklung mit Composer-Integration.
        </div>
    </div>
</div>
', false);

$content .= $fragment->parse('core/page/section.php');

// Aktuelle Konfiguration anzeigen
$config = rex_config::get('redaxo_composer_demo_addon') ?: [];

$configRows = '';
foreach ($config as $key => $value) {
    $displayValue = is_bool($value) ? ($value ? 'true' : 'false') : $value;
    $configRows .= '
            <tr>
                <td><code>' . rex_escape($key) . '</code></td>
                <td>' . rex_escape($displayValue) . '</td>
            </tr>';
}

$configFragment = new rex_fragment();
$configFragment->setVar('title', 'Aktuelle Konfiguration');
$configFragment->setVar('body', '
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Schlüssel</th>
                <th>Wert</th>
            </tr>
        </thead>
        <tbody>' . $configRows . '
        </tbody>
    </table>
</div>
', false);

$content .= $configFragment->parse('core/page/section.php');

echo $content;