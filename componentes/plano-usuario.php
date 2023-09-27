<?php
    $stmt_premium = $conexao -> prepare("SELECT premium FROM empresa WHERE id = :empresa");
    $stmt_premium -> execute(
        array(
        ":empresa" => $_SESSION["empresacodigo"]
        )
    );
    $usuario_premium = (int)$stmt_premium -> fetch(PDO::FETCH_COLUMN);

    if($usuario_premium) {
        echo '<span style="background-color: #000000; color: #fff424; border-radius: 10px; padding: 3px 5px; float: right; font-size: 15px;">Plano: <b>Premium</b></span>';    
    }
    else {
        echo '<span style="background-color: #000000; color: white; border-radius: 10px; padding: 3px 5px; float: right; font-size: 15px;">Plano: <b>Starter</b></span>';
    }

?>