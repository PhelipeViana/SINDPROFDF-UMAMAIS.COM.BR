	<div class="jumbotron">
		<h1 class="text-center">CAMPANHAS DE ENVIO</h1>
	</div>
	<button class="btn btn-danger btn-block" id="btn_prepara_envio">
		CRIAR CAMPANHA <i class="fa fa-paper-plane" aria-hidden="true"></i>
	</button>
	<hr>
	<a href="BASEFRIA.php" target="_blank" class="btn btn-info btn-block">ENVIAR BASE FRIA</a>

	<hr>
	<table class="table">
		<thead>
			<tr class="text-center">
				<th scope="col">Campanha</th>
				<th scope="col">Detalhe</th>
				<th scope="col">Quantidade</th>
				<th scope="col">Enviar</th>
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
					<form id='form_mensagem'>
						<input type="hidden" name="id" id="input_id_campanha">
						<label for="">Detalhe da campanha</label>
						<input type="text" id="text_msg_campa" class="form-control text-justify" name="msg">
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

		
		
		function retlist_campanha(response){
			let corpo="";

			if(response!==null){
				for(let i=0;i<response.length;i++){
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
					<td scope="row">${response[i].num_envio}</td>
					
					<td>
					<a class='btn btn-danger' href="CAMPANHA_ENVIO.php?id=${response[i].id_cam_envio}&limit=100"
					target='_blank'>
					INICIAR <i class="fa fa-arrow-right" aria-hidden="true"></i>
					</a>

					</td>

					<td>					
					<a class='btn btn-link' href="relatorio.php?id=${response[i].id_cam_envio}"
					target='_blank'>
					RELATÓRIO <i class="fa fa-arrow-right" aria-hidden="true"></i>
					</a>
					</td>					
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
				$("#text_msg_campa").val(msg)
				$("#input_id_campanha").val(id);
				
				
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
			<button type="submit" class="btn btn-danger btn-block" id='btn_criar_campa'>CRIAR CAMPANHA</button>
			</div>
			`

			$("#form_envio_massa").html(corpo)
			$("#modal_perfil_envio").modal('show')
			$(".mouse_chose").css('cursor','pointer')

		}

		$("#form_envio_massa").submit(function(event) {
			event.preventDefault();
			$("#btn_criar_campa").attr('disabled',true)

			READ.perfil_cliente_campanha2();
		});

		function nova_camapanha(response){
			
			$("#modal_perfil_envio").modal('hide')
			$("#btn_criar_campa").attr('disabled',false)
			
			READ.list_campanha();
		}

	</script>