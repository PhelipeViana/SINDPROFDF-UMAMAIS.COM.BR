<?php
include "_conect.php";
//header('Content-Type: application/json');

$sub = "SELECT `id_acesso` FROM `acesso`";

$sql = "SELECT count(`id_rel_atendimento`) AS ATENDIMENTO, REF_ATENDENTE, A.nome_acesso AS NOME FROM `rel_atendimento` AS R 
left join acesso as A
ON R.REF_ATENDENTE=A.id_acesso
WHERE R.REF_ATENDENTE in ($sub) group by R.REF_ATENDENTE";
$exe = mysqli_query($conn, $sql);

// while ($r = mysqli_fetch_assoc($exe)) {
//     $dados[] = $r;
// }
// var_dump($dados);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>atendimento por atendentes</title>
    <link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
    <link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
    <script src="ATENDENTE/js/bootstrap.min.js"></script>
    <script src="ATENDENTE/js/mascara.js"></script>
</head>

<body>
<h1 class="jumbotron text-center">ATENDIMENTOS POR ATENDENTES</h1>
    <table class="table">
        <thead>
            <tr>
                <th>NOME</th>
                <th>Quantidade</th>

            </tr>
        </thead>

        <tbody>
            <?php
            while ($r = mysqli_fetch_assoc($exe)) {
            ?>

                <tr>
                    <td><?= $r['NOME'] ?></td>
                    <td><?= $r['ATENDIMENTO'] ?></td>

                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>

</body>

</html>