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
    function printReturnForm()
    {
        
        print "<form id='returnForm' method='post' action='../course/courseContents.php'>";
        print "<input type = 'hidden' id='courseInput' name='courseInput' value='".$_POST["currentCourse"]."'>";
        print "<input type = 'submit' id='submitBtn' name='submitBtn' value='Return to course content'>";
        print "</form>";
    }
        session_start();
        print "You are submitting an exam with the following information<br>";
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
            printReturnForm();
		    die("Fail to connect with server \n Please contact system admin with the following reason:".mysqli_connect_errno());
        }

        $courseID = $_POST["currentCourse"]; //TODO: record the course prefix, which will be used to form exam id. currentCourse is the course_prefix
        //do a query to get the course id of course
        $queryCmd = "SELECT courseid FROM courses WHERE course_prefix = '".$courseID."';";
        $result = mysqli_query($connect,$queryCmd);

        if (!$result)
        {
            printReturnForm();
            die("Error when retrieving the database data. Reason: ".mysqli_connect_errno());
        }

        //has result
        while ($row = mysqli_fetch_assoc($result))
            $courseID = $row["courseid"];//suppose each prefix is unique, change prefix to course id.

        //get the latest exam number
        $queryCmd = "SELECT examid FROM exams WHERE examid BETWEEN ". $courseID ."00000 AND ".$courseID."99999;";
        $result = mysqli_query($connect,$queryCmd);

        if (!$result)
        {
            printReturnForm();
            die("Error occurred when processing the exam id, reason: ".mysqli_error($connect));
        }

        //assign a exam id.
        $existingRecordNumber = $courseID."00000";
        while ($row = mysqli_fetch_assoc($result))
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
             `questions`,
             `relevant_subject`)
            VALUES
            ('".$existingRecordNumber."',
             '".$_SESSION["examName"]."',
             '".$examDateTime."',
             '".$durationString."',
             '".$questionAnswer."',
             '".$courseID."');
            ";
            

        $queryResult = mysqli_query($connect,$insertCmd);
        if (!$queryResult)
        {
            printReturnForm();
            die("Unable to insert exam data to server, reason: ".mysqli_connect_errno());
        }
        
        //also update the content in course.
        //check the contentid
        $queryCmd = "SELECT contentid FROM course_contents WHERE contentid BETWEEN ".$courseID."00000 AND ".$courseID."99999;";
        $queryResult = mysqli_query($connect,$queryCmd);
        if (!$queryResult)
        {
            printReturnForm();
            die("Cannot update the course content, reason: ".mysqli_error($connect));
        }
//FOCUS
        $contentID = $courseID."00000";
        while ($row = mysqli_fetch_assoc($queryResult))
        {
            $cid = $row['contentid'];
            if ($contentID < $row['contentid'])
                $contentID = $row['contentid'];
        }
//FOCUS
        $contentID++;
        $queryCmd = "INSERT INTO course_contents (`courseid`,`contentid`,`type`) VALUES ('".$courseID."','".$contentID."','Exam');";
        $queryResult = mysqli_query($connect,$queryCmd);
        if (!$queryResult)
        {
            printReturnForm();
            die("Cannot update the course content to the db, reason: ".mysqli_error($connect));
        } else
        {
            print "The exam has been uploaded successfully.<br>";
            //add the input form and button for returning to course contents list.
            printReturnForm();
        }
        
    ?>
    </p>
</body>
</html>