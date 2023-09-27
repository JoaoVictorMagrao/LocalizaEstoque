<?php

  session_start();
  if(isset($_SESSION["empresacodigo"])) {
    header("location: /retaguarda");
  }
  include("estilos.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Syspan Satisfação - Cadastro</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.css">
  <link rel="stylesheet" href="./dist/css/responsivetable.css">
</head>
<body class="hold-transition">
<!--<div class="register-box">-->

     
      <div class="card-body mx-auto" style="width:90%">

        <form class="form-cadastro">
          <div class="section-signup" style="background-color: var(--cor-de-destaque);color: var(--cor-de-texto);">
            INFORMAÇÕES GERAIS
          </div>
          <!-- <div class="input-group mb-3">
            <select class="form-control" name="tipo_cadastro" id="tipo_cadastro">
              <option value="1">Pessoa Jurídica</option>
              <option value="0">Pessoa Física</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-card"></span>
              </div>
            </div>
          </div> -->
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Razão Social" name="razao_social" id="razao_social">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-card"></span>
              </div>
            </div>
          </div>
          
          <div class="input-group mb-3 cnpj-div">
            <input type="text" class="form-control" placeholder="CNPJ" name="cnpj" id="cnpj">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-card"></span>
              </div>
            </div>
          </div>
          
          <div class="input-group mb-3 cpf-div">
            <input type="text" class="form-control" placeholder="CPF" name="cpf" id="cpf">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-card"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Celular" name="celular" id="celular">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-mobile"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Telefone" name="telefone" id="telefone">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="section-signup" style="background-color: var(--cor-de-destaque);color: var(--cor-de-texto);">DADOS PARA ACESSO</div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Usuário" name="usuario" id="usuario">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Senha" name="senha_cad" id="senha_cad">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirme sua senha" name="confirmar_senha" id="confirmar_senha">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="d-flex justify-content-center w-100 ">
              <button type="submit" style="background-color: var(--cor-de-destaque);color: var(--cor-de-texto);" class="btn w-25">Cadastrar</button>
            </div>
            
            <div class="d-flex justify-content-center w-100 ">
             <a href="./login.php" class="text-center" style="color: black; text-decoration: underline #869104 !important">Já tenho uma conta</a>
            </div>
            <!-- /.col -->
          </div>
        </form>

        
      </div>
      <!-- /.form-box -->
  

<!--</div>-->
<!-- /.register-box -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>

<script src="./plugins/jquery-validation/jquery.validate.js"></script>
<script src="./plugins/jquery-validation/additional-methods.js"></script>
<script src="./plugins/jquery-validation/localization/messages_pt_BR.js"></script>
<script src="./plugins/jquery-validation/localization/methods_pt.js"></script>
<script src="./plugins/jquery-mask/jquery.mask.js"></script>

<script>
  $(".cpf-div").hide();
		$("#tipo_cadastro").on("change", function() {
			if($(this).val() == 1) {
				$("#razao_social").attr("placeholder", "Razão Social");
				$(".cpf-div").hide();
				$(".cnpj-div").show();
        $("#cpf").val("");
			}
			else {
				$("#razao_social").attr("placeholder", "Nome");
				$(".cpf-div").show();
				$(".cnpj-div").hide();
        $("#cnpj").val("");
			}
	});

  // CADASTRO

		// Validando os campos de cadastro
		$(".form-cadastro").validate({
      errorElement: "div",
			errorPlacement: function(error, element) {
				error.css('color', '#cf0202');
				error.insertBefore(element.parent());
			},
			rules: {
				razao_social: {
					required: true,
					minlength: 3
				},
				senha_cad: {
					required: true,
					minlength: 6
				},
				confirmar_senha: {
					required: true,
					equalTo: "#senha_cad"
				},
				cnpj: {
					required: true,
					cnpj: true
					// Criar validador para cnpj
				},
				telefone: {
					required: false,
					telefone: true
					// Criar validador para telefone
				},
				celular: {
					required: true,
					celular: true
					// Criar validador para celular
				},
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				razao_social: {
					required: "Digite seu nome ou razão social de sua empresa",
					minlength: "Digite o nome com pelo menos 3 caracteres"
				},
				senha_cad: {
					required: "Digite sua nova senha",
					minlength: "Digite sua nova senha com pelo menos 6 caracteres"
				},
				confirmar_senha: {
					required: "Confirme sua nova senha",
					equalTo: "Confirmação não bate com a senha"
				},
				cnpj: {
					required: "Digite seu CNPJ",
					cnpj: "Informe um CNPJ válido"
					// Criar validador para cnpj
				},
				telefone: {
					required: "Digite seu telefone",
					telefone: "Informe um telefone válido"
					// Criar validador para telefone
				},
				celular: {
					required: "Digite seu celular",
					celular: "Informe um celular válido"
					// Criar validador para celular
				},
				email: {
					required: "Digite seu e-mail",
					email: "Insira um e-mail válido"
				}
			},
			submitHandler: function() {
				let razaoSocial = $("#razao_social").val();
				let telefone = $("#telefone").val();
				let celular = $("#celular").val();
				let email = $("#email").val();
				let senha = $("#senha_cad").val();
				let cnpj = $("#cnpj").val();
				let cpf = $("#cpf").val();
				$.ajax({
					method: "GET",
					url: "https://satisfacao.syspanweb.com.br/services/cadastro.php?razao_social="+razaoSocial+"&telefone="+telefone+"&celular="+celular+"&email="+email+"&senha="+senha+"&cnpj="+cnpj+"&cpf="+cpf,
					success: function(data) {
						if(data.status) {
							alert("Cadastro realizado com sucesso!");
							
              location.href="/retaguarda/login.php";
						}
						else {
							alert(data.mensagem);
 						}
					},
					error: function() {
						alert("Algo de errado aconteceu no cadastro. Tente novamente mais tarde.");
					}
				});
			}
		});

		// Adicionando máscara aos campos
		$("#cpf").mask('000.000.000-00', {reverse: true});
		$("#cnpj").mask("99.999.999/9999-99");
		$("#telefone").add("#celular").mask("(99) 9999-99999")
    .focusout(function (event) {  
        var target, phone, element;  
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
        phone = target.value.replace(/\D/g, '');
        element = $(target);  
        element.unmask();  
        if(phone.length > 10) {  
            element.mask("(99) 99999-9999");  
        } else {  
            element.mask("(99) 9999-99999");  
        }  
    });

</script>
</body>
</html>
