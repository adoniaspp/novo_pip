<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>

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

<?php foreach ($this->getItem() as $modal) { ?>
    <div class="ui modal" id='modal<?php echo $modal->getId() ?>'>
        <i class="close icon"></i>
        <div class="header">
            Detalhes do Imóvel
        </div>
        <div class="content">
            <div class="description">
                <?php
                echo "<div class='ui items'>
                                    <div class='item'>
                                      <div class='content'>
                                        <div class='header'>Tipo</div>
                                        <div class='meta'>
                                            <span class='price'>" . $modal->buscarTipoImovel($modal->getIdTipoImovel()) . "</span>
                                        </div>
                                        <div class='header'>Descrição</div>
                                        <div class='meta'>
                                            <span class='price'>" . $modal->getIdentificacao() . "</span>
                                        </div>
                                        </div>
                                    </div>
                           </div>";
                switch ($modal->getIdTipoImovel()) {
                    case "1":

                        echo "Condição: " . $modal->getCondicao() . "<br />";
                        echo "Quarto(s): " . $modal->getCasa()->getQuarto() . "<br />";
                        echo "Vagas de Garagem: " . $modal->getCasa()->getGaragem() . "<br />";
                        echo "Banheiro(s): " . $modal->getCasa()->getBanheiro() . "<br />";
                        echo "Suite(s): " . $modal->getCasa()->getSuite() . "<br />";
                        echo "Área: " . $modal->getCasa()->getArea() . "m2<br />";
                        break;

                    case "2":

                        echo "<div class='fields'><div class='four wide field'>
                                                      <label>Número de Andares: </label>" . $modal->getApartamentoPlanta()->getAndares() . "</div>
                                                      <div class='four wide field'>
                                                      <label>Unidades por Andar: </label>" . $modal->getApartamentoPlanta()->getUnidadesAndar() . "</div>
                                  </div>";
                        echo "Número de Torres: " . $modal->getApartamentoPlanta()->getNumeroTorres() . "<br />";
                        echo "Total de Unidades: " . $modal->getApartamentoPlanta()->getTotalUnidades() . "<br />";
                        echo "<div class='ui dividing header'></div>";

                        $numeroPlantas = count($modal->getPlanta());

                        if ($numeroPlantas == 1) {
                            echo "Planta:";

                            echo "<table class='ui table'>
                                <thead>
                                    <tr>
                                        <th>Titulo da Planta</th>
                                        <th>Quarto(s)</th>
                                        <th>Banheiro(s)</th>
                                        <th>Suite(s)</th>
                                        <th>Vaga(s) de Garagem</th>
                                        <th>Área</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>";


                            foreach ($modal->getPlanta() as $valoresPlanta) {
                                echo "<td>" . $valoresPlanta->getTituloPlanta() . "</td>";
                                echo "<td>" . $valoresPlanta->getQuarto() . "</td>";
                                echo "<td>" . $valoresPlanta->getBanheiro() . "</td>";
                                echo "<td>" . $valoresPlanta->getSuite() . "</td>";
                                echo "<td>" . $valoresPlanta->getGaragem() . "</td>";
                                echo "<td>" . $valoresPlanta->getArea() . "</td>";
                            }

                            echo "</tr></tbody></table>";
                        } else {
                            echo "Plantas: <br />";

                            echo "<table class='ui table'>
                                <thead>
                                    <tr>
                                        <th>Titulo da Planta</th>
                                        <th>Quarto(s)</th>
                                        <th>Banheiro(s)</th>
                                        <th>Suite(s)</th>
                                        <th>Vaga(s) de Garagem</th>
                                        <th>Área</th>
                                    </tr>
                                </thead>
                                <tbody>";

                            foreach ($modal->getPlanta() as $valoresPlanta) {
                                echo "<tr>";
                                echo "<td>" . $valoresPlanta->getTituloPlanta() . "</td>";
                                echo "<td>" . $valoresPlanta->getQuarto() . "</td>";
                                echo "<td>" . $valoresPlanta->getBanheiro() . "</td>";
                                echo "<td>" . $valoresPlanta->getSuite() . "</td>";
                                echo "<td>" . $valoresPlanta->getGaragem() . "</td>";
                                echo "<td>" . $valoresPlanta->getArea() . "</td>";
                            }
                            echo "</tr></tbody></table>";
                        }

                        break;
                    case "3":
                        echo "Quarto: " . $modal->getApartamento()->getQuarto() . "<br />";
                        echo "Vagas de Garagem: " . $modal->getApartamento()->getGaragem() . "<br />";
                        echo "Quarto(s): " . $modal->getApartamento()->getQuarto() . "<br />";
                        echo "Banheiro(s): " . $modal->getApartamento()->getBanheiro() . "<br />";
                        echo "Suite(s): " . $modal->getApartamento()->getSuite() . "<br />";
                        echo "Possui Sacada: " . $modal->getApartamento()->getSacada() . "<br />";
                        echo "Apartamentos p/ Andar: " . $modal->getApartamento()->getUnidadesAndar() . "<br />";
                        break;
                    case "4":
                        echo "Condição: " . $modal->getCondicao() . "<br />";
                        echo "Banheiro: " . $modal->getSalaComercial()->getBanheiro() . "<br />";
                        echo "Vagas de Garagem: " . $modal->getSalaComercial()->getGaragem() . "<br />";
                        echo "Condomínio: " . $modal->getSalaComercial()->getCondominio() . "<br />";
                        echo "Area: " . $modal->getSalaComercial()->getArea() . "<br />";
                        break;
                    case "5":
                        echo "Area: " . $modal->getPredioComercial()->getArea() . "<br />";
                        break;
                    case "6":
                        echo "Area: " . $modal->getTerreno()->getArea() . "<br />";
                        break;
                }
                echo "<div class='ui dividing header'></div>";
                if ($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() != "") {
                    echo "Endereço: " . $modal->getEndereco()->getLogradouro() . ", " . $modal->getEndereco()->getNumero() . ", " . $modal->getEndereco()->getComplemento() . "<br />";
                    echo $modal->getEndereco()->getBairro()->getNome() . ", " . $modal->getEndereco()->getCidade()->getNome() . " - " . $imovel->getEndereco()->getEstado()->getUf();
                } elseif ($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() == "") {
                    echo "Endereço: " . $modal->getEndereco()->getLogradouro() . ", " . $modal->getEndereco()->getNumero() . "<br />";
                    echo $modal->getEndereco()->getBairro()->getNome() . ", " . $modal->getEndereco()->getCidade()->getNome() . " - " . $imovel->getEndereco()->getEstado()->getUf();
                } elseif ($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() == "") {
                    echo "Endereço: " . $modal->getEndereco()->getLogradouro() . "<br />";
                    echo $modal->getEndereco()->getBairro()->getNome() . ", " . $modal->getEndereco()->getCidade()->getNome() . " - " . $imovel->getEndereco()->getEstado()->getUf();
                } elseif ($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() != "") {
                    echo "Endereço: " . $modal->getEndereco()->getLogradouro() . ", " . $modal->getEndereco()->getComplemento() . "<br />";
                    ;
                    echo $modal->getEndereco()->getBairro()->getNome() . ", " . $modal->getEndereco()->getCidade()->getNome() . " - " . $imovel->getEndereco()->getEstado()->getUf();
                }
                ?>
            </div>
        </div>
        <div class="actions">
            <div class="ui button">FECHAR</div>
        </div>
    </div> 

    <script>
        $(("#detalhes<?php echo $modal->getId() ?>")).click(function () {

            $("#modal<?php echo $modal->getId() ?>").modal({
                closable: false,
                transition: "fade up",
            }).modal('show');

        })
    </script> 

<?php
}

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