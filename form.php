<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FORMULÁRIO TESTE</title>
	<script src="SCRIPTS/jquery.js"></script>
	<link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
	<link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

	<form id="form" method="post">
		<input type="text" name="link[]" class="form-control" value="val1">
		<input type="text" name="link[]" class="form-control" value="val2">
		<input type="text" name="link[]" class="form-control" value="val3">
		<input type="text" name="link[]" class="form-control" value="val4">
		<input type="text" name="link[]" class="form-control" value="val5">
		<input type="text" name="link[]" class="form-control" value="val6">


		<button class="btn btn-success">Enviar</button>
		
	</form>
	<script>
		$("#form").submit(function(event) {
			event.preventDefault();
			let obj={
				id:1,
				label:'testando'
			}

			$.ajax({
				url: 'teste.php',
				type: 'POST',
				dataType: 'json',
				data: $(this).serialize(),
			})
			.done(function(response) {
				console.log(response);
			})
			
		});
	</script>
</body>
</html>