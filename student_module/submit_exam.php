<?php
    $server = "us-cdbr-east-02.cleardb.com";
	$user = "b06abb5474de88";
	$pw = "5b46e8a1";
    $db = "heroku_2d30a0192d19383";
    $connect = mysqli_connect($server,$user,$pw,$db);

    if (!$connect)
    {
        print "FailConnection";
    } else
    {
        $exam_name = $_POST['exam_name'];
        $userid = $_POST['userid'];
        $submitTime = $_POST['submit_time'];

        $questionAnswers = $_POST['questionanswers'];
        $student_answer = $_POST['student_answer'];
        $marking = $_POST['marking'];
        $totalmarks = $_POST['totalmarks'];
        
        //retrieve exam id 
        $query = "SELECT DISTINCT examid FROM exams where exam_name='".$exam_name."'";
        $result = mysqli_query($connect,$query);

        if (!$result)
        {
            print "FailQuery";
            
        } else
        {
            $row = mysqli_fetch_assoc($result);
            $exam_id = $row['examid'];

            $query = "INSERT INTO exam_records (examid,studentid,submit_time,questionanswers,student_answer,marking,totalmarks) VALUES ".
            "('".$exam_id."','".$userid."','".$submitTime."','".$questionAnswers."','".$student_answer."','".$marking."','".$totalmarks."');";
            print($query);
            $result = mysqli_query($connect,$query);

            if (!$result)
            {
                print "FailQuery";
            } else
            {
                if (mysqli_affected_rows($connect) > 0)
                {
                    print "Added";
                }
            else
            {
                print "NoEffects";
            }   
            }

            
        }
        
    }

        

    

    

?>