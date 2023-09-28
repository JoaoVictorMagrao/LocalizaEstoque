<?php
include("../../conexao_estoque.php");


?>
<div class="container mt-5">
        <h2>Informar Localização</h2>
        <form action="processar_cadastro.php" method="POST">
            <div class="d-flex justify-content-between" style="gap:5%;">
                <div class="form-group w-50">
                    <label for="codBarrasLocalizacao">Código de Barras</label>
                    <input type="text" class="form-control" id="codBarrasLocalizacao" name="codBarrasLocalizacao" required>
                </div>
                <!-- <div class="form-group w-50">
                    <label for="nomeProdutoLocalizao">Nome do Produto</label>
                    <input type="text" class="form-control typeahead" id="nomeProdutoLocalizao" name="nomeProdutoLocalizao">
                </div> -->
            </div>
            <h2>Localização</h2>

            <div class="d-flex justify-content-between" style="gap:5%;">
                <div class="form-group w-25">
                    <label for="corredorLocalizacao">Corredor</label>
                    <input type="text" class="form-control" id="corredorLocalizacao" name="corredorLocalizacao" required>
                </div>
                <div class="form-group w-25">
                    <label for="colunaLocalizacao">Coluna</label>
                    <input type="text" class="form-control" id="colunaLocalizacao" name="colunaLocalizacao" required>
                </div>

                <div class="form-group w-25">
                    <label for="nivelLocalizacao">Nível</label>
                    <input type="text" class="form-control" id="nivelLocalizacao" name="nivelLocalizacao" required>
                </div>
            </div>
           
            <button type="button" id="btnCadastrarLocalizacao" class="btn" style="background-color: var(--cor-de-destaque); color: var(--cor-de-texto);">Cadastrar</button>
        </form>
    </div>



