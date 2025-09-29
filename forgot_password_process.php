<?php
session_start();
include 'login/conn.php';

if(isset($_POST['check_username'])){
    $username = $_POST['username'];
    
    // Sanitize username to prevent SQL injection
    $username = $conn->real_escape_string($username);
    
    // Check if username exists
    $sql = "SELECT * FROM admin WHERE username = '$username' AND activation = 'Active'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check if user has security questions set up
        $has_security_questions = false;
        if(!empty($row['sec_1']) && !empty($row['ans_1'])) {
            $has_security_questions = true;
        }
        
        // Store username in session for next steps
        $_SESSION['reset_username'] = $username;
        $_SESSION['reset_user_id'] = $row['id'];
        
        if($has_security_questions) {
            // User has security questions, redirect to answer them
            header('Location: security_question_verification.php');
        } else {
            // User doesn't have security questions, redirect to setup
            header('Location: setup_security_questions.php');
        }
        exit();
    } else {
        $_SESSION['error'] = 'Username not found or account is inactive';
    }
} else {
    $_SESSION['error'] = 'Please enter a username';
}

header('Location: forgot_password.php');
exit();
?>
