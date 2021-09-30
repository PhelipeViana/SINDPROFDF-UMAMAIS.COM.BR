<?php 
$num=$_REQUEST['p1'];
$canal=$_REQUEST['p2'];

$NUM_PESQUISA=substr($num, -7);


//PESQUISAR PRIMEIRO NO BANCO NORMAL
$sql_contato="SELECT id_carregamento, nome_carregamento FROM `carregamento_contato` WHERE `phone_carregamento` 
LIKE '%$NUM_PESQUISA' limit 1";
$exe_contato=mysqli_query($conn,$sql_contato);
$existe_no_contato=mysqli_num_rows($exe_contato);

if ($existe_no_contato > 0) {
	$row=mysqli_fetch_assoc($exe_contato);
	$NOME_CONTATO=$row['nome_carregamento'];
	$ID_CONTATO=$row['id_carregamento'];
	//TRATAR O NOME EM BRANCO
	if(is_null($NOME_CONTATO) || empty($NOME_CONTATO)){
		$NOME_CONTATO='NOME VAZIO';

	}else{
		$NOME_CONTATO=$row['nome_carregamento'];
		
	}

	//DAR O UPDATE AO NUMERO DO CARREGAMENTO
	$sql_update_carregamento="UPDATE `carregamento_contato` SET 
	`nome_carregamento`='$NOME_CONTATO',
	`phone_carregamento`='$num',
	`tipo_carregamento`=3  WHERE `id_carregamento`='$ID_CONTATO'";
	
	$exe_altera_carregamento=mysqli_query($conn,$sql_update_carregamento);
	if ($exe_altera_carregamento) {
		$ret=true;
	}else{
		$ret=false;
	}

	echo json_encode(['ret'=>$ret,'msg'=>'Existe no Carregamento','st'=>1]);
	die();

}else{
	$sql_disparos="SELECT `nome_disparo` FROM `DISPAROS` WHERE `num_disparo` LIKE '%$NUM_PESQUISA' limit 1";
	$exe_disparos=mysqli_query($conn,$sql_disparos);
	$existe_no_disparo=mysqli_num_rows($exe_disparos);
	
	if($existe_no_disparo > 0){
		$row=mysqli_fetch_assoc($exe_disparos);
		$NOME_DISPARO=$row['nome_disparo'];

		if(is_null($NOME_DISPARO) || empty($NOME_DISPARO)){
			$NOME_DISPARO='NOME VAZIO';

		}else{
			$NOME_DISPARO=$row['nome_disparo'];

		}


		//DAR O INSERT AO CARREGAMENTO ATRAVES DOS DISPAROS
		$sql_insert_no_carregamento="INSERT INTO `carregamento_contato` (
		`nome_carregamento`,
		`phone_carregamento`,
		`IDREFCANAL`,
		`tipo_carregamento`) VALUES ('$NOME_DISPARO','$num','$canal',3)";

		$exe_insert_no_carregamento=mysqli_query($conn,$sql_insert_no_carregamento);
		if ($exe_insert_no_carregamento) {
			$ret=true;
		}else{
			$ret=false;
		}

		echo json_encode(['ret'=>$ret,'msg'=>'Existe no disparo','st'=>2]);

		
	}else{
		echo json_encode(['st'=>0,'msg'=>'não existe no banco de dados']);

	}

}


