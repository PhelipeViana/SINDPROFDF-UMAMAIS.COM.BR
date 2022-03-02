<?php
include "_conect.php";















?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RELATÓRIO GERAL</title>
    <link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
    <link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
    <script src="ATENDENTE/js/bootstrap.min.js"></script>
    <script src="ATENDENTE/js/mascara.js"></script>
</head>

<body>
    <h1 class="jumbotron text-center">RELATÓRIO GERAL</h1>
    <p class="text-center text-danger">a) Quantas mensagens foram enviadas no total?</p>
    <p class="text-center text-danger">b) Quantas mensagens foram enviadas por dia?</p>

    <hr>
    <table class="table">
        <thead>
            <tr>

                <th>DATA</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_mensagens = "SELECT DISTINCT(date(date)) as data, COUNT(*) as num FROM `LOG_ENVIO` GROUP BY date(date) ORDER by date(date) DESC";
            $exe = mysqli_query($conn, $sql_mensagens);

            while ($r = mysqli_fetch_assoc($exe)) {
            ?>
                <tr>
                    <td>
                        <?= date('d/m/Y', strtotime($r['data']))  ?>
                    </td>
                    <td>
                        <?= $r['num'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    <p class="text-center text-danger">c) Quantas mensagens foram lidas?</p>
    <hr>
    <table class="table">
        <thead>
            <tr>

                <th>DATA</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_mensagens_lidas = "SELECT DISTINCT(date(date)) as data, COUNT(*) as num FROM `LOG_ENVIO` WHERE status_log='READ' GROUP BY date(date) ORDER by date(date) DESC";
            $exe = mysqli_query($conn,  $sql_mensagens_lidas);

            while ($r = mysqli_fetch_assoc($exe)) {
            ?>
                <tr>
                    <td>
                        <?= date('d/m/Y', strtotime($r['data']))  ?>
                    </td>
                    <td>
                        <?= $r['num'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    <p class="text-center text-danger">d) Quantas mensagens foram respondidas?</p>
    <hr>
    <table class="table">
        <thead>
            <tr>

                <th>DATA</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_respondidas = "SELECT DISTINCT(date(data_mensagem)) as data, count(*) as num FROM `MENSAGENS` WHERE `tipo`='1' GROUP by date(data_mensagem) ORDER BY date(data_mensagem) DESC";
            $exe = mysqli_query($conn, $sql_respondidas);

            while ($r = mysqli_fetch_assoc($exe)) {
            ?>
                <tr>
                    <td>
                        <?= date('d/m/Y', strtotime($r['data']))  ?>
                    </td>
                    <td>
                        <?= $r['num'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    <p class="text-center text-danger">f) Quantos contatos digitaram 0?</p>
    <hr>
    <table class="table">
        <thead>
            <tr>

                <th>DATA</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_zeros = "SELECT DISTINCT(date(data_mensagem)) as data, count(*) as num FROM `MENSAGENS` WHERE `mensagem`='0' GROUP by date(data_mensagem) ORDER BY date(data_mensagem) DESC";
            $exe = mysqli_query($conn, $sql_zeros);

            while ($r = mysqli_fetch_assoc($exe)) {
            ?>
                <tr>
                    <td>
                        <?= date('d/m/Y', strtotime($r['data']))  ?>
                    </td>
                    <td>
                        <?= $r['num'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    <p class="text-center text-danger">POSSIVEIS BLOQUEIOS</p>
    <hr>
    <table class="table">
        <thead>
            <tr>

                <th>DATA</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_zeros = "SELECT DISTINCT(date(date)) as data, COUNT(*) as num FROM `LOG_ENVIO` WHERE status_log IS NULL GROUP BY date(date) ORDER by date(date) DESC";
            $exe = mysqli_query($conn, $sql_zeros);

            while ($r = mysqli_fetch_assoc($exe)) {
            ?>
                <tr>
                    <td>
                        <?= date('d/m/Y', strtotime($r['data']))  ?>
                    </td>
                    <td>
                        <?= $r['num'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    <p class="text-center text-danger">CADASTRADOS POR DIA NA BASE QUENTE</p>
    <hr>
    <table class="table">
        <thead>
            <tr>

                <th>DATA</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_zeros = "SELECT DISTINCT(date(data_vinculado)) as data, COUNT(*) as num FROM carregamento_contato GROUP BY date(data_vinculado) ORDER by date(data_vinculado) DESC";
            $exe = mysqli_query($conn, $sql_zeros);

            while ($r = mysqli_fetch_assoc($exe)) {
            ?>
                <tr>
                    <td>
                        <?= date('d/m/Y', strtotime($r['data']))  ?>
                    </td>
                    <td>
                        <?= $r['num'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    
    

</body>

</html>