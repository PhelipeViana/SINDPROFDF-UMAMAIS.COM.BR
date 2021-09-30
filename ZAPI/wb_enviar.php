<?php 
include "../_conect.php";

$json = file_get_contents('php://input');
$decoded = json_decode($json,true);


$sql="INSERT INTO `teste` (`retorno`) VALUES ('$json')";

$exe=mysqli_query($conn,$sql);
