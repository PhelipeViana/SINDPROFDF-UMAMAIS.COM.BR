<?php

$JSON = $_REQUEST['JSON'];
$id_grupo = noInjection($_REQUEST['p1']);
$nome_grupo = noInjection($_REQUEST['p2']);
/*VARIAVEIS DE USO GLOBAL*/
$nomecamp = date('d/m/y H:i:s');
$create_campanha = date('Y-m-d H:i:s');
/*VARIAVEIS DE USO GLOBAL*/



if ($id_grupo > -1) {
	//quando for campanha UNICA POR GRUPO
	$sql_create_campanha = "INSERT INTO `campanha_envios` (
		`nome_campanha`,
		msg,
		`create_campanha`) 
	VALUES ('$nomecamp','$nome_grupo','$create_campanha')";

	$exe_create = mysqli_query($conn, $sql_create_campanha);
	$ID_CAMPANHA = mysqli_insert_id($conn);

	$sql = "SELECT * FROM `carregamento_contato` AS CONT	
	LEFT JOIN canaiszapio AS CAN 
	ON CONT.IDREFCANAL=CAN.idcanalzapio
	WHERE CONT.ativo=1 and ref_grupo_hastag='$id_grupo'";

	$exe = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($exe);

	while ($r = mysqli_fetch_assoc($exe)) {

		$dados[] = $r;
	}
	$cont = 0;
	for ($i = 0; $i < count($dados); $i++) {
		//onde lista os envios
		$NOME = $dados[$i]['nome_carregamento'];
		$NUM = $dados[$i]['phone_carregamento'];
		$ID = $dados[$i]['id_canalzapio'];
		$TK = $dados[$i]['token_canalzapio'];
		$sql_inser = "INSERT INTO 
	`listagem_envio`(`nome_list`,`num_list`,`idzaio_list`,`tokenzapio_list`,`REF_CAMP`) 
	VALUES ('$NOME','$NUM','$ID','$TK','$ID_CAMPANHA')";
		$e = mysqli_query($conn, $sql_inser);
		$cont++;
	}

	echo json_encode(['numbers' => $cont, 'st' => 1, 'id_camp' => $ID_CAMPANHA]);
	
	/*ALTERAR A CAMPANHA APÓS CRIADA*/
	
	$sql_alter = "UPDATE `campanha_envios` SET `num_envio`='$cont' WHERE `id_cam_envio`='$ID_CAMPANHA'";
	$e_alter = mysqli_query($conn, $sql_alter);


	//fim da criação de campanha por tag unica
	die();
} else {


	$sql_create_campanha = "INSERT INTO `campanha_envios`(`nome_campanha`,`create_campanha`) 
	VALUES ('$nomecamp','$create_campanha')";

	$exe_create = mysqli_query($conn, $sql_create_campanha);
	$ID_CAMPANHA = mysqli_insert_id($conn);


	if (empty($JSON)) {
		$sql = "SELECT * FROM carregamento_contato AS CONT	
	LEFT JOIN canaiszapio AS CAN 
	ON CONT.IDREFCANAL=CAN.idcanalzapio
	WHERE CONT.ativo=1 ORDER by CONT.nome_carregamento";
		$exe = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($exe);
	} else {
		//se a ca

		$JSON = implode(',', $JSON);
		$subquery = "SELECT distinct REF_CADASTRO FROM `hast_cadastro` WHERE `REF_HASTAG` IN ($JSON)";

		$sql = "SELECT * FROM `carregamento_contato` AS CONT	
	LEFT JOIN canaiszapio AS CAN 
	ON CONT.IDREFCANAL=CAN.idcanalzapio
	WHERE CONT.id_carregamento IN ($subquery) AND CONT.ativo=1";

		$exe = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($exe);
	}
	while ($r = mysqli_fetch_assoc($exe)) {

		$dados[] = $r;
	}
	$cont = 0;
	for ($i = 0; $i < count($dados); $i++) {
		//onde lista os envios
		$NOME = $dados[$i]['nome_carregamento'];
		$NUM = $dados[$i]['phone_carregamento'];
		$ID = $dados[$i]['id_canalzapio'];
		$TK = $dados[$i]['token_canalzapio'];
		$sql_inser = "INSERT INTO 
	`listagem_envio`(`nome_list`,`num_list`,`idzaio_list`,`tokenzapio_list`,`REF_CAMP`) 
	VALUES ('$NOME','$NUM','$ID','$TK','$ID_CAMPANHA')";
		$e = mysqli_query($conn, $sql_inser);
		$cont++;
	}

	echo json_encode(['numbers' => $cont, 'st' => 1, 'id_camp' => $ID_CAMPANHA]);
	$sql_alter = "UPDATE `campanha_envios` SET msg='$nomecamp',`num_envio`='$cont' WHERE `id_cam_envio`='$ID_CAMPANHA'";
	$e_alter = mysqli_query($conn, $sql_alter);
}
