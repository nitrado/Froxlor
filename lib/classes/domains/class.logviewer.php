<?php

class LogViewer {
    private $user = null;
    private $logpath = "/var/customers/logs";
    private $maxRequestSize = 300; // in kbytes

    function __construct($user) {
        $this->user = $user;
    }

    private function _logFilename($type) {
        return "{$this->logpath}/{$this->user}-{$type}.log";
    }

    function newLines($logfileType, $lastSize=0) {
        clearstatcache();

        $filename = $this->_logFilename($logfileType);
        if (!file_exists($filename)) return false;

        $length = filesize($filename) - $lastSize;
        if ($length === 0) return false;

        if ($length > $this->maxRequestSize*1024)
            $length = $this->maxRequestSize*1024;

        $fh = fopen($filename, 'r');
        fseek($fh, -$length, SEEK_END);
        $lines = explode("\n", fread($fh, $length));
        fclose($fh);

        if (end($lines) === '') array_pop($lines);

        return array('size' => filesize($filename), 'lines' => $lines);
    }
}
