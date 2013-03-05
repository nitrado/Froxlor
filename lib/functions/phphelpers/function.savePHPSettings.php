<?php

function savePHPSettings($panel_domain_id, $settings) {
    global $db;
    $result = $db->query_first("SELECT `special_phpsettings` FROM `" . TABLE_PANEL_DOMAINS . "`
        WHERE id = '" . $panel_domain_id . "'");

    $php_settings = "";
    foreach ($settings as $key => $value) {
        if ($value == "disabled") continue;
        if (strstr($key, "zend_extension") !== false) $key = "zend_extension";
        $php_settings .= "$key $value\n";
    }

    $db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
       `special_phpsettings` = '" . $db->escape($php_settings) . "'
        WHERE id = '" . $panel_domain_id  . "'");
    inserttask('1');
    inserttask('5');
    inserttask('9');
    inserttask('10');
    return $php_settings;
}

