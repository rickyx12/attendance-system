  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Settings</a>
        </li>

        <li class="breadcrumb-item">
          <a href="#">Attendance</a>
        </li>
      </ol>


      <div class="row">
        <div class="col-md-4">
          <select id="students-list" class="form-control" style="width: 100%">
            <option></option>
          </select>
          <input name="dates" class="form-control mt-2">
        </div>
        <div class="col-md-8">
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-md-12">
          
          <div class="table-responsive">
            <table id="attendanceTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Day</th>
                  <th>Schedule</th>
                  <th>Time tap</th>
                  <th>Type</th>
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <input type="hidden" id="studentName">
          </div>

        </div>
      </div>


    </div>
  </div>

  <script src="<?= base_url('assets/js/settings/attendance.js') ?>"></script>