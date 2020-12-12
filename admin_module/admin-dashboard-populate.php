<?php
    require_once "connection.php";
    
    if (isset($_POST["addc"])) {
        createCourse();
    }
    if (isset($_POST["addu"])) {
        createUser();
    }
    if (isset($_POST["removeu"])) {
        removeUser();
    }
    if (isset($_POST["removec"])) {
        removeCourse();
    }

    function createCourse() {
        global $conn;
        $prefix = trim($_POST["prefix"]);
        $name = trim($_POST["name"]);
        $iid = trim($_POST["id"]);
        $stmt = $conn->prepare("insert into courses (coursename, course_prefix, instructorid) values (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $prefix, $iid);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "<meta http-equiv='refresh' content='0'>";
    }

    function createUser() {
        $defaultRank = "S";
        $defaultEmail = "user@miniblackboard.com";
        global $conn;

        $id = trim($_POST["uid"]);
        $pw = trim($_POST["pw"]);
        $perm = (empty(trim($_POST["perm"]))) ? trim($_POST["perm"]) : $defaultRank;
        $alias = trim($_POST["name"]);

        $stmt = $conn->prepare("insert into permission (userId, permission, password, alias, email) values (?, ?, ?, ?, ?)");
        $hashx = password_hash($pw, PASSWORD_DEFAULT);
        $stmt->bind_param("issss", $id, $perm, $hashx, $alias, $defaultEmail);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "<meta http-equiv='refresh' content='0'>";
    }

    function removeUser() {
        global $conn;
        $cid = trim($_POST["cid"]);

        $stmt = $conn->prepare("DELETE FROM permission WHERE userid = ?");
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "<meta http-equiv='refresh' content='0'>";
    }

    function removeCourse() {
        global $conn;
        $cid = trim($_POST["cid"]);

        $stmt = $conn->prepare("DELETE FROM courses WHERE courseid = ?");
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "<meta http-equiv='refresh' content='0'>";
    }
?>