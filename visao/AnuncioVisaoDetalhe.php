<!-- fotorama.css & fotorama.js. -->
<link  href="assets/libs/fotorama/fotorama.css" rel="stylesheet"> 
<script src="assets/libs/fotorama/fotorama.js"></script> 

<?php
$item = $this->getItem();
//print_r($item['anuncio'][0]);
//die();
?>
<div class="container">

    <div class="ui one column centered page grid">
        <div class="column">
            <div class="ui segment">
                <a class="ui blue ribbon label">Detalhes</a>
                <div class="ui stackable two column padded grid">
                    <div class="eight wide column">  
                        <div class="ui blue dividing header">
                            <i class="file image outline icon"></i>
                            <div class="content">
                                Fotos
                            </div>
                        </div>
                        <div class="fotorama" data-nav="thumbs" data-fit="cover" data-width="700" data-ratio="700/467" data-max-width="100%">
                            <?php //foreach ($imagens as $imagem) { ?>
                            <a href="<?php echo "http://localhost/pip/fotos/5a04mq12btaqveua2pr7pai904/amostra04.jpg" ?>" data-caption="<?php echo "Casa" ?>" data-thumb="<?php echo "http://localhost/pip/fotos/5a04mq12btaqveua2pr7pai904/thumbnail/amostra04.jpg" ?>"></a>
                            <a href="<?php echo "http://localhost/pip/fotos/5a04mq12btaqveua2pr7pai904/amostra04.jpg" ?>" data-caption="<?php echo "Casa" ?>" data-thumb="<?php echo "http://localhost/pip/fotos/5a04mq12btaqveua2pr7pai904/thumbnail/amostra04.jpg" ?>"></a>
                            <?php //} ?>
                        </div>
                        <div class="ui info message">
                            <p> <?php echo $item['anuncio'][0]['descricaoanuncio'] ?></p>
                        </div>
                    </div>
                    <div class="eight wide column">
                        <div class="ui red dividing header">
                            <i class="file image outline icon"></i>
                            <div class="content">
                                <?php echo $item['anuncio'][0]['tituloanuncio'] ?>
                            </div>
                        </div>
                        <!--                        <div class="ui info message">
                                                    <p> <?php echo $item['anuncio'][0]['descricaoanuncio'] ?></p>
                                                </div>-->
<!--                        <div class="ui stackable two column grid">
                            <div class="column">-->
                                <div class="ui stackable two column grid">
                                    <div class="column">
                                        <div class="ui raised segment">
                                            <a class="ui ribbon label">Detalhes</a>
                                            <div class="ui celled list">                                                
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/helen.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Finalidade</div>
                                                        <?php echo $item['anuncio'][0]['finalidade'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Tipo do Imóvel</div>
                                                        <?php echo $item['anuncio'][0]['descricao'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Condição</div>
                                                        <?php echo $item['anuncio'][0]['condicao'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Valor</div>
                                                        <?php echo $item['anuncio'][0]['valormin'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Quartos</div>
                                                        <?php echo $item['anuncio'][0]['quarto'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Banheiros</div>
                                                        <?php echo $item['anuncio'][0]['banheiro'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Área</div>
                                                        <?php echo $item['anuncio'][0]['area'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Suítes</div>
                                                        <?php echo $item['anuncio'][0]['suite'] ?>
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Garagem</div>
                                                        <?php echo $item['anuncio'][0]['garagem'] ?>
                                                    </div>
                                                </div>
                                            </div>           
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="ui segment">
                                            <a class="ui right ribbon label">Diferenciais</a>
                                            <div class="ui celled list">                                                
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/helen.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Academia</div>
                                                        Sim
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Área de Serviço</div>
                                                        Sim
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Dependência de Empregada</div>
                                                        Sim
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Elevador</div>
                                                        Sim
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Gabinete</div>
                                                        Sim
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Piscina</div>
                                                        Sim
                                                    </div>
                                                </div>
                                                <div class="item">
<!--                                                    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">-->
                                                    <div class="content">
                                                        <div class="header">Quadra</div>
                                                        Sim
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                 
<!--                            </div>
                        </div>-->
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
                            <div class="ui small images">
                                <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                                <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                                <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                                <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                            </div>
                        </div>
                        <div class="column">
                            asdjaoidjioajsd
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
                            sdjaoidjioasjdoa
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



