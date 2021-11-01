<?php

include "../_conect.php";

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socket.io</title>
    <script src="../SCRIPTS/jquery.js"></script>
    <link href="../ATENDENTE/css/bootstrap.min.css" rel="stylesheet">
    <link href="../ATENDENTE/css/font-awesome.min.css" rel="stylesheet">
    <script src="../ATENDENTE/js/bootstrap.min.js"></script>
    <script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-KAZ4DtjNhLChOB/hxXuKqhMLYvx3b5MlT55xPEiNmREKRzeEm+RVPlTnAn0ajQNs" crossorigin="anonymous"></script>

</head>

<body>


    <script>
        const socket = new WebSocket("ws://localhost:3306");

        socket.onopen = () => {
            socket.send("Hello!");
        };

        socket.onmessage = (data) => {
            console.log(data);
        };
    </script>

</body>

</html>