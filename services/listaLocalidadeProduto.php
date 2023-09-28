<?php
    include("../../conexao_estoque.php");
    header("Content-type: application/json; charset=utf8;");

    $idProduto = isset($_GET['idProduto']) ? $_GET['idProduto'] : null;
    $resultado = array("status" => true, "mensagem" => "");

if (empty($idProduto)) {
    $resultado["status"] = false;
    $resultado["mensagem"] = "É necessario preencher o produto.";
    echo json_encode($resultado);
    exit; 
}
    try {
      $stmt = $conexao->prepare("SELECT corredor, coluna, nivel FROM localizacao_produto WHERE idProduto = :id_produto");
      $stmt->bindParam(':id_produto', $idProduto);
    
      $stmt->execute();
   
      $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($stmt){
      if(count($produtos) == 0){
        $resultado["status"] = false;
        $resultado["mensagem"] = "Não existe nenhuma unidade desse produto em estoque.";
      }else{
      $resultado["status"] = true;
      $resultado["produtos"] = $produtos;
      }
    }
      
    } catch (PDOException $e) {
        $resultado["status"] = false;
        $resultado["mensagem"] = "Erro ao buscar produtos: " . $e->getMessage();
    }
  
  echo json_encode($resultado);
?>