<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Attendance System</title>

  <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
  <link rel="icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <!-- <link href="../assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet"> -->

  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/vendor/css/sb-admin.css') ?>" rel="stylesheet">
 	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/tempusdominus-bootstrap-4.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/select2.min.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/jquery.dataTables.min.css') ?>" rel="stylesheet" />

  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/select2.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/buttons.flash.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/jszip.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/pdfmake.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/vfs_fonts.js') ?>"></script>
  <script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/misc.js') ?>"></script>
  
</head>

<body id="page-top" data-urlbase="<?= base_url() ?>">

<?php include('navbar.php') ?>
<?php include('sidebar.php') ?>