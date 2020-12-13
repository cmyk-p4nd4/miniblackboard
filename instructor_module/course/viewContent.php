<!DOCTYPE html>
<html>
<head>
    <title>View content</title><!--Target: set to "Course Contents for XXX12345"-->
	<link rel="stylesheet" type="text/css" href="courseContents.css"/>
    <script src="viewContent.js"></script>
</head>
<body>
    <?php
        function printReturnForm()
        {
            print "<form id='returnForm' method='post' action='/eie4432/project/course/courseMenu.php'>";
            print "<input type = 'submit' id='submitBtn' name='submitBtn' value='Return to course menu'>";
            print "</form>";
        }

        session_start();
        //retrieve all related 
        $contentid = $_POST["contentID"];
        print "<p align='right'>Your instructor ID: ".$_SESSION['userid']."<br>".
        "<button id='logoutBtn' name='logoutBtn' onclick=''>Log Out</button>".
        "<button id='detailsBtn name='detailsBtn' onclick=''>My details</button>".
        "</p>";

        $server = "us-cdbr-east-02.cleardb.com";
	    $user = "b06abb5474de88";
	    $pw = "5b46e8a1";
        $db = "heroku_2d30a0192d19383";
        $connect = mysqli_connect($server,$user,$pw,$db);
        if (!$connect)
        {
            printReturnForm();
            die("Fail to connect with server \n Please contact system admin with the following reason:".mysqli_connect_error());
        }

        //get the course name
        $query = "SELECT courseid FROM course_contents WHERE contentid = '".$contentid."';";
        $result = mysqli_query($connect,$query);

        if (!$result)
        {
            printReturnForm();
            die("Unable to connect with server, reason:". mysqli_error($connect));
        }

        $courseid = 0;
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $courseid = $row['courseid'];
        }
        else
        {
            printReturnForm();
            die("Cannot acquire course information from the database.");
        }

        //get subject name
        $query = "SELECT course_prefix FROM courses WHERE courseid= '".$courseid."'";
        $result = mysqli_query($connect,$query);

        if (!$result)
        {
            printReturnForm();
            die("Unable to connect with server, reason:". mysqli_error($connect));
        }

        $course_prefix = "";
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $course_prefix = $row['course_prefix'];
        }
        else
        {
            printReturnForm();
            die("Cannot acquire course record from the database.");
        }

        print "<p align='center'>Viewing the content of ".$course_prefix."</p>";

        //course_prefix is acquired, get exam details with contentid 
        $query = "SELECT * FROM exams WHERE examid = '".$contentid."';";
        $result = mysqli_query($connect,$query);
        if (!$result)
        {
            printReturnForm();
            die("Unable to connect with server, reason:". mysqli_error($connect));
        }

        if (mysqli_num_rows($result) < 0)
        {
            printReturnForm();
            die("No record for this exam is found.");
        }

        $record = mysqli_fetch_assoc($result);
        $examName = $record['exam_name'];
        $startDate = $record['startdate'];
        $duration = $record['duration'];
        $questions = $record['questions'];
        $examid = $contentid;

        print "<p>Exam name: ".$examName."</p>";
        print "<p>Start Date and time: ".$startDate."</p>";
        $duration = explode(";",$duration);
        print "<p>Duration: ".$duration[0].", ".$duration[1]."</p>";

        $questionStruct = json_decode($questions);
        $questionArray = $questionStruct[0];
        $questionTypeArray = $questionStruct[1];
        $answerArray = $questionStruct[2];
        $correctAnswerArray = $questionStruct[3];

        print "<p>This exam has a total of ".sizeof($questionArray)." questions.</p>";
        print "<p>Please select your action:</p>";
        //get student's attempt record
        $query = "SELECT studentid FROM exam_records WHERE examid ='".$contentid."'";
        $result = mysqli_query($connect, $query);
        if (!$result)
        {
            printReturnForm();
            die("Unable to retrieve student's attempt record from the database.");
        }

        if (mysqli_num_rows($result) <= 0)
        {
            //No student attempted.
            print "<p>There is no student attempted this test.</p>";
        }
        else
        {
            //There is student attempted, show the performance button
            print "<p>".mysqli_num_rows($result)." students attempted this test.</p>";
            print "<form id='viewPerformanceForm' name='viewPerformanceForm' action='/eie4432/project/course/viewContent.php' method='post'>";
            print "<input type='hidden' id='refExamID' name='refExamID' value='".$contentid."'>";
            print "<input type='submit' id='viewPerformance_submit' name='viewPerformance_submit' value='View student's performance'>";
            print "</form>";
        }

        //Modify question button
        print "<form id='modifyForm' name='modifyForm' action='/eie4432/project/exam/modifyExam.php' method='post'>";
        print "<input type='hidden' id='modifyExamID' name='modifyExamID' value='".$contentid."'>";
        print "<input type='submit' id='modify_submit' name='modify_submit' value='Modify questions'>";
        print "</form>";
        
        printReturnForm();
    ?>
</body>
</html>