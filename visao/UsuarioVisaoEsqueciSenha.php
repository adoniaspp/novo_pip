<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/js/usuario.js"></script>
<?php
Sessao::gerarToken();
?>
<script>
    buscarEmail();
    esqueciSenha();
</script>
<div class="ui column doubling grid container" id="breadcrumb">
    <div class="column">
        <div class="ui large breadcrumb">
            <a class="section" href="index.php">Início</a>
            <i class="right chevron icon divider"></i>
            <a class="active section">Lembrar Senha</a>
        </div>
    </div>  
</div>
<div class="ui doubling stackable grid container">
    <div class="column">
        <form id="form" class="ui large form" action="index.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
            <input type="hidden" id="hdnAcao" name="hdnAcao" value="esquecersenha" />
            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
            <h3 class="ui dividing header">Encaminharemos as instruções para o e-mail cadastrado</h3>
            <div class="ui message">
                <p>Caso tenha esquecido sua senha, insira o e-mail cadastro abaixo, que enviaremos para seu email as instruções de troca de senha.</p>
            </div> 
            <div class="fields">
                <div class="seven wide required field">
                    <label>E-mail</label>
                    <input type="text" name="txtEmail" id="txtEmail" placeholder="Informe o email cadastrado" maxlength="50">
                </div>
            </div>
            <div class="ui hidden divider"></div>
            <div id="divEnviarEmail">
                <button class="ui blue button" type="button" id="btnEnviar">Enviar</button>
            </div>
            <div class="ui hidden divider"></div>
            <div id="divRetorno"></div>               
            <div class="ui hidden divider"></div>      
        </form>
    </div>        
</div>
