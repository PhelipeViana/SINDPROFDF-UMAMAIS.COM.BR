<?php 
include "../_conect.php";

$json = file_get_contents('php://input');
$CANAL_RECEBIMENTO=1;//ID DO CADASTRADO
$decoded = json_decode($json,true);
$phone=$decoded["phone"];
$type=6;//CODIGO DE MENSAGEM RECEBIDA
$idmsg=$decoded["messageId"];
$data_mensagem=date('Y-m-d H:i:s');
$mensagem=noInjection($decoded["text"]["message"]);
$foto_no_atendimento=$decoded["photo"];



if (!empty($decoded["text"]["message"])) {
	$mensagem=$decoded["text"]["message"];
	$leitura='text';
	

	/*INICIO CAMPANHA DE HASTAG*/
	$tag_has=$mensagem[0];
	$parte=explode("#",$mensagem);
	$parte2=explode(" ",$parte[1]);

	$tag=strtoupper($parte2[0]);
	if ($tag_has=='#') {
		$sql_tag="INSERT INTO `whats_hastag` (`tag_campanha`, `num_has_campanha`, canal_whats_campanha ,`date_cam_has`) 
		VALUES 
		('$tag','$phone','$CANAL_RECEBIMENTO','$data_mensagem')";

		$exe_tag=mysqli_query($conn,$sql_tag);
	}	
	/*FIM CAMPANHA DE HASTAG*/

}

if (!empty($decoded["audio"]["audioUrl"])) {
	$mensagem=$decoded["audio"]["audioUrl"];
	$leitura="audio";


}

if (!empty($decoded["image"]["imageUrl"])) {
	$mensagem=$decoded["image"]["imageUrl"];
	$leitura='image';

}

if (!empty($decoded["video"]["videoUrl"])) {
	$mensagem=$decoded["video"]["videoUrl"];
	$leitura='video';
	
}
if (!empty($decoded["location"])) {
	$mensagem="https://maps.google.com/?q=@".$decoded['location']['latitude'].','.$decoded['location']['longitude'];
	$leitura='location';

}
if (!empty($decoded["document"])) {
	$mensagem=$decoded["document"]["documentUrl"];
	$leitura='document';

}
if (!empty($decoded["sticker"])) {
	$mensagem=$decoded["sticker"]["stickerUrl"];
	$leitura='sticker';

}


$sql="INSERT INTO `MENSAGENS`(
`idzap`,
`phone`,
`mensagem`,
`tipo`,
`canal_mensagem`,data_mensagem,leitura) VALUES ('$idmsg','$phone','$mensagem','$type','$CANAL_RECEBIMENTO','$data_mensagem','$leitura')";

$exe=mysqli_query($conn,$sql);


//verifica se já tem atendimento aberto
$sql_v="SELECT * FROM `atendimento_pendente` 
WHERE phone_atendimento='$phone' AND `REF_CANAL_ENTRADA`='$CANAL_RECEBIMENTO'";
$exe_v=mysqli_query($conn,$sql_v);
$existe_atendimento=mysqli_num_rows($exe_v);

if($existe_atendimento  == 0){

	$sql_atendimento="INSERT INTO `atendimento_pendente`(`phone_atendimento`, 
	`REF_ID_ATENDENTE`,
	`REF_CANAL_ENTRADA`, 
	`DATA_INICIO_CHAMADA`,foto_no_atendimento) VALUES ('$phone',0,'$CANAL_RECEBIMENTO','$data_mensagem',
	'$foto_no_atendimento')";

	$exe_atendimento=mysqli_query($conn,$sql_atendimento);

	if ($exe_atendimento) {
	alertarFilaFirebase();//atualiza a fila quando entra mensagem
}
}


/*EXISTE ATENDIMENTO*/
$sql_id="SELECT * FROM `atendimento_pendente` 
WHERE `phone_atendimento`='$phone' and `REF_CANAL_ENTRADA`='$CANAL_RECEBIMENTO'";
$exe_id=mysqli_query($conn,$sql_id);
$exe_id_existe=mysqli_num_rows($exe_id);
$row_id=mysqli_fetch_assoc($exe_id);
$ID_DO_ATENDIMENTO=$row_id['id_atendimento'];

if($exe_id_existe > 0){

	atualizaMensagemCanal($ID_DO_ATENDIMENTO);	
}




function alertarFilaFirebase(){
	global $FIREBASE_REFER;
	global $FIREBASE_HTTPS;

	$data=md5(date('d/m/Y H:i:s'));

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "$FIREBASE_HTTPS".$FIREBASE_REFER."/FILA_ATENDIMENTO/time.json",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PUT",
		CURLOPT_POSTFIELDS =>"{\r\n    \"time\":\"$data\"\r\n}",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json"
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
}
function atualizaMensagemCanal($id){
	global $FIREBASE_REFER;
	global $FIREBASE_HTTPS;
	
	$data=md5(date('d/m/Y H:i:s'));

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "$FIREBASE_HTTPS".$FIREBASE_REFER."/ATENDIMENTO/".$id."/time.json",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PUT",
		CURLOPT_POSTFIELDS =>"{\r\n    \"time\":\"$data\"\r\n}",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json"
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
}