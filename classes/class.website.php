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
    var $session;
    var $mainConfigFile = "configs/config.php";

    function __construct() {
        require "classes/class.database.php";
        require "classes/class.session.php";
        $this->db = new database();
        $this->session = session::getInstance();
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
            <form action="index.php" method="POST">
                <table align="right">
                    <tr>		
                        <td>
                            <input type="text" name="username" class="login-field" value="Gebruikersnaam">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="password" class="login-field" value="Wachtwoord">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="login" class="login-submit" value="Login">
                            <input type="submit" name="register" class="login-submit" value="Register">
                        </td>
                    </tr>				
                </table>
            </form>
        ';
        return $loginform;
    }
    
    function getRegisterForm() {
        
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

    function login($username, $password) {
        $username = stripslashes(mysql_real_escape_string(strtolower($username)));
        $password = stripslashes(mysql_real_escape_string($password));
        $result = $this->db->doQuery("SELECT `password` FROM `studenten` WHERE `username` = '" . $username . "';");
        if ($result != false) {     // Account bestaat...
            if (mysql_result($result, 0) == sha1($password.":".$username)) {    // Correct password
                require $this->mainConfigFile;
                setcookie($cookiename, $username . "," . $password, time() + ($cookietime * 60));
            } else {
                return 'Onjuist wachtwoord';
            }
        } else {
            return 'Onbekende gebruikersnaam.';
        }
    }

    function register($_POST) {
        
    }

    function getResult($search) {
        return 'Als ik daadwerkelijk hier code zou neerzetten ipv text, dan zou hier je zoekresultaat komen.';
    }

    function getHomepage() {
        $homepage = '
            <h3>Content van de dingetjes</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vehicula, odio feugiat venenatis auctor, ligula odio auctor ipsum, ac luctus mi turpis nec risus. Vivamus rhoncus commodo lorem, non ultrices erat hendrerit eu. Vestibulum velit neque, dapibus ut commodo eget, scelerisque at eros. Phasellus vulputate, eros sit amet aliquet euismod, ante elit auctor leo, lobortis feugiat odio odio quis justo. Vivamus viverra orci non nisi gravida laoreet. Vivamus nec ligula tellus, in semper felis. Aliquam in ante quis elit faucibus porta vitae vitae risus. Duis ligula metus, bibendum fermentum pellentesque non, tempor non purus. Suspendisse ac arcu dolor, vel commodo tortor. In magna elit, lacinia in tincidunt non, fermentum eu purus.<br>
                Fusce gravida elementum tincidunt. Curabitur vehicula fringilla purus, et posuere lacus viverra eget. Cras quis tristique lectus. Mauris accumsan imperdiet feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum at malesuada quam. In nunc urna, tincidunt quis vulputate non, lobortis eget magna. Aliquam eleifend varius felis sit amet porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sit amet nulla est, sed fermentum orci. Mauris volutpat diam vitae orci faucibus eget eleifend neque iaculis. Suspendisse potenti. Pellentesque eu velit sed ligula luctus rutrum.<br>
                In dapibus neque egestas lacus hendrerit sit amet sodales turpis rutrum. Ut ut bibendum lacus. Nunc a pharetra urna. Nam bibendum consequat ante non molestie. Aliquam at quam non risus faucibus suscipit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ligula erat, pretium quis suscipit in, interdum vel neque. Pellentesque commodo placerat risus, ut sagittis leo adipiscing vitae. Nam sollicitudin fermentum euismod. Vivamus lacinia iaculis orci nec blandit. Mauris ullamcorper tincidunt condimentum. Etiam dapibus dignissim risus, et fringilla enim adipiscing sit amet. Vestibulum non ante quis orci sollicitudin dictum ut vitae ante. Proin ut suscipit orci. Maecenas auctor pellentesque neque non consequat. Donec ac risus ut neque sodales dignissim. Ut placerat nisl nec turpis vehicula auctor.<br>
                Ut a enim quis nunc laoreet luctus nec vel sapien. Mauris blandit ligula eu felis aliquam semper. Mauris luctus ligula porttitor quam ornare pretium. Fusce id tellus quam. Sed leo sapien, venenatis et porta ut, sodales sit amet arcu. Nulla facilisi. Morbi lacus turpis, interdum quis condimentum ac, ultricies in ante. Quisque ultrices, metus eget convallis iaculis, sem ante convallis ipsum, sit amet elementum purus elit vitae lacus. Nunc quis dui eu erat dictum faucibus at eget mi. Duis a erat in lacus blandit imperdiet nec sit amet lacus. Etiam id libero risus. Nullam et ipsum sit amet dui hendrerit condimentum vitae rhoncus est. Donec sagittis, lorem ac vestibulum porttitor, leo massa pharetra purus, id fringilla ante lectus id nisl. In facilisis, lacus quis egestas ullamcorper, erat orci suscipit libero, vel vestibulum massa neque id mauris. Vivamus ac magna eros, a pharetra tellus. Nulla urna lorem, scelerisque at pretium sit amet, facilisis ut est. Quisque et mi sapien, id adipiscing quam.
            </p>
        ';
        return $homepage;
    }
}