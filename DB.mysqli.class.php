<?php
class DB {
        private $db;
        private $credentials;
        private $queries = array();
        
        public function __construct($host, $user, $pw, $db=null) {
            $this->credentials = array('host' => $host, 'user' => $user, 'pw' => $pw, 'db' => $db);
            $this->connect();
        }
        
        private function connect() {
            $tries = 0;
            do {
                $this->db = $this->realConnect();
                if (!$this->db) {
                    echo "Could not connect. Retrying 12 times (try=$tries)\n";
                    sleep(5);
                }
                $tries++;
                if ($tries > 12) break;
            } while ($this->db == false);
            
            if (!$this->db) {
                echo "Could not establish a database connection - cancelling\n";
                echo mysqli_error($this->db);
                return false;
            }
            if ($this->credentials['db'] != null) {
                return mysqli_select_db($this->db, $this->credentials['db']) or die(mysqli_error($this->db));
            }
            return true;
        }
        
        private function realConnect() {
            return mysqli_connect($this->credentials['host'], $this->credentials['user'], $this->credentials['pw']);
        }
        
        public function disconnect() {
            mysqli_close($this->db);
            $this->db = false;
        }
        
        public function addQuery($sql) {
            $this->queries[] = $sql;
        }
        
        public function clearMultiQuery() {
            $this->queries = array();
        }
        
        public function multiQuery() {
//          file_put_contents("db-sql.log", implode(";", $this->queries) . "\n", FILE_APPEND);
            $success =  mysqli_multi_query($this->db, implode(";", $this->queries));
            $this->clearMultiQuery();
            return $success;
        }
        
        public function query($sql, $returnRes = false) {
//          file_put_contents("db-sql.log", $sql . "\n", FILE_APPEND);
            if (!$this->db) {
                if (!$this->connect()) {
                    echo "Could not execute query. connect() failed\n";
                    return false;
                }
            }
            $res = mysqli_query($this->db, $sql);
            if ((is_object($res) && $returnRes) || !is_object($res)) {
                return $res;
            } else {
                $data = array();
                while ($row = mysqli_fetch_assoc($res)) {
                    $data[] = $row;
                }
            }
            return $data;
        }
        
        public function escape($n) {
            if (!$this->db) {
                $this->connect();       
            }
            return mysqli_real_escape_string($this->db, $n);
        }
        
        public function __destruct() {
            mysqli_close($this->db);
        }
}
