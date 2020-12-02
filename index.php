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

<body class="bg-white text-dark">
    <!-- Begin page content -->
    <div id="login" style="height: 100%">
        <div class="d-flex align-items-center flex-column">
            <img class="" style="width:200px" src="assets/minibb.png" alt="MiniBB Logo">
            <p><strong>Welcome to MiniBlackboard</strong></p>
            <p>Please Sign-in to Continue</p>
            <a href="#modal-login" role="button" class="btn btn-primary btn-lg" data-toggle="modal">Sign In</a>
        </div>
        <div id="modal-login" class="modal fade">
            <div class="modal-dialog modal-login">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Sign In</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="uuid" placeholder="UserID" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" class="form-control" name="password" placeholder="Passcode" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
                            </div>
                            <p><a href="#">Forgot Password?</a></p>
                        </form>
                    </div>
                    <div class="modal-footer">Don't have an account? <a href="#modal-register" role="button" data-dismiss="modal" data-toggle="modal">Create one</a></div>
                </div>
            </div>
        </div>
        <div id="modal-register" class="modal fade">
            <div class="modal-dialog modal-login">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Register</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-uid" placeholder="UserID" required="required">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-password" placeholder="Password" required="required">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-alias" placeholder="Nickname" required="required">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="reg-email" placeholder="Email" required="required">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-3">
                                    <input type="text" class="form-control" name="reg-gender" placeholder="Gender" required="required">
                                </div>                            
                                <div class="form-group col">
                                    <input type="date" class="form-control" name="reg-birthday" placeholder="Birthday" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>