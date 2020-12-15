<nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-between">
    <span class="navbar-brand"><img src="../assets/minibb.ico" width="40" height="40" alt=""></span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarLeft" aria-controls="navbarLeft" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse text-white" id="navbarLeft">
        <ul class="navbar-nav" style="color:aliceblue !important;">
            <li class="nav-item active">
                <a class="nav-link nav-item" href="#course-list" data-toggle="tab" role="tab" aria-selected="TRUE">Course</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Grade</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#"></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="profileLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $welcomeMsg; ?>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileLink">
                    <a class="dropdown-item" id="edit-profile" data-toggle="modal" data-target="#profileForm">Edit Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" id="sign-out" href="..\admin_module\logout.php">Sign Out</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="profileForm">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body container">
                    <form id="profilecontent">
                        <div class="form-group">
                            <img src="..\assets\def-image.jpg" class="mx-auto d-block" width="50%" height="auto">
                        </div>
                        <div class="form-group row">
                            <div class="input-group">
                                <span class="input-group-icon col-sm-2 col-form-label"><i class="fa fa-hashtag" aria-hidden="true"></i></span>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control-plaintext" readonly value="<?php echo $_COOKIE["userid"];?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="input-group">
                                <span class="input-group-icon col-sm-2 col-form-label"><i class="fa fa-commenting-o" aria-hidden="true"></i></span>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nick-input" value="<?php if (!empty($_COOKIE["alias"]))echo $_COOKIE['alias']; else echo "No Nickname";?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="input-group">
                                <span class="input-group-icon col-sm-2 col-form-label"><i class="fa fa-id-badge" aria-hidden="true"></i></span>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control-plaintext" readonly 
                                    value="<?php 
                                    switch ($_COOKIE["permission"]) {
                                        case 'S':
                                            echo "Student";
                                            break;
                                        case 'T':
                                            echo "Instructor";
                                            break;
                                    }
                                    ?>
                                    ">
                                </div>
                            </div>
                        </div>
                        <?php
                            if ($_COOKIE['permission'] == 'S') {
                            require_once "../admin_module/connection.php";
                            $results = $conn->query("SELECT gender, birthday from studentinfo where userid=".$_COOKIE['userid']);
                            $gender = '';
                            $birthday = null;
                            if ($results->num_rows == 0) {
                                $gender = "Unknown";
                                $birthday = (new DateTime())->setTimestamp(0);
                            } else {
                                $arr = $results->fetch_array();
                                $gender = $arr[0];
                                $birthday = new DateTime($arr[1]);
                            }
                            
                        ?>
                        <div class="form-group row">
                            <div class="input-group">
                                <span class="input-group-icon col-sm-2 col-form-label"><i class="fa fa-venus-mars" aria-hidden="true"></i></span>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="gen-input" value="<?php echo $gender;?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="input-group">
                                <span class="input-group-icon col-sm-2 col-form-label"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="birth-input" value="<?php echo date_format($birthday, "Y-m-d");?>">
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="form-control" id="nickUpdate">Update Nickname</button>
                </div>
                <script>
                    $(function() {
                        var input1 = $("#profilecontent #nick-input").val();
                        $("#nickUpdate").click(function() {
                            if (input1 != $("#nick-input").val()) {
                                $.post("navbar-jquery.php", {
                                    val: $("#nick-input").val(),
                                    changenick: '1'
                                }).done(function () {
                                    location.reload();
                                });
                            }
                            if ($("#birth-input").length + $("#gen-input").length >=0) {
                                $.post("navbar-jquery.php", {
                                    gender: $("#gen-input").val(),
                                    birth: $("#birth-input").val(),
                                    gb: '1'
                                }).done(function() {
                                    location.reload();
                                });
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</nav>