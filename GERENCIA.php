<?php
include '_conect.php';
protect('2');

$id_logado = $_SESSION['token'];
$sql = "SELECT * FROM `acesso` WHERE `id_acesso`='$id_logado'";
$exe = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($exe);




?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GERENCIA</title>
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
	<script src="SCRIPTS/firebase.js"></script>
	<script src="SCRIPTS/analitic.js"></script>
	<script src="SCRIPTS/app.js"></script>

	<?php include 'GERENCIA/_script.php'; ?>
	<style>
		.print_oculto {
			display: none;
		}

		.print_over {
			visibility: hidden;
		}

		.noprintmenu {
			visibility: visible;
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

			.noprintmenu {
				display: none;
				visibility: hidden;
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
	<div class="noprintmenu">
		<?php include "GERENCIA/menu.php"; ?>

	</div>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="tab-content" id="myTabContent">

			<div class="tab-pane fade" id="tela_midias" role="tabpanel" aria-labelledby="home-tab">
				<?php include "GERENCIA/midia.php"; ?>

			</div>

			<div class="tab-pane fade" id="tela_base_dados" role="tabpanel" aria-labelledby="home-tab">
				<?php include "GERENCIA/basededados.php"; ?>
			</div>

			<div class="tab-pane fade    active in" id="tela_dados_tags" role="tabpanel" aria-labelledby="home-tab">
				<?php include "GERENCIA/dadostag.php"; ?>
			</div>



			<div class="tab-pane fade" id="tela_campanhas" role="tabpanel" aria-labelledby="home-tab">
				<?php include "GERENCIA/campanha.php"; ?>
			</div>
			<div class="tab-pane fade" id="tela_whatscampanha" role="tabpanel" aria-labelledby="home-tab">
				<?php include "GERENCIA/whats_campanha.php"; ?>
			</div>
			<div class="tab-pane fade" id="tela_transmissao" role="tabpanel" aria-labelledby="home-tab">
				<?php include "GERENCIA/transmissao.php"; ?>
			</div>

			<div class="tab-pane fade" id="tela_1" role="tabpanel" aria-labelledby="home-tab">
				<?php include "GERENCIA/atendimento.php"; ?>
			</div>
			<div class="tab-pane fade " id="tela_2" role="tabpanel" aria-labelledby="contact-tab">
				<?php include "GERENCIA/meusatendentes.php"; ?>
			</div>
			<div class="tab-pane fade " id="tela_3" role="tabpanel" aria-labelledby="contact-tab">
				<?php include "GERENCIA/canais.php"; ?>
			</div>

		</div>
	</div>





	<script>
		// window.onload = function () {
		// 	var chart1 = document.getElementById("line-chart").getContext("2d");
		// 	window.myLine = new Chart(chart1).Line(lineChartData, {
		// 		responsive: true,
		// 		scaleLineColor: "rgba(0,0,0,.2)",
		// 		scaleGridLineColor: "rgba(0,0,0,.05)",
		// 		scaleFontColor: "#c5c7cc"
		// 	});
		// };
	</script>

</body>

</html>