<!DOCTYPE html>
<html>
<head>
    <title>Course Contents</title><!--Target: set to "Course Contents for XXX12345"-->
	<link rel="stylesheet" type="text/css" href="courseContents.css"/>
	<script src="courseContents.js"></script>
</head>
<body>
    <?php
    session_start();

    function printReturnForm()
    {
        print "<form id='returnForm' method='post' action='/eie4432/project/course/courseMenu.php'>";
        print "<input type = 'submit' id='submitBtn' name='submitBtn' value='Return to course menu'>";
        print "</form>";
    }

    //in the session and post variable, has - course number, user ID.
    print "<h1 align='center'>Course: ".$_POST['courseInput']."</h1>";
    print "<p align='right'>Your instructor ID: ".$_COOKIE['userid']."<br>".
    "<button id='logoutBtn' name='logoutBtn' onclick=''>Log Out</button>".
    "<button id='detailsBtn name='detailsBtn' onclick=''>My details</button>".
    "</p>";

    $coursePrefix = $_POST['courseInput'];
    //query to see if there is any course content
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

    print "<p>Contents for this course: </p>";

    //get the courseid from coursePrefix
    $query = "SELECT courseid FROM courses WHERE course_prefix = '".$coursePrefix."';";
    $result = mysqli_query($connect,$query);
    if (!$result)
    {
        printReturnForm();
        die("Unable to get the course information from the server.");
    }

    if (mysqli_num_rows($result)<0)
    {
        printReturnForm();
        die("Cannot the course ".$coursePrefix.".");
    }
    //only one courseid will be obtained
    $row = mysqli_fetch_assoc($result);
    $courseid = $row['courseid'];


    //get relevant data from db
    $query = "SELECT course_contents.courseid, course_contents.contentid, course_contents.type, exams.exam_name
              FROM course_contents, exams
              WHERE course_contents.courseid = '".$courseid."' AND course_contents.contentid = exams.examid;";
    $result = mysqli_query($connect,$query);

    if (!$result)
    {
        printReturnForm();
        die("Unable to get the course information from the server.");
    }

    if (mysqli_num_rows($result) <= 0)
    {
        print "<p>No content found for this course! Would you like to add contents to it?</p>";
        print "<form id='addContentForm' method='post' action='addContents.php'>";
        print "<input type='hidden' id='currentCourse' name='currentCourse' value='".$coursePrefix."'>";
        print "<input type='submit' id='addContentBtn' name='addContentBtn' value='Add contents'>";
        print "</form>";
        printReturnForm();
    }
    else
    {
        $countContents = 0;
        print "<p>".mysqli_num_rows($result)." content(s) found.</p>";
        while ($row = mysqli_fetch_assoc($result))
        {
            //output course contents one by one
            if ($row['courseid'] == $courseid)
            {
                $divID = $row['type'].$row['contentid'];
                print "<div id='".$divID."'>";
                print "<p>".$row['type']."<br>"."</p>";
                print "<p>".$row['exam_name']."<p>";
                $viewBtn = $divID."viewBtn";
                $modifyBtn = $divID."modifyBtn";
                $deleteBtn = $divID."deleteBtn";
                print "<p align='center'><button id='".$viewBtn."' name='".$viewBtn."' onclick='onViewChosen(\"".$row['contentid']."\")'>View</button></p>";
                print "</div>";
                $countContents++;
            }
        }
        
        print "<form id='addContentForm' method='post' action='addContents.php'>";
        print "<input type='hidden' id='currentCourse' name='currentCourse' value='".$coursePrefix."'>";
        print "<input type='submit' id='addContentBtn' name='addContentBtn' value='Add contents'>";
        print "</form>";
        printReturnForm();
            
    }
    mysqli_close($connect);
    ?>
</body>
</html>