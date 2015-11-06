<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script>

    cadastrarImovel();
    esconderCamposInicio();
    mascarasFormUsuario();
    cancelar("Usuario", "meuPIP"); //caso estejam os dois parametros vazios, redirecionar para o index
    acoesCEP();
    confirmarCadastroImovel();
    buscarCep();
    preco();

</script>

<?php
Sessao::gerarToken();
?>

    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"> 
                        <i class="small icons">
                            <i class="home icon"></i>
                            <i class="corner add icon"></i>
                        </i>Cadastrar Imóvel</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
                <input type="hidden" id="hdnCEP" name="hdnCEP" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Informações do Imóvel</h3>
                <div class="fields">
                    <div class="four wide required field">
                        <label>Tipo de Imóvel</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltTipo" id="sltTipo">
                            <div class="default text">Escolha o Imóvel</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">Casa</div>
                                <div class="item" data-value="2">Apartamento na Planta</div>
                                <div class="item" data-value="3">Apartamento</div>
                                <div class="item" data-value="4">Sala Comercial</div>
                                <div class="item" data-value="5">Prédio Comercial</div>
                                <div class="item" data-value="6">Terreno</div>
                            </div>
                        </div>
                    </div>

                    <div class="four wide required field" id="divCondicao">
                        <label>Condição</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltCondicao" id="sltCondicao">
                            <div class="default text">Condição</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="novo">Novo</div>
                                <div class="item" data-value="usado">Usado</div>
                            </div>
                        </div>
                    </div>   

                    <div class="three wide required field" id="divNumeroPlantas">
                        <label>Número de Plantas</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltNumeroPlantas" id="sltNumeroPlantas">
                            <div class="default text">Número de Plantas</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <?php
                                for ($plantas = 1; $plantas <= 6; $plantas++) {
                                    echo "<div class='item' data-value='$plantas'>" . $plantas . "</div>";
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                    <div id="divArea" class="three wide field">
                        <div class="field">
                            <label>Área(m<sup>2</sup>)</label>
                            <input type="text" name="txtArea" id="txtArea" placeholder="Informe a Área" maxlength="7">
                        </div>                                     
                    </div>

                </div>
                <div class="fields" id="divPlantaUm"></div>

                <div class="row">
                    <div class="fields" id="divInfoApeCasa">

                    </div>
                </div>

                <div class="fields">                
                    <div id="divInserePlanta">
                        <span id="a"></span>
                        <div class="exemplo"></div>
                    </div>
                </div>

                <div class="one field" id="divDescricao">
                    <div class="field">
                        <label>Identificar este imóvel como:</label>
                        <textarea maxlength="200" id="txtDescricao" name="txtIdentificacao" rows="2" cols="8"></textarea>
                    </div>                    
                </div>

                <div class="fields" id="divApartamento">

                    <div class="two required field" id="divAndares">
                        <label>Nº de Andares do Prédio</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndares" id="sltAndares">
                            <div class="default text">Andares</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <?php
                                for ($andares = 1; $andares <= 40; $andares++) {
                                    echo "<div class='item' data-value='" . $andares . "'>" . $andares . "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div> 


                    <div class="two field" id="divUnidadesAndar">
                        <label>Unidades por Andar</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltUnidadesAndar" id="sltUnidadesAndar">
                            <div class="default text">Número de Aptos</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="sltUnidadesAndar">
                                <?php
                                for ($unidadesAndar = 1; $unidadesAndar <= 10; $unidadesAndar++) {
                                    echo "<div class='item' data-value='" . $unidadesAndar . "'>" . $unidadesAndar . "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>                    

                    <div class="two field" id="divNumeroTorres">
                        <label>Nº de Torres</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltNumeroTorres" id="sltNumeroTorres">
                            <div class="default text">Torres</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="sltNumeroTorres">
                                <?php
                                for ($torres = 1; $torres <= 10; $torres++) {
                                    echo "<div class='item' data-value='" . $torres . "'>" . $torres . "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>   

                    <div class="two field" id="divAndar">
                        <label>Andar do Apartamento</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndar" id="sltAndar">
                            <div class="default text">Andar</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="sltAndar">
                                <?php
                                for ($andar = 1; $andar <= 40; $andar++) {
                                    echo "<div class='item' data-value='" . $andar . "'>" . $andar . "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div> 

                    <div class="three wide field" id="divUnidadesTotal">
                        <div class="field">
                            <label>Total de Unidades</label>                       
                            <input type="text" name="txtTotalUnidades" id="txtTotalUnidades" placeholder="Total de Apartamentos" maxlength="3">
                        </div>
                    </div>

                    <div id="divCondominio" class="one field">
                        <div class=" field">
                            <label>Condominio(R$)</label>
                            <input type="text" name="txtCondominio" id="txtCondominio" placeholder="Valor do Condominio">
                        </div>                                     
                    </div>

                    <div class="ui checkbox" id="chkCobertura">
                        <input type="checkbox" name="chkCobertura" value="chkCobertura">
                        <label>Está na Cobertura</label>
                    </div>

                    <div class="ui checkbox" id="chkSacada">
                        <input type="checkbox" name="chkSacada" value="chkSacada">
                        <label>Possui Sacada</label>
                    </div>

                </div>

                <div class="ui hidden divider"></div>
                <div id="divDiferencial">

                    <h3 class="ui dividing header">Diferencial do Imóvel</h3>
                    <div id="chkDiferencial">                        
                    </div>

                </div>       

                <div class="ui hidden divider"></div>

                <div id="divEndereco">

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
                                <label>Número</label>
                                <input type="text" name="txtNumero" id="txtNumero" placeholder="Informe o nº" maxlength="6">
                            </div>
                            <div class="field">
                                <label>Complemento</label>
                                <input type="text" name="txtComplemento" id="txtComplemento" placeholder="Complemento" maxlength="60">
                            </div>
                        </div>
                    </div>

                </div>

                <h3 class="ui dividing header">Confirmação de Cadastro</h3>

                <a href='#' <button class="ui blue submit button" type="submit" id="btnCadastrar">Cadastrar</button> </a>
                <button class="ui orange button" type="button" id="btnCancelar">Cancelar</button>
            </form>
        </div>
    </div>

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

<script>



</script>