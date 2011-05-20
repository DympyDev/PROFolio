<?php

if (!@Darkrulerz) {
    define("PROFolio", 1);
}
$db_name = "profolio";
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$cookiename = "profolio_login";
$cookietime = "60";                 // Tijd die de cookie geldig blijft in minuten
$AvatarMaxSize = "2";               // Maximum grootte van je plaatje, in MB
$AvatarSaveDir = "./avatars/";      // Map waarin de plaatjes komen
$AvatarMaxDimensions = "50x50";
$AvatarAllowedFiletypes = array("image/png", "image/jpg", "image/jpeg");
$LanguageDir = "./languages/";
$LogDir = "./logs/";
?>