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

</script>


<?php
include_once "visao/modulo/menuBusca.php";
?>


<?php
$item = $this->getItem();
if ($item) {
    $anuncios = $item;
    ?>
<div class="ui hidden divider"></div>
<div class="ui grid container">
    <h2 class="ui header">Sugestões baseadas nos anúncios que você viu</h2>    
</div>
    <div class="ui middle aligned one column grid container swiper-container">
        <div class="ui ten wide column">
        </div>
        <div class="swiper-wrapper">

            <div class="ui stackable special cards "> 
    <?php
    for ($crtl = 0; $crtl <= count($anuncios); $crtl++) {
        for ($k = 0; $k <= count($anuncios[$crtl]['anuncio']); $k++) {
            if ($anuncios[$crtl]['anuncio'][$k]) {
                $anuncio = $anuncios[$crtl]['anuncio'][$k];
                ?>
                            <script>
                                formatarValor("<?php echo $anuncio['idanuncio'] ?>");
                            </script>  
                            <div class="card" style="width: 263px; border-radius: 2.285714rem; box-shadow: 0 1px 3px 0 #D4D4DD,0 0 0 1px #000000" id="cartao<?php echo $anuncio['idanuncio'] ?>">
                                <div class="content">
                <?php
                if ($anuncio['finalidade'] == "Venda") {
                    echo "<div class='ui blue ribbon label'> Venda </div>";
                } else {
                    echo "<div class='ui green ribbon label'> Aluguel </div>";
                }
                ?>                                                                       
                                </div>

                                <div class="dimmable image" style=" text-align: center;
                                     margin: 0px auto;
                                     max-height: 200px !important;">
                                    <div class="ui inverted dimmer">
                                        <div class="content">
                                            <div class="center">
                                                <div class="ui blue basic button"> Detalhes </div>                                          
                                                <input type="hidden" id="anuncio<?php echo $anuncio['id'] ?>"
                                                       value="<?php echo $anuncio['idanuncio'] ?>"/>
                                                <input type="hidden" id="anuncio<?php echo $anuncio['tipo'] ?>"
                                                       value="<?php echo $anuncio['tipo'] ?>"/>                                                   
                                            </div>
                                        </div>
                                    </div>
                <?php
                if ($anuncio['imagem']) {
                    foreach ($anuncio['imagem'] as $imagem) {
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
                                </div>

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
        <div class="ui column" ></div>
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
    <div class="column"><i class="teal big help icon"></i>COMO ANUNCIAR</div>
</div>

<div class="ui center aligned equal width grid">
    <div class="column"><i class="teal big add user icon"></i>1 - FAÇA SEU CADASTRO
        <br>
        Cadastre seus dados (Nome, Endereço, Tipo de Pessoa, Telefone, Email, etc) e escolha um login
        para ser sua identificação no PIP On-Line (Ex: www.piponline.com.br/joaosilva1980)
    </div>
    <div class="column"><i class="teal big edit icon"></i>2 - CADASTRE SEU IMÓVEL (Casa, Apartamentos, etc.)
        <br>
        Cadastre as características do imóvel (quartos, banheiros, garagens, área, etc).
    </div>
    <div class="column"><i class="teal big add to cart icon"></i>3 - COMPRE O ANUNCIO
        <br>
        Após cadastrar o imóvel, compre o anuncio para divulgar seu produto, escolhendo o melhor
        para sua necessidade (1 mês de divulgação no site, 2 meses, etc.)
    </div>
</div>  

<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<div class="ui center aligned grid">
    <div class="column"><i class="teal big list icon"></i>VANTAGENS DO PIP-ONLINE</div>
</div>

<div class="ui left aligned equal width grid">
    <div class="column">
        <div class="ui bulleted list">
            <div class="item">Cadastre vários imóveis e escolha quais anunciar </div>
            <div class="item">Enviar anuncios por e-mail</div>
            <div class="item">Envie dúvidas sobre os anuncios</div>
            <div class="item">É vendedor? você tem sua área específica, bastando digitar seu login na barra de endereços</div>
        </div>
    </div>
    <div class="column">
        <div class="ui bulleted list">
            <div class="item">Busca completa, inclusive na área do vendedor</div>
            <div class="item">Reative anuncios expirados, sem necessidade de recadastrar o imóvel</div>
            <div class="item">Compatível com dispositivos móveis (celular e tablet)</div>
            <div class="item">Quer saber mais detalhes sobre mais vantagens? clique AQUI</div>
        </div>  
    </div>
</div>

<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>





