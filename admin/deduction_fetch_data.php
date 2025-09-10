<?php
include 'includes/conn.php';

header('Content-Type: application/json');

function respond_error($message){
  echo json_encode(['error' => $message]);
  exit;
}

$contribution = isset($_POST['contribution']) ? strtolower(trim($_POST['contribution'])) : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';
$nameFilter = isset($_POST['name']) ? trim($_POST['name']) : '';

if(!$contribution || !$month){
  respond_error('Missing required parameters');
}

// Validate month format (YYYY-MM)
if(!preg_match('/^\\d{4}-\\d{2}$/', $month)){
  respond_error('Invalid month format');
}

// Convert month (YYYY-MM) to date range format that matches database
$year = date('Y', strtotime($month));
$month_num = date('m', strtotime($month));

// Get first and last day of the month
$firstDay = $year . '-' . $month_num . '-01';
$lastDay = date('Y-m-t', strtotime($firstDay));

// Build date range patterns that could exist in the database for this month
$dateRangePatterns = [
    "[$firstDay] - [$lastDay]",  // Full month range
    "[$firstDay] - [" . date('Y-m-15', strtotime($firstDay)) . "]",  // First half
    "[" . date('Y-m-16', strtotime($firstDay)) . "] - [$lastDay]"   // Second half
];

// Build WHERE clause to match any of these patterns
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

// Optional name filter (case-insensitive contains)
if(!empty($nameFilter)) {
  $where .= " AND CONCAT(e.firstname, ' ', e.lastname) LIKE ?";
  $params[] = '%' . $nameFilter . '%';
  $types .= 's';
}

$sql = "
  SELECT 
    pe.employee_id,
    CONCAT(e.firstname, ' ', e.lastname) as name,
    SUM(pe.sss) as sss,
    SUM(pe.sss_employeer) as sss_employeer,
    SUM(pe.pagibig) as pagibig,
    SUM(pe.pagibig_employeer) as pagibig_employeer,
    SUM(pe.philhealth) as philhealth,
    SUM(pe.philhealth_employeer) as philhealth_employeer,
    SUM(pe.tin) as tin
  FROM payroll_employee pe
  JOIN employees e ON e.employee_id = pe.employee_id
  {$where}
  GROUP BY pe.employee_id, name
  ORDER BY pe.employee_id
";

$stmt = $conn->prepare($sql);
if(!$stmt){
  respond_error('SQL prepare failed: ' . $conn->error);
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while($row = $result->fetch_assoc()){
  $employee_data = [
    'employee_id' => $row['employee_id'],
    'name' => $row['name'],
    'sss' => (float)$row['sss'],
    'sss_employeer' => (float)$row['sss_employeer'],
    'pagibig' => (float)$row['pagibig'],
    'pagibig_employeer' => (float)$row['pagibig_employeer'],
    'philhealth' => (float)$row['philhealth'],
    'philhealth_employeer' => (float)$row['philhealth_employeer'],
    'tin' => (float)$row['tin'],
    'total' => 0,
  ];
  
  // Calculate total based on contribution type
  switch($contribution) {
    case 'sss':
      $employee_data['total'] = $employee_data['sss'] + $employee_data['sss_employeer'];
      break;
    case 'pagibig':
      $employee_data['total'] = $employee_data['pagibig'] + $employee_data['pagibig_employeer'];
      break;
    case 'philhealth':
      $employee_data['total'] = $employee_data['philhealth'] + $employee_data['philhealth_employeer'];
      break;
    case 'income tax':
      $employee_data['total'] = $employee_data['tin'];
      break;
  }

  // Only include employees who have contributions (employee contribution > 0)
  $hasContribution = false;
  switch($contribution) {
    case 'sss':
      $hasContribution = $employee_data['sss'] > 0;
      break;
    case 'pagibig':
      $hasContribution = $employee_data['pagibig'] > 0;
      break;
    case 'philhealth':
      $hasContribution = $employee_data['philhealth'] > 0;
      break;
    case 'income tax':
      $hasContribution = $employee_data['tin'] > 0;
      break;
  }

  if($hasContribution) {
    $data[] = $employee_data;
  }
}

$stmt->close();
$conn->close();

echo json_encode($data);
