function buscarAnuncio() {
    $(document).ready(function() {

        $("#divCaracteristicas").hide();
        $("#divValor").hide();

        $("#sltTipoImovel").change(function() {
            if ($(this).val() == "casa") {
                $("#divCaracteristicas").show();
                $("#condicao").show();
            }
            if ($(this).val() == "apnovo") {
                $("#divCaracteristicas").show();
                $("#condicao").hide();
                //$("#divCaracteristicas").hide();
            }
            if ($(this).val() == "apusado") {
                $("#divCaracteristicas").hide();
                $("#condicao").show();
            }
            if ($(this).val() == "slcomercial") {
                $("#divCaracteristicas").hide();
                $("#condicao").show();
            }
            if ($(this).val() == "terreno") {
                $("#divCaracteristicas").hide();
                $("#condicao").show();
            }
        })

        $("#sltFinalidade").change(function() {
            if ($(this).val() == "venda") {
                $("#divValorAluguel").hide();
                $("#divPreenchimento2").hide();
                $("#divValor").show();
            }
            if ($(this).val() == "aluguel") {
                $("#divValorVenda").hide();
                $("#divPreenchimento2").hide();
                $("#divValor").show();
            }
        })

        $("input[name=sltCidade]").change(function() {
            $("#menuBairro").html("<div class='item'>Procurando...</div>");
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidade').val(),
                    function(resposta) {
                        $("#menuBairro").html(resposta);
                    }
            );
        });
        
        $("#spanValor").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $('.ui.checkbox')
                .checkbox();

        $('.special.cards .image').dimmer({
            on: 'hover'
        });

        /*Criar uma view especifica para tela inicial*/
        $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
            tipoImovel: 'todos',
            valor: '',
            finalidade: '',
            cidade: '',
            bairro: '',
            quarto: '',
            condicao: '',
            garagem: 'false'});


        $("#btnBuscarAnuncio").on('click', function() {
            $("#load").addClass('ui active inverted dimmer');
            if($('#sltTipoImovel').val() == "") {tipoimovel = "todos"} else {tipoimovel = $('#sltTipoImovel').val()};
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: tipoimovel,
                valor: $('#sltValor').val(),
                finalidade: $('#sltFinalidade').val(),
                idcidade: $('#sltCidade').val(),
                idbairro: $('#sltBairro').val(),
                quarto: $('#sltQuartos').val(),
                condicao: $('#sltCondicao').val(),
                garagem: $('#checkgaragem').parent().checkbox('is checked')}, function() {
                $("#load").addClass('ui active inverted dimmer');
            });
            setTimeout(function() {
                $('#load').removeClass("ui active inverted dimmer");
            }, 1000);
        });
    });
}

function carregarAnuncio() {
    
    $('.special.cards .image').dimmer({
            on: 'hover'
        });
        
    $("#spanValor").priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    })
    
    $('.special.cards .image .button').on('click', function(){
         $("#hdnCodAnuncio").val($(this).siblings().val());
         $("#hdnTipoImovel").val($(this).siblings().next().val());
        $('#form').submit();
    })
}

