function esconderCamposInicio() {
    $(document).ready(function () {
        
        $('.ui.dropdown')
                .dropdown({
            on: 'hover'
        });
        $('.ui.checkbox')
            .checkbox();
        
        //$("#divCondicao").hide();
        $("#divArea").hide();
        $("#divInfoApeCasa").hide();
        $("#divDescricao").hide();
        $("#divApartamento").hide();
        $("#divDiferencial").hide();
        $("#divEndereco").hide();   
        $("#divNumeroPlantas").hide();
        $("#divCondominio").hide();
   
        $("#sltTipo").change(function() {
           
           $('#sltNumeroPlantas').parent().dropdown('restore defaults');
           $('#sltQuarto').parent().dropdown('restore defaults');
           $('#sltSuite').parent().dropdown('restore defaults');
           $('#sltBanheiro').parent().dropdown('restore defaults');
           $('#sltGaragem').parent().dropdown('restore defaults');
           $('#sltAndares').parent().dropdown('restore defaults');
           
            mostrarArea();
                        
            if ($(this).val() == "1") { //casa
                $("#divApartamento").hide();
                $("#divNumeroPlantas").hide();
                $("#divAndar").hide();
                $("#divInserePlanta").hide();
                $("#divPlantaUm").hide();
                $("#divInfoBasicas").show();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                
                
            } else if ($(this).val() == "2"){  //apartamento na planta / novo

                //$("#divCondicao").show();  
                $("#divNumeroPlantas").show();
                mostrarPlantas(); 
                $("#divArea").hide();
                $("#divInserePlanta").hide();
                $("#divPlantaUm").hide();
                $("#divInfoBasicas").hide();
                $("#divInfoApeCasa").hide();
                $("#divDescricao").hide();
                $("#divEndereco").hide();
                $("#divApartamento").hide();
                $("#divDiferencial").hide();
            
            } else if ($(this).val() == "3") { //apartamento usado 
                $("#divPlantaUm").hide();
                //$("#divCondicao").hide();
                $("#divNumeroPlantas").hide();
                $("#divInserePlanta").hide();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                $("#divApartamento").show();
                $("#divAndar").show();
                $("#divDiferencial").show();
                $("#divCondominio").show();

             
            } else if ($(this).val() == "4") { //sala comercial
                $("#divPlantaUm").hide();
                $("#divAndar").hide();
                $("#divNumeroPlantas").hide();
                //$("#divCondicao").hide();
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
                //$("#divCondicao").hide();
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
                $("#divPlantaUm").show();
                $("#divInfoBasicas").show();
                $("#divInfoApeCasa").show();
                $("#divDescricao").show();
                $("#divEndereco").show();
                $("#divApartamento").show();
                $("#divDiferencial").show();                                                      
                $("#divAndar").hide();
                $("#divCondominio").hide();
                                
            }    
        
        var valores = parseInt($("#sltNumeroPlantas").val());
        
        if(valores == 1){
            $("#sltQuarto").attr("name", "sltQuarto");
            $("#sltBanheiro").attr("name", "sltBanheiro");
            $("#sltSuite").attr("name", "sltSuite");
            $("#sltGaragem").attr("name", "sltGaragem");
        }
        
        if(valores >= 1){ //verifica se já existem divs na tela e as remove 
                
                $("#divInserePlanta").empty();
                $("#divPlantaUm").empty();

        }
        
        if(valores >=2){ //só mostrar mais opções de planta se for maior que 2
            
                $("#divPlantaUm").append("<label>Planta 1</label>");
            
                 for (var valor = 2 ; valor <=valores ; valor++){ //clona as divs das plantas e as adiciona
                    var $clone = $('#divInfoApeCasa').clone();
                    $clone.attr("id","divInfoApeCasa"+valor);
                    $("#sltQuarto").attr("name", "sltQuarto[]");
                    $("#sltBanheiro").attr("name", "sltBanheiro[]");
                    $("#sltSuite").attr("name", "sltSuite[]");
                    $("#sltGaragem").attr("name", "sltGaragem[]");

                 var label = "<label>Planta "+(valor)+"</label>";
                 $('#divInserePlanta').append(label);
                 $('#divInserePlanta').append($clone);
              }
        
         }        
       
       })
    
    }
    
}

function carregaB(){
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