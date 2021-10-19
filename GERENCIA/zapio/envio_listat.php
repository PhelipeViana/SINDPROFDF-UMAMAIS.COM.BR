<?php
$ID = $_REQUEST['ID'];
$TK = $_REQUEST['TOKEN'];
$NUMERO = $_REQUEST['NUMERO'];
//$NUMERO ='5565996830909';
$MIDIA = $_REQUEST['MIDIA'];


$MENSAGEM = $_REQUEST['MSG'];
$MENSAGEM = urlencode($MENSAGEM);

if ($MIDIA != '0') {
    $explode = explode('.', $MIDIA);
    $FORMATO_MIDIA = "." . end($explode);
    switch ($FORMATO_MIDIA) {
        case '.ogg':
            //FORMATO DE AUDIO
            audioSend($ID, $TK, $NUMERO, $MIDIA);
            if (!empty($MENSAGEM)) {
                MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            }
            break;

        case '.opus':
            //FORMATO DE AUDIO
            audioSend($ID, $TK, $NUMERO, $MIDIA);
            if (!empty($MENSAGEM)) {
                MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            }
            break;

        case '.mp4':
            //FORMATO DE VIDEO
            videoSend($ID, $TK, $NUMERO, $MIDIA);
            if (!empty($MENSAGEM)) {
                MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            }
            break;

        case '.docx':
            //FORMATO DE DOCUMENTO
            arquivoSend($ID, $TK, $NUMERO, $MIDIA, $FORMATO_MIDIA);
            if (!empty($MENSAGEM)) {
                MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            }
            break;


        case '.xlsx':
            //FORMATO DE DOCUMENTO em excel
            arquivoSend($ID, $TK, $NUMERO, $MIDIA, $FORMATO_MIDIA);
            if (!empty($MENSAGEM)) {
                MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            }
            break;


        case '.csv':
            //FORMATO DE DOCUMENTO em excel antigo
            arquivoSend($ID, $TK, $NUMERO, $MIDIA, $FORMATO_MIDIA);
            if (!empty($MENSAGEM)) {
                MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            }
            break;

        case '.pdf':
            //FORMATO DE DOCUMENTO em pdf
            arquivoSend($ID, $TK, $NUMERO, $MIDIA, $FORMATO_MIDIA);
            if (!empty($MENSAGEM)) {
                MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            }
            break;


        case '.jpg':
            //FORMATO DE IMAGEM

            imagemSend($ID, $TK, $NUMERO, $MIDIA, $MENSAGEM);
            break;


        case '.png':
            //FORMATO DE IMAGEM
            imagemSend($ID, $TK, $NUMERO, $MIDIA, $MENSAGEM);
            break;

        case '.jpeg':
            //FORMATO DE IMAGEM
            imagemSend($ID, $TK, $NUMERO, $MIDIA, $MENSAGEM);
            break;


        default:
            MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
            break;
    }
} else {
    MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM);
}

function imagemSend($ID, $TOKEN, $NUMERO, $URL_IMG, $MENSAGEM)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TOKEN . '/send-image',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'phone=' . $NUMERO . '&image=' . $URL_IMG . '&caption=' . $MENSAGEM . '',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    echo json_encode(['reponse' => $response, 'mensagem' => $MENSAGEM, 'num' => $NUMERO]);
}

function arquivoSend($ID, $TOKEN, $NUMERO, $URL_ARQUIVO, $EXT)
{
    $explode = explode('.', $EXT);
    $EXT = $explode[1];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TOKEN . '/send-document/' . $EXT . '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'phone=' . $NUMERO . '&document=' . $URL_ARQUIVO . '',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
}

function audioSend($ID, $TOKEN, $NUMERO, $URL_AUDIO)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TOKEN . '/send-audio',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'phone=' . $NUMERO . '&audio=' . $URL_AUDIO . '',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
}
function videoSend($ID, $TOKEN, $NUMERO, $URL_VIDEO)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TOKEN . '/send-video',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'phone=' . $NUMERO . '&video=' . $URL_VIDEO . '',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
}



function MENSAGEM($ID, $TK, $NUMERO, $MENSAGEM)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.z-api.io/instances/' . $ID . '/token/' . $TK . '/send-messages',
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
    curl_close($curl);
    echo json_encode(['reponse' => $response, 'mensagem' => $MENSAGEM, 'num' => $NUMERO]);
}
