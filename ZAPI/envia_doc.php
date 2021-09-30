<?php

$ID="39543B5E6D6A60CF599492E705D4F47B";
$TOKEN="9A00363D714EE5E8CBE23681";

$NUMERO="556596927038";
$URL_DOC="https://cidadao.maringa.br/DOC/MIDIA/modelo_importar_clientes (1).xlsx";
$EXT="xlsx";


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/send-document/'.$EXT.'',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&document='.$URL_DOC.'',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
