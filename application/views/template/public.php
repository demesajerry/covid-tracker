<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>COVID19-Tracker - Dashboard</title>
  <link rel="icon" href="<?php echo base_url('assets/images/lblogo.png'); ?>">

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/admin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!--CSS FOR DATATABLE-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css'); ?>" />
  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/admin2/css/sb-admin-2.min.css" rel="stylesheet">
  <!--CSS FOR DATATABLE-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css'); ?>" />
<link href="<?php echo base_url('assets/js/tree/Themes/smoothness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/tree/CSS/jHTree.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/tree/js/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/tree/js/jQuery.jHTree.js'); ?>"></script>
<script type="text/javascript">
$(function () {
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
   $(".sidebar").toggleClass("toggled");
  }
});
</script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <img src="<?php echo base_url('assets/images/lblogo.png'); ?>" height="45" width="45"/>
        <div class="sidebar-brand-text mx-3">COVID19-Tracker</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Statistics
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>public_info/list">
          <i class="fas fa-fw fa-user-plus"></i>
          <span>Confirmed Case</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>public_info/pui">
          <i class="fas fa-fw fa-user-lock"></i>
          <span>PUI</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>public_info/pum">
          <i class="fas fa-fw fa-user-circle"></i>
          <span>PUM</span></a>
      </li>
   
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow navbar-fixed-top">
                <!-- Sidebar Toggler (Sidebar) -->
        <button class="rounded-circle border-0" id="sidebarToggle"><i class="fa fa-bars"></i></button>
Ligtas Ang Bayan Laban sa Covid-19
        </nav>
        <!-- End of Topbar -->

    <?php  $this->load->view($content); ?>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; ICSO-LB 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

</body>

</html>

  <!--DatePicker-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<!--DATERANGE PICKER -->
<script src="<?php echo base_url(); ?>assets/js/daterange/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/daterange/daterangepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/daterange/daterangepicker.css">
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
  <!--call datatable print, pdf, excel button and select row required to be put after the datatable table -->
  <script type="text/javascript" src="<?php echo base_url('assets/datatables/datatables.min.js'); ?>"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>

<script src="<?php echo base_url('assets/croppie/croppie.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/croppie/croppie.css'); ?>" />
<script src="<?php echo base_url(); ?>assets/admin2/js/canvas.js"></script>
<link href="<?php echo base_url('assets/js/tree/Themes/ui-lightness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
