function buscarAnuncio() {
    $(document).ready(function() {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $('.ui.checkbox')
                .checkbox()
                ;
        $("#btnBuscarAnuncio").click(function () {
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
                        garagem: $('#checkgaragem').parent().checkbox('is checked'),
                        hdnEntidade: "Anuncio",
                        hdnAcao: "buscarAnuncio"
                    },
                    beforeSend: function () {
                        
                    },
                    success: function (resposta) {
                        
                    }
                })
        });
    });
}



