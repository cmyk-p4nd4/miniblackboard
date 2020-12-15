<?php
    $userid = $_POST['userid'];
    $exam_name = $_POST['exam_name'];

    $server = "us-cdbr-east-02.cleardb.com";
	$user = "b06abb5474de88";
	$pw = "5b46e8a1";
    $db = "heroku_2d30a0192d19383";
    $connect = mysqli_connect($server,$user,$pw,$db);

    if (!$connect)
    {
        print "FailConnection";
        die();
    }
    else 
    {
        $query = "SELECT questions FROM exams WHERE exam_name='".$exam_name."';";
        $result = mysqli_query($connect,$query);

        if (!$result)
        {
            print "FailQuery";
            die();
        }

        //suppose only one row
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            print $row['questions'];
        } else
        {
            print "NoResultFound";
        }
    }

    
    


?>