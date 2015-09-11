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

?>

<script>
    marcarMapa("<?php echo $item["anuncio"][0]["logradouro"]?>", "<?php echo $item["anuncio"][0]["numero"]?>", "<?php echo $item["anuncio"][0]["bairro"]?>", "<?php echo $item["anuncio"][0]["tituloanuncio"]?>", "<?php echo $item["anuncio"][0]["valormin"]?>", "<?php echo $item["anuncio"][0]["finalidade"]?>", "500", "300", 10);
    enviarDuvidaAnuncio();
    slideAnuncio();

</script>

<div class="ui hidden divider"></div>

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
                            <?php 
                            if($item['anuncio'][0]['imagem']) {
                            foreach ($item['anuncio'][0]['imagem'] as $imagem) {                                  
                                ?>
                                <a href="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] .'/'. $imagem['nome'] ?>" data-caption="<?php echo $imagem['legenda'] ?>" data-thumb="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] .'/'. 'thumbnail/' . $imagem['nome'] ?>"></a>
                            <?php 
                                }
                            }else{
                                    ?>
                                   <a href="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" data-thumb=" <?php echo PIPURL . "/assets/imagens/thumbnail/foto_padrao.png" ?>"></a>
                               <?php 
                                } ?>
                        </div>
                        <!--<div class="ui info message">
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
            <div class="ui stackable two column padded grid">
            <div class="six wide column">               
                
                <div class="content">
                Endereço:  <?php echo $item['anuncio'][0]['logradouro'] ?>   
                </div>
                
                <div class="content">
                Nº -  <?php echo $item['anuncio'][0]['numero'] ?>
                </div>
                
                <div class="content">
                Bairro: <?php echo $item['anuncio'][0]['bairro'] ?>
                </div>
               
                <div class="content">
                <?php echo $item['anuncio'][0]['cidade'] ?>
                        <?php echo " - "; ?>
                        <?php echo $item['anuncio'][0]['estado']; ?>  
                </div>
                
                <?php if($item['anuncio'][0]['complemento'] != ""){?>               
                    <div class="content">
                Complemento: <?php echo $item['anuncio'][0]['complemento'] ?>
                     </div>
                <?php }?>
                
            </div>
            <div class="column">
                <div id="mapaGmapsBusca"></div>
            </div>
            </div>
        </div>
        </div>
        
        <?php if($item["qtdAnuncios"] >= 2){
            ?>

            <div class="ui attached message">
                Este vendedor possui <?php echo $item["qtdAnuncios"] ?> anuncios cadastrados. Clique <a href='index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $item["loginUsuario"]?>' target="_blank">AQUI</a> para visualizá-los
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
                                    <img style="height:180px; width: 290px;" src="<?php echo PIPURL . "fotos/usuarios/" . $item['anuncio'][0]['foto'] ?>">
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




