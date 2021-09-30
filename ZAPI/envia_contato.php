<?php

// $ID=$_REQUEST['ID'];
// $TOKEN=$_REQUEST['TOKEN'];
//$NUMERO=$_REQUEST['NUMERO'];
//$NOME_CONTATO=$_REQUEST['NOME_CONTATO'];
//$NUMERO_CONTATO=$_REQUEST['NUMERO_CONTATO'];
//$DESCRITIVO_CONTATO=$_REQUEST['DESCRITIVO_CONTATO'];
$ID="39543B5E6D6A60CF599492E705D4F47B";
$TOKEN="9A00363D714EE5E8CBE23681";
$NUMERO="556596927038";
$NOME_CONTATO="LEONCIO DA SILVA";
$NUMERO_CONTATO="5565996830909";
$DESCRITIVO_CONTATO="CHEFE DA CAMPANHA";




$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/send-contact',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&contactName='.$NOME_CONTATO.'&contactPhone='.$NUMERO_CONTATO.'&contactBusinessDescription='.$DESCRITIVO_CONTATO.'',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
