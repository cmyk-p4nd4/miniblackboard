<!DOCTYPE html>
<html>
<head>
    <title>Add subject</title>
	<link rel="stylesheet" type="text/css" href="addCourse.css"/>
	<script src="addCourse.js"></script>
</head>
<body>
    <h1 align="center">Add new subject</h1>
    <?php
        //add new subject to server first
        session_start();
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

        print "<p>Your instructor ID: ".$_SESSION['userid']."</p>";
        print "<p>You are adding course: ".$_POST["course_prefix"]."</p>";

        //check if the course_prefix exists first
        $query = "SELECT course_prefix FROM courses WHERE course_prefix ='".$_POST["course_prefix"]."';";
        
        $result = mysqli_query($connect,$query);

        if (!$result)
        {
            die("1Unable to access the database contents, reason: ".mysqli_connect_errno());
        }
        else
        {
            if (mysqli_num_rows($result) > 0)
            {
                //same subject already exists
                print "Unable to add the content, this course already exists.<br>";
                print "<button value='Return to add course page' id='returnBtn' name='returnBtn' onclick='addCourse.php'><br>";
            }
            else
            {
                //subject not exists
                //insert the subject with the largest courseid
                //search largest courseid first
                $query = "SELECT MAX(courseid) as `courseid` FROM courses";
                $courseID = 0;
                $result1 = mysqli_query($connect,$query);
                if (!$result1)
                {
                    die("2Unable to access the database contents, reason: ".mysqli_connect_errno());
                }
                
                while ($row = mysqli_fetch_assoc($result1))
                    $courseID = $row['courseid'] + 1;
                $query = "INSERT INTO courses (`courseid`,
                `coursename`,
                `course_prefix`,
                `instructorid`,
                `contents`) VALUES ('". $courseID ."','".$_POST["course_name"]."','".$_POST["course_prefix"]."','".$_SESSION['userid']."',''); ";
                
                $result = mysqli_query($connect,$query);

                if (!$result)
                {
                    print "Unable to insert the course. Reason: ".mysqli_connect_errno()."<br>";
                } else
                {
                    print "The course has been inserted successfully.<br>";
                    //TODO: add a button to navigate back to course select
                    print "<form action='courseMenu.php' method='post'><input type='submit' id='navCourseMenuBtn' name='navCourseMenuBtn' value='Return to course menu'></form>";
                }

            }
        }

        
    
        mysqli_close($connect);
    ?>
</body>
</html>