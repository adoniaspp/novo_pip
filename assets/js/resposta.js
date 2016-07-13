function esconderResposta(){
    
    $(document).ready(function () {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $("div[id^='divResposta']").hide();
        
    })
    
}

function ordemInicio() {

    $(document).ready(function () {
        $("#sltOrdenacao").change(function () { sdasdsad

            $('#divMensagemMaior').load("UsuarioVisaoMinhasMensagens.php", {hdnEntidade: 'Mensagem', hdnAcao: 'buscarAnuncio',

                ordem: $(this).val()}, function () {
                
            });
            setTimeout(function () {
                $('#load').removeClass("ui active inverted dimmer");
            }, 1000);
        })
    });
}

function exibirDivResposta(divResposta){
    
    $(document).ready(function () {
        
        $("#responder"+divResposta).click(function () {
        
        $("#divResposta"+divResposta).show();
    
      })
    
    })
}

function ocultarResposta(divResposta){
    
    $(document).ready(function () {
        
        $("#btnCancelarMensagem"+divResposta).click(function () {
        
        $("#divResposta"+divResposta).hide();
    
      })
    
    })
}

function responderMensagem(botaoResponder){
    
    $(document).ready(function () {
        $("#txtResposta"+botaoResponder).maxlength({
            alwaysShow: true,
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
    })
}

function formatarValorProposta(valor){
    $(document).ready(function () {
        $("#txtProposta"+valor).priceFormat({
                prefix: 'R$ ',
                centsSeparator: ',',
                centsLimit: 0,
                limit: 12,
                thousandsSeparator: '.'
        })
    })
}
