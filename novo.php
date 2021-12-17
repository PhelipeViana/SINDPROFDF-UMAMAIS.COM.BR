<?php
include "_conect.php";


$sql = "SELECT * FROM `campanha_envios`";
$exe = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>num disparos por campanha</title>
    <link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
    <link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
    <script src="ATENDENTE/js/bootstrap.min.js"></script>
    <script src="ATENDENTE/js/mascara.js"></script>
</head>

<body>
    <h1 class="jumbotron text-center">CAMPANHAS FEITAS</h1>
    <table class="table">
        <thead>
            <tr>
                <th>NOME</th>
                <th>DATA</th>
                <th>Num Disparo</th>

            </tr>
        </thead>
        <tbody>
            <?php
            while ($r = mysqli_fetch_assoc($exe)) {
            ?>

                <tr>
                    <td>
                        <a href="relatorio.php?id=<?= $r['id_cam_envio'] ?>" target='_blank'>
                            <?= $r['msg'] ?>
                        </a>
                    </td>
                    <td>
                        <a href="relatorio.php?id=<?= $r['id_cam_envio'] ?>" target='_blank'>
                            <?= $r['nome_campanha'] ?>
                        </a>
                    </td>
                    <td><?= $r['num_envio'] ?></td>

                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>

</body>

</html>