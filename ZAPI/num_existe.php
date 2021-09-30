<?php

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

