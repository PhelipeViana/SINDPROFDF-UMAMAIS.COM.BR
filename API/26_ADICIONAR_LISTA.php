<?php 


$id=$_REQUEST['p1'];

$sql="UPDATE `carregamento_contato` SET `ativo`=1 WHERE `id_carregamento`='$id'";
$exe=mysqli_query($conn,$sql);

if ($exe) {

	echo json_encode(['st'=>1,'msg'=>'adicionado com sucesso!']);
}else{

	echo json_encode(['st'=>0,'msg'=>'erro ao adicionar na lista']);
}

