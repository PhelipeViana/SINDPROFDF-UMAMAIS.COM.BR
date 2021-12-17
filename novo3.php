<?php
include "_conect.php";


$sql_lidos = "SELECT * FROM `LOG_ENVIO` WHERE `status_log` LIKE 'READ'";
$exe_lidos = mysqli_query($conn, $sql_lidos);
$num_lidos = mysqli_num_rows($exe_lidos);
// cadastros
$sql_cadastro = "SELECT * FROM `carregamento_contato` ORDER BY `id_carregamento`";
$exe_cadastro = mysqli_query($conn, $sql_cadastro);
$num_cadastro = mysqli_num_rows($exe_cadastro);
//ATENDIMENTOS
$sql_atendimento = "SELECT * FROM `rel_atendimento`";
$exe_atendimento = mysqli_query($conn, $sql_atendimento);
$num_atendimentos = mysqli_num_rows($exe_atendimento);

//bloqueados
$sql_bloqueados = "SELECT * FROM `carregamento_contato`WHERE `ativo` = 2";
$exe_bloqueados = mysqli_query($conn, $sql_bloqueados);
$num_bloqueados = mysqli_num_rows($exe_bloqueados);


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
    <div class="container">
        <h1 class="jumbotron text-center">INDICE GERAL</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>LIDOS</th>
                    <th>ATENDIMENTOS</th>
                    <th>BASE ORGANIZADA</th>
                    <th>BLOQUEADOS</th>
                    <th>BASE ATIVA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $num_lidos ?></td>
                    <td><?= $num_atendimentos ?></td>

                    <td><?= $num_cadastro ?></td>
                    <td><?= $num_bloqueados ?></td>
                    <td><?= $num_cadastro-$num_bloqueados?></td>



                </tr>


            </tbody>
        </table>
    </div>
</body>

</html>