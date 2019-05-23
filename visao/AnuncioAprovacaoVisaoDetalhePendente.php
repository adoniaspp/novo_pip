<link  href="assets/libs/fotorama/fotorama.css" rel="stylesheet">
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/fotorama/fotorama.js"></script> 
<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/js/anuncio.js"></script>
<script src="assets/js/resposta.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script async defer src="<?php echo GOOGLEMAPSURL; ?>"> </script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>

<?php
$item = $this->getItem();

$latitude = "";
$longitude = "";
$expirado = "";
if ($item["mapaImovel"]) {
    $latitude = $item["mapaImovel"]->getLatitude();
    $longitude = $item["mapaImovel"]->getLongitude();
}
?>

<script>
    $(document).ready(function () {

        var tipoAnuncio = "<?php echo $item['anuncio']->getImovel()->getIdtipoImovel(); ?>";

        switch (tipoAnuncio) {

            case "3":
                $("#textoEspecifico").html("Características do Apartamento");
                $("#txtDiferencialAnuncio").html("Diferenciais do Apartamento");
                break;
            case "1":
                $("#textoEspecifico").html("Características da Casa");
                $("#txtDiferencialAnuncio").html("Diferenciais da Casa");
                break;
            case "2":
                $("#textoEspecifico").html("Informações das Plantas");
                $("#txtDiferencialAnuncio").html("Diferenciais Comuns do Apartamento na Planta");
                break;
            case "4":
                $("#textoEspecifico").html("Características da Sala Comercial");
                $("#txtDiferencialAnuncio").html("Diferenciais da Sala Comercial");
                break;
            case "5":
                $("#textoEspecifico").html("Características do Prédio Comercial");
                $("#txtDiferencialAnuncio").html("Diferenciais do Prédio Comercial");
                break;
            case "6":
                $("#textoEspecifico").html("Características do Terreno");
                $("#txtDiferencialAnuncio").html("Diferenciais do Terreno");
                break;
        }
    })

    formatarDetalhe();

<?php if ($item['anuncio']->getPublicarmapa() == "SIM") { ?>

        marcarMapaIndividual("<?php echo $item["anuncio"]->getImovel()->getEndereco()->getLogradouro() ?>", "<?php echo $item["anuncio"]->getImovel()->getEndereco()->getNumero() ?>",
                "<?php echo $item["anuncio"]->getImovel()->getEndereco()->getBairro()->getNome() ?>", "<?php echo $item["anuncio"]->getImovel()->getEndereco()->getCidade()->getNome() ?>",
                "<?php echo $item["anuncio"]->getImovel()->getEndereco()->getEstado()->getNome() ?>", "<?php echo $item["anuncio"]->getTituloanuncio() ?>",
                "<?php echo $item["anuncio"]->getValormin() ?>", "<?php echo $item["anuncio"]->getFinalidade() ?>",
                "<?php echo $latitude ?>", "<?php echo $longitude ?>", "100%", "300", 16);

<?php } ?>

</script>

<div class="ui hidden divider"></div>

<?php if (($item["anuncio"]->getStatus() === "pendenteanalise" || $item["anuncio"]->getStatus() === "emanalise") && $_SESSION['login'] == "pipdiministrador") { ?>

    <div class="ui middle aligned stackable grid container">
        <div class="sixteen column">
            <div class="ui warning message">
                <i class='big yellow warning circle icon'></i>
                <strong>Administrador</strong>, veja se este anúncio pode ou não ser aprovado. </strong>
            </div>
        </div>
    </div>

    <?php
}
if ($item["anuncio"]->getStatus() === "aprovacaonegada" && $_SESSION['login'] == "pipdiministrador") {
    ?>    

    <div class="ui middle aligned stackable grid container">
        <div class="sixteen column">
            <div class="ui negative message">
                <i class='big red times circle outline icon'></i>
                <strong>ATENÇÃO: Esse anúncio teve sua aprovação negada, não podendo ser visualizado</strong>
            </div>
        </div>
    </div>

<?php } ?>



<?php if ($item["anuncio"]->getStatus() === "pendenteanalise" || $item["anuncio"]->getStatus() === "emanalise") { ?>

    <div class="ui middle aligned stackable grid container">
        <div class="sixteen column">
            <div class="ui warning message">
                <i class='big yellow warning circle icon'></i>
                <strong>ATENÇÃO</strong>: Este anúncio ainda está pendente de aprovação, não podendo ainda ser visualizado por outros usuários
            </div>
        </div>
    </div>

<?php } ?>


<?php
switch ($item['anuncio']->getImovel()->getIdtipoimovel()) {

    case "1":
        $tipoImovelTitulo = "Casa";
        break;

    case "2":
        $tipoImovelTitulo = "Apartamento na Planta";
        break;

    case "3":
        $tipoImovelTitulo = "Apartamento";
        break;

    case "4":
        $tipoImovelTitulo = "Sala Comercial";
        break;

    case "5":
        $tipoImovelTitulo = "Prédio Comercial";
        break;

    case "6":
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
            <div class="description"> <?php echo $item['anuncio']->getTituloanuncio() ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment">
            <a class="header">Descrição do Anúncio</a>
            <div class="description"><?php echo nl2br($item['anuncio']->getDescricaoanuncio()) //função nl2br usada para formatar o texto cadastrado na textarea     ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment"><a class="header">Código do Anúncio</a>
            <div class="description"><?php echo $item['anuncio']->getIdanuncio() ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment"><a class="header">Data de Cadastro</a>
            <div class="description">
                 <?php echo FuncoesAuxiliares::tempo_corrido($item['anuncio']->getDatahoracadastro())." - ". date('d/m/Y H:i:s', strtotime($item['anuncio']->getDatahoracadastro())) ?>
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
                                <?php echo "<font size = '4' color = 'maroon'>" . $item['anuncio']->getFinalidade() . "</font>"; ?>
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
                                <?php echo "<font size = '4' color = 'maroon'>" . $tipoImovelTitulo . "</font>"; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($item['anuncio']->getImovel()->getIdtipoimovel() != '2') { ?>
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeArea.jpg">
                            <label>Área m<sup>2</sup></label>
                            <br>
                            <div class="content">
                                <div class="sub header">
                                    <?php echo "<font size = '4' color = 'maroon'>" . $item['dados']["area"] . "</font>"; ?>
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
                                    if ($item['anuncio']->getImovel()->getCondicao() == "usado") {
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

            <?php if ($item['anuncio']->getImovel()->getIdtipoimovel() != '2') { ?>    

            <?php } ?>    

            <div class="ui horizontal divider" id="divisorTextoEspecifico">
                <div class="ui teal large label">
                    <div id="textoEspecifico"></div>                     
                </div>                     
            </div>     

            <div class="fields">  
                <?php
                if ($item['anuncio']->getImovel()->getIdtipoimovel() != '4' && $item['anuncio']->getImovel()->getIdtipoimovel() != '6' &&
                        $item['anuncio']->getImovel()->getIdtipoimovel() != '2' && $item['anuncio']->getImovel()->getIdtipoimovel() != '5') {
                    ?>
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                            <label>Quarto(s)</label>
                            <br>
                            <div class="content">
                                <div class="sub header">
                                    <?php echo "<font size = '4' color = 'maroon'>" . $item['dados']["quarto"] . "</font>" ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php
                if ($item['anuncio']->getImovel()->getIdtipoimovel() != '6' &&
                        $item['anuncio']->getImovel()->getIdtipoimovel() != '2' &&
                        $item['anuncio']->getImovel()->getIdtipoimovel() != '5') {
                    ?>
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                            <label>Banheiro(s)</label>
                            <br>
                            <div class="content">
                                <div class="sub header">
                                    <?php echo "<font size = '4' color = 'maroon'>" . $item['dados']['banheiro'] . "</font>" ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?> 
                <?php
                if ($item['anuncio']->getImovel()->getIdtipoimovel() != '4' && $item['anuncio']->getImovel()->getIdtipoimovel() != '6' &&
                        $item['anuncio']->getImovel()->getIdtipoimovel() != '2' && $item['anuncio']->getImovel()->getIdtipoimovel() != '5') {
                    ?>   
                    <div class="four wide field">
                        <div class="ui header">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                            <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                            <label>Suite(s)</label>
                            <br>
                            <div class="content">
                                <div class="sub header">
                                    <?php echo "<font size = '4' color = 'maroon'>" . $item['dados']['suite'] . "</font>" ?>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <?php
                    if ($item['anuncio']->getImovel()->getIdtipoimovel() == '3') {
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
                                        <?php echo "<font size = '4' color = 'maroon'>" . $item['dados']['garagem'] . "</font>" ?> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($item['anuncio']->getImovel()->getIdtipoimovel() == '3') {
                            ?>
                            <div class="four wide field">
                                <div class="ui header">
                                    <i class="privacy icon"></i>
                                    <div class="content">
                                        Condomínio

                                        <div class="sub header" id="divValorCondominio" style="font-size: medium ;color: maroon">
                                            <?php echo $item['dados']['condominio'] ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>     
                </div>

                <?php
                if ($item['anuncio']->getImovel()->getIdtipoimovel() == '3') {

                    // if ($item['anuncio'][0]['unidadesandar'] != null) {
                    ?>

                    <div class="ui list">
                        <div class="item">
                            <i class="right triangle icon"></i>
                            <h3 class="content">
                                <div class="header">Apartamentos por Andar: <?php echo "<font size = '4' color = 'maroon'>" . $item['dados']['unidadesandar'] . "</font>" ?></div>                   
                            </h3>
                        </div>
                        <div class="item">
                            <i class="right triangle icon"></i>
                            <h3 class="content">
                                <div class="header">Andar do Apartamento: <?php echo "<font size = '4' color = 'maroon'>" . $item['dados']['andar'] . "</font>" ?></div>                   
                            </h3>
                        </div>
                    </div>            


                    <?php
                    //}
                }
                ?>

                <?php
                if ($item['anuncio']->getImovel()->getIdtipoimovel() == '2') {
                    //apartamento na planta
                    $plantasOrdenadas = $item['plantas'];
                    //ordenar as plantas pelo ID
                    usort($plantasOrdenadas, function( $a, $b ) {
                        $a = $a[0];
                        $b = $b[0];
                        $primeiroElemento = $a[0];
                        $segundoElemento = $b[0];
                        return ( $primeiroElemento->getOrdemplantas() > $segundoElemento->getOrdemplantas() );
                    });
                    ?>

                    <div class="fields">

                        <div class="ui styled fluid accordion">
                            <?php
                            foreach ($plantasOrdenadas as $arrayPlanta) {
                                $dadosPlanta = $arrayPlanta[0];
                                $planta = $dadosPlanta[0];
                                ?>
                                <div class="active title">
                                    <i class="dropdown icon"></i>
                                    <?php
                                    if (count($plantasOrdenadas) > 1) {
                                        echo "<font size = '4' color = 'maroon'>Planta " . ($planta->getOrdemplantas() + 1) . " - " . $planta->getTituloplanta() . "</font>";
                                    } else {
                                        echo "<font size = '4' color = 'maroon'>" . $planta->getTituloplanta() . "</font>";
                                    }
                                    ?>
                                </div>
                                <div class="active content">
                                    <div class="ui six column stackable grid container">
                                        <div class="column">
                                            <div class="fotorama" data-allowfullscreen="true">
                                                <?php if($planta->getImagemaprovacaodiretorio() == "") { ?>
                                                <img class="ui medium image" src="<?php echo PIPURL . "assets/imagens/logo.png" ?>">
                                                <?php } else { ?>
                                                <img class="ui medium image" src="<?php echo PIPURL . "fotos/plantas/" . $planta->getImagemaprovacaodiretorio() . "/" . $planta->getImagemaprovacaonome(); ?>">
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="column">
                                            <div class="ui tiny header">
                                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                                                <label>Quarto(s)</label>
                                                <br>
                                                <div class="content">
                                                    <div class="sub header">
        <?php echo $planta->getQuarto(); ?>
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
        <?php echo $planta->getBanheiro(); ?>
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
        <?php echo $planta->getSuite(); ?>
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
        <?php echo $planta->getGaragem(); ?>
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
        <?php echo $planta->getArea(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


        <?php
        
        
        $numeroDifPlantas = count($dadosPlanta['diferenciais']);

        if ($numeroDifPlantas > 0) {
            ?>

                                        <div class="ui  items">
                                            <div class="item">
                                                <div class="content">
                                                    <a class="header">Diferencial da Planta</a>
                                                    <div class="description">
            <?php
            foreach ($dadosPlanta['diferenciais'] as $dif) {

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

                <?php if (($item['anuncio']->getImovel()->getImoveldiferencial())) { ?>


                    <div class="ui horizontal divider" id="divisorTextoEspecifico">
                        <div class="ui teal large label">
                            <div id="txtDiferencialAnuncio"></div>                     
                        </div>                     
                    </div>

                    <div class="fields">

    <?php
    if (is_array($item['anuncio']->getImovel()->getImoveldiferencial())) {
        foreach ($item['anuncio']->getImovel()->getImoveldiferencial() as $diferenciais) {
            ?>

                                <div class="twelve wide field">
                                    <div class="ui tiny header">
                                        <div class="content">
                                            <i class="green checkmark icon"></i><?php echo $diferenciais->getDiferencial()->getDescricao() ?>
                                        </div>
                                    </div>
                                </div>
            <?php
        }
    } else {
        ?>                            
                            <div class="twelve wide field">
                                <div class="ui tiny header">
                                    <div class="content">
                                        <i class="green checkmark icon"></i><?php echo $item['anuncio']->getImovel()->getImoveldiferencial()->getDiferencial()->getDescricao() ?>
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
if ($item['anuncio']->getValormin() == 0) { //caso não haja valor cadastrado para o anúncio
    echo "<div class='ui compact yellow message'><i class='big warning circle icon'></i>Valor não informado. Entre em contato com o anunciante para mais detalhes.</div>";
} else {
    if ($item['anuncio']->getImovel()->getIdtipoimovel() != '2') {

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
                    echo "</div><div class='ui big label'><span id='formatarValorUnicoJS" . $novoValor->getId() . "'>" . $novoValor->getNovoValor() . "</div></span>&nbsp;&nbsp;&nbsp;&nbsp";
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
                                formatarValorUnico(<?php echo $item['anuncio']->getId() ?>);
                            </script>

            <?php
            echo "<div class='ui hidden divider'></div><div class='ui big label'><span id='formatarValorUnicoJS" . $item['anuncio']->getId() . "'>" . $item['anuncio']->getValormin() . "</span></div>&nbsp;&nbsp;&nbsp;&nbsp";
        }
        ?>

                    <?php } else { ?>

                        <div class="ui hidden divider"></div>

        <?php
        foreach ($plantasOrdenadas as $arrayPlanta) {
            $dadosPlanta = $arrayPlanta[0];
            $planta = $dadosPlanta[0];
            $valores = $dadosPlanta["valores"];
            //ordenar valores crescentes por andar inicial
            usort($valores, function( $primeiroElemento, $segundoElemento ) {
                return ( $primeiroElemento->getAndarinicial() > $segundoElemento->getAndarinicial() );
            });
            ?>

                            <div><?php echo "<font size = '4' color = 'maroon'>Planta " . ($planta->getOrdemplantas() + 1) . " - " . $planta->getTituloplanta() . "</font>"; ?></div>

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

            for ($x = 0; $x < count($valores); $x++) {

                echo "<td>";

                echo $valores[$x]->getAndarinicial() . "º ao " . $valores[$x]->getAndarfinal() . "º";

                echo "</td>";
                ?>

                                    <script>
                                        formatarValorCampos(<?php echo $valores[$x]->getId(); ?>);
                                    </script>

                                    <td id="formatarValorJS<?php echo $valores[$x]->getId(); ?>"><?php echo $valores[$x]->getValor(); ?></td>

                <?php
                echo "</tr>";
            }
            ?>

                                </tbody>    
                            </table>    

            <?php
        }
    }
}
?>

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
if ($item["anuncio"]->getImovel()->getEndereco()->getNumero() != "" && $item["anuncio"]->getImovel()->getEndereco()->getComplemento() != "") {
    $endereco = $item["anuncio"]->getImovel()->getEndereco()->getLogradouro() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getBairro()->getNome() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getNumero() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getComplemento() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getCidade()->getNome() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getEstado()->getNome();
} elseif ($item["anuncio"]->getImovel()->getEndereco()->getNumero() != "" && $item["anuncio"]->getImovel()->getEndereco()->getComplemento() == "") {
    $endereco = $item["anuncio"]->getImovel()->getEndereco()->getLogradouro() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getBairro()->getNome() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getNumero() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getCidade()->getNome() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getEstado()->getNome();
} elseif ($item["anuncio"]->getImovel()->getEndereco()->getNumero() == "" && $item["anuncio"]->getImovel()->getEndereco()->getComplemento() == "") {
    $endereco = $item["anuncio"]->getImovel()->getEndereco()->getLogradouro() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getBairro()->getNome() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getCidade()->getNome() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getEstado()->getNome();
} elseif ($item["anuncio"]->getImovel()->getEndereco()->getNumero() == "" && $item["anuncio"]->getImovel()->getEndereco()->getComplemento() != "") {
    $endereco = $item["anuncio"]->getImovel()->getEndereco()->getLogradouro() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getBairro()->getNome() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getComplemento() . " - " . $item["anuncio"]->getImovel()->getEndereco()->getCidade()->getNome() . ", " . $item["anuncio"]->getImovel()->getEndereco()->getEstado()->getNome();
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
$imagemAprovacao = $item['anuncio']->getImagemaprovacao();
if ($imagemAprovacao) {
    if (is_array($imagemAprovacao)) {
        foreach ($imagemAprovacao as $imagem) {
            echo '<a href="' . PIPURL . '/fotos/imoveis/' . $imagem->getDiretorio() . '/' . $imagem->getNome() . '" data-caption="' . $imagem->getLegenda() . '" data-thumb="' . PIPURL . '/fotos/imoveis/' . $imagem->getDiretorio() . '/' . 'thumbnail/' . $imagem->getNome() . '"></a>';
        }
    } else {
        echo '<a href="' . PIPURL . '/fotos/imoveis/' . $imagemAprovacao->getDiretorio() . '/' . $imagemAprovacao->getNome() . '" data-caption="' . $imagemAprovacao->getLegenda() . '" data-thumb="' . PIPURL . '/fotos/imoveis/' . $imagemAprovacao->getDiretorio() . '/' . 'thumbnail/' . $imagemAprovacao->getNome() . '"></a>';
    }
} else {
    echo '<a href="' . PIPURL . "/assets/imagens/foto_padrao.png" . '" data-thumb="' . PIPURL . "/assets/imagens/thumbnail/foto_padrao.png" . '"></a>';
}
?>
                        </div>
                    </div>

                </div>    

                <div class="ui hidden divider"></div>
<?php if ($item['anuncio']->getPublicarcontato() == "SIM") { ?>

                    <div class="row">
                        <h2 class="ui header">
                            <i class="volume control red phone icon"></i>
                            <div class="content">
                                Contato
                                <div class="sub header">Fale com o anunciante</div>
                            </div>
                        </h2>
                    </div>

                    <div class="column">

                        <div class="ui horizontal segments">


                            <div class="ui segment">
                                <a class="header"><?php echo $item['contato'][0]->getNome() ?></a>
    <?php
    if (is_array($item['contato'][0]->getTelefone())) {
        foreach ($item['contato'][0]->getTelefone() as $telefone) {
            ?>

                                        <div class="description">

            <?php echo $telefone->getNumero() ?> - <?php echo $telefone->getOperadora() ?>                    
                                            <?php if ($telefone->getWhatsapp() == "SIM") { ?>                        
                                                <i class="large green whatsapp icon"></i>
                                            <?php } ?>

                                        </div>
            <?php
        }
        ?>
                                <?php } else { ?>
                                    <div class="description">

        <?php echo $item['contato'][0]->getTelefone()->getNumero() ?> - <?php echo $item['contato'][0]->getTelefone()->getOperadora() ?>                    
                                        <?php if ($item['contato'][0]->getTelefone()->getWhatsapp() == "SIM") { ?>                        
                                            <i class="large green whatsapp icon"></i>
                                        <?php } ?>

                                    </div>
    <?php } ?>
                            </div>
                            <?php } ?>

                    </div>
                </div>
        </form>
    </div>
</div>
</div>