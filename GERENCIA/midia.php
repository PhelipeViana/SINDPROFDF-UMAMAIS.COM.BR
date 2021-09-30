<div class="jumbotron text-center">
	<h1>GERENCIAR ARQUIVOS</h1>	
</div>
<div class="row">
	<div class="col-4"></div>
	<div class="col-4">
		<form action="_midia.php" method="post" enctype="multipart/form-data" id="form_subir_arquivo">

			<input type="file" name="arq" size="20" required>
			<br>
			<button class='btn btn-danger col-4' id='btn_gravar_arquivo'>GRAVAR ARQUIVO</button>	

		</form>		
	</div>
	<div class="col-4"></div>
</div>

<hr>
<table class="table table-bordered table-striped">
	<thead class="text-center">
		<tr>
			<th>#</th>
			<th>NOME</th>
			<th>ARQUIVO</th>
			<th>EXTENSÃO</th>
			<th>ALTERADO</th>
			<th>STATUS</th>
		</tr>
	</thead>
	<tbody id="table_list_arquivo">
	</tbody>
</table>

<div class="modal fade" id="modal_editar_nome_arquivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">NOME DO ARQUIVO</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_editar_nome_arquivo">
					<label for="">Nome do arquivo</label>
					<input type="hidden" id="id_do_arquivo"  name="id">
					<input type="text" id="input_nome_arquivo" class="form-control" maxlength="50" name="arquivo">
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</form>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

			</div>
		</div>
	</div>
</div>
<script>

	READ.todos_arquivos()
	$("#form_subir_arquivo").submit(function(event) {
		$("#btn_gravar_arquivo")
		.attr('disable',true)
		.html('..aguarde')

	});
	$("#form_editar_nome_arquivo").submit(function(event) {
		event.preventDefault();
		UPDATE.nomearquivo('form_editar_nome_arquivo');
	});
	
	function retnomearquivo(response){
		let status=response.st;
		if(status==1){
			$("#input_nome_arquivo")
			.css('color','black')
			$("#modal_editar_nome_arquivo").modal('hide');
			alert('Alterado com sucesso!');
			READ.todos_arquivos()

		}else{
			alert('Ops! Nome já existe no DB');
			$("#input_nome_arquivo")
			.css('color','red')
			.focus();
		}
	}

	
	function rettodos_arquivos(response){
		let indice=response.ret;
		let corpo="";
		if(indice!==null){
			for(let i=0;i<indice.length;i++){
				let comando_status="";
				if(indice[i].statusArquivo==0){
					comando_status=` 
					<button class='btn btn-danger desbloquear_arquivo' 
					data-id='${indice[i].idArquivo}'>Bloqueado</button>
					`;
				}else{
					comando_status=` 
					<button class='btn btn-primary bloquear_arquivo' data-id='${indice[i].idArquivo}'>Liberado</button>
					`;
				}


				corpo+=`
				<tr class='text-center'>
				<th scope="row">${indice[i].idArquivo}</th>
				<td>
				<button class='btn btn-link btn-block edit_nome' 
				data-nome='${indice[i].nomeArquivo}' 
				data-id='${indice[i].idArquivo}'>
				${indice[i].nomeArquivo} 
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</button>
				
				<a href='#' data-toggle="modal" data-target="#editar_nome_arquivo">

				
				</a>
				</td>
				<td>
				<a href="${indice[i].linkArquivo}" target='_blank'>
				<button class='btn btn-link btn-block'>VISUALIZAR</button>
				</a>
				</td>
				<td>${indice[i].extArquivo}</td>
				<td>${indice[i].alterArquivo}</td>
				<td>${comando_status}</td>
				</tr> 
				`
			}
		}else{
			corpo=`
			<tr>
			<th colspan='7' class='text-center'>NÃO HÁ ARQUIVOS</th>
			</tr> 
			`
		}
		$("#table_list_arquivo").html(corpo);
		
		$(".edit_nome").on('click',function(e){
			let nome=$(this).data('nome')
			let id=$(this).data('id')
			$('#input_nome_arquivo').val(nome)
			$('#id_do_arquivo').val(id)			
			$("#modal_editar_nome_arquivo").modal('show')

		})
		$(".desbloquear_arquivo").on('click',function(e){
			let id=$(this).data('id')
			let ok=confirm('Ao DESBLOQUEAR, esse arquivo ficará DISPONIVEL para o ATENDENTE!\nDeseja mesmo assim?');
			if(ok){
				UPDATE.desbloqueiaarrquivo(id)
			}
		})
		$(".bloquear_arquivo").on('click',function(e){
			let id=$(this).data('id')
			let ok=confirm('Ao BLOQUEAR, esse arquivo ficará INDISPONIVEL para o ATENDENTE!\nDeseja mesmo assim?');
			if(ok){
				UPDATE.bloquearrquivo(id)
			}			
		})

	}

</script>

