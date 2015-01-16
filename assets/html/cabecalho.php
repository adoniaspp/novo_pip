<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>PIP - Procure Im&oacute;veis Pai D'Egua</title> 
        <!-- JQUERY --> 
        <script src="<?php echo PIPURL; ?>/assets/libs/jquery/jquery-2.1.3.min.js"></script> 
        <!-- SEMANTIC UI --> 
        <link href="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.css" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.js"></script> 
        <!-- Template PIP -->
        <link href="<?php echo PIPURL; ?>/assets/css/template-pip.css" rel="stylesheet" type="text/css" /> 		
    </head>
    <body>   
        <div class="container">  
            <nav class="ui menu inverted navbar page grid" style="margin-bottom: 0px">
                <a href="" class="brand item">Project Name</a>
                <div class="right menu">
                                            <div class="ui input">
                                                    <div id="divForm">
                            <input name="txtLoginIndex" type="text" id="txtLoginIndex" placeholder="Login">
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui input">
                            <input type="password" name="txtSenhaIndex" id="txtSenhaIndex" placeholder="Senha">
                        </div>
                    </div>
                                        <div class="item"><button  type="button" id="btnAcessar" class="ui green button">Acessar</button></div>
                </div>
                                        
                     
                        </div>
                    
                    
              
                    
                </div>
                                        <div id="divUsuario" class="hide">
                            <form class="navbar-form navbar-right">
                                <div id="divNome"></div>
                                <div id="divBotoes">  
                                    <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=meuPIP" class="btn btn-primary"><span class="glyphicon glyphicon-th-large"></span> Meu Pip</a>
                                    <a id="btnLogout" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Sair</a>
                                </div>
                            </form>            
                        </div>
            </nav>
        </div>
        <script>

            $(document).ready(function() {
                $(document).keypress(function(e) {
                    if (e.which == 13) {
                        if ($('#txtLoginIndex').val().length > 0 && $('#txtSenhaIndex').val().length > 0) {
                            autenticarUsuario();
                        }
                    }
                });
<?php
if (Sessao::verificarSessaoUsuario()) {
    ?>
                    $("#divForm").hide();
                    $("#divUsuario").show();
                    $("#divUsuario").attr('class', 'text');
                    $("#divNome").html("<h4>Seja bem vindo, <?php echo ucfirst(strtolower(explode(" ", $_SESSION['nome'])[0])); ?>  <h4>");
    <?php
} else {
    Sessao::gerarToken();
};
?>
                $("#btnAcessar").click(function() {
                    autenticarUsuario();
                });
                $("#btnLogout").click(function() {
                    logoutUsuario();
                });
                function autenticarUsuario() {
                    if ($('#txtLoginIndex').val().length < 2 | $('#txtSenhaIndex').val().length < 8) {
                        alert('Atenção: Você deve informar o usuário e a senha');
                    } else {

                        $.ajax({
                            url: "index.php",
                            dataType: "json",
                            type: "POST",
                            data: {
                                txtLogin: $('#txtLoginIndex').val(),
                                txtSenha: $('#txtSenhaIndex').val(),
                                hdnEntidade: "Usuario",
                                hdnAcao: "autenticar"
                            },
                            success: function(resposta) {
                                if (resposta.resultado == 1) {
                                    var nome = resposta.nome;
                                    $('#divForm').hide();
                                    $("#divUsuario").fadeIn('slow');
                                    $("#divUsuario").attr('class', 'text');
                                    $("#divNome").html("<h4>Seja bem vindo " + resposta.nome + "  <h4>");
                                    location.href = resposta.redirecionamento;
                                }
                                if (resposta.resultado == 2) {
                                    $("#divTitulo").attr('class', 'text text-danger').html("Usuário e/ou Senha Inválidos");
                                }
                                if (resposta.resultado == 3) {
                                    $("#divTitulo").attr('class', 'text text-danger').html("Ops... lamentamos o ocorrido..").fadeIn('slow');
                                }
                            }
                        })
                    }
                }

                function logoutUsuario() {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: {
                            hdnEntidade: "Usuario",
                            hdnAcao: "logout"
                        },
                        success: function(resposta) {
                            if (resposta.resultado == 1) {
                                $("#divUsuario").hide();
                                $('#divForm').show();
                                location.href = 'index.php'
                            }
                        }
                    })
                }
            });
        </script>
