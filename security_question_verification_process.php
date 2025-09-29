<?php
session_start();
include 'login/conn.php';

if(isset($_POST['verify_answers'])){
    // Check if reset_username is set
    if(!isset($_SESSION['reset_username'])){
        $_SESSION['error'] = 'Session expired. Please try again.';
        header('Location: forgot_password.php');
        exit();
    }
    
    $username = $_SESSION['reset_username'];
    $ans_1 = $_POST['ans_1'];
    $ans_2 = $_POST['ans_2'];
    $ans_3 = $_POST['ans_3'];
    
    // Sanitize inputs
    $ans_1 = $conn->real_escape_string($ans_1);
    $ans_2 = $conn->real_escape_string($ans_2);
    $ans_3 = $conn->real_escape_string($ans_3);
    
    // Get user's stored answers
    $sql = "SELECT ans_1, ans_2, ans_3 FROM admin WHERE username = '$username' AND activation = 'Active'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_ans_1 = $row['ans_1'];
        $stored_ans_2 = $row['ans_2'];
        $stored_ans_3 = $row['ans_3'];
        
        // Check if answers match (case-insensitive)
        if(strtolower(trim($ans_1)) == strtolower(trim($stored_ans_1)) && 
           strtolower(trim($ans_2)) == strtolower(trim($stored_ans_2)) && 
           strtolower(trim($ans_3)) == strtolower(trim($stored_ans_3))) {
            
            // Answers are correct, redirect to password reset
            $_SESSION['security_verified'] = true;
            header('Location: reset_password.php');
            exit();
        } else {
            $_SESSION['error'] = 'One or more answers are incorrect. Please try again.';
            header('Location: security_question_verification.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'User not found.';
        header('Location: forgot_password.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
    header('Location: forgot_password.php');
    exit();
}
?>
