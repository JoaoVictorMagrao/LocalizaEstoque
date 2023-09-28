<?php
  include("estilos.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>InventorySolutions - Login</title>

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
  <link rel="icon" type="image/x-icon" href="dist/img/lg.png">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div style='text-align: center;'>
    <img src="./dist/img/lg.png" style="width: 100px; margin-bottom: 30px;"/>
  </div>

    <div class="card-header text-center">
      <a href="/" class="h3"><b style="font-family: var(--font-saira);color: var(--cor-de-destaque);" >InventorySolutions</b></a>
    </div>
  


      <form id="formLogin">
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
              <span class="fas fa-lock mostrarSenha"></span>
            </div>
          </div>
        </div>
      
        
        <div class="row">
          <!-- /.col -->
          <div class="col">
            <button type="button" class="btn btn-block" id="btnLogin" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">Entrar</button>
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
  $(".mostrarSenha").on("mouseover", function() {
    $(this).attr("class", "fas fa-eye mostrarSenha");
    $("#senha").attr("type", "text");
  });
  $(".mostrarSenha").on("mouseout", function() {
    $(this).attr("class", "fas fa-lock mostrarSenha");
    $("#senha").attr("type", "password");
  });

  $("#btnLogin").on("click", function() {

    var usuario = $('#usuario').val();
    var senha   = $('#senha').val();

    var jsonData = {
            "usuario": usuario,
            "senha": senha 
        };
    $.ajax({
            method: "POST",
            url: "/Estoque/services/login.php",
            contentType: "application/json",
            data: JSON.stringify(jsonData),
            success: function (data) {
               if (data.status) {
                 window.location.href = "./?tab-localizarProduto=1";
               } else {
                  mensagem("error", "Usuário ou senha incorretos.");
              }
            },
            error: function () {
                mensagem("error", "Algo de errado aconteceu na tentativa de efetuar o login. Tente novamente mais tarde.");
            }
        });
  });

</script>

</body>
</html>
