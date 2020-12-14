<?php 
    if (isset($_POST["changenick"])) {
        require_once "../admin_module/connection.php";
        $val = $_POST["val"];
        $id = $_COOKIE["userid"];
        $stmt = $conn->prepare("UPDATE permission set `alias` = ? where userid = ?");
        $stmt->bind_param("si", $val, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        setcookie("alias", $val, time()+86400, '/');
    }
?>