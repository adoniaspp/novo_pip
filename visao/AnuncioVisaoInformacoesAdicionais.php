<p>Para cada planta informe o valor (não informar os centavos) por andar inicial e final.</p>
<?php
$plantas = $item["imovel"][0]->getPlanta();
echo '<input id="hdnPlantas" type="hidden" value="' . count($plantas) . '">';
if (is_object($plantas))
    $plantas = array($plantas);
$andares = $item["imovel"][0]->getApartamentoPlanta()->getAndares();
echo '<input id="hdnAndares" type="hidden" value="' . $andares . '">';
usort($plantas, function( $a, $b ) {
    //ID da planta será usado para comparação
    return ( $a->getOrdemplantas() > $b->getOrdemplantas() );
});
foreach ($plantas as $planta) {
    $tipoAndar = array('Inicial', 'Final');
    ?>
    <span class="ui green tag label">Planta <?php echo $planta->getOrdemplantas() + 1; ?>: <?php echo $planta->getTituloplanta(); ?></span>
    <div class="ui form segment">
        <div class="ui stackable grid">
            <div class="twelve wide column">
                <div class="fields">
                    <?php
                    for ($i = 0; $i < 2; $i++) {
                        ?>
                        <div class="five wide required field">
                            <label>Andar <?php echo $tipoAndar[$i]; ?></label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltAndar<?php echo $tipoAndar[$i]; ?>[]" id="sltAndar<?php echo $tipoAndar[$i]; ?>" class="sltAndar<?php echo $tipoAndar[$i]; ?>">
                                <div class="default text">Andar</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <?php
                                    for ($j = 1; $j <= $andares; $j++) {
                                        ?>
                                        <div class="item" data-value="<?php echo $j; ?>"><?php echo $j; ?></div>
        <?php } ?>
                                </div>
                            </div>
                        </div>
    <?php } ?>
                    <div class="three wide required field">
                        <label>Valor por andar</label>
                        <input type="text" name="txtValor[]" placeholder="Valor" class="txtValor">
                    </div>
                    <div class="three wide required field">
                        <br>
                        <button type="button" class="teal ui labeled icon button btnAdicionarValor" value="<?php echo $planta->getOrdemplantas(); ?>" />
                        <i class="add icon"></i>
                        Adicionar
                        </button>
                    </div>
                </div>    
                <table class="ui compact celled blue table" id="tabelaPlanta_<?php echo $planta->getOrdemplantas(); ?>" style="display: none">
                    <thead>
                        <tr>
                            <th>Andar Inicial</th>
                            <th>Andar Final</th>
                            <th>Valor</th>
                            <th>Opção</th>
                        </tr>
                    </thead>
                    <tbody id="dadosPlanta_<?php echo $planta->getOrdemplantas(); ?>"></tbody>
                </table>
            </div>
            <div class="four wide column">
                <div class="ui horizontal segment">
                    <div class="ui special cards">
                        <div class="card">
                            <div class="dimmable image">
                                <div class="ui dimmer">
                                    <div class="content">
                                        <div class="center">
                                            <label class="ui inverted button btn-file"> <input id="attachmentName<?php echo $planta->getOrdemplantas(); ?>" class="attachmentName" type="file" name="attachmentName<?php echo $planta->getOrdemplantas(); ?>" style="display: none"/>Inserir Imagem</label>
                                        </div>
                                    </div>
                                </div>
                                <?php  if($planta->getImagemdiretorio()!=""){ ?>
                                <img id="uploadPreview<?php echo $planta->getOrdemplantas(); ?>" class="ui small uploadPreview rounded image" src="/fotos/plantas/<?php echo $planta->getImagemdiretorio() . "/" . $planta->getImagemnome(); ?>">
<?php } else { ?>
                                
                                <img id="uploadPreview<?php echo $planta->getOrdemplantas(); ?>" class="ui small uploadPreview rounded image" src="/assets/imagens/logo.png">
                                
<?php } ?>
                                
                            </div>
                            <div class="extra content">
                                <a>
                                    <i class="file image outline icon"></i>
                                    Imagem Planta <?php echo $planta->getOrdemplantas() + 1; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>
<script>
    planta();
</script>

<script>    
    $(document).ready(function () {
        <?php if(isset($item["ValoresPlanta"])){
            foreach ($item["ValoresPlanta"] as $valor) { ?>
    $($($(".btnAdicionarValor")[<?php echo $valor->getPlanta()->getOrdemplantas(); ?>]).parent().parent().find("input")[0]).parent().dropdown('set selected', '<?php echo $valor->getAndarinicial(); ?>');
    $($($(".btnAdicionarValor")[<?php echo $valor->getPlanta()->getOrdemplantas(); ?>]).parent().parent().find("input")[1]).parent().dropdown('set selected', '<?php echo $valor->getAndarfinal(); ?>');
    $($($(".btnAdicionarValor")[<?php echo $valor->getPlanta()->getOrdemplantas(); ?>]).parent().parent().find("input")[2]).val('<?php echo $valor->getValor(); ?>').priceFormat({prefix: 'R$ ',centsSeparator: ',',centsLimit: 0,limit: 8,thousandsSeparator: '.'});
    $($(".btnAdicionarValor")[<?php echo $valor->getPlanta()->getOrdemplantas(); ?>]).click();
            <?php } } ?>
    
    })
    
</script>
