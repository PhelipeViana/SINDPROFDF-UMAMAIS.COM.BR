<?php
header('Access-Control-Allow-Origin: *');
include "../_conect.php";

$id = $_GET['id'];

$sql = "SELECT * FROM `acesso` WHERE `id_acesso`=$id";

$exe = mysqli_query($conn, $sql);

while ($r = mysqli_fetch_assoc($exe)) {
    $dados[] = $r;
}

echo json_encode(['data' => $dados]);
