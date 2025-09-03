<!-- SSS Contribution Edit Modal -->
<div class="modal fade" id="editSSS" tabindex="-1" role="dialog" aria-labelledby="editSSSLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="editSSSLabel">Edit SSS Contribution Schedule</h4>
      </div>
      <form id="edit-sss-form">
        <div class="modal-body">
          <input type="hidden" id="sss-id" name="id">
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-min-compensation">Minimum Compensation</label>
                <input type="number" class="form-control" id="edit-min-compensation" name="min_compensation" step="0.01" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-max-compensation">Maximum Compensation</label>
                <input type="number" class="form-control" id="edit-max-compensation" name="max_compensation" step="0.01" required>
              </div>
            </div>
          </div>
          
          <h5>Employer Contribution</h5>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="edit-regular-ss-employer">Regular SS</label>
                <input type="number" class="form-control" id="edit-regular-ss-employer" name="regular_ss_employer" step="0.01" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="edit-mpf-employer">MPF</label>
                <input type="number" class="form-control" id="edit-mpf-employer" name="mpf_employer" step="0.01" value="0.00">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="edit-ec-employer">EC</label>
                <input type="number" class="form-control" id="edit-ec-employer" name="ec_employer" step="0.01" required>
              </div>
            </div>
          </div>
          
          <h5>Employee Contribution</h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-regular-ss-employee">Regular SS</label>
                <input type="number" class="form-control" id="edit-regular-ss-employee" name="regular_ss_employee" step="0.01" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-mpf-employee">MPF</label>
                <input type="number" class="form-control" id="edit-mpf-employee" name="mpf_employee" step="0.01" value="0.00">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="edit-sss-active">Status</label>
            <select class="form-control" id="edit-sss-active" name="active">
              <option value="yes">Active</option>
              <option value="no">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update SSS Contribution</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Security Modal for SSS Edit -->
<div class="modal fade" id="security_edit_sss" tabindex="-1" role="dialog" aria-labelledby="securityEditSSSLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="securityEditSSSLabel">Need to enter password</h4>
      </div>
      <form id="security-form-edit-sss">
        <div class="modal-body">
          <div class="form-group">
            <label for="security-pass-edit-sss">Password:</label>
            <input type="password" class="form-control" id="security-pass-edit-sss" name="password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
