<?php
    session_start();
    if (!isset($_SESSION["ARM_GPIO"])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        session_unset();
        session_destroy();
        exit;
    } 
?>

<!DOCTYPE HTML>
<html>

    <head>
        <title>Admin - MiniBlackboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>

<body>
    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills bg-primary">
                <img class="mx-auto"src="../assets/minibb.png" style="width:30%;"/>
            </div>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="" data-toggle="pill" href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true">General</a>
                <a class="nav-link" id="" data-toggle="pill" href="#v-pills-modify" role="tab" aria-controls="v-pills-modify" aria-selected="false">Modify</a>
                <a class="nav-link" id="" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                <a class="nav-link" id="" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent" style="padding-right: 15px;">
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                    <div class="card" >
                        <h5 class="card-header">User List</h5>
                        <div class="card-body">
                            <?php 
                                require_once "../admin_module/connection.php";
                                $stmt = $conn->prepare("select * from permission");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows != 0) {
                            ?> 
                            <table class="table">  
                                <thead>
                                    <th scope="col">UserID</th>
                                    <th scope="col">Permission</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Alias</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Profile Image</th>
                                </thead>
                                <tbody>
                            <?php 
                                    while($row = $result->fetch_row()) {
                                        echo "<tr>";
                                        echo "<th scope='row'>".$row[0]."</th>";
                                        $row = array_slice($row, 1);
                                        foreach ($row as $value) {
                                            echo "<td>".$value."</td>";
                                        }
                                        unset($value);
                                        echo "</tr>";
                                    }
                                }
                            ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <?php 
                                echo $result->num_rows." record(s) found.";
                                $stmt->free_result();
                                $stmt->close();
                                $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-modify" role="tabpanel" aria-labelledby="v-pills-modify-tab">
                    
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    
                </div>
            </div>
        </div>
    </div>
</body>

</html>