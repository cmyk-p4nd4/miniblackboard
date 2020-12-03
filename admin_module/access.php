<?php 
    session_start();
    if(!isset($_SESSION['ARM_GPIO'])) {
        //Send 403 Forbidden response.
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        session_unset();
        session_destroy();
        exit;
    }
?>