<?php
include '_conect.php';
$ID_REL = noInjection($_REQUEST['id']);
if (is_numeric($ID_REL)) {
	$sql = "SELECT *,
	(SELECT count(id_rel_atendimento)  FROM `rel_atendimento` WHERE num_atendido=L.num_list)
	AS NUM_ATENDIMENTOS
	FROM `listagem_envio`  AS L
	WHERE `REF_CAMP`='$ID_REL'";

	$execute = mysqli_query($conn, $sql);
	$existe = mysqli_num_rows($execute);
} else {
	header('Location:index.php');
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RELATÓRIO</title>
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
		<h1 id="n_campanha" class="jumbotron text-center"></h1>
		<div class="noprint">
			<button type="button" class="btn btn-danger btn-block" onclick="window.print()">
				IMPRIMIR <i class="fa fa-print" aria-hidden="true"></i>
			</button>
		</div>
		<hr>
		<table class="table table-bordered table-striped table-responsive-sm">
			<thead>
				<tr>
					<th>AGUARDANDO</th>
					<th>ENVIADOS</th>
					<th>LIDOS</th>
					<th>ATENDIMENTO</th>


				</tr>
			</thead>
			<tbody>
				<tr>
					<td id="num_aguardando">0</td>
					<td id="num_enviados">0</td>
					<td id="num_lido">0</td>
					<td id="num_atendimento">0</td>

				</tr>
			</tbody>
		</table>
		<table class="table table-striped table-responsive">
			<thead>
				<tr>
					<th>Data</th>
					<th>Envios/Interações</th>
				</tr>
			</thead>
			<tbody>

				<?php
				$sql_rel_dia = "SELECT distinct(DATE(data_update)) AS date, COUNT(*) as num FROM `listagem_envio` WHERE `REF_CAMP` = 32 and enviado=1 GROUP BY DATE(data_update)";
				$exe_rel_dia = mysqli_query($conn, $sql_rel_dia);

				while ($row = mysqli_fetch_assoc($exe_rel_dia)) {
				?>
					<tr>
						<td><?= date('d/m/Y', strtotime($row['date'])) ?></td>
						<td><?= $row['num'] ?></td>
					</tr>

				<?php
				}
				?>

			</tbody>

		</table>



		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Nome</th>
					<th>Número</th>
					<th>Status</th>
					<th>Data</th>
					<th>Interação</th>

				</tr>
			</thead>
			<tbody>
				<?php

				if ($existe > 0) {
					while ($row = mysqli_fetch_assoc($execute)) {
						$campanha = $row['REF_CAMP'];
						$i++;
				?>
						<tr>
							<td><?= $i ?></td>
							<td><?= $row['nome_list'] ?></td>
							<td><?= $row['num_list'] ?></td>
							<td>
								<?php
								if ($row['enviado'] == '0') {
									echo "NA FILA";
									$AGUARDANDO++;
								} else {
									if ($row['RETORNO_ZAPIO'] == 'READ') {
										echo "LIDO";
										$LIDO++;
									} else {
										echo "ENVIADO";
									}
									$ENVIADOS++;
								}
								?>
							</td>

							<td>

								<?php
								$data = date('d/m/y H:i:s', strtotime($row['data_update']));
								echo $data;
								?>


							</td>
							<td>
								<?php
								if ($row['NUM_ATENDIMENTOS'] > 0) {
									$ATENDIDOS++;
									echo "SIM";
								} else {
									echo "NÃO";
								}
								?>

							</td>
						</tr>

					<?php
					} //fim while
					?>


				<?php
				} else {
				?>
					<tr>
						<th colspan="4" class="text-center">
							NÃO EXISTE ENVIOS.. <?= $existe ?>
						</th>
					</tr>

				<?php
				}
				?>

			</tbody>
		</table>
	</div>
	<script>
		$("#n_campanha").html('CAMPANHA ' + <?= $campanha ?>)
		$("#num_aguardando").html('<?= $AGUARDANDO ?>')
		$("#num_enviados").html('<?= $ENVIADOS ?>')
		$("#num_lido").html('<?= $LIDO ?>')
		$("#num_atendimento").html('<?= $ATENDIDOS ?>')
	</script>


</body>

</html>