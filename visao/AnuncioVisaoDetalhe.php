<!-- fotorama.css & fotorama.js. -->
<link  href="assets/libs/fotorama/fotorama.css" rel="stylesheet">
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/fotorama/fotorama.js"></script> 
<script src="assets/js/anuncioDetalhe.js"></script>
<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=pt"></script>

<?php
$item = $this->getItem();
/*echo '<pre>';
print_r($item['anuncio']);
die();*/
?>

<script>
    marcarMapa("<?php echo $item["anuncio"][0]["logradouro"]?>", "<?php echo $item["anuncio"][0]["numero"]?>", "<?php echo $item["anuncio"][0]["bairro"]?>", "<?php echo $item["anuncio"][0]["tituloanuncio"]?>", "<?php echo $item["anuncio"][0]["valormin"]?>", "<?php echo $item["anuncio"][0]["finalidade"]?>", "500", "300", 10);
    confirmarEmail();
    enviarEmail();
    slideAnuncio();

</script>




<div class="container">

    <div class="ui one column centered page grid">
        <div class="column">
            <div class="ui segment">
                <a class="ui blue ribbon label">Detalhes</a>
                <div class="ui stackable three column padded grid">
                    <div class="eight wide column">  
                        <div class="ui blue dividing header">
<!--                            <i class="file image outline icon"></i>-->
                            <div class="content">
                                Fotos
                            </div>
                        </div>
                        <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-fit="cover" data-width="700" data-ratio="700/467" data-max-width="100%">
                            <?php foreach ($item['anuncio'][0]['imagem'] as $imagem) { ?>
                                <a href="<?php echo PIPURL . $imagem['diretorio'] ?>" data-caption="<?php echo $imagem['legenda'] ?>" data-thumb="<?php echo PIPURL . "/fotos/imoveis/teste1/thumbnail/foto1.jpg" ?>"></a>
                            <?php } ?>
                        </div>
                        <!--                        <div class="ui info message">
                                                    <p> <?php echo $item['anuncio'][0]['descricaoanuncio'] ?></p>
                                                </div>-->
                    </div>
                    <div class="eight wide column">
                        <div class="ui blue dividing header">
<!--                            <i class="file image outline icon"></i>-->
                            <div class="content">
                                Informações Gerais
                            </div>
                        </div>

                        <div class="ui stackable one column grid">
                            <div class="column">
                                <div class="ui stackable three column padded grid"> 
                                    <div class="column">
                                        <div class="ui header">
                                            <i class="announcement icon"></i>
                                            <div class="content">
                                                Finalidade
                                                <div class="sub header">
                                                    <?php echo $item['anuncio'][0]['finalidade'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="ui header">
                                            <i class="home icon"></i>
                                            <div class="content">
                                                Tipo
                                                <div class="sub header">
                                                    <?php if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') {
                                                        echo 'Apartamento na planta';
                                                    } else {
                                                        echo ucfirst($item['anuncio'][0]['tipo']);
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="ui header">
                                            <i class="money icon"></i>
                                            <div class="content">
                                                Valor
                                                <div class="sub header">
                                                    R$ <?php echo $item['anuncio'][0]['valormin'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider"></div>
                                <div class="ui stackable three column padded grid">
<?php if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Andares
                                                    <div class="sub header">
    <?php echo $item['anuncio'][0]['andares'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Unidades p/ Andar
                                                    <div class="sub header">
    <?php echo $item['anuncio'][0]['unidadesandar'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Total de Unidades
                                                    <div class="sub header">
                                        <?php echo $item['anuncio'][0]['totalunidades'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
<?php
if ($item['anuncio'][0]['tipo'] != 'salacomercial' && $item['anuncio'][0]['tipo'] != 'terreno' &&
        $item['anuncio'][0]['tipo'] != 'apartamentoplanta') {
    ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Quartos
                                                    <div class="sub header">
                                        <?php echo $item['anuncio'][0]['quarto'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php } ?>
<?php if ($item['anuncio'][0]['tipo'] != 'terreno' && $item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="money icon"></i>
                                                <div class="content">
                                                    Banheiros
                                                    <div class="sub header">
                                        <?php echo $item['anuncio'][0]['banheiro'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php } ?> 
<?php if ($item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Área
                                                    <div class="sub header">
                                        <?php echo $item['anuncio'][0]['area'] . 'm' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php } ?> 
<?php if ($item['anuncio'][0]['tipo'] == 'salacomercial') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Condomínio
                                                    <div class="sub header">
                                        <?php echo $item['anuncio'][0]['condominio'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
<?php if ($item['anuncio'][0]['tipo'] != 'terreno') { ?>
                                    <div class="ui divider"></div>
                                    <div class="ui stackable three column padded grid">
    <?php if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') { ?>
                                            <div class="column">
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Torres
                                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['numerotorres'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    <?php } ?>
    <?php if ($item['anuncio'][0]['tipo'] != 'salacomercial' && $item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                                            <div class="column">
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Suites
                                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['suite'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    <?php } ?>
    <?php if ($item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                                            <div class="column">
                                                <div class="ui header">
                                                    <i class="car icon"></i>
                                                    <div class="content">
                                                        Garagem
                                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['garagem'] ?> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    <?php } ?>       
                                    </div>
<?php } ?>    
                                <div class="ui divider"></div>                              
                            </div>
                        </div> 
                        <div class="sixteen wide column"> 
                            <div class="ui info message">
                                <div class="header"><?php echo $item['anuncio'][0]['tituloanuncio'] ?></div>
                                <p><?php echo $item['anuncio'][0]['descricaoanuncio'] ?></p>
                            </div>
                        </div>
                    </div> 
                </div>
            </div> 
        </div>
<?php if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') { ?>
            <div class="column">
                <div class="ui segment">
                    <a class="ui yellow ribbon label">Plantas</a>
                    <div class="ui stackable one column padded grid">
                        <div class="column"> 
                            <div class="ui styled fluid accordion">
                                    <?php
                                    foreach ($item['anuncio'][0]['plantas'] as $planta) {
                                        ?>
                                    <div class="active title">
                                        <i class="dropdown icon"></i>
        <?php echo $planta['tituloplanta'] ?>
                                    </div>
                                    <div class="active content">
                                        <div class="ui six column stackable grid container"> 
                                            <div class="column">
                                                <div class="fotorama" data-allowfullscreen="true">
                                                    <img class="ui medium image" src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>"> 
                                                </div>
                                            </div>

                                            <div class="column">  
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Quartos
                                                        <div class="sub header">
        <?php echo $planta['quarto'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column"> 
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Suites
                                                        <div class="sub header">
        <?php echo $planta['suite'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column"> 
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Banheiros
                                                        <div class="sub header">
        <?php echo $planta['banheiro'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column"> 
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Garagem
                                                        <div class="sub header">
        <?php echo $planta['garagem'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column"> 
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Area
                                                        <div class="sub header">
        <?php echo $planta['area'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
        <?php
    }
    ?>
                            </div>
                        </div>
                    </div> 

                </div>
            </div>
<?php } ?>
        
        <div class="column">
            <div class="ui segment">
                <a class="ui green ribbon label">Localização</a>
                <div class="ui vertically padded page grid">
                    <div class="ui two column centered row">
                        <div class="column">
                                <?php if ($item['anuncio'][0]['publicarmapa'] == "SIM") { ?>

                                    <div class="row">

                                                <div data-row-span="5">
                                                    <div data-field-span="1">
                                                        <label>Endereço: </label>
                                                        <?php echo $item['anuncio'][0]['logradouro'] ?>
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Nº - </label>
                                                        <?php echo $item['anuncio'][0]['numero'] ?>
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Bairro: </label>
                                                        <?php echo $item['anuncio'][0]['bairro'] ?>
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Cidade: </label>
                                                    <?php echo $item['anuncio'][0]['cidade'] ?>
                                                        <?php echo " - "; ?>
                                                        <?php echo $item['anuncio'][0]['estado']; ?>
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Complemento: </label>
                                                    <?php echo $item['anuncio'][0]['complemento'] ?>
                                                    </div>
                                                </div>
                                    </div>
                        <?php } ?>
                        </div>
                        <div class="column">
                            <div class="row">
                                <div id="mapaGmapsBusca"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
        </div>
        
        <div class="column">
            <div class="ui segment">
                <a class="ui red ribbon label">Contatos</a>
                <div class="ui stackable one column padded grid">
                    <div class="column"> 
                        <div class="ui relaxed divided items">
                            <div class="item">
                                <div class="ui small image">
                                    <img src="<?php echo PIPURL . "fotos/usuarios/" . $item['anuncio'][0]['foto'] ?>">
                                </div>
                                <div class="content">
                                    <a class="header"><?php echo $item['anuncio'][0]['nome'] ?></a>
                                        <?php
                                        foreach ($item['anuncio'][0]['telefone'] as $telefone) {
                                            ?>
                                        <div class="description">
                                        <?php echo $telefone['numero'] ?> - <?php echo $telefone['operadora'] ?>
                                        </div>
    <?php
}
?>
                                    <div class="extra">
                                        
                                        <button class="ui right floated primary button" id="btnEmail">
                                            Envie uma mensagem
                                            <i class="right mail outline icon"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>                                
                    </div>
                </div>
            </div>
        </div> 
        <div class="column"></div>
    </div>
    <div class="column"></div>

    <!-- Modal Para Abrir a Div do Enviar Anuncios por Email -->
    <div class="ui standart modal" id="modalEmail">
        <i class="close icon"></i>
        <div class="header">
            Envie sua dúvida
        </div>
        <div class="content" id="camposEmail">
            <div class="description">
                <div class="ui piled segment">
                    <p id="textoConfirmacao"></p>

                    <form class="ui form" id="formEmail" action="index.php" method="post">
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="enviarEmail" />   
                        <input type="hidden" id="hdnMsgDuvida" name="hdnMsgDuvida"/>
                        <input type="hidden" id="hdnAnuncio" name="hdnAnuncio" value="<?php echo $item['anuncio'][0]['idanuncio'] ?>" />

                        <div class="field">
                            <label>Nome</label>
                            <input name="txtNomeEmail" id="txtNomeEmail" placeholder="Digite Seu Nome" type="text" maxlength="50">
                        </div>
                        <div class="field">
                            <label>E-mail para contato</label>
                            <input name="txtEmailEmail"  id="txtEmailEmail" placeholder="Digite o email" type="text" maxlength="50">
                        </div>
                        <div class="field">
                            <label>Escreva sua dúvida</label>
                            <textarea rows="2" id="txtMsgEmail" name="txtMsgEmail" maxlength="200"></textarea>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <div id="divRetorno"></div>
        <div class="actions">
            <div  id="botaoCancelarEmail" class="ui red deny button">
                Cancelar
            </div>
            <div  id="botaoEnviarEmail" class="ui positive right labeled icon button">
                Enviar
                <i class="checkmark icon"></i>
            </div>
            <div  id="botaoFecharEmail" class="ui red deny button">
                Fechar
            </div>
        </div>
    </div>
</div>




