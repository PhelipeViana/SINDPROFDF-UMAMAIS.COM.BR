<?php 
$arquivo=noInjection($_REQUEST['arquivo']);
$id=$_REQUEST['id'];

$NOME_IGUAL=RegistroDuplicado('arquivos','nomeArquivo',$arquivo);

if(!$NOME_IGUAL){
	$sql="UPDATE `arquivos` SET `nomeArquivo`='$arquivo' WHERE `idArquivo`='$id'";
	$exe=mysqli_query($conn,$sql);

	if($exe){
		echo json_encode(['msg'=>'sucesso','st'=>1]);

	}else{
		echo json_encode(['msg'=>'erro','st'=>0]);

	}
}else{
	echo json_encode(['msg'=>'nome duplicado','st'=>2]);

}


