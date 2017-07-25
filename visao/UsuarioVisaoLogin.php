<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<!-- JS -->
<script src="assets/js/usuario.js"></script>
<script>
    fazerLogin();
</script>
<!-- HTML -->
<?php Sessao::gerarToken(); ?>

<script>
    $(document).ready(function () {

        $("#divMaiorRetornoOperacao").hide();

        if ("<?php echo $_SESSION["confirmarOperacao"] ?>" != null) {

            if ("<?php echo $_SESSION["confirmarOperacao"] ?>" == "sucesso") {

                $("#divMaiorRetornoOperacao").show();

                $("#divRetornoOperacao").attr("class", "ui positive message");

                $("#divRetornoOperacao").html("<i class='big green check circle outline icon'></i>Operação Realizada Com Sucesso. Digite abaixo seu login e senha para entrar.");

            }

            if ("<?php echo $_SESSION["confirmarOperacao"] ?>" == "erroGenerico") {

                $("#divMaiorRetornoOperacao").show();

                $("#divRetornoOperacao").attr("class", "ui negative message");

                $("#divRetornoOperacao").html("<i class='big red remove circle outline icon'>\n\
                            </i>Erro ao processar requisição. Tente novamente fazer o cadastro em alguns minutos - 000");

            }

            if ("<?php echo $_SESSION["confirmarOperacao"] ?>" == "erroToken") {

                $("#divMaiorRetornoOperacao").show();

                $("#divRetornoOperacao").attr("class", "ui negative message");

                $("#divRetornoOperacao").html("<i class='big red remove circle outline icon'>\n\
                            </i>Tempo limite para a operação expirou. Tente novamente fazer o cadastro.");

            }

<?php unset($_SESSION["confirmarOperacao"]) ?>

        }

    })
</script>

<div class="ui hidden divider"></div>

<div class="ui column doubling grid container" id="divMaiorRetornoOperacao">
    <div class="row">
        <div class="column">
            <div id="divRetornoOperacao" class=""></div>    
        </div>
    </div>
</div>

<div class="ui column doubling stackable grid container">
    <div class="column">
        <form id="form" class="ui form" action="index.php" method="post">
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
            <input type="hidden" id="hdnAcao" name="hdnAcao" value="autenticar" />
            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
            <h3 class="ui dividing header">Preencha os campos abaixo para acessar sua conta</h3>

            <div class="ui message">
                Veja todos os seus anúncios, edite, exclua e reative-os de forma rápida e fácil, 
                altere seu perfil com segurança, administre suas mensagens recebidas, envie seus anúncios por e-email e muito mais.
            </div>

            <div class="four fields" id="divCamposTrocaSenha">
                <div class="required field">
                    <label>Nome de Usuário</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>                            
                        <input type="text" name="txtLogin" id="txtLogin" placeholder="Digite o Login" maxlength="25">
                    </div>
                </div>
                <div class="required field">
                    <label>Senha</label>
                    <div class="ui left icon input">
                        <input type="password" name="txtSenha" id="txtSenha" placeholder="Digite a Senha" maxlength="20">
                        <i class="lock icon"></i>
                    </div>
                </div>
            </div>            
            <div class="ui hidden divider"></div>
            <div id="divBotoesTrocarSenha">
                <button class="ui blue button" id="btnLogin">Fazer Login</button>
                <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=esquecisenha" class="ui red button">Não lembra a senha?</a>
            </div>                
            <div class="ui hidden divider"></div>
            <div id="divRetorno"></div>               
            <div class="ui hidden divider"></div>
        </form>
    </div>
</div>
