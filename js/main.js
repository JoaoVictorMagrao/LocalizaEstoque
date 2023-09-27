

$(document).ready(function() {
  
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