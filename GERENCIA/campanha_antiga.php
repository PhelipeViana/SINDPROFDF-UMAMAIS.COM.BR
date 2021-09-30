	<div class="jumbotron">
		<h1 class="text-center">CAMPANHAS DE ENVIO</h1>
	</div>
	<button class="btn btn-danger btn-block" id="btn_prepara_envio">
		CRIAR CAMPANHA <i class="fa fa-paper-plane" aria-hidden="true"></i>
	</button>
	<hr>
	<table class="table">
		<thead>
			<tr class="text-center">
				<th scope="col">Campanha</th>
				<th scope="col">Mensagem</th>
				<th scope="col">Quantidade</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody id="listagem_campanhas">

		</tbody>
	</table>

	<div class="modal fade" id="modal_perfil_envio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center">PERFIL DE ENVIO</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="form_envio_massa">

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_msg_envio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center">MENSAGEM DE ENVIO</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-4">
							<button class="btn-link" id='ncompleto'>NOME COMPLETO <i class="fa fa-hand-o-down" aria-hidden="true"></i></button>
						</div>
						<div class="col-sm-4"></div>
						<div class="col-sm-4">
							<button class="btn-link" id='pnome'>PRIMEIRO NOME<i class="fa fa-hand-o-down" aria-hidden="true"></i></button>
							
						</div>
					</div>
					<hr>
					<form id='form_mensagem'>
						<select name="midia" id="opcoes_mensagem" class="form-control"></select>
						<div id="link_da_midia"></div>
						<br>
						<input type="hidden" name="id" id="input_id_campanha">
						<textarea class="form-control text-justify" name="msg" id="text_msg_campa" cols="30" rows="10" required minlength="2"></textarea>

						<br>
						<button class="btn btn-danger btn-block" type="submit">SALVAR</button>
					</form>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		READ.list_campanha()
		$("#form_mensagem").submit(function(event) {
			event.preventDefault();
			UPDATE.msg_campanha("form_mensagem")
		});
		
		$("#pnome").on('click',function(e){
			let input=$("#text_msg_campa")
			let valor=input.val();
			input
			.val(valor+' '+' <pnome> ')
			.focus()
		})


		$("#ncompleto").on('click',function(e){
			let input=$("#text_msg_campa")
			let valor=input.val();
			input
			.val(valor+' '+' <nome> ')
			.focus()
		})
		
		function retlist_campanha(response){
			let corpo="";

			if(response!==null){
				for(let i=0;i<response.length;i++){
					let comando_campanha="";

					if(response[i].status_campanha==0){
						comando_campanha=` 
						<button class='btn btn-primary btn-block iniciar_campanha' data-id='${response[i].id_cam_envio}' 
						id='btn_iniciar_${response[i].id_cam_envio}'>
						INICIAR						
						</button>
						`
					}

					if(response[i].status_campanha==1){
						comando_campanha=` 
						<p>ENVIANDO...</p>					
						`

					}


					if(response[i].status_campanha==2){
						comando_campanha=` 
						<a class='btn btn-link' href="relatorio.php?id=${response[i].id_cam_envio}"
						target='_blank'
						>RELATÓRIO <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
						`

					}
					corpo+=` 
					<tr>
					<th scope="row">${response[i].id_cam_envio}</th>
					<td class='text-justify'>

					<button class='btn-link alter_msg' 
					data-msg='${response[i].msg}'
					data-id='${response[i].id_cam_envio}'
					data-midia='${response[i].REF_MIDIA}'>
					<i class="fa fa-pencil" aria-hidden="true"></i>
					${response[i].msg}
					</button>
					
					</td>
					<td>${response[i].num_envio}</td>
					<td>${comando_campanha}</td>					
					</tr>

					`
				}
			}
			$("#listagem_campanhas").html(corpo)
			$(".alter_msg").on('click',function(e){
				let msg=$(this).data('msg');
				let midia=$(this).data('midia');

				
				let id=$(this).data('id');

				$("#modal_msg_envio").modal('show');	
				$("#text_msg_campa").html(msg)
				$("#input_id_campanha").val(id);
				READ.select_arquivos(midia);
				
				
			})
			
			$(".iniciar_campanha").on('click',function(e){
				let id=$(this).data('id');
				let ok=confirm('Iniciar os envios?');
				if(ok){
					$("#btn_iniciar_"+id)
					.html('iniciando...')
					.removeClass('iniciar_campanha')
					.removeClass('btn_primary')
					.addClass('btn_primary')


					iniciarCampanha(id)	
				}
			})

		}
		function list_arquivos(response,valor){
			let corpo="";
			corpo+=`<option value='0'>MENSAGEM TEXTO</option>`
			let indice=response.ret;
			if(indice!==null){
				for(let i=0;i<indice.length;i++){
					corpo+=`<option value='${indice[i].idArquivo}'>${indice[i].nomeArquivo}</option>`
				}

			}else{
				corpo=`<option value='0'>NÃO HÁ MIDIA</option>`
			}
		
			$("#opcoes_mensagem")
			.html(corpo)
			.val(valor)			
		}
		
		$("#btn_prepara_envio").on('click',function(e){
			READ.hastagsenvio()

		})
		function retgravadomsg(response){
			let status=response.st;
			if(status==1){
				alert('Sucesso!');
				$("#modal_msg_envio").modal('hide');
				READ.list_campanha();
			}else{
				alert('Erro 23');
			}
		}

		function retmontarhastagsescolha(response){

			let corpo="";
			let indice=response.ret;
			corpo+=`
			<div class='text-center text-danger'>
			*Filtrar envio por #tags não obrigatório
			<hr>
			</div>
			`
			for(let i=0; i < indice.length; i++){
				let red='';
				if(indice[i].qdecad < 1){
					red='text-danger';
				}else{
					red='';
				}
				corpo+=`
				<div>
				<input type="checkbox" id="escolha_${indice[i].idhastag}" name="escolha" value='${indice[i].idhastag}' class='tagescolha mouse_chose'>
				<label for="escolha_${indice[i].idhastag}" class='mouse_chose ${red}'>
				${indice[i].qdecad+' <i class="fa fa-users" aria-hidden="true"></i>- '+indice[i].nomehastag}</label>
				</div>
				`
			}
			corpo+=`
			<hr>
			<div class='text-center'>
			<button type="submit" class="btn btn-danger btn-block">CRIAR CAMPANHA</button>
			</div>
			`

			$("#form_envio_massa").html(corpo)
			$("#modal_perfil_envio").modal('show')
			$(".mouse_chose").css('cursor','pointer')

		}

		$("#form_envio_massa").submit(function(event) {
			event.preventDefault();
			READ.perfil_cliente_campanha();
		});

		function encaminhar_campanha(response){

			if(response.res){
				$("#modal_perfil_envio").modal('hide');
				READ.list_campanha()
			}
		}

		function iniciarCampanha(id){
			let cenviando=`
			ENVIANDO...					
			`
			$("#btn_iniciar_"+id)
			.html(cenviando)
			.removeClass('iniciar_campanha')
			.removeClass('btn_primary')
			.addClass('btn_primary')


			$.ajax({
				url: 'GERENCIA/zapio/envio_campanha.php',
				type: 'POST',
				dataType: 'json',
				data: {id: id},
			})
			.done(function(response) {
				let status=response.st;
				if(status){
					alert('Campanha enviada com sucesso!')
					READ.list_campanha();
				}else{
					alert(response.msg);
				}
				
			})
			
		}

	</script>