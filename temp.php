<?php 
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: mainhub.php");
        exit;
    }
?>

<!doctype html>
<html lang="en" class="h-100">
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<head>
    <title>Mini BlackBoard</title>
    <meta content="/images/branding/googleg/1x/googleg_standard_color_128dp.png" itemprop="image">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style type="text/css">
        @font-face {
            font-family: 'Metropolis';
            src: local('Metropolis Thin'), local('Metropolis-Thin'),
                url('Metropolis-Thin.woff2') format('woff2'),
                url('Metropolis-Thin.woff') format('woff'),
                url('Metropolis-Thin.ttf') format('truetype');
            font-weight: 100;
            font-style: normal;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&amp;display=swap" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles -->
    <link href="modal-css.css" rel="stylesheet">
</head>

<?php
    require_once "admin_module/connection.php";

    //global variables
    $rUserID = $rPassword = $rConfirmPassword = "";
    $userID = $password = "";
    $login_errMsg = $register_errMsg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //check if user is perfoming login
        if (!isset($_POST["uuid"]) && !isset($_POST["password"])) {
            $userID = trim($_POST["uuid"]);
            $password = trim($_POST["password"]);
            if ($stmt = $conn->prepare("select userid,alias, password from permission where userid = ?")) {
                $stmt->bind_param("i", $userID);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) { // check if account exists
                        $stmt->bind_result($id,$alias,$hashed_password);
                        $stmt->fetch();
                        if (password_verify($password, $hashed_password)) {
                            session_start(); //create new session for user
                            //store user basic variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["userid"] = $id;
                            $_SESSION["alias"] = $alias;

                            header("location: mainhub.php");
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
        } else {
            //otherwise switch to registration handler
            session_unset();
            session_destroy();

            
        }
    }
    $conn->close();
?>

<body class="bg-white">
    <!-- Begin page content -->
    <div id="login" style="height: 100%">
        <div class="d-flex align-items-center flex-column">
            <img class="" style="width:200px" src="assets/minibb.png" alt="MiniBB Logo">
            <p><strong>Welcome to MiniBlackboard</strong></p>
            <p>Please Sign-in to Continue</p>
            <a href="#modal-login" role="button" class="btn btn-secondary btn-lg" data-toggle="modal">Sign In</a>
        </div>
        <div id="modal-login" class="modal fade">
            <div class="modal-login">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Sign In</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="uuid" placeholder="UserID" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" class="form-control" name="password" placeholder="Passcode" required>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block btn-lg" id="sign-in">Sign In</button>
                                <span class="help-tooltip" style="font-size: small;color: red;"><?php echo $login_errMsg?></span>
                            </div>
                            <p><a href="#">Forgot Password?</a></p>
                        </form>
                    </div>
                    <div class="modal-footer">Don't have an account? <a href="#modal-register" role="button" data-dismiss="modal" data-toggle="modal">Create one</a></div>
                </div>
            </div>
        </div>
        <div id="modal-register" class="modal fade">
            <div class="modal-dialog modal-register">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Register</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-userid" placeholder="UserID" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-password" placeholder="Password" required pattern="[\S]{6,}" title="Password must be atleast 6 characters long">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-password-check" placeholder="Confirm Password" required>
                                <span class="help-tooltip" style="font-size: small;color: red;"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-alias" placeholder="Nickname" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-email" placeholder="Email" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <input type="text" class="form-control" name="reg-gender" placeholder="Gender" required>
                                </div>                            
                                <div class="form-group col">
                                    <input type="text" class="form-control" name="reg-birthday" placeholder="Birthday (YYYY/MM/DD)" required 
                                    pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"
                                    title="Enter a date in this format YYYY/MM/DD">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-block btn-lg">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>

    </div>
</body>
</html>