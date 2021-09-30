<?php 
include "../_conect.php";

$json = file_get_contents('php://input');
$decoded = json_decode($json,true);
$phone=$decoded["phone"];
$type=$decoded["type"];
$idmsg=$decoded["messageId"];

$mensagem=$decoded["text"]["message"];

if (!empty($decoded["text"]["message"])) {
	$mensagem=$decoded["text"]["message"];

}

if (!empty($decoded["audio"]["audioUrl"])) {
	$mensagem=$decoded["audio"]["audioUrl"];

}

if (!empty($decoded["image"]["imageUrl"])) {
	$mensagem=$decoded["image"]["imageUrl"];

}

if (!empty($decoded["video"]["videoUrl"])) {
	$mensagem=$decoded["video"]["videoUrl"];

}
if (!empty($decoded["location"])) {
	$mensagem="https://maps.google.com/?q=@".$decoded['location']['latitude'].','.$decoded['location']['longitude'];

}
if (!empty($decoded["document"])) {
	$mensagem=$decoded["document"]["documentUrl"];

}
if (!empty($decoded["sticker"])) {
	$mensagem=$decoded["sticker"]["stickerUrl"];

}



$sql="INSERT INTO `teste`(`retorno`,mensagem,phone,type,idmsg) VALUES ('$json','$mensagem','$phone','$type','$idmsg')";

$exe=mysqli_query($conn,$sql);
