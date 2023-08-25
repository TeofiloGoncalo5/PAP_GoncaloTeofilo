<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../Homepage/global.css">
  <script src="https://kit.fontawesome.com/a4ea18999d.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse fundo">

  <div class="wrapper">
    <!-- Main Sidebar Container -->

    <aside class="main-sidebar sidebar-dark-primary position-fixed elevation-4">

      <!-- Logo -->
      <?php
      if ($_SESSION['isAdmin'] == 0) :
      ?>
      <a href="/minha_PAP/Views/Homepage/Home.php" class="brand-link">
        <div style="text-align:center;">
          <img src="../../assets/img/mini-logo-sportscare.png" style="width:69px; height:54px;">
        </div>
      </a>
      <?php endif ?>
      <?php
      if ($_SESSION['isAdmin'] == 1) :
      ?>
      <a href="/minha_PAP/Views/Homepage/HomeAdmin.php" class="brand-link">
        <div style="text-align:center;">
          <img src="../../assets/img/mini-logo-sportscare.png" style="width:69px; height:54px;">
        </div>
      </a>
      <?php endif ?>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="/minha_PAP/Views/calendario/futebol.php" class="nav-link">
                <i class="fa-solid fa-calendar-days"></i>
                <p>
                  Calendario
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/minha_PAP/Views/noticias/Noticiaspage.php" class="nav-link">
                <i class="fa-solid fa-radio"></i>
                <p>
                  Noticias
                </p>
              </a>
            </li>
            <?php
            if ($_SESSION['isAdmin']) :
            ?>
              <li class="nav-item">
                <a href="/minha_PAP/Views/noticias/CriarNoticias.php" class="nav-link">
                  <i class="fa-solid fa-radio"></i>
                  <p>
                    Criar Noticias
                  </p>
                </a>
              </li>
            <?php endif ?>
            <li class="nav-item">
              <a href="javascript:apostasalert()" class="nav-link">
                <i class="fa-solid fa-clover"></i>
                <p>
                  Apostas
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/minha_PAP/Views/topmelhorescoisas/topmelhorescoisas.php" class="nav-link">
              <i class="fa-solid fa-comment"></i>
                <p>
                  Forum
                </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="position: absolute; bottom: 0;">
            <li class="nav-item">
              <a class="nav-link" href="../login/index.php?logout=1">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Logout</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
  </div>
</body>

</html>

<script>
  function apostasalert() {
    swal.fire({
      title: "Tens mais de 18 anos ?",
      text: "Lembre-se que tem de ter mais de 18 anos para apostar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: 'Sim Tenho',
      cancelButtonText: 'Não Tenho',
    }).then(function() {
      window.open("https://www.betclic.pt", "_blank")
    })

  }
</script>