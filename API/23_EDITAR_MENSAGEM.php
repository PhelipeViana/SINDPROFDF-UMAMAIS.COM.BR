<?php 

$id=noInjection($_REQUEST['id']);
$msg=$_REQUEST['msg'];


$sql="UPDATE `campanha_envios` SET `msg`='$msg'
WHERE id_cam_envio='$id'";

$exe=mysqli_query($conn,$sql);

if($exe){
	echo json_encode(['msg'=>'sucesso','st'=>1]);

}else{
	echo json_encode(['msg'=>'erro ao editar msg','st'=>0]);

}