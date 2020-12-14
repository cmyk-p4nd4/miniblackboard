<!DOCTYPE html>
<html>
<head>
    <title>Statistics of exam</title>
	<link rel="stylesheet" type="text/css" href="registerExam.css"/>
	<script src="checkStatistics.js"></script>
</head>
<body>
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

        //do a set of query to retrieve 
    ?>
</body>
</html>
