<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/js/util.validate.js"></script>

<script>
    cancelar("","");
    alterarSenha();
</script>

<?php
Sessao::gerarToken();
?>

<div class="ui middle aligned stackable grid container">
    <div class="row" id="breadcrumb">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"> <i class="privacy icon"></i>Alterar Senha</div>
                </div>
            </div>
        </div>
     </div>   
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Digite a nova senha e depois a repita para realizar a troca</p>
            </div>
        </div>
    </div>

</div>

<div class="ui middle aligned stackable grid container">
    <div class="column">
            <form id="form" class="ui form" action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="alterarSenha" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Alterar Senha</h3>
                <div class="two fields" id="divCamposAlterarSenha">
                    <div class="five wide field required field" id="pwd-container">
                        <label>Nova Senha</label>
                        <div class="ui left icon input">
                            <input type="password" name="txtSenha" id="txtSenha" placeholder="Informe uma senha" maxlength="20">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    <div class="five wide field required field" id="pwd-container">
                        <label>Repita Nova Senha</label>
                        <div class="ui left icon input">
                            <input type="password" name="txtSenhaConfirmacao" id="txtSenhaConfirmacao" placeholder="Repita a senha" maxlength="20">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                </div>
                <div id="divBotoesAlterarSenha">
                <div class="ui hidden divider"></div>
                <button class="ui blue button" type="button" id="btnAlterar">Alterar</button>
                <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
                <div class="ui hidden divider"></div>     
                </div>
                <div class="ui hidden divider"></div>
                <div id="divRetorno"></div>               
                <div class="ui hidden divider"></div> 
                
            </form>
    </div>    
</div>

            

<div class="ui stardart modal" id="modalCancelar">
    <i class="close icon"></i>
    <div class="header">
        Cancelar
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">Deseja realmente cancelar?</div>
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
