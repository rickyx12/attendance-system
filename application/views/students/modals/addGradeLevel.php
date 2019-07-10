  <div id="newGradeLevelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Grade Level</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-6" style="width: 150px; height: 150px;">
                <img id="studentPhotoPreview" style="width: 100%; height: 100%;">
              </div>
              <div class="col-6">
                <form id="uploadStudentPhoto">
                    <input type="file" id="studentPhotoInput" name="studentPhotoFile" id="fileToUpload">
                </form>                
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Student</label>
              <select id="students-list" class="form-control" style="width: 100%">
                <option></option>
              </select>
          </div>
          <div class="form-group">
            <label>Grade Level</label>
            <select id="gradeLevelSelect" class="form-control gradeLevelSelect">
              <option></option>
              <?php foreach($gradeLevel as $grade): ?>
                <option value="<?= $grade->id ?>"><?= $grade->grade_level ?></option>
              <?php endforeach; ?>
            </select>
          </div> 
          <div class="form-group">
            <label>Section</label>
            <select id="section" class="form-control sectionSelect">
              <option></option>
            </select>
          </div>             
          <div class="form-group">
            <label>Schedule</label>
            <div class="row">
              <div class="col-6">
                <div class="input-group date" id="scheduleFrom" data-target-input="nearest">
                    <input type="text" id="timein" class="form-control datetimepicker-input" data-target="#scheduleFrom"/>
                    <div class="input-group-append" data-target="#scheduleFrom" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
              </div>
              <div class="col-6">
                <div class="input-group date" id="scheduleTo" data-target-input="nearest">
                    <input type="text" id="timeout" class="form-control datetimepicker-input" data-target="#scheduleTo"/>
                    <div class="input-group-append" data-target="#scheduleTo" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>School Year</label>
            <input type="text" id="schoolYear" class="form-control" autocomplete="off">
          </div>

          <div class="form-group">
            <label>Guardian</label>
            <input type="text" id="guardian" class="form-control" autocomplete="off">
          </div>

          <div class="form-group">
            <label>Contact#</label>
            <input type="text" id="guardianContact" class="form-control" autocomplete="off">
          </div>

          <div class="form-group">
            <label>RF Card</label>
            <input type="text" id="rfCard" class="form-control" autocomplete="off">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" id="newGradeLevelBtn" class="btn btn-success">Proceed</button>
        </div>
      </div>

    </div>
  </div>