<!DOCTYPE html>
<html>
<head>
    <title>Course Menu</title>
	<link rel="stylesheet" type="text/css" href="courseMenu.css"/>
	<script src="courseMenu.js"></script>
</head>
<body>
    <?php
        session_start();
        $_SESSION['userid'] = 2001;//TO BE REPLACED WITH SESSION RETRIEVEAL CODES!
    ?>
    <h1 align="center">Course Menu</h1>
    <?php
    print "<p align='right'> <button id='logoutBtn' name='logoutBtn' onclick=''>Log out</button><button id='detailsBtn'
     name='detailsBtn' onclick=''>Your details</button></p>";
    print "<p>Your instructor ID: ".$_SESSION['userid']."</p>";

    
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

    print "<p>Your courses:</p>";

    //retrieve all instructor's courses
    $query = "SELECT course_prefix, coursename FROM courses WHERE instructorid = '".$_SESSION['userid']."'";
    $result = mysqli_query($connect,$query);
    if (!$result)
    {
        die("Unable to do query with server, reason: ".mysqli_connect_errno());
    }

    $i = 0;
    if (mysqli_num_rows($result) > 0)
    {
        //display buttons for navigating to each subject.
        print "You have a total of ".mysqli_num_rows($result)." subjects.<br>";
        print "<div id='resultList'>";
        while ($row = mysqli_fetch_assoc($result))
        {
            $courseInf = $row["course_prefix"]." ".$row["coursename"];
            $i++;
            print "<p><button id='courseBtn".$i."' name='".$i."' onclick='processCourse(\"".$row["course_prefix"]."\")'>".$courseInf."</button></p>";
            
        }
        print "</div>";
    }
    else
    {
        print "You have no teaching courses<br>";
        
    }

    mysqli_close($connect);
    ?>

    
</body>
</html>