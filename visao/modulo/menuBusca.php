<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<link rel="stylesheet" href="assets/libs/icones/font-awesome-4.7.0/css/font-awesome.min.css"></script>

<script>
validarArea(true);
</script>

<div class="ui form" id="divBusca">

        <div class="ui pointing secondary menu" id="tabsTwo">
            <a class="active blue item" data-tab="first"><i class="large search icon"></i>Busca Básica</a>
            <a class="blue item" data-tab="second"><i class="large search icon"></i>Busca Avançada</a>

        </div>
        <div class="ui basic tab segment active" data-tab="first">
            
            <div class="row">

                <div class="fields">
                    
                    
                    
                    <div class="five field">      
  
                    <div class="ui dropdown">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCasa.jpg"> 
                        <input type="hidden" name="sltTipoImovel" id="sltTipoImovel">
                        <div class="text">Tipo de Imóvel</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">                                                         
                                <div class="item" data-value="apartamento">Apartamento</div>
                                <div class="item" data-value="apartamentoplanta">Apartamento na Planta</div>
                                <div class="item" data-value="casa">Casa</div>
                                <div class="item" data-value="prediocomercial">Predio Comercial</div>
                                <div class="item" data-value="salacomercial">Sala Comercial</div>                               
                                <div class="item" data-value="terreno">Terreno</div>
                            </div>
                      </div>
                        
                        <!--<div class="ui selection dropdown" style="background-color: #f8f8f8;">
                            <input type="hidden" name="sltTipoImovel" id="sltTipoImovel">
                            <i class="large building outline icon"></i>
                            <div class='text'>Tipo de Imóvel</div>
                            <i class="large dropdown icon"></i>
                            <div class="menu">                                                         
                                <div class="item" data-value="apartamento">Apartamento</div>
                                <div class="item" data-value="apartamentoplanta">Apartamento na Planta</div>
                                <div class="item" data-value="casa">Casa</div>
                                <div class="item" data-value="prediocomercial">Predio Comercial</div>
                                <div class="item" data-value="salacomercial">Sala Comercial</div>                               
                                <div class="item" data-value="terreno">Terreno</div>
                            </div>
                        </div>-->
                    </div>
                    
                    
                    
                    <div class="five field">   
                        
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeFinalidade.jpg">
                        <div class="ui dropdown">
                        <input type="hidden" name="sltFinalidade" id="sltFinalidade">     
                        <div class="text">Finalidade</div>                                      
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="aluguel">Aluguel</div>
                            <div class="item" data-value="venda">Venda</div>                            
                        </div>
                      </div>
                    <!--<div class="ui selection dropdown" style="background-color: #f8f8f8;">
                        <input type="hidden" name="sltFinalidade" id="sltFinalidade">                    
                        <div class="text">Finalidade</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="aluguel">Aluguel</div>
                            <div class="item" data-value="venda">Venda</div>                            
                        </div>
                    </div>-->
                    </div>

                    <div class="five field">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCidade.jpg">
                        <div class="ui dropdown">
                        <input type="hidden" name="sltCidade" id="sltCidade">     
                        <div class="text">Cidade</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">Belém</div>
                                <div class="item" data-value="2">Ananindeua</div>
                                <div class="item" data-value="3">Marituba</div>
                            </div>
                        <!--<div class="ui selection dropdown" style="background-color: #f8f8f8;">
                            <i class="large industry icon"></i>
                            <input type="hidden" name="sltCidade" id="sltCidade">
                            <div class="text">Cidade</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">Belém</div>
                                <div class="item" data-value="2">Ananindeua</div>
                                <div class="item" data-value="3">Marituba</div>
                            </div>-->
                        </div>
                    </div>
                    <div class="five field">
                        <div class="ui multiple dropdown">
                        <input type="hidden" name="filtroBairro[]" id="filtroBairro">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBairro.jpg">
                            <span class="text">Bairro</span>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                              <div class="ui icon search input">
                                <i class="search icon"></i>
                                <input type="text" placeholder="busca de bairro...">
                              </div>
                              <div class="divider"></div>
                              <div class="header">
                                Escolha os bairros
                              </div>
                              <div class="scrolling menu" id="sltBairro">

                              </div>
                            </div>
                        <!--<select multiple=""  class="ui search dropdown"  name="sltBairro" id="sltBairro" style="background-color: #f8f8f8;">    
                            <option value="">Selecione a Cidade</option>   
                        </select>-->
                        </div>    
                    </div>

                    <div class="five field" id="divCondicao"> 
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCondicao.jpg">
                        <div class="ui dropdown">
                            <input type="hidden" name="sltCondicao" id="sltCondicao">
                            <div class="text">Condição</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="novo">Novo</div>
                                <div class="item" data-value="usado">Usado</div>
                            </div>
                        </div>
                        <!--<div class="ui selection dropdown" style="background-color: #f8f8f8;">
                            <input type="hidden" name="sltCondicao" id="sltCondicao">
                            <div class="text">Condição</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Condição</div>
                                <div class="item" data-value="novo">Novo</div>
                                <div class="item" data-value="usado">Usado</div>
                            </div>
                        </div>-->
                    </div>    

                    <div class="five field" id="divGaragem">
                        
                         

                        <label>Garagem</label>
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="checkgaragem" id="checkgaragem">

                        </div>
                    </div>
                    
                    <div class="five field">            
                        <div class="teal ui icon button" id="btnBuscarAnuncioBasico">
                        <i class="search icon"></i>Filtrar</div>
                    </div>
                    
                </div>      

            </div>
            
        </div>
        <div class="ui basic tab segment" data-tab="second">
            
            <div class="row">

                <div class="fields">

                <div class="five field">
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltTipoImovelAvancado" id="sltTipoImovelAvancado">
                        <i class="large building outline icon"></i>
                        <div class="text">Tipo de Imóvel</div>
                        <i class="large dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="apartamento">Apartamento</div>
                            <div class="item" data-value="apartamentoplanta">Apartamento na Planta</div>
                            <div class="item" data-value="casa">Casa</div>
                            <div class="item" data-value="prediocomercial">Predio Comercial</div>
                            <div class="item" data-value="salacomercial">Sala Comercial</div>                            
                            <div class="item" data-value="terreno">Terreno</div>
                        </div>
                    </div>
                </div>
                <div class="five field">                    
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltFinalidadeAvancado" id="sltFinalidadeAvancado">
                        <div class="text">Finalidade</div>
                        <i class="large dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="aluguel">Aluguel</div>
                            <div class="item" data-value="venda">Venda</div>                          
                        </div>
                    </div>
                </div>
                <div class="five field">                    
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltCidadeAvancado" id="sltCidadeAvancado">                        
                        <div class="text">Cidade</div>
                        <i class="large dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">Belém</div>
                            <div class="item" data-value="2">Ananindeua</div>
                            <div class="item" data-value="3">Marituba</div>
                        </div>
                    </div>
                </div>
                <div class="five field">
                    <select multiple="" class="ui search dropdown"  name="sltBairroAvancado" id="sltBairroAvancado">    
                        <option value="">Selecione a Cidade</option>   
                    </select>
                </div>

                <div class="five field" id="divCondicaoAvancado">
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltCondicaoAvancado" id="sltCondicaoAvancado">
                        <div class="text">Condição</div>
                        <i class="large dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="novo">Novo</div>
                            <div class="item" data-value="usado">Usado</div>
                        </div>
                    </div>
                </div>                                    
                    
                <div class="five field" id="divValorVenda">
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltValor" id="sltValor">
                        <div class="text">Valor</div>
                        <i class="large dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Qualquer Valor</div>
                            <div class='item' data-value=0>Menos de R$100.000</div>
                            <?php
                            $i = 100000;
                            while ($i < 1000000) {
                                print "<div class='item' data-value=" .
                                        $i . ">Entre R$" . number_format($i, 2, ',', '.') . " e R$" . number_format($i + 100000, 2, ',', '.') . "</div>";
                                $i = $i + 100000;
                            }
                            ?>
                            <div class='item' data-value=1000000>Mais de R$1.000.000</div>
                        </div>
                    </div>
                </div>

                <div class="five field" id="divValorAluguel">
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltValor" id="sltValor">
                        <div class="text">Valor</div>
                        <i class="large dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Qualquer Valor</div>
                            <div class='item' data-value=0>Menos de R$500</div>
                            <?php
                            $i = 500;
                            while ($i < 10000) {
                                print "<div class='item' data-value=" .
                                        $i . ">Entre R$" . number_format($i, 2, ',', '.') . " e R$" . number_format($i + 500, 2, ',', '.') . "</div>";
                                $i = $i + 500;
                            }
                            ?>
                            <div class='item' data-value=1000000>Mais de R$10.000</div>
                        </div>
                    </div>
                </div>    
                    
                </div>      
   
                <div class="fields"><!-- DIV QUE FICAVA O VALOR DO IMÓVEL PARA SELEÇÃO--></div>    

            </div>

            <div class="ui horizontal divider"><div id="textoEspecifico"></div></div>    
                
            <div class='ui two column center aligned grid' id="tabelaInicioBusca">
                <div class='ui compact yellow message'><i class='big warning circle icon'></i>Escolha um Tipo de Imóvel para mais opções de busca</div>

            </div>

            <div class="row">

            <div class="fields">                   

                <div class="five field" id="divBairro">                   
                            <select multiple="" class="ui search dropdown"  name="sltBairro" id="sltBairro">    
                                <option value="">Quarto(s)</option> 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5 ou mais</option>
                            </select>
                    </div>
                                       
                    <div class="five field" id="divBanheiro">
                            <select multiple="" class="ui search dropdown"  name="sltBanheiros" id="sltBanheiros">    
                                <option value="">Banheiro(s)</option> 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5 ou mais</option>
                            </select>
                    </div>
                    
                    <div class="five field" id="divSuite">
                            <select multiple="" class="ui search dropdown"  name="sltSuites" id="sltSuites">    
                                <option value="">Suite(s)</option> 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5 ou mais</option>
                            </select>
                    </div>
                    
                    <div class="five field" id="divGaragemAvancado">
                            <select multiple="" class="ui search dropdown"  name="sltGaragem" id="sltGaragem">   
                             <i class="fa fa-area-chart fa-lg"></i>
                                <option value="">Vaga(s) de Garagem</option> 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5 ou mais</option>
                            </select>
                    </div>
                    
                    <div class="five field" id="divUnidadesAndar">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltUnidadesAndar" id="sltUnidadesAndar">
                            <div class="text">Apto(s) por andar</div>
                            <i class="large dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">5</div>
                                <div class="item" data-value="6">6 ou mais</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="five field" id="divAndares">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndares" id="sltAndares">
                            <div class="text">Nº de Andares</div>
                            <i class="large dropdown icon"></i>
                            <div class="menu">
                                <?php 
                                for($andares = 1; $andares <=40; $andares++){
                                echo "<div class='item' data-value='".$andares."'>".$andares."</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div> 
                
            </div>   

        </div>      

        <div class="ui horizontal divider" id="divOutrasCaracteristicas"><div class="ui white large label">Outras Características</div></div>    

        <div class="row">

            <div class="fields">

                <div class="five wide field" id="divAreaApartamento">
                        <div class="fields">
                        <div class="seven wide field" id="minArea">
                        <div class="ui fluid search selection dropdown">
                            <input type="hidden" name="sltArea" id="sltAreaMin">
                            <i class="fa fa-area-chart fa-lg"></i>
                            <div class="text">Área Mínima</div>
                            <i class="large dropdown icon"></i>
                            <div class="menu">
                                <div class='item' data-value="0">Área Mínima</div>
                                 <?php
                                $i = 30;
                                while ($i < 1000) {
                                    print "<div class='item' data-value=" . number_format($i) . ">" . $i . " m<sup>2</sup></div>";
                                    $i = $i + 30;
                                }
                                ?>
                            </div>
                        </div>
                        </div>
                        <div class="seven wide field" id="maxArea">
                        <div class="ui fluid search selection dropdown">
                            <input type="hidden" name="sltArea" id="sltAreaMax">
                            <i class="fa fa-area-chart fa-lg"></i>
                            <div class="text">Área Máxima</div>
                            <i class="large dropdown icon"></i>
                            <div class="menu">
                                <div class='item' data-value="0">Área Máxima</div>
                                 <?php
                                $i = 30;
                                while ($i < 1000) {
                                    print "<div class='item' data-value=" . number_format($i) . ">" . $i . " m<sup>2</sup></div>";
                                    $i = $i + 30;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                    
<!--                    <div class="five field" id="divAreaCasaTerreno">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeArea.jpg">
                        <label>Área m<sup>2</sup></label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltArea" id="sltArea">
                            <div class="default text">Area</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class='item' data-value="">Indiferente</div>
                                <div class='item' data-value=0>Menos de 60</div>
                                <?php
                                $i = 60;
                                while ($i < 500) {
                                    print "<div class='item' data-value=" . number_format($i) . ">Entre " . $i . " e " . number_format($i + 20) . " m<sup>2</sup></div>";
                                    $i = $i + 20;
                                }
                                ?>
                                <div class='item' data-value=240>Mais de 500 m<sup>2</sup></div>
                            </div>
                        </div>
                    </div>  -->
                    
                    <div class="five field" id="divDiferencial">
                        <select multiple="" class="ui search dropdown"  name="carregarDiferenciais" id="carregarDiferenciais">    
                            
                            <option value="">Diferencial</option>   
                        </select>
                    </div>

            </div>   

        </div>
        <br>
            <div class="ui two column center aligned grid">
                <div class="teal ui icon button" id="btnBuscarAnuncioAvancado">
                <i class="search icon"></i> 
                Filtrar
                </div>
            </div>
        <br>
        
        </div>

</div>

<div class="ui divider"></div>