<?php
    $userid = $_POST['userid'];
    $exam_name = $_POST['exam_name'];

    $server = "us-cdbr-east-02.cleardb.com";
	$user = "b06abb5474de88";
	$pw = "5b46e8a1";
    $db = "heroku_2d30a0192d19383";
    $connect = mysqli_connect($server,$user,$pw,$db);

    if !($connect)
    {
        die("FailConnection");
    }

    $query = "SELECT DISTINCT questions FROM exams WHERE exam_name='".$exam_name."';";
    $result = mysqli_query($connect,$query);

    if (!$result)
    {
        die("FailQuery");
    }

    //suppose only one row
    $row = mysqli_fetch_assoc($result);
    print $row['questions'];


?>