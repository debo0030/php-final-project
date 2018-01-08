<?php
    require_once("includes/header.php");
    
    $session->logout();
    redirect("LogIn.php");