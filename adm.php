<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LOGADO</title>
	<link href="ADM/css/bootstrap.min.css" rel="stylesheet">
	<link href="ADM/css/font-awesome.min.css" rel="stylesheet">
	<link href="ADM/css/datepicker3.css" rel="stylesheet">
	<link href="ADM/css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<script src="ADM/js/jquery-1.11.1.min.js"></script>
	<script src="ADM/js/bootstrap.min.js"></script>
	<script src="ADM/js/chart.min.js"></script>
	<script src="ADM/js/chart-data.js"></script>
	<script src="ADM/js/easypiechart.js"></script>
	<script src="ADM/js/easypiechart-data.js"></script>
	<script src="ADM/js/bootstrap-datepicker.js"></script>
	<script src="ADM/js/custom.js"></script>

	
</head>
<body>
	<?php include "ADM/menu.php"; ?>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade active in" id="tela_1" role="tabpanel" aria-labelledby="home-tab">
				<?php include "ADM/atendimento.php"; ?>
			</div>
			<div class="tab-pane fade " id="tela_2" role="tabpanel" aria-labelledby="contact-tab">
				<h1>SEGUNDA TELA</h1>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis esse corporis quasi maxime facere suscipit aspernatur, magnam nostrum, dolorem aliquam dignissimos fugit quae. Ratione quidem officia tempora facilis distinctio accusantium. SEGUNDA TELA
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