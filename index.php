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
    } else if (isset($_POST['teamnaam']) && isset($_POST['projectid'])) {
        $website->makeTeam($_POST);
    } else if (isset($_POST['teams'])){
        $website->createTeam($_POST);
    } else if (isset($_POST['contentarea'])) {
        if (isset($_GET['CV'])) {
            echo $website->saveCV($_POST['contentarea']);
        } else if(isset($_GET['info'])) {
            echo $website->saveinfo($_POST['contentarea']);
        } else {
            echo $website->saveProject($_POST);
        }
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
                    if (isset($_GET['user'])) {
                        echo $website->getNavMenu($_GET['user']);
                    } else {
                        echo $website->getNavMenu();
                    }
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
                    if (isset($_GET['user'])) {
                        echo $website->getUserInfo($_GET['user']);
                    } else {
                        echo $website->getUserInfo();
                    }
                    ?>
                </div>
                <?php
                if (isset($_GET['search'])) {
                    echo $website->getSearchResult($_GET['search']);
                } else if (isset($_POST['register']) || isset($_POST['profileEdit'])) {
                    echo $website->getRegisterForm($_POST);
                } else if (isset($_GET['showcase'])) {
                    if ($website->getCurrentUser() == false || $_GET['showcase'] != $website->getCurrentUser()->id) {
                        echo $website->getShowcase($_GET['user']);
                    } else {
                        echo $website->getShowcase();
                    }
                } else if (isset($_GET['pop'])) {
                    if ($website->getCurrentUser() == false || $_GET['pop'] != $website->getCurrentUser()->id) {
                        echo $website->getPOP($_GET['user']);
                    } else {
                        echo $website->getPOP();
                    }
                } else if (isset($_POST['admin'])) {
                    echo $website->getAdminForm();
                } else if (isset($_GET['addProjectForm'])) {
                    echo $website->getAddProjectForm();
                } else if (isset($_GET['info'])) {
                    if ($website->getCurrentUser() == false || $_GET['info'] != $website->getCurrentUser()->id) {
                        echo $website->getInfo($_GET['user']);
                    } else {
                        echo $website->getInfo();
                    }
                } else if (isset($_GET['newProject'])) {
                    echo $website->getPoster(true, "", "", $website->getAvailableProjects());
                } else if (isset($_GET['CV'])) {
                    if ($website->getCurrentUser() == false || $_GET['CV'] != $website->getCurrentUser()->id) {
                        echo $website->getCV($_GET['user']);
                    } else {
                        echo $website->getCV();
                    }
                } else if (isset($_GET['editCV'])) {
                    echo $website->editCV();
                } else {
                    if (isset($_GET['user'])) {
                        echo $website->getHomepage($_GET['user']);
                    } else {
                        echo $website->getHomepage();
                    }
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