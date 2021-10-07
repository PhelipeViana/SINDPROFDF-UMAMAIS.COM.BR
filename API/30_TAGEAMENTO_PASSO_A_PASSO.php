<?php
$id_tag = noInjection($_REQUEST['id_tag']);
$id_user = noInjection($_REQUEST['id_user']);
$nome_tag = noInjection($_REQUEST['nome_tag']);
$data = date('Y-m-d H:i:s');

$sql_pesquisa = "SELECT `idhastcadastro` FROM `hast_cadastro` WHERE `REF_CADASTRO`='$id_user' and `REF_HASTAG`='$id_tag'";
$exe_pesquisa = mysqli_query($conn, $sql_pesquisa);
$num_pesquisa = mysqli_num_rows($exe_pesquisa);

if ($num_pesquisa > 0) {

    echo json_encode(['msg' => 'ja cadastrado', 'st' => 2, 'id' => $id_user, 'nome_tag' => $nome_tag]);

    die();
} else {
    $sql_insert = "INSERT INTO `hast_cadastro`(`REF_CADASTRO`, `REF_HASTAG`, `data_create_hastcad`) VALUES ('$id_user','$id_tag','$data')";
    $exe_insert = mysqli_query($conn, $sql_insert);

    if ($exe_insert) {
        echo json_encode(['msg' => 'sucesso', 'st' => 1, 'id' => $id_user, 'nome_tag' => $nome_tag]);
    } else {
        echo json_encode(['msg' => 'error: 30', 'st' => 0]);
    }
}
