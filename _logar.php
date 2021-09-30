<!-- data-toggle="modal" data-target="#exampleModal" -->
<div class="modal fade" id="acesso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <h5 class="modal-title text-center" id="exampleModalLabel">ACESSAR</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body">
        <form id='logarIndex'>
          <input type="hidden" value="2" name="AUTH">
          <input type="text" class="form-control" placeholder="LOGIN" name="login" required id="cx_login">
          <br>
          <input type="password" class="form-control" placeholder="SENHA" name="senha"  required id="cx_senha">
          <br>
          <p id="alertAcesso" class="text-center" style="display: none;"></p>
          <button type="submit" class="btn_1 btn-block" id="btn_entrar">ENTRAR</button>
        </div>
      </form>
      <a href="esqueci_senha.php" class='text-center'>Esqueci a senha</a>


    </div>
  </div>
</div>
<div class="modal fade" id="cadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <h5 class="modal-title text-center" id="exampleModalLabel">SEJA BEM VINDO</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
      </button>

      <div class="modal-body">
        <form id="cadastroIndex">
         <input type="hidden" name='AUTH' value='1'>
         <input type="text" class="form-control classeCad" placeholder="Seu nome completo" name="nome" required id="nome_input" maxlength="50">
         <br>
         <input type="email" class="form-control classeCad" placeholder="Seu email" name="email" required id="email_input" maxlength="50">
         <br>
         <input type="text" class="form-control classeCad mask-phone" placeholder="Celular" 
         name="celular" required minlength="15">
         <br>
         <label for="">Estado</label>
         <select class="form-control form-control-sm classeCad" name="estado" id="estado_cad"  required>
         </select>
         <br>
         <label for="">Cidade</label>
         <select class="form-control form-control-sm classeCad" name="cidade" id="cidade_cad" required>
         </select>
         <hr>
         
         <button type="submit" class="btn_1 btn-block" id="btn_cad">ENTRAR</button>
       </form>
     </div>
   </div>
 </div>
</div>
<?php
if (isset($_GET['login'])) {
  $temp_login=$_GET['login'];
  $temp_senha=$_GET['senha'];
  ?>
  <script>
    $("#acesso").modal('show');
    $("#cx_senha").val("<?=$temp_senha;?>");
    $("#cx_login").val("<?=$temp_login;?>");
    

    


  </script>
  <?php

} 

?>


<script>

  jQuery(document).ready(function($) {
    initializeMasks();
    
    selecionar.cidade("estado_cad","cidade_cad");

  });

  function initializeMasks() {
    $(".mask-credit-card").mask("9999 9999 9999 99999");
    $(".mask-month-year").mask("99/9999");
    $(".mask-date").mask("99/99/9999");
    $(".mask-cep").mask("99999-999");
    $(".mask-cpf").mask("999.999.999-99");
    $(".mask-cnpj").mask("99.999.999/9999-99");
    $(".mask-cellphone").mask("99999-9999");
    $(".mask-onlyphone").mask("99999-9999");
    $(".mask-phone").mask("(99) 99999-9999");
    $(".mask-numhab").mask("99999999999");
    $(".mask-placa").mask("999-999");
  }

  $("#cadastroIndex").submit(function(event) {
    event.preventDefault();
    $("#btn_cad")
    .html("...autenticando email")
    .prop('disabled',true);

    let email=$("#email_input").val();


    let ok=confirm(email+"\nEstá correto?");

    if (ok) {
      $.ajax({
        url: '<?=$ENDPOINT;?>',
        type: 'POST',
        dataType: 'JSON',
        data:$("#cadastroIndex").serialize(), 
      })
      .done(function(resp) {
       if (resp.st==1) {
        alert('Verifique seu email!\n\nCaso não tenha recebido, Verifique sua caixa de spam/lixo eletrônico');
        $(".classeCad").val("");
        $("#cadastro").modal('hide');



      }else{
        alert(resp.msg);
        $("#email_input").focus();
        $("#email_input").css('color','red');
      }
    })

    }else{
      $("#email_input")
      .focus()
      .css('color','red')
    }
    $("#btn_cad")
    .html("ENVIAR")
    .prop('disabled',false);


  });

  $("#logarIndex").submit(function(event) {
    event.preventDefault();
    $("#btn_entrar")
    .html("...aguarde")
    .prop('disabled',true);

    $.ajax({
      url: '<?=$ENDPOINT;?>',
      type: 'POST',
      dataType: 'JSON',
      data:$(this).serialize(), 
    })
    .done(function(response) {

      if(response.st==1){
        $("#btn_entrar")
        .html("SUCESSO!")


        $.post('index.php', {token:response.token,acesso:response.acesso,ID_ALUNO:response.ID}, function(data, textStatus, xhr) {
          window.location.assign('index.php');
        });  
      }else{
        alert('Ops!\nErro no Login e/ou Senha!');
        $("#btn_entrar")
        .html("ENVIAR")
        .prop('disabled',false);


      }
    });




  });

</script>