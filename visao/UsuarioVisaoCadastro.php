<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/usuario.js"></script>

<script>
    cadastrarUsuario();
    mascarasFormUsuario();
    acoesCEP();
    cancelar("", ""); //caso estejam os dois parametros vazios, redirecionar para o index
    confirmar();
    telefone();
</script>
<?php
Sessao::gerarToken();
?>


<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <a class="active section">Cadastrar-se</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">       
        <div class="column">
            <div class="ui message">
                <p>Faça seu cadastro no PIP-Online inserindo os dados abaixo para ter acesso aos nossos serviços
                </p>
            </div>       
        </div>
    </div>

</div>



<div class="ui middle aligned stackable grid container">
    <div class="column">
        <form id="form" class="ui form" action="index.php" method="post" enctype="multipart/form-data">
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
                        <div class="text">Física ou Jurídica</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="pf">Pessoa Física</div>
                            <div class="item" data-value="pj">Pessoa Jurídica</div>
                        </div>
                    </div>
                </div>
                <div class="twelve wide required field">
                    <label>E-mail</label>
                    <input type="text" name="txtEmail" id="txtEmail" placeholder="Informe seu e-mail" maxlength="100">
                </div>
            </div>
            <div id="linhaPF" class="two fields">
                <div class="required field">
                    <label>Nome Completo</label>
                    <input type="text" name="txtNome" id="txtNome" placeholder="Informe o seu nome" maxlength="100">
                </div>
                <div class="required field">
                    <label>CPF</label>
                    <input type="text" name="txtCPF" id="txtCPF" placeholder="Informe o seu CPF">
                </div>                    
            </div>
            <div id="linhaPJ1" class="two fields">
                <div class="required field">
                    <label>Nome da Empresa</label>
                    <input type="text" name="txtNomeEmpresa" id="txtNomeEmpresa" placeholder="Informe o Nome da Empresa" maxlength="100">
                </div>
                <div class="required field">
                    <label>CNPJ</label>
                    <input type="text" name="txtCNPJ" id="txtCNPJ" placeholder="Informe o CNPJ da empresa">
                </div>                    
            </div>
            <div id="linhaPJ2" class="three fields">
                <div class="required field">
                    <label>Razão Social</label>
                    <input type="text" name="txtRazaoSocial" id="txtRazaoSocial" placeholder="Informe a Razão Social da Empresa" maxlength="100">
                </div>
                <div class="required field">
                    <label>Responsável</label>
                    <input type="text" name="txtResponsavel" id="txtResponsavel" placeholder="Informe o Responsável da Empresa" maxlength="100">
                </div>                    
                <div class="required field">
                    <label>CPF do Responsável</label>
                    <input type="text" name="txtCPFResponsavel" id="txtCPFResponsavel" placeholder="Informe o CPF do Responsável">
                </div>                    
            </div>
            <h3 class="ui dividing header">Informações de Acesso</h3>
            <div class="three fields">
                <div class="required field">
                    <label>Nome de Usuário</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>                            
                        <input type="text" name="txtLogin" id="txtLogin" placeholder="Informe um login" maxlength="25">
                    </div>
                </div>
                <div class="required field" id="pwd-container">
                    <label>Senha</label>
                    <div class="ui left icon input">
                        <input type="password" name="txtSenha" id="txtSenha" placeholder="Informe uma senha" maxlength="20">
                        <i class="lock icon"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Confirmação da senha</label>
                    <div class="ui left icon input">
                        <input type="password" name="txtConfirmarSenha" id="txtConfirmarSenha" placeholder="Repita a senha" maxlength="20">
                        <i class="lock icon"></i>
                    </div>
                </div>
            </div>
            <h3 class="ui dividing header">Endereço</h3>
            <div class="fields">
                <div class="five wide field">
                    <div class="ui action left icon input">
                        <i class="search icon"></i>
                        <input type="text" name="txtCEP" id="txtCEP" placeholder="Informe o seu CEP...">
                        <div class="ui teal button" id="btnCEP">Buscar CEP</div>
                    </div>              
                </div>
                <div class="three wide field"><label>Não sabe o CEP? <a href="http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do?Metodo=menuLogradouro" target="_blank">clique aqui</a></label></div>
                <div class="five wide field"><div id="msgCEP"></div> </div>
            </div>
            <div id="divCEP" class="ui">
                <div class="three disabled fields">
                    <div class="field">
                        <label>Cidade</label>
                        <input type="text" name="txtCidade" id="txtCidade" readonly="readonly">
                    </div>
                    <div class="two wide field">
                        <label>Estado</label>
                        <input type="text" name="txtEstado" id="txtEstado" readonly="readonly">
                    </div>
                    <div class="field">
                        <label>Bairro</label>
                        <input type="text" name="txtBairro" id="txtBairro" readonly="readonly">
                    </div>
                </div>
                <div class="two fields">
                    <div class="disabled field">
                        <label>Logradouro</label>
                        <input type="text" name="txtLogradouro" id="txtLogradouro" readonly="readonly">
                    </div>
                    <div class="three wide required field">
                        <label>Número </label>
                        <input type="text" name="txtNumero" id="txtNumero" placeholder="Informe o nº" maxlength="6">
                    </div>
                    <div class="field">
                        <label>Complemento</label>
                        <input type="text" name="txtComplemento" id="txtComplemento" placeholder="Complemento" maxlength="60">
                    </div>
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
                            <div class="item" data-value="NET">NET</div>
                        </div>
                    </div>
                </div>
                <div class="four wide required field">
                    <label>(DDD) Número</label>
                    <input type="text" name="txtTel" id="txtTel" placeholder="Informe o Número">
                </div>


                <div class="four wide field">                   
                    <div class="ui checkbox">
                        <br/><br/>
                        <label>Número WhatsApp</label>
                        <input type="checkbox" name="chkWhatsApp" id="chkWhatsApp">                        
                    </div>  
                    <i class="large green whatsapp icon"></i>

                </div>

            </div>    

            <div class="fields">
                <div class="center aligned column">
                    <br>
                    <div class="teal ui labeled icon button" id="btnAdicionarTelefone">
                        <i class="add icon"></i>
                        Salvar Telefone
                    </div>
                </div>
            </div>    

            <table class="ui compact celled blue table" id="tabelaTelefone">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Operadora</th>
                        <th>Número</th>
                        <th>Nº WhatsApp</th>
                        <th>Opção</th>                           
                    </tr>
                </thead>
                <tbody id="dadosTelefone"></tbody>
            </table>
            <h3 class="ui dividing header" >Foto / Logomarca</h3>
            <div class="twelve wide field">
                <img id="uploadPreview" src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" width="155" height="140"/><br />
                <div class="ui action input">

                    <label for="attachmentName" class="ui teal icon labeled button btn-file">
                        <i class="large file image outline icon"></i>
                        <input type="file" id="attachmentName" name="attachmentName" style="display: none">Selecione a imagem</label>
                </div>
            </div> 
            <h3 class="ui dividing header">Confirmação de Cadastro</h3>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox"  name="chkConfirmacao" id="chkConfirmacao">
                    <label>Estou de acordo com a <a href="#">política de privacidade</a> e os <a href="#">termos de uso</a> do PIP.</label>
                </div>


            </div>

            <div class="five wide field">
                <label>Digite o código abaixo:</label>
                <img id="captcha" src="../assets/libs/captcha/securimage/securimage_show.php" alt="CAPTCHA Image" />    
                <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random(); return false">
                    <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
            </div>

            <h3 class="ui dividing header"></h3>

            <button class="ui blue button" type="button" id="btnRegistrar">Registrar Agora</button>
            <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
        </form>
    </div>
</div>
<div class="ui hidden divider"></div>

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
<div class="ui small modal" id="modalTelefone">
    <i class="close icon"></i>
    <div class="header">
        Nenhum Telefone
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">Você deve informar pelo menos um telefone para contato</div>
        </div>
    </div>
    <div class="actions">
        <div class="ui positive right labeled icon button">
            Ok
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>
<div class="ui standart modal" id="modalConfirmar">
    <i class="close icon"></i>
    <div class="header">
        Confirmar Dados
    </div>
    <div class="content">
        <div class="description">
            <div class="ui piled segment">
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
