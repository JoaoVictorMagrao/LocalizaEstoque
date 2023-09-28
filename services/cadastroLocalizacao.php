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

    $idProduto        = $data['idProduto'];
    $corredor         = $data['corredor'];
    $coluna           = $data['coluna'];
    $nivel            = $data['nivel'];

    
    if ($idProduto === null || empty($idProduto)) {
        $resultado = array(
            "status" => false,
            "mensagem" => "Nenhum produto foi cadastrado."
        );
        echo json_encode($resultado);
        exit;
    }
    
    if ($corredor === null || empty($corredor)) {
        $resultado = array(
            "status" => false,
            "mensagem" => "Campo 'Corredor' é obrigatório."
        );
        echo json_encode($resultado);
        exit;
    }
    
    if ($coluna === null || empty($coluna)) {
        $resultado = array(
            "status" => false,
            "mensagem" => "Campo 'Coluna' é obrigatório."
        );
        echo json_encode($resultado);
        exit;
    }

    try {
  
      $sql = "INSERT INTO localizacao_produto (idProduto, corredor, coluna, nivel)
              VALUES (:idProduto, :corredor, :coluna, :nivel)";
  
      $stmt = $conexao->prepare($sql);
      $stmt->bindParam(':idProduto', $idProduto);
      $stmt->bindParam(':corredor', $corredor);
      $stmt->bindParam(':coluna', $coluna);
      $stmt->bindParam(':nivel', $nivel);
  
      $stmt->execute();
      $resultado["status"] = true;
      $resultado["mensagem"] = "Produto inserido com sucesso.";
  } catch (PDOException $e) {
      $resultado["status"] = false;
      $resultado["mensagem"] = "Erro ao inserir o produto: " . $e->getMessage();
  }
    
    echo json_encode($resultado);
?>