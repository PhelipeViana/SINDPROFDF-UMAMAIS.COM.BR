<?php

include "../_conect.php";
$REQUISICAO = AUTORIZATION(); //POST PARA PROTEGER
$AUTORIZACAO = $REQUISICAO['STATUS'];
$MSG = $REQUISICAO['MSG'];
$AUTH = isset($_REQUEST['auth']) ? $_REQUEST['auth'] : "";

switch ($AUTH) {

	case 1:
		include "01_login.php";
		break;

	case 2:
		include "02_LISTAR_ATENDENTES.php";
		break;

	case 3:
		include "03_EDICAO_ATENDENTES.php";
		break;

	case 4:
		include "04_CRIAR_ATENDENTE.php";
		break;

	case 5:
		include "05_LISTAR_HASTAG.php";
		break;

	case 6:
		include "06_GER_HASTAG.php";
		break;

	case 7:
		include "07_FILA_ATENDIMENTO.php";
		break;


	case 8:
		include "08_PEGAR_ATENDIMENTO.php";
		break;

	case 9:
		include "09_ATENDIMENTO_EM_CURSO.php";
		break;

	case 10:
		include "10_LISTAR_CONVERSAR_POR_NUMERO.php";
		break;

	case 11:
		include "11_CADASTRO_EDICAO.php";
		break;

	case 12:
		include "12_ENCERRAR_ATENDIMENTO.php";
		break;


	case 13:
		include "13_HAST_ID_CLIENTE.php";
		break;

	case 14:
		include "14_ATIV_DES_HASTG.php";
		break;


	case 15:
		include "15_BASE_DADOS.php";
		break;

	case 16:
		include "16_WHATS_CAMPANH.php";
		break;

	case 17:
		include "17_SELECIONE_CLIENTE_PERFIL.php";
		break;

	case 18:
		include "18_LISTAR_CAMPANHAS.php";
		break;

	case 19:
		include "19_EDITAR_NOME_ARQUIVO.php";
		break;

	case 20:
		include "20_LISTAR_MIDIAS.php";
		break;

	case 21:
		include "21_Bloqueia_arquivos.php";
		break;

	case 22:
		include "22_desbloqueia_arquivo.php";
		break;

	case 23:
		include "23_EDITAR_MENSAGEM.php";
		break;

	case 24:
		include "24_NOVA_CAMPANHA.php";
		break;

	case 25:
		include "25_RETIRAR_LISTA.php";
		break;

	case 26:
		include "26_ADICIONAR_LISTA.php";
		break;


	case 27:
		include "27_ALTERAR_NUM_REFER.php";
		break;

	case 28:
		include "28_LISTAR_TODAS_TAGS.php";
		break;


	case 29:
		include "29_TAGEAR_GERAL.php";
		break;
	case 30:
		include "30_TAGEAMENTO_PASSO_A_PASSO.php";
		break;
		case 31:
			include "31_LISTAS_TRANSMISSAO.php";
			break;




	default:
		echo json_encode(['msg' => 'nok1']);
		break;
}
