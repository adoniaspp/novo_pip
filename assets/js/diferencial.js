

function chamarDiferencial(){

    $(document).ready(function() {
        
        $("#divDiferencialApartamento").hide(); //oculta a div dos diferenciais, sendo preciso escolher o tipo de imóvel primeiro 
        $("#divDiferencialCasa").hide(); //oculta a div dos diferenciais, sendo preciso escolher o tipo de imóvel primeiro 

        $("#sltTipoAvancado").change(function() { //caso seja escolhido apartamento, mostrar os diferenciais do apartamento
            if ($(this).val() == "apartamento") {           
                $("#divDiferencial").hide();    
                $("#divDiferencialCasa").hide();
                $('#sltDiferencialApartamento').attr("disabled",false);
                $("#divDiferencialApartamento").show(); 
                $('#sltDiferencialApartamento').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
                });
                $('#sltDiferencialCasa').attr("disabled",true);
            }
            else if ($(this).val() == "casa") { //caso seja escolhida casa, mostrar os diferenciais da casa
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $('#sltDiferencialCasa').attr("disabled",false);
                $("#divDiferencialCasa").show();
                $('#sltDiferencialCasa').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
                });
                $('#sltDiferencialApartamento').attr("disabled",true);
            }
            else if ($(this).val() == "terreno") { //caso seja escolhido terreno, não mostrar nenhum diferencial
                $('#sltDiferencialCasa').attr("disabled",true);
                $('#sltDiferencialApartamento').attr("disabled",true);
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $("#divDiferencialCasa").hide();
            }
            else{
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $("#divDiferencialCasa").hide();
                $("#divDiferencial").show();               
            }
        })
    });

}

function chamarDiferencialCadastro(){

    $(document).ready(function() {
       
        $("#divDiferencialApartamento").hide(); //oculta a div dos diferenciais, sendo preciso escolher o tipo de imóvel primeiro 
        $("#divDiferencialCasa").hide(); //oculta a div dos diferenciais, sendo preciso escolher o tipo de imóvel primeiro 

        $("#sltTipo").change(function() { //caso seja escolhido apartamento, mostrar os diferenciais do apartamento
            if ($(this).val() == "apartamento") {           
                $("#divDiferencial").hide();    
                $("#divDiferencialCasa").hide();
                $('#sltDiferencialApartamento').attr("disabled",false);
                $("#divDiferencialApartamento").fadeIn(); 
                $('#sltDiferencialApartamento').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
                }); 
                
                $('#sltDiferencialCasa').attr("disabled",true);
                
                
            }
            else if ($(this).val() == "casa") { //caso seja escolhida casa, mostrar os diferenciais da casa
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $('#sltDiferencialCasa').attr("disabled",false);
                $("#divDiferencialCasa").fadeIn();
                $('#sltDiferencialCasa').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
                });
                $('#sltDiferencialApartamento').attr("disabled",true);
            }
            else if ($(this).val() == "terreno") { //caso seja escolhido terreno, não mostrar nenhum diferencial
                $('#sltDiferencialCasa').attr("disabled",true);
                $('#sltDiferencialApartamento').attr("disabled",true);
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $("#divDiferencialCasa").hide();
            }
            else{
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $("#divDiferencialCasa").hide();
                $("#divDiferencial").fadeIn();               
            }
        })
    });

}


function chamarDiferencialEdicao(){

    $(document).ready(function() {
              
        if ($("#sltTipo").val() == "casa") {
            $('#sltDiferencialCasa').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
            });
            $("#divDiferencialCasa").show();
            $("#divDiferencialApartamento").hide();
        }
        else if($("#sltTipo").val() == "apartamento"){
            $('#sltDiferencialApartamento').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
            });
            $("#divDiferencialApartamento").show();           
            $("#divDiferencialCasa").hide();
        }
        else if($("#sltTipo").val() == "terreno"){
            $('#sltDiferencialCasa').attr("disabled",true);
            $('#sltDiferencialApartamento').attr("disabled",true);
            $("#divDiferencialCasa").hide();
            $("#divDiferencial").hide();
            $("#divDiferencialApartamento").hide();
            
        }

        $("#sltTipo").change(function() { //caso seja escolhido apartamento, mostrar os diferenciais do apartamento
            if ($(this).val() == "apartamento") {           
                $("#divDiferencial").hide();    
                $("#divDiferencialCasa").hide();
                $('#sltDiferencialApartamento').attr("disabled",false);
                $("#divDiferencialApartamento").show(); 
                $('#sltDiferencialApartamento').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
                });
                 $('#sltDiferencialCasa').attr("disabled",true);
            }
            else if ($(this).val() == "casa") { //caso seja escolhida casa, mostrar os diferenciais da casa
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $('#sltDiferencialCasa').attr("disabled",false);
                $("#divDiferencialCasa").show();
                $('#sltDiferencialCasa').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                includeSelectAllOption: true
                });
                $('#sltDiferencialApartamento').attr("disabled",true);
            }
            else if ($(this).val() == "terreno") { //caso seja escolhido terreno, não mostrar nenhum diferencial
                $('#sltDiferencialCasa').attr("disabled",true);
                $('#sltDiferencialApartamento').attr("disabled",true);
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $("#divDiferencialCasa").hide();
            }
            else{
                $("#divDiferencial").hide();
                $("#divDiferencialApartamento").hide(); 
                $("#divDiferencialCasa").hide();
                $("#divDiferencial").show();               
            }
        })
    });

    }
    