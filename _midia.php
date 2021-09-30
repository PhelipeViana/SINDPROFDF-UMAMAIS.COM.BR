<?php  
include '_conect.php';


$nome_da_pasta='MIDIA';

mkdir(dirname(__FILE__).'/DOC/'.$nome_da_pasta.'/', 0777, true); //CRIA A PASTA SE NAO EXISTIR

$newname=md5(date('d/m/Y H:i:s'));
$nome=$_FILES['arq']['name'];
$extensao =".".pathinfo($nome, PATHINFO_EXTENSION);

$destino=$_SERVER['DOCUMENT_ROOT'].'/DOC/'.$nome_da_pasta.'/'.$newname.$extensao;
move_uploaded_file($_FILES['arq']['tmp_name'], $destino);

$file="https://".$_SERVER['HTTP_HOST'].'/DOC/'.$nome_da_pasta.'/'.$newname.$extensao;

$sql="INSERT INTO `arquivos` (
`nomeArquivo`,
`linkArquivo`,
`extArquivo`) VALUES ('$newname','$file','$extensao')";

$exe=mysqli_query($conn,$sql);

if ($exe) {
	
	header('Location:index.php');

}else{
	echo "FALHA AO CARREGAR O ARQUIVO!";
	header('Location:index.php');

}


?>
