<script src="assets/libs/jquery/jquery.price_format.min.js"></script>

<script>
    carregarAnuncio();
</script>

<?php
$item = $this->getItem();
//echo '<pre>';
//print_r($item['anuncio'][0][tipo]);
//die();
if (count($item['anuncio']) == 1) {
    $linhas = 1;
    $ultimaLinha = 1;
} else {
    $itens = count($item['anuncio']);
    $linhas = round($itens / 3);
    $ultimaLinha = $itens - (($linhas-1) * 3);
//var_dump($ultimaLinha);
//die();
}
?>

<form id="form" action="index.php" method="post" target='_blank'>
    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar" />
    <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" />
    <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" />
    <div class="ui center aligned three column page grid" id="resultadoBusca">
        <div class="one wide column">
        </div>  
        <div class="fourteen wide column">
            <?php
            for ($i = 0; $i < $linhas; $i++) {
                $linha = 3;
                ?>
                <div class="ui special cards" id="resultados">
                    <?php
                    if ($i + 1 >= $linhas) {
                        $linha = $ultimaLinha;
                    }
                    for ($j = 0; $j < $linha; $j++) {
                        if ($i == 0) {
                            $crtl = $j;
                        } else {
                            $crtl = (($i + 1) * 3) - (3 - ($j));
                        }
                        ?>
                        <div class="card">
                            <div class="dimmable image">
                                <div class="ui inverted dimmer">
                                    <div class="content">
                                        <div class="center">
                                           <div class="ui blue basic button"> Detalhes </div>                                          
                                            <input type="hidden" id="anuncio<?php echo $item['anuncio'][$crtl]['id'] ?>"
                                                   value="<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>"/>
                                            <input type="hidden" id="anuncio<?php echo $item['anuncio'][$crtl]['tipo'] ?>"
                                                   value="<?php echo $item['anuncio'][$crtl]['tipo'] ?>"/>
                                            $item['anuncio'][$crtl]['tipo']
                                        </div>
                                    </div>
                                </div>
                                <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                            </div>
                            <div class="content">
                                <div class="description"><b><?php echo mb_substr($item['anuncio'][$crtl]['tituloanuncio'], 0, 32) . "..." ?></b></div>

                                <div class="description">
                                    <?php echo ucfirst($item['anuncio'][$crtl]['tipo']) ?>
                                    <br />
                                    <span id="spanValor"> <?php echo $item['anuncio'][$crtl]['valormin'] ?> </span>
                                </div>
                            </div>
                            <!--                        Integração com redes sociais-->
                            <div class="extra content">      
                                <a>
                                    <i class="big facebook square icon"></i>
                                </a>
<!--                                <a>
                                    <i class="big flickr icon"></i>
                                </a>-->
                                <a>
                                    <i class="big google plus icon"></i>
                                </a>
<!--                                <a>
                                    <i class="big instagram icon"></i>
                                </a>-->
                                <a>
                                    <i class="big twitter square icon"></i>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            ?>
        </div>
        
        <div class="one wide column">
        </div>
    </div>
</form>
<div id="load">
    <div class="ui text loader">Loading</div>
</div>  
