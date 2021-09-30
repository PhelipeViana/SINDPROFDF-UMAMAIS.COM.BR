<?php
$ID="39543B5E6D6A60CF599492E705D4F47B";
$TOKEN="9A00363D714EE5E8CBE23681";
$NUMERO="556195596420";
$LINK="https://cidadao.maringa.br/DOC/MIDIA/rodrigo.jpeg";
$MENSAGEM="PARA CONFERIR CLICK: $LINK";
$IMAGEM="https://cidadao.maringa.br/DOC/MIDIA/rodrigo.jpeg";
$TITULO="FLORESTA";
$DESCRICAO="DESCRICAO";


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/send-link',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&message='.$MENSAGEM.'&image='.$IMAGEM.'&linkUrl='.$LINK.'&title='.$TITULO.'&linkDescription='.$DESCRICAO.'',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
