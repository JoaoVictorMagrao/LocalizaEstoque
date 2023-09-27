<?php  

    $usuario = $_REQUEST['usuario'];
    $senha = $_REQUEST['senha'];

    $manter_logado = ($_REQUEST['manter_logado'] == "on") ? true : false;

    $url = "". $usuario ."&senha=". $senha;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resultado_string = curl_exec($ch);

    curl_close($ch);

    $resultado = json_decode($resultado_string);

    if (session_status() != PHP_SESSION_ACTIVE) session_start();
    
    if($manter_logado) {
        session_set_cookie_params(PHP_INT_MAX);
    }
    else {
        session_set_cookie_params(2 * 60 * 60);
    }

    

    echo var_dump($resultado);

    if($resultado -> status) {
        
        $_SESSION["empresacodigo"] = $resultado -> dados_usuario -> codigo;
        $_SESSION["cliente"] = $resultado -> dados_usuario ->cliente;
        $_SESSION["nome_representante"] = $resultado -> dados_usuario -> nome_representante;
        $_SESSION["email"] = $resultado -> dados_usuario -> email;
        $_SESSION["premium"] = (int)$resultado -> dados_usuario -> premium;
        
        $SECRET = "420e21ceec0ddf29bf";
       
        $_SESSION["login"] = hash("sha256",$usuario.$senha.$SECRET);

        header("location: /estoque?tab-campanha=1");
        
    }
    else {
        if(isset($resultado -> acesso_negado) and ($resultado -> acesso_negado == 1)) {
            header("location: /estoque/login.php?erro=2");
        }
        else {
            header("location: /estoque/login.php?erro=1");
        }
    }


?>