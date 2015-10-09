<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <title>PIP - Procure Im&oacute;veis Pai D'Egua</title> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- JQUERY --> 
        <script src="<?php echo PIPURL; ?>/assets/libs/jquery/jquery-2.1.3.min.js"></script> 
        <!-- SEMANTIC UI --> 
        <link href="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.css" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.js"></script> 
        <!-- Template PIP -->
        <link href="<?php echo PIPURL; ?>/assets/css/template-pip.css" rel="stylesheet" type="text/css" />
        <!-- Scripts -->
        <script type="text/javascript" src="assets/js/cabecalho.js"></script>
        <script type="text/javascript" src="assets/libs/timeout-dialog/timeout-dialog.js"></script>
    </head>

    <script>
        $(document).ready(function () {
<?php if (Sessao::verificarSessaoUsuario()) { ?>
                exibirMeuPIP("SIM", "<?php echo ucfirst(strtolower(explode(" ", $_SESSION['nome'])[0])); ?>");
                logout();
<?php } else { ?>
                exibirMeuPIP("NAO", "");
<?php } ?>
        })
    </script>

    <div class="container">  
        <nav class="ui menu inverted navbar page grid" style="background-color: #ffffff" style="margin-bottom:300px">
            <a href="<?php echo PIPURL; ?>/index.php"> <img src="<?php echo PIPURL; ?>/assets/imagens/logo.png" width="120px"/></a>

            <div id="loginCadastro">
                <div class="ui menu">
                    <div class="item">
                        <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=login"><div class="ui primary button" id="btnAcessar">LOGIN</div></a>
                    </div>
                    <div class="item">
                        <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=cadastro"<div class="ui button">CADASTRAR-SE</div></a>
                    </div>
                </div>
            </div>

            <div id="divUsuario" class="right menu hide" style="margin-left:800px; margin-top: -80px" style="display: none">
                <form>
                    <div class="ui center aligned compact segment" style="margin-bottom: 10px">
                        <div id="divNome" style="margin-bottom: -10px"> </div>
                        <div>
                            <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=meuPIP" class="ui primary button"> <i class="block layout icon"></i> Meu PIP </a>
                            <a id="btnLogout" href="#" class="ui red button"><i class="power icon"></i> Sair</a>  
                        </div>
                    </div>
                </form>            
            </div>



            <div id="modalAlertaSessao" class="ui basic test small modal">                
                <div class="ui icon header">
                    <i class="warning sign icon"></i>
                    ATENÇÃO: Seu tempo de sessão irá expirar
                </div>
                <div class="content">
                    <p>Você será deslogado e redirecionado automaticamente para a página inicial em  <span id="timeout-countdown">60</span> segundos.</p>
                </div>
                <div class="actions">
                    <div class="ui red basic cancel inverted button">
                        <i class="remove icon"></i>
                        Encerrar sessão
                    </div>
                    <div class="ui green ok inverted button">
                        <i class="checkmark icon"></i>
                        Desejo continuar logado!
                    </div>
                </div>
                
            </div>
            <div id="modalAlertaLogout" class="ui basic test small modal">
                <div class="ui icon header">
                    <i class="sign out icon"></i>
                    ATENÇÃO: Você foi deslogado
                </div>
            </div>

