<?php

$link=$_REQUEST['link'];

for ($i=0; $i < count($link); $i++) { 
	$array_links[$i]['id']=$i+1;
	$array_links[$i]['label']=$link[$i];
	
}

$split=json_encode($array_links,JSON_UNESCAPED_UNICODE);

$asp1=str_replace("[","", $split);

$array_links=str_replace("]","", $asp1);

//echo json_encode($array_links);

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.z-api.io/instances/39DDF139A3CB809ED9132AAEDCA634E8/token/E3303ABF1908F937F5BB1C47/send-button-list",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "{\"phone\": \"5565996830909\", \"message\": \"*SERÁ QUE VAI?\",\"buttonList\": { \"buttons\": [$array_links] }}",
	CURLOPT_HTTPHEADER => array(
		"content-type: application/json"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo json_encode(['msg'=>'erro']);


} else {
  //echo $response;
	echo json_encode(['msgS'=>$response,'link'=>$array_links]);

}
