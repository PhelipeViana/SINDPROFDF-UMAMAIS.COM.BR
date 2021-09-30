<?php 

// LIMPEZA DE DUPLICADOS NOS DISPAROS
include "_conect.php";

$sql="SELECT `REF_CADASTRO` FROM `hast_cadastro` WHERE `REF_HASTAG`=8";
//$exe=mysqli_query($conn,$sql);

while ($row=mysqli_fetch_assoc($exe)) {
	$dados[]=$row;
}


for ($i=0; $i < count($dados); $i++) { 
  $id=$dados[$i]['REF_CADASTRO'];

}


//*
/*
VALIDA NUMERO
$ID="39543B5E6D6A60CF599492E705D4F47B";
$TOKEN="0FAA7504F6604945ECCF4A50";
$NUMERO="5565996830909";



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/phone-exists/'.$NUMERO,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);
$data=json_decode($response,true);
$existe=$data['exists'];
curl_close($curl);

echo json_encode(['existe'=>$existe]);


*/




















// $sql="SELECT * FROM `carregamento_contato` WHERE `tipo_carregamento`!='0'";
// $exe=mysqli_query($conn,$sql);

// while ($row=mysqli_fetch_assoc($exe)) {
// 	$dados[]=$row;

// }
// //var_dump($dados);


// for ($i=0; $i < count($dados); $i++) { 
// 	$nome=$dados[$i]['nome_carregamento'];
// 	$num=$dados[$i]['phone_carregamento'];


// 	$sql_insert="INSERT INTO `DISPAROS`(`nome_disparo`, `num_disparo`) VALUES ('$nome','$num')";
// 	$e=mysqli_query($conn,$sql_insert);

// 	if($e){

// 		echo "SUCESSO! </br>";
// 	}else{

// 		echo "ERRO! </br>";
// 	}

// }