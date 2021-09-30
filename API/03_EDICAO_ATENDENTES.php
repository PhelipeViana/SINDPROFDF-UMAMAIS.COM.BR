<?php 

$id=noInjection($_REQUEST['p1']);
$comando=noInjection($_REQUEST['p2']);
$nome=noInjection($_REQUEST['p3']);
$nome=nomeCase($nome);
$email=noInjection($_REQUEST['p4']);
$email=strtolower($email);

switch ($comando) {
	case '1':
		// salvar dados
	$sql_verifica="SELECT `login_acesso` FROM `acesso` WHERE id_acesso!='$id' AND `login_acesso`='$email'";
	$exe_verifica=mysqli_query($conn,$sql_verifica);
	$num=mysqli_num_rows($exe_verifica);
	if($num > 0){

		echo json_encode(['msg'=>'Registro Duplicado','st'=>2,'indice'=>1]);

	}else{
		$sql="UPDATE `acesso` SET 
		`nome_acesso`='$nome',
		`login_acesso`='$email'
		WHERE `id_acesso`='$id'";

		$exe=mysqli_query($conn,$sql);

		if($exe){
			echo json_encode(['msg'=>'sucesso','st'=>1,'indice'=>1]);

		}else{
			echo json_encode(['msg'=>'error3','st'=>0,'indice'=>1]);

		}
	}
	
	break;

	case '2':
		// desbloquear
	$sql="UPDATE `acesso` SET `liberado`=1 WHERE `id_acesso`='$id'";

	$exe=mysqli_query($conn,$sql);

	if($exe){
		echo json_encode(['msg'=>'sucesso','st'=>1,'indice'=>2]);

	}else{
		echo json_encode(['msg'=>'error3','st'=>0,'indice'=>2]);

	}


	break;


	case '3':
	//bloquear
	$sql="UPDATE `acesso` SET `liberado`=0 WHERE `id_acesso`='$id'";

	$exe=mysqli_query($conn,$sql);

	if($exe){
		echo json_encode(['msg'=>'sucesso','st'=>1,'indice'=>3]);

	}else{
		echo json_encode(['msg'=>'error3','st'=>0,'indice'=>3]);

	}

	break;


	case '4':
		// GERAR SENHA
	$senha=GerarSenha();
	$senhadb=md5($senha);

	$sql="UPDATE `acesso` SET 
	`senha_acesso`='$senhadb'
	WHERE `id_acesso`='$id'";

	$exe=mysqli_query($conn,$sql);

	if($exe){
		echo json_encode(['msg'=>'sucesso','st'=>1,'senha'=>$senha,'indice'=>4]);

	}else{
		echo json_encode(['msg'=>'error3','st'=>0,'indice'=>4]);

	}


	break;
	
}