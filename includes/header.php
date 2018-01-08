<?php
    ob_start();
    require_once("init.php");
?>

<!DOCTYPE html>
<html lang="en" style="position: relative; min-height: 100%;">
    <head>
        <title>AC PHP Project</title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body style="padding-top: 50px; margin-bottom: 60px;">
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" style="padding: 10px" href="http://www.algonquincollege.com">
                        <img src="/AlgCommon/Contents/img/AC.png" alt="Algonquin College" style="max-width:100%; max-height:100%;"/>
                    </a>    
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="Index.php">Home</a></li>
                        <li><a href="MyFriends.php">My Friends</a></li>
                        <li><a href="MyAlbums.php">My Albums</a></li>
                        <li><a href="MyPictures.php">My Pictures</a></li>
                        <li><a href="UploadPictures.php">Upload Pictures</a></li>                       
                        <?php
                            if($session->is_signed_in()) {                        
                                echo "<li><a href='Logout.php'>Log Out</a></li>";
                            } else {
                                echo "<li><a href='Login.php'>Log In</a></li>";
                            }                    
                        ?>
                    </ul>
                </div>
            </div>  
        </nav>