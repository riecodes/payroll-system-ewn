<?php
	include 'includes/session.php';

    // Fetch deduction rates once
    $deductions_sql = "SELECT description, employee_contribution, employeer_contribution FROM deductions";
    $deductions_query = $conn->query($deductions_sql);
    $deduction_rates = [];
    while($row = $deductions_query->fetch_assoc()){
        $desc = strtolower(trim($row['description']));
        $deduction_rates[$desc] = $row;
    }

	if(isset($_POST['addPayroll'])){

        $dateFrom="";
        $dateTo="";
        $cutOff =  $_POST['cut-off'];
        $month =  $_POST['month'];
        $year =  $_POST['year'];

        //First cutoff
        if($cutOff==1){
            $dateFrom = "$year-$month-01";
            $dateTo = "$year-$month-15";
        }else if($cutOff==2){
            //2nd cutoff
            if ($month == 2) {
                $dateFrom = "$year-$month-16";
                $dateTo = "$year-$month-28";
            } else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
                $dateFrom = "$year-$month-16";
                $dateTo = "$year-$month-30";
            } else if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
                $dateFrom = "$year-$month-16";
                $dateTo = "$year-$month-31";
            }
        }

        $dateRange = '['.$dateFrom.'] - ['.$dateTo.']';
        // $_SESSION['success'] = 'Date range:'.$dateRange;

        //GET THE HIGHEST COUNT
        $checkDays_sql = "SELECT COUNT(DISTINCT ass_schedule) AS maxDaysOfWork 
              FROM ass_sched_fin AS asf
              LEFT JOIN employees ON employees.employee_id = asf.ass_employee_id_sc
              WHERE asf.ass_schedule BETWEEN '$dateFrom' AND '$dateTo' AND employees.archive = 'no'";

            $checkDays_query = $conn->query($checkDays_sql);

            if ($checkDays_query->num_rows < 1) {
            $_SESSION['error'] = 'No rows found';
            } else {
            $checkDays_row = $checkDays_query->fetch_assoc();
            $greater_num_days_of_work = (int)$checkDays_row["maxDaysOfWork"];
            }

            // echo "Total days of work: ".$greater_num_days_of_work;
            // exit();

            // query for employee payroll
            $sql2 = "SELECT SUM(CAST(efl.meal_allowance AS DECIMAL(10,2))) AS meal_allowance,
                SUM(CAST(efl.adjustments AS DECIMAL(10,2))) AS adjustments,
                SUM(CAST(efl.transportation AS DECIMAL(10,2))) AS transportation,
                SUM(CAST(efl.incentives_value AS DECIMAL(10,2))) AS incentives_value,
                CAST(efl.base_pay AS DECIMAL(10,2)) AS base_pay,
                CAST(efl.salary AS DECIMAL(10,2)) AS rate,
                CAST(efl.leave_credits AS DECIMAL(10,2)) AS leave_credits,
                COUNT(DISTINCT efl.date) AS days_of_work,
                efl.employee_id AS employee_id
                FROM employee_financial_list AS efl
                LEFT JOIN employees ON employees.employee_id = efl.employee_id
                WHERE efl.date BETWEEN '$dateFrom' AND '$dateTo' AND employees.archive = 'no'
                GROUP BY efl.employee_id
                ";
    
    
                $query2 = $conn->query($sql2);
                if($query2->num_rows < 1){
                    $_SESSION['error'] = 'No rows found';
                }else{
                        // $test[] ='';
                        while($row2 = $query2->fetch_assoc()){
                        $addEmployee = $row2['employee_id'];
                        $date = date('Y-m-d');
                        
                        $mealAllowance = (float)$row2["meal_allowance"];
                        $adjustments = (float)$row2["adjustments"];
                        $transportation = (float)$row2["transportation"];
                        $salary = 0;
                        $base_pay = (float)$row2["base_pay"]/2;
                        $tempBase_pay = $base_pay*2;
                        $rate = (float)$row2["rate"];
                        $leave_credits = (float)$row2["leave_credits"];
                        $incentivesValue = (float)$row2["incentives_value"];
 
                        $daysOfWork = (float)$row2["days_of_work"];
                        $numOfAbsent = 0;
                        
                        if($greater_num_days_of_work > $daysOfWork){
                            $numOfAbsent = $greater_num_days_of_work - $daysOfWork;
                            if($numOfAbsent > 0){
                                $incentivesValue = 0;
                                $leave_credits -= $numOfAbsent;
                                if($leave_credits < 0){
                                    $x = $numOfAbsent + $leave_credits;
                                    $base_pay -= ($x * $rate);
                                    $salary = ($daysOfWork * $rate);

                                    //set to zero not to diplay negative
                                    $leave_credits = 0;
                                }else{
                                    $salary = ($daysOfWork * $rate);
                                }
                            }
                        }else{
                            $salary += ($daysOfWork * $rate);
                        }

                        $grossEarnings = $mealAllowance + $adjustments + $transportation + $incentivesValue + $salary;
                        //creeate temp to pass the gross earning value
                        $tempGross = $grossEarnings;

                          // Query for income tax
                          $incomeTax = 0;
                            $sql_tin = "SELECT * FROM income_tax";
                            $query_tin = $conn->query($sql_tin);
                            while($row_tin = $query_tin->fetch_assoc()){
                                $firstBracket = $row_tin['first_bracket'];
                                $secondBracket = $row_tin['second_bracket'];
                                // $taxRate = $row_tin['tax_rate'];
                                $taxRate = !empty($row_tin['tax_rate']) ? (float)$row_tin['tax_rate'] : 1;
                                $id = $row_tin['id'];
                                }
                               
                                $base_pay = $tempBase_pay;
                                $currentDate = date('Y-m-d');
                                // Check if the current date is December 31st
                                if (date('m-d', strtotime($currentDate)) == '12-31') {
                                        $incomeTax = (float)$taxRate*(float)$base_pay;
                                        if($id && $base_pay>=$firstBracket || $base_pay<=$secondBracket){
                                            echo $incomeTax."<br/>";
                                        // $test = "
                                            // FirstBracket: $firstBracket<br>
                                            // SecondBracket: $secondBracket<br/>
                                            // TaxRate: $taxRate<br>
                                            // ";
                                            // echo $test;
                                        }
                                } else {
                                    // If it's not December 31st, do something else or skip tax computation
                                    echo "Not December 31st. No tax computation needed.\n";
                                }
                        
                        //after income tax computation pass the original value of gross earnings to compute sss,pagibig, and phil.
                        $grossEarnings = $tempGross;

                        //Initialize
                        $cashAdvance = 0;
                        $payPerCutOff = 0;
                        $number_of_cutoffs = 0;
                        $balance = 0;

                        $sql_ca = "SELECT * FROM cashadvance WHERE employee_id = '$addEmployee' ORDER BY id DESC LIMIT 1";
                        $query_ca = $conn->query($sql_ca);

                        if ($query_ca->num_rows > 0) {
                            $row_ca = $query_ca->fetch_assoc();

                            $cashAdvance = round((float)$row_ca["amount"], 2);
                            $number_of_cutoffs = round((float)$row_ca["number_of_cutoffs"], 2);
                            $payPerCutOff = round((float)$row_ca["pay_per_cut_off"], 2);
                            $balance = round((float)$row_ca["balance"], 2);
                            
                        }
                        //  TEST cash advance
                        //cash advance computation
                        if($balance>0){
                            $balance -= $payPerCutOff;
                            $number_of_cutoffs -= 1;
                            if($number_of_cutoffs < 0){
                                $number_of_cutoffs = 0;
                            }
                            if($balance<0){
                                $payPerCutOff = ($balance * -1);
                                $balance = 0;
                                // INSERTION FOR CASHADVANCE SUMMARY
                                $sql = "INSERT INTO cashadvance (employee_id, date_advance, amount, pay_per_cut_off, number_of_cutoffs,balance) VALUES ('$addEmployee', CURDATE(), '$cashAdvance', '$payPerCutOff','$number_of_cutoffs', '$balance')";
                                $conn->query($sql);
                            }else{
                                // INSERTION FOR CASHADVANCE SUMMARY
                                $sql = "INSERT INTO cashadvance (employee_id, date_advance, amount, pay_per_cut_off, number_of_cutoffs, balance) VALUES ('$addEmployee', CURDATE(), '$cashAdvance', '$payPerCutOff','$number_of_cutoffs', '$balance')";
                                $conn->query($sql);
                            }
                            //  $test = "
                            //     cash advacne: ".$row_ca["id"]."<br>
                            //     cash advacne: $cashAdvance<br>
                            //     pay per cut off: $payPerCutOff<br>
                            //     balance: $balance<br>
                            //     ";
                            //     echo $test;
                            //     exit();
                        }
                        
                        // SSS employee and employer contribution (schedule-based)
                        $sssEmpContribution = 0;
                        $sssEmployeerContribution = 0;
                        $stmtSss = $conn->prepare("SELECT regular_ss_employee, mpf_employee, regular_ss_employer, mpf_employer, ec_employer FROM sss_contribution_schedule WHERE active='yes' AND ? BETWEEN min_compensation AND max_compensation LIMIT 1");
                        if($stmtSss){
                            $stmtSss->bind_param("d", $tempBase_pay);
                            if($stmtSss->execute()){
                                $stmtSss->bind_result($regular_ss_employee_amt, $mpf_employee_amt, $regular_ss_employer_amt, $mpf_employer_amt, $ec_employer_amt);
                                if($stmtSss->fetch()){
                                    $sssEmpContribution = round((float)$regular_ss_employee_amt + (float)$mpf_employee_amt, 2);
                                    // Only calculate employer contribution if employee contribution > 0
                                    if($sssEmpContribution > 0) {
                                        $sssEmployeerContribution = round((float)$regular_ss_employer_amt + (float)$mpf_employer_amt + (float)$ec_employer_amt, 2);
                                    }
                                }
                            }
                            $stmtSss->close();
                        }

                        // Get PhilHealth and Pag-IBIG rates from the fetched deduction rates
                        $philhealthEmpRate = isset($deduction_rates['philhealth']) ? (float)$deduction_rates['philhealth']['employee_contribution'] : 0;
                        $philhealthEmployeerRate = isset($deduction_rates['philhealth']) ? (float)$deduction_rates['philhealth']['employeer_contribution'] : 0;
                        $pagibigEmpContribution = isset($deduction_rates['pagibig']) ? (float)$deduction_rates['pagibig']['employee_contribution'] : 0;

                        //Philhealth employee contribution
                        $philhealthEmpContribution = round($philhealthEmpRate * $tempBase_pay, 2);
                        //Philhealth employer contribution - only calculate if employee contribution > 0
                        $philhealthEmployeerContribution = 0;
                        if($philhealthEmpContribution > 0) {
                            $philhealthEmployeerContribution = round($philhealthEmployeerRate * $tempBase_pay, 2);
                        }

                        // Pag-IBIG employer contribution - only calculate if employee contribution > 0
                        $pagibigEmployeerContribution = 0;
                        if($pagibigEmpContribution > 0) {
                            $pagibigEmployeerContribution = isset($deduction_rates['pagibig']) ? (float)$deduction_rates['pagibig']['employeer_contribution'] : 0;
                        }

                        // $test = "<br>
                        //     basepay:$tempBase_pay<br>
                        //     ssemployee: $sssEmpContribution($sssEmp)<br>
                        //     ssemployeeR: $sssEmployeerContribution($sssEmployeer)<br>
                        //     philhealthemployee: $philhealthEmpContribution($philhealthEmp)<br>
                        //     philhealthemployeRR: $philhealthEmployeerContribution($philhealthEmployeer)<br>
                        //     pagibigemployee: $pagibigEmpContribution($philhealthEmp)<br>
                        //     pagibigemployeRR: $pagibigEmployeerContribution($pagibigEmployeer)<br>
                        //     ";
                        //     echo $test;
                         // exit();
                        //total deductions
                        $totalDeduction = 0;
                        
                        //mimimum wage
                        $sql_wage = "SELECT current_wage FROM wage";
                        $query_wage = $conn->query($sql_wage);
                        $row_wage = $query_wage->fetch_assoc();

                        $wage = (float)$row_wage['current_wage'];
                        
                        //Check where to apply deduction based on cut off
                        if($cutOff==1){
                            //first cutoff only deduct sss
                            $totalDeduction = $pagibigEmpContribution;
                            $sssEmpContribution = 0;
                            $philhealthEmpContribution = 0;
                        }else{
                            //2nd cut off deducts sss and philhealth
                            $totalDeduction = $sssEmpContribution + $philhealthEmpContribution;
                            $pagibigEmpContribution = 0;
                        }

                        //apply deduction when rate is  above minimum wage
                        if($rate>$wage){
                            $totalDeduction += $payPerCutOff;
                        }else{
                            $sssEmpContribution = 0;
                            $philhealthEmpContribution = 0;
                            $pagibigEmpContribution = 0;
                        }

                        $netSalary = $grossEarnings - $totalDeduction;
                        $grossEarnings = $tempGross;


                        //TEST CONTRIBUTIONS
                            // $test = "
                            // GROSS:  $grossEarnings<br>
                            // sss_Contribution:  $sssEmpContribution<br>
                            // tin_Contribution:  $philhealthEmpContribution<br>
                            // philhealth_Contribution:  $philhealthEmpContribution<br>
                            // Total Deduction:  $totalDeduction<br>
                            // Net salary:  $netSalary<br>
                            // Wage:  $wage<br>";
                            // echo $test;

                        //13th month pay
                        // $sql_13th = "INSERT INTO _13th_pay (date_range, employee_id, date) VALUES('$dateRange','$addEmployee',CURDATE())";
                        // $conn->query($sql_13th);
 
                        //INSERTION FOR PAYSLIP
                        $sql = "INSERT INTO payroll_employee (employee_id, date_range, salary, meal_allowance, incentives, adjustments, transportation,sss,sss_employeer,pagibig,pagibig_employeer,tin,philhealth,philhealth_employeer,cashadvance,pay_per_cut_off,cashadvance_balance,total_deduction,gross,net_salary,num_days_work, workdays_total, num_of_absent, remaining_credits, created_on) VALUES ('$addEmployee', '$dateRange', '$salary','$mealAllowance','$incentivesValue','$adjustments','$transportation','$sssEmpContribution', '$sssEmployeerContribution', '$pagibigEmpContribution','$pagibigEmployeerContribution','$incomeTax','$philhealthEmpContribution','$philhealthEmployeerContribution','$cashAdvance','$payPerCutOff','$balance','$totalDeduction','$grossEarnings','$netSalary','$daysOfWork','$greater_num_days_of_work','$numOfAbsent', '$leave_credits','$date')";
                        if($conn->query($sql)){
                            $success = true;
                        }
                        else{
                            $error = false;
                            break;
                        }
                        // $_SESSION['success'] = 'Employee attendance date found its match on salary calculation'.$test;
                    }//end while
                    if($success){
                    	$_SESSION['success'] = 'payroll added successfully';
                            // Adding audit trail
                            $user = $_SESSION['username'];
                            $audit_description = "Payroll created by: $user. Cutoff: $cutOff. Date range: $dateRange";
                            $audit_sql = "INSERT INTO audit_logs (date_and_time, user, description) VALUES (NOW(), '$user', '$audit_description')";
                            $conn->query($audit_sql);
                            // Adding audit trail
                    }else if($error){
                        $_SESSION['error'] = $conn->error;
                    }
            }
            // exit();

            //end sql2, query2
		// $_SESSION['success'] = 'Employee found';
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}
    header('location: financial_statement.php');
?>