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

    function __construct($errorFile) {
        $this->errorFile = $errorFile;
    }

    function writeToLog($text) {
        if (file_exists($this->errorFile)) {
            $text = file_get_contents($this->errorFile) . "\n" . $text;
        }
        $errorWriter = fopen($this->errorFile, 'w');
        fwrite($errorWriter, $text);
        fclose($errorWriter);
    }
}
?>
