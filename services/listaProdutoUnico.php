<?php
    include("../../conexao_estoque.php");
    header("Content-type: application/json; charset=utf8;");

    $codBarras = isset($_GET['codBarras']) ? $_GET['codBarras'] : null;
    $resultado = array("status" => true, "mensagem" => "");

    if (empty($codBarras)) {
      $resultado["status"] = false;
      $resultado["mensagem"] = "É necessario preencher o Código de barras.";
      echo json_encode($resultado);
      exit; 
    }

    try {
      $stmt = $conexao->prepare("SELECT id, nome FROM produtos WHERE codBarras = :codBarras");
      $stmt->bindParam(':codBarras', $codBarras);
      $stmt->execute();
      $produto = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($stmt){
        if(count($produto) == 0){
          $resultado["status"] = false;
          $resultado["mensagem"] = "Nenhum produto foi encontrado com esse código de barras";
        }else{
          $resultado["status"] = true;
          $resultado["produtos"] = $produto;
        }
      }
      
    } catch (PDOException $e) {
        $resultado["status"] = false;
        $resultado["mensagem"] = "Erro ao buscar produto: " . $e->getMessage();
    }
  
  echo json_encode($resultado);
?>