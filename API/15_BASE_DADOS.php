<?php 

$pagina_limite=$_REQUEST['p1']; //indice da pagina
$pesquisa=$_REQUEST['p2']; //indice da pagina
$PAGINACAO='LIMIT 1  , '.$pagina_limite;

if ($pesquisa=='0') {
	$sql="SELECT 
	*
	FROM `carregamento_contato` as C 
	left join canaiszapio as Z 
	ON C.IDREFCANAL=Z.idcanalzapio  order by C.nome_carregamento $PAGINACAO";

	$exe=mysqli_query($conn,$sql);


	while ($r=mysqli_fetch_assoc($exe)) {
		$dados[]=$r;
	}
	//die();

}else{
	$sql="SELECT 
	*
	FROM `carregamento_contato` as C 
	left join canaiszapio as Z 
	ON C.IDREFCANAL=Z.idcanalzapio where CONCAT (C.nome_carregamento, C.phone_carregamento)  LIKE '%$pesquisa%'";
	$exe=mysqli_query($conn,$sql);
	$num_pesquisa=mysqli_num_rows($exe);
	

	while ($r=mysqli_fetch_assoc($exe)) {
		$dados[]=$r;
	}
	
}





//NUMEROS TOTAIS
$sql_total="SELECT * FROM `carregamento_contato`";
$exe_total=mysqli_query($conn,$sql_total);
$num_total=mysqli_num_rows($exe_total);



echo json_encode(['ret'=>$dados,'num'=>$num_total,'pesquisa'=>$pesquisa,'pagina'=>$pagina_limite]);