<!DOCTYPE html>
<html>
<head>
    <title>Add subject</title>
	<link rel="stylesheet" type="text/css" href="addCourse.css"/>
	<script src="addCourse.js"></script>
</head>
<body>
    <?php
        //Retrieve the instructor id here
        session_start();
        //$_SESSION['userid'] = 2001; //TO BE REPLACED WITH SESSION RETRIEVEAL CODES!
        
    ?>
    <h1 align="center">Add a new subject</h1>
    <?php print "Your instructor ID: ".$_SESSION['userid']."<br>";?>
    <p>Please input the following information:</p>
    <form id="subject_input_form" method="post" action="processAdd.php">
    <p>Course prefix: <input type="text" id="course_prefix" name="course_prefix"></p>
    <p>Course name: <input type="text" id="course_name" name="course_name"></p>
    <input type="button" id="submitBtn" name="submitBtn" value="Submit" onclick="checkCourseInputCorrect();">
    </form>
</body>
</html>