<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<?php
$item = $this->getItem();
?>
<script>
    carregarAnuncio(<?php echo count($item['anuncio']) ?>);
</script>
<form id="form" action="index.php" method="post" target='_blank'>
    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar" />
    <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" />
    <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" />
    <div class="ui center aligned three column page grid" id="resultadoBusca">
        <div class="sixteen wide column">
            <table id="tabela" class="ui very basic table stackable">
                <thead>
                    <tr style="border: none !important">
                        <th class="three wide">cards</th>
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
                                    <!--                        Integração com redes sociais-->
                                    <div class="extra content">      
                                        <div class="ui checkbox">
                                            <input type="checkbox" name="selecionarAnuncio[]" id="selecionarAnuncio_<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">
                                            <label>Selecionar</label>
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
    <div id="divBotoes"></div>
    <div class="one wide column"></div>
</div>
</form>
<div id="load">
    <div class="ui text loader">Loading</div>
</div>  
<script>
    $(document).ready(function () {
        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "pageLength": 6,
            "lengthMenu": [[6, 12, 18, 24, -1], [6, 12, 18, 24, "Todos"]],
            "stateSave": true
        });
    })
</script>