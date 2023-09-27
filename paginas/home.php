<?php
    
    include("../util.php");
    include("./services/conta_teste.php");

    $conta_de_teste = $_SESSION["empresacodigo"] == ID_CONTA_TESTE;

    $array_empresa = array(
        ":empresa" => $_SESSION['empresacodigo']
    );

    $premium = $_SESSION["premium"];

    $stmt_dispositivos_qtd = $conexao -> prepare("SELECT COUNT(id) as qtd FROM celular WHERE empresa = :empresa;");
    $stmt_dispositivos_qtd -> execute($array_empresa);
    $dispositivos_ativos = $stmt_dispositivos_qtd -> fetch();
    
    $stmt_notas = $conexao -> prepare("SELECT COUNT(notas.id) as qtd FROM notas INNER JOIN perguntas ON perguntas.id = notas.pergunta WHERE perguntas.empresa = :empresa;");
    $stmt_notas -> execute($array_empresa);
    $respostas_qtd = $stmt_notas -> fetch();
    
    $stmt_dispositivos = $conexao -> prepare("SELECT * FROM celular WHERE empresa = :empresa");
    $stmt_dispositivos -> execute($array_empresa);
    $dispositivos = $stmt_dispositivos -> fetchAll(PDO::FETCH_ASSOC);

    $stmt_respostas_geral = $conexao -> prepare("SELECT *, perguntas.id AS id_pergunta FROM notas INNER JOIN perguntas ON perguntas.id = notas.pergunta WHERE perguntas.empresa = :empresa;");
    $stmt_respostas_geral -> execute($array_empresa);
    $respostas_geral = $stmt_respostas_geral -> fetchAll();

    $stmt_perguntas = $conexao -> prepare("SELECT perguntas.id AS id, perguntas.pergunta AS pergunta, perguntas.campanha AS campanha, campanhas.campanha AS nome_campanha FROM perguntas INNER JOIN campanhas ON campanhas.id = perguntas.campanha WHERE perguntas.empresa = :empresa");
    $stmt_perguntas -> execute($array_empresa);
    
    $perguntas = $stmt_perguntas -> fetchAll(PDO::FETCH_ASSOC);

    $stmt_campanhas = $conexao -> prepare("SELECT id, campanha, ativa FROM campanhas WHERE empresa = :empresa");
    $stmt_campanhas -> execute($array_empresa);
    
    $campanhas = $stmt_campanhas -> fetchAll(PDO::FETCH_ASSOC);

    $campanha_ativa = "Nenhuma";
    $campanha_ativa_id = 0;
    
    foreach($campanhas as $campanha) {
        
        if($campanha["ativa"]) {
            $campanha_ativa = $campanha["campanha"];
            $campanha_ativa_id = $campanha["id"];
        }
    }

    $stmt_perguntas = $conexao -> prepare("SELECT COUNT(perguntas.id) as qtd FROM perguntas INNER JOIN campanhas ON campanhas.id = perguntas.campanha WHERE perguntas.ativa = 1 AND campanhas.empresa = :empresa AND campanhas.ativa = 1 AND campanhas.id = :campanha_id");
    $stmt_perguntas -> execute(array(":empresa" => $_SESSION['empresacodigo'], ":campanha_id" => $campanha_ativa_id));
    
    $perguntas_ativas = $stmt_perguntas -> fetch();

    $stmt_qtd_pessoas = $conexao -> prepare("SELECT SUM(pessoas) AS qtd FROM (SELECT campanhas.id,campanhas.campanha,
    IFNULL((
    SELECT COUNT(notas.id)
        FROM campanhas AS cp
        INNER JOIN perguntas ON (cp.id = perguntas.campanha) 
        LEFT JOIN notas ON (perguntas.id = notas.pergunta)
        WHERE cp.id = campanhas.id AND cp.empresa = :empresa AND perguntas.ativa = 1 AND IFNULL(notas.id,0) <> 0
        GROUP BY cp.id) /
    (SELECT COUNT(perguntas.id)
        FROM campanhas AS cc
        INNER JOIN perguntas ON (cc.id = perguntas.campanha) 
        WHERE cc.id = campanhas.id AND cc.empresa = :empresa AND perguntas.ativa = 1
        GROUP BY cc.id) ,0)
    AS pessoas

    FROM campanhas) AS qtd_pessoas;
    ");
    $stmt_qtd_pessoas -> execute($array_empresa);
    $pessoas = $stmt_qtd_pessoas -> fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Dashboard <?php include("./componentes/plano-usuario.php");?></h2>
<div class="row">
    
<div class="card w-100">
        <div class="card-header">
            <h2 class="card-title">Gráfico Dinâmico</h2>
            <!-- <p>Como está o nível de satisfação de sua empresa no geral? Neste gráfico fazemos contabilização das respostas de todas as campanhas e mostramos para você qual a visão geral de sua empresa aos olhos de seus clientes.</p> -->
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <button class="nav-link active btn btn-dark w-100" id="btn-perguntas" onclick="graficoDinamico.perguntas();">Perguntas</button>
                        </li>
                        <li class="nav-item mb-5">
                            <button class="nav-link active btn btn-dark w-100" id="btn-campanhas" onclick="graficoDinamico.campanhas();">Campanhas</button>
                        </li>
                        <li class="nav-item nao-aparece-celular">
                            <label for="select-grafico-dinamico">Pergunta/Campanha: </label>
                            <select class="form-control w-100 mb-2" id="select-grafico-dinamico">

                            </select>
                            <label for="select-dispositivos">Escolha o dispositivo: </label>
                            <select class="form-control mb-3" id="select-dispositivos">
                                <option value="0">TODOS OS DISPOSITIVOS</option>
                                <?php
                                    if(!$conta_de_teste) {
                                        foreach($dispositivos as $celular) {
                                            echo "<option value='".$celular["deviceid"]."'>".(isset($celular["nome"]) ? $celular["nome"] : $celular["modelo"])."</option>";
                                        }
                                    }
                                    else {
                                        echo "<option value='0'>IPhone 11 (Celular de exemplo)</option>";
                                    }
                                    
                                ?>
                            </select>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="data-inicial-filtro">Data inicial</label>
                                    <input type="date" max="9999-12-31" class="form-control mb-3" id="data-inicial-filtro">
                                </div>

                                <div class="col-md-6">
                                    <label for="data-final-filtro">Data final</label>
                                    <input type="date" max="9999-12-31" class="form-control mb-3" id="data-final-filtro">
                                </div>
                            </div>

                            <button id="btn-exportar-excel" class="btn btn-secondary">Exportar para Excel</button>

                            
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <div class="row">
                        
                            <div class="grafico-dinamico col-lg-9">
                            </div>  
                        
                            <div class="col">
                                <style>
                                    .img-emoji {
                                        width: 30px;
                                        height: 30px;
                                    }
                                </style>
                                <table class="table text-center gap tabela_emoji">
                                    
                                </table>
                            </div>

                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100">
        <div class="col">
            <div class="card-header">
                <h2 class="card-title">Gráfico Geral</h2>
                <!-- <p>Como está o nível de satisfação de sua empresa no geral? Neste gráfico fazemos contabilização das respostas de todas as campanhas e mostramos para você qual a visão geral de sua empresa aos olhos de seus clientes.</p> -->
            </div>
            <div class="card-body">
                <div class="grafico-geral">
                    
                </div>
            </div>
        </div>

        <div class="col" id="relatorio-qtd">
            <div class="card-header">  
                <h2 class="card-title">Relatório</h2>      
            </div>
            <div class="card-body align-middle">
                Dispositivos: <?= $dispositivos_ativos["qtd"] ?>/<?= (int)$premium ? "∞" : "1" ?> <br>
                Nome da campanha ativa: <?= $campanha_ativa ?><br>
                Qtd de perguntas ativas: <?= $perguntas_ativas["qtd"] ?> <br>
                Total de respostas: <?= $respostas_qtd["qtd"] ?> <br>
                Total de clientes: <?= (int)$pessoas[0]["qtd"] ?>
            </div> 
            <div class="card-header">
                <h2 class="card-title">Dispositivos</h2>
            </div>
            <div class="card-body align-middle">
                <ul style='list-style: none;'>

                    <?php
                        if($dispositivos == array()) {
                            echo "Você não possui dispositivos conectados a essa conta.";
                        }

                        if($conta_de_teste) {
                            echo "<li><input type='checkbox' checked class='mr-2' disabled /> IPhone 11 (Celular de exemplo) </li>";
                        }
                        else {
                            foreach($dispositivos as $celular) {
                                echo "<li><input type='checkbox' ".($celular["ativo"] ? "checked" : "")." class='mr-2' disabled />".(isset($celular["nome"]) ? $celular["nome"] : $celular["modelo"])."</li>";
                            }
                        }
                        
                    ?>

                </ul>
                <a href="/retaguarda/?tab-celular=1" style='text-shadow: 1px 1px 1.5px black;'>Gerenciar meus dispositivos <i class="fas fa-arrow-right"></i></a>
            </div>
            
        </div>
    </div>
    
    
    
    
    
</div>

<script>
    let respostas = <?= json_encode(array($respostas_geral)); ?>;
    var dispositivos = <?php echo json_encode($dispositivos); ?>;
     console.log(respostas);
    let dataExport = [];
    window.onload = function () {

        plotar_grafico(<?= json_encode(soma_respostas($respostas_geral)); ?>, "donut", "Todas as respostas", ".grafico-geral");
        graficoDinamico.campanhas();

        $("#select-grafico-dinamico").add("#select-dispositivos").add("#data-final-filtro").add("#data-inicial-filtro").on("change", function() {
            let idSelect = $("#select-grafico-dinamico").val();
            let estaVindoDe = $("#select-grafico-dinamico").attr("data-from");
            
            if(estaVindoDe == "perguntas") {
                graficoDinamico.perguntas(idSelect);
            }
            else if(estaVindoDe == "campanhas") {
                graficoDinamico.campanhas(idSelect);
            }
        });
        $('#data-final-filtro').prop('disabled', true);

        $('#data-inicial-filtro').change(function() {
            // Verifique se o campo está preenchido
            if ($(this).val() !== '') {
                // Se estiver preenchido, habilite o campo "Data Final"
                $('#data-final-filtro').prop('disabled', false);
            } else {
                // Caso contrário, desabilite o campo "Data Final"
                $('#data-final-filtro').prop('disabled', true);
            }
        });

        $("#btn-exportar-excel").click(function(){
            downloadXLSX();
        });
        
    }
    const downloadXLSX = () => {
    const dados = [['Dispositivo', 'Pergunta', 'Ruim', 'Bom', 'Ótimo', 'Total']]; // Cabeçalho

    // Dicionário para armazenar as somas das notas por dispositivo e pergunta
    const somaRespostasPorDispositivo = {};

    // Somas gerais
    let somaRuimGeral = 0;
    let somaBomGeral = 0;
    let somaOtimoGeral = 0;

    // Iterar sobre as respostas
    for (const resposta of dataExport) {
        const dispositivo = resposta.celular; // Identificador único do dispositivo

        // Verificar se o dispositivo já existe no dicionário
        if (!somaRespostasPorDispositivo[dispositivo]) {
            somaRespostasPorDispositivo[dispositivo] = {};
        }

        // Verificar se a pergunta já existe no dicionário do dispositivo
        const pergunta = resposta.pergunta;
        if (!somaRespostasPorDispositivo[dispositivo][pergunta]) {
            somaRespostasPorDispositivo[dispositivo][pergunta] = {
                ruim: 0,
                bom: 0,
                otimo: 0,
                total: 0, // Adicione a contagem total
            };
        }

        // Somar as notas de acordo com a resposta atual
        switch (resposta.nota) {
            case '1':
                somaRespostasPorDispositivo[dispositivo][pergunta].ruim++;
                somaRuimGeral++;
                break;
            case '3':
                somaRespostasPorDispositivo[dispositivo][pergunta].bom++;
                somaBomGeral++;
                break;
            case '5':
                somaRespostasPorDispositivo[dispositivo][pergunta].otimo++;
                somaOtimoGeral++;
                break;
            default:
                // Tratamento para valores diferentes de 1, 3 e 5
                break;
        }

        // Atualizar a contagem total
        somaRespostasPorDispositivo[dispositivo][pergunta].total++;
    }

    // Iterar sobre os dispositivos
    for (const dispositivo in somaRespostasPorDispositivo) {
        // Iterar sobre as perguntas de cada dispositivo
        for (const pergunta in somaRespostasPorDispositivo[dispositivo]) {
            const modelo = getDeviceName(dispositivo); // Função para obter o modelo do dispositivo
            const soma = somaRespostasPorDispositivo[dispositivo][pergunta];

            const linhaResposta = [
                modelo, // Nome do dispositivo
                pergunta, // Nome da pergunta
                soma.ruim, // Contagem de Ruim
                soma.bom, // Contagem de Bom
                soma.otimo, // Contagem de Ótimo
                soma.total, // Total de respostas
            ];

            // Adicionar uma linha para a resposta atual
            dados.push(linhaResposta);
        }
    }

    // Adicionar a linha de cabeçalho adicional com as somas gerais
    dados.push(['', '', '', '', '', '']); // Cabeçalho adicional
    dados.push(['Geral', '', somaRuimGeral, somaBomGeral, somaOtimoGeral, '']); // Soma das notas gerais

    const wb = XLSX.utils.book_new();
    wb.Props = {
        Title: 'Relatório',
        Subject: 'Notas',
        Author: 'Desenvolvedor',
        CreatedDate: new Date(),
    };
    wb.SheetNames.push('Relatório 1');

    const ws = XLSX.utils.aoa_to_sheet(dados);
    wb.Sheets['Relatório 1'] = ws;

    const dataHoraAtual = new Date();
    const dataHoraString = dataHoraAtual.toLocaleString();

    XLSX.writeFile(wb, `Relatório${dataHoraString}.xlsx`, { type: 'binary' });
};

function getDeviceName(deviceId) {
    const dispositivo = dispositivos.find((d) => d.deviceid === deviceId);
    return dispositivo.nome == null ? dispositivo.modelo :  dispositivo.nome;
}

    let graficoDinamico = {
        somaRespostas: function(respostas) {
            
            let ruim = 0, bom = 0, otimo = 0;

            for(resposta of respostas) {
                if(resposta.nota == 1) {
                    ruim++;
                }
                else if(resposta.nota == 3) {
                    bom++;
                }
                else if(resposta.nota == 5) {
                    otimo++;
                }
            }

            return [ruim, bom, otimo];
        },
        renderizar: function(titulo, dados, tipo = 'donut') {
            plotar_grafico(dados, tipo, titulo, ".grafico-dinamico");
            
            $(".valor_atual_otimo").html(dados[2]);
            $(".valor_atual_bom").html(dados[1]);
            $(".valor_atual_ruim").html(dados[0]);
        },
        perguntas: function(perguntaId = 0) {
            let perguntas = <?= json_encode($perguntas); ?>
            
            if(perguntaId != 0) {
                let dataset = [];
                var dataInicial = $('#data-inicial-filtro').val();
                var dataFinal = $('#data-final-filtro').val();

                for(resposta of respostas[0]) {
                   //console.log(resposta);
                    if(perguntaId == resposta.id_pergunta) {
                        let celularEscolhido = $("#select-dispositivos").val();
                        if(celularEscolhido != 0) {
                           
                            if(resposta.celular == celularEscolhido) {
         
                                if(dataInicial !== '' && dataFinal !== ''){
                              
                                    let dataResposta = new Date(resposta.data_nota);
                                    let dataInicialObj = new Date(dataInicial);
                                    let dataFinalObj = new Date(dataFinal);

                                    dataResposta.setHours(0, 0, 0, 0);
                                    
                                    if (dataResposta >= dataInicialObj && dataResposta <= dataFinalObj) {
                               
                                        dataset.push(resposta);
                                        dataExport.push(resposta);
                                    }
                                }else{
                              
                                    dataset.push(resposta);
                                    dataExport.push(resposta);
                                }
                                //dataset.push(resposta);
                            }
                        }
                        else {

                            if(dataInicial !== '' && dataFinal !== ''){
                                    let dataResposta = new Date(resposta.data_nota);
                                    let dataInicialObj = new Date(dataInicial);
                                    let dataFinalObj = new Date(dataFinal);

                                    dataResposta.setHours(0, 0, 0, 0);
                                    
                                    if (dataResposta >= dataInicialObj && dataResposta <= dataFinalObj) {
                                    // console.log(resposta);
                                        dataset.push(resposta);
                                        dataExport.push(resposta);
                                    }
                            }else{
                                dataset.push(resposta);
                                dataExport.push(resposta);
                            }
                        }
                    }
                }
                this.renderizar("Perguntas",this.somaRespostas(dataset), "pizza");
                console.log("Perguntas: ");
                console.log(this.somaRespostas(dataset));
            }
            else {

                let selectOptions = "";
                
                for(pergunta of perguntas) {
                    selectOptions += "<option value='"+pergunta.id+"'>"+pergunta.nome_campanha+" | "+pergunta.pergunta+"</option>";
                }

                $("#select-grafico-dinamico").html(selectOptions);
                $("#select-grafico-dinamico").attr("data-from", "perguntas");

                
                let idPergunta = $("#select-grafico-dinamico").val();
                this.perguntas(idPergunta);
            }
            
            // this.renderizar("", "");
        },
        campanhas: function(campanhaId = 0) {

            let campanhas = <?= json_encode($campanhas); ?>;

            let dataset = [];
            
            if(campanhaId != 0) {
                var dataInicial = $('#data-inicial-filtro').val();
                var dataFinal = $('#data-final-filtro').val();

                
                for(resposta of respostas[0]) {
                    if(campanhaId == resposta.campanha) {
                        let celularEscolhido = $("#select-dispositivos").val();
                        if(celularEscolhido != 0) {
                            if(resposta.celular == celularEscolhido) {
                                if(dataInicial !== '' && dataFinal !== ''){
                                    let dataResposta = new Date(resposta.data_nota);
                                    let dataInicialObj = new Date(dataInicial);
                                    let dataFinalObj = new Date(dataFinal);

                                    dataResposta.setHours(0, 0, 0, 0);
                                    
                                    if (dataResposta >= dataInicialObj && dataResposta <= dataFinalObj) {
                                    // console.log(resposta);
                                        dataset.push(resposta);
                                        dataExport.push(resposta);
                                    }
                            }else{
                                dataset.push(resposta);
                                dataExport.push(resposta);
                            }
                            }
                        }
                        else {
                            if(dataInicial !== '' && dataFinal !== ''){
                                    let dataResposta = new Date(resposta.data_nota);
                                    let dataInicialObj = new Date(dataInicial);
                                    let dataFinalObj = new Date(dataFinal);

                                    dataResposta.setHours(0, 0, 0, 0);
                                    
                                    if (dataResposta >= dataInicialObj && dataResposta <= dataFinalObj) {
                                    // console.log(resposta);
                                        dataset.push(resposta);
                                        dataExport.push(resposta);
                                    }
                            }else{
                                dataset.push(resposta);
                                dataExport.push(resposta);
                            }
                        }
                    }
                }

                this.renderizar("Campanhas",this.somaRespostas(dataset));
            }
            else {
                let selectOptions = "";
                
                for(campanha of campanhas) {
                    selectOptions += "<option value='"+campanha.id+"' "+(parseInt(campanha.ativa) ? "selected" : "")+">"+campanha.campanha+ ((parseInt(campanha.ativa)) ? " (campanha ativa)" : "") + "</option>";
                }

                $("#select-grafico-dinamico").html(selectOptions);
                $("#select-grafico-dinamico").attr("data-from", "campanhas");

                
                let idCampanha = $("#select-grafico-dinamico").val();
                this.campanhas(idCampanha);                
            }
            

        }

    }

</script>
