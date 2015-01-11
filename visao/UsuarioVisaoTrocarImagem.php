<script src="assets/js/additional-methods.min.js"></script>

<?php
Sessao::gerarToken();
$tipoImagem = ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca");
$nomeUsuario = $this->getItem()->getNome();
$enderecoImagem = PIPURL . "/fotos/usuarios/" . $this->getItem()->getFoto();
?>

<script>

    $(document).ready(function () {
        $("#btnCancelar").click(function () {
            if (confirm("Deseja cancelar a alteração da imagem?")) {
                location.href = "index.php?entidade=Usuario&acao=meuPIP";
            }
        });

        $("#btnAlterar").click(function () {
            if ($("#form").valid()) {
                $("#form").submit();
            }
        });

        $("#btnExcluir").click(function () {
            if (confirm("Deseja realmente excluir?")) {
                $("#hdnExcluir").val(1);
                $("#arquivo").rules("remove");
                $("#form").submit();
            }
        });
        $.validator.addMethod('filesize', function (value, element, param) {
            // param = size (en bytes) 
            // element = element to validate (<input>)
            // value = value of the element (file name)
            return this.optional(element) || (element.files[0].size <= param)
        });
        $('#form').validate({
            rules: {
                arquivo: {
                    required: true,
                    filesize: 2097152,
                    accept: "jpeg|png|gif"
                }
            },
            messages: {
                arquivo: {
                    required: "Campo obrigatório",
                    filesize: "A imagem deve ser menor que 2MB",
                    accept: "Extensão de Arquivo Inválida"
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function () {
                form.submit();
            }
        });
    });
</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <li class="active">Alterar Imagem</li>
</ol>
    <!-- Alertas -->
    <div class="alert">Altere a Imagem Abaixo</div>
    <form id="form" class="form-horizontal" action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="trocarimagem" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
        <input type="hidden" id="hdnExcluir" name="hdnExcluir" value="0" />

        <div class="row">
            <div class="col-lg-9">
                <table class="table table-striped table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center"><?php echo $tipoImagem; ?> Atual</th>
                            <th style="text-align: center"><?php echo $tipoImagem; ?> Nova</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center">
                                <?php if ($this->getItem()->getFoto() != "") { ?>
                                    <img src="<?php echo $enderecoImagem; ?>" alt="<?php echo $nomeUsuario; ?>" width="160" height="160">

                                <?php } else { ?>
                                    <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" alt="<?php echo $nomeUsuario; ?>" width="160" height="160">
                                <?php } ?>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="sltArquivo">Selecione:</label>
                                    <div class="col-lg-2">
                                        <input  id="arquivo" name="arquivo" type="file"/> <br />
                                    </div>             
                                </div>
                                <br /><br />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="col-lg-offset-2 col-lg-10">
                                                <button id="btnAlterar" type="button" class="btn btn-primary">Alterar</button>
                                                <button id="btnCancelar" type="button" class="btn btn-warning">Cancelar</button>
                                                <button id="btnExcluir" type="button" class="btn btn-danger">Excluir</button>
                                            </div>
                                        </div>                
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>