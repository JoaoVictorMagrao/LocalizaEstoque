<?php
    include("../../conexao_estoque.php");
    header("Content-type: application/json; charset=utf8;");

    $resultado = array("status" => true, "mensagem" => "");
    try {
      $stmt = $conexao->prepare("SELECT id, nome FROM produtos");
      $stmt->execute();
  
      $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      $resultado["produtos"] = $produtos;
    } catch (PDOException $e) {
        $resultado["status"] = false;
        $resultado["mensagem"] = "Erro ao buscar produtos: " . $e->getMessage();
    }
  
  echo json_encode($resultado);
?>