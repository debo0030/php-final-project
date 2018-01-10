<?php
    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    define('SITE_ROOT', DS.'C:'.DS.'Program Files (x86)'.DS.'Ampps'.DS.'www'.DS.'photo-sharing-social-network');
    defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes'); 
    defined('IMAGES_PATH') ? null : define('IMAGES_PATH', SITE_ROOT.DS.'admin'.DS.'images');
    
    define(ORIGINAL_PICTURES_DIR, "./pictures/OriginalPictures");
    define(ALBUM_PICTURES_DIR, "./pictures/AlbumPictures");
    define(THUMBNAIL_DIR, "./pictures/ThumbnailPictures");

    define(IMG_MAX_WIDTH, 1024);
    define(IMG_MAX_HEIGHT, 800);

    define(THUMB_MAX_WIDTH, 100);
    define(THUMB_MAX_HEIGHT, 100);

    $supportedImageTypes = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    date_default_timezone_set("America/Toronto");

    require_once("functions.php");
    require_once("new_config.php");
    require_once("database.php");
    require_once("db_object.php");
    require_once("user.php");
    require_once("photo.php");
    require_once("session.php");
    require_once ("album.php");
