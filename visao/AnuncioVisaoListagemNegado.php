
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">

<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/js/anuncio.js"></script>

<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {

        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "order": [[4, "desc"]]
        });

    })

</script>

<?php if ($_SESSION['login'] === 'pipdiministrador') { ?>

    <div class="ui middle aligned stackable grid container">
        <div class="row" id="breadcrumb">
            <div class="column">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <a class="active section">Anúncios Negados</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="column">
                <div class="ui message">
                    Listagem de anúncios com a ativação negada
                </div>
            </div>
        </div>

        <div class="row">
            <div class="column">
                <div class="ui horizontal segments">

                    <div class="ui segment center aligned ">
                        <i class='big red thumbs down icon'></i>Anúncios que tiveram a ativação negada
                    </div>

                </div>           
            </div>
        </div>


    </div>

    <div class="ui hidden divider"></div>

    <?php
    Sessao::gerarToken();

    $item = $this->getItem();

    $totalAnunciosCadastrados = count($item["listaAnuncio"]);

    if ($totalAnunciosCadastrados < 1) {
        ?>

        <div class="ui middle aligned stackable grid container">
            <div class="row">
                <div class="column">
                    <div class="ui warning message">
                        <i class="big yellow warning circle icon"></i>
                        Não existem anúncios com a ativação negada. Clique em voltar para retornar ao MEUPIP
                    </div>

                    <div class="row">
                        <a href="index.php?entidade=Usuario&acao=meuPIP">
                            <button class="ui orange button">Voltar</button>
                        </a>
                    </div> 
                </div>   
            </div>
        </div>    

    <?php } else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable?>
        <div class="ui middle aligned stackable grid container">
            <div class="row">
                <div class="column">
                    <table class="ui red stackable table" id="tabela">

                        <thead>
                            <tr>
                                <th>Cód. Anúncio</th>
                                <th>Tipo</th>
                                <th>Finalidade</th>
                                <th>Valor</th>
                                <th>Data Cadastro</th>
                                <th>Data Negação</th>                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($item) {
                                foreach ($item["listaAnuncio"] as $anuncio) {

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

                                            <form id="form<?php echo $anuncio->getId() ?>" action="index.php" method="post" target='_blank'>
                                                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="AnuncioAprovacao" />
                                                <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalharPendente"/>
                                                <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio->getId() ?>"/>
                                                <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>                                                                               

                                                <button class="ui labeled icon button">
                                                    <i class="zoom icon"></i>
                <?php echo $anuncio->getIdAnuncio(); ?>
                                                </button>
                                                <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $anuncio->getIdAnuncio() ?>" />
                                            </form>     
                                        </td>
                                        <td><?php
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
                                            ?></td>
                                        <td><?php echo $anuncio->getFinalidade(); ?></td>
                                        <td id="tdValor<?php echo $anuncio->getId(); ?>">
                <?php
                echo $anuncio->getValorMin();
                ?>

                                        </td>

                                        <td> <?php echo date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro())); ?> </td>  

                                        <td> <?php echo date('d/m/Y H:i:s', strtotime($anuncio->getDatahoraalteracao())); ?> </td>

                                    </tr>

                <?php
            }
        }
        ?>
                        </tbody>       
                    </table>
                </div>
            </div>
        </div>

        <div class="ui hidden divider"></div>

        <?php
        if ($item) {
            foreach ($item["listaAnuncio"] as $anuncio) {
                ?>

                <script>
                    formatarValor(<?php echo $anuncio->getId() ?>);
                    alterarStatusAnuncio(<?php echo $anuncio->getId() ?>)
                </script>

                <?php
            }
        }
        ?>

    <?php } //fim do else, caso haja anuncios ativos ?> 

<?php
} else {
    header("Location:" . PIPURL);
} //fim do else, caso o usuário não seja administrador
?> 