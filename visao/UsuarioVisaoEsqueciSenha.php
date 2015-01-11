<script src="assets/js/util.validate.js"></script>

<?php
Sessao::gerarToken();
?>
<script>

    $(document).ready(function() {
        $('.alert').hide();
        $("#txtEmail").focusin(function() {
            $('.alert').fadeOut();
        });
        $('#divalert').hide();
        $("#btnCancelar").click(function() {
            if (confirm("Deseja cancelar a alteração da senha?")) {
                location.href = "index.php?entidade=Usuario&acao=meuPIP";
            }
        });

        $("#btnEnviar").click(function() {
            if ($("#form").valid()) {
                $("#form").submit();
            }
        });

        $('#form').validate({
            rules: {
                txtEmail: {
                    email: true,
                    required: true
                }
            },
            messages: {
                txtEmail: {
                    required: "Campo obrigatório"
                },
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
            submitHandler: function() {
                form.submit();
            }
        });
    });
</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <!-- Alertas -->
      <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li class="active">Lembrar Senha</li>
</ol>
    <form id="form" class="form-horizontal" action="index.php" method="post">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="esquecersenha" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
        <div class="form-group">
            <label class="col-lg-3 control-label" for="txtEmail">Email</label>
            <div class="col-lg-3">
                <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe o email cadastrado">
                <!--                            <div id="mensagem" class="col-lg-3 control-label"></div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button id="btnEnviar" type="button" class="btn btn-primary">Enviar</button>
                        <button id="btnCancelar" type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>                
            </div>
        </div>
    </form>
</div>



