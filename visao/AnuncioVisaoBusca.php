<script src="assets/js/jquery.price_format.min.js"></script>

<script>
    carregarAnuncio();
</script>

<?php
$item = $this->getItem();
//print_r(count($item['anuncio'][0]['finalidade']));
//die();
$itens = count($item['anuncio']);
$linhas = ceil($itens / 4);
$resto = bcmod($itens, '4');
if($resto == 0){
    $ultimaLinha = 4;
}else{
    $ultimaLinha = $resto;
}
?>


<div class="ui center aligned column page grid" id="resultadoBusca">
    <div class="column">
        <?php
        for ($i = 0; $i < $linhas; $i++) {
            ?>
            <div class="ui four cards" id="resultados">
                <?php
                if(i+1 >= $linhas){
                    $linha = $ultimaLinha;
                }
                for ($j = 0; $j < $linha; $j++) {
                    ?>
                    <div class="card">
                        <div class="dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                        <div class="ui inverted button">Detalhes</div>
                                    </div>
                                </div>
                            </div>
                            <img src="/imagens/foto_padrao.png">
                        </div>
                        <div class="content">
                            <div class="description"><b><?php echo mb_substr($item['anuncio'][$j]['tituloanuncio'], 0, 32) . "..." ?></b></div>
                            
                            <div class="description">
                                <?php echo ucfirst($item['anuncio'][$j]['descricao']) ?>
                                <br />
                                <span id="spanValor"> <?php echo $item['anuncio'][$j]['valormin'] ?> </span>
                            </div>
                        </div>
<!--                        Integração com redes sociais-->
                        <div class="extra content">      
                            <a>
                                <i class="big facebook square icon"></i>
                            </a>
                            <a>
                                <i class="big flickr icon"></i>
                            </a>
                            <a>
                                <i class="big google plus icon"></i>
                            </a>
                            <a>
                                <i class="big instagram icon"></i>
                            </a>
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
</div>
<div id="load">
    <div class="ui text loader">Loading</div>
</div>  
