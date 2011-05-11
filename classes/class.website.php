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
    var $logger;
    var $user = "";
    var $mainConfigFile = "configs/config.php";

    function __construct() {
        require $this->mainConfigFile;
        require "classes/class.database.php";
        require "classes/class.logger.php";
        require "classes/class.session.php";
        $this->logger = new logger($LogDir);
        $this->db = new database($this->logger);
        $this->session = session::getInstance();
        $this->getCurrentUser();
    }

    function getHead() {
        $head = '
            <title>PROFolio</title>
            <meta name="robots" content="index, follow">
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <link href="css/style.css" rel="stylesheet" type="text/css">
            <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
            <script type="text/javascript">
            if (typeof jQuery == "undefined") { // Als jQuery niet bestaat op dit punt, is de file niet bereikbaar
                var fileref = document.createElement("script"); //  Maak een nieuw script object
                fileref.setAttribute("type","text/javascript"); //  Definieer het als een javascript file
                fileref.setAttribute("src", "./js/jquery.js");  //  Laad de lokale versie in de src attribuut
                if (typeof fileref != "undefined") {            //  Als ons net aangemaakte script object nog correc is
                    document.getElementsByTagName("head")[0].appendChild(fileref);  // Stop het in de head (laad de file)
                }
            }
            </script>
        ';
        return $head;
    }
    
    function getFooter() {
        return 'Copyright rommel komt hier';
    }

    function getLoginForm() {
        $loginform = '
            <form action="index.php" method="POST">
                <table align="right">
                    <tr>		
                        <td>
                            <input type="text" name="studentnr" class="login-field" value="Leerlingnummer" onclick="this.value=\'\';">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="password" class="login-field" value="Wachtwoord" onclick="this.value=\'\';">
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
        $registerform = '
            <div align="center">
                <form action="index.php" method="POST">
                    <table>
                        <tr>
                            <td>Voor naam: </td> 
                            <td><input type="text" name="firstname"></td>
                        </tr>
                        <tr>
                            <td>Tussenvoegsel: </td>
                            <td><input type="text" name="insertion"></td>
                        </tr>
                        <tr>
                            <td>Achter naam: </td>
                            <td><input type="text" name="lastname"></td>
                        </tr>
                        <tr>
                            <td>Leerling Nr.: </td>
                            <td><input type="text" name="llnr"></td>
                        </tr>
                        <tr>
                            <td>Klas: </td>
                            <td><input type="text" name="year"></td>
                        </tr>
                        <tr>
                            <td>E-mail: </td>
                            <td><input type="text" name="email"></td>
                        </tr>                    
                        <tr>
                            <td>Gebruikersnaam: </td>
                            <td><input type="text" name="username"></td>
                        </tr>
                        <tr>
                            <td>Wachtwoord: </td>
                            <td><input type="password" name="password"></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td><input type="submit" name="register" value="Registreer"></td>
                        </tr>
                    </table>
                </form>
            </div>
        ';
        return $registerform;
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

    function login($id, $password) {
        $username = stripslashes(mysql_real_escape_string(strtolower($username)));
        $password = stripslashes(mysql_real_escape_string($password));
        $result = $this->db->doQuery("SELECT `password` FROM `studenten` WHERE `id` = '$id';");
        if ($result != false) {     // Account bestaat...
            if (mysql_result($result, 0) == sha1($password . ":" . $id)) {    // Correct password
                require $this->mainConfigFile;
                setcookie($cookiename, $id . "," . $password, time() + ($cookietime * 60));
                $this->session->id = $id;
                $this->session->password = $password;
                $this->getCurrentUser();
            } else {
                return 'Onjuist wachtwoord';
            }
        } else {
            return 'Onbekende gebruikersnaam.';
        }
    }

    function register($_POST) {
        $id =  stripslashes(mysql_real_escape_string($_POST['llnr']));
        $firstname =  stripslashes(mysql_real_escape_string($_POST['firstname']));
        $insertion =  stripslashes(mysql_real_escape_string($_POST['insertion']));
        $lastname =  stripslashes(mysql_real_escape_string($_POST['lastname']));
        $password =  stripslashes(mysql_real_escape_string($_POST['password']));
        $email =  stripslashes(mysql_real_escape_string($_POST['email']));
        $year =  stripslashes(mysql_real_escape_string($_POST['year']));
        $password = sha1("$password :  $id");
        $query = "INSERT INTO `studenten` (id, firstname, insertion, lastname, password, email, year) "
                + "VALUES('" + $llnr + "', '" + $firstname + "', '" + $insertion + "', '" + $lastname 
                + "', '" + $password + "', '" + $email + "', '" + $year + "')";
        $result = $this->db->doQuery($query);
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
    
    function getUser($id) {
        $query = "SELECT * FROM `studenten WHERE `id` = '$id';";
        $result = $this->db->doQuery($query);
        if ($result != false) {
            return new user($id);
        } else {
            return false;
        }
    }
    
    function getCurrentUser() {
        require $this->mainConfigFile;
        if ($this->user == "") {
            if (isset($this->session->id) && isset($this->session->password)) {
                $user = new user($this->session->id, $this->session->password);
                if ($user != false) {
                    $this->user = $user;
                }
            } else if (isset($_COOKIE[$cookiename])) {
                $pieces = explode(",", $_COOKIE[$cookiename]);
                $id = $pieces[0];
                $password = $pieces[1];
                $user = new user($id, $password);
                if ($user != false) {
                    $this->user = $user;
                    return $this->user;
                }
            }
        } else {
            return $this->user;
        }
        return false;
    }

}