<!-- fotorama.css & fotorama.js. -->
<link  href="assets/libs/fotorama/fotorama.css" rel="stylesheet"> 
<script src="assets/libs/fotorama/fotorama.js"></script> 

<?php
$item = $this->getItem();
//echo '<pre>';
//print_r($item);
//die();
?>
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
                        <div class="fotorama" data-nav="thumbs" data-fit="cover" data-width="700" data-ratio="700/467" data-max-width="100%">
                            <?php //foreach ($imagens as $imagem) { ?>
                            <a href="<?php echo "http://localhost/fotos/5a04mq12btaqveua2pr7pai904/amostra04.jpg" ?>" data-caption="<?php echo "Casa" ?>" data-thumb="<?php echo "http://localhost/fotos/5a04mq12btaqveua2pr7pai904/thumbnail/amostra04.jpg" ?>"></a>
                            <a href="<?php echo "http://localhost/fotos/5a04mq12btaqveua2pr7pai904/amostra04.jpg" ?>" data-caption="<?php echo "Casa" ?>" data-thumb="<?php echo "http://localhost/fotos/5a04mq12btaqveua2pr7pai904/thumbnail/amostra04.jpg" ?>"></a>
                            <?php //} ?>
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
                                            <i class="privacy icon"></i>
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
                                                    <?php echo $item['anuncio'][0]['descricao'] ?>
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
                                </div>
                                <div class="ui divider"></div>
                                <div class="ui stackable three column padded grid"> 
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
                                    
                                </div>
                                
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

            <div class="column">
                <div class="ui segment">
                    <a class="ui green ribbon label">Localização</a>
                    <div class="ui vertically padded page grid">
                        <div class="ui two column centered row">
                            <div class="column">
                                <?php if ($item['anuncio'][0]['publicarmapa'] == "SIM") { ?>
                                    <div class="tab-pane fade" id="vernomapa">
                                        <div class="row">
                                            <form class="grid-form">
                                                <div class="col-xs-12">
                                                    <div data-row-span="5">
                                                        <div data-field-span="1">
                                                            <label>Logradouro</label>
                                                            <?php echo $item['anuncio'][0]['logradouro'] ?>
                                                        </div>
                                                        <div data-field-span="1">
                                                            <label>Número</label>
                                                            <?php echo $item['anuncio'][0]['numero'] ?>
                                                        </div>
                                                        <div data-field-span="1">
                                                            <label>Bairro</label>
                                                            <?php echo $item['anuncio'][0]['bairro'] ?>
                                                        </div>
                                                        <div data-field-span="1">
                                                            <label>Cidade</label>
                                                            <?php echo $item['anuncio'][0]['cidade'] ?>
                                                            <?php echo " - "; ?>
                                                            <?php echo $item['anuncio'][0]['estado']; ?>
                                                        </div>
                                                        <div data-field-span="1">
                                                            <label>Complemento</label>
                                                            <?php echo $item['anuncio'][0]['complemento'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="column">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="popin">
                                            <div id="mapaModal"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 
            </div>
            <div class="column">
                <div class="ui segment">
                    <a class="ui red ribbon label">Contatos</a>
                    <div class="ui vertically padded page grid">
                        <div class="ui two column centered row">
                            <div class="column">
                                <form id="formContato" class="ui form" action="index.php" method="post" enctype="multipart/form-data"">
                                    <input type="hidden" id="hdnIdAnuncio" name="hdnIdAnuncio" value= "<?php echo $anuncio->getId() ?> "/>
                                    <input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" value= "<?php echo $usuario->getId() ?>" />

                                    <div class="modal-body text-left col-xs-7">

                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Nome:</label>            
                                            <input type="text" class="form-control" id="txtNome">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">E-mail:</label>
                                            <input type="text" class="form-control" id="txtEmail" name="txtEmail">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Telefone:</label>
                                            <input type="text" class="form-control" id="txtTelefone" name="txtTelefone">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="control-label">Mensagem:</label>
                                            <textarea maxlength="200" class="form-control" id="txtMensagem"></textarea>
                                        </div>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>    
                                        <button type="submit" id="btnEnviarEmailAnuncio" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="column">
                                asdjaoidjioajsd
                            </div>
                        </div>

                    </div>
                </div> 
            </div>
            <div class="column"></div>
        </div>


    </div>
</div>



