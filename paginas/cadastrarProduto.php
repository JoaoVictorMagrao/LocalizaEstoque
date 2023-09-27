<?php
    // ini_set("display_errors", true);
    // error_reporting(E_ALL);

    include("../conexao.php");

    $id_pergunta = (int)$_REQUEST["id_pergunta"];
    $empresa = (int)$_SESSION['empresacodigo'];

    $stmt = $conexao -> prepare("SELECT * FROM perguntas WHERE empresa = :empresa AND id = :pergunta;");
    
    $stmt -> execute(array(
        ":empresa" => $empresa,
        ":pergunta" => $id_pergunta
    ));

    $pergunta = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    //echo var_dump($pergunta);
?>
<h2>Pergunta</h2>

<?php 
    if($pergunta == array()) {
        echo "Esta pergunta não existe!";
    }
    else {

        $stmt2 = $conexao -> prepare("SELECT notas.nota, notas.pergunta, STR_TO_DATE(notas.data_nota, '%Y-%m-%d') as data_nota FROM notas INNER JOIN perguntas ON notas.pergunta = perguntas.id WHERE notas.pergunta = :pergunta AND perguntas.empresa = :empresa");
        $stmt2 -> execute(array(
            ":empresa" => $empresa,
            ":pergunta" => $id_pergunta
        ));

        $respostas = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);

        if($respostas == array()) {
            echo "Esta pergunta não contém respostas.";
        }
        else {
            
            echo
            '<div class="grafico-container">
                
            </div>';

            //$respostas_pergunta = soma_respostas($respostas);

        }
    }
?>

<?php
    if($respostas != array()) {
        echo '
        <script>
            window.onload = function() {
                plotar_grafico('.json_encode(soma_respostas($respostas)).', "donut", "'.$pergunta[0]["pergunta"].'");
            }
        </script>
        ';
    }
?>