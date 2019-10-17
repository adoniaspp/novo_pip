<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/swiper/swiper.min.css">
<script src="assets/libs/swiper/swiper.min.js"></script>


<script>

    inicio();
    ordemInicio();
    buscarAnuncio();
    carregarCarrosselPreferencias();
    carregarDiferencial();
    ordenarAnuncio();

    $(document).ready(function () {

        if(testMobile())
        {
            $('#menuMobile').html(
                '<a class="icon item" id="btnMenuMobile">\n' +
                '        <i class="content large icon">\n' +
                '        </i></a>\n' +
                '    <a class="item" id="btnPesquisaMobile">\n' +
                '        <i class="search icon">\n' +
                '        </i>\n' +
                '    Buscar Anúncio</a>\n' +
                '    <a class="item" id="btnOrdencacaoMobile">\n' +
                '        <i class="sort icon">\n' +
                '        </i>\n' +
                '    Ordenar</a>'
            )
        }

        $("#btnPesquisaMobile").on('click', function () {
            $('.overlay.fullscreen.modal')
                .modal('show')
            ;
        })

        $("#btnOrdencacaoMobile").on('click', function () {
            $("#modalOrdenacao")
                .modal('show')
            ;
        })

        $("#btnMenuMobile").on('click', function () {
            $('.ui.sidebar')
                .sidebar('toggle');
        })


    });


</script>


<?php
$menuCorretor = true;
//include_once "visao/modulo/menuBusca.php";
?>


<?php
$item = $this->getItem();
if ($item) {
    $anuncios = $item;
    ?>
    <!--<div class="ui hidden divider"></div>-->
    <div class="ui grid container">
        <h2 class="ui header">Sugestões baseadas nos anúncios que você viu</h2>
    </div>
    <div class="ui middle aligned one column grid container swiper-container">
        <div class="ui ten wide column">
        </div>
        <div class="swiper-wrapper">

            <div class="ui stackable cards ">
                <?php
                for ($crtl = 0; $crtl <= count($anuncios); $crtl++) {
                    for ($k = 0; $k <= count($anuncios[$crtl]['anuncio']); $k++) {
                        if ($anuncios[$crtl]['anuncio'][$k]) {
                            $anuncio = $anuncios[$crtl]['anuncio'][$k];
                            ?>
                            <script>
                                formatarValor("<?php echo $anuncio['idanuncio'] ?>");
                            </script>
                            <div class="card"
                                 style="width: 263px; border-radius: 2.285714rem; box-shadow: 0 1px 3px 0 #D4D4DD,0 0 0 1px #000000"
                                 id="cartao<?php echo $anuncio['idanuncio'] ?>">


                                <div class="content">
                                    <?php
                                    if ($anuncio['finalidade'] == "Venda") {
                                        echo "<div class='ui blue ribbon label'> Venda </div>";
                                    } else {
                                        echo "<div class='ui green ribbon label'> Aluguel </div>";
                                    }
                                    ?>
                                    <!--                                <div class="left floated header">Venda</div>-->
                                    <div class="right floated meta">
                                        <a href="https://www.facebook.com/sharer.php?u=https://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>"
                                           target="_blank"><i class="large blue facebook square icon"></i></a>
                                        <a href="https://twitter.com/intent/tweet?text=Anúncio%20Compartilhado%20via%20PIP-OnLine%20https%3A%2F%2Fwww.pipbeta.com.br%2F<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>"
                                           target="_blank"><i class="large blue twitter icon"></i></a>
                                        <a href="https://plus.google.com/share?url=https://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>"
                                           target="_blank"><i class="large red google plus circle icon"></i></a>
                                        <a class="compartilhar-whatsapp"
                                           href='whatsapp://send?text=https://www.pipbeta.com.br/<?php echo $item['anuncio'][$crtl]['idanuncioformatado'] ?>'><i
                                                    class="large green whatsapp icon"></i></a>
                                        <!--                                        <div class="ui primary button" id="copiarBotao" onclick="copiar()">Copiar Link Anúncio</div>-->
                                    </div>
                                </div>
                                <!--                             <div class="ui divider"></div>-->
                                <div class="ui grid">
                                    <div class="ui centered row">
                                        <h4>
                                            <?php
                                            if ($anuncio['tipo'] == "prediocomercial") {
                                                echo "Prédio Comercial";
                                            } else if
                                            ($anuncio['tipo'] == "apartamentoplanta") {
                                                echo "Apartamento na Planta";
                                            } else if
                                            ($anuncio['tipo'] == "salacomercial") {
                                                echo "Sala Comercial";
                                            } else
                                                echo ucfirst($anuncio['tipo'])
                                            ?>
                                        </h4>
                                    </div>
                                </div>

                                <!--                                Imagem-->
                                <div class="image" style=" text-align: center;
                                     margin: 0px auto;
                                     max-height: 200px !important;">
                                    <!--                                <div class="ui inverted dimmer">-->
                                    <div class="content">
                                        <div class="center">
                                            <!--                                            <div class="ui blue basic button"> Detalhes </div>                                          -->
                                            <input type="hidden" id="anuncio<?php echo $anuncio['id'] ?>"
                                                   value="<?php echo $anuncio['idanuncio'] ?>"/>
                                            <input type="hidden" id="anuncio<?php echo $anuncio['tipo'] ?>"
                                                   value="<?php echo $anuncio['tipo'] ?>"/>
                                        </div>
                                        <!--                                    </div>-->
                                    </div>
                                    <?php
                                    if ($anuncio['imagem']) {
                                        foreach ($anuncio['imagem'] as $imagem) {
                                            if ($imagem['destaque'] == 'SIM') {
                                                ?>
                                                <img style="display: block; margin-left: auto; margin-right: auto; width: auto; max-height: 140px; overflow: scroll;position: relative; max-width: 165px"
                                                     src="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>">
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
                                        <div class="ui stackable three column centered grid">
                                            <div class="ui three wide column">
                                                <img class="ui center image dimmable"
                                                     src="../assets/imagens/icones/iconeQuartoPequeno.jpg">&nbsp;
                                                <div style="font-size: 12px">
                                                    <?php
                                                    if ($anuncio['tipo'] == "casa" || $$anuncio['tipo'] == "apartamento") {
                                                        echo $anuncio['quarto'];
                                                    } else if ($anuncio['tipo'] == "salacomercial" || $anuncio['tipo'] == "prediocomercial" || $anuncio['tipo'] == "terreno") {
                                                        echo "&nbsp; - ";
                                                    } else if ($anuncio['tipo'] == "apartamentoplanta") {
                                                        echo maximoMinimo($anuncio, 'quarto');
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="ui three wide column">
                                                <img class="ui left image"
                                                     src="../assets/imagens/icones/iconeBanheiroPequeno.jpg">&nbsp;
                                                <div style="font-size: 12px"><?php
                                                    if ($anuncio['tipo'] == "casa" || $anuncio['tipo'] == "apartamento" || $anuncio['tipo'] == "salacomercial") {
                                                        echo $anuncio['banheiro'];
                                                    } else if ($anuncio['tipo'] == "salacomercial" || $anuncio['tipo'] == "prediocomercial" || $anuncio['tipo'] == "terreno") {
                                                        echo "&nbsp; - ";
                                                    } else if ($anuncio['tipo'] == "apartamentoplanta") {
                                                        echo maximoMinimo($anuncio, 'banheiro');
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="ui three wide column">
                                                <img class="ui left image "
                                                     src="../assets/imagens/icones/iconeGaragemPequeno.jpg">&nbsp;
                                                <div style="font-size: 12px"><?php
                                                    if ($anuncio['tipo'] == "casa" || $anuncio['tipo'] == "apartamento" || $anuncio['tipo'] == "salacomercial") {
                                                        echo $anuncio['garagem'];
                                                    } else if ($anuncio['tipo'] == "salacomercial" || $anuncio['tipo'] == "prediocomercial" || $$anuncio['tipo'] == "terreno") {
                                                        echo "&nbsp; - ";
                                                    } else if ($anuncio['tipo'] == "apartamentoplanta") {
                                                        echo maximoMinimo($anuncio, 'garagem');
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="ui divider"></div>-->

                                    <!--                                </div>-->
                                    <?php if ($anuncio['tipo'] !== "apartamentoplanta") { ?>
                                        <div class="left floated header"
                                             id="spanValor<?php echo $anuncio['idanuncio'] ?>">
                                            <?php echo ($anuncio['novovalor'] != "") ? $anuncio['novovalor'] : $anuncio['valormin']; ?>
                                        </div>
                                        <?php
                                    } else {

                                    if ($anuncio['valormin'] != 0) {
                                    ?>

                                    A partir de <br>
                                    <span class="left floated header" id="spanValor<?php echo $anuncio['idanuncio'] ?>">
                                                <?php
                                                echo $anuncio['valormin'];
                                                }
                                                if ($anuncio['valormin'] == 0) {
                                                    echo "Valor não informado";
                                                }
                                                }
                                                ?>
                                    </span>
                                    <div class="right floated"><h4> <?php echo $anuncio['bairro'] ?> </h4></div>
                                    <div class="description">
                                        <!--                                    <br />-->
                                        <span hidden="true" class="data"
                                              id="spanData<?php echo $anuncio['idanuncio'] ?>">
                                            <?php echo $anuncio['datahoracadastro']; ?> </span>
                                        <!-- CASO SEJA UM APARTAMENTO NA PLANTA, NÃO EXIBIR O VALOR-->

                                        <!--<br />
                                        Cod. <?php $anuncio['idanuncioformatado'] ?> -->
                                        <input type="hidden" name="hdnCodAnuncioFormatado[]"
                                               value="<?php echo $anuncio['idanuncioformatado'] ?>"/>
                                        <input type="hidden" id="hiddenAnuncioFormatadaoCopiar"
                                               value="<?php echo $anuncio['idanuncioformatado'] ?>"/>


                                    </div>
                                    <br/>
                                    <div class="ui one column centered grid">
                                        <div class="column">
                                            <a class='ui twitter button'
                                               href="<?php echo PIPURL; ?><?php echo $anuncio['idanuncioformatado'] ?>"
                                               target="_blank">+ Detalhes</a>
                                        </div>
                                    </div>
                                </div>

                                <!--                                <div class="content">;
                                                                    <div class="header"><b>
                                <?php
                                $limite = 24;
                                $titulo = $anuncio['tituloanuncio'];
                                echo (strlen(trim($titulo)) >= $limite) ? trim(substr($titulo, 0, strrpos(substr($titulo, 0, $limite), " "))) . "..." : $titulo;
                                ?></b></div>
                                                                    <div class="description"> 
                                <?php
                                if ($anuncio['tipo'] == "prediocomercial") {
                                    echo "Prédio Comercial";
                                } else if
                                ($anuncio['tipo'] == "apartamentoplanta") {
                                    echo "Apartamento na Planta";
                                } else if
                                ($anuncio['tipo'] == "salacomercial") {
                                    echo "Sala Comercial";
                                } else
                                    echo ucfirst($anuncio['tipo'])
                                ?>
                                                                        <br />
                                                                        <span hidden="true" class="data" id="spanData<?php echo $anuncio['idanuncio'] ?>"> 
                                <?php echo $anuncio['datahoracadastro']; ?> </span>
                                                                        <span class="valor" id="spanValor<?php echo $anuncio['idanuncio'] ?>"> 
                                <?php echo ($anuncio['novovalor'] != "") ? $anuncio['novovalor'] : $anuncio['valormin']; ?> </span>
                                                                        <br />
                                                                        Cod. <?php echo $anuncio['idanuncioformatado'] ?>
                                                                        <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $anuncio['idanuncioformatado'] ?>" />
                                                                        <br />
                                                                        Data Cadastro: <?php echo date('d/m/Y', strtotime($anuncio['datahoracadastro'])) ?>
                                                                    </div>
                                                                </div>-->

                            </div>
                            <?php ?>

                            <?php
                        }
                    }
                }
                ?>

                <div class="swiper-pagination"></div>
            </div>

        </div>
        <div class="ui column"></div>
    </div>
    <div class="ui divider"></div>

    <?php
}
?>


<div class="ui hidden divider"></div>
<div class="ui grid container">
    <h2 class="ui header">Confira nossos anúncios</h2>
</div>


<div class="ui basic segment" id="divAnuncios"></div>

<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<div class="ui center aligned grid">
    <div class="column">
        <div class="ui pointing below large blue grey label">
            ANUNCIE EM 3 PASSOS
        </div>
    </div>
</div>

<div class="ui center aligned equal width stackable grid">
    <div class="column">
        <div class="ui large icon blue header">
            <a class="ui pointing below basic blue large label">1º Passo</a>
            <i class="ui add user icon"></i>
            <p>FAÇA SEU CADASTRO</p>

        </div>

    </div>

    <div class="column">
        <div class="ui large icon brown header">
            <a class="ui pointing below basic brown large label">2º Passo</a>
            <i class="ui home icon"></i>
            <p>CADASTRE SEU IMÓVEL</p>
        </div>
    </div>

    <div class="column">
        <div class="ui large icon green header">
            <a class="ui pointing below basic green large label">3º Passo</a>
            <i class="ui bullhorn icon"></i>
            <p>ANUNCIE</p>

        </div>
    </div>
</div>


    <div class="ui horizontal labeled icon bottom fixed fluid three item mini menu" id="menuMobile">

    </div>



<div class="ui modal" id="modalOrdenacao">
    <div class="content">
        <a id="menorValor"><h2 class="ui header">Maior Valor</h2></a>
        <div class="ui divider"></div>
        <h2 class="ui header">Menor Valor</h2>
        <div class="ui divider"></div>
        <h2 class="ui header">Mais Recente</h2>
        <div class="ui divider"></div>
        <h2 class="ui header">Mais Antigo</h2>
    </div>
</div>


<div class="ui overlay fullscreen modal" id="modalBuscaAnuncio">
    <i class="close icon"></i>
    <div class="header">
        Busca de Anúcios
    </div>
    <div class="scrolling content">
        <div class="ui large form">
            <div class="ui stackable six column grid">
                <div class="column"></div>
                <div class="column">
                    <select name="sltTipoImovel" id="sltTipoImovel">
                        <option value=""> Todos os tipos</option>
                        <option value="apartamento"> Apartamento</option>
                        <option value="apartamentoplanta"> Apartamento na Planta</option>
                        <option value="casa"> Casa</option>
                        <option value="prediocomercial"> Prédio Comercial</option>
                        <option value="salacomercial"> Sala Comercial</option>
                        <option value="terreno"> Terreno</option>
                    </select>
                </div>
                <div class="column">
                    <select name="sltFinalidade" id="sltFinalidade">
                        <option value=""> Todas as finalidades</option>
                        <option value="aluguel">Aluguel</option>
                        <option value="venda">Venda</option>
                    </select>
                </div>
                <div class="column">
                    <select name="sltCidade" id="sltCidade">
                        <option value="">Todas as cidades</option>
                        <option value="1">Belém</option>
                        <option value="2">Ananindeua</option>
                        <option value="3">Marituba</option>
                        <option value="4">Benevides</option>
                        <option value="6">Castanhal</option>
                    </select>
                </div>

                <div id="sltBairro">
                </div>

                <!--<div class="column" id="divCondicao">
                    <select name="sltCidade" id="sltCidade">
                        <option value="">Todas</option>
                        <option value="novo">Novo</option>
                        <option value="usado">Usado</option>
                    </select>

                </div>-->

                          <!--<div class="column" id="divGaragem">
                                <div class="ui left floated compact segment">
                                    <div class="ui fitted toggle checkbox">
                                        <input type="checkbox" name="checkgaragem" id="checkgaragem">

                                    </div>
                                    <label>Garagem</label>
                                </div>
                            </div>-->

            </div>

            <div class="ui stackable four column centered grid">
                <div class="column">
                    <div class="ui twitter icon fluid button" id="btnBuscarAnuncioBasico">
                        <i class="search icon"></i>
                        Procurar
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--<div class="actions">
       <div class="ui black deny button">
            Nope
        </div>
        <div class="ui positive right labeled icon button">
            Yep, that's me
            <i class="checkmark icon"></i>
        </div>
    </div>-->
</div>
<!--<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>
<div class="ui center aligned grid">

    <div class="column">
        <div class="ui pointing below large blue grey label">
            PIP EM NÚMEROS
        </div>
              <span class="ui large block header">ANUNCIE EM 3 PASSOS</span>-->
 <!--   </div>
</div>
<div class="ui centered stackable grid">
    <div class="ui large statistic">
        <div class="value">
            22
        </div>
        <div class="label">
            Faves
        </div>
    </div>
    <div class="ui large statistic">
        <div class="value">
            31,200
        </div>
        <div class="label">
            Views
        </div>
    </div>
    <div class="ui large statistic">
        <div class="value">
            22
        </div>
        <div class="label">
            Members
        </div>
    </div>
</div>-->
<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<div class="ui center aligned grid">
    <div class="column"><i class="teal big list icon"></i>VANTAGENS DO PIP-ONLINE</div>
</div>

<div class="ui center aligned equal width stackable grid">
<div class="ui left aligned equal width grid">
    <div class="column">
        <!--<div class="ui bulleted list">-->
            <div class="item"><i class="red map marker icon"></i>Cadastre vários imóveis e escolha quais anunciar</div>
            <div class="item"><i class="red map marker icon"></i>Enviar anuncios por e-mail</div>
            <div class="item"><i class="red map marker icon"></i>Envie dúvidas sobre os anúncios</div>
            <div class="item"><i class="red map marker icon"></i>É vendedor? você tem sua área específica, bastando digitar seu login na barra de
                endereços
            <!--</div>-->
        </div>
    </div>
    <div class="column">
        <!--<div class="ui bulleted list">-->
            <div class="item"><i class="red map marker icon"></i>Busca completa, inclusive na área do vendedor</div>
            <div class="item"><i class="red map marker icon"></i>Reative anúncios expirados, sem necessidade de recadastrar o imóvel</div>
            <div class="item"><i class="red map marker icon"></i>Compatível com dispositivos móveis (celular e tablet)</div>
            <div class="item"><i class="red map marker icon"></i>Quer saber mais detalhes sobre mais vantagens? clique AQUI</div>
        <!--</div>-->
    </div>
</div>
</div>
    
<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<script async defer src="<?php echo GOOGLEMAPSURL; ?>"></script>





