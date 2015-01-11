<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>PIP - Procure Im&oacute;veis Pai D'Egua</title> 
        <!-- SEMANTIC UI --> 
        <link href="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.css" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.js"></script> 
        <!-- JQUERY --> 
        <script src="<?php echo PIPURL; ?>/assets/libs/jquery/jquery-2.0.2.min.js"></script> 
        <!-- Template PIP -->
        <link href="<?php echo PIPURL; ?>/assets/css/template-pip.css" rel="stylesheet" type="text/css" /> 		
        <!-- CSS adjustments for browsers with JavaScript disabled -->
        <noscript><link rel="stylesheet" href="<?php echo PIPURL; ?>/assets/css/jquery.fileupload-noscript.css"></noscript>
        <noscript><link rel="stylesheet" href="<?php echo PIPURL; ?>/assets/css/jquery.fileupload-ui-noscript.css"></noscript>
    </head>
    <body>
        
        <div class="ui fixed main menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-2"><a href="<?php echo PIPURL; ?>/index.php"> <img src="<?php echo PIPURL; ?>/assets/imagens/logo.png" width="120px" /> </a> </div>
                <div class="col-lg-6">
                    <h4> Temos a Ferramenta Tecnológica de busca do seu imóvel desejado <br /> Procure aqui!</h4>
                </div>
                <div class="col-lg-4">
                    <div id="divForm">
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="3"><h5 id="divTitulo" style="text-align: left"> Acesse o Meu PIP </h5></td>
                                </tr>
                                <tr>
                                    <td width="130"><input name="txtLoginIndex" type="text" class="form-control" id="txtLoginIndex" style="width:120px" placeholder="Login"></td>
                                    <td width="75"><input name="txtSenhaIndex" type="password" class="form-control" id="txtSenhaIndex" style="width:120px" placeholder="Senha"></td>
                                    <td width="130"><button type="button" id="btnAcessar" class="btn btn-sm btn-primary">Acessar</button></td>
                                </tr>
                                <tr>
                                    <td height="30" colspan="3" style="text-align: left">
                                        <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=cadastro" class="text text-success">Ainda não é cadastrado?</a>
                                        <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=esquecisenha" class="text text-danger">Não lembra a senha?</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                </div>
            </div>
        </div>
        </div>
        <script>
            
            $(document).ready(function() {
                $(document).keypress(function(e) {
                if (e.which == 13) {
                    if($('#txtLoginIndex').val().length > 0 && $('#txtSenhaIndex').val().length > 0){
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
