<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>
<script src="assets/js/mask.js"></script>

<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">          
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Imóveis Cadastrados</a>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>

        <table class="ui table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Data Cadastro</th>
                    <th>Detalhes</th>
                    <th>Operações</th>
                </tr>
            </thead>
            <tbody>
                
    <?php
    
    $params = array(
    'mode'       => 'Sliding',
    'perPage'    => 5,
    'dela'       => 2,
    'itemData'   => $this->getItem());
    
    $pager = & Pager::factory($params);
    $data  = $pager->getPageData();
            
    Sessao::gerarToken(); 
    /*echo "<pre>";
    var_dump($this->getItem());
    echo "</pre>";*/
    foreach($data as $imovel){ /*echo "<pre>"; var_dump($imovel);echo "</pre>";*/?>
                
               
                
               <tr>        
        <?php
                        
        echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel());
                        
        echo "<td>".$imovel->getIdentificacao()."</td>";
                        
        echo "<td>".$imovel->getDatahoracadastro()."</td>";
                        
        echo "<td><a href='#' class='ui teal button' id='detalhes".$imovel->getId()."' >Detalhes</div></td>" ;
       
        if(count($imovel->getAnuncio())>0 && verificaAnuncioAtivo($imovel->getAnuncio())){echo"<td><div class='ui compact message'>Imóvel com Anúncio Ativo</div></td>";}
          else {              
             echo "<td><a href=index.php?entidade=Imovel&acao=selecionar&id=".$imovel->getId().'&token='.$_SESSION['token']."  id='editar".$imovel->getId()."'><div class='ui green button'>Editar</div></a></td>";             
                if(count($imovel->getAnuncio())>0){echo"<td><div class='ui compact message'>Imóvel possui anúncio. Não é possível excluir</div></td>";}
             else{
             echo "<td><a href=index.php?entidade=Imovel&acao=excluir&id=".$imovel->getId().'&token='.$_SESSION['token']." id='excluir".$imovel->getId()."''><div class='ui red button'>Excluir</div></a></td>";}
          }
       
        }
    ?>                    
               </tr>         
            </tbody>
        </table>
        <?php
            $links = $pager->getLinks();
            echo ($links['all']!="" ? "&nbsp;&nbsp;&nbsp;&nbsp;Página: ".$links['all'] : ""); 
        ?>
    </div>
    <div class="ui hidden divider"></div>
    
<?php

foreach($this->getItem() as $modal){?>
<div class="ui modal" id='modal<?php echo $modal->getId()?>'>
  <i class="close icon"></i>
  <div class="header">
    Detalhes do Imóvel
  </div>
  <div class="content">
    <div class="description">
        <?php

                     echo  "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Tipo</div>
                                    ".$modal->buscarTipoImovel($modal->getIdTipoImovel())."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Descrição</div>
                                    ".$modal->getIdentificacao()."
                                  </div>
                                </div>
                            </div>
                            <div class='ui hidden divider'></div>";
                  
                    switch ($modal->getIdTipoImovel()) {
                      case "1":
                           
                      echo  "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condição</div>
                                    ".strtoupper($modal->getCondicao())."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Quarto(s)</div>
                                    ".$modal->getCasa()->getQuarto()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Vagas de Garagem</div>
                                    ".$modal->getCasa()->getGaragem()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Banheiro(s)</div>
                                    ".$modal->getCasa()->getBanheiro()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Suite(s)</div>
                                    ".$modal->getCasa()->getSuite()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    ".$modal->getCasa()->getArea()."
                                  </div>
                                </div>
                            </div>";
                            break;

                        case "2":
                            
                        echo  "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Número de Andares</div>
                                    ".$modal->getApartamentoPlanta()->getAndares()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Unidades por Andar</div>
                                    ".$modal->getApartamentoPlanta()->getUnidadesAndar()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Número de Torres</div>
                                    ".$modal->getApartamentoPlanta()->getNumeroTorres()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Total de Unidades</div>
                                    ".$modal->getApartamentoPlanta()->getTotalUnidades()."
                                  </div>
                                </div>                              
                            </div>";
                            
                         /*   echo "<div class='fields'><div class='four wide field'>
                                                      <label>Número de Andares: </label>" . $modal->getApartamentoPlanta()->getAndares() . "</div>
                                                      <div class='four wide field'>
                                                      <label>Unidades por Andar: </label>" . $modal->getApartamentoPlanta()->getUnidadesAndar() . "</div>
                                  </div>";                           
                            echo "Número de Torres: " . $modal->getApartamentoPlanta()->getNumeroTorres() . "<br />";
                            echo "Total de Unidades: " . $modal->getApartamentoPlanta()->getTotalUnidades() . "<br />";
                            echo "<div class='ui dividing header'></div>";*/
                            
                            $numeroPlantas = count($modal->getPlanta());
                            
                            if($numeroPlantas == 1){                           
                            
                                echo "<div class='ui hidden divider'></div>                                   
                                <div class='ui horizontal list'>
                                    <div class='item'>
                                      <div class='content'>
                                        <div class='header'>Total de Plantas</div>
                                        ".$numeroPlantas."
                                      </div>
                                    </div>
                                </div>
                                
                                <table class='ui table'>
                                <thead>
                                    <tr>
                                        <th>Titulo da Planta</th>
                                        <th>Quarto(s)</th>
                                        <th>Banheiro(s)</th>
                                        <th>Suite(s)</th>
                                        <th>Vaga(s) de Garagem</th>
                                        <th>Área m<SUP>2</SUP></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>";

                                      
                                foreach($modal->getPlanta() as $valoresPlanta){
                                    echo "<td>". $valoresPlanta->getTituloPlanta()."</td>";
                                    echo "<td>". $valoresPlanta->getQuarto()."</td>";
                                    echo "<td>". $valoresPlanta->getBanheiro()."</td>";
                                    echo "<td>". $valoresPlanta->getSuite()."</td>";
                                    echo "<td>". $valoresPlanta->getGaragem()."</td>";
                                    echo "<td>". $valoresPlanta->getArea()."</td>";
                                }   
                                
                                echo "</tr></tbody></table>";
                                
                             } else{
                               
                          echo "<div class='ui hidden divider'></div>                                   
                                    <div class='ui horizontal list'>
                                      <div class='item'>
                                      <div class='content'>
                                        <div class='header'>Total de Plantas</div>
                                        ".$numeroPlantas."
                                      </div>
                                    </div>
                                </div>
                                <table class='ui table'>
                                <thead>
                                    <tr>
                                        <th>Titulo da Planta</th>
                                        <th>Quarto(s)</th>
                                        <th>Banheiro(s)</th>
                                        <th>Suite(s)</th>
                                        <th>Vaga(s) de Garagem</th>
                                        <th>Área m<SUP>2</SUP></th>
                                    </tr>
                                </thead>
                                <tbody>";
                                
                                foreach($modal->getPlanta() as $valoresPlanta){ 
                                    echo "<tr>";
                                    echo "<td>". $valoresPlanta->getTituloPlanta()."</td>";
                                    echo "<td>". $valoresPlanta->getQuarto()."</td>";
                                    echo "<td>". $valoresPlanta->getBanheiro()."</td>";
                                    echo "<td>". $valoresPlanta->getSuite()."</td>";
                                    echo "<td>". $valoresPlanta->getGaragem()."</td>";
                                    echo "<td>". $valoresPlanta->getArea()."</td>";
                                    
                                }   
                                echo "</tr></tbody></table>";
                             }
                            
                            break;
                        case "3":
                            
                            echo  "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condição</div>
                                    ".strtoupper($modal->getCondicao())."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Quarto(s)</div>
                                    ".$modal->getApartamento()->getQuarto()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Vagas de Garagem</div>
                                    ".$modal->getApartamento()->getGaragem()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Banheiro(s)</div>
                                    ".$modal->getApartamento()->getBanheiro()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Suite(s)</div>
                                    ".$modal->getApartamento()->getSuite()."
                                  </div>
                                </div>                               
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Andar do Apartamento</div>
                                    ".$modal->getApartamento()->getAndar()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Apartamentos por Andar</div>
                                    ".$modal->getApartamento()->getUnidadesAndar()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    ".$modal->getApartamento()->getArea()."
                                  </div>
                                </div>
                            </div>";
                            break;  
                        
                        case "4":     
                            
                            
                        echo  "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condição</div>
                                    ".strtoupper($modal->getCondicao())."
                                  </div>
                                </div>                                
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Vagas de Garagem</div>
                                    ".$modal->getSalaComercial()->getGaragem()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Banheiro(s)</div>
                                    ".$modal->getSalaComercial()->getBanheiro()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condomínio</div>
                                    ".$modal->getSalaComercial()->getCondominio()."
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    ".$modal->getSalaComercial()->getArea()."
                                  </div>
                                </div>                               
                            </div>";
                            break;
                        
                        case "5":     
                       echo  "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    ".$modal->getPredioComercial()->getArea()."
                                  </div>
                                </div>
                              </div>";
                            break;
                        
                        case "6":
                            echo  "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    ".$modal->getTerreno()->getArea()."
                                  </div>
                                </div>
                              </div>";
                            break;
                    }
                    echo "<div class='ui dividing header'></div>";
                    
                    if($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() != ""){
                    $endereco = $modal->getEndereco()->getLogradouro().", ".$modal->getEndereco()->getNumero().", ".$modal->getEndereco()->getComplemento();
                    }
                    
                    elseif($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() == ""){
                    $endereco = $modal->getEndereco()->getLogradouro().", ".$modal->getEndereco()->getNumero();
                    }
                    
                    elseif($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() == ""){
                    $endereco = $modal->getEndereco()->getLogradouro();                  
                    }
                    
                    elseif($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() != ""){
                    $endereco = $modal->getEndereco()->getLogradouro().", ".$modal->getEndereco()->getComplemento();
                    }
                    
                    echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Endereço</div>
                                    ".$endereco."<br />
                                    ".$modal->getEndereco()->getBairro()->getNome().", ".$modal->getEndereco()->getCidade()->getNome()." - ".$imovel->getEndereco()->getEstado()->getUf()."
                                  </div>
                                </div>                               
                          </div>";
              
                    ?>
    </div>
  </div>
  <div class="actions">
    <div class="ui button">FECHAR</div>
  </div>
  </div> 
    
   <script>
    $(("#detalhes<?php echo $modal->getId()?>")).click(function () {

        $("#modal<?php echo $modal->getId()?>").modal({
            closable: false,
            transition: "fade up",
        }).modal('show');

    })
   </script> 
   
  <?php }

function verificaAnuncioAtivo($listaAnuncios) {
   $temAnuncioAtivo = false;
   if (count($listaAnuncios) > 1) {
       foreach ($listaAnuncios as $anuncio) {
           if ($anuncio->getStatus() == "cadastrado")
               $temAnuncioAtivo = true;
       }
   } else {
       if ($listaAnuncios->getStatus() == "cadastrado")
           $temAnuncioAtivo = true;
   }
   return $temAnuncioAtivo;
}

?>