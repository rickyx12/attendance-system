<div id="content-wrapper">

  <div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Settings</a>
      </li>

      <li class="breadcrumb-item">
        <a href="#">Students per Course</a>
      </li>
    </ol>

    <div class="row">
      <div class="col-md-4">
        <select id="courseSelect" class="form-control">
          <option>Select Course</option>
          <?php foreach($courses as $course): ?>
            <option value="<?= $course->id ?>"><?= $course->course ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="schoolYearSelect" class="form-control">
          <?php foreach($schoolYear as $sy): ?>
            <option value="<?= $sy->id ?>"><?= $sy->school_year ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <button id="reportBtn" class="btn btn-success">Proceed</button>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="courseTable" class="table table-bordered table-striped w-100">
            <thead>
              <tr>
                <th>Name</th>
                <th>Section</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/settings/courseStudent.js') ?>"></script>

