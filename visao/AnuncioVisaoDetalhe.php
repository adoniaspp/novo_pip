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
                    </div>
                    <div class="eight wide column">
                        <div class="ui red dividing header">
                            <i class="announcement icon"></i>
                            <div class="content">
                                <?php echo $item['anuncio'][0]['tituloanuncio'] ?>
                            </div>
                        </div>
                        <div class="ui info message">
                            <p> <?php echo $item['anuncio'][0]['descricaoanuncio'] ?></p>
                        </div>
                        <div class="ui stackable two column grid">
                            <div class="  column">
                                <div class="ui segment">
                                    <div class="ui top left attached label">Top Left</div>
                                    <div class="ui top right attached label">Top Right</div>
                                    <div class="ui bottom left attached label">Bottom Left</div>
                                    <div class="ui bottom right attached label">Bottom Right</div>
                                </div>
                                <!--                                <table class="ui collapsing celled table">
                                                                    <thead>
                                                                        <tr><th colspan="2">
                                                                                Detalhes
                                                                            </th>
                                                                        </tr></thead><tbody>
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="announcement icon"></i> Finalidade
                                                                            </td>
                                
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['finalidade'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Tipo
                                                                            </td>
                                
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['descricao'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Condição
                                                                            </td>
                                
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['condicao'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Valor
                                                                            </td>
                                
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['valormin'] ?></td>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Quartos
                                                                            </td>
                                
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['quarto'] ?></td>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Banheiros
                                                                            </td>
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['banheiro'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Área
                                                                            </td>
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['area'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Suítes
                                                                            </td>
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['suite'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="collapsing">
                                                                                <i class="folder icon"></i> Garagem
                                                                            </td>
                                                                            <td class="collapsing"><?php echo $item['anuncio'][0]['garagem'] ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>-->
                            </div>

<!--                            <div class="eight wide column"> 
                                <table class="ui collapsing celled table">
                                    <thead>
                                        <tr><th colspan="2">
                                                Diferenciais
                                            </th>
                                        </tr></thead><tbody>
                                        <tr>
                                            <td class="collapsing">
                                                <i class="folder icon"></i> Academia
                                            </td>

                                            <td class="collapsing">ok</td>
                                        </tr>
                                        <tr>
                                            <td class="collapsing">
                                                <i class="folder icon"></i> Área de Serviço
                                            </td>

                                            <td class="collapsing">ok</td>
                                        </tr>
                                        <tr>
                                            <td class="collapsing">
                                                <i class="folder icon"></i> Dep. de Empregada
                                            </td>

                                            <td class="collapsing">ok</td>
                                        </tr>
                                        <tr>
                                            <td class="collapsing">
                                                <i class="folder icon"></i> Elevador
                                            </td>

                                            <td class="collapsing">ok</td>
                                        </tr>
                                        <tr>
                                            <td class="collapsing">
                                                <i class="folder icon"></i> Gabinete
                                            </td>

                                            <td class="collapsing">ok</td>
                                        </tr>
                                        <tr>
                                            <td class="collapsing">
                                                <i class="folder icon"></i> Piscina
                                            </td>

                                            <td class="collapsing">ok</td>
                                        </tr>
                                        <tr>
                                            <td class="collapsing">
                                                <i class="folder icon"></i> Quadra
                                            </td>

                                            <td class="collapsing">ok</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>-->
                        </div>
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



