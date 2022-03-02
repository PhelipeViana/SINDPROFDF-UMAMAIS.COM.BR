<?php
header('Access-Control-Allow-Origin: *');
include "../_conect.php";

$BUSCA = $_GET['nome'];

$sql = "SELECT id_carregamento,`nome_carregamento`,	phone_carregamento FROM `carregamento_contato` 
WHERE  `nome_carregamento` LIKE '$BUSCA%'";

$exe = mysqli_query($conn, $sql);

while ($r = mysqli_fetch_assoc($exe)) {
    $dados[] = $r;
}

echo json_encode(['data' => $dados]);
