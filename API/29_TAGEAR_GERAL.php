<?php
// descontinuado por falta de recurso de maquina
$JSON = $_REQUEST['JSON'];
$tag = $_REQUEST['p1'];
$data_criacao = date('Y-m-d H:i:s');
$PERMITIDOS = [];

for ($i = 0; $i < count($JSON); $i++) {
    $ID_USER = $JSON[$i];
    $sql_pesquisa = "SELECT idhastcadastro FROM `hast_cadastro` WHERE `REF_CADASTRO`='$ID_USER' AND `REF_HASTAG`='$tag'";
    $exe_pesquisa = mysqli_query($conn, $sql_pesquisa);
    $num_pesquisa = mysqli_num_rows($exe_pesquisa);
    if ($num_pesquisa < 1) {
        $PERMITIDOS[] = $ID_USER;
    }
   
}

echo json_encode(['PERMITIDO'=>$PERMITIDOS,'st' => 1, 'tag' => $tag, 'num_tageados' => 0]);
die();
/*INSERIR OS IDS PERMITIDOS*/
$NUM_TAGEADOS = count($PERMITIDOS);
if ($NUM_TAGEADOS < 1) {

    echo json_encode(['msg' => 'Já tageados anteriormente', 'st' => 2, 'tag' => $tag]);
    die();
} else {

    for ($i = 0; $i < count($PERMITIDOS); $i++) {
        $id = $PERMITIDOS[$i];
        $sql = "INSERT INTO `hast_cadastro`(`REF_CADASTRO`, `REF_HASTAG`,data_create_hastcad) VALUES ('$id','$tag','$data_criacao')";
        $e = mysqli_query($conn, $sql);
        
    }

    echo json_encode(['msg' => 'sucesso', 'st' => 1, 'tag' => $tag, 'num_tageados' => $NUM_TAGEADOS]);
}
