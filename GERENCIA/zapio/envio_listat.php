<?php
$ID = $_REQUEST['ID'];
$TOKEN = $_REQUEST['TOKEN'];
$NUMERO = $_REQUEST['NUMERO'];
$MENSAGEM = $_REQUEST['MSG'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TOKEN . '/send-messages',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'phone=' . $NUMERO . '&message=' . $MENSAGEM,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
    ),
));

$response = curl_exec($curl);
$data = json_decode($response, true);
$msg_id_rc = $data['messageId'];

echo json_encode($response);