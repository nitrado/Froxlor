<?php

function checkNitradoServiceLimit($customerID, $action, $item, $value=null) {
    global $db;

    $res = $db->query_first("SELECT nitrado_service_type FROM `" . TABLE_PANEL_CUSTOMERS . "`
        WHERE customerid = '$customerID'");
    $serviceType = $res['nitrado_service_type'];

    // Restrictions matrix ("Blacklist"!)
    $restrictions = array(
        'beginner' => array(
            'general' => array(),
            'php' => array(
                'php_version' => array('5.4.12', '5.5.0alpha6'),
                //'zend_extension' => array(
                //    '/opt/php-builds/extensions/ioncube_loader_lin_5.4.so',
                //    '/opt/php-builds/extensions/ioncube_loader_lin_5.3.so'
                //),
                'memory_limit' => array('256M')
            ),
            //'mysql' => array(
            //    'allow_external_access' => array('1')
            //)
        )
    );

    if (!isset($restrictions[$serviceType][$action][$item])) return true;
    return !in_array($value, $restrictions[$serviceType][$action][$item]);
}
