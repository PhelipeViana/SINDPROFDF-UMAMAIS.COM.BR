<?php 

$sql="SELECT * FROM `campanha_envios` order by id_cam_envio desc";

$exe=mysqli_query($conn,$sql);

while ($r=mysqli_fetch_assoc($exe)) {
	$r['json_envio']=json_decode($r['json_envio']);
	$dados[]=$r;
}

echo json_encode($dados);