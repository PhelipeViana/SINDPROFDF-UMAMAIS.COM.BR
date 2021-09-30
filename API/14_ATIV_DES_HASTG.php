<?php 
$acao=$_REQUEST['p1'];//1 ATIVAR 0 DESATIVAR
$idtag=$_REQUEST['p2'];//id tag
$user=$_REQUEST['p3'];// id do numero
$data_criacao=date('Y-m-d H:i:s');


$sql_verifica="SELECT idhastcadastro FROM `hast_cadastro` WHERE `REF_CADASTRO`='$user' and `REF_HASTAG`='$idtag'";
$exe_verifica=mysqli_query($conn,$sql_verifica);
$num_existe=mysqli_num_rows($exe_verifica);

if($num_existe > 0){
	$sql="DELETE FROM `hast_cadastro` WHERE `REF_CADASTRO`='$user' and `REF_HASTAG`='$idtag'";
	$msg="Removido com sucesso";
}else{
	$sql="INSERT INTO `hast_cadastro` (`REF_CADASTRO`, `REF_HASTAG`,data_create_hastcad) VALUES (
	'$user','$idtag','$data_criacao')";
	$msg="Adicionado com sucesso";
}

$exe=mysqli_query($conn,$sql);
if($exe){
	$st=1;
}else{
	$st=0;
}

echo json_encode(['st'=>$st,'msg'=>$msg,'id'=>$user]);


