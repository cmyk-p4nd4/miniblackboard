<!DOCTYPE html>
<html>
<head>
    <title>Modify exam</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
    <script src="modifyExam.js"></script>
</head>

<body onload="loading('<?php print $_POST['modifyExamID']; ?>')">
    <h1 align="center">Modify Exam</h1>
    <?php
        session_start();
        print "<p align='right'>Your instructor ID: ".$_SESSION['userid']
        ."</p>";
        //print "<script>loading('".$_POST['modifyExamID']."');</script>";
        
    ?>

    <div id="modifyContent">
        <p id ='loadingLabel'>Loading... Please wait...</p>


    </div>

</body>
</html>
