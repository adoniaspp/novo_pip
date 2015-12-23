function cancelar(entidade, acao) {
    $(document).ready(function () {

        $('#btnCancelar').click(function () {
            $('#modalCancelar').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                    if (entidade === "" && acao === "") {
                        location.href = "index.php";
                    }
                    else
                        location.href = "index.php?entidade=" + entidade + "&acao=" + acao;
                }
            }).modal('show');
        })
    })
}
function cadastrarAnuncio() {
    $(document).ready(function () {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $('.ui.checkbox')
                .checkbox()
                ;
        $('#txtDescricao').maxlength({
            alwaysShow: true,
            threshold: 150,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtTitulo').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('.txtValor').priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
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
        $('#fileupload').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                sltPlano: {
                    required: true
                },
                sltFinalidade: {
                    required: true
                },
                txtTitulo: {
                    required: true
                },
                txtDescricao: {
                    required: true
                },
                chkAceite: {
                    required: true
                }
            },
            messages: {
                chkAceite: {
                    required: "A confirmação é obrigatória"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#fileupload').serialize(),
                    beforeSend: function () {
                        $('button').attr('disabled', 'disabled');
                    },
                    success: function (resposta) {
                        $("div[id^='step']").hide();
                        $("#step6").show();
                        if (resposta.resultado == 1) {
                            $("#divRetorno").html('<div class="ui inverted green center aligned segment">\n\
    <h2 class="ui header">Publicado!</h2>\n\
    <p>O cadastro de seu anúncio foi concluído com sucesso. </p>\n\
    <p>Em breve você receberá um e-mail confirmando a publicação do mesmo. </p>\n\n\
    <p><a href="index.php?entidade=Anuncio&acao=listarCadastrar" class="ui brown button"><i class="ui add icon"></i>Cadastrar outro anúncio?</a> </p>\n\n\
    <p><a href="index.php?entidade=UsuarioPlano&amp;acao=listar" class="ui orange button"><i class="ui add icon"></i>Comprar mais planos!</a></p>\n\
    <p>Compartilhe no <span class="ui facebook button"> <i class="facebook square icon"></i> Facebook </span></p>\n\
    </div>');
                            $('button').attr('disabled', 'disabled');
                        } else {
                            $("#divRetorno").html('<div class="ui inverted red center aligned segment">\n\
    <h2 class="ui header">Tente novamente mais tarde!</h2>\n\
    <p>Houve um erro no processamento de cadastro. </p>\n\
    </div>');
                            $('button').removeAttr('disabled');
                        }
                    }
                })
                return false;
            }
        })

    });
}

function stepsSemPlanta() {
    $(document).ready(function () {
        $("#step1").show();
        $("#step2").hide();
        $("#step3").hide();
        $("#step4").hide();
        $("#step5").hide();
        $("#step6").hide();
        $("#divInformarValor").hide();
        $("div[id^='btnAnterior']").hide();
        $("#sltPlano").change(function () {
            $(this).valid();
        })

        $("#sltFinalidade").change(function () {
            $(this).valid();
        })

        $("#chkValor").change(function () {
            if ($(this).parent().checkbox('is checked')) {
                $("#divInformarValor").show();
            } else {
                $("#divInformarValor").hide();
            }
        })

        $("div[id^='btnProximo']").click(function () {
            if (validarStepSemPlanta()) {
                var atual = parseInt($("#hdnStep").val());
                var proximo;
                if (atual == 2) {
                    proximo = atual + 2;
                } else {
                    proximo = atual + 1;
                }
                $("#step" + atual).hide();
                $("#step" + proximo).show();
                $("#hdnStep").val(proximo);
                $("#menuStep" + atual).removeClass();
                $("#menuStep" + atual).addClass("completed step");
                $("#menuStep" + proximo).addClass("active step");
                if (proximo > 1)
                    $("div[id^='btnAnterior']").show();
                else
                    $("div[id^='btnAnterior']").hide();
                if (proximo > 5) {
                    $("div[id^='btnProximo']").hide();
                    $("div[id^='btnAnterior']").hide();
                    $("#btnCancelar").hide();
                }
                else
                    $("div[id^='btnProximo']").show();
            }
        })

        $("div[id^='btnAnterior']").click(function () {
            var atual = parseInt($("#hdnStep").val());
            var anterior;
            if (atual == 4) {
                anterior = atual - 2;
            } else {
                anterior = atual - 1;
            }
            $("#step" + atual).hide();
            $("#step" + anterior).show();
            $("#hdnStep").val(anterior);
            $("#menuStep" + atual).removeClass();
            $("#menuStep" + atual).addClass("step");
            $("#menuStep" + anterior).removeClass();
            $("#menuStep" + anterior).addClass("active step");
            $("div[id^='btnProximo']").show();
            if (anterior > 1)
                $("div[id^='btnAnterior']").show();
            else
                $("div[id^='btnAnterior']").hide();
        })
    })
}

function validarStepSemPlanta() {
    var validacao = false;
    var step = parseInt($("#hdnStep").val());
    switch (step) {
        case 0:
        case 1:
            validacao = $("#sltPlano").valid();
            break;
        case 2:
            validacao = (($("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()));
            break;
        case 4:
            validacao = true;
            if (typeof ($("input[name^=txtLegenda]").val()) !== "undefined" && typeof ($("input[name^=txtLegenda]").attr('disabled')) === "undefined") {
                alert("Você ainda não enviou todas as fotos. \n Clique no botão Enviar");
                validacao = false;
            }
            if (typeof ($("input[name=delete]").val()) !== "undefined") {
                if (typeof ($("input[name=rdbDestaque]:checked").val()) === "undefined") {
                    alert("Informe uma Foto para ser Destaque do seu anúncio");
                    validacao = false;
                }
            }
            $("#tdPlano").html($('#sltPlano').parent().find(".selected").html());
            $("#tdFinalidade").html($('#sltFinalidade').parent().find(".selected").html());
            $("#tdTitulo").html($("#txtTitulo").val());
            $("#tdDescricao").html($("#txtDescricao").val());
            $("#tdValor").html(
                    (typeof ($("input[name=chkValor]:checked").val()) === "undefined" ? "Não Informado" : $("#txtValor").val())

                    );
            $("#tdMapa").html((typeof ($("input[name=chkMapa]:checked").val()) === "undefined" ? "Não" : "Sim"));
            $("#tdContato").html((typeof ($("input[name=chkContato]:checked").val()) === "undefined" ? "Não" : "Sim"));

            break;
        case 5:
            validacao = ($("#sltPlano").valid() & $("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid());
            if (validacao) {
                $("#fileupload").submit();
            }
            break;
    }
    return validacao;

}

function stepsComPlanta() {
    $(document).ready(function () {
        $("#step1").show();
        $("#step2").hide();
        $("#step3").hide();
        $("#step4").hide();
        $("#step5").hide();
        $("#step6").hide();
        $("#divInformarValor").hide();
        $("div[id^='btnAnterior']").hide();
        $("#sltPlano").change(function () {
            $(this).valid();
        })

        $("#sltFinalidade").change(function () {
            $(this).valid();
        })

        $("div[id^='btnProximo']").click(function () {
            if (validarStepComPlanta()) {
                var atual = parseInt($("#hdnStep").val());
                var proximo = atual + 1;
                $("#step" + atual).hide();
                $("#step" + proximo).show();
                $("#hdnStep").val(proximo);
                $("#menuStep" + atual).removeClass();
                $("#menuStep" + atual).addClass("completed step");
                $("#menuStep" + proximo).addClass("active step");
                if (proximo > 1)
                    $("div[id^='btnAnterior']").show();
                else
                    $("div[id^='btnAnterior']").hide();
                if (proximo > 5) {
                    $("div[id^='btnProximo']").hide();
                    $("div[id^='btnAnterior']").hide();
                    $("#btnCancelar").hide();
                }
                else
                    $("div[id^='btnProximo']").show();
            }
        })

        $("div[id^='btnAnterior']").click(function () {
            var atual = parseInt($("#hdnStep").val());
            var anterior = atual - 1;
            $("#step" + atual).hide();
            $("#step" + anterior).show();
            $("#hdnStep").val(anterior);
            $("#menuStep" + atual).removeClass();
            $("#menuStep" + atual).addClass("step");
            $("#menuStep" + anterior).removeClass();
            $("#menuStep" + anterior).addClass("active step");
            $("div[id^='btnProximo']").show();
            if (anterior > 1)
                $("div[id^='btnAnterior']").show();
            else
                $("div[id^='btnAnterior']").hide();
        })
    })
}

function validarStepComPlanta() {

    var validacao = false;
    var step = parseInt($("#hdnStep").val());
    switch (step) {
        case 0:
        case 1:
            validacao = $("#sltPlano").valid();
            break;
        case 2:
            validacao = (($("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()));
            break;
        case 3:
            validacao = true;
            break;
        case 4:
            validacao = true;
            if (typeof ($("input[name^=txtLegenda]").val()) !== "undefined" && typeof ($("input[name^=txtLegenda]").attr('disabled')) === "undefined") {
                alert("Você ainda não enviou todas as fotos. \n Clique no botão Enviar");
                validacao = false;
            }
            if (typeof ($("input[name=delete]").val()) !== "undefined") {
                if (typeof ($("input[name=rdbDestaque]:checked").val()) === "undefined") {
                    alert("Informe uma Foto para ser Destaque do seu anúncio");
                    validacao = false;
                }
            }
            $("#tdPlano").html($('#sltPlano').parent().find(".selected").html());
            $("#tdFinalidade").html($('#sltFinalidade').parent().find(".selected").html());
            $("#tdTitulo").html($("#txtTitulo").val());
            $("#tdDescricao").html($("#txtDescricao").val());
            $("#tdValor").html(
                    (typeof ($("input[name=chkValor]:checked").val()) === "undefined" ? "Não Informado" : $("#txtValor").val())

                    );
            $("#tdMapa").html((typeof ($("input[name=chkMapa]:checked").val()) === "undefined" ? "Não" : "Sim"));
            $("#tdContato").html((typeof ($("input[name=chkContato]:checked").val()) === "undefined" ? "Não" : "Sim"));

            break;
        case 5:
            validacao = ($("#sltPlano").valid() & $("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid());
            if (validacao) {
                $("#fileupload").submit();
            }
            break;
    }
    //console.log(validacao);
    return validacao;

}

function planta() {
    $(document).ready(function () {

        $(".sltAndarInicial").change(function () {
            $(this).valid();
        })
        $(".sltAndarFinal").change(function () {
            $(this).valid();
        })

        $(".btnAdicionarValor").click(function () {
            var input = $(this).parent().parent().find("input");
            var sltAndarInicial = input[0];
            var sltAndarFinal = input[1];

            var ordemPlanta = $(this).val();
            $(sltAndarInicial).rules("add", {
                required: true,
                validaAndar: function () {
                    return ordemPlanta
                },
                max: function () {
                    return $(sltAndarFinal).val();
                },
                messages: {
                    max: "Andar Inicial deve ser Maior ou Igual ao Andar Final"
                }
            });

            $(sltAndarFinal).rules("add", {
                required: true,
                validaAndar: function () {
                    return ordemPlanta
                },
                min: function () {
                    return $(sltAndarInicial).val();
                },
                messages: {
                    min: "Andar Inicial deve ser Maior ou Igual ao Andar Final"
                }
            });

            var txtValor = input[2];
            $(txtValor).rules("add", {
                required: true
            });
            var validacao = validarPlanta(sltAndarInicial, sltAndarFinal, txtValor, ordemPlanta);
            if (validacao) {
                var tbody = "#dadosPlanta_" + ordemPlanta;
                $(tbody).append(
                        "<tr><td> <input type='hidden' id='hdnAndarInicial" + ordemPlanta + "[]' name='hdnAndarInicial" + ordemPlanta + "[]' value='" + $(sltAndarInicial).val() + "'>" + $(sltAndarInicial).val() + "</td>" +
                        "<td> <input type='hidden' id='hdnAndarFinal" + ordemPlanta + "[]' name='hdnAndarFinal" + ordemPlanta + "[]' value='" + $(sltAndarFinal).val() + "'>" + $(sltAndarFinal).val() + "</td>" +
                        "<td> <input type='hidden' id='hdnValor" + ordemPlanta + "[]' name='hdnValor" + ordemPlanta + "[]' value='" + $(txtValor).val() + "'>" + $(txtValor).val() + "</td>" +
                        "<td class='collapsing'><div class='red ui icon button' onclick='excluirPlanta($(this))'><i class='trash icon'></i>Excluir</div></td></tr>");
                var tabela = "#tabelaPlanta_" + ordemPlanta;
                $(tabela).show();
            }
            $(sltAndarInicial).rules("remove");
            $(sltAndarFinal).rules("remove");
            $(txtValor).rules("remove");

            if (validacao) {
                $(sltAndarInicial).parent().dropdown('restore defaults');
                $(sltAndarFinal).parent().dropdown('restore defaults');
                $(txtValor).val("");
            }
        });
    })
}

function validarPlanta(sltAndarInicial, sltAndarFinal, txtValor, ordemPlanta) {
    var sucesso = $(sltAndarInicial).valid() & $(sltAndarFinal).valid() & $(txtValor).valid();
    /*
     if (sucesso) {
     var tbody = "#dadosPlanta_" + ordemPlanta;
     var linhas = $(tbody).children();
     if (linhas.length === 0) {
     sucesso = true;
     }
     else {
     var arrayIntervalo = [];
     $(linhas).each(function () {
     var inputs;
     inputs = $(this).find("input");
     var andarInicial = inputs[0];
     var andarFinal = inputs[1];
     arrayIntervalo = gerarNumerosIntervalos($(andarInicial).val(), $(andarFinal).val(), arrayIntervalo);
     })
     Array.prototype.duplicates = function () {
     return this.filter(function (x, y, k) {
     return y === k.lastIndexOf(x);
     });
     }
     var andaresAdicionados = arrayIntervalo.duplicates();
     if (andaresAdicionados.indexOf(parseInt($(sltAndarInicial).val())) < 0 && andaresAdicionados.indexOf(parseInt($(sltAndarFinal).val())) < 0) {
     sucesso = true;
     } else {
     sucesso = false;
     alert("ERRO: Não é permitido adicionar o mesmo andar");
     }
     }
     }
     */
    return sucesso;
}
/*
 function gerarNumerosIntervalos(inicial, final, array) {
 inicial = parseInt(inicial);
 final = parseInt(final);
 for ($i = inicial; $i <= final; $i++) {
 array.push($i);
 }
 return array;
 }
 */
function excluirPlanta(element) {
    $(document).ready(function () {
        var linha = element.parent().parent();
        var pai = linha.parent();
        linha.remove();
        if (pai.find("input").length === 0) {
            pai.parent().hide();
        }
    })
}

function validarValor(validacao) {
    $(document).ready(function () {

        if (validacao) {
            $.validator.addMethod("verificaValor", function (value, element) {
                var validacao = false;
                if ($("#chkValor").parent().checkbox('is checked')) {
                    var valor = parseInt($("#txtValor").unmask());
//                    switch ($('#sltFinalidade').parent().dropdown('get value')) {
//                        case "Aluguel":
                    if (!isNaN(valor)) {
                        if (valor > 100) {
                            validacao = true;
                        }
                    }
//                            break;
//                        case "Venda":
//                            if (!isNaN(valor)) {
//                                if (valor > 1000) {
//                                    validacao = true;
//                                }
//                            }
//                            break;

                } else {
                    validacao = true;
                }
                return this.optional(element) || validacao;
            }, 'Informe um valor mínimo.');

            $("#txtValor").rules("add", {
                verificaValor: true,
                required: function (element) {
                    return $("#chkValor").parent().checkbox('is checked');
                }
            });

            $("#chkValor").change(function () {
                if ($(this).parent().checkbox('is checked')) {
                    $("#divInformarValor").show();
                } else {
                    $("#divInformarValor").hide();
                }
            })
        }

    })
}




function validarValorProposta(validacao) {
    $(document).ready(function () {

        if (validacao) {
            $.validator.addMethod("verificaValor", function (value, element) {
                var validacao = false;
                if ($("#txtProposta").val() != "") {
                    var valor = parseInt($("#txtProposta").unmask());
                    switch ($('#hdnFinalidade').val()) {
                        case "Aluguel":
                            if (!isNaN(valor)) {
                                if (valor > 100) {
                                    validacao = true;
                                }
                            }
                            break;
                        case "Venda":
                            if (!isNaN(valor)) {
                                if (valor > 1000) {
                                    validacao = true;
                                }
                            }
                            break;
                    }
                } else {
                    validacao = true;
                }
                return this.optional(element) || validacao;
            }, 'Informe um valor mínimo.');

            $("#txtProposta").rules("add", {
                verificaValor: true,
                required: function (element) {
                    return $("#txtProposta").val();
                }
            });

            $("#txtProposta").val(function () {
                if ($(this).val() != "") {
                    $("#divInformarValor").show();
                } else {
                    $("#divInformarValor").hide();
                }
            })
        }

    })
}

function reativar(botao) {
    $(document).ready(function () {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $('#btnReativar' + botao).click(function () {
            
            $("#btnFecharReativar" + botao).hide();
            $("#sltPlano" + botao).dropdown('restore defaults');
            $("#dadosAnuncio" + botao).hide();
            $('#txtValor' + botao).priceFormat({
                prefix: 'R$ ',
                centsSeparator: ',',
                centsLimit: 0,
                limit: 8,
                thousandsSeparator: '.'
            });
            $("#chkValor" + botao).parent().checkbox('set checked');
            $("#sltPlano" + botao).change(function () {
                $('.ui.modal').modal('refresh');
                $("#dadosAnuncio" + botao).show();
                $("#chkValor" + botao).change(function () {
                    if ($(this).parent().checkbox('is checked')) {
                        $("#divInformarValor" + botao).show();
                    } else {
                        $("#divInformarValor" + botao).hide();
                    }
                })
            })
            
            $('#modalReativar' + botao).modal({
                closable: true,
                transition: "fade up",
                observeChanges: true,
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formReativar" + botao).submit();
                    return false; //deixar o modal fixo
                },
                
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

            $("#formReativar" + botao).validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    sltPlano: {
                        required: true
                    },
                    txtTitulo: {
                        required: true
                    },
                    txtDescricao: {
                        required: true
                    },
                },
                messages: {
                    sltPlano: {
                        email: "Escolha um Plano"
                    },
                    txtTitulo: {
                        remote: "Informe o Titulo do Anúncio"
                    },
                    txtDescricao: {
                        remote: "Informe a Descrição do Anúncio"
                    },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $("#formReativar" + botao).serialize(),
                        beforeSend: function () {
                            $("#btnReativarModal" + botao).hide();
                            $("#btnCancelarReativar" + botao).hide();
                            $("#camposAnuncio" + botao).hide();
                            $("#divRetorno" + botao).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Enviando mensagem. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetorno" + botao).empty();
                            $("#btnFecharReativar" + botao).show();
//                            window.location = "index.php?entidade=Anuncio&acao=listarReativarAluguel";
                            $("#btnFecharReativar" + botao).click(function () {
                                window.location = "index.php?entidade=Anuncio&acao=listarReativarAluguel";
                            });
                            if (resposta.resultado == 1) {
                                $("#divRetorno" + botao).html('<div class="ui positive message">\n\
                        <div class="header">Anuncio Reativado com Sucesso </div></div>');

                            } else {
                                $("#divRetorno" + botao).html('<div class="ui negative message">\n\
                        <div class="header">Tente novamente mais tarde.</div> <p>Houve um erro no processamento.</p></div>');
                            }
                        }
                    })
                    return false;
                }
            })

        })
        
    })

}

function formatarDetalhe() {
    $(document).ready(function () {
        $("#divValor").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })
        $("#txtProposta").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 12,
            thousandsSeparator: '.'
        })
    })
}

function formatarValor(vetor) {
    $("#tdValor" + vetor).priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    })
}

function finalizar(botao) {
    $(document).ready(function () {

        $('.ui.radio.checkbox')
                .checkbox()
                ;

        $("#radioSucesso" + botao).select(function () {
            $(this).valid();
        })

        $("#botaoFecharFinalizar" + botao).hide();

        $('#btnFinalizar' + botao).click(function () {

            $('#txtFinalizar' + botao).maxlength({
                alwaysShow: true,
                threshold: 100,
                warningClass: "ui small green circular label",
                limitReachedClass: "ui small red circular label",
                separator: ' de ',
                preText: 'Voc&ecirc; digitou ',
                postText: ' caracteres permitidos.',
                validate: true
            });

            $('#modalFinalizar' + botao).modal({
                closable: false,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formFinalizar" + botao).submit();
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
            $('#formFinalizar' + botao).validate({
                focusInvalid: true,
                rules: {
                    radioSucesso: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#formFinalizar' + botao).serialize(),
                        beforeSend: function () {
                            $("#botaoFecharFinalizar" + botao).hide();
                            $("#botaoCancelarFinalizar" + botao).hide();
                            $("#camposFinalizar" + botao).hide();
                            $("#divRetorno" + botao).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetorno" + botao).empty();
                            $("#botaoCancelarFinalizar" + botao).hide();
                            $("#botaoEnviarFinalizar" + botao).hide();
                            $("#botaoFecharFinalizar" + botao).show();
                            //ao clicar no botão de fechar, o conteúdo será atualizado para retirar o último negócio finalizado
                            $("#botaoFecharFinalizar" + botao).click(function () {
                                window.location = "index.php?entidade=Anuncio&acao=listarAtivo";
                            });

                            if (resposta.resultado == 1) {
                                $("#divRetorno" + botao).html('<div class="ui inverted green center aligned segment">\n\
                        <p>Obrigado por fazer negócio no PIP OnLine</p>');

                            } else {
                                $("#divRetorno" + botao).html('<div class="ui inverted red center aligned segment">\n\
                        <h2 class="ui header">Tente novamente mais tarde. Houve um erro no processamento.</h2></div>');
                            }
                        }
                    })
                    return false;
                }
            })

        })
    })
}