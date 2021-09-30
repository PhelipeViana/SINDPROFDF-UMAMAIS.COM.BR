<?php 
$data=date('d/m/y H:i:s');

$sql="SELECT 
tag_campanha,
(SELECT count(tag_campanha) from whats_hastag where tag_campanha=WH.tag_campanha) AS QTDE,
(SELECT COUNT(distinct num_has_campanha)   from whats_hastag where tag_campanha=WH.tag_campanha) AS NUMER

FROM `whats_hastag` as WH 
group by WH.tag_campanha order by QTDE desc";

$exe=mysqli_query($conn,$sql);

while ($r=mysqli_fetch_assoc($exe)) {
	$dados[]=$r;
}

echo json_encode(['ret'=>$dados,'atualizado'=>$data]);