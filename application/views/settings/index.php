  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Settings</a>
        </li>
      </ol>

      <div class="row">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/gradeLevel') ?>">Grade Level</a>
              <br>
              <label style="font-size:13px;">Add / View / Delete a Grade Level for Students.</label>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/gradeLevelStudents') ?>">Students per Grade Level</a>
              <br>
              <label style="font-size:13px;">View all students on every grade level</label>
            </div>
          </div>          
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/section') ?>">Sections</a>
              <br>
              <label style="font-size:13px;">Add / View / Delete a Sections for Students.</label>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/sectionStudents') ?>">Student per Sections</a>
              <br>
              <label style="font-size:13px;">View all students on every section</label>
            </div>
          </div>        
        </div>
      </div>

    </div>
  </div>

