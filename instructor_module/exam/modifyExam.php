<!DOCTYPE html>
<html>
<head>
</head>
    <title>Modify exam</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
    <script src="modifyExam.js"></script>
</html>

<body >
    <h1 align="center">Modify Exam</h1>
    <?php
        session_start();
        print "<p align='right'>Your instructor ID: ".$_SESSION['userid']
        ."</p>";
        print "<script>loading('".$_POST['modifyExamID']."');</script>";
    ?>

    <div id='content'>



    </div>

</body>

