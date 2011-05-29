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
    var $errors = "";
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
                                <br><input type="submit" name="profileEdit" class="login-submit" value="Edit">
            ';
            if ($this->getCurrentUser()->admin == 1) {
                $loginform .= '<br><input type="submit" name="admin" class="login-submit" value="Admin">';
            }
            $loginform .= '
                            </td>
                        </tr>
                    </table>
                </form>
            ';
        }
        return $loginform;
    }

    function getAdminForm() {
        $adminform = '
            <div align="center">
                Dit is het admin menu, hier kunnen meerdere opties worden aangepast.<br>
                Kies hieronder een optie om verder te gaan.<br>
                <a href="index.php?addProjectForm=1"><button class="login-submit">Projecten toevoegen</button></a>
                <!--
                <form action="index.php" method="POST">
                    <table>
                        <tr>
                            <td>
                                <input type="submit" name="addProjectForm" class="login-submit" value="Projecten toevoegen">
                            </td>
                        </tr>
                    </table>
                </form>
                -->
            </div>
            ';
        return $adminform;
    }

    function getAddProjectForm() {
        $addProject = '
            <div align="center">
                Voer hier de naam van een project in.<br>
                Op het moment dat U op de Toevoegen knop klikt, zit deze in de database.<br>
                <form action="index.php?addProjectForm=1" method="POST">
                    <table>
                        <tr>
                            <td>
                                <br><input type="text" name="projectName">
                                <input type="submit" name="addProject" class="login-submit" value="Toevoegen">
                            </td>
                        </tr>
                    </table>
                </form>
               <br>
        ';
        $result = $this->getProjects();
        if ($result != false) {
            $addProject .= 'Er bestaan al een paar projecten. Dat zijn:<br>';
            while ($fields = mysql_fetch_assoc($result)) {
                $addProject .= $fields['project_naam'] . '<br>';
            }
        }
        $addProject .= '</div>';
        return $addProject;
    }

    function addProject($_POST) {
        $project = stripslashes(mysql_real_escape_string($_POST['projectName']));
        $query = "INSERT INTO `projecten` (`project_naam`) VALUES ('$project');";
        $this->db->doQuery($query);
    }

    function getProjects() {
        $query = "SELECT `project_naam` FROM `projecten`;";
        return $this->db->doQuery($query);
    }

    function getRegisterForm($_POST = "") {
        $firstname = "";
        $insertion = "";
        $lastname = "";
        $email = "";
        $year = "";
        $id = "";
        if ($this->getCurrentUser() != false) {
            $firstname = $this->getCurrentUser()->firstname;
            $insertion = $this->getCurrentUser()->insertion;
            $lastname = $this->getCurrentUser()->lastname;
            $email = $this->getCurrentUser()->email;
            $year = $this->getCurrentUser()->year;
        } else if (isset($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
            $insertion = $_POST['insertion'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $year = $_POST['year'];
            $id = $_POST['llnr'];
        }
        $registerform = '
            <div align="center">
        ';
        if ($this->errors != "") {
            $registerform .= '<font color="red"><b>' . $this->errors . '</b></font>';
            $this->errors = "";
        }
        $registerform .= '
            <form action="index.php" method="POST">
                <table>
                    <tr>
                        <td>Voornaam: </td> 
                        <td><input type="text" name="firstname" value="' . $firstname . '"></td>
                    </tr>
                    <tr>
                        <td>Tussenvoegsel: </td>
                        <td><input type="text" name="insertion" value="' . $insertion . '"></td>
                    </tr>
                    <tr>
                        <td>Achternaam: </td>
                        <td><input type="text" name="lastname" value="' . $lastname . '"></td>
                    </tr>
                    <tr>
                        <td>Email-adres: </td>
                        <td><input type="text" name="email" value="' . $email . '"></td>
                    </tr>
        ';
        if ($this->getCurrentUser() == false) {
            $registerform .= '
                <tr>
                    <td>Leerling Nummer: </td>
                    <td><input type="text" name="llnr" value="' . $id . '"></td>
                </tr>
            ';
        }
        $registerform .= '
                        <tr>
                            <td>Studiejaar: </td>
                            <td><input type="text" name="year" value="' . $year . '"></td>
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
                        <li><a href="index.php?projects=' . $this->getCurrentUser()->id . '">Projecten</a></li>    
                    </ul>
                ';
            } else {
                $navmenu = '
                    <ul class="submenu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?showcase=none">Showcase</a></li>
                        <li><a href="index.php?pop=none">POP</a></li>
                        <li><a href="index.php?info=none">Wie?</a></li>
                        <li><a href="index.php?projects=none">Projecten</a></li>
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
                        li><a href="index.php?projects=' . $this->getUser($id)->id . '">Projecten</a></li>    
                    </ul>
                ';
            } else {
                $navmenu = '
                    <ul class="submenu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?showcase=none">Showcase</a></li>
                        <li><a href="index.php?pop=none">POP</a></li>
                        <li><a href="index.php?info=none">Wie?</a></li>
                        <li><a href="index.php?projects=none">Projecten</a></li>
                    </ul>
                ';
            }
        }
        return $navmenu;
    }

    function getUserInfo($id = "") {
        $userinfo = "";
        $image = 'images/no-pic.bmp';
        if ($id == "") {
            if ($this->getCurrentUser() != false) {
                $path = 'avatars/' . $this->getCurrentUser()->id . '_img.png';
                if (file_exists($path) == true) {
                    $image = $path;
                }
                $userinfo = '
                    <div id="avatar">
                        <img src="' . $image . '"/>
                    </div>
                    </br>Naam leerling:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getCurrentUser()->firstname . ' ' . $this->getCurrentUser()->insertion . ' ' . $this->getCurrentUser()->lastname . '</b></br>
                    </br>Leerling Nummer:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getCurrentUser()->id . '</b></br>
                    </br>Studie Jaar:</br>
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getCurrentUser()->year . '</b></br>';
                if ($image != $path) {
                    $userinfo .= '
                    <form action="index.php" method="POST" enctype="multipart/form-data">
                        Afbeelding:<input type="file" name="img">
                        <input type="submit" value="Verzenden">
                    </form>
                    ';
                }
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
                    <br><a href="index.php?newProject=1">Nieuw project uploaden</a>
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
                    Dit is het Persoonlijk Onwikkelingsplan van 
                    ' . $this->getCurrentUser()->firstname . ' ' . $this->getCurrentUser()->insertion . ' ' . $this->getCurrentUser()->lastname . '.
                ';
            } else {
                $pop = '
                    U bent niet ingelogd. </br>
                    Als U een Persoonlijk Ontwikkelingsplan wilt bekijken raden wij U aan te zoeken naar de desbetreffende leerling.
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
        $password = stripslashes(mysql_real_escape_string($_POST['password']));
        $errors = "";
        if ($this->getCurrentUser() == false) {
            if ($id == "") {
                $errors .= 'Het leerlingnummer veld was leeg.<br>';
            } else if ($this->getUser($id) != false) {
                $errors .= 'Het ingevulde leerlingnummer is al geregistreerd.<br>';
            }
        }
        if ($firstname == "") {
            $errors .= 'Het voornaam veld was leeg.<br>';
        }
        if ($lastname == "") {
            $errors .= 'Het achternaam veld was leeg.<br>';
        }
        if ($email == "") {
            $errors .= 'Het emailadres veld was leeg.<br>';
        } else if (!preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/', $email)) {
            $errors .= 'Het veld voor het emailadres bevat geen geldig emailadres.<br>';
        }
        if ($year == "") {
            $errors .= 'Het schooljaar veld was leeg.<br>';
        }
        if ($password == "") {
            $errors .= 'Het wachtwoord veld was leeg.<br>';
        } else if (!preg_match('/^(?=.*\d)(?=.*[A-Z]*[a-z]).{6,}$/', $password)) {
            $errors .= 'Het ingevulde wachtwoord voldoet niet aan de eisen.<br>';
        }
        if (strlen($year) != 4) {
            $errors .= 'Dat is geen geldig jaartal, een jaar heeft vier cijfers.<br>';
        } else if ($year < (Date("Y") - 100) || $year > Date("Y")) {
            $errors .= 'U kunt niet op ' . $year . ' op school gezeten hebben.<br>';
        }
        if ($errors != "") {
            $this->errors = $errors;
            $_POST['register'] = 1;
            return;
        }
        $password = sha1($_POST['password'] . " : " . $id);
        $query = "";
        if ($this->getCurrentUser() == false) {
            $query = "INSERT INTO `studenten` (id, firstname, insertion, lastname, password, email, year)
                    VALUES('$id', '$firstname', '$insertion', '$lastname',
                    '$password', '$email', '$year')";
        } else {
            $query = "UPDATE `studenten` SET `firstname`='$firstname', `insertion`='$insertion', `lastname`='$lastname',
                    `password`='$password', `email`='$email', `year`='$year'
                    WHERE `id` = '" . $this->getCurrentUser()->id . "'";
        }
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
        $homepage = "";
        if ($this->getCurrentUser() == false) {
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
        } else {
            $result = $this->db->doQuery(
                            "SELECT `projecten`.project_naam as `naam`
                FROM `projecten`, `projects`, `studenten`, `teamleden`, `teams`
                WHERE `projecten`.project_id = `projects`.project_id
                AND `projects`.teamnr = `teams`.teamnr
                AND `teams`.teamnr = `teamleden`.teamnr
                AND `teamleden`.leerlingnr = `studenten`.id
                AND `studenten`.id = '" . $this->getCurrentUser()->id . "';
            ");
            if ($result != false) {
                echo 'Projecten waar je lid van bent:<br>';
                while ($fields = mysql_fetch_assoc($result)) {
                    echo $fields['naam'] . '<br>';
                }
            }
        }
        return $homepage;
    }

    function getUser($id) {
        if (!class_exists('user')) {
            require "classes/class.user.php";
        }
        $query = "SELECT * FROM `studenten` WHERE `id` = '$id';";
        $result = $this->db->doQuery($query);
        if ($result != false) {
            return (new user($this->db, $id));
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
                        if (!is_dir($AvatarSaveDir)) {
                            mkdir($AvatarSaveDir);
                        }
                        if (imagepng($destination, 'avatars/' . $this->getCurrentUser()->id . "_img.png")) {
                            
                        }
                        imagedestroy($image);
                        imagedestroy($destination);
                        header('Content-Type: text/html');
                    } else {
                        echo "Verkeerd bestandstype.";
                    }
                } else {
                    echo "Bestand is te groot";
                }
            }
        }
    }

    function getAvailableProjects() {
        $project = "";
        $query = "SELECT * FROM `projecten`;";
        $result = $this->db->doQuery($query);
        if ($this->getCurrentUser() != false) {
            $project = '
                <form action="index.php?projects=' . $this->getCurrentUser()->id . '" method="POST">
                    <select name="projectid" onChange="this.form.submit();">
                        <option>Select Project</option>';
            while ($fields = mysql_fetch_assoc($result)) {
                $project .= '<option value="' . $fields['project_id'] . '">' . $fields['project_naam'] . '</option>';
            }
            $project .= '
                    </select>
                </form>
            ';
        } else {
            $project = "U kunt geen project toevoegen als u niet bent ingelogd!";
        }
        return $project;
    }
    
    function makeTeam($_POST) {
        $team = stripslashes(mysql_real_escape_string($_POST['teamnaam']));
        $sql = "INSERT INTO `teams` (`teamnaam`) VALUES('$team');";
        $this->db->doQuery($sql);
    }
    
    function getTeamsProjects($id) {
        $team = "";
        if ($this->getCurrentUser() != false) {
            $query = "SELECT * FROM `projects` WHERE `project_id` = '" . $id . "';";
            $result = $this->db->doQuery($query);
            if ($result != false) {
                $team = '
                    <form action="index.php" method="POST">
                        <select id="teams">
                            <option>Select Team</option>';
                while ($record = mysql_fetch_assoc($result)) {
                    $team .= '<option value="' . $record['project_id'] . '">' . $record['teamnr'] . '</option>';
                }
                $team .= '
                        </select>
                    </form>
                ';
            } else {
                $team = '
                    <form action="index.php" method="POST">
                        <input type="text" name="teamnaam">
                        <input type="submit" value="Maak aan">
                ';                
                $team .= '</form>';
            }
        } else {
            $team = "U kunt geen Team toevoegen als u niet bent ingelogd!";
        }
        return $team;
    }

    function getProjectPoster() {
        $poster = "";
        if ($this->getCurrentUser() != false) {
            $poster = '
                <div style="position:relative;top:0px;width:10%;height:500px;float:right;right:10px;">
                    <div align="center">
                        <script type="text/javascript">
                        var element = document.createElement("script");
                        element.setAttribute("type", "text/javascript");
                        element.setAttribute("src", "./js/bbcode.js");
                        document.getElementsByTagName("head")[0].appendChild(element);
                        </script>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'div\');">Div</button>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'h1\');">H1</button>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'h2\');">H2</button>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'br\');">BR</button>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'u\');"><u>U</u></button>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'i\');"><i>I</i></button>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'b\');"><b>B</b></button>
                        <button style="width:100%;" onClick="bbcode_ins(\'project\', \'url\');"><u><font color="blue">URL</font></u></button>
                        <select id="fontcolors" onchange="this.style.backgroundColor = this.options[this.selectedIndex].style.backgroundColor;" style="width:40%;height:23px;background-color:red">
                            <option value="red" style="background-color:red"></option>
                            <option value="blue" style="background-color:blue"></option>
                            <option value="green" style="background-color:green"></option>
                            <option value="black" style="background-color:black"></option>
                            <option value="white" style="background-color:white"></option>
                            <option value="gray" style="background-color:gray"></option>
                            <option value="yellow" style="background-color:yellow"></option>
                        </select><button style="width:60%;" onClick="bbcode_ins(\'project\', \'font\');">Font</button>
                    </div>
                </div>
                <div align="center">
                    <script type="text/javascript">
                    var counter = 1;
                    function addUpload() {
                        if (counter < 5) {
                            var form = document.getElementById("inputs");

                            var br = document.createElement("br");
                            form.appendChild(br);

                            var element = document.createElement("input");
                            element.setAttribute("type", "file");
                            element.setAttribute("id", "document"+counter);

                            form.appendChild(element);
                            counter++;
                        }
                    }
                    </script>
                    <form method="POST" id="projectform" action="index.php" enctype="multipart/form-data">
                        Projectnaam:
                        <input type="text" id="projectname" style="width:40%;">
                        <br><br>
                        <textarea id="project" style="width:50%;height:500px;resize:none;" onClick="if (this.value == \'Gebruik hier HTML om je project te plaatsen\')this.value = \'\';">Gebruik hier HTML om je project te plaatsen</textarea>
                        <br>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                        <div style="position:relative;right:20%;">
                            <a href="javascript:addUpload();">[+]</a>
                            <div id="inputs" style="">
                                <input type="file" id="document1">
                            </div>
                            <input type="submit" value="Opslaan">
                        </div>
                    </form>
                </div>
            ';
        } else {
            $poster = "U kunt geen project toevoegen als u niet bent ingelogd!";
        }
        return $poster;
    }

}