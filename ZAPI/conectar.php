<?php

$ID=$_REQUEST['ID'];
$TOKEN=$_REQUEST['TOKEN'];


// $ID="39543B5E6D6A60CF599492E705D4F47B";
// $TOKEN="9A00363D714EE5E8CBE23681";

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/qr-code/image',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);
$resposta=json_decode($response);
?>

<?php 
if(isset($resposta->connected)){
	?>
	<h5 class="text-primary text-center">APARELHO CONECTADO!!!</h5>
	<?php
}else{

	?>		
	<img src="<?=$resposta->value?>" alt="PAREAMENTO">


	<?php
}

?>

