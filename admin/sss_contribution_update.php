<?php
include 'includes/session.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $min_compensation = $_POST['min_compensation'];
    $max_compensation = $_POST['max_compensation'];
    $regular_ss_employer = $_POST['regular_ss_employer'];
    $mpf_employer = $_POST['mpf_employer'];
    $ec_employer = $_POST['ec_employer'];
    $regular_ss_employee = $_POST['regular_ss_employee'];
    $mpf_employee = $_POST['mpf_employee'];
    $active = $_POST['active'];
    
    // Validate input
    if(!is_numeric($min_compensation) || !is_numeric($max_compensation) || 
       !is_numeric($regular_ss_employer) || !is_numeric($mpf_employer) || 
       !is_numeric($ec_employer) || !is_numeric($regular_ss_employee) || 
       !is_numeric($mpf_employee)){
        echo json_encode(array('success' => false, 'message' => 'Invalid input data'));
        exit;
    }
    
    // Update the record
    $sql = "UPDATE sss_contribution_schedule SET 
            min_compensation = ?, 
            max_compensation = ?, 
            regular_ss_employer = ?, 
            mpf_employer = ?, 
            ec_employer = ?, 
            regular_ss_employee = ?, 
            mpf_employee = ?, 
            active = ?,
            updated_on = CURRENT_TIMESTAMP
            WHERE id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dddddddsi", 
        $min_compensation, 
        $max_compensation, 
        $regular_ss_employer, 
        $mpf_employer, 
        $ec_employer, 
        $regular_ss_employee, 
        $mpf_employee, 
        $active, 
        $id
    );
    
    if($stmt->execute()){
        // Log the update
        $admin_name = $_SESSION['name'] ?? 'Unknown';
        $log_sql = "INSERT INTO audit_logs (date_and_time, user, description) VALUES (NOW(), ?, ?)";
        $log_stmt = $conn->prepare($log_sql);
        $description = "SSS contribution schedule updated by: $admin_name. ID: $id";
        $log_stmt->bind_param("ss", $admin_name, $description);
        $log_stmt->execute();
        $log_stmt->close();
        
        echo json_encode(array('success' => true, 'message' => 'SSS contribution updated successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error updating record: ' . $stmt->error));
    }
    
    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}

$conn->close();
?>
