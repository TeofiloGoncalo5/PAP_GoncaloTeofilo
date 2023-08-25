<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

include_once '../../config.php';
include_once '../../db.php';

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../assets/plugins/summernote/summernote-bs4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
  <link rel="icon" href="../../assets/img/logo-sports.png">
  <!-- Option 1: Include in HTML -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <script src="https://kit.fontawesome.com/a4ea18999d.js" crossorigin="anonymous"></script>
</head>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/minha_PAP/Views/Homepage/Home.php" class="nav-link">Página Principal</a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <i class="fa-solid fa-user-gear"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <li class="user-header bg-primary" style="height: 90px;">
          <h4 id="name2"></h4>
          <p id="Tipo"></p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <a class="btn btn-default btn-flat" data-toggle="modal" data-target="#new_pssw_modal">Mudar Password</a>
          <a class="btn btn-default btn-flat float-right" href="/minha_PAP/Views/perfil/perfilpage.php">Perfil</a>
        </li>
      </ul>
    </li>
  </ul>
</nav>

<div class="modal fade" id="new_pssw_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Mudar de Password</h3>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Password Antiga:</label>
              <input type="password" class="form-control" id="oldpsw" name="old-password">
            </div>
            <div class="form-group">
              <label>Nova Password:</label>
              <input type="password" class="form-control" id="newpsw" name="new-password">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="savePssw">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
  $('#savePssw').on('click', function() {
    var oldPssw = $('#oldpsw').val();
    var newPssw = $('#newpsw').val();
    $.ajax({
      url: "<?= $global_configs['SERVER_URL'] ?>/api/verify_psw_change.php",
      method: 'POST',
      data: {
        "oldpsw": oldPssw,
        "newpsw": newPssw
      }
    }).done(function(res) {
      console.log(res);
      res = JSON.parse(res);
      toastr[res.status](res.message);
    }).fail(function(res) {
      try {
        res = JSON.parse(res.responseText);
        toastr[res.status](res.message);
      } catch (e) {
        toastr.error("An error occurred while processing the request.");
      }
    });
  });
</script>