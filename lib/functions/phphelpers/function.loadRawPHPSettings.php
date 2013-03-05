<?php

function loadRawPHPSettings($panel_domain_id) {
    global $db;
    $result = $db->query_first("SELECT `special_phpsettings` FROM `" . TABLE_PANEL_DOMAINS . "`
        WHERE id = '" . $panel_domain_id . "'");
    return $result['special_phpsettings'];
}

