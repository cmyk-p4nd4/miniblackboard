<?php
    require_once "admin_module/connection.php";
    //global variables
    $rUserID = $rPassword = $rConfirmPassword = "";
    $userID = $password = "";
    $login_errMsg = $register_errMsg = "";
    $forgot_errMsg = "";
    $errFlag = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //check if user is perfoming login
        if (isset($_POST["uuid"]) && isset($_POST["password"])) {
            $userID = trim($_POST["uuid"]);
            $password = trim($_POST["password"]);
            if ($stmt = $conn->prepare("select userid, alias,password,permission from permission where userid = ?")) {
                $stmt->bind_param("i", $userID);                
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) { // check if account exists
                        $stmt->bind_result($id,$alias,$hashed_password, $permission);
                        $stmt->fetch();
                        if (password_verify($password, $hashed_password)) {
                             //create new session for user
                            //store user basic variables
                            setcookie("userid", $id, time()+3600, '/');
                            setcookie("alias", $alias, time()+3600, '/');
                            setcookie("loggedin", true, time()+3600, '/');
                            setcookie("permission", $permission, time()+3600, '/');
                            if ($permission == "A") setcookie("ARM_GPIO", 0x32f7, time()+3600, '/');
                            if ($permission == "A") setcookie("ARM_GPIO", 0x32f7, time()+3600, '/');
                           
                            header("location: wrap/mainhub.php");
                        } else {
                            $login_errMsg = "Your password is incorrect";
                        }
                    } else {
                        $login_errMsg = "User account does not exist";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later";
                }
            }
            $stmt->close();
        } else if (isset($_POST["reg-userid"])) {
            //otherwise switch to registration handler
            if (session_status() != PHP_SESSION_NONE) { //NULL Session handler
                session_unset();
                session_destroy();
            }

            $defaultEmail = "user@miniblackboard.com";

            $rUserID = trim($_POST["reg-userid"]);
            $rPassword = trim($_POST["reg-password"]);
            $rConfirmPassword = trim($_POST["reg-password-check"]);
            $nickname = trim($_POST["reg-alias"]);
            $mail = (empty(trim($_POST["reg-email"])) ? trim($_POST["reg-email"]) : $defaultEmail);

            if ($stmt = $conn->prepare("select userid from permission where userid = ?")) {
                $stmt->bind_param("i", $rUserID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows==1) {
                    $register_errMsg = "This id is already taken.";
                    $errFlag = true;                    
                }
                $stmt->close();
                
            }
            if ($rPassword != $rConfirmPassword) {
                $register_errMsg = "Password Mismatch.";
                $errFlag = true;
            }
            if (!$errFlag) {
                $stmt = $conn->prepare("insert into permission (userId, permission, password, alias, email) values (?, ?, ?, ?, ?)");
                $defaultRank = "S";
                
                $hashx = password_hash($rPassword, PASSWORD_DEFAULT);
                $stmt->bind_param("issss", $rUserID, $defaultRank, $hashx, $nickname, $defaultEmail);
                $stmt->execute();
                $stmt->close();
                header("location: ");
            } else {
                header("location: ");
            }
        } else if (isset($_POST["f-userid"])) {
            $rid = trim($_POST["f-userid"]);
            $rpw = trim($_POST["f-password"]);
            $stmt = $conn->prepare("select userid, password from permission where userid = ?");
            $stmt->bind_param("i", $rid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $stmt->close();
                $ehash = password_hash($rpw, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("update permission set `password` = ? where userid = ?");
                $stmt->bind_param("si", $ehash, $rid);
                $stmt->execute();
                $forgot_errMsg = "";
                $login_errMsg = "Password Resetted!";
            } else {
                $forgot_errMsg = "User account does not exists";
            }
            $stmt->close();
            header("location: ");
        }
    }
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MiniBlack Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Custom Style-->
        <link href="assets/index-ui.css" rel="stylesheet">
    </head>
    <body>
        <div style="height: 100%;">
            <div class="d-flex align-items-center flex-column">
                <img class="" style="width:200px" src="assets/minibb.png" alt="MiniBB Logo">
                <p><strong>Welcome to MiniBlackboard</strong></p>
                <p>Please Sign-in to Continue</p>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 login-form">
                        <h4>Sign In</h4>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="uuid" placeholder="UserID" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="clicker" value="Sign In"/>
                                <small class="text-primary float-right" data-toggle="collapse" href="#div-forget-password" style="cursor: pointer;">Forget Password?</small>
                            </div>
                            <span class="help-block"><?php echo $login_errMsg; ?></span>
                        </form>
                    </div>
                    <div class="col-md-6 register-form">
                        <h4>Register</h4>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-userid" placeholder="UserID *" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="reg-password" placeholder="Password *" required pattern="[\S]{6,}" title="Password must be atleast 6 characters long">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="reg-password-check" placeholder="Confirm Password *" required>
                                <span class="help-tooltip" style="font-size: small;color: red;"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-alias" placeholder="Nickname *" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-email" placeholder="Email">
                            </div>
                            <!-- <div class="form-row">
                                <div class="form-group col-4">
                                    <input type="text" class="form-control" name="reg-gender" placeholder="Gender" required>
                                </div>                            
                                <div class="form-group col">
                                    <input type="text" class="form-control" name="reg-birthday" placeholder="Birthday (YYYY/MM/DD)" required 
                                    pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"
                                    title="Enter a date in this format YYYY/MM/DD">
                                </div> 
                            </div> -->
                            <div class="form-group" >
                                <input type="submit" class="clicker" value="Create Account"/>
                            </div>
                            <span class="help-block"><?php echo $register_errMsg;?></span>
                        </form>
                    </div>
                </div>
                <div class="collapse row justify-content-md-center" id="div-forget-password">
                    <div class="reset-password-form">
                        <h4>Reset Password</h4>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" name="f-userid" placeholder="User ID *" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="f-password" placeholder="Password *" required pattern="[\S]{6,}">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="f-pwcheck" placeholder="Confirm Password *" title="Password Mismatch" required>
                            </div>
                            <div class="form-group" >
                                <input type="submit" class="clicker" value="Reset Password" id="submit-reset-password"/><br>
                                <label class="help-block" id="small-error"><?php echo $forgot_errMsg;?></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
    $(function(){
        $(".reset-password-form").ready(function() {
            var flag = false;
            $("input[name='f-pwcheck']").on("keyup", function(){
                //console.log($("input[name='f-password']").val() == $(this).val());
                if ($("input[name='f-password']").val() != $(this).val()) {
                    $(this).addClass("big-error");
                    flag = false;
                } else {
                    $(this).removeClass("big-error");
                    flag = true;
                }
            });

            // var form = $(this);
            // $("#submit-reset-password").on("click", function() {
            //     var arr = [];
            //     form.find("input[name*='f-']").each(function() {
            //         arr.push($(this).val());
            //     });
            //     console.log(arr.slice(0,-1));
            //     if (flag) {
            //         $.post("<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>", {
            //             data: arr.slice(0,-1),
            //             resetu: '1'
            //         }, function () {
            //             location.reload();
            //         });
                    
            //     }
            // });
        });
    });
    </script>
</html>