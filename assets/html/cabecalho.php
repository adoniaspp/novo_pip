<!DOCTYPE HTML>
<html lang=pt-br>
<head>
<title>PIP - Procure Im&oacute;veis Pai D'Egua</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv=X-UA-Compatible content="IE=edge,chrome=1">
<?php echo $this->getTag_cabecalho(); ?>
<script src=<?php echo PIPURL; ?>assets/js/bundle.js></script>
<link href=<?php echo PIPURL; ?>assets/css/bundle.css rel="stylesheet" type="text/css" >
<link rel="shortcut icon" href=<?php echo PIPURL; ?>assets/imagens/tituloCasaAzulChanfle.jpg type="image/x-icon"/>
    <link rel="manifest" href="/manifest.json">
    <script src=<?php echo PIPURL; ?>assets/js/cabecalho.js></script>

</head>
<body>
<?php if (Sessao::verificarSessaoUsuario()) { ?>
<script>$(document).ready(function(){logout()});
</script>
<?php } ?>

<?php
//$item = $this->getItem();

?>

<div class="ui sidebar left vertical sidebar menu">
<?php if (!Sessao::verificarSessaoUsuario()) { ?>
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
        <?php } else { ?>
    <a class="ui active one column stackable center aligned container item" href="<?php echo PIPURL; ?>index.php">
        <div class="column twelve wide">
            <i class="red map marker alternate icon"></i>
            <span class="ui blue header">Meu PIP</span>
        </div>
    </a>
        <div class="ui vertical accordion item">
        <a class="title">
            <i class="dropdown icon"></i>
            <i class="user icon"></i>
            <span class="ui blue header">Meus Dados</span>
        </a>
        <div class="content">
            <div class="ui vertical item">
            </div>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Usuario&acao=selecionar">
                <div class="column twelve wide">
                    <i class="edit icon"></i>
                    <span class="ui blue header">Atualizar Cadastro</span>
                </div>
            </a>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha">
                <div class="column twelve wide">
                    <i class="lock icon"></i>
                    <span class="ui blue header">Trocar Senha</span>
                </div>
            </a>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Usuario&acao=form&tipo=trocarimagem">
                <div class="column twelve wide">
                    <i class="file image outline icon"></i>
                    <span class="ui blue header">Alterar Foto</span>
                </div>
            </a>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Usuario&acao=Configuracoes">
                <div class="column twelve wide">
                    <i class="configure icon"></i>
                    <span class="ui blue header">Configurações</span>
                </div>
            </a>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $_SESSION["login"] ?>" class="item">
                <div class="column twelve wide">
                    <i class="newspaper icon"></i>
                    <span class="ui blue header">Vizualizar Minha Página</span>
                </div>
            </a>
        </div>
    </div>
    <div class="ui vertical accordion item">
        <a class="title">
            <i class="dropdown icon"></i>
            <i class="home icon"></i>
            <span class="ui blue header">Meus Imóveis</span>
        </a>
        <div class="content">
            <div class="ui vertical item">
            </div>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Imovel&acao=form">
                <div class="column twelve wide">
                    <i class="add icon"></i>
                    <span class="ui blue header">Cadastrar Imóvel</span>
                </div>
            </a>
                    <a class="ui one column stackable center aligned item" href="index.php?entidade=Imovel&acao=listarEditar">
                        <div class="column twelve wide">
                            <i class="edit icon"></i>
                            <span class="ui blue header">Alterar Imóvel</span>
                        </div>
                    </a>
                    <!--<a class="ui one column stackable center aligned item" href="index.php?entidade=Imovel&acao=listar" id="listarImoveis">
                        <div class="column twelve wide">
                            <i class="list icon"></i>
                            <span class="ui blue header">Meus Imóveis</span>
                        </div>
                    </a>-->

        </div>
    </div>

    <div class="ui vertical accordion item">
        <a class="title">
            <i class="dropdown icon"></i>
            <i class="announcement icon"></i>
            <span class="ui blue header">Meus Anúncios</span>
        </a>
        <div class="content">
            <div class="ui vertical item">
            </div>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Anuncio&acao=listarCadastrar">
                <div class="column twelve wide">
                    <i class="add icon"></i>
                    <span class="ui blue header">Publicar Anúncio</span>
                </div>
            </a>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Anuncio&acao=listarReativarAluguel">
                <div class="column twelve wide">
                    <i class="refresh icon"></i>
                    <span class="ui blue header">Reativar Anúncios (aluguel)</span>
                </div>
            </a>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Anuncio&acao=listarAtivo" id="listarImoveis">
                <div class="column twelve wide">
                    <i class="list icon"></i>
                    <span class="ui blue header">Anúncios Ativos</span>
                </div>
            </a>
            <!--<a class="ui one column stackable center aligned item" href="index.php?entidade=AnuncioAprovacao&acao=listarPendente" id="listarImoveis">
                <div class="column twelve wide">
                    <i class="warning icon"></i>
                    <span class="ui blue header">Pendentes de Aprovação</span>
                </div>
            </a>-->
            <!--<a class="ui one column stackable center aligned item" href="index.php?entidade=Anuncio&acao=listarFinalizado" id="listarImoveis">
                <div class="column twelve wide">
                    <i class="thumbs outline up icon"></i>
                    <span class="ui blue header">Anúncios Não Ativos</span>
                </div>
            </a>-->
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Usuario&acao=listarMensagem" id="listarImoveis">
                <div class="column twelve wide">
                    <i class="mail outline icon"></i>
                    <span class="ui blue header">Mensagens</span>
                </div>
            </a>

        </div>
    </div>

    <div class="ui vertical accordion item">
        <a class="title">
            <i class="dropdown icon"></i>
            <i class="shop icon"></i>
            <span class="ui blue header">Meus Planos</span>
        </a>
        <div class="content">
            <div class="ui vertical item">
            </div>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=UsuarioPlano&acao=listar">
                <div class="column twelve wide">
                    <i class="add icon"></i>
                    <span class="ui blue header">Comprar</span>
                </div>
            </a>


        </div>
    </div>

    <div class="ui vertical accordion item">
        <a class="title">
            <i class="dropdown icon"></i>
            <i class="info circle icon"></i>
            <span class="ui blue header">Central de Ajuda</span>
        </a>
        <div class="content">
            <div class="ui vertical item">
            </div>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Usuario&acao=AbrirChamado">
                <div class="column twelve wide">
                    <i class="comment outline icon"></i>
                    <span class="ui blue header">Fale Com o PIP Online</span>
                </div>
            </a>
            <a class="ui one column stackable center aligned item" href="index.php?entidade=Institucional&acao=duvidasFrequentes">
                <div class="column twelve wide">
                    <i class="book icon"></i>
                    <span class="ui blue header">Dúvidas Mais Frequentes</span>
                </div>
            </a>

        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="ui vertical item">
    </div>
    <br>
    <div class="ui centered column stackable grid">
            <a class="title" id='btnLogout' href=# >
                <i class="power red icon"></i>
                <span class="ui blue header">Sair</span>
            </a>
    </div>

<?php } ?>

</div>

<div class="pusher">
<div class="ui top fixed huge menu" style="background-color: #f2f0f3">
    <div class="ui container">
    <div class="left menu" id="divMenuCabecalhoEsquerda">
    </div>
        <div class="right menu" id="divMenuCabecalhoDireita">
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

        <div class="ui overlay fullscreen modal">
            <i class="close icon"></i>
            <div class="header">
                Busca de Anúcios
            </div>
            <div class="scrolling content">
                <div class="ui form container">
                    <div class="ui stackable six column grid">
                        <div class="column"></div>
                        <div class="column">
                            <select name="sltTipoImovel" id="sltTipoImovel">
                                <option value=""> Todos os tipos</option>
                                <option value="apartamento"> Apartamento</option>
                                <option value="apartamentoplanta"> Apartamento na Planta</option>
                                <option value="casa"> Casa</option>
                                <option value="prediocomercial"> Prédio Comercial</option>
                                <option value="salacomercial"> Sala Comercial</option>
                                <option value="terreno"> Terreno</option>
                            </select>
                        </div>
                        <div class="column">
                            <select name="sltFinalidade" id="sltFinalidade">
                                <option value=""> Todas as finalidades</option>
                                <option value="aluguel">Aluguel</option>
                                <option value="venda">Venda</option>
                            </select>
                        </div>
                        <div class="column">
                            <select name="sltCidade" id="sltCidade">
                                <option value="">Todas as cidades</option>
                                <option value="1">Belém</option>
                                <option value="2">Ananindeua</option>
                                <option value="3">Marituba</option>
                                <option value="4">Benevides</option>
                                <option value="6">Castanhal</option>
                            </select>
                        </div>

                        <div id="sltBairro">
                        </div>

                        <div class="column" id="divCondicao">
                            <select name="sltCidade" id="sltCidade">
                                <option value="">Todas</option>
                                <option value="novo">Novo</option>
                                <option value="usado">Usado</option>
                            </select>

                        </div>
                        <!--            <div class="column" id="divGaragem">
                                        <div class="ui left floated compact segment">
                                            <div class="ui fitted toggle checkbox">
                                                <input type="checkbox" name="checkgaragem" id="checkgaragem">

                                            </div>
                                            <label>Garagem</label>
                                        </div>
                                    </div>-->
                    </div>

                    <div class="ui stackable four column centered grid">
                        <div class="column">
                            <div class="ui twitter icon fluid button" id="btnBuscarAnuncioBasico">
                                <i class="search icon"></i>
                                Procurar
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--<div class="actions">
               <div class="ui black deny button">
                    Nope
                </div>
                <div class="ui positive right labeled icon button">
                    Yep, that's me
                    <i class="checkmark icon"></i>
                </div>
            </div>-->
        </div>