  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Students</a>
        </li>
      </ol>


      <!-- Nav tabs -->
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#personalInfo">Personal Info</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#gradeLevel">Enrollees</a>
        </li>
      </ul>


      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active container" id="personalInfo">
          
          <?php include('studentTable.php') ?>
          <?php include('modals/addStudent.php') ?>
          <?php include('modals/editStudent.php') ?>
          <?php include('modals/deleteStudent.php') ?>

        </div>
        <div class="tab-pane container" id="gradeLevel">
          
          <?php include ('gradeLevel.php') ?>
          <?php include ('modals/addGradeLevel.php') ?>
          <?php include ('modals/editGradeLevel.php')  ?>
          <?php include ('modals/deleteGradeLevel.php') ?>

        </div>
      </div>
    </div>
  </div>

  <script src="<?= base_url('assets/js/students/students.js') ?>"></script>
  <script src="<?= base_url('assets/js/students/gradeLevel.js') ?>"></script>