<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<!-- JS -->
<script src="assets/js/util.validate.js"></script>
<script>
    
    carregaB();      
    esconderCamposInicio();
    mascarasFormUsuario();
    acoesCEP();
    buscarCep();
    
</script>

<?php
Sessao::gerarToken();
?>

<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">          
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Cadastrar Imovel</a>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
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
                                <div class="item" data-value="2">Apartamento na Planta/Novo</div>
                                <div class="item" data-value="3">Apartamento Usado</div>
                                <div class="item" data-value="4">Sala Comercial</div>
                                <div class="item" data-value="5">Terreno</div>
                            </div>
                        </div>
                    </div>
                    
                       <!-- <div class="four wide required field" id="divCondicao">
                            <label>Condição</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltCondicao" id="sltCondicao">
                                <div class="default text">Condição do Apartamento</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <div class="item" data-value="plantaconstrucao">Na Planta/Em Construçao</div>
                                    <div class="item" data-value="novo">Novo</div>
                                </div>
                            </div>
                        </div>    -->
                    
                        <div class="three wide required field" id="divNumeroPlantas">
                            <label>Número de Plantas</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltNumeroPlantas" id="sltNumeroPlantas">
                                <div class="default text">Número de Plantas</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <?php 
                                    for($plantas = 1; $plantas <=4; $plantas++){
                                    echo "<div class='item' data-value='$plantas'>".$plantas."</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            
                        </div>
                    
                        <div id="divArea" class="one field">
                                    <div class="required field">
                                        <label>Área(m2)</label>
                                        <input type="text" name="txtArea" placeholder="Informe a Área">
                                    </div>                                     
                        </div>
                    
                </div>
                <div id="divPlantaUm"></div>
                <div class="fields" id="divInfoApeCasa">
                                     
                    <div class="three wide required field">
                        <label>Quarto(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltQuarto" id="sltQuarto">
                            <div class="default text">Quarto(s)</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">5</div>
                                <div class="item" data-value="6">Mais de 5</div>
                            </div>
                        </div>
                    </div>
                    <div class="three wide required field">
                        <label>Banheiro(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltBanheiro" id="sltBanheiro">
                            <div class="default text">Banheiro(s)</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">Mais de 5</div>
                            </div>
                        </div>
                    </div>
                    <div class="three wide required field">
                        <label>Suite(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltSuite" id="sltSuite">
                            <div class="default text">Suite(s)</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="0">nenhuma</div>
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">Mais de 5</div>
                            </div>
                        </div>
                    </div>
                    <div class="three wide required field">
                        <label>Vagas de Garagem</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltGaragem" id="sltGaragem">
                            <div class="default text">Vaga(s) de Garagem</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="0">nenhuma</div>
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">Mais de 5</div>
                            </div>
                        </div>
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
                        <label>Identificar Este Imóvel Como:</label>
                        <textarea maxlength="100" id="txtDescricao" name="txtIdentificacao" class="form-control" rows="2" cols="8"></textarea>
                    </div>                    
                </div>
                
                
                
                <div class="fields" id="divApartamento">
                    
                    <div class="three required field">
                        <label>Número de Andares do Prédio</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndares" id="sltAndares">
                            <div class="default text">Andares do Prédio</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <?php 
                                for($andares = 1; $andares <=40; $andares++){
                                echo "<div class='item' data-value='".$andares."'>".$andares."</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div> 
                                        
                    <div class="three wide required field" id="divAndar">
                        <label>Andar do Apartamento</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndar" id="sltAndar">
                            <div class="default text">Escolha o Andar</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="sltAndar">
                                <?php 
                                for($andar = 1; $andar <=40; $andar++){
                                echo "<div class='item' data-value='".$andar."'>".$andar."</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div id="divCondominio" class="one field">
                    <div class="required field">
                        <label>Valor do Condominio</label>
                        <input type="text" name="txtCondominio" placeholder="Valor do Condominio">
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
                
                
                <div class="fields" id="divEndereco">
                    <h3 class="ui dividing header">Endereço</h3>                
                        <div class="five wide field">
                            <div class="ui action left icon input">
                                <i class="search icon"></i>
                                <input type="text" name="txtCEP" id="txtCEP" placeholder="Informe o seu CEP...">
                                <div class="ui teal button" id="btnCEP">Buscar CEP</div>
                            </div>              
                        </div>
                    <div class="three wide field"><label>Não sabe o CEP? <a href="#">clique aqui</a></label></div>
                    <div class="five wide field"><div id="alertCEP"></div> </div>
                
                    <div id="divCEP" class="six fields">
                        <div class="field">
                        <label>Cidade</label>
                        <input type="text" name="txtCidade" id="txtCidade" readonly="readonly">
                    </div>
                    <div class="one wide field">
                        <label>Estado</label>
                        <input type="text" name="txtEstado" id="txtEstado" readonly="readonly">
                    </div>
                    <div class=" field">
                        <label>Bairro</label>
                        <input type="text" name="txtBairro" id="txtBairro" readonly="readonly">
                    </div>
                    <div class="seven wide field">
                        <label>Logradouro</label>
                        <input type="text" name="txtLogradouro" id="txtLogradouro" readonly="readonly">
                    </div>
                    <div class="two wide field">
                        <label>Número</label>
                        <input type="text" name="txtNumero" id="txtNumero" placeholder="Informe o nº">
                    </div>
                    <div class="seven wide field">
                        <label>Complemento</label>
                        <input type="text" name="txtComplemento" id="txtComplemento" placeholder="Complemento">
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
                <button class="ui blue submit button" type="submit">Cadastrar</button>
                <button class="ui orange button" type="reset">Cancelar</button>
            </form>
        </div>
    </div>
    <div class="ui hidden divider"></div>
</div>
