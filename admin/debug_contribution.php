<?php
include 'includes/conn.php';

// Debug script to test the contribution report query
$month = '2025-08'; // Test with August 2025

echo "<h2>Debug Contribution Report</h2>";
echo "<p>Testing month: $month</p>";

// Convert month (YYYY-MM) to date range format that matches database
$year = date('Y', strtotime($month));
$month_num = date('m', strtotime($month));

// Get first and last day of the month
$firstDay = $year . '-' . $month_num . '-01';
$lastDay = date('Y-m-t', strtotime($firstDay));

echo "<p>First day: $firstDay</p>";
echo "<p>Last day: $lastDay</p>";

// Build date range patterns that could exist in the database for this month
$dateRangePatterns = [
    "[$firstDay] - [$lastDay]",  // Full month range
    "[$firstDay] - [" . date('Y-m-15', strtotime($firstDay)) . "]",  // First half
    "[" . date('Y-m-16', strtotime($firstDay)) . "] - [$lastDay]"   // Second half
];

echo "<h3>Date Range Patterns:</h3>";
foreach($dateRangePatterns as $i => $pattern) {
    echo "<p>Pattern " . ($i+1) . ": '$pattern'</p>";
}

// Test the exact query
$where = "WHERE (";
$whereConditions = [];
$params = [];
$types = '';

foreach($dateRangePatterns as $pattern) {
    $whereConditions[] = "pe.date_range = ?";
    $params[] = $pattern;
    $types .= 's';
}

$where .= implode(' OR ', $whereConditions);
$where .= ") AND pe.status = 1";

echo "<h3>SQL Query:</h3>";
$sql = "
  SELECT 
    pe.employee_id,
    CONCAT(e.firstname, ' ', e.lastname) as name,
    pe.date_range,
    pe.sss,
    pe.sss_employeer,
    pe.pagibig,
    pe.pagibig_employeer,
    pe.philhealth,
    pe.philhealth_employeer,
    pe.tin
  FROM payroll_employee pe
  JOIN employees e ON e.employee_id = pe.employee_id
  {$where}
  ORDER BY pe.employee_id
";

echo "<pre>" . htmlspecialchars($sql) . "</pre>";

echo "<h3>Parameters:</h3>";
echo "<pre>";
print_r($params);
echo "</pre>";

// Execute the query
$stmt = $conn->prepare($sql);
if(!$stmt){
    echo "<p style='color:red'>SQL prepare failed: " . $conn->error . "</p>";
} else {
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<h3>Results:</h3>";
    if($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Employee ID</th><th>Name</th><th>Date Range</th><th>SSS</th><th>SSS Employer</th><th>Pag-IBIG</th><th>Pag-IBIG Employer</th><th>PhilHealth</th><th>PhilHealth Employer</th><th>TIN</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['employee_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['date_range'] . "</td>";
            echo "<td>" . $row['sss'] . "</td>";
            echo "<td>" . $row['sss_employeer'] . "</td>";
            echo "<td>" . $row['pagibig'] . "</td>";
            echo "<td>" . $row['pagibig_employeer'] . "</td>";
            echo "<td>" . $row['philhealth'] . "</td>";
            echo "<td>" . $row['philhealth_employeer'] . "</td>";
            echo "<td>" . $row['tin'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red'>No results found!</p>";
    }
}

// Also test a simple query to see all payroll_employee data
echo "<h3>All Payroll Employee Data:</h3>";
$simple_sql = "SELECT employee_id, date_range, sss, sss_employeer, status FROM payroll_employee";
$simple_result = $conn->query($simple_sql);

if($simple_result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Employee ID</th><th>Date Range</th><th>SSS</th><th>SSS Employer</th><th>Status</th></tr>";
    while($row = $simple_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['employee_id'] . "</td>";
        echo "<td>" . $row['date_range'] . "</td>";
        echo "<td>" . $row['sss'] . "</td>";
        echo "<td>" . $row['sss_employeer'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red'>No payroll data found!</p>";
}
?>
