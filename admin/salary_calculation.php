<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Finances
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Finances</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          $locationId = '';
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <?php
       $sql = "SELECT COUNT(*) AS total_location FROM location";
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
             $total_locations = $row["total_location"];
           }
       } else {
           echo "0 results";
       }
       // Close connection
      ?>

      <?php
      $limit = 10; // Number of records per page

      // Function to get total records for a location
      function getTotalRecords($conn, $location_id) {
          $sql = "SELECT COUNT(*) AS total FROM employee_financial_list WHERE location_id = '$location_id'";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          return $row['total'];
      }

      $total_locations = 10; // Set this to the number of locations you have
      ?>

      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
                <!-- finances filtering by date range -->
                <div class="row">
                  <form action="" method="POST">
                  <div class="col-sm-10 align-right">
                        <div class="date col-sm-2">
                            <label for="dateFrom" class="col-form-label">Date from</label>
                            <input type="text" class="form-control" id="dateFrom" name="dateFrom" required>
                          </div>
                          <div class="date col-sm-2">
                            <label for="dateTo" class="col-form-label">Date to</label>
                            <input type="text" class="form-control" id="dateTo" name="dateTo" required>
                          </div>
                          
                          <div class="date col-sm-2" style="margin-top:25px">
                            <button type="submit" class="btn btn-primary print">Print</button>
                          </div>
                    </div>
                  </form>
                </div><br><br>
                <!-- finances filtering by date range -->
            </div>
            <div class="box-body">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <?php 
                for($i = 1; $i <= $total_locations; $i++) {
                    // Fetch location name from the database based on $i
                    $sql_location = "SELECT province, municipality FROM location WHERE id = $i";
                    $result_location = $conn->query($sql_location);
                    if ($result_location->num_rows > 0) {
                        $row_location = $result_location->fetch_assoc();
                        $location_name = $row_location["province"].", ".$row_location["municipality"];
                        // Check if there is data for this location
                        $sql_check_data = "SELECT COUNT(*) AS data_count FROM employee_financial_list WHERE location_id = $i";
                        $result_check_data = $conn->query($sql_check_data);
                        $data_count = 0;
                        if ($result_check_data->num_rows > 0) {
                            $row_check_data = $result_check_data->fetch_assoc();
                            $data_count = $row_check_data["data_count"];
                        }
                        // If data exists for this location, display the tab
                        if ($data_count > 0) {
                ?>
                    <li role="presentation" <?php echo ($i === 1) ? 'class="active"' : ''; ?>>
                      <a href="#location<?php echo $i; ?>" aria-controls="location<?php echo $i; ?>" role="tab" data-toggle="tab"><?php echo $location_name; ?></a>
                    </li>
                <?php
                        }
                    } else {
                        $location_name = "Unknown Location";
                    }
                } 
                ?>
              </ul>

              <!-- <div class="row">
                  <div class="col-md-6">
                      <a href="#total" data-toggle="modal" class="btn btn-warning btn-sm btn-flat">
                          <i class="fa fa-calculator"></i>Sum
                      </a>
                  </div>
              </div> -->

              <!-- Tab panes -->
              <div class="tab-content">
                <?php
                $i = 1;
                for($i = 1; $i <= $total_locations; $i++) { 
                    // Fetch data only for locations with corresponding data
                    $sql_check_data = "SELECT COUNT(*) AS data_count FROM employee_financial_list WHERE location_id = $i";
                    $result_check_data = $conn->query($sql_check_data);
                    $data_count = 0;
                    if ($result_check_data->num_rows > 0) {
                        $row_check_data = $result_check_data->fetch_assoc();
                        $data_count = $row_check_data["data_count"];
                    }
                    if ($data_count > 0) {
                ?>
                    <div role="tabpanel" class="tab-pane <?php echo ($i === 1) ? 'active' : ''; ?> tabtab" id="location<?php echo $i; ?>" data-tab-id="<?php echo $i; ?>" style="overflow-x:auto;">
                      <table id="example<?php echo $i; ?>" class="table table-bordered">
                        <thead>
                          <th>Date Hatch</th>
                          <th>Total DOC</th>
                          <th>Incentives Rate</th>
                          <th>Incentives Value Per Employee</th>
                          <th>Xtra Meal Allowance/Adjustments</th>
                          <th>Meal Allowance</th>
                          <th>Transportation</th>
                          <th>No. of EWN Crew</th>
                          <th>Total Cost</th>
                          <!-- <th>Toos</th> -->
                        </thead>
                        <tbody>
                        <?php
                         $sql = "SELECT *,
                         COUNT(*) AS numOfrows,
                         COUNT(DISTINCT efl.employee_id) AS crews,
                         SUM(efl.meal_allowance) AS meal_allowance,
                         SUM(efl.adjustments) AS adjustments,
                         SUM(efl.transportation) AS transportation,
                         location.doc AS doc,
                         efl.incentives_value AS incentives_value,
                         efl.date AS date
                         FROM employee_financial_list AS efl
                         LEFT JOIN location ON efl.location_id = location.id
                         LEFT JOIN employees ON employees.employee_id = efl.employee_id
                         WHERE efl.location_id = '$i' AND employees.archive = 'no'
                         GROUP BY efl.date";
                          $query = $conn->query($sql);

                          // Initialize an array to store row data
                          $rows = array();

                          while($row = $query->fetch_assoc()){
                              // Store each row's data in the $rows array
                              $rows[] = $row;
                          }

                          // Process each row's data separately
                          $totalDoc = 0;
                          $total_incentivesRate = 0;
                          $total_incentivesValue = 0;
                          $total_adjustments = 0;
                          $total_mealAllowance = 0;
                          $total_transportation = 0;
                          $total_crews = 0;
                          $total_totalCost = 0;

                          foreach ($rows as $row) {
                            $doc = number_format((float)$row['doc'],2);
                            $incentivesRate = number_format((float)$row['incentives_value'],2);
                            $incentivesValue = $row['crews'] != 0 ? number_format((float)$row['incentives_value'] / $row['crews'], 2) : "N/A";
                            $adjustments = number_format((float)$row['adjustments'],2);
                            $mealAllowance = number_format((float)$row['meal_allowance'],2);
                            $transportation = number_format((float)$row['transportation'],2);
                            $crews = $row['crews'];
                            $totalCost = number_format(((float)$row['meal_allowance'] + (float)$row['incentives_value']),2);
                              ?>
                              <tr>
                                  <td class="text-right"><?php echo $row['date']; ?></td>
                                  <td class="text-right"><?php echo $doc ?></td>
                                  <td class="text-right"> &#8369; <?php echo  $incentivesRate ?></td>
                                  <td class="text-right">
                                      <?= $incentivesValue ?>
                                  </td>
                                  <td class="text-right"> &#8369; <?php echo $adjustments ?></td>
                                  <td class="text-right"> &#8369; <?php echo $mealAllowance ?></td>
                                  <td class="text-right"> &#8369; <?php echo $transportation ?></td>
                                  <td class="text-right"><?php echo $crews ?></td>
                                  <td class="text-right"> &#8369; <?php echo $totalCost ?></td>
                              </tr>
                             
                          <?php 
                        
                        $totalDoc += (float)$row['doc'];
                        $total_incentivesRate += (float)$row['incentives_value'];
                        $total_incentivesValue += $row['crews'] != 0 ? (float)$row['incentives_value'] /  (float)$row['crews'] : "N/A";
                        $total_adjustments += (float)$row['adjustments'];
                        $total_mealAllowance += (float)$row['meal_allowance'];
                        $total_transportation += (float)$row['transportation'];
                        $total_crews += $row['crews'];
                        $total_totalCost += ((float)$row['meal_allowance'] + (float)$row['incentives_value']);
                        }

                        // Formatting the totals
                        $totalDoc = number_format($totalDoc, 2);
                        $total_incentivesRate = number_format($total_incentivesRate, 2);
                        $total_incentivesValue = number_format($total_incentivesValue, 2);
                        $total_adjustments = number_format($total_adjustments, 2);
                        $total_mealAllowance = number_format($total_mealAllowance, 2);
                        $total_transportation = number_format($total_transportation, 2);
                        $total_totalCost = number_format($total_totalCost, 2);
                        ?> 
                            <tr>
                                <th class="text-right">Total</th>
                                <th class="text-right"><?php echo $totalDoc ?></th>
                                <th class="text-right"> &#8369; <?php echo $total_incentivesRate ?></th>
                                <th class="text-right"> &#8369; <?php echo $total_incentivesValue ?></th>
                                <th class="text-right"> &#8369; <?php echo $total_adjustments ?></th>
                                <th class="text-right"> &#8369; <?php echo $total_mealAllowance ?></th>
                                <th class="text-right"> &#8369; <?php echo $total_transportation ?></th>
                                <th class="text-right"><?php echo $total_crews ?></th>
                                <th class="text-right"> &#8369; <?php echo $total_totalCost ?></th>
                            </tr>
                            <!-- END COMPUTATION OF TOTAL -->
                        </tbody>
                      </table>
                    </div>
                <?php 
                    }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/salary_calculation_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<?php include 'includes/security_question_modal_promt.php'; ?>

<script>
$(function(){
  // Get the href attribute of the first tab and pass it to sal_id
  var firstTabPaneId = $('.nav-tabs a:first').attr('href');
  var firstTabPaneValue = $(firstTabPaneId).data('tab-id');
  $('#sal_id').val(firstTabPaneValue);

  // Event handler for tab click
  $('.nav-tabs a').on('click', function(){
    var tabPaneId = $(this).attr('href');
    var tabPaneValue = $(tabPaneId).data('tab-id');
    $('#sal_id').val(tabPaneValue);
  });

  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

// Function to fetch data for editing
function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'salary_calculation_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      // Update modal content
      $('#add-doc').val(response.doc);
      $('#add-incentives').val(response.incent);
      $('#add-salary').val(response.ass_salary);
      $('#add-crew').val(response.crew_numbers);
      $('#add-locid').val(response.add_loc_id);
      $('#com-loc-id').val(response.add_loc_id);
      $('#ref-id').val(response.add_loc_id);
      $('#del-salary-locid').val(response.id);
      $('#del_salary_calculation').html(response.incentives);
    },
    error: function(xhr, status, error) {
      // Handle errors
      console.error(xhr.responseText);
      alert("An error occurred while fetching data.");
    }
  });
}

// DATE RANGE PRINT
function printFunction(dateFrom, dateTo) {
// AJAX call to fetch data from the server
$.ajax({
    type: 'POST',
    url: 'salary_calculation_fetch_data.php',
    data: {
        dateFrom: dateFrom,
        dateTo: dateTo
    },
    dataType: 'json',
    success: function(response) {
        // Generate printable output using fetched data with EWN logo and styling
        var printableContent = `
        <div class="" style="display:flex;align-items:center;justify-content:center;flex-direction:row;text-align:center">
        <div style="margin-right: 20px;">
            <img src="${window.location.origin}/payroll-system-ewn/images/logo.png" class="img-responsive" id="ewn-logo" alt="img"  style="width: 100px">
        </div>
        <center><h1><b>EWN Manpower Services</b></h1></center>
        
        <b style="margin-left: 20px;">ewn@gmail.com <i class="fa fa-envelope-o"></i><b><br>
        <b style="margin-left: 20px;">Noveleta, Cavite <i class="fa fa-location-arrow"></i><b>
        </div>
        `;
        printableContent += "<h2>Finances Report</h2>";
        printableContent += "<p>Date Range: " + dateFrom + " to " + dateTo + "</p>";
        printableContent += "<table border='1' style='width:100%; border-collapse: collapse;'>";
        printableContent += "<tr><th>Date Hatch</th><th>Location</th><th>Total DOC</th><th>Incentives Rate</th><th>Incentives Value Per Employee</th><th>Xtra Meal Allowance/Adjustments</th><th>Meal Allowance</th><th>Transportation</th><th>No. of EWN Crew</th><th>Total Cost</th></tr>";
        
        for (var i = 0; i < response.length; i++) {
            printableContent += "<tr>";
            printableContent += "<td>" + response[i].date + "</td>";
            printableContent += "<td>" + response[i].province + ", " + response[i].municipality + "</td>";
            printableContent += "<td>" + response[i].formatted_doc + "</td>";
            printableContent += "<td>₱ " + response[i].formatted_incentives_rate + "</td>";
            printableContent += "<td>₱ " + response[i].formatted_incentives_value + "</td>";
            printableContent += "<td>₱ " + response[i].formatted_adjustments + "</td>";
            printableContent += "<td>₱ " + response[i].formatted_meal_allowance + "</td>";
            printableContent += "<td>₱ " + response[i].formatted_transportation + "</td>";
            printableContent += "<td>" + response[i].formatted_crews + "</td>";
            printableContent += "<td>₱ " + response[i].formatted_total_cost + "</td>";
            printableContent += "</tr>";
        }
        printableContent += "</table>";
        printableContent += `
        <br><br><br>
        
        <div style="display:flex;align-items:right;justify-content:right;flex-direction:row;text-align:right">
            <div style="text-align:center">
              <span>Prepared by:</span><br>
              <span style="font-size:20px !important"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?></span><br>
              <i><?php echo isset($_SESSION['role']) ? $_SESSION['role'] : ''; ?></i><br>
              <span><?php echo date('Y-m-d H:i:s'); ?></span>
            </div>
        </div>
        `;
        
        // Create a new window for printing
        var printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>Finances Report - ${dateFrom} to ${dateTo}</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    .text-right { text-align: right; }
                    h1, h2 { text-align: center; }
                    @media print {
                        body { margin: 0; }
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                ${printableContent}
            </body>
            </html>
            `);
        printWindow.document.close();
        
        // Wait for the content to load, then trigger print dialog
        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print();
            // Close the window after printing (optional)
            // printWindow.close();
        };
    },
    error: function(xhr, status, error) {
        console.error("Error fetching finances data:", error);
        alert("Error fetching finances data. Please try again.");
    }
    });
}
$(function() {
    $('.print').click(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        var dateFrom = $('#dateFrom').val(); // Get the value of dateFrom input
        var dateTo = $('#dateTo').val(); // Get the value of dateTo input
        printFunction(dateFrom, dateTo); // Call printFunction with dateFrom and dateTo values
    });
});
// END DATE RANGE PRINT

</script>

</body>
</html>
