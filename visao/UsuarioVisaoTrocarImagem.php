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

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"> <i class="small photo icon"></i>Alterar Imagem</div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Troque <?php if($tipoImagem != "pf"){echo "sua imagem ";} else echo "seu logotipo"; ?>, 
                selecionando a nova. Se desejar, faça a exclusão</p>
            </div>
        </div>
    </div>
        
</div>

    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="trocarimagem" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <input type="hidden" id="hdnExcluir" name="hdnExcluir" value="0" />
                <div class="ui dividing header"></div>
                <div class="ui two column center aligned relaxed fitted stackable grid" style="position: relative">
                    <div class="column">
                        <div class="ui header center aligned"><?php echo $tipoImagem; ?>  Atual</div>
                        
                            <?php if ($this->getItem()->getFoto() != "") { ?>
                            <div class="ui small image right aligned ">
                                <img src="<?php echo $enderecoImagem; ?>" alt="<?php echo $nomeUsuario; ?>">
                            </div>    
                            <?php } else { ?>
                                <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" alt="<?php echo $nomeUsuario; ?>" width="247" height="200">
                            <?php } ?>
                        
                    </div>

                    <div class="center aligned column">
                        <div class="ui header"><?php echo $tipoImagem; ?>  Nova</div>
                          
                        <img id="uploadPreview" src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" width="247" height="200"/><br />
                    
                    <div>   
                        
                        <label for="attachmentName" class="ui teal icon labeled button btn-file">
                        <i class="large file image outline icon"></i>                        
                        <input id="attachmentName" type="file" name="attachmentName" style="display: none"/>Selecionar</label>
                    </div>  
                    </div>
                </div>
                <div class="ui hidden  divider"></div>
                <button class="ui blue button" type="button" id="btnAlterarImagem" disabled="disabled">Alterar Imagem!</button>
                <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
                <button class="ui red button" type="button" id="btnExcluirImagem">Excluir Imagem</button>
                <div class="ui hidden divider"></div>
            </form>
        </div>
    </div>

<!-- MODAIS -->

<div class="ui small modal" id="modalAlterar">
    <i class="close icon"></i>
    <div class="ui header">
        Alterar imagem
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">Confirmar a troca da imagem?</div>
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

<div class="ui small modal" id="modalCancelar">
    <i class="close icon"></i>
    <div class="header">
        Cancelar Troca
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
<div class="ui small modal" id="modalExcluir">
    <i class="close icon"></i>
    <div class="ui header">
        Excluir imagem
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">Deseja realmente excluir?</div>
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