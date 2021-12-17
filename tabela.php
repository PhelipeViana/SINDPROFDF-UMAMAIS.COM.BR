<?php
include "_conect.php";


$sql = "SELECT * FROM `AGENDA` WHERE num not in (SELECT AG.num FROM `AGENDA` as AG inner join carregamento_contato as CA ON AG.num=CA.phone_carregamento) and valido=1";
$exe = mysqli_query($conn, $sql);
$num=mysqli_num_rows($exe);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TABELA <?=$num?></title>
    <link href="ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
    <link href="ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
    <script src="ATENDENTE/js/bootstrap.min.js"></script>
    <script src="ATENDENTE/js/mascara.js"></script>
</head>

<body>
    <h1 class="jumbotron text-center">AGENDA SIM BASE NÃO</h1>
    <table class="table">
        <thead>
            <tr>
              
                <th>NOME</th>
                <th>NUM</th>

            </tr>
        </thead>
        <tbody>
            <?php
          
            while ($r = mysqli_fetch_assoc($exe)) {
            ?>

                <tr>
                  

                    <td>
                        <?= $r['nome'] ?>
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