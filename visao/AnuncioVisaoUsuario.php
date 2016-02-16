<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=pt"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>


<script>
 
    //$(document).ready(function() {        
        inicio();
        buscarAnuncioUsuario();
        carregarAnuncioUsuario();      
        enviarEmail();      
        carregarDiferencial();
    //})
</script>

<?php 
    
    $item = $this->getItem();
    $usuario = $item["usuario"][0];
    $cidadeEstado = $item["cidadeEstado"][0];
    $anuncios = $item["anuncio"];
    $diferenciais = $item["diferenciais"];
    
    if($usuario->getEndereco()->getNumero() != "" && $usuario->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getNumero().", ".$usuario->getEndereco()->getComplemento();
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() != "" && $usuario->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getNumero();
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() == "" && $usuario->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario->getEndereco()->getLogradouro();                  
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() == "" && $usuario->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getComplemento();
                    }
    
    ?>

<form class="ui form">
    
<div class="ui middle aligned stackable grid container">

        <div class="column">
   
            <div class="ui dividing header">
                
                <div class="ui large teal label">Informações do Vendedor</div>
                    
            </div>
            
            <div class="fields">    
            
            <div class="five wide field">

                <?php if ($usuario->getFoto() != "") { ?>
                    <img width="220px" height="120px" src="<?php echo PIPURL ?>/fotos/usuarios/<?php echo $usuario->getFoto(); ?>" style="" >

                    <?php } else { ?>
                        <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" class="img-circle" width="120px" height="120px">
                    <?php } ?>

            </div>    
         
            
            <div class="six wide field">
                <div class="ui header">
                    <input type="hidden" id="hdUsuario" name="hdUsuario" value="<?php echo $usuario->getId();?>" 
                    <label><?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "Nome";
                            } else echo "Empresa"; ?>
                    </label>
                    <br>
                    <div class="content">                                               
                        <div class="sub header">
                            <?php echo strtoupper($usuario->getNome()); ?>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="five wide field">
                <div class="ui header">
                    <label>Tipo de Pessoa</label>
                    <br>
                    <div class="content">                                               
                        <div class="sub header">
                            <?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "Pessoa Física";
                            } else echo "Pessoa Jurídica"; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="nine wide field">
                <div class="ui header">
                    <label><?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "Endereço";
                            } else echo "Localização"; ?>
                    </label>
                    <br>
                    <div class="content">                                               
                        <div class="sub header">
                        <?php echo $endereco . " - "; ?>
                        <?php echo strtoupper($cidadeEstado->getCidade()->getNome()) . ", " . strtoupper($cidadeEstado->getEstado()->getUf()); ?>
                        </div>
                    </div>
                </div>
            </div>  
                
               
                
        </div>
         
           
    
        <div class="ui dividing header">
                
                <div class="ui large orange label">Contato(s)</div>
                    
        </div>
                
        
            <div class="fields">
                
                <div class="six wide field">
                    
                    
                    <?php
                        $quantidade = count($usuario->getTelefone());
                        if ($quantidade == 1) {
                            $array = array($usuario->getTelefone());
                        } else {
                            $array = $usuario->getTelefone();
                        }
                        foreach ($array as $telefone) {
                            if($telefone->getWhatsApp()=="SIM"){
                                $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero() . "  <i class='large green whatsapp icon'></i> ";
                            }else $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero();
                        }

                        $fonesImplode = implode(" | ", $fones); //retirar a barra do último elemento

                        echo $fonesImplode;
                        ?>
     
                    </div>
                          
            </div>
           
            
    </div>      
    
</div>

</form> 

<div class="ui middle aligned stackable grid container">
 
    <div class="column">

    <div class="ui hidden divider"></div>
    
    <div class="ui dividing header">
                
        <div class="ui large blue label">Anúncio(s) <?php if($usuario->getTipoUsuario() == "pf"){echo "do Vendedor";} else echo "da Empresa";?></div> 
                    
    </div>
    
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
                            <div class="teal ui icon button" id="btnBuscarAnuncioUsuario">
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
    
    <div class="ui hidden divider"></div>
    
    <div class="ui segment" id="divAnuncios"></div> <!-- Exibe os resultados dos anuncios-->
       
</div>
</div>
<script>
  /*  $(document).ready(function() {
    $('[id^=btnAnuncioModal]').click(function() {
            $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
            $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
            $("#modal-body").load("index.php", {hdnEntidade:'Anuncio', hdnAcao:'modal', hdnToken:'<?php //Sessao::gerarToken(); echo $_SESSION["token"]; ?>', hdnModal:$(this).attr('data-modal')});
        })
        
     var NumeroMaximo = 10;
        $("input[id^='selecoes_']").click(function() {
            if ($("input[id^='selecoes_']").filter(':checked').size() > NumeroMaximo) {
                alert('Selecione no máximo ' + NumeroMaximo + ' imóveis para a comparação');
                return false;
            }
        })

        $("#btncomparar").click(function() {
            //alert('teste');
            if ($("input[id^='selecoes_']").filter(':checked').size() <= 1)
            {
                alert('Selecione no mínimo 2 imóveis para a comparação');
                return false;
            }
        })
        
        $("#btnEnviarEmail").click(function() {
            //alert('teste');
            if ($("input[id^='selecoes_']").filter(':checked').size() <= 0)
            {
                alert('Selecione no mínimo 1 imóvel para envio');
                return false;
            }
        })
     
     });
*/

</script>


<!-- Modal Para Abrir a Div do Enviar Anuncios por Email -->
<?php
include_once "/modal/AnuncioEnviarEmailModal.php";
?>