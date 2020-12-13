<?php
    $contentID = $_POST['contentID'];
    if (!isset($contentID))
        die("Unauthorized access is banned!");
    //after getting the content id, start to get exam data by sql
    $server = "us-cdbr-east-02.cleardb.com";
	$user = "b06abb5474de88";
	$pw = "5b46e8a1";
    $db = "heroku_2d30a0192d19383";

    $connect = mysqli_connect($server,$user,$pw,$db);
    if (!$connect)
    {
        die("Fail to connect with server");
    }

    //get exam data
    $query = "SELECT * FROM exams WHERE examid ='".$contentID."';";
    $result = mysqli_query($connect,$query);

    if (!$result)
    {
        die("Unable to extract exam data");
    }

    //there should be only one 
    $row = mysqli_fetch_assoc($result);
    $output = json_encode($row);
    print $output;
    mysqli_close($connect);
?>