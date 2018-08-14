function esconderCamposInicio() {
    $(document).ready(function () {
        preco();
        $("#sltTipo").val('');//limpar o valor do campo tipo de imovel
        $('.ui.dropdown')
                .dropdown({
                    //on: 'hover'
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
            $("#txtLogradouro").rules("add", {
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
                $("#divDiferencial").show();
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
                $("#divDiferencial").show();
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
                $("#divDiferencial").show();
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
                    var area = "<div id='divAreaPlanta' class='four wide field'><div class='field'><label>Área (m<sup>2</sup>)</label><input type='text' name='txtArea[]' id='txtArea" + contador + "' maxlength='8' placeholder='Área'></div></div>";
                    
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

                    $('#txtArea' + contador).keyup(function() {
                        $(this).val(this.value.replace(/\D/g, ''));
                    });

                }

                $("input[name^='slt']:not('#sltTipo'):not('#sltNumeroPlantas')").parent().dropdown({
                    //on: 'hover'
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
                //on: 'hover'
            })


            $("#sltBanheiro").parent().dropdown({
                //on: 'hover'
            })


            $("#sltSuite").parent().dropdown({
                //on: 'hover'
            })


            $("#sltGaragem").parent().dropdown({
                //on: 'hover'
            })

        }
        //se o tipo escolhido for sala comercial, carrega os campos basicos: banheiro e garagem
        else if ($("#sltTipo").val() == "4") {

            var banheiro = "<div class='four wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";
            var garagem = "<div class='four wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>5 ou mais</div></div></div></div>";

            $("#divInfoApeCasa").append(banheiro);
            $("#divInfoApeCasa").append(garagem);

            $("#sltBanheiro").parent().dropdown({
                //on: 'hover'
            })

            $("#sltGaragem").parent().dropdown({
                //on: 'hover'
            })

        }
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
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='8' value='" + parametroArea + "'>\n\
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
                    //on: 'hover'
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
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='8' value='" + parametroArea + "'>\n\
                        </div></div>";

        campos(parametroQuarto,
                parametroBanheiro,
                parametroSuite,
                parametroGaragem,
                null);


        var condominio = "<div class='three wide field'>\n\
                                <div class='field'><label>Condomínio (R$)</label>\n\
                                <input type='text' name='txtCondominio' id='txtCondominio' value='" + parametroCondominio + "'>\n\
                            </div></div>";

        $("#divInfoBasicas").append(condicao);
        $("#divInfoBasicas").append(area);
        $("#divApartamento").append(condominio);

        $('.ui.dropdown')
                .dropdown({
                    //on: 'hover'
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
                    //on: 'hover'
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
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='8' value='" + parametroArea + "'>\n\
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
                    //on: 'hover'
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
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='8' value='" + parametroArea + "'>\n\
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
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='8' value='" + parametroArea + "'>\n\
                        </div></div>";

        $("#divInfoBasicas").append(area);

        $('.ui.dropdown')
                .dropdown({
                    //on: 'hover'
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
                    //on: 'hover'
                });

       $('#txtArea' + parametroOrdem).keyup(function() {
            $(this).val(this.value.replace(/\D/g, ''));
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
    
    var appendi = "";
    
    if (parametroQuarto !== null) {
        appendi += quarto;//$("#divInfoApeCasa").append(quarto);
    } else if ($("#divQuarto")) {
        $("#divQuarto").remove();
    }

    if (parametroBanheiro !== null) {
        appendi += banheiro;//$("#divInfoApeCasa").append(banheiro);
    } else if ($("#divBanheiro")) {
        $("#divBanheiro").remove();
    }

    if (parametroSuite !== null) {
        appendi += suite;//$("#divInfoApeCasa").append(suite);
    } else if ($("#divSuite")) {
        $("#divSuite").remove();
    }

    if (parametroGaragem !== null) {
        appendi += garagem;//$("#divInfoApeCasa").append(garagem);
    } else if ($("#divGaragem")) {
        $("#divGaragem").remove();
    }
 
    $("#divInfoApeCasa").append("<div class='fields'>"+appendi+"</div>");
    
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
                             <input type='text' name='txtArea[]' id='txtArea" + parametroOrdem + "' placeholder='Informe a Área' maxlength='8' value='" + parametroArea + "'>\n\
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
  
        
        if($("#sltCondicao").val() == 'novo' || $("#sltCondicao").val() == 'NOVO'){
            $("#sltCondicao").val('Novo');
        } 
        if($("#sltCondicao").val() == 'usado' || $("#sltCondicao").val() == 'USADO'){
            $("#sltCondicao").val('Usado');
        }

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
                            <div class='content'><div class='header'>Banheiro(s)</div>" + $("#sltBanheiro").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Suite(s)</div>" + $("#sltSuite").val() + "\
                            </div></div>\n\\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Vaga(s) de Garagem</div>" + $("#sltGaragem").val() + "\
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
                        <th>Diferencial da Planta</th> \n\
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
                            <div class='content'><div class='header'>Banheiro(s)</div>" + $("#sltBanheiro").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Suite(s)</div>" + $("#sltSuite").val() + "\
                            </div></div>\n\\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Vaga(s) de Garagem</div>" + $("#sltGaragem").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Andar do Apartamento</div>" + campoNaoInformado($("#sltAndar").val()) + "\
                            </div></div>\n\\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Apartamentos por Andar</div>" + campoNaoInformado($("#sltUnidadesAndar").val()) + "\
                            </div></div>\n\\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Área m<SUP>2</SUP></div>" + area + "\
                            </div></div>\n\
                        </div>\n\
                        <div class='ui horizontal list'>\n\
                            <div class='item'>\n\
                                <div class='content'><div class='header'>Condomínio</div>" + campoNaoInformado($("#txtCondominio").val()) + "\
                                </div>\n\
                            </div>\n\
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
                            <div class='content'><div class='header'>Banheiro(s)</div>" + $("#sltBanheiro").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Vaga(s) de Garagem</div>" + $("#sltGaragem").val() + "\
                            </div></div>\n\
                            <div class='item'>\n\
                            <div class='content'><div class='header'>Condominio</div>" + campoNaoInformado($("#txtCondominio").val()) + "\
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
        
        //diferencial
//        var diferencial;
        var totalDiferencial = $('input[type=checkbox]:checked').not('input[id^=chkDiferencialPlanta]').length;

        if (totalDiferencial != 0) 
        {
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
        
        var endereco;
        if ($("#txtNumero").val() !== "" && $("#txtComplemento").val() !== "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtNumero").val() + ", " + $("#sltBairro").parent().dropdown('get text'); + " - " + $("#txtComplemento").val();
        } else if ($("#txtNumero").val() !== "" && $("#txtComplemento").val() === "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtNumero").val() + " - " + $("#sltBairro").parent().dropdown('get text');;
        } else if ($("#txtNumero").val() === "" && $("#txtComplemento").val() === "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#sltBairro").parent().dropdown('get text');;
        } else if ($("#txtNumero").val() === "" && $("#txtComplemento").val() !== "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#sltBairro").parent().dropdown('get text'); + " - " + $("#txtComplemento").val();
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
            prefix: 'R$ ',
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 6
        });

        $('#txtArea').keyup(function() {
            $(this).val(this.value.replace(/\D/g, ''));
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
            return  " Casa ";
            break;
        case "2":
            return " Apartamento na Planta ";
            break;
        case "3":
            return " Apartamento ";
            break;
        case "4":
            return " Sala Comercial ";
            break;
        case "5":
            return " Prédio Comercial ";
            break;
        case "6":
            return " Terreno ";
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
        $('.first.modal .description').html('<h4 class="ui center aligned header">Confirmar a exclusão do imóvel ' + tipo + '?</h4>');
        $('.second.modal').modal({
            closable: false,
            onApprove: function () {
                window.location.reload();
                ;
            }
        });
        $('.first.modal').modal('attach events', '.first.modal .orange', 'hide');
        $('.first.modal').modal('show');
    })
}

function excluirImovel() {
    $(document).ready(function () {
       
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
                    $('.second.modal .content').html('<div class="ui positive message"><i class="big green check circle outline icon"></i>Sucesso. Exclusão realizada com sucesso</div>');

                } else {
                    $('.second.modal .content').html('<div class="ui negative message"><i class="big red remove circle outline icon"></i>Houve um erro na exclusão. Tente novamente mais tarde</div>');
                }
            }
        })
    })
}

function campoNaoInformado(campo){
    
    if(campo === "" || campo === null || campo === "0" || campo === 0){
        
      return  campo = "<h4 class='ui red header'>Não Informado</h4>";
        
    }
    
    else return campo = campo;
}

function carregarBairro(cidade, bairro) {
    $(document).ready(function () {
       
        if (cidade === 'Belém' || cidade === 'Belem') {
            $("#dropBairro").html(
                    '<label>Bairro</label>' +
                    '<div class="ui fluid search selection dropdown">' +
                    '<input type="hidden" name="itensBairro[]" id="itensBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="3"> Aeroporto </div>' +
                    '<div class="item" data-value="1"> Água Boa </div>' +
                    '<div class="item" data-value="7"> Águas Lindas </div>' +
                    '<div class="item" data-value="2"> Águas Negras </div>' +
                    '<div class="item" data-value="9"> Agulha </div>' +
                    '<div class="item" data-value="10"> Ariramba </div>' +
                    '<div class="item" data-value="11"> Atalaia </div>' +
                    '<div class="item" data-value="12"> Aurá </div>' +
                    '<div class="item" data-value="13"> Baía do Sol </div>' +
                    '<div class="item" data-value="14"> Barreiro </div>' +
                    '<div class="item" data-value="15"> Batista Campos </div>' +
                    '<div class="item" data-value="16"> Bengui </div>' +
                    '<div class="item" data-value="17"> Bonfim </div>' +
                    '<div class="item" data-value="18"> Brasília </div>' +
                    '<div class="item" data-value="19"> Cabanagem </div>' +
                    '<div class="item" data-value="20"> Campina </div>' +
                    '<div class="item" data-value="21"> Campina de Icoaraci </div>' +
                    '<div class="item" data-value="22"> Canudos </div>' +
                    '<div class="item" data-value="23"> Carananduba </div>' +
                    '<div class="item" data-value="24"> Caruara </div>' +
                    '<div class="item" data-value="25"> Castanheira </div>' +
                    '<div class="item" data-value="26"> Chapéu Virado </div>' +
                    '<div class="item" data-value="27"> Cidade Velha </div>' +
                    '<div class="item" data-value="29"> Coqueiro </div>' +
                    '<div class="item" data-value="30"> Cremação </div>' +
                    '<div class="item" data-value="31"> Cruzeiro </div>' +
                    '<div class="item" data-value="32"> Curió-Utinga </div>' +
                    '<div class="item" data-value="33"> Farol </div>' +
                    '<div class="item" data-value="34"> Fátima </div>' +
                    '<div class="item" data-value="35"> Guamá </div>' +
                    '<div class="item" data-value="36"> Guanabara </div>' +
                    '<div class="item" data-value="37"> Itaiteua </div>' +
                    '<div class="item" data-value="38"> Jurunas </div>' +
                    '<div class="item" data-value="39"> Mangueirão </div>' +
                    '<div class="item" data-value="40"> Mangueiras </div>' +
                    '<div class="item" data-value="41"> Maracacuera </div>' +
                    '<div class="item" data-value="42"> Maracajá </div>' +
                    '<div class="item" data-value="43"> Maracangalha </div>' +
                    '<div class="item" data-value="44"> Marahu </div>' +
                    '<div class="item" data-value="45"> Marambaia </div>' +
                    '<div class="item" data-value="46"> Marco </div>' +
                    '<div class="item" data-value="47"> Miramar </div>' +
                    '<div class="item" data-value="48"> Murubira </div>' +
                    '<div class="item" data-value="49"> Natal do Murubira </div>' +
                    '<div class="item" data-value="50"> Nazaré </div>' +
                    '<div class="item" data-value="51"> Outros </div>' +
                    '<div class="item" data-value="52"> Paracuri </div>' +
                    '<div class="item" data-value="53"> Paraíso </div>' +
                    '<div class="item" data-value="54"> Parque Guajará </div>' +
                    '<div class="item" data-value="55"> Parque Verde </div>' +
                    '<div class="item" data-value="56"> Pedreira </div>' +
                    '<div class="item" data-value="57"> Ponta Grossa </div>' +
                    '<div class="item" data-value="58"> Porto Arthur  </div>' +
                    '<div class="item" data-value="59"> Praia Grande  </div>' +
                    '<div class="item" data-value="60"> Pratinha  </div>' +
                    '<div class="item" data-value="61"> Reduto  </div>' +
                    '<div class="item" data-value="62"> Sacramenta  </div>' +
                    '<div class="item" data-value="63"> São Brás  </div>' +
                    '<div class="item" data-value="64"> São Clemente  </div>' +
                    '<div class="item" data-value="65"> São Francisco  </div>' +
                    '<div class="item" data-value="66"> São João do Outeiro  </div>' +
                    '<div class="item" data-value="67"> Souza  </div>' +
                    '<div class="item" data-value="68"> Sucurijuquara  </div>' +
                    '<div class="item" data-value="69"> Tapanã  </div>' +
                    '<div class="item" data-value="70"> Telégrafo Sem Fio  </div>' +
                    '<div class="item" data-value="71"> Tenoné  </div>' +
                    '<div class="item" data-value="72"> Terra Firme  </div>' +
                    '<div class="item" data-value="73"> Umarizal  </div>' +
                    '<div class="item" data-value="74"> Una  </div>' +
                    '<div class="item" data-value="75"> Universitário  </div>' +
                    '<div class="item" data-value="76"> Val-de-Cães  </div>' +
                    '<div class="item" data-value="77"> Vila  </div>' +
                    '</div>' +
                    '</div>'
                    );
        }
        if (cidade === 'Ananindeua') {
            $("#dropBairro").html(
                    '<label>Bairro</label>' +
                    '<div class="ui fluid search selection dropdown">' +
                    '<input type="hidden" name="itensBairro[]" id="itensBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="78"> 40 horas </div>' +
                    '<div class="item" data-value="79"> Águas Brancas </div>' +
                    '<div class="item" data-value="81"> Atalaia </div>' +
                    '<div class="item" data-value="82"> Aurá </div>' +
                    '<div class="item" data-value="83"> Cajuí </div>' +
                    '<div class="item" data-value="84"> Centro </div>' +
                    '<div class="item" data-value="85"> Cidade Nova </div>' +
                    '<div class="item" data-value="86"> Coqueiro </div>' +
                    '<div class="item" data-value="87"> Curuçambá </div>' +
                    '<div class="item" data-value="88"> Distrito Industrial </div>' +
                    '<div class="item" data-value="89"> Dom Bosco </div>' +
                    '<div class="item" data-value="90"> Dona Ana </div>' +
                    '<div class="item" data-value="91"> Guajará </div>' +
                    '<div class="item" data-value="92"> Guanabara </div>' +
                    '<div class="item" data-value="93"> Heliolândia </div>' +
                    '<div class="item" data-value="94"> Icuí </div>' +
                    '<div class="item" data-value="95"> Jaderlândia </div>' +
                    '<div class="item" data-value="96"> Jibóia Branca </div>' +
                    '<div class="item" data-value="97"> Júlia Seffer </div>' +
                    '<div class="item" data-value="98"> Laranjeira </div>' +
                    '<div class="item" data-value="99"> Maguari </div>' +
                    '<div class="item" data-value="100"> Paar </div>' +
                    '<div class="item" data-value="101"> Providência </div>' +
                    '<div class="item" data-value="102"> Samambaia </div>' +
                    '<div class="item" data-value="103"> Santana do Aurá </div>' +
                    '</div>' +
                    '</div>'
                    );
        }

        if (cidade === 'Marituba') {
            $("#dropBairro").html(
                    '<label>Bairro</label>' +
                    '<div class="ui fluid search selection dropdown">' +
                    '<input type="hidden" name="itensBairro[]" id="itensBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="115"> Almir Gabriel </div>' +
                    '<div class="item" data-value="114"> Beira Rio </div>' +
                    '<div class="item" data-value="116"> Bela Vista </div>' +
                    '<div class="item" data-value="106"> Centro </div>' +
                    '<div class="item" data-value="113"> Decouville </div>' +
                    '<div class="item" data-value="109"> Dom Aristides </div>' +
                    '<div class="item" data-value="112"> Nossa Senhora da Paz </div>' +
                    '<div class="item" data-value="107"> Pedreirinha </div>' +
                    '<div class="item" data-value="117"> Riacho Doce </div>' +
                    '<div class="item" data-value="110"> São Francisco </div>' +
                    '<div class="item" data-value="104"> São João </div>' +
                    '<div class="item" data-value="108"> São José </div>' +
                    '<div class="item" data-value="111"> União </div>' +
                    '<div class="item" data-value="105"> Uriboca </div>' +
                    '</div>' +
                    '</div>'
                    );
        }
        if (cidade === 'Benevides') {
            $("#dropBairro").html(
                    '<label>Bairro</label>' +
                    '<div class="ui fluid search selection dropdown">' +
                    '<input type="hidden" name="itensBairro[]" id="itensBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="121"> Campestre </div>' +
                    '<div class="item" data-value="122"> Canutama </div>' +
                    '<div class="item" data-value="123"> Centro </div>' +
                    '<div class="item" data-value="124"> Cajueiro </div>' +
                    '<div class="item" data-value="125"> Duque de Caxias </div>' +
                    '<div class="item" data-value="126"> Flores </div>' +
                    '<div class="item" data-value="127"> Neópolis </div>' +
                    '<div class="item" data-value="128"> Madre Teresa </div>' +
                    '<div class="item" data-value="129"> Presidente Médici </div>' +
                    '<div class="item" data-value="130"> Independente </div>' +
                    '<div class="item" data-value="131"> Santos Dumont </div>' +
                    '<div class="item" data-value="132"> Novo Bairro </div>' +
                    '<div class="item" data-value="133"> Santa Rosa </div>' +
                    '<div class="item" data-value="134"> Maguari </div>' +
                    '</div>' +
                    '</div>'
                    );
        }
        if (cidade === 'Castanhal') {
            $("#dropBairro").html(
                    '<label>Bairro</label>' +
                    '<div class="ui fluid search selection dropdown">' +
                    '<input type="hidden" name="itensBairro[]" id="itensBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="136"> Bairro Novo </div>' +			
                    '<div class="item" data-value="137"> Betânia </div>' +
                    '<div class="item" data-value="138"> Bom Jesus </div>' +
                    '<div class="item" data-value="139"> Caiçara </div>' +
                    '<div class="item" data-value="140"> Cariri </div>' +
                    '<div class="item" data-value="141"> Centro </div>' +
                    '<div class="item" data-value="142"> Cohab </div>' +
                    '<div class="item" data-value="143"> Conjuntos Ypês </div>' +
                    '<div class="item" data-value="144"> Cristo </div>' +
                    '<div class="item" data-value="145"> Estrela </div>' +
                    '<div class="item" data-value="146"> Florestal </div>' +
                    '<div class="item" data-value="147"> Fonte Boa </div>' +
                    '<div class="item" data-value="148"> Heliolândia </div>' +
                    '<div class="item" data-value="149"> Ianetama </div>' +			
                    '<div class="item" data-value="150"> Imperador </div>' +
                    '<div class="item" data-value="151"> Imperial </div>' +
                    '<div class="item" data-value="152"> Jaderlândia </div>' +
                    '<div class="item" data-value="153"> Jardim das Acácias </div>' +
                    '<div class="item" data-value="154"> Jardim Castanhal </div>' +
                    '<div class="item" data-value="155"> Jardim das Flores </div>' +
                    '<div class="item" data-value="156"> Nova Olinda </div>' +
                    '<div class="item" data-value="157"> Novo Caiçara </div>' +
                    '<div class="item" data-value="158"> Novo Estrela </div>' +
                    '<div class="item" data-value="159"> Pantanal </div>' +
                    '<div class="item" data-value="160"> Fonte Boa </div>' +
                    '<div class="item" data-value="161"> Pirapora </div>' +
                    '<div class="item" data-value="162"> Propira </div>' +			
                    '<div class="item" data-value="163"> Rouxinol </div>' +
                    '<div class="item" data-value="164"> Sales Jardim </div>' +
                    '<div class="item" data-value="165"> Salgadinho </div>' +
                    '<div class="item" data-value="166"> Santa Catarina </div>' +
                    '<div class="item" data-value="167"> Santa Helena </div>' +
                    '<div class="item" data-value="168"> Santa Lídia </div>' +
                    '<div class="item" data-value="169"> São José </div>' +
                    '<div class="item" data-value="170"> Saudade I </div>' +
                    '<div class="item" data-value="171"> Saudade II </div>' +
                    '<div class="item" data-value="172"> Titanlândia </div>' +
                    '<div class="item" data-value="173"> Tókio </div>' +
                    '<div class="item" data-value="174"> Vale Do Sol </div>' +
                    '<div class="item" data-value="175"> Vila do Apeú </div>' +
                    '</div>' +
                    '</div>'
                    );
        }
        
        $("#sltBairro").parent().dropdown('set selected', bairro);
        $('.ui.dropdown')
                .dropdown({
                    message: {
                        noResults: 'Nenhum resultado.'
                    }
                });
    });

}
