<script src="assets/js/util.validate.js"></script>
<script>
    $(document).ready(function() {
<?php
Sessao::gerarToken();
$item = $this->getItem();
if ($item == "errologinsenha") {
    ?>
            $("#divmsgerro").fadeIn('slow');
            $("#divmsgerro").html("<h5>Login ou senhas inválidos!</h5>");
    <?php
}
?>
        $('#form').validate({
            rules: {
                txtLogin: {
                    required: true
                },
                txtSenha: {
                    required: true
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
        });
    })
</script>
<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Identificação de Usuário</h1>
    </div>
    <!-- Example row of columns -->
    <!--    <div class="alert">Todos</div> -->
    <form id="form" class="form-horizontal" action="index.php" method="post">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="autenticar" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
        <div class="form-group">
            <label class="col-lg-3 control-label" for="txtLogin">Login</label>
            <div class="col-lg-2">
                <input type="text" id="txtLogin" name="txtLogin" class="form-control" placeholder="Informe o Login">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label" for="txtSenha">Senha</label>
            <div class="col-lg-2">
                <input type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder="Informe a Senha">
            </div>
        </div> 
        <div class="form-group">
            <div class="col-lg-3"></div>
<!--            <label class="col-lg-3 control-label" for="txtSenha">Senha</label>-->
            <div class="col-lg-3">
                <div class="row text-danger" id="divmsgerro" hidden="true"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <button type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>                
            </div>
        </div>
<!--        <div class="row text-danger" id="divmsgerro" hidden="true"></div>-->
        <div class="form-group">
            <label class="col-lg-5 control-label"><a href="index.php?entidade=Usuario&acao=form&tipo=esquecisenha">Esqueceu sua a senha?</a></label>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label"><a href="index.php?entidade=Usuario&acao=form&tipo=cadastro">Ainda não é cadastrado?</a></label>
        </div>

    </form>
</div>

