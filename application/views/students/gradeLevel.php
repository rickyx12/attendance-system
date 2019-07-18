<div class="row mt-3 mb-3">
  <div class="col-md-6">
    <select id="schoolYearDefault" class="form-control w-50">
      <?php foreach($schoolYear as $sy): ?>
        <option value="<?= $sy->id ?>">
          <?= $sy->school_year ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-6 text-right">
    <button class="btn btn-success" data-toggle="modal" data-target="#newGradeLevelModal">New <i class="fa fa-plus"></i></button>
  </div>
</div>

<div class="row mt-2">
  <div class="col-md-12">
    <div class="table-responsive">
      <table id="gradeLevelTable" class="table table-bordered table-striped w-100">
        <thead>
          <tr>
            <th>Student</th>
            <th>Grade Level</th>
            <th>Schedule</th>
            <th>Course</th>
            <th></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>