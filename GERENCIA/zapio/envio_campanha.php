<?php

include "../../_conect.php";

$ID_CAMPANHA=$_REQUEST['id'];



$sql_campanha="SELECT * FROM campanha_envios as C  
left join arquivos  AS A 
ON C.REF_MIDIA=A.idArquivo
WHERE
id_cam_envio='$ID_CAMPANHA'";
$exe_campanha=mysqli_query($conn,$sql_campanha);
$row=mysqli_fetch_assoc($exe_campanha);
$NOME_CAMPANHA=$row['nome_campanha'];
$JSON=$row['json_envio'];
$dados=json_decode($JSON);

//tratativa de midia
$LINK_MIDIA=$row['linkArquivo'];

if(is_null($LINK_MIDIA)){
  $EXISTE_MIDIA=0;
  $FORMATO_MIDIA=0;
  $LINK_MIDIA="000";
}else{
  $EXISTE_MIDIA=1;
  $FORMATO_MIDIA=$row['extArquivo'];
  $LINK_MIDIA=$row['linkArquivo'];
}


$INICIO=updateStatusCampanha(1,$ID_CAMPANHA);

if($INICIO){

  for ($i=0; $i < count($dados); $i++) { 
    $ID=$dados[$i]->id_canalzapio;
    $TOKEN=$dados[$i]->token_canalzapio;
    $NUMERO=$dados[$i]->phone_carregamento;
    $REF_CANAL_RC=$dados[$i]->idcanalzapio;
    $NOME_COMPLETO=$dados[$i]->nome_carregamento;
    $exp=explode(" ", $NOME_COMPLETO);
    $PRIMEIRO_NOME=$exp[0];
    $MENSAGEM=$row['msg'];
    $MENSAGEM=str_replace("<nome>",$NOME_COMPLETO,$MENSAGEM);
    $MENSAGEM=str_replace("<pnome>",$PRIMEIRO_NOME,$MENSAGEM);
    returnEnvio($ID,$TOKEN,$NUMERO,$MENSAGEM,$REF_CANAL_RC,$EXISTE_MIDIA,$FORMATO_MIDIA,$LINK_MIDIA);
    
    sleep(10);// aguarda 10 segundos
  }
  $FINALIZADO=updateStatusCampanha(2,$ID_CAMPANHA);
  echo json_encode(['msg'=>'sucesso','st'=>$FINALIZADO]);

}else{

  echo json_encode(['msg'=>'erro ao iniciar campanha!','st'=>false]);

}



function returnEnvio($ID,$TOKEN,$NUMERO,$MENSAGEM,$REF_CANAL_RC,$EXISTE_MIDIA,$FORMATO_MIDIA,$LINK_MIDIA){
  global $conn;
  global $ID_CAMPANHA;
  $data_envio=date('Y-m-d H:i:s');
  
  if ($EXISTE_MIDIA > 0) {
    // envio de midia...
    switch ($FORMATO_MIDIA) {
      case '.ogg':
      //FORMATO DE AUDIO
      audioSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA);
      break;

      case '.opus':
      //FORMATO DE AUDIO
      audioSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA);
      break;

      case '.mp4':
      //FORMATO DE VIDEO
      videoSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA);
      break;

      case '.docx':
      //FORMATO DE DOCUMENTO
      arquivoSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA,$FORMATO_MIDIA);
      break;


      case '.xlsx':
      //FORMATO DE DOCUMENTO em excel
      arquivoSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA,$FORMATO_MIDIA);
      break;


      case '.csv':
      //FORMATO DE DOCUMENTO em excel antigo
      arquivoSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA,$FORMATO_MIDIA);
      break;

      case '.pdf':
      //FORMATO DE DOCUMENTO em pdf
      arquivoSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA,$FORMATO_MIDIA);
      break;


      case '.jpg':
      //FORMATO DE IMAGEM
      imagemSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA);
      break;


      case '.png':
      //FORMATO DE IMAGEM
      imagemSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA);
      break;

      case '.jpeg':
      //FORMATO DE IMAGEM
      imagemSend($ID,$TOKEN,$NUMERO,$LINK_MIDIA);
      break;


      default:
      // code...
      break;
    }


  }
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
  $data=json_decode($response,true);
  $msg_id_rc=$data['messageId'];


  $sql="INSERT INTO `relatorio_das_campanhas`
  (REF_DA_CAMPANHA,
  REF_CANAL_RC,
  `msg_id_rc`,
  `num_rc`,
  `msg_rc`,
  status_envio_rc,data_envio) VALUES ('$ID_CAMPANHA',
  '$REF_CANAL_RC',
  '$msg_id_rc',
  '$NUMERO',
  '$MENSAGEM',
  0,'$data_envio')";
  $exe=mysqli_query($conn,$sql);
}


function updateStatusCampanha($val,$id_camp){
  global $conn;
  $sql_status="UPDATE `campanha_envios` SET `status_campanha`=$val 
  WHERE `id_cam_envio`='$id_camp'";
  $execute=mysqli_query($conn,$sql_status);
  if ($execute) {
    return true;
  }else{
    return false;
  }

}
function imagemSend($ID,$TOKEN,$NUMERO,$URL_IMG){
 $curl = curl_init();
 curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/send-image',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&image='.$URL_IMG.'',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));
 $response = curl_exec($curl);

 curl_close($curl);
}
function audioSend($ID,$TOKEN,$NUMERO,$URL_AUDIO){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/send-audio',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&audio='.$URL_AUDIO.'',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
}

function videoSend($ID,$TOKEN,$NUMERO,$URL_VIDEO){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TOKEN.'/send-video',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&video='.$URL_VIDEO.'',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded'
    ),
  ));

  $response = curl_exec($curl);

}


function arquivoSend($ID,$TOKEN,$NUMERO,$URL_ARQUIVO,$EXT){
  $explode=explode('.',$EXT);
  $EXT=$explode[1];

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
    CURLOPT_POSTFIELDS => 'phone='.$NUMERO.'&document='.$URL_ARQUIVO.'',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);

}
