<?php
session_start();
include 'login/conn.php';

if(isset($_POST['setup_questions'])){
    // Check if reset_username is set
    if(!isset($_SESSION['reset_username'])){
        $_SESSION['error'] = 'Session expired. Please try again.';
        header('Location: forgot_password.php');
        exit();
    }
    
    $username = $_SESSION['reset_username'];
    $sec_1 = $_POST['sec_1'];
    $ans_1 = $_POST['ans_1'];
    $sec_2 = $_POST['sec_2'];
    $ans_2 = $_POST['ans_2'];
    $sec_3 = $_POST['sec_3'];
    $ans_3 = $_POST['ans_3'];
    
    // Sanitize inputs
    $sec_1 = $conn->real_escape_string($sec_1);
    $ans_1 = $conn->real_escape_string($ans_1);
    $sec_2 = $conn->real_escape_string($sec_2);
    $ans_2 = $conn->real_escape_string($ans_2);
    $sec_3 = $conn->real_escape_string($sec_3);
    $ans_3 = $conn->real_escape_string($ans_3);
    
    // Validate that all questions and answers are provided
    if(empty($sec_1) || empty($ans_1) || empty($sec_2) || empty($ans_2) || empty($sec_3) || empty($ans_3)) {
        $_SESSION['error'] = 'All security questions and answers are required.';
        header('Location: setup_security_questions.php');
        exit();
    }
    
    // Update security questions in database
    $sql = "UPDATE admin SET sec_1 = '$sec_1', ans_1 = '$ans_1', sec_2 = '$sec_2', ans_2 = '$ans_2', sec_3 = '$sec_3', ans_3 = '$ans_3' WHERE username = '$username'";
    
    if($conn->query($sql)) {
        $_SESSION['success'] = 'Security questions have been set up successfully. You can now answer them to reset your password.';
        header('Location: security_question_verification.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error setting up security questions. Please try again.';
        header('Location: setup_security_questions.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
    header('Location: forgot_password.php');
    exit();
}
?>
