<?php
// Aggregates government contributions from posted payroll for printing
// Inputs (POST): contribution (sss|philhealth|pagibig|income tax), dateFrom, dateTo, optional name
// Output: JSON array of rows per employee with fields depending on contribution type

include 'includes/session.php';

header('Content-Type: application/json');

function respond_error($message){
  echo json_encode([]);
  exit;
}

$contribution = isset($_POST['contribution']) ? strtolower(trim($_POST['contribution'])) : '';
$dateFrom = isset($_POST['dateFrom']) ? $_POST['dateFrom'] : '';
$dateTo = isset($_POST['dateTo']) ? $_POST['dateTo'] : '';
$nameFilter = isset($_POST['name']) ? trim($_POST['name']) : '';

if(!$contribution || !$dateFrom || !$dateTo){
  respond_error('Missing required parameters');
}

// Validate date format (YYYY-MM-DD)
if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)){
  respond_error('Invalid date format');
}

// Build base WHERE clause
$where = "pe.created_on BETWEEN ? AND ? AND pe.status = 1";
$params = [$dateFrom, $dateTo];
$types = 'ss';

// Optional name filter (case-insensitive contains)
if($nameFilter !== ''){
  $where .= " AND CONCAT(e.firstname,' ',e.lastname) LIKE ?";
  $params[] = '%'.$nameFilter.'%';
  $types .= 's';
}

$rows = [];

if($contribution === 'philhealth' || $contribution === 'pagibig' || $contribution === 'income tax' || $contribution === 'income_tax'){
  // Use aggregation directly from payroll_employee
  $selectFields = '';
  if($contribution === 'philhealth'){
    $selectFields = 'SUM(CAST(pe.philhealth AS DECIMAL(12,2))) AS emp_total, SUM(CAST(pe.philhealth_employeer AS DECIMAL(12,2))) AS er_total';
  } else if($contribution === 'pagibig'){
    $selectFields = 'SUM(CAST(pe.pagibig AS DECIMAL(12,2))) AS emp_total, SUM(CAST(pe.pagibig_employeer AS DECIMAL(12,2))) AS er_total';
  } else { // income tax
    $selectFields = 'SUM(CAST(pe.tin AS DECIMAL(12,2))) AS emp_total, 0 AS er_total';
  }

  $sql = "SELECT pe.employee_id, e.firstname, e.lastname, $selectFields
          FROM payroll_employee pe
          LEFT JOIN employees e ON e.employee_id = pe.employee_id
          WHERE $where
          GROUP BY pe.employee_id, e.firstname, e.lastname
          ORDER BY e.lastname ASC, e.firstname ASC";

  $stmt = $conn->prepare($sql);
  if(!$stmt){ respond_error('Query prepare failed'); }
  $stmt->bind_param($types, ...$params);
  if($stmt->execute()){
    $result = $stmt->get_result();
    while($r = $result->fetch_assoc()){
      $employeeId = $r['employee_id'];
      $name = trim(($r['firstname'] ?? '').' '.($r['lastname'] ?? ''));
      $emp = round((float)$r['emp_total'], 2);
      $er = round((float)$r['er_total'], 2);
      $total = round($emp + $er, 2);

      if($contribution === 'philhealth'){
        $rows[] = [
          'employee_id' => $employeeId,
          'name' => $name,
          'philhealth' => (float)$emp,
          'philhealth_employeer' => (float)$er,
          'total' => (float)$total,
        ];
      } else if($contribution === 'pagibig'){
        $rows[] = [
          'employee_id' => $employeeId,
          'name' => $name,
          'pagibig' => (float)$emp,
          'pagibig_employeer' => (float)$er,
          'total' => (float)$total,
        ];
      } else { // income tax (employee only)
        $rows[] = [
          'employee_id' => $employeeId,
          'name' => $name,
          'tin' => (float)$emp,
          'total' => (float)$emp,
        ];
      }
    }
  }
  $stmt->close();
}
else if($contribution === 'sss'){
  // For SSS: employee side from payroll_employee.sss; employer side recomputed per schedule bracket

  // Prefetch schedule into a map: employee_total => employer_total
  $mapEmpToEr = [];
  $schedSql = "SELECT (regular_ss_employee + mpf_employee) AS emp_total, (regular_ss_employer + mpf_employer + ec_employer) AS er_total FROM sss_contribution_schedule WHERE active='yes'";
  $schedRes = $conn->query($schedSql);
  if($schedRes){
    while($s = $schedRes->fetch_assoc()){
      $empKey = number_format((float)$s['emp_total'], 2, '.', '');
      $mapEmpToEr[$empKey] = round((float)$s['er_total'], 2);
    }
  }

  // Fetch per-row SSS values to map to employer via schedule, then aggregate per employee
  $sql = "SELECT pe.employee_id, e.firstname, e.lastname, CAST(pe.sss AS DECIMAL(12,2)) AS sss_emp
          FROM payroll_employee pe
          LEFT JOIN employees e ON e.employee_id = pe.employee_id
          WHERE $where
          ORDER BY e.lastname ASC, e.firstname ASC";

  $stmt = $conn->prepare($sql);
  if(!$stmt){ respond_error('Query prepare failed'); }
  $stmt->bind_param($types, ...$params);

  $perEmployee = [];
  if($stmt->execute()){
    $result = $stmt->get_result();
    while($r = $result->fetch_assoc()){
      $employeeId = $r['employee_id'];
      $name = trim(($r['firstname'] ?? '').' '.($r['lastname'] ?? ''));
      $empAmt = round((float)$r['sss_emp'], 2);
      if($empAmt <= 0){
        // still register employee for name if not present
        if(!isset($perEmployee[$employeeId])){
          $perEmployee[$employeeId] = ['name' => $name, 'emp' => 0.00, 'er' => 0.00];
        }
        continue;
      }
      $empKey = number_format($empAmt, 2, '.', '');
      $erAmt = isset($mapEmpToEr[$empKey]) ? $mapEmpToEr[$empKey] : 0.00;

      if(!isset($perEmployee[$employeeId])){
        $perEmployee[$employeeId] = ['name' => $name, 'emp' => 0.00, 'er' => 0.00];
      }
      $perEmployee[$employeeId]['emp'] += $empAmt;
      $perEmployee[$employeeId]['er'] += $erAmt;
    }
  }
  $stmt->close();

  // Build rows array
  foreach($perEmployee as $empId => $v){
    $empSum = round($v['emp'], 2);
    $erSum = round($v['er'], 2);
    $rows[] = [
      'employee_id' => $empId,
      'name' => $v['name'],
      'sss' => (float)$empSum,
      'sss_employeer' => (float)$erSum,
      'total' => (float)($empSum + $erSum),
    ];
  }
}
else{
  respond_error('Invalid contribution type');
}

echo json_encode($rows);
exit;
