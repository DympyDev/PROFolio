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
    const mainConfigFile = "configs/config.php";

    function __construct() {
        require website::mainConfigFile;
        require "classes/class.database.php";
        require "classes/class.logger.php";
        require "classes/class.session.php";
        $this->logger = new logger();
        $this->db = new database($this->logger);
        $this->session = session::getInstance();
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
        return 'Profolio is onderdeel van een groep HvA Informatica studenten.</br>
            Onder deze groep vallen Dymion Fritz, Giedo Terol, Ramon Vloon, Wouter Kievit en Tom Hoogeveen.';
    }

    function getLoginForm() {
        $loginform = "";
        if ($this->getCurrentUser() == false) {
            $loginform = '
                <form action="index.php" method="POST"><br>
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
        } else {
            $loginform = '
                <form action="index.php" method="POST"><br>
                    <table align="right">
                        <tr>
                            <td>
                                <input type="submit" name="logout" class="login-submit" value="Logout">
                            </td>
                        </tr>
                    </table>
                </form>
            ';
        }
        return $loginform;
    }

    function getRegisterForm() {
        $registerform = '
            <div align="center">
                <form action="index.php" method="POST">
                    <table>
                        <tr>
                            <td>Voornaam: </td> 
                            <td><input type="text" name="firstname"></td>
                        </tr>
                        <tr>
                            <td>Tussenvoegsel: </td>
                            <td><input type="text" name="insertion"></td>
                        </tr>
                        <tr>
                            <td>Achternaam: </td>
                            <td><input type="text" name="lastname"></td>
                        </tr>
                        <tr>
                            <td>Email-adres: </td>
                            <td><input type="text" name="email"></td>
                        </tr>
                        <tr>
                            <td>Leerling Nummer: </td>
                            <td><input type="text" name="llnr"></td>
                        </tr>
                        <tr>
                            <td>Studiejaar: </td>
                            <td><input type="text" name="year"></td>
                        </tr>
                        <tr>
                            <td>Wachtwoord: </td>
                            <td><input type="password" name="password"></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td><input type="submit" name="registreer" value="Registreer"></td>
                        </tr>
                    </table>
                </form>
            </div>
        ';
        return $registerform;
    }

    function getNavMenu($id = "") {
        $navmenu = "";
        if ($id == "") {
            if ($this->getCurrentUser() != false) {
                $navmenu = '
                    <ul class="submenu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?showcase=' . $this->getCurrentUser()->id . '">Showcase</a></li>
                        <li><a href="index.php?pop=' . $this->getCurrentUser()->id . '">POP</a></li>
                        <li><a href="index.php?info=' . $this->getCurrentUser()->id . '">Wie?</a></li>
                    </ul>
                ';
            } else {
                $navmenu = '
                    <ul class="submenu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?showcase=none">Showcase</a></li>
                        <li><a href="index.php?pop=none">POP</a></li>
                        <li><a href="index.php?info=none">Wie?</a></li>
                    </ul>
                ';
            }
        } else {
            if ($this->getUser($id) != false) {
                $navmenu = '
                    <ul class="submenu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?showcase=' . $this->getUser($id)->id . '">Showcase</a></li>
                        <li><a href="index.php?pop=' . $this->getUser($id)->id . '">POP</a></li>
                        <li><a href="index.php?info=' . $this->getUser($id)->id . '">Wie?</a></li>
                    </ul>
                ';
            } else {
                $navmenu = '
                    <ul class="submenu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?showcase=none">Showcase</a></li>
                        <li><a href="index.php?pop=none">POP</a></li>
                        <li><a href="index.php?info=none">Wie?</a></li>
                    </ul>
                ';
            }
        }
        return $navmenu;
    }

    function getUserInfo($id = "") {
        $userinfo = "";
        $image = 'no-pic.bmp';
        if ($id == "") {
            if ($this->getCurrentUser() != false) {
                $path = '../profolio/images/' . $this->getCurrentUser()->id . '_img.png';
                if (file_exists($path) == true) {
                    $image = $this->getCurrentUser()->id . '_img.png';
                }
                $userinfo = '
                    <div id="avatar">
                        <img src="/profolio/images/' . $image . '"/>
                    </div>
                    </br>Naam leerling:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getCurrentUser()->firstname . ' ' . $this->getCurrentUser()->insertion . ' ' . $this->getCurrentUser()->lastname . '</b></br>
                    </br>Leerling Nummer:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getCurrentUser()->id . '</b></br>
                    </br>Studie Jaar:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getCurrentUser()->year . '</b></br>
                ';
            } else {
                $userinfo = '
                    </br></br>Log in of maak een account aan om gebruik te kunnen maken van onze diensten.
                ';
            }
        } else {
            if ($this->getUser($id) != false) {
                $path = '../profolio/images/' . $this->getUser()->id . '_img.png';
                if (file_exists($path) == true) {
                    $image = $this->getUser($id)->id . '_img.png';
                }
                $userinfo = '
                    <div id="avatar">
                        <img src="/profolio/images/' . $image . '"/>
                    </div>
                    </br>Naam leerling:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getUser($id)->firstname . ' ' . $this->getUser($id)->insertion . ' ' . $this->getUser($id)->lastname . '</b></br>
                    </br>Leerling Nummer:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getUser($id)->id . '</b></br>
                    </br>Studie Jaar:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getUser($id)->year . '</b></br>
                ';
            } else {
                $userinfo = '
                    Er is geen gebruikers informatie beschikbaar voor de opgevraagde gebruiker. </br>
                    Controleer of de gebruiker wel bestaat of dat de ingevoerde data wel klopt en probeer het opnieuw.
                ';
            }
        }
        return $userinfo;
    }

    function getShowcase($id = "") {
        $showcase = "";
        if ($id == "") {
            if ($this->getCurrentUser() != false) {
                $showcase = '
                    Dit is de showcase van 
                    ' . $this->getCurrentUser()->firstname . ' ' . $this->getCurrentUser()->insertion . ' ' . $this->getCurrentUser()->lastname . '.
                ';
            } else {
                $showcase = '
                    U bent niet ingelogd. </br>
                    Als U een showcase wilt bekijken raden wij U aan te zoeken naar de desbetreffende leerling.
                    </br></br>
                    Als U uw eigen showcase openbaar wilt maken raden wij U aan een account aan te maken.
                ';
            }
        } else {
            if ($this->getUser($id) != false) {
                $showcase = '
                    Dit is de showcase van 
                    ' . $this->getUser($id)->firstname . ' ' . $this->getUser($id)->insertion . ' ' . $this->getUser($id)->lastname . '.
                ';
            } else {
                $showcase = '
                    Er is geen showcase beschikbaar voor de opgevraagde gebruiker. </br>
                    Controleer of de gebruiker wel bestaat of dat de ingevoerde data wel klopt en probeer het opnieuw.
                ';
            }
        }
        return $showcase;
    }

    function getPOP($id = "") {
        $pop = "";
        if ($id == "") {
            if ($this->getCurrentUser() != false) {
                $pop = '
                    Dit is het Persoonlijk Onwikkelings Plan van 
                    ' . $this->getCurrentUser()->firstname . ' ' . $this->getCurrentUser()->insertion . ' ' . $this->getCurrentUser()->lastname . '.
                ';
            } else {
                $pop = '
                    U bent niet ingelogd. </br>
                    Als U een Persoonlijk Ontwikkelingplan wilt bekijken raden wij U aan te zoeken naar de desbetreffende leerling.
                    </br></br>
                    Als U uw eigen Persoonlijk Ontwikkelingsplan openbaar wilt maken raden wij U aan een account aan te maken.
                ';
            }
        } else {
            if ($this->getUser($id) != false) {
                $pop = '
                    Dit is het Persoonlijk Ontwikkelingsplan van 
                    ' . $this->getUser($id)->firstname . ' ' . $this->getUser($id)->insertion . ' ' . $this->getUser($id)->lastname . '.
                ';
            } else {
                $pop = '
                    Er is geen Persoonlijk Ontwikkelingsplan beschikbaar voor de opgevraagde gebruiker. </br>
                    Controleer of de gebruiker wel bestaat of dat de ingevoerde data wel klopt en probeer het opnieuw.
                ';
            }
        }
        return $pop;
    }

    function getInfo($id = "") {
        $info = "";
        if ($id == "") {
            if ($this->getCurrentUser() != false) {
                $info = '
                    Dit is de overige informatie van 
                    ' . $this->getCurrentUser()->firstname . ' ' . $this->getCurrentUser()->insertion . ' ' . $this->getCurrentUser()->lastname . '.
                ';
            } else {
                $info = '
                    U bent niet ingelogd. </br>
                    Als U een de Info van een leerling wilt bekijken raden wij U aan te zoeken naar de desbetreffende leerling.
                    </br></br>
                    Als U uw eigen Info openbaar wilt maken raden wij U aan een account aan te maken.
                ';
            }
        } else {
            if ($this->getUser($id) != false) {
                $info = '
                    Dit is de overige informatie van 
                    ' . $this->getUser($id)->firstname . ' ' . $this->getUser($id)->insertion . ' ' . $this->getUser($id)->lastname . '.
                ';
            } else {
                $info = '
                    Er is geen info beschikbaar voor de opgevraagde gebruiker. </br>
                    Controleer of de gebruiker wel bestaat of dat de ingevoerde data wel klopt en probeer het opnieuw.
                ';
            }
        }
        return $info;
    }

    function login($id, $password) {
        $id = stripslashes(mysql_real_escape_string($id));
        $query = "SELECT `password` FROM `studenten` WHERE `id` = '$id';";
        $result = $this->db->doQuery($query);
        if ($result != false) {         // Account bestaat...
            $password = sha1($password . " : " . $id);
            if (mysql_result($result, 0) == $password) {    // Correct password
                require website::mainConfigFile;
                setcookie($cookiename, $id . "," . $password, time() + ($cookietime * 60));
                $this->session->id = $id;
                $this->session->password = $password;
                $this->getCurrentUser();
            } else {
                return 'Onjuist wachtwoord';
            }
        } else {
            return 'Onbekend leerlingnummer.';
        }
    }

    function logout() {
        require website::mainConfigFile;
        setcookie($cookiename, "", time() - 600);
        $this->session->destroy();
        return '<script type="text/javascript">window.location="index.php";</script>';
    }

    function register($_POST) {
        $id = stripslashes(mysql_real_escape_string($_POST['llnr']));
        $firstname = stripslashes(mysql_real_escape_string($_POST['firstname']));
        $insertion = stripslashes(mysql_real_escape_string($_POST['insertion']));
        $lastname = stripslashes(mysql_real_escape_string($_POST['lastname']));
        $email = stripslashes(mysql_real_escape_string($_POST['email']));
        $year = stripslashes(mysql_real_escape_string($_POST['year']));
        $password = sha1($_POST['password'] . " : " . $id);
        $query = "INSERT INTO `studenten` (id, firstname, insertion, lastname, password, email, year)
                VALUES('$id', '$firstname', '$insertion', '$lastname',
                '$password', '$email', '$year')";
        $this->db->doQuery($query);
        return $this->login($id, $_POST['password']);
    }

    function getResult($search) {
        $result = "";
        if (strlen($search) > 3) {
            $result .= "Gebruikers die matchen met uw zoekterm:<br>";
            $query = $this->db->doQuery("SELECT * FROM `studenten` WHERE `firstname` REGEXP '$search' OR `lastname` REGEXP '$search' OR `id` = '$search';");
            if ($query != false) {
                while ($fields = mysql_fetch_assoc($query)) {
                    $result .= $fields['firstname'] . ' ' . $fields['insertion'] . ' ' . $fields['lastname'] . '<br>';
                }
            } else {
                $result .= "Geen<br>";
            }

            $result .= "<br><hr><br>Teams die matchen met uw zoekterm:<br>";
            $query = $this->db->doQuery("SELECT * FROM `teams` WHERE `teamnaam` REGEXP '$search' OR `teamnr` REGEXP '$search';");
            if ($query != false) {
                while ($fields = mysql_fetch_assoc($query)) {
                    $result .= $fields['teamnaam'] . '<br>';
                }
            } else {
                $result .= "Geen<br>";
            }

            $result .= "<br><hr><br>Projecten die matchen met uw zoekterm:<br>";
            $query = $this->db->doQuery("SELECT * FROM `projects` WHERE `name` REGEXP '$search' OR `id` REGEXP '$search';");
            if ($query != false) {
                while ($fields = mysql_fetch_assoc($query)) {
                    $result .= $fields['teamnr'] . ' ' . $fields['name'] . '<br>';
                }
            } else {
                $result .= "Geen<br>";
            }
        } else {
            $result = "Die zoekterm is te kort, probeer meer dan 3 letters te gebruiken<br>";
        }
        return $result;
    }

    function getHomepage() {
        $homepage = '
            <h1>Profolio</h1>
            <h3>Een online portfolio voor informatica studenten</h3>
            <p>
                Hallo en welkom op deze site. </br>
                Om gebruik te maken van al onze diensten raden wij U aan een account aan te maken.</br>
                Zodra U dit gedaan heeft kunt U uw Portfolio, Persoonlijk Ontwikkelingplan en extra informatie over jezelf op deze site plaatsen.</br>
            </p>
            <p>
                Als U alleen de Portfolio\'s of Persoonlijke Ontwikkelingsplannen wilt bekijken verwijzen wij U graag door naar de zoekfunctie van onze site.</br>
                </br>
                Wij hopen dat U kunt vinden wat U zoekt.
            </p>
        ';
        return $homepage;
    }

    function getUser($id) {
        if (!class_exists('user')) {
            require "classes/class.user.php";
        }
        $query = "SELECT * FROM `studenten WHERE `id` = '$id';";
        $result = $this->db->doQuery($query);
        if ($result != false) {
            return new user($this->db, $id);
        } else {
            return false;
        }
    }

    function getCurrentUser() {
        require website::mainConfigFile;
        if (!class_exists('user')) {
            require "classes/class.user.php";
        }
        if ($this->user == "") {
            $user = "";
            if (isset($this->session->id) && isset($this->session->password)) {
                $user = new user($this->db, $this->session->id, $this->session->password);
            } else if (isset($_COOKIE[$cookiename])) {
                $pieces = explode(",", $_COOKIE[$cookiename]);
                $id = $pieces[0];
                $password = $pieces[1];
                $user = new user($this->db, $id, $password);
            } else {
                return false;
            }

            if ($user->exists == true) {
                $this->user = $user;
                return $this->user;
            }
        } else {
            return $this->user;
        }
        return false;
    }

    function uploadImage($_FILES) {
        if (isset($_FILES)) {
            if ($_FILES["img"]["error"] > 0) {
                echo "Bestand is corrupt.";
            } else {
                if ($_FILES["img"]["size"] < 1000000) {
                    require website::mainConfigFile;
                    if (in_array($_FILES["img"]["type"], $AvatarAllowedFiletypes)) {
                        $orimg = $_FILES["img"]["tmp_name"];
                        $orsize = getimagesize($orimg);
                        $orw = $orsize[0];
                        $orh = $orsize[1];
                        $xscale = 100 / $orw;
                        $yscale = 150 / $orh;
                        $scale = min($xscale, $yscale);
                        $new = ($orw * $scale);
                        $neh = ($orh * $scale);
                        $image = "";
                        switch ($_FILES["img"]["type"]) {
                            case "image/gif":
                                $image = imagecreatefromgif($orimg);
                                break;
                            case "image/png":
                                $image = imagecreatefrompng($orimg);
                                break;
                            default:
                                $image = imagecreatefromjpeg($orimg);
                                break;
                        }
                        $destination = imagecreatetruecolor(100, 150);
                        imagecopyresampled($destination, $image, ((($orw * $xscale) - $new) / 2), ((($orh * $yscale) - $neh) / 2), 0, 0, $new, $neh, $orw, $orh);
                        header('Content-Type: image/png');
                        imagepng($destination, $this->getCurrentUser()->id . "_img.png", 100);
                        imagedestroy($image);
                        imagedestroy($destination);
                        echo "<img src='" . $this->getCurrentUser()->id . "_img.png' width='100' height='150'>";
                    } else {
                        echo "Verkeerd bestandstype.";
                    }
                } else {
                    echo "Bestand is te groot";
                }
            }
        }
    }

}