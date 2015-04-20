
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.6/css/jquery.dataTables.css">
<script src="assets/libs/DataTables-1.10.6/media/js/jquery.dataTables.min.js"></script>

<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">          
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Publicar Anúncios</a>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>

    <table class="ui table" id="tabela">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Descrição</th>
                <th>Data Cadastro</th>
                <th>Detalhes</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            <?php
           /* $params = array(
                'mode' => 'Sliding',
                'perPage' => 5,
                'dela' => 2,
                'itemData' => $this->getItem());

            $pager = & Pager::factory($params);
            $data = $pager->getPageData();*/

            Sessao::gerarToken();

            foreach ($this->getItem() as $imovel) {
                ?>
                <tr>        
                    <?php
                    echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel());
                    echo "<td>" . $imovel->getIdentificacao() . "</td>";
                    echo "<td>" . $imovel->getDatahoracadastro() . "</td>";
                    echo "<td><a href='#' class='ui green button' id='detalhes" . $imovel->getId() . "' ><i class='ui home icon'></i>Detalhes</div></td>";
                    
                    echo "<td>";
                    
                    if (count($imovel->getAnuncio()) > 0 && verificaAnuncioAtivo($imovel->getAnuncio())) {
                        echo"<div class='ui compact message'>Imóvel com Anúncio Ativo</div>";
                    } else {
                        echo"<a href='index.php?entidade=Anuncio&acao=form&idImovel=" . $imovel->getId() . "&token=" . $_SESSION['token'] . "' class='btn btn-info'><div class='ui purple button'>Publicar Anúncio</div></a>";
                    }
                    
                    echo "</td>";
                }
                ?>                    
            </tr>         
        </tbody>
    </table>
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
$('#tabela').dataTable({
        "language": {
            "url": "assets/libs/DataTables-1.10.6/media/js/pt.json",
        },
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "stateSave": true,
        "columnDefs": [
        { "orderable": false, "targets": 3 },
        { "orderable": false, "targets": 4 }
        ]
    });
</script>