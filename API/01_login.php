<?php 

$login=noInjection($_REQUEST['login']);
$login=strtolower($login);

$senha=noInjection($_REQUEST['senha']);
$senha=md5($senha);



$sql="SELECT `id_acesso`, `nivel` FROM `acesso` 
WHERE `login_acesso`='$login' AND `senha_acesso`='$senha'";

$exe=mysqli_query($conn,$sql);
$existe=mysqli_num_rows($exe);
$row=mysqli_fetch_assoc($exe);
$TOKEN=$row['id_acesso'];
$ACESSO=$row['nivel'];

if($existe > 0){
	echo json_encode(['msg'=>'login correto','tk'=>$TOKEN,'acesso'=>$ACESSO,'st'=>1]);

}else{
	echo json_encode(['msg'=>'erro login','st'=>0]);
	
}

