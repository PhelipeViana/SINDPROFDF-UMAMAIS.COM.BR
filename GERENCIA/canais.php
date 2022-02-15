	<h1 class="jumbotron text-center">CANAIS DE WHATSAPP</h1>

	<script>
		function novaconexao(id, tk, ret) {
			$("#btn_" + ret)
				.html('....')
				.attr('disabled', true)
			$.ajax({
					url: 'ZAPI/conectar.php',
					type: 'POST',
					dataType: 'html',
					data: {
						ID: id,
						TOKEN: tk
					},
				})
				.done(function(response) {
					$("#retorno" + ret).html(response)
					$("#btn_" + ret).html('ATUALIZAR')
						.attr('disabled', false)
				})


		}

		function desligar(id, tk, ret) {
			$("#btn_desligar" + ret)
				.html('....')
				.attr('disabled', true)
			$.ajax({
					url: 'ZAPI/desconectar.php',
					type: 'POST',
					dataType: 'html',
					data: {
						ID: id,
						TOKEN: tk
					},
				})
				.done(function(response) {
					novaconexao(id, tk, ret)
				})


		}


		function importarContatosAtivos(id, tk, ret) {
			$("#btn_importar" + ret)
				.html('importando.....')
				.attr('disabled', true)
			$.ajax({
					url: 'GERENCIA/zapio/db_conversas_ativas.php',
					type: 'POST',
					dataType: 'json',
					data: {
						ID: id,
						TOKEN: tk,
						IDREFCANAL: ret
					},
				})
				.done(function(response) {
					let number = response.number
					alert('CONTATOS IMPORTADOS: \n' + number);
					$("#btn_importar" + ret).hide()
				})

		}

		function importarContatosTodaAgenda(id, tk, ret) {
			$("#btn_agenda" + ret)
				.html('importando agenda.....')
				.attr('disabled', true)
			$.ajax({
					url: 'GERENCIA/zapio/db_agenda.php',
					type: 'POST',
					dataType: 'json',
					data: {
						ID: id,
						TOKEN: tk,
						IDREFCANAL: ret
					},
				})
				.done(function(response) {
					let number = response.number
					alert('CONTATOS DA AGENDA: \n' + number);
					$("#btn_agenda" + ret).hide()
					console.log(response)
				})

		}
	</script>
	<div class="row">
		<?php
		$sql = "SELECT * FROM `canaiszapio`";
		$execute = mysqli_query($conn, $sql);


		while ($row = mysqli_fetch_assoc($execute)) {
			if ($row['idcanalzapio'] == '2') {
				//$btn = 'disabled';
			} else {
				$btn = '';
			}
		?>

			<div class="col-sm-4 jumbotron">
				<h1 class="card-title text-center text-danger"><?= $row['nome_canalzapio'] ?></h1>

				<div id="retorno<?= $row['idcanalzapio'] ?>"></div>
				<div class="card-body">
					<button class="btn btn-info btn-block" onclick="novaconexao('<?= $row['id_canalzapio'] ?>',
					'<?= $row['token_canalzapio'] ?>','<?= $row['idcanalzapio'] ?>')" id='btn_<?= $row['idcanalzapio'] ?>' id='btnatualizar'>
						Atualizar
					</button>
					<br>
					<button class="btn btn-danger btn-block desligar" onclick="desligar('<?= $row['id_canalzapio'] ?>',
				'<?= $row['token_canalzapio'] ?>','<?= $row['idcanalzapio'] ?>')" id='btn_desligar<?= $row['idcanalzapio'] ?>'  <?=$btn?> >
						DESLIGAR
					</button>
					<br>
					<!--  
			<button class="btn btn-warning btn-block import" 
			onclick="importarContatosAtivos('<?= $row['id_canalzapio'] ?>',
			'<?= $row['token_canalzapio'] ?>','<?= $row['idcanalzapio'] ?>')" id='btn_importar<?= $row['idcanalzapio'] ?>' id='btnimportar'>
			IMPORTAR ATIVOS
		</button>

			<button class="btn btn-info btn-block import" 
			onclick="importarContatosTodaAgenda('<?= $row['id_canalzapio'] ?>',
			'<?= $row['token_canalzapio'] ?>','<?= $row['idcanalzapio'] ?>')" id='btn_agenda<?= $row['idcanalzapio'] ?>' id='btnimportar'>
			IMPORTAR MINHA AGENDA
		</button>  -->
				</div>
			</div>
			<script>
				novaconexao('<?= $row['id_canalzapio'] ?>', '<?= $row['token_canalzapio'] ?>', '<?= $row['idcanalzapio'] ?>')
			</script>
		<?php
		}
		?>
	</div>