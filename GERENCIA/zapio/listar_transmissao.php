<?php

include "../../_conect.php";


$ID = $_REQUEST['ID'];
$TOKEN = $_REQUEST['TOKEN'];
$CANAL = $_REQUEST['CANAL'];



/*TESTANDO CONEXÃO*/


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TOKEN . '/status',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response_conexao = curl_exec($curl);
curl_close($curl);
$resposta_conexao = json_decode($response_conexao);
$pareamento = $resposta_conexao->connected;
$aparelho = $resposta_conexao->smartphoneConnected;


if (!$pareamento) {
    echo json_encode(['msg' => 'APARELHO DESCONECTADO', 'st' => 0]);
    die();
}




$limitpage = 11;

for ($i = 1; $i < $limitpage; $i++) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TOKEN . '/chats?page=' . $i . '&pageSize=20',
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



for ($i = 0; $i < count($response); $i++) {
    $decoded = json_decode($response[$i]);
    for ($k = 0; $k < count($decoded); $k++) {
        $str = $decoded[$k]->phone;

        if (strpos($str, '-broadcast') !== false) {

            $NOME = $decoded[$k]->name;
            $PHONE = $decoded[$k]->phone;

            $sql_insert = "INSERT INTO `listas_de_transmissao`(`phone_transmissao`, `nome_tranmissao`, `id_canal_transmissao`) VALUES ('$PHONE','$NOME','$CANAL')";
            $exe = mysqli_query($conn, $sql_insert);
        }
    }
}
echo json_encode(['st' => 1]);
