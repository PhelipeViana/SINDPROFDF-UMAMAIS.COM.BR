<?php 


$sql="SELECT 
*,
(SELECT COUNT(*) from `hast_cadastro` WHERE REF_HASTAG=H.idhastag) as qdecad


FROM hastag as H ORDER BY nomehastag";

$e=mysqli_query($conn,$sql);

while($r=mysqli_fetch_assoc($e)){
	$dados[]=$r;
}

echo json_encode(['msg'=>'sucesso','ret'=>$dados]);