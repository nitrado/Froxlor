<?php
function readPHPSettings($panel_domain_id) {
    global $db, $zend_extensions;
    $result = $db->query_first("SELECT `special_phpsettings` FROM `" . TABLE_PANEL_DOMAINS . "`
        WHERE id = '" . $panel_domain_id . "'");

    $php_settings = array();
    $zend_libs = array_flip($zend_extensions);
    foreach (explode("\n", $result['special_phpsettings']) as $line) {
        if ($line == "") continue;
        if (preg_match('/([^ ]+) +(.*)/', $line, $matches)) {
            if ($matches[1] == "zend_extension") {
                if ($zend_libs[$matches[2]]) {
                    $extension_key = $zend_libs[$matches[2]];
                    $php_settings[$extension_key] = "enabled";
                }
            } else {
                $php_settings[$matches[1]] = $matches[2];
            }
        }
    }

    return $php_settings;
}

