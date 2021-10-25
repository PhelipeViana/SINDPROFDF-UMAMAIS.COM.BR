<?php
set_time_limit(50000);
//validando numeros errados


include "_conect.php";


$sql = "SELECT phone_carregamento FROM `auditoria` where num_valido=0";
$exe = mysqli_query($conn, $sql);

while ($r = mysqli_fetch_assoc($exe)) {
    $dados[] = $r;
}

//var_dump($dados);

for ($i = 0; $i < count($dados); $i++) {
    $phone = $dados[$i]['phone_carregamento'];
    validador_number($phone);
    
}
echo "<script>alert('TERMINOU!')</script>";






function validador_number($phone)
{
    global $conn;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.z-api.io/instances/3A04E937F4F6F0FB819FF69AF8E18979/token/CAD2FF6203C2AA43885D2640/phone-exists/' . $phone,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    $r = json_decode($response)->exists;
    $erro = json_decode($response)->error;
    curl_close($curl);
    if (isset($erro)) {
        echo "<script>alert('APARELHO DESCONECTADO!')</script>";
        $sql = "UPDATE `auditoria` SET `num_valido`=0 WHERE `phone_carregamento`='$phone'";
        mysqli_query($conn, $sql);
        die();
    } else {
        if ($r) {
            $sql = "UPDATE `auditoria` SET `num_valido`=1 WHERE `phone_carregamento`='$phone'";
            mysqli_query($conn, $sql);
            echo $phone . "-> EXISTE<br>";
        } else {

            $sql = "UPDATE `auditoria` SET `num_valido`=2 WHERE `phone_carregamento`='$phone'";
            mysqli_query($conn, $sql);
            echo $phone . "-> NÃO EXISTE</br>";
        }
    }
}
