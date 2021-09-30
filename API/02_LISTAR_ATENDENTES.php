<?php 

$sql="SELECT * FROM `acesso` WHERE `nivel`='1' order by nome_acesso";

$e=mysqli_query($conn,$sql);

while ($r=mysqli_fetch_assoc($e)) {
	$dados[]=$r;
}

echo json_encode(['msg'=>'sucesso','st'=>1,'ret'=>$dados]);