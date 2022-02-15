<h1 class="jumbotron text-center">Dados do Tageamento</h1>
<div class="pull-right noprint">
    <button class="btn btn-primary" id="btn_atualizar">
        <i class="fa fa-refresh" aria-hidden="true"></i>
    </button>
    <!-- <button class="btn btn-danger" onclick="window.print()">
    <i class="fa fa-print" aria-hidden="true"></i>
    </button> -->
</div>
<table class="table table-striped table-responsive-sm table-bordered">
    <thead class="text-center">
        <tr id="corpo_header"></tr>



    </thead>
    <tbody id="corpo_body"></tbody>

</table>

<script>
    READ.dadosTageamento();
    $("#btn_atualizar").click(function(e) {
        alert('Atualizado com sucesso!')
        READ.dadosTageamento();

    })

    function montarDadosTag(response) {
        let chaves = Object.keys(response.ret);
        let indice = response.ret;
        let locais = response.COLUNAS;
        let corpo_cabecario = ` 
        <th>LOCAL</th>        
        `;
        let corpo = "";

        for (let i = 0; i < chaves.length; i++) {
            corpo_cabecario += ` 
            <th>
            ${chaves[i]}
            <p class='rel1 btn btn-link'
            data-total='${indice[chaves[i]].total}'
            data-id='${indice[chaves[i]].id_tag}'
           
            >${indice[chaves[i]].total}</p>
            </th>         
            `
        }

        let total = 0;
        for (let k = 0; k < locais.length; k++) {
            corpo += ` 
            <tr class='text-center'>                
            <td>
            ${locais[k]['nomehastag']}
            <button class='btn btn-link rel1'
            data-id='${locais[k]['idhastag']}'
            data-total='${locais[k]['total']}'>
           
            ${locais[k]['total']}
            </button>
           
            </td>                 
            `
            for (let i = 0; i < chaves.length; i++) {
                let numeros = indice[chaves[i]][locais[k]['nomehastag']].PARCIAL;
                let corpo_numeros = "";
                total += parseInt(numeros);

                if (numeros > 0) {
                    corpo_numeros = ` 
                    <button class='btn btn-link rel2'
                    data-total='${numeros}'
                    data-id='${indice[chaves[i]][locais[k]['nomehastag']].LINHA}'
                    data-id2='${indice[chaves[i]][locais[k]['nomehastag']].COLUNA}'
                   >${numeros}
                    </button>
                    `
                } else {
                    corpo_numeros = ` 
                    ${numeros}
                    
                    `

                }
                corpo += ` 
                <td>${corpo_numeros}</td>
                                 
                `
            }

            corpo += ` 
        </tr> 
        `
        }



        $("#corpo_header").html(corpo_cabecario);
        $("#corpo_body").html(corpo);

        $(".rel1").on('click', function(e) {
            let tipo = 1;
            let total = $(this).data('total');
            let id = $(this).data('id');
            let ok = confirm('Deseja Criar uma campanha para ' + total);
            if (ok) {
                CREATE.campanha_por_tag(tipo, id)

            }

        })
        $(".rel2").on('click', function(e) {
            let tipo = 2;
            let total = $(this).data('total');
            let id = $(this).data('id');
            let id2 = $(this).data('id2');

            let ok = confirm('Deseja Criar uma campanha para ' + total);
            if (ok) {
                CREATE.campanha_por_tag(tipo, id, id2);

            }
        })
    }
</script>