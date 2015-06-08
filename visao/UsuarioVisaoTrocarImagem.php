<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.additional-methods.min.js"></script>
<!-- JS -->
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/usuario.js"></script>
<script>
    cancelar("Usuario","meuPIP");
    trocarImagem();
</script>

<?php
Sessao::gerarToken();
$tipoImagem = ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca");
$nomeUsuario = $this->getItem()->getNome();
$enderecoImagem = PIPURL . "/fotos/usuarios/" . $this->getItem()->getFoto();
?>
<!-- HTML -->
<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Alterar Imagem</a>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="trocarimagem" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <input type="hidden" id="hdnExcluir" name="hdnExcluir" value="0" />
                <h3 class="ui dividing header" >Foto / Logomarca</h3>
                <div class="ui two column center aligned relaxed fitted stackable grid" style="position: relative">
                    <div class="column">
                        <div class="ui header center aligned"><?php echo $tipoImagem; ?>  Atual</div>
                        <div class="ui small image right aligned ">
                            <?php if ($this->getItem()->getFoto() != "") { ?>
                                <img src="<?php echo $enderecoImagem; ?>" alt="<?php echo $nomeUsuario; ?>">

                            <?php } else { ?>
                                <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" alt="<?php echo $nomeUsuario; ?>">
                            <?php } ?>
                        </div>
                    </div>

                    <div class="center aligned column">
                        <div class="ui header"><?php echo $tipoImagem; ?>  Nova</div>
                          
                        <img id="uploadPreview" src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" width="155" height="140"/><br />
                    
                    <div>   
                        
                        <label for="attachmentName" class="ui teal icon labeled button btn-file">
                        <i class="large file image outline icon"></i>                        
                        <input id="attachmentName" type="file" name="attachmentName" style="display: none"/>Selecionar</label>
                    </div>  
                    </div>
                </div>
                <div class="ui hidden  divider"></div>
                <button class="ui blue button" type="button" id="btnAlterarImagem" disabled="disabled">Alterar Imagem!</button>
                <button class="ui orange button" type="reset" id="btnCancelar">Cancelar</button>
                <button class="ui red button" type="reset" id="btnExcluirImagem">Excluir Imagem</button>
                <div class="ui hidden divider"></div>
            </form>
        </div>
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
        <div class="ui red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>
<div class="ui small modal" id="modalExcluir">
    <i class="close icon"></i>
    <div class="ui red header">
        Excluir imagem
    </div>
    <div class="content">
        <div class="description">
            <div class="ui red header">Deseja realmente Excluir a sua foto?</div>
        </div>
    </div>
    <div class="actions">
        <div class="ui red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>

<script type="text/javascript">
  /*  function PreviewImage(no) {
       
       
       
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("arquivo").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    }*/
</script>