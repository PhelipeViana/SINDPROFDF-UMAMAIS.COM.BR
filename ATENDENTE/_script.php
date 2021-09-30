
<?php 

$validador_usuario=$_SESSION['token']; //INSERIR O NOME DA SESSAO DO LOGADO
$endpoint="API/webservice.php";


?>	




<script>

	const READ = {
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
		fila_atendimento:function(){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('7'),
			})
			.done(function(response) {
				
				readfila_atendimento(response);
				
			})	
		},
		meus_atendimentos:function(){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('9'),
			})
			.done(function(response) {
				readmeus_atendimentos(response);
			})	
		},
		conversas:function(ref,io=0){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('10',ref),
			})
			.done(function(response) {
				readconversas(response,io)
			})	
		}
		
		

	}
	const CREATE = {}
	const UPDATE = {
		alterar_numero: function(num,canal){ 
			$.ajax({
				url: '<?=$ENDPOINT?>',
				type: 'POST',
				dataType: 'JSON',
				data: DADOS.PARS('27',num,canal),
			})
			.done(function(response) {
				ret_alterar_numero(response)
				
			})
		},
		adicionar_lista:function(id){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('26',id),
			})
			.done(function(response) {
				console.log(response)
				READ.meus_atendimentos()
			})	
		},
		retirar_lista:function(id){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('25',id),
			})
			.done(function(response) {
				console.log(response)
				READ.meus_atendimentos()
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
		pegar_atendimento:function(classe){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('8'),
			})
			.done(function(response) {
				$(classe).attr('disabled',false)
				READ.meus_atendimentos()

				FIREBASE.atualizarFila();
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
	const DELETE = {
		atendimento:function(id,num){
			$.ajax({
				url: '<?=$ENDPOINT;?>',
				type: 'POST',
				dataType: 'json',
				data: DADOS.PARS('12',id,num),
			})
			.done(function(response) {
				READ.meus_atendimentos()
			})	
		}
		
	}

	
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
			
			json['REF_CLINICA']="<?=$REF_CLINICA?>";
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
const FIREBASE={
	atualizarFila:function(){
		firebase.database().ref("<?=$FIREBASE_REFER?>").child('FILA_ATENDIMENTO').set({time:time()});


	}
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
/**/ 
function pegarInfoEndereco(endereco){
	$.ajax({
		url: "https://maps.googleapis.com/maps/api/geocode/json?address="+endereco+"&key=<?=$chave_mapa?>",
		type: 'GET',
		dataType: 'json',

	})
	.done(function(resp) {
		console.log(resp);
	})

}

function EscutarGeolocalizacao(){
	navigator.geolocation.watchPosition(function(position) {
		let  lat_now=position.coords.latitude;
		let  long_now=position.coords.longitude;
		captarDadosLatLong(lat_now,long_now);
	},function (error) { 
		if (error.code == error.PERMISSION_DENIED){
			alert('Favor permitir sua geolocalição');
		}
	});
}


function PegarGeolocalizacao(){
	navigator.geolocation.getCurrentPosition (function(position) {
		let  lat_now=position.coords.latitude;
		let  long_now=position.coords.longitude;
		captarDadosLatLong(lat_now,long_now);
	},function (error) { 
		if (error.code == error.PERMISSION_DENIED){
			alert('Favor permitir sua geolocalição');
		}
	});
}



function captarDadosLatLong(a,b){

	let obj={};
	let resultado="";
	$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?latlng='+a+','+b+'&key=<?=$chave_mapa?>', function(json, textStatus) {
		infoApiGEO(json);


	});

}

function infoApiGEO(json){
	obj={
		local:json.results[0].formatted_address,
		latitude:json.results[0].geometry.location.lat,
		longitude:json.results[0].geometry.location.lng,
		placeId:json.results[0].place_id,
		numero:json.results[0].address_components[0].long_name,
		rua:json.results[0].address_components[1].long_name,
		bairro:json.results[0].address_components[2].long_name,
		cidade:json.results[0].address_components[3].long_name,
		estado:json.results[0].address_components[4].long_name,
		pais:json.results[0].address_components[5].long_name,
		cep:json.results[0].address_components[6].long_name,
	}
	console.log(obj)
		// $(".atual_endereco_val").val(obj.endereco);
    	// $(".atual_latitude_val").val(obj.latitude);
    	// $(".atual_longitude_val").val(obj.longitude);
    	// $(".atual_bairro_val").val(obj.bairro);
    	// $(".atual_cidade_val").val(obj.cidade);
    	// $(".atual_estado_val").val(obj.estado);
    	// $(".atual_pais_val").val(obj.pais);



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
    	//$(".relogio").html(horario)

    	setTimeout("relogio()","1000");

    }
    function diferencaDeHoras(tempoincial, tempofinal) {
       //moment.js
       let inicial = moment(tempoincial, 'H:m:s');
       let final = moment(tempofinal, 'H:m:s');
       let segundos = final.diff(inicial, 'second')
       let tempo = moment.utc(segundos * 1000).format('HH:mm:ss');
       return tempo;
   }
   function transfSegEmTEmpo(segundos) {
       //moment.js
       let tempo = moment.utc(segundos * 1000).format('HH:mm:ss');
       return tempo;
   }

   function retSegundos(tempoincial, tempofinal) {
        //moment.js
        let inicial = moment(tempoincial, 'H:m:s');
        let final = moment(tempofinal, 'H:m:s');
        let segundos = final.diff(inicial, 'second')
        if (Number.isNaN(segundos)) {
        	segundos = 0;
        }
        return segundos;
    }

    function time(){
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


    function pegarPeloEndereco(end){


    	$.ajax({
    		url: "https://maps.googleapis.com/maps/api/geocode/json?address="+end+"&key=<?=$chave_mapa?>",
    		type: 'GET',
    		dataType: 'json',

    	})
    	.done(function(resp) {

    		console.log(resp)
    	})


    }
    function infoApiEND(json){
    	obj={
    		endereco:json.results[0].formatted_address,
    		latitude:json.results[0].geometry.location.lat,
    		longitude:json.results[0].geometry.location.lng,
    		bairro:json.results[0].address_components[1].long_name,
    		cidade:json.results[0].address_components[2].long_name,
    		estado:json.results[0].address_components[3].long_name,
    		pais:json.results[0].address_components[4].long_name


    	}

    	console.log(json);

// $(".atual_endereco_val").val(obj.local);
// $(".atual_bairro_val").val(obj.bairro);
// $(".atual_cidade_val").val(obj.cidade);
// $(".atual_numero_val").val(obj.numero);
// $(".atual_latitude_val").val(obj.latitude);
// $(".atual_longitude_val").val(obj.longitude);
// $(".atual_estado_val").val(obj.estado);
// $(".atual_endereco_html").html(obj.local);


}


</script>