<?php 



$sql_atendimento="SELECT id_atendimento FROM `atendimento_pendente` WHERE `REF_ID_ATENDENTE`=0";
$exe_atendimento=mysqli_query($conn,$sql_atendimento);
$num_pendentes=mysqli_num_rows($exe_atendimento);

echo json_encode(['num_pendentes'=>$num_pendentes]);