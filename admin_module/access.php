<?php 
    session_start();
    if(!isset($_SESSION['loggedin'])) {
        //Send 403 Forbidden response.
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        session_unset();
        session_destroy();
        exit;
    }
    require "../admin_module/connection.php";
    $username = "";
    $userid = -1;
    $welcomeMsg = "";
    if ($stmt = $conn->prepare("select userid,alias from permission where userid = ?")) {
        $stmt->bind_param("i", $_SESSION["userid"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($userid, $username);
        $stmt->fetch();
        if (empty($result)) 
            $welcomeMsg = "User ".$userid;
        else 
            $welcomeMsg = $username;
    }
?>