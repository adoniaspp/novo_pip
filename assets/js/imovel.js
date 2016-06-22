function esconderCamposInicio() {
    $(document).ready(function () {
        preco();
        $("#sltTipo").val('');//limpar o valor do campo tipo de imovel
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

        $("#sltTipo").parent().dropdown('restore defaults');//reiniciar ao valor padrao do campo tipo de imovel
        $('.ui.checkbox')
                .checkbox();

        $("#divAndar").hide();
        $("#divCondicao").hide();
        $("#divArea").hide();
        $("#divAreaPlanta").hide();
        $("#divInfoApeCasa").hide();
        $("#divDescricao").hide();
        $("#divApartamento").hide();
        $("#divDiferencial").hide();
        $("#divEndereco").hide();
        $("#divNumeroPlantas").hide();
        $("#divCondominio").hide();
        $("#divCEP").hide();
        $("#divAreaApeNovo").hide();
        $("#chkCobertura").hide();
        $("#chkSacada").hide();
        $("#divDiferencialPlanta").hide();
        
        $("#sltNumeroPlantas").change(function () {
            mostrarPlantas();
        })
        
        $("#sltTipo").rules("add", {
            required: true
        });

        //ao mudar o tipo do imovel
        $("#sltTipo").change(function () {
            $(this).valid();
            //chama os diferencias por tipo de imovel
            $.ajax({
                url: "index.php",
                type: "POST",
                data: {
                    hdnEntidade: "TipoImovelDiferencial",
                    hdnAcao: "buscarDiferencialChk",
                    sltTipo: $('#sltTipo').val()
                },
                success: function (resposta) {
                    $('#chkDiferencial').html(resposta);
                    $('.ui.checkbox')
                            .checkbox();
                }
            })
            //remove todas as regras do validate
            $("#txtCEP").rules("remove");
            //resetar os valores default dos dropdown e campos textos
            $('#sltNumeroPlantas').parent().dropdown('restore defaults');
            $('#sltCondicao').parent().dropdown('restore defaults');
            $('#sltQuarto').parent().dropdown('restore defaults');
            $('#sltSuite').parent().dropdown('restore defaults');
            $('#sltBanheiro').parent().dropdown('restore defaults');
            $('#sltGaragem').parent().dropdown('restore defaults');
            $('#sltAndares').parent().dropdown('restore defaults');
            $("#txtArea").val("");
            $("#txtDescricao").val("");
            
            //mostra a area
            mostrarArea();
            //adiciona novamente a regra do CEP o validate
            $("#txtCEP").rules("add", {
                required: true
            });
            //verificar o tipo do imovel escolhido
            if ($(this).val() == "1") { //casa
                //chama a funcao de carregamento da casa/apartamento/sala comercial
                mostrarDivInfoApeCasa();
                //esconde as div de apartamento e planta
                $("#divApartamento").hide();
                $("#divNumeroPlantas").hide();
                $("#divInserePlanta").hide();
                $("#divPlantaUm").hide();
                $("#divDiferencialPlanta").hide();
                $("#divAndar").hide();
                //exibe as informacoes de casa
                $("#divInfoBasicas").show();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                $("#divCondicao").show();
                //adiciona as regras do validate     
                $("input[id^='txtPlanta']").each(function () {
                    $(this).rules("remove");
                });
                $("input[id^='slt']").each(function () {
                    $(this).rules("remove");
                });
                $("#sltCondicao").rules("add", {
                    required: true
                });
                $("#sltQuarto").rules("add", {
                    required: true
                });
                $("#sltSuite").rules("add", {
                    required: true
                });
                $("#sltBanheiro").rules("add", {
                    required: true
                });
                $("#sltGaragem").rules("add", {
                    required: true
                });
                $("#sltCondicao").change(function () {
                    $(this).valid();
                })
                $("#sltQuarto").change(function () {
                    $(this).valid();
                })
                $("#sltSuite").change(function () {
                    $(this).valid();
                })
                $("#sltBanheiro").change(function () {
                    $(this).valid();
                })
                $("#sltGaragem").change(function () {
                    $(this).valid();
                })

            } else if ($(this).val() == "2") {  //apartamento na planta
                //limpa a div de carregamento
                $("#divInfoApeCasa").empty();
                //chama funcao de carregar as plantas
                //mostrarPlantas();
                //exibe as divs de planta
                $("#divNumeroPlantas").show();
                $("#divAreaPlanta").show();
                $("#divNumeroTorres").show();
                $("#divAndares").show();
                $("#divUnidadesTotal").show();
                $("#divUnidadesAndar").show();
                $("#divDiferencialPlanta").show();
                //esconde as
                $("#divInserePlanta").hide();
                $("#divPlantaUm").hide();
                $("#divInfoBasicas").hide();
                $("#divInfoApeCasa").hide();
                $("#divDescricao").hide();
                $("#divEndereco").hide();
                $("#divApartamento").hide();
                $("#divDiferencial").hide();
                $("#chkCobertura").hide();
                $("#chkSacada").hide();
                $("#divCondicao").hide();
                $("#divArea").hide();
                $("#divInfoApeCasa").hide();
                $("#divAndar").hide();

            } else if ($(this).val() == "3") { //apartamento novo ou usado 

                $("#divInfoApeCasa").empty();

                mostrarDivInfoApeCasa();
                $("#divPlantaUm").hide();
                $("#divNumeroTorres").hide();
                $("#divAndares").hide();
                $("#divUnidadesTotal").hide();
                $("#divNumeroPlantas").hide();
                $("#divInserePlanta").hide();
                $("#divAreaPlanta").hide();
                $("#divDiferencialPlanta").hide();
                $("#divCondicao").show();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                $("#divApartamento").show();
                $("#divAndar").show();
                $("#divUnidadesAndar").show();
                $("#divDiferencial").show();
                $("#divCondominio").show();
                $("#chkCobertura").show();
                $("#chkSacada").show();

                $("input[id^='txtPlanta']").each(function () {
                    $(this).rules("remove");
                });
                $("input[id^='slt']").each(function () {
                    $(this).rules("remove");
                });

                $("#sltCondicao").rules("add", {
                    required: true
                });
                $("#sltQuarto").rules("add", {
                    required: true
                });
                $("#sltSuite").rules("add", {
                    required: true
                });
                $("#sltBanheiro").rules("add", {
                    required: true
                });
                $("#sltGaragem").rules("add", {
                    required: true
                });

                $("#sltCondicao").change(function () {
                    $(this).valid();
                })

                $("#sltQuarto").change(function () {
                    $(this).valid();
                })

                $("#sltSuite").change(function () {
                    $(this).valid();
                })

                $("#sltBanheiro").change(function () {
                    $(this).valid();
                })

                $("#sltGaragem").change(function () {
                    $(this).valid();
                })

            } else if ($(this).val() == "4") { //sala comercial
                mostrarDivInfoApeCasa()
                $("#divApartamento").show();
                $("#chkCobertura").hide();
                $("#chkSacada").hide();
                $("#divPlantaUm").hide();
                $("#divAndar").hide();
                $("#divNumeroPlantas").hide();
                $("#divAreaPlanta").hide();
                $("#divInserePlanta").hide();
                $("#divNumeroTorres").hide();
                $("#divAndares").hide();
                $("#divUnidadesTotal").hide();
                $("#divNumeroPlantas").hide();
                $("#divUnidadesAndar").hide();
                $("#divDiferencialPlanta").hide();
                $("#divCondominio").show();
                $("#divDiferencial").show();
                $("#divInfoApeCasa").show();
                $("#divCondicao").show();
                $("#divDescricao").show();
                $("#divEndereco").show();

                $("input[id^='txtPlanta']").each(function () {
                    $(this).rules("remove");
                });
                $("input[id^='slt']").each(function () {
                    $(this).rules("remove");
                });

                $("#sltCondicao").rules("add", {
                    required: true
                });

                $("#sltBanheiro").rules("add", {
                    required: true
                });

                $("#sltGaragem").rules("add", {
                    required: true
                });

                $("#sltCondicao").change(function () {
                    $(this).valid();
                })

                $("#sltBanheiro").change(function () {
                    $(this).valid();
                })

                $("#sltGaragem").change(function () {
                    $(this).valid();
                })

            } else if ($(this).val() == "5") { //prédio comercial
                mostrarDivInfoApeCasa()
                $("#divPlantaUm").hide();
                $("#divAndar").hide();
                $("#divNumeroPlantas").hide();
                $("#divCondicao").hide();
                $("#divAreaPlanta").hide();
                $("#divInserePlanta").hide();
                $("#divInfoApeCasa").hide();
                $("#divApartamento").hide();
                $("#divDiferencialPlanta").hide();
                $("#divDescricao").show();
                $("#divEndereco").show();
                
                $("input[id^='txtPlanta']").each(function () {
                    $(this).rules("remove");
                });
                $("input[id^='slt']").each(function () {
                    $(this).rules("remove");
                });

            } else if ($(this).val() == "6") { //terreno
                mostrarDivInfoApeCasa()
                $("#divPlantaUm").hide();
                $("#divInserePlanta").hide();
                $("#divAndar").hide();
                $("#divNumeroPlantas").hide();
                $("#divCondicao").hide();
                $("#divInfoApeCasa").hide();
                $("#divApartamento").hide();
                $("#divAreaPlanta").hide();
                $("#divDiferencialPlanta").hide();
                $("#divDescricao").show();
                $("#divEndereco").show();
                
                $("input[id^='txtPlanta']").each(function () {
                    $(this).rules("remove");
                });
                $("input[id^='slt']").each(function () {
                    $(this).rules("remove");
                });
            }


        });

    });

    function mostrarArea() {
        $("#divArea").show();
    }

    function mostrarPlantas() {
        $(document).ready(function () {
            //define a regra caso altere a quantidade de plantas
                //limpa a div de carregamento
                $("#divInfoApeCasa").empty();

                //valida o campo para remover a marcação de erro, se houver
                $("#sltNumeroPlantas").valid();
                //se for mais de 1 
                if ($("#sltNumeroPlantas").val() >= "1") {
                    $("#divInserePlanta").show();
                    $("#divAreaApeNovo").show();
                    $("#divPlantaUm").show();
                    $("#divInfoBasicas").show();
                    $("#divInfoApeCasa").show();
                    $("#divDescricao").show();
                    $("#divEndereco").show();
                    $("#divApartamento").show();
                    $("#divDiferencial").show();
                    $("#divAndar").hide();
                    $("#divCondominio").hide();
                    $("#divArea").hide();

                }

                var valores = parseInt($("#sltNumeroPlantas").val());

                if (valores >= 1) { //verifica se já existem divs na tela e as remove 

                    $("#divInserePlanta").empty();
                    $("#divPlantaUm").empty();

                }

                for (var valor = 1; valor <= valores; valor++) { //clona as divs das plantas e as adiciona
                    
                    var $clone = $('#divInfoApeCasa').clone();
                    
                    var cloneDifPlanta = $('#divDiferencialPlanta').clone();
                    
                    //$('#divDiferencialPlanta').attr("id", "simoncartman");
                    
                    $clone.attr("id", "divInfoApeCasa" + valor);
                    
                    cloneDifPlanta.attr("id", "divDiferencialPlanta" + valor);

                    var label = "<h4>Planta " + (valor) + ": </h4><div id='divNomePlantas' class='ten wide required field'><input type='text' maxlength='80' name='txtPlanta[]' id='txtPlanta" + valor + "' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>"

                    $('#divInserePlanta').append(label);
                    $('#divInserePlanta').append($clone);
                    $('#divInserePlanta').append(cloneDifPlanta);

                    //componente que exibe o valor máximo a ser digitado para cada planta
                    $('#txtPlanta' + valor).maxlength({
                        alwaysShow: true,
                        threshold: 50,
                        warningClass: "ui small green circular label",
                        limitReachedClass: "ui small red circular label",
                        separator: ' de ',
                        preText: 'Voc&ecirc; digitou ',
                        postText: ' caracteres permitidos.',
                        validate: true
                    });

                }
                //var teste = 0;
                for (var contador = 1; contador <= valores; contador++) {
         
                    //teste = teste + 1;
                    var quarto = "<div class='four wide required field'>\n\
                                    <label>Quarto(s)</label>\n\
                                    <div class='ui selection dropdown'>\n\
                                    <input type='hidden' name='sltQuarto[]' id='sltQuarto" + contador + "'>\n\
                                    <div class='default text'>Quarto(s)</div>\n\
                                    <i class='dropdown icon'></i><div class='menu'>\n\
                                        <div class='item' data-value='1'>1</div>\n\
                                        <div class='item' data-value='2'>2</div>\n\
                                        <div class='item' data-value='3'>3</div>\n\
                                        <div class='item' data-value='4'>4</div>\n\
                                        <div class='item' data-value='5'>5 ou mais</div>\n\
                                        </div></div></div>";
                    var banheiro = "<div class='four wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro[]' id='sltBanheiro" + contador + "'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
                    var suite = "<div class='four wide required field'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite[]' id='sltSuite" + contador + "'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
                    var garagem = "<div class='four wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem[]' id='sltGaragem" + contador + "'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
                    var area = "<div id='divAreaPlanta' class='four wide field'><div class='field'><label>Área (m<sup>2</sup>)</label><input type='text' name='txtArea[]' id='txtArea" + contador + "' maxlength='7' placeholder='Área'></div></div>";
                    
                        $.ajax({
                            url: "index.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                
                                hdnEntidade: "TipoImovelDiferencial",
                                hdnAcao: "buscarDiferencialChkPlanta",
                                sltTipo: 2,
                                contador: contador
                            },
                            success: function (resposta) {

                                     for (var i = 0; i < resposta.Diferenciais.length; i++) { 

                                        for (var key in resposta.Diferenciais[i]) { 
                                        
                                        var respostaTotal = "<div class='ui checkbox'>\n\
                                                            <input type='checkbox' id='chkDiferencialPlanta"+ resposta.contador +"' name='chkDiferencialPlanta"+ resposta.contador +"[]' \n\
                                                                value='"+ key+"'>\n\
                                                            <label id='diferencialPlanta"+ resposta.contador +"' style='margin-right: 10px;'>"+ resposta.Diferenciais[i][key]+"\
                                                            </label> &nbsp;</div>";
           
                                        }
                                        
                                        $("#divDiferencialPlanta"+resposta.contador).append(respostaTotal);
                                        $('.ui.checkbox').checkbox();
                                        
                                    }

                            }
                        })
   
                    $("#divInfoApeCasa" + contador).append(quarto);
                    $("#divInfoApeCasa" + contador).append(banheiro);
                    $("#divInfoApeCasa" + contador).append(suite);
                    $("#divInfoApeCasa" + contador).append(garagem);
                    $("#divInfoApeCasa" + contador).append(area);                  
                    
                    $("#sltQuarto" + contador).change(function () {
                        $(this).valid();
                    })

                    $("#sltBanheiro" + contador).change(function () {
                        $(this).valid();
                    })

                    $("#sltSuite" + contador).change(function () {
                        $(this).valid();
                    })

                    $("#sltGaragem" + contador).change(function () {
                        $(this).valid();
                    })

                    $('#txtArea' + contador).priceFormat({
                        prefix: ' ',
                        centsSeparator: '.',
                        thousandsSeparator: '.',
                        limit: 6
                    });

                }

                $("input[name^='slt']:not('#sltTipo'):not('#sltNumeroPlantas')").parent().dropdown({
                    on: 'hover'
                })


                $("#sltCondicao").rules("remove");

                $("#sltNumeroPlantas").rules("add", {
                    required: true
                });

                $("#sltAndares").change(function () {
                    $(this).valid();
                })
                $("#sltAndares").rules("add", {
                    required: true
                });

                $("input[name^='txtPlanta[]']").each(function () {
                    $(this).rules("add", {required: true});
                })
                $("input[name^='sltQuarto[]']").each(function () {
                    $(this).rules("add", {required: true});
                })
                $("input[name^='sltBanheiro[]']").each(function () {
                    $(this).rules("add", {required: true});
                })
                $("input[name^='sltSuite[]']").each(function () {
                    $(this).rules("add", {required: true});
                })
                $("input[name^='sltGaragem[]']").each(function () {
                    $(this).rules("add", {required: true});
                })
                $("input[name^='txtArea[]']").each(function () {
                    $(this).rules("add", {maxlength: 7,
                        minlength: 2});
                })

            

            }
        )
    }
}

function mostrarDivInfoApeCasa() {
    $(document).ready(function () {
        //limpa o que tiver na div de carregamento
        $("#divInfoApeCasa").empty();
        
        
        //se o tipo escolhido for casa ou apartamento, carrega os campos basicos: quarto, banheiro, suite e garagem
        if ($("#sltTipo").val() == "1" || $("#sltTipo").val() == "3") {
            var quarto = "<div class='four wide required field'><label>Quarto(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltQuarto' id='sltQuarto'><div class='default text'>Quarto(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
            var banheiro = "<div class='four wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
            var suite = "<div class='four wide required field'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite' id='sltSuite'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
            var garagem = "<div class='four wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";

            $("#divInfoApeCasa").append(quarto);
            $("#divInfoApeCasa").append(banheiro);
            $("#divInfoApeCasa").append(suite);
            $("#divInfoApeCasa").append(garagem);

            $("#sltQuarto").parent().dropdown({
                on: 'hover'
            })


            $("#sltBanheiro").parent().dropdown({
                on: 'hover'
            })


            $("#sltSuite").parent().dropdown({
                on: 'hover'
            })


            $("#sltGaragem").parent().dropdown({
                on: 'hover'
            })

        }
        //se o tipo escolhido for sala comercial, carrega os campos basicos: banheiro e garagem
        else if ($("#sltTipo").val() == "4") {

            var banheiro = "<div class='four wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
            var garagem = "<div class='four wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";

            $("#divInfoApeCasa").append(banheiro);
            $("#divInfoApeCasa").append(garagem);

            $("#sltBanheiro").parent().dropdown({
                on: 'hover'
            })

            $("#sltGaragem").parent().dropdown({
                on: 'hover'
            })

        }
    })

}

function cadastrarImovel() {
    $(document).ready(function () {

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
            submitHandler: function (form) {
                form.submit();
            }
        });

    });

}

function mostrarCamposEdicaoCasa(tipoImovel,
        parametroCondicao,
        parametroArea,
        parametroQuarto,
        parametroBanheiro,
        parametroSuite,
        parametroGaragem) {
    $(document).ready(function () {
        exibirDiferencialEdicao();
        preco();
        $("#divAndares").hide();
        $("#divAndar").hide();
        $("#divUnidadesAndar").hide();
        $("#divNumeroTorres").hide();

        $("#sltAndares").rules("remove");

        $("#sltAndar").rules("remove");

        var condicao = "<div class='four wide required field' id='divCondicao'>\n\
                             <label>Condição</label><div class='ui selection dropdown'>\n\
                             <input type='hidden' name='sltCondicao' id='sltCondicao' value='" + parametroCondicao + "'> \n\
                             <div class='default text'>Condição</div> \n\
                             <i class='dropdown icon'></i>\n\
                             <div class='menu'>\n\
                             <div class='item' data-value='novo'>Novo</div>\n\
                             <div class='item' data-value='usado'>Usado</div>\n\
                             </div> \n\
                             </div> </div>";

        var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área (m<sup>2</sup>)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='" + parametroArea + "'>\n\
                        </div></div>";

        $("#divInfoBasicas").append(condicao);
        $("#divInfoBasicas").append(area);

        campos(parametroQuarto,
                parametroBanheiro,
                parametroSuite,
                parametroGaragem,
                null);

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

    })
}

function mostrarCamposEdicaoApartamento(tipoImovel,
        parametroCondicao,
        parametroArea,
        parametroQuarto,
        parametroBanheiro,
        parametroSuite,
        parametroGaragem,
        parametroCondominio) {

    $(document).ready(function () {

        exibirDiferencialEdicao();
        preco();
        $("#divNumeroPlantas").hide();
        $("#divAndares").hide();
        $("#divAndar").show();
        $("#divUnidadesAndar").show();
        $("#divNumeroTorres").hide();

        $("#sltAndares").rules("remove");

        var condicao = "<div class='four wide required field' id='divCondicao'>\n\
                             <label>Condição</label><div class='ui selection dropdown'>\n\
                             <input type='hidden' name='sltCondicao' id='sltCondicao' value='" + parametroCondicao + "'> \n\
                             <div class='default text'>Condição</div> \n\
                             <i class='dropdown icon'></i>\n\
                             <div class='menu'>\n\
                             <div class='item' data-value='novo'>Novo</div>\n\
                             <div class='item' data-value='usado'>Usado</div>\n\
                             </div> \n\
                             </div> </div>";

        var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área (m<sup>2</sup>)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='" + parametroArea + "'>\n\
                        </div></div>";

        campos(parametroQuarto,
                parametroBanheiro,
                parametroSuite,
                parametroGaragem,
                null);


        var condominio = "<div class='three wide field'>\n\
                                <div class='field'><label>Condominio(R$)</label>\n\
                                <input type='text' name='txtCondominio' id='txtCondominio' value='" + parametroCondominio + "'>\n\
                            </div></div>";

        $("#divInfoBasicas").append(condicao);
        $("#divInfoBasicas").append(area);
        $("#divApartamento").append(condominio);

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

    })
}

function mostrarDiferencialPlantas(idPlanta, contador){
    
    contador = contador + 1;
    
    $(document).ready(function () {
        
        $.ajax({
                url: "index.php",
                type: "POST",
                dataType: "json",
                data: {
                    hdnEntidade: "TipoImovelDiferencial",
                    hdnAcao: "buscarDiferencialPlantaChkEdicao",
                    idPlanta: $('#idPlanta'+idPlanta).val(),
                    contador: contador
                },
                success: function (resposta) {
                    
                    for (var i = 0; i < resposta.Diferenciais.length; i++) { 

                        for (var key in resposta.Diferenciais[i]) { 

                        var respostaTotal = "<div class='ui checkbox'>\n\
                                            <input type='checkbox' id='chkDiferencialPlanta"+ (resposta.contador) +"' name='chkDiferencialPlanta"+ (resposta.contador) +"[]' \n\
                                                value='"+ key+"'\n\
                                                "+ ((resposta.selecionar[key])?" checked ": "") +">\n\
                                            <label id='diferencialPlanta"+ (resposta.contador) +"' style='margin-right: 10px;'>"+ resposta.Diferenciais[i][key]+"\
                                            </label> &nbsp;</div>";

                        }

                        $("#divInsereDiferencialPlanta"+$('#idPlanta'+idPlanta).val()).append(respostaTotal);
                        $('.ui.checkbox').checkbox();

                    }
                    
                    
                    
                    
                    //$('#divInsereDiferencialPlanta'+idPlanta).html(resposta);
                    //$('.ui.checkbox')
                            //.checkbox();
                }
            })
        
    })
    
    //}
}

function mostrarCamposEdicaoApartamentoPlanta(tipoImovel,
        parametroTotalUnidades,
        parametroNumeroPlantas) {

    $(document).ready(function () {
        exibirDiferencialEdicao();
        preco();
        $("#divAndar").hide();
        $("#divAndares").show();
        $("#divUnidadesAndar").show();

        var totalUnidades = "<div class='three wide field' id='divUnidadesTotal'>\n\
                                    <div class='field'><label>Total de Unidades</label>\n\
                                    <input type='text' name='txtTotalUnidades' id='txtTotalUnidades' placeholder='Total de Apartamentos' maxlength='3' value = '" + parametroTotalUnidades + "'>\n\
                                </div></div>";


        var numeroPlantas = "<label>Número de Plantas</label>\n\
                                 <div> " + parametroNumeroPlantas + " </div>";

        $("#divApartamento").append(totalUnidades);
        $("#divNumeroPlantas").append(numeroPlantas);

        campos( null,
                null,
                null,
                null,
                null,
                null);

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

    })
}

function mostrarCamposEdicaoSalaComercial(tipoImovel,
        parametroCondicao,
        parametroArea,
        parametroBanheiro,
        parametroGaragem,
        parametroCondominio) {
    $(document).ready(function () {
        exibirDiferencialEdicao();
        preco();
        $("#divNumeroPlantas").hide();
        $("#divAndares").hide();
        $("#divAndar").hide();
        $("#divUnidadesAndar").hide();
        $("#divNumeroTorres").hide();

        $("#sltAndares").rules("remove");

        var condicao = "<div class='four wide required field' id='divCondicao'>\n\
                             <label>Condição</label><div class='ui selection dropdown'>\n\
                             <input type='hidden' name='sltCondicao' id='sltCondicao' value='" + parametroCondicao + "'> \n\
                             <div class='default text'>Condição</div> \n\
                             <i class='dropdown icon'></i>\n\
                             <div class='menu'>\n\
                             <div class='item' data-value='novo'>Novo</div>\n\
                             <div class='item' data-value='usado'>Usado</div>\n\
                             </div> \n\
                             </div> </div>";

        var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área (m<sup>2</sup>)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='" + parametroArea + "'>\n\
                        </div></div>";

        campos(null, parametroBanheiro, null, parametroGaragem, null);


        var condominio = "<div class='three wide field'>\n\
                                <div class='field'><label>Condominio (R$)</label>\n\
                                <input type='text' name='txtCondominio' id='txtCondominio' value='" + parametroCondominio + "'>\n\
                            </div></div>";

        $("#divInfoBasicas").append(condicao);
        $("#divInfoBasicas").append(area);
        $("#divApartamento").append(condominio);

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
    })
}

function mostrarCamposEdicaoPredioComercial(tipoImovel, parametroArea) {
    $(document).ready(function () {
        exibirDiferencialEdicao();
        preco();
        $("#divNumeroPlantas").hide();
        $("#divAndares").hide();
        $("#divAndar").hide();
        $("#divUnidadesAndar").hide();
        $("#divCondicao").hide();
        $("#divNumeroTorres").hide();

        $("#sltAndares").rules("remove");

        var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área (m<sup>2</sup>)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='" + parametroArea + "'>\n\
                        </div></div>";

        $("#divInfoBasicas").append(area);

    })
}

function mostrarCamposEdicaoTerreno(tipoImovel, parametroArea) {
    $(document).ready(function () {
        exibirDiferencialEdicao();
        preco();
        $("#divNumeroPlantas").hide();
        $("#divAndares").hide();
        $("#divAndar").hide();
        $("#divUnidadesAndar").hide();
        $("#divNumeroTorres").hide();

        $("#sltAndares").rules("remove");

        var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área (m<sup>2</sup>)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='" + parametroArea + "'>\n\
                        </div></div>";

        $("#divInfoBasicas").append(area);

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
    })
}

function mostrarPlantas(
        parametroId,
        parametroOrdem,
        parametroTituloPlanta,
        parametroQuarto,
        parametroBanheiro,
        parametroSuite,
        parametroGaragem,
        parametroArea) {
    $(document).ready(function () {

        var tituloPlanta = "<div class='fields'>\n\
                                <div class='ten wide field'>\n\
                                     <div id='divNomePlantas' class='required field'>\n\
                                        <label>Planta " + (parametroOrdem+1) + ": </label>\n\
                                        <input type='text' name='txtPlanta[]' id='txtPlanta" + parametroOrdem + "' maxlength='80' value = '"+parametroTituloPlanta+"'>\n\
                                        </div></div></div>";
        $('#divInfoApeCasa').append(tituloPlanta);
        $('#txtPlanta' + parametroOrdem).maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        camposPlantas(parametroId, parametroQuarto, parametroBanheiro, parametroSuite, parametroGaragem, parametroArea, parametroOrdem);

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

        $('#txtArea' + parametroOrdem).priceFormat({
            prefix: ' ',
            centsSeparator: '.',
            thousandsSeparator: '.',
            limit: 6
        });

    })
}

function campos(parametroQuarto,
        parametroBanheiro,
        parametroSuite,
        parametroGaragem,
        parametroArea) {
    var quarto = "<div class='four wide required field' id='divQuarto'><label>Quarto(s)</label>\n\
                            <div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltQuarto' id='sltQuarto' value='" + parametroQuarto + "'>\n\
                            <div class='default text'>Quarto(s)</div><i class='dropdown icon'></i>\n\
                            <div class='menu'>\n\
                                <div class='item' data-value='1'>1</div>\n\
                                <div class='item' data-value='2'>2</div>\n\
                                <div class='item' data-value='3'>3</div>\n\
                                <div class='item' data-value='4'>4</div>\n\
                                <div class='item' data-value='5'>5 ou mais</div>\n\
                            </div></div></div>";
    var banheiro = "<div class='four wide required field' id='divBanheiro'>\n\
                                <label>Banheiro(s)</label><div class='ui selection dropdown'>\n\
                                <input type='hidden' name='sltBanheiro' id='sltBanheiro' value='" + parametroBanheiro + "'>\n\
                                <div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i>\n\
                                <div class='menu'>\n\
                                <div class='item' data-value='1'>1</div>\n\
                                <div class='item' data-value='2'>2</div>\n\
                                <div class='item' data-value='3'>3</div>\n\
                                <div class='item' data-value='4'>4</div>\n\
                                <div class='item' data-value='5'>5 ou mais</div>\n\
                            </div></div></div>";
    var suite = "<div class='four wide required field' id='divSuite'>\n\
                            <label>Suite(s)</label><div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltSuite' id='sltSuite' value='" + parametroSuite + "'>\n\
                            <div class='default text'>Suite(s)</div><i class='dropdown icon'></i>\n\
                            <div class='menu'><div class='item' data-value='0'>nenhuma</div>\n\
                            <div class='item' data-value='1'>1</div>\n\
                            <div class='item' data-value='2'>2</div>\n\
                            <div class='item' data-value='3'>3</div>\n\
                            <div class='item' data-value='4'>4</div>\n\
                            <div class='item' data-value='5'>5 ou mais</div>\n\
                            </div></div></div>";

    var garagem = "<div class='four wide required field' id='divGaragem'><label>Vagas de Garagem</label>\n\
                            <div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltGaragem' id='sltGaragem' value='" + parametroGaragem + "'>\n\
                            <div class='default text'>Vaga(s) de Garagem</div>\n\
                            <i class='dropdown icon'></i><div class='menu'>\n\
                            <div class='item' data-value='0'>nenhuma</div>\n\
                            <div class='item' data-value='1'>1</div>\n\
                            <div class='item' data-value='2'>2</div>\n\
                            <div class='item' data-value='3'>3</div>\n\
                            <div class='item' data-value='4'>4</div>\n\
                            <div class='item' data-value='5'>5 ou mais</div>\n\
                           </div></div></div>";
    /*
     var area = "<div id='divArea' class='three wide field'>\n\
     <div class='field'><label>Área(m<sup>2</sup>)</label>\n\
     <input type='text' name='txtArea[]' id='txtArea' placeholder='Informe a Área' maxlength='7' value='" + parametroArea + "'>\n\
     </div></div>";*/

    if (parametroQuarto !== null) {
        $("#divInfoApeCasa").append(quarto);
    } else if ($("#divQuarto")) {
        $("#divQuarto").remove();
    }

    if (parametroBanheiro !== null) {
        $("#divInfoApeCasa").append(banheiro);
    } else if ($("#divBanheiro")) {
        $("#divBanheiro").remove();
    }

    if (parametroSuite !== null) {
        $("#divInfoApeCasa").append(suite);
    } else if ($("#divSuite")) {
        $("#divSuite").remove();
    }

    if (parametroGaragem !== null) {
        $("#divInfoApeCasa").append(garagem);
    } else if ($("#divGaragem")) {
        $("#divGaragem").remove();
    }

    if (parametroArea !== null) {
        $("#divInfoApeCasa").append(area);
    }
}


function camposPlantas(
        parametroId,
        parametroQuarto,
        parametroBanheiro,
        parametroSuite,
        parametroGaragem,
        parametroArea,
        parametroOrdem) {
    var quarto = "<div class='three wide required field' id='divQuarto'><label>Quarto(s)</label>\n\
                            <div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltQuarto[]' id='sltQuarto" + parametroOrdem + "' value='" + parametroQuarto + "'>\n\
                            <div class='default text'>Quarto(s)</div><i class='dropdown icon'></i>\n\
                            <div class='menu'>\n\
                                <div class='item' data-value='1'>1</div>\n\
                                <div class='item' data-value='2'>2</div>\n\
                                <div class='item' data-value='3'>3</div>\n\
                                <div class='item' data-value='4'>4</div>\n\
                                <div class='item' data-value='5'>5 ou mais</div>\n\
                            </div></div></div>";
    var banheiro = "<div class='three wide required field' id='divBanheiro'>\n\
                                <label>Banheiro(s)</label><div class='ui selection dropdown'>\n\
                                <input type='hidden' name='sltBanheiro[]' id='sltBanheiro" + parametroOrdem + "' value='" + parametroBanheiro + "'>\n\
                                <div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i>\n\
                                <div class='menu'>\n\
                                <div class='item' data-value='1'>1</div>\n\
                                <div class='item' data-value='2'>2</div>\n\
                                <div class='item' data-value='3'>3</div>\n\
                                <div class='item' data-value='4'>4</div>\n\
                                <div class='item' data-value='5'>5 ou mais</div>\n\
                            </div></div></div>";
    var suite = "<div class='three wide required field' id='divSuite'>\n\
                            <label>Suite(s)</label><div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltSuite[]' id='sltSuite" + parametroOrdem + "' value='" + parametroSuite + "'>\n\
                            <div class='default text'>Suite(s)</div><i class='dropdown icon'></i>\n\
                            <div class='menu'><div class='item' data-value='0'>nenhuma</div>\n\
                            <div class='item' data-value='1'>1</div>\n\
                            <div class='item' data-value='2'>2</div>\n\
                            <div class='item' data-value='3'>3</div>\n\
                            <div class='item' data-value='4'>4</div>\n\
                            <div class='item' data-value='5'>5 ou mais</div>\n\
                            </div></div></div>";
    var garagem = "<div class='three wide required field' id='divGaragem'><label>Vagas de Garagem</label>\n\
                            <div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltGaragem[]' id='sltGaragem" + parametroOrdem + "' value='" + parametroGaragem + "'>\n\
                            <div class='default text'>Vaga(s) de Garagem</div>\n\
                            <i class='dropdown icon'></i><div class='menu'>\n\
                            <div class='item' data-value='0'>nenhuma</div>\n\
                            <div class='item' data-value='1'>1</div>\n\
                            <div class='item' data-value='2'>2</div>\n\
                            <div class='item' data-value='3'>3</div>\n\
                            <div class='item' data-value='4'>4</div>\n\
                            <div class='item' data-value='5'>5 ou mais</div>\n\
                           </div></div></div>";

    var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área (m<sup>2</sup>)</label>\n\
                             <input type='text' name='txtArea[]' id='txtArea" + parametroOrdem + "' placeholder='Informe a Área' maxlength='7' value='" + parametroArea + "'>\n\
                        </div></div>";
    
    var planta = "<input type='hidden' name='idPlanta[]' id='idPlanta" + parametroId + "' value=" + parametroId + ">";
    
    var divDiferencialPlanta = "<div class='fields'><div class='field' id='divDiferencialPlanta" + parametroId + "' name='divDiferencialPlanta[]' value='" + parametroId + "'><div id='divInsereDiferencialPlanta" + parametroId + "'></div></div></div>";
    
    var appendi = "";
    if (parametroQuarto !== null) {
        appendi += quarto;
    } else if ($("#divQuarto")) {
        $("#divQuarto").remove();
    }

    if (parametroBanheiro !== null) {
        appendi += banheiro;
    } else if ($("#divBanheiro")) {
        $("#divBanheiro").remove();
    }

    if (parametroSuite !== null) {
        appendi += suite;
    } else if ($("#divSuite")) {
        $("#divSuite").remove();
    }

    if (parametroGaragem !== null) {
        appendi += garagem;
    } else if ($("#divGaragem")) {
        $("#divGaragem").remove();
    }

    if (parametroArea !== null) {
        appendi += area;
    } else if ($("#divArea")) {
        $("#divArea").remove();
    }
    
    appendi += planta;
    
    $("#divInfoApeCasa").append("<div class='fields'>"+appendi+"</div>"+divDiferencialPlanta+"<div class='ui hidden divider'></div>");
      
}

function confirmarCadastroImovel() {
    $(document).ready(function () {
        $('#btnCadastrar').click(function () {
            if ($("#form").valid()) {
                if ($("#hdnCEP").val() != "") {

                    carregaDadosModalImovel($("#textoConfirmacao"));
                    $('#modalConfirmar').modal({
                        closable: true,
                        transition: "fade up",
                        onDeny: function () {
                            return true;
                        },
                        onApprove: function () {
                            $("#form").submit();
                        }
                    }).modal('show');
                } else {
                    $("#msgCEP").html(criarAlerta("red", "<i class=\"red warning sign icon\"></i> \n\
                   Primeiro fa&ccedil;a a busca do CEP"));
                }
            }
        })
    })
}

function carregaDadosModalImovel($div) {
    $(document).ready(function () {
        $div.html("");

        var descricao;
        var area; //utilizada quando o imóvel não for do tipo apartamentoPlanta

        if ($("#txtDescricao").val() == "") {
            descricao = "<h4 class='ui red header'>Não Informado</h4>";
        } else
            descricao = $("#txtDescricao").val();
        if ($("#txtArea").val() == "") {
            area = "<h4 class='ui red header'>Não Informado</h4>";
        } else
            area = $("#txtArea").val();

        $div.append("<div class='ui horizontal list'>\n\
                            <div class='item'>\n\
                            <div class='content'>\n\
                            <div class='header'>Tipo</div>" + tipoImovel($("#sltTipo").val()) + "</div>\n\
                            </div><div class='item'>\n\
                            <div class='content'><div class='header'>Descrição</div>" + descricao + "\
                            </div></div>\n\
                    </div>\n\
                    <div class='ui hidden divider'></div>");

        //diferencial
        var diferencial;
        var totalDiferencial = $('input[type=checkbox]:checked').not('input[id^=chkDiferencialPlanta]').length;

        if (totalDiferencial == 0) {

            $div.append("<div class='ui horizontal list'>\n\
                                        <div class='item'>\n\
                                        <div class='content'>\n\
                                        <div class='header'>Diferenciais</div><h4 class='ui red header'>Não Informado</h4></div>\n\
                                        </div>\n\
                                </div>\n\
                <div class='ui hidden divider'></div>");
        } else {

            //transforma os elementos do checkbox em um array
            var arr = [];
            $("input[type^='checkbox']:checked").not('input[name^="chkDiferencialPlanta"]').parent().find("#diferencial").each(function ()
            {
                arr.push($(this).html().trim());
            });

            //retira a vírgula do último elemento
            var diferenciais = arr.join(", ");

            $div.append("<div class='ui horizontal list'>\n\
                                        <div class='item'>\n\
                                        <div class='content'>\n\
                                        <div class='header'>Diferenciais do Empreendimento </div>" + diferenciais + "</div>\n\
                         </div>\n\
                         </div>\n\
            <div class='ui hidden divider'></div>");

        }

        //fim do diferencial

        switch ($("#sltTipo").val()) {
            case "1":
                $div.append("<div class='ui horizontal list'>\n\
                            <div class='item'>\n\
                            <div class='content'>\n\
                            <div class='header'>Condição</div>" + $("#sltCondicao").val() + "</div>\n\
                            </div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Quarto</div>" + $("#sltQuarto").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Vaga(s) de Garagem</div>" + $("#sltGaragem").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Banheiro(s)</div>" + $("#sltBanheiro").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Suite(s)</div>" + $("#sltSuite").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Área m<SUP>2</SUP></div>" + area + "\
                            </div></div>\n\
                    </div>\n\
                    <div class='ui hidden divider'></div>");

                break;

            case "2":

                $div.append("<div class='ui horizontal list'>\n\
                            <div class='item'>\n\
                            <div class='content'>\n\
                            <div class='header'>Nº de Plantas</div>" + $("#sltNumeroPlantas").val() + "</div>\n\
                            </div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Andares do Prédio</div>" + $("#sltAndares").val() + "</div>\n\
                            </div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Unidades por Andar</div>" + $("#sltUnidadesAndar").val() + "</div>\n\
                            </div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Número de Torres</div>" + $("#sltNumeroTorres").val() + "</div>\n\
                            </div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Total de Unidades</div>" + $("#txtTotalUnidades").val() + "</div>\n\
                            </div>\n\
                    </div>\n\
                    <div class='ui hidden divider'></div>");

                $div.append("<div class='ui hidden divider'></div>\n\
                        <div class='ui horizontal list'>\n\
                            <div class='item'><div class='content'>\n\
                            <div class='header'>Planta(s)</div></div>\n\
                            </div></div>");

                var linhas = "";
                var areaPlanta;
                
                //var numero = $("input[name^='chkDiferencialPlanta']:checked").parent().size();
                
                //var temp = [];
                
                //for(var a = 1; a <= numero; a++){
                
                    //var nomeDaVariavel = "chkDiferencialPlanta" + (valor+1); 


                    //var inputDiferencial = $("label[id='"+diferencialPlanta+"']").val();


                    
                    //retira a vírgula do último elemento
                
                //}
                
                
                for (var valor = 0; valor < $("#sltNumeroPlantas").val(); valor++) {
                    
                    //$("#diferencialPlanta").attr("id", "diferencialPlanta" + valor);    
                    
                    var arr = [];
                    
                    $("input[type^='checkbox']:checked").parent().find("#diferencialPlanta"+(valor+1)).each(function ()
                    {
                           arr.push($(this).html().trim());
                    });

                    var diferencialPlanta = arr.join(", ");
                    
       
                    var quarto = $($("input[name^='sltQuarto']")[valor]).val();
                    var banheiro = $($("input[name^='sltBanheiro']")[valor]).val();
                    var suite = $($("input[name^='sltSuite']")[valor]).val();
                    var garagem = $($("input[name^='sltGaragem']")[valor]).val();
                    if ($($("input[name^='txtArea[]']")[valor]).val() == "") {
                        areaPlanta = "<h4 class='ui red header'>Não Informado</h4>";
                    } else
                        areaPlanta = $($("input[name^='txtArea[]']")[valor]).val();

                    linhas = linhas + "<tr><td>" + quarto + "</td><td>" + banheiro + "</td><td>" + suite + "</td><td>" + garagem + "</td><td>" + areaPlanta + "</td><td>" + diferencialPlanta + "</td></tr>";
                }
                $div.append("<table class='ui table'>\n\
                        <thead><tr>\n\
                        <th>Quarto(s)</th>\n\
                        <th>Banheiro(s)</th>\n\
                        <th>Suite(s)</th> \n\
                        <th>Vaga(s) de Garagem</th> \n\
                        <th>Area m<SUP>2</SUP></th> \n\
                        <th>Diferencial da Planta</SUP></th> \n\
                        </tr>\n\
                        </thead> \n\
                    <tbody>" + linhas + "</tbody></table>");

                break;

            case "3":

                $div.append("<div class='ui horizontal list'>\n\
                            <div class='item'>\n\
                            <div class='content'>\n\
                            <div class='header'>Condição</div>" + $("#sltCondicao").val() + "</div>\n\
                            </div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Quarto</div>" + $("#sltQuarto").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Vaga(s) de Garagem</div>" + $("#sltGaragem").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Banheiro(s)</div>" + $("#sltBanheiro").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Suite(s)</div>" + $("#sltSuite").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Andar do Apartamento</div>" + $("#sltAndar").val() + "\
                            </div></div>\n\\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Apartamentos por Andar</div>" + $("#sltUnidadesAndar").val() + "\
                            </div></div>\n\\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Área m<SUP>2</SUP></div>" + area + "\
                            </div></div>\n\
                    </div>\n\
                    <div class='ui hidden divider'></div>");
                break;
            case "4":
                $div.append("<div class='ui horizontal list'>\n\
                            <div class='item'>\n\
                            <div class='content'>\n\
                            <div class='header'>Condição</div>" + $("#sltCondicao").val() + "</div>\n\
                            </div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Quarto</div>" + $("#sltQuarto").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Vaga(s) de Garagem</div>" + $("#sltGaragem").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Banheiro(s)</div>" + $("#sltBanheiro").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Suite(s)</div>" + $("#sltSuite").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Condominio</div>" + $("#txtCondominio").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Área m<SUP>2</SUP></div>" + area + "\
                            </div></div>\n\
                    </div>\n\
                    <div class='ui hidden divider'></div>");
                break;
            case "5":
            case "6":

                $div.append("<div class='ui horizontal list'>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Área m<SUP>2</SUP></div>" + area + "\
                            </div></div>\n\
                            </div>\n\
                    <div class='ui hidden divider'></div>");

                break;

        }

        var endereco;
        if ($("#txtNumero").val() !== "" && $("#txtComplemento").val() !== "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtNumero").val() + ", " + $("#txtComplemento").val();
        } else if ($("#txtNumero").val() !== "" && $("#txtComplemento").val() === "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtNumero").val();
        } else if ($("#txtNumero").val() === "" && $("#txtComplemento").val() === "") {
            endereco = $("#txtLogradouro").val();
        } else if ($("#txtNumero").val() === "" && $("#txtComplemento").val() !== "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtComplemento").val();
        }

        $div.append("<div class='ui dividing header'></div>\n\
                     <div class='ui horizontal list'>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Endereço</div>" + endereco + "</div>\n\
                     </div></div>");

    })
}

function preco() {

    $(document).ready(function () {
        $('#txtCondominio').priceFormat({
            prefix: ' ',
            centsSeparator: '',
            thousandsSeparator: '',
            limit: 6
        });

        $('#txtArea').priceFormat({
            prefix: ' ',
            centsSeparator: '.',
            thousandsSeparator: '.',
            limit: 7
        });
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
        $('#txtComplemento').maxlength({
            alwaysShow: true,
            threshold: 80,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
            
        });
        
        $("#txtTotalUnidades").mask("000");
    })
}

function exibirDiferencialEdicao() {
    $.ajax({
        url: "index.php",
        type: "POST",
        data: {
            hdnEntidade: "TipoImovelDiferencial",
            hdnAcao: "buscarDiferencialChkEdicao",
            sltTipo: $('#sltTipo').val()
        },
        success: function (resposta) {
            $('#chkDiferencial').html(resposta);
            $('.ui.checkbox').checkbox();
        }
    })
}

function tipoImovel(tipo) {
    switch (tipo) {
        case "1":
            return  " CASA ";
            break;
        case "2":
            return " APARTAMENTO NA PLANTA ";
            break;
        case "3":
            return " APARTAMENTO ";
            break;
        case "4":
            return " SALA COMERCIAL ";
            break;
        case "5":
            return " PRÉDIO COMERCIAL ";
            break;
        case "6":
            return " TERRENO ";
            break;
    }
}

function formExcluirImovel(imovel, token, tipo) {
    $(document).ready(function () {
        $('.coupled.modal').modal({
            allowMultiple: false
        });
        $("#hdnImovel").val(imovel);
        $("#hdnToken").val(token);
        $('.first.modal .description').html('<h3 class="ui center aligned header">Confirmar a exclusão do imóvel ' + tipo + '?</h3>');
        $('.second.modal').modal({
            closable: false,
            onApprove: function () {
                window.location.reload();
                ;
            }
        });
        $('.first.modal').modal('attach events', '.first.modal .orange', 'hide');
        $('.first.modal').modal('show');
        console.log('formExcluirImovel');
    })
}

function excluirImovel() {
    $(document).ready(function () {
        console.log('excluirImovel');
        console.log($('#form'));
        $.ajax({
            url: "index.php",
            dataType: "json",
            type: "POST",
            data: $('#form').serialize(),
            beforeSend: function () {
                $(".first.modal .content").html("<div class='ui active inverted dimmer'><div class='ui text loader'>Processando. Aguarde...</div></div>");
            },
            success: function (resposta) {
                $(".first.modal .content .dimmer").remove();
                $("#hdnImovel").val("");
                $("#hdnToken").val("");
                if (resposta.resultado == 1) {
                    $('.second.modal').modal('show');
                    $('.second.modal .content').html('<div class="ui positive message"><div class="header">Exclusão realizada com sucesso!</div></div>');

                } else {
                    $('.second.modal .content').html('<div class="ui negative message"><div class="header">Houve um erro na exclusão!</div></div>');
                }
            }
        })
    })
}