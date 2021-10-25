<?php 

include "_conect.php";
$json = file_get_contents('php://input');
$data=json_decode($json,true);
$ID=$data['ids'][0];
$ST=$data["status"];


$sql_status="UPDATE `listagem_envio` SET RETORNO_ZAPIO='$ST', json_list='$json' WHERE REF_ZAPIO='$ID'";
$exe_status=mysqli_query($conn,$sql_status);


/*alterando o status das enviadas*/

$sql_enviadas="UPDATE `LOG_ENVIO` SET `status_log`='$ST', json_log_recebimento='$json' WHERE messageId='$ID'";
$e_enviadas=mysqli_query($conn,$sql_enviadas);