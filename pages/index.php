<?php

/**
 * Demo AddOn - Hauptseite
 * Zeigt wie man auf Manifest-Settings zugreift
 */

use Klxm\RedaxoComposerDemoAddon\Boot;
use KLXM\Composer\ComposerAddonHelper;

$content = '';

// Lade Boot-Klasse manuell falls Autoloading nicht funktioniert
if (!class_exists('Klxm\RedaxoComposerDemoAddon\Boot')) {
    require_once __DIR__ . '/../src/Boot.php';
}

// Manifest-Settings abrufen
$manifestSettings = ComposerAddonHelper::getCurrentSettings();
$packageName = ComposerAddonHelper::getCurrentPackageName();
$manifest = ComposerAddonHelper::getCurrentManifest();

// Übersicht
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
            <li>✅ <strong>Manifest Settings API (default_config)</strong></li>
            <li>✅ Konfigurationsverwaltung mit rex_config</li>
            <li>✅ Asset-Management</li>
        </ul>

        <div class="alert alert-info">
            <i class="rex-icon fa-info-circle"></i>
            <strong>Package:</strong> <code>' . rex_escape($packageName) . '</code><br>
            <strong>Version:</strong> <code>' . rex_escape($manifest['version'] ?? 'unknown') . '</code><br>
            <strong>Author:</strong> ' . rex_escape($manifest['author'] ?? 'unknown') . '
        </div>
    </div>
</div>
', false);

$content .= $fragment->parse('core/page/section.php');

// Manifest Settings Demo
$settingsRows = '';
foreach ($manifestSettings as $key => $value) {
    $displayValue = $value;
    if (is_bool($value)) {
        $displayValue = $value ? '✅ true' : '❌ false';
    } elseif (is_array($value)) {
        $displayValue = '<code>' . rex_escape(json_encode($value, JSON_PRETTY_PRINT)) . '</code>';
    } else {
        $displayValue = '<code>' . rex_escape($value) . '</code>';
    }
    
    $settingsRows .= '
            <tr>
                <td><strong>' . rex_escape($key) . '</strong></td>
                <td>' . $displayValue . '</td>
            </tr>';
}

$manifestFragment = new rex_fragment();
$manifestFragment->setVar('title', 'Manifest Settings (aus redaxo-addon.json)');
$manifestFragment->setVar('body', '
<div class="alert alert-success">
    <h4><i class="rex-icon fa-cog"></i> Zugriff auf default_config aus dem Manifest</h4>
    <p>Diese Settings werden aus dem <code>default_config</code> Block in der <code>redaxo-addon.json</code> gelesen:</p>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="250">Setting Key</th>
                <th>Wert aus Manifest</th>
            </tr>
        </thead>
        <tbody>' . $settingsRows . '
        </tbody>
    </table>
</div>

<div class="well">
    <h5><i class="rex-icon fa-code"></i> Code-Beispiel:</h5>
    <pre><code class="language-php">' . rex_escape('<?php
use KLXM\Composer\ComposerAddonHelper;

// IN BACKEND-SEITEN (Kontext verfügbar):
// getCurrentSetting() ermittelt automatisch das aktuelle AddOn
$settings = ComposerAddonHelper::getCurrentSettings();
$apiKey = ComposerAddonHelper::getCurrentSetting(\'api_key\', \'default-key\');
$maxItems = ComposerAddonHelper::getCurrentSetting(\'max_items\', 5);

// AUSSERHALB VON BACKEND-SEITEN (in Klassen, Templates, etc.):
// Package-Name MUSS angegeben werden
$packageName = \'klxm/redaxo-composer-demo-addon\';
$settings = ComposerAddonHelper::getSettings($packageName);
$apiKey = ComposerAddonHelper::getSetting($packageName, \'api_key\', \'default\');

// Settings sind PRO ADDON isoliert - kein Konflikt möglich!
// vendor1/addon → eigene Settings aus eigenem Manifest
// vendor2/addon → eigene Settings aus eigenem Manifest
') . '</code></pre>
    
    <div class="alert alert-warning" style="margin-top: 15px;">
        <strong><i class="rex-icon fa-exclamation-triangle"></i> Wichtig:</strong>
        <ul>
            <li>Settings kommen aus dem <code>default_config</code> Block im <strong>eigenen Manifest</strong></li>
            <li>Jedes AddOn hat seine <strong>eigenen, isolierten Settings</strong></li>
            <li>Kein Konflikt zwischen AddOns möglich (package-Name ist eindeutig)</li>
            <li><code>getCurrentSetting()</code> funktioniert nur in Backend-Seiten (Kontext!)</li>
            <li>In anderen Klassen: <code>getSetting($packageName, $key)</code> verwenden</li>
        </ul>
    </div>
</div>
', false);

$content .= $manifestFragment->parse('core/page/section.php');

// Praktische Anwendung
$apiKey = ComposerAddonHelper::getCurrentSetting('api_key', '');
$maxItems = ComposerAddonHelper::getCurrentSetting('max_items', 10);
$enableCaching = ComposerAddonHelper::getCurrentSetting('enable_caching', false);
$cacheLifetime = ComposerAddonHelper::getCurrentSetting('cache_lifetime', 3600);
$featureFlags = ComposerAddonHelper::getCurrentSetting('feature_flags', []);

$usageFragment = new rex_fragment();
$usageFragment->setVar('title', 'Praktische Anwendung der Settings');
$usageFragment->setVar('body', '
<div class="alert alert-warning">
    <h4><i class="rex-icon fa-lightbulb-o"></i> So verwendet man die Settings im Code:</h4>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">API-Integration</h3>
            </div>
            <div class="panel-body">
                <dl>
                    <dt>API Key:</dt>
                    <dd><code>' . rex_escape($apiKey) . '</code></dd>
                </dl>
                <pre><code class="language-php">' . rex_escape('// In Backend-Seiten:
$apiKey = ComposerAddonHelper::getCurrentSetting(\'api_key\');

// In anderen Klassen:
$pkg = \'klxm/redaxo-composer-demo-addon\';
$apiKey = ComposerAddonHelper::getSetting($pkg, \'api_key\');

if ($apiKey) {
    $client = new ApiClient($apiKey);
}') . '</code></pre>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Cache-Konfiguration</h3>
            </div>
            <div class="panel-body">
                <dl>
                    <dt>Caching aktiviert:</dt>
                    <dd>' . ($enableCaching ? '✅ Ja' : '❌ Nein') . '</dd>
                    <dt>Cache Lifetime:</dt>
                    <dd>' . rex_escape($cacheLifetime) . ' Sekunden</dd>
                </dl>
                <pre><code class="language-php">' . rex_escape('// In Backend-Seiten:
if (ComposerAddonHelper::getCurrentSetting(\'enable_caching\')) {
    $lifetime = ComposerAddonHelper::getCurrentSetting(\'cache_lifetime\');
    rex_cache::set($key, $data, $lifetime);
}

// In anderen Klassen:
$pkg = \'klxm/redaxo-composer-demo-addon\';
if (ComposerAddonHelper::getSetting($pkg, \'enable_caching\')) {
    $lifetime = ComposerAddonHelper::getSetting($pkg, \'cache_lifetime\');
    rex_cache::set($key, $data, $lifetime);
}') . '</code></pre>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Feature Flags</h3>
    </div>
    <div class="panel-body">
        <table class="table table-condensed">
            <tr>
                <td><strong>New Editor:</strong></td>
                <td>' . (($featureFlags['new_editor'] ?? false) ? '✅ Aktiviert' : '❌ Deaktiviert') . '</td>
            </tr>
            <tr>
                <td><strong>Experimental Mode:</strong></td>
                <td>' . (($featureFlags['experimental_mode'] ?? false) ? '✅ Aktiviert' : '❌ Deaktiviert') . '</td>
            </tr>
            <tr>
                <td><strong>Analytics:</strong></td>
                <td>' . (($featureFlags['analytics'] ?? false) ? '✅ Aktiviert' : '❌ Deaktiviert') . '</td>
            </tr>
        </table>
        <pre><code class="language-php">' . rex_escape('// In Backend-Seiten:
$flags = ComposerAddonHelper::getCurrentSetting(\'feature_flags\', []);
if ($flags[\'new_editor\'] ?? false) {
    $editor = new ModernEditor();
}

// In anderen Klassen (z.B. Service, Helper):
$pkg = \'klxm/redaxo-composer-demo-addon\';
$flags = ComposerAddonHelper::getSetting($pkg, \'feature_flags\', []);
if ($flags[\'analytics\'] ?? false) {
    Analytics::track($event);
}') . '</code></pre>
    </div>
</div>
', false);

$content .= $usageFragment->parse('core/page/section.php');

// User-Settings vs. Manifest-Settings
$userSettings = rex_config::get('redaxo_composer_demo_addon') ?: [];

$comparisonFragment = new rex_fragment();
$comparisonFragment->setVar('title', 'Unterschied: Manifest Settings vs. User Settings');
$comparisonFragment->setVar('body', '
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="rex-icon fa-file-code-o"></i> Manifest Settings (default_config)</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>✅ Definiert in <code>redaxo-addon.json</code></li>
                    <li>✅ Teil des AddOn-Codes (versioniert)</li>
                    <li>✅ Unveränderbar (Default-Werte)</li>
                    <li>✅ <strong>Pro AddOn isoliert (package-Name)</strong></li>
                    <li>✅ Ideal für Feature-Flags, API-Defaults, etc.</li>
                </ul>
                <strong>Zugriff in Backend-Seiten:</strong>
                <pre><code>ComposerAddonHelper::getCurrentSetting(\'key\')</code></pre>
                <strong>Zugriff in Klassen/Templates:</strong>
                <pre><code>ComposerAddonHelper::getSetting($pkg, \'key\')</code></pre>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="rex-icon fa-database"></i> User Settings (rex_config)</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>✅ Gespeichert in Datenbank</li>
                    <li>✅ Vom User änderbar</li>
                    <li>✅ Überschreibt Manifest-Defaults</li>
                    <li>✅ <strong>Namespace per AddOn-Key</strong></li>
                    <li>✅ Ideal für individuelle Konfiguration</li>
                </ul>
                <strong>Zugriff:</strong>
                <pre><code>rex_config::get(\'addon_key\', \'key\')</code></pre>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    <h4><i class="rex-icon fa-lightbulb-o"></i> Best Practice:</h4>
    <pre><code class="language-php">' . rex_escape('// EMPFOHLEN: Manifest-Default als Fallback für User-Setting

// In Backend-Seiten:
$manifestDefault = ComposerAddonHelper::getCurrentSetting(\'api_key\', \'\');
$userApiKey = rex_config::get(\'my_addon\', \'api_key\', $manifestDefault);

// In anderen Klassen:
$pkg = \'vendor/my-addon\';
$manifestDefault = ComposerAddonHelper::getSetting($pkg, \'api_key\', \'\');
$userApiKey = rex_config::get(\'my_addon\', \'api_key\', $manifestDefault);

// Oder kombiniert:
$apiKey = rex_config::get(\'my_addon\', \'api_key\') 
       ?: ComposerAddonHelper::getSetting($pkg, \'api_key\', \'fallback\');

// WICHTIG: Settings sind pro AddOn isoliert!
// vendor1/addon-a → eigenes Manifest, eigene Settings
// vendor2/addon-b → eigenes Manifest, eigene Settings
// Kein Konflikt möglich, da Package-Name eindeutig ist
') . '</code></pre>
</div>

<div class="well">
    <h5>Aktuelle User-Settings (aus Datenbank):</h5>
    ' . (empty($userSettings) ? '<p class="text-muted">Keine User-Settings gespeichert. Nutze die <a href="' . rex_url::currentBackendPage(['subpage' => 'settings']) . '">Einstellungen</a> Seite um welche anzulegen.</p>' : '<pre>' . rex_escape(print_r($userSettings, true)) . '</pre>') . '
</div>
', false);

$content .= $comparisonFragment->parse('core/page/section.php');

echo $content;