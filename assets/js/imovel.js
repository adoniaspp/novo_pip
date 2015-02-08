function esconderCamposInicio() {
    $(document).ready(function () {
        
        $('.ui.dropdown')
                .dropdown({
            on: 'hover'
        });
        $('.ui.checkbox')
            .checkbox();
        
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

           $('#sltNumeroPlantas').parent().dropdown('restore defaults');
           $('#sltCondicao').parent().dropdown('restore defaults');
           $('#sltQuarto').parent().dropdown('restore defaults');
           $('#sltSuite').parent().dropdown('restore defaults');
           $('#sltBanheiro').parent().dropdown('restore defaults');
           $('#sltGaragem').parent().dropdown('restore defaults');
           $('#sltAndares').parent().dropdown('restore defaults');
           $("#txtArea").val("");
           
            mostrarArea();
                        
            if ($(this).val() == "1") { //casa
                mostrarDivInfoApeCasa();
                $("#divApartamento").hide();  
                $("#divNumeroPlantas").hide();
                $("#divAndar").hide();
                $("#divInserePlanta").hide();
                $("#divPlantaUm").hide();
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
                $("#txtCEP").rules("add", {
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
                mostrarPlantas();
                mostrarDivInfoApeCasa() 
                $("#divNumeroPlantas").show();   
                $("#divAreaPlanta").show();
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
                
                $("#sltCondicao").rules("remove");
                
                $("#sltNumeroPlantas").rules("add", {
                    required: true
                });
                /*
                $("select.sltQuarto").each(function () {
                    $(this).rules("add", {
                        required: true
                    });
                });*/
            
            } else if ($(this).val() == "3") { //apartamento novo ou usado 
                mostrarDivInfoApeCasa();
                $("#divPlantaUm").hide();               
                $("#divNumeroPlantas").hide();
                $("#divInserePlanta").hide();
                $("#divAreaPlanta").hide();
                $("#divCondicao").show();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                $("#divApartamento").show();
                $("#divAndar").show();
                $("#divDiferencial").show();
                $("#divCondominio").show();
                $("#chkCobertura").show();
                $("#chkSacada").show();
             
            } else if ($(this).val() == "4") { //sala comercial
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

            } else if ($(this).val() == "5") { //terreno
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
            
           
        if(valores == 1){
            
        var quarto = "<div class='three wide required field'><label>Quarto(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltQuarto' id='sltQuarto'><div class='default text'>Quarto(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var banheiro = "<div class='three wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Bnheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var suite = "<div class='three wide required field'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite' id='sltSuite'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var garagem = "<div class='three wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var area = "<div id='divAreaPlanta' class='one field'><div class='field'><label>Área(m2)</label><input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área'></div></div>";
        $("#divInfoApeCasa").append(quarto);
        $("#divInfoApeCasa").append(banheiro);
        $("#divInfoApeCasa").append(suite);
        $("#divInfoApeCasa").append(garagem);
        $("#divInfoApeCasa").append(area);
        /*
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
                })*/

        }
        
        if(valores >= 1){ //verifica se já existem divs na tela e as remove 
                
                $("#divInserePlanta").empty();
                $("#divPlantaUm").empty();

        }
        
        if(valores >=2){ //só mostrar mais opções de planta se for maior que 2
             //$("#divPlantaUm").append("<h4>Planta 1: </h4><div id='divNomePlantas' class='nine wide field'><input type='text' name='txtPlanta[]' id='txtPlanta' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>");
            
                 for (var valor = 1 ; valor <=valores ; valor++){ //clona as divs das plantas e as adiciona
                    var $clone = $('#divInfoApeCasa').clone();
                    $clone.attr("id","divInfoApeCasa"+valor);

                 var label = "<h4>Planta "+(valor)+": </h4><div id='divNomePlantas' class='nine wide field'><input type='text' name='txtPlanta[]' id='txtPlanta"+valor+"' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>"                 
                 
                 $('#divInserePlanta').append(label);
                 $('#divInserePlanta').append($clone);
              }
              
               for (var contador = 1 ; contador <=valores ; contador++){

                 var quarto = "<div class='three wide required field'><label>Quarto(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltQuarto[]' id='sltQuarto"+contador+"'><div class='default text'>Quarto(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var banheiro = "<div class='three wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro[]' id='sltBanheiro"+contador+"'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var suite = "<div class='three wide required field'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite[]' id='sltSuite"+contador+"'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var garagem = "<div class='three wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem[]' id='sltGaragem"+contador+"'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
                 var area = "<div id='divAreaPlanta' class='one field'><div class='field'><label>Área(m2)</label><input type='text' name='txtArea[]' id='txtArea"+contador+"' placeholder='Informe a Área'></div></div>";  
                 
                 $("#divInfoApeCasa"+contador).append(quarto);
                 $("#divInfoApeCasa"+contador).append(banheiro);
                 $("#divInfoApeCasa"+contador).append(suite);
                 $("#divInfoApeCasa"+contador).append(garagem);
                 $("#divInfoApeCasa"+contador).append(area);
                 
                $("#sltQuarto"+contador).rules("add", {
                    required: true
                });
                $("#sltSuite"+contador).rules("add", {
                    required: true
                });
                $("#sltBanheiro"+contador).rules("add", {
                    required: true
                });
                $("#sltGaragem"+contador).rules("add", {
                    required: true
                }); 
                 
               }
               
               
                $("input[name^='slt']:not('#sltTipo'):not('#sltNumeroPlantas')").parent().dropdown({
                    on: 'hover'
                })
              
         }        
       
       })
    
    }
    )}
}

function mostrarDivInfoApeCasa(){
    $(document).ready(function() {
        
       if ($("#sltTipo").val()=="1" || $("#sltTipo").val()=="3"){
        var quarto = "<div class='three wide required field'><label>Quarto(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltQuarto' id='sltQuarto'><div class='default text'>Quarto(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var banheiro = "<div class='three wide required field'><label>Banheiro(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltBanheiro' id='sltBanheiro'><div class='default text'>Banheiro(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var suite = "<div class='three wide required field'><label>Suite(s)</label><div class='ui selection dropdown'><input type='hidden' name='sltSuite' id='sltSuite'><div class='default text'>Suite(s)</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        var garagem = "<div class='three wide required field'><label>Vagas de Garagem</label><div class='ui selection dropdown'><input type='hidden' name='sltGaragem' id='sltGaragem'><div class='default text'>Vaga(s) de Garagem</div><i class='dropdown icon'></i><div class='menu'><div class='item' data-value='0'>nenhuma</div><div class='item' data-value='1'>1</div><div class='item' data-value='2'>2</div><div class='item' data-value='3'>3</div><div class='item' data-value='4'>4</div><div class='item' data-value='5'>Mais de 5</div></div></div></div>";
        //var area = "<div id='divAreaPlanta' class='one field'><div class='field'><label>Área(m2)</label><input type='text' name='txtArea' id='txtArea' placeholder='Informe a Área'></div></div>";
        $("#divInfoApeCasa").append(quarto);
        $("#divInfoApeCasa").append(banheiro);
        $("#divInfoApeCasa").append(suite);
        $("#divInfoApeCasa").append(garagem);
        //$("#divInfoApeCasa").append(area);
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

                txtArea: {
                    minlength: 2
                },
            },
            messages: {
                txtArea: {
                    minlength: "Digite ao menos 2 numeros"
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });
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