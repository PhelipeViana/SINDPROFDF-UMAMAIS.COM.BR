
<?php
// $ID=$_REQUEST['ID'];
// $TOKEN=$_REQUEST['TOKEN'];

$ID="39C654D4786580056C6A52059E828D91";
$TOKEN="E273A7AD4ACD2C33DE5C1A46";

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/status',
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
$pareamento=$resposta->connected;
$aparelho=$resposta->smartphoneConnected;

echo json_encode(['pareamentro'=>$pareamento,'aparelho'=>$aparelho]);



