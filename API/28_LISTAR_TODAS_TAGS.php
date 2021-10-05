<?php 

$sql="SELECT * FROM `hastag` ORDER BY `nomehastag`";
$exe=mysqli_query($conn,$sql);


while($r=mysqli_fetch_assoc($exe)){
	$dados[]=$r;
}

echo json_encode(['ret'=>$dados,'st'=>1]);