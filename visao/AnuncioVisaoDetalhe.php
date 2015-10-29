<!-- fotorama.css & fotorama.js. -->
<link  href="assets/libs/fotorama/fotorama.css" rel="stylesheet">
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/fotorama/fotorama.js"></script> 
<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=pt"></script>

<?php
$item = $this->getItem();
?>

<script>
    $(document).ready(function () {
    $("#divValor").priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
        })
    })
    marcarMapa("<?php echo $item["anuncio"][0]["logradouro"] ?>", "<?php echo $item["anuncio"][0]["numero"] ?>", "<?php echo $item["anuncio"][0]["bairro"] ?>", "<?php echo $item["anuncio"][0]["tituloanuncio"] ?>", "<?php echo $item["anuncio"][0]["valormin"] ?>", "<?php echo $item["anuncio"][0]["finalidade"] ?>", "600", "300", 9);
    enviarDuvidaAnuncio();
    //slideAnuncio();
    

</script>

<div class="ui hidden divider"></div>

<div class="ui middle aligned stackable grid container">
    <div class="row">
    <div class="column">
    <div class="ui segment">
                <a class="ui blue ribbon label">Detalhes</a>
                <div class="ui stackable two column padded grid">
                    <div class="column">  
                        <div class="ui blue dividing header">
<!--                            <i class="file image outline icon"></i>-->
                            <div class="content">
                                Fotos
                            </div>
                        </div>

                        <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-fit="cover" data-width="700" data-ratio="700/467" data-max-width="100%">                            
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
                    <div class="column">
                        <div class="ui blue dividing header">
<!--                            <i class="file image outline icon"></i>-->
                            <div class="content">
                                Informações Gerais
                            </div>
                        </div>

                    <div class="ui equal width grid"> 
                        <div class="column">
                            <div class="ui tiny header">
                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeFinalidade.jpg">
                                <label>Finalidade</label>
                                <br>
                                <div class="content">                                               
                                    <div class="sub header">
                                        <?php echo $item['anuncio'][0]['finalidade'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="ui tiny header">
                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeCasa.jpg">                     
                                <label>Imóvel</label>
                                <br>
                                <div class="content">
                                    <div class="sub header">
                                        <?php
                                        if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') {
                                            echo 'Apto na planta';
                                        } else {
                                            echo ucfirst($item['anuncio'][0]['tipo']);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="ui tiny header">
                                <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeValor.jpg">
                                <label>Valor</label>
                                <br>
                                <div class="content">
                                    <div class="sub header" id="divValor">
                                        <?php echo $item['anuncio'][0]['valormin'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                <div class="ui divider"></div>
                    <div class="ui stackable three column padded grid">
                        <?php if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') { ?>
                            <div class="column">
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeAndaresApto.jpg">
                                    <label>Nº de Andares</label>
                                    <br>
                                    <div class="content">
                                        Andares
                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['andares'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeAptoAndarDetalhes.jpg">
                                    <label>Apto(s) por Andar</label>
                                    <br>
                                    <div class="content">
                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['unidadesandar'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeTotalUnidades.jpg">
                                    <label>Total de Unidades</label>
                                    <br>
                                    <div class="content">                  
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
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                                    <label>Quarto(s)</label>
                                    <br>
                                    <div class="content">
                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['quarto'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($item['anuncio'][0]['tipo'] != 'terreno' && $item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                            <div class="column">
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                                    <label>Banheiro(s)</label>
                                    <br>
                                    <div class="content">
                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['banheiro'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> 
                        <?php if ($item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                            <div class="column">
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeArea.jpg">
                                    <label>Área m<sup>2</sup></label>
                                    <br>
                                    <div class="content">
                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['area']?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> 
                        <?php if ($item['anuncio'][0]['tipo'] == 'salacomercial') { ?>
                            <div class="column">
                                <div class="ui tiny header">
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
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeNumeroTorres.jpg">
                                    <label>Número de Torres</label>
                                    <br>
                                    <div class="content">
                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['numerotorres'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($item['anuncio'][0]['tipo'] != 'salacomercial' && $item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                            <div class="column">
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeQuarto.jpg">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeBanheiro.jpg">
                                    <label>Suite(s)</label>
                                    <br>
                                    <div class="content">
                                        <div class="sub header">
                                            <?php echo $item['anuncio'][0]['suite'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($item['anuncio'][0]['tipo'] != 'apartamentoplanta') { ?>
                            <div class="column">
                                <div class="ui tiny header">
                                    <img class="ui mini left floated image" src="../../assets/imagens/icones/iconeGaragem.jpg">
                                    <label>Garagem(ns)</label>
                                    <br>
                                    <div class="content">
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
    </div>

    <div class="row">

    <?php if ($item['anuncio'][0]['tipo'] == 'apartamentoplanta') { ?>
        <div class="column">
        <div class="ui segment">
            <a class="ui yellow ribbon label">Planta(s)</a>
                <div class="ui stackable one column padded grid">
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
                            </div>
                            <?php
                        }
                        ?>
                    </div>      
                        
                    </div>
                </div>
        </div>
        <?php } ?>
    
    </div>
    
    <div class="row">
    <?php if ($item['anuncio'][0]['diferenciais']) { ?>
            <div class="column">
                <div class="ui segment">
                    <a class="ui black ribbon label">Diferenciais</a>
                    <div class="ui stackable one column padded grid">
                        <div class="column">
                            <div class="ui three column stackable grid container"> 

                                <?php foreach ($item['anuncio'][0]['diferenciais'] as $diferenciais) { ?>
                                    <div class="column">  
                                        <div class="ui tiny header">
                                            <div class="content">
                                                <li><?php echo $diferenciais['descricao'] ?></li>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>    
    </div>
    
    <div class="row">
        <div class="column">
           <div class="ui segment">
                <a class="ui green ribbon label">Localização</a>
                <div class="ui stackable two column padded grid">
                    
                    <div class="column">
                    <div class="ui center aligned column page grid">
                    
                            <div id="mapaGmapsBusca"></div>
                    </div>
                    </div>
                    
                    <div class="five wide column">               
                        <div class="ui middle aligned selection list">
                            <div class="item">                                
                                <div class="content">
                                    <div class="header">Endereço</div>
                                    <?php echo $item['anuncio'][0]['logradouro'].", ".$item['anuncio'][0]['numero'] ?>
                                </div>
                            </div>
                            <?php if ($item['anuncio'][0]['complemento'] != "") { ?>  
                                <div class="item">                                
                                    <div class="content">
                                        <div class="header">Complemento</div>
                                        <?php echo $item['anuncio'][0]['complemento'] ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="item">                                
                                <div class="content">
                                    <div class="header">Bairro</div>
                                    <?php echo $item['anuncio'][0]['bairro'] ?>
                                </div>
                            </div>
                            <div class="item">                                
                                <div class="content">
                                    <div class="header">Cidade</div>
                                    <?php echo $item['anuncio'][0]['cidade'] ?>
                                </div>
                            </div>
                            <div class="item">                                
                                <div class="content">
                                    <div class="header">Estado</div>
                                    <?php echo $item['anuncio'][0]['estado'] ?>
                                </div>
                            </div>
                            
                        </div>                       
                    </div>
                    
                </div>
            </div> 
        </div>
    </div>

    <div class="row">
        
        <div class="column">
         
            <div class="ui segment">
                <?php if ($item["qtdAnuncios"] >= 2) {
            ?>

            <div class="ui message">
                Este vendedor possui <?php echo $item["qtdAnuncios"] ?> anuncios cadastrados. Clique <a href='index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $item["loginUsuario"] ?>' target="_blank">AQUI</a> para visualizá-los
            </div>

            <?php } ?>
            
            <div class="ui hidden divider"></div>
                
                    <a class="ui red ribbon label">Contatos</a>
                    <div class="ui stackable one column padded grid">
                        <div class="column"> 
                            <div class="ui relaxed divided items">
                                <div class="item">
                                    <div class="ui small image">
                                        <img style="height:150px; width: 220px;" src="<?php echo PIPURL . "fotos/usuarios/" . $item['anuncio'][0]['foto'] ?>">
                                    </div>
                                    <div class="content">
                                        <a class="header"><?php echo $item['anuncio'][0]['nome'] ?></a>
                                        <?php
                                        foreach ($item['anuncio'][0]['telefone'] as $telefone) {
                                            ?>
                                            
                                            <div class="description">
                                                <?php if($telefone['whatsapp']=="SIM"){?>
                                                
                                                <i class="big whatsapp icon"></i>
                                                <?php } ?>
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
            
    </div>
    
</div>

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






