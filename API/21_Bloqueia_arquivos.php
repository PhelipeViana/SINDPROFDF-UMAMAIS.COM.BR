<?php 
$id=$_REQUEST['p1'];

$sql="UPDATE `arquivos` SET `statusArquivo`=0 WHERE `idArquivo`='$id'";
$exe=mysqli_query($conn,$sql);

if($exe){
	echo json_encode(['msg'=>'sucesso','st'=>1]);

}else{
	echo json_encode(['msg'=>'erro','st'=>0]);

}


