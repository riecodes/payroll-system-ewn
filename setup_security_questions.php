<?php
session_start();
include 'login/conn.php';

// Check if user is already logged in
if(isset($_SESSION['user'])){
    header('location:admin/home.php');
}

// Check if reset_username is set
if(!isset($_SESSION['reset_username'])){
    header('location:forgot_password.php');
    exit();
}

$username = $_SESSION['reset_username'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Setup Security Questions | EWN Payroll System</title>
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
            <b>Setup Security Questions</b>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Setup security questions for <strong><?php echo htmlspecialchars($username); ?></strong></p>
            
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

            <form action="setup_security_questions_process.php" method="POST">
                <div class="form-group">
                    <label>Security Question 1:</label>
                    <select class="form-control" name="sec_1" required>
                        <option value="">Select a question</option>
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                        <option value="What city were you born in?">What city were you born in?</option>
                        <option value="What was your favorite subject in school?">What was your favorite subject in school?</option>
                        <option value="What is the name of your childhood best friend?">What is the name of your childhood best friend?</option>
                        <option value="What was your first car?">What was your first car?</option>
                        <option value="What is your favorite movie?">What is your favorite movie?</option>
                        <option value="What is the name of the street you grew up on?">What is the name of the street you grew up on?</option>
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="ans_1" placeholder="Answer 1" maxlength="100" required>
                    <span class="glyphicon glyphicon-question-sign form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <label>Security Question 2:</label>
                    <select class="form-control" name="sec_2" required>
                        <option value="">Select a question</option>
                        <option value="What is your father's middle name?">What is your father's middle name?</option>
                        <option value="What was the name of your elementary school?">What was the name of your elementary school?</option>
                        <option value="What is your favorite color?">What is your favorite color?</option>
                        <option value="What was your first job?">What was your first job?</option>
                        <option value="What is your favorite food?">What is your favorite food?</option>
                        <option value="What is the name of your favorite teacher?">What is the name of your favorite teacher?</option>
                        <option value="What is your favorite book?">What is your favorite book?</option>
                        <option value="What is your favorite sport?">What is your favorite sport?</option>
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="ans_2" placeholder="Answer 2" maxlength="100" required>
                    <span class="glyphicon glyphicon-question-sign form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <label>Security Question 3:</label>
                    <select class="form-control" name="sec_3" required>
                        <option value="">Select a question</option>
                        <option value="What is your favorite holiday destination?">What is your favorite holiday destination?</option>
                        <option value="What is your favorite season?">What is your favorite season?</option>
                        <option value="What is your favorite hobby?">What is your favorite hobby?</option>
                        <option value="What is your favorite music genre?">What is your favorite music genre?</option>
                        <option value="What is your favorite animal?">What is your favorite animal?</option>
                        <option value="What is your favorite drink?">What is your favorite drink?</option>
                        <option value="What is your favorite game?">What is your favorite game?</option>
                        <option value="What is your favorite place to visit?">What is your favorite place to visit?</option>
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="ans_3" placeholder="Answer 3" maxlength="100" required>
                    <span class="glyphicon glyphicon-question-sign form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <a href="forgot_password.php" class="btn btn-default btn-block btn-flat">Cancel</a>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="setup_questions">
                            <i class="fa fa-save"></i> Setup Questions
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
