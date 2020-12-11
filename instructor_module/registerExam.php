<!DOCTYPE html>
<html>
<head>
	<title>Register an exam</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
	<script src="registerExam2.js"></script>
</head>

<body onload="init();">
<?php
		//start a new session, in actual implementation no need
		session_start();
		$_SESSION["examName"] = $_POST["examName"];
		$_SESSION["examDate"] = $_POST["examDate"];
		$_SESSION["examTime"] = $_POST["examTime"];
		$_SESSION["examDurationHours"] = $_POST["examDurationHrs"];
		$_SESSION["examDurationMinutes"] = $_POST["examDurationMinutes"];
?>
	<h1 align="center">Register an exam</h1>
	<form id="inputForm" method="post" action="finishExamRegister.php">
	<p>
	<?php
	print "Current exam information<br><br>";
	print "Name of exam: ". $_SESSION["examName"]."<br>";
	print "Start date of the exam: ".  $_SESSION["examDate"]."<br>";
	print "Start time of the exam: ". $_SESSION["examTime"]."<br>";
	print "Duration of the exam: ". $_SESSION["examDurationHours"]. " hours, ".$_SESSION["examDurationMinutes"]." minutes<br>";
	?>
	</p>
	<p id="questionNumber"></p>
	<p>Please select the question type:
		<select name="questiontype" id="questiontype" onChange="onTypeChange();">
			<option>Select....</option>
			<option name="mcq">MC Questions</option>
			<option name="sq">Short Questions</option>
			<option name="fill">Fill in the blanks</option>
		</select>
	</p>
	<div id="question" name="question">
		
	</div>
	<input type="hidden" id = "questionCnt" name="questionCnt"><input type="hidden" id = "questionAnswers" name ="questionAnswers">
	<p><input name="prev" id="prev" type="button" value="Previous question" onclick="onPrevQuestionClicked();">  <input name="next" id="next" type="button" value="Next question" onclick="onNextQuestionClicked();"> <input name="closebtn" id="closebtn" type="button" value="Finished" onclick="onFinishClick();"></p>
	</form>
	
	<?php
	
	?>
</body>
</html>