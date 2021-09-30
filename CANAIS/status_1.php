<?php 
include "../_conect.php";

$json = file_get_contents('php://input');
$data=json_decode($json,true);
$ID=$data['ids'][0];
$ST=$data["status"];



// $sql="INSERT INTO `teste`(`json`) VALUES ('$json')";

$sql="UPDATE `relatorio_das_campanhas` SET `status_envio_rc`='$ST'
WHERE `msg_id_rc`='$ID'";

$e=mysqli_query($conn,$sql);