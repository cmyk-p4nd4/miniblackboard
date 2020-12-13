<?php

if (!isset($_COOKIE["ARM_GPIO"])) {
    header("location: /miniblackboard/wrap/trying-to-outsmart-huh.php");
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
</head>

<body>
    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills bg-primary">
                <img class="mx-auto" src="../assets/minibb.png" style="width:30%;" />
            </div>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link" id="v-pills-general-tab" data-toggle="pill" href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true">General</a>
                <a class="nav-link" id="v-pills-modify-tab" data-toggle="pill" href="#v-pills-modify" role="tab" aria-controls="v-pills-modify" aria-selected="false">Modify</a>
                <a class="nav-link" href="..\admin_module\logout.php">Logout</a>
            </div>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent" style="padding-right: 15px;">
                <div class="tab-pane fade show active" role="tabpanel">Select an option from the left
                </div>
                <div class="tab-pane fade" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                    <div class="card">
                        <h5 class="card-header">User List</h5>
                        <div class="card-body" id="user-list">
                            <?php
                            require_once "../admin_module/connection.php";
                            $stmt = $conn->prepare("select * from permission");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows != 0) {
                            ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th scope="col">UserID</th>
                                            <th scope="col">Permission</th>
                                            <th scope="col">Password</th>
                                            <th scope="col">Alias</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Profile Image</th>
                                            <th scope="col" style="color:red; text-align:center">DELETE</th>
                                        </thead>
                                        <tbody id="user-list-body">
                                            <?php
                                            while ($row = $result->fetch_row()) {
                                                echo "<tr value=" . $row[0] . ">";
                                                echo "<th scope='row'>" . $row[0] . "</th>";
                                                $row = array_slice($row, 1);
                                                foreach ($row as $value) {
                                                    echo "<td>" . $value . "</td>";
                                                }
                                                unset($value);
                                                echo "<td class='text-center'><i class='fa fa-times-circle'></i>";
                                                echo "</tr>";
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <?php
                            echo $result->num_rows . " record(s) found.";
                            $stmt->free_result();
                            $stmt->close();
                            ?>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">Course List</h5>
                        <div class="card-body" id="course-list">
                            <?php
                            $stmt = $conn->prepare("select courseid,course_prefix, coursename, instructorid, contents from courses");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows != 0) {
                            ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th scope="col">#</th>
                                            <th scope="col">Course ID</th>
                                            <th scope="col">Course Name</th>
                                            <th scope="col">Instructor</th>
                                            <th scope="col">Contents</th>
                                            <th scope="col" style="color:red; text-align:center">DELETE</th>
                                        </thead>
                                        <tbody id="course-list-body">
                                            <?php
                                            while ($row = $result->fetch_row()) {
                                                echo "<tr value=" . $row[0] . ">";
                                                echo "<th scope='row'>" . $row[0] . "</th>";
                                                $row = array_slice($row, 1);
                                                foreach ($row as $value) {
                                                    echo "<td>" . $value . "</td>";
                                                }
                                                unset($value);
                                                echo "<td class='text-center'><i class='fa fa-times-circle'></i>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <?php
                            echo $result->num_rows . " record(s) found.";
                            $stmt->free_result();
                            $stmt->close();
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-modify" role="tabpanel" aria-labelledby="v-pills-modify-tab">
                    <div class="card">
                        <h5 class="card-header">Add Courses</h4>
                            <div class="card-body">
                                <form id="course" method="POST">
                                    <div class="form-row">
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect1">Course ID</label>
                                                </div>
                                                <input type="text" class="form-control" id="inputGroupSelect1" name="createcourse-1" required>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect2">Course Name</label>
                                                </div>
                                                <input type="text" class="form-control" id="inputGroupSelect2" name="createcourse-2" required>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect3">Instructor Assigned</label>
                                                </div>
                                                <select class="form-control tutDropdown" id="inputGroupSelect3" name="createcourse-3" required></select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type='button' class="form-control" value="Add" id="courseForm">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">Add User</h5>
                        <div class="card-body">
                            <form id="user" method="POST">
                                <div class="form-row">
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect11">User ID</label>
                                            </div>
                                            <input type="text" class="form-control" id="inputGroupSelect11" name="createuser-1" required>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect12">Password</label>
                                            </div>
                                            <input type="password" class="form-control" id="inputGroupSelect12" name="createuser-2" required>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect13">Permission</label>
                                            </div>
                                            <select class="form-control" id="inputGroupSelect13" name="createuser-3" required>
                                                <option value="S">S</option>
                                                <option value="T">T</option>
                                                <option value="A">A</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect14">Name</label>
                                            </div>
                                            <input type="text" class="form-control" id="inputGroupSelect14" name="createuser-4" required>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <input type='button' class="form-control" value="Add" id="userForm">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">Add User to Course</h5>
                        <div class="card-body">
                            <form id="appendstd">
                                <div class="form-row">
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect31">Select Subject</label>
                                            </div>
                                            <select class="form-control subDropdown" id="inputGroupSelect31" name="appenduser-1" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row"> 
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect32">Select Student</label>
                                            </div>
                                            <select class="form-control custom-select stdDropdown" id="inputGroupSelect32" name="appenduser-2" size="4"  multiple></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-auto">
                                        <input type="button" class="form-control" value="Submit" id="appendstdForm">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">Remove User from Course</h5>
                        <div class="card-body">
                            <form id="removestd">
                                <div class="form-row">
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect41">Select Subject</label>
                                            </div>
                                            <select class="form-control r-subDropdown" id="inputGroupSelect41" name="removeuser-1" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row"> 
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect42">Select Student</label>
                                            </div>
                                            <select class="form-control custom-select r-stdDropdown" id="inputGroupSelect42" name="removeuser-2" size="4"  multiple></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-auto">
                                        <input type="button" class="form-control" value="Submit" id="removestdForm">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(function() {
        $("#course").ready(function() {
            $.post("../admin_module/admin-dashboard-populate.php", {
                func1: '1'
            }, function(data) {
                $(".tutDropdown").html(data);
            });
        });
        $("#appendstd").ready(function() {
            $.post("../admin_module/admin-dashboard-populate.php", {
                func2:'1'
            }, function(data) {
                $(".subDropdown").html(data);
            });
            $.post("../admin_module/admin-dashboard-populate.php", {
                func3:'1'
            }, function(data) {
                $(".stdDropdown").html(data);
            });
        });
        $("#modifyuser").ready(function() {
            $.post("../admin_module/admin-dashboard-populate.php", {
                    func2:'1'
            }, function(data) {
                $(".r-subDropdown").html(data);
            });
            
        });
        $(".r-subDropdown").change(function() {
            $.post("../admin_module/admin-dashboard-populate.php", {
                courseid: $(this).val(),
                func4: '1'
            }, function(data) {
                $(".r-stdDropdown").html("");
                $(".r-stdDropdown").html(data);
            });
        });
        $("#removestdForm").click(function() {
            var term =[];
            $("[name*='removeuser']").each(function() {
                term.push($(this).val());
            });
            $.post("../admin_module/admin-dashboard-populate.php", {
                datas: term,
                func5: '1'
            }).done(function() {
                location.reload();
            });
        });
        $("#courseForm").on('click', function(e) {
            var $form = $(this),
                id = $("input[name='createcourse-1']").val(),
                cname = $("input[name='createcourse-2']").val(),
                iid = $("select[name='createcourse-3']").val();
            //console.log(id,cname,iid);
            var posting = $.post("../admin_module/admin-dashboard-populate.php", {
                prefix: id,
                name: cname,
                id: iid,
                addc: '1'
            }).done(function() {
                location.reload();
            });
        });
        $("#userForm").on('click', function(e) {
            var reg_id = $("input[name='createuser-1']").val(),
            reg_pw = $("input[name='createuser-2']").val(),
            reg_perm = $("[name='createuser-3']").val(),
            reg_name = $("input[name='createuser-4']").val();
            console.log(reg_id, reg_pw, reg_perm, reg_name);
            $.post("../admin_module/admin-dashboard-populate.php", {
                uid: reg_id,
                pw: reg_pw,
                perm: reg_perm,
                name: reg_name,
                addu: '1'
            }).done(function() {
                location.reload();
            });
        });
        $("#appendstdForm").on("click", function() {
            var arr = [];
            $("select[name*='appenduser']").each(function() {
                arr.push($(this).val());
            });
            json_encode()
            $.post("../admin_module/admin-dashboard-populate.php", {
                subject: arr[0],
                students: arr[1],
                appendstd:'1'
            }).done(function() {
                location.reload();
            });
        });
        $("#user-list i.fa").on("click", function() {
            var target = $(this).closest("tr");
            target.css({
                "border": "2px solid red"
            });
            setTimeout(function() {
                if (confirm("Are you sure you want to remove this record? (Highlighted in red)")) {
                    //console.log(target.children().first().html());
                    target.remove();
                    $.post("../admin_module/admin-dashboard-populate.php", {
                        cid: target.children().first().html(),
                        removeu: '1'
                    }).done(function() {
                        location.reload();
                    });
                } else {
                    target.css({
                        "border": "none"
                    });
                    target.css({
                        "border-top": "1px solid #dee2e6"
                    });
                }
            }, 0);
        });
        $("#course-list i.fa").on("click", function() {
            var target = $(this).closest("tr");
            target.css({
                "border": "2px solid red"
            });
            setTimeout(function() {
                if (confirm("Are you sure you want to remove this record? (Highlighted in red)")) {
                    //console.log(target.children().first().html());
                    target.remove();
                    $.post("../admin_module/admin-dashboard-populate.php", {
                        cid: target.children().first().html(),
                        removec: '1'
                    }).done(function() {
                        location.reload();
                    });
                } else {
                    target.css({
                        "border": "none"
                    });
                    target.css({
                        "border-top": "1px solid #dee2e6"
                    });
                }
            }, 0);
        });
    });
</script>

</html>