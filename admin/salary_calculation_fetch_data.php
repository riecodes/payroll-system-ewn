<?php
include 'includes/session.php';

if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    
    // Query to fetch financial data within the specified date range
    $sql = "SELECT *,
    COUNT(*) AS numOfrows,
    COUNT(DISTINCT efl.employee_id) AS crews,
    SUM(efl.meal_allowance) AS meal_allowance,
    SUM(efl.adjustments) AS adjustments,
    SUM(efl.transportation) AS transportation,
    location.doc AS doc,
    efl.incentives_value AS incentives_value,
    efl.date AS date,
    location.province,
    location.municipality
    FROM employee_financial_list AS efl
    LEFT JOIN location ON efl.location_id = location.id
    LEFT JOIN employees ON employees.employee_id = efl.employee_id
    WHERE DATE(efl.date) >= '$dateFrom' AND DATE(efl.date) <= '$dateTo' AND employees.archive = 'no'
    GROUP BY efl.date, efl.location_id
    ORDER BY efl.date DESC";
    
    $result = $conn->query($sql);
    
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        $financialData = array();
        while ($row = $result->fetch_assoc()) {
            // Calculate values for each row
            $doc = number_format((float)$row['doc'], 2);
            $incentivesRate = number_format((float)$row['incentives_value'], 2);
            $incentivesValue = $row['crews'] != 0 ? number_format((float)$row['incentives_value'] / $row['crews'], 2) : "N/A";
            $adjustments = number_format((float)$row['adjustments'], 2);
            $mealAllowance = number_format((float)$row['meal_allowance'], 2);
            $transportation = number_format((float)$row['transportation'], 2);
            $crews = $row['crews'];
            $totalCost = number_format(((float)$row['meal_allowance'] + (float)$row['incentives_value']), 2);
            
            // Add calculated values to the row
            $row['formatted_doc'] = $doc;
            $row['formatted_incentives_rate'] = $incentivesRate;
            $row['formatted_incentives_value'] = $incentivesValue;
            $row['formatted_adjustments'] = $adjustments;
            $row['formatted_meal_allowance'] = $mealAllowance;
            $row['formatted_transportation'] = $transportation;
            $row['formatted_crews'] = $crews;
            $row['formatted_total_cost'] = $totalCost;
            
            // Add fetched rows to the array
            $financialData[] = $row;
        }
        // Return the fetched data as JSON
        echo json_encode($financialData);
    } else {
        // No data found within the specified date range
        echo json_encode(array());
    }
} else {
    // Invalid request, dateFrom and dateTo parameters not set
    echo json_encode(array('error' => 'Invalid request'));
}
?>
