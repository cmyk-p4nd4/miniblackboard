<?php
    if (!isset($_POST['examid']))
    {
        die("No authorized access!");
    }

    $examid = $_POST['examid'];
    $server = "us-cdbr-east-02.cleardb.com";
	$user = "b06abb5474de88";
	$pw = "5b46e8a1";
    $db = "heroku_2d30a0192d19383";
    
    $connect = mysqli_connect($server,$user,$pw,$db);
    if (!$connect)
	{
		die("Fail to connect with server \n Please contact system admin with the following reason: ".mysqli_error());
    }

    $query = "SELECT * FROM exam_records WHERE examid='".$examid."';";
    $result = mysqli_query($connect,$query);

    if (!$result)
    {
        die("Query failed, reason: ".mysqli_error());
    }

    if (mysqli_num_rows($result) > 0)
    {
        $records = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result))
        {
            //fetch a row, then pack it as json object.
            $records[$i] = $row;
            $i++;
        }

        print json_encode($records);
    } else
    {
        die("No record found.");
    }
?>