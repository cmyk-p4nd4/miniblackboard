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
    if (isset($_POST["func1"])) {
        func1();
    }
    if (isset($_POST["func2"])) {
        func2();
    }
    if (isset($_POST["func3"])) {
        func3();
    }
    if (isset($_POST["func4"])) {
        func4();
    }
    if (isset($_POST["func5"])) {
        func5();
    }
    if (isset($_POST["func6"])) {
        func6();
    }
    if (isset($_POST["appendstd"])){
        appendStudent();
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

    function func1()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_TOKEN, DB_TARGET);
        $stmt = $conn->prepare("select userid from permission where permission = 'T'");
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<option value='0'></option>";
        while ($row = $result->fetch_array()) {
            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
        }
        $stmt->close();
        $conn->close();
    }

    function func2() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_TOKEN, DB_TARGET);
        $stmt = $conn->prepare("select courseid,course_prefix, coursename from courses");
        $stmt->execute();
        $result = $stmt->get_result();
        //echo "<option value='0'></option>";
        while ($row = $result->fetch_array()) {
            echo "<option value='" . $row[0] . "'>" . $row[1].': '. $row[2] . "</option>";
        }
        $stmt->close();
        $conn->close(); 
    }

    function func3() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_TOKEN, DB_TARGET);
        $stmt = $conn->prepare("select userid from permission where permission = 'S'");
        $stmt->execute();
        $result = $stmt->get_result();
        //echo "<option value='0'></option>";
        while ($row = $result->fetch_array()) {
            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
        }
        $stmt->close();
        $conn->close(); 
    }

    function func4() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_TOKEN, DB_TARGET);
        $courseid = $_POST["courseid"];
        $stmt = $conn->prepare("select studentid from student_course where courseid = ?");
        $stmt->bind_param("i", $courseid);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<option value='0'></option>";
        while ($row = $result->fetch_array()) {
            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
        }
        $stmt->close();
        $conn->close(); 
    }

    function func5() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_TOKEN, DB_TARGET);
        $subject = $_POST["datas"][0];
        $student = $_POST["datas"][1];
        $stmt = $conn->prepare("DELETE from student_course where courseid = ? AND studentid = ?");
        $stmt->bind_param("ii", $subject, $student);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function func6() {

    }

    function appendStudent() {
        $subject = trim($_POST["subject"]);
        $students= $_POST["students"];

        $query = array();
        foreach ($students as $student) {
            $query[] = '("'.$student.'", '.$subject.')';
        }

        $conn = new mysqli(DB_HOST, DB_USER, DB_TOKEN, DB_TARGET);
        $conn->query("insert into student_course (studentid, courseid) values " .implode(',', $query));
        $conn->close();
    }
?>