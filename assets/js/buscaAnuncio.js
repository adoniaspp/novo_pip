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

        $("#btnBuscarAnuncio").click(function() {
            $.ajax({
                url: "index.php",
                dataType: "json",
                type: "POST",
                data: {
                    tipoImovel: $('#sltTipoImovel').val(),
                    valor: $('#sltValor').val(),
                    finalidade: $('#sltFinalidade').val(),
                    cidade: $('#sltCidade').val(),
                    bairro: $('#sltBairro').val(),
                    quarto: $('#sltQuartos').val(),
                    condicao: $('#sltCondicao').val(),
                    garagem: $('#checkgaragem').parent().checkbox('is checked'),
                    hdnEntidade: "Anuncio",
                    hdnAcao: "buscarAnuncio"
                },
                beforeSend: function() {

                },
                success: function(resposta) {
                    
                    document.write(resposta.anuncio);
//                    for (var valor = 1 ; valor <=valores ; valor++){
//                        
//                    }
                }
            })
        });
    });
}



