<?php 
include '_conect.php';
if (isset($_POST['token'])) {
	
	$_SESSION['token']=$_POST['token'];//token do usuario logado
	$_SESSION['acesso']=$_POST['acesso']; //acesso a pagina

}
//
//var_dump($_SESSION);
function verificar()
{

	if (isset($_SESSION['acesso'])) {
		switch ($_SESSION['acesso']) {

			case '1':
			header("Location:ATENDENTE.php");
			break;

			case '2':
			header("Location:GERENCIA.php");
			break;

			// case '1':
			// header("Location:admin.php");
			// break;

			default:
			header("Location:_deslogar.php");
			break;
		}
	}
}