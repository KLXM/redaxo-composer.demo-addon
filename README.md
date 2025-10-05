# REDAXO Composer Demo AddOn

Ein modernes REDAXO AddOn, das die neuen Composer-Integration-Funktionen demonstriert.

## 🚀 Features

- ✅ **Composer-native Installation** - Installiert via `composer require`
- ✅ **PSR-4 Autoloading** - Moderne Klassenstruktur
- ✅ **Automatische Erkennung** - Wird vom Composer Discovery System erkannt
- ✅ **Backend-Integration** - Eigene Admin-Seiten
- ✅ **Extension Points** - Erweitert REDAXO-Funktionalität
- ✅ **Asset-Management** - CSS/JS Dateien werden automatisch geladen
- ✅ **Konfigurationsverwaltung** - Nutzt `rex_config`

## 📦 Installation

### Via Composer (empfohlen)
```bash
composer require klxm/redaxo-composer-demo-addon
```

### Manuelle Installation
1. Repository klonen oder ZIP herunterladen
2. In das REDAXO `vendor/` Verzeichnis entpacken
3. AddOn wird automatisch erkannt und kann aktiviert werden

## 🏗️ Struktur

```
redaxo-composer-demo-addon/
├── composer.json           # Composer-Konfiguration
├── redaxo-addon.json      # REDAXO AddOn Manifest
├── src/
│   ├── Boot.php           # Boot-Klasse (wird automatisch geladen)
│   └── DemoManager.php    # Hauptverwaltungsklasse
├── pages/
│   ├── index.php          # Hauptseite im Backend
│   └── settings.php       # Einstellungsseite
├── assets/
│   ├── demo.css          # Stylesheet
│   └── demo.js           # JavaScript
└── README.md             # Diese Datei
```

## ⚙️ Konfiguration

Das AddOn verwendet `rex_config` für die Konfigurationsverwaltung:

```php
// Konfiguration abrufen
$value = rex_config::get('redaxo_composer_demo_addon', 'demo_setting');

// Konfiguration setzen
rex_config::set('redaxo_composer_demo_addon', 'demo_setting', 'Neuer Wert');
```

### Standard-Konfiguration

```json
{
    "demo_setting": "Hallo REDAXO Composer!",
    "show_debug": false,
    "install_date": "2025-10-05 10:30:00",
    "version": "1.0.0"
}
```

## 🔧 Entwicklung

### Voraussetzungen
- PHP 7.4 oder höher
- REDAXO 5.12 oder höher
- Composer

### Lokale Entwicklung

1. Repository klonen:
```bash
git clone https://github.com/klxm/redaxo-composer-demo-addon.git
cd redaxo-composer-demo-addon
```

2. Dependencies installieren:
```bash
composer install
```

3. In REDAXO-Instanz verlinken oder kopieren

### Boot-Klasse

Die `Boot`-Klasse wird automatisch vom Discovery System geladen:

```php
<?php
namespace Klxm\RedaxoComposerDemoAddon;

class Boot
{
    public static function boot(): void
    {
        // AddOn-Initialisierung
        self::initConfig();
        self::registerExtensions();
        self::loadAssets();
    }
}
```

### Manager-Klasse

Die `DemoManager`-Klasse stellt zentrale Funktionen bereit:

```php
use Klxm\RedaxoComposerDemoAddon\DemoManager;

// Konfiguration verwalten
DemoManager::setConfig('key', 'value');
$value = DemoManager::getConfig('key');

// Demo-Daten generieren
$data = DemoManager::generateDemoData();

// Status abrufen
$status = DemoManager::getStatus();
```

## 📋 Backend-Seiten

Das AddOn registriert zwei Backend-Seiten:

1. **Übersicht** (`pages/index.php`)
   - Zeigt AddOn-Informationen
   - Debug-Daten anzeigen
   - Aktuelle Konfiguration

2. **Einstellungen** (`pages/settings.php`)
   - Konfiguration bearbeiten
   - Debug-Modus aktivieren/deaktivieren
   - System-Informationen

## 🎨 Assets

### CSS (`assets/demo.css`)
- Moderne Panel-Designs
- Responsive Layout
- Animationen und Übergänge

### JavaScript (`assets/demo.js`)
- Interaktive Funktionen
- Form-Validierung
- Auto-Save-Funktionalität

## 🔌 Extension Points

Das AddOn nutzt folgende Extension Points:

- `OUTPUT_FILTER` - Fügt Debug-Kommentare hinzu
- Weitere können in der `Boot`-Klasse registriert werden

## 📁 Manifest-Datei

Die `redaxo-addon.json` definiert AddOn-Eigenschaften:

```json
{
    "package": "klxm/redaxo-composer-demo-addon",
    "name": "REDAXO Composer Demo AddOn",
    "description": "Demonstration eines modernen REDAXO AddOns",
    "version": "1.0.0",
    "author": "KLXM <info@klxm.de>",
    "requires": {
        "redaxo": "^5.12",
        "php": "^7.4 || ^8.0"
    },
    "pages": {
        "redaxo_composer_demo_addon": {
            "title": "REDAXO Composer Demo",
            "icon": "rex-icon fa-puzzle-piece",
            "subpages": {
                "main": {"title": "Übersicht"},
                "settings": {"title": "Einstellungen"}
            }
        }
    }
}
```

## 🧪 Testing

Das AddOn kann getestet werden durch:

1. Installation via Composer
2. Aktivierung im REDAXO Backend
3. Aufruf der Backend-Seiten
4. Konfiguration der Einstellungen
5. Überprüfung der Frontend-Funktionalität

## 🤝 Contributing

Beiträge sind willkommen! Bitte:

1. Fork das Repository
2. Erstelle einen Feature-Branch
3. Committe deine Änderungen
4. Push zum Branch
5. Erstelle einen Pull Request

## 📄 Lizenz

MIT License - siehe [LICENSE](LICENSE) für Details.

## 🆘 Support

- **Issues**: [GitHub Issues](https://github.com/klxm/redaxo-composer-demo-addon/issues)
- **Email**: info@klxm.de
- **REDAXO Slack**: @klxm

## 🏷️ Versionen

- **1.0.0** - Erste Release
  - Grundfunktionalität
  - Backend-Integration
  - Composer-Support

## 🔗 Links

- [REDAXO CMS](https://redaxo.org/)
- [Composer](https://getcomposer.org/)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [REDAXO AddOn Entwicklung](https://redaxo.org/doku/master/addon-entwicklung)

---

**Entwickelt mit ❤️ für die REDAXO Community**