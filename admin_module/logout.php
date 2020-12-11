<?php
session_start();
session_destroy();
if (isset($_COOKIE["loggedin"])) {
    setcookie('loggedin', true, time()-3600,'/');
    unset($_COOKIE['loggedin']);
    setcookie('permission', 'N', time()-3600,'/');
    unset($_COOKIE['permission']);
    setcookie('userid', -1, time()-3600, '/');
    unset($_COOKIE['userid']);
}
if (isset($_COOKIE['ARM_GPIO'])) {
    setcookie('ARM_GPIO', 0, time()-3600,'/');
    unset($_COOKIE['ARM_GPIO']);
    
}
header("location: ../ ");
exit;
?>