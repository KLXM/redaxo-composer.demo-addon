<?php

/**
 * Demo AddOn - Hauptseite
 */

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
$config = rex_config::get('redaxo_composer_demo_addon', []);

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
        <tbody>
');

foreach ($config as $key => $value) {
    $configFragment->setVar('body', $configFragment->getVar('body') . '
            <tr>
                <td><code>' . rex_escape($key) . '</code></td>
                <td>' . rex_escape(is_bool($value) ? ($value ? 'true' : 'false') : $value) . '</td>
            </tr>
    ');
}

$configFragment->setVar('body', $configFragment->getVar('body') . '
        </tbody>
    </table>
</div>
', false);

$content .= $configFragment->parse('core/page/section.php');

echo $content;