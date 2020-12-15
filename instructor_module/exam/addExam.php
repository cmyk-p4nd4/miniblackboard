<!DOCTYPE html>
<html>
<head>
	<title>Register an exam</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
	<script src="registerExam.js"></script>
</head>
<body onload="initElements();">
    <?php
        session_start();
    ?>

    <h1 align="center">Register an exam</h1>
    <?php
        print "<p>";
        print "Your instructor id is: ".$_COOKIE['userid']."<br>";
        print "You are adding an exam for course ".$_POST['courseID']."<br>";
    ?>
	<form action="registerExam.php" method="post" id="registerForm">
    <?php
        print "<input type='hidden' id='currentCourse' name='currentCourse' value='".$_POST['courseID']."'>";
    ?>
	<p>Please enter the following information:</p>
	<p>Name of the exam: <input type="text" id="examName" name="examName"/></p>
	<p>Start date of the exam: <input type="date" id="examDate" name="examDate"/></p>
	<p>Start time of the exam: 
		<input type="time" id="examTime" name="examTime"/>
	</p>
	<p>Duration of the exam:
		<select id="examDurationHrs" name="examDurationHrs">
		</select>
		<select id="examDurationMinutes" name="examDurationMinutes">
		</select>
	</p>
	<p><button type="button" onclick="check();">Next</button></p>
	</form>
	<?php 
			print "<form id='returnForm' method='post' action='../course/courseContents.php'>";
			print "<input type = 'hidden' id='courseInput' name='courseInput' value='".$_POST['courseID']."'>";
			print "<input type = 'submit' id='submitBtn' name='submitBtn' value='Return to course content'>";
			print "</form>";
	?>
</body>
</html>
