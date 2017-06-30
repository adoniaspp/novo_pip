function buscarAnuncio() {
    $(document).ready(function () {

        $("#divCaracteristicas").hide();
        $("#divValor").hide();

        $("input[name=sltCidade]").change(function () {
            $("#sltBairro").dropdown('clear');
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidade').val(),
                    function (resposta) {
                        $("#sltBairro").html(resposta);
                    }
            );
        });

        $("input[name=sltCidadeAvancado]").change(function () {
            $("#sltBairro").dropdown('clear');
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidadeAvancado').val(),
                    function (resposta) {
                        $("#sltBairroAvancado").html(resposta);
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
                    on: 'hover',
                    message: {
                        noResults: 'Nenhum resultado.'
                    }
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
            banheiro: '',
            suite: '',
            condicao: '',
            unidadesandar: '',
            area: '',
            id: $('#hdUsuario').val(),
            garagem: 'false',
            page: 'index'});


        $("#btnBuscarAnuncioBasico").on('click', function () {

            $("#divOrdenacao").show(); //mostrar a ordenação, caso esteja oculta quando a buscar não retornar nada

            $("#load").addClass('ui active inverted dimmer');
            if ($('#sltTipoImovel').val() == "") {
                tipoimovel = "todos"
            } else {
                tipoimovel = $('#sltTipoImovel').val()
            }
            ;
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: tipoimovel,
                valor: $('#sltValor').val(),
                finalidade: $('#sltFinalidade').val(),
                idcidade: $('#sltCidade').val(),
                idbairro: $('#filtroBairro').val(),
                quarto: $('#sltQuartos').val(),
                banheiro: $('#sltBanheiros').val(),
                suite: $('#sltSuites').val(),
                condicao: $('#sltCondicao').val(),
                unidadesandar: $('#sltUnidadesAndar').val(),
                areaMin: $('#sltAreaMin').val(),
                areaMax: $('#sltAreaMax').val(),
                id: $('#hdUsuario').val(),
                diferencial: $('#carregarDiferenciais').val(),
                garagem: $('#checkgaragem').parent().checkbox('is checked')}, function () {
                $("#load").addClass('ui active inverted dimmer');
            });
            setTimeout(function () {
                $('#load').removeClass("ui active inverted dimmer");
            }, 1000);
        });


        $("#btnBuscarAnuncioAvancado").on('click', function () {

            $("#load").addClass('ui active inverted dimmer');
            if ($('#sltTipoImovelAvancado').val() == "") {
                tipoimovel = "todos"
            } else {
                tipoimovel = $('#sltTipoImovelAvancado').val()
            }
            ;
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: tipoimovel,
                valor: $('#sltValor').val(),
                finalidade: $('#sltFinalidadeAvancado').val(),
                idcidade: $('#sltCidadeAvancado').val(),
                idbairro: $('#sltBairroAvancado').val(),
                quarto: $('#sltQuartos').val(),
                banheiro: $('#sltBanheiros').val(),
                suite: $('#sltSuites').val(),
                condicao: $('#sltCondicaoAvancado').val(),
                unidadesandar: $('#sltUnidadesAndar').val(),
                area: $('#sltArea').val(),
                id: $('#hdUsuario').val(),
                diferencial: $('#carregarDiferenciais').val(),
                garagem: $('#sltGaragem').val()},
                    function () {
                        $("#load").addClass('ui active inverted dimmer');
                    });
            setTimeout(function () {
                $('#load').removeClass("ui active inverted dimmer");
            }, 1000);
        });


    });
}

/*
 function buscarAnuncioUsuario() {
 $(document).ready(function () {
 
 $("#divCaracteristicas").hide();
 $("#divValorVenda").hide(); //oculta a div dos valores de venda 
 $("#divValorAluguel").hide(); //oculta a div dos valores de aluguel
 
 $("#sltTipoImovel").change(function () {
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
 
 $("#sltFinalidade").change(function () {
 
 if ($(this).val() == "venda") {
 $("#divValorAluguel").hide();
 $("#divValorVenda").show();
 
 }
 if ($(this).val() == "aluguel") {
 $("#divValorVenda").hide();
 $("#divValorAluguel").show();
 }
 
 })
 
 $("input[name=sltCidade]").change(function () {
 $("#defaultBairro").html("<option value=''>Procurando...</div>");
 $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidade').val(),
 function (resposta) {
 $("#defaultBairro").html("Selecione o Bairro");
 $("#menuBairro").html(resposta);
 }
 );
 });
 
 $("input[name=sltCidadeAvancado]").change(function () {
 $("#defaultBairroAvancado").html("<option value=''>Procurando...</div>");
 $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidadeAvancado').val(),
 function (resposta) {
 $("#defaultBairroAvancado").html("Selecione o Bairro");
 $("#menuBairroAvancado").html(resposta);
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
 
 
 $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
 tipoImovel: 'todos',
 valor: '',
 finalidade: '',
 cidade: '',
 bairro: '',
 quarto: '',
 condicao: '',
 id: $('#hdUsuario').val(),
 garagem: 'false'});
 
 
 $("#btnBuscarAnuncioUsuario").on('click', function () {
 $("#load").addClass('ui active inverted dimmer');
 if ($('#sltTipoImovel').val() == "") {
 tipoimovel = "todos"
 } else {
 tipoimovel = $('#sltTipoImovel').val()
 }
 ;
 $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
 tipoImovel: tipoimovel,
 valor: $('#sltValor').val(),
 finalidade: $('#sltFinalidade').val(),
 idcidade: $('#sltCidade').val(),
 idbairro: $('#sltBairro').val(),
 quarto: $('#sltQuartos').val(),
 banheiro: $('#sltBanheiros').val(),
 suite: $('#sltSuites').val(),
 condicao: $('#sltCondicao').val(),
 id: $('#hdUsuario').val(),
 garagem: $('#checkgaragem').parent().checkbox('is checked')}, function () {
 $("#load").addClass('ui active inverted dimmer');
 });
 setTimeout(function () {
 $('#load').removeClass("ui active inverted dimmer");
 }, 1000);
 });
 
 $("#btnBuscarAnuncioUsuarioAvancado").on('click', function () {
 $("#load").addClass('ui active inverted dimmer');
 if ($('#sltTipoImovelAvancado').val() == "") {
 tipoimovel = "todos"
 } else {
 tipoimovel = $('#sltTipoImovelAvancado').val()
 }
 ;
 $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
 tipoImovel: tipoimovel,
 valor: $('#sltValor').val(),
 finalidade: $('#sltFinalidadeAvancado').val(),
 idcidade: $('#sltCidadeAvancado').val(),
 idbairro: $('#sltBairroAvancado').val(),
 quarto: $('#sltQuartos').val(),
 banheiro: $('#sltBanheiros').val(),
 suite: $('#sltSuites').val(),
 condicao: $('#sltCondicaoAvancado').val(),
 unidadesandar: $('#sltUnidadesAndar').val(),
 area: $('#sltArea').val(),
 diferencial: $('#carregarDiferenciais').val(),
 id: $('#hdUsuario').val(),
 garagem: $('#sltGaragem').val()}, function () {
 $("#load").addClass('ui active inverted dimmer');
 });
 setTimeout(function () {
 $('#load').removeClass("ui active inverted dimmer");
 }, 1000);
 });
 
 });
 }*/

function carregarAnuncio() { //valor = quantidade de anuncios

    $(document).ready(function () {

        exibirEnviarComparar();

        $('.special.cards .image').dimmer({
            on: 'hover'
        });

        $('#lista').jplist({
            itemsBox: '.list',
            itemPath: '.list-item',
            panelPath: '.jplist-panel',
//          Executa a action do botão de detalhes a cada vez que os cards são renderizados pela paginação.  
            redrawCallback: function () {

                $('.ui.checkbox')
                        .checkbox();

                exibirEnviarComparar();

                $(".valor").priceFormat({
                    prefix: 'R$ ',
                    centsSeparator: ',',
                    centsLimit: 0,
                    limit: 8,
                    thousandsSeparator: '.'
                })

                $('.special.cards .image .button').on('click', function () {
                    $("#hdnCodAnuncio").val($(this).siblings().val());
                    $("#hdnTipoImovel").val($(this).siblings().next().val());
                    $("#hdnEntidade").val("Anuncio");
                    $("#hdnAcao").val("detalhar");
                    $('#form').submit();
                })
            }
        })


        $("#spanValor").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

        $("#hdnOrdTipoImovel").val($('#sltTipoImovel').val());
        $("#hdnOrdValor").val($('#sltValor').val());
        $("#hdnOrdFinalidade").val($('#sltFinalidade').val());
        $("#hdnOrdIdcidade").val($('#sltCidade').val());
        $("#hdnOrdIdbairro").val($('#sltBairro').val());
        $("#hdnOrdQuarto").val($('#sltQuartos').val());
        $("#hdnOrdCondicao").val($('#sltCondicao').val());
        $("#hdnOrdGaragem").val($('#checkgaragem').parent().checkbox('is checked'));

    })

}

function exibirEnviarComparar() {

    $(document).ready(function () {

        var selecionado = 0;

        $('.ui.checkbox').checkbox({
            beforeChecked: function () { //ao clicar no anuncio, marcar de vermelho                                               
                var NumeroMaximo = 5;
                if ($("input[name^='listaAnuncio']").length >= NumeroMaximo) {
                    alert('Selecione no máximo ' + NumeroMaximo + ' imóveis para a comparação');
                    return false;
                } else {

                    $('#hdnTipoImovel').after('<input type="hidden" name="listaAnuncio[]" id=anuncio_' + $(this).val() + ' value=' + $(this).val() + '>');
                    $(this).closest('.card').attr("class", "red card");
                    selecionado = selecionado + 1;
                    var botaoEmailComparar = ("<div class='ui buttons'><button class='ui button' type='submit' id='btnEmail'>Enviar Por Email</button><div class='or' data-text='ou'></div><button class='ui positive button' type='submit' id='btnComparar'>Comparar</button></div>");
                    if (selecionado == 1) {
                        $("#divBotoes").html(botaoEmailComparar);
                        confirmarEmail();
                        $('#btnComparar').on('click', function () {
                            $("#hdnEntidade").val("Anuncio");
                            $("#hdnAcao").val("comparar");
                            $('#form').submit();
                        })
                    }
                }
            },
            onUnchecked: function () { //ao desmarcar o anuncio, tirar o vermelho
                $('#anuncio_' + $(this).val()).remove();
                $(this).closest('.card').attr("class", "card");
                selecionado = selecionado - 1;
                if (selecionado == 0) {
                    $("#divBotoes").empty();
                }

            }}
        );
    })
}

function carregarAnuncioUsuario() {

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

    $('.special.cards .image .button').on('click', function () {
        $("#hdnCodAnuncio").val($(this).siblings().val());
        $("#hdnTipoImovel").val($(this).siblings().next().val());
        $('#form').submit();
    })
}

function confirmarEmail() {
    $(document).ready(function () {

        $('#btnEmail').click(function () {

            $("#divMsg").empty();

            $("#txtNomeEmail").show();
            $("#labelNome").show();

            $('.emailPDF').attr('value', 'enviarEmail'); //alterar o método para enviarEmailPDF 

            $("#divMsg").append("Envie o(s) Anúncio(s) selecionado(s) para o e-mail desejado");

            $('#modalEmail').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formEmail").submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');

            $("#txtMsgEmail").rules("add", {
                required: true
            });

            $("#camposEmail").show();
            $("#botaoEnviarEmail").show();
            $("#botaoCancelarEmail").show();
            $("#botaoFecharEmail").hide();
            $("#divRetorno").empty();

            $("#idAnuncios").empty();
            $("#idAnunciosCabecalho").empty();

            /*var arr = [];
             $("input[type^='checkbox']:checked").each(function ()
             {
             $("#idAnuncios").append("<input type='hidden' name='anunciosSelecionados[]' value='" + $(this).val() + "'>");
             var codigos = $("input[name^='hdnCodAnuncioFormatado']");
             arr.push($(this).parent().parent().parent().find(codigos).val());
             });
             
             //retira a vírgula do último elemento
             var anuncios = arr.join(", ");
             
             $("#idAnunciosCabecalho").append("<div class='ui horizontal list'>\n\
             <div class='item'>\n\
             <div class='content'>" + anuncios + "</div>\n\
             </div>\n\
             </div>");*/
            var arr = [];
            $("#idAnuncios").append($("input[name^='listaAnuncio']"));
            $(("input[name^='listaAnuncio']")).each(function () {
                arr.push($(this).val());
            });
            var anuncios = arr.join(", ");
            ;
            $("#idAnunciosCabecalho").append("<div class='ui horizontal list'>\n\
                                        <div class='item'>\n\
                                        <div class='content'>" + anuncios + "</div>\n\
                         </div>\n\
                         </div>");


        })
    })
}

function formatarValor(valor) {

    $("#spanValor" + valor).priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    })

    $("#txtTitulo" + valor).maxlength({
        threshold: 50,
        warningClass: "ui small green circular label",
        limitReachedClass: "ui small red circular label",
        separator: ' de ',
        preText: 'Voc&ecirc; digitou ',
        postText: ' caracteres permitidos.',
        validate: true
    })

    $("#txtDescricao" + valor).maxlength({
        threshold: 200,
        warningClass: "ui small green circular label",
        limitReachedClass: "ui small red circular label",
        separator: ' de ',
        preText: 'Voc&ecirc; digitou ',
        postText: ' caracteres permitidos.',
        validate: true
    })

}

function formatarValorComparar(valor) {

    $("#spanValor" + valor).priceFormat({
        prefix: ' ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    });

}

function enviarEmail() {
    $(document).ready(function () {

        $("#botaoFecharEmail").hide();

        $('#txtNomeEmail').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtMsgEmail').maxlength({
            alwaysShow: true,
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailEmail').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest(".error").removeClass("error").addClass("success");
            }
        });

        $.validator.messages.required = 'Campo obrigatório';
        $('#formEmail').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtEmailEmail: {
                    required: true,
                    email: true
                },
                captcha_code: {
                    required: true,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "validarCaptcha"
                                }
                            }
                }
            },
            messages: {
                txtEmailEmail: {
                    email: "Informe um email válido"
                },
                captcha_code: {
                    remote: "Código Inválido"
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#formEmail').serialize(),
                    beforeSend: function () {
                        $("#botaoEnviarEmail").hide();
                        $("#botaoCancelarEmail").hide();
                        $("#camposEmail").hide();
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'><div class='ui text loader'>Enviando Email. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {
                        $("#divRetorno").empty();
                        $("#botaoCancelarEmail").hide();
                        $("#botaoFecharEmail").show();
                        if (resposta.resultado == 1) {
                            $("#divRetorno").html('<div class="ui positive message">\n\
<i class="big green check circle outline icon"></i>Anúncio(s) enviado(s) com sucesso</div>');

                        } else {
                            $("#divRetorno").html('<div class="ui negative message">\n\
<i class="big red remove circle outline icon"></i>Tente novamente mais tarde. Houve um erro no processamento</div>');
                        }
                    }
                })
                return false;
            }
        })

    });
}

function inserirValidacao() {
    $(document).ready(function () {
        if ($("#hdnFinalidade").val() == "Venda") {

            $("#txtProposta").rules("add", {
                minLenght: 4,
                maxLenght: 7
            });
        }
    });
}

function enviarDenuncia() {
    $(document).ready(function () {

        $("#botaoFecharDenuncia").hide();

        $("#sltTipoDenuncia").dropdown('clear');
        $.post('index.php?hdnEntidade=Denuncia&hdnAcao=buscarTipoDenuncia',
                function (resposta) {
                    $("#retornoTipoDenuncia").html(resposta);
                }
        )

        $('.ui.dropdown')
                .dropdown()
                ;

        $('#txtMsgDenuncia').maxlength({
            alwaysShow: true,
            threshold: 500,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailDenuncia').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#btnDenuncia').click(function () {
            $('#modalDenunciaAnuncio').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formDenunciaAnuncio").submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');
            $.validator.setDefaults({
                ignore: [],
                errorClass: 'errorField',
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest("div.field").addClass("error").removeClass("success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest(".error").removeClass("error").addClass("success");
                }
            });
            $.validator.messages.required = 'Campo obrigatório';
            $('#formDenunciaAnuncio').validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    txtEmailDenuncia: {
                        email: true
                    },
                    txtMsgDenuncia: {
                        required: true
                    },
                    captcha_code: {
                        required: true,
                        remote:
                                {
                                    url: "index.php",
                                    dataType: "json",
                                    type: "POST",
                                    data: {
                                        hdnEntidade: "Usuario",
                                        hdnAcao: "validarCaptcha"
                                    }
                                }
                    }
                },
                messages: {
                    txtEmailDenuncia: {
                        email: "Informe um email válido"
                    },
                    captcha_code: {
                        remote: "Código Inválido"
                    },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#formDenunciaAnuncio').serialize(),
                        beforeSend: function () {
                            $("#botaoEnviarDenuncia").hide();
                            $("#botaoCancelarDenuncia").hide();
                            $("#camposDenuncia").hide();
                            $("#divRetornoDenuncia").html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Enviando denúncia. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetornoDenuncia").empty();
                            $("#botaoCancelarDenuncia").hide();
                            $("#botaoFecharDenuncia").show();
                            if (resposta.resultado == 1) {
                                $("#divRetornoDenuncia").html("<div class='ui positive message'>\n\
<i class='big green check circle outline icon'></i>Denúncia Enviada com Sucesso</div>");
                                $("#btnDenuncia").attr("disabled", "disabled");

                            } else {
                                $("#divRetornoDenuncia").html("<div class='ui negative message'>\n\
<i class='big red remove circle outline icon'></i>Erro no Envio. Tente novamente em alguns minutos</div>");
                            }
                        }
                    })
                    return false;
                }
            })

        })
    })
}

function enviarDuvidaAnuncio() {
    $(document).ready(function () {

        $("#botaoFecharDuvida").hide();

        $('#txtNomeDuvida').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtMsgDuvida').maxlength({
            alwaysShow: true,
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailDuvida').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#btnDuvida').click(function () {

            $('#modalDuvidaAnuncio').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formDuvidaAnuncio").submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');

            $.validator.setDefaults({
                ignore: [],
                errorClass: 'errorField',
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest("div.field").addClass("error").removeClass("success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest(".error").removeClass("error").addClass("success");
                }
            });

            $.validator.messages.required = 'Campo obrigatório';
            $('#formDuvidaAnuncio').validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    txtEmailDuvida: {
                        required: true,
                        email: true
                    },
                    txtMsgDuvida: {
                        required: true
                    },
                    captcha_code: {
                        required: true,
                        remote:
                                {
                                    url: "index.php",
                                    dataType: "json",
                                    type: "POST",
                                    data: {
                                        hdnEntidade: "Usuario",
                                        hdnAcao: "validarCaptcha"
                                    }
                                }
                    }
                },
                messages: {
                    txtEmailDuvida: {
                        email: "Informe um email válido"
                    },
                    captcha_code: {
                        remote: "Código Inválido"
                    },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#formDuvidaAnuncio').serialize(),
                        beforeSend: function () {
                            $("#botaoEnviarDuvida").hide();
                            $("#botaoCancelarDuvida").hide();
                            $("#camposDuvida").hide();
                            $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Enviando mensagem. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetorno").empty();
                            $("#botaoCancelarDuvida").hide();
                            $("#botaoFecharDuvida").show();
                            if (resposta.resultado == 1) {
                                $("#divRetorno").html("<div class='ui positive message'>\n\
<i class='big green check circle outline icon'></i>Mensagem Enviada com Sucesso</div>");
                                $("#btnDuvida").attr("disabled", "disabled");

                            } else {
                                $("#divRetorno").html("<div class='ui negative message'>\n\
<i class='big red remove circle outline icon'></i>Erro no Envio. Tente novamente em alguns minutos</div>");
                            }
                        }
                    })
                    return false;
                }
            })

        })
    })
}


function inserirAnuncioModal() {

    var idAnuncio;

    $('.ui.checkbox')
            .checkbox({
                onChecked: function () {
                    idAnuncio = ("<input type='hidden' name='idAnuncio[]' id='idAnuncio'" + $(this) + ">");
                    $("#divBotoes").append(idAnuncio);
                },
                onUnchecked: function () {
                    // idAnuncio.remove();

                }})

}

function marcarMapa(logradouro, numero, bairro, cidade, estado, tituloAnuncio, valor, finalidade, latitude, longitude, altura, largura, aprox) {

    $(document).ready(function () {

        $("#mapaGmapsBusca").width(altura).height(largura).gmap3();

        if (latitude == "" && longitude == "") {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        center: [-1.38, -48.2],
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {address: logradouro + ", " + numero + ", " + bairro + ", " + cidade + ", " + estado, data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        } else {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        center: [-1.38, -48.2],
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {latLng: [latitude, longitude], data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        }

    });

}

function marcarMapaIndividual(logradouro, numero, bairro, cidade, estado, tituloAnuncio, valor, finalidade, latitude, longitude, altura, largura, aprox) {

    $(document).ready(function () {

        $("#mapaGmapsBusca").width(altura).height(largura).gmap3();

        if (latitude == "" && longitude == "") {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {address: logradouro + ", " + numero + ", " + bairro + ", " + cidade + ", " + estado, data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        } else {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {latLng: [latitude, longitude], data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        }
        setTimeout(function () {
            $("#mapaGmapsBusca").width("100%").height(300).gmap3({trigger: "resize"});
            $('#mapaGmapsBusca').gmap3('get').setCenter($("#mapaGmapsBusca").gmap3({get: "marker"}).getPosition());
        }, 1000);
    });



}

function marcarMapaPublicarAnuncio(logradouro, numero, bairro, cidade, estado, tituloAnuncio, valor, finalidade, altura, largura, aprox) {

    $(document).ready(function () {

        $("#mapaGmapsBusca").width(altura).height(largura).gmap3();

        $("#mapaGmapsBusca").gmap3({
            map: {
                options: {
                    zoom: aprox,
                    draggable: true
                }
            },
            marker: {
                values: [{
                        address: logradouro + ", " + numero + ", " + bairro + ", " + cidade + "," + estado,
                        data: "Arraste o marcador, caso necessário, para o endereço correto"/*,
                         lat: logradouro + ", " + numero + ", " + bairro + ", "+ cidade + "," + estado,
                         lng: logradouro + ", " + numero + ", " + bairro + ", "+ cidade + "," + estado*/
                    },
                ],
                options: {
                    draggable: true
                },
                events: {
                    mouseover: function (marker, event, context) {
                        var map = $(this).gmap3("get"),
                                infowindow = $(this).gmap3({get: {name: "infowindow"}});
                        if (infowindow) {
                            infowindow.open(map, marker);
                            infowindow.setContent(context.data);
                        } else {
                            $(this).gmap3({
                                infowindow: {
                                    anchor: marker,
                                    options: {content: context.data}
                                }
                            });
                        }
                    },
                    mouseout: function () {
                        var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                        if (infowindow) {
                            infowindow.close();
                        }
                    },
                    dragend: function (map, event) {
                        var myLatLng = event.latLng;
                        var lat = myLatLng.lat();
                        var lng = myLatLng.lng();

                        $("#hdnLatitude").val(lat);
                        $("#hdnLongitude").val(lng);

                        //alert($("#hdnLatitude").val()+$("#hdnLongitude").val());

                    }
                }
            }

        });

    });

}

function carregarDiferencial() {

    $(document).ready(function () {

        $("#sltTipoImovelAvancado").change(function () {

            $.ajax({
                url: "index.php",
                type: "POST",
                data: {
                    hdnEntidade: "TipoImovelDiferencial",
                    hdnAcao: "buscarDiferencialLista",
                    sltTipoImovel: $('#sltTipoImovelAvancado').val()
                },
                success: function (resposta) {

                    $('#carregarDiferenciais').html(resposta);

                }
            })
        })
    })
}

function carregarCarrosselPreferencias() {

    $(document).ready(function () {
        var swiper = new Swiper('.swiper-container', {
//            pagination: '.swiper-pagination',
            slidesPerView: 4,
            paginationClickable: true,
            spaceBetween: 30
        });
//       $('.bxslider').bxSlider({
//        minSlides: 2,
//        maxSlides: 2,
//        slideWidth: 350,
//        slideMargin: 10
//});

//        $('.multiple-items').slick({
//            infinite: true,
//            slidesToShow: 3,
//            slidesToScroll: 3
//        });

//        $('.owl-carousel').owlCarousel({
//            loop: false,
//            nav: true,
////            margin: 39,
//            stagePadding: 24,
//            items: 4,
//            
//            responsive: {
//                0: {
//                    items: 1
//                },
//                600: {
//                    items: 2
//                },
//                1000: {
//                    items: 4
//                }
//            }
//        })
    })
}

function inicio() {

    $(document).ready(function () {

        $('.menu .item').tab();

        $("#divValorVenda").hide();
        $("#divValorAluguel").hide();
        $("#divQuarto").hide();
//        $("#divCondicao").hide();
        $("#divCondicaoAvancado").hide();
        $("#divQuarto").hide();
        $("#divBanheiro").hide();
        $("#divSuite").hide();
        $("#divAreaApartamento").hide();
        $("#divAreaCasaTerreno").hide();
        $("#divUnidadesAndar").hide();
        $("#divDiferencial").hide();
        $("#divGaragem").hide();
        $("#divGaragemAvancado").hide();
        $("#divAndares").hide();
        $("#divOutrasCaracteristicas").hide();

        $("#sltFinalidadeAvancado").change(function () {
            if ($(this).val() == "venda") {
                $("#divValorInicial").hide();
                $("#divValorAluguel").hide();
                $("#divValorVenda").show();


            }
            if ($(this).val() == "aluguel") {
                $("#divValorInicial").hide();
                $("#divValorVenda").hide();
                $("#divValorAluguel").show();

            }

            if ($(this).val() == "") {
                $("#divValorVenda").hide();
                $("#divValorAluguel").hide();
                $("#divValorInicial").show();
            }

        })

        $("#sltTipoImovel").change(function () {

            switch ($(this).val()) {

                case "":
                    $("#divGaragem").hide();
                    $("#divCondicao").hide();
                    break;

                case "casa":
                    //$("#divGaragem").show();
                    $("#divCondicao").show();
                    break;

                case "apartamentoplanta":
                    //$("#divGaragem").show();
                    $("#divCondicao").hide();
                    break;

                case "apartamento":
                    //$("#divGaragem").show();
                    $("#divCondicao").show();
                    break;

                case "salacomercial":
                    //$("#divGaragem").show();
                    $("#divCondicao").show();
                    break;

                case "prediocomercial":
                    $("#divGaragem").hide();
                    $("#divCondicao").hide();
                    break;

                case "terreno":
                    $("#divGaragem").hide();
                    $("#divCondicao").hide();
                    break;

            }

        })

        $("#sltTipoImovelAvancado").change(function () {

            $('#carregarDiferenciais').dropdown('restore defaults'); //resetar os diferenciais selecionados ao trocar o tipo    

            switch ($(this).val()) {

                case "":

                    $("#divValorVenda").hide();
                    $("#divValorAluguel").hide();
                    $("#divQuarto").hide();
                    $("#divCondicao").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divQuarto").hide();
                    $("#divBanheiro").hide();
                    $("#divSuite").hide();
                    $("#divAreaApartamento").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divDiferencial").hide();
                    $("#divGaragem").hide();
                    $("#divGaragemAvancado").hide();
                    $("#divAndares").hide();
                    $("#divOutrasCaracteristicas").hide();
                    $("#textoEspecifico").hide();
                    $("#tabelaInicioBusca").show();
                    break;

                case "casa":

                    $("#tabelaInicioBusca").hide();
                    $("#divAreaApartamento").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAndares").hide();
                    $("#divQuarto").show();
                    $("#divCondicaoAvancado").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divSuite").show();
                    $("#divAreaApartamento").show();
                    $("#divDiferencial").show();
                    $("#divOutrasCaracteristicas").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico da Casa</div>");
                    break;

                case "apartamento":

                    $("#tabelaInicioBusca").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divAndares").hide();
                    $("#divQuarto").show();
                    $("#divCondicaoAvancado").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divSuite").show();
                    $("#divAreaApartamento").show();
                    $("#divUnidadesAndar").show();
                    $("#divDiferencial").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico do Apartamento</div>");
                    $("#divOutrasCaracteristicas").show();
                    break;

                case "apartamentoplanta":

                    $("#tabelaInicioBusca").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divQuarto").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divSuite").show();
                    $("#divAreaApartamento").show();
                    $("#divUnidadesAndar").show();
                    $("#divDiferencial").show();
                    $("#divAndares").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico do Apartamento na Planta</di>");
                    $("#divOutrasCaracteristicas").show();
                    break;

                case "salacomercial":

                    $("#tabelaInicioBusca").hide();
                    $("#divQuarto").hide();
                    $("#divSuite").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divAreaTerreno").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAndares").hide();
                    $("#divOutrasCaracteristicas").hide();
                    $("#divAreaApartamento").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divDiferencial").hide();
                    $("#divAndares").hide();
                    $("#divAreaApartamento").hide();
                    $("#divCondicaoAvancado").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divDiferencial").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico da Sala Comercial</div>");
                    break;

                case "prediocomercial":

                    $("#tabelaInicioBusca").hide();
                    $("#divQuarto").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divSuite").hide();
                    $("#divGaragemAvancado").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divAreaApartamento").hide();
                    $("#divAndares").hide();
                    $("#textoEspecifico").hide();
                    $("#divBanheiro").hide();
                    $("#divOutrasCaracteristicas").hide();
//                    $("#divArea").show();
//                    $("#divDiferencial").show();
//                    $("#divOutrasCaracteristicas").show();
                    break;

                case "terreno":

                    $("#tabelaInicioBusca").hide();
                    $("#divQuarto").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divSuite").hide();
                    $("#divGaragemAvancado").hide();
                    $("#divBanheiro").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAndares").hide();
                    $("#divAreaApartamento").hide();
                    $("#divAreaCasaTerreno").show();
                    $("#textoEspecifico").hide();
                    $("#divOutrasCaracteristicas").hide();
                    break;
            }

        })

    });
}

function ordemInicio() {

    $(document).ready(function () {

        $("#sltOrdenacao").change(function () {
            $("#load").addClass('ui active inverted dimmer');
            if ($('#hdnOrdTipoImovel').val() == "") {
                tipoimovel = "todos";
            } else {
                tipoimovel = $('#sltTipoImovel').val();
            }
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: tipoimovel,
                valor: $('#hdnOrdValor').val(),
                finalidade: $('#hdnOrdFinalidade').val(),
                idcidade: $('#hdnOrdCidade').val(),
                idbairro: $('#hdnOrdBairro').val(),
                quarto: $('#hdnOrdQuartos').val(),
                condicao: $('#hdnOrdCondicao').val(),
                garagem: $('#hdnOrdGaragem').val(),
                ordem: $(this).val()}, function () {
                $("#load").addClass('ui active inverted dimmer');
            });
            setTimeout(function () {
                $('#load').removeClass("ui active inverted dimmer");
            }, 1000);
        })
    });
}



function validarArea(validacao) {
//    $(document).ready(function () {
//
//        if (validacao) {
//            $.validator.addMethod("verificaArea", function (value, element) {
//                var validacao = false;
//                if ($("#sltAreaMin").val() == "" && $("#sltAreaMax").val() != "") {
//                    validacao = true;
//                }
//                if ($("#sltAreaMax").val() != "" && $("#sltAreaMax").val() == "") {
//                    validacao = true;
//                }
//                return this.optional(element) || validacao;
//            }, 'Informe um valor.');
//
//            $("#sltAreaMin").rules("add", {
//                verificaArea: true
////                required: function (element) {
////                    return $("#chkValor").parent().checkbox('is checked');
////                }
//            });
//            $("#sltAreaMax").rules("add", {
//                verificaArea: true
////                required: function (element) {
////                    return $("#chkValor").parent().checkbox('is checked');
////                }
//            });
//        }
//        
//        if ("#hdnMsgDuvida") {
//                $("#txtMsgEmail").rules("add", {
//                    required: true
//                });
//            }
////if ($("#sltAreaMin").val() != "" && $("#sltAreaMax").val() == ""){
////                    var valor = parseInt($("#txtValor").unmask());
////                    if (!isNaN(valor)) {
////                        if (valor > 100) {
////                            validacao = true;
////                        }
////                    }
////                } else {
////                    validacao = true;
////                }
//    })
}

function enviarDuvidaUsuario() {

    $(document).ready(function () {

        $('#txtNomeDuvida').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtMsgDuvida').maxlength({
            alwaysShow: true,
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtTituloDuvida').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailDuvida').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $("#botaoEnviarDuvida").click(function () {
            if ($("#form").valid()) {
                $("#form").submit();
            }
        });

        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest(".error").removeClass("error").addClass("success");
            }
        });
        $.validator.messages.required = 'Campo obrigatório';
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtEmailDuvida: {
                    email: true,
                    required: true
                },
                txtTituloDuvida: {
                    required: true
                },
                txtMsgDuvida: {
                    required: true
                },
                captcha_code: {
                    required: true,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "validarCaptcha"
                                }
                            }
                },
            },
            messages: {
                txtEmailDuvida: {
                    email: "Informe um email válido"
                },
                captcha_code: {
                    remote: "Código Inválido"
                },
            },
            submitHandler: function (form) {
                //form.submit();
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                            <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {
                        $("#divRetorno").empty();

                        $("input[type^='text']").each(function () {
                            $(this).attr("disabled", "disabled");
                        });

                        $("#txtMsgDuvida").attr("disabled", "disabled");

                        $("#botoesDuvidas").hide();

                        $("#duvidaCaptcha").hide();

                        if (resposta.resultado == 1) {
                            $("#divRetorno").html('<div class="ui positive message">\n\
                            <i class="big green check circle outline icon"></i>Dúvida enviada com sucesso. Em breve responderemos a você</div>');

                        } else {
                            $("#divRetorno").html('<div class="ui negative message">\n\
                            <i class="big red remove circle outline icon"></i>Tente novamente mais tarde. Houve um erro no processamento</div>');
                        }
                    }
                })
                return false;

            }
        });


    });
}