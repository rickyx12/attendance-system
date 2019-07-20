  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Settings</a>
        </li>

        <li class="breadcrumb-item">
          <a href="#">Users</a>
        </li>
      </ol>

      <?php include('usersTable.php') ?>
      <?php include('modals/add.php') ?>
      <?php include('modals/delete.php') ?>
 
    </div>
  </div>

  <script src="<?= base_url('assets/js/settings/users.js') ?>"></script>

