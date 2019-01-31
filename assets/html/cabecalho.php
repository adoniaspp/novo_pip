<!DOCTYPE HTML>
<html lang=pt-br>
<head>
<title>PIP - Procure Im&oacute;veis Pai D'Egua</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv=X-UA-Compatible content="IE=edge,chrome=1">
<?php echo $this->getTag_cabecalho(); ?>
<script src=<?php echo PIPURL; ?>assets/js/bundle.js></script>
<link href=<?php echo PIPURL; ?>assets/css/bundle.css rel=stylesheet type=text/css />
<link rel="shortcut icon" href=<?php echo PIPURL; ?>assets/imagens/tituloCasaAzulChanfle.jpg type="image/x-icon"/>
    <link rel="manifest" href="/manifest.json">
    <script src=<?php echo PIPURL; ?>assets/js/cabecalho.js></script>

</head>
<body>
<?php if (Sessao::verificarSessaoUsuario()) { ?>
<script>$(document).ready(function(){logout()});</script>
<?php } ?>


    <div class="ui sidebar left vertical sidebar menu">
        <a class="ui active one column stackable center aligned container item" href="<?php echo PIPURL; ?>index.php">
            <div class="column twelve wide">
                <i class="red map marker alternate icon"></i>
                <span class="ui blue header">PIP-Imóveis</span>
            </div>
        </a>

        <a class="ui one column stackable center aligned item" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=form&tipo=login">
            <div class="column twelve wide">
                <i class="key icon"></i>
                <span class="ui blue header">Entrar</span>
            </div>
        </a>
        <a class="ui one column stackable center aligned item" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=form&tipo=cadastro">
            <div class="column twelve wide">
                <i class="pencil alternate icon"></i>
                <span class="ui blue header">Cadastre-se</span>
            </div>
        </a>
        <div class="ui vertical accordion menu">
            <div class="item">
                <a class="active title">
                    <i class="dropdown icon"></i>
                    Size
                </a>
                <div class="active content">
                    <div class="ui form">
                        <div class="grouped fields">
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="size" value="small">
                                    <label>Small</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="size" value="medium">
                                    <label>Medium</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="size" value="large">
                                    <label>Large</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="size" value="x-large">
                                    <label>X-Large</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="pusher">
<div class="ui top fixed huge menu" style="background-color: #f2f0f3">
    <div class="ui container">
    <div class="left menu" id="divMenuCabecalhoEsquerda">
    </div>
        <div class="right menu" id="divMenuCabecalhoDireita">
            <?php if (Sessao::verificarSessaoUsuario()) { ?>
            <!--<div class="ui one column stackable right aligned grid">
                    <div class="middle aligned row">
                        <div class="column">
                            <h4 class="ui blue header">
                                Seja Bem Vindo!
                                <?php echo ucfirst(strtolower(explode(" ", $_SESSION['nome'])[0])); ?></span>
                            </h4>
                        </div>
                        <div class="column">
                            <div class="ui buttons">
                                <a class="ui primary button" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=meuPIP"><i class="icon home"></i>Acessar Meu PIP</a>
                                <div class="or" data-text="ou"></div>
                                <a class="ui button" id="btnLogout" href=# ><i class="power red icon"></i>Sair</a>
                            </div>
                        </div>
                    </div>

                </div>-->
            <?php } else { ?>
            <!--<div class="ui one column stackable center aligned grid">
                <div class="middle aligned row">
                    <div class="column">
                        <div class="ui buttons">
                            <a class="ui primary button" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=form&tipo=login"><i class="icon lock"></i>Entrar</a>
                            <div class="or" data-text="ou"></div>
                            <a class="ui olive button" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=form&tipo=cadastro"><i class="icon edit"></i>Cadastre-se</a>
                        </div>
                    </div>
                </div>
            </div>-->
            <?php } ?>
        </div>
        </div>
    </div>

<div class="ui hidden divider"></div>
<div class="ui hidden divider"></div>
<div class="ui hidden divider"></div>
<div class="ui hidden divider"></div>
<div id=modalAlertaSessao class="ui basic test small modal">
<div class="ui icon header">
<i class="warning sign icon"></i>
ATENÇÃO: Seu tempo de sessão irá expirar
</div>
<div class=content>
<p>Você será deslogado e redirecionado automaticamente para a página inicial em <span id=timeout-countdown>60</span> segundos.</p>
</div>
<div class=actions>
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
<div id=modalAlertaLogout class="ui basic test small modal">
<div class="ui icon header">
<i class="sign out icon"></i>
ATENÇÃO: Você foi deslogado por segurança devido a um longo período de inatividade
</div>
</div>

<script src="/sw.js"></script>

<script>
    var urlHome = "<?php echo PIPURL; ?>index.php";
    var imgURL = "<?php echo PIPURL; ?>assets/imagens/tituloCasaAzulChanfle.jpg";
    var sessao = "<?php echo (Sessao::verificarSessaoUsuario()); ?>";
    var nomeUsuarioSessao =  "<?php echo ucfirst(strtolower(explode(" ", $_SESSION['nome'])[0])); ?>";
    var PIPURL =  "<?php echo PIPURL; ?>";

    menuCabecalhoMobile(urlHome, imgURL, sessao, nomeUsuarioSessao, PIPURL);
    $(document).ready(function(){
        $("#btnMenuMobile").on('click', function () {
            $('.ui.sidebar')
                .sidebar('toggle');
        })
    });

</script>