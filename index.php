<?php
error_reporting(false);
  if (session_status() != PHP_SESSION_ACTIVE) session_start();
  if(!isset($_SESSION['empresacodigo'])) {
    header("location: /estoque/login.php");
  }

  include("../conexao.php");

  include("util.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Satisfação - Retaguarda</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  
  <link rel="icon" type="image/x-icon" href="dist/img/syspan.png">

  <link rel="stylesheet" href="dist/css/responsivetable.css">

  <style>
  
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<nav class="main-header navbar navbar-expand navbar-white navbar-light nao-aparece-pc">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <ul>

  </nav>
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/syspan.png" alt="Syspan" height="60" width="60">
  </div>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("./componentes/menu-sidebar.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="p-5">
      <?php 
        // Aqui é feito a inclusão da guia escolhida pelo usuário
        if ($_REQUEST['tab-celular'] == 1) {
          include("./paginas/celular.php");
        }
        else if($_REQUEST['tab-campanha'] == 1) {
          include("./paginas/campanha.php");
        }
        else if($_REQUEST['tab-perfil'] == 1) {
          include("./paginas/perfil.php");
        }
        else {
          include("./paginas/home.php"); 
        } 
      ?>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 1997-<?= date("Y"); ?> <a href="https://syspan.com.br/" style='color: black;' target='_blank'>Syspan - Soluções Tecnológicas</a>.</strong>
    Todos os direitos reservados.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- /.modal -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="./dist/js/pages/dashboard.js"></script> -->
<!-- Script Main -->


<script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="./plugins/qrcodejs/qrcode.min.js"></script>

<script src="js/main.js"></script>

<script src="js/mensagens.js"></script>

<script src="./plugins/jquery-validation/jquery.validate.js"></script>
<script src="./plugins/jquery-validation/additional-methods.js"></script>
<script src="./plugins/jquery-validation/localization/messages_pt_BR.js"></script>
<script src="./plugins/jquery-validation/localization/methods_pt.js"></script>
<script src="./plugins/jquery-mask/jquery.mask.js"></script>


<script>
</script>
<?php 
  include("controle_mensagens.php");
?>
</body>
</html>
