<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>

<script>
    
    inicio();
    ordemInicio();
    buscarAnuncio();
    carregarDiferencial();

</script>

<div class="ui hidden divider"></div>
    
    <div class="ui form" id="divBusca">
       
        <div class="ui hidden divider"></div>
                               
            <div class="ui top attached tabular menu">
                <a class="active item" data-tab="basico">Busca Básica</a>
                <a class="item" data-tab="avancado">Busca Avançada</a>
            </div>
            
            <div class="ui bottom attached active tab segment" data-tab="basico">
                    
                <div class="row">
                
                    <div class="fields">
                    
                        <div class="five field">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCasa.jpg">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeApartamento.jpg">
                            <label>Tipo de Imóvel</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltTipoImovel" id="sltTipoImovel">
                                <div class="default text">Tipo</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <div class="item" data-value="">Todos</div>
                                    <div class="item" data-value="casa">Casa</div>
                                    <div class="item" data-value="apartamentoplanta">Apartamento na Planta/Novo</div>
                                    <div class="item" data-value="apartamento">Apartamento</div>
                                    <div class="item" data-value="salacomercial">Sala Comercial</div>
                                    <div class="item" data-value="prediocomercial">Predio Comercial</div>
                                    <div class="item" data-value="terreno">Terreno</div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="five field">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeFinalidade2.jpg">
                        <label>Finalidade</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltFinalidade" id="sltFinalidade">
                            <div class="default text">Finalidade</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Todas</div>
                                <div class="item" data-value="venda">Venda</div>
                                <div class="item" data-value="aluguel">Aluguel</div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="five field">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCidade.jpg">
                            <label>Cidade</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltCidade" id="sltCidade">
                                <div class="default text">Cidade</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <div class="item" data-value="">Todas as Cidades</div>
                                    <div class="item" data-value="1">Belém</div>
                                    <div class="item" data-value="2">Ananindeua</div>
                                    <div class="item" data-value="3">Marituba</div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="five field">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBairro.jpg">
                            <label>Bairro</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltBairro" id="sltBairro">
                                <div class="default text" id="defaultBairro">Selecione a Cidade</div>
                                <i class="dropdown icon"></i>
                                <div class="menu" id="menuBairro">
                                </div>
                            </div>
                        </div>
                        
                        <div class="five field" id="divCondicao">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCondicao.jpg">
                            <label>Condição</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltCondicao" id="sltCondicao">
                                <div class="default text">Condição</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <div class="item" data-value="">Qualquer Condição</div>
                                    <div class="item" data-value="novo">Novo</div>
                                    <div class="item" data-value="usado">Usado</div>
                                </div>
                            </div>
                        </div>    
                    
                        <div class="five field" id="divGaragem">
                            <label>Garagem</label>
                            <div class="ui toggle checkbox">
                                <input type="checkbox" name="checkgaragem" id="checkgaragem">

                            </div>
                        </div>
                      
                    </div>      
                    
                </div>
                
                <div class="ui hidden divider"></div>
                
                <div class="row">
                    <div class="ui center aligned basic segment">
                        <div class="five field">
                            <div class="teal ui icon button" id="btnBuscarAnuncio">
                            <i class="search icon"></i> 
                            Filtrar
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        
                <div class="ui bottom attached tab segment" data-tab="avancado">
                    
                <div class="row">
                    
                    <div class="fields">
                    
                    <div class="five field">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCasa.jpg">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeApartamento.jpg">
                        <label>Tipo de Imóvel</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltTipoImovelAvancado" id="sltTipoImovelAvancado">
                            <div class="default text">Tipo</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Todos</div>
                                <div class="item" data-value="casa">Casa</div>
                                <div class="item" data-value="apartamentoplanta">Apartamento na Planta</div>
                                <div class="item" data-value="apartamento">Apartamento</div>
                                <div class="item" data-value="salacomercial">Sala Comercial</div>
                                <div class="item" data-value="prediocomercial">Predio Comercial</div>
                                <div class="item" data-value="terreno">Terreno</div>
                            </div>
                        </div>
                    </div>
                    <div class="five field">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeFinalidade2.jpg">
                        <label>Finalidade</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltFinalidadeAvancado" id="sltFinalidadeAvancado">
                            <div class="default text">Finalidade</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Todas</div>
                                <div class="item" data-value="venda">Venda</div>
                                <div class="item" data-value="aluguel">Aluguel</div>
                            </div>
                        </div>
                    </div>
                    <div class="five field">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCidade.jpg">
                        <label>Cidade</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltCidadeAvancado" id="sltCidadeAvancado">
                            <div class="default text">Cidade</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Todas</div>
                                <div class="item" data-value="1">Belém</div>
                                <div class="item" data-value="2">Ananindeua</div>
                                <div class="item" data-value="3">Marituba</div>
                            </div>
                        </div>
                    </div>
                    <div class="five field">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBairro.jpg">
                        <label>Bairro</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltBairroAvancado" id="sltBairroAvancado">
                            <div class="default text" id="defaultBairroAvancado">Selecione a Cidade</div>
                            <i class="dropdown icon"></i>
                            <div class="menu" id="menuBairroAvancado">
                            </div>
                        </div>
                    </div>
                        
                    <div class="five field" id="divCondicaoAvancado">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCondicao.jpg">
                        <label>Condição</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltCondicaoAvancado" id="sltCondicaoAvancado">
                            <div class="default text">Condição</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Condição</div>
                                <div class="item" data-value="novo">Novo</div>
                                <div class="item" data-value="usado">Usado</div>
                            </div>
                        </div>
                    </div>    
                    
                    <div class="five field" id="divValorVenda">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeValor.jpg">
                        <label>Valor</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltValor" id="sltValor">
                            <div class="default text">Valor</div>
                            <i class="dropdown icon"></i>
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
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeValor.jpg">
                        <label>Valor</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltValor" id="sltValor">
                            <div class="default text">Valor</div>
                            <i class="dropdown icon"></i>
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
                    
                </div>
                
                    
                    
                <div class="ui horizontal divider"><div id="textoEspecifico"></div></div>    
                
                    <table class="ui very basic table" id="tabelaInicioBusca">
                        <thead>
                            <tr class="center aligned">
                                <td>
                                    <div class="ui compact positive message">
                                        Escolha um Tipo de Imóvel para mais opções de busca
                                    </div> 
                                </td>
                          </tr>
                           
                        </thead>
                    </table>
           
                <div class="row">
            
                <div class="fields">                   
                    
                    <div class="five field" id="divAndares">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeAndaresApto.jpg">
                        <label>Nº de Andares do Prédio</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltAndares" id="sltAndares">
                            <div class="default text">Andares</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Quantidade</div>
                                <?php 
                                for($andares = 1; $andares <=40; $andares++){
                                echo "<div class='item' data-value='".$andares."'>".$andares."</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="five field" id="divUnidadesAndar">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeAptoPorAndar.jpg">
                        <label>Apartamentos por Andar</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltUnidadesAndar" id="sltUnidadesAndar">
                            <div class="default text">Apto(s) por andar</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Quantidade</div>
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">5</div>
                                <div class="item" data-value="6">6 ou mais</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="five field" id="divQuarto">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                        <label>Quarto(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltQuartos" id="sltQuartos">
                            <div class="default text">Quarto(s)</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Quantidade</div>
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">5 ou mais</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="five field" id="divBanheiro">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                        <label>Banheiro(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltBanheiros" id="sltBanheiros">
                            <div class="default text">Banheiro(s)</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Quantidade</div>
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">5 ou mais</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="five field" id="divSuite">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                        <label>Suite(s)</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltSuites" id="sltSuites">
                            <div class="default text">Suite(s)</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Quantidade</div>
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">5 ou mais</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="five field" id="divGaragemAvancado">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeGaragem.jpg">
                        <label>Vagas de Garagem</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltGaragem" id="sltGaragem">
                            <div class="default text">Vagas de Garagem</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="">Qualquer Quantidade</div>
                                <div class="item" data-value="1">1</div>
                                <div class="item" data-value="2">2</div>
                                <div class="item" data-value="3">3</div>
                                <div class="item" data-value="4">4</div>
                                <div class="item" data-value="5">5 ou mais</div>
                            </div>
                        </div>
                    </div>
                    
                </div>   
                
            </div>      
            
                <div class="ui horizontal divider" id="divOutrasCaracteristicas"><div class="ui brown large label">Outras Características</div></div>    
                
            <div class="row">
                    
                <div class="fields">
                
                    <div class="five field" id="divAreaApartamento">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeArea.jpg">
                        <label>Área m<sup>2</sup></label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="sltArea" id="sltArea">
                            <div class="default text">Area</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class='item' data-value="">Indiferente</div>
                                <div class='item' data-value=0>Menos de 40</div>
                                <?php
                                $i = 40;
                                while ($i < 240) {
                                    print "<div class='item' data-value=" . number_format($i) . ">Entre " . $i . " e " . number_format($i + 20) . " m<sup>2</sup></div>";
                                    $i = $i + 20;
                                }
                                ?>
                                <div class='item' data-value=240>Mais de 240 m<sup>2</sup></div>
                            </div>
                        </div>
                    </div>    
                    
                    <div class="five field" id="divAreaCasaTerreno">
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
                    </div>  
                    
                    <div class="five field" id="divDiferencial">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuadra.jpg">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconePiscina.jpg">
                        <label>Diferenciais</label>
                        <select multiple="" class="ui dropdown"  name="carregarDiferenciais" id="carregarDiferenciais">    
                        <option value="" >Indiferente</option>   
                        </select>
                    </div>
                    
                </div>   
                
            </div>                
            
            <div class="row">
                <div class="ui center aligned basic segment">
                <div class="five field">
                    <div class="teal ui icon button" id="btnBuscarAnuncioAvancado">
                    <i class="search icon"></i> 
                    Filtrar
                    </div>
                </div>
                </div>
            </div>       
                    
            </div>

    </div>


<div class="ui center aligned column page grid"></div>
<div id="divOrdenacao" class="ui center aligned basic segment">
    <input type="hidden" id="hdnOrdTipoImovel" name="hdnOrdTipoImovel"/>
    <input type="hidden" id="hdnOrdValor" name="hdnOrdValor"/>
    <input type="hidden" id="hdnOrdFinalidade" name="hdnOrdFinalidade"/>
    <input type="hidden" id="hdnOrdIdcidade" name="hdnOrdIdcidade"/>
    <input type="hidden" id="hdnOrdIdbairro" name="hdnOrdIdbairro"/>
    <input type="hidden" id="hdnOrdQuarto" name="hdnOrdQuarto"/>
    <input type="hidden" id="hdnOrdCondicao" name="hdnOrdCondicao"/>
    <input type="hidden" id="hdnOrdGaragem" name="hdnOrdGaragem"/>   
    <div class="ui selection dropdown">
        <input type="hidden" name="sltOrdenacao" id="sltOrdenacao">
        <div class="default text">Escolha a ordem</div>
        <i class="dropdown icon"></i>
        <div class="menu">
            <div class="item" data-value="preco_maior"><i class="ui chevron up icon"></i>Maior Preço</div>
            <div class="item" data-value="preco_menor"><i class="ui chevron down icon"></i>Menor Preço</div>
            <div class="item" data-value="recente_mais"><i class="ui chevron up icon"></i>Mais Recente</div>
            <div class="item" data-value="recente_menos"><i class="ui chevron down icon"></i>Menos Recente</div>
        </div>
    </div>
</div>

<div class="ui red segment" id="divAnuncios"></div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>





