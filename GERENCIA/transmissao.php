<h1 class="jumbotron text-center">LISTA DE TRANSMISSÃO 3</h1>

<div id="area_listas">
    <hr>
    <br>
    <label for="">Tipo de mensagem</label>
    <select id="midia" class="form-control">
        <option value="0">SOMENTE MENSAGEM</option>
        <?php

        $sql_arq = "SELECT * FROM `arquivos` order by idArquivo desc";
        $e_arq = mysqli_query($conn, $sql_arq);

        while ($row = mysqli_fetch_assoc($e_arq)) {
        ?>
            <option value="<?= $row['linkArquivo'] ?>"><?= $row['nomeArquivo'] ?></option>
        <?php
        }

        ?>
    </select>

    <label class="text-center">TEXTO PARA ENVIAR</label>
    <textarea class='form-control' cols="30" rows="10" id="conteudo_lista"></textarea>
    <br>
    <hr>
    <button class="btn btn-block btn-danger" id="iniciar_testar">TESTAR ANTES</button>
    <hr>
    <button class='btn btn-primary btn-block' id='btn_enviar_msg_list' disabled>Enviar</button>
    <br>
    <!-- 
    <div class="row">
        <div class="col-md-10">
            <label for="">Canal da lista</label>
            <select name="" id="canal_lista" class="form-control">
                <option value="0">SELECIONE O CANAL</option>
                <?php
                $sql_canais = "SELECT * FROM `canaiszapio`";
                $exe_canais = mysqli_query($conn, $sql_canais);
                while ($r = mysqli_fetch_assoc($exe_canais)) {
                ?>
                    <option value="<?= $r['idcanalzapio']; ?>" data-tk="<?= $r['token_canalzapio']; ?>" data-id="<?= $r['id_canalzapio']; ?>"><?= $r['nome_canalzapio']; ?>
                    </option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class='btn btn-danger btn-block' style="margin-top:22px" disabled id='btn_busca_lista'>ATUALIZAR</button>
        </div>

    </div>
     -->
    <h3>LISTA(S) DE TRANSMISSÃO</h3>
    <table class='table table-responsive table-bordered'>
        <thead>
            <th>
                <div class="text-center noprint">
                    <p>
                        Todos
                        <input type="checkbox" class="form-control" id='check_all' checked>
                    </p>
                </div>
            </th>
            <th>Nome da Lista</th>
            <th>Status Envio</th>
        </thead>
        <tbody id="corpo_lista_transmissao">

        </tbody>
    </table>
</div>
<div class="modal fade" id="modal_teste_envio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TESTAR ENVIO DA LISTA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <label for="">CANAL</label>
                <select name="" id="seleciona_canal_teste" class="form-control">
                    <option value="0">SELECIONE O CANAL</option>
                    <?php
                    $sql_canais = "SELECT * FROM `canaiszapio`";
                    $exe_canais = mysqli_query($conn, $sql_canais);
                    while ($r = mysqli_fetch_assoc($exe_canais)) {
                    ?>
                        <option value="<?= $r['idcanalzapio']; ?>" data-tk="<?= $r['token_canalzapio']; ?>" data-id="<?= $r['id_canalzapio']; ?>"><?= $r['nome_canalzapio']; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>

                <label for="">Numero</label>
                <input type="text" id="numero_teste" class="form-control mask-phone">

                <input type="hidden" id="token_envio_teste" value="0">
                <input type="hidden" id="id_envio_teste" value="0">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='btn_envia_teste'>ENVIAR TESTE</button>


                <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
            </div>
        </div>
    </div>
</div>




<script>
    READ.listas_tranmissao();
    let ID_SELECIONADO = [];
    $("#iniciar_testar").on('click', function(e) {
        let cx_msg = $("#conteudo_lista").val()
        if (cx_msg.length < 1) {
            alert('ops! mensagem vazia')
            $("#cx_msg").focus()
        } else {
            $("#modal_teste_envio").modal('show')
        }
    })

    jQuery(document).ready(function($) {
        $(".mask-phone").mask("(99) 99999-9999");
    });
    $("#seleciona_canal_teste").on('change', function(e) {
        let valor = $("#seleciona_canal_teste").val()
        let id = $("#seleciona_canal_teste :selected").data('id')
        let tk = $("#seleciona_canal_teste :selected").data('tk')

        if (valor > 0) {
            $("#token_envio_teste").val(tk);
            $("#id_envio_teste").val(id);
            $("#btn_envia_teste").attr('disabled',false)

        } else {
            $("#token_envio_teste").val(0);
            $("#id_envio_teste").val(0);
            $("#btn_envia_teste").attr('disabled',true)
        }
    })

    $("#btn_envia_teste").on('click', function(e) {
        let tk = $("#token_envio_teste").val();
        let id = $("#id_envio_teste").val();

        let midia = $("#midia").val()
        let cx_msg = $("#conteudo_lista").val()
        let num1 = $("#numero_teste").val()
        let num2 = num1.replace("(", "");
        let num3 = num2.replace(")", "")
        let num4 = num3.replace("-", "");
        let num = '55' + num4.replace(" ", "");



        if (tk == 0 || id == 0) {
            alert('OPS! SELECIONE O CANAL');

        } else {
            //console.log('id: ' + id + ' tk: ' + tk + ' nome: ' + nome + ' numeroreplace: ' + num)
            if (num.length < 13) {
                alert('Ops! Número inválido')
                $("#numero_teste")
                    .focus()
                    .css('color', 'red')
            } else {
                $("#btn_envia_teste")
                    .attr('disabled', true)
                    .html('...enviando')

                enviandoMensagemLista(id, tk, num, cx_msg, midia);

                $("#numero_teste").css('color', 'black')
            }

        }


    })

    $("#check_all").on('click', function(e) {
        ID_SELECIONADO = [];
        if ($("#check_all").prop("checked")) {

            $(".escolha_linha")
                .prop("checked", true)
                .each(function(e) {
                    let id = $(this).data('id');
                    ID_SELECIONADO.push(id);
                    $("#linha_" + id).css('color', 'blue')
                })
            // console.log(ID_SELECIONADO)

        } else {
            $(".escolha_linha").prop("checked", false);
            ID_SELECIONADO = [];
            $(".linha").css('color', 'red')
            //console.log(ID_SELECIONADO)

        }
    })



    function montarListaFixa(response) {


        let corpo = "";
        if (response != null) {
            for (let i = 0; i < response.length; i++) {
                corpo += `<tr id='linha_${response[i].phone_transmissao}' class='linha'>
                <td>
                ${[i+1]}
                <input type='checkbox' class='form-control escolha_linha' 
                data-id='${response[i].phone_transmissao}' checked>
                </td>
                <td>${response[i].nome_tranmissao}</td>
                <td class='st_envios'
                data-num='${response[i].phone_transmissao}'
                data-id='${response[i].id_canalzapio}'
                data-tk='${response[i].token_canalzapio}'
                id='resp_${response[i].phone_transmissao}'>...</td>
                </tr>`
                ID_SELECIONADO.push(response[i].phone_transmissao)

            }


        } else {
            corpo += `<tr>
                <td colpan='4'>NENHUMA LISTA DE TRANSMISSÃO ATIVA</td>
                </tr>
               `
        }
        $("#corpo_lista_transmissao").html(corpo)
        $(".linha").css('color', 'blue')


        $(".escolha_linha").on('click', function(e) {

            let id = $(this).data('id')
            $("#check_all").prop("checked", false)

            if ($(this).prop("checked")) {
                ID_SELECIONADO.push(id);
                $("#linha_" + id).css('color', 'blue')
            } else {
                let arr = ID_SELECIONADO.indexOf(id)
                ID_SELECIONADO.splice(arr, 1);
                $("#linha_" + id).css('color', 'red')

            }


        })
    }



    $("#conteudo_lista").keyup(function(e) {
        let txt = $(this).val();
        if (txt.length > 0 && ID_SELECIONADO.length > 0) {
            $("#btn_enviar_msg_list").attr('disabled', false)

        } else {
            $("#btn_enviar_msg_list").attr('disabled', true)
        }

    })



    $("#btn_enviar_msg_list").on('click', function(e) {

        $(".st_envios").html('...'); //altera o status quando faz outro envio

        let txt = $("#conteudo_lista").length;
        let msg = $("#conteudo_lista").val()
        let num_selecionado = ID_SELECIONADO.length;
        if (msg.length > 0 && ID_SELECIONADO.length > 0) {
            let cont = 0;
            let nums = ID_SELECIONADO.length;
            $("#btn_enviar_msg_list")
                .attr('disabled', true)
                .html('...enviando')

            let envio = setInterval(function() {

                if (nums == cont) {
                    clearInterval(envio)
                    alert('enviado com sucesso!')
                    $("#conteudo_lista")
                        .val('')
                    $("#btn_enviar_msg_list").html('Enviar')


                    $(".escolha_linha").attr('disabled', false)
                    $("#midia").attr('disabled', false)
                    $("#conteudo_lista").attr('disabled', false)
                    $("#check_all").attr('disabled', false)
                    $("#iniciar_testar").attr('disabled', false)



                } else {
                    let indice = ID_SELECIONADO[cont];
                    let classe = $("#resp_" + indice);
                    let num = classe.data('num');
                    let id = classe.data('id');
                    let tk = classe.data('tk');
                    let midia = $("#midia").val()
                    classe.html('ENVIADO COM SUCESSO!')
                    enviandoMensagemLista(id, tk, num, msg, midia);
                    //console.log('ID-> '+id + 'TOKEN-> ' + tk + 'NUMERO-> ' + num);
                    // configurações de envio id, tk, num, msg, midia

                    $(".escolha_linha").attr('disabled', true)
                    $("#midia").attr('disabled', true)
                    $("#conteudo_lista").attr('disabled', true)
                    $("#check_all").attr('disabled', true)
                    $("#iniciar_testar").attr('disabled', true)

                }
                cont++;

            }, 20000)
        } else {
            alert('Ops!\nVerifique a mensagem e os destinatários')
            $("#conteudo_lista").focus()
        }
    })

    $("#canal_lista").change(function(e) {
        let valor = $(this).val();
        let id = $("#canal_lista :selected").data('id')
        let tk = $("#canal_lista :selected").data('tk')
        if (valor > 0) {
            $("#btn_busca_lista").attr('disabled', false)
        } else {
            $("#btn_busca_lista").attr('disabled', true)
        }
        $("#btn_busca_lista").on('click', function(e) {
            buscarLista(id, tk, valor);
            $("#btn_busca_lista")
                .attr('disabled', true)
                .html('...atualizando')
        })
    })


    function buscarLista(id, tk, valor) {
        $.ajax({
                url: 'GERENCIA/zapio/listar_transmissao.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    ID: id,
                    TOKEN: tk,
                    CANAL: valor
                },
            })
            .done(function(response) {

                atualizarLista(response)
            })
    }

    function atualizarLista(response) {
        let status = response.st;

        if (status == 0) {
            alert('Ops! Aparelho desconectado')
        } else {
            alert('Atualizado com sucesso!')

            $("#btn_busca_lista")
                .attr('disabled', false)
                .html('ATUALIZADO')
            READ.listas_tranmissao();

        }

    }

    function enviandoMensagemLista(id, tk, num, msg, midia) {
        let obj = {
            ID: id,
            TOKEN: tk,
            NUMERO: num,
            MSG: msg,
            MIDIA: midia

        }
        $.ajax({
                url: 'GERENCIA/zapio/envio_listat.php',
                type: 'POST',
                dataType: 'json',
                data: obj
            })
            .done(function(response) {
                $("#btn_envia_teste")
                    .attr('disabled', false)
                    .html('ENVIADO')

                console.log(response)
            })

    }
</script>