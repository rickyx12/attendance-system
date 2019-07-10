  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Settings / Section</a>
        </li>

        <li class="breadcrumb-item">
          <a href="#">Grade Level</a>
        </li>
      </ol>

      <?php include('sectionTable.php') ?>
      <?php include('modals/add.php') ?>
      <?php include('modals/edit.php') ?>
      <?php include('modals/delete.php') ?>

    </div>
  </div>

  <script src="<?= base_url('assets/js/settings/section.js') ?>"></script>

