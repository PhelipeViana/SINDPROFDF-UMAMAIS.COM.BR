<?php 

$sql="SELECT * FROM `arquivos` order by idArquivo desc";

$exe=mysqli_query($conn,$sql);

while($r=mysqli_fetch_assoc($exe)){

	$r['alterArquivo']=date('d/m/Y H:i:s',strtotime($r['alterArquivo']));
	
	$dados[]=$r;
}

echo json_encode(['msg'=>'sucesso','st'=>1,'ret'=>$dados]);