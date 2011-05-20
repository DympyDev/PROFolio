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

    function writeToLog($text) {
        require website::mainConfigFile;
        if (!is_dir($LogDir)) {
            mkdir($LogDir);
        }
        if (file_exists($LogDir . "/errors.txt")) {
            $file_content = file_get_contents($LogDir . "/errors.txt");
            if ($file_content != "") {
                if (strpos($file_content, $text) === false) {   // Als de huidige error nog NIET in de errorlog zit...
                    $text = $file_content . "\n" . $text;
                } else {
                    return;
                }
            }
        }
        $errorWriter = fopen($LogDir . "/errors.txt", 'w');
        fwrite($errorWriter, $text);
        fclose($errorWriter);
    }
}
?>
