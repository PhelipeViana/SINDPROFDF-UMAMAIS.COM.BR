<?php

include "../../_conect.php";


$ID=$_REQUEST['ID'];
$TOKEN=$_REQUEST['TOKEN'];
$IDREFCANAL=$_REQUEST['IDREFCANAL'];





$limitpage=20;

for ($i=1; $i < $limitpage; $i++) { 
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/chats?page='.$i.'&pageSize=20',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));

	$response[] = curl_exec($curl);
	curl_close($curl);
	
}

$c=0;

for ($i=0; $i < count($response); $i++) { 
	$decoded=json_decode($response[$i]);
	for ($k=0; $k < count($decoded); $k++) { 
		$NOMES[]=$decoded[$k]->name;
		$PHONES[]=$decoded[$k]->phone;
		$FOTOS[]=$decoded[$k]->profileThumbnail;

	}	
}
for($y=0;$y < count($PHONES);$y++){
	$nomes=$NOMES[$y];
	$numeros=$PHONES[$y];
	$fotos=$FOTOS[$y];

	// $sql="INSERT INTO `carregamento_contato` (
	// nome_carregamento,
	// foto_carregamento,
	// `phone_carregamento`, IDREFCANAL,tipo_carregamento) VALUES (
	// '$nomes',
	// '$fotos',
	// '$numeros',
	// '$IDREFCANAL',1)";
	$sql="INSERT INTO `teste`(`nome_teste`, `numero_teste`) VALUES ('$nomes','$numeros')";

	$execute=mysqli_query($conn,$sql);
	if($execute){
		$c++;
	}

}

echo json_encode(['number'=>$c]);

?>

