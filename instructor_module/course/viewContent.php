<?php require_once "../../admin_module/access.php"?>
<!DOCTYPE html>
<html>
<head>
        <title>Welcome, <?php echo $welcomeMsg; ?> - MiniBlackboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Custom Style+JS -->
        <link rel="stylesheet" type="text/css" href="courseContents.css"/>
        <script src="viewContent.js"></script>
</head>
<body>
    <?php
        function printReturnForm()
        {
            print "<form id='returnForm' method='post' action='/miniblackboard/wrap/mainhub.php'>";
            print "<input type = 'submit' id='submitBtn' name='submitBtn' value='Return to course menu'>";
            print "</form>";
        }

        session_start();
        //retrieve all related 
        $contentid = $_POST["contentID"];
        require_once "../inst-navbar.php";

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
            print "<p>".mysqli_num_rows($result)." students attempted this test.</p>";
            print "<form id='gradeForm' name='gradeForm' action='../exam/markExam.php' method='post'>";
            print "<input type='hidden' id='gradeForm_refExamID' name='gradeForm_refExamID' value='".$contentid."'>";
            print "<input type='hidden' id='gradeForm_refExamPrefix' name='gradeForm_refExamPrefix' value='".$course_prefix."'>";
            print "<input type='submit' id='gradeForm_submit' name='gradeForm_submit' value='Grade work of students'>";
            print "</form>";

            //There is student attempted, show the performance button
            print "<form id='viewPerformanceForm' name='viewPerformanceForm' action='../exam/checkStatistics.php' method='post'>";
            print "<input type='hidden' id='refExamID' name='refExamID' value='".$contentid."'>";
            print "<input type='hidden' id='refExamPrefix' name='refExamPrefix' value='".$course_prefix."'>";
            print "<input type='submit' id='viewPerformance_submit' name='viewPerformance_submit' value='View performance of students'>";
            print "</form>";

            
        }

        
        printReturnForm();
    ?>
</body>
</html>