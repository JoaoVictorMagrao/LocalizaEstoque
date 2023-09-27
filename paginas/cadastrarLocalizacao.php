
<div class="container mt-5">
        <h2>Informar Localização</h2>
        <form action="processar_cadastro.php" method="POST">
            <div class="d-flex justify-content-between" style="gap:5%;">
                <div class="form-group w-50">
                    <label for="ean">Código de Barras</label>
                    <input type="text" class="form-control" id="codBarras" name="codBarras" required>
                </div>
                <div class="form-group w-50">
                    <label for="nomeProdutoLocaliza">Nome do Produto</label>
                    <input type="text" class="form-control" id="nomeProdutoLocaliza" name="nomeProdutoLocaliza">
                </div>
            </div>
            <h2>Localização</h2>

            <div class="d-flex justify-content-between" style="gap:5%;">
                <div class="form-group w-25">
                    <label for="ean">Código de Barras</label>
                    <input type="text" class="form-control" id="codBarras" name="codBarras" required>
                </div>
                <div class="form-group w-25">
                    <label for="ean">Código de Barras</label>
                    <input type="text" class="form-control" id="codBarras" name="codBarras" required>
                </div>

                <div class="form-group w-25">
                    <label for="ean">Código de Barras</label>
                    <input type="text" class="form-control" id="codBarras" name="codBarras" required>
                </div>
            </div>
           
            <button type="submit" class="btn" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">Cadastrar</button>
        </form>
    </div>



