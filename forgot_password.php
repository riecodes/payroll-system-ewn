<?php
session_start();
include 'login/conn.php';

// Check if user is already logged in
if(isset($_SESSION['user'])){
    header('location:admin/home.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password | EWN Payroll System</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Forgot Password</b>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Enter your username to reset password</p>
            
            <?php
            // Display messages
            if(isset($_SESSION['error'])){
                echo "
                    <div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa fa-warning'></i> Error!</h4>
                        ".$_SESSION['error']."
                    </div>
                ";
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])){
                echo "
                    <div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa fa-check'></i> Success!</h4>
                        ".$_SESSION['success']."
                    </div>
                ";
                unset($_SESSION['success']);
            }
            ?>

            <form action="forgot_password_process.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Username" maxlength="50" required autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <a href="login/index.php" class="btn btn-default btn-block btn-flat">Back to Login</a>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="check_username">
                            <i class="fa fa-search"></i> Check Username
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
</body>
</html>
