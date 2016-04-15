<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/js/util.validate.js"></script>


<script>
validarArea(true);
</script>

<div class="ui form" id="divBusca">
       
    <div class="ui hidden divider"></div>

        <div class="ui top attached tabular menu">
            <a class="active item" data-tab="basico"><i class="search icon"></i>Busca Básica</a>
            <a class="item" data-tab="avancado"><i class="search icon"></i>Busca Avançada</a>
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
                                <div class="item" data-value="apartamentoplanta">Apartamento na Planta</div>
                                <div class="item" data-value="apartamento">Apartamento</div>
                                <div class="item" data-value="salacomercial">Sala Comercial</div>
                                <div class="item" data-value="prediocomercial">Predio Comercial</div>
                                <div class="item" data-value="terreno">Terreno</div>
                            </div>
                        </div>
                    </div>

                    <div class="five field">
                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeFinalidade.jpg">
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
                        <select multiple="" class="ui search dropdown"  name="sltBairro" id="sltBairro">    
                            <option value="">Selecione a Cidade</option>   
                        </select>
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
                        <div class="teal ui icon button" id="btnBuscarAnuncioBasico">
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
                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeFinalidade.jpg">
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
                    <select multiple="" class="ui search dropdown"  name="sltBairroAvancado" id="sltBairroAvancado">    
                        <option value="">Selecione a Cidade</option>   
                    </select>
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

                </div>      

                <div class="fields">

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
                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeAptoAndar.jpg">
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
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                        <label>Banheiro(s)</label>
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
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                        <label>Suite(s)</label>
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
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeGaragem.jpg">
                        <label>Vagas de Garagem</label>
                            <select multiple="" class="ui search dropdown"  name="sltGaragem" id="sltGaragem">    
                                <option value="">Vagas de Garagem</option> 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5 ou mais</option>
                            </select>
                    </div>

            </div>   

        </div>      

            <div class="ui horizontal divider" id="divOutrasCaracteristicas"><div class="ui brown large label">Outras Características</div></div>    

        <div class="row">

            <div class="fields">

                <div class="five wide field" id="divAreaApartamento">                       
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeArea.jpg" width="30px">
                        <label>Área m<sup>2</sup></label>
                        <br>
                        <div class="fields">
                        <div class="seven wide field" id="minArea">
                        <div class="ui fluid search selection dropdown">
                            <input type="hidden" name="sltArea" id="sltAreaMin">
                            <div class="default text">Mínimo</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class='item' data-value="0">Indiferente</div>
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
                            <div class="default text">Máximo</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class='item' data-value="0">Indiferente</div>
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
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuadra.jpg">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconePiscina.jpg">
                        <label>Diferenciais</label>
                        <br>
                        <select multiple="" class="ui search dropdown"  name="carregarDiferenciais" id="carregarDiferenciais">    
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