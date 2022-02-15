<?php
include '_conect.php';
$data = date('Y-m-d');

$SQL_CANAL = "SELECT * FROM `canaiszapio` WHERE `idcanalzapio`=2";
$EXE_CANAL = mysqli_query($conn, $SQL_CANAL);
$ROW_CANAL = mysqli_fetch_assoc($EXE_CANAL);

$ARRAY_GRUPO = ['0', 'APOSENTADOS', 'ATIVOS', 'ENCONTRADOS', 'EM_BRANCO'];
$SELECIONADO = "";

$limit = $_REQUEST['limit'];
if (isset($limit) && !empty($limit)) {
	if (is_numeric($limit)) {
		$LIMITE_CONTATOS = $limit;
	} else {
		$LIMITE_CONTATOS = 100;
	}
} else {
	$LIMITE_CONTATOS = 100;
}

?>


<!DOCTYPE html>
<html lang="pt">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BASE FRIA</title>
	<script src="SCRIPTS/jquery.js"></script>
	<link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
	<link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
	<?php
	$sql_envios_dia = "SELECT * FROM `LOG_ENVIO` WHERE `date` > '$data'";
	$exe_envios_dia = mysqli_query($conn, $sql_envios_dia);
	$num_envios = mysqli_num_rows($exe_envios_dia);
	?>
	<div class="container">
		<h1 class="jumbotron text-center">CANAL DE ENVIO <?= $ROW_CANAL['nome_canalzapio'] ?></h1>
		<p>MENSAGENS ENVIADAS NO DIA : <?=$num_envios?></p>
		<div id="rel_status"></div>
		<hr>
		<div class="row text-center">
			<label for="">Escolher Categoria: </label>
			<a href='?limit=<?= $limit ?>'><button class='btn'>TODOS</button><a>
					<?php
					for ($num = 1; $num < count($ARRAY_GRUPO); $num++) {

						if ($_GET['filtro'] == $ARRAY_GRUPO[$num]) {
							$class = "btn-danger";
							$SELECIONADO = "AND grupo='" . $num . "'";
						} else {
							$class = "btn-secondary";
						}


					?>


						<a href='?filtro=<?= $ARRAY_GRUPO[$num] . '&limit=100' ?>'><button class='btn <?= $class ?>'><?= $ARRAY_GRUPO[$num] ?></button><a>



							<?php
						}
							?>
		</div>
		<hr>
		<button class="btn btn-block btn-success" id="iniciar_acao">INICIAR</button>
		<hr>
		<a href="BASEFRIA.php">
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
			<label for="">MENSAGEM</label>
			<textarea id="txt_mensagem" cols="30" rows="10" class="form-control" required minlength="5"></textarea>
			<hr>
			<!-- LINKS -->

			<!-- 			<label for="">LINKS DE RESPOSTA</label>
			<select id="opcoes_link" class="form-control">
				<option value="0">SEM LINK</option>
				<option value="1">1 OPÇÃO</option>
				<option value="2">2 OPÇÕES</option>
				<option value="3">3 OPÇÕES</option>
			</select>
			<hr>
			<div id="inputs_links"></div> -->

			<!-- FIM LINKS -->
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


					$sql = "SELECT * FROM `DISPAROS` WHERE `enviado`=0 $SELECIONADO limit $limit ";
					//$sql="SELECT * FROM `DISPAROS` WHERE `id_disparos`=31744";

					$e = mysqli_query($conn, $sql);
					$num_pendentes = mysqli_num_rows($e);

					while ($r = mysqli_fetch_assoc($e)) {
					?>
						<tr>
							<td><?= $r['id_disparos']; ?></td>
							<td><?= $r['nome_disparo']; ?></td>
							<td><?= $r['num_disparo']; ?></td>
							<td><?= $ARRAY_GRUPO[$r['grupo']]; ?></td>

							<td class='resultado' data-nome='<?= $r['nome_disparo']; ?>' data-numero='<?= $r['num_disparo']; ?>' data-id="<?= $ROW_CANAL['id_canalzapio'] ?>" data-tk="<?= $ROW_CANAL['token_canalzapio'] ?>" data-reflist='<?= $r['id_disparos']; ?>'>NA FILA</td>

						</tr>


					<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>

	<?php

	$sql_enviados = "SELECT * FROM `DISPAROS` WHERE `enviado` > 0 $SELECIONADO";
	$e = mysqli_query($conn, $sql_enviados);
	$num_enviados = mysqli_num_rows($e);


	$sql_nao = "SELECT * FROM `DISPAROS` WHERE `enviado` =0 $SELECIONADO";
	$e_n = mysqli_query($conn, $sql_nao);
	$num_nao = mysqli_num_rows($e_n);

	$sql_tt = "SELECT * FROM `DISPAROS`";
	$e_tt = mysqli_query($conn, $sql_tt);
	$num_tt = mysqli_num_rows($e_tt);

	?>
	<script>
		/*CRIAR LINKS DE RESPOSTA*/
		$("#opcoes_link").change(function(event) {
			/* Act on the event */
			let qtde = $(this).val();
			let corpo = "";
			if (qtde > 0) {
				for (let i = 0; i < qtde; i++) {
					corpo += `<label>Resposta ${[i+1]} *não pode ser vazio</label>
					<input type="text" class="form-control links" value="${[i+1]}">
					<br>`
				}

				$("#inputs_links").html(corpo);
			} else {
				$("#inputs_links").html('');
			}
		});
		let enviados = <?= $num_enviados ?>;
		let nenviados = <?= $num_nao ?>;
		let total = <?= $num_tt ?>;
		let porcentagem = Math.round((enviados * 100) / total);
		let corpo = ` 
		<p class='text-center'>PROGRESSO DE ENVIO ${enviados+' de '+total}</p>
		<div class="progress">
		<div class="progress-bar" role="progressbar" style="width: ${porcentagem}%;" aria-valuenow="${enviados}" 
		aria-valuemin="0" aria-valuemax="${total}">${porcentagem}%</div>
		</div>
		<p class='text-center'>PENDENTES DE ENVIO ${nenviados}</p>
		
		`
		$("#rel_status").html(corpo)
		let envio = "";

		$("#iniciar_acao").on('click', function(e) {
			let qtde = $('.resultado').length;
			let contador = 0;
			let contador_console = contador + 1
			let tempo = 1000;
			let btn_acao = $("#iniciar_acao");

			let MSG = $("#txt_mensagem").val()
			if (MSG.length > 3) {
				btn_acao.attr('disabled', true).text('iniciando....')
				$("#reiniciar").show()

				let envio = setInterval(function() {
					let variavel = $('.resultado').eq(contador);
					variavel.html('enviado');
					btn_acao.text(contador_console + " / " + qtde);

					//chamar a funcao de envio


					let NOME = variavel.data('nome');
					let NUM = variavel.data('numero');
					let ID = variavel.data('id');
					let TK = variavel.data('tk');
					let REF_LIST = variavel.data('reflist');


					let IDCAMPANHA = "<?= $id ?>";
					let midia = $("#midia").val()


					if (tempo > 5000) {
						tempo = 1000
					} else {
						tempo += 1000
					}
					/*TRATATIVA DOS LINKS*/
					let array_links = [];
					let classe = document.getElementsByClassName("links");
					for (let i = 0; i < classe.length; i++) {
						array_links.push(classe[i].value);
					}




					processandoEnvio(NOME, NUM, ID, TK, IDCAMPANHA, midia, MSG, REF_LIST, array_links);


					contador++;
					contador_console++;
					if (contador == qtde) {
						clearInterval(envio);
						alert('FINALIZOU')
					}
				}, 3000);

			} else {
				$("#txt_mensagem").focus()
				alert('Mensagem vazia')
			}

		})

		$("#pnome").on('click', function(e) {
			let input = $("#txt_mensagem")
			let valor = input.val();
			input
				.val(valor + ' ' + ' <pnome> ')
				.focus()
		})


		$("#ncompleto").on('click', function(e) {
			let input = $("#txt_mensagem")
			let valor = input.val();
			input
				.val(valor + ' ' + ' <nome> ')
				.focus()
		})




		function processandoEnvio(NOME, NUM, ID, TK, IDCAMPANHA, midia, MSG, REF_LIST, array_links) {
			let obj = {
				NOME: NOME,
				NUM: NUM,
				ID: ID,
				TK: TK,
				IDCAMPANHA: IDCAMPANHA,
				midia: midia,
				MSG: MSG,
				REF_LIST: REF_LIST,
				link: array_links
			}
			$.ajax({
					url: 'ENVIO_BASE_FRIA.php',
					type: 'POST',
					dataType: 'json',
					data: obj
				})
				.done(function(response) {
					let status = response.st
					if (status == 0) {
						clearInterval(envio);
						alert('SEM CONEXÃO!!!')
						location.assign('BASEFRIA.php');
					}
					console.log(response);

				})


		}
	</script>
</body>

</html>