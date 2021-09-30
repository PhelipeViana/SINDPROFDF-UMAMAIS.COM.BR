<?php 

$JSON=$_REQUEST['JSON'];



if(empty($JSON)){
	$sql="SELECT * FROM carregamento_contato AS CONT	
	LEFT JOIN canaiszapio AS CAN 
	ON CONT.IDREFCANAL=CAN.idcanalzapio
	WHERE CONT.ativo=1 ORDER by CONT.nome_carregamento";
	$exe=mysqli_query($conn,$sql);
	$num=mysqli_num_rows($exe);

}else{
	//quando há predilçeção por alguam #tag
	
	$JSON= implode(',', $JSON);
	$subquery="SELECT distinct REF_CADASTRO FROM `hast_cadastro` WHERE `REF_HASTAG` IN ($JSON)"; 

	$sql="SELECT * FROM `carregamento_contato` AS CONT	
	LEFT JOIN canaiszapio AS CAN 
	ON CONT.IDREFCANAL=CAN.idcanalzapio
	WHERE CONT.id_carregamento IN ($subquery) AND CONT.ativo=1";

	$exe=mysqli_query($conn,$sql);
	$num=mysqli_num_rows($exe);

}


while ($r=mysqli_fetch_assoc($exe)) {
	$dados[]=$r;
}
$datajson=json_encode($dados);
$nomecamp=date('d/m/y H:i:s');
$create_campanha=date('Y-m-d H:i:s');
$msg='Olá <nome>!';
$sql_int="INSERT INTO `campanha_envios` (nome_campanha,
msg,
json_envio,
num_envio, create_campanha) VALUES 
('$nomecamp','$msg','$datajson', $num, '$create_campanha')";
$exe_int=mysqli_query($conn,$sql_int);
if ($exe_int) {
	$res=true;
}else{
	$res=false;
}
$id=mysqli_insert_id($conn);


echo json_encode(['data'=>$dados,'num'=>$num,'res'=>$res,'ids'=>$id]);


