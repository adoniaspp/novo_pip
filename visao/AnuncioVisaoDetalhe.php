<?php

include_once 'configuracao/cookies.php';

?>

<link  href="assets/libs/fotorama/fotorama.css" rel="stylesheet">
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/fotorama/fotorama.js"></script> 
<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/js/anuncio.js"></script>
<script src="assets/js/resposta.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>

<?php
$item = $this->getItem();

$latitude = "";
$longitude = "";

if ($item["mapaImovel"]) {

    foreach ($item["mapaImovel"] as $mapa) {

        $latitude = $mapa->getLatitude();
        $longitude = $mapa->getLongitude();
    }
}
?>

<script>
    $(document).ready(function () {
        var tipoAnuncio = "<?php echo $item['anuncio'][0]['tipo'] ?>";

        switch (tipoAnuncio) {

            case "apartamento":
                $("#textoEspecifico").html("Características do Apartamento");
                $("#txtDiferencialAnuncio").html("Diferenciais do Apartamento");
                break;
            case "casa":
                $("#textoEspecifico").html("Características da Casa");
                $("#txtDiferencialAnuncio").html("Diferenciais da Casa");
                break;
            case "apartamentoplanta":
                $("#textoEspecifico").html("Informações das Plantas");
                $("#txtDiferencialAnuncio").html("Diferenciais Comuns do Apartamento na Planta");
                break;
            case "salacomercial":
                $("#textoEspecifico").html("Características da Sala Comercial");
                $("#txtDiferencialAnuncio").html("Diferenciais da Sala Comercial");
                break;
            case "prediocomercial":
                $("#textoEspecifico").html("Características do Prédio Comercial");
                $("#txtDiferencialAnuncio").html("Diferenciais do Prédio Comercial");
                break;
            case "terreno":
                $("#textoEspecifico").html("Características do Terreno");
                $("#txtDiferencialAnuncio").html("Diferenciais do Terreno");
                break;
        }
    })

    enviarDuvidaAnuncio();
    formatarDetalhe();

    marcarMapaIndividual("<?php echo $item["anuncio"][0]["logradouro"] ?>", "<?php echo $item["anuncio"][0]["numero"] ?>",
            "<?php echo $item["anuncio"][0]["bairro"] ?>", "<?php echo $item["anuncio"][0]["cidade"] ?>",
            "<?php echo $item["anuncio"][0]["estado"] ?>", "<?php echo $item["anuncio"][0]["tituloanuncio"] ?>",
            "<?php echo $item["anuncio"][0]["valormin"] ?>", "<?php echo $item["anuncio"][0]["finalidade"] ?>",
            "<?php echo $latitude ?>", "<?php echo $longitude ?>", "100%", "300", 16);

</script>

<div class="ui hidden divider"></div>

<?php if ($item["anuncio"][0]["status"] == "finalizado" || $item["anuncio"][0]["status"] == "expirado") { ?>
    <div class="ui middle aligned stackable grid container">
        <div class="sixteen column">
            <div class="ui negative message">
                <div class="header">
                    Atenção
                </div>
                Este seu anuncio não está mais ativo, não podendo mais ser visualizado por outros usuários.
            </div>
        </div>
    </div>
<?php } ?>

<?php
switch ($item['anuncio'][0]['tipo']) {

    case "casa":
        $tipoImovelTitulo = "Casa";
        break;

    case "apartamento":
        $tipoImovelTitulo = "Apartamento";
        break;

    case "apartamentoplanta":
        $tipoImovelTitulo = "Apartamento na Planta";
        break;

    case "salacomercial":
        $tipoImovelTitulo = "Sala Comercial";
        break;

    case "prediocomercial":
        $tipoImovelTitulo = "Prédio Comercial";
        break;

    case "terreno":
        $tipoImovelTitulo = "Terreno";
        break;
}
?>

<div class="stackable two column ui grid container">

    <div class="row">
        <h2 class="ui header">
            <i class="building icon"></i>
            <div class="content">
<?php echo $tipoImovelTitulo ?> - Informações Básicas
                <div class="sub header">Informações básicas do anúncio</div>
            </div>
        </h2>
    </div>

    <div class="column">
        <div class="ui segment">
            <a class="header">Título do Anúncio</a>
            <div class="description"> <?php echo $item['anuncio'][0]['tituloanuncio'] ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment">
            <a class="header">Descrição do Anúncio</a>
            <div class="description"><?php echo $item['anuncio'][0]['descricaoanuncio'] ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment"><a class="header">Código do Anúncio</a>
            <div class="description"><?php echo $item['anuncio'][0]['idanuncioformatado'] ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment"><a class="header">Data de Cadastro</a>
            <div class="description">
<?php echo date('d/m/Y H:i:s', strtotime($item['anuncio'][0]['datahoracadastro'])) ?>
            </div></div>
    </div>

</div>


<div class="stackable one column ui grid container">

    <div class="column">
        <form id="form" class="ui form">

            <div class="fields">          

                <div class="four wide field">
                    <div class="ui header">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeFinalidade.jpg">
                        <label>Finalidade</label>
                        <br>
                        <div class="content">    

                            <div class="sub header">
<?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['finalidade'] . "</font>"; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="four wide field">
                    <div class="ui header">
                        <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCasa.jpg">                     
                        <label>Imóvel</label>
                        <br>
                        <div class="content">
                            <div class="sub header">
<?php
$fonteImovel = "<font size = '4' color = 'maroon'>";

if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') {
    $fonteImovel .= 'Apartamento na planta';
} else if ($item['anuncio'][0]['tipo'] == 'salacomercial') {
    $fonteImovel .= 'Sala Comercial';
} else if ($item['anuncio'][0]['tipo'] == 'prediocomercial') {
    $fonteImovel .= 'Prédio Comercial';
} else if ($item['anuncio'][0]['tipo'] == 'apartamento') {
    $fonteImovel .= 'Apartamento';
} else if ($item['anuncio'][0]['tipo'] == 'casa') {
    $fonteImovel .= 'Casa';
} else
    $fonteImovel .= 'Terreno';

echo $fonteImovel . "</font>";
?>
                            </div>
                        </div>
                    </div>
                </div>

                                <?php if ($item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeArea.jpg">
                            <label>Área m<sup>2</sup></label>
                            <br>
                            <div class="content">
                                <div class="sub header">
    <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['area'] . "</font>" ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCondicao.jpg">
                            <label>Condição</label>
                            <br>
                            <div class="content">
                                <div class="sub header">
    <?php
    if ($item['anuncio'][0]['condicao'] == "usado") {
        echo "<font size = '4' color = 'maroon'>" . "Usado" . "</font>";
    } else
        echo "<font size = '4' color = 'maroon'>" . "Novo" . "</font>";
    ?>
                                </div>
                            </div>
                        </div>
                    </div>

<?php } ?> 

            </div>

            <div class="ui hidden divider"></div>

<?php if ($item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>    

<?php } ?>    

            <div class="ui horizontal divider" id="divisorTextoEspecifico">
                <div class="ui teal large label">
                    <div id="textoEspecifico"></div>                     
                </div>                     
            </div>     

            <div class="fields">  
<?php
if ($item['anuncio'][0]['tipo'] != 'salacomercial' && $item['anuncio'][0]['tipo'] != 'terreno' &&
        $item['anuncio'][0]['tipo'] != 'apartamentoplanta' && $item['anuncio'][0]['tipo'] != 'prediocomercial') {
    ?>
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                            <label>Quarto(s)</label>
                            <br>
                            <div class="content">
                                <div class="sub header">
    <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['quarto'] . "</font>" ?>
                                </div>
                            </div>
                        </div>
                    </div>
<?php } ?>



                <?php
                if ($item['anuncio'][0]['tipo'] != 'terreno' &&
                        $item['anuncio'][0]['tipo'] != 'apartamentoplanta' &&
                        $item['anuncio'][0]['tipo'] != 'prediocomercial') {
                    ?>
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                            <label>Banheiro(s)</label>
                            <br>
                            <div class="content">
                                <div class="sub header">
    <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['banheiro'] . "</font>" ?>
                                </div>
                            </div>
                        </div>
                    </div>
<?php } ?> 
                <?php
                if ($item['anuncio'][0]['tipo'] != 'salacomercial' && $item['anuncio'][0]['tipo'] != 'terreno' &&
                        $item['anuncio'][0]['tipo'] != 'apartamentoplanta' && $item['anuncio'][0]['tipo'] != 'prediocomercial') {
                    ?>   
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                            <label>Suite(s)</label>
                            <br>
                            <div class="content">
                                <div class="sub header">
    <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['suite'] . "</font>" ?>
                                </div>
                            </div>
                        </div>
                    </div>  
    <?php
    if ($item['anuncio'][0]['tipo'] == 'apartamento') {
        ?>    
                        <div class="four wide field">

    <?php } else { ?>    

                            <div class="four eight field">    

    <?php } ?>    

                            <div class="ui header">
                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeGaragem.jpg">
                                <label>Garagem(ns)</label>
                                <br>
                                <div class="content">
                                    <div class="sub header">
    <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['garagem'] . "</font>" ?> 
                                    </div>
                                </div>
                            </div>
                        </div>

    <?php
    if ($item['anuncio'][0]['tipo'] == 'apartamento') {
        ?>
                            <div class="four wide field">
                                <div class="ui header">
                                    <i class="privacy icon"></i>
                                    <div class="content">
                                        Condomínio

                                        <div class="sub header" id="divValorCondominio" style="font-size: medium ;color: maroon">
        <?php echo $item['anuncio'][0]['condominio'] ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
    <?php }
} ?>     
                </div>

                <?php
                if ($item['anuncio'][0]['tipo'] == 'apartamento') {

                    if ($item['anuncio'][0]['unidadesandar'] != null) {
                        ?>

                        <div class="ui list">
                            <div class="item">
                                <i class="right triangle icon"></i>
                                <h3 class="content">
                                    <div class="header">Apartamentos por Andar: <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['unidadesandar'] . "</font>" ?></div>                   
                                </h3>
                            </div>
                            <div class="item">
                                <i class="right triangle icon"></i>
                                <h3 class="content">
                                    <div class="header">Andar do Apartamento: <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio'][0]['andar'] . "</font>" ?></div>                   
                                </h3>
                            </div>
                        </div>            


    <?php }
} ?>

                <?php
                if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') {
                    ?>

                    <div class="fields">

                        <div class="ui styled fluid accordion">
    <?php
    foreach ($item['anuncio'][0]['plantas'] as $planta) {
        ?>
                                <div class="active title">
                                    <i class="dropdown icon"></i>
                                <?php
                                if (count($item['anuncio'][0]['plantas']) > 1) {

                                    echo "<font size = '4' color = 'maroon'>Planta " . ($planta['ordemplantas'] + 1) . " - " . $planta['tituloplanta'] . "</font>";
                                } else {

                                    echo "<font size = '4' color = 'maroon'>" . $planta['tituloplanta'] . "</font>";
                                }
                                ?>
                                </div>
                                <div class="active content">
                                    <div class="ui six column stackable grid container"> 
                                        <div class="column">
                                            <div class="fotorama" data-allowfullscreen="true">
                                                <img class="ui medium image" src="<?php echo PIPURL . "fotos/plantas/" . $planta['imagemdiretorio'] . "/" . $planta['imagemnome'] ?>"> 
                                            </div>
                                        </div>

                                        <div class="column">  
                                            <div class="ui tiny header">
                                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                                                <label>Quarto(s)</label>
                                                <br>
                                                <div class="content">
                                                    <div class="sub header">
        <?php echo $planta['quarto'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="column"> 
                                            <div class="ui tiny header">
                                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                                                <label>Banheiro(s)</label>
                                                <br>
                                                <div class="content">
                                                    <div class="sub header">
        <?php echo $planta['banheiro'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="column"> 
                                            <div class="ui tiny header">
                                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                                                <label>Suite(s)</label>
                                                <br>
                                                <div class="content">
                                                    <div class="sub header">
        <?php echo $planta['suite'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="column"> 
                                            <div class="ui tiny header">
                                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeGaragem.jpg">
                                                <label>Garagem(ns)</label>
                                                <br>
                                                <div class="content">
                                                    <div class="sub header">
        <?php echo $planta['garagem'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column"> 
                                            <div class="ui tiny header">
                                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeArea.jpg">
                                                <label>Area m<sup>2</sup></label>
                                                <br>
                                                <div class="content">
                                                    <div class="sub header">
        <?php echo $planta['area'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


        <?php
        $numeroDifPlantas = count($item['difPlantas'][$planta['id']]);

        if ($numeroDifPlantas > 0) {
            ?>

                                        <div class="ui  items">
                                            <div class="item">
                                                <div class="content">
                                                    <a class="header">Diferencial da Planta</a>
                                                    <div class="description">
                                        <?php
                                        foreach ($item['difPlantas'][$planta['id']] as $dif) {

                                            echo "<i class='large green checkmark icon'></i>" . $dif->getDiferencial()->getDescricao();
                                        }
                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                                        <?php
                                                    }//fim do If se existir mais de um diferencial da planta
                                                    ?>

                                </div>
        <?php
    }
    ?>

                        </div> 



                    </div>    
                    <div class="ui hidden divider"></div>
                        <?php } ?>

                        <?php if ($item['anuncio'][0]['diferenciais']) { ?>


                    <div class="ui horizontal divider" id="divisorTextoEspecifico">
                        <div class="ui teal large label">
                            <div id="txtDiferencialAnuncio"></div>                     
                        </div>                     
                    </div>


                    <div class="fields">

                    <?php foreach ($item['anuncio'][0]['diferenciais'] as $diferenciais) { ?>
                            <div class="twelve wide field">
                                <div class="ui tiny header">
                                    <div class="content">
                                        <i class="large green checkmark icon"></i><?php echo $diferenciais['descricao'] ?>
                                    </div>
                                </div>
                            </div>
    <?php } ?>

                    </div>    
                    <div class="ui hidden divider"></div>
                    <?php } ?>

                <div class="ui divider"></div>

                <div class="row">
                    <h2 class="ui header">
                        <i class="dollar green icon"></i>
                        <div class="content">
                            Valor do Anúncio
                            <div class="sub header">cadastrado pelo anunciante</div>
                        </div>
                    </h2>
                </div>

<?php
if ($item['anuncio'][0]['tipo'] != 'apartamentoplanta') {

    if ($item["novoValor"] != null) {
        ?>

                        <div class="ui hidden divider"></div>

                        <div class="item"> 

        <?php
        $contador = 0;
        foreach ($item["novoValor"] as $novoValor) {

            $contador = $contador + 1;
            if ($contador == 1) {
                ?>

                                    <script>
                                        formatarValorUnico(<?php echo $novoValor->getId() ?>);
                                    </script>

                                    <?php
                                    echo "<div class='ui big label'><span id='formatarValorUnicoJS" . $novoValor->getId() . "'>" . $novoValor->getNovoValor() . "</div></span>&nbsp;&nbsp;&nbsp;&nbsp";
                                } else {
                                    ?>

                                    <script>
                                        formatarValorCampos(<?php echo $novoValor->getId() ?>);
                                    </script>

                <?php
                echo "<div class='ui big label'><strike id='formatarValorJS" . $novoValor->getId() . "'>" . $novoValor->getNovoValor() . "</div></strike>&nbsp;&nbsp;&nbsp;&nbsp";
            }
        }
        ?>

                            <script>
                                formatarValorUnico(<?php echo $item['anuncio'][0]['id'] ?>);
                            </script>

                            <?php
                            echo "<div class='ui big label'><strike id='formatarValorUnicoJS" . $item['anuncio'][0]['id'] . "'>" . $item['anuncio'][0]['valormin'] . "</strike></div>&nbsp;&nbsp;&nbsp;&nbsp";
                            ?>

                        </div>

                        <?php } else { ?>

                        <script>
                            formatarValorUnico(<?php echo $item['anuncio'][0]['id'] ?>);
                        </script>

                            <?php
                            echo "<div class='ui big label'><span id='formatarValorUnicoJS" . $item['anuncio'][0]['id'] . "'>" . $item['anuncio'][0]['valormin'] . "</span></div>&nbsp;&nbsp;&nbsp;&nbsp";
                        }
                        ?>

                    <?php } else { ?>

                    <div class="ui hidden divider"></div>

                        <?php
                        $plantasOrdenadas = $item['anuncio'][0]['plantas'];
                        //ordenar as plantas pelo ID
                        usort($plantasOrdenadas, function( $a, $b ) {
                            //ID da planta será usado para comparação
                            return ( $a['ordemplantas'] > $b['ordemplantas'] );
                        });

                        foreach ($plantasOrdenadas as $planta) {
                            ?>

                        <div><?php echo "<font size = '4' color = 'maroon'>Planta " . ($planta['ordemplantas'] + 1) . " - " . $planta['tituloplanta'] . "</font>"; ?></div>

                        <table class="ui celled structured striped table">
                            <thead>
                                <tr>
                                    <th rowspan="2">Andar</th>                           
                                    <th rowspan="2">Valor</th>
                                </tr>
                            </thead>

                            <tbody>

                        <?php
                        echo "<tr>";

                        for ($x = 0; $x < count($planta['valores']); $x++) {

                            echo "<td>";

                            echo $planta['valores'][$x]['andarinicial'] . "º ao " . $planta['valores'][$x]['andarfinal'] . "º";

                            echo "</td>";
                            ?>

                                <script>
                                    formatarValorCampos(<?php echo $planta['valores'][$x]['id'] ?>);
                                </script>

                                <td id="formatarValorJS<?php echo $planta['valores'][$x]['id'] ?>"><?php echo $planta['valores'][$x]['valor'] ?></td>

            <?php
            echo "</tr>";
        }
        ?>

                            </tbody>    
                        </table>    

                            <?php }
                        } ?>

                <div class="ui hidden divider"></div>

                <div class="row">
                    <h2 class="ui header">
                        <i class="map outline brown icon"></i>
                        <div class="content">
                            Endereço
                            <div class="sub header">Veja a localização do Imóvel</div>
                        </div>
                    </h2>
                </div>

                <div class="fields">
                    <div id="mapaGmapsBusca"></div>
                </div>

                <div class="ui hidden divider"></div>
                <div class="sixteen wide field">
                    <div class="ui icon message">
                        <i class="red marker icon"></i>
                        <div class="header">

<?php
if ($item['anuncio'][0]['numero'] != "" && $item['anuncio'][0]['complemento'] != "") {
    $endereco = $item['anuncio'][0]['logradouro'] . " - " . $item['anuncio'][0]['bairro'] . ", " . $item['anuncio'][0]['numero'] . ", " . $item['anuncio'][0]['complemento'] . " - " . $item['anuncio'][0]['cidade'] . ", " . $item['anuncio'][0]['estado'];
} elseif ($item['anuncio'][0]['numero'] != "" && $item['anuncio'][0]['complemento'] == "") {
    $endereco = $item['anuncio'][0]['logradouro'] . " - " . $item['anuncio'][0]['bairro'] . ", " . $item['anuncio'][0]['numero'] . " - " . $item['anuncio'][0]['cidade'] . ", " . $item['anuncio'][0]['estado'];
} elseif ($item['anuncio'][0]['numero'] == "" && $item['anuncio'][0]['complemento'] == "") {
    $endereco = $item['anuncio'][0]['logradouro'] . " - " . $item['anuncio'][0]['bairro'] . " - " . $item['anuncio'][0]['cidade'] . ", " . $item['anuncio'][0]['estado'];
} elseif ($item['anuncio'][0]['numero'] == "" && $item['anuncio'][0]['complemento'] != "") {
    $endereco = $item['anuncio'][0]['logradouro'] . " - " . $item['anuncio'][0]['bairro'] . ", " . $item['anuncio'][0]['complemento'] . " - " . $item['anuncio'][0]['cidade'] . ", " . $item['anuncio'][0]['estado'];
}

echo $endereco;
?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <h2 class="ui header">
                        <i class="photo blue icon"></i>
                        <div class="content">
                            Fotos
                            <div class="sub header">Veja as imagens do anúncio</div>
                        </div>
                    </h2>
                </div>

                <div class="ui stackable two column centered grid">

                    <div class="column"> 

                        <div class="fotorama" data-allowfullscreen="native" data-nav="thumbs" data-width="100%" data-ratio="800/600">                            
                            <?php
                            if ($item['anuncio'][0]['imagem']) {
                                foreach ($item['anuncio'][0]['imagem'] as $imagem) {
                                    ?>
                                    <a href="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>" data-caption="<?php echo $imagem['legenda'] ?>" data-thumb="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . 'thumbnail/' . $imagem['nome'] ?>"></a>
        <?php
    }
} else {
    ?>
                                <a href="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" data-thumb=" <?php echo PIPURL . "/assets/imagens/thumbnail/foto_padrao.png" ?>"></a>
<?php }
?>
                        </div>
                        <!--<div class="ui info message">
                        <p> <?php echo $item['anuncio'][0]['descricaoanuncio'] ?></p>
                        </div>-->

                    </div>

                </div>    

                <div class="ui hidden divider"></div>

                <div class="row">
                    <h2 class="ui header">
                        <i class="volume control red phone icon"></i>
                        <div class="content">
                            Contato
                            <div class="sub header">Telefone(s) do anunciante</div>
                        </div>
                    </h2>
                </div>

                <div class="column">

                    <div class="ui horizontal segments">

                        <div class="ui segment">
                            <a class="header"><?php echo $item['anuncio'][0]['nome'] ?></a>

                            <div class="description">
<?php if ($item['anuncio'][0]['status'] == "cadastrado") { ?>





<?php } ?>
                            </div> 

<?php
foreach ($item['anuncio'][0]['telefone'] as $telefone) {
    ?>

                                <div class="description">

    <?php echo $telefone['numero'] ?> - <?php echo $telefone['operadora'] ?>                    
    <?php if ($telefone['whatsapp'] == "SIM") { ?>                        
                                        <i class="large green whatsapp icon"></i>
    <?php } ?>

                                </div>
    <?php
}
?>


                        </div>
                        <div class="ui segment center aligned ">
                            <button type="button" class="ui primary button" id="btnDuvida">
                                Enviar Mensagem/Proposta
                                <i class="right mail outline icon"></i>
                            </button>
                        </div>
                    </div>
                </div>



                                <?php if ($item["qtdAnuncios"] >= 2) { ?>

                                    <?php if ($item['anuncio'][0]['status'] == "cadastrado") { ?>
                           <div class="ui icon message">
                        <i class="blue user icon"></i>
                        <div class="header"> Este vendedor possui <?php echo $item["qtdAnuncios"] ?> anúncios cadastrados. <a href='index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $item["loginUsuario"] ?>' target="_blank">Veja mais anúncios dele.</a></div>
                        </div>
                                <?php } ?>

                            <?php } ?>                            

        </form>


<?php
if (Sessao::verificarSessaoUsuario()) {

    if ($_SESSION["idusuario"] == $item["loginUsuario"]) {

        if ($item["qtdMensagem"] >= 1) {
            ?>

                    <div class="ui dividing header"><div class="ui big brown label">Mensagem(ns) do Anúncio</div></div>

                    <script>
                        esconderResposta();
                    </script>

                    <div class="row">

                        <div class="column">

                            <div class="ui segment">

                                <div class="ui hidden divider"></div>

                                <div>

                    <?php foreach ($item["mensagem"] as $mensagem) { ?>

                                        <script>
                                            exibirDivResposta(<?php echo $mensagem->getId(); ?>);
                                            responderMensagem(<?php echo $mensagem->getId(); ?>);
                                            ocultarResposta(<?php echo $mensagem->getId(); ?>);

                                            $(document).ready(function () {

                                                $("#form<?php echo $mensagem->getId(); ?>").submit(function () {

                                                    $("#form<?php echo $mensagem->getId(); ?>").validate();
                                                    $("#txtResposta<?php echo $mensagem->getId(); ?>").rules("add", {
                                                        required: true,
                                                        minlength: 2,
                                                        messages: {
                                                            required: "Campo Obrigatório",
                                                            minlength: "Digite ao menos 2 caracteres"
                                                        }
                                                    });

                                                    if (($("#txtResposta<?php echo $mensagem->getId(); ?>").valid())) {
                                                        $.ajax({
                                                            url: "index.php",
                                                            dataType: "json",
                                                            type: "POST",
                                                            data: $('#form' + <?php echo $mensagem->getId(); ?>).serialize(),
                                                            beforeSend: function () {
                                                                $("#divRetorno" + <?php echo $mensagem->getId(); ?>).html("<div><div class='ui active inverted dimmer'>\n\
                                        <div class='ui text loader'>Processando. Aguarde...</div></div></div>");

                                                                $("#divCamposResposta" + <?php echo $mensagem->getId(); ?>).hide();

                                                            },
                                                            success: function (resposta) {
                                                                $("#divRetorno" + <?php echo $mensagem->getId(); ?>).empty();
                                                                if (resposta.resultado == 0) {
                                                                    $("#divRetorno" + <?php echo $mensagem->getId(); ?>).html('<div class="ui compact red message"><div class="header">Erro ao responder. Tente novamente em alguns minutos - 000.</div></div>');
                                                                } else if (resposta.resultado == 1) {
                                                                    $("#btnResponderMensagem" + <?php echo $mensagem->getId(); ?>).hide();
                                                                    $("#divRetorno" + <?php echo $mensagem->getId(); ?>).html('<div class="ui compact green message"><div class="header">Resposta enviada</div></div>');
                                                                }
                                                            }
                                                        })
                                                    }
                                                    return false;

                                                });
                                            });

                                        </script> 

                                        <form id="form<?php echo $mensagem->getId() ?>" class="ui form" action="index.php" method="post">
                                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="responderMensagem" />
                                            <input type="hidden" id="hdnMensagem" name="hdnMensagem" value="<?php echo $mensagem->getId(); ?>" />
                                            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

                                            <div id="divMensagem<?php echo (string) $mensagem->getId() ?>">                   

                                                <div class="field">

                                                    <div class="ui info icon message" style="width: 90%">   
                                                        <i class="mail icon"></i>
                                                        <div class="content">
                                                            <div class="header">Mensagem</div>
                <?php echo $mensagem->getMensagem() ?>
                                                        </div>
                                                    </div>


                <?php if ($mensagem->getProposta() != 0) { ?>

                                                        <script>
                                                            formatarValorProposta(<?php echo $mensagem->getId(); ?>);
                                                        </script>

                                                        <div class="ui positive icon message" style="width: 30%">   
                                                            <i class="dollar green icon"></i>
                                                            <div class="content">                                           
                                                                <div class="header">Proposta do comprador</div>
                                                                <label id="txtProposta<?php echo $mensagem->getId() ?>" name="txtProposta"><?php echo $mensagem->getProposta() ?></label>
                                                            </div>
                                                        </div>
                <?php } ?>

                                                    <div>
                                                        <label>Enviado em <?php echo substr($mensagem->getDataHora(), 0, 10) ?> 
                                                            as <?php echo substr($mensagem->getDataHora(), 10, -3) ?> por 

                                                            <?php
                                                            if ($mensagem->getNome() == "") {
                                                                echo "Anônimo";
                                                            } else
                                                                echo $mensagem->getNome();
                                                            ?>

                                                        </label>    
                                                    </div>

                                                </div>                                       

                <?php
                if ($mensagem->getStatus() != "RESPONDIDO") {
                    ?>

                                                    <div id="divCamposResposta<?php echo $mensagem->getId() ?>" style="width: 90%">

                                                        <label id="laberResponder<?php echo $mensagem->getId() ?>">
                                                            <a href="#<?php echo $mensagem->getId() ?>" id="responder<?php echo $mensagem->getId(); ?>">Responder</a>
                                                        </label>

                                                        <div class="required field"  id="divResposta<?php echo $mensagem->getId(); ?>">
                                                            <label>Digite a resposta</label>
                                                            <textarea rows="2" cols="5" name="txtResposta" id="txtResposta<?php echo $mensagem->getId(); ?>" maxlength="200"></textarea>     

                                                            <div class="ui hidden divider"></div>       

                                                            <div id="divBotoesMensagem">
                                                                <button class="ui blue button" type="submit" id="btnResponderMensagem<?php echo $mensagem->getId() ?>">Responder</button>
                                                                <button class="ui orange button" type="button" id="btnCancelarMensagem<?php echo $mensagem->getId() ?>">Cancelar</button>
                                                            </div>    

                                                        </div>

                                                    </div>     
                                                <?php } else { ?>  

                                                    <div id="divMsgRespondida<?php echo $mensagem->getId() ?>">

                                                    </div>
                                                    <label>Sua resposta:</label>


                                                    <i class="forward mail icon"></i>
                    <?php echo $mensagem->getRespostaMensagem()->getResposta() ?>

                                                    <div class="ui hidden divider"></div>

                                                    <label>Respondido em <?php echo substr($mensagem->getRespostaMensagem()->getDataHora(), 0, 10) ?> 
                                                        as <?php echo substr($mensagem->getRespostaMensagem()->getDataHora(), 10, -3) ?>
                                                    </label>          

                <?php } ?>  

                                            </div>  

                                            <div class="ui hidden divider"></div>
                                            <div id="divRetorno<?php echo $mensagem->getId() ?>"></div>               
                                            <div class="ui hidden divider"></div>

                                        </form>

                                        <div class="ui divider"></div>

            <?php } ?>

                                </div>
                            </div>

                        </div>


        <?php }
    }
} ?>
        </div>
    </div>
</div>

<div class="ui standart modal" id="modalDuvidaAnuncio">
    <i class="close icon"></i>
    <div class="header">
        Envie sua mensagem/proposta
    </div>
    <div class="content" id="camposDuvida">
        <div class="description">
            <div class="ui piled segment">
                <p id="textoConfirmacao"></p>

                <form class="ui form" id="formDuvidaAnuncio" action="index.php" method="post">
                    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                    <input type="hidden" id="hdnAcao" name="hdnAcao" value="enviarDuvidaAnuncio" />  
                    <input type="hidden" id="hdnUsuario" name="hdnUsuario" value="<?php echo $item['anuncio'][0]['id'] ?>" />  
                    <input type="hidden" id="hdnAnuncio" name="hdnAnuncio" value="<?php echo $item['anuncio'][0]['idanuncio'] ?>" />

                    <div class="field">
                        <label>Seu Nome</label>
                        <input name="txtNomeDuvida" id="txtNomeDuvida" placeholder="Digite seu Nome" type="text" maxlength="50">
                    </div>
                    <div class="field">
                        <label>E-mail para contato</label>
                        <input name="txtEmailDuvida"  id="txtEmailDuvida" placeholder="Digite seu email" type="text" maxlength="50">
                    </div>
                    <div class="field">
                        <label>Proposta de <?php if ($item['anuncio'][0]['finalidade'] == "Venda") {
    echo "Compra";
} else echo "aluguel" ?> R$ (Digite o valor se quiser fazer uma proposta ao vendedor)</label>
                        <input type="hidden" value="<?php echo $item['anuncio'][0]['finalidade'] ?>" id="hdnFinalidade" name="hdnFinalidade">
                        <div class="three wide field" id="divProposta">
                            <input name="txtProposta" id="txtProposta" type="text" maxlength="12" size="12"> 
                        </div>
                    </div>

                    <div class="field">
                        <label>Escreva sua dúvida</label>
                        <textarea rows="2" id="txtMsgDuvida" name="txtMsgDuvida" maxlength="200"></textarea>
                    </div>

                    <div class="five wide field">
                        <label>Digite o código abaixo:</label>
                        <img id="captcha" src="../assets/libs/captcha/securimage/securimage_show.php" alt="CAPTCHA Image" />    
                        <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random();
                                return false">
                            <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                        <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
                    </div>

                </form>

            </div>
        </div>
    </div>
    <div id="divRetorno"></div>
    <div class="actions">
        <div  id="botaoCancelarDuvida" class="ui orange deny button">
            Cancelar
        </div>
        <div  id="botaoEnviarDuvida" class="ui positive right labeled icon button">
            Enviar
            <i class="checkmark icon"></i>
        </div>
        <div  id="botaoFecharDuvida" class="ui red deny button">
            Fechar
        </div>
    </div>
</div>






