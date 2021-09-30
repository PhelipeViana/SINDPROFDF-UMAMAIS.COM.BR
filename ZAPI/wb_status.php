<?php 
include "../_conect.php";

$json = file_get_contents('php://input');

$decoded = json_decode($json,true);
$id=$decoded["id"];

$sql="UPDATE `teste` SET leu='$id' WHERE idmsg='$id'";

$exe=mysqli_query($conn,$sql);
