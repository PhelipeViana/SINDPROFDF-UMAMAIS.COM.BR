<?php 

$ID=noInjection($_REQUEST['p1']);
$NUM=noInjection($_REQUEST['p2']);


$sql_inser="INSERT INTO `rel_atendimento`(`REF_ATENDENTE`, `num_atendido`) VALUES ('$TOKEN_USER','$NUM')";
$exe_insert=mysqli_query($conn,$sql_inser);

//deleta
$sql_delete="DELETE FROM `atendimento_pendente` WHERE `id_atendimento`='$ID'";

$exe_delete=mysqli_query($conn,$sql_delete);

if ($exe_delete) {
	echo json_encode(['msg'=>'sucesso','st'=>1]);

}else{
	echo json_encode(['msg'=>'erro ao finalizar atendimento','st'=>0]);
	
}