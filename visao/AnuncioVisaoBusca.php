<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script>
    carregarAnuncio();
</script>
<?php
$item = $this->getItem();
?>
<form id="form" action="index.php" method="post" target='_blank'>
    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar" />
    <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" />
    <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" />
    <input type="hidden" id="hdnOrdTipoImovel" name="hdnOrdTipoImovel"/>
    <input type="hidden" id="hdnOrdValor" name="hdnOrdValor"/>
    <input type="hidden" id="hdnOrdFinalidade" name="hdnOrdFinalidade"/>
    <input type="hidden" id="hdnOrdIdcidade" name="hdnOrdIdcidade"/>
    <input type="hidden" id="hdnOrdIdbairro" name="hdnOrdIdbairro"/>
    <input type="hidden" id="hdnOrdQuarto" name="hdnOrdQuarto"/>
    <input type="hidden" id="hdnOrdCondicao" name="hdnOrdCondicao"/>
    <input type="hidden" id="hdnOrdGaragem" name="hdnOrdGaragem"/>    
    <div class="ui center aligned three column page grid" id="resultadoBusca">
        <div class="sixteen wide column">
            <?php if (count($item['anuncio']) > 0) { ?>
                <div class="ui right aligned">
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltOrdenacao" id="sltOrdenacao">
                        <div class="default text">Escolha a ordem</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="preco_maior"><i class="ui chevron up icon"></i>Maior Preço</div>
                            <div class="item" data-value="preco_menor"><i class="ui chevron down icon"></i>Menor Preço</div>
                            <div class="item" data-value="recente_mais"><i class="ui chevron up icon"></i>Mais Recente</div>
                            <div class="item" data-value="recente_menos"><i class="ui chevron down icon"></i>Menos Recente</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
                        <tr style="width: 33%;float: left; border: none !important">
                            <td class="ui special cards" style="border: none !important">
                                <div class="card" id="cartao<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">
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
                                        <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                                    </div>
                                    <div class="content">
                                        <div class="description"><b><?php echo mb_substr($item['anuncio'][$crtl]['tituloanuncio'], 0, 32) . "..." ?></b></div>

                                        <div class="description">
                                            <?php echo ucfirst($item['anuncio'][$crtl]['tipo']) ?>
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