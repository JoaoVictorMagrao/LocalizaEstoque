
let linkAppIOS = "google.com";
let linkAppAndroid = "youtube.com";

// Tela "Dispositivos"
let idAcao = 0;

function insertAfter(newElement, reference) {
    reference.parentNode.insertBefore(newElement, reference.nextSibling);
}

function dataBR(data) {
    let dataArray = data.split("-");
    return (dataArray[2][0] + dataArray[2][1]) + "/" + dataArray[1] + "/" + dataArray[0];
}

let celular = {
    ativar: function (id) {
        location.href = "./services/ativar_celular.php?id=" + id;
    },
    desativar: function (id) {
        location.href = "./services/desativar_celular.php?id=" + id;
    },
    excluir: function(deviceid, id) {
        if(confirm("Você tem certeza que deseja excluir este dispositivo?")) {
            location.href = "./services/excluir_celular.php?id=" + id + "&deviceid=" + deviceid;
        }
    }
}

// Coloquei o evento dentro de uma função para usá-lo na página de dispositivos depois que o filtro é ativo.
function eventoChangeAtivoCelular() {

    $(".ativo-celular").on("change", function () {
        let idCelular = $(this).attr("class").replace("ativo-celular ativo-", "");

        if ($(this).prop("checked")) {
            celular.ativar(idCelular);
        }
        else {
            celular.desativar(idCelular);
        }

    });

}

eventoChangeAtivoCelular();

$("#salvar-pergunta").on("click", function () {
    let textoPergunta = $(".nova-pergunta").val();
    if (textoPergunta == '') {
        mensagem("error", "Insira um texto para sua pergunta.");
    }
});

function eventoPerguntaAtivarCampanha(id, dataset) {
    let ok = false;
    if(dataset.length == 1) {
        console.log("Passou aqui 1!");
        console.log(dataset[0].perguntas);
        if(dataset[0].perguntas.length > 0) {
            console.log("Passou aqui 2!");
            if(!parseInt(dataset[0].ativa)) {
                console.log("Passou aqui 3!");
                ok = true;
                $('#modal-detalhes-campanha').on('hide.bs.modal', function (e) {
                    Swal.fire({
                        title: 'Você deseja ativar esta campanha?',
                        showDenyButton: true,
                        confirmButtonText: 'Sim',
                        denyButtonText: 'Não',
                        customClass: {
                            actions: 'my-actions',
                            cancelButton: 'order-1 right-gap',
                            confirmButton: 'order-2',
                            denyButton: 'order-3',
                        },
                        allowOutsideClick: false
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            campanha.ativar(id);
                        }
                        $('#modal-detalhes-campanha').on('hide.bs.modal', function(e) {});
                    });
                });
            }
            
        }

        console.log(ok);
        if(ok == false) {
            $('#modal-detalhes-campanha').on('hide.bs.modal', function (e) {});
        }
        
    }

}


// Tela de campanha

let editandoCampanhaId = 0;

let campanha = {
    ativarPergunta: function (idPergunta) {

        let campanhaId = $("#titulo-campanha").attr("data-campanha");

        $.ajax({
            method: "GET",
            url: "/retaguarda/services/ativar_pergunta.php?pergunta=" + idPergunta + "&campanha=" + campanhaId,
            success: function (data) {
                mensagem("success", "Pergunta ativada com sucesso!");

                for (dadosCampanha of dadosCampanhas) {

                    if (campanhaId == dadosCampanha.id) {
                        campanhaAtiva = dadosCampanha.ativa;
                        let indice = dadosCampanhas.indexOf(dadosCampanha);
                        dadosCampanhas[indice].perguntas = data.perguntas_atualizado;
                    }

                }
            },
            error: function () {
                $(".ativa-pergunta-" + idPergunta).prop("checked", false);
                mensagem("error", "Algo de errado aconteceu na tentativa de ativar a pergunta. Tente novamente mais tarde.");
            }
        });
    },
    desativarPergunta: function (idPergunta) {

        let campanhaId = $("#titulo-campanha").attr("data-campanha");

        if (confirm("Você tem certeza que deseja desativar essa pergunta?")) {
            $.ajax({
                method: "GET",
                url: "/retaguarda/services/desativar_pergunta.php?pergunta=" + idPergunta + "&campanha=" + campanhaId,
                success: function (data) {
                    if(data.status) {
                        mensagem("success", "Pergunta desativada com sucesso!");

                        for (dadosCampanha of dadosCampanhas) {

                            if (campanhaId == dadosCampanha.id) {
                                campanhaAtiva = dadosCampanha.ativa;
                                let indice = dadosCampanhas.indexOf(dadosCampanha);
                                dadosCampanhas[indice].perguntas = data.perguntas_atualizado;
                            }
    
                        }
                    }
                    else {
                        mensagem("error", data.mensagem);
                        $(".ativa-pergunta-" + idPergunta).prop("checked", true);
                    }
                    
                },
                error: function () {
                    $(".ativa-pergunta-" + idPergunta).prop("checked", true);
                    mensagem("error", "Algo de errado aconteceu na tentativa de desativar a pergunta. Tente novamente mais tarde.");
                }
            })
        }
        else {
            $(".ativa-pergunta-" + idPergunta).prop("checked", true);
        }
    },

    editarTextoPergunta: function (idPergunta) {

        if ($("#input-editar-pergunta").length == 0) {
            let texto = $("#pergunta-texto-" + idPergunta).html();
            let inputEditarPergunta = "<input type='text' id='input-editar-pergunta' data-pergunta='" + idPergunta + "' value='" + texto + "' class='form-control mr-2' />";
            $("#pergunta-texto-" + idPergunta).html(inputEditarPergunta);
            $(".btn-editar-pergunta-" + idPergunta).hide();
            $(".btn-confirmar-edicao-" + idPergunta).show();

        }

    },

    salvarEdicaoPergunta: function (idPergunta) {

        let textoPergunta = $("#input-editar-pergunta").val();
        let campanhaId = $("#titulo-campanha").attr("data-campanha");

        if (textoPergunta == "") {
            mensagem("error", "Insira um texto em sua pergunta!");
        }
        else {
            $.ajax({
                method: "GET",
                url: "/retaguarda/services/editar_pergunta.php?pergunta=" + idPergunta + "&novo_texto=" + textoPergunta + "&campanha=" + campanhaId,
                success: function (data) {

                    $(".btn-confirmar-edicao-" + idPergunta).hide();
                    $(".btn-editar-pergunta-" + idPergunta).show();
                    mensagem("success", "Pergunta alterada com sucesso!");
                    $("#pergunta-texto-" + idPergunta).html(textoPergunta);

                    for (dadosCampanha of dadosCampanhas) {

                        if (campanhaId == dadosCampanha.id) {
                            campanhaAtiva = dadosCampanha.ativa;
                            let indice = dadosCampanhas.indexOf(dadosCampanha);
                            dadosCampanhas[indice].perguntas = data.perguntas_atualizado;
                        }

                    }

                },
                error: function () {
                    mensagem("error", "Algo de errado aconteceu ao tentar alterar a pergunta. Tente novamente mais tarde!");
                }
            });
        }
    },
    mudarPrioridadePergunta: function(idPergunta) {
        let campanhaId = $("#titulo-campanha").attr("data-campanha");
        let novaPrioridade = $(".prioridade-pergunta-"+idPergunta).val();
        $.ajax({
            method: "GET",
            url: "/retaguarda/services/mudar_prioridade_pergunta.php?pergunta="+idPergunta+"&nova_prioridade="+novaPrioridade+"&campanha="+campanhaId,
            success: function(data) {
                if(data.status) {
                    mensagem("success", "A prioridade da pergunta foi alterada!");
                    for (dadosCampanha of dadosCampanhas) {

                        if (campanhaId == dadosCampanha.id) {
                            campanhaAtiva = dadosCampanha.ativa;
                            let indice = dadosCampanhas.indexOf(dadosCampanha);
                            dadosCampanhas[indice].perguntas = data.perguntas_atualizado;
                        }
    
                    }
                }
                else {
                    mensagem("error", data.mensagem);
                }
                
            },
            error: function() {
                mensagem("error", "Algo de errado aconteceu ao tentar mudar a prioridade da pergunta. Tente novamente mais tarde.");
            }
        });
    },
    salvarPergunta: function () {

        let pergunta = $(".nova-pergunta").val();
        let campanhaId = $("#titulo-campanha").attr("data-campanha");

        //$(".btn-confirmar-edicao").hide();

        if (pergunta == "") {
            mensagem("error", "Insira um texto para sua pergunta!");
        }
        else {
            $.ajax({
                method: "GET",
                url: "/retaguarda/services/criar_pergunta.php?id_campanha=" + campanhaId + "&pergunta=" + pergunta,
                success: function (data) {
                    
                    let divModal = "";

                    let campanhaAtiva;

                    for (dadosCampanha of dadosCampanhas) {

                        if (campanhaId == dadosCampanha.id) {
                            campanhaAtiva = dadosCampanha.ativa;
                            let indice = dadosCampanhas.indexOf(dadosCampanha);
                            dadosCampanhas[indice].perguntas = data.perguntas_atualizado;
                        }

                    }

                    eventoPerguntaAtivarCampanha(campanhaId, dadosCampanhas);
                    
                    for(dadosCampanha of dadosCampanhas) {
                        if(campanhaId == dadosCampanha.id) {
                            for (pergunta of dadosCampanha.perguntas) {
                                if (campanhaId == pergunta.campanha) {

                                    let edicaoExclusaoPergunta = (!parseInt(pergunta.movimento) && !parseInt(dadosCampanha.ativa)) ?
                                    "<td><button type='button' class='btn btn-primary btn-sm btn-editar-pergunta btn-editar-pergunta-" + pergunta.id + "' onclick='campanha.editarTextoPergunta(" + pergunta.id + ");'><i class='fas fa-pen'></i></button><button type='button' style='background-color: lightgreen !important;' class='btn btn-primary btn-sm btn-confirmar-edicao btn-confirmar-edicao-" + pergunta.id + "' onclick='campanha.salvarEdicaoPergunta(" + pergunta.id + ");'><i class='fas fa-check'></i></button></td>" +
                                    "<td><button type='button' style='background-color: #ff4545 !important;' class='btn btn-primary btn-sm' onclick='campanha.excluirPergunta(" + pergunta.id + ");'><i class='fas fa-trash'></i></button></td>" : "<td></td><td></td>";

                                    let movimentoLabel = (parseInt(pergunta.movimento)) ? " <small>(Possui notas registradas)</small>" : "";

                                    divModal +=
                                        "<tr class='tr-pergunta-" + pergunta.id + "'>" +
                                        "<td id='pergunta-texto-" + pergunta.id + "'>" + pergunta.pergunta + movimentoLabel + "</td>" +
                                        "<td class='nao-aparece-mobile'>" + dataBR(pergunta.data_pergunta) + "</td>" +
                                        "<td><input type='checkbox' class='ativa-pergunta ativa-pergunta-" + pergunta.id + "' " + (pergunta.ativa == 1 ? "checked" : "") + " /></td>" +
                                        "<td class='nao-aparece-mobile'><input type='number' class='prioridade-pergunta prioridade-pergunta-"+pergunta.id+"' value='"+pergunta.posicao+"' min=-1/></td>"+
                                        edicaoExclusaoPergunta + "</tr>";
                                }

                            }
                        }
                    }


                    divModal +=
                        "<tr class='btn-criar-pergunta'>" +
                        "<td colspan=6 class='text-center'><button class='btn btn-success' onclick='campanha.criarPergunta();'><i class='fas fa-plus mr-2'></i>Criar Pergunta</button></td>" +
                        "</tr>";

                    $("#perguntas").html(divModal);

                    $(".btn-confirmar-edicao").hide();

                    $(".prioridade-pergunta").on("change", function() {
                        let idPergunta = $(this).attr("class").replace("prioridade-pergunta prioridade-pergunta-", "");
                        campanha.mudarPrioridadePergunta(idPergunta);
                    });

                    $(".ativa-pergunta").on("change", function () {
                        let idPergunta = $(this).attr("class").replace("ativa-pergunta ativa-pergunta-", "");
                        //console.log("Status pergunta: " + ($(this).is(":checked") ? "ativada" : "desativada"), idPergunta);
                        if ($(this).is(':checked')) {
                            campanha.ativarPergunta(idPergunta);
                        }
                        else {
                            campanha.desativarPergunta(idPergunta);

                        }
                    });

                    $("#criar-pergunta-input").remove();
                    mensagem("success", "Pergunta criada com sucesso!");
                },
                error: function () {
                    mensagem("error", "Algo de errado aconteceu ao tentar criar a pergunta!");
                }

            });

        }


    },
    criarPergunta: function (campanhaAtiva) {
        let existeInput = $("#criar-pergunta-input").length;
        if (!existeInput) {
            $("<tr id='criar-pergunta-input'><td colspan='6' class='text-center'><input type='text' class='form-control nova-pergunta w-100' placeholder='Digite sua nova pergunta.'/><button class='btn btn-success w-25 mt-2' style='margin: 0 auto;' id='salvar-pergunta' onclick='campanha.salvarPergunta();'><i class='fas fa-check'></i>Salvar</button></td></tr>").insertBefore(".btn-criar-pergunta");
        }
    },
    ativar: function (id) {
        location.href = "./services/ativar_campanha.php?id=" + id;
    },
    desativar: function (id) {
        location.href = "./services/desativar_campanha.php?id=" + id;
    },
    modalDetalhesCampanha(id, filtro="todos") {
        $("#perguntas").html("");

        let divModal = "";

        let campanhaAtiva = true;
        let dadosCampanhaa;

        let temPerguntas = false;
        
        for (dadosCampanha of dadosCampanhas) {

            if (id == dadosCampanha.id) {
                campanhaAtiva = dadosCampanha.ativa;

                dadosCampanhaa = dadosCampanha;

                btnExcluirCampanhaCelular = "<button type='button' class='btn btn-danger btn-sm nao-aparece-pc ml-2' style='background-color: #ff4545 !important;' onclick='campanha.excluirCampanha("+id+")' data-dismiss='modal'><i class='fas fa-trash'></i> Excluir</button>";

                $(".excluir-campanha-btn").html(btnExcluirCampanhaCelular);

                // Adiciona o id da campanha na tag para ser pegado depois
                $("#titulo-campanha").html(dadosCampanha.campanha);
                $("#titulo-campanha").attr("data-campanha", dadosCampanha.id);

                temPerguntas = dadosCampanhaa.perguntas.length != 1;
                
                for (pergunta of dadosCampanha.perguntas) {

                    // A edição e exclusão só pode acontecer caso a pergunta não possuir avaliações e não houver
                    let edicaoExclusaoPergunta = (!parseInt(pergunta.movimento) && !parseInt(dadosCampanha.ativa)) ?
                        "<td><button type='button' class='btn btn-primary btn-sm btn-editar-pergunta btn-editar-pergunta-" + pergunta.id + "' onclick='campanha.editarTextoPergunta(" + pergunta.id + ");'><i class='fas fa-pen'></i></button><button type='button' style='background-color: lightgreen !important;' class='btn btn-primary btn-sm btn-confirmar-edicao btn-confirmar-edicao-" + pergunta.id + "' onclick='campanha.salvarEdicaoPergunta(" + pergunta.id + ");'><i class='fas fa-check'></i></button></td>" +
                        "<td><button type='button' style='background-color: #ff4545 !important;' class='btn btn-primary btn-sm' onclick='campanha.excluirPergunta(" + pergunta.id + ");'><i class='fas fa-trash'></i></button></td>" : "<td></td><td></td>";
                    
                    // Este texto é adicionado na frente da pergunta.
                    let movimentoLabel = (parseInt(pergunta.movimento)) ? " <small>(Possui notas registradas)</small>" : "";

                    let filtroCondicao;

                    
                    if(filtro == "todos") {
                        filtroCondicao = true;
                    }
                    else if(filtro == "ativo") {
                        filtroCondicao = parseInt(pergunta.ativa);
                    }
                    else if(filtro == "inativo") {
                        filtroCondicao = pergunta.ativa == false;
                    }

                    // Monta a tabela de acordo com os parâmetros passados
                    if(filtroCondicao) {
                        divModal +=
                        "<tr class='tr-pergunta-" + pergunta.id + "'>" +
                            "<td id='pergunta-texto-" + pergunta.id + "'>" + pergunta.pergunta + movimentoLabel + "</td>" +
                            "<td class='nao-aparece-mobile'>" + dataBR(pergunta.data_pergunta) + "</td>" +
                            "<td><input type='checkbox' class='ativa-pergunta ativa-pergunta-" + pergunta.id + "' " + (pergunta.ativa == 1 ? "checked" : "") + " /></td>" +
                            "<td class='nao-aparece-mobile'><input type='number' class='prioridade-pergunta prioridade-pergunta-"+pergunta.id+"' value='"+pergunta.posicao+"'/></td>"+
                            edicaoExclusaoPergunta + 
                        "</tr>";
                    }
                    
                }

            }
        }

        // Adiciona o botão de "Criar Pergunta" caso a campanha esteja desativada
        if (!parseInt(campanhaAtiva)) {
            divModal +=
                "<tr class='btn-criar-pergunta'>" +
                "<td colspan=6 class='text-center'><button class='btn btn-success' onclick='campanha.criarPergunta();'><i class='fas fa-plus mr-2'></i>Criar Pergunta</button></td>" +
                "</tr>";
        }

        $("#perguntas").html(divModal);

        $(".btn-confirmar-edicao").hide();

        $(".prioridade-pergunta").on("change", function() {
            let idPergunta = $(this).attr("class").replace("prioridade-pergunta prioridade-pergunta-", "");
            campanha.mudarPrioridadePergunta(idPergunta);
        });

        eventoChangeAtivoPergunta();

        
        document.querySelector("#filtro-pergunta").onchange = function () {
            let filtroSelect = document.querySelector("#filtro-pergunta").value;
            campanha.modalDetalhesCampanha(id, filtroSelect);
        };
        
        
        
        
    },
    modalEditarCampanha(id, campanha) {
        editandoCampanhaId = id;
        $("#campanha_editar").val(campanha);
    },
    modalCriarCampanha() {

    },
    confirmarEdicao() {
        location.href = "./services/editar_campanha.php?id_campanha=" + editandoCampanhaId + "&novo_nome=" + $("#campanha_editar").val();
    },
    confirmarExclusaoCampanha() {
        // PASSO 1 - Respostas Invertidas;



        // PASSO 2 - Confirmação por código;



    },
    excluirCampanha: function (id) {
        Swal.fire({
            title: 'Você deseja realmente excluir esta campanha? Não existe possibilidade de recuperá-la após a exclusão.',
            showDenyButton: true,
            confirmButtonText: 'Não',
            denyButtonText: 'Sim',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
                denyButton: 'order-3',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('A campanha foi mantida.', '', 'info');
            } else if (result.isDenied) {
                
                let numeros = [1,2,3,4,5,6,7,8,9];
                let codigo = "";
                for(x = 0; x<6; x++) {
                    codigo += numeros[Math.floor(Math.random()*9)];
                }
                Swal.fire({
                    title: 'Digite o código ' + codigo + ' para confirmar: ',
                    html: `<input type="text" id="codigoExclusao" class="swal2-input" placeholder="Digite o código...">`,
                    confirmButtonText: 'Confirmar',
                    showDenyButton: true,
                    denyButtonText: "Cancelar",
                    focusConfirm: false,
                    preConfirm: () => {
                        const codigoInput = Swal.getPopup().querySelector('#codigoExclusao').value;
                        if(codigoInput != codigo) {
                            Swal.showValidationMessage("Digite o código corretamente ou cancele.");
                        }
                        return true;
                    }
                    }).then((result2) => {
                        if(result2.isConfirmed) {
                            $.ajax({
                                method: "GET",
                                url: "./services/excluir_campanha.php?id=" + id,
                                success: function (data) {
                                    if (data.status) {
            
                                        $(".campanha-" + id).remove();
                                        mensagem("success", "Campanha excluida com sucesso!");
            
                                    }
                                    else {
                                        let msgTemMovimento = "Esta campanha possui respostas já cadastradas. Não é possível removê-la.";
                                        let msgErroCampanha = "Algum erro aconteceu ao tentar remover as campanhas";
                                        //mensagem("error", (data.tem_movimento) ? msgTemMovimento : msgErroCampanha);
                                        mensagem("error", data.mensagem);
                                    }
                                },
                                error: function () {
            
                                }
                            });
                        }
                        else if (result2.isDenied) {
                            Swal.fire('A campanha foi mantida.', '', 'info');
                        }
                        
                });

                
            }
        });
        // if(confirm("Você tem certeza que deseja remover esta campanha?")) {

        // }
    },
    excluirPergunta: function (id) {
        if (confirm("Você tem certeza que deseja remover esta pergunta?")) {
            $.ajax({
                method: "GET",
                url: "./services/excluir_pergunta.php?id=" + id,
                success: function (data) {

                    let campanhaId = "";
                    // Atualiza o array dadosCampanhas que renderiza ao abrir o modal;  
                    for(let dadosCampanha of dadosCampanhas) {
                        let indice = 0;
                        for(let pergunta of dadosCampanha.perguntas) {
                            if(pergunta.id == id) {
                                dadosCampanha.perguntas.splice(indice);
                                campanhaId = dadosCampanha.id
                                break;
                            }
                            indice++;
                        }
                    }

                    eventoPerguntaAtivarCampanha(campanhaId, dadosCampanhas);

                    if (data.status) {
                        $(".tr-pergunta-" + id).remove();
                        mensagem("success", "Pergunta excluida com sucesso!");
                    }
                    else {
                        let msgTemMovimento = "Esta pergunta possui respostas já cadastradas. Não é possível removê-la.";
                        let msgErroPergunta = "Algum erro aconteceu ao tentar remover a pergunta";
                        mensagem("error", (data.tem_movimento) ? msgTemMovimento : msgErroPergunta);
                    }
                },
                error: function () {

                }
            });
        }
    }
}

function eventoChangeAtivoPergunta() {
    $(".ativa-pergunta").on("change", function () {
        let idPergunta = $(this).attr("class").replace("ativa-pergunta ativa-pergunta-", "");
        
        console.log("Status pergunta: " + ($(this).is(":checked") ? "ativada" : "desativada"), idPergunta);

        if ($(this).is(':checked')) {
            campanha.ativarPergunta(idPergunta);
        }
        else {
            campanha.desativarPergunta(idPergunta);
        }
    });

}

function eventoChangeAtivoCampanha() {
    $(".ativo-campanha").on("change", function () {
        let idCampanha = $(this).attr("class").replace("ativo-campanha ativo-", "").replace("nao-aparece-pc ", "").replace("mr-2 ", "");

        if ($(this).prop("checked")) {
            campanha.ativar(idCampanha);
        }
        else {
            campanha.desativar(idCampanha);
        }

    });
}

eventoChangeAtivoCampanha();
function plotar_grafico(dados, tipo, titulo, tag_container = ".grafico-container") {

    if (JSON.stringify(dados) != JSON.stringify([0, 0, 0])) {
        let graphDiv = '<div class="card"><div class="card-header"><h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>' + titulo + '</h3></div><!-- /.card-header --><div class="card-body"><div class="tab-content p-0"><div class="chart" id="respostas-chart" style="position: relative; height: 300px;"><canvas id="respostas-chart-canvas-' + tag_container.replace('.', '') + '" height="300" style="height: 300px;"></canvas></div></div></div><!-- /.card-body --></div>';
        let tableDiv = '<tr><td colspan="2"><b>Qtd de respostas<b></td></tr><tr><td><img src="./dist/img/emojis/emoji_otimo.png" class="img-emoji"><br><span class="text-center">Ótimo</span></td><td class="valor_atual_otimo align-middle">0</td></tr><tr><td><img src="./dist/img/emojis/emoji_bom.png" class="img-emoji"><br><span class="text-center">Bom</span></td><td class="valor_atual_bom align-middle">0</td></tr><tr><td><img src="./dist/img/emojis/emoji_ruim.png" class="img-emoji"><br><span class="text-center">Ruim</span></td><td class="valor_atual_ruim align-middle">0</td></tr>';
        $(tag_container).html(graphDiv);
        $(".tabela_emoji").html(tableDiv);
        $(".tabela_emoji").show();
        if (tipo == "pizza") {
            var pieChartCanvas = $('#respostas-chart-canvas-' + tag_container.replace('.', '')).get(0).getContext('2d');
            var pieData = {
                labels: [
                    'Ruim',
                    'Bom',
                    'Ótimo'
                ],
                datasets: [
                    {
                        data: dados,
                        backgroundColor: ['#ff1717', '#b9ff17', '#17ff51']
                    }
                ]
            }
            var pieOptions = {
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                responsive: true,
                tooltipTemplate: "<%= value %>",
              
                showTooltips: true,
              
                onAnimationComplete: function() {
                  this.showTooltip(this.datasets[0].points, true);
                },
                tooltipEvents: []
            }
            // Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            // eslint-disable-next-line no-unused-vars
            var pieChart = new Chart(pieChartCanvas, { // lgtm[js/unused-local-variable]
                type: 'pie',
                data: pieData,
                options: pieOptions
            });
        }
        else if (tipo == "donut") {
            // dados precisa ser um array com 3 indices, sendo o primeiro a quantidade de ruins, o segundo a quantidade de bons e o terceiro a quantidade de ótimos
            // Donut Chart
            var pieChartCanvas = $('#respostas-chart-canvas-' + tag_container.replace('.', '')).get(0).getContext('2d')
            var pieData = {
                labels: [
                    'Ruim',
                    'Bom',
                    'Ótimo'
                ],
                datasets: [
                    {
                        data: dados,
                        backgroundColor: ['#ff1717', '#b9ff17', '#17ff51']
                    }
                ]
            }
            var pieOptions = {
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                responsive: true,
                tooltipTemplate: "<%= value %>",
              
                showTooltips: true,
              
                onAnimationComplete: function() {
                  this.showTooltip(this.datasets[0].points, true);
                },
                tooltipEvents: []
            }
            // Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            // eslint-disable-next-line no-unused-vars
            var pieChart = new Chart(pieChartCanvas, { // lgtm[js/unused-local-variable]
                type: 'doughnut',
                data: pieData,
                options: pieOptions
            });
        }
        else if (tipo == "line") {
            // "dados" precisa ser um objeto com dois atributos do tipo array: dados.labels (com as strings que nomearão o x) e dados.dados (com os números que alimentarão y).
            /* Chart.js Charts */
            // Sales chart
            var salesChartCanvas = $('#respostas-chart-canvas').get(0).getContext('2d')
            // $('#revenue-chart').get(0).getContext('2d');

            var salesChartData = {
                labels: dados.labels,
                datasets: [
                    {
                        label: "Ruim",
                        backgroundColor: 'rgba(255, 23, 23,0.3)',
                        borderColor: 'rgba(255, 23, 23,0.8)',
                        pointRadius: false,
                        pointColor: 'rgb(255, 23, 23)',
                        pointStrokeColor: 'rgba(255, 23, 23,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(255, 23, 23,1)',
                        data: dados.respostas.ruim
                    },
                    {
                        label: "Bom",
                        backgroundColor: 'rgba(185, 255, 23,0.3)',
                        borderColor: 'rgba(185, 255, 23,0.8)',
                        pointRadius: false,
                        pointColor: 'rgb(185, 255, 23)',
                        pointStrokeColor: 'rgba(185, 255, 23,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(185, 255, 23,1)',
                        data: dados.respostas.bom
                    },
                    {
                        label: "Ótimo",
                        backgroundColor: 'rgba(23, 255, 81,0.3)',
                        borderColor: 'rgba(23, 255, 81,0.8)',
                        pointRadius: false,
                        pointColor: 'rgb(23, 255, 81)',
                        pointStrokeColor: 'rgba(23, 255, 81,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(23, 255, 81,1)',
                        data: dados.respostas.otimo
                    }
                ]
            }   

            
            var salesChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                },
                tooltipTemplate: "<%= value %>",
              
                showTooltips: true,
              
                onAnimationComplete: function() {
                  this.showTooltip(this.datasets[0].points, true);
                },
                tooltipEvents: []
            }

            // This will get the first returned node in the jQuery collection.
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
            })
        }
    }
    else {
        $(tag_container).html("<p style='text-align: center'>Não há respostas.</p>");
        $(".tabela_emoji").html("");
        $(".tabela_emoji").hide();
    }
}

function gerarQRCodeLogin() {

    var qrcode = new QRCode(document.getElementById("qrcode"), {
        width: 180,
        height: 180
    });

    $.ajax(
        {
            method: "GET",
            url: "./services/hash_qrcode.php",
            success: function (data) {
                qrcode.makeCode(data.login);
            }
        }
    );
}

function gerarQRCodeApp() {
    var qrcode = new QRCode(document.getElementById("qrcode-app"), {
        width: 135,
        height: 135
    });

    qrcode.makeCode(linkAppAndroid);
}


$(".salvar-edicao-perfil").on("click", function() {
    if($("#form-edicao-perfil").valid()) {
        let dados = $("#form-edicao-perfil").serialize();
        $.ajax({
            method: "POST",
            url: "./services/editar_perfil.php",
            data: dados,
            success: function() {
                mensagem("success", "Perfil editado com sucesso!");
            },
            error: function() {
                mensagem("error", "Alguma coisa aconteceu de errado ao tentar editar o seu perfil. Tente novamente mais tarde.");
            }
        })
    }
});

$(document).ready(function() {
    // Validando campos do formulário de edição de perfil
    $("#form-edicao-perfil").validate({
        errorPlacement: function(error, element) {
            error.css('color', '#cf0202');
            error.insertAfter(element);
        },
        rules: {
            razao_social: {
                required: true,
                minlength: 3
            },
            senha_cad: {
                minlength: 6
            },
            confirmar_senha: {
                equalTo: {
                    param: "#senha_cad",
                    depends: function(element) {
                        return $("#senha_cad").val() != "";
                    }
                }
            },
            cnpj: {
                required: true,
                cnpj: true
            },
            telefone: {
                required: false,
                telefone: true
            },
            celular: {
                required: true,
                celular: true
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            razao_social: {
                required: "Digite sua nova razão social",
                minlength: "Digite sua nova razão social com pelo menos 3 caracteres"
            },
            senha_cad: {
                required: "Digite sua nova senha",
                minlength: "Digite sua nova senha com pelo menos 6 caracteres"
            },
            confirmar_senha: {
                equalTo: "Confirmação não bate com a senha"
            },
            cnpj: {
                required: "Digite seu CNPJ",
                cnpj: true
                // Criar validador para cnpj
            },
            telefone: {
                telefone: "Digite um número de telefone válido"
                // Criar validador para telefone
            },
            celular: {
                required: "Digite seu celular",
                celular: "Digite um número de celular válido"
                // Criar validador para celular
            },
            email: {
                required: "Digite seu e-mail",
                email: "Insira um e-mail válido"
            },
            cnpj: {
                required: "Digite seu CNPJ",
                cnpj: "Digite um CNPJ válido"
            },
            telefone: {
                required: "Digite seu telefone",
                telefone: "Digite um telefone válido"
            },
            celular: {
                celular: "Digite um número de celular válido"
            }
        }
    });

    // Adicionando máscara aos campos do formulário de edição de perfil
    $("#cnpj").mask("99.999.999/9999-99");
    $("#telefone").add("#celular").mask("(99) 9999-99999")
    .focusout(function (event) {  
        var target, phone, element;  
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
        phone = target.value.replace(/\D/g, '');
        element = $(target);  
        element.unmask();  
        if(phone.length > 10) {  
            element.mask("(99) 99999-9999");  
        } else {  
            element.mask("(99) 9999-99999");  
        }  
    });

    gerarQRCodeApp();
    gerarQRCodeLogin();

    
});




