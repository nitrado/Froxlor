<?php
/**
 * @property DB $db
 */
class FroxlorLogin {
    private $db = '';
    private $url = '';
    private $token = '';
    
    private $loginname = '';
    private $userid = 0;
    private $language = 'de';
    
    public function setCheckUrl($url) {
        $this->url = $url;
    }
    
    public function setToken($token) {
        $this->token = $token;
    }
    
    public function setDB($db) {
        $this->db = $db;
    }
    
    public function login() {
        $data = $this->getLoginDataFromUrl();
        if (empty($data->alias)) {
            $this->error('No alias received');
        }
        $this->setLoginname($data->alias);
        $this->setLanguage(empty($data->lang) ? 'de' : $data->lang);
        $this->userid = $this->getFroxlorUserid();
        $session = $this->getFroxlorSession();
        if (empty($session)) {
            $this->error('Could not create session');
        }
        header('LOCATION: customer_index.php?s=' . urlencode($session));
    }
    
    private function setLanguage($languageCode) {
        switch ($languageCode) {
            case 'deu':
                $language = 'Deutsch';
                break;
            case 'eng':
            default:
                $language = 'English';
                break;
        }
        $this->language = $language;
    }
    
    private function getFroxlorSession() {
        if (empty($this->userid))
                return false;
        $s = md5(uniqid(microtime(), 1));
        $this->db->query("DELETE FROM panel_sessions WHERE userid=" . (int)$this->userid);
        $remote_addr = $_SERVER['REMOTE_ADDR'];
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $http_user_agent = 'unknown';
        } else {
            $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
        }
        $inserted = $this->db->query("INSERT INTO `panel_sessions`
            (`hash`, `userid`, `ipaddress`, `useragent`, `lastactivity`, `language`, `adminsession`)
            VALUES
            (
                '" . $this->db->escape($s) . "',
                '" . (int)$this->userid . "',
                '" . $this->db->escape($remote_addr) . "', 
                '" . $this->db->escape($http_user_agent) . "',
                '" . time() . "', 
                '" . $this->db->escape($this->language) . "',
                '0');");
        return $inserted ? $s : false;
    }
    
    private function setLoginname($loginname) {
        $this->loginname = $loginname;
    }
    
    private function getFroxlorUserid() {
        $row = $this->db->query("SELECT customerid FROM panel_customers WHERE loginname='".$this->db->escape($this->loginname)."';");
        if (empty($row[0]['customerid'])) {
            return 0;
        }
        return $row[0]['customerid'];
    }
    
    private function getLoginDataFromUrl() {
        $response = file_get_contents($this->url . $this->token);
        if (!$response) {
            $this->error('Invalid Response');
        }
        $data = json_decode($response);
        if (!is_object($data)) {
            $this->error('No object received');
        }
        return $data;
    }
    
    private function error($msg) {
        die($msg);
    }
}