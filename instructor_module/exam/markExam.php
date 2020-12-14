<!DOCTYPE html>
<html>
<head>
    <title>Marking a student's work</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
	<script src="markExam.js"></script>
</head>
<body>
    <?php
        $examid = $_POST['gradeForm_refExamID'];
        $examPrefix = $_POST['gradeForm_refExamPrefix'];
     ?>
     <p id='examidRef' hidden><?php echo $examid;?></p>
     <p id='examPrefix' hidden><?php echo $examPrefix;?></p>
    
    <h1 align="center">Marking exam for <?php echo $examPrefix;?></h1>
    <p id='chooseStdLbl'>Choose Student to grade: <select id='chooseStd' name='chooseStd' onchange="displayStdRecord();"></select></p>
    <div id ='stdInfDiv'>
        
    </div>

    <div id ='stdQuestionDiv'>

    </div>
    <script>retrieveStudentID(<?php echo $examid?>);</script>
</body>
</html>