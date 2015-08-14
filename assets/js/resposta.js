function esconderResposta(){
    
    $(document).ready(function () {
     
        $("div[id^='divResposta']").hide();
        
    })
    
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
            $("#btnResponderMensagem"+botaoResponder).click(function() {
            
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form'+botaoResponder).serialize(),
                    beforeSend: function () {                     
                        $("#divRetorno"+botaoResponder).html("<div><div class='ui active inverted dimmer'>\n\
                    <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                        
                        $("#divCamposResposta"+botaoResponder).hide();
                        
                    },
                    success: function (resposta) {
                        
                        $("#divRetorno"+botaoResponder).empty();
                        
                        if (resposta.resultado == 0) {
                            $("#divRetorno"+botaoResponder).html('<div class="ui inverted red center aligned segment">\n\
                            <p>Erro ao responder. Tente novamente em alguns minutos - 000</p>');
                        } else if (resposta.resultado == 1) {
                            $("#btnResponderMensagem"+botaoResponder).hide();
                            $("#divRetorno"+botaoResponder).html('<div class="ui inverted green center aligned segment">\n\
    <p>Resposta enviada</p>');
                        } 
                    }
                })
                return false;
            
         })
    })
}