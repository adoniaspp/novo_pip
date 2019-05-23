<script src="assets/js/usuario.js"></script>


<script>
    cancelar("Usuario", "meuPIP");
    editarConfiguracao();
</script>
<?php
Sessao::gerarToken();
$item = $this->getItem();

foreach ($item as $usuario) {

?>
<div class="ui middle aligned stackable grid container">
    <div class="row" id="breadcrumb">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"> <i class="small configure icon"></i>Configurações</div>
                </div>
            </div>
        </div>
     </div>   
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Altere suas configurações e preferências ao exibir suas informações na sua página</p>
            </div>
        </div>
    </div>

</div>   

    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="editarConfiguracoes" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Modifique suas informações exibidas em sua página</h3>
                <div class="three fields" id="divMudarConfiguracoes">

                        <div class="field">
                            <div class="ui toggle checkbox">
                                <?php if ($usuario->getExibirEndereco() == 'SIM') { ?>
                                    <input name="chkEndereco" id="chkEndereco" type="checkbox" value="SIM" checked="checked">
                                <?php } else { ?>
                                    <input name="chkEndereco" id="chkEndereco" type="checkbox" value="SIM">
                                <?php } ?>

                                <label>Exibir Meu Endereço</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui toggle checkbox">
                                <?php if ($usuario->getExibirContato() == 'SIM') { ?>
                                    <input name="chkContato" id="chkContato" type="checkbox" value="SIM" checked="checked">
                                <?php } else { ?>
                                    <input name="chkContato" id="chkContato" type="checkbox" value="SIM">
                                <?php } ?>
                                <label>Exibir Minhas Informações de Contato</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui toggle checkbox">
                                <?php if ($usuario->getExibirAnuncios() == 'SIM') { ?>
                                    <input name="chkAnuncios" id="chkAnuncios" type="checkbox" value="SIM" checked="checked">
                                <?php } else { ?>
                                    <input name="chkAnuncios" id="chkAnuncios" type="checkbox" value="SIM">
                                <?php } ?>

                                <label>Exibir Meus Anúncios Publicados</label>
                            </div>
                        </div>
                </div>  
                
                <div class="two fields" id="divMudarConfiguracoesEmail">
                
                <div class="field">
                        <div class="ui toggle checkbox">
                            <?php //if ($usuario->getExibirEndereco() == 'SIM') { ?>
                                <input name="chkEmail" id="chkEmail" type="checkbox" value="SIM" checked="checked">
                            <?php //} else { ?>
                                <input name="chkEmail" id="chkEmail" type="checkbox" value="SIM">
                            <?php //} ?>

                            <label>Receber e-mails de alerta do PIP (dúvidas de usuários, anúncios aprovados, etc.)</label>
                        </div>
                </div>
                    
                </div>    
                
                <div id="divDesabilitarPagina">
                
                    <div class='ui compact yellow message'><i class='big warning circle icon'>                    
                        </i>ATENÇÃO: A opção abaixo desabilita a visualização de sua página!
                    </div>

                    <div class="one field">

                        <div class="field">
                                <div class="ui toggle checkbox">
                                    <?php if ($usuario->getStatus() == 'ativo') { ?>
                                        <input name="chkStatus" id="chkStatus" type="checkbox" value="ativo" checked="checked">
                                    <?php } else { ?>
                                        <input name="chkStatus" id="chkStatus" type="checkbox" value="ativo">
                                    <?php } ?>

                                    <label>Habilitar a Visualização de Minha Página</label>
                                </div>
                            </div>
                    </div>
                </div>
                
                <div class="ui hidden divider"></div>

                <div id="divBotoesTrocarSenha">
                    <button class="ui blue button" type="button" id="btnAlterarConfiguracoes">Alterar</button>
                    <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
                </div>

                <div class="ui hidden divider"></div>
                <div id="divRetorno"></div>               
                <div class="ui hidden divider"></div>

            </form>
        </div>

    </div>
<?php } ?>
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

<div class="ui standart modal" id="modalConfiguracoes">
    <i class="close icon"></i>
    <div class="header">
        Confirmar Alterações
    </div>
    <div class="content">
        <div class="description">
            <div class="ui basic segment">
                <p id="textoConfirmacao"></p>
            </div>
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