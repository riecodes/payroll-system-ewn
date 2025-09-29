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

// Get user's security questions
$sql = "SELECT sec_1, sec_2, sec_3 FROM admin WHERE username = '$username' AND activation = 'Active'";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sec_1 = $row['sec_1'];
    $sec_2 = $row['sec_2'];
    $sec_3 = $row['sec_3'];
} else {
    $_SESSION['error'] = 'User not found.';
    header('Location: forgot_password.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Answer Security Questions | EWN Payroll System</title>
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
            <b>Security Questions</b>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Answer your security questions for <strong><?php echo htmlspecialchars($username); ?></strong></p>
            
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

            <form action="security_question_verification_process.php" method="POST">
                <div class="form-group">
                    <label><?php echo htmlspecialchars($sec_1); ?></label>
                    <input type="text" class="form-control" name="ans_1" placeholder="Your answer" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label><?php echo htmlspecialchars($sec_2); ?></label>
                    <input type="text" class="form-control" name="ans_2" placeholder="Your answer" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label><?php echo htmlspecialchars($sec_3); ?></label>
                    <input type="text" class="form-control" name="ans_3" placeholder="Your answer" maxlength="100" required>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <a href="forgot_password.php" class="btn btn-default btn-block btn-flat">Cancel</a>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="verify_answers">
                            <i class="fa fa-check"></i> Verify Answers
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
