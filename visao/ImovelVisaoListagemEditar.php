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
        
        if(trim($imovel->getIdentificacao()) == ""){
            $descricao = "<h4 class='ui red header'>Não Informado</h4>";
            
        } else { $descricao = $imovel->getIdentificacao(); }
        
        echo "<td>".$descricao."</td>";
                        
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
    
<?php include_once "/modal/ImovelListagemModal.php"; 

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

