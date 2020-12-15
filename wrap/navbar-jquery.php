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
    if (isset($_POST['gb'])) {
        require_once "../admin_module/connection.php";
        $gender = $_POST["gender"];
        $birthday = $_POST["birth"];
        $id = $_COOKIE["userid"];
        $stmt = $conn->prepare("SELECT gender, birthday from studentinfo where userid = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results->num_rows == 0) {
            $results->free();
            $stmt->close();
            $stmt = $conn->prepare("INSERT into studentinfo (userid, gender,birthday) values (?,?,?)");
            $stmt->bind_param("iss",$id, $gender,$birthday);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        } else {
            $results->free();
            $stmt->close();
            $stmt = $conn->prepare("UPDATE studentinfo set `gender`=?, `birthday`=? where userid=?");
            $stmt->bind_param("ssi", $gender,$birthday,$id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }

    }
?>