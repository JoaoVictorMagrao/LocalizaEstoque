

$(document).ready(function() {

  $("#btnCadastrarProduto").on("click", function() {
   
    var codBarras          = $('#codBarrasCadastro').val();
    var nomeProduto        = $('#nomeProdutoCadastro').val();
    var qtdEstoque         = $('#qtdEstoqueCadastro').val();
    var qtdEstoqueMenimo   = $('#qtdEstoqueMinimoCadastro').val();
    var obs                = $('#obsCadastro').val();
   
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
                mensagem("sucess", data.mensagem);
               } else {
                mensagem("error", data.mensagem);
                }
            },
            error: function () {
                mensagem("error", "Algo de errado aconteceu na tentativa de efetuar o login. Tente novamente mais tarde.");
            }
        });
  });

  $("#btnCadastrarLocalizacao").on("click", function() {
  
   // var idProduto = $('#idProduto').val();
    var corredor    = $('#corredorLocalizacao').val();
    var coluna      = $('#colunaLocalizacao').val();
    var nivel       = $('#nivelLocalizacao').val();
   
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
                mensagem("sucess", data.mensagem);
               } else {
                mensagem("error", data.mensagem);
                }
            },
            error: function () {
                mensagem("error", "Algo de errado aconteceu na tentativa de efetuar o login. Tente novamente mais tarde.");
            }
        });
  });
  
  
    // Dados de exemplo (substitua isso com seus próprios dados)
    var produtos = ['Produto 1', 'Produto 2', 'Produto 3', 'Produto 4', 'Produto 5'];

    // Configurar o Bloodhound
    var produtosBloodhound = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: produtos
    });

    // Inicializar o Typeahead.js
    $('#nomeProdutoLocaliza').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'produtos',
        source: produtosBloodhound
    });
});