<h1 class="jumbotron text-center">BASE DE DADOS <span class="badge badge-primary" id='num_db'>...</span></h1>

<hr>

<div class="templatemo-flex-row my-5">
	<div class="templatemo-content col-md-12 light-gray-bg">

		<button class="btn btn-success btn-block" id="btn_gerenciar_hastag">
			GERENCIAR MINHAS <i class="fa fa-hashtag" aria-hidden="true"></i>HASTAG
		</button>
		<br>
		<a href="TAGEAMENTO.php" target="_blank">
			<button class="btn btn-danger btn-block">TAGEAMENTO AUTOMÁTICO</button>
		</a>
		<hr>
		<hr>
		<div>
			<div class="row">
				<div class="col-md-8">
					<label for="">Pesquisa</label>
					<div class="row">
						<input type="text" class="form-control" placeholder="Nome ou numero" id="input_pesquisa" style="height: 34px !important;">
					</div>
				</div>
				<!-- <div class="col-md-4">
					<label for="">Grupo unitário</label>
					<select name="grupo" id="select_group" class="form-control"></select>
				</div> -->
				<div class="col-md-2">

					<label for="">Limite</label>
					<select id="select_limit" class="form-control"></select>
				</div>

				<div class="col-md-2" style="padding-top: 23px;">
					<button class="btn btn-danger btn-block" id="btn_pesquisa"><i class="fa fa-search"></i></button>
				</div>

			</div>
			<br><br>
		</div>
		<div id="retorno_das_pesquisas" class="text-center"></div>
		<table class="table table-bordered table-responsive-sm table-striped" id='tabela_investidor'>
			<thead>
				<tr>

					<th scope="col">
						<!-- <button class="btn btn-danger btn-block" id='tag_geral'># GERAL</button>
						<div class="text-center">
							<p>
								Todos
								<input type="checkbox" class="form-control" id='check_all'>
							</p>
						</div> -->
					</th>
					<th scope="col">Nome</th>
					<th scope="col">Contato</th>
					<th scope="col">Canal</th>
					<th scope="col">#Edição</th>
				</tr>
				<!-- 	<tr>
					<th colspan='4'>
						<label for="">Pesquise</label>
						<input type="text" class='form-control' pleaceholder='Pesquise' id='filtro_nome_cadastrados'>
					</th>
				</tr> -->
			</thead>
			<tbody id='corpo_cadastrados'>

			</tbody>
		</table>

	</div>
</div>
<div class="modal fade" id="modal_gerenciar_hastag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">GERENCIAR HASTAG</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
				<table class="table">
					<thead>
						<tr>
							<th colspan="2">
								<input type="text" class="form-control" placeholder="Nome Tag" id="input_nova_tag">
							</th>

							<th colspan="2">
								<button class="btn btn-block" id="btn_add_tag">Adicionar</button>
							</th>

						</tr>
						<tr>
							<th scope="col"><i class="fa fa-users" aria-hidden="true"></i></th>

							<th scope="col">#nome</th>
							<th scope="col" colspan="2">STATUS</th>
						</tr>
					</thead>
					<tbody id='list_hastag'>

					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_tags" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabeltagas">#CLASSIFICAR</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h1 class="text-center">#HASTAGS</h1>
				<table class="table table-bordered table-responsive-sm">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Tag</th>
						</tr>
					</thead>
					<tbody id="corpo_table_hast">

					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">FECHAR</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_cadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulo_numero"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_cadastro">
					<label for="">Nome</label>
					<input type="text" class="form-control" placeholder="Nome Completo" id='input_nome' name="nome" required minlength="5">
					<input type="hidden" id="input_id" name="numero">
					<input type="hidden" id="input_foto" name="foto">
					<input type="hidden" id="input_canal" name="canal">


			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Salvar</button>
				</form>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_lista_massa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">TAGEAR GERAL</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="text-center" id='qtde_select'></div>
				<table class="table table-stripe">
					<tbody id="corpo_tag_todos"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
			</div>
		</div>
	</div>
</div>







<script>
	READ.contatos();
	READ.tags_geral();


	let ID_DADOS = [];
	$("#check_all").on('click', function(e) {
		ID_DADOS = [];
		if ($("#check_all").prop("checked")) {

			$(".escolha_linha")
				.prop("checked", true)
				.each(function(e) {
					let id = $(this).data('id');
					ID_DADOS.push(id)
				})


		} else {
			$(".escolha_linha").prop("checked", false);
			ID_DADOS = [];
		}
	})

	$("#tag_geral").on('click', function(e) {
		if (ID_DADOS == '') {
			alert('Ops!\nSelecione algum usúario!');
		} else {
			let num_select = ID_DADOS.length
			$("#modal_lista_massa").modal('show')
			READ.tags_em_massa();
			$("#qtde_select").html('<h3>' + num_select + ' USÚARIO(S)</h3>')

		}

	})

	function ret_tags_em_massa(response) {
		let indice = response.ret;
		let corpo = "";

		for (let i = 0; i < indice.length; i++) {
			corpo += `
			<tr>
			<td>${indice[i].nomehastag}</td>
			<td>
			<button class="btn btn-primary btn-block tag_geral" 
			data-tag='${indice[i].idhastag}' 
			id='btn_tag_geral${indice[i].idhastag}'>TAGEAR TODOS</button>
			</td>
			</tr>
			`
		}
		$("#corpo_tag_todos").html(corpo)
		$(".tag_geral").on('click', function(e) {
			let tag = $(this).data('tag');
			$("#btn_tag_geral" + tag)
				.attr('disabled', true)
				.removeClass('btn-primary')
				.addClass('btn-secondary')
				.html('...aguarde')
			UPDATE.tag_massa(tag)

			console.log(DADOS.CLASSE_CHECK_DATA('29', 'id', 'escolha_linha', tag))

		})
	}

	function ret_btn_tag_mass(response) {
		console.log(response)
		let btn = $("#btn_tag_geral" + response.tag);
		let status = response.st;
		if (status == '1') {
			btn
				.removeClass('btn-secondary')
				.addClass('btn-success')
				.html('Sucesso: ' + response.num_tageados)
		} else {

			btn
				.removeClass('btn-secondary')
				.addClass('btn-danger')
				.html('TODOS JÁ TAGEADOS')
		}
	}

	function ret_tags_geral(response) {
		let corpo = "";
		corpo += ` 
		<option value='-1'>ESCOLHA O GRUPO</option>
		<option value='0'>TODOS SEM GRUPO</option>
		`
		let indice = response.ret
		for (let i = 0; i < indice.length; i++) {
			corpo += ` <option value='${indice[i].idhastag}'>${indice[i].nomehastag}</option> `
		}
		$("#select_group").html(corpo)
	}
	$("#btn_pesquisa").on('click', function(e) {
		let valor = $("#input_pesquisa").val()
		let valor_grupo = $("#select_group").val()
		let valor_grupo_text = $("#select_group option:selected").text();
		let corpo_ret = "";
		$("#check_all").prop("checked", false)
		ID_DADOS = [];

		corpo_ret = `<h1>${valor+' ('+valor_grupo_text+') '}</h1> <button class='btn btn-link' id='limpa_pesquisa'>Limpar pesquisa</button> `;
		READ.contatos(0, valor, valor_grupo);
		$("#retorno_das_pesquisas").html(corpo_ret)

		$("#limpa_pesquisa").on('click', function(e) {

			READ.contatos();
			$("#retorno_das_pesquisas").html('') //LIMPA O RESULTADO DA PESQUISA
			$("#input_pesquisa").val('');
			$("#select_group").val(-1)
			$("#check_all").prop("checked", false);
			ID_DADOS = [];

		})

	})

	function readcontatos(response) {
		let indice = response.ret;
		let corpo = "";
		if (indice !== null) {
			corpo = "";
			for (let i = 0; i < indice.length; i++) {
				corpo += `
				<tr>
				<td>
				${[i+1]}
		
				
				</td>

				<td>
				${indice[i].nome_carregamento}
				</td>
				<td>${indice[i].phone_carregamento}</td>
				<td>${indice[i].nome_canalzapio}</td>
				`

				if (indice[i].ativo == 1) {
					corpo += `<td>
					<div class="btn-group" role="group" aria-label="Basic example">
					
					<button type="button" class="btn btn-success classificar" data-id='${indice[i].id_carregamento}'>
					<i class="fa fa-hashtag" aria-hidden="true"></i>
					</button>

					<button type="button" class="btn btn-warning adicionar"
					data-num='${indice[i].phone_carregamento}'
					data-nome='${indice[i].nome_carregamento}'
					data-foto='${indice[i].foto_carregamento}'
					data-canal='${indice[i].IDREFCANAL}'>
					<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
					<button type="button" class="btn btn-danger msg_ger"
					data-id='${indice[i].id_canalzapio}'
					data-tk='${indice[i].token_canalzapio}'
					data-num='${indice[i].phone_carregamento}'
					data-canal='${indice[i].idcanalzapio}'
					data-nome='${indice[i].nome_carregamento}'>
					<i class="fa fa-paper-plane" aria-hidden="true"></i>
					</button>
					</div>				
					</td>`

				} else {
					corpo += `<td>
					INATIVO		
					</td>`

				}

				corpo += `</tr> 

				`
			}
		} else {
			corpo += `
			<tr>
			<td  colspan='5' class='text-center'><h1>NÃO HÁ REGISTRO(S)</h1></td>
			</tr> 

			`

		}

		$("#corpo_cadastrados").html(corpo)
		$("#num_db").html(response.num);
		let num_paginas = Math.ceil(response.num / 100);
		let corpo_select = "";
		//select_limit
		for (let i = 1; i < num_paginas; i++) {

			corpo_select += ` 
			<option value='${[i*100]}'>${[i*100]}</option>
			`
		}
		corpo_select += ` 
		<option value='${response.num}'>TODOS</option>
		`

		$(".escolha_linha").on('click', function(e) {
			let id = $(this).data('id')
			$("#check_all").prop("checked", false)

			if ($(this).prop("checked")) {
				ID_DADOS.push(id)

			} else {

				let arr = ID_DADOS.indexOf(id)
				ID_DADOS.splice(arr, 1);

			}


		})
		$("#select_limit")
			.html(corpo_select)
			.on('change', function(e) {
				let qtde = $(this).val()

				READ.contatos(qtde);
				//limpa pesquisa se houver
				$("#retorno_das_pesquisas").html('') //LIMPA O RESULTADO DA PESQUISA
				$("#input_pesquisa").val('');

			})

		$("#select_limit").val(response.pagina) //iniciar da base de pesquisa

		$(".classificar").on('click', function(e) {
			let id = $(this).data('id');
			READ.hast_cliente(id)
		})
		$('.adicionar').on('click', function(e) {
			let num = $(this).data('num');
			let nome = $(this).data('nome');
			let foto = $(this).data('foto');
			let canal = $(this).data('canal');


			let retorno = "";
			if (nome == "") {
				retorno = 'NÃO CADASTRADO';
			} else {
				retorno = nome;
			}

			$("#input_nome").val(nome)
			$("#input_id").val(num)
			$("#input_foto").val(foto)
			$("#input_canal").val(canal)


			$("#titulo_numero").html(retorno)
			$("#modal_cadastro").modal('show');
		})
		$(".msg_ger").on('click', function(e) {
			let id = $(this).data('id');
			let tk = $(this).data('tk');
			let num = $(this).data('num');
			let nome = $(this).data('nome');
			let canal = $(this).data('canal');


			let msg = prompt('Qual é a mensagem para:\n' + nome + '?');
			if (msg) {
				enviandoMensagemTexto(id, tk, num, msg, canal);
			}


		});

	}
	$("#form_cadastro").submit(function(event) {
		event.preventDefault();
		UPDATE.cadastramento("form_cadastro")

	});

	function updatecadastramento(response) {
		$("#modal_cadastro").modal('hide');
		alert(response.msg);
		//atualiza a lista
		READ.contatos();


	}


	$("#btn_gerenciar_hastag").on('click', function(e) {
		$("#modal_gerenciar_hastag").modal('show')
		READ.hastags()

	})


	$("#btn_add_tag").on('click', function(e) {
		let nome_tag = $("#input_nova_tag").val();
		if (nome_tag.length > 0) {
			CREATE.hastags(0, 1, nome_tag);

		} else {
			$("#input_nova_tag").focus()
		}
	})

	function retacaohastags(response) {
		let indice = response.indice;
		switch (indice) {
			case 1:
				if (response.st == 1) {
					READ.hastags();
					$("#input_nova_tag").val('').css('color', 'black')
				}
				if (response.st == 2) {
					alert('HASTAG JÁ EXISTE');
					$("#input_nova_tag")
						.css('color', 'red')
						.focus()

				}
				break;
			case 2:

				READ.hastags()
				break;
			case 3:
				READ.hastags()

				break;
		}
	}

	function retmontarhastags(response) {
		let indice = response.ret;

		let corpo = "";
		if (indice !== null) {
			for (let i = 0; i < indice.length; i++) {
				let comando = ""
				if (indice[i].ativohastag == '1') {
					comando += `
					<button class='btn btn-primary btn-block inativar' data-id='${indice[i].idhastag}'>ATIVO</button>
					`
				} else {
					comando += `
					<button class='btn btn-danger btn-block ativar' data-id='${indice[i].idhastag}'>INATIVO</button>
					`
				}
				corpo += `
				<tr>

				<td>${indice[i].qdecad}</td>
				<td>${indice[i].nomehastag}</td>
				<td colspan="2">${comando}</td>
				</tr> 

				`
			}
		} else {
			corpo = "CARREGANDO...";
		}
		$("#list_hastag").html(corpo)
		$(".inativar").on('click', function(e) {
			let id = $(this).data('id')
			let ok = confirm('Deixar cadastrar pessoas com essas hastags?')
			if (ok) {
				CREATE.hastags(id, 3);
			}

		})
		$(".ativar").on('click', function(e) {
			let id = $(this).data('id')
			let ok = confirm('Cadastrar pessoas com essas hastags?')
			if (ok) {
				CREATE.hastags(id, 2);

			}

		})
	}

	function readhast_cliente(response) {
		let indice = response.TAGS;
		let corpo = "";
		if (indice !== null) {
			for (let i = 0; i < indice.length; i++) {
				let comandoativo = "";
				if (indice[i].ativo > 0) {
					comandoativo += `
					<button class='btn btn-success desativar' data-id='${indice[i].idhastag}' data-user='${indice[i].id}'>ATIVO</button>
					`
				} else {
					comandoativo += `
					<button class='btn btn-secondary ativar' data-id='${indice[i].idhastag}' 
					data-user='${indice[i].id}'>INATIVO</button>
					`

				}


				corpo += `
				<tr>
				<td>${indice[i].nomehastag}</td>
				<td>
				${comandoativo}
				</td>
				</tr>
				`
			}
		} else {
			corpo += `
			<tr colspan='2'>
			<td>
			<h1>NENHUMA TAG ATIVA</h1>
			</td>
			</tr>
			`
		}

		$("#corpo_table_hast").html(corpo)
		$("#modal_tags").modal('show')
		$(".desativar").on('click', function(e) {
			$(this)
				.attr('disabled', true)
				.html('..aguarde')
			let id = $(this).data('id');
			let user = $(this).data('user');
			UPDATE.atualiza_hatgs(0, id, user)

		})
		$(".ativar").on('click', function(e) {
			$(this)
				.attr('disabled', true)
				.html('..aguarde')
			let id = $(this).data('id');
			let user = $(this).data('user');
			UPDATE.atualiza_hatgs(1, id, user)

		})
	}


	$(function() {
		$("#filtro_nome_cadastrados").keyup(function() {

			var index = $("#filtro_nome_cadastrados").parent().index();
			var nth = "#tabela_investidor td:nth-child(" + (index + 1).toString() + ")";
			var valor = $(this).val().toUpperCase();
			$("#tabela_investidor tbody tr").show();
			$(nth).each(function() {
				if ($(this).text().toUpperCase().indexOf(valor) < 0) {
					$(this).parent().hide();
				}
			});

		});

		$("#tabela_investidor input").blur(function() {
			$(this).val("");
		});
	});

	function enviandoMensagemTexto(ID, TOKEN, NUMERO, MENSAGEM, CANAL) {
		let obj = {
			ID: ID,
			TOKEN: TOKEN,
			NUMERO: NUMERO,
			MENSAGEM: MENSAGEM,
			CANAL: CANAL,
			ATENDENTE: "<?= $row['nome_acesso'] ?>",
			REF_IDATENDENTE_MSG: "<?= $row['id_acesso'] ?>"
		}
		$.ajax({
				url: 'GERENCIA/zapio/texto.php',
				type: 'POST',
				dataType: 'json',
				data: obj
			})
			.done(function(response) {
				if (response.st == 1) {
					alert('Enviado com sucesso!');
				} else {
					alert('Ops! Erro ao enviar')
				}


			})
	}
</script>