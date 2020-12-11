<?php 
    session_start();
    if(!isset($_COOKIE['loggedin'])) {
        //Send 403 Forbidden response.
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        session_unset();
        session_destroy();
        exit;
    }
    require "../admin_module/connection.php";
    $userid = -1;
    $welcomeMsg = "";
    if (empty($_COOKIE["alias"])) {
        $welcomeMsg = "User ".$_COOKIE["userid"];
    } else {
        $welcomeMsg = $_COOKIE['alias'];
    }
?>