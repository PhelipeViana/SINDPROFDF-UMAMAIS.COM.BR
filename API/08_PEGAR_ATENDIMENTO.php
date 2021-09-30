<?php 

$data_atendimento=date('Y-m-d H:i:s');


$sql="UPDATE `atendimento_pendente` SET `REF_ID_ATENDENTE`='$TOKEN_USER',
DATA_INICIO_ATENDIMENTO='$data_atendimento' WHERE REF_ID_ATENDENTE=0 ORDER BY DATA_INICIO_ATENDIMENTO asc limit 1";

$exe=mysqli_query($conn,$sql);
if($exe){
	echo json_encode(['msg'=>'sucesso','st'=>1]);	

}else{
	echo json_encode(['msg'=>'sucesso','st'=>0]);	

}
