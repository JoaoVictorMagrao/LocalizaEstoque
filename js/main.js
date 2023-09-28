

$(document).ready(function() {

  /* ------------------------------ PAGINA LOCALIZAR PRODUTO ------------------------------*/
  var produtoData = {};

$.ajax({
    url: '/Estoque/services/listaProdutos.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        if (response.status) {
            $.each(response.produtos, function(index, produto) {
                produtoData[produto.nome] = produto.id;
            });

            // Inicialize o autocompletar após receber os dados
            $(function() {
                $("#nomeProduto").autocomplete({
                    source: Object.keys(produtoData),
                    select: function(event, ui) {
                        var selectedProdutoNome = ui.item.value;
                        var selectedProdutoID = produtoData[selectedProdutoNome];
                        
                    }
                });
            });

            console.log(produtoData);
        } else {
            console.error('Erro na resposta do servidor:', response.mensagem);
        }
    },
    error: function() {
        console.error('Erro na requisição AJAX');
    }
});

 /* ------------------------------ FIM PAGINA LOCALIZAR PRODUTO ------------------------------*/


  /* ------------------------------ PAGINA CADASTRAR PRODUTO ------------------------------*/
  $("#btnCadastrarProduto").on("click", function() {

    var codBarras          = $('#codBarrasCadastro').val();
    var nomeProduto        = $('#nomeProdutoCadastro').val();
    var qtdEstoque         = $('#qtdEstoqueCadastro').val();
    var qtdEstoqueMenimo   = $('#qtdEstoqueMinimoCadastro').val();
    var obs                = $('#obsCadastro').val();
   
    if(codBarras == '' || nomeProduto == '' || obs == ''){
      mensagem("warning", "Preencha todos os campos obrigatórios.");
    }else{
        var jsonData = {
                "codBarras": codBarras,
                "nomeProduto": nomeProduto,
                "qtdEstoque": qtdEstoque,
                "qtdMinimaEstoque": qtdEstoqueMenimo,
                "obs": obs
            };
        $.ajax({
            method: "POST",
            url: "/Estoque/services/cadastroProduto.php",
            contentType: "application/json",
            data: JSON.stringify(jsonData),
            success: function (data) {
              if (data.status) {
                  $('#codBarrasCadastro').val('');
                  $('#nomeProdutoCadastro').val('');
                  $('#qtdEstoqueCadastro').val('');
                  $('#qtdEstoqueMinimoCadastro').val('');
                  $('#obsCadastro').val('');
                mensagem("success", data.mensagem);
              } else {
                mensagem("error", data.mensagem);
                }
            },
            error: function () {
                mensagem("error", "Algo de errado aconteceu na tentativa de cadastrar o produto. Tente novamente mais tarde.");
            }
          });
    } //FIM ELSE
  });
 /* ------------------------------ FIM PAGINA CADASTRAR PRODUTO ------------------------------*/

  /* ------------------------------ PAGINA CADASTRAR LOCALIZACAO DO PRODUTO ------------------------------*/
  $("#btnCadastrarLocalizacao").on("click", function() {
  
   // var idProduto = $('#idProduto').val();
    var corredor    = $('#corredorLocalizacao').val();
    var coluna      = $('#colunaLocalizacao').val();
    var nivel       = $('#nivelLocalizacao').val();
    if(corredor == '' || coluna == '' || nivel == ''){
      mensagem("warning", "Preencha todos os campos obrigatórios.");
    }else{
    var jsonData = {
            "idProduto": 1,
            "corredor": corredor,
            "coluna": coluna,
            "nivel": nivel
        };
    $.ajax({
            method: "POST",
            url: "/Estoque/services/cadastroLocalizacao.php",
            contentType: "application/json",
            data: JSON.stringify(jsonData),
            success: function (data) {
              console.log(data.status);
               if (data.status) {
                  $('#corredorLocalizacao').val('');
                  $('#colunaLocalizacao').val('');
                  $('#nivelLocalizacao').val('');
                mensagem("success", data.mensagem);
               } else {
                mensagem("error", data.mensagem);
                }
            },
            error: function () {
                mensagem("error", "Algo de errado aconteceu na tentativa de cadastrar o produto. Tente novamente mais tarde.");
            }
        });
      } //FIM ELSE
  });
   /* ------------------------------ FIM PAGINA CADASTRAR LOCALIZACAO DO PRODUTO ------------------------------*/
 
});