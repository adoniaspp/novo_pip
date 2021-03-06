<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<!-- JS -->
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/js/imovel.js"></script>

<?php
Sessao::gerarToken();
$item = $this->getItem();
?>

<script>
    cancelar("Usuario", "meuPIP");
    alterarUsuario();
    mascarasFormUsuario();
    acoesCEP();
    confirmar();
    telefone();
    //carregarBairro("<?php //echo $item[0]->getEndereco()->getCidade()->getNome();?>", "<?php //echo $item[0]->getEndereco()->getBairro()->getNome();?>");
</script>
<?php

if ($item) {
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
                    <div class="active section"> 
                        <i class="small icons">
                            <i class="user icon"></i>
                            <i class="corner write icon"></i>
                        </i>Atualizar Cadastro</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Faça a edição de seus dados cadastrados</p>
            </div>
        </div>
    </div>
</div>            

    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="alterar" />
                <!--<input type="hidden" name="txtBairro" id="txtBairro" value="<?php //echo $usuario->getEndereco()->getBairro()->getNome() ?>">
                <input type="hidden" id="hdnCEP" name="hdnCEP" value="<?php //echo $usuario->getEndereco()->getCep() ?>"/>-->
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Informações Básicas</h3>
                <div class="fields">
                    <div class="four wide field">
                        <label>Tipo de Pessoa</label>
                        <?php if ($usuario->getTipoUsuario() == "pf") {
                            echo "Pessoa Física";
                        } else {
                            echo "Pessoa Jurídica";
                        } ?>
                        <input type="hidden" name="sltTipoUsuario" id="sltTipoUsuario" value="<?php echo $usuario->getTipoUsuario(); ?>">
                    </div>
                    <div class="twelve wide required field">
                        <label>E-mail</label>
                        <input type="text" name="txtEmail" id="txtEmail" placeholder="Informe seu e-mail" value="<?php echo $usuario->getEmail() ?>" maxlength="100">
                    </div>
                </div>
                <div id="linhaPF" class="two fields">
                    <div class="required field">
                        <label>Nome Completo</label>
                        <input type="text" name="txtNome" id="txtNome" placeholder="Informe o seu nome" value="<?php echo $usuario->getNome() ?>" maxlength="100">
                    </div>
                    <div class="field">
                        <label>CPF</label>

                        <?php echo $usuario->getCpfcnpj() ?>

                        <?php if ($usuario->getTipoUsuario() == "pf") {
                            echo "<input type='hidden' id='txtCPF' value='".$usuario->getCpfcnpj()."'>";
                        } ?>

                    </div>                    
                </div>
                <div id="linhaPJ1" class="two fields">
                    <div class="required field">
                        <label>Nome da Empresa</label>
                        <input type="text" name="txtNomeEmpresa" id="txtNomeEmpresa" placeholder="Informe o Nome da Empresa" value="<?php echo $usuario->getNome() ?>" maxlength="100">
                    </div>
                    <div class="field">
                        <label>CNPJ</label>
                        <?php echo $usuario->getCpfcnpj() ?>
                        <?php if ($usuario->getTipoUsuario() == "pj") {
                            echo "<input type='hidden' id='txtCNPJ' value='".$usuario->getCpfcnpj()."'>";
                        } ?>
                    </div>                    
                </div>
                <!--<div id="linhaPJ2" class="three fields">
                    <div class="required field">
                        <label>Razão Social</label>
                        <input type="text" name="txtRazaoSocial" id="txtRazaoSocial" placeholder="Informe a Razão Social da Empresa" value="<?php
                        //if ($usuario->getTipousuario() == "pj") {
                        //    echo $usuario->getEmpresa()->getRazaosocial();
                        //}
                        ?>" maxlength="100">
                    </div>
                    <div class="required field">
                        <label>Responsável</label>
                        <input type="text" name="txtResponsavel" id="txtResponsavel" placeholder="Informe o Responsável da Empresa" value="<?php
                        //if ($usuario->getTipousuario() == "pj") {
                        //    echo $usuario->getEmpresa()->getResponsavel();
                        //}
                        ?>" maxlength="100">
                    </div>                    
                    <div class="required field">
                        <label>CPF do Responsável</label>
                        <input type="text" name="txtCPFResponsavel" id="txtCPFResponsavel" placeholder="Informe o CPF do Responsável" value="<?php
                        //if ($usuario->getTipousuario() == "pj") {
                        //    echo $usuario->getEmpresa()->getCpfresponsavel();
                        //}
                        ?>">
                    </div>                    
                </div>-->
                <!--<h3 class="ui dividing header">Endereço</h3>
                <div class="fields">
                <div class="five wide field">
                    <div class="ui action left icon input">
                        <i class="search icon"></i>
                        <input type="text" name="txtCEP" id="txtCEP" placeholder="Informe o seu CEP..."
                        value="<?php //echo $usuario->getEndereco()->getCep() ?>">
                        <div class="ui teal button" id="btnCEP">Buscar CEP</div>
                    </div>              
                </div>
                <div class="three wide field"><label>Não sabe o CEP? <a href="http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do?Metodo=menuLogradouro" target="_blank">clique aqui</a></label></div>
                <div class="five wide field"><div id="msgCEP"></div> </div>
                </div>-->
                <!--<div id="divCEP" class="ui">
                    <div class="three fields">
                        <div class="disabled field">
                            <label>Cidade</label>
                            <input type="text" name="txtCidade" id="txtCidade" readonly="readonly" value="<?php //echo $usuario->getEndereco()->getCidade()->getNome(); ?>">
                        </div>
                        <div class="two wide disabled field">
                            <label>Estado</label>
                            <input type="text" name="txtEstado" id="txtEstado" readonly="readonly" value="<?php //echo $usuario->getEndereco()->getEstado()->getUf() ?>">
                        </div>
                        <div class="field" id="dropBairro">    
                            
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label>Logradouro</label>
                            <input type="text" name="txtLogradouro" id="txtLogradouro" value="<?php //echo $usuario->getEndereco()->getLogradouro() ?>">
                        </div>
                        <div class="three wide required field">
                            <label>Número</label>
                            <input type="text" name="txtNumero" id="txtNumero" placeholder="Informe o nº" maxlength="6" value="<?php //echo $usuario->getEndereco()->getNumero() ?>">
                        </div>
                        <div class="field">
                            <label>Complemento</label>
                            <input type="text" name="txtComplemento" id="txtComplemento" placeholder="Complemento" maxlength="60" value="<?php //echo $usuario->getEndereco()->getComplemento() ?>">
                        </div>
                    </div>
                </div>-->
                <h3 class="ui dividing header">Telefones</h3> 
                <div class="fields">
                    <!--<div class="four wide required field">
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
                    </div>-->
                    <div class="four wide required field">
                        <label>Operadora</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltOperadora" id="sltOperadora">
                            <div class="default text">Operadora</div>
                            <i class="dropdown icon"></i>
                            <select>
                                <option value="Oi">Oi</option>
                                <option value="Tim">Tim</option>
                                <option value="Vivo">Vivo</option>
                                <option value="Claro">Claro</option>
                                <option value="NET">NET</option>
                            </select>
                            <!--<div class="menu">
                                <div class="item" data-value="Oi">Oi</div>
                                <div class="item" data-value="Tim">Tim</div>
                                <div class="item" data-value="Vivo">Vivo</div>
                                <div class="item" data-value="Claro">Claro</div>
                                <div class="item" data-value="NET">NET</div>
                            </div>-->
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
                            <!--<th>Tipo</th>-->
                            <th>Operadora</th>
                            <th>Número</th>
                            <th>Nº WhatsApp</th>
                            <th>Opção</th>
                        </tr>
                    </thead>
                    <tbody id="dadosTelefone">
                        <?php
                        $quantidade = count($usuario->getTelefone());
                        if ($quantidade == 1) {
                            $array = array($usuario->getTelefone());
                        } else {
                            $array = $usuario->getTelefone();
                        }
                        foreach ($array as $telefone) {
                            ?> 
                            <tr>
                                <!--<td> <input type=hidden id="hdnTipoTelefone[]" name="hdnTipoTelefone[]" value="<?php //echo $telefone->getTipotelefone() ?>"> <?php //echo $telefone->getTipotelefone() ?> </td>-->
                                <td> <input type=hidden id="hdnOperadora[]" name="hdnOperadora[]" value="<?php echo $telefone->getOperadora() ?>"> <?php echo $telefone->getOperadora() ?> </td>
                                <td> <input type=hidden id="hdnTelefone[]" name="hdnTelefone[]" value="<?php echo $telefone->getNumero() ?>"> <?php echo $telefone->getNumero() ?> </td>

                                <?php if($telefone->getWhatsApp()==""){?>                                       
                                <td> <input type='hidden' id='hdnWhatsApp[]' name='hdnWhatsApp[]'>NÃO INFORMADO </td>                                        
                                <?php } else {?>                                       
                                <td> <input type='hidden' id='hdnWhatsApp[]' name='hdnWhatsApp[]' value="<?php echo $telefone->getWhatsApp() ?>"> <?php echo $telefone->getWhatsApp() ?> </td>
                                <?php } ?>
                                <td class='collapsing'> <div class='red ui icon button' onclick='excluirTelefone($(this))'><i class='trash icon'></i>Excluir</div></td>
                            </tr>
                        <?php } ?>     
                    </tbody>
                </table>
                <button class="ui blue button" type="button" id="btnRegistrar">Atualizar</button>
                <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
            </form>
        </div>
    </div>
            <div class="ui hidden divider"></div>
        
        <?php
    }
}
?>
        
        
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
        Confirmar Alteração
    </div>
    <div class="content">
        <div class="description">
            <div class="ui piled segment">
                <p id="textoConfirmacao"></p>
            </div>
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
