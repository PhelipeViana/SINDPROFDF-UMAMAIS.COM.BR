<?php 
session_start();
date_default_timezone_set('America/Manaus');
define('HOST','localhost:3306');
define('DB','sinprodf_multi');
define('USER','sinprodf_phelipao');
define('PASS','%0hVe-[V;M)I');


$conn=mysqli_connect(HOST,USER,PASS,DB) or die(mysqli_errno());
mysqli_set_charset($conn,"utf8");

$TOKEN_USER = isset($_REQUEST['TOKEN_USER']) ? $_REQUEST['TOKEN_USER'] : " ";

$ENDPOINT="API/webservice.php";
$FIREBASE_REFER="SINPRODF";
$FIREBASE_HTTPS="https://projeto-whatsapp-um-a-mais-default-rtdb.firebaseio.com/";

//origem das requisições
$URL_AUTORIZADA=[

	//'speakupbrasil.com',
	//'muraldaescola.com',
	

];


function AUTORIZATION($METODO_AUTORIZADO=" "){
	global $URL_AUTORIZADA;
	$URL_REQUISITADA=$_SERVER['HTTP_REFERER'];
	$METODO_REQUISICAO=$_SERVER['REQUEST_METHOD'];


	if ($METODO_AUTORIZADO==" ") {

			$RETORNO['STATUS']=true;
			$RETORNO['MSG']='AUTORIZADO ALL METHODS';


		}else{
			$expl=explode("https://",$URL_REQUISITADA);
			$exp2=explode("/",$expl[1]);
			$BASE=$exp2[0];


			if (in_array($BASE,$URL_AUTORIZADA)) {

				if ($METODO_REQUISICAO==$METODO_AUTORIZADO) {
					$RETORNO['STATUS']=true;
					$RETORNO['MSG']='AUTORIZADO';

				}else{
					$RETORNO['STATUS']=false;
					$RETORNO['MSG']='ERROR METHOD';

				}

			}else{
				$RETORNO['STATUS']=false;
				$RETORNO['MSG']='BAD REQUEST';
			

			
			}
			
		}


	
	return $RETORNO;


}



function protect($i)
{
	if ($_SESSION['acesso'] != $i) {
		// Se houver invasão via GET quebrar a session
		header("Location:_deslogar.php");
	}
}

function respJson($exe)
{

	if ($exe) {
		$resp = 1;
	} else {
		$resp = 0;
	}
	return $resp;
}

function noInjection($i)
{
	global $conn;

	$primeiro = trim($i);
	$segundo = htmlspecialchars($primeiro);
	$terceiro = mysqli_real_escape_string($conn, $segundo);

	return $terceiro;
}



function SemAcentos($string)
{
	return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/"), explode(" ", "a A e E i I o O u U n N C c"), $string);
}

function isEmail($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function contatoInteiro($num)
{
	$asp1 = str_replace("(", "", $num);
	$asp2 = str_replace(")", "", $asp1);
	$retNUM = str_replace("-", "", $asp2);
	$space = str_replace(" ", "", $retNUM);

	return "55" . $space;
}


function numDDD($i)
{
	$asp1 = str_replace("(", "", $i);
	$retDDD = str_replace(")", "", $asp1);

	return $retDDD;
}

function numCEL($i)
{
	$retNUM = str_replace("-", "", $i);

	return $retNUM;
}
function GerarSenha()
{
	$a = rand(10, 99);
	$b = rand(10, 99);
	$c = rand(10, 99);

	return $a . $b . $c;
}

function Registro2Duplicado($tabela, $nameDB1, $recebido1, $nameDB2, $recebido2){
	global $conn;

	$sql = "SELECT * FROM $tabela WHERE 
	$nameDB1='$recebido1' 
	AND
	$nameDB2='$recebido2'";
	$executar = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($executar);
	if ($num > 0) {
		return true;
	} else {

		return false;
	}
}

function RegistroDuplicado($tabela, $nameDB1, $recebido1)
{
	global $conn;

	$sql = "SELECT * FROM $tabela WHERE 
	$nameDB1='$recebido1'";
	$executar = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($executar);
	if ($num > 0) {
		return true;
	} else {

		return false;
	}
}

function Youtube($video_url)
{

	$video_url_tipo1 = explode("//", $video_url);



	$video_url_tipo2 = explode("/", $video_url_tipo1[1]);



	if ($video_url_tipo2[0] == "youtu.be") {



		$cod_video = $video_url_tipo2[1];



		$url = "https://www.youtube.com/embed/$cod_video";

		$resposta['codigo'] = $cod_video;
		$resposta['endereco'] = $url;
	} else {

		$cod_2 = explode("=", $video_url);

		$cod_video = explode("&", $cod_2[1]);

		$cod_video = $cod_video[0];



		$url = "https://www.youtube.com/embed/$cod_video";

		$resposta['codigo'] = $cod_video;
		$resposta['endereco'] = $url;
	}

	return $resposta;

}


function nomeCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "I", "II", "III", "IV", "V", "VI"))
{

	$string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
	foreach ($delimiters as $dlnr => $delimiter) {
		$words = explode($delimiter, $string);
		$newwords = array();
		foreach ($words as $wordnr => $word) {
			if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
				$word = mb_strtoupper($word, "UTF-8");
			} elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
				$word = mb_strtolower($word, "UTF-8");
			} elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
				$word = ucfirst($word);
			}
			array_push($newwords, $word);
		}
		$string = join($delimiter, $newwords);
       }//foreach
       return $string;
   }
   
   function primeiroNome($name){
	$explode=explode(" ",$name);
	$primeiro=$explode[0];
	return $primeiro;
}