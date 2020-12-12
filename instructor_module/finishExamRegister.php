<!DOCTYPE html>
<html>
<head>
    <title>Register an exam</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
	<script src="registerExam3.js"></script>
</head>

<body>
    <h1 align="center">Register an exam</h1>
    <p>
    <?php
        session_start();
        //$dummy_course_id = 12345; // retrieve the course id
        print("You are submitting an exam with the following information<br>");
        print "Current exam information<br><br>";
	    print "Name of exam: ". $_SESSION["examName"]."<br>";
	    print "Start date of the exam: ".  $_SESSION["examDate"]."<br>";
	    print "Start time of the exam: ". $_SESSION["examTime"]."<br>";
        print "Duration of the exam: ". $_SESSION["examDurationHours"]. " hours, ".$_SESSION["examDurationMinutes"]." minutes<br>";
        $questionCount = $_POST["questionCnt"];
        $questionAnswer = $_POST["questionAnswers"];
        print "Number of questions: ". $questionCount . "<br><br>";
        
        $server = "us-cdbr-east-02.cleardb.com";
	    $user = "b06abb5474de88";
	    $pw = "5b46e8a1";
	    $db = "heroku_2d30a0192d19383";

        //create mysql connection
        $connect = mysqli_connect($server,$user,$pw,$db);
        if (!$connect)
	    {
		    die("Fail to connect with server \n Please contact system admin with the following reason:".mysqli_connect_error());
        }

        $dummy_test_head = 12345; //TODO: record the course number, which will be used to form exam id.
        
        //get the latest exam number
        $queryCmd = "SELECT examid FROM exams WHERE examid BETWEEN ". $dummy_test_head ."00000 AND ".$dummy_test_head."99999;";
        $queryResult = mysqli_query($connect,$queryCmd);

        if (!$queryResult)
        {
            die("Error occurred when processing the exam id, reason: ".mysqli_connect_error());
        }
        else
        {

            
            $existingRecordNumber = $dummy_test_head."00000";
            while ($row = mysqli_fetch_assoc($queryResult))
            {
                $cid = $row['examid'];
                if ($cid > $existingRecordNumber)
                    $existingRecordNumber = $cid;
            }
            
            $existingRecordNumber++;

            print "This exam has exam id of ".$existingRecordNumber."<br><br>";

            $examDateTime = $_SESSION["examDate"]." ".$_SESSION["examTime"].":00";
            $durationString = $_SESSION["examDurationHours"]."h;".$_SESSION["examDurationMinutes"]."m;"."0s";
            //insert the exam to sql db
            $insertCmd = 
            "INSERT INTO `heroku_2d30a0192d19383`.`exams`
            (`examid`,
             `exam_name`,
             `startdate`,
             `duration`,
             `questions`)
            VALUES
            ('".$existingRecordNumber."',
             '".$_SESSION["examName"]."',
             '".$examDateTime."',
             '".$durationString."',
             '".$questionAnswer."');
            ";
            

            $queryResult = mysqli_query($connect,$insertCmd);
            if (!$queryResult)
            {
                die("Unable to insert exam data to server, reason: ".mysqli_connect_error());
            }
            else
                print "The exam ".$existingRecordNumber." has been uploaded successfully.<br>";
            mysqli_close($connect);
        }
    ?>
    </p>
</body>
</html>