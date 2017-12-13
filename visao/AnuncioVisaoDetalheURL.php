<!-- fotorama.css & fotorama.js. -->
<link  href="assets/libs/fotorama/fotorama.css" rel="stylesheet">
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/fotorama/fotorama.js"></script> 
<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>
<script async defer src="<?php echo GOOGLEMAPSURL; ?>"> </script>

<?php
$item = $this->getItem();

$anuncio        = $item["anuncio"];
$endereco       = $item["endereco"];
$imovel         = $item["imovel"];
$usuario        = $item["usuario"];
$qtdAnuncios    = $item["qtdAnuncios"];

?>

<script>
    marcarMapa("<?php echo $endereco[0]->getLogradouro()?>", "<?php echo $endereco[0]->getNumero()?>", "<?php echo $endereco[0]->getBairro()->getNome()?>", "<?php echo $anuncio[0]->getTituloAnuncio()?>", "<?php echo $anuncio[0]->getValormin()?>", "<?php echo $anuncio[0]->getFinalidade()?>", "500", "300", 10);
    enviarDuvidaAnuncio();
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
                            <?php foreach ($item['anuncio']['imagem'] as $imagem) { ?>
                                <a href="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . $imagem['nome'] ?>" data-caption="<?php echo $imagem['legenda'] ?>" data-thumb="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . 'thumbnail/' . $imagem['nome'] ?>"></a>
                            <?php } ?>
                        </div>
                        <!--<div class="ui info message">
                        <p> <?php echo $anuncio[0]->getDescricaoAnuncio() ?></p>
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
                                                    <?php echo $anuncio[0]->getFinalidade() ?>
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
                                                    <?php if ($imovel[0]->getTipoImovel()->getDescricao() == 'apartamentoplanta') {
                                                        echo 'Apartamento na Planta';
                                                    } else {
                                                        echo ucfirst($imovel[0]->getTipoImovel()->getDescricao());
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
                                                    R$ <?php echo $anuncio[0]->getValorMin() ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider"></div>
                                <div class="ui stackable three column padded grid">
<?php if ($imovel[0]->getTipoImovel()->getDescricao() == 'apartamentoplanta') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Andares
                                                    <div class="sub header">
    <?php echo $imovel[0]->getApartamentoPlanta()->getAndares() ?>
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
    <?php echo $imovel[0]->getApartamentoPlanta()->getUnidadesAndar() ?>
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
                                        <?php echo $imovel[0]->getApartamentoPlanta()->getTotalUnidades() ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
<?php
if ($imovel[0]->getTipoImovel()->getDescricao() != 'salacomercial' && $imovel[0]->getTipoImovel()->getDescricao() != 'terreno' &&
        $imovel[0]->getTipoImovel()->getDescricao() != 'apartamentoplanta') {
    ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Quartos
                                                    <div class="sub header">
                <?php 
                    $tipo = $imovel[0]->getTipoImovel()->getDescricao();
                    switch ($tipo){
                    case "casa"             : echo $imovel[0]->getCasa()->getQuarto(); break;
                    case "apartamento"      : echo $imovel[0]->getApartamento()->getQuarto();  break;                                            
                    }   
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php } ?>
<?php if ($imovel[0]->getTipoImovel()->getDescricao() != 'terreno' && $imovel[0]->getTipoImovel()->getDescricao() != 'apartamentoplanta') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="money icon"></i>
                                                <div class="content">
                                                    Banheiros
                                                    <div class="sub header">
                <?php 
                    $tipo = $imovel[0]->getTipoImovel()->getDescricao();
                    switch ($tipo){
                    case "casa"             : echo $imovel[0]->getCasa()->getBanheiro(); break;
                    case "apartamento"      : echo $imovel[0]->getApartamento()->getBanheiro();  break;                                            
                    case "salacomercial"    : echo $imovel[0]->getSalaComercial()->getBanheiro();  break;
                    }   
                ?>
                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php } ?> 
<?php if ($imovel[0]->getTipoImovel()->getDescricao() != 'apartamentoplanta') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Área
                                                    <div class="sub header">
                <?php 
                    $tipo = $imovel[0]->getTipoImovel()->getDescricao();
                    switch ($tipo){
                    case "casa"             : echo $imovel[0]->getCasa()->getArea()." m<sup>2</sup>"; break;
                    case "apartamento"      : echo $imovel[0]->getApartamento()->getArea()." m<sup>2</sup>";  break;                                            
                    case "salacomercial"    : echo $imovel[0]->getSalaComercial()->getArea()." m<sup>2</sup>";  break;
                    case "prediocomercial"  : echo $imovel[0]->getSalaPredioComercial()->getArea()." m<sup>2</sup>";  break;
                    case "terreno       "   : echo $imovel[0]->getSalaTerreno()->getArea()." m<sup>2</sup>";  break;
                    }   
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php } ?> 
<?php if ($imovel[0]->getTipoImovel()->getDescricao() == 'salacomercial') { ?>
                                        <div class="column">
                                            <div class="ui header">
                                                <i class="privacy icon"></i>
                                                <div class="content">
                                                    Condomínio
                                                    <div class="sub header">
                                        <?php echo $imovel[0]->getSalaComercial()->getCondominio() ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
<?php if ($imovel[0]->getTipoImovel()->getDescricao() != 'terreno') { ?>
                                    <div class="ui divider"></div>
                                    <div class="ui stackable three column padded grid">
    <?php if ($imovel[0]->getTipoImovel()->getDescricao() == 'apartamentoplanta') { ?>
                                            <div class="column">
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Torres
                                                        <div class="sub header">
                                            <?php echo $item['anuncio']['numerotorres'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    <?php } ?>
    <?php if ($imovel[0]->getTipoImovel()->getDescricao() != 'salacomercial' 
            && $imovel[0]->getTipoImovel()->getDescricao() != 'apartamentoplanta'
            && $imovel[0]->getTipoImovel()->getDescricao() != 'prediocomercial'){ ?>
                                            <div class="column">
                                                <div class="ui header">
                                                    <i class="privacy icon"></i>
                                                    <div class="content">
                                                        Suites
                                                        <div class="sub header">
                <?php 
                    $tipo = $imovel[0]->getTipoImovel()->getDescricao();
                    switch ($tipo){
                    case "casa"             : echo $imovel[0]->getCasa()->getGaragem(); break;
                    case "apartamento"      : echo $imovel[0]->getApartamento()->getGaragem();  break;                                                               
                    }   
                ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    <?php } ?>
    <?php if ($imovel[0]->getTipoImovel()->getDescricao() != 'apartamentoplanta') { ?>
                                            <div class="column">
                                                <div class="ui header">
                                                    <i class="car icon"></i>
                                                    <div class="content">
                                                        Garagem
                                                        <div class="sub header">
                <?php 
                    $tipo = $imovel[0]->getTipoImovel()->getDescricao();
                    switch ($tipo){
                    case "casa"             : echo $imovel[0]->getCasa()->getGaragem(); break;
                    case "apartamento"      : echo $imovel[0]->getApartamento()->getGaragem();  break;                                            
                    case "salacomercial"    : echo $imovel[0]->getSalaComercial()->getGaragem();  break; 
                    }   
                ?>
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
                                <div class="header"><?php echo $anuncio[0]->getTituloAnuncio() ?></div>
                                <p><?php echo $anuncio[0]->getDescricaoAnuncio() ?></p>
                            </div>
                        </div>
                    </div> 
                </div>
            </div> 
        </div>
<?php if ($imovel[0]->getTipoImovel()->getDescricao() == 'apartamentoplanta') { ?>
            <div class="column">
                <div class="ui segment">
                    <a class="ui yellow ribbon label">Plantas</a>
                    <div class="ui stackable one column padded grid">
                        <div class="column"> 
                            <div class="ui styled fluid accordion">
                                    <?php
                                    foreach ($item['anuncio']['plantas'] as $planta) {
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
            <div class="ui stackable two column padded grid">
            <div class="six wide column">               
              
                <div class="content">
                Endereço:  <?php echo $endereco[0]->getLogradouro(); ?>   
                </div>
                
                <div class="content">
                Nº -  <?php echo $endereco[0]->getNumero(); ?>
                </div>
                
                <div class="content">
                Bairro: <?php echo $endereco[0]->getBairro()->getNome() ?>
                </div>
               
                <div class="content">
                <?php echo $endereco[0]->getCidade()->getNome() ?>
                        <?php echo " - "; ?>
                        <?php echo $endereco[0]->getEstado()->getUF(); ?>  
                </div>
                
                <?php if($endereco[0]->getComplemento() != ""){?>               
                    <div class="content">
                Complemento: <?php echo $endereco[0]->getComplemento() ?>
                     </div>
                <?php }?>
                
            </div>
            <div class="column">
                <div id="mapaGmapsBusca"></div>
            </div>
            </div>
        </div>
        </div>
        
        <?php if($qtdAnuncios >= 2){
            ?>

            <div class="ui attached message">
                Este vendedor possui <?php echo $qtdAnuncios ?> anuncios cadastrados. Clique <a href='index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $usuario[0]->getLogin()?>' target="_blank">AQUI</a> para visualizá-los
            </div>

        <?php } ?>
        
        <div class="column">
            
            <div class="ui segment">
                <a class="ui red ribbon label">Contatos</a>
                
                
                
                <div class="ui stackable one column padded grid">
                    <div class="column"> 
                        <div class="ui relaxed divided items">
                            <div class="item">
                                <div class="ui small image">
                                    <img src="<?php echo PIPURL . "fotos/usuarios/" . $usuario[0]->getFoto() ?>">
                                </div>
                                <div class="content">
                                    <a class="header"><?php echo $usuario[0]->getNome() ?></a>
                                        <?php
                                        foreach ($usuario[0]->getTelefone() as $telefone) {
                                            ?>
                                        <div class="description">
                                        <?php echo $telefone->getNumero() ?> - <?php echo $telefone->getOperadora() ?>
                                        </div>
                                        <?php
                                    } 
                                    ?>                                   
                                    
                                    <div class="extra">
                                        
                                        <button class="ui right floated primary button" id="btnDuvida">
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
    <div class="ui standart modal" id="modalDuvidaAnuncio">
        <i class="close icon"></i>
        <div class="header">
            Envie sua dúvida
        </div>
        <div class="content" id="camposDuvida">
            <div class="description">
                <div class="ui piled segment">
                    <p id="textoConfirmacao"></p>

                    <form class="ui form" id="formDuvidaAnuncio" action="index.php" method="post">
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="enviarDuvidaAnuncio" />  
                        <input type="hidden" id="hdnUsuario" name="hdnUsuario" value="<?php echo $item['anuncio']['id'] ?>" />  
                        <input type="hidden" id="hdnAnuncio" name="hdnAnuncio" value="<?php echo $item['anuncio']['idanuncio'] ?>" />

                        <div class="field">
                            <label>Seu Nome</label>
                            <input name="txtNomeDuvida" id="txtNomeDuvida" placeholder="Digite seu Nome" type="text" maxlength="50">
                        </div>
                        <div class="field">
                            <label>E-mail para contato</label>
                            <input name="txtEmailDuvida"  id="txtEmailDuvida" placeholder="Digite seu email" type="text" maxlength="50">
                        </div>
                        <div class="field">
                            <label>Escreva sua dúvida</label>
                            <textarea rows="2" id="txtMsgDuvida" name="txtMsgDuvida" maxlength="200"></textarea>
                        </div>
                        
                        <div class="five wide field">
                        <label>Digite o código abaixo:</label>
                        <img id="captcha" src="../assets/libs/captcha/securimage/securimage_show.php" alt="CAPTCHA Image" />    
                        <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random(); return false">
                        <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                        <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
                        </div>
                        
                    </form>

                </div>
            </div>
        </div>
        <div id="divRetorno"></div>
        <div class="actions">
            <div  id="botaoCancelarDuvida" class="ui red deny button">
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
</div>




