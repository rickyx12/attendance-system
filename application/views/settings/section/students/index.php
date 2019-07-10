<div id="content-wrapper">

  <div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Settings</a>
      </li>

      <li class="breadcrumb-item">
        <a href="#">Students per Section</a>
      </li>
    </ol>

    <div class="row">
      <div class="col-md-4">
        <select id="sectionSelect" class="form-control">
          <option>Select Section</option>
          <?php foreach($sections as $section): ?>
            <option value="<?= $section->id ?>"><?= $section->section ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-8">
        
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="studentsTable" class="table table-bordered table-striped w-100">
            <thead>
              <tr>
                <th>Name</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>


  </div>
</div>

<script src="<?= base_url('assets/js/settings/sectionStudent.js') ?>"></script>

