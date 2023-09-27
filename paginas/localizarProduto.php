<div class="container mt-5">
        <h2>Localizar Produto</h2>
        <form action="processar_cadastro.php" method="POST">
            <div class="form-group">
                <label for="ean">Código de Barras</label>
                <input type="text" class="form-control" id="codBarras" name="codBarras" required>
            </div>
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <button type="submit" class="btn" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">Procurar</button>
        </form>
             <!-- Card de Localização -->
    <div class="card mt-3">
        <div class="card-header" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">
            Localização
        </div>
        <div class="card-body" style="background-color: var(--cor-de-destaque-clara);">

            <div class="form-group">
                <label for="corredor">Corredor</label>
                <input type="text" disabled class="form-control" id="corredor" name="corredor">
            </div>

            <div class="form-group">
                <label for="coluna">Coluna</label>
                <input type="text" disabled class="form-control" id="coluna" name="coluna">
            </div>
            
            <div class="form-group">
                <label for="nivel">Nível</label>
                <input type="text" disabled class="form-control" id="nivel" name="nivel">
            </div>
        </div>
    </div>
           
           
       
    </div>
