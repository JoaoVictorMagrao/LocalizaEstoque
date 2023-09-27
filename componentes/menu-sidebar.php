<?php
  include("../estilos.php");
?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: var(--cor-de-destaque-escuro); color: var(--cor-de-texto);">
    <!-- Brand Logo -->
    <a href="#" target="_blank" class="brand-link">
      <img src="dist/img/lg.png" alt="Syspan Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">InventorySolutions</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: var(--cor-de-destaque-escuro); color: var(--cor-de-texto);">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="./services/sair.php" style="color: #ff4747; font-size: 15px; text-decoration: underline; font-weight:bold;">Sair</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="./?tab-cadastrarProduto=1" style="<?= ($_REQUEST['tab-cadastrarProduto'] == 1) ? "background-color: var(--cor-de-destaque); color: var(--cor-de-texto);" : ""; ?>" class="nav-link <?= ($_REQUEST['tab-cadastrarProduto'] == 1) ? "active" : ""; ?>">
              <i class="nav-icon far fa-smile"></i>
              <p>
                Cadastrar Produto
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./?tab-cadastrarLocalizacao=1" style="<?= ($_REQUEST['tab-cadastrarLocalizacao'] == 1) ? "background-color: var(--cor-de-destaque); color: var(--cor-de-texto);" : ""; ?>" class="nav-link <?= ($_REQUEST['tab-cadastrarLocalizacao'] == 1) ? "active" : "";?>">
              <i class="nav-icon fas fa-mobile"></i>
              <p>
                Informar Localização
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./?tab-localizarProduto=1" style="<?= ($_REQUEST['tab-localizarProduto'] == 1) ? "background-color: var(--cor-de-destaque); color: var(--cor-de-texto);" : ""; ?>" class="nav-link <?= ($_REQUEST['tab-localizarProduto'] == 1) ? "active" : "";?>">
              <i class="nav-icon fas fa-mobile"></i>
              <p>
                Localizar Produto
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./?tab-saidaProduto=1" style="<?= ($_REQUEST['tab-saidaProduto'] == 1) ? "background-color: var(--cor-de-destaque); color: var(--cor-de-texto);" : ""; ?>" class="nav-link <?= ($_REQUEST['tab-saidaProduto'] == 1) ? "active" : "";?>">
              <i class="nav-icon fas fa-mobile"></i>
              <p>
                Saida do produto
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./?tab-perfil=1" style="<?= ($_REQUEST['tab-perfil'] == 1) ? "background-color: var(--cor-de-destaque); color: var(--cor-de-texto);" : ""; ?>"  class="nav-link <?= ($_REQUEST['tab-perfil'] == 1) ? "active" : "";?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Perfil
              </p>
            </a>
          </li>
        </ul>
      </nav>
     
  </aside>