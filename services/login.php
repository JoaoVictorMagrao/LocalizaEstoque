<?php  
    include("../../conexao_estoque.php");
    header("Content-type: application/json; charset=utf8;");
    $resultado = array("status" => true, "mensagem" => "");
    $data = json_decode(file_get_contents("php://input"), true);

     
     if (!$data) {
         $resultado["status"] = false;
         $resultado["mensagem"] = "Erro ao decodificar os dados JSON.";
         echo json_encode($resultado);
         exit;
     }
     $usuario = $data['usuario'];
     $senha   = $data['senha'];
 
     $stmt = $conexao->prepare("SELECT * FROM empresa WHERE usuario = :usuario AND senha = :senha");
     $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);
     $stmt->bindValue(":senha", $senha, PDO::PARAM_STR);
     $stmt->execute();
     
     if ($stmt->rowCount() > 0) {
         $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);
     
         $resultado["status"] = true;
         $resultado["dados_usuario"] = $usuarioData;
         echo json_encode($resultado);
     } else {
        $resultado["status"] = false;
         $resultado["mensagem"] = "Usuário ou senha incorretos.";
         echo json_encode($resultado);
     }


?>