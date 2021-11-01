<?php

include "../_conect.php";

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENVIOS EM GERAL</title>
    <script src="../SCRIPTS/jquery.js"></script>
    <link href="../ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
    <link href="../ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
    <script src="../ATENDENTE/js/bootstrap.min.js"></script>

    <style>
        .print_oculto {
            display: none;
        }

        .print_over {
            visibility: hidden;
        }

        @media print {
            .noprint {
                display: none;
            }

            .print_oculto {
                display: block;
            }

            .print_over {
                visibility: visible;
            }

        }

        /*quando passa o mouse sobre o menu*/
        .nav-link:hover {
            font-weight: bold;
        }

        /*quando selecionado menu*/

        .nav-link.active {
            border-bottom: 2px solid #fff;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center jumbotron">
            <h1>AUDITORIA DOS ENVIOS</h1>
            <p class="text-danger">Log dos envios <?= date('d/m/Y h:i:s') ?></p>
        </div>
        <hr>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">TOTAL DE ENVIOS</th>
                    <th scope="col">NÃO EXISTE (INATIVOS)</th>
                    <th scope="col">SPAM</th>

                    <th scope="col" class="noprint">
                        <button class="btn btn-danger" onclick="window.print()">
                            <i class="fa fa-print" aria-hidden="true"></i>
                        </button>
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="total_enviados">-</td>
                    <td id="total_invalidos">-</td>
                    <td id='total_spam' class="text-danger">-</td>

                </tr>
            </tbody>
        </table>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Número</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `LOG_ENVIO`";
                $exe = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($exe)) {
                    if ($row['type'] == 'ERROR') {
                        $row['type'] = 'Não Existe';
                        $NUM_INVALIDO++;
                    } else {
                        $row['type'] = 'Existe';
                    }

                    if (is_null($row['status_log'])) {
                        $row['status_log'] = '/ TEM SPAM';
                        $NUM_SPAM++;
                    } else {
                        $row['status_log'] = '/ OK';
                    }
                    $NUM_TOTAL++;

                ?>
                    <tr>
                        <th scope="row"><?= $row['id_log_envio'] ?></th>
                        <th scope="row"><?= $row['phone'] ?></th>
                        <th scope="row"><?= $row['type'] . $row['status_log'] ?></th>


                    </tr>

                <?php
                }
                ?>


            </tbody>
        </table>

    </div>
    <script>
        $("#total_enviados").html('<?= number_format($NUM_TOTAL, 0, ",", ".") ?>');
        $("#total_invalidos").html('<?= number_format($NUM_INVALIDO, 0, ",", ".") ?>');
        $("#total_spam").html('<?= number_format($NUM_SPAM, 0, ",", ".") ?>');
        // $("#total_analise").html('<?= number_format($EM_ANALISE, 0, ",", ".") ?>');
    </script>

</body>

</html>