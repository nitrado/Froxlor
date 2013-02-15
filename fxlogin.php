<?php
require_once("FroxlorLogin.php");
require_once("lib/userdata.inc.php");
require_once("DB.mysqli.class.php");


$token = isset($_GET['t']) ? trim(urldecode($_GET['t'])) : '';
$label = 'nitrado';

if (empty($token)) {
    die("ERROR: No token received");
}

switch ($label) {
    case 'nitrado':
    default:
        if (!empty($_GET['dev']) && $_GET['dev'] == 'yes') {
            $checkUrl = 'https://psc:psc@dev.server.nitrado.net/deu/services/checkWebinterfaceToken/';
        } else {
            $checkUrl = 'https://server.nitrado.net/deu/services/checkWebinterfaceToken/';
        }
        break;
}
$db  = new DB($sql['host'],$sql['user'],$sql['password'],$sql['db']);
$login = new FroxlorLogin();
$login->setCheckUrl($checkUrl);
$login->setToken($token);
$login->setDB($db);
$login->login();
