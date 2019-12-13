  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Import</a>
        </li>
      </ol>

      <!-- Nav tabs -->
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#newStudent">New Student</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#existingStudent">Existing Student</a>
        </li>
      </ul>

       <!-- Tab panes -->
      <div class="tab-content">

         <div class="tab-pane active container mt-3" id="newStudent">
            <div class="row">
              <div class="col-md-12" id="importFrm">
                  <form id="csvUpload">
                      <input type="file" name="csvFile" />
                      <input type="button" class="btn btn-primary" id="importBtn" name="importSubmit" value="IMPORT">
                  </form>
              </div>
            </div>

            <span id="status"></span>
            
            <br><br>
            <span id="newSuccess"><h3>Success Import</h3></span>

            <br>
            <br>
            <span id="newDenied"><h3>Denied Import</h3></span>
          </div>
          <div class="tab-pane container mt-3" id="existingStudent">
            <div class="row">
              <div class="col-md-12" id="importFrm">
                  <form id="existingCsvUpload">
                      <input type="file" name="existingCsvFile" />
                      <input type="button" class="btn btn-primary" id="importGradeLevelBtn" name="importSubmit" value="IMPORT">
                  </form>
              </div>
            </div>            

            <span id="status"></span>
            
            <br><br>
            <span id="existingSuccess"><h3>Success Import</h3></span>

            <br>
            <br>
            <span id="existingDenied"><h3>Denied Import</h3></span>
          </div>
      </div>



    </div>
  </div>

<script src="<?= base_url('assets/js/settings/import.js') ?>"></script>
