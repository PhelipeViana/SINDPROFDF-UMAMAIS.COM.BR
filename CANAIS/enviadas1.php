<?php
include "../_conect.php";
$REF_CANAL=1;//id do canal cadastrado

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$phone = $data["phone"];
$zaapId = $data["zaapId"];
$momment = $data["momment"];
$messageId = $data["messageId"];



$ERROR = $data["error"];

if (!isset($ERROR)) {
    $type = $data["type"];
} else {
    $type = 'ERROR';
}


$sql = "INSERT INTO `LOG_ENVIO`
(type,phone,zaapId,momment,messageId,json_log_envio,REF_CANAL_LOG_ENVIO) VALUES ('$type','$phone','$zaapId','$momment','$messageId','$json','$REF_CANAL')";

$e = mysqli_query($conn, $sql);

/*
{
  
    "momment": 1634914805729,
    "messageId": "56F6CD6EC9E8D4FCDFE2"
}