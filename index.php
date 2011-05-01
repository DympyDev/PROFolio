<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <?php
        require "classes/class.website.php";
        $website = new website();
        echo $website->getHead();
        ?>
    </head>
    <body id="page">
        <!-- wrapper -->
        <div class="rapidxwpr floatholder">
            <!-- header -->
            <div id="header">  
                <!-- logo -->
                <a href="index.html"><img id="logo" class="correct-png" src="images/logo.png" alt="Home" title="Home"></a>
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
                    <form action="" method="get">
                        <input type="text" name="search" class="search-field" value="">
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
                                        <h3>Content van de dingetjes</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vehicula, odio feugiat venenatis auctor, ligula odio auctor ipsum, ac luctus mi turpis nec risus. Vivamus rhoncus commodo lorem, non ultrices erat hendrerit eu. Vestibulum velit neque, dapibus ut commodo eget, scelerisque at eros. Phasellus vulputate, eros sit amet aliquet euismod, ante elit auctor leo, lobortis feugiat odio odio quis justo. Vivamus viverra orci non nisi gravida laoreet. Vivamus nec ligula tellus, in semper felis. Aliquam in ante quis elit faucibus porta vitae vitae risus. Duis ligula metus, bibendum fermentum pellentesque non, tempor non purus. Suspendisse ac arcu dolor, vel commodo tortor. In magna elit, lacinia in tincidunt non, fermentum eu purus.<br>
                                            Fusce gravida elementum tincidunt. Curabitur vehicula fringilla purus, et posuere lacus viverra eget. Cras quis tristique lectus. Mauris accumsan imperdiet feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum at malesuada quam. In nunc urna, tincidunt quis vulputate non, lobortis eget magna. Aliquam eleifend varius felis sit amet porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sit amet nulla est, sed fermentum orci. Mauris volutpat diam vitae orci faucibus eget eleifend neque iaculis. Suspendisse potenti. Pellentesque eu velit sed ligula luctus rutrum.<br>
                                            In dapibus neque egestas lacus hendrerit sit amet sodales turpis rutrum. Ut ut bibendum lacus. Nunc a pharetra urna. Nam bibendum consequat ante non molestie. Aliquam at quam non risus faucibus suscipit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ligula erat, pretium quis suscipit in, interdum vel neque. Pellentesque commodo placerat risus, ut sagittis leo adipiscing vitae. Nam sollicitudin fermentum euismod. Vivamus lacinia iaculis orci nec blandit. Mauris ullamcorper tincidunt condimentum. Etiam dapibus dignissim risus, et fringilla enim adipiscing sit amet. Vestibulum non ante quis orci sollicitudin dictum ut vitae ante. Proin ut suscipit orci. Maecenas auctor pellentesque neque non consequat. Donec ac risus ut neque sodales dignissim. Ut placerat nisl nec turpis vehicula auctor.<br>
                                            Ut a enim quis nunc laoreet luctus nec vel sapien. Mauris blandit ligula eu felis aliquam semper. Mauris luctus ligula porttitor quam ornare pretium. Fusce id tellus quam. Sed leo sapien, venenatis et porta ut, sodales sit amet arcu. Nulla facilisi. Morbi lacus turpis, interdum quis condimentum ac, ultricies in ante. Quisque ultrices, metus eget convallis iaculis, sem ante convallis ipsum, sit amet elementum purus elit vitae lacus. Nunc quis dui eu erat dictum faucibus at eget mi. Duis a erat in lacus blandit imperdiet nec sit amet lacus. Etiam id libero risus. Nullam et ipsum sit amet dui hendrerit condimentum vitae rhoncus est. Donec sagittis, lorem ac vestibulum porttitor, leo massa pharetra purus, id fringilla ante lectus id nisl. In facilisis, lacus quis egestas ullamcorper, erat orci suscipit libero, vel vestibulum massa neque id mauris. Vivamus ac magna eros, a pharetra tellus. Nulla urna lorem, scelerisque at pretium sit amet, facilisis ut est. Quisque et mi sapien, id adipiscing quam.
                                        </p>
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
                <p>
                    Overige crap die we kwijt willen(zoals copyright xD)
                </p>
            </div>
            <!-- footermenu -->
        </div>
        <!-- / footer -->
    </body>
</html>