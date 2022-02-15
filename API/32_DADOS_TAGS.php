<?php

$sub = "SELECT `idhastag`, nomehastag FROM `hastag` WHERE `tipo_tag`=2";
$exe_sub = mysqli_query($conn, $sub);
while ($r = mysqli_fetch_assoc($exe_sub)) {
    $LINHA[] = $r;
}
$sub_local = "SELECT `idhastag`,
nomehastag,
(SELECT COUNT(*) FROM `hast_cadastro` WHERE `REF_HASTAG`=HT.idhastag) AS total
 FROM `hastag` AS HT WHERE `tipo_tag`=1";
$exe_local = mysqli_query($conn, $sub_local);
while ($r = mysqli_fetch_assoc($exe_local)) {
    $COLUNA[] = $r;
}

for ($l = 0; $l < count($LINHA); $l++) {
   $NUM_LINHA=$LINHA[$l]['idhastag'];
   
   $sql_total = "SELECT * FROM `hast_cadastro` 
    WHERE `REF_HASTAG`=$NUM_LINHA";
    $exe_total = mysqli_query($conn, $sql_total);
    $num_total = mysqli_num_rows($exe_total);

    $data[$LINHA[$l]['nomehastag']]['total']=$num_total;
    $data[$LINHA[$l]['nomehastag']]['id_tag']=$NUM_LINHA;
    
    for ($c = 0; $c < count($COLUNA); $c++) {
        $LINHA_MASTER = $LINHA[$l]['idhastag'];
        $COLUNA_MASTER = $COLUNA[$c]['idhastag'];
        //$array = $LINHA_MASTER . "," . $COLUNA_MASTER;
        $sub="SELECT REF_CADASTRO FROM `hast_cadastro` 
        WHERE `REF_HASTAG`='$NUM_LINHA'";
        
        $sql = "SELECT * FROM `hast_cadastro` 
        WHERE REF_CADASTRO in ($sub) and REF_HASTAG='$COLUNA_MASTER'";

        $exe = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($exe);
        $data[$LINHA[$l]['nomehastag']][$COLUNA[$c]['nomehastag']]['PARCIAL'] = $num;
        $data[$LINHA[$l]['nomehastag']][$COLUNA[$c]['nomehastag']]['LINHA'] = $LINHA_MASTER;
        $data[$LINHA[$l]['nomehastag']][$COLUNA[$c]['nomehastag']]['COLUNA'] = $COLUNA_MASTER;
        $locais[]=$COLUNA[$c]['nomehastag'];
    }
}



echo json_encode(['ret' => $data,'COLUNAS'=>$COLUNA]);
