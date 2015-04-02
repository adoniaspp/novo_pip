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
    acoesCEP();
    confirmarCadastroImovel(); //chama o mesmo modal da confirmação do Cadastro
    buscarCep();
    preco();
       
</script>



<?php
Sessao::gerarToken();
$item = $this->getItem();


if ($item) {
    
    foreach ($item as $imovel) {

?>

<?php 

    switch ($imovel->getIdTipoImovel()) {
    case "1":
    ?> 
    <script>
    mostrarCamposEdicaoCasa(1,  
                   "<?php echo $imovel->getCondicao();?>", 
                    <?php echo $imovel->getCasa()->getArea();?>,
                    <?php echo $imovel->getCasa()->getQuarto();?>,
                    <?php echo $imovel->getCasa()->getBanheiro();?>, 
                    <?php echo $imovel->getCasa()->getSuite();?>,
                    <?php echo $imovel->getCasa()->getGaragem();?>);
    </script>
    <?php
    break;
    case "2":
    $totalPlantas = count($imovel->getPlanta());
    ?> 
    <script>
    mostrarCamposEdicaoApartamentoPlanta(2,
                    <?php echo $imovel->getApartamentoPlanta()->getTotalUnidades();?>,
                    <?php echo $totalPlantas;?>);
    </script>  
    <?php
            
            
            if($totalPlantas == 1){

            ?>
            <script>
            mostrarPlantas(<?php echo $imovel->getPlanta()->getOrdemPlantas();?>,
                           "<?php echo $imovel->getPlanta()->getTituloPlanta();?>",
                           <?php echo $imovel->getPlanta()->getQuarto();?>,
                           <?php echo $imovel->getPlanta()->getBanheiro();?>,
                           <?php echo $imovel->getPlanta()->getSuite();?>,
                           <?php echo $imovel->getPlanta()->getGaragem();?>,
                           <?php echo $imovel->getPlanta()->getArea();?>);    
            </script>
          
            <?php

            } else {
                
                 foreach($imovel->getPlanta() as $valoresPlanta){

            ?>
            <script>
            mostrarPlantas(<?php echo $valoresPlanta->getOrdemPlantas();?>,
                           "<?php echo $valoresPlanta->getTituloPlanta();?>",
                           <?php echo $valoresPlanta->getQuarto();?>,
                           <?php echo $valoresPlanta->getBanheiro();?>,
                           <?php echo $valoresPlanta->getSuite();?>,
                           <?php echo $valoresPlanta->getGaragem();?>,
                           <?php echo $valoresPlanta->getArea();?>);    
            </script>
            
            <?php } } ?>
            
    <?php
    break;
    case "3":
    ?> 
    <script>
    mostrarCamposEdicaoApartamento(3,  
                   "<?php echo $imovel->getCondicao();?>", 
                    <?php echo $imovel->getApartamento()->getArea();?>,
                    <?php echo $imovel->getApartamento()->getQuarto();?>,
                    <?php echo $imovel->getApartamento()->getBanheiro();?>, 
                    <?php echo $imovel->getApartamento()->getSuite();?>,
                    <?php echo $imovel->getApartamento()->getGaragem();?>,
                    <?php echo $imovel->getApartamento()->getCondominio();?>);
    </script>
    <?php
    break;
    case "4":
    ?> 
    <script>
    mostrarCamposEdicaoSalaComercial(4,  
                   "<?php echo $imovel->getCondicao();?>", 
                    <?php echo $imovel->getSalaComercial()->getArea();?>,
                    <?php echo $imovel->getSalaComercial()->getBanheiro();?>,                      
                    <?php echo $imovel->getSalaComercial()->getGaragem();?>,
                    <?php echo $imovel->getSalaComercial()->getCondominio();?>);
    </script>
    <?php
    break;
    case "5":
    ?> 
    <script>
    mostrarCamposEdicaoPredioComercial(5,  
                   "<?php echo $imovel->getCondicao();?>", 
                    <?php echo $imovel->getPredioComercial()->getArea();?>);
    </script>
    <?php
    break;
    case "6":
    ?> 
    <script>
    mostrarCamposEdicaoTerreno(6, 
                    <?php echo $imovel->getTerreno()->getArea();?>);
    </script>
    <?php
    break;
    ?>
    <?php
    }
    ?>

<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">          
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a href="index.php?entidade=Imovel&acao=listarEditar">Listar Imóveis</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Editar Imóvel</a>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
                <form id="form" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="editar" />
                <input type="hidden" id="hdnCEP" name="hdnCEP" value="<?php echo $imovel->getEndereco()->getCep() ?>"/>
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Informações do Imóvel</h3>
                <div class="fields" id="divInfoBasicas">
                    <div class="four wide field">
                        <label>Tipo de Imóvel</label>
                            <input type="hidden" name="sltTipo" id="sltTipo" value="<?php echo $imovel->getIdTipoImovel()?>">
                             <input type="hidden" name="sltNumeroPlantas" id="sltNumeroPlantas" value="<?php echo $totalPlantas?>">
                            <?php echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel())?>
                    </div>
                    
                       <div class="three wide field" id="divNumeroPlantas">                     
                        <!--   <label>Número de Plantas</label>
                             <div class="ui selection dropdown">
                                <input type="hidden" name="sltNumeroPlantas" id="sltNumeroPlantas" 
                                    <?php /*if($imovel->getApartamentoPlanta()){
                                       $numeroPlantas = count($imovel->getPlanta());
                                       echo "value='".$numeroPlantas."'";
                                   }*/
                                   ?>
                                   
                                   >
                                <div class="default text">Número de Plantas</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <?php 
                                    /*for($plantas = 1; $plantas <=6; $plantas++){
                                    echo "<div class='item' data-value='$plantas'>".$plantas."</div>";
                                    }*/
                                    ?>
                                </div>
                            </div> -->
                            
                      </div>
                    <!-- 
                       <div id="divArea" class="three wide field">
                                    <div class="field">
                                        <label>Área(m2)</label>
                                        <input type="text" name="txtArea" id="txtArea" placeholder="Informe a Área" maxlength="7">
                                    </div>                                     
                        </div>
                 -->   
                </div>
                
                <div class="fields" id="divInfoApeCasa">
               
                
                    <!--<div class="three wide required field">
                        <label>Quarto(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltQuarto[]" id="sltQuarto">
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
                    </div>-->
                    <!--<div class="three wide required field">
                        <label>Banheiro(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltBanheiro[]" id="sltBanheiro">
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
                    </div>-->
                    <!--<div class="three wide required field">
                        <label>Suite(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltSuite[]" id="sltSuite">
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
                    </div>-->
                    <!--<div class="three wide required field">
                        <label>Vagas de Garagem</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltGaragem[]" id="sltGaragem">
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
                    </div>-->
                    
                    <!--<div id="divAreaPlanta" class="one field">
                        <div class="field">
                            <label>Área(m2)</label>
                            <input type="text" name="txtArea[]" id="txtArea" placeholder="Informe a Área">
                        </div>                                     
                    </div>-->
                    
                </div>
            
                <div class="one field" id="divDescricao">
                    <div class="field">
                        <label>Identificar Este Imóvel Como:</label>
                        <textarea maxlength="200" id="txtDescricao" name="txtIdentificacao" class="form-control" rows="2" cols="8" >
                        <?php echo $imovel->getIdentificacao();?>   
                        </textarea>
                    </div>                    
                </div>
                
                
                
                <div class="fields" id="divApartamento">
                    
                    <div class="two field" id="divAndares">
                        <label>Nº de Andares do Prédio</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndares" id="sltAndares"
                                <?php if($imovel->getApartamentoPlanta()){
                                       echo "value='".$imovel->getApartamentoPlanta()->getAndares()."'";
                                   }
                                   ?>
                                   
                                   >
                            <div class="default text">Andares</div>
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
                             
                    <div class="two field" id="divUnidadesAndar">
                        <label>Unidades por Andar</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltUnidadesAndar" id="sltUnidadesAndar"
                                   
                                   <?php if($imovel->getApartamento()){
                                       echo "value='".$imovel->getApartamento()->getUnidadesAndar()."'";
                                   } else if($imovel->getApartamentoPlanta()){
                                       echo "value='".$imovel->getApartamentoPlanta()->getUnidadesAndar()."'";
                                   }
                                   ?>
                                   
                                   >
                            <div class="default text">Numero de Aptos</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="sltUnidadesAndar">
                                <?php 
                                for($unidadesAndar = 1; $unidadesAndar <=10; $unidadesAndar++){
                                echo "<div class='item' data-value='".$unidadesAndar."'>".$unidadesAndar."</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="two field" id="divNumeroTorres">
                        <label>Nº de Torres</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltNumeroTorres" id="sltNumeroTorres"
                                   <?php if($imovel->getApartamentoPlanta()){
                                       echo "value='".$imovel->getApartamentoPlanta()->getNumeroTorres()."'";
                                   }
                                   ?>
                                   
                                   >
                            <div class="default text">Torres</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="sltNumeroTorres">
                                <?php 
                                for($torres = 1; $torres <=10; $torres++){
                                echo "<div class='item' data-value='".$torres."'>".$torres."</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>   
                   
                    <div class="two field" id="divAndar">
                        <label>Andar do Apartamento</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndar" id="sltAndar"
                            <?php if($imovel->getApartamento()){
                                       echo "value='".$imovel->getApartamento()->getAndar()."'";
                                   }
                                   ?>                                  
                                   >       
                            <div class="default text">Andar</div>
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
                  <!-- 
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
                    
                -->    
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
                                <input type="text" name="txtCEP" id="txtCEP" placeholder="Informe o seu CEP..." value="<?php echo $imovel->getEndereco()->getCep()?>">
                                <div class="ui teal button" id="btnCEP">Buscar CEP</div>
                            </div>              
                        </div>
                    <div class="three wide field"><label>Não sabe o CEP? <a href="#">clique aqui</a></label></div>
                    <div class="five wide field"><div id="msgCEP"></div> </div>
                
                    <div id="divCEP" class="six fields">
                        <div class="field">
                        <label>Cidade</label>
                        <input type="text" name="txtCidade" id="txtCidade" readonly="readonly" value="<?php echo $imovel->getEndereco()->getCidade()->getNome()?>">
                    </div>
                    <div class="one wide field">
                        <label>Estado</label>
                        <input type="text" name="txtEstado" id="txtEstado" readonly="readonly" value="<?php echo $imovel->getEndereco()->getEstado()->getUf()?>">
                    </div>
                    <div class=" field">
                        <label>Bairro</label>
                        <input type="text" name="txtBairro" id="txtBairro" readonly="readonly" value="<?php echo $imovel->getEndereco()->getBairro()->getNome()?>">
                    </div>
                    <div class="seven wide field">
                        <label>Logradouro</label>
                        <input type="text" name="txtLogradouro" id="txtLogradouro" readonly="readonly" value="<?php echo $imovel->getEndereco()->getLogradouro()?>">
                    </div>
                    <div class="two required wide field">
                        <label>Número</label>
                        <input type="text" name="txtNumero" id="txtNumero"  maxlength="5" placeholder="Informe o nº" value="<?php echo $imovel->getEndereco()->getNumero()?>">
                    </div>
                    <div class="nine wide field">
                        <label>Complemento</label>
                        <input type="text" name="txtComplemento" id="txtComplemento" maxlength="80" placeholder="Complemento" value="<?php echo $imovel->getEndereco()->getComplemento()?>">
                    </div>
                    </div>
                
                </div>    
<?php }} ?> 
                <h3 class="ui dividing header">Confirmação de Alteração</h3>

                 <a href='#' <button class="ui blue submit button" type="submit" id="btnCadastrar" >Alterar</button></a>
                <button class="ui orange button" type="reset" id="btnCancelar">Cancelar</button>
            </form>
        </div>
    </div>
    <div class="ui hidden divider"></div>
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
        <div class="ui red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>
    
<script>
  /*  
    $(("#btnCadastrar")).click(function () {
        if ($("#form").valid()) {
        $("#modalConfirmar").modal({
            closable: true,
                        transition: "fade up",
                        onDeny: function() {
                            return false;
                        },
                        onApprove: function() {
                            $("#form").submit();
                        }
        }).modal('show');
        } 
    })*/
   </script> 
   
   <script>
        /*
    $(document).ready(function () {
   
    var vetor1 = new Array();

    $("input[id^='slt']").each(function(i){ 
        vetor1.push($(this).val());
    }); 
    
  
    $(("#btnAlterar")).click(function () {
        
        
        for (var x = 0; x < vetor1.length-1; x++){
        $("#modalCondicao").empty();
        var $clone = $('#modalCondicao').clone();
        $clone.attr("id","modalCondicao"+x);
       
        $("#modalCondicao"+x).append(vetor1[x]);
        
        
  //if(vetor1[x] !== vetor1[x]){console.log(vetor1[x]);}

        }
        
        
        
    })
})*/
</script>