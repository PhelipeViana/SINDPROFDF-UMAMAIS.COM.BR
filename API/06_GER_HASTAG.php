<?php 

$id=noInjection($_REQUEST['p1']);
$acao=noInjection($_REQUEST['p2']);
$nome=noInjection($_REQUEST['p3']);
$nome=strtoupper($nome);
$nome=trim($nome);




switch ($acao) {
	case '1':
		// CRIAR A TAG
	$sql_verifica="SELECT idhastag FROM `hastag` WHERE `nomehastag`='$nome'";
	$e=mysqli_query($conn,$sql_verifica);
	$num_existe=mysqli_num_rows($e);
	if ($num_existe > 0) {
		echo json_encode(['msg'=>'nome duplicado','st'=>2,'indice'=>1]);

	}else{

		$sql="INSERT INTO `hastag` (`nomehastag`) VALUES ('$nome')";
		$exe=mysqli_query($conn,$sql);
		if($exe){
			echo json_encode(['msg'=>'sucesso','st'=>1,'indice'=>1]);

		}else{
			echo json_encode(['msg'=>'erro 6','st'=>0,'indice'=>1]);

		}
	}
	break;

	case '2':
		// ATIVA
	$sql="UPDATE `hastag` SET `ativohastag`=1 WHERE `idhastag`='$id'";
	$exe=mysqli_query($conn,$sql);
	if($exe){
		echo json_encode(['msg'=>'sucesso','st'=>1,'indice'=>2]);

	}else{
		echo json_encode(['msg'=>'erro 6','st'=>0,'indice'=>2]);

	}

	break;

	case '3':
		// INATIVAR
	$sql="UPDATE `hastag` SET `ativohastag`=0 WHERE `idhastag`='$id'";
	$exe=mysqli_query($conn,$sql);
	if($exe){
		echo json_encode(['msg'=>'sucesso','st'=>1,'indice'=>3]);

	}else{
		echo json_encode(['msg'=>'erro 6','st'=>0,'indice'=>3]);

	}
	break;
	
}
