<?php 

$nome=noInjection($_REQUEST['nome']);
$nome=nomeCase($nome);
$numero=noInjection($_REQUEST['numero']);
$foto=$_REQUEST['foto'];
$canal=$_REQUEST['canal'];


$sql_existe="SELECT * FROM `carregamento_contato` WHERE `phone_carregamento`='$numero'";
$exe_existe=mysqli_query($conn,$sql_existe);
$num_existe=mysqli_num_rows($exe_existe);

if ($num_existe > 0) {
	// EDITAR
	$sql_edita="UPDATE `carregamento_contato` SET 
	`nome_carregamento`='$nome',
	foto_carregamento='$foto'
	WHERE `phone_carregamento`='$numero'";
	$exe_edita=mysqli_query($conn,$sql_edita);
	if($exe_edita){
		echo json_encode(['msg'=>'Editado com sucesso!','st'=>1]);
	}else{
		echo json_encode(['msg'=>'Erro ao editadar','st'=>0]);	
	}

}else{
	//SALVAR
	$sql_insert="INSERT INTO `carregamento_contato`(
	`nome_carregamento`,
	foto_carregamento,
	`phone_carregamento`,
	IDREFCANAL) VALUES ('$nome','$foto','$numero','$canal')";
	$exe_insert=mysqli_query($conn,$sql_insert);
	if($exe_insert){
		echo json_encode(['msg'=>'Cadastrado com sucesso!','st'=>1]);
	}else{
		echo json_encode(['msg'=>'Erro ao cadastrar','st'=>0]);	
	}


}


