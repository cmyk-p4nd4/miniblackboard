<?php 
    if(!isset($_COOKIE['loggedin'])) {
        //Send 404 Forbidden response.
        header("location: /miniblackboard/wrap/trying-to-outsmart-huh.php");
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