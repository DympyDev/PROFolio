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
            $file_content = file_get_contents($this->errorFile);
            if (strpos($file_content, $text) === false) {   // Als de huidige error nog NIET in de errorlog zit...
                $text = $file_content . "\n" . $text;
            } else {
                return;
            }
        }
        $errorWriter = fopen($this->errorFile, 'w');
        fwrite($errorWriter, $text);
        fclose($errorWriter);
    }
}
?>
