<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<!-- JS -->
<script src="assets/js/usuario.js"></script>
<script>
    cancelar("Usuario", "meuPIP");
    trocarSenha();
</script>
<?php
Sessao::gerarToken();
?>
    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"> <i class="small privacy icon"></i>Trocar Senha</div>
                </div>
            </div>
        </div>
    </div>   

    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="trocarSenha" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Preencha os campos abaixo para alterar sua senha</h3>
                <div class="three fields" id="divCamposTrocaSenha">
                    <div class="required field">
                        <label>Senha atual</label>
                        <div class="ui left icon input">
                            <i class="lock icon"></i>                            
                            <input type="password" name="txtSenhaAtual" id="txtSenhaAtual" placeholder="Informe a senha atual" maxlength="20">
                        </div>
                    </div>
                    <div class="required field">
                        <label>Nova Senha</label>
                        <div class="ui left icon input">
                            <input type="password" name="txtSenhaNova" id="txtSenhaNova" placeholder="Informe uma senha nova" maxlength="20">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    <div class="required field">
                        <label>Confirmação da senha</label>
                        <div class="ui left icon input">
                            <input type="password" name="txtSenhaConfirmacao" id="txtSenhaConfirmacao" placeholder="Repita a senha nova" maxlength="20">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                </div>            
                <div class="ui hidden divider"></div>

                <div id="divBotoesTrocarSenha">
                    <button class="ui blue button" type="button" id="btnAlterarSenha">Alterar</button>
                    <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
                </div>

                <div class="ui hidden divider"></div>
                <div id="divRetorno"></div>               
                <div class="ui hidden divider"></div>

            </form>
        </div>

    </div>

<!-- MODAIS -->
<div class="ui small modal" id="modalCancelar">
    <i class="close icon"></i>
    <div class="header">
        Cancelar
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">Deseja realmente cancelar e perder as informações não gravadas?</div>
        </div>
    </div>
    <div class="actions">
        <div class="ui red deny button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>
<div class="ui small modal" id="modalSenha">
    <i class="close icon"></i>
    <div class="ui red header">
        Atenção
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">A nova senha não pode ser igual a senha atual</div>
        </div>       
    </div>
    <div class="actions">
        <div class="ui red deny button">FECHAR</div>
    </div>
</div>