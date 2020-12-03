<?php
    require_once "admin_module.php";
    
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
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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
                        <form class="center">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="uuid" placeholder="UserID" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="clicker" value="Sign In" />
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 register-form">
                        <h4>Register</h4>
                        <form class="center">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-userid" placeholder="UserID" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="reg-password" placeholder="Password" required pattern="[\S]{6,}" title="Password must be atleast 6 characters long">
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
                                <input type="submit" class="clicker" value="Create Account" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>