<?php
    require_once "../admin_module/access.php";
    require_once dirname(__FILE__)."/../admin_module/connection.php";
    $stmt = $conn->prepare("SELECT distinct course_contents.type, exams.exam_name, exams.startdate, exams.duration from exams, course_contents where course_contents.courseid = exams.relevant_subject AND exams.relevant_subject = ?");
    $stmt->bind_param("i", $_COOKIE["courseid"]);
    $stmt->execute();
    $result = $stmt->get_result();
    // $list = $result->fetch_all();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Welcome, <?php echo $welcomeMsg; ?> - MiniBlackboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="std-courseDisplay.js"></script>
    </head>
    <body>
        
        <?php 
            require_once "course-navbar.php";
        ?>
        <div class="list-group" id="list-div">
            <div class="row">
            <?php
                while ($row= $result->fetch_array()) {
                ?>
                    <div class="col-md-4">
                        <a style="cursor:pointer" onclick='onCourseClicked("<?php echo $row[1]; ?>","<?php echo $row[2]; ?>","<?php echo $row[3]; ?>"," <?php echo $row[1];?>");'>
                            <div class="card">
                                <h5 class="card-header"><?php print $row[0].": ".$row[1];?></h5>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Commit time: <?php echo date_format(date_create($row[2], new DateTimeZone("Asia/Hong_Kong")), "F j, Y h:ia ")?></li>
                                        <li class="list-group-item">Due Date: <?php echo date_format(date_add(date_create($row[2], new DateTimeZone("Asia/Hong_Kong")), new DateInterval("PT".strtoupper(implode('', explode(";", $row[3]))))), "F j, Y h:ia ");?></li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>

