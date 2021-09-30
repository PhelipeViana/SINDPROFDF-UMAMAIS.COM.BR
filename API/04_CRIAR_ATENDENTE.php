<?php
$nome=noInjection($_REQUEST['nome']);
$nome=nomeCase($nome);
$email=noInjection($_REQUEST['login']);
$email=strtolower($email);
$senha=GerarSenha();
$senhadb=md5($senha);


$sql_verifica="SELECT * FROM  acesso WHERE login_acesso='$email'";
$exe=mysqli_query($conn,$sql_verifica);
$num_existe=mysqli_num_rows($exe);

if($num_existe > 0){
	echo json_encode(['msg'=>'Email ja existente','st'=>2]);
}else{

	$sql="INSERT INTO `acesso`(`nome_acesso`, `login_acesso`, `senha_acesso`) VALUES (
	'$nome','$email','$senhadb')";
	$exe=mysqli_query($conn,$sql);
	if($exe){
		echo json_encode(['msg'=>'Sucesso','st'=>1,'senha'=>$senha]);
	}else{
		echo json_encode(['msg'=>'erro 4','st'=>0]);

	}

}

