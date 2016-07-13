<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"><i class="list small icon"></i>Visualizar meus imóveis</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Veja seus imóveis já cadastrados abaixo</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <table class="ui green stackable table" id="tabela">
                <thead>
                    <tr>
                        <th class="three wide">Tipo</th>
                        <th class="five wide">Descrição</th>
                        <th class="three wide">Data Cadastro</th>
                        <th class="five wide">Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->getItem() as $imovel) {
                        echo "<tr>";

                        echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel()) . "</td>";

                        if (trim($imovel->getIdentificacao()) == "") {
                            $descricao = "<h4 class='ui red header'>Não Informado</h4>";
                        } else {
                            $descricao = $imovel->getIdentificacao();
                        }

                        echo "<td>" . $descricao . "</td>";

                        echo "<td>" . date('d/m/Y H:i:s', strtotime($imovel->getDatahoracadastro())) . "</td>";

                        echo "<td><a href='#' class='ui green button' id='detalhes" . $imovel->getId() . "' ><i class='ui home icon'></i>Detalhes</a>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="ui hidden divider"></div>  

<?php
include_once "/modal/ImovelListagemModal.php";

function verificaAnuncioAtivo($listaAnuncios) {
    $temAnuncioAtivo = false;
    if (count($listaAnuncios) > 1) {
        foreach ($listaAnuncios as $anuncio) {
            if ($anuncio->getStatus() == "cadastrado")
                $temAnuncioAtivo = true;
        }
    } else {
        if ($listaAnuncios->getStatus() == "cadastrado")
            $temAnuncioAtivo = true;
    }
    return $temAnuncioAtivo;
}
?>

<script>
    $(document).ready(function () {
        
        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );
        
        $('#tabela').dataTable({
            "language": {
                "url": "assets/libs/DataTables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "columnDefs": [
                {"orderable": false, "targets": 3}
            ]
        });
    })
</script>