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
    })
}