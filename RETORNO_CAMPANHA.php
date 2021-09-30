<?php 

include "_conect.php";

$NOME=$_POST['NOME']; $EXPLODE_NOME=explode(" ",$NOME);
$PNOME=$EXPLODE_NOME[0];

$NUM=$_POST['NUM'];
$ID=$_POST['ID'];
$TK=$_POST['TK'];
$IDCAMPANHA=$_POST['IDCAMPANHA'];
$midia=$_POST['midia'];
$REF_LIST=$_POST['REF_LIST'];

/*TRATATIVA DAS MENSAGENS*/
$MENSAGEM=$_POST['MSG'];
$MENSAGEM=str_replace("<nome>",$NOME,$MENSAGEM);
$MENSAGEM=str_replace("<pnome>",$PNOME,$MENSAGEM);



/*TESTANDO CONEXÃO*/

/*TRATANDO LINK*/
$link=$_REQUEST['link'];

for ($i=0; $i < count($link); $i++) { 
	$array_links[$i]['id']=$i+1;
	$array_links[$i]['label']=$link[$i];
	
}

$split=json_encode($array_links,JSON_UNESCAPED_UNICODE);

$asp1=str_replace("[","", $split);

$array_links=str_replace("]","", $asp1);


/*TESTANDO CONEXÃO*/






$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TK.'/status',
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
$resposta_conexao=json_decode($response_conexao);
$pareamento=$resposta_conexao->connected;
$aparelho=$resposta_conexao->smartphoneConnected;


if (!$pareamento) {
	echo json_encode(['msg'=>'nao conectado','st'=>0]);
	die();
}



/*FIM TESTE CONEXÃO*/

if ($midia != '0') {
	$explode=explode('.',$midia);
	$FORMATO_MIDIA=".".end($explode);
	switch ($FORMATO_MIDIA) {
		case '.ogg':
      //FORMATO DE AUDIO
		audioSend($ID,$TK,$NUM,$midia);
		break;

		case '.opus':
      //FORMATO DE AUDIO
		audioSend($ID,$TK,$NUM,$midia);

		break;

		case '.mp4':
    	  //FORMATO DE VIDEO
		videoSend($ID,$TK,$NUM,$midia);
		break;

		case '.docx':
      //FORMATO DE DOCUMENTO
		arquivoSend($ID,$TK,$NUM,$midia,$FORMATO_MIDIA);
		break;


		case '.xlsx':
      //FORMATO DE DOCUMENTO em excel
		arquivoSend($ID,$TK,$NUM,$midia,$FORMATO_MIDIA);
		break;


		case '.csv':
      //FORMATO DE DOCUMENTO em excel antigo
		arquivoSend($ID,$TK,$NUM,$midia,$FORMATO_MIDIA);
		break;

		case '.pdf':
      //FORMATO DE DOCUMENTO em pdf
		arquivoSend($ID,$TK,$NUM,$midia,$FORMATO_MIDIA);
		break;


		case '.jpg':
      //FORMATO DE IMAGEM

		imagemSend($ID,$TK,$NUM,$midia);
		break;


		case '.png':
      //FORMATO DE IMAGEM
		imagemSend($ID,$TK,$NUM,$midia);
		break;

		case '.jpeg':
      //FORMATO DE IMAGEM
		imagemSend($ID,$TK,$NUM,$midia);
		break;


		default:
      // code...
		break;
	}

	
}
//curl de envio da mensagem
$MENSAGEM=urlencode($MENSAGEM);
if (empty($link)) {
//ENVIANDO SEM LINK
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TK.'/send-messages',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => 'phone='.$NUM.'&message='.$MENSAGEM,
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded'
		),
	));

	$response = curl_exec($curl);
	$data=json_decode($response,true);
	$REF_ZAPIO=$data['messageId'];

}else{
//ENVIANDO MENSAGEM COM O LINK
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.z-api.io/instances/'.$ID.'/token/'.$TK.'/send-button-list',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\"phone\": \"$NUM\", \"message\": \"$MENSAGEM\",\"buttonList\": { \"buttons\": [$array_links] }}",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/json"
		),
	));

	$response = curl_exec($curl);
	$data=json_decode($response,true);
	$REF_ZAPIO=$data['messageId'];

	curl_close($curl);
}


//ALTERAR STATUS NA LISTA

$sql_status="UPDATE `listagem_envio` SET `enviado`='1' , REF_ZAPIO='$REF_ZAPIO' WHERE `id_list`='$REF_LIST'";
$exe_status=mysqli_query($conn,$sql_status);
if ($exe_status) {
	$exe_status='sim';
}else{
	$exe_status='nao';
}

echo json_encode(['JSON'=>$response]);


//echo json_encode(['NOME'=>$NOME,'NUM'=>$NUM,'ID'=>$ID,'IDCAMPANHA'=>$IDCAMPANHA,'midia'=>$midia,'MSG'=>$MSG,'st'=>1]);

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