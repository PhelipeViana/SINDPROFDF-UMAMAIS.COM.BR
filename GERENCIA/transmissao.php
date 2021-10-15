<h1 class="jumbotron text-center">LISTA DE TRANSMISSÃO 2</h1>
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
        <button class='btn btn-danger btn-block' style="margin-top:22px" disabled id='btn_busca_lista'>BUSCAR</button>
    </div>

</div>
<div id="area_listas" style="display: none;">
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
    <hr>


    <label class="text-center">TEXTO PARA ENVIAR</label>
    <textarea class='form-control' cols="30" rows="10" id="conteudo_lista"></textarea>

    <br>
    <button class='btn btn-primary btn-block' id='btn_enviar_msg_list'>Enviar</button>
    <br>
    <h3>LISTA(S) DE TRANSMISSÃO</h3>
    <table class='table table-responsive table-bordered'>
        <thead>
            <th>Nome da Lista</th>
            <th>Status Envio</th>
        </thead>
        <tbody id="corpo_lista_transmissao">

        </tbody>
    </table>
</div>



<script>
    $("#btn_enviar_msg_list").on('click', function(e) {
        $("#btn_enviar_msg_list")
            .attr('disabled', true)
            .html('...enviando')
        let txt = $("#conteudo_lista").length;
        let msg = $("#conteudo_lista").val()
        if (txt > 0) {
            let cont = 0;
            let nums = $(".phones_enviar").length;

            let envio = setInterval(function() {
                if (nums == cont) {
                    clearInterval(envio)
                    alert('enviado com sucesso!')
                    $("#conteudo_lista")
                        .val('')
                    $("#btn_enviar_msg_list")
                        .attr('disabled', false)
                        .html('Enviar')
                } else {
                    let classe = $(".phones_enviar");
                    let num = classe.eq(cont).data('num');
                    let id = classe.eq(cont).data('id');
                    let tk = classe.eq(cont).data('tk');
                    let midia = $("#midia").val()
                    $("#resp_" + num).html('ENVIADO COM SUCESSO!')
                    enviandoMensagemLista(id, tk, num, msg, midia);
                }
                cont++;

            }, 15000)



        } else {
            alert('Ops!\nTexto Vazio!')
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
            buscarLista(id, tk);
            $("#btn_busca_lista")
                .attr('disabled', true)
                .html('...buscando')
        })
    })


    function buscarLista(id, tk) {
        $.ajax({
                url: 'GERENCIA/zapio/listar_transmissao.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    ID: id,
                    TOKEN: tk
                },
            })
            .done(function(response) {

                montarAreaLista(response)
            })
    }

    function montarAreaLista(response) {
        let status = response.st;
        let nomes = response.nomes;
        let phones = response.phones;
        let id = response.ID;
        let token = response.TOKEN;

        let corpo = "";
        if (status == 0) {
            alert(response.msg)
            $("#btn_busca_lista")
                .attr('disabled', true)
                .html('NÃO CONECTADO')
        }
        if (nomes == "" || phones == "") {
            alert('Ops!\nEsse canal não possui lista ativa!')
        } else {
            $("#btn_busca_lista")
                .attr('disabled', true)
                .removeClass('btn-danger')
                .addClass('btn-success')
                .html('SUCESSO')

            for (let i = 0; i < phones.length; i++) {
                corpo += `<tr>
                <td>${nomes[i]}</td>
                <td class='phones_enviar' 
                data-num='${phones[i]}'
                data-id='${id}'
                data-tk='${token}'
                id='resp_${phones[i]}'                
                >aguardando envio</td></tr>`
            }

            $("#corpo_lista_transmissao").html(corpo)
            $("#area_listas").show()
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
                data:obj
            })
            .done(function(response) {

                console.log(response)
            })
    
    }
</script>