<?php
    $marking = $_POST['marking'];
    $examid = $_POST['examid'];
    $studentid = $_POST['studentid'];
    
    $examid = $_POST['examid'];
    $server = "us-cdbr-east-02.cleardb.com";
	$user = "b06abb5474de88";
	$pw = "5b46e8a1";
    $db = "heroku_2d30a0192d19383";

    $connect = mysqli_connect($server,$user,$pw,$db);
    if (!$connect)
	{
		die("Fail");
    }

    $updateCmd = "UPDATE exam_records SET marking='".$marking."' WHERE examid='".$examid."' AND 
    studentid = '".$studentid."';";
    $result = mysqli_query($connect,$updateCmd);

    if (!$result)
        die("Fail");
    else
    {
        if (mysqli_affected_rows($connect) > 0)
            print "Success";
        else print "No effect";
    }
    mysqli_close($connect);
?>