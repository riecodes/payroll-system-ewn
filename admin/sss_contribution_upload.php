<?php
include 'includes/session.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if file was uploaded
if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'success' => false,
        'message' => 'No file uploaded or upload error occurred.',
        'errors' => ['Please select a valid CSV file.']
    ]);
    exit;
}

$file = $_FILES['csv_file'];
$backup_existing = isset($_POST['backup_existing']) ? (bool)$_POST['backup_existing'] : true;
$validate_only = isset($_POST['validate_only']) ? (bool)$_POST['validate_only'] : false;

// Validate file type
$file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($file_extension !== 'csv') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid file type. Please upload a CSV file.',
        'errors' => ['Only CSV files are allowed.']
    ]);
    exit;
}

// Validate file size (5MB limit)
if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode([
        'success' => false,
        'message' => 'File too large. Maximum size is 5MB.',
        'errors' => ['File size exceeds 5MB limit.']
    ]);
    exit;
}

try {
    // Read CSV file
    $csv_data = [];
    $handle = fopen($file['tmp_name'], 'r');
    
    if ($handle === false) {
        throw new Exception('Could not read CSV file.');
    }
    
    $row_number = 0;
    $errors = [];
    $stats = [
        'total_rows' => 0,
        'updated' => 0,
        'added' => 0,
        'errors' => 0
    ];
    
    // Skip header row
    $header = fgetcsv($handle);
    if (!$header) {
        throw new Exception('CSV file appears to be empty.');
    }
    
    // Validate header format
    $expected_headers = [
        'Range of Compensation',
        'Employer Regular SS',
        'Employer MPF', 
        'Employer EC',
        'Employee Regular SS',
        'Employee MPF'
    ];
    
    if (count($header) < 6) {
        throw new Exception('CSV format is incorrect. Expected 6 columns: Range of Compensation, Employer Regular SS, Employer MPF, Employer EC, Employee Regular SS, Employee MPF');
    }
    
    // Create backup if requested
    if ($backup_existing && !$validate_only) {
        createBackup();
    }
    
    // Process each row
    while (($row = fgetcsv($handle)) !== false) {
        $row_number++;
        $stats['total_rows']++;
        
        // Skip empty rows
        if (empty(array_filter($row))) {
            continue;
        }
        
        // Validate row data
        $validation_result = validateCSVRow($row, $row_number);
        if (!$validation_result['valid']) {
            $errors[] = "Row $row_number: " . $validation_result['error'];
            $stats['errors']++;
            continue;
        }
        
        $csv_data[] = $validation_result['data'];
    }
    
    fclose($handle);
    
    // If validation only, return results without updating database
    if ($validate_only) {
        echo json_encode([
            'success' => true,
            'message' => "Validation complete. Found {$stats['total_rows']} valid rows.",
            'stats' => $stats,
            'errors' => $errors
        ]);
        exit;
    }
    
    // Update database
    $update_result = updateSSSContributions($csv_data, $stats, $errors);
    
    // Log the upload
    $admin_name = $_SESSION['name'] ?? 'Unknown';
    $log_sql = "INSERT INTO audit_logs (date_and_time, user, description) VALUES (NOW(), ?, ?)";
    $log_stmt = $conn->prepare($log_sql);
    $description = "SSS contribution CSV uploaded by: $admin_name. Rows processed: {$stats['total_rows']}";
    $log_stmt->bind_param("ss", $admin_name, $description);
    $log_stmt->execute();
    $log_stmt->close();
    
    echo json_encode($update_result);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error processing CSV: ' . $e->getMessage(),
        'errors' => [$e->getMessage()]
    ]);
}

// Function to validate CSV row
function validateCSVRow($row, $row_number) {
    if (count($row) < 6) {
        return [
            'valid' => false,
            'error' => 'Insufficient columns. Expected 6 columns.'
        ];
    }
    
    $range = trim($row[0]);
    $regular_ss_employer = trim($row[1]);
    $mpf_employer = trim($row[2]);
    $ec_employer = trim($row[3]);
    $regular_ss_employee = trim($row[4]);
    $mpf_employee = trim($row[5]);
    
    // Parse compensation range
    $range_data = parseCompensationRange($range);
    if (!$range_data) {
        return [
            'valid' => false,
            'error' => "Invalid compensation range format: '$range'. Expected format: '0-5249.99' or 'BELOW 5249.99'"
        ];
    }
    
    // Validate numeric values
    $numeric_fields = [
        'regular_ss_employer' => $regular_ss_employer,
        'mpf_employer' => $mpf_employer,
        'ec_employer' => $ec_employer,
        'regular_ss_employee' => $regular_ss_employee,
        'mpf_employee' => $mpf_employee
    ];
    
    foreach ($numeric_fields as $field => $value) {
        if (!is_numeric($value) || $value < 0) {
            return [
                'valid' => false,
                'error' => "Invalid value for $field: '$value'. Must be a positive number."
            ];
        }
    }
    
    return [
        'valid' => true,
        'data' => [
            'min_compensation' => $range_data['min'],
            'max_compensation' => $range_data['max'],
            'regular_ss_employer' => (float)$regular_ss_employer,
            'mpf_employer' => (float)$mpf_employer,
            'ec_employer' => (float)$ec_employer,
            'regular_ss_employee' => (float)$regular_ss_employee,
            'mpf_employee' => (float)$mpf_employee
        ]
    ];
}

// Function to parse compensation range
function parseCompensationRange($range) {
    $range = trim($range);
    
    // Handle "BELOW X" format
    if (preg_match('/^BELOW\s+([0-9,]+\.?[0-9]*)$/i', $range, $matches)) {
        $max = (float)str_replace(',', '', $matches[1]);
        return ['min' => 0, 'max' => $max];
    }
    
    // Handle "X-Y" format
    if (preg_match('/^([0-9,]+\.?[0-9]*)\s*-\s*([0-9,]+\.?[0-9]*)$/', $range, $matches)) {
        $min = (float)str_replace(',', '', $matches[1]);
        $max = (float)str_replace(',', '', $matches[2]);
        return ['min' => $min, 'max' => $max];
    }
    
    return false;
}

// Function to update SSS contributions
function updateSSSContributions($csv_data, &$stats, &$errors) {
    global $conn;
    
    $conn->autocommit(false);
    
    try {
        foreach ($csv_data as $data) {
            // Check if record exists
            $check_sql = "SELECT id FROM sss_contribution_schedule WHERE min_compensation = ? AND max_compensation = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("dd", $data['min_compensation'], $data['max_compensation']);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update existing record
                $row = $result->fetch_assoc();
                $id = $row['id'];
                
                $update_sql = "UPDATE sss_contribution_schedule SET 
                    regular_ss_employer = ?, 
                    mpf_employer = ?, 
                    ec_employer = ?, 
                    regular_ss_employee = ?, 
                    mpf_employee = ?,
                    updated_on = CURRENT_TIMESTAMP
                    WHERE id = ?";
                
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("dddddi", 
                    $data['regular_ss_employer'],
                    $data['mpf_employer'],
                    $data['ec_employer'],
                    $data['regular_ss_employee'],
                    $data['mpf_employee'],
                    $id
                );
                
                if ($update_stmt->execute()) {
                    $stats['updated']++;
                } else {
                    $errors[] = "Failed to update record for range {$data['min_compensation']}-{$data['max_compensation']}";
                    $stats['errors']++;
                }
                $update_stmt->close();
            } else {
                // Insert new record
                $insert_sql = "INSERT INTO sss_contribution_schedule 
                    (min_compensation, max_compensation, regular_ss_employer, mpf_employer, ec_employer, regular_ss_employee, mpf_employee, active) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'yes')";
                
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ddddddd", 
                    $data['min_compensation'],
                    $data['max_compensation'],
                    $data['regular_ss_employer'],
                    $data['mpf_employer'],
                    $data['ec_employer'],
                    $data['regular_ss_employee'],
                    $data['mpf_employee']
                );
                
                if ($insert_stmt->execute()) {
                    $stats['added']++;
                } else {
                    $errors[] = "Failed to insert record for range {$data['min_compensation']}-{$data['max_compensation']}";
                    $stats['errors']++;
                }
                $insert_stmt->close();
            }
            $check_stmt->close();
        }
        
        $conn->commit();
        
        $message = "CSV upload completed successfully. ";
        $message .= "Updated: {$stats['updated']}, Added: {$stats['added']}";
        if ($stats['errors'] > 0) {
            $message .= ", Errors: {$stats['errors']}";
        }
        
        return [
            'success' => true,
            'message' => $message,
            'stats' => $stats,
            'errors' => $errors
        ];
        
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    } finally {
        $conn->autocommit(true);
    }
}

// Function to create backup
function createBackup() {
    global $conn;
    
    $backup_sql = "CREATE TABLE sss_contribution_schedule_backup_" . date('Y_m_d_H_i_s') . " AS SELECT * FROM sss_contribution_schedule";
    $conn->query($backup_sql);
}

$conn->close();
?>
