
<div class="container mt-5">
    <h2>Cadastro de Produto</h2>
      <form>
          <div class="form-group">
              <label for="codBarrasCadastro">Código de Barras <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="codBarrasCadastro" name="codBarrasCadastro" required>
          </div>
          <div class="form-group">
              <label for="nomeProdutoCadastro">Nome do Produto <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="nomeProdutoCadastro" name="nomeProdutoCadastro" required>
          </div>
        
          <div class="form-group">
              <label for="qtdEstoqueCadastro">Quantidade em Estoque <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="qtdEstoqueCadastro" name="qtdEstoqueCadastro" required>
          </div>
          <div class="form-group">
              <label for="qtdEstoqueMinimoCadastro">Quantidade Mínima em Estoque <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="qtdEstoqueMinimoCadastro" name="qtdEstoqueMinimoCadastro" required>
          </div>
          <div class="form-group">
              <label for="obsCadastro">Observações</label>
              <textarea class="form-control" id="obsCadastro" name="obsCadastro" rows="3"></textarea>
          </div>
        
          <button type="button" class="btn" id="btnCadastrarProduto" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">Cadastrar</button>
      </form>
</div>


