<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/pagination/jPages.min.js"></script>
<!--<script src="assets/libs/jplist/jplist.core.min.js"></script>
<link href="assets/libs/jplist/jplist.core.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/jplist/jplist.sort-bundle.min.js"></script>
<link href="assets/libs/jplist/jplist.pagination-bundle.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/jplist/jplist.pagination-bundle.min.js"></script>-->
<link href="assets/css/template-pip.css" rel="stylesheet" type="text/css" />
<!--<link href="assets/libs/pagination/jPages.css" rel="stylesheet" type="text/css" />-->

<script>
    carregarAnuncio();
    paginarAnuncio();
    enviarEmail();

<?php
$item = $this->getItem();

foreach ($item["anuncio"] as $buscaAnuncio) {

    if (!$item["page"]) {
        ?>
            marcarMapa("<?php echo $buscaAnuncio["logradouro"] ?>",
                    "<?php echo $buscaAnuncio["numero"] ?>",
                    "<?php echo $buscaAnuncio["bairro"] ?>",
                    "<?php echo $buscaAnuncio["cidade"] ?>",
                    "<?php echo $buscaAnuncio["estado"] ?>",
                    "<?php echo $buscaAnuncio["tituloanuncio"] ?>",
                    "<?php echo $buscaAnuncio["valormin"] ?>",
                    "<?php echo $buscaAnuncio["finalidade"] ?>", "", "", "100%", "350", 11);

        <?php
    }
}
?>

</script>

<div class="ui middle aligned stackable grid container">
    <div id="mapaGmapsBusca"></div>
</div>

<div class="ui hidden divider"></div>


<form id="form" action="index.php" method="post" target='_blank'>
    <input type="hidden" id="hdnEntidade" name="hdnEntidade"  />
    <input type="hidden" id="hdnAcao" name="hdnAcao" />
    <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" />
    <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" />
    <div class="ui middle aligned one column grid container" id="lista">
        <?php if (count($item['anuncio']) > 0) { ?>
            <div class="stackable two column ui grid container">
                
                <div class="center aligned column">
                
                    <div class="holder"></div>
                
                </div>
<!--                <button class="ui button" id="btnOrdenar">
                    Ordenar
                </button>-->
                
            <div class="center aligned column">

                <div class="ui right aligned container">
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltOrdenacao" id="sltOrdenacao">
                        <i class="dropdown icon"></i>
                        <div class="default text">Ordenar</div>
                        <div class="menu">
                            <div class="item" data-value="mnvalor">Menor Valor</div>
                            <div class="item" data-value="mrvalor">Maior Valor</div>
                            <div class="item" data-value="recente">Mais Recente</div>
                            <div class="item" data-value="antigo">Mais Antigo</div>
                        </div>
                    </div>
                </div>
            </div>     
                <!--                <div class="jplist-panel">
                                    <div 
                                        class="jplist-drop-down" 
                                        data-control-type="items-per-page-drop-down" 
                                        data-control-name="paging" 
                                        data-control-action="paging">
                                        <ul>
                                            <li><span data-number="8" data-default="true"> 8 resultados </span></li>
                                            <li><span data-number="16"> 16 resultados </span></li>
                                            <li><span data-number="24"> 24 resultados </span></li>
                                        </ul>
                                    </div>
                                    <div 
                                        class="jplist-label" 
                                        data-type="{start} - {end} de {all}"
                                        data-control-type="pagination-info" 
                                        data-control-name="paging" 
                                        data-control-action="paging">
                                    </div>	
                                    <div 
                                        class="jplist-pagination" 
                                        data-control-type="pagination" 
                                        data-control-name="paging" 
                                        data-control-action="paging">
                                    </div>
                
                                    <div 
                                        class="jplist-drop-down" 
                                        data-control-type="sort-drop-down" 
                                        data-control-name="sort" 
                                        data-control-action="sort"
                                        data-datetime-format="{year}-{month}-{day} {hour}:{min}:{sec}">  
                
                                        <ul>
                                            <li><span data-path="default">Escolha a ordem</span></li>
                                            <li><span data-path=".valor" data-order="desc" data-type="number">Maior Preço</span></li>
                                            <li><span data-path=".valor" data-order="asc" data-type="number">Menor Preço</span></li>
                                            <li><span data-path=".data" data-order="desc" data-type="datetime">Mais Recente</span></li>
                                            <li><span data-path=".data" data-order="asc" data-type="datetime">Menos Recente</span></li>
                                        </ul>
                                    </div>
                                </div>-->
            </div>

            <?php

            //verificar maior e menor número de quartos, banheiros e garagens de cada planta
            function maximoMinimo($item, $coluna) {
                if ($item['tipo'] == 'apartamentoplanta') {

                    foreach ($item['plantas'] as $planta) {
                        $conjunto[] = $planta[$coluna];
                    }
                    return min($conjunto) . ' a ' . max($conjunto);
                } else if ($planta[$coluna]) {
                    return $planta[$coluna];
                } else {
                    return ' - ';
                }
            }
            ?>

            <!--<div class="ui stackable special cards list">-->
            <div class="ui stackable column grid">
                <div id="itemContainer" class="ui stackable cards list">

                    <?php
                    for ($crtl = 0; $crtl < count($item['anuncio']); $crtl++) {
//                        echo '<pre>';
//                        print_r($item['anuncio'][$crtl]['idanuncioformatado']);
//                        echo '</pre>';
                        ?> 
                        <div data-valor="<?php echo $item['anuncio'][$crtl]['valormin'] ?>" class="card list-item" style="width: 263px; border-radius: 2.285714rem; box-shadow: 0 1px 3px 0 #D4D4DD,0 0 0 1px #000000" id="cartao<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>" data-cadastro="<?php echo $item['anuncio'][$crtl]['datahoracadastro'] ?>">                            
                            <!--                            <div class="content">
                            <?php
                            if ($item['anuncio'][$crtl]['finalidade'] == "Venda") {
                                echo "<div class='ui blue ribbon label'> Venda </div>";
                            } else {
                                echo "<div class='ui green ribbon label'> Aluguel </div>";
                            }
                            ?>            
                                                            
                            <?php
                            if ($item['anuncio'][$crtl]['tipo'] == "prediocomercial") {
                                echo "Prédio Comercial";
                            } else if
                            ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                echo "Apartamento na Planta";
                            } else if
                            ($item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                                echo "Sala Comercial";
                            } else
                                echo ucfirst($item['anuncio'][$crtl]['tipo'])
                                ?>                                           
                                                                    </b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>-->

                            <div class="content">
                                <?php
                                if ($item['anuncio'][$crtl]['finalidade'] == "Venda") {
                                    echo "<div class='ui blue ribbon label'> Venda </div>";
                                } else {
                                    echo "<div class='ui green ribbon label'> Aluguel </div>";
                                }
                                ?> 
                                <!--                                <div class="left floated header">Venda</div>-->
                                <div class="right floated meta">
                                    <a href="http://www.facebook.com/sharer.php?u=http://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank"><i class="large blue facebook square icon"></i></a>
                                    <a href="https://twitter.com/intent/tweet?text=Anúncio%20Compartilhado%20via%20PIP-OnLine%20http%3A%2F%2Fwww.pipbeta.com.br%2F<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank"><i class="large blue twitter icon"></i></a>
                                    <a href="https://plus.google.com/share?url=http://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank"><i class="large red google plus circle icon"></i></a>
                                    <a class="compartilhar-whatsapp" href='whatsapp://send?text=http://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>'><i class="large green whatsapp icon"></i></a>
                                    <!--                                        <div class="ui primary button" id="copiarBotao" onclick="copiar()">Copiar Link Anúncio</div>-->
                                </div>                                
                            </div>
                            <!--                             <div class="ui divider"></div>-->
                            <div class="ui grid">
                                <div class="ui centered row">
                                    <h4>
                                        <?php
                                        if ($item['anuncio'][$crtl]['tipo'] == "prediocomercial") {
                                            echo "Prédio Comercial";
                                        } else if
                                        ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                            echo "Apartamento na Planta";
                                        } else if
                                        ($item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                                            echo "Sala Comercial";
                                        } else
                                            echo ucfirst($item['anuncio'][$crtl]['tipo'])
                                            ?>                                           
                                    </h4>
                                </div>
                            </div>


                            <div class="image" style=" text-align: center;
                                 margin: 0px auto;
                                 max-height: 200px !important;">

                                <?php
                                if ($item['anuncio'][$crtl]['imagem']) {
                                    foreach ($item['anuncio'][$crtl]['imagem'] as $imagem) {
                                        if ($imagem['destaque'] == 'SIM') {
                                            ?>
                                            <img style="display: block; margin-left: auto; margin-right: auto; width: auto; max-height: 140px; overflow: scroll;position: relative; max-width: 165px" src="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>">
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                                <?php }
                                ?>
                            </div>

                            <div class="content">
                                <div class="ui segment">    
                                    <div class="ui three column center aligned grid">                                       
                                        <div class="column">
                                            <img class="ui center image dimmable" src="../assets/imagens/icones/iconeQuartoPequeno.jpg">&nbsp;
                                            <div style="font-size: 12px">  
                                                <?php
                                                if ($item['anuncio'][$crtl]['tipo'] == "casa" || $item['anuncio'][$crtl]['tipo'] == "apartamento") {
                                                    echo $item['anuncio'][$crtl]['quarto'];
                                                } else if ($item['anuncio'][$crtl]['tipo'] == "salacomercial" || $item['anuncio'][$crtl]['tipo'] == "prediocomercial" || $item['anuncio'][$crtl]['tipo'] == "terreno") {
                                                    echo "&nbsp; - ";
                                                } else if ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                                    echo maximoMinimo($item['anuncio'][$crtl], 'quarto');
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="column">
                                            <img class="ui left image" src="../assets/imagens/icones/iconeBanheiroPequeno.jpg">&nbsp;
                                            <div style="font-size: 12px"><?php
                                                if ($item['anuncio'][$crtl]['tipo'] == "casa" || $item['anuncio'][$crtl]['tipo'] == "apartamento" || $item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                                                    echo $item['anuncio'][$crtl]['banheiro'];
                                                } else if ($item['anuncio'][$crtl]['tipo'] == "salacomercial" || $item['anuncio'][$crtl]['tipo'] == "prediocomercial" || $item['anuncio'][$crtl]['tipo'] == "terreno") {
                                                    echo "&nbsp; - ";
                                                } else if ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                                    echo maximoMinimo($item['anuncio'][$crtl], 'banheiro');
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="column">
                                            <img class="ui left image " src="../assets/imagens/icones/iconeGaragemPequeno.jpg">&nbsp;
                                            <div style="font-size: 12px"><?php
                                                if ($item['anuncio'][$crtl]['tipo'] == "casa" || $item['anuncio'][$crtl]['tipo'] == "apartamento" || $item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                                                    echo $item['anuncio'][$crtl]['garagem'];
                                                } else if ($item['anuncio'][$crtl]['tipo'] == "salacomercial" || $item['anuncio'][$crtl]['tipo'] == "prediocomercial" || $item['anuncio'][$crtl]['tipo'] == "terreno") {
                                                    echo "&nbsp; - ";
                                                } else if ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                                    echo maximoMinimo($item['anuncio'][$crtl], 'garagem');
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <!--                                    <div class="ui divider"></div>-->

                                <!--                                </div>-->
                                <?php if ($item['anuncio'][$crtl]['tipo'] !== "apartamentoplanta") { ?>
                                    <div class="left floated header" id="spanValor<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">       
                                        <?php echo ($item['anuncio'][$crtl]['novovalor'] != "") ? $item['anuncio'][$crtl]['novovalor'] : $item['anuncio'][$crtl]['valormin']; ?>                                         
                                    </div>
                                    <?php
                                } else {

                                    if ($item['anuncio'][$crtl]['valormin'] != 0) {
                                        ?>

                                        A partir de  <br>
                                        <span class="left floated header" id="spanValor<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">     
                                            <?php
                                            echo $item['anuncio'][$crtl]['valormin'];
                                        } if ($item['anuncio'][$crtl]['valormin'] == 0) {
                                            echo "Valor não informado";
                                        }
                                    }
                                    ?>
                                </span>
                                <div class="right floated"> <h4><?php echo $item['anuncio'][$crtl]['bairro'] ?> </h4></div>
                                <div class="description"> 
                                    <!--                                    <br />-->
                                    <span hidden="true" class="data" id="spanData<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>"> 
                                        <?php echo $item['anuncio'][$crtl]['datahoracadastro']; ?> </span>
                                    <!-- CASO SEJA UM APARTAMENTO NA PLANTA, NÃO EXIBIR O VALOR-->

                                    <!--<br />
                                    Cod. <?php $item['anuncio'][$crtl]['idanuncioformatado'] ?> -->
                                    <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" />
                                    <input type="hidden" id="hiddenAnuncioFormatadaoCopiar" value="<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" />


                                </div>
                                <br />
                                <div class="ui one column center aligned grid">
                                    <div class="column">
                                        <a class='ui twitter button' href="<?php echo PIPURL; ?><?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank">+ Detalhes</a>
                                    </div>
                                </div>       
                            </div>
                            <div class="extra content">      
                                <div class="ui checkbox">
                                    <input type="checkbox" name="selecionarAnuncio[]" id="selecionarAnuncio_<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" value="<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>">
                                    <label id="idsAnuncios">Selecionar</label>
                                </div>
                                <span class="right floated">
                                    <?php echo FuncoesAuxiliares::tempo_corrido($item['anuncio'][$crtl]['datahoracadastro']) ?> <?php ?>
                                </span>
                            </div> 
                        </div> 
                    <?php }
                    ?>                    
                </div>
                <div id="pagination-container"></div>
                <!--                <div class="column">
                                <div class="ui pagination menu">
                                    <a class="action2 active item" href="#" rel="first">Primeiro</a>
                                    <a class="action2 item" href="#" rel="prev">Anterior</a>
                                    <a class="action2 item" href="#" rel="next">Próximo</a>
                                    <a class="action2 item" href="#" rel="last">Último</a>
                                <div class="ui pagination menu">
                                </div>-->
            </div>            
        <?php }
        ?>
        <div class="ui column">
            <div class="holder"></div>

            <!--            <div class="jplist-panel">
                            <div 
                                class="jplist-drop-down" 
                                data-control-type="items-per-page-drop-down" 
                                data-control-name="paging" 
                                data-control-action="paging">
                                <ul>
                                    <li><span data-number="8" data-default="true"> 8 resultados </span></li>
                                    <li><span data-number="16"> 16 resultados </span></li>
                                    <li><span data-number="24"> 24 resultados </span></li>
                                        <li><span data-number="all"> view all </span></li>
                                </ul>
                            </div>
                            <div 
                                class="jplist-label" 
                                data-type="{start} - {end} de {all}"
                                data-control-type="pagination-info" 
                                data-control-name="paging" 
                                data-control-action="paging">
                            </div>
                            <div 
                                class="jplist-pagination" 
                                data-control-type="pagination" 
                                data-control-name="paging" 
                                data-control-action="paging">
                            </div>
                        </div>-->
        </div>
    </div>
    <div class="one wide column"></div>
</form>

<div class="ui hidden divider"></div>

<div class="ui one column centered grid" id="divBotoes"></div>
<div id="load">
    <div class="ui text loader">Carregando...</div>
</div>  
<?php
include_once "modal/AnuncioEnviarEmailModal.php";
?>