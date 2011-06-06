<?php

if (!@Darkrulerz) {
    define("PROFolio", 1);
}
$db_name = "profolio";
$db_host = "88.198.43.24";
$db_username = "profolio";
$db_password = "koffiekan";
$cookiename = "profolio_login";
$cookietime = "60";                 // Tijd die de cookie geldig blijft in minuten
$AvatarMaxSize = "2";               // Maximum grootte van je plaatje, in MB
$AvatarSaveDir = "./avatars/";      // Map waarin de plaatjes komen
$AvatarMaxDimensions = "50x50";
$AvatarAllowedFiletypes = array("image/png", "image/jpg", "image/jpeg");
$POPAllowedFiletypes = array("application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf","application/msword");
$LanguageDir = "./languages/";
$LogDir = "./logs/";
?>