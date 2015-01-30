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
   
        $("#sltTipo").change(function() {
           
           $('#sltNumeroPlantas').parent().dropdown('restore defaults');
           $('#sltQuarto').parent().dropdown('restore defaults');
           $('#sltSuite').parent().dropdown('restore defaults');
           $('#sltBanheiro').parent().dropdown('restore defaults');
           $('#sltGaragem').parent().dropdown('restore defaults');
           $('#sltAndares').parent().dropdown('restore defaults');
           $("#txtArea").val("");
           
            mostrarArea();
                        
            if ($(this).val() == "1") { //casa
                $("#divApartamento").hide();
                $("#divCondicao").hide(); 
                $("#divNumeroPlantas").hide();
                $("#divAndar").hide();
                $("#divInserePlanta").hide();
                $("#divPlantaUm").hide();
                $("#divInfoBasicas").show();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                
                
            } else if ($(this).val() == "2"){  //apartamento na planta / novo
                mostrarPlantas();
                 
                $("#divNumeroPlantas").show();                
                $("#divArea").hide();
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
            
            } else if ($(this).val() == "3") { //apartamento usado 
                $("#divPlantaUm").hide();               
                $("#divNumeroPlantas").hide();
                $("#divInserePlanta").hide();
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
                $("#divPlantaUm").hide();
                $("#divAndar").hide();
                $("#divNumeroPlantas").hide();
                $("#divCondicao").hide();
                $("#divInserePlanta").hide();
                $("#divInfoApeCasa").hide();
                $("#divApartamento").hide();
                $("#divDescricao").show();               
                $("#divEndereco").show(); 

            } else if ($(this).val() == "5") { //terreno
                $("#divPlantaUm").hide();
                $("#divInserePlanta").hide();
                $("#divAndar").hide();
                $("#divNumeroPlantas").hide();
                $("#divCondicao").hide();
                $("#divInfoApeCasa").hide();
                $("#divApartamento").hide();
                $("#divDescricao").show();               
                $("#divEndereco").show();

            }   
            
            
        });
     
    });
    
    function mostrarArea(){
            $("#divArea").show();
    }
    
    function mostrarPlantas(){
        
       
        
        $("#sltNumeroPlantas").change(function() {         
            
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
            $("#sltQuarto").attr("name", "sltQuarto").attr("id", "sltQuarto1");
            $("#sltBanheiro").attr("name", "sltBanheiro").attr("id", "sltQuarto1");
            $("#sltSuite").attr("name", "sltSuite").attr("id", "sltQuarto1");
            $("#sltGaragem").attr("name", "sltGaragem").attr("id", "sltQuarto1");
            $("#txtAreaApeNovo").attr("name", "txtAreaApeNovo").attr("id", "txtAreaApeNovo1");
        }
        
        if(valores >= 1){ //verifica se já existem divs na tela e as remove 
                
                $("#divInserePlanta").empty();
                $("#divPlantaUm").empty();

        }
        
        if(valores >=2){ //só mostrar mais opções de planta se for maior que 2
            
            
                $("#divPlantaUm").append("<h4>Planta 1: </h4><div id='divNomePlantas' class='nine wide field'><input type='text' name='txtPlanta[]' id='txtPlanta1' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>");
            
                 for (var valor = 2 ; valor <=valores ; valor++){ //clona as divs das plantas e as adiciona
                    var $clone = $('#divInfoApeCasa').clone();
                    $clone.attr("id","divInfoApeCasa"+valor);
                    $("#sltQuarto").attr("name", "sltQuarto[]").attr("id", "sltQuarto"+valor);
                    $("#sltBanheiro").attr("name", "sltBanheiro[]").attr("id", "sltBanheiro"+valor);
                    $("#sltSuite").attr("name", "sltSuite[]").attr("id", "sltSuite[]"+valor);
                    $("#sltGaragem").attr("name", "sltGaragem[]").attr("id", "sltGaragem"+valor);
                    $("#txtAreaApeNovo").attr("name", "txtAreaApeNovo[]").attr("id", "txtAreaApeNovo"+valor);

                 var label = "<h4>Planta "+(valor)+": </h4><div id='divNomePlantas' class='nine wide field'><input type='text' name='txtPlanta[]' id='txtPlanta"+valor+"' placeholder='Titulo da Planta. Ex: 3 Quartos + 2 Suites + Opções (Ex: Gabinete, Living Ampliado, etc)'></div>";
                 $('#divInserePlanta').append(label);
                 $('#divInserePlanta').append($clone);
              }
              
            $('.ui.dropdown')
                .dropdown({
            on: 'hover'
            });
              
         }        
       
       })
    
    }
    
}

function carregaDiferencial(){
    $(document).ready(function() {
                $("#sltTipo").change(function () {

        $.ajax({
                    url: "index.php",
                    //dataType: "json",
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



                });
            });
}

function cadastrarImovel(){
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
                txtSenha: {
                    required: true,
                    minlength: 8
                },
                txtConfirmarSenha: {
                    required: true,
                    equalTo: "#txtSenha"
                },
                txtCEP: {
                    required: true
                },
                txtNumero: {
                    required: true
                },
                chkConfirmacao: {
                    required: true
                },
                arquivo: {
                    filesize: 2097152,
                    accept: "jpeg|png|gif"
                },
            },
            messages: {
                txtCpf: {
                    remote: "CPF já utilizado"
                },
                txtCnpj: {
                    remote: "CNPJ já utilizado"
                },
                txtEmail: {
                    remote: "Email já utilizado"
                },
                txtLogin: {
                    minlength: "Login deve possuir no mínimo 2 caracteres",
                    remote: "Login já utilizado"
                },
                txtSenha: {
                    minlength: "Senha deve possuir no mínimo 8 caracteres"
                },
                txtConfirmarSenha: {
                    equalTo: "Por Favor digite o mesmo valor novamente"
                },
                chkConfirmacao: {
                    required: "A confirmação é obrigatória"
                },
                arquivo: {
                    //required: "Campo obrigatório"
                    filesize: "A imagem deve ser menor que 2MB",
                    accept: "Extensão de Arquivo Inválida"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
}