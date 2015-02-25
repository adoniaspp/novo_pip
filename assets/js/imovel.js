function esconderCamposInicio() {
    $(document).ready(function () {
        preco();
        $('.ui.dropdown')
                .dropdown({
            on: 'hover'
        });
     
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
       
        $("#sltTipo").rules("add", {
                    required: true
        });
        
        $("#sltTipo").change(function() {
                    $(this).valid();
        })
        
        $("#sltTipo").change(function() {
            
            
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
            
            
            $("input[id^='slt']").each(function () {
                $(this).rules("remove");
              
            });
            
            $("#txtCEP").rules("remove");
            
           $('#sltNumeroPlantas').parent().dropdown('restore defaults');
           $('#sltCondicao').parent().dropdown('restore defaults');
           $('#sltQuarto').parent().dropdown('restore defaults');
           $('#sltSuite').parent().dropdown('restore defaults');
           $('#sltBanheiro').parent().dropdown('restore defaults');
           $('#sltGaragem').parent().dropdown('restore defaults');
           $('#sltAndares').parent().dropdown('restore defaults');
           $("#txtArea").val("");
           
            mostrarArea();
            
            $("#txtCEP").rules("add", {
                    required: true
                });
                        
            if ($(this).val() == "1") { //casa
                
                $("#divInfoApeCasa").empty();
                
                mostrarDivInfoApeCasa();
                $("#divApartamento").hide();  
                $("#divNumeroPlantas").hide();
                $("#divInserePlanta").hide();
                $("#divPlantaUm").hide();
                $("#divAndar").hide();
                $("#divInfoBasicas").show();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                $("#divCondicao").show(); 
                
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
                
                $("#sltCondicao").change(function() {
                    $(this).valid();
                })
                
                $("#sltQuarto").change(function() {
                    $(this).valid();
                })
                
                $("#sltSuite").change(function() {
                    $(this).valid();
                })
                
                $("#sltBanheiro").change(function() {
                    $(this).valid();
                })
                
                $("#sltGaragem").change(function() {
                    $(this).valid();
                })
                
            } else if ($(this).val() == "2"){  //apartamento na planta
                
                $("#divInfoApeCasa").empty();
                
                mostrarPlantas();
                mostrarDivInfoApeCasa() 
              
                $("#divNumeroPlantas").show();   
                $("#divAreaPlanta").show();
                $("#divNumeroTorres").show();
                $("#divAndares").show();
                $("#divUnidadesTotal").show();
                $("#divUnidadesAndar").show();
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
                
                $("#sltCondicao").rules("remove");
                
                $("#sltNumeroPlantas").rules("add", {
                    required: true
                });
                   
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
                
                $("#sltCondicao").change(function() {
                    $(this).valid();
                })
                
                $("#sltQuarto").change(function() {
                    $(this).valid();
                })
                
                $("#sltSuite").change(function() {
                    $(this).valid();
                })
                
                $("#sltBanheiro").change(function() {
                    $(this).valid();
                })
                
                $("#sltGaragem").change(function() {
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
                $("#divCondominio").show();
                $("#divDiferencial").show();
                $("#divInfoApeCasa").show();
                $("#divCondicao").show();
                $("#divDescricao").show();               
                $("#divEndereco").show(); 
                
                $("#sltCondicao").rules("add", {
                    required: true
                });
                
                $("#sltBanheiro").rules("add", {
                    required: true
                });
                
                $("#sltGaragem").rules("add", {
                    required: true
                });               
                
                $("#sltCondicao").change(function() {
                    $(this).valid();
                })
                
                $("#sltBanheiro").change(function() {
                    $(this).valid();
                })
                
                $("#sltGaragem").change(function() {
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
                $("#divDescricao").show();               
                $("#divEndereco").show(); 

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
                $("#divDescricao").show();               
                $("#divEndereco").show();

            }   
            
            
        });
     
    });
    
    function mostrarArea(){
            $("#divArea").show();
    }
    
    function mostrarPlantas(){
    $(document).ready(function () {    
        
        $("#sltNumeroPlantas").change(function() {    
        $("#divInfoApeCasa").empty();
        $(this).valid();    
        if ($(this).val() >= "1") {
            
                       
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
            
           
     /*   if(valores == 1){
            
        $("#divInfoApeCasa").empty();
        
        var plantaUm = "<div id='divNomePlantas' class='nine wide required field'> <label>Planta: </label> <input type='text' id='txtPlanta1' name='txtPlanta[]' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'>  <div class='ui hidden divider'></div> </div>";                 
        
        var quarto = "<div class='three wide required field' id='divQuarto'><label>Quarto(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltQuarto' id='sltQuarto'><div class='default text'>Quarto(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var banheiro = "<div class='three wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var suite = "<div class='three wide required field' id='divSuite'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite' id='sltSuite'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var garagem = "<div class='three wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var area = "<div id='divAreaPlanta' class='three wide field'><div class='field'><label>Área(m2)</label><input type='text' name='txtArea' id='txtArea' maxlength='7' placeholder='Informe a Área'></div></div>";

        $("#divPlantaUm").append(plantaUm);

        $("#divInfoApeCasa").append(quarto);
        $("#divInfoApeCasa").append(banheiro);
        $("#divInfoApeCasa").append(suite);
        $("#divInfoApeCasa").append(garagem);
        $("#divInfoApeCasa").append(area);
        
                
                $("#txtPlanta").rules("add", {
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
                

                $("#sltQuarto").change(function() {
                    $(this).valid();
                })
                
                $("#sltSuite").change(function() {
                    $(this).valid();
                })
                
                $("#sltBanheiro").change(function() {
                    $(this).valid();
                })
                
                $("#sltGaragem").change(function() {
                    $(this).valid();
                })
                
                $('#txtArea').priceFormat({
                prefix: ' ',
                centsSeparator: '.',
                thousandsSeparator: '.',
                limit: 6
                });
        
        $("input[name^='slt']:not('#sltTipo'):not('#sltNumeroPlantas')").parent().dropdown({
                    on: 'hover'
                })

        }*/
        
        if(valores >= 1){ //verifica se já existem divs na tela e as remove 
                
                $("#divInserePlanta").empty();
                $("#divPlantaUm").empty();

        }
        
       // if(valores >=2){ //só mostrar mais opções de planta se for maior que 2
             //$("#divPlantaUm").append("<h4>Planta 1: </h4><div id='divNomePlantas' class='nine wide field'><input type='text' name='txtPlanta[]' id='txtPlanta' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>");
            
                 for (var valor = 1 ; valor <=valores ; valor++){ //clona as divs das plantas e as adiciona
                    var $clone = $('#divInfoApeCasa').clone();
                    $clone.attr("id","divInfoApeCasa"+valor);

                 var label = "<h4>Planta "+(valor)+": </h4><div id='divNomePlantas' class='nine wide required field'><input type='text' name='txtPlanta[]' id='txtPlanta"+valor+"' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>"                 
                 
                 $('#divInserePlanta').append(label);
                 $('#divInserePlanta').append($clone);
              }
              
               for (var contador = 1 ; contador <=valores ; contador++){

                 var quarto = "<div class='three wide required field'><label>Quarto(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltQuarto[]' id='sltQuarto"+contador+"'><div class='default text'>Quarto(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var banheiro = "<div class='three wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro[]' id='sltBanheiro"+contador+"'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var suite = "<div class='three wide required field'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite[]' id='sltSuite"+contador+"'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var garagem = "<div class='three wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem[]' id='sltGaragem"+contador+"'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var area = "<div id='divAreaPlanta' class='three wide field'><div class='field'><label>Área(m2)</label><input type='text' name='txtArea[]' id='txtArea"+contador+"' maxlength='7' placeholder='Informe a Área'></div></div>";  
                 
                 $("#divInfoApeCasa"+contador).append(quarto);
                 $("#divInfoApeCasa"+contador).append(banheiro);
                 $("#divInfoApeCasa"+contador).append(suite);
                 $("#divInfoApeCasa"+contador).append(garagem);
                 $("#divInfoApeCasa"+contador).append(area);
                 
                 
                $("#sltQuarto"+contador).change(function() {
                    $(this).valid();
                })
                
                $("#sltBanheiro"+contador).change(function() {
                    $(this).valid();
                })
                
                $("#sltSuite"+contador).change(function() {
                    $(this).valid();
                })
                
                $("#sltGaragem"+contador).change(function() {
                    $(this).valid();
                })
                
                $('#txtArea'+contador).priceFormat({
                prefix: ' ',
                centsSeparator: '.',
                thousandsSeparator: '.',
                limit: 6
                });
                 
               }
             
                $("input[name^='slt']:not('#sltTipo'):not('#sltNumeroPlantas')").parent().dropdown({
                    on: 'hover'
                })
              
        // }     
       
       })
    
    }
    )}
}

function mostrarDivInfoApeCasa(){
    $(document).ready(function() {
       
        $("#divInfoApeCasa").empty();
        
       if ($("#sltTipo").val()=="1"  || $("#sltTipo").val()=="3"){
        var quarto = "<div class='three wide required field'><label>Quarto(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltQuarto' id='sltQuarto'><div class='default text'>Quarto(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var banheiro = "<div class='three wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var suite = "<div class='three wide required field'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite' id='sltSuite'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var garagem = "<div class='three wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        
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
        
        else if ($("#sltTipo").val()=="4"){
            
            
            
            var banheiro = "<div class='three wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
            var garagem = "<div class='three wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
            
            $("#divInfoApeCasa").append(banheiro);
            $("#divInfoApeCasa").append(garagem);

            $("#sltBanheiro").parent().dropdown({
             on: 'hover'
            })

            $("#sltGaragem").parent().dropdown({
             on: 'hover'
            })
        
        }
        
        else {
            $("#divInfoApeCasa").empty();
        }
       
    })

}

function cadastrarImovel(){
     $(document).ready(function() {

        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest(".error").removeClass("error").addClass("success");
            }
        });
        $.validator.messages.required = 'Campo obrigatório';
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                
                txtPlanta: {
                    required: true,
                    minlength: 5
                },
                txtArea: {
                    minlength: 2,
                },
                
                txtTotalUnidades: {
                    digits:true,
                    minlength: 2
                },
                
                "txtPlanta[]": {
                    required: true
                },
                
                "sltQuarto[]": {
                    required: true
                },
                "sltBanheiro[]": {
                    required: true
                },
                "sltSuite[]": {
                    required: true
                },
                "sltGaragem[]": {
                    required: true
                },
                "txtArea[]": {
                    maxlength: 7,
                    minlength: 2
                },
                
            },
            messages: {
                txtPlanta: {
                    required: "Campo Obrigatorio",
                    minlength: "Digite ao menos 2 numeros"
                },
                txtArea: {
                    minlength: "Digite ao menos 2 numeros"
                },
                "txtArea[]": {
                    digits: "Digite Somente Numeros",
                    minlength: "Digite ao menos 2 numeros"
                },
                txtTotalUnidades: {
                    digits: "Digite Somente Numeros",
                    minlength: "Digite ao menos 2 numeros"
                },
            },
            submitHandler: function(form) {
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
                                parametroGaragem){
    $(document).ready(function () {
            preco();
            $("#divAndares").hide();
            $("#divAndar").hide();
            $("#divUnidadesAndar").hide();  
            $("#divNumeroTorres").hide();  
        
            var condicao = "<div class='four wide required field' id='divCondicao'>\n\
                             <label>Condição</label><div class='ui selection dropdown'>\n\
                             <input type='hidden' name='sltCondicao' id='sltCondicao' value='"+parametroCondicao+"'> \n\
                             <div class='default text'>Condição</div> \n\
                             <i class='dropdown icon'></i>\n\
                             <div class='menu'>\n\
                             <div class='item' data-value='novo'>Novo</div>\n\
                             <div class='item' data-value='usado'>Usado</div>\n\
                             </div> \n\
                             </div> </div>";
            
            var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área(m2)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='"+parametroArea+"'>\n\
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
                                parametroCondominio){
    
    $(document).ready(function () {
            preco();
            $("#divNumeroPlantas").hide();
            $("#divAndares").hide();
            $("#divAndar").show();
            $("#divUnidadesAndar").show();
            $("#divNumeroTorres").hide();  
             
            var condicao = "<div class='four wide required field' id='divCondicao'>\n\
                             <label>Condição</label><div class='ui selection dropdown'>\n\
                             <input type='hidden' name='sltCondicao' id='sltCondicao' value='"+parametroCondicao+"'> \n\
                             <div class='default text'>Condição</div> \n\
                             <i class='dropdown icon'></i>\n\
                             <div class='menu'>\n\
                             <div class='item' data-value='novo'>Novo</div>\n\
                             <div class='item' data-value='usado'>Usado</div>\n\
                             </div> \n\
                             </div> </div>";
            
            var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área(m2)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='"+parametroArea+"'>\n\
                        </div></div>";
             
             campos(parametroQuarto, 
                    parametroBanheiro, 
                    parametroSuite, 
                    parametroGaragem,
                    null);

        
            var condominio = "<div class='three wide field'>\n\
                                <div class='field'><label>Condominio</label>\n\
                                <input type='text' name='txtCondominio' id='txtCondominio' value='"+parametroCondominio+"'>\n\
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
    
    
    function mostrarCamposEdicaoApartamentoPlanta(tipoImovel,
                                parametroNumeroTorres){
    
    $(document).ready(function () {
            preco();
            $("#divAndar").hide();
            $("#divAndares").show();
            $("#divUnidadesAndar").show();
            
            var totalUnidades = "<div class='three wide field' id='divUnidadesTotal'>\n\
                                    <div class='field'><label>Total de Unidades</label>\n\
                                    <input type='text' name='txtTotalUnidades' id='txtTotalUnidades' placeholder='Total de Apartamentos' maxlength='3' value = '"+parametroNumeroTorres+"'>\n\
                                </div></div>";
            
            $("#divApartamento").append(totalUnidades); 
        
             campos(null, 
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
                                parametroCondominio){
    $(document).ready(function () { 
            preco();
            $("#divNumeroPlantas").hide();
            $("#divAndares").hide();
            $("#divAndar").hide();
            $("#divUnidadesAndar").hide();   
            $("#divNumeroTorres").hide();  
            
            var condicao = "<div class='four wide required field' id='divCondicao'>\n\
                             <label>Condição</label><div class='ui selection dropdown'>\n\
                             <input type='hidden' name='sltCondicao' id='sltCondicao' value='"+parametroCondicao+"'> \n\
                             <div class='default text'>Condição</div> \n\
                             <i class='dropdown icon'></i>\n\
                             <div class='menu'>\n\
                             <div class='item' data-value='novo'>Novo</div>\n\
                             <div class='item' data-value='usado'>Usado</div>\n\
                             </div> \n\
                             </div> </div>";
            
            var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área(m2)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='"+parametroArea+"'>\n\
                        </div></div>";
             
             campos(null,
                    parametroBanheiro, 
                    null,
                    parametroGaragem,
                    null);

        
            var condominio = "<div class='three wide field'>\n\
                                <div class='field'><label>Condominio (R$)</label>\n\
                                <input type='text' name='txtCondominio' id='txtCondominio' value='"+parametroCondominio+"'>\n\
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
 
    function mostrarCamposEdicaoPredioComercial(tipoImovel, parametroArea){
    $(document).ready(function () { 
            preco();
            $("#divNumeroPlantas").hide();
            $("#divAndares").hide();
            $("#divAndar").hide();
            $("#divUnidadesAndar").hide();   
            $("#divCondicao").hide();
            $("#divNumeroTorres").hide();  
            
            campos(null, null, null, null, parametroArea);
            
            /*var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área(m2)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='"+parametroArea+"'>\n\
                        </div></div>";
        
            $("#divInfoBasicas").append(area);  */

         })  
    }
    
    function mostrarCamposEdicaoTerreno(tipoImovel, 
                                parametroArea){
    $(document).ready(function () { 
            preco();
            $("#divNumeroPlantas").hide();
            $("#divAndares").hide();
            $("#divAndar").hide();
            $("#divUnidadesAndar").hide();   
            $("#divNumeroTorres").hide();  
            
            var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área(m2)</label>\n\
                             <input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área' maxlength='7' value='"+parametroArea+"'>\n\
                        </div></div>";
        
            $("#divInfoBasicas").append(area);  
            
             $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
             });
         })  
    }
    
    function mostrarPlantas(parametroOrdem,
                            parametroTituloPlanta,
                            parametroQuarto,
                            parametroBanheiro,
                            parametroSuite,
                            parametroGaragem,
                            parametroArea){
    $(document).ready(function () {  

            var tituloPlanta = "<h4>Planta "+(parametroOrdem+1)+": </h4><div id='divNomePlantas' class='nine wide required field'><input type='text' name='txtPlanta[]' id='txtPlanta"+parametroOrdem+"' value = '"+parametroTituloPlanta+"' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>";                                     
            $('#divInserePlanta').append(tituloPlanta);

            campos(parametroQuarto, parametroBanheiro, parametroSuite, parametroGaragem, parametroArea);
            
             $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
             });
            
        })     
    }
    
    function campos(parametroQuarto, 
                   parametroBanheiro, 
                   parametroSuite, 
                   parametroGaragem,
                   parametroArea){
            var quarto = "<div class='three wide required field' id='divQuarto'><label>Quarto(s)</label>\n\
                            <div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltQuarto' id='sltQuarto' value='"+parametroQuarto+"'>\n\
                            <div class='default text'>Quarto(s)</div><i class='dropdown icon'></i>\n\
                            <div class='menu'>\n\
                                <div class='item' data-value='0'>nenhuma</div>\n\
                                <div class='item' data-value='1'>1</div>\n\
                                <div class='item' data-value='2'>2</div>\n\
                                <div class='item' data-value='3'>3</div>\n\
                                <div class='item' data-value='4'>4</div>\n\
                                <div class='item' data-value='5'>Mais de 5</div>\n\
                            </div></div></div>";
            var banheiro = "<div class='three wide required field' id='divBanheiro'>\n\
                                <label>Banheiro(s)</label><div class='ui selection dropdown'>\n\
                                <input type='hidden' name='sltBanheiro' id='sltBanheiro' value='"+parametroBanheiro+"'>\n\
                                <div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i>\n\
                                <div class='menu'>\n\
                                <div class='item' data-value='0'>nenhuma</div>\n\
                                <div class='item' data-value='1'>1</div>\n\
                                <div class='item' data-value='2'>2</div>\n\
                                <div class='item' data-value='3'>3</div>\n\
                                <div class='item' data-value='4'>4</div>\n\
                                <div class='item' data-value='5'>Mais de 5</div>\n\
                            </div></div></div>";
            var suite = "<div class='three wide required field' id='divSuite'>\n\
                            <label>Suite(s)</label><div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltSuite' id='sltSuite' value='"+parametroSuite+"'>\n\
                            <div class='default text'>Suite(s)</div><i class='dropdown icon'></i>\n\
                            <div class='menu'><div class='item' data-value='0'>nenhuma</div>\n\
                            <div class='item' data-value='1'>1</div>\n\
                            <div class='item' data-value='2'>2</div>\n\
                            <div class='item' data-value='3'>3</div>\n\
                            <div class='item' data-value='4'>4</div>\n\
                            <div class='item' data-value='5'>Mais de 5</div>\n\
                            </div></div></div>";
            var garagem = "<div class='three wide required field' id='divGaragem'><label>Vagas de Garagem</label>\n\
                            <div class='ui selection dropdown'>\n\
                            <input type='hidden' name='sltGaragem' id='sltGaragem' value='"+parametroGaragem+"'>\n\
                            <div class='default text'>Vaga(s) de Garagem</div>\n\
                            <i class='dropdown icon'></i><div class='menu'>\n\
                            <div class='item' data-value='0'>nenhuma</div>\n\
                            <div class='item' data-value='1'>1</div>\n\
                            <div class='item' data-value='2'>2</div>\n\
                            <div class='item' data-value='3'>3</div>\n\
                            <div class='item' data-value='4'>4</div>\n\
                            <div class='item' data-value='5'>Mais de 5</div>\n\
                           </div></div></div>";
            
            var area = "<div id='divArea' class='three wide field'>\n\
                             <div class='field'><label>Área(m2)</label>\n\
                             <input type='text' name='txtArea[]' id='txtArea' placeholder='Informe a Área' maxlength='7' value='"+parametroArea+"'>\n\
                        </div></div>";
 
        if(parametroQuarto !== null){
            $("#divInfoApeCasa").append(quarto); 
        } else if($("#divQuarto")){$("#divQuarto").remove();}
        
        if(parametroBanheiro !== null){
        $("#divInfoApeCasa").append(banheiro); 
        } else if($("#divBanheiro")){$("#divBanheiro").remove();}
        
        if(parametroSuite !== null){
            $("#divInfoApeCasa").append(suite); 
        } else if($("#divSuite")){$("#divSuite").remove();}
        
        if(parametroGaragem !== null){
        $("#divInfoApeCasa").append(garagem);   
        } else if($("#divGaragem")){$("#divGaragem").remove();}
        
        if(parametroArea !== null){
            $("#divInfoApeCasa").append(area); 
        } else if($("#divArea")){$("#divArea").remove();}
    }
    
function preco(){
    
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
    })
    }

/*function sltTiraRegrasValidação(){
    $(document).ready(function() {
        $("#sltTipo").change(function () {
            $("input[id^='slt']").each(function () {
                $(this).rules("remove");
            }) 
        })
    })
}*/