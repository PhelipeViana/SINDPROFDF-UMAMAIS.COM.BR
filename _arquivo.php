<?php 
$arquivo=$_FILES['fileimagem'];
$nome_tmp=$_FILES['fileimagem']['tmp_name'];
$pasta='foto/';
$nome_arq=$_FILES['fileimagem']['name'];

if (!empty($arquivo))

{
	move_uploaded_file($nome_tmp, $pasta.$nome_arq);
	echo "$pasta$nome_arq";

}
else
{
	echo 'erro ao enviar arquivo';
}

/*
<form>
  		<input type="file" name="fileimagem" id="fileimagem" />
  		<button type="button" id="btn">Enviar</button>
  	</form>

  	<script type="text/javascript">
  		$(document).ready(function(){
  			$("#btn").on('click', function(){

  				var data = new FormData();
  				data.append('fileimagem', $('#fileimagem')[0].files[0]);

  				$.ajax({
  					url: '_foto.php',
  					data: data,
  					processData: false,
  					contentType: false,
  					type: 'POST',
  					success: function(data) 
  					{
  						console.log(data)
  					}
  				});

  			});
  		});
  	</script> 