<?php 
    session_start();
    if(!isset($_COOKIE['loggedin'])) {
        //Send 404 Forbidden response.
        header("location: /miniblackboard/wrap/trying-to-outsmart-huh.php");
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