<h1 class="jumbotron text-center">
	MEUS ATENDENTES
</h1>

<button class="btn btn-success btn-block"  data-toggle="modal" data-target="#modal_criar_atendente">ADICIONAR <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
<hr>
<div class="templatemo-flex-row my-5">
	<div class="templatemo-content col-md-12 light-gray-bg">
		<table class="table table-bordered table-responsive-sm table-striped" id='tabela_meus_atendentes'>
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Nome</th>
					<th scope="col">Login</th>
					<th scope="col">Editar</th>
				</tr>
				<tr>
					<th colspan='4'>
						<label for="">Pesquise</label>
						<input type="text" class='form-control' pleaceholder='Pesquise' id='filtro'>
					</th>
				</tr>
			</thead>
			<tbody id='corpo_atendentes'>
			</tbody>			
		</table>
		
	</div>
</div>

<div class="modal fade" id="modal_editar_atendente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar atendente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id='form_editar_atendente'>
					<input type="hidden" name="id" id="input_id_atendente">
					<label for="">Nome</label>
					<input type="text" class="form-control"  required  id="input_nome_atendente" minlength="5"> 
					<label for="">Login</label>
					<input type="email" class="form-control" required  id='input_login_atendente'>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</form>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fecha</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_criar_atendente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">NOVO ATENDENTE</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id='form_criar_atendente'>
					<label for="">Nome</label>
					<input type="text" class="form-control inputcad"  required name="nome"  minlength="5"> 
					<label for="">Email (Login) </label>
					<input type="email" class="form-control inputcad" required name="login">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">SALVAR</button>
				</form> 

				<button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>

			</div>
		</div>
	</div>
</div>
<script>
	$("#form_criar_atendente").submit(function(e){
		e.preventDefault()
		CREATE.novoatendente("form_criar_atendente")
	})

	function retnovoatendente(response){
		let status=response.st;
		switch (status) {
			case 1:
			alert('Criado com sucesso!\nSENHA:\n'+response.senha)
			READ.atendentes()
			$(".inputcad")
			.css('color','black')
			.val('')
			$('#modal_criar_atendente').modal('hide')
			break;
			
			case 2:
			alert('Ops! Email duplicado')
			$(".inputcad").css('color','red')
			
			break;
			
			default:
			alert('Erro inesperado!')
				break;
			}
		}

		READ.atendentes()
		function atendentes(response){
			let indice=response.ret;
			let corpo='';
			if(indice!==null){
				for(let i=0;i<indice.length;i++){
					let comandos="";
					if(indice[i].liberado==1){
						comandos+=` 
						<button type="button" class="btn btn-success bloquear" 
						data-id='${indice[i].id_acesso}'><i class="fa fa-check-circle" aria-hidden="true"></i></button>

						`
					}else{
						comandos+=` 
						<button type="button" class="btn btn-danger desbloquear"
						data-id='${indice[i].id_acesso}'><i class="fa fa-ban" aria-hidden="true"></i></button>

						`

					}

					corpo+=`
					<tr>
					<td>
					${'#'+indice[i].id_acesso}
					<p style='display: none'>${indice[i].nome_acesso}</p>
					<p style='display: none'>${indice[i].login_acesso}</p>

					</td>
					<td>${indice[i].nome_acesso}</td>
					<td>${indice[i].login_acesso}</td>

					<td>
					<div class="btn-group" role="group" aria-label="Basic example">
					<button class='btn btn-warning  editar' 
					data-id='${indice[i].id_acesso}'
					data-nome='${indice[i].nome_acesso}'
					data-login='${indice[i].login_acesso}'>
					<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
					${comandos}			
					<button type="button" class="btn btn-info novasenha" data-id='${indice[i].id_acesso}'>
					<i class="fa fa-key" aria-hidden="true"></i></button>
					</div>
					</td>
					</tr>

					`	
				}
			}else{
				corpo='';
			}

			$("#corpo_atendentes").html(corpo);
			$(".editar").on('click',function(e){
				let id=$(this).data('id');
				$("#input_id_atendente").val(id);
				let nome=$(this).data('nome');
				$("#input_nome_atendente").val(nome);
				let login=$(this).data('login');
				$("#input_login_atendente").val(login);
				$("#modal_editar_atendente").modal('show')
			})
			$(".bloquear").on('click',function(){
				let id=$(this).data('id');
				let ok=confirm('ATENDENTE DESBLOQUEADO!\nDESEJA BLOQUEA-LO??');
				if(ok){
					UPDATE.atendente(id,'3');	
				}
			})

			$(".desbloquear").on('click',function(){
				let id=$(this).data('id');
				let ok=confirm('ATENDENTE BLOQUEADO!\nDESEJA DESBLOQUEA-LO??');
				if(ok){
					UPDATE.atendente(id,'2');	
				}

			})

			$(".novasenha").on('click',function(){
				let id=$(this).data('id');
				let ok=confirm('Deseja alterar a senha do atendente?');
				if(ok){
					UPDATE.atendente(id,'4');	
				}

			})

		}
		$("#form_editar_atendente").submit(function(e){
			e.preventDefault();
			let nome=$('#input_nome_atendente').val();
			let email=$('#input_login_atendente').val();
			let id=$('#input_id_atendente').val();
			UPDATE.atendente(id,'1',nome,email);	

		})
		function retedicaoatendentes(response){
			let indice=response.indice;
			switch (indice) {
				case 1:

				if(response.st==1){
					alert('SUCESSO!')
					$("#modal_editar_atendente").modal('hide')

					READ.atendentes();

				}

				if(response.st==2){
					alert('EMAIL JÁ EXISTE')
					$('#input_login_atendente').focus()

				}
				break;
				case 2:

				if(response.st==1){
					alert('DESBLOQUEADO COM SUCESSO!')
					READ.atendentes();


				}else{
					alert('Ops! Tente novamente mais tarde...')

				}
				break;
				case 3:

				if(response.st==1){
					alert('BLOQUEADO COM SUCESSO!')
					READ.atendentes();


				}else{
					alert('Ops! Tente novamente mais tarde...')

				}
				break;
				case 4:
				if(response.st==1){
					alert('SENHA NOVA DO PRIMEIRO ACESSO:\n'+response.senha)

				}else{
					alert('Ops! Tente novamente mais tarde...')

				}
				break;
			}
		}


		$(function(){
			$("#filtro").keyup(function(){ 

				var index = $("#filtro").parent().index();
				var nth = "#tabela_meus_atendentes td:nth-child("+(index+1).toString()+")";
				var valor = $(this).val().toUpperCase();
				$("#tabela_meus_atendentes tbody tr").show();
				$(nth).each(function(){
					if($(this).text().toUpperCase().indexOf(valor) < 0){
						$(this).parent().hide();
					}
				});

			});

			$("#tabela_meus_atendentes input").blur(function(){
				$(this).val("");
			}); 
		});
	</script>