<?php
include 'includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $sql = "SELECT * FROM sss_contribution_schedule WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        
        $response = array(
            'id' => $row['id'],
            'min_compensation' => $row['min_compensation'],
            'max_compensation' => $row['max_compensation'],
            'regular_ss_employer' => $row['regular_ss_employer'],
            'mpf_employer' => $row['mpf_employer'],
            'ec_employer' => $row['ec_employer'],
            'regular_ss_employee' => $row['regular_ss_employee'],
            'mpf_employee' => $row['mpf_employee'],
            'active' => $row['active']
        );
        
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Record not found'));
    }
    
    $stmt->close();
} else {
    echo json_encode(array('error' => 'No ID provided'));
}

$conn->close();
?>
