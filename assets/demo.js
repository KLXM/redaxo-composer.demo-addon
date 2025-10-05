/**
 * Demo AddOn JavaScript
 */

(function($) {
    'use strict';

    var DemoAddon = {
        
        init: function() {
            this.bindEvents();
            this.showWelcomeMessage();
            this.updateTimestamp();
        },

        bindEvents: function() {
            // Debug-Info Toggle
            $('.demo-addon-debug-toggle').on('click', this.toggleDebugInfo);
            
            // Form-Validierung
            $('form[data-demo-addon]').on('submit', this.validateForm);
            
            // Auto-Save für Einstellungen
            $('.demo-addon-auto-save').on('change', this.autoSave);
        },

        showWelcomeMessage: function() {
            if (sessionStorage.getItem('demo-addon-welcome-shown') !== 'true') {
                setTimeout(function() {
                    if (typeof rex !== 'undefined' && rex.message) {
                        rex.message.success('Demo AddOn erfolgreich geladen!', 3000);
                    }
                    sessionStorage.setItem('demo-addon-welcome-shown', 'true');
                }, 500);
            }
        },

        updateTimestamp: function() {
            var $timestamps = $('.demo-addon-timestamp');
            if ($timestamps.length > 0) {
                setInterval(function() {
                    var now = new Date();
                    var timeString = now.toLocaleString('de-DE');
                    $timestamps.text(timeString);
                }, 1000);
            }
        },

        toggleDebugInfo: function(e) {
            e.preventDefault();
            var $target = $($(this).data('target') || '.demo-addon-debug-info');
            $target.slideToggle();
            
            var $icon = $(this).find('i');
            if ($icon.hasClass('fa-eye')) {
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        },

        validateForm: function(e) {
            var valid = true;
            var $form = $(this);
            
            // Demo-Text Validierung
            var $demoText = $form.find('input[name="demo_setting"]');
            if ($demoText.length && $demoText.val().trim().length < 3) {
                valid = false;
                DemoAddon.showFieldError($demoText, 'Demo-Text muss mindestens 3 Zeichen lang sein.');
            }
            
            if (!valid) {
                e.preventDefault();
                rex.message.error('Bitte korrigieren Sie die Eingabefehler.');
            }
            
            return valid;
        },

        showFieldError: function($field, message) {
            $field.addClass('has-error');
            
            // Entferne vorherige Fehlermeldungen
            $field.next('.demo-addon-field-error').remove();
            
            // Füge neue Fehlermeldung hinzu
            $field.after('<div class="demo-addon-field-error text-danger small">' + message + '</div>');
            
            // Entferne Fehler bei nächster Eingabe
            $field.one('input', function() {
                $(this).removeClass('has-error');
                $(this).next('.demo-addon-field-error').remove();
            });
        },

        autoSave: function() {
            var $field = $(this);
            var fieldName = $field.attr('name');
            var fieldValue = $field.is(':checkbox') ? $field.is(':checked') : $field.val();
            
            // Zeige Speicher-Indikator
            var $indicator = $('<span class="demo-addon-save-indicator text-muted"> <i class="fa fa-spinner fa-spin"></i> Speichere...</span>');
            $field.after($indicator);
            
            // Simuliere AJAX-Speicherung
            setTimeout(function() {
                $indicator.html(' <i class="fa fa-check text-success"></i> Gespeichert').fadeOut(2000, function() {
                    $(this).remove();
                });
            }, 800);
        },

        // Utility-Funktionen
        formatBytes: function(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            
            var k = 1024;
            var dm = decimals < 0 ? 0 : decimals;
            var sizes = ['Bytes', 'KB', 'MB', 'GB'];
            
            var i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        },

        showNotification: function(message, type = 'info', duration = 3000) {
            if (typeof rex !== 'undefined' && rex.message) {
                rex.message[type](message, duration);
            } else {
                console.log('[Demo AddOn] ' + type.toUpperCase() + ': ' + message);
            }
        }
    };

    // Initialisierung
    $(document).ready(function() {
        DemoAddon.init();
    });

    // Global verfügbar machen
    window.DemoAddon = DemoAddon;

})(jQuery);