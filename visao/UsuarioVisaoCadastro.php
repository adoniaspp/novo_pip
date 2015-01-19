<!-- LIBS -->
<script src="assets/libs/jquery/jquery.maskedinput.min.js"></script>
<script src="assets/libs/jquery/jquery.pwstrength.min.js"></script>
<!-- JS -->
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/usuario.js"></script>
<script>
    cadastrarUsuario();
    mascarasFormUsuario();
    acoesCEP();
    cancelar();
</script>
<?php
Sessao::gerarToken();
?>
<!-- HTML -->
<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Novo Usuário</a>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
                <input type="hidden" id="hdnCEP" name="hdnCEP" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Informações Básicas</h3>
                <div class="fields">
                    <div class="four wide required field">
                        <label>Tipo de Pessoa</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltTipoUsuario" id="sltTipoUsuario">
                            <div class="default text">Física ou Jurídica</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="pf">Pessoa Física</div>
                                <div class="item" data-value="pj">Pessoa Jurídica</div>
                            </div>
                        </div>
                    </div>
                    <div class="twelve wide required field">
                        <label>E-mail</label>
                        <input type="text" name="txtEmail" placeholder="Informe seu e-mail">
                    </div>
                </div>
                <div id="linhaPF" class="two fields">
                    <div class="required field">
                        <label>Nome Completo</label>
                        <input type="text" name="txtNome" placeholder="Informe o seu nome">
                    </div>
                    <div class="required field">
                        <label>CPF</label>
                        <input type="text" name="txtCPF" placeholder="Informe o seu CPF">
                    </div>                    
                </div>
                <div id="linhaPJ1" class="two fields">
                    <div class="required field">
                        <label>Nome da Empresa</label>
                        <input type="text" name="txtNomeEmpresa" placeholder="Informe o Nome da Empresa">
                    </div>
                    <div class="required field">
                        <label>CNPJ</label>
                        <input type="text" name="txtCNPJ" placeholder="Informe o CNPJ da empresa">
                    </div>                    
                </div>
                <div id="linhaPJ2" class="three fields">
                    <div class="required field">
                        <label>Razão Social</label>
                        <input type="text" name="txtRazaoSocial" placeholder="Informe a Razão Social da Empresa">
                    </div>
                    <div class="required field">
                        <label>Responsável</label>
                        <input type="text" name="txtResponsavel" placeholder="Informe o Responsável da Empresa">
                    </div>                    
                    <div class="required field">
                        <label>CPF do Responsável</label>
                        <input type="text" name="txtCPFResponsavel" placeholder="Informe o CPF do Responsável">
                    </div>                    
                </div>
                <h3 class="ui dividing header">Informações de Acesso</h3>
                <div class="three fields">
                    <div class="required field">
                        <label>Login</label>
                        <div class="ui left icon input">
                            <i class="user icon"></i>                            
                            <input type="text" name="txtLogin" placeholder="Informe um login">
                        </div>
                    </div>
                    <div class="required field">
                        <label>Senha</label>
                        <div class="ui left icon input">
                            <input type="password" name="txtSenha" placeholder="Informe uma senha">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    <div class="required field">
                        <label>Confirmação da senha</label>
                        <div class="ui left icon input">
                            <input type="password" name="txtConfirmSenha" placeholder="Repita a senha">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                </div>
                <h3 class="ui dividing header">Endereço</h3>
                <div class="fields">
                    <div class="five wide field">
                        <div class="ui action left icon input">
                            <i class="search icon"></i>
                            <input type="text" placeholder="Informe o seu CEP...">
                            <div class="ui teal button">Buscar CEP</div>
                        </div>              
                    </div>
                    <div class="three wide field"><label>Não sabe o CEP? <a href="#">clique aqui</a></label></div>
                    <div class="five wide field"><div id="alertCEP"></div> </div>
                </div>
                <div id="divCEP" class="six fields">
                    <div class="field">
                        <label>Cidade</label>
                        <input type="text" name="txtCidade" readonly="readonly">
                    </div>
                    <div class="one wide field">
                        <label>Estado</label>
                        <input type="text" name="txtEstado" readonly="readonly">
                    </div>
                    <div class=" field">
                        <label>Bairro</label>
                        <input type="text" name="txtBairro" readonly="readonly">
                    </div>
                    <div class="five wide field">
                        <label>Logradouro</label>
                        <input type="text" name="txtLogradouro" readonly="readonly">
                    </div>
                    <div class="two wide field">
                        <label>Número</label>
                        <input type="text" name="txtNumero" placeholder="Informe o nº">
                    </div>
                    <div class="two wide field">
                        <label>Complemento</label>
                        <input type="text" name="txtComplemento" placeholder="Complemento">
                    </div>
                </div>
                <h3 class="ui dividing header">Telefones</h3>
                <div class="fields">
                    <div class="four wide required field">
                        <label>Tipo</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltTipotelefone" id="sltTipotelefone">
                            <div class="default text">Tipo do telefone</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="Fixo">Fixo</div>
                                <div class="item" data-value="Celular">Celular</div>
                            </div>
                        </div>
                    </div>
                    <div class="four wide required field">
                        <label>Operadora</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltOperadora" id="sltOperadora">
                            <div class="default text">Operadora</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="Oi">Oi</div>
                                <div class="item" data-value="Tim">Tim</div>
                                <div class="item" data-value="Vivo">Vivo</div>
                                <div class="item" data-value="Claro">Claro</div>
                                <div class="item" data-value="Embratel">Embratel</div>
                            </div>
                        </div>
                    </div>
                    <div class="four wide required field">
                        <label>Número</label>
                        <input type="text" name="txtTel" placeholder="Informe o Número">
                    </div>
                    <div class="center aligned column">
                        <br>
                        <div class="teal ui labeled icon button ">
                            <i class="add icon"></i>
                            Adicionar Telefone
                        </div>
                    </div>
                </div>
                <table class="ui compact celled blue table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Operadora</th>
                            <th>Número</th>
                            <th>Opção</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>FIxo</td>
                            <td>Oi</td>
                            <td>00000000</td>
                            <td class="collapsing">
                                <div class="red ui icon button ">
                                    <i class="trash icon"></i>
                                    Excluir
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="ui dividing header" >Foto / Logomarca</h3>
                <div class="ui two column middle aligned relaxed fitted stackable grid" style="position: relative">
                    <div class="column">
                        <div class="ui card">
                            <div class="image">
                                <img src="..//fotos/usuarios/5a5235761b74c97e4fad660f5dde0fa0.jpg">
                            </div>
                            <div class="content">
                                <a class="header">George</a>
                            </div>
                        </div>

                    </div>
                    <div class="ui vertical divider"> </div>
                    <div class="center aligned column">
                        <div class="teal ui labeled icon button">
                            <i class="add icon"></i>
                            Selecionar uma imagem
                        </div>
                    </div>
                </div>
                <h3 class="ui dividing header">Confirmação de Cadastro</h3>
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="confirmacao">
                        <label>Estou de acordo com a <a href="#">política de privacidade</a> e os <a href="#">termos de uso</a> do PIP.</label>
                    </div>
                </div>
                <button class="ui blue submit button" type="submit" id="btnRegistrar">Registrar Agora!</button>
                <button class="ui orange button" type="reset" id="btnCancelar">Cancelar</button>
            </form>
        </div>
    </div>
    <div class="ui hidden divider"></div>
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
<div class="ui standart modal" id="modalConfirmar">
    <i class="close icon"></i>
    <div class="header">
        Confirmar
    </div>
    <div class="content">
        <div class="description">
            <div class="ui piled segment">
                <h4 class="ui header">A header</h4>
                <p>Te eum doming eirmod, nominati pertinacia argumentum ad his. Ex eam alia facete scriptorem, est autem aliquip detraxit at. Usu ocurreret referrentur at, cu epicurei appellantur vix. Cum ea laoreet recteque electram, eos choro alterum definiebas in. Vim dolorum definiebas an. Mei ex natum rebum iisque.</p>
                <p>Audiam quaerendum eu sea, pro omittam definiebas ex. Te est latine definitiones. Quot wisi nulla ex duo. Vis sint solet expetenda ne, his te phaedrum referrentur consectetuer. Id vix fabulas oporteat, ei quo vide phaedrum, vim vivendum maiestatis in.</p>
                <p>Eu quo homero blandit intellegebat. Incorrupte consequuntur mei id. Mei ut facer dolores adolescens, no illum aperiri quo, usu odio brute at. Qui te porro electram, ea dico facete utroque quo. Populo quodsi te eam, wisi everti eos ex, eum elitr altera utamur at. Quodsi convenire mnesarchum eu per, quas minimum postulant per id.</p>
            </div>
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
