<?php
    include("./services/conta_teste.php");
    $conta_de_teste = $_SESSION["empresacodigo"] == ID_CONTA_TESTE;

    $dispositivos = array();

    if(isset($_SESSION['empresacodigo'])) {
        $stmt = $conexao -> prepare("SELECT * FROM celular WHERE empresa = :empresa");
        $stmt -> execute(array(
            ":empresa" => (int)$_SESSION['empresacodigo']
        ));

        $dispositivos = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
?>

    <h2>Dispositivos <?php include("./componentes/plano-usuario.php");?></h2>
    <p> Nesta página ficam dispostos os dispositivos que conectaram em sua conta. Você pode controlar os acessos por aqui. </p>

    <? if(!$conta_de_teste) {?>
    <div class="mt-4 mb-4">
        Filtro:
        <select id="filtro">
            <option value='todos'>Todos</option>
            <option value='ativo'>Ativos</option>
            <option value='inativo'>Inativos</option>
        </select>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th width="50%">Modelo</td>
                    <th width="30%" class="nao-aparece-mobile">Id único</td>
                    <th width="10%">Ativo</td>
                    <th width="10%">Excluir</td>
                </tr>
            </thead>
            <tbody id="dispositivos">

                
                
                
                

            </tbody>
            <tfooter>


            </tfooter>

        </table>
    
    </div>
    
    <div class="qrcodecontainer text-center">
        <p> Você pode fazer login escaneando este QR Code através do app. </p>
        <div id="qrcode">

        </div>
        <style>
            /* Alinha o QR Code no centro */
            #qrcode > img {
                display: inline !important;
            }
        </style>
    </div>
        
<script>
    let dispositivos = <?= json_encode($dispositivos) ?>; 
    
    console.log(dispositivos);
    function editarNome(idDispositivo) {
        let status = $(".editar-nome-"+idDispositivo).attr("class").replace("fas ", "").replace(" editar-nome-"+idDispositivo, "");
        if(status == "fa-pen") {
            $(".editar-nome-"+idDispositivo).attr("class", "fas fa-check editar-nome-"+idDispositivo);
            $(".dispositivo-nome-"+idDispositivo).html("<input type='text' class='inp-editar-nome-"+idDispositivo+"'/>");
        }
        else {
            $(".editar-nome-"+idDispositivo).attr("class", "fas fa-pen editar-nome-"+idDispositivo);
            let novoNome = $(".inp-editar-nome-"+idDispositivo).val();
            $.ajax({
                url: "./services/editar_nome_dispositivo.php?id=" + idDispositivo + "&novo_nome=" + novoNome,
                method: "GET", 
                success: function(data) {
                    if(data.status) {
                        $(".dispositivo-nome-"+idDispositivo).html($(".inp-editar-nome-"+idDispositivo).val());
                        mensagem("success", "Nome editado com sucesso!");
                    }
                    else {
                        mensagem("error", "Aconteceu algum erro ao tentar editar o nome. Tente novamente!");
                    }
                },
                error: function() {
                    mensagem("error", "Aconteceu algum erro ao tentar editar o nome. Tente novamente!");
                }
            })
            
        }
        

    }
    function montarTabela(dadosDispositivos) {
        
        htmlTabela = "";
        
        for(dispositivo of dadosDispositivos) {

            let checked = parseInt(dispositivo.ativo) ? "checked" : ""; 
            
            htmlTabela += "<tr>" + 
            "<td><button class='btn btn-success btn-sm mr-1 editar-nome-input-"+dispositivo.id+"' onclick='editarNome("+dispositivo.id+");'><i class='fas fa-pen editar-nome-"+dispositivo.id+"'></i></button><strong class='dispositivo-nome-"+dispositivo.id+"'>" + ((!dispositivo.nome) ? "Sem nome" : dispositivo.nome) +"</strong> <small>("+ dispositivo.modelo + ")</small></td>" +
            "<td class='nao-aparece-mobile'>" + dispositivo.deviceid + "</td>" +
            "<td>" + "<input type='checkbox' "+checked+" class='ativo-celular ativo-"+dispositivo.id+"'/></td>" +
            "<td><button type='button' class='btn btn-danger btn-sm' style='background-color: #ff4545 !important;' onclick='celular.excluir(\""+dispositivo.deviceid+"\", "+dispositivo.id+")'><i class='fas fa-trash'></i></button></td></tr>";

            
        }

        return htmlTabela;
    }

    let filtro = document.querySelector("#filtro");

    filtro.onchange = function() {
        let dataset = [];

        for(dispositivo of dispositivos) {
            if(filtro.value == 'inativo') {if(!parseInt(dispositivo.ativo)) {dataset.push(dispositivo);}};
            if(filtro.value == 'ativo') {if(parseInt(dispositivo.ativo)) {dataset.push(dispositivo);}}
            if(filtro.value == 'todos') {dataset.push(dispositivo);}
        }

        document.querySelector("#dispositivos").innerHTML = montarTabela(dataset);

        eventoChangeAtivoCelular();
    }

    document.querySelector("#dispositivos").innerHTML = montarTabela(dispositivos);


</script>

<?}?>