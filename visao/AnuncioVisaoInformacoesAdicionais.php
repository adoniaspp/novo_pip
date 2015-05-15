<?php
$plantas = $item["imovel"][0]->getPlanta();
$andares = $item["imovel"][0]->getApartamentoPlanta()->getAndares();
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
                                <input type="hidden" name="sltAndar<?php echo $tipoAndar[$i]; ?>[]" id="sltAndar<?php echo $tipoAndar[$i]; ?>">
                                <div class="default text">Andar</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <?php
                                    for ($j = 0; $j <= $andares; $j++) {
                                        ?>
                                        <div class="item" data-value="<?php echo $j; ?>"><?php echo $j; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="three wide required field">
                        <label>Valor por andar</label>
                        <input type="text" name="txtValor[]" placeholder="Valor">
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
                    <tbody id="dadosPlanta<?php echo $planta->getOrdemplantas(); ?>"></tbody>
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
                                            <div class="ui inverted button">Inserir Imagem</div>
                                        </div>
                                    </div>
                                </div>
                                <img class="ui small  rounded image" src="/assets/imagens/logo.png">
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
           