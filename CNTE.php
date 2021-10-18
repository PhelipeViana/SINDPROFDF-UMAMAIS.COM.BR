<?php
define('HOST','localhost:3306');
define('DB','cnteumam_multi');
define('USER','cnteumam_phelipao');
define('PASS','[7-ryy_t;{mO');


$conn=mysqli_connect(HOST,USER,PASS,DB) or die(mysqli_errno());
mysqli_set_charset($conn,"utf8");



$id = $_REQUEST['id'];
$limit = $_REQUEST['limit'];

if (isset($id) && !empty($id)) {
	$sql_campanha = "SELECT * FROM `campanha_envios` WHERE `id_cam_envio`='$id'";
	$exe_campanha = mysqli_query($conn, $sql_campanha);
	$dados_campanha = mysqli_fetch_assoc($exe_campanha);
} else {
	header('Location:index.php');
}

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
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CAMPANHA <?= $id ?></title>
	<script src="SCRIPTS/jquery.js"></script>
	<link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
	<link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
	<script src="ATENDENTE/js/bootstrap.min.js"></script>
	<script src="ATENDENTE/js/mascara.js"></script>


</head>

<body>
	<div class="container">
		<div class="jumbotron text-center">
			<h1>CAMPANHA <?= $id ?></h1>
			<h3 class="text-danger"><?= $dados_campanha['msg'] ?></h3>
		</div>

		<a href="CAMPANHA_ENVIO.php?id=<?= $id ?>">
			<button class="btn btn-danger btn-block" style="display: none;" id='reiniciar'>PARA/REINICIAR</button>
		</a>
		<hr>
		<div id="area_de_envio">
			<label for="">Tipo de mensagem</label>
			<select id="midia" class="form-control">
				<option value="0">ENVIAR SOMENTE TEXTO</option>
				<?php

				$sql_arq = "SELECT * FROM `arquivos` order by idArquivo desc";
				$e_arq = mysqli_query($conn, $sql_arq);

				while ($row = mysqli_fetch_assoc($e_arq)) {
					?>
					<option value="<?= $row['linkArquivo'] ?>"><?= $row['nomeArquivo'] ?> + TEXTO</option>
					<?php
				}

				?>


			</select>
			<hr>
			<div class="row">
				<div class="col-sm-4">

					<label for="">MENSAGEM</label>
				</div>
				<div class="col-sm-4">
					<button class="btn-link" id='ncompleto'>NOME COMPLETO <i class="fa fa-hand-o-down" aria-hidden="true"></i></button>
				</div>
				<div class="col-sm-4">
					<button class="btn-link" id='pnome'>PRIMEIRO NOME<i class="fa fa-hand-o-down" aria-hidden="true"></i></button>

				</div>
			</div>
			<textarea id="txt_mensagem" cols="30" rows="10" class="form-control" required minlength="5"></textarea>
			<hr>
			<button class="btn btn-block btn-danger" id="iniciar_testar">TESTAR ANTES</button>
			<hr>
			<button class="btn btn-block btn-success" id="iniciar_acao">INICIAR ENVIOS</button>
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

					$sql = "SELECT * FROM `listagem_envio` WHERE `REF_CAMP`='$id' and enviado=0 limit $LIMITE_CONTATOS";
					$e = mysqli_query($conn, $sql);
					$num_pendentes = mysqli_num_rows($e);

					while ($r = mysqli_fetch_assoc($e)) {
						?>
						<tr>
							<td><?= $r['id_list']; ?></td>
							<td><?= $r['nome_list']; ?></td>
							<td><?= $r['num_list']; ?></td>
							<td class='resultado' data-nome='<?= $r['nome_list']; ?>' data-numero='<?= $r['num_list']; ?>' data-id='<?= $r['idzaio_list']; ?>' data-tk='<?= $r['tokenzapio_list']; ?>' data-reflist='<?= $r['id_list']; ?>'>
								<button class="btn btn-warning btn-block">NA FILA</button>

							</td>

						</tr>


						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- modal testar envio -->
	<!-- Button trigger modal -->
	<div class="modal fade" id="modal_teste_envio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">TESTAR ENVIO</h5>
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
				<label for="">Nome</label>
				<input type="text" id="nome_teste" class="form-control">
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

		} else {
			$("#token_envio_teste").val(0);
			$("#id_envio_teste").val(0);
		}
	})

	$("#btn_envia_teste").on('click', function(e) {
		let tk = $("#token_envio_teste").val();
		let id = $("#id_envio_teste").val();
		let nome = $("#nome_teste").val()
		let midia = $("#midia").val()
		let cx_msg = $("#txt_mensagem").val()
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
					.html('...enviado')
					processandoEnvio(nome, num, id, tk, 0, midia, cx_msg, 0);
					$("#numero_teste").css('color', 'black')
				}

			}


		})
	$("#form_teste_envio").submit(function(e) {
		e.preventDefault()
		console.log($(this).serialize())
	})


	$("#iniciar_testar").on('click', function(e) {
		let cx_msg = $("#txt_mensagem").val()
		if (cx_msg.length < 1) {
			alert('ops! mensagem vazia')
			$("#cx_msg").focus()
		} else {
			$("#modal_teste_envio").modal('show')
		}
	})
	let envio = "";
	let pendentes_envios = "<?= $num_pendentes ?>";
	if (pendentes_envios < 1) {
		alert('CAMPANHA JÁ FINALIZADA');
		$("#iniciar_acao")
		.html('ENVIO CONCLUIDO')
		.removeClass('btn-success')
		.addClass('btn-danger')
		.on('click', function(e) {
			alert('CAMPANHA JÁ FINALIZADA');

		})
		$("#area_de_envio").hide()
	} else {
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
					variavel.html('<button class="btn btn-success btn-block">ENVIADO!</button>');
					let proxima_variavel = $('.resultado').eq(contador + 1);
					proxima_variavel.html('<button class="btn btn-secondary btn-block">ENVIANDO....</button>');


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



						processandoEnvio(NOME, NUM, ID, TK, IDCAMPANHA, midia, MSG, REF_LIST);


						contador++;
						contador_console++;
						if (contador == qtde) {
							clearInterval(envio);
							alert('FINALIZOU')
						}
					}, 10000);

			} else {
				$("#txt_mensagem").focus()
				alert('Mensagem vazia')
			}

		})




	}

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




	function processandoEnvio(NOME, NUM, ID, TK, IDCAMPANHA, midia, MSG, REF_LIST) {
		let obj = {
			NOME: NOME,
			NUM: NUM,
			ID: ID,
			TK: TK,
			IDCAMPANHA: IDCAMPANHA,
			midia: midia,
			MSG: MSG,
			REF_LIST: REF_LIST
		}
		$.ajax({
			url: 'RETORNO_CAMPANHA.php',
			type: 'POST',
			dataType: 'json',
			data: obj
		})
		.done(function(response) {
			let status = response.st
			if (status == 0) {
				clearInterval(envio);
				alert('SEM CONEXÃO!!!')
				location.assign('CAMPANHA_ENVIO.php?id=<?= $id ?>');
			}


			if (obj.REF_LIST == 0) {
				alert('TESTE ENVIADO COM SUCESSO!')
				$("#btn_envia_teste")
				.attr('disabled', false)
				.html('ENVIAR TESTE')
			}
		})


	}
</script>
</body>

</html>