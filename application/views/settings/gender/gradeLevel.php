<div id="content-wrapper">

  <div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Settings</a>
      </li>

      <li class="breadcrumb-item">
        <a href="#">Gender per Grade Level</a>
      </li>
    </ol>

    <div class="row">
      <div class="col-md-4">
        <select id="gradeLevelSelect" class="form-control">
          <option>Select Grade Level</option>
          <?php foreach($gradeLevel as $level): ?>
            <option value="<?= $level->id ?>"><?= $level->grade_level ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2">
        <select id="genderSelect" class="form-control">
          <option>Select Gender</option>
            <option value="male">male</option>
            <option value="female">female</option>
        </select>
      </div>
      <div class="col-md-3">
        <select id="schoolYearSelect" class="form-control">
          <?php foreach($schoolYear as $sy): ?>
            <option value="<?= $sy->id ?>"><?= $sy->school_year ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <button id="reportBtn" class="btn btn-success">Proceed</button>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="sectionTable" class="table table-bordered table-striped w-100">
            <thead>
              <tr>
                <th>Name</th>
                <th>Section</th>
                <th>Course</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>


  </div>
</div>

<script src="<?= base_url('assets/js/settings/genderPerGradeLevel.js') ?>"></script>

