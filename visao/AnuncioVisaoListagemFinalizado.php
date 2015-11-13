
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/js/anuncio.js"></script>

<script>
    $(document).ready(function () {

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "columnDefs": [
                {"orderable": false, "targets": 6}
            ]
        });

    })

</script>

<div class="ui middle aligned stackable grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <a class="section" href="index.php">Início</a>
            <i class="right chevron icon divider"></i>
            <i class="block layout small icon"></i><a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
            <i class="right chevron icon divider"></i>
            <a class="active section">Visualizar Anuncios Não Ativos</a>
        </div>
    </div>
 </div>
 
<div class="ui hidden divider"></div>

    <?php
    Sessao::gerarToken();

    $item = $this->getItem();
    
    //var_dump($item);
    
    $totalAnunciosFinalizados = count($item["listaAnuncioFinalizado"]);
    $totalAnunciosExpirados = count($item["listaAnuncioExpirado"]);
    
    if($totalAnunciosFinalizados < 1 || $totalAnunciosExpirados < 1){      
    ?>
  
    <div class="ui middle aligned stackable grid container">
    
    <div class="column">
        
    <div class="ui warning compact message">
        <div class="header">Atenção</div>
        <ul class="list">
          <li>Você não possui anuncios não ativos. Clique em voltar para retornar ao MEUPIP</li>
        </ul>
    </div>
 
    <div class="row">
    <a href="index.php?entidade=Usuario&acao=meuPIP">
    <button class="ui orange button">Voltar</button>
    </a>
    </div>
    
    <div class="row"></div>     
        
    </div>   
    </div>    

    <?php } else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable?>
    <div class="ui middle aligned stackable grid container">
    <div class="column">
        
    <table class="ui brown table" id="tabela">
        
        <thead>
            <tr>
                <th>Cod. Anuncio</th>
                <th>Tipo</th>
                <th>Finalidade</th>
                <th>Titulo</th>
                <th>Descrição</th> 
                <th>Valor</th>
                <th>Data Cadastro</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($item) {
                foreach ($item["listaAnuncioFinalizado"] as $anuncio) {
            
                switch ($anuncio->getImovel()->getIdTipoImovel()){
                                
                                case 1: $tipoImovel = "casa"; break;
                                case 2: $tipoImovel = "apartamento"; break;
                                case 3: $tipoImovel = "apartamentoplanta"; break;
                                case 4: $tipoImovel = "salacomercial"; break;
                                case 5: $tipoImovel = "prediocomercial"; break;
                                case 6: $tipoImovel = "terreno"; break;
                                
                            }    
                    
                    ?>
            
            
            <script> 
            $(document).ready(function () {
            formatarValor(<?php echo $anuncio->getId() ?>);
            })
            </script>
            
                    <tr>

                        <td>
                            
                        <form id="form" action="index.php" method="post" target='_blank'>
                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar"/>
                            <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio->getId() ?>"/>
                            <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>
               
                            
                            <button class="ui labeled icon button">
                            <i class="zoom icon"></i>
                            <?php echo $anuncio->getIdAnuncio(); ?>
                            </button>
                        
                         </form>                       
                        
                        </td>
                        <td><?php 
                        
                        switch ($anuncio->getImovel()->getIdTipoImovel()){
                                
                                case 1: echo "Casa"; break;
                                case 2: echo "Apartamento na Planta"; break;
                                case 3: echo "Apartamento"; break;
                                case 4: echo "Sala Comercial"; break;
                                case 5: echo "Prédio Comercial"; break;
                                case 6: echo "Terreno"; break;
                                
                            }  
                        
                        ?></td>
                        <td><?php echo $anuncio->getFinalidade(); ?></td>
                        <td><?php echo $anuncio->getTituloAnuncio(); ?></td>
                        <td><?php echo $anuncio->getDescricaoAnuncio(); ?></td>
                        <td id="tdValor<?php echo $anuncio->getId(); ?>"><?php echo $anuncio->getValorMin(); ?></td>
                        <td><?php echo $anuncio->getDataHoraCadastro(); ?></td>
                        <td> <?php
                               echo "<i class='large thumbs up red icon'></i>Finalizado em " . $anuncio->getHistoricoAluguelVenda()->getDatahora();
                              ?>
                        </td>

                    </tr>

                <?php
            }
        }
        ?>
                        
        <?php
            if ($item) {
                foreach ($item["listaAnuncioExpirado"] as $anuncio) {
                    
                    switch ($anuncio->getImovel()->getIdTipoImovel()){
                                
                                case 1: $tipoImovel = "casa";
                                case 2: $tipoImovel = "apartamento";
                                case 3: $tipoImovel = "apartamentoplanta";
                                case 4: $tipoImovel = "salacomercial";
                                case 5: $tipoImovel = "prediocomercial";
                                case 6: $tipoImovel = "terreno";
                                
                            }
                    ?>
            <script> 
            $(document).ready(function () {
            formatarValor(<?php echo $anuncio->getId() ?>);
            })
            </script>
                    <tr>
                        <td>
                            
                        <form id="form" action="index.php" method="post" target='_blank'>
                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar"/>
                            <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio->getId() ?>"/>
                            <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo "casa"//$tipoImovel ?>"/>
                            
                            <button class="ui labeled icon button">
                            <i class="zoom icon"></i>
                            <?php echo $anuncio->getIdAnuncio(); ?>
                            </button>                   
                            
                        </form>
                            
                        </td>
                        <td><?php switch ($anuncio->getImovel()->getIdTipoImovel()){
                                
                                case 1: echo "Casa"; break;
                                case 2: echo "Apartamento na Planta"; break;
                                case 3: echo "Apartamento"; break;
                                case 4: echo "Sala Comercial"; break;
                                case 5: echo "Prédio Comercial"; break;
                                case 6: echo "Terreno"; break;
                                
                            }   ?>
                        </td>
                        <td><?php echo $anuncio->getFinalidade(); ?></td>
                        <td><?php echo $anuncio->getTituloAnuncio(); ?></td>
                        <td><?php echo $anuncio->getDescricaoAnuncio(); ?></td>
                        <td id="tdValor<?php echo $anuncio->getId(); ?>"><?php echo $anuncio->getValorMin(); ?></td>
                        <td><?php echo $anuncio->getDataHoraCadastro(); ?></td>
                        <td> <?php                                
                                    echo "<i class='large remove circle red icon'></i>Expirado em " . $anuncio->getDataHoraDesativacao();
         
                                ?>
                        </td>

                    </tr>

                <?php
            }
        }
        ?>           
                    
        </tbody>
    </table>
    
    </div>
</div>

<div class="ui hidden divider"></div>

<?php } //fim do else, caso haja anuncios ativos?> 
