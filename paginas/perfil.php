<?php 
    
    $empresa = (int)$_SESSION['empresacodigo'];

    $stmt = $conexao -> prepare("SELECT * FROM empresa WHERE id = :empresa");
    $stmt -> execute(
        array(":empresa" => $empresa)
    );

    $usuario = $stmt -> fetch(PDO::FETCH_OBJ);
?>

<h2>Perfil <?php include("./componentes/plano-usuario.php");?></h2>

<form method="POST" id="form-edicao-perfil" action="./services/editar_perfil.php">
    <div class="row">
        <div class="col">
            <label for="razao_social"><?= ($usuario -> cnpj == "0") ? "Nome" : "Razão Social" ?></label>
            <input type="text" class="form-control" name="razao_social" id="razao_social" value="<?= $usuario -> razao_social ?>"/>
        </div>
    </div>    
    <div class="row">
        <div class='col'>
            <label for="senha_cad">Nova senha</label>
            <input type="password" class="form-control" name="senha_cad" id="senha_cad"/>
        </div>
        <div class='col'>
            <label for="confirmar_senha">Confirmar nova senha</label>
            <input type="password" class="form-control" name="confirmar_senha" id="confirmar_senha"/>
        </div>
    </div>
    
    <div class="row">
        <div class='col'>
            <?php
                if($usuario -> cnpj != "0") {
                    echo '<label for="cnpj">CNPJ</label>
                    <input type="text" class="form-control" name="cnpj" id="cnpj" value="'.$usuario -> cnpj.'" disabled />';
                }
                else {
                    echo '<label for="cpf">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" value="'.$usuario -> cpf.'" disabled />';
                }
            ?>
        </div>    
    </div>
    
    <div class='row'>
        <div class='col'>
            <label for="email">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= $usuario -> email ?>"/>
        </div>
        
        <div class='col'>
            <label for="telefone">Telefone</label>
            <input type="tel" class="form-control" name="telefone" id="telefone" value="<?= $usuario -> telefone ?>"/>
        </div>
        
        <div class='col'>
            <label for="celular">Celular</label>
            <input type="tel" class="form-control" name="celular" id="celular" value="<?= $usuario -> celular ?>"/>
        </div>

    </div>
    
    <button type="button" class='salvar-edicao-perfil form-control mt-5'>Salvar</button>
</form>
