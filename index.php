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
    } else if (isset($_POST['addProject'])) {
        echo $website->addProject($_POST);
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
            <!-- right column -->

            <!-- / right column -->         
            <!-- content column -->
            <div id="content">  
                <div id="right">
                    <?php
                    echo $website->getUserInfo();
                    ?>
                </div>
                <?php
                if (isset($_GET['search'])) {
                    echo $website->getResult($_GET['search']);
                } else if (isset($_POST['register']) || isset($_POST['profileEdit'])) {
                    echo $website->getRegisterForm($_POST);
                } else if (isset($_GET['showcase'])) {
                    echo $website->getShowcase();
                } else if (isset($_GET['pop'])) {
                    echo $website->getPOP();
                }  else if (isset($_POST['admin'])) {
                    echo $website->getAdminForm();
                }  else if (isset($_GET['addProjectForm'])) {
                    echo $website->getAddProjectForm();
                } else if (isset($_GET['info'])) {
                    echo $website->getInfo();
                } else if (isset($_GET['newProject'])) {
                    echo $website->getProjectPoster();
                } else {
                    echo $website->getHomepage();
                }
                ?>
            </div>
            <!-- content column -->
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