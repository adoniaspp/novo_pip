function visualizarRespostaChamado(valor) {
     
    $(document).ready(function () {   
        
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

        $('#btnDetalhesChamado' + valor).click(function () {

        $("#divModalMenorCancelar" + valor).hide();
        
        $("#divModalVisualizar" + valor).show();

            $('#modalChamado' + valor).modal({
                transition: "fade up",
                observeChanges: true,
                onSubmit: function () {
                return false; //deixar o modal fixo
            },
            }).modal('show');

        }) 
        
        $('#btnCancelarChamado' + valor).click(function () {

        $("#divModalVisualizar" + valor).hide();
        
        $("#divModalMenorCancelar" + valor).show();

            $('#modalChamado' + valor).modal({
                transition: "fade up",
                observeChanges: true,
                onSubmit: function () {
                return false; //deixar o modal fixo
            },
            }).modal('show');

        })

        $('#botaoResponderChamado' + valor).click(function () {

            $.ajax({
                url: "index.php",
                dataType: "json",
                type: "POST",
                data: $('#formChamado'+valor).serialize(),
                beforeSend: function () {
                    $("#divRetornoResposta"+valor).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                },
                success: function (resposta) {
                    if (resposta.resultado == 1) {
                        $("#divRetornoResposta" + valor).html("<div class='ui positive message'>\n\
                        <i class='big green check circle outline icon'></i>Chamado respondido com sucesso</div>");
                        $("#divAtencaoCancela" + valor).hide();

                        $("#botaoFecharChamado" + valor).click(function () {
                            window.location = "index.php?entidade=Chamado&acao=listarChamados";
                        });

                        } else {
                        $("#divRetornoResposta" + valor).html("<div class='ui negative message'>\n\
                        <i class='big red remove circle outline icon'></i>Erro. Tente novamente em alguns minutos</div>");
                        $("#botaoFecharChamado" + valor).click(function () {
                            window.location = "index.php?entidade=Chamado&acao=listarChamados";
                        });
                        }
                }
            })

        })

    })     

}



