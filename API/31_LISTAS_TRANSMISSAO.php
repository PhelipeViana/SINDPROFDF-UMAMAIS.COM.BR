<?php 

$sql="SELECT * FROM `listas_de_transmissao` AS LIST
LEFT JOIN canaiszapio AS CANAL
ON CANAL.idcanalzapio=LIST.id_canal_transmissao";
$exe=mysqli_query($conn,$sql);

while($r=mysqli_fetch_assoc($exe)){
    $dados[]=$r;

}

echo json_encode($dados);