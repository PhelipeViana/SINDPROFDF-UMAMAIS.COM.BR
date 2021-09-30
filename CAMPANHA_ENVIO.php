<?php 
include '_conect.php';

$id=$_REQUEST['id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CAMPANHA <?=$id?></title>
	<script src="SCRIPTS/jquery.js"></script>
	<link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
	<link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<h1 class="jumbotron text-center">CAMPANHA <?=$id?></h1>
		<hr>
		<button class="btn btn-block btn-success" id="iniciar_acao">INICIAR</button>
		<hr>
		<a href="CAMPANHA_ENVIO.php?id=<?=$id?>">
			<button class="btn btn-danger btn-block" style="display: none;" id='reiniciar'>PARA/REINICIAR</button>
		</a>
		<hr>
		<div id="area_de_envio">
			<div class="row">
				<div class="col-sm-4">
					<button class="btn-link" id='ncompleto'>NOME COMPLETO <i class="fa fa-hand-o-down" aria-hidden="true"></i></button>
				</div>
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<button class="btn-link" id='pnome'>PRIMEIRO NOME<i class="fa fa-hand-o-down" aria-hidden="true"></i></button>

				</div>
			</div>
			
			<select id="midia" class="form-control">
				<option value="0">SOMENTE MENSAGEM</option>
				<?php 

				$sql_arq="SELECT * FROM `arquivos` order by idArquivo desc";
				$e_arq=mysqli_query($conn,$sql_arq);

				while ($row=mysqli_fetch_assoc($e_arq)) {
					?>
					<option value="<?=$row['linkArquivo']?>"><?=$row['nomeArquivo']?></option>
					<?php 
				}

				?>


			</select>
			<hr>
			<label for="">MENSAGEM</label>
			<textarea  id="txt_mensagem" cols="30" rows="10" class="form-control" required minlength="5"></textarea>
			<!-- LINKS -->
			
	<!-- 		<label for="">LINKS DE RESPOSTA</label>
			<select id="opcoes_link" class="form-control">
				<option value="0">SEM LINK</option>
				<option value="1">1 OPÇÃO</option>
				<option value="2">2 OPÇÕES</option>
				<option value="3">3 OPÇÕES</option>
			</select>
			<hr>
			<div id="inputs_links"></div>  -->

			<!-- FIM LINKS -->
			<hr>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#id</th>
						<th scope="col">NOME</th>
						<th scope="col">TELEFONE</th>
						<th scope="col">RETORNO</th>
					</tr>
				</thead>
				<tbody>
					<?php 

					$sql="SELECT * FROM `listagem_envio` WHERE `REF_CAMP`='$id' and enviado=0 limit 100";
					$e=mysqli_query($conn,$sql);
					$num_pendentes=mysqli_num_rows($e);

					while ($r=mysqli_fetch_assoc($e)) {
						?>
						<tr>
							<td><?=$r['id_list'];?></td>
							<td><?=$r['nome_list'];?></td>
							<td><?=$r['num_list'];?></td>
							<td class='resultado'
							data-nome='<?=$r['nome_list'];?>'
							data-numero='<?=$r['num_list'];?>'
							data-id='<?=$r['idzaio_list'];?>'
							data-tk='<?=$r['tokenzapio_list'];?>'
							data-reflist='<?=$r['id_list'];?>'
							>NA FILA</td>

						</tr>


						<?php 
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
	<script>
		/*CRIAR LINKS DE RESPOSTA*/
		$("#opcoes_link").change(function(event) {
			/* Act on the event */
			let qtde=$(this).val();
			let corpo="";
			if (qtde > 0) {
				for(let i=0; i < qtde; i++){
					corpo+=`<label>Resposta ${[i+1]} *não pode ser vazio</label>
					<input type="text" class="form-control links" value="${[i+1]}">
					<br>`
				}

				$("#inputs_links").html(corpo);
			}else{
				$("#inputs_links").html('');
			}
		});
		let envio="";
		let pendentes_envios="<?=$num_pendentes?>";
		if(pendentes_envios < 1){
			alert('CAMPANHA JÁ FINALIZADA');
			$("#iniciar_acao")
			.html('ENVIO CONCLUIDO')
			.removeClass('btn-success')
			.addClass('btn-danger')
			.on('click',function(e){
				alert('CAMPANHA JÁ FINALIZADA');

			})
			$("#area_de_envio").hide()
		}else{
			$("#iniciar_acao").on('click',function(e){
				let qtde=$('.resultado').length;
				let contador=0;
				let contador_console=contador+1
				let tempo=1000;
				let btn_acao=$("#iniciar_acao");

				let MSG=$("#txt_mensagem").val()
				if(MSG.length > 3){
					btn_acao.attr('disabled',true).text('iniciando....')
					$("#reiniciar").show()

					let envio=setInterval(function(){ 
						let variavel=$('.resultado').eq(contador);
						variavel.html('enviado');
						btn_acao.text(contador_console+" / "+qtde);

			//chamar a funcao de envio
			
			
			let NOME=variavel.data('nome');
			let NUM=variavel.data('numero');
			let ID=variavel.data('id');
			let TK=variavel.data('tk');
			let REF_LIST=variavel.data('reflist');

			
			let IDCAMPANHA="<?=$id?>";
			let midia=$("#midia").val()


			if(tempo > 5000){
				tempo=1000
			}else{
				tempo+=1000
			}
			/*TRATATIVA DOS LINKS*/
			let array_links=[];
			let classe=document.getElementsByClassName("links");
			for(let i=0;i<classe.length;i++){
				array_links.push(classe[i].value);
			}

			



			processandoEnvio(NOME,NUM,ID,TK,IDCAMPANHA,midia,MSG,REF_LIST,array_links);

			contador++;
			contador_console++;
			if(contador==qtde){
				clearInterval(envio);
				alert('FINALIZOU')
			}
		}, 5000);

				}else{
					$("#txt_mensagem").focus()
					alert('Mensagem vazia')
				}

			})




		}
		
		$("#pnome").on('click',function(e){
			let input=$("#txt_mensagem")
			let valor=input.val();
			input
			.val(valor+' '+' <pnome> ')
			.focus()
		})


		$("#ncompleto").on('click',function(e){
			let input=$("#txt_mensagem")
			let valor=input.val();
			input
			.val(valor+' '+' <nome> ')
			.focus()
		})

		

		function processandoEnvio(NOME,NUM,ID,TK,IDCAMPANHA,midia,MSG,REF_LIST,array_links){
			let obj={
				NOME:NOME,
				NUM:NUM,
				ID:ID,
				TK:TK,
				IDCAMPANHA:IDCAMPANHA,
				midia:midia,
				MSG:MSG,
				REF_LIST:REF_LIST,
				link:array_links
			}
			$.ajax({
				url: 'RETORNO_CAMPANHA.php',
				type: 'POST',
				dataType: 'json',
				data: obj
			})
			.done(function(response) {
				let status=response.st
				if(status==0){
					clearInterval(envio);
					alert('SEM CONEXÃO!!!')
					location.assign('CAMPANHA_ENVIO.php?id=<?=$id?>');
				}

			})

			
		}
	</script>
</body>
</html>