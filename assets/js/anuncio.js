function cadastrarAnuncio() {
    $(document).ready(function () {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $('.ui.checkbox')
                .checkbox()
                ;
        $("#step1").show();
        $("#step2").hide();
        $("#step3").hide();
        $("#step4").hide();
        $("#step5").hide();
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
            if (validarStep()) {
                var atual = parseInt($("#hdnStep").val());
                var proximo = atual + 1;
                $("#step" + atual).hide();
                $("#step" + proximo).show();
                $("#hdnStep").val(proximo);
                $("div[id^='menuStep']").removeClass();
                $("div[id^='menuStep']").addClass("step");
                $("#menuStep" + proximo).addClass("active step");
                if (proximo > 1)
                    $("div[id^='btnAnterior']").show();
                else
                    $("div[id^='btnAnterior']").hide();
                if (proximo > 4) {
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
            $("div[id^='menuStep']").removeClass();
            $("div[id^='menuStep']").addClass("step");
            $("#menuStep" + anterior).addClass("active step");
            $("div[id^='btnProximo']").show();
            if (anterior > 1)
                $("div[id^='btnAnterior']").show();
            else
                $("div[id^='btnAnterior']").hide();
        })


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
        function validarStep() {
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
                case 4:
                    validacao = ($("#sltPlano").valid() & $("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid());
                    if (validacao) {
                        $("#fileupload").submit();
                    }
                    break;
            }
            return validacao;
        }

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
        $.validator.addMethod("verificaValor", function (value, element) {
            var validacao = false;
            if ($("#chkValor").parent().checkbox('is checked')) {
                var valor = parseInt($("#txtValor").unmask());
                switch ($('#sltFinalidade').parent().dropdown('get value')) {
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
                txtValor: {
                    verificaValor: true,
                    required: function (element) {
                        return $("#chkValor").parent().checkbox('is checked');
                    }
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
                        $("#step5").show();
                        if (resposta.resultado == 1) {
                            $("#divRetorno").html('<div class="ui inverted green center aligned segment">\n\
    <h2 class="ui header">Obrigado!</h2>\n\
    <p>O cadastro de seu anúncio foi concluído com sucesso. </p>\n\
    <p>Em breve você receberá um e-mail confirmando a publicação do mesmo. </p>\n\n\
    <p><a href="index.php?entidade=Anuncio&acao=listarCadastrar" class="ui purple button"><i class="ui add icon"></i>Cadastrar outro anúncio?</a> </p>\n\n\
    <p><a href="index.php?entidade=UsuarioPlano&amp;acao=listar" class="ui orange button"><i class="ui add icon"></i>Comprar mais planos!</a></p>\n\
    <p>Divulgue esse anuncio no <span class="ui facebook button"> <i class="facebook square icon"></i> Facebook </span></p>\n\
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


function planta() {
    $(document).ready(function () {

        $(".sltAndarInicial").change(function () {
            $(this).valid();
        })
        $(".sltAndarFinal").change(function () {
            $(this).valid();
        })

        $(".btnAdicionarValor").click(function () {
            var sltAndarInicial = $(this).parent().parent().find("input")[0];
            var sltAndarFinal = $(this).parent().parent().find("input")[1];

            $(sltAndarInicial).rules("add", {
                required: true,
                max: function () {
                    return $(sltAndarFinal).val();
                },
                messages: {
                    max: "Andar Inicial deve ser Maior ou Igual ao Andar Final"
                }
            });

            $(sltAndarFinal).rules("add", {
                required: true,
                min: function () {
                    return $(sltAndarInicial).val();
                },
                messages: {
                    min: "Andar Inicial deve ser Maior ou Igual ao Andar Final"
                }
            });

            var txtValor = $(this).parent().parent().find("input")[2];
            $(txtValor).rules("add", {
                required: true
            });
            var ordemPlanta = $(this).val();
            if (validarPlanta(sltAndarInicial, sltAndarFinal, txtValor, ordemPlanta)) {
                var tbody = "#dadosPlanta_" + ordemPlanta;
                $(tbody).append(
                        "<tr><td> <input type='hidden' id='hdnAndarInicial" + ordemPlanta + "[]' name='hdnAndarInicial" + ordemPlanta + "[]' value='" + $(sltAndarInicial).val() + "'>" + $(sltAndarInicial).val() + "</td>" +
                        "<td> <input type='hidden' id='hdnAndarFinal" + ordemPlanta + "[]' name='hdnAndarFinal" + ordemPlanta + "[]' value='" + $(sltAndarFinal).val() + "'>" + $(sltAndarFinal).val() + "</td>" +
                        "<td> <input type='hidden' id='hdnValor" + ordemPlanta + "[]' name='hdnValor" + ordemPlanta + "[]' value='" + $(txtValor).val() + "'>" + $(txtValor).val() + "</td>" +
                        "<td class='collapsing'><div class='red ui icon button' onclick='excluirPlanta($(this))'><i class='trash icon'></i>Excluir</div></td></tr>");
                $(sltAndarInicial).parent().dropdown('restore defaults');
                $(sltAndarFinal).parent().dropdown('restore defaults');
                $(txtValor).val("");
                var tabela = "#tabelaPlanta_" + ordemPlanta;
                $(tabela).show();
            }
            $(sltAndarInicial).rules("remove");
            $(sltAndarFinal).rules("remove");
            $(txtValor).rules("remove");
        });
    })
}

function validarPlanta(sltAndarInicial, sltAndarFinal, txtValor, ordemPlanta) {
    var sucesso = $(sltAndarInicial).valid() & $(sltAndarFinal).valid() & $(txtValor).valid();

    if (sucesso) {
        var tbody = "#dadosPlanta_" + ordemPlanta;
        var linhas = $(tbody).children();
        if (linhas === 0) {
            console.log('beleza nao tem tabela');
        }
        else {
            var arrayIntervalo = [];
            $(linhas).each(function(){
                //buscar o andar inicial
                //buscar o andar final
                //criar array com numeros do intervalo
                
                
                
            })
    //fazer um merge unique
    //verificar se o valor do andar inicial ou final esta dentro dentro desse array

    
            console.log(' tem tabela');
            
            
        }
        console.log($(tbody).children());
        //console.log($(tbody).children().children().find("input"));
//        var hege = ["Cecilie", "Lone"];
//var stale = ["Emil", "Lone", "Linus"]; var c = hege.concat(stale);
//c.filter(function (item, pos) {return c.indexOf(item) == pos});
//
//
//c.sort();
    }

    return sucesso;
}

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