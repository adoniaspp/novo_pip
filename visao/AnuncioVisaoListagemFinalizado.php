
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/js/anuncio.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {
        
        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );
        
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
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section"></a>
                <div class="active section"><i class="thumbs outline up small icon"></i>Visualizar Anúncios Não Ativos</div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>
                    Abaixo estão os anúncios <strong>finalizados</strong> por você e os <strong>expirados</strong> 
                    (finalizados automaticamente pelo sistema devido ao prazo do anúncio).
                    Clique no código ao lado de cada anúncio para mais detalhes
                </p>dido
            </div>
        </div>
    </div>
    
 </div>
 
<div class="ui hidden divider"></div>

    <?php
    Sessao::gerarToken();

    $item = $this->getItem();
    
    $totalAnunciosFinalizados = count($item["listaAnuncioFinalizado"]);
    
    $totalAnunciosExpirados = count($item["listaAnuncioExpirado"]);
    
    if($totalAnunciosFinalizados < 1 && $totalAnunciosExpirados < 1){      
    ?>
  
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui warning message">
                <div class="header">Atenção</div>
                <ul class="list">
                  Você não possui anúncios não ativos. Clique em voltar para retornar ao MEUPIP
                </ul>
            </div>

            <div class="row">
            <a href="index.php?entidade=Usuario&acao=meuPIP">
            <button class="ui orange button">Voltar</button>
            </a>
            </div>

        </div>   
    </div>
</div>    

    <?php } else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable?>
    <div class="ui middle aligned stackable grid container">
    <div class="column">
        
    <table class="ui brown table" id="tabela">
        
        <thead>
            <tr>
                <th>Cód. Anúncio</th>
                <th>Tipo</th>
                <th>Finalidade</th>
                <th>Titulo</th>
                <th>Valor</th>
                <th>Data Cadastro</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($item) {
                foreach ($item["listaAnuncioFinalizado"] as $anuncio) {
            
                switch ($anuncio->getImovel()->getIdTipoImovel()){
                                
                                case 1: $tipoImovel = "casa"; break;
                                case 2: $tipoImovel = "apartamentoplanta"; break;
                                case 3: $tipoImovel = "apartamento"; break;
                                case 4: $tipoImovel = "salacomercial"; break;
                                case 5: $tipoImovel = "prediocomercial"; break;
                                case 6: $tipoImovel = "terreno"; break;
                                
                            }    
                    
                    ?>
            
            
            <script> 
            
                $(document).ready(function () { 
                
                <?php if($anuncio->getNovoValorAnuncio() != ""){?>   
                       
                formatarValor(<?php echo $anuncio->getNovoValorAnuncio()->getId(); ?>); 
                
                <?php } else { ?>

                formatarValor(<?php echo $anuncio->getId(); ?>);
                
                <?php        
                }        
                ?>
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
                        <td><?php 
                                $limite = 20;
                                $titulo = $anuncio->getTituloAnuncio();
                                echo (strlen(trim($titulo)) >= $limite) ? trim(substr($titulo, 0, strrpos(substr($titulo, 0, $limite), " "))) . "..." : $titulo;
                            ?>
                        </td>
                        <td id="tdValor<?php if($anuncio->getNovoValorAnuncio() != ""){ echo $anuncio->getNovoValorAnuncio()->getId();} else echo $anuncio->getId(); ?>"><?php if($anuncio->getNovoValorAnuncio() != ""){ echo $anuncio->getNovoValorAnuncio()->getNovoValor(); } else echo $anuncio->getValorMin(); ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro())); ?></td>
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
                                
                                case 1: $tipoImovel = "casa"; break;
                                case 2: $tipoImovel = "apartamentoplanta"; break;
                                case 3: $tipoImovel = "apartamento"; break;
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

<?php } //fim do else, caso haja anuncios finalizados ou expirados?> 
