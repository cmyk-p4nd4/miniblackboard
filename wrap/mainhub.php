<?php
    require_once "../admin_module/access.php";
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

        <!-- Custom Style-->
        <link href="../assets/main-navbar-ui.css" rel="stylesheet">
    </head>
    <body>
        <?php 
            if (isset($_COOKIE["ARM_GPIO"])) {
                header("location: admin-dashboard.php");
            }else {
                require_once "main-navbar.php";
                ?>
                <div class="tab-content">
                <?php
                if ($_COOKIE["permission"] == 'T') {
                    require_once "../instructor_module/course/courseContents.php";
                } else {
                    require_once "../student_module/courseMenu.php";
                    require_once "../student_module/checkStatistics.php";
                }
            }
        ?>
        </div>

    </body>
</html>