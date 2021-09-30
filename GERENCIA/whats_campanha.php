<h1 class="text-center">CAMPANHA # WHATSAPP</h1>
<p class="text-center text-danger noprint">Palavra captada após #</p>
<div class="templatemo-flex-row my-5">
	<div class="templatemo-content col-md-12 light-gray-bg">
		<div class="pull-right row">
			<button class="btn btn-danger  noprint" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i></button>
			<button class="btn btn-info noprint" id="atualiza_cam_whats"><i class="fa fa-refresh" aria-hidden="true"></i></button>
			<span id="td_whats_camp_tualizado"></span>
		</div>
		<table class="table table-bordered table-responsive-sm table-striped" id='tabela_whats_campanha'>
			<thead>
				<tr>
					<th scope="col">COLOCAÇÃO</th>
					<th scope="col">QUANTIDADE</th>
					<th scope="col">#CAMPANHA</th>
					<th scope="col">NÚMEROS</th>
				</tr>
				<tr class="noprint">
					<th colspan='4'>
						<label for="">Pesquise</label>
						<input type="text" class='form-control' pleaceholder='Pesquise' id='filtro_whats_camp'>
					</th>
				</tr>
			</thead>
			<tbody id="lista_camp_whats">
			</tbody>			
		</table>
		
	</div>
</div>


<script>
	
	READ.whats_campanha();
	$("#atualiza_cam_whats").on('click',function(e){
		READ.whats_campanha();
		$("#td_whats_camp_tualizado").css('color','red');

	})


	function readwhats_campanha(response){
		let indice=response.ret
		let corpo="";
		if (indice!==null) {
			for(let i=0;i<indice.length;i++){
				corpo+=` 
				<tr>
				<td>
				${[i+1]+'° Lugar'}
				<p style='display:none'>${indice[i].tag_campanha}</p>
				</td>
				<td>${indice[i].QTDE}</td>
				<td>${indice[i].tag_campanha}</td>
				<td>${indice[i].NUMER}</td>

				</tr>

				`
			}
		}else{
			corpo+=` 
			<tr colspan='4'>
			<h1>NÃO HÁ CAMPANHA# ATIVA</h1>
			</tr>

			`
			
		}
		$("#lista_camp_whats").html(corpo)
		$("#td_whats_camp_tualizado").html(response.atualizado)

		
	}

	$(function(){
		$("#filtro_whats_camp").keyup(function(){ 

			var index = $("#filtro_whats_camp").parent().index();
			var nth = "#tabela_whats_campanha td:nth-child("+(index+1).toString()+")";
			var valor = $(this).val().toUpperCase();
			$("#tabela_whats_campanha tbody tr").show();
			$(nth).each(function(){
				if($(this).text().toUpperCase().indexOf(valor) < 0){
					$(this).parent().hide();
				}
			});

		});

		$("#tabela_whats_campanha input").blur(function(){
			$(this).val("");
		}); 
	});
</script>