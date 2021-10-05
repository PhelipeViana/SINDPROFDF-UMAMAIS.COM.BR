<?php 

$sql_cabecario="SELECT 
PEN.id_atendimento,
PEN.phone_atendimento,
PEN.REF_CANAL_ENTRADA,
PEN.foto_no_atendimento,
CAR.nome_carregamento,
CAR.foto_carregamento,
CAR.ativo as spam,
C.nome_canalzapio,
C.id_canalzapio,
C.token_canalzapio,
CONT.id_carregamento,
CONT.ref_grupo_hastag

FROM `atendimento_pendente` AS PEN
left join carregamento_contato as CAR
ON PEN.phone_atendimento=CAR.phone_carregamento
left join canaiszapio as C 
ON PEN.REF_CANAL_ENTRADA=C.idcanalzapio
left join carregamento_contato as CONT 
on PEN.phone_atendimento=CONT.phone_carregamento

WHERE `REF_ID_ATENDENTE`='$TOKEN_USER' ORDER BY DATA_INICIO_ATENDIMENTO desc";

$exe_cabecario=mysqli_query($conn,$sql_cabecario);

while ($r=mysqli_fetch_assoc($exe_cabecario)) {
	$e=explode(" ",$r['nome_carregamento']);
	$r['pnome']=$e[0];

	if(is_null($r['id_carregamento'])){
		$r['id_carregamento']="0";
	}	
	$data_cabecario[]=$r;
}



echo json_encode(['nums'=>$data_cabecario]);