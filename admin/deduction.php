<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="deduction.css">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Deductions
      </h1>
      <ol class="breadcrumb">
      <li><button style="color:yellow;font-size:15px;margin-top:2px;background:green" class="lock"><i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;<span style="color:white;font-weight:bolder">LOCK SYSTEM</span></button></li>
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Deductions</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
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
      
      <!-- Deduction Settings Section -->
      <div class="row">
        <div class="col-xs-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Deduction Settings</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered">
                <thead>
                  <th>ID</th>
                  <th>Description</th>
                  <th>Employee contribution (decimal)</th>
                  <th>Employeer contribution (decimal)</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM deductions";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$row['id']."</td>
                          <td class='text-right'>".$row['description']."</td>
                          <td class='text-left'>".$row['employee_contribution']."</td>
                          <td class='text-left'>".$row['employeer_contribution']."</td>
                          <td>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                          </td>
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="box">
            <div class="box-body">
              <div class="form-group">
                <?php
                  $sql_wage = "SELECT * FROM wage";
                  $query_wage = $conn->query($sql_wage);
                  $row_w = $query_wage->fetch_assoc();
                ?>
                <label for="current-wage">Minimum wage</label>
                <input type="hidden" name="id" id="wage-id" value="<?php echo $row_w['id']; ?>">
                <input type="text" class="form-control wage" id="current-wage" name="wage" value="<?php echo $row_w['current_wage']; ?>">
              </div>
              <button type="submit" class="btn btn-success" id="apply-wage">Apply</button>
            </div>
          </div>
        </div>
      </div>

      <!-- SSS Contribution Table -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">SSS Contribution Schedule</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-success btn-sm" id="upload-csv-btn" style="margin-right: 5px;">
                  <i class="fa fa-upload"></i> Upload CSV
                </button>
                <button class="btn btn-primary btn-sm edit-mode-btn" id="edit-sss-schedule">
                  <i class="fa fa-edit"></i> Edit Schedule
                </button>
              </div>
            </div>
            <div class="edit-mode-indicator" style="display: none; background: #fff3cd; border: 1px solid #f39c12; padding: 10px; margin: 10px; border-radius: 4px; text-align: center;">
              <i class="fa fa-exclamation-triangle" style="color: #f39c12;"></i>
              <strong style="color: #f39c12;">EDIT MODE ACTIVE</strong> - Click on any row to edit SSS contribution values
            </div>
            <div class="edit-mode-disabled" style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 10px; border-radius: 4px; text-align: center;">
              <i class="fa fa-info-circle" style="color: #6c757d;"></i>
              <strong style="color: #6c757d;">READ-ONLY MODE</strong> - Click "Edit Schedule" to enable editing
            </div>
            <div class="box-body">
              <div class="table-container">
                <table class="deduction-table table table-bordered table-striped">
                  <thead>
                    <tr class="bg-primary">
                      <th rowspan="2" class="text-center">RANGE OF<br>COMPENSATION</th>
                      <th colspan="4" class="text-center">EMPLOYER CONTRIBUTION</th>
                      <th colspan="3" class="text-center">EMPLOYEE CONTRIBUTION</th>
                      <th rowspan="2" class="text-center">TOTAL</th>
                    </tr>
                    <tr class="bg-info">
                      <th class="sub-header text-center">REGULAR SS</th>
                      <th class="sub-header text-center">MPF</th>
                      <th class="sub-header text-center">EC</th>
                      <th class="sub-header text-center">TOTAL</th>
                      <th class="sub-header text-center">REGULAR SS</th>
                      <th class="sub-header text-center">MPF</th>
                      <th class="sub-header text-center">TOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      // Fetch SSS contribution data from database
                      $sql_sss = "SELECT * FROM sss_contribution_schedule ORDER BY min_compensation ASC";
                      $query_sss = $conn->query($sql_sss);
                      
                      if($query_sss->num_rows > 0) {
                        while($row_sss = $query_sss->fetch_assoc()) {
                          $range_text = $row_sss['min_compensation'] == 0 ? 'BELOW ' . number_format($row_sss['max_compensation']) : 
                                       number_format($row_sss['min_compensation']) . ' - ' . number_format($row_sss['max_compensation']);
                          
                          $employer_total = $row_sss['regular_ss_employer'] + $row_sss['mpf_employer'] + $row_sss['ec_employer'];
                          $employee_total = $row_sss['regular_ss_employee'] + $row_sss['mpf_employee'];
                          $grand_total = $employer_total + $employee_total;
                          
                          echo "<tr class='sss-row' data-id='" . $row_sss['id'] . "'>";
                          echo "<td class='range-cell text-center'><strong>" . $range_text . "</strong></td>";
                          echo "<td class='text-center'>" . number_format($row_sss['regular_ss_employer'], 2) . "</td>";
                          echo "<td class='text-center'>" . ($row_sss['mpf_employer'] > 0 ? number_format($row_sss['mpf_employee'], 2) : '-') . "</td>";
                          echo "<td class='text-center'>" . number_format($row_sss['ec_employer'], 2) . "</td>";
                          echo "<td class='text-center'><strong>" . number_format($employer_total, 2) . "</strong></td>";
                          echo "<td class='text-center'>" . number_format($row_sss['regular_ss_employee'], 2) . "</td>";
                          echo "<td class='text-center'>" . ($row_sss['mpf_employee'] > 0 ? number_format($row_sss['mpf_employee'], 2) : '-') . "</td>";
                          echo "<td class='text-center'><strong>" . number_format($employee_total, 2) . "</strong></td>";
                          echo "<td class='total-cell text-center'><strong>" . number_format($grand_total, 2) . "</strong></td>";
                          echo "</tr>";
                        }
                      } else {
                        // Fallback to hardcoded data if database is empty
                        echo "<tr><td colspan='9' class='text-center text-muted'>No SSS contribution data found. Please add data to the database.</td></tr>";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>



      <!-- Income Tax Section -->
      <div class="row">
        <div class="col-xs-8">
          <h3>Income tax</h3>
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnewTax" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp;Create annual gross range</a>
            </div>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered">
                <thead>
                    <th class="hidden"></th>
                    <th>Annual salary range</th>
                    <th>Tax rate (decimal)</th>
                    <th>Tools</th>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM income_tax
                    ORDER BY id ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        // Convert string values to floats
                        $firstBracket =  $row['first_bracket'];
                        $secondBracket = $row['second_bracket'];
                        $taxRate = $row['tax_rate'];                        
                        echo "
                        <tr>
                            <td class='hidden'></td>
                            <td class='text-right'>&#8369;".$firstBracket." - &#8369;".$secondBracket."</td>
                            <td class='text-left'>0".$taxRate."</td>
                            <td>
                                <button class='btn btn-success btn-sm editTax btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                                <button class='btn btn-danger btn-sm deleteTax btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                            </td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xs-4">
          <h3>Contribution report</h3>
          <div class="box">
          <!-- Details -->
          <div class="box-body shadow" style="box-shadow: 0 1px 1px gray;">
          <form class="form-horizontal">
              <div class="form-group">
                  <div class="row">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-4">
                          <label for="add-location" class="control-label">Contribution</label>
                          <div class="form-check">
                              <input type="radio" class="form-check-input" name="contribution" id="sss" value="sss" required/>
                              <label class="form-check-label" for="sss">SSS</label>
                          </div>
                          <div class="form-check">
                              <input type="radio" class="form-check-input" name="contribution" id="pagibig" value="pagibig" required/>
                              <label class="form-check-label" for="pagibig">Pagibig</label>
                          </div>
                          <div class="form-check">
                              <input type="radio" class="form-check-input" name="contribution" id="philhealth" value="philhealth" required/>
                              <label class="form-check-label" for="philhealth">Philhealth</label>
                          </div>
                          <div class="form-check">
                              <input type="radio" class="form-check-input" name="contribution" id="tin" value="income tax" required/>
                              <label class="form-check-label" for="tin">Income tax</label>
                          </div>
                      </div>
                      <div class="col-sm-4">
                         <label for="payroll" class="control-label">Date range</label>
                            <input type="text" class="form-control check-payroll" id="payroll" name="payroll" required>
                          <br/><br/> 
                          <div class="d-flex justify-content-end mt-3">
                              <button type="button" class="btn btn-primary generate">Generate</button>
                          </div>
                      </div>
                      <div class="col-sm-2"></div>
                  </div>
              </div>
          </form>
          </div>
          <!-- Details -->
            <div class="box-body">
              <table id="" class="table table-bordered">
            
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/deduction_modal.php'; ?>
  <?php include 'includes/security_modal.php'; ?>
  <?php include 'includes/income_tax_modal.php'; ?>
  <?php include 'includes/sss_contribution_modal.php'; ?>

</div>
<?php include 'includes/scripts.php'; ?>
<?php include 'includes/security_question_modal_promt.php'; ?>
<?php include "includes/system_lock_modal.php";?>


<script>
  $(document).ready(function(){
    // Ensure all input handling scripts are correctly closed
    $('#employeer-contribution, #employee-contribution, #edit-employeer-contribution, #edit-employee-contribution').on('input', function() {
      this.value = this.value.replace(/[^0-9.]/g, '');
    });
  });
</script>

<script>
  $(function(){
    // Handle edit button click
    $('.edit').click(function(e){
      e.preventDefault();
      $('#security_edit').modal('show');
      var id = $(this).data('id');
      getRow(id); // Ensure this function is defined and works correctly
    });

    // Handle SSS edit button click
    $('#edit-sss-schedule').click(function(e){
      e.preventDefault();
      
      // If already in edit mode, don't show security modal
      if($('.deduction-table').hasClass('edit-mode')) {
        return;
      }
      
      $('#security_edit_sss').modal('show');
    });

    // Handle CSV upload button click
    $('#upload-csv-btn').click(function(e){
      e.preventDefault();
      $('#csvUploadModal').modal('show');
    });

    // Handle CSV template download
    $('#download-template').click(function(e){
      e.preventDefault();
      downloadCSVTemplate();
    });

    // Handle CSV upload form submission
    $('#csv-upload-form').submit(function(e){
      e.preventDefault();
      uploadCSV();
    });

    // Handle progress modal close
    $('#close-progress').click(function(){
      $('#csvProgressModal').modal('hide');
      // Reset progress bar
      $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
      $('.progress-bar .sr-only').text('0% Complete');
      $('#progress-text').text('Preparing upload...');
      $('#upload-results').hide();
      $('#results-content').empty();
      $(this).hide();
    });

    // Handle SSS security form submission
    $('#security-form-edit-sss').submit(function(e){
      e.preventDefault();
      const password = $('#security-pass-edit-sss').val();
      $.ajax({
        url: 'vax_location_security.php',
        method: 'POST',
        data: { password: password },
        success: function(response) {
          response = JSON.parse(response);
          if(response.result === true) {
            $('#security_edit_sss').modal('hide');
            // Clear password field
            $('#security-pass-edit-sss').val('');
            // Enable edit mode
            enableEditMode();
          } else {
            alert('Incorrect password. Please try again.');
          }
        },
        error: function() {
          alert('An error occurred while validating the password. Please try again.');
        }
      });
    });

    // Clear password field when security modal is closed
    $('#security_edit_sss').on('hidden.bs.modal', function () {
      $('#security-pass-edit-sss').val('');
    });

    // Function to enable edit mode
    function enableEditMode() {
      $('.deduction-table').addClass('edit-mode');
      $('#edit-sss-schedule').addClass('active').html('<i class="fa fa-edit"></i> Edit Mode Active');
      $('.sss-row').css('cursor', 'pointer');
      $('.edit-mode-indicator').show();
      $('.edit-mode-disabled').hide();
      
      // Show success message
      showNotification('Edit mode activated! Click on any row to edit.', 'success');
    }

    // Function to disable edit mode
    function disableEditMode() {
      $('.deduction-table').removeClass('edit-mode');
      $('#edit-sss-schedule').removeClass('active').html('<i class="fa fa-edit"></i> Edit Schedule');
      $('.sss-row').css('cursor', 'default');
      $('.edit-mode-indicator').hide();
      $('.edit-mode-disabled').show();
      
      // Clear any password fields that might have been filled
      $('#security-pass-edit-sss').val('');
    }

    // Add click handler to exit edit mode
    $(document).on('click', '#edit-sss-schedule.active', function(e) {
      e.preventDefault();
      if(confirm('Do you want to exit edit mode?')) {
        disableEditMode();
        showNotification('Edit mode deactivated.', 'info');
        // Reset the button to its original state
        $('#edit-sss-schedule').removeClass('active').html('<i class="fa fa-edit"></i> Edit Schedule');
      }
    });

    // Function to show notifications
    function showNotification(message, type) {
      const alertClass = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : 'alert-info';
      const icon = type === 'success' ? 'fa-check' : type === 'error' ? 'fa-warning' : 'fa-info';
      const title = type === 'success' ? 'Success!' : type === 'error' ? 'Error!' : 'Info';
      
      // Remove any existing notifications of the same type to avoid stacking
      $('.toast-notification').remove();
      
      const notification = `
        <div class="alert ${alertClass} alert-dismissible toast-notification" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa ${icon}"></i> ${title}</h4>
          <p style="margin: 5px 0 0 0;">${message}</p>
        </div>
      `;
      
      $('body').append(notification);
      
      // Auto-remove after 5 seconds
      setTimeout(function() {
        $('.toast-notification').fadeOut(500, function() {
          $(this).remove();
        });
      }, 5000);
      
      // Add click to dismiss functionality
      $('.toast-notification').click(function() {
        $(this).fadeOut(300, function() {
          $(this).remove();
        });
      });
      
      // Ensure close button works properly
      $('.toast-notification .close').click(function(e) {
        e.stopPropagation();
        $(this).closest('.toast-notification').fadeOut(300, function() {
          $(this).remove();
        });
      });
    }

    // Handle SSS contribution form submission
    $('#edit-sss-form').submit(function(e){
      e.preventDefault();
      const formData = $(this).serialize();
      $.ajax({
        url: 'sss_contribution_update.php',
        method: 'POST',
        data: formData,
        success: function(response) {
          response = JSON.parse(response);
          if(response.success) {
            showNotification(response.message, 'success');
            $('#editSSS').modal('hide');
            disableEditMode();
            location.reload(); // Refresh to show updated data
          } else {
            showNotification('Error: ' + response.message, 'error');
          }
        },
        error: function() {
          alert('An error occurred while updating the SSS contribution. Please try again.');
        }
      });
    });

    // Handle SSS table row clicks for editing - only when edit mode is active
    $(document).on('click', '.sss-row', function(e){
      // Only allow editing if edit mode is active
      if(!$('.deduction-table').hasClass('edit-mode')) {
        return; // Exit early if not in edit mode
      }
      
      const id = $(this).data('id');
      getSSSRow(id);
    });

    $('#security-form-edit').submit(function(e) {
        e.preventDefault();
        const password = $('#security-pass-edit').val();
        $.ajax({
          url: 'vax_location_security.php', // Your server-side validation endpoint
          method: 'POST',
          data: { password: password },
          success: function(response) {
            response = JSON.parse(response);
            if(response.result === true) {
              $('#security_edit').modal('hide');
              $('#edit').modal('show');
              getRow(id); // Use the saved id here
            } else {
              alert('Incorrect password. Please try again.');
              console.log(response.result);
            }
          },
          error: function() {
            alert('An error occurred while validating the password. Please try again.');
          }
        });
    });
    

    // // Handle delete button click
    // $('.delete').click(function(e){
    //   e.preventDefault();
    //   $('#security_archive').modal('show');
    //   var id = $(this).data('id');
    //   getRow(id);
    // });
    // $('#security-form-archive').submit(function(e) {
    //     e.preventDefault();
    //     const password = $('#security-pass-archive').val();
    //     $.ajax({
    //       url: 'vax_location_security.php',
    //       method: 'POST',
    //       data: { password: password },
    //       success: function(response) {
    //         response = JSON.parse(response);
    //         if(response.result === true) {
    //           $('#security_archive').modal('hide');
    //           $('#delete').modal('show');
    //           getRow(id);
    //         } else {
    //           alert('Incorrect password. Please try again.');
    //           console.log(response.result);
    //         }
    //       },
    //       error: function() {
    //         alert('An error occurred while validating the password. Please try again.');
    //       }
    //     });
    // });
  });

  // Function to get row details
  function getRow(id){
    $.ajax({
      type: 'POST',
      url: 'deduction_row.php',
      data: {id:id},
      dataType: 'json',
      success: function(response){
        $('.decid').val(response.id);
        $('#edit_description').val(response.description);
        $('#edit-employeer-contribution').val(response.employeer_contribution);
        $('#edit-employee-contribution').val(response.employee_contribution);
        $('#del_deduction').html(response.description);
        $('#annual_salary_range').html(response.description);
      }
    });
  }
</script>

<!-- WAGE SCRIPT -->
<script>
    $(document).ready(function() {
        $('#apply-wage').click(function() {
          $('#security_wage').modal('show');
          wageSecurityModal();
        });

        function wageFunction(){
            var id = $('#wage-id').val();
            var wage = $('#current-wage').val();
            $.ajax({
                url: 'deduction_wage.php', // Your server-side script to handle the update
                method: 'POST',
                data: { id: id, wage: wage },
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.success) {
                        alert('Wage updated successfully');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while updating the wage. Please try again.');
                }
            });
          }
          function wageSecurityModal(){
            $('#security-form-edit-wage').submit(function(e) {
                e.preventDefault();
                const password = $('#security-pass-edit-wage').val();

                $.ajax({
                  url: 'vax_location_security.php', // Your server-side validation endpoint
                  method: 'POST',
                  data: { password: password },
                  success: function(response) {
                    response = JSON.parse(response);
                    if(response.result === true) {
                      $('#security_wage').modal('hide');
                      wageFunction();
                    } else {
                      alert('Incorrect password. Please try again.');
                      console.log(response.result);
                    }
                  },
                  error: function() {
                    alert('An error occurred while validating the password. Please try again.');
                  }
                });

              });
          }
    });
</script>

<!-- INCOME TAX SCRIPT,-->
<script>
  $(function(){
    // Handle tax edit button click
    $('.editTax').click(function(e){
      e.preventDefault();
      $('#security_edit_tax').modal('show');
      var id = $(this).data('id');
      getRowTax(id);
    });
    $('#security-form-edit-tax').submit(function(e) {
        e.preventDefault();
        const password = $('#security-pass-edit-tax').val();
        $.ajax({
          url: 'vax_location_security.php',
          method: 'POST',
          data: { password: password },
          success: function(response) {
            response = JSON.parse(response);
            if(response.result === true) {
              $('#security_edit_tax').modal('hide');
              $('#editTax').modal('show');
              getRow(id);
            } else {
              alert('Incorrect password. Please try again.');
              console.log(response.result);
            }
          },
          error: function() {
            alert('An error occurred while validating the password. Please try again.');
          }
        });
    });

    // Handle tax delete button click
    $('.deleteTax').click(function(e){
      e.preventDefault();
      $('#security_archive').modal('show');
      var id = $(this).data('id');
      getRowTax(id);
    });
    $('#security-form-archive').submit(function(e) {
        e.preventDefault();
        const password = $('#security-pass-archive').val();
        $.ajax({
          url: 'vax_location_security.php', // Your server-side validation endpoint
          method: 'POST',
          data: { password: password },
          success: function(response) {
            response = JSON.parse(response);
            if(response.result === true) {
              $('#security_archive').modal('hide');
              $('#deleteTax').modal('show');
              getRow(id); // Use the saved id here
            } else {
              alert('Incorrect password. Please try again.');
              console.log(response.result);
            }
          },
          error: function() {
            alert('An error occurred while validating the password. Please try again.');
          }
        });
    });
  });



  // Function to get tax row details
  function getRowTax(id){
    $.ajax({
      type: 'POST',
      url: 'income_tax_row.php',
      data: {id:id},
      dataType: 'json',
      success: function(response){
        console.log(response);
        $('#tax-id').val(response.id);
        $('.delete_id').val(response.id);
        $('#edit-first-bracket').val(response.second_bracket);
        $('#edit-tax-rate').val(response.tax_rate);
      }
    });
  }

  // Function to get SSS row details
  function getSSSRow(id){
    $.ajax({
      type: 'POST',
      url: 'sss_contribution_row.php',
      data: {id:id},
      dataType: 'json',
      success: function(response){
        if(response.error) {
          alert('Error: ' + response.error);
          return;
        }
        
        $('#sss-id').val(response.id);
        $('#edit-min-compensation').val(response.min_compensation);
        $('#edit-max-compensation').val(response.max_compensation);
        $('#edit-regular-ss-employer').val(response.regular_ss_employer);
        $('#edit-mpf-employer').val(response.mpf_employer);
        $('#edit-ec-employer').val(response.ec_employer);
        $('#edit-regular-ss-employee').val(response.regular_ss_employee);
        $('#edit-mpf-employee').val(response.mpf_employee);
        $('#edit-sss-active').val(response.active);
        
        $('#editSSS').modal('show');
      },
      error: function(){
        alert('An error occurred while fetching SSS contribution data.');
      }
    });
  }

  // Function to download CSV template
  function downloadCSVTemplate() {
    const csvContent = `Range of Compensation,Employer Regular SS,Employer MPF,Employer EC,Employee Regular SS,Employee MPF
BELOW 5249.99,500.00,0.00,10.00,250.00,0.00
5250.00-5749.99,550.00,0.00,10.00,275.00,0.00
5750.00-6249.99,600.00,0.00,10.00,300.00,0.00
6250.00-6749.99,650.00,0.00,10.00,325.00,0.00
6750.00-7249.99,700.00,0.00,10.00,350.00,0.00
7250.00-7749.99,750.00,0.00,10.00,375.00,0.00
7750.00-8249.99,800.00,0.00,10.00,400.00,0.00
8250.00-8749.99,850.00,0.00,10.00,425.00,0.00
8750.00-9249.99,900.00,0.00,10.00,450.00,0.00
9250.00-9749.99,950.00,0.00,10.00,475.00,0.00
9750.00-10249.99,1000.00,0.00,10.00,500.00,0.00
10250.00-10749.99,1050.00,0.00,10.00,525.00,0.00
10750.00-11249.99,1100.00,0.00,10.00,550.00,0.00
11250.00-11749.99,1150.00,0.00,10.00,575.00,0.00
11750.00-12249.99,1200.00,0.00,10.00,600.00,0.00
12250.00-12749.99,1250.00,0.00,10.00,625.00,0.00
12750.00-13249.99,1300.00,0.00,10.00,650.00,0.00
13250.00-13749.99,1350.00,0.00,10.00,675.00,0.00
13750.00-14249.99,1400.00,0.00,10.00,700.00,0.00
14250.00-14749.99,1450.00,0.00,10.00,725.00,0.00
14750.00-15249.99,1500.00,0.00,30.00,750.00,0.00
15250.00-15749.99,1550.00,0.00,30.00,775.00,0.00
15750.00-16249.99,1600.00,0.00,30.00,800.00,0.00
16250.00-16749.99,1650.00,0.00,30.00,825.00,0.00
16750.00-17249.99,1700.00,0.00,30.00,850.00,0.00
17250.00-17749.99,1750.00,0.00,30.00,875.00,0.00
17750.00-18249.99,1800.00,0.00,30.00,900.00,0.00
18250.00-18749.99,1850.00,0.00,30.00,925.00,0.00
18750.00-19249.99,1900.00,0.00,30.00,950.00,0.00
19250.00-19749.99,1950.00,0.00,30.00,975.00,0.00
19750.00-20249.99,2000.00,0.00,30.00,1000.00,0.00
20250.00-20749.99,2000.00,50.00,30.00,1000.00,25.00
20750.00-21249.99,2000.00,100.00,30.00,1000.00,50.00
21250.00-21749.99,2000.00,150.00,30.00,1000.00,75.00
21750.00-22249.99,2000.00,200.00,30.00,1000.00,100.00
22250.00-22749.99,2000.00,250.00,30.00,1000.00,125.00
22750.00-23249.99,2000.00,300.00,30.00,1000.00,150.00
23250.00-23749.99,2000.00,350.00,30.00,1000.00,175.00
23750.00-24249.99,2000.00,400.00,30.00,1000.00,200.00
24250.00-24749.99,2000.00,450.00,30.00,1000.00,225.00
24750.00-25249.99,2000.00,500.00,30.00,1000.00,250.00
25250.00-25749.99,2000.00,550.00,30.00,1000.00,275.00
25750.00-26249.99,2000.00,600.00,30.00,1000.00,300.00
26250.00-26749.99,2000.00,650.00,30.00,1000.00,325.00
26750.00-27249.99,2000.00,700.00,30.00,1000.00,350.00
27250.00-27749.99,2000.00,750.00,30.00,1000.00,375.00
27750.00-28249.99,2000.00,800.00,30.00,1000.00,400.00
28250.00-28749.99,2000.00,850.00,30.00,1000.00,425.00
28750.00-29249.99,2000.00,900.00,30.00,1000.00,450.00
29250.00-29749.99,2000.00,950.00,30.00,1000.00,475.00
29750.00-30249.99,2000.00,1000.00,30.00,1000.00,500.00
30250.00-30749.99,2000.00,1050.00,30.00,1000.00,525.00
30750.00-31249.99,2000.00,1100.00,30.00,1000.00,550.00
31250.00-31749.99,2000.00,1150.00,30.00,1000.00,575.00
31750.00-32249.99,2000.00,1200.00,30.00,1000.00,600.00
32250.00-32749.99,2000.00,1250.00,30.00,1000.00,625.00
32750.00-33249.99,2000.00,1300.00,30.00,1000.00,650.00
33250.00-33749.99,2000.00,1350.00,30.00,1000.00,675.00
33750.00-34249.99,2000.00,1400.00,30.00,1000.00,700.00
34250.00-34749.99,2000.00,1450.00,30.00,1000.00,725.00
34750.00-999999.99,2000.00,1500.00,30.00,1000.00,750.00`;

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'sss_contribution_template.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  // Function to upload CSV
  function uploadCSV() {
    const fileInput = document.getElementById('csv-file');
    const file = fileInput.files[0];
    
    if (!file) {
      showNotification('Please select a CSV file to upload.', 'error');
      return;
    }
    
    if (file.type !== 'text/csv' && !file.name.toLowerCase().endsWith('.csv')) {
      showNotification('Please select a valid CSV file.', 'error');
      return;
    }
    
    if (file.size > 5 * 1024 * 1024) { // 5MB limit
      showNotification('File size must be less than 5MB.', 'error');
      return;
    }
    
    // Show progress modal
    $('#csvUploadModal').modal('hide');
    $('#csvProgressModal').modal('show');
    
    const formData = new FormData();
    formData.append('csv_file', file);
    formData.append('backup_existing', document.getElementById('backup-existing').checked ? '1' : '0');
    formData.append('validate_only', document.getElementById('validate-only').checked ? '1' : '0');
    
    // Update progress
    updateProgress(10, 'Reading CSV file...');
    
    $.ajax({
      url: 'sss_contribution_upload.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      xhr: function() {
        const xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
          if (evt.lengthComputable) {
            const percentComplete = Math.round((evt.loaded / evt.total) * 100);
            updateProgress(percentComplete, 'Uploading file...');
          }
        }, false);
        return xhr;
      },
      success: function(response) {
        try {
          const result = JSON.parse(response);
          updateProgress(100, 'Processing complete!');
          
          setTimeout(function() {
            showUploadResults(result);
          }, 1000);
        } catch (e) {
          updateProgress(100, 'Error processing response');
          showNotification('Error processing upload response.', 'error');
          $('#close-progress').show();
        }
      },
      error: function(xhr, status, error) {
        updateProgress(100, 'Upload failed');
        showNotification('Upload failed: ' + error, 'error');
        $('#close-progress').show();
      }
    });
  }

  // Function to update progress
  function updateProgress(percent, text) {
    $('.progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
    $('.progress-bar .sr-only').text(percent + '% Complete');
    $('#progress-text').text(text);
  }

  // Function to show upload results
  function showUploadResults(result) {
    let resultsHtml = '';
    
    if (result.success) {
      resultsHtml += '<div class="alert alert-success">';
      resultsHtml += '<h5><i class="fa fa-check"></i> Upload Successful!</h5>';
      resultsHtml += '<p>' + result.message + '</p>';
      resultsHtml += '</div>';
      
      if (result.stats) {
        resultsHtml += '<div class="alert alert-info">';
        resultsHtml += '<h6>Upload Statistics:</h6>';
        resultsHtml += '<ul>';
        resultsHtml += '<li>Total rows processed: ' + result.stats.total_rows + '</li>';
        resultsHtml += '<li>Successfully updated: ' + result.stats.updated + '</li>';
        resultsHtml += '<li>New records added: ' + result.stats.added + '</li>';
        if (result.stats.errors > 0) {
          resultsHtml += '<li>Errors: ' + result.stats.errors + '</li>';
        }
        resultsHtml += '</ul>';
        resultsHtml += '</div>';
      }
      
      showNotification(result.message, 'success');
      
      // Refresh the page after successful upload
      setTimeout(function() {
        location.reload();
      }, 2000);
    } else {
      resultsHtml += '<div class="alert alert-danger">';
      resultsHtml += '<h5><i class="fa fa-warning"></i> Upload Failed!</h5>';
      resultsHtml += '<p>' + result.message + '</p>';
      if (result.errors && result.errors.length > 0) {
        resultsHtml += '<h6>Errors:</h6><ul>';
        result.errors.forEach(function(error) {
          resultsHtml += '<li>' + error + '</li>';
        });
        resultsHtml += '</ul>';
      }
      resultsHtml += '</div>';
      
      showNotification(result.message, 'error');
    }
    
    $('#upload-results').show();
    $('#results-content').html(resultsHtml);
    $('#close-progress').show();
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var generateButton = document.querySelector('.generate');
    
    generateButton.addEventListener('click', function() {
      const contribution = document.querySelector("input[name='contribution']:checked").value;
      const payroll = document.getElementById('payroll').value;
      fetchData(contribution, payroll);
    });

    function fetchData(contribution, payroll) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'deduction_fetch_data.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
          var response = JSON.parse(xhr.responseText);
          var printableContent = `
            <div style="display:flex;align-items:center;justify-content:center;flex-direction:row;text-align:center">
              <div style="margin-right: 20px;">
                <img src="${window.location.origin}/payroll-system-ewn/images/logo.png" class="img-responsive" id="ewn-logo" alt="img" style="width: 100px">
              </div>
              <center><h1><b>EWN Manpower Services</b></h1></center>
              <b style="margin-left: 20px;">ewn@gmail.com <i class="fa fa-envelope-o"></i></b>
              <b style="margin-left: 20px;">Noveleta, Cavite <i class="fa fa-location-arrow"></i></b>
            </div>`;
          printableContent += "<h1>Contribution report</h1>";
          printableContent += "<p>Contribution: " + contribution + "</p>";
          printableContent += "<p>Date range: " + payroll + "</p>";
          printableContent += "<table border=''>";

          let overAll = 0;
          if (contribution === 'sss') {
            printableContent += `
              <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Employee contribution</th>
                <th>Employer contribution</th>
                <th>Total</th>
              </tr>`;
            for (var i = 0; i < response.length; i++) {
              printableContent += "<tr>";
              printableContent += "<td>" + response[i].employee_id + "</td>";
              printableContent += "<td>" + response[i].name + "</td>";
              printableContent += "<td>" + response[i].sss + "</td>";
              printableContent += "<td>" + response[i].sss_employeer + "</td>";
              printableContent += "<td>" + response[i].total + "</td>";
              printableContent += "</tr>";
              overAll += parseFloat(response[i].total);
            }
          } else {
            printableContent += `
              <tr>
                <th>Employee ID</th>
                <th>Name</th>`;
            if (contribution === "pagibig") {
              printableContent += "<th>Employee contribution</th>";
              printableContent += "<th>Employer contribution</th>";
            }
            if (contribution === "philhealth") {
              printableContent += "<th>Employee contribution</th>";
              printableContent += "<th>Employer contribution</th>";
            }
            if (contribution === "income tax") {
              printableContent += "<th>Employee contribution</th>";
            }
            printableContent += "<th>Total</th>";
            printableContent += "</tr>";
            for (var i = 0; i < response.length; i++) {
              printableContent += "<tr>";
              printableContent += "<td>" + response[i].employee_id + "</td>";
              printableContent += "<td>" + response[i].name + "</td>";
              if (contribution === "pagibig") {
                printableContent += "<td>" + response[i].pagibig + "</td>";
                printableContent += "<td>" + response[i].pagibig_employeer + "</td>";
              }
              if (contribution === "philhealth") {
                printableContent += "<td>" + response[i].philhealth + "</td>";
                printableContent += "<td>" + response[i].philhealth_employeer + "</td>";
              }
              if (contribution === "income tax") {
                printableContent += "<td>" + response[i].tin + "</td>";
              }
              printableContent += "<td>" + response[i].total + "</td>";
              printableContent += "</tr>";
              overAll += parseFloat(response[i].total);
            }
          }

          printableContent += "<tr>";
          printableContent += "<th></th>";
          printableContent += "<th></th>";
          printableContent += "<th></th>";
          printableContent += "<th>Total</th>";
          printableContent += "<th>" + parseFloat(overAll).toLocaleString() + "</th>";
          printableContent += "</tr>";
          printableContent += "</table>";
          printableContent += `
            <br><br><br>
            <div style="display:flex;align-items:right;justify-content:right;flex-direction:row;text-align:right">
              <div style="text-align:center">
                <span>Prepared by:</span><br>
                <span style="font-size:20px !important"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?></span><br>
                <i><?php echo isset($_SESSION['role']) ? $_SESSION['role'] : ''; ?></i><br>
              </div>
            </div>`;

          var printWindow = window.open('', '_blank');
          printWindow.document.open();
          printWindow.document.write(`
            <html>
            <head>
              <title>Print</title>
              <style>
                body {
                  font-family: Arial, sans-serif;
                }
                h1 {
                  text-align: center;
                }
                table {
                  width: 100%;
                  border-collapse: collapse;
                  margin: 20px 0;
                }
                table, th, td {
                  border: 1px solid black;
                }
                th, td {
                  padding: 8px;
                  text-align: left;
                }
                th {
                  background-color: #f2f2f2;
                }
              </style>
            </head>
            <body>
              ${printableContent}
              <script>
                (function(){
                  function waitForImagesAndPrint(){
                    var imgs = Array.prototype.slice.call(document.images);
                    if(imgs.length === 0){ window.print(); return; }
                    var loaded = 0;
                    function done(){ if(++loaded === imgs.length){ setTimeout(function(){ window.print(); }, 100); } }
                    imgs.forEach(function(img){
                      if(img.complete){ done(); }
                      else { img.addEventListener('load', done, { once: true }); img.addEventListener('error', done, { once: true }); }
                    });
                  }
                  window.addEventListener('load', waitForImagesAndPrint);
                  window.onafterprint = function(){ window.close(); };
                })();
              <\/script>
            </body>
            </html>`);
          printWindow.document.close();
          
        }
      };
      xhr.send("contribution=" + contribution + "&payroll=" + payroll);
    }
  });
</script>

</body>
</html>
