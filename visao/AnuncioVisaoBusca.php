<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jplist/jplist.core.min.js"></script>
<link href="assets/libs/jplist/jplist.core.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/jplist/jplist.sort-bundle.min.js"></script>
<link href="assets/libs/jplist/jplist.pagination-bundle.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/jplist/jplist.pagination-bundle.min.js"></script>
<link href="assets/css/template-pip.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/imagefill.js-master/jquery-imagefill.js"></script>
<link href="assets/css/libs/imagefill.js-master/grid.css" rel="stylesheet" type="text/css" />
<link href="assets/css/libs/imagefill.js-master/main.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/imagefill.js-master/imagesloaded.pkgd.min.js"></script>


<script>
    carregarAnuncio();
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
    <!--    <div class="ui center aligned three column page grid" id="resultadoBusca">-->
    <!--    <div class="ui middle aligned stackable one column grid container" id="lista">-->
    <div class="ui middle aligned one column grid container" id="lista">
        <!--        <div class="sixteen wide row">-->
        <?php if (count($item['anuncio']) > 0) { ?>
            <div class="ui column">
                <div class="jplist-panel">
                    <div 
                        class="jplist-drop-down" 
                        data-control-type="items-per-page-drop-down" 
                        data-control-name="paging" 
                        data-control-action="paging">
                        <ul>
                            <li><span data-number="8" data-default="true"> 8 resultados </span></li>
                            <li><span data-number="16"> 16 resultados </span></li>
                            <li><span data-number="24"> 24 resultados </span></li>
    <!--                            <li><span data-number="all"> view all </span></li>-->
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
                </div>
            </div>
            <div class="ui ten wide column">
            </div>
            <!--            <div class="ui stackable special cards list">-->
            <div class="ui stackable column grid">
                <div class="ui stackable special cards list">
                    <?php
                    for ($crtl = 0; $crtl < count($item['anuncio']); $crtl++) {                        
                        ?>
                    
                        <script>
                            formatarValor("<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>");
                        </script>       
                        <div class="card list-item" id="cartao<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">
                            <div class="content">
                                <?php
                                if ($item['anuncio'][$crtl]['finalidade'] == "Venda") {
                                    echo "<div class='ui blue ribbon label'> Venda </div>";
                                } else {
                                    echo "<div class='ui green ribbon label'> Aluguel </div>";
                                }
                                ?>                                                                       
                            </div>

                            <div class="dimmable image" style=" text-align: center;
                                 margin: 0px auto;
                                 max-height: 200px !important;">
                                <div class="ui inverted dimmer">
                                    <div class="content">
                                        <div class="center">
                                            <div class="ui blue basic button"> Detalhes </div>                                          
                                            <input type="hidden" id="anuncio<?php echo $item['anuncio'][$crtl]['id'] ?>"
                                                   value="<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>"/>
                                            <input type="hidden" id="anuncio<?php echo $item['anuncio'][$crtl]['tipo'] ?>"
                                                   value="<?php echo $item['anuncio'][$crtl]['tipo'] ?>"/>                                                   
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($item['anuncio'][$crtl]['imagem']) {
                                    foreach ($item['anuncio'][$crtl]['imagem'] as $imagem) {
                                        if ($imagem['destaque'] == 'SIM') {
                                            ?>
                                            <img style="width: auto; max-height: 140px; overflow: scroll;position: relative; max-width: 165px" src="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>">
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
                                <div class="header"><b>
                                        <?php
                                        $limite = 24;
                                        $titulo = $item['anuncio'][$crtl]['tituloanuncio'];
                                        echo (strlen(trim($titulo)) >= $limite) ? trim(substr($titulo, 0, strrpos(substr($titulo, 0, $limite), " "))) . "..." : $titulo;
                                        ?></b></div>
                                <div class="description"> 
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
                                    <br />
                                    <span hidden="true" class="data" id="spanData<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>"> 
                                        <?php echo $item['anuncio'][$crtl]['datahoracadastro']; ?> </span>
                                    <span class="valor" id="spanValor<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>"> 
                                        <?php echo ($item['anuncio'][$crtl]['novovalor'] != "") ? $item['anuncio'][$crtl]['novovalor'] : $item['anuncio'][$crtl]['valormin']; ?> </span>
                                    <br />
                                    Cod. <?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>
                                    <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" />
                                    <br />
                                    Data Cadastro: <?php echo date('d/m/Y', strtotime($item['anuncio'][$crtl]['datahoracadastro'])) ?>
                                </div>
                            </div>
                            <div class="extra content">      
                                <div class="ui checkbox">
                                    <input type="checkbox" name="selecionarAnuncio[]" id="selecionarAnuncio_<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>" value="<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">
                                    <label id="idsAnuncios">Selecionar</label>
                                </div>
                            </div>                        
                        </div> 
                    <?php }
                    ?>
                </div>
            </div>
        <?php }
        ?>
        <div class="ui column">
            <div class="jplist-panel">
                <div 
                    class="jplist-drop-down" 
                    data-control-type="items-per-page-drop-down" 
                    data-control-name="paging" 
                    data-control-action="paging">
                    <ul>
                        <li><span data-number="8" data-default="true"> 8 resultados </span></li>
                        <li><span data-number="16"> 16 resultados </span></li>
                        <li><span data-number="24"> 24 resultados </span></li>
<!--                            <li><span data-number="all"> view all </span></li>-->
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
            </div>
        </div>
    </div>
    <div class="one wide column"></div>
</form>
<div class="ui one column centered grid">
    <div class="four column centered row">
        <div class="column" id="divBotoes"></div>
    </div>
</div>
<div id="load">
    <div class="ui text loader">Carregando...</div>
</div>  
<?php
include_once "/modal/AnuncioEnviarEmailModal.php";
?>