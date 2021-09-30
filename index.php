<?php 
include '_validar.php';
verificar()


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INICIO</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="index.css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="SCRIPTS/jquery.js"></script>

</head>
<body>

  <div class="wrapper fadeInDown">
    <div id="formContent">
      <div class="fadeIn first">
        <img src="dadosmobileIcon.png" id="icon" alt="User Icon"  style="width: 150px">
      </div>

      <form id="form_login">
        <input type="hidden" name="auth"  value="1">
        <input type="text" id="login" class="fadeIn second input_formulario" name="login" placeholder="Login" required>
        <input type="password" id="senha" class="fadeIn second input_formulario" name="senha" placeholder="Senha"  required>
        <button type="submit" class="btn btn-warning btn-block" id="btn_entrar">ENTRAR</button>
      </form>
    </div>
  </div>
  <script>
    $("#form_login").submit(function(e){
      $("#btn_entrar")
      .attr('disabled',true)
      .text('VALIDANDO...')
      e.preventDefault();
      $.ajax({
        url: '<?=$ENDPOINT?>',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
      })
      .done(function(response) {
        let status=response.st;
        if(status==1){
         $("#btn_entrar")
         .attr('disabled',true)
         .text('SUCESSO')
         $.post('index.php', {token: response.tk,acesso:response.acesso}, function(data, textStatus, xhr) {
          window.location.assign('index.php');
        });
       }else{
        alert('erro no login')
      }

    })      
    })
  </script>
</body>
</html>

