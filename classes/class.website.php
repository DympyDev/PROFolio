<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of website
 *
 * @author Dark
 */
class website {

    var $db;
    var $mainConfigFile = "configs/config.php";

    function __construct() {
        require "classes/class.database.php";
        $this->db = new database();
    }

    function getHead() {
        $head = '
            <title>PROFolio</title>
            <meta name="robots" content="index, follow">
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <link href="css/style.css" rel="stylesheet" type="text/css">
            <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        ';
        return $head;
    }

    function getLoginForm() {
        $loginform = '
            <form action="" method="get">
                <table align="right">
                    <tr>		
                        <td>
                            <input type="text" name="username" class="login-field" value="Gebruikersnaam">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="password" class="login-field" value="Wachtwoord">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" class="login-submit" value="Login">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="">Registreer</a>
                        </td>
                    </tr>				
                </table>
            </form>
        ';
        return $loginform;
    }
    
    function getNavMenu() {
        $navmenu = '
            <ul class="submenu">
                <li><a href="">Showcase</a></li>
                <li><a href="">POP</a></li>
                <li><a href="">Wie?</a></li>
            </ul>
        ';
        return $navmenu;
    }
    
    function getUserInfo() {
        return "Hier komt de gebruikerinfo";
    }
}