<?php 
//GERENCIA
$validador_usuario=$_SESSION['token']; //INSERIR O NOME DA SESSAO DO LOGADO


?>	




<script>
	const READ = {
		select_arquivos: function(midia=0){ 
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'JSON',
				data: DADOS.PARS('20'),
			})
			.done(function(response) {
				
				list_arquivos(response,midia)

			})
		},
		todos_arquivos: function(){ 
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'JSON',
				data: DADOS.PARS('20'),
			})
			.done(function(response) {
				rettodos_arquivos(response)

			})
		},
		list_campanha:function(){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('18'),
			})
			.done(function(response) {
				
				retlist_campanha(response);

			})	
		},
		perfil_cliente_campanha:function(){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.CLASSE_CHECK('17','tagescolha'),
			})
			.done(function(response) {
				encaminhar_campanha(response)


			})	
		},
		perfil_cliente_campanha2:function(){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.CLASSE_CHECK('24','tagescolha'),
			})
			.done(function(response) {
				nova_camapanha(response)

			})	
		},
		whats_campanha:function(){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('16'),
			})
			.done(function(response) {
				readwhats_campanha(response)

			})	
		},
		hast_cliente:function(id){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('13',id),
			})
			.done(function(response) {
				readhast_cliente(response)

			})	
		},
		contatos:function(pagina=100,pesquisa=0){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('15',pagina,pesquisa),
			})
			.done(function(response) {
				readcontatos(response)
				
			})	
		},
		atendentes:function(){
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('2'),
			})
			.done(function(response) {
				atendentes(response)
			})
			
		},
		hastags:function(){
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('5'),
			})
			.done(function(response) {
				retmontarhastags(response)
			})
			
		},
		hastagsenvio:function(){
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('5'),
			})
			.done(function(response) {
				retmontarhastagsescolha(response)
			})
			
		}

		
	}
	const CREATE = {
		novoatendente:function(form){
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.FORM('4',form),
			})
			.done(function(response) {
				retnovoatendente(response)
			})
			
		},
		hastags:function(id=0,acao=0,nome='0'){
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('6',id,acao,nome),
			})
			.done(function(response) {
				retacaohastags(response)
			})
			
		}
	}
	const UPDATE = {
		msg_campanha: function(form){ 
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'JSON',
				data: DADOS.FORM('23',form),
			})
			.done(function(response) {
				retgravadomsg(response)
			})
		},
		bloquearrquivo: function(id){ 
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'JSON',
				data: DADOS.PARS('21',id),
			})
			.done(function(response) {
				READ.todos_arquivos()//atualiza a pagina de arquivos
			})
		},
		desbloqueiaarrquivo: function(id){ 
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'JSON',
				data: DADOS.PARS('22',id),
			})
			.done(function(response) {
				READ.todos_arquivos()//atualiza a pagina de arquivos
			})
		},
		nomearquivo: function(form){ 
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'JSON',
				data: DADOS.FORM('19',form),
			})
			.done(function(response) {
				retnomearquivo(response)
			})
		},
		atualiza_hatgs:function(acao,idgroup,iduser){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('14',acao,idgroup,iduser),
			})
			.done(function(response) {
				
				READ.hast_cliente(response.id)     
				
			})	
		},
		atendente:function(id,acao,nome=0,email=0){
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('3',id,acao,nome,email),
			})
			.done(function(response) {
				retedicaoatendentes(response)
			})
			
		},
		cadastramento:function(form){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.FORM('11',form),
			})
			.done(function(response) {
				updatecadastramento(response)
				
			})	
		}


	}
	const DELETE = {}

	
	const DADOS={
		PARS:function(auth,p1=0,p2=0,p3=0,p4=0,p5=0){
			let obj={
				auth:auth,
				TOKEN_USER:"<?=$validador_usuario?>",
				p1:p1,
				p2:p2,
				p3:p3,
				p4:p4,
				p5:p5
			}
			return obj;
		},
		OBJ:function(auth,obj){
			obj['TOKEN_USER']="<?=$validador_usuario?>";
			obj['auth']=auth;

			
			return obj;
		},
		CLASSE_CHECK:function(auth,cl,p1=0){
			let classe=document.getElementsByClassName(cl);
			let json={};
			let obj=[];
			for(let i=0;i<classe.length;i++){
				if(classe[i].checked){
					obj.push(classe[i].value);
				}
			}
			json['TOKEN_USER']="<?=$validador_usuario?>";
			json['JSON']=obj;
			json['auth']=auth;
			json['p1']=p1;
			
			return json;
		},
		CLASSE:function(auth,cl){
			let classe=document.getElementsByClassName(cl);
			let json={};
			for(let i=0;i<classe.length;i++){
				json[classe[i].getAttribute("name")]=classe[i].value;
			}
			json['TOKEN_USER']="<?=$validador_usuario?>";
			json['auth']=auth;
			
			return json;
		},
		CLASSE_JSON:function(auth,cl,p1=0,p2=0){
			let classe=document.getElementsByClassName(cl);
			let json={};
			let obj=[];
			for(let i=0;i<classe.length;i++){
				obj.push(classe[i].value);
			}
			json['TOKEN_USER']="<?=$validador_usuario?>";
			json['auth']=auth;
			json['JSON']=obj;
			json['p1']=p1;
			json['p2']=p2;


			
			return json;
		},
		FORM:function(auth,formulario,p1=0){
			let int=$("#"+formulario).serialize();
			let usuario="<?=$validador_usuario?>";
			int+="&auth="+auth+"&TOKEN_USER="+usuario+"&p1="+p1;
			return int
		},
		FORM_ARRAY:function(auth,formulario,cl){
			let form=$("#"+formulario).serializeArray();
			let json={};
			let array=[];
			for(let i=0;i<form.length;i++){
				json[form[i].name]=form[i].value

			}
			//POVOA O ARRAY MEDIANTE A CLASSE
			let classe=document.getElementsByClassName(cl);
			for(let i=0;i<classe.length;i++){
				array.push(classe[i].value);
			}
			
			json['auth']=auth;
			json['TOKEN_USER']="<?=$validador_usuario?>";
			json['ARRAY']=array;


			

			return json;

		}

	}
	jQuery(document).ready(function($) {
		initializeMasks();
		
	});

	function initializeMasks() {
		$(".mask-credit-card").mask("9999 9999 9999 99999");
		$(".mask-month-year").mask("99/9999");
		$(".mask-date").mask("99/99/9999");
		$(".mask-cep").mask("99999-999");
		$(".mask-cpf").mask("999.999.999-99");
		$(".mask-cnpj").mask("99.999.999/9999-99");
		$(".mask-cellphone").mask("99999-9999");
		$(".mask-onlyphone").mask("99999-9999");
		$(".mask-phone").mask("(99) 99999-9999");
		$(".mask-numhab").mask("99999999999");
		$(".mask-placa").mask("999-999");
		$(".mask-dinheiro")
		.mask("######.##",{reverse: true})
		.attr('maxlength','9');




	}


	function limparFormulario(form){
		$('#'+form).each (function(){
			this.reset();
		});
	}
	

//	console.log(CPF.generate())

function CallDocRun(){
	firebase.database().ref("DOCUMENTOS").child('ATUAL').set({time:time()});

}
function relogio(){
	var tempo=new Date();
	var hora=tempo.getHours();
	var min=tempo.getMinutes();
	var seg=tempo.getSeconds();
	if(min<10){

		var min="0"+min;
	}
	if(seg<10){

		var seg="0"+seg;
	}

	let horario=hora+":"+min+":"+seg;

	setTimeout("relogio()","1000");
	return horario; 
}


</script>