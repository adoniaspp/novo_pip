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
                            <i class="home icon"></i>
                            <i class="corner add icon"></i>
                        </i>Cadastrar Imóvel</div>
                </div>
            </div>
        </div>
    </div>    

    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Cadastre o imóvel que deseja vender, informando as caracteristicas básicas (quartos, banheiros,
                    tamanho, diferenciais, etc). Escolha primeiramente o <strong>Tipo</strong> que deseja cadastrar</p>
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
            <input type="hidden" name="txtBairro" id="txtBairro">
            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
            <h3 class="ui dividing header">Informações do Imóvel</h3>
            <div class="fields">
                <div class="four wide required field">
                    <label>Tipo de Imóvel</label>
                        <select name="sltTipo" id="sltTipo">
                            <option value="">Escolha o Imóvel</option>
                            <option value="1">Casa</option>
                            <option value="2">Apartamento na Planta</option>
                            <option value="3">Apartamento</option>
                            <option value="4">Sala Comercial</option>
                            <option value="5">Prédio Comercial</option>
                            <option value="6">Terreno</option>
                        </select>
                </div>

                <div class="four wide required field" id="divCondicao">
                    <label>Condição</label>
                    <select name="sltCondicao" id="sltCondicao">
                        <option value="">Condição</option>
                        <option value="novo">Novo</option>
                        <option value="usado">Usado</option>
                    </select>
                </div>   

                <div class="three wide required field" id="divNumeroPlantas">
                    <label>Número de Plantas</label>
                    <select name="sltNumeroPlantas" id="sltNumeroPlantas">
                        <option value="">Número de Plantas</option>
                        <?php
                        for ($plantas = 1; $plantas <= 6; $plantas++) {
                            echo "<option value='$plantas'>" . $plantas . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div id="divArea" class="three wide field">
                    <div class="field">
                        <label>Área (m<sup>2</sup>)</label>
                        <input type="text" name="txtArea" id="txtArea" placeholder="Informe a Área" maxlength="6">
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

            <div id="divDiferencialPlanta"></div>

            <div class="ui hidden divider"></div>

            <div class="one field" id="divDescricao">
                <div class="field">
                    <label>Identificar este imóvel como:</label>
                    <textarea maxlength="200" id="txtDescricao" name="txtIdentificacao" rows="2" cols="8"></textarea>
                </div>                    
            </div>

            <div class="fields" id="divApartamento">

                <div class="two required field" id="divAndares">
                    <label>Nº de Andares do Prédio</label>
                    <select name="sltAndares" id="sltAndares">
                        <option value="">Número de Andares</option>
                        <?php
                        for ($andares = 1; $andares <= 40; $andares++) {
                            echo "<option value='" . $andares . "'>" . $andares . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="two field" id="divUnidadesAndar">
                    <label>Unidades por Andar</label>
                    <select name="sltUnidadesAndar" id="sltUnidadesAndar">
                        <option value="">Número de Aptos</option>
                            <?php
                            for ($unidadesAndar = 1; $unidadesAndar <= 10; $unidadesAndar++) {
                                echo "<option value='" . $unidadesAndar . "'>" . $unidadesAndar . "</option>";
                            }
                            ?>
                    </select>
                </div>

                <div class="two field" id="divNumeroTorres">
                    <label>Nº de Torres</label>
                    <select name="sltNumeroTorres" id="sltNumeroTorres">
                        <option value="">Torres</option>
                            <?php
                            for ($torres = 1; $torres <= 10; $torres++) {
                                echo "<option value='" . $torres . "'>" . $torres . "</option>";
                            }
                            ?>
                    </select>
                </div>

                <div class="two field" id="divAndar">
                    <label>Andar do Apartamento</label>
                    <select name="sltAndar" id="sltAndar">
                        <option value="">Andar</option>
                            <?php
                            for ($andar = 1; $andar <= 40; $andar++) {
                                echo "<option value='" . $andar . "'>" . $andar . "</div>";
                            }
                            ?>
                    </select>
                </div>

                <div class="three wide field" id="divUnidadesTotal">
                    <div class="field">
                        <label>Total de Unidades</label>                       
                        <input type="text" name="txtTotalUnidades" id="txtTotalUnidades" placeholder="Total de Apartamentos" maxlength="3">
                    </div>
                </div>

                <div id="divCondominio" class="one field">
                    <div class=" field">
                        <label>Condom&iacute;nio (R$)</label>
                        <input type="text" name="txtCondominio" id="txtCondominio" placeholder="Valor do Condom&iacute;nio">
                    </div>                                     
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
                            <input type="text" name="txtCEP" id="txtCEP" placeholder="Informe o CEP..." maxlength="10">
                            <div class="ui teal button" id="btnCEP">Buscar CEP</div>
                        </div>              
                    </div>
                    <div class="three wide field"><label>Não sabe o CEP? <a href="https://www.correios.com.br/" target="_blank">clique aqui</a></label></div>
                    <div class="five wide field"><div id="msgCEP"></div> </div>
                </div>


                <div id="divCEP" class="ui">
                    <div class="three fields">
                        <div class="disabled field">
                            <label>Cidade</label>
                            <input type="text" name="txtCidade" id="txtCidade" readonly="readonly">
                        </div>
                        <div class="two wide disabled field">
                            <label>Estado</label>
                            <input type="text" name="txtEstado" id="txtEstado" readonly="readonly">
                        </div>
                        <div class="field" id="dropBairro">
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label>Logradouro</label>
                            <input type="text" name="txtLogradouro" id="txtLogradouro">
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
            <!--<h3 class="ui dividing header">Confirmação de Cadastro</h3>-->
            <button class="ui blue submit button" type="button" id="btnCadastrar">Cadastrar</button>
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