<?php
include 'includes/session.php';

if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    
    // Query to fetch cash advance data within the specified date range
    $sql = "SELECT *, CONCAT(firstname,' ',lastname) AS name, 
            cashadvance.id AS caid, 
            employees.employee_id AS empid,
            CAST(amount AS DECIMAL) - CAST(balance AS DECIMAL) AS paid
            FROM cashadvance 
            LEFT JOIN employees ON employees.employee_id=cashadvance.employee_id
            WHERE employees.archive = 'no' 
            AND DATE(cashadvance.date_advance) >= '$dateFrom' 
            AND DATE(cashadvance.date_advance) <= '$dateTo'";
    
    $result = $conn->query($sql);
    
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        $payrollData = array();
        while ($row = $result->fetch_assoc()) {
            // Add fetched rows to the array
            $payrollData[] = $row;
        }
        // Return the fetched data as JSON
        echo json_encode($payrollData);
    } else {
        // No data found within the specified date range
        echo json_encode(array());
    }
} else {
    // Invalid request, dateFrom and dateTo parameters not set
    echo json_encode(array('error' => 'Invalid request'));
}

?>
