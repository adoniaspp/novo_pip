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

    <table class="ui table">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Descrição</th>
                <th>Data Cadastro</th>
                <th>Detalhes</th>
                <th>Operações</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $params = array(
                'mode' => 'Sliding',
                'perPage' => 5,
                'dela' => 2,
                'itemData' => $this->getItem());

            $pager = & Pager::factory($params);
            $data = $pager->getPageData();

            Sessao::gerarToken();

            foreach ($data as $imovel) {
                ?>
                <tr>        
                    <?php
                    echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel());
                    echo "<td>" . $imovel->getIdentificacao() . "</td>";
                    echo "<td>" . $imovel->getDatahoracadastro() . "</td>";
                    echo "<td><a href='#' class='ui green button' id='detalhes" . $imovel->getId() . "' ><i class='ui home icon'></i>Detalhes</div></td>";
                    if (count($imovel->getAnuncio()) > 0 && verificaAnuncioAtivo($imovel->getAnuncio())) {
                        echo"<td><div class='ui compact message'>Imóvel com Anúncio Ativo</div></td>";
                    } else {
                        echo"<td><a href='index.php?entidade=Anuncio&acao=form&idImovel=" . $imovel->getId() . "&token=" . $_SESSION['token'] . "' class='btn btn-info'><div class='ui purple button'>Publicar Anúncio</div></a></td>";
                    }
                }
                ?>                    
            </tr>         
        </tbody>
    </table>
    <?php
    $links = $pager->getLinks();
    echo ($links['all'] != "" ? "&nbsp;&nbsp;&nbsp;&nbsp;Página: " . $links['all'] : "");
    ?>
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