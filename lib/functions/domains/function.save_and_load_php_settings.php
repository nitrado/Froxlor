<?php

// Delimiter for the special php settings in the apache config. All stuff below
// this delimiter are php settings which will be automatically updated within
// the functions in this file.
define(PHP_SPECIALSETTINGS_DELIMITER, "##### PHP SETTINGS #####");

// Save the given php settings (an array which key is the settings and the value
// is the value of the php setting) to the specialsettings column for the given
// domain. To separate the saved settings from the manually placed settings, a
// delimiter is placed if the settings array os not empty.
function savePHPSettings($panel_domain_id, $settings) {
    global $db;
    $result = $db->query_first("SELECT `specialsettings` FROM `" . TABLE_PANEL_DOMAINS . "`
        WHERE id = '" . $panel_domain_id . "'");

    $apache_settings = "";
    foreach (explode("\n", $result['specialsettings']) as $line) {
        if ($line == PHP_SPECIALSETTINGS_DELIMITER) break;
        $apache_settings .= "$line\n";
    }
    $apache_settings = trim($apache_settings);

    $php_settings = "";
    foreach ($settings as $key => $value) {
        $directive = "php_value";
        if (in_array(strtolower($value), array("on", "off"))) $directive = "php_flag";
        if (strstr($key, "zend_extension") !== false) {
            $directive = "zend_extension";
            $key = "=";
        }
        $php_settings .= "$directive $key $value\n";
    }
    if ($php_settings != "") {
        $apache_settings = $apache_settings . "\n" . PHP_SPECIALSETTINGS_DELIMITER . "\n" . $php_settings;
    }

    $result = $db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
       `specialsettings` = '" . $db->escape($apache_settings) . "'
        WHERE id = '" . $panel_domain_id  . "'");

    return $apache_settings;
}

// Read the php settings from the specialsettins column from the domain. The
// function uses the delimiter do determine the beginning of the settings.
// The method returns an array with the settings read from the column.
function readPHPSettings($panel_domain_id) {
    global $db, $zend_extensions;
    $result = $db->query_first("SELECT `specialsettings` FROM `" . TABLE_PANEL_DOMAINS . "`
        WHERE id = '" . $panel_domain_id . "'");

    $php_settings = array();
    $zend_libs = array_flip($zend_extensions);
    $marker_reached = false;
    foreach (explode("\n", $result['specialsettings']) as $line) {
        if ($line == "") continue;
        if ($marker_reached) {

            // A normal php value/flag
            if (preg_match('/php_(value|flag) +([^ ]+) +(.*)/', $line, $matches)) {
                $php_settings[$matches[2]] = $matches[3];
            }

            // We have detected a zend extension
            if (preg_match('/zend_extension = (.+)/', $line, $matches)) {
                if ($zend_libs[$matches[1]]) {
                    $extension_key = $zend_libs[$matches[1]];
                    $php_settings[$extension_key] = "enabled"; //<-- Da ist der Wurm drin ...
                }
            }
        }
        if ($line == PHP_SPECIALSETTINGS_DELIMITER) $marker_reached = true;
    }

    return $php_settings;
}

