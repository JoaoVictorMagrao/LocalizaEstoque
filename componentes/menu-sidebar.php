  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" target="_blank" class="brand-link">
      <img src="dist/img/logo.png" alt="Syspan Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">InventorySolutions</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="./?tab-perfil=1" class="d-block"><?= $_SESSION['cliente'] ?></a>
          <a href="./services/sair.php" style="color: #ff4747; font-size: 15px; text-decoration: underline;">Sair</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="./?tab-campanha=1" class="nav-link <?= ($_REQUEST['tab-campanha'] == 1) ? "active" : ""; ?>">
              <i class="nav-icon far fa-smile"></i>
              <p>
                Campanhas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./?tab-celular=1" class="nav-link <?= ($_REQUEST['tab-celular'] == 1) ? "active" : "";?>">
              <i class="nav-icon fas fa-mobile"></i>
              <p>
                Dispositivos
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./" class="nav-link <?= ($_REQUEST == array()) ? "active" : "";?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./?tab-perfil=1" class="nav-link <?= ($_REQUEST['tab-perfil'] == 1) ? "active" : "";?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Perfil
              </p>
            </a>
          </li>
        </ul>
      </nav>
     
  </aside>