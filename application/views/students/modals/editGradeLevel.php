  <div id="editGradeLevelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Grade Level</h4>
          <input type="hidden" id="gradeLevelId">
        </div>
        <div class="modal-body">

          <ul class="nav nav-tabs mb-3" id="gradeLevelTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#student" role="tab" aria-controls="home" aria-selected="true">     Student
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="fetcher-tab" data-toggle="tab" href="#fetcher" role="tab" aria-controls="profile" aria-selected="false">
                Fetcher
              </a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="home-tab">
              <div class="form-group">
                <div class="row">
                  <div class="col-6 btnRotate" onClick="rotateImage()" style="width: 150px; height: 350px;">
                    <a href="#">
                      <img id="editStudentPhotoPreview" class="studentPhoto" style="width: 100%; height: 100%;">
                    </a>
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
                <label>Course</label>
                <select id="editCourse" class="form-control courseSelect">
                  <option></option>
                  <?php foreach($courses as $course): ?>
                    <option value="<?= $course->id ?>"><?= $course->course ?></option>
                  <?php endforeach; ?>
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
                <select id="editSchoolYearSelect" class="form-control schoolYearSelect">
                  <?php foreach($schoolYear as $sy): ?>
                    <option value="<?= $sy->id ?>"><?= $sy->school_year ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label>Guardian</label>
                <input type="text" id="editGuardian" class="form-control" autocomplete="off">
              </div>

              <div class="form-group">
                <label>Guardian Contact#</label>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">+63</span>
                  </div>              
                  <input type="text" id="editGuardianContact" class="form-control" autocomplete="off">
                </div>

              </div>

              <div class="form-group">
                <label>RF Card</label>
                <input type="text" id="editRFCard" class="form-control" autocomplete="off">
              </div>

              <div class="row">
                <div class="col-md-12 text-right">
                  <button type="button" class="btn btn-danger closeModalBtn" data-dismiss="modal">Close</button>
                  <button type="button" id="editGradeLevelBtn" class="btn btn-success">Proceed</button>                  
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="fetcher" role="tabpanel" aria-labelledby="fetcher-tab">
              <div class="form-group">
                <div class="row">
                  <div class="col-6" style="width: 150px; height: 200px;">
                    <img id="fetcherPhotoPreview" style="width: 100%; height: 100%;">
                  </div>
                  <div class="col-6">
                    <form id="uploadFetcherPhoto">
                        <input type="file" id="fetcherPhotoInput" name="fetcherPhotoFile">
                    </form>                
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-right">
                  <button type="button" class="btn btn-danger closeModalBtn" data-dismiss="modal">Close</button>
                  <button type="button" id="editFetcherBtn" class="btn btn-success">Proceed</button>                  
                </div>
              </div>
            </div> 

          </div>
        </div>

<!--         <div class="modal-footer">
          <button type="button" class="btn btn-danger closeModalBtn" data-dismiss="modal">Close</button>
          <button type="button" id="editGradeLevelBtn" class="btn btn-success">Proceed</button>
        </div> -->
      </div>
    </div>
  </div>