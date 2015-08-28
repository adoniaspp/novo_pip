<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<!-- JS -->
<script src="assets/js/usuario.js"></script>
<script>
    fazerLogin();
    cancelar("", "");
    
</script>
<?php
Sessao::gerarToken();
?>
<!-- HTML -->
<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main"></div>
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="autenticar" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Preencha os campos abaixo para acessar sua conta</h3>
                <div class="three fields" id="divCamposTrocaSenha">
                    <div class="required field">
                        <label>Login</label>
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
                    <div class="field">
                        <label></label>
                        <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=esquecisenha" class="ui red label">Não lembra a senha?</a>
                    </div>
                </div>            
                <div class="ui hidden divider"></div>
                
                <div id="divBotoesTrocarSenha">
                <button class="ui blue button" type="button" id="btnLogin">Fazer Login</button>
                <button class="ui orange button" type="reset" id="btnCancelar">Cancelar</button>
                </div>
                
                <div class="ui hidden divider"></div>
                <div id="divRetorno"></div>               
                <div class="ui hidden divider"></div>
                
            </form>
        </div>

    </div>
</div>

<div class="ui small modal" id="modalCancelar">
    <i class="close icon"></i>
    <div class="header">
        Cancelar
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">Cancelar Login?</div>
        </div>
    </div>
    <div class="actions">
        <div class="ui deny red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>