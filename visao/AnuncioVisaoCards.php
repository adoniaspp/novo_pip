<?php
$item = $this->getItem();

if (count($item['anuncio']) > 0) {
    ?>

            <?php
            for ($crtl = 0; $crtl < count($item['anuncio']); $crtl++) {
//                        echo '<pre>';
//                        print_r($item['anuncio'][$crtl]['idanuncioformatado']);
//                        echo '</pre>';
                ?> 
                <div data-valor="<?php echo $item['anuncio'][$crtl]['valormin'] ?>" class="card list-item" style="width: 263px; border-radius: 2.285714rem; box-shadow: 0 1px 3px 0 #D4D4DD,0 0 0 1px #000000" id="cartao<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>" data-cadastro="<?php echo $item['anuncio'][$crtl]['datahoracadastro'] ?>">                            
                    <!--                            <div class="content">
                    <?php
                    if ($item['anuncio'][$crtl]['finalidade'] == "Venda") {
                        echo "<div class='ui blue ribbon label'> Venda </div>";
                    } else {
                        echo "<div class='ui green ribbon label'> Aluguel </div>";
                    }
                    ?>            
                                                    
                    <?php
                    if ($item['anuncio'][$crtl]['tipo'] == "prediocomercial") {
                        echo "Prédio Comercial";
                    } else if
                    ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                        echo "Apartamento na Planta";
                    } else if
                    ($item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                        echo "Sala Comercial";
                    } else
                        echo ucfirst($item['anuncio'][$crtl]['tipo'])
                        ?>                                           
                                                            </b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>-->

                    <div class="content">
                        <?php
                        if ($item['anuncio'][$crtl]['finalidade'] == "Venda") {
                            echo "<div class='ui blue ribbon label'> Venda </div>";
                        } else {
                            echo "<div class='ui green ribbon label'> Aluguel </div>";
                        }
                        ?> 
                        <!--                                <div class="left floated header">Venda</div>-->
                        <div class="right floated meta">
                            <a href="http://www.facebook.com/sharer.php?u=http://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank"><i class="large blue facebook square icon"></i></a>
                            <a href="https://twitter.com/intent/tweet?text=Anúncio%20Compartilhado%20via%20PIP-OnLine%20http%3A%2F%2Fwww.pipbeta.com.br%2F<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank"><i class="large blue twitter icon"></i></a>
                            <a href="https://plus.google.com/share?url=http://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank"><i class="large red google plus circle icon"></i></a>
                            <a class="compartilhar-whatsapp" href='whatsapp://send?text=http://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>'><i class="large green whatsapp icon"></i></a>
                            <!--                                        <div class="ui primary button" id="copiarBotao" onclick="copiar()">Copiar Link Anúncio</div>-->
                        </div>                                
                    </div>
                    <!--                             <div class="ui divider"></div>-->
                    <div class="ui grid">
                        <div class="ui centered row">
                            <h4>
                                <?php
                                if ($item['anuncio'][$crtl]['tipo'] == "prediocomercial") {
                                    echo "Prédio Comercial";
                                } else if
                                ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                    echo "Apartamento na Planta";
                                } else if
                                ($item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                                    echo "Sala Comercial";
                                } else
                                    echo ucfirst($item['anuncio'][$crtl]['tipo'])
                                    ?>                                           
                            </h4>
                        </div>
                    </div>


                    <div class="image" style=" text-align: center;
                         margin: 0px auto;
                         max-height: 200px !important;">

                        <?php
                        if ($item['anuncio'][$crtl]['imagem']) {
                            foreach ($item['anuncio'][$crtl]['imagem'] as $imagem) {
                                if ($imagem['destaque'] == 'SIM') {
                                    ?>
                                    <img style="display: block; margin-left: auto; margin-right: auto; width: auto; max-height: 140px; overflow: scroll;position: relative; max-width: 165px" src="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>">
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                        <?php }
                        ?>
                    </div>

                    <div class="content">
                        <div class="ui segment">    
                            <div class="ui three column center aligned grid">                                       
                                <div class="column">
                                    <img class="ui center image dimmable" src="../assets/imagens/icones/iconeQuartoPequeno.jpg">&nbsp;
                                    <div style="font-size: 12px">  
                                        <?php
                                        if ($item['anuncio'][$crtl]['tipo'] == "casa" || $item['anuncio'][$crtl]['tipo'] == "apartamento") {
                                            echo $item['anuncio'][$crtl]['quarto'];
                                        } else if ($item['anuncio'][$crtl]['tipo'] == "salacomercial" || $item['anuncio'][$crtl]['tipo'] == "prediocomercial" || $item['anuncio'][$crtl]['tipo'] == "terreno") {
                                            echo "&nbsp; - ";
                                        } else if ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                            echo maximoMinimo($item['anuncio'][$crtl], 'quarto');
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="column">
                                    <img class="ui left image" src="../assets/imagens/icones/iconeBanheiroPequeno.jpg">&nbsp;
                                    <div style="font-size: 12px"><?php
                                        if ($item['anuncio'][$crtl]['tipo'] == "casa" || $item['anuncio'][$crtl]['tipo'] == "apartamento" || $item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                                            echo $item['anuncio'][$crtl]['banheiro'];
                                        } else if ($item['anuncio'][$crtl]['tipo'] == "salacomercial" || $item['anuncio'][$crtl]['tipo'] == "prediocomercial" || $item['anuncio'][$crtl]['tipo'] == "terreno") {
                                            echo "&nbsp; - ";
                                        } else if ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                            echo maximoMinimo($item['anuncio'][$crtl], 'banheiro');
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="column">
                                    <img class="ui left image " src="../assets/imagens/icones/iconeGaragemPequeno.jpg">&nbsp;
                                    <div style="font-size: 12px"><?php
                                        if ($item['anuncio'][$crtl]['tipo'] == "casa" || $item['anuncio'][$crtl]['tipo'] == "apartamento" || $item['anuncio'][$crtl]['tipo'] == "salacomercial") {
                                            echo $item['anuncio'][$crtl]['garagem'];
                                        } else if ($item['anuncio'][$crtl]['tipo'] == "salacomercial" || $item['anuncio'][$crtl]['tipo'] == "prediocomercial" || $item['anuncio'][$crtl]['tipo'] == "terreno") {
                                            echo "&nbsp; - ";
                                        } else if ($item['anuncio'][$crtl]['tipo'] == "apartamentoplanta") {
                                            echo maximoMinimo($item['anuncio'][$crtl], 'garagem');
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!--                                    <div class="ui divider"></div>-->

                        <!--                                </div>-->
                        <?php if ($item['anuncio'][$crtl]['tipo'] !== "apartamentoplanta") { ?>
                            <div class="left floated header" id="spanValor<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">       
                                <?php echo ($item['anuncio'][$crtl]['novovalor'] != "") ? $item['anuncio'][$crtl]['novovalor'] : $item['anuncio'][$crtl]['valormin']; ?>                                         
                            </div>
                            <?php
                        } else {

                            if ($item['anuncio'][$crtl]['valormin'] != 0) {
                                ?>

                                A partir de  <br>
                                <span class="left floated header" id="spanValor<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>">     
                                    <?php
                                    echo $item['anuncio'][$crtl]['valormin'];
                                } if ($item['anuncio'][$crtl]['valormin'] == 0) {
                                    echo "Valor não informado";
                                }
                            }
                            ?>
                        </span>
                        <div class="right floated"> <h4><?php echo $item['anuncio'][$crtl]['bairro'] ?> </h4></div>
                        <div class="description"> 
                            <!--                                    <br />-->
                            <span hidden="true" class="data" id="spanData<?php echo $item['anuncio'][$crtl]['idanuncio'] ?>"> 
                                <?php echo $item['anuncio'][$crtl]['datahoracadastro']; ?> </span>
                            <!-- CASO SEJA UM APARTAMENTO NA PLANTA, NÃO EXIBIR O VALOR-->

                            <!--<br />
                            Cod. <?php $item['anuncio'][$crtl]['idanuncioformatado'] ?> -->
                            <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" />
                            <input type="hidden" id="hiddenAnuncioFormatadaoCopiar" value="<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" />


                        </div>
                        <br />
                        <div class="ui one column center aligned grid">
                            <div class="column">
                                <a class='ui twitter button' href="<?php echo PIPURL; ?><?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" target="_blank">+ Detalhes</a>
                            </div>
                        </div>       
                    </div>
                    <div class="extra content">      
                        <div class="ui checkbox">
                            <input type="checkbox" name="selecionarAnuncio[]" id="selecionarAnuncio_<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>" value="<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>">
                            <label id="idsAnuncios">Selecionar</label>
                        </div>
                        <span class="right floated">
                            <?php echo FuncoesAuxiliares::tempo_corrido($item['anuncio'][$crtl]['datahoracadastro']) ?> <?php ?>
                        </span>
                    </div> 
                </div> 
            <?php }
            ?>                    

    <?php
}
?>

