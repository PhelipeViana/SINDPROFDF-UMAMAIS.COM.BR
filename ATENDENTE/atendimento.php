<?php include "ATENDENTE/atendimento_estilo.php" ?>

<div class="container">
  <div id="fila_atendimento">
  </div>
  <hr>
  <div id="area_atendimento" class="row bootstrap snippets bootdeys"></div>

</div>

<!-- Modal -->
<div class="modal fade" id="modal_cadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_numero"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_cadastro">
          <label for="">Nome</label>
          <input type="text" class="form-control" placeholder="Nome Completo" id='input_nome' name="nome" required minlength="5">
          <input type="hidden" id="input_id" name="numero">
          <input type="hidden" id="input_foto" name="foto">
          <input type="hidden" id="input_canal" name="canal">
          <label for="">Grupo unitário</label>
          <select name="grupo"  class="form-control" id="select_grupo"></select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_tags" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabeltagas">#CLASSIFICAR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h1 class="text-center">#HASTAGS</h1>
        <table class="table table-bordered table-responsive-sm">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Tag</th>
            </tr>
          </thead>
          <tbody id="corpo_table_hast">

          </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
      </div>
    </div>
  </div>
</div>

<script>
  READ.fila_atendimento()
  READ.tags_geral();
  firebase.database().ref("<?= $FIREBASE_REFER ?>").child('FILA_ATENDIMENTO').on('value', function(e) {
    READ.fila_atendimento()

  })
  function ret_tags_geral(response){
    let corpo="<option value='0'>ESCOLHA O GRUPO</option>";
    let indice=response.ret
    for(let i=0;i<indice.length;i++){
      corpo+=` <option value='${indice[i].idhastag}'>${indice[i].nomehastag}</option> `
    }
  
  $("#select_grupo").html(corpo)
  }
  READ.meus_atendimentos()

  function readmeus_atendimentos(response) {
    let corpo = "";
    let cabecario = response.nums;
    if (cabecario != null) {

      for (let cab = 0; cab < cabecario.length; cab++) {
        let status_cadastro = "";
        let refer_class = "";


        if (cabecario[cab].nome_carregamento == null) {
          status_cadastro = "<button class='btn btn-link pesquisa' data-num_pesquisa='" + cabecario[cab].phone_atendimento + "' data-canal='" + cabecario[cab].REF_CANAL_ENTRADA + "'>" + cabecario[cab].phone_atendimento + "</button> " + cabecario[cab].nome_canalzapio;
        } else {
          status_cadastro = cabecario[cab].nome_carregamento + " " + cabecario[cab].nome_canalzapio;

        }
        let comandosjacadastrado = "";

        if (cabecario[cab].id_carregamento == "0") {
          comandosjacadastrado = ` 

          `
        } else {

          if (cabecario[cab].spam == 1) {
            comandosjacadastrado = `
            <button type="button" class="btn  btn-success retirar_lista" 
            data-id='${cabecario[cab].id_carregamento}'>
            <i class="fa fa-check" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn  btn-box-tool classificar" 
            data-id='${cabecario[cab].id_carregamento}'
            data-nome='${cabecario[cab].nome_carregamento}'>
            <i class="fa fa-hashtag" aria-hidden="true"></i>
            </button>
            `
          } else {
            comandosjacadastrado = `
            <button type="button" class="btn  btn-danger inserir_lista" 
            data-id='${cabecario[cab].id_carregamento}'>
            <i class="fa fa-ban" aria-hidden="true"></i>
            </button>
            
            `
          }

        }





        corpo += ` 
        <div>
        <div class="col-md-4">
        <div class="box box-primary direct-chat direct-chat-success" id='corpo_cabeca_${cabecario[cab].id_atendimento}'>
        <div class="box-header with-border">
        <div class="pull-left">
        ${status_cadastro}
        </div>
        <div class="box-tools pull-right">

        ${comandosjacadastrado}

        <button type="button" class="btn btn-box-tool adicionar" 
        data-num='${cabecario[cab].phone_atendimento}'
        data-nome='${cabecario[cab].nome_carregamento}'
        data-foto='${cabecario[cab].foto_no_atendimento}'
        data-canal='${cabecario[cab].REF_CANAL_ENTRADA}'
        data-grupo='${cabecario[cab].ref_grupo_hastag}'>
        <i class="fa fa-plus" aria-hidden="true"></i>
        </button>

        </button>
        <button type="button" class="btn  fechar btn-danger" data-widget="remove" 
        data-atendimento='${cabecario[cab].id_atendimento}'
        data-num='${cabecario[cab].phone_atendimento}'
        >
        <i class="fa fa-times"></i>
        </button>

        </div>
        </div>
        <div class="box-body"> 

        <div class="direct-chat-messages" id='corpo_conversa_${cabecario[cab].id_atendimento}'></div>`

        // CONTEUDO A PREENCHER
        corpo += `</div>
        <div class="box-footer">
        <div class="input-group">
        <input type="text" name="Escreva..." placeholder="Digite a mensagem" class="form-control" 
        id='input_${cabecario[cab].id_atendimento}'>
        <span class="input-group-btn">
        <button type="submit" class="btn btn-primary btn-flat enviar"
        data-id='${cabecario[cab].id_canalzapio}'
        data-tk='${cabecario[cab].token_canalzapio}'
        data-num='${cabecario[cab].phone_atendimento}'
        data-canal='${cabecario[cab].REF_CANAL_ENTRADA}'

        data-indice='${cabecario[cab].id_atendimento}'
        >Enviar</button>
        </span>
        </div>
        </div>
        </div>
        </div>
        </div>
        `

        firebase.database().ref("<?= $FIREBASE_REFER ?>")
          .child('ATENDIMENTO')
          .child(cabecario[cab].id_atendimento)
          .child('time')
          .on('value', function(e) {
            READ.conversas(cabecario[cab].id_atendimento, 1);
       
          })
      }
    } else {
      corpo = `<h1 class='text-center'>NÃO HÁ ATENDIMENTO</h1>`;
    }
    $("#area_atendimento").html(corpo)
    $(".retirar_lista").on('click', function(e) {
      let id = $(this).data('id');
      let ok = confirm('Esse número NÃO RECEBERÁ novas mensagens?');
      if (ok) {
        UPDATE.retirar_lista(id)
      }

    })

    $(".inserir_lista").on('click', function(e) {
      let id = $(this).data('id');
      let ok = confirm('Esse número  RECEBERÁ novas mensagens?');
      if (ok) {
        UPDATE.adicionar_lista(id)
      }


    })
    $(".enviar").on('click', function(e) {
      let indice = $(this).data('indice');
      let valor = $("#input_" + indice).val();
      let id = $(this).data('id');
      let tk = $(this).data('tk');
      let num = $(this).data('num');
      let canal = $(this).data('canal');


      if (valor.length > 0) {
        $("#input_" + indice)
          .val('').focus();
        enviandoMensagemTexto(id, tk, num, valor, canal, "<?= $row['nome_acesso'] ?>", indice);

      } else {
        alert('Caixa de mensagem vazia!')
        $("#input_" + indice).focus();
      }
    })
    $('.adicionar').on('click', function(e) {
      let num = $(this).data('num');
      let nome = $(this).data('nome');
      let foto = $(this).data('foto');
      let canal = $(this).data('canal');
      let id_grupo = $(this).data('grupo');
      

      let retorno = "";
      if (nome == "") {
        retorno = 'NÃO CADASTRADO';
      } else {
        retorno = nome;
      }

      $("#input_nome").val(nome)
      $("#input_id").val(num)
      $("#input_foto").val(foto)
      $("#input_canal").val(canal)
      $("#select_grupo").val(id_grupo)
            


      $("#titulo_numero").html(retorno)
      $("#modal_cadastro").modal('show'); //modal cadastro
    })

    $(".fechar").on('click', function(e) {
      let id = $(this).data('atendimento');
      let num = $(this).data('num');

      let ok = confirm('Deseja encerrar esse atendimento?')
      if (ok) {
        DELETE.atendimento(id, num)

      }

    })
    $(".classificar").on('click', function(e) {
      let id = $(this).data('id');

      READ.hast_cliente(id)


    })
    $(".pesquisa").on('click', function(e) {
      let num_pesquisa = $(this).data('num_pesquisa');
      let canal = $(this).data('canal');




      UPDATE.alterar_numero(num_pesquisa, canal)

    })



  }

  function ret_alterar_numero(response) {
    let status = response.st;
    if (status == 0) {
      alert('NÃO EXISTE NO BANCO\nFavor cadastra-lo!');
    } else {
      alert('Atualizado com sucesso!')
      READ.meus_atendimentos();
    }
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
    // console.log(response)
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

  $("#form_cadastro").submit(function(event) {
    event.preventDefault();
    UPDATE.cadastramento("form_cadastro")

  });

  function updatecadastramento(response) {
    $("#modal_cadastro").modal('hide');
    alert(response.msg);
    READ.meus_atendimentos();

  }

  function readconversas(response, io) {
    let MSG = response.MSG;
    let foto = response.FOTO;
    if (foto == "") {
      foto = "https://dadosmobile.com/whats.png";
    } else {
      foto = foto;

    }


    let corpo = "";
    for (let i = 0; i < MSG.length; i++) {


      //TRATIVA DE MIDIA
      let descricao_msg = "";
      if (MSG[i].leitura == 'text') {
        if (MSG[i].mensagem == "") {
          descricao_msg = `
       <div style="width: 20rem;">
       .....
       </div>
       `
          //MSG[i].json_response
        } else {
          descricao_msg = `
       <div style="width: 20rem;">
       ${MSG[i].mensagem}
       </div>
       `
        }

      }
      if (MSG[i].leitura == 'audio') {
        descricao_msg = `
    <audio controls='controls' style='max-width: 90%'><source src='${MSG[i].mensagem}'></audio>

    <a href='${MSG[i].mensagem}' target='_blank'><i class="fa fa-eye" aria-hidden="true"></i></a>
    `
      }

      if (MSG[i].leitura == 'image') {
        descricao_msg = `
   <img src='${MSG[i].mensagem}' class='img-thumbnail'>
   <a href='${MSG[i].mensagem}' target='_blank'><i class="fa fa-eye" aria-hidden="true"></i></a>
   `
      }
      if (MSG[i].leitura == 'video') {
        descricao_msg = `
  <div class="embed-responsive embed-responsive-16by9">
  <iframe src="${MSG[i].mensagem}" frameborder="0" allowfullscreen></iframe>
  </div>

  <a href='${MSG[i].mensagem}' target='_blank'><i class="fa fa-eye" aria-hidden="true"></i></a>
  `
      }

      if (MSG[i].leitura == 'sticker') {
        descricao_msg = `
 <img src='${MSG[i].mensagem}' class='img-thumbnail'>
 <a href='${MSG[i].mensagem}' target='_blank'><i class="fa fa-eye" aria-hidden="true"></i></a>
 `
      }

      if (MSG[i].tipo == 1) {
        //pergunta do cliente
        corpo += ` 
<div class="direct-chat-msg">
<img class="direct-chat-img" src="${foto}" alt="User Picture">
<div class="direct-chat-text">
${descricao_msg}
</div>
<div class="direct-chat-info clearfix">
<span class="direct-chat-name pull-left">
${response.PHONE}
</span>
<span class="direct-chat-timestamp pull-right">
<i class="fa fa-clock-o" aria-hidden="true"></i>
${MSG[i].data_mensagem}
</span>
</div>
</div>
`
      } else {
        //resposta do atendente
        corpo += `
  <div class="direct-chat-msg right">
  <img class="direct-chat-img" src="https://dadosmobile.com/whats.png" alt="Message User Image">
  <div class="direct-chat-text">
  ${descricao_msg}
  </div>
  <div class="direct-chat-info clearfix">
  <span class="direct-chat-name pull-right">${MSG[i].idzap}</span>
  <span class="direct-chat-timestamp pull-left text-danger">${MSG[i].data_mensagem}</span>
  </div>
  </div>
  `
      }

    }
    $("#corpo_conversa_" + response.ATENDIMENTO).html(corpo);
    var objScrDiv = document.getElementById("corpo_conversa_" + response.ATENDIMENTO);
    objScrDiv.scrollTop = objScrDiv.scrollHeight;
    if (io == 1) {
      $("#corpo_cabeca_" + response.ATENDIMENTO)
        .removeClass('box-primary')
        .addClass('box-danger')
    } else {

      $("#corpo_cabeca_" + response.ATENDIMENTO)
        .removeClass('box-danger')
        .addClass('box-primary')
    }




  }


  function readfila_atendimento(response) {
    let num_pendentes = response.num_pendentes
    let corpo = "";
    if (num_pendentes > 0) {
      corpo = ` 
    <button class="btn btn-block btn-danger pegar_atendimento">
    ${num_pendentes} <i class="fa fa-download" aria-hidden="true"></i>
    </button>
    `
    } else {
      corpo = `
    <button class="btn btn-secondary btn-block atendimento_zerado">
    0 <i class="fa fa-check" aria-hidden="true"></i>
    </button> 
    `
    }
    $("#fila_atendimento").html(corpo)
    $(".pegar_atendimento").on('click', function(e) {
      $(".pegar_atendimento").attr('disabled', true);
      UPDATE.pegar_atendimento(".pegar_atendimento")
    })
    $(".atendimento_zerado").on('click', function(e) {
      alert('Não há atendimento pendente')
    })


  }


  function enviandoMensagemTexto(ID, TOKEN, NUMERO, MENSAGEM, CANAL, ATENDENTE, IDATENDIMENTO) {
    let obj = {
      ID: ID,
      TOKEN: TOKEN,
      NUMERO: NUMERO,
      MENSAGEM: MENSAGEM,
      CANAL: CANAL,
      ATENDENTE: ATENDENTE,
      REF_IDATENDENTE_MSG: "<?= $row['id_acesso'] ?>"
    }
    $.ajax({
        url: 'ATENDENTE/zapio/texto.php',
        type: 'POST',
        dataType: 'json',
        data: obj,
      })
      .done(function(response) {
        READ.conversas(IDATENDIMENTO);
      }).always(function() {
        //rolagem ao responder
        setTimeout(function() {
          var objScrDiv = document.getElementById("corpo_conversa_" + IDATENDIMENTO);
          objScrDiv.scrollTop = objScrDiv.scrollHeight;
          //rolagem ao responder

        }, 500)


      });
  }
</script>