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
    foreach($data as $imovel){?>
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
                    echo "Tipo: " . $modal->buscarTipoImovel($modal->getIdTipoImovel()) . "<br />";	 
                    echo "Descrição: " . $modal->getIdentificacao() . "<br />";
                    
                    switch ($modal->getIdTipoImovel()) {
                        case "1":
                            echo "Condição: " . $modal->getCondicao() . "<br />";
                            echo "Quarto(s): " . $modal->getCasa()->getQuarto() . "<br />";
                            echo "Vagas de Garagem: " . $modal->getCasa()->getGaragem() . "<br />";
                            echo "Banheiro(s): " . $modal->getCasa()->getBanheiro() . "<br />";
                            echo "Suite(s): " . $modal->getCasa()->getSuite() . "<br />";
                            echo "Área: " . $modal->getCasa()->getArea() . "m2<br />";
                            break;

                        case "2":
                            echo "Número de Andares: " . $modal->getApartamentoPlanta()->getAndares() . "<br />";
                            echo "Unidades por Andar: " . $modal->getApartamentoPlanta()->getUnidadesAndar() . "<br />";
                            echo "Número de Torres: " . $modal->getApartamentoPlanta()->getNumeroTorres() . "<br />";
                            echo "Total de Unidades: " . $modal->getApartamentoPlanta()->getTotalUnidades() . "<br />";/*
                            echo "Possui Sacada: " . $modal->getApartamentoPlanta()->getSacada() . "<br />";
                            echo "Apartamentos p/ Andar: " . $modal->getApartamentoPlanta()->getUnidadesAndar() . "<br />";*/
                            break;
                        case "3":
                           echo "Quarto: " . $modal->getApartamento()->getQuarto() . "<br />";
                            echo "Vagas de Garagem: " . $modal->getApartamento()->getGaragem() . "<br />";
                            echo "Quarto(s): " . $modal->getApartamento()->getQuarto() . "<br />";
                            echo "Banheiro(s): " . $modal->getApartamento()->getBanheiro() . "<br />";
                            echo "Suite(s): " . $modal->getApartamento()->getSuite() . "<br />";
                            echo "Possui Sacada: " . $modal->getApartamento()->getSacada() . "<br />";
                            echo "Apartamentos p/ Andar: " . $modal->getApartamento()->getUnidadesAndar() . "<br />";
                            break;                       
                        case "4":                    
                            echo "Condição: " . $modal->getCondicao() . "<br />";
                            echo "Banheiro: " . $modal->getSalaComercial()->getBanheiro() . "<br />";
                            echo "Vagas de Garagem: " . $modal->getSalaComercial()->getGaragem() . "<br />";
                            echo "Condomínio: " . $modal->getSalaComercial()->getCondominio() . "<br />";
                            echo "Area: " . $modal->getSalaComercial()->getArea() . "<br />";
                            break;
                        case "5":                    
                            echo "Area: " . $modal->getPredioComercial()->getArea() . "<br />";
                            break;
                        case "6":
                            echo "Area: " . $modal->getTerreno()->getArea() . "<br />";
                            break;
                    }
                    echo "<div class='ui hidden divider'></div>";
                    if($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() != ""){
                    echo "Endereço: ".$modal->getEndereco()->getLogradouro().", ".$modal->getEndereco()->getNumero().", ".$modal->getEndereco()->getComplemento()."<br />";
                    echo $modal->getEndereco()->getBairro()->getNome().", ".$modal->getEndereco()->getCidade()->getNome()." - ".$imovel->getEndereco()->getEstado()->getUf();
                    }
                    
                    elseif($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() == ""){
                    echo "Endereço: ".$modal->getEndereco()->getLogradouro().", ".$modal->getEndereco()->getNumero()."<br />";
                    echo $modal->getEndereco()->getBairro()->getNome().", ".$modal->getEndereco()->getCidade()->getNome()." - ".$imovel->getEndereco()->getEstado()->getUf();
                    }
                    
                    elseif($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() == ""){
                    echo "Endereço: ".$modal->getEndereco()->getLogradouro()."<br />";
                    echo $modal->getEndereco()->getBairro()->getNome().", ".$modal->getEndereco()->getCidade()->getNome()." - ".$imovel->getEndereco()->getEstado()->getUf();
                    }
                    
                    elseif($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() != ""){
                    echo "Endereço: ".$modal->getEndereco()->getLogradouro().", ".$modal->getEndereco()->getComplemento()."<br />";;
                    echo $modal->getEndereco()->getBairro()->getNome().", ".$modal->getEndereco()->getCidade()->getNome()." - ".$imovel->getEndereco()->getEstado()->getUf();
                    }
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
