function menuCabecalhoMobile(url, imgURL, sessao, nomeUsuarioSessao, PIPURL) {
    $(document).ready(function () {
        $('.ui.accordion')
            .accordion();
        var agentID = testMobile();
        if (!agentID) {
            $("#divMenuCabecalhoEsquerda").html("<div class='ui one column stackable center aligned grid'>\n" +
                "            <div class='middle aligned row'>\n" +
                "                <div class='column'>\n" +
                "                    <h2 class='ui header'>\n" +
                "                        <a href=" + url + ">" +
                "                            <img src=" + imgURL + " width='60px'>\n" +
                "                        <div class='content'>\n" +
                "                            <a href=" + url + ">PIP - Imóveis</a>\n" +
                "                            <div class='sub header'>Seu imóvel aqui!</div>\n" +
                "                        </div>\n" +
                "                    </h2>\n" +
                "                </div>\n" +
                "            </div>\n" +
                "        </div>");
            if(sessao){
                $("#divMenuCabecalhoDireita").html("<div class='ui one column stackable right aligned grid'>\n" +
                    "                    <div class='middle aligned row'>\n" +
                    "                        <div class='column'>\n" +
                    "                            <h4 class='ui blue header'>\n" +
                    "                                Seja Bem Vindo, " + nomeUsuarioSessao + "\n" +
                    "                            </h4>\n" +
                    "                        </div>\n" +
                    "                        <div class='column'>\n" +
                    "                            <div class='ui buttons'>\n" +
                    "                                <a class='ui primary button' href=" + PIPURL + "index.php?entidade=Usuario&acao=meuPIP><i class='icon home'></i>Acessar Meu PIP</a>\n" +
                    "                                <div class='or' data-text='ou'></div>\n" +
                    "                                <a class='ui button' id='btnLogout' href=# ><i class='power red icon'></i>Sair</a>\n" +
                    "                            </div>\n" +
                    "                        </div>\n" +
                    "                    </div>\n" +
                    "\n" +
                    "                </div>");
            }else if(!sessao){
                $("#divMenuCabecalhoDireita").html("<div class='ui one column stackable center aligned grid'>\n" +
                    "                <div class='middle aligned row'>\n" +
                    "                    <div class='column'>\n" +
                    "                        <div class='ui buttons'>\n" +
                    "                            <a class='ui primary button' href=" + PIPURL + "index.php?entidade=Usuario&acao=form&tipo=login><i class='icon lock'></i>Entrar</a>\n" +
                    "                            <div class='or' data-text='ou'></div>\n" +
                    "                            <a class='ui grey button' href=" + PIPURL + "index.php?entidade=Usuario&acao=form&tipo=cadastro><i class='icon edit'></i>Cadastre-se</a>\n" +
                    "                        </div>\n" +
                    "                    </div>\n" +
                    "                </div>\n" +
                    "            </div>");
            }
        }else if(!sessao){
            $("#cabecalhoMenu").remove();
                $("#btnMenuMobile").on('click', function () {
                    $('.ui.sidebar')
                        .sidebar('toggle');
                })
        }else if (sessao){
        /*    $(".pusher").before("");*/
            $("#btnMenuMobile").on('click', function () {
                $('.ui.sidebar')
                    .sidebar('toggle');
            })

        }
    });
}