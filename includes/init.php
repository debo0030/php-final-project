<?php
    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    define('SITE_ROOT', DS.'C:'.DS.'Program Files (x86)'.DS.'Ampps'.DS.'www'.DS.'photo-sharing-social-network');
    defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes'); 
    defined('IMAGES_PATH') ? null : define('IMAGES_PATH', SITE_ROOT.DS.'admin'.DS.'images');
    require_once("functions.php");
    require_once("new_config.php");
    require_once("database.php");
    require_once("db_object.php");
    require_once("user.php");
    require_once("photo.php");
    require_once("session.php");
    require_once ("album.php");
    require_once ("user.php");