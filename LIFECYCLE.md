# 🔄 Lifecycle-System für Composer AddOns

Das REDAXO Composer AddOn-System unterstützt einen **Hybrid-Ansatz** für Installation, Aktivierung, Deaktivierung und Deinstallation.

## 📋 Übersicht

### Zwei Möglichkeiten:

1. **Manifest-basiert** (`redaxo-addon.json`) - Deklarativ und einfach
2. **PHP-Dateien** (`install.php`, `activate.php`, etc.) - Flexibel und mächtig

### Priorität:

✅ **PHP-Dateien haben Priorität** - Falls vorhanden, werden diese ausgeführt  
🔹 **Manifest wird als Fallback verwendet** - Wenn keine PHP-Datei existiert

---

## 🎯 Manifest-Lifecycle (`redaxo-addon.json`)

### Beispiel:

```json
{
  "lifecycle": {
    "install": {
      "directories": ["uploads", "cache", "logs"],
      "database": "install.sql",
      "copy_files": {
        "config/default.yml": "redaxo/data/addons/myaddon/config.yml"
      }
    },
    "activate": {
      "message": "AddOn wurde aktiviert"
    },
    "deactivate": {
      "message": "AddOn wurde deaktiviert"  
    },
    "uninstall": {
      "cleanup": ["cache/*", "logs/*"],
      "keep_data": true,
      "database": "uninstall.sql"
    }
  }
}
```

### Unterstützte Aktionen:

#### `install`:
- **`directories`** - Array von Verzeichnissen, die erstellt werden sollen
- **`database`** - SQL-Datei die ausgeführt werden soll
- **`copy_files`** - Object mit source → destination Mappings

#### `activate`:
- **`message`** - Nachricht die angezeigt wird

#### `deactivate`:
- **`message`** - Nachricht die angezeigt wird

#### `uninstall`:
- **`cleanup`** - Array von Pfaden die gelöscht werden sollen
- **`keep_data`** - Boolean, ob User-Daten behalten werden sollen
- **`database`** - SQL-Datei für Cleanup

---

## 💻 PHP-Hooks

### Unterstützte Dateien:

- `install.php` - Bei Installation
- `activate.php` - Bei Aktivierung  
- `deactivate.php` - Bei Deaktivierung
- `uninstall.php` - Bei Deinstallation

### Beispiel `install.php`:

```php
<?php

// Komplexe Logik
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    throw new Exception('PHP 7.4+ erforderlich!');
}

// Datenmigration
$sql = rex_sql::factory();
$sql->setQuery('CREATE TABLE IF NOT EXISTS ...');

// Config setzen
rex_config::set('myaddon', 'installed_at', time());

// API-Call
$api = new MyAddonApi();
$api->registerInstallation();

echo "Installation erfolgreich!";
```

---

## 🎨 Best Practices

### ✅ Verwende **Manifest** für:

- Einfache Verzeichnis-Operationen
- Standard SQL-Dateien
- Datei-Kopien
- Einfache Cleanup-Operationen

### ✅ Verwende **PHP-Hooks** für:

- Komplexe Installations-Logik
- Datenmigration aus anderen Systemen
- API-Calls und externe Services
- Bedingte Operationen
- Versionsprüfungen
- Custom Error-Handling

### ⚡ Hybrid-Ansatz:

```
install.sql          →  Basis-Schema
↓
install.php          →  Komplexe Logik, Migrationen, API-Calls
↓
Manifest "directories"  →  Verzeichnisse (wird übersprungen, da install.php existiert)
```

---

## 🔧 Entwickler-Tipps

### 1. Start Simple:

Beginne mit Manifest-Hooks. Füge PHP-Dateien nur hinzu, wenn du komplexe Logik brauchst.

### 2. Teste beide Wege:

```bash
# Test mit nur Manifest
rm install.php && composer install

# Test mit PHP-Hook
# install.php wieder hinzufügen
composer install
```

### 3. Logging:

```php
// In PHP-Hooks
$logFile = rex_path::addonData('myaddon', 'logs/install.log');
file_put_contents($logFile, "Install: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
```

### 4. Error-Handling:

```php
// PHP-Hooks können Exceptions werfen
if (!extension_loaded('gd')) {
    throw new Exception('GD-Extension erforderlich!');
}
```

---

## 📚 Weitere Infos

Siehe:
- `redaxo-addon.json` - Manifest-Beispiel
- `install.php` - PHP-Hook-Beispiel
- `install.sql` - SQL-Schema-Beispiel

**Pro-Tipp:** Beide Ansätze können kombiniert werden! PHP-Hook läuft zuerst, Manifest-Aktionen werden übersprungen wenn PHP-Datei existiert.
