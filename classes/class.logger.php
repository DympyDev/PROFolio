<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Dark
 */
class logger {
    
    var $errorFile;
    var $logDir;

    function __construct($logDir) {
        $this->logDir = $logDir;
        $this->errorFile = $logDir . "errors.txt";
    }

    function writeToLog($text) {
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir);
        }
        if (file_exists($this->errorFile)) {
            $text = file_get_contents($this->errorFile) . "\n" . $text;
        }
        $errorWriter = fopen($this->errorFile, 'w');
        fwrite($errorWriter, $text);
        fclose($errorWriter);
    }
}
?>
