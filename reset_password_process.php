<?php
session_start();
include 'login/conn.php';

if(isset($_POST['reset_password'])){
    // Check if reset_username and security_verified are set
    if(!isset($_SESSION['reset_username']) || !isset($_SESSION['security_verified'])){
        $_SESSION['error'] = 'Session expired. Please try again.';
        header('Location: forgot_password.php');
        exit();
    }
    
    $username = $_SESSION['reset_username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords
    if($new_password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: reset_password.php');
        exit();
    }
    
    if(strlen($new_password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters long.';
        header('Location: reset_password.php');
        exit();
    }
    
    // Sanitize password
    $new_password = $conn->real_escape_string($new_password);
    
    // Update password in database
    $sql = "UPDATE admin SET password = '$new_password' WHERE username = '$username'";
    
    if($conn->query($sql)) {
        // Clear all reset-related session variables
        unset($_SESSION['reset_username']);
        unset($_SESSION['reset_user_id']);
        unset($_SESSION['security_verified']);
        
        $_SESSION['success'] = 'Password has been reset successfully. You can now login with your new password.';
        header('Location: login/index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error resetting password. Please try again.';
        header('Location: reset_password.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
    header('Location: forgot_password.php');
    exit();
}
?>
