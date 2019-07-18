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
              <a href="<?= base_url('Settings/sectionStudents') ?>">Students per Sections</a>
              <br>
              <label style="font-size:13px;">View all students on every section</label>
            </div>
          </div>        
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/schoolYear') ?>">School Year</a>
              <br>
              <label style="font-size:13px;">Add / Edit / Delete School Year.</label>
            </div>
          </div>
        </div>

        <div class="col-6">      
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/absences') ?>">Absences</a>
              <br>
              <label style="font-size:13px;">View all absent student in a specific period.</label>
            </div>
          </div>
        </div>
      </div>


      <div class="row mt-2">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Course/index') ?>">Course</a>
              <br>
              <label style="font-size:13px;">Add / Edit / Delete Course.</label>
            </div>
          </div>
        </div>

        <div class="col-6">  

          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/lates') ?>">Lates</a>
              <br>
              <label style="font-size:13px;">View all late student in a specific period.</label>
            </div>
          </div>

        </div>
      </div>


      <div class="row mt-2">
        <div class="col-6">

          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/courseStudents') ?>">Students Per Course</a>
              <br>
              <label style="font-size:13px;">View all students on every grade level.</label>
            </div>
          </div>

        </div>

        <div class="col-6">  

          <div class="card">
            <div class="card-body">
              <a href="<?= base_url('Settings/attendance') ?>">Attendance</a>
              <br>
              <label style="font-size:13px;">View attendance of specific student.</label>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

