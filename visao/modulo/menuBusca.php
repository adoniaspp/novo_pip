<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<link rel="stylesheet" href="assets/libs/icones/font-awesome-4.7.0/css/font-awesome.min.css"></script>

<script>
    validarArea(true);
</script>

<div class="ui form" id="divBusca" 
     
     style="background-color: #FFFFFF; border-style: solid; border-color: #9d9d9c; border-radius: 30px;
     border-bottom-width: 10px; border-top-width: 10px; border-right-width: 10px; border-left-width: 10px;">

    <div class="ui stackable pointing secondary menu" id="tabsTwo">
        <a class="active blue item" data-tab="first" id="abaBasica"><i class="large search icon"></i>Busca Básica</a>
        <a class="blue item" data-tab="second" id="abaAvancada"><i class="large search icon"></i>Busca Avançada</a>
        
        <?php  
        
        if($menuCorretor){ //verificar se o menu está na página do MySpace do corretor
        
        ?>
        
        <a class="blue item" data-tab="third" id="abaCorretor"><i class="large search icon"></i>Busca por Corretor</a>
        
        <?php } //fim da verificação se o menu está no MySpace do corretor ?>
        
    </div>
    
    <div class="ui basic tab segment active" data-tab="first" id="abaBasicaMenu">
        <div class="ui stackable five column grid"> 
            <div class="column">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltTipoImovel" id="sltTipoImovel">
                    <div class="default text">Tipo de Imóvel</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">   
                        <div class="item" data-value="">Todos os tipos</div>
                        <div class="item" data-value="apartamento">Apartamento</div>
                        <div class="item" data-value="apartamentoplanta">Apartamento na Planta</div>
                        <div class="item" data-value="casa">Casa</div>
                        <div class="item" data-value="prediocomercial">Prédio Comercial</div>
                        <div class="item" data-value="salacomercial">Sala Comercial</div>                               
                        <div class="item" data-value="terreno">Terreno</div>
                    </div>
                </div>  
            </div>
            <div class="column">            
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltFinalidade" id="sltFinalidade">     
                    <div class="default text">Finalidade</div>                                      
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="">Todas as finalidades</div>
                        <div class="item" data-value="aluguel">Aluguel</div>
                        <div class="item" data-value="venda">Venda</div>                            
                    </div>
                </div>
            </div>
            <div class="column">            
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltCidade" id="sltCidade">     
                    <div class="default text">Cidade</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="">Todas as cidades</div>
                        <div class="item" data-value="1">Belém</div>
                        <div class="item" data-value="2">Ananindeua</div>
                        <div class="item" data-value="3">Marituba</div>
                    </div>                       
                </div>
            </div>

            <div class="column">            
                <div class="ui fluid multiple search selection dropdown">
                    <input type="hidden" name="filtroBairro[]" id="filtroBairro">
                    <span class="default text">Bairro</span>
                    <i class="dropdown icon"></i>
                    <div class="menu" id="sltBairro">
                    </div>
                </div>    
            </div>

                        <div class="column" id="divCondicao">             
                            <div class="ui fluid selection dropdown">
                                <input type="hidden" name="sltCondicao" id="sltCondicao">
                                <div class="default text">Condição</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <div class="item" data-value="novo">Novo</div>
                                    <div class="item" data-value="usado">Usado</div>
                                </div>
                            </div>                       
                        </div>    
<!--            <div class="column" id="divGaragem">  
                <div class="ui left floated compact segment">
                    <div class="ui fitted toggle checkbox">
                        <input type="checkbox" name="checkgaragem" id="checkgaragem">
                        
                    </div>
                    <label>Garagem</label>
                </div>
            </div>-->
        </div>
        
        <div class="ui stackable one column centered grid"> 
            <div class="column">
                <div class="teal ui icon button" id="btnBuscarAnuncioBasico">
                    <i class="search icon"></i> 
                    Filtrar
                </div>
            </div>
        </div>
        
    </div>            
    
    <div class="ui basic tab segment" data-tab="second" id="abaAvancadaMenu">

        <div class="ui stackable five column grid"> 
            <div class="column">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltTipoImovelAvancado" id="sltTipoImovelAvancado">
                    <div class="default text">Tipo de Imóvel</div>
                    <i class="large dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="">Todos os tipos</div>
                        <div class="item" data-value="apartamento">Apartamento</div>
                        <div class="item" data-value="apartamentoplanta">Apartamento na Planta</div>
                        <div class="item" data-value="casa">Casa</div>
                        <div class="item" data-value="prediocomercial">Prédio Comercial</div>
                        <div class="item" data-value="salacomercial">Sala Comercial</div>                            
                        <div class="item" data-value="terreno">Terreno</div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltFinalidadeAvancado" id="sltFinalidadeAvancado">
                    <div class="default text">Finalidade</div>
                    <i class="large dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="">Todas as finalidades</div>
                        <div class="item" data-value="aluguel">Aluguel</div>
                        <div class="item" data-value="venda">Venda</div>                          
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltCidadeAvancado" id="sltCidadeAvancado">                        
                    <div class="default text">Cidade</div>
                    <i class="large dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="">Todas as cidades</div>
                        <div class="item" data-value="1">Belém</div>
                        <div class="item" data-value="2">Ananindeua</div>
                        <div class="item" data-value="3">Marituba</div>
                    </div>
                </div>
            </div>

            <div class="column">            
                <div class="ui fluid multiple search selection dropdown">
                    <input type="hidden" name="filtroBairro[]" id="sltBairroAvancado">
                    <span class="default text">Bairro</span>
                    <i class="dropdown icon"></i>
                    <div class="menu" id="sltBairro">
                    </div>
                </div>    
            </div>

            <div class="column">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltCondicaoAvancado" id="sltCondicaoAvancado">
                    <div class="default text">Condição</div>
                    <i class="large dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="novo">Novo</div>
                        <div class="item" data-value="usado">Usado</div>
                    </div>
                </div>
            </div>                                    

            <div class="column" id="divValorVenda">
                <div class="ui fluid selection dropdown">
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

            <div class="column" id="divValorAluguel">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltValor" id="sltValor">
                    <div class="default text">Valor</div>
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

        <!--        <div class="fields"> DIV QUE FICAVA O VALOR DO IMÓVEL PARA SELEÇÃO</div>    -->

        <!--    </div>-->

        <div class="ui horizontal divider"><div id="textoEspecifico"></div></div>    

        <div class='ui two column center aligned grid' id="tabelaInicioBusca">
            <div class='ui compact yellow message'><i class='big warning circle icon'></i>Escolha um Tipo de Imóvel para mais opções de busca</div>

        </div>

        <div class="ui stackable six column grid"> 
            <div class="column" id="divQuarto">
                <div class="ui fluid multiple selection dropdown" name="sltQuarto" id="sltQuarto">
                    <div class="default text">Quarto(s)</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">                                                         
                        <div class="item" data-value="1">1</div>
                        <div class="item" data-value="2">2</div>
                        <div class="item" data-value="3">3</div>
                        <div class="item" data-value="4">4</div>
                        <div class="item" data-value="5">5 ou mais</div>                               
                    </div>
                </div>
            </div>

            <div class="column" id="divBanheiro">
                <div class="ui fluid multiple selection dropdown" name="sltBanheiros" id="sltBanheiros">
                    <div class="default text">Banheiro(s)</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">                                                         
                        <div class="item" data-value="1">1</div>
                        <div class="item" data-value="2">2</div>
                        <div class="item" data-value="3">3</div>
                        <div class="item" data-value="4">4</div>
                        <div class="item" data-value="5">5 ou mais</div>                               
                    </div>
                </div>
            </div>

            <div class="column" id="divSuite">
                <div class="ui fluid multiple selection dropdown" name="sltSuites" id="sltSuites">
                    <div class="default text">Suite(s)</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">                                                         
                        <div class="item" data-value="1">1</div>
                        <div class="item" data-value="2">2</div>
                        <div class="item" data-value="3">3</div>
                        <div class="item" data-value="4">4</div>
                        <div class="item" data-value="5">5 ou mais</div>                               
                    </div>
                </div>
            </div>

            <div class="column" id="divGaragemAvancado">
                <div class="ui fluid multiple selection dropdown" name="sltGaragem" id="sltGaragem">
                    <div class="default text">Garagem</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">                                                         
                        <div class="item" data-value="1">1</div>
                        <div class="item" data-value="2">2</div>
                        <div class="item" data-value="3">3</div>
                        <div class="item" data-value="4">4</div>
                        <div class="item" data-value="5">5 ou mais</div>                               
                    </div>
                </div>
            </div>

            <div class="column" id="divUnidadesAndar">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltUnidadesAndar" id="sltUnidadesAndar">
                    <div class="default text">Apto(s) por andar</div>
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

            <div class="column" id="divAndares">
                <div class="ui fluid selection dropdown">
                    <input type="hidden" name="sltAndares" id="sltAndares">
                    <div class="default text">Nº de Andares</div>
                    <i class="large dropdown icon"></i>
                    <div class="menu">
                        <?php
                        for ($andares = 1; $andares <= 40; $andares++) {
                            echo "<div class='item' data-value='" . $andares . "'>" . $andares . "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div> 

        </div>   

        <div class="ui horizontal divider" id="divOutrasCaracteristicas"><div class="ui white large label">Outras Características</div></div>    

        <div class="ui stackable three column grid" id="divAreaApartamento"> 

            <div class="column" id="minArea">
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="sltArea" id="sltAreaMin">
                    <div class="default text">Área Mínima</div>
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
            <div class="column" id="maxArea">
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="sltArea" id="sltAreaMax">
                    <div class="default text">Área Máxima</div>
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
            <div class="column" id="divDiferencial">        
                <div class="ui fluid multiple search selection dropdown">    
                    <div class="default text">Diferencial</div>
                    <i class="large dropdown icon"></i>
                    <div class="menu" name="carregarDiferenciais" id="carregarDiferenciais">

                    </div>
                </div>
            </div>

        </div>   
        
        <div class="ui stackable one column centered grid"> 
            <div class="column">
                <div class="teal ui icon button" id="btnBuscarAnuncioAvancado">
                    <i class="search icon"></i> 
                    Filtrar
                </div>
            </div>
        </div>
        
        </div>
    
        <?php  
        
        if($menuCorretor){ //verificar se o menu está na página do MySpace do corretor
        
        ?>
    
        <div class="ui basic tab segment active" data-tab="third" id="porCorretor">
            
            <div class="ui stackable four column grid" id="divBuscaCorretor"> 
                <div class="column">            
                    <div class="ui fluid multiple search selection dropdown">
                        <input type="hidden" name="filtroCorretor[]" id="sltCorretorAvancado">
                        <span class="default text">Corretor(res)</span>
                        <i class="dropdown icon"></i>
                        <div class="menu" id="sltCorretor">
                        </div>
                    </div>    
                </div>
            </div>
            
            <div class="ui stackable one column centered grid"> 
                <div class="column">
                    <div class="teal ui icon button" id="btnBuscarAnuncioCorretor">
                        <i class="search icon"></i> 
                        Filtrar
                    </div>
                </div>
            </div>
            
        </div>
    
    <br>
        <?php } //fim da verificação se o menu está no MySpace do corretor?>
</div>