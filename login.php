<?php
  session_start();
  if(isset($_SESSION["empresacodigo"])) {
    header("location: /estoque");
  }
  include("estilos.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Syspan Satisfação - Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="icon" type="image/x-icon" href="dist/img/logo.png">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div style='text-align: center;'>
    <img src="./dist/img/logo.png" style="width: 100px; margin-bottom: 30px;"/>
  </div>

    <div class="card-header text-center">
      <a href="/" class="h3"><b style="font-family: var(--font-saira);color: var(--cor-de-destaque);" >InventorySolutions</b></a>
    </div>
  


      <form action="./services/login.php" method="post" id="formLogin">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock mostrar-senha"></span>
            </div>
          </div>
        </div>
      
        
        <div class="row">
          <!-- /.col -->
          <div class="col">
            <button type="submit" class="btn btn-block" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      

        <a href="./cadastro.php" style="color: black; text-decoration: underline #869104 !important">Ainda não tenho uma conta.</a>
      </form>
  
 
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- SweetAlert -->
<script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Mensagens -->
<script src="./js/mensagens.js"></script>

<script>
  $(".mostrar-senha").on("mouseover", function() {
    $(this).attr("class", "fas fa-eye mostrar-senha");
    $("#senha").attr("type", "text");
  });
  $(".mostrar-senha").on("mouseout", function() {
    $(this).attr("class", "fas fa-lock mostrar-senha");
    $("#senha").attr("type", "password");
  });

  // Fazer login na conta de demonstração
  $("#demonstracao").on("click", function() {
    $("#usuario").val("teste@syspan.com");
    $("#senha").val("teste");
    $("#formLogin").submit();
  });
</script>

<?php
  if(isset($_GET['erro']) and $_GET['erro'] == 1) {
    echo "<script>mensagem(\"error\", \"Usuário ou senha incorretos.\")</script>";
  }
  if(isset($_GET['erro']) and $_GET['erro'] == 2) {
    echo "<script>mensagem(\"error\", \"Você não tem acesso a este sistema. Caso tenha interesse, entre contato com a SYSPAN\")</script>";
  }
  
?>
</body>
</html>
