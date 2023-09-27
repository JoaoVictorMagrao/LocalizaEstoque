<?php
    function mensagem($tipo, $mensagem) {
        
        if($tipo == "erro") {
            $tipo_bootstrap = "danger";
            $simbolo = "<p class='msg-title'> <i class='msg-icon fa-solid fa-circle-xmark'></i> </p>";
        }
        else if($tipo == "sucesso") {
            $tipo_bootstrap = "success";
            $simbolo = "<p class='msg-title'> <i class='msg-icon fa-solid fa-circle-check'></i> </p>";
        }
        else if($tipo == "normal") {
            $tipo_bootstrap = "primary";
            $simbolo = "<p class='msg-title'> <i class='msg-icon fa-solid fa-circle-info'></i> </p>";
        }
        else if($tipo == "alerta") {
            $tipo_bootstrap = "warning";
            $simbolo = "<p class='msg-title'> <i class='msg-icon fa-solid fa-triangle-exclamation'></i> </p>";
        }
        return "<div class='alert alert-$tipo_bootstrap mb-2 mt-2' role='alert'>
                    $simbolo
                    $mensagem
                </div>";
    }

    if(isset($_REQUEST['erro']) or isset($_REQUEST['sucesso'])) {
        echo '
            <script> 
                setTimeout(function() {
                    document.querySelector(".alert").outerHTML =  "";
                }, 8000);
            </script>
        ';
    }
    

?>