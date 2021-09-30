<?php 

$IDATENDIMENTO=$_REQUEST['p1'];

//*DADOS DO ATENDIMENTO EM RECORRÊNCIA
$sql_atendimento="SELECT * FROM `atendimento_pendente` as PEN WHERE PEN.id_atendimento='$IDATENDIMENTO' limit 1";
$exe_atendimento=mysqli_query($conn,$sql_atendimento);
$row=mysqli_fetch_assoc($exe_atendimento);
$PHONE_ATENDIMENTO=$row['phone_atendimento'];
$CANAL_ATENDIMENTO=$row['REF_CANAL_ENTRADA'];
$FOTO_ATENDIMENTO=$row['foto_no_atendimento'];




$sql_response="SELECT * FROM `MENSAGENS`
WHERE `phone`='$PHONE_ATENDIMENTO' AND 
canal_mensagem='$CANAL_ATENDIMENTO' order by idmsg";


$exe_response=mysqli_query($conn,$sql_response);

while ($r=mysqli_fetch_assoc($exe_response)) {
	$r['data_mensagem']=date('d/m/y H:i:s',strtotime($r['data_mensagem']));	
	$r['json_response']=json_decode($r['json_response'],true);
	
	// $r['json_response']=json_decode($r['json_response']);

	
	$dados[]=$r;

}

echo json_encode(['MSG'=>$dados,
	'PHONE'=>$PHONE_ATENDIMENTO,
	'ATENDIMENTO'=>$IDATENDIMENTO,'FOTO'=>$FOTO_ATENDIMENTO]);