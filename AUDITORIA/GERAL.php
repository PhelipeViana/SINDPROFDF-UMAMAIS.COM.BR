<?php

include "../_conect.php";

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DADOS DO DISPAROS</title>
    <script src="../SCRIPTS/jquery.js"></script>
    <link href="../ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
    <link href="../ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
    <script src="../ATENDENTE/js/bootstrap.min.js"></script>
    <script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-KAZ4DtjNhLChOB/hxXuKqhMLYvx3b5MlT55xPEiNmREKRzeEm+RVPlTnAn0ajQNs" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <div class="text-center jumbotron">
            <h1>AUDITORIA</h1>
            <p class="text-danger">Contatos da agenda em <?= date('d/m/Y h:i:s') ?></p>
        </div>
        <hr>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">TOTAL DE NÚMEROS</th>
                    <th scope="col">EM ANALISE</th>
                    <th scope="col">ATIVOS</th>
                    <th scope="col" class="text-danger">INATIVOS</th>
                    <th scope="col" class="noprint">
                        <button class="btn btn-danger" onclick="window.print()">
                            <i class="fa fa-print" aria-hidden="true"></i>
                        </button>
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="total_agenda">-</td>
                    <td id="total_analise">0</td>

                    <td id='total_ativo'>-</td>
                    <td id="total_inativo" class="text-danger">-</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Número</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `DISPAROS` limit 100";
                $exe = mysqli_query($conn, $sql);
                $i = 0;
                while ($row = mysqli_fetch_assoc($exe)) {

                ?>
                    <tr>
                        <th><?= $i + 1 ?></th>
                        <th><?= $row['nome_disparo']  ?></th>
                        <td><?= $row['num_disparo']?></td>
                        <td><?= $row['num_valido']?></td>
                    </tr>

                <?php
                    $i++;
                }
                ?>


            </tbody>
        </table>

    </div>




</body>

</html>