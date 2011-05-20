<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <?php
    require "classes/class.website.php";
    $website = new website();
    if (isset($_POST['login'])) {
        echo $website->login($_POST['studentnr'], $_POST['password']);
    } else if (isset($_POST['registreer'])) {
        $website->register($_POST);
    } else if (isset($_POST['logout'])) {
        echo $website->logout();
    } else if (isset($_FILES['img'])) {
        $website->uploadImage($_FILES);
    }
    ?>
    <head>
        <?php
        echo $website->getHead();
        ?>
    </head>
    <body id="page">
        <!-- wrapper -->
        <div class="rapidxwpr floatholder">
            <!-- header -->
            <div id="header">  
                <!-- logo -->
                <a href="index.php"><img id="logo" class="correct-png" src="images/logo.png" alt="Home" title="Home"></a>
                <!-- / logo -->    
                <!-- loginform -->
                <div class="loginform">
                    <?php
                    echo $website->getLoginForm();
                    ?>
                </div>
                <!-- / loginform -->  
            </div>
            <!-- / header -->  
            <!-- menu -->
            <div id="menu">  
                <div class="searchform">
                    <form action="index.php" method="get">
                        <input type="text" name="search" class="search-field">
                        <input type="submit" name="submit" class="search-submit" value="Zoek">
                    </form>
                </div>    
                <!-- navigation -->
                <div class="nav">
                    <?php
                    echo $website->getNavMenu();
                    ?>
                </div>
                <!-- / navigation -->  
            </div>
            <!-- / menu -->  
            <!-- main body -->
            <div id="middle">
                <div class="background layoutleft">    
                    <div id="main">
                        <div id="main_container" class="clearingfix">
                            <div id="mainmiddle" class="floatbox withright" >       
                                <!-- right column -->
                                <div id="right">
                                    <div id="right_container" class="clearingfix">
                                        <?php
                                        echo $website->getUserInfo();
                                        ?>
                                    </div>
                                </div>
                                <!-- / right column -->         
                                <!-- content column -->
                                <div id="content">      
                                    <!-- intro -->
                                    <div class="intro">
                                        <?php
                                        if (isset($_GET['search'])) {
                                            echo $website->getResult($_GET['search']);
                                        } else if (isset($_POST['register'])) {
                                            echo $website->getRegisterForm();
                                        } else {
                                            echo $website->getHomepage();
                                        }
                                        ?>
                                    </div>
                                    <!-- / intro -->      
                                </div>
                                <!-- / content column -->          
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <!-- / main body -->
        </div>
        <!-- / wrapper -->
        <!-- footer -->
        <div id="footer" class="clearingfix">
            <!-- footermenu -->
            <div class="footermenu">
                <?php
                echo $website->getFooter();
                ?>
            </div>
            <!-- footermenu -->
        </div>
        <!-- / footer -->
    </body>
</html>