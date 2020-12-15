<!DOCTYPE html>
<html>
<head>
    <title>Statistics of exam</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
	<script src="checkStatistics.js"></script>
</head>
<body onload="init();">
    <?php
        session_start();
        $examID = $_POST['refExamID'];
        $examPrefix = $_POST['refExamPrefix'];
        //you have $_SESSION['userid']

        print "<div id='userInfoDiv' align='right'>".
        "<p>Your instructor ID is: ".$_SESSION["userid"]."<br>".
        "<button id='LogoutBtn' name='LogoutBtn' onclick='logout();'>Log out</button>"
        ."</p>"
        ."</div>";

        
    ?>
    <h1 align='center' id='titleH1'></h1>
    <div id="overallDiv">
        <p id='refExamID' hidden><?php echo $_POST['refExamId']?></p>;
        <p id='refExamPrefix' hidden><?php echo $_POST['refExamPrefix']?></p>
        <p>Overall statistics: </p>
        <p id='studentCountLbl'></p>
        <p id='omaxLbl'></p>
        <p id='ominLbl'></p>
        <p id='omedianLbl'></p>
        <p id='oaverageLbl'></p>
    </div>

    <div id="questionDiv">
        <h2 id='questionDivH2'>Statistics of each question</h2>
        <p id='questionSelect'>Question: <select id='qSelect'></select></p>
        <p id='questionDisp'></p>
        <p id='percentageDisp'></p>
        <p id='averageDisp'></p>
    </div>

    <div id="buttonDiv">
    </div>
</body>
</html>
