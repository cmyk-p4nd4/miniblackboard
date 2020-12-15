<!DOCTYPE html>
<html>
<head>
    <title>Add Course contents</title><!--Target: set to "Course Contents for XXX12345"-->
	<link rel="stylesheet" type="text/css" href="addContents.css"/>
	<script src="addContents.js"></script>
</head>
<body>
    <h1 align='center'>Add contents</h1>
    <?php
        session_start();
        $courseCode = $_POST['currentCourse'];
        $coursePrefix = explode(" ",$courseCode);
        print "<form id='returnForm' name='returnForm' action='courseContents.php' method='post'>";
        print "<p align='right'>Your instructor ID: ".$_COOKIE['userid']."<br>";
        print "<input type='submit' value='Return to course contents'></p>";
        print "<input type='hidden' id='courseInput' name='courseInput' value='".$coursePrefix[0]."'>";
        print "</form>";

        print "<p>Course: ".$courseCode."</p>";
        print "<p>Which kind of course contents to add? "
        ."<select id='chooseContents' onchange='onChange()'>
          <option value='Select...'>Select...</option>
          <option value='Exam'>Exam</option>
          <option value='Textbook'>Textbook</option>
          <option value='Tutorial'>Tutorial</option>
        </select>"
        ."</p>";
    ?>
    <div id="inputDiv" name="inputDiv">



    </div>
    
</body>
</html>