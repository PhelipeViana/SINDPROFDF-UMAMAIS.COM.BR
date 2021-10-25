<?php

include "../_conect.php";

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUDITORIA EM AGENDA</title>
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
                    <th scope="col">Número</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `auditoria` order by id_carregamento asc";
                $exe = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($exe)) {
                    // estatistica
                    if ($row['num_valido'] == 1) {
                        $NUM_VALIDO++;
                        $CLASS = "";
                        $TXT = "VÁLIDO";
                    } elseif ($row['num_valido'] == 2) {
                        $NUM_INVALIDO++;
                        $CLASS = "text-danger";
                        $TXT = "INATIVO/SPAM";
                    } else {
                        $EM_ANALISE++;
                        $CLASS = "";
                        $TXT = "EM ANALISE";
                    }
                    $NUM_TOTAL++;

                ?>
                    <tr class="<?= $CLASS ?>">
                        <th scope="row"><?= $row['id_carregamento'] ?></th>
                        <td><?= $row['phone_carregamento'] ?></td>
                        <td><?= $TXT ?></td>
                    </tr>

                <?php
                }
                ?>


            </tbody>
        </table>

    </div>
    <script>
        $("#total_agenda").html('<?= number_format($NUM_TOTAL, 0, ",", ".") ?>');
        $("#total_ativo").html('<?= number_format($NUM_VALIDO, 0, ",", ".") ?>');
        $("#total_inativo").html('<?= number_format($NUM_INVALIDO, 0, ",", ".") ?>');
        $("#total_analise").html('<?= number_format($EM_ANALISE, 0, ",", ".") ?>');
    </script>

</body>

</html>