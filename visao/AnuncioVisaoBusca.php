<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>

<script>
    carregarAnuncio();
    
    <?php 
    $item = $this->getItem();          
    foreach ($item["anuncio"] as $buscaAnuncio){
    if(!$item["page"])       {
    ?> 
    marcarMapa("<?php echo $buscaAnuncio["logradouro"]?>", "<?php echo $buscaAnuncio["numero"]?>", "<?php echo $buscaAnuncio["bairro"]?>", "<?php echo $buscaAnuncio["tituloanuncio"]?>", "<?php echo $buscaAnuncio["valormin"]?>", "<?php echo $buscaAnuncio["finalidade"]?>", "1000", "350", 11);    
    
    <?php 
    }
    }
    ?>
 
</script>
<?php

?>

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
    <div class="ui middle aligned stackable grid container">
    <div class="sixteen wide row">
        <?php if (count($item['anuncio']) > 0) { ?>
        <table id="tabela" class="ui very basic table stackable">
            <thead>
                <tr style="border: none !important">
                    <th class="three wide"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($crtl = 0; $crtl < count($item['anuncio']); $crtl++) {
                    ?>
                <script>
                    formatarValor("<?php echo $item['anuncio'][$crtl]['idanuncio']?>");
                </script>
                    <tr style="width: 33%;float: left; border: none !important">
                        <td class="ui special cards" style="border: none !important">
                            <div class="ui stackable card" id="cartao<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">
                                <div class="content">
                                    <div class="ui blue ribbon label">Anúncio <?php echo $item['anuncio'][$crtl]['idanuncioformatado']?></div>        
                                </div>
                                <div class="dimmable image">
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
                        if($item['anuncio'][$crtl]['imagem']) {
                        foreach ($item['anuncio'][$crtl]['imagem'] as $imagem) {                                                                
                            if($imagem['destaque'] == 'SIM'){
//                                    var_dump($imagem['diretorio']);
//                                    die();
                                ?>
                                    <img style="height:200px; width: 290px;" src="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] .'/'. $imagem['nome'] ?>">
                        <?php 
                            }}
                        }else{
                                ?>
                            <img style="height:200px; width: 290px;" src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                           <?php 
                            } ?>
                                </div>
                                <div class="content">
                                    <div class="description"><b>
                                    
                                    <?php echo mb_substr($item['anuncio'][$crtl]['tituloanuncio'], 0, 32) . "..." ?></b></div>

                                    <div class="description">Tipo - 

                                        <?php 

                                        if($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta"){
                                            echo "Apartamento na Planta";
                                        }
                                        else
                                        echo ucfirst($item['anuncio'][$crtl]['tipo']) ?>


                                        <br />
                                        <span id="spanValor<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>"> 
                                        <?php echo $item['anuncio'][$crtl]['valormin'] ?> </span>
                                    </div>
                                </div>
                                <div class="extra content">      
                                    <div class="ui checkbox">
                                        <input type="checkbox" name="selecionarAnuncio[]" id="selecionarAnuncio_<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>" value="<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">
                                        <label id="idsAnuncios">Selecionar</label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
            <?php } ?>
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
    <div class="ui text loader">Loading</div>
</div>  