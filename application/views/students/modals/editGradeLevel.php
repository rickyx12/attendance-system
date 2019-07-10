  <div id="editGradeLevelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Grade Level</h4>
          <input type="hidden" id="gradeLevelId">
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-6" style="width: 150px; height: 150px;">
                <img id="editStudentPhotoPreview" style="width: 100%; height: 100%;">
              </div>
              <div class="col-6">
                <form id="editUploadStudentPhoto">
                    <input type="file" id="editStudentPhotoInput" name="editStudentPhotoFile" id="fileToUpload">
                </form>                
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Student</label>
              <select id="edit-students-list" class="form-control" style="width: 100%">
                <option></option>
              </select>
          </div>

          <div class="form-group">
            <label>Grade Level</label>
            <select id="editGradeLevelSelect" class="form-control gradeLevelSelect">
              <?php foreach($gradeLevel as $grade): ?>
              	<option value="<?= $grade->id ?>"><?= $grade->grade_level ?></option>
              <?php endforeach; ?>
            </select>
          </div>     

          <div class="form-group">
            <label>Section</label>
            <select id="editSection" class="form-control sectionSelect">
              <option></option>
            </select>
          </div>

          <div class="form-group">
            <label>Schedule</label>
            <div class="row">
              <div class="col-6">
                <div class="input-group date" id="editScheduleFrom" data-target-input="nearest">
                    <input type="text" id="editScheduleFrom1" class="form-control datetimepicker-input" data-target="#editScheduleFrom"/>
                    <div class="input-group-append" data-target="#editScheduleFrom" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
              </div>
              <div class="col-6">
                <div class="input-group date" id="editScheduleTo" data-target-input="nearest">
                    <input type="text" id="editScheduleTo1" class="form-control datetimepicker-input" data-target="#editScheduleTo"/>
                    <div class="input-group-append" data-target="#editScheduleTo" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>School Year</label>
            <input type="text" id="editSchoolYear" class="form-control" autocomplete="off">
          </div>

          <div class="form-group">
            <label>Guardian</label>
            <input type="text" id="editGuardian" class="form-control" autocomplete="off">
          </div>

          <div class="form-group">
            <label>Contact#</label>
            <input type="text" id="editGuardianContact" class="form-control" autocomplete="off">
          </div>

          <div class="form-group">
            <label>RF Card</label>
            <input type="text" id="editRFCard" class="form-control" autocomplete="off">
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" id="editGradeLevelBtn" class="btn btn-success">Proceed</button>
        </div>
      </div>

    </div>
  </div>