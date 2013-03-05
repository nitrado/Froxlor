<?php

require_once("../simpletest/autorun.php");

require_once("../lib/userdata.inc.php");
require_once("../lib/tables.inc.php");
require_once("../lib/functions.php");
$db = new db($sql['host'], $sql['user'], $sql['password'], $sql['db']);


class SavePHPSettingsTest extends UnitTestCase {
    function _getSettings() {
        global $db;
        $settings = $db->query_first("SELECT `specialsettings` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE id = '12'");
        return $settings['specialsettings'];
    }

    function testEmptyCase() {
        savePHPSettings(12, array());
        $this->assertEqual($this->_getSettings(), savePHPSettings(12, array()));
    }

    function testSimpleCase() {
        savePHPSettings(12, array());
        $before = $this->_getSettings();
        $this->assertNotEqual($before, savePHPSettings(12, array("save_mode" => "off")));
        $this->assertPattern('/php_flag/', savePHPSettings(12, array("save_mode" => "off")));
    }

    function testMultipleTypes() {
        $this->assertPattern('/php_flag/', savePHPSettings(12, array("save_mode" => "off")));
        $this->assertPattern('/php_flag/', savePHPSettings(12, array("save_mode" => "none", "asdf" => "off")));
    }

    function testRemoveSettings() {
        savePHPSettings(12, array('key1' => 'value'));
        $this->assertNoPattern('/#####/', savePHPSettings(12, array()));
    }
}

class ReadPHPSettingsTest extends UnitTestCase {
    function _getSettings() {
        global $db;
        $settings = $db->query_first("SELECT `specialsettings` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE id = '12'");
        return $settings['specialsettings'];
    }

    function testEmptyCase() {
        savePHPSettings(12, array());
        $this->assertEqual(0, count(readPHPSettings(12)));
    }

    function testSingleValue() {
        savePHPSettings(12, array('key1' => 'val1'));
        $this->assertEqual(1, count(readPHPSettings(12)));
    }

    function testMultipleValues() {
        savePHPSettings(12, array('key1' => 'val1', 'key2' => 'off'));
        $this->assertEqual(2, count(readPHPSettings(12)));
    }
}

