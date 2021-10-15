<?php
include '_conect.php';
protect('2');

$id_logado = $_SESSION['token'];
$sql = "SELECT * FROM `acesso` WHERE `id_acesso`='$id_logado'";
$exe = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($exe);




?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAGEAMENTO POR PERFIL</title>
    <link href="GERENCIA/css/bootstrap.min.css" rel="stylesheet">
    <link href="GERENCIA/css/font-awesome.min.css" rel="stylesheet">
    <link href="GERENCIA/css/datepicker3.css" rel="stylesheet">
    <link href="GERENCIA/css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="SCRIPTS/jquery.js"></script>

    <script src="GERENCIA/js/chart.min.js"></script>
    <script src="GERENCIA/js/chart-data.js"></script>
    <script src="GERENCIA/js/easypiechart.js"></script>
    <script src="GERENCIA/js/easypiechart-data.js"></script>
    <script src="GERENCIA/js/bootstrap-datepicker.js"></script>
    <script src="GERENCIA/js/custom.js"></script>
    <script src="SCRIPTS/mascara.js"></script>
    <script src="SCRIPTS/cpf.js"></script>
    <script src="SCRIPTS/locais.js"></script>
    <script src="GERENCIA/js/bootstrap.min.js"></script>
    <script src="SCRIPTS/firebase.js"></script>
    <script src="SCRIPTS/analitic.js"></script>
    <script src="SCRIPTS/app.js"></script>

    <?php include 'GERENCIA/_script.php'; ?>
    <style>
        .print_oculto {
            display: none;
        }

        .print_over {
            visibility: hidden;
        }

        @media print {
            .noprint {
                display: none;
            }

            .print_oculto {
                display: block;
            }

            .print_over {
                visibility: visible;
            }

        }

        /*quando passa o mouse sobre o menu*/
        .nav-link:hover {
            font-weight: bold;
        }

        /*quando selecionado menu*/

        .nav-link.active {
            border-bottom: 2px solid #fff;

        }
    </style>

</head>

<body>
    <div class="container">
        <h1 class="jumbotron text-center">TAGEAMENTO AUTOMÁTICO</span></h1>

        <hr>

        <div class="templatemo-flex-row my-5">
            <div class="templatemo-content col-md-12 light-gray-bg">

                <div>
                    <div class="row noprint">
                        <div class="col-md-8">
                            <label for="">Pesquisa</label>
                            <div class="row">
                                <input type="text" class="form-control" placeholder="Nome ou numero" id="input_pesquisa" style="height: 34px !important;">
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
					<label for="">Grupo unitário</label>
					<select name="grupo" id="select_group" class="form-control"></select>
				</div> -->
                        <div class="col-md-2">

                            <label for="">Limite</label>
                            <select id="select_limit" class="form-control"></select>
                        </div>

                        <div class="col-md-2" style="padding-top: 23px;">
                            <button class="btn btn-danger btn-block" id="btn_pesquisa"><i class="fa fa-search"></i></button>
                        </div>

                    </div>
                    <br><br>
                </div>
                <div id="retorno_das_pesquisas" class="text-center noprint"></div>
                <button class="btn btn-success btn-block noprint" id='tag_geral'>
                    INICIAR TAGEAMENTO
                </button>
                <div id='barra_progresso'></div>


                <hr>
                <table class="table table-stripe noprint">
                    <tbody id="corpo_tag_todos"></tbody>
                </table>
                <hr>
                <table class="table table-bordered table-responsive-sm table-striped" id='tabela_investidor'>
                    <thead>
                        <tr id='header_list_tageamento'>
                            <th scope="col">
                                <div class="text-center noprint">
                                    <p>
                                        Todos
                                        <input type="checkbox" class="form-control" id='check_all'>
                                    </p>
                                </div>
                            </th>
                            <th scope="col">Nome</th>
                            <th scope="col">Contato</th>
                            <th scope="col">RESP TAGEAMENTO</th>




                        </tr>
                        <!-- 	<tr>
					<th colspan='4'>
						<label for="">Pesquise</label>
						<input type="text" class='form-control' pleaceholder='Pesquise' id='filtro_nome_cadastrados'>
					</th>
				</tr> -->
                    </thead>
                    <tbody id='corpo_cadastrados'>

                    </tbody>
                </table>

            </div>
        </div>


    </div>






    <script>
        READ.contatos();
        //READ.tags_geral();
        READ.tags_em_massa();

        let ID_DADOS = [];
        let ID_TAGAS = [];
        let ID_TAGAS_NOME = [];


        $("#check_all").on('click', function(e) {
            ID_DADOS = [];
            if ($("#check_all").prop("checked")) {

                $(".escolha_linha")
                    .prop("checked", true)
                    .each(function(e) {
                        let id = $(this).data('id');
                        ID_DADOS.push(id)
                    })


            } else {
                $(".escolha_linha").prop("checked", false);
                ID_DADOS = [];
            }
        })

        $("#tag_geral").on('click', function(e) {
            if (ID_DADOS == "" || ID_TAGAS == "") {
                alert('Ops!\nSelecione uma tag e um usúario')
            } else {
                //botão iniciar tageamento
                $("#tag_geral")
                    .attr('disabled', true)
                    .html('...iniciando')
                    .removeClass('btn-success')
                    .addClass('btn-secondary')


                let cont_tags = 0;
                let cont_pessoas = 0;
                let enviados = 1;
                let envio = setInterval(function() {
                    if (cont_tags == ID_TAGAS.length) {
                        cont_pessoas++;
                        cont_tags = 0;
                    } else {
                        if (cont_pessoas == ID_DADOS.length) {
                            clearInterval(envio);
                            alert('TAGEAMENTO FINALIZADO COM SUCESSO!')
                            $("#tag_geral")
                                .attr('disabled', false)
                                .html('INICIAR TAGEAMENTO')
                                .removeClass('btn-secondary')
                                .addClass('btn-success')
                            let ok = confirm('Deseja imprimir relatório?')
                            if (ok) {
                                window.print()
                            }
                        } else {
                            let id_user = ID_DADOS[cont_pessoas];
                            let id_tag = ID_TAGAS[cont_tags];
                            let nome_tag = ID_TAGAS_NOME[cont_tags];
                            cadastroDasTags(id_tag, id_user, nome_tag);
                            cont_tags++;
                            /*BARRA DE PROGRESSO*/

                            let total = ID_DADOS.length * ID_TAGAS.length

                            let porcentagem = Math.round((enviados * 100) / total);
                            let corpo_barra = ` 
		                            <hr>
		                            <div class="progress">
		                            <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: ${porcentagem}%; height:250px !important" aria-valuenow="${enviados}" aria-valuemin="0" aria-valuemax="${total}">${porcentagem}%</div>
                                    </div>
                                    <p class='text-center'>PROGRESSO DE TAGEAMENTO ${enviados+' de '+total}</p>
                                    <hr>
		                            
                                `

                            $("#barra_progresso").html(corpo_barra)
                            enviados++;
                        }
                    }

                }, 1000)
            }

        })

        function cadastroDasTags(idtag, iduser, nometag) {
            let obj = {
                id_tag: idtag,
                id_user: iduser,
                nome_tag: nometag
            }
            $.ajax({
                url: 'API/webservice.php?auth=30',
                type: 'POST',
                dataType: 'json',
                data: obj
            }).done(function(response) {
                let status = response.st;

                if (status == 0) {
                    alert(response.msg)
                } else {
                    let btn = "";
                    if (status == 1) {
                        btn = `
                    <p>
                    <span class="badge" style='background:green !important'>
                    ${response.nome_tag+": Ok"}
                    </span>
                    </p>
                    `
                    } else {
                        btn = `
                    <p>
                    <span class="badge"  style='background:red !important'>
                    ${response.nome_tag+": duplicado"}
                    </span>
                    </p>
                   
                        `
                    }

                    $("#response_" + response.id).append(btn)
                }

                console.log(response)
            })
        }



        function ret_tags_em_massa(response) {
            let indice = response.ret;
            let corpo = "";
            let count = 0;
            for (let i = 0; i < indice.length; i++) {
                if (count == 5) {
                    count = 0
                }
                if (count == 0) {
                    corpo += `<tr>`

                }

                corpo += `
			<td>
        
            <input type='checkbox' class='check_tags' 
            data-id='${indice[i].idhastag}' 
            data-nome='${indice[i].nomehastag}' id='input_check_${indice[i].idhastag}'>
            <label for="input_check_${indice[i].idhastag}">${indice[i].nomehastag}</label>
		
            </td>
            
			`
                if (count == 5) {
                    corpo += `</tr>`
                }

                count++;
            }

            $("#corpo_tag_todos").html(corpo)

            $(".check_tags").on('click', function(e) {
                let id = $(this).data('id')
                let nome = $(this).data('nome')




                if ($(this).prop("checked")) {
                    ID_TAGAS.push(id)
                    ID_TAGAS_NOME.push(nome)

                } else {
                    let arr = ID_TAGAS.indexOf(id)
                    ID_TAGAS.splice(arr, 1);

                    let arr_nome = ID_TAGAS_NOME.indexOf(nome)
                    ID_TAGAS_NOME.splice(arr_nome, 1);


                }

                console.log(ID_TAGAS)
                console.log(ID_TAGAS_NOME)

            })

        }




        $("#btn_pesquisa").on('click', function(e) {
            let valor = $("#input_pesquisa").val()
            let valor_grupo = $("#select_group").val()

            $("#check_all").prop("checked", false)
            ID_DADOS = [];

            corpo_ret = `<h1>${valor}</h1> <button class='btn btn-link' id='limpa_pesquisa'>Limpar pesquisa</button> `;
            READ.contatos(0, valor, valor_grupo);
            $("#retorno_das_pesquisas").html(corpo_ret)

            $("#limpa_pesquisa").on('click', function(e) {

                READ.contatos();
                $("#retorno_das_pesquisas").html('') //LIMPA O RESULTADO DA PESQUISA
                $("#input_pesquisa").val('');
                $("#select_group").val(-1)
                $("#check_all").prop("checked", false);
                ID_DADOS = [];

            })

        })

        function readcontatos(response) {
            console.log(response)
            let indice = response.ret;
            let corpo = "";
            if (indice !== null) {
                corpo = "";
                for (let i = 0; i < indice.length; i++) {
                    corpo += `
				<tr>
				<td>
				${[i+1]}
				<input type='checkbox' class='form-control escolha_linha ' data-id='${indice[i].id_carregamento}'>	
				</td>

				<td>
				${indice[i].nome_carregamento}
				</td>
				<td>${indice[i].phone_carregamento}</td>
                <td id='${'response_'+indice[i].id_carregamento}'></td>
                
				</tr> 
				`

                }
            } else {
                corpo += `
			<tr>
			<td  colspan='5' class='text-center'><h1>NÃO HÁ REGISTRO(S)</h1></td>
			</tr> 

			`

            }

            $("#corpo_cadastrados").html(corpo)

            let num_paginas = Math.ceil(response.num / 100);
            let corpo_select = "";
            //select_limit
            for (let i = 1; i < num_paginas; i++) {

                corpo_select += ` 
			<option value='${[i*100]}'>${[i*100]}</option>
			`
            }
            corpo_select += ` 
		<option value='${response.num}'>TODOS</option>
		`

            $(".escolha_linha").on('click', function(e) {
                let id = $(this).data('id')
                $("#check_all").prop("checked", false)

                if ($(this).prop("checked")) {
                    ID_DADOS.push(id)

                } else {

                    let arr = ID_DADOS.indexOf(id)
                    ID_DADOS.splice(arr, 1);

                }


            })
            $("#select_limit")
                .html(corpo_select)
                .on('change', function(e) {
                    let qtde = $(this).val()

                    READ.contatos(qtde);
                    //limpa pesquisa se houver
                    $("#retorno_das_pesquisas").html('') //LIMPA O RESULTADO DA PESQUISA
                    $("#input_pesquisa").val('');

                })

            $("#select_limit").val(response.pagina) //iniciar da base de pesquisa





        }



        function retacaohastags(response) {
            let indice = response.indice;
            switch (indice) {
                case 1:
                    if (response.st == 1) {
                        READ.hastags();
                        $("#input_nova_tag").val('').css('color', 'black')
                    }
                    if (response.st == 2) {
                        alert('HASTAG JÁ EXISTE');
                        $("#input_nova_tag")
                            .css('color', 'red')
                            .focus()

                    }
                    break;
                case 2:

                    READ.hastags()
                    break;
                case 3:
                    READ.hastags()

                    break;
            }
        }

        function retmontarhastags(response) {
            let indice = response.ret;

            let corpo = "";
            if (indice !== null) {
                for (let i = 0; i < indice.length; i++) {
                    let comando = ""
                    if (indice[i].ativohastag == '1') {
                        comando += `
					<button class='btn btn-primary btn-block inativar' data-id='${indice[i].idhastag}'>ATIVO</button>
					`
                    } else {
                        comando += `
					<button class='btn btn-danger btn-block ativar' data-id='${indice[i].idhastag}'>INATIVO</button>
					`
                    }
                    corpo += `
				<tr>

				<td>${indice[i].qdecad}</td>
				<td>${indice[i].nomehastag}</td>
				<td colspan="2">${comando}</td>
				</tr> 

				`
                }
            } else {
                corpo = "CARREGANDO...";
            }
            $("#list_hastag").html(corpo)
            $(".inativar").on('click', function(e) {
                let id = $(this).data('id')
                let ok = confirm('Deixar cadastrar pessoas com essas hastags?')
                if (ok) {
                    CREATE.hastags(id, 3);
                }

            })
            $(".ativar").on('click', function(e) {
                let id = $(this).data('id')
                let ok = confirm('Cadastrar pessoas com essas hastags?')
                if (ok) {
                    CREATE.hastags(id, 2);

                }

            })
        }

        function readhast_cliente(response) {
            let indice = response.TAGS;
            let corpo = "";
            if (indice !== null) {
                for (let i = 0; i < indice.length; i++) {
                    let comandoativo = "";
                    if (indice[i].ativo > 0) {
                        comandoativo += `
					<button class='btn btn-success desativar' data-id='${indice[i].idhastag}' data-user='${indice[i].id}'>ATIVO</button>
					`
                    } else {
                        comandoativo += `
					<button class='btn btn-secondary ativar' data-id='${indice[i].idhastag}' 
					data-user='${indice[i].id}'>INATIVO</button>
					`

                    }


                    corpo += `
				<tr>
				<td>${indice[i].nomehastag}</td>
				<td>
				${comandoativo}
				</td>
				</tr>
				`
                }
            } else {
                corpo += `
			<tr colspan='2'>
			<td>
			<h1>NENHUMA TAG ATIVA</h1>
			</td>
			</tr>
			`
            }

            $("#corpo_table_hast").html(corpo)
            $("#modal_tags").modal('show')
            $(".desativar").on('click', function(e) {
                $(this)
                    .attr('disabled', true)
                    .html('..aguarde')
                let id = $(this).data('id');
                let user = $(this).data('user');
                UPDATE.atualiza_hatgs(0, id, user)

            })
            $(".ativar").on('click', function(e) {
                $(this)
                    .attr('disabled', true)
                    .html('..aguarde')
                let id = $(this).data('id');
                let user = $(this).data('user');
                UPDATE.atualiza_hatgs(1, id, user)

            })
        }


        $(function() {
            $("#filtro_nome_cadastrados").keyup(function() {

                var index = $("#filtro_nome_cadastrados").parent().index();
                var nth = "#tabela_investidor td:nth-child(" + (index + 1).toString() + ")";
                var valor = $(this).val().toUpperCase();
                $("#tabela_investidor tbody tr").show();
                $(nth).each(function() {
                    if ($(this).text().toUpperCase().indexOf(valor) < 0) {
                        $(this).parent().hide();
                    }
                });

            });

            $("#tabela_investidor input").blur(function() {
                $(this).val("");
            });
        });

        function enviandoMensagemTexto(ID, TOKEN, NUMERO, MENSAGEM, CANAL) {
            let obj = {
                ID: ID,
                TOKEN: TOKEN,
                NUMERO: NUMERO,
                MENSAGEM: MENSAGEM,
                CANAL: CANAL,
                ATENDENTE: "<?= $row['nome_acesso'] ?>",
                REF_IDATENDENTE_MSG: "<?= $row['id_acesso'] ?>"
            }
            $.ajax({
                    url: 'GERENCIA/zapio/texto.php',
                    type: 'POST',
                    dataType: 'json',
                    data: obj
                })
                .done(function(response) {
                    if (response.st == 1) {
                        alert('Enviado com sucesso!');
                    } else {
                        alert('Ops! Erro ao enviar')
                    }


                })
        }
    </script>


</body>

</html>