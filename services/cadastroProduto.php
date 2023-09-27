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


    $codBarras        = $data['codBarras'];
    $nomeProduto      = $data['nomeProduto'];
    $qtdEstoque       = $data['qtdEstoque'];
    $qtdMinimaEstoque = $data['qtdMinimaEstoque'];
    $obs              = $data['obs'];

    if ($codBarras === null || empty($codBarras)) {
        $resultado = array(
            "status" => false,
            "mensagem" => "Campo 'Código de barras' é obrigatório."
        );
        echo json_encode($resultado);
        exit;
    }
    
    if ($nomeProduto === null || empty($nomeProduto)) {
        $resultado = array(
            "status" => false,
            "mensagem" => "Campo 'Nome do Produto' é obrigatório."
        );
        echo json_encode($resultado);
        exit;
    }
    
    if ($qtdEstoque === null || empty($qtdEstoque)) {
        $resultado = array(
            "status" => false,
            "mensagem" => "Campo 'Quantidade em Estoque' é obrigatório."
        );
        echo json_encode($resultado);
        exit;
    }
    
    if ($qtdMinimaEstoque === null || empty($qtdMinimaEstoque)) {
        $resultado = array(
            "status" => false,
            "mensagem" => "Campo 'Quantidade Mínima em Estoque' é obrigatório."
        );
        echo json_encode($resultado);
        exit;
    }

    try {
  
      $sql = "INSERT INTO produtos (codBarras, nome, obs, quantidade, quantidadeEstoqueMinimo)
              VALUES (:codBarras, :nomeProduto, :obs, :qtdEstoque, :qtdMinimaEstoque)";
  
      $stmt = $conexao->prepare($sql);
      $stmt->bindParam(':codBarras', $codBarras);
      $stmt->bindParam(':nomeProduto', $nomeProduto);
      $stmt->bindParam(':obs', $obs);
      $stmt->bindParam(':qtdEstoque', $qtdEstoque);
      $stmt->bindParam(':qtdMinimaEstoque', $qtdMinimaEstoque);
  
      // Executar a consulta
      $stmt->execute();
      $resultado["status"] = true;
      $resultado["mensagem"] = "Produto inserido com sucesso.";
  } catch (PDOException $e) {
      $resultado["status"] = false;
      $resultado["mensagem"] = "Erro ao inserir o produto: " . $e->getMessage();
  }
    

    
    echo json_encode($resultado);
?>