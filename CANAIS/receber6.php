<?php
include "../_conect.php";

$json = file_get_contents('php://input');
$CANAL_RECEBIMENTO = 6; //ID DO CADASTRADO
$decoded = json_decode($json, true);
$phone = $decoded["phone"];
$type = 1; //CODIGO DE MENSAGEM RECEBIDA

$data_mensagem = date('Y-m-d H:i:s');
$mensagem = noInjection($decoded["text"]["message"]);
$foto_no_atendimento = $decoded["photo"];

/*controle do aparelho no multi device*/
$fromMe = $decoded["fromMe"];
if ($fromMe) {
	$idmsg = 'APARELHO';
} else {
	$idmsg = $decoded["messageId"];
}

if (!empty($decoded["text"]["message"])) {
	$mensagem = $decoded["text"]["message"];
	$leitura = 'text';


	/*INICIO CAMPANHA DE HASTAG*/
	$tag_has = $mensagem[0];
	$parte = explode("#", $mensagem);
	$parte2 = explode(" ", $parte[1]);

	$tag = strtoupper($parte2[0]);
	if ($tag_has == '#') {
		$sql_tag = "INSERT INTO `whats_hastag` (`tag_campanha`, `num_has_campanha`, canal_whats_campanha ,`date_cam_has`) 
		VALUES 
		('$tag','$phone','$CANAL_RECEBIMENTO','$data_mensagem')";

		$exe_tag = mysqli_query($conn, $sql_tag);
	}
	/*FIM CAMPANHA DE HASTAG*/
}
/*SAIDA AUTOMATICA*/
$array = explode(" ", $mensagem);
if (in_array("0", $array)) {
	naoReceberMensagem($phone);
}
// POR VALOR EXATO

$MSG_COMPARE = strtoupper(SemAcentos($mensagem));


if ($MSG_COMPARE == 'NAO RECEBER') {
	naoReceberMensagem($phone);
}
if ($MSG_COMPARE == 'NAO SOU EU') {
	naoReceberMensagem($phone);
}
if ($MSG_COMPARE == 'EXCLUI MEU NUMERO') {
	naoReceberMensagem($phone);
}

if ($MSG_COMPARE == 'EXCLUI ESSE NUMERO') {
	naoReceberMensagem($phone);
}

if ($MSG_COMPARE == 'NAO DESEJO RECEBER MENSAGEM') {
	naoReceberMensagem($phone);
}


function naoReceberMensagem($phone)
{
	global $conn;
	global $CANAL_RECEBIMENTO;


	$sql_pesquisa = "SELECT id_carregamento FROM `carregamento_contato` WHERE `phone_carregamento`='$phone'";
	$exe_pesquisa = mysqli_query($conn, $sql_pesquisa);
	$existe = mysqli_num_rows($exe_pesquisa);

	if ($existe > 0) {
		$sql_up = "UPDATE `carregamento_contato` SET `ativo`=2 WHERE `phone_carregamento`='$phone'";
		$exe = mysqli_query($conn, $sql_up);
	} else {
		$sql_cre = "INSERT INTO `carregamento_contato`(`phone_carregamento`,IDREFCANAL,`ativo`) VALUES ('$phone','$CANAL_RECEBIMENTO',2)";
		$exe = mysqli_query($conn, $sql_cre);
	}
}
function FormatUpper($string)
{
	$a = str_replace(",", " ", $string);
	$b = str_replace("-", " ", $a);
	$c = str_replace("_", " ", $b);
	$d = str_replace(".", " ", $c);



	return strtoupper(preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/"), explode(" ", "a A e E i I o O u U n N C c"), $d));
}


if (!empty($decoded["audio"]["audioUrl"])) {
	$mensagem = $decoded["audio"]["audioUrl"];
	$leitura = "audio";
}

if (!empty($decoded["image"]["imageUrl"])) {
	$mensagem = $decoded["image"]["imageUrl"];
	$leitura = 'image';
}

if (!empty($decoded["video"]["videoUrl"])) {
	$mensagem = $decoded["video"]["videoUrl"];
	$leitura = 'video';
}
if (!empty($decoded["location"])) {
	$mensagem = "https://maps.google.com/?q=@" . $decoded['location']['latitude'] . ',' . $decoded['location']['longitude'];
	$leitura = 'location';
}
if (!empty($decoded["document"])) {
	$mensagem = $decoded["document"]["documentUrl"];
	$leitura = 'document';
}
if (!empty($decoded["sticker"])) {
	$mensagem = $decoded["sticker"]["stickerUrl"];
	$leitura = 'sticker';
}


$sql = "INSERT INTO `MENSAGENS`(
`idzap`,
`phone`,
`mensagem`,
`tipo`,
`canal_mensagem`,data_mensagem,leitura) VALUES ('$idmsg','$phone','$mensagem','$type','$CANAL_RECEBIMENTO','$data_mensagem','$leitura')";

$exe = mysqli_query($conn, $sql);


//verifica se já tem atendimento aberto
$sql_v = "SELECT * FROM `atendimento_pendente` 
WHERE phone_atendimento='$phone' AND `REF_CANAL_ENTRADA`='$CANAL_RECEBIMENTO'";
$exe_v = mysqli_query($conn, $sql_v);
$existe_atendimento = mysqli_num_rows($exe_v);

if ($existe_atendimento  == 0) {

	$sql_atendimento = "INSERT INTO `atendimento_pendente`(`phone_atendimento`, 
	`REF_ID_ATENDENTE`,
	`REF_CANAL_ENTRADA`, 
	`DATA_INICIO_CHAMADA`,foto_no_atendimento) VALUES ('$phone',0,'$CANAL_RECEBIMENTO','$data_mensagem',
	'$foto_no_atendimento')";

	$exe_atendimento = mysqli_query($conn, $sql_atendimento);

	if ($exe_atendimento) {
		alertarFilaFirebase(); //atualiza a fila quando entra mensagem
	}
}


/*EXISTE ATENDIMENTO*/
$sql_id = "SELECT * FROM `atendimento_pendente` 
WHERE `phone_atendimento`='$phone' and `REF_CANAL_ENTRADA`='$CANAL_RECEBIMENTO'";
$exe_id = mysqli_query($conn, $sql_id);
$exe_id_existe = mysqli_num_rows($exe_id);
$row_id = mysqli_fetch_assoc($exe_id);
$ID_DO_ATENDIMENTO = $row_id['id_atendimento'];

if ($exe_id_existe > 0) {

	atualizaMensagemCanal($ID_DO_ATENDIMENTO);
}




function alertarFilaFirebase()
{
	global $FIREBASE_REFER;
	global $FIREBASE_HTTPS;

	$data = md5(date('d/m/Y H:i:s'));

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "$FIREBASE_HTTPS" . $FIREBASE_REFER . "/FILA_ATENDIMENTO/time.json",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PUT",
		CURLOPT_POSTFIELDS => "{\r\n    \"time\":\"$data\"\r\n}",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json"
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
}
function atualizaMensagemCanal($id)
{
	global $FIREBASE_REFER;
	global $FIREBASE_HTTPS;

	$data = md5(date('d/m/Y H:i:s'));

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "$FIREBASE_HTTPS" . $FIREBASE_REFER . "/ATENDIMENTO/" . $id . "/time.json",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PUT",
		CURLOPT_POSTFIELDS => "{\r\n    \"time\":\"$data\"\r\n}",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json"
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
}
