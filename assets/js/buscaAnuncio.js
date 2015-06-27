function buscarAnuncio() {
    $(document).ready(function() {

        $("#divCaracteristicas").hide();
        $("#divValor").hide();
        

        $("#sltTipoImovel").change(function() {
            if ($(this).val() == "casa") {
                $("#divCaracteristicas").show();
                $("#condicao").show();
            }
            if ($(this).val() == "apartamentoplanta") {
                $("#divCaracteristicas").show();
                $("#condicao").hide();
                //$("#divCaracteristicas").hide();
            }
            if ($(this).val() == "apartamento") {
                $("#divCaracteristicas").show();
                $("#condicao").hide();
            }
            if ($(this).val() == "salacomercial") {
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

function buscarAnuncioUsuario() {
    $(document).ready(function() {

        $("#divCaracteristicas").hide();
        $("#divValorVenda").hide(); //oculta a div dos valores de venda 
        $("#divValorAluguel").hide(); //oculta a div dos valores de aluguel

        $("#sltTipoImovel").change(function() {
            if ($(this).val() == "casa") {
                $("#divCaracteristicas").show();
                $("#condicao").show();
            }
            if ($(this).val() == "apartamentoplanta") {
                $("#divCaracteristicas").show();
                $("#condicao").hide();
                //$("#divCaracteristicas").hide();
            }
            if ($(this).val() == "apartamento") {
                $("#divCaracteristicas").show();
                $("#condicao").hide();
            }
            if ($(this).val() == "salacomercial") {
                $("#divCaracteristicas").hide();
                $("#condicao").show();
            }
            if ($(this).val() == "terreno") {
                $("#divCaracteristicas").hide();
                $("#condicao").show();
            }
            if ($(this).val() == "") {
                $("#divCaracteristicas").hide();
                $("#condicao").hide();
            }
        })

        $("#sltFinalidade").change(function() {

            if ($(this).val() == "venda") {
                $("#divValorAluguel").hide();
                $("#divValorVenda").show();
                
            }
            if ($(this).val() == "aluguel") {
                $("#divValorVenda").hide();
                $("#divValorAluguel").show();
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
            id: $('#txtUsuario').val(),
            garagem: 'false'});


        $("#btnBuscarAnuncioUsuario").on('click', function() {
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
                id: $('#hdUsuario').val(),
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

