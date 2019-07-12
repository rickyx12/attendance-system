  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Settings</a>
        </li>

        <li class="breadcrumb-item">
          <a href="#">Absences</a>
        </li>
      </ol>


      <div class="row">
        <div class="col-md-3">
          <input name="dates" class="form-control">
        </div>
        <div class="col-md-9"></div>
      </div>

      <br>

      <div class="row">
        <div class="col-md-12">
          
          <div class="table-responsive">
            <table id="absencesTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Grade</th>
                  <th>Section</th>
                  <th>Date</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
      </div>


    </div>
  </div>

  <script src="<?= base_url('assets/js/settings/absences.js') ?>"></script>