<?php require_once dirname(__FILE__)."/../../admin_module/access.php"?>
<!DOCTYPE html>
<html>
<head>
        <title>Welcome, <?php echo $welcomeMsg; ?> - MiniBlackboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="courseContents.js"></script>
</head>
<body>
    <?php
    require_once "../inst-navbar.php";
    global $conn;
    function printReturnForm()
    {
        print "<form id='returnForm' method='post' action='/miniblackboard/wrap/mainhub.php'>";
        print "<input type = 'submit' id='submitBtn' name='submitBtn' value='Return to course menu'>";
        print "</form>";
    }
    ?>
    <div class="alert alert-dark" role="alert">Contents for this course:</div>
    <?php
    $coursePrefix = $_COOKIE['course_prefix'];

    //get the courseid from coursePrefix
    $query = "SELECT courseid FROM courses WHERE courseid = ".$_COOKIE['courseid'];
    $result = $conn->query($query);
    if (!$result)
    {
        die("Unable to get the course information from the server.");
    }

    if (mysqli_num_rows($result)<0)
    {
        die("Cannot the course ".$coursePrefix.".");
    }
    //only one courseid will be obtained
    $row = $result->fetch_assoc();
    $courseid = $row['courseid'];
    $result->free_result();


    //get relevant data from db
    $query = "SELECT course_contents.courseid, course_contents.contentid, course_contents.type, exams.exam_name
              FROM course_contents, exams
              WHERE course_contents.courseid = '".$courseid."' AND course_contents.contentid = exams.examid;";
    $result = $conn->query($query);

    if (!$result)
    {
        die("Unable to get the course information from the server.");
    }
    ?>
    <div class="card">
        <div class="card-body">
            <div class="list-group list-group-flush">
                <?php
                while ($row = $result->fetch_array()) {
                ?>
                    <button class="list-group-item list-group-item-action" title="Click to view" style="cursor: pointer" id='link-ref'><?php 
                        echo $row[2].": ".$row[3];
                    ?></button><input type="hidden" id='content-ref' value='<?php echo $row[1];?>'>
                <?php
                } 
                ?>
            </div>
        </div>
        <div class="card-footer">
            <?php echo $result->num_rows . " result(s) found.";
            print "<form id='addContentForm' method='post' action='addContents.php'>";
            print "<input type='hidden' id='currentCourse' name='currentCourse' value='".$coursePrefix."'>";
            print "<input type='submit' id='addContentBtn' name='addContentBtn' value='Add contents'>";
            print "</form>";
            $result->close();
            $conn->close()
            ?>
        </div>
    </div>
</body>
<script>
    $('button[id="link-ref"]').click(function() {
        let tmp = $("input[id='content-ref']").first().val();
        onViewChosen(tmp);
    });
</script>
</html>