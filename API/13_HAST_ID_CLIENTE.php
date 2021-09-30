<?php 
$ID=$_REQUEST['p1'];

$sql="SELECT 
*, 
(SELECT COUNT(*) FROM hast_cadastro WHERE REF_CADASTRO='$ID' AND REF_HASTAG=H.idhastag) AS ativo
FROM hastag as H 

WHERE 
H.ativohastag=1 ORDER BY nomehastag asc";
$exe=mysqli_query($conn,$sql);


while($r=mysqli_fetch_assoc($exe)){
	$r['id']=$ID;
	$dados[]=$r;
}



echo json_encode(['TAGS'=>$dados]);