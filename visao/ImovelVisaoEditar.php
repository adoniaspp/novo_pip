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
    mascarasFormUsuario();
    cancelar("Imovel", "listarEditar"); //caso estejam os dois parametros vazios, redirecionar para o index
    acoesCEP();
    confirmarCadastroImovel(); //chama o mesmo modal da confirmação do Cadastro
    buscarCep();
    preco();

</script>



<?php
Sessao::gerarToken();
$item = $this->getItem();
/*
echo "<pre>";
var_dump($item);
echo "</pre>";*/

if ($item) {

    foreach ($item as $imovel) {
        ?>

        <?php
        switch ($imovel->getIdTipoImovel()) {
            case "1":
                ?> 
                <script>
                    mostrarCamposEdicaoCasa(1,
                            "<?php echo $imovel->getCondicao(); ?>",
                <?php echo $imovel->getCasa()->getArea(); ?>,
                <?php echo $imovel->getCasa()->getQuarto(); ?>,
                <?php echo $imovel->getCasa()->getBanheiro(); ?>,
                <?php echo $imovel->getCasa()->getSuite(); ?>,
                <?php echo $imovel->getCasa()->getGaragem(); ?>);
                </script>
                <?php
                break;
            case "2":
                $totalPlantas = count($imovel->getPlanta());
                ?> 
                <script>
                    mostrarCamposEdicaoApartamentoPlanta(2,
                <?php echo $imovel->getApartamentoPlanta()->getTotalUnidades(); ?>,
                <?php echo $totalPlantas; ?>);
                </script>  
                <?php
                if ($totalPlantas == 1) {
                    ?>
                    <script>
                        mostrarPlantas(<?php echo $imovel->getPlanta()->getId(); ?>,
                                      "<?php echo $imovel->getPlanta()->getTituloPlanta(); ?>",
                                       <?php echo $imovel->getPlanta()->getQuarto(); ?>,
                                       <?php echo $imovel->getPlanta()->getBanheiro(); ?>,
                                       <?php echo $imovel->getPlanta()->getSuite(); ?>,
                                       <?php echo $imovel->getPlanta()->getGaragem(); ?>,
                                       <?php echo $imovel->getPlanta()->getArea(); ?>);
                    </script>

                    <?php
                } else {
                    
                    $plantasOrdenadas = $imovel->getPlanta();
                    //ordenar as plantas pelo ID
                    usort($plantasOrdenadas, function( $a, $b ) {
                    //ID da planta será usado para comparação
                             return ( $a  -> getId() > $b  -> getId() ) ;
                         });
                    //fim da ordenação
                    foreach ($plantasOrdenadas as $valoresPlanta) {
                        ?>
                        <script>
                            mostrarPlantas(<?php echo $valoresPlanta->getId(); ?>,
                                           <?php echo $valoresPlanta->getOrdemPlantas(); ?>,
                                          "<?php echo $valoresPlanta->getTituloPlanta(); ?>",
                                           <?php echo $valoresPlanta->getQuarto(); ?>,
                                           <?php echo $valoresPlanta->getBanheiro(); ?>,
                                           <?php echo $valoresPlanta->getSuite(); ?>,
                                           <?php echo $valoresPlanta->getGaragem(); ?>,
                                           <?php echo $valoresPlanta->getArea(); ?>);
                                               
                            mostrarDiferencialPlantas(<?php echo $valoresPlanta->getId(); ?>, <?php echo $valoresPlanta->getOrdemPlantas(); ?>);
                            
                        </script>

                    <?php }
                }
                ?>

                <?php
                break;
            case "3":
                ?> 
                <script>
                    mostrarCamposEdicaoApartamento(3,
                            "<?php echo $imovel->getCondicao(); ?>",
                <?php echo $imovel->getApartamento()->getArea(); ?>,
                <?php echo $imovel->getApartamento()->getQuarto(); ?>,
                <?php echo $imovel->getApartamento()->getBanheiro(); ?>,
                <?php echo $imovel->getApartamento()->getSuite(); ?>,
                <?php echo $imovel->getApartamento()->getGaragem(); ?>,
                <?php echo $imovel->getApartamento()->getCondominio(); ?>);
                </script>
                <?php
                break;
            case "4":
                ?> 
                <script>
                    mostrarCamposEdicaoSalaComercial(4,
                            "<?php echo $imovel->getCondicao(); ?>",
                <?php echo $imovel->getSalaComercial()->getArea(); ?>,
                <?php echo $imovel->getSalaComercial()->getBanheiro(); ?>,
                <?php echo $imovel->getSalaComercial()->getGaragem(); ?>,
                <?php echo $imovel->getSalaComercial()->getCondominio(); ?>);
                </script>
                <?php
                break;
            case "5":
                ?> 
                <script>
                    mostrarCamposEdicaoPredioComercial(5,
                            "<?php echo $imovel->getCondicao(); ?>",
                <?php echo $imovel->getPredioComercial()->getArea(); ?>);
                </script>
                <?php
                break;
            case "6":
                ?> 
                <script>
                    mostrarCamposEdicaoTerreno(6,
                <?php echo $imovel->getTerreno()->getArea(); ?>);
                </script>
                <?php
                break;
                ?>
            <?php
        }
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
                    <i class="list small icon"></i><a href="index.php?entidade=Imovel&acao=listarEditar">Imóveis Cadastrados</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"> 
                        <i class="small icons">
                            <i class="home icon"></i>
                            <i class="corner write icon"></i>
                        </i>Editar Imóvel</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Faça a edição do imóvel cadastrado, alterando os campos abaixo</p>
            </div>
        </div>
    </div>
    
</div>

<div class="ui middle aligned stackable grid container">
    <div class="column">
        <form id="form" class="ui form" action="index.php" method="post">
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
            <input type="hidden" id="hdnAcao" name="hdnAcao" value="editar" />
            <input type="hidden" id="hdnCEP" name="hdnCEP" value="<?php echo $imovel->getEndereco()->getCep() ?>"/>
            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
            <h3 class="ui dividing header">Editar Imóvel</h3>

            <div class="fields" id="divInfoBasicas">
                <div class="four wide field">
                    <label>Tipo de Imóvel</label>
                    <input type="hidden" name="sltTipo" id="sltTipo" value="<?php echo $imovel->getIdTipoImovel() ?>">
                    <input type="hidden" name="sltNumeroPlantas" id="sltNumeroPlantas" value="<?php echo $totalPlantas ?>">
<?php echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel()) ?>
                </div>

                <div class="three wide field" id="divNumeroPlantas"></div>

            </div>

            <div id="divInfoApeCasa"></div>
                        
            <div class="one field" id="divDescricao">
                <div class="field">
                    <label>Identificar Este Imóvel Como:</label>
                    <textarea maxlength="200" id="txtDescricao" name="txtIdentificacao" rows="2" cols="8" ><?php echo $imovel->getIdentificacao(); ?></textarea>
                </div>                    
            </div>

            <div class="fields" id="divApartamento">

                <div class="two field" id="divAndares">
                    <label>Nº de Andares do Prédio</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltAndares" id="sltAndares"
                        <?php
                        if ($imovel->getApartamentoPlanta()) {
                            echo "value='" . $imovel->getApartamentoPlanta()->getAndares() . "'";
                        }
                        ?>>
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
                        <input type="hidden" name="sltUnidadesAndar" id="sltUnidadesAndar"

                               <?php
                               if ($imovel->getApartamento()) {
                                   echo "value='" . $imovel->getApartamento()->getUnidadesAndar() . "'";
                               } else if ($imovel->getApartamentoPlanta()) {
                                   echo "value='" . $imovel->getApartamentoPlanta()->getUnidadesAndar() . "'";
                               }
                               ?>

                               >
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
                        <input type="hidden" name="sltNumeroTorres" id="sltNumeroTorres"
                        <?php
                        if ($imovel->getApartamentoPlanta()) {
                            echo "value='" . $imovel->getApartamentoPlanta()->getNumeroTorres() . "'";
                        }
                        ?>

                               >
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
                        <input type="hidden" name="sltAndar" id="sltAndar"
                        <?php
                        if ($imovel->getApartamento()) {
                            echo "value='" . $imovel->getApartamento()->getAndar() . "'";
                        }
                        ?>                                  
                               >       
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

            </div>

            <div class="ui hidden divider"></div>
            <div id="divDiferencial">

                <h3 class="ui dividing header">Diferencial do Imóvel</h3>
                <div id="chkDiferencial">              

                </div>

            </div>       

            <div class="ui hidden divider"></div>

            <div class="fields">
                <div class="five wide field">
                    <div class="ui action left icon input">
                        <i class="search icon"></i>
                        <input type="text" name="txtCEP" id="txtCEP" placeholder="Informe o CEP..." value="<?php echo $imovel->getEndereco()->getCep() ?>">
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
                        <input type="text" name="txtCidade" id="txtCidade" readonly="readonly" value="<?php echo $imovel->getEndereco()->getCidade()->getNome() ?>">
                    </div>
                    <div class="two wide field">
                        <label>Estado</label>
                        <input type="text" name="txtEstado" id="txtEstado" readonly="readonly" value="<?php echo $imovel->getEndereco()->getEstado()->getUF() ?>">
                    </div>
                    <div class="field">
                        <label>Bairro</label>
                        <input type="text" name="txtBairro" id="txtBairro" readonly="readonly" value="<?php echo $imovel->getEndereco()->getBairro()->getNome() ?>">
                    </div>
                </div>
                <div class="two fields">
                    <div class="disabled field">
                        <label>Logradouro</label>
                        <input type="text" name="txtLogradouro" id="txtLogradouro" readonly="readonly" value="<?php echo $imovel->getEndereco()->getLogradouro() ?>">
                    </div>
                    <div class="three wide required field">
                        <label>Número</label>
                        <input type="text" name="txtNumero" id="txtNumero" placeholder="Informe o nº" maxlength="5" value="<?php echo $imovel->getEndereco()->getNumero() ?>">
                    </div>
                    <div class="field">
                        <label>Complemento</label>
                        <input type="text" name="txtComplemento" id="txtComplemento" placeholder="Complemento" maxlength="80" value="<?php echo $imovel->getEndereco()->getComplemento() ?>">
                    </div>
                </div>
            </div>

        <?php }
    }
    ?> 

    <h3 class="ui dividing header">Confirmação de Alteração</h3>

    <a href='#' <button class="ui blue submit button" type="submit" id="btnCadastrar" >Alterar</button></a>
    <button class="ui orange button"  type="button" id="btnCancelar">Cancelar</button>
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
        <div class="ui deny red button">
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
        <div class="ui deny red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>