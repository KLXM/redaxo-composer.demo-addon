<?php

/**
 * Demo AddOn - Einste//// Einstellungsformular
$formContent = '
<form method="post">';nstellungsformular
$formContent = '
<form method="post">';ngen
 */

// Lade DemoManager-Klasse manuell falls Autoloading nicht funktioniert
if (!class_exists('Klxm\RedaxoComposerDemoAddon\DemoManager')) {
    require_once __DIR__ . '/../src/DemoManager.php';
}

$content = '';
$message = '';

// Formular verarbeiten
if (rex_post('save', 'string') !== '') {
    $demoSetting = rex_post('demo_setting', 'string', '');
    $showDebug = rex_post('show_debug', 'boolean', false);
    
    rex_config::set('redaxo_composer_demo_addon', 'demo_setting', $demoSetting);
    rex_config::set('redaxo_composer_demo_addon', 'show_debug', $showDebug);
    
    $message = '<div class="alert alert-success">
        <i class="rex-icon fa-check"></i> Einstellungen wurden gespeichert!
    </div>';
}

// Aktuelle Werte laden
$demoSetting = rex_config::get('redaxo_composer_demo_addon', 'demo_setting', 'Hallo REDAXO Composer!');
$showDebug = rex_config::get('redaxo_composer_demo_addon', 'show_debug', false);

$content .= $message;

// Einstellungsformular mit Hidden Fields für GET-Parameter
$formContent = '
<form method="post">
    <input type="hidden" name="page" value="' . rex_escape(rex_get('page')) . '">
    <input type="hidden" name="composer_addon" value="' . rex_escape(rex_get('composer_addon')) . '">
    <input type="hidden" name="subpage" value="' . rex_escape(rex_get('subpage')) . '">
    
    <fieldset>
        <legend>REDAXO Composer Demo AddOn Einstellungen</legend>
        
        <div class="form-group">
            <label for="demo_setting">Demo Text:</label>
            <input type="text" 
                   class="form-control" 
                   id="demo_setting" 
                   name="demo_setting" 
                   value="' . rex_escape($demoSetting) . '"
                   placeholder="Geben Sie einen Demo-Text ein">
            <p class="help-block">Dieser Text wird in der Konfiguration gespeichert.</p>
        </div>
        
        <div class="checkbox">
            <label>
                <input type="checkbox" 
                       name="show_debug" 
                       value="1" 
                       ' . ($showDebug ? 'checked' : '') . '>
                Debug-Kommentare im Frontend anzeigen
            </label>
            <p class="help-block">Fügt HTML-Kommentare zum Frontend-Output hinzu.</p>
        </div>
        
        <div class="form-group">
            <button type="submit" name="save" value="1" class="btn btn-primary">
                <i class="rex-icon fa-save"></i> Speichern
            </button>
        </div>
    </fieldset>
</form>
';

$fragment = new rex_fragment();
$fragment->setVar('title', 'Einstellungen');
$fragment->setVar('body', $formContent, false);
$content .= $fragment->parse('core/page/section.php');

// Info-Box über das Composer System
$infoContent = '
<div class="alert alert-info">
    <h4><i class="rex-icon fa-info-circle"></i> Über das Composer AddOn System</h4>
    <p>Dieses AddOn demonstriert folgende Eigenschaften des neuen Systems:</p>
    <ul>
        <li><strong>Automatische Erkennung:</strong> AddOns werden durch <code>redaxo-addon.json</code> erkannt</li>
        <li><strong>PSR-4 Autoloading:</strong> Klassen werden automatisch geladen</li>
        <li><strong>Boot-System:</strong> <code>Boot::boot()</code> wird beim Laden aufgerufen</li>
        <li><strong>Konfiguration:</strong> Verwendet <code>rex_config</code> für Einstellungen</li>
        <li><strong>Extension Points:</strong> Erweitert REDAXO-Funktionalität</li>
    </ul>
    
    <h5>Installation via Composer:</h5>
    <pre><code>composer require klxm/redaxo-composer-demo-addon</code></pre>
    
    <h5>Entwicklung:</h5>
    <p>Das AddOn ist auf GitHub verfügbar: 
       <a href="https://github.com/klxm/redaxo-composer-demo-addon" target="_blank">
           https://github.com/klxm/redaxo-composer-demo-addon
       </a>
    </p>
</div>
';

$infoFragment = new rex_fragment();
$infoFragment->setVar('title', 'System Information');
$infoFragment->setVar('body', $infoContent, false);
$content .= $infoFragment->parse('core/page/section.php');

echo $content;