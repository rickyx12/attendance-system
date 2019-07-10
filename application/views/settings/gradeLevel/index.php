  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Settings</a>
        </li>

        <li class="breadcrumb-item">
          <a href="#">Grade Level</a>
        </li>
      </ol>

      <?php include('gradeLevelTable.php') ?>
      <?php include('modals/add.php') ?>
      <?php include('modals/edit.php') ?>
      <?php include('modals/delete.php') ?>

    </div>
  </div>

  <script src="<?= base_url('assets/js/settings/gradeLevel.js') ?>"></script>

