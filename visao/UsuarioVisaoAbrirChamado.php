<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/js/usuario.js"></script>

<script>
abrirChamadoUsuario();
cancelar("Usuario", "meuPIP");
</script>

<?php
Sessao::gerarToken();
?>

<div class="ui column doubling grid container">

    <div class="row" id="breadcrumb">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>                    
                    <i class="right chevron icon divider"></i>
                    <div class="active section"> 
                        <i class="small icons">
                            <i class="comment outline icon"></i>
                        </i>Fale com PIP Online
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<div class="row">
    <div class="column">
        <form id="form" class="ui form" action="index.php" method="post">
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
            <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrarChamadoUsuario" />
            <input type="hidden" id="hdnUsuario" name="hdnUsuario" value="<?php echo $_SESSION['idusuario']; ?>" />
            <input type="hidden" id="hdnEmailAssunto" name="hdnEmailAssunto" value="Abertura Chamado" />
            <input type="hidden" id="hdnEnviadoPor" name="hdnEnviadoPor" value="PIP Online" />
            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
            <h3 class="ui dividing header">Fale com o PIP Online</h3>
            <div class="ui message">                
                Caro usuário, preencha os campos abaixo para entrar em contato conosco. Em até 3 dias, iremos respondê-lo
            </div>    
            
            <div class="fields">
                    <div class="four wide required field">
                        <label>Tipo de Chamado</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltTipoChamado" id="sltTipoChamado">
                            <div class="text">Selecione</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">Relatar Problema</div>
                                <div class="item" data-value="2">Dúvida</div>
                                <div class="item" data-value="3">Reclamação</div>
                                <div class="item" data-value="4">Elogio</div>
                                <div class="item" data-value="5">Sugestões</div>
                                <div class="item" data-value="6">Outros Assuntos</div>
                            </div>
                        </div>
                    </div>
                    <div class="four wide required field" id="escolhaTipo">
                        <label>Assunto</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltChamado" id="sltChamado">
                            <div class="default text">Escolha o Tipo</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">                               
                            </div>
                        </div>
                    </div>
                
                    <div class="six wide required field" id="assunto">
                        <label>Assunto</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltChamadoAssunto" id="sltChamadoAssunto">
                            <div class="text">Escolha a Opção</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="retornoAssunto">                               
                            </div>
                        </div>
                    </div>
                
                    
                    <div class="eight wide required field" id="assuntoTitulo">
                        <input type="hidden" name="idAssuntoChamado" id="idAssuntoChamado">
                        <div class="required field">
                        <label>Título</label>
                        <input type="text" id="txtAssuntoChamado" name="txtAssuntoChamado" placeholder="Digite o Título" maxlength="50">
                    </div>
                    </div>
                    
            </div>


            <div class="field">
                <label>Descreva abaixo seu chamado</label>
                <textarea rows="2" id="txtMsgChamado" name="txtMsgChamado" maxlength="200"></textarea>
            </div>

            <div class="five wide field" id="duvidaCaptcha">
                <label>Digite o código abaixo:</label>
                <img id="captcha" src="../assets/libs/captcha/securimage/securimage_show.php" alt="CAPTCHA Image" />    
                <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random();
                                return false">
                    <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
            </div>
            <div class="ui hidden divider"></div>
            <div class="ui stackable two column grid container" id="botoesChamado">   
                
                <button class="ui green button" type="button" id="botaoCadastrarChamado">Cadastrar Chamado</button>
   
                <div id="botaoCancelarChamado" >
                    <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
<!--                <a href="index.php" class="ui orange deny button">            
                     Cancelar
                </a>-->
                </div>

            </div>
            
            <div class="ui hidden divider"></div>
            <div id="divRetorno"></div>
            
            <br>
        </form>
        
        <div class="fields" id="botaoVoltar">
            <div class="four wide required field">
                <a href="index.php?entidade=Usuario&acao=meuPIP">
                    <button class="ui orange button">Voltar</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div>

<!-- MODAIS -->
<div class="ui standart modal" id="modalCancelar">
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
        <div class="ui deny red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>
