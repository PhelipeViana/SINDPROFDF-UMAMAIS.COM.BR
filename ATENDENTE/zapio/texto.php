<?php

include "../../_conect.php";

$ID=$_REQUEST['ID'];
$TOKEN=$_REQUEST['TOKEN'];
$NUMERO=$_REQUEST['NUMERO'];
$MENSAGEM=noInjection($_REQUEST['MENSAGEM']);
$CANAL_RECEBIMENTO=$_REQUEST['CANAL'];
$ATENDENTE=$_REQUEST['ATENDENTE'];
$REF_IDATENDENTE_MSG=$_REQUEST['REF_IDATENDENTE_MSG'];



$data_mensagem=date('Y-m-d H:i:s');


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/send-messages',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&message='.$MENSAGEM,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);


  $sql="INSERT INTO `MENSAGENS`(
  idzap,
  `phone`,
  `mensagem`,
  `tipo`,
  `canal_mensagem`,
  data_mensagem,
  REF_IDATENDENTE_MSG,
  leitura) VALUES ('$ATENDENTE','$NUMERO','$MENSAGEM',2,'$CANAL_RECEBIMENTO','$data_mensagem','$REF_IDATENDENTE_MSG','text')";
  curl_close($curl);

  $exe=mysqli_query($conn,$sql);

  if($exe){
    echo json_encode(['msg'=>'enviado com sucesso','st'=>1]);

  }else{
    echo json_encode(['msg'=>'erro ao gravar','st'=>0]);

  }



