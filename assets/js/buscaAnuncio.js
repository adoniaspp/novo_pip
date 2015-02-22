function buscarAnuncio() {
    $(document).ready(function() {

        $("#divCaracteristicas").hide();
        $("#divValor").hide();

        $("#sltTipoImovel").change(function() {
            if ($(this).val() == "casa") {
                $("#divCaracteristicas").show();
            }
            if ($(this).val() == "apnovo") {
                $("#divCaracteristicas").hide();
            }
            if ($(this).val() == "apusado") {
                $("#divCaracteristicas").hide();
            }
            if ($(this).val() == "slcomercial") {
                $("#divCaracteristicas").hide();
            }
            if ($(this).val() == "terreno") {
                $("#divCaracteristicas").hide();
            }
        })

        $("#sltFinalidade").change(function() {
            if ($(this).val() == "venda") {
                $("#divPreenchimento2").hide();
                $("#divValor").show();
            }
            if ($(this).val() == "aluguel") {
                $("#divPreenchimento2").hide();
                $("#divValor").show();
            }
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

//        $("#spanValor").priceFormat({
//                prefix: 'R$ ',
//                centsSeparator: ',',
//                centsLimit: 0,
//                limit: 8,
//                thousandsSeparator: '.'
//            })

        $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
            tipoImovel: 'casa',
            valor: '',
            finalidade: '',
            cidade: '',
            bairro: '',
            quarto: '',
            condicao: '',
            garagem: 'false'});


        $("#btnBuscarAnuncio").on('click', function() {
            $("#load").addClass('ui active inverted dimmer');
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: $('#sltTipoImovel').val(),
                valor: $('#sltValor').val(),
                finalidade: $('#sltFinalidade').val(),
                cidade: $('#sltCidade').val(),
                bairro: $('#sltBairro').val(),
                quarto: $('#sltQuartos').val(),
                condicao: $('#sltCondicao').val(),
                garagem: $('#checkgaragem').parent().checkbox('is checked')}, function() {
   $("#load").addClass('ui active inverted dimmer');
});
                setTimeout(function() {
                    $('#load').removeClass("ui active inverted dimmer");
            }, 10000);
        });
    });
}



