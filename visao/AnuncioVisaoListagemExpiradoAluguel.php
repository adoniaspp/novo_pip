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
        $("span[class='ui small grey button']").popup({
        });

        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "order": [[3, "desc"]],
            "columnDefs": [
                {"width": "20%", "orderable": false, "targets": 5}
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
                <div class="active section"><i class="refresh small icon"></i>Reativar Anúncios (aluguel)</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Reative um anúncio do tipo Aluguel sem precisar cadastrá-lo novamente. Você precisará escolher o plano e, caso queria, edite as características do anúncio.
                </p>
            </div>
        </div>
    </div> 
</div>
<div class="ui hidden divider"></div>
<?php
Sessao::gerarToken();
$item = $this->getItem();
$totalAnunciosExpirados = count($item["listaAnuncioExpirado"]);
if ($totalAnunciosFinalizados < 1 && $totalAnunciosExpirados < 1) {
    ?>
    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <div class="ui warning message">
                    <div class="header">Atenção</div>
                    <ul class="list">
                        Você não possui anúncios do tipo aluguel expirados. Clique em voltar para retornar ao MEUPIP
                    </ul>
                </div>
                <div class="row" id="btnCancelar">
                    <a href="index.php?entidade=Usuario&acao=meuPIP">
                        <button class="ui orange button">Voltar</button>
                    </a>
                </div>
            </div>  
        </div>
    </div>   
    <?php
} else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable  
    if (count($item["listaPlanos"]) == 0) {
        ?>
        <div class="ui middle aligned stackable grid container">
            <div class="row">
                <div class="column">
                    <div class="ui warning message">                          
                        <i class="large warning circle icon"></i>Atenção! Para reativar um anúncio de aluguel você deve ter um plano ativo. Não perca tempo e compre agora um novo plano clicando <a href="index.php?entidade=Plano&acao=listar">AQUI</a>.                
                    </div>
                </div>
            </div>
        </div>    
        <?php
    }
    ?>    
    <div class="ui middle aligned stackable grid container">
        <div class="column">
            <table class="ui brown table" id="tabela">
                <thead>
                    <tr>
                        <th>Cód. Anúncio</th>
                        <th>Tipo</th>
                        <th>Titulo do Anúncio</th>
                        <th>Valor</th>
                        <th>Data de Cadastro</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($item) {
                        foreach ($item["listaAnuncioExpirado"] as $anuncio) {
                            switch ($anuncio->getImovel()->getIdTipoImovel()) {
                                case 1: $tipoImovel = "casa";
                                    break;
                                case 2: $tipoImovel = "apartamentoplanta";
                                    break;
                                case 3: $tipoImovel = "apartamento";
                                    break;
                                case 4: $tipoImovel = "salacomercial";
                                    break;
                                case 5: $tipoImovel = "prediocomercial";
                                    break;
                                case 6: $tipoImovel = "terreno";
                                    break;
                            }
                            ?>
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
                                <td>
                                    <?php
                                    switch ($anuncio->getImovel()->getIdTipoImovel()) {
                                        case 1: echo "Casa";
                                            break;
                                        case 2: echo "Apartamento na Planta";
                                            break;
                                        case 3: echo "Apartamento";
                                            break;
                                        case 4: echo "Sala Comercial";
                                            break;
                                        case 5: echo "Prédio Comercial";
                                            break;
                                        case 6: echo "Terreno";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $anuncio->getTituloanuncio(); ?></td>
                                <td id="tdValor<?php echo $anuncio->getId(); ?>"><?php echo $anuncio->getValorMin(); ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro())); ?></td>
                                <td>
                                    <?php
                                    if ($anuncio->getStatus() == 'finalizado') {
                                        echo "<i class='big thumbs up red icon'></i>Finalizado em " . date('d/m/Y \à\s H:i:s \h', strtotime($anuncio->getHistoricoAluguelVenda()->getDatahora()));
                                    } else {
                                        echo "<i class='big remove circle red icon'></i>Expirado em " . date('d/m/Y', strtotime($anuncio->getDataHoraDesativacao()));
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (count($item["listaPlanos"]) > 0) {
                                        echo "<a href='index.php?entidade=Anuncio&acao=form&idAnuncio=" . $anuncio->getId() . "&token=" . $_SESSION['token'] . "&status=" . $anuncio->getStatus() ."' class='ui circular inverted icon button'><i class='big red refresh icon'></i></a>";
                                    } else {
                                        echo "<span class='ui circular inverted icon' data-content='Você precisa adquirir um plano para poder reativar este anúncio' data-variation='inverted'><i class='big disabled refresh icon'></i></span>";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>           
                </tbody>
            </table>
            <div class="row">
                <div class="column">
                    <div class="ui horizontal segments">
                        <div class="ui segment center aligned ">
                            <i class='big red refresh icon'></i> Reativar Anúncio
                        </div>
                        <div class="ui segment center aligned ">
                            <i class='big disabled refresh icon'></i>Não é possível reativar o anúncio
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>
    <script>
    <?php
    if ($item) {
        foreach ($item["listaAnuncioExpirado"] as $anuncio) {
            echo "formatarValor(" . $anuncio->getId() . ");";
        }
    }
    ?>
    </script>
<?php } ?> 