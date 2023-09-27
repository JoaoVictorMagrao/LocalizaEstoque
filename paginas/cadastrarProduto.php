
<div class="container mt-5">
        <h2>Cadastro de Produto</h2>
        <form action="processar_cadastro.php" method="POST">
            <div class="form-group">
                <label for="ean">Código de Barras</label>
                <input type="text" class="form-control" id="codBarras" name="codBarras" required>
            </div>
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
           
            <div class="form-group">
                <label for="qtdEstoque">Quantidade em Estoque</label>
                <input type="number" class="form-control" id="qtdEstoque" name="qtdEstoque" required>
            </div>
            <div class="form-group">
                <label for="qtdEstoqueMinimo">Quantidade Mínima em Estoque</label>
                <input type="number" class="form-control" id="qtdEstoqueMinimo" name="qtdEstoqueMinimo" required>
            </div>
            <div class="form-group">
                <label for="obs">Observações</label>
                <textarea class="form-control" id="obs" name="obs" rows="3"></textarea>
            </div>
           
            <button type="submit" class="btn" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">Cadastrar</button>
        </form>
    </div>


