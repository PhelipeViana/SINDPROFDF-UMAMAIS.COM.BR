<?php 
include '_conect.php';
protect('1');

$id_logado=$_SESSION['token'];
$sql="SELECT * FROM `acesso` WHERE `id_acesso`='$id_logado'";
$exe=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($exe);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ATENDIMENTO</title>
	<link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
	<link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
	<link href="ATENDENTE/css/datepicker3.css" rel="stylesheet">
	<link href="ATENDENTE/css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<script src="SCRIPTS/jquery.js"></script>
	<script src="ATENDENTE/js/chart.min.js"></script>
	<script src="ATENDENTE/js/chart-data.js"></script>
	<script src="ATENDENTE/js/easypiechart.js"></script>
	<script src="ATENDENTE/js/easypiechart-data.js"></script>
	<script src="ATENDENTE/js/bootstrap-datepicker.js"></script>
	<script src="ATENDENTE/js/custom.js"></script>
	<script src="SCRIPTS/mascara.js"></script>
	<script src="SCRIPTS/cpf.js"></script>
	<script src="SCRIPTS/locais.js"></script>
	<script src="ATENDENTE/js/bootstrap.min.js"></script>
	<script src="SCRIPTS/firebase.js"></script>
	<script src="SCRIPTS/analitic.js"></script>
	<script src="SCRIPTS/app.js"></script>
	<?php 
	include "ATENDENTE/_script.php";
	?>
</head>
<body>

	<?php 
	if($row['primeiro_acesso']==1){
		?>
		<h1>PRIMEIRO ACESSO</h1>


		<?php
	}else{
		?>

		<?php include "ATENDENTE/menu.php"; ?>	
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade active in" id="tela_1" role="tabpanel" aria-labelledby="home-tab">
					<?php include "ATENDENTE/atendimento.php"; ?>
				</div>
				<div class="tab-pane fade " id="tela_2" role="tabpanel" aria-labelledby="contact-tab">
					<h1>SEGUNDA TELA</h1>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis esse corporis quasi maxime facere suscipit aspernatur, magnam nostrum, dolorem aliquam dignissimos fugit quae. Ratione quidem officia tempora facilis distinctio accusantium. SEGUNDA TELA
				</div>

			</div>
		</div>


		<?php
	}
	?>

</body>
</html>