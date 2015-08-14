<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>
<script src="assets/js/mask.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.8/css/jquery.dataTables.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>


<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">          
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Imóveis Cadastrados - Informações</a>
            </div>
        </div>
      
    </div>
    
    <div class="ui hidden divider"></div>
    
    <div class="ui page grid main">
    
    <table class="ui table" id="tabela">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Data Cadastro</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                
    <?php

    Sessao::gerarToken(); 

    foreach($this->getItem() as $imovel){ /*echo "<pre>"; var_dump($imovel);echo "</pre>";*/?>
                
        <?php

        echo "<tr>";
        
        echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel())."</td>";
        
        if(trim($imovel->getIdentificacao()) == ""){
            $descricao = "<h4 class='ui red header'>Não Informado</h4>";
            
        } else { $descricao = $imovel->getIdentificacao(); }
        
        echo "<td>".$descricao."</td>";
                        
        echo "<td>".$imovel->getDatahoracadastro()."</td>";
                        
        echo "<td><a href='#' class='ui teal button' id='detalhes".$imovel->getId()."' >Detalhes do Imóvel</td>" ;
        
        echo "</tr>";
        
        }
    ?>                    
                       
            </tbody>
        </table>
        <?php
         /*   $links = $pager->getLinks();
            echo ($links['all']!="" ? "&nbsp;&nbsp;&nbsp;&nbsp;Página: ".$links['all'] : ""); 
         
          */
        ?>
    </div>
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

<script>
$(document).ready(function () {   
$('#tabela').dataTable({
        "language": {
            "url": "assets/libs/DataTables/js/Portuguese-Brasil.json",
        },
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "stateSave": true,
        "columnDefs": [
        { "orderable": false, "targets": 3 }
        ]
    });
})
</script>