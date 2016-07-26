<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/echarts/build/dist/echarts-all.js"></script>
<script src="assets/js/grafico.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {

        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "order": [2, "desc"],
            "stateSave": true,
            "searching": false
        });

    })
</script>

<style>
    .ui.menu .item:before {
        width: 4px !important;
    }
</style>
<?php
$item = $this->getItem();

$usuario = $item["usuario"];
$imoveis = $item["imovelCadastrado"];
$mensagens = $item["mensagem"];

$totalAnuncios = 0; //total de anuncios cadastrados

foreach ($imoveis as $qtdAnuncios) {
    if ($qtdAnuncios->getAnuncio()) {
        $totalAnuncios = $totalAnuncios + 1;
    }
}
?>

<script>
    $(document).ready(function () {

        $("#divMaiorRetornoOperacao").hide();

        if ("<?php echo $_SESSION["confirmarOperacao"] ?>" != null) {

            if ("<?php echo $_SESSION["confirmarOperacao"] ?>" == "sucesso") {

                $("#divMaiorRetornoOperacao").show();

                $("#divRetornoOperacao").attr("class", "ui positive message");

                $("#divRetornoOperacao").html("<i class='big green check circle outline icon'></i>Operação Realizada Com Sucesso");

            }

            if ("<?php echo $_SESSION["confirmarOperacao"] ?>" == "erroGenerico") {

                $("#divMaiorRetornoOperacao").show();

                $("#divRetornoOperacao").attr("class", "ui negative message");

                $("#divRetornoOperacao").html("<i class='big red remove circle outline icon'>\n\
                            </i>Erro ao processar requisição. Tente novamente em alguns minutos - 000");

            }

            if ("<?php echo $_SESSION["confirmarOperacao"] ?>" == "erroToken") {

                $("#divMaiorRetornoOperacao").show();

                $("#divRetornoOperacao").attr("class", "ui negative message");

                $("#divRetornoOperacao").html("<i class='big red remove circle outline icon'>\n\
                            </i>Tempo limite para a operação expirou. Tente novamente.");

            }

<?php unset($_SESSION["confirmarOperacao"]) ?>

        }

    })
</script>

<div class="ui column doubling grid container" id="divMaiorRetornoOperacao">
    <div class="row">
        <div class="column">
            <div id="divRetornoOperacao" class=""></div>    
        </div>
    </div>
</div>

<!-- HTML -->
<div class="ui column doubling grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"><i class="block layout small icon"></i>Meu PIP</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>No Meu PIP, faça a administração de seus dados, imóveis, anúncios, mensagens e seus planos</p>
            </div>    
        </div>
    </div>
</div>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="user icon"></i>
            <div class="content">
                Meus Dados
                <div class="sub header">Gerencie sua conta no PIP</div>
            </div>
        </h2>
    </div>
    <div class="ui stackable blue inverted container menu">
        <a href="index.php?entidade=Usuario&acao=selecionar" class="item">            
            <i class="edit icon"></i> Atualizar Cadastro            
        </a>
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha" class="item"> 
            <i class="lock icon"></i> Trocar Senha 
        </a>
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarimagem" class="item"> 
            <i class="file image outline icon"></i>  Alterar <?php echo ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca"); ?>
        </a>
        <a href="index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $_SESSION["login"] ?>index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $_SESSION["login"] ?>" class="item"> 
            <i class="newspaper icon"></i> Visualizar Minha Página
        </a>
    </div>

    <?php
    if ($usuario[0]->getEndereco()->getNumero() != "" && $usuario[0]->getEndereco()->getComplemento() != "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro() . ", " . $usuario[0]->getEndereco()->getNumero() . ", " . $usuario[0]->getEndereco()->getComplemento();
    } elseif ($usuario[0]->getEndereco()->getNumero() != "" && $usuario[0]->getEndereco()->getComplemento() == "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro() . ", " . $usuario[0]->getEndereco()->getNumero();
    } elseif ($usuario[0]->getEndereco()->getNumero() == "" && $usuario[0]->getEndereco()->getComplemento() == "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro();
    } elseif ($usuario[0]->getEndereco()->getNumero() == "" && $usuario[0]->getEndereco()->getComplemento() != "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro() . ", " . $usuario[0]->getEndereco()->getComplemento();
    }
    ?>    
</div>

<div class="stackable two column ui grid container">
    <div class="column">
        <div class="ui segment">
            <a class="header">Usuário do PIP OnLine desde:</a>
            <div class="description"> <?php echo date('d/m/Y', strtotime($usuario[0]->getDataHoraCadastro())) ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment">
            <a class="header"><?php
                if ($usuario[0]->getTipoUsuario() == "pf") {
                    echo "Nome - Email:";
                } else
                    echo "Empresa - Email:"
                    ?></a>
            <div class="description"><?php echo $usuario[0]->getNome() . " - " . $usuario[0]->getEmail(); ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment"><a class="header">Endereço:</a>
            <div class="description"> <?php echo $endereco; ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment"><a class="header">Telefone(s):</a>
            <div class="description">
                <?php
                $quantidade = count($usuario[0]->getTelefone());
                if ($quantidade == 1) {
                    $array = array($usuario[0]->getTelefone());
                } else {
                    $array = $usuario[0]->getTelefone();
                }
                foreach ($array as $telefone) {
                    if ($telefone->getWhatsApp() == "SIM") {
                        $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero() . "  <i class='large green whatsapp icon'></i> ";
                    } else
                        $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero();
                }

                $fonesImplode = implode(" | ", $fones); //retirar a barra do último elemento

                echo $fonesImplode;
                ?>
            </div></div>
    </div>
</div>

<!-- IMOVEIS --> 
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <h3 class="ui dividing header"></h3>
        </div>
    </div>

    <div class="row">
        <h2 class="ui header">
            <i class="home icon"></i>
            <div class="content">
                Meus Imóveis
                <div class="sub header">Gerencie seus imóveis (casas, apartamentos, kit-net, salas comerciais, terrenos) </div>
            </div>
        </h2>
    </div>

    <div class="ui stackable green inverted container menu">
        <a href="index.php?entidade=Imovel&acao=form" class="item">            
            <i class="add icon"></i> Cadastrar Imóvel
        </a>

        <?php
        if ($item) {
            if ($item['imovel']) {
                ?>
                <a href="index.php?entidade=Imovel&acao=listarEditar" class="item"> 
                    <i class="edit icon"></i> Alterar Imóvel
                </a>
                <a href="index.php?entidade=Imovel&acao=listar" class="item"> 
                    <i class="list icon"></i> Meus Imóveis
                </a>
                <?php
            }
            ?>

            <?php
        }
        ?> 
    </div>
    <!--TABELAS IMOVEIS-->
    <?php
    if ($item) {
        if ($item['imovel']) {
            ?>

            <div class="row">
                <div class="ui horizontal segments">

                    <?php
                    $casaAnuncio = 0;
                    $casaAnuncioAluguel = 0;
                    $casaAnuncioVenda = 0;
                    $casa = 0;

                    $apAnuncio = 0;
                    $apAnuncioAluguel = 0;
                    $apAnuncioVenda = 0;
                    $ap = 0;

                    $apPlantaAnuncio = 0;
                    $apPlantaAnuncioAluguel = 0;
                    $apPlantaAnuncioVenda = 0;
                    $apPlanta = 0;

                    $salaAnuncio = 0;
                    $salaAnuncioAluguel = 0;
                    $salaAnuncioVenda = 0;
                    $sala = 0;

                    $predioAnuncio = 0;
                    $predioAnuncioAluguel = 0;
                    $predioAnuncioVenda = 0;
                    $predio = 0;

                    $terrenoAnuncio = 0;
                    $terrenoAnuncioAluguel = 0;
                    $terrenoAnuncioVenda = 0;
                    $terreno = 0;

                    $cadastrado = 0;

                    foreach ($imoveis as $imovel) {
                        switch ($imovel->getIdTipoImovel()) {
                            case 1:
                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado") {
                                    $casaAnuncio = $casaAnuncio + 1;
                                }

                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Aluguel") {
                                    $casaAnuncioAluguel = $casaAnuncioAluguel + 1;
                                } else if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Venda") {
                                    $casaAnuncioVenda = $casaAnuncioVenda + 1;
                                }

                                $casa = $casa + 1;
                                break;
                            case 2:
                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado") {
                                    $apPlantaAnuncio = $apPlantaAnuncio + 1;
                                }

                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Aluguel") {
                                    $apPlantaAnuncioAluguel = $apPlantaAnuncioAluguel + 1;
                                } else if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Venda") {
                                    $apPlantaAnuncioVenda = $apPlantaAnuncioVenda + 1;
                                }

                                $apPlanta = $apPlanta + 1;
                                break;
                            case 3:
                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado") {
                                    $apAnuncio = $apAnuncio + 1;
                                }

                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Aluguel") {
                                    $apAnuncioAluguel = $apAnuncioAluguel + 1;
                                } else if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Venda") {
                                    $apAnuncioVenda = $apAnuncioVenda + 1;
                                }
                                $ap = $ap + 1;

                                break;
                            case 4:
                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado") {
                                    $salaAnuncio = $salaAnuncio + 1;
                                }

                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Aluguel") {
                                    $salaAnuncioAluguel = $salaAnuncioAluguel + 1;
                                } else if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Venda") {
                                    $salaAnuncioVenda = $salaAnuncioVenda + 1;
                                }

                                $sala = $sala + 1;
                                break;
                            case 5:
                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado") {
                                    $predioAnuncio = $predioAnuncio + 1;
                                }

                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Aluguel") {
                                    $predioAnuncioAluguel = $predioAnuncioAluguel + 1;
                                } else if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Venda") {
                                    $predioAnuncioVenda = $predioAnuncioVenda + 1;
                                }

                                $predio = $predio + 1;
                                break;
                            case 6:
                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado") {
                                    $terrenoAnuncio = $terrenoAnuncio + 1;
                                }

                                if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Aluguel") {
                                    $terrenoAnuncioAluguel = $terrenoAnuncioAluguel + 1;
                                } else if (count($imovel->getAnuncio()) > 0 && $imovel->getAnuncio()->getStatus() == "cadastrado" && $imovel->getAnuncio()->getFinalidade() == "Venda") {
                                    $terrenoAnuncioVenda = $terrenoAnuncioVenda + 1;
                                }

                                $terreno = $terreno + 1;
                                break;
                        }
                    }
                    ?>

                    <table class="ui green celled fixed table">
                        <thead>
                            <tr>
                                <th colspan="6">Você possui 
                                    <?php
                                    if (count($imoveis) > 1) {
                                        echo count($imoveis) . " imóveis cadastrados";
                                    } else {
                                        echo " 1 imóvel cadastrado";
                                    }
                                    ?>
                                </th>
                            </tr>
                            <tr>
                                <th class="ui center aligned"><?php
                                    if ($casa > 1) {
                                        echo "Casas";
                                    } else
                                        echo "Casa";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($ap > 1) {
                                        echo "Apartamentos";
                                    } else
                                        echo "Apartamento";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($apPlanta > 1) {
                                        echo "Apartamentos na Planta";
                                    } else
                                        echo "Apartamento na Planta";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($sala > 1) {
                                        echo "Salas Comerciais";
                                    } else
                                        echo "Sala Comercial";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($predio > 1) {
                                        echo "Prédios Comerciais";
                                    } else
                                        echo "Prédio Comercial";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($terreno > 1) {
                                        echo "Terrenos";
                                    } else
                                        echo "Terreno";
                                    ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $casa; ?></td>
                                <td><?php echo $ap; ?></td>
                                <td><?php echo $apPlanta; ?></td>
                                <td><?php echo $sala; ?></td>
                                <td><?php echo $predio; ?></td>
                                <td><?php echo $terreno; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                graficoBarrasTotal('graficoImoveisEcharts', 'Número de Imóveis', '#21ba45', <?php echo $casa ?>, <?php echo $ap ?>, <?php echo $apPlanta ?>, <?php echo $sala ?>, <?php echo $predio ?>, <?php echo $terreno ?>);
            </script>

            <div class="row">
                <div class="column">
                    <div id="graficoImoveisEcharts" 
                         style="height:450px; max-width: 40%; min-width: 90%;width: 850px">
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="column">
                    <div id="area_grafico"></div>
                </div>
            </div>

            <?php
        }
    }
    ?>

    <div class="row">
        <div class="column">
            <h3 class="ui dividing header"></h3>
        </div>
    </div>
</div> 

<!--ANUNCIOS-->
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="announcement icon"></i>
            <div class="content">
                Meus Anúncios
                <div class="sub header">Gerencie seus anúncios. Você pode cadastar, visualizar, finalizar ou reativar anuncios, além de ler suas mensagens </div>
            </div>
        </h2>
    </div>
    <div class="row">
        <?php
        if ($item) {
            if ($item['imovel']) {
                ?>
                <div class="ui stackable brown inverted container menu">
                    <a href="index.php?entidade=Anuncio&acao=listarCadastrar" class="item">            
                        <i class="add icon"></i> Publicar Anúncio
                    </a>
                    <?php if ($item['anuncio']) { ?>
                        <a href="index.php?entidade=Anuncio&acao=listarReativarAluguel" class="item"> 
                            <i class="refresh icon"></i>  Reativar Anúncios (aluguel)
                        </a>
                        <a href="index.php?entidade=Anuncio&acao=listarAtivo" class="item"> 
                            <i class="list icon"></i> Anúncios Ativos
                        </a>
                        <a href="index.php?entidade=Anuncio&acao=listarFinalizado" class="item"> 
                            <i class="thumbs outline up icon"></i> Anúncios Não Ativos
                        </a>
                        <a href="index.php?entidade=Usuario&acao=listarMensagem" class="item"> 
                            <i class="mail outline icon"></i> Mensagens
                        </a>
                    <?php }
                    ?>
                </div>
                <?php
            } else {
                echo '<div class="column"><div class="ui red message"><h4 class="ui red header">Primeiro cadastre um imóvel.</h4></div></div>';
            }
        }
        ?>

    </div>
    <!-- TABELAS ANUNCIOS -->
    <?php
    if ($item) {
        if ($item['anuncio']) {
            ?>
            <div class="row">
                <div class="eight wide column"> 
                    <?php
                    $anuncioAtivo = 0;
                    $anuncioFinalizado = 0;
                    $anuncioExpirado = 0;

                    $anuncioAtivoAluguel = 0;
                    $anuncioAtivoVenda = 0;

                    $anuncioFinalizadoAluguel = 0;
                    $anuncioFinalizadoVenda = 0;

                    $anuncioExpiradoAluguel = 0;
                    $anuncioExpiradoVenda = 0;

                    foreach ($imoveis as $anuncio) {
                        $anuncios = $anuncio->getAnuncio();
                        if ($anuncio->getAnuncio()) {

                            switch ($anuncio->getAnuncio()->getStatus()) {
                                case "cadastrado":
                                    $anuncioAtivo = $anuncioAtivo + 1;

                                    if ($anuncio->getAnuncio()->getFinalidade() == "Aluguel") {
                                        $anuncioAtivoAluguel = $anuncioAtivoAluguel + 1;
                                    } else
                                        $anuncioAtivoVenda = $anuncioAtivoVenda + 1;

                                    break;
                                case "finalizado":
                                    $anuncioFinalizado = $anuncioFinalizado + 1;

                                    if ($anuncio->getAnuncio()->getFinalidade() == "Aluguel") {
                                        $anuncioFinalizadoAluguel = $anuncioFinalizadoAluguel + 1;
                                    } else
                                        $anuncioFinalizadoVenda = $anuncioFinalizadoVenda + 1;

                                    break;
                                case "expirado":
                                    $anuncioExpirado = $anuncioExpirado + 1;

                                    if ($anuncio->getAnuncio()->getFinalidade() == "Aluguel") {
                                        $anuncioExpiradoAluguel = $anuncioExpiradoAluguel + 1;
                                    } else
                                        $anuncioExpiradoVenda = $anuncioExpiradoVenda + 1;

                                    break;
                            }
                        }
                    }
                    ?>

        <?php if ($totalAnuncios > 0) { ?>

                        <div class="ui horizontal segments">       
                            <table class="ui striped brown celled structured fixed table">
                                <thead>
                                    <tr>                                   
                                        <th colspan="4">Você possui <?php
                                            if ($totalAnuncios > 1) {
                                                echo $totalAnuncios . " anúncios cadastrados";
                                            } else {
                                                echo " 1 anúncio cadastrado";
                                            }
                                            ?> 
                                        </th>
                                    </tr>

                                    <tr>

                                        <th class="ui center aligned"></th>

                                        <th class="ui center aligned"><?php
                                            if ($anuncioAtivo > 1) {
                                                echo "Ativos";
                                            } else
                                                echo "Ativo";
                                            ?>
                                        </th>

                                        <th class="ui center aligned"><?php
                                            if ($anuncioFinalizado > 1) {
                                                echo "Finalizados";
                                            } else
                                                echo "Finalizado";
                                            ?></th>
                                        <th class="ui center aligned"><?php
                                            if ($anuncioExpirado > 1) {
                                                echo "Expirados";
                                            } else
                                                echo "Expirado";
                                            ?></th>                                  
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Aluguel</td>
                                        <td><?php echo $anuncioAtivoAluguel; ?></td>
                                        <td><?php echo $anuncioFinalizadoAluguel; ?></td>
                                        <td><?php echo $anuncioExpiradoAluguel; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Venda</td>
                                        <td><?php echo $anuncioAtivoVenda; ?></td>
                                        <td><?php echo $anuncioFinalizadoVenda; ?></td>
                                        <td><?php echo $anuncioExpiradoVenda; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Total</td>
                                        <td><?php echo $anuncioAtivo; ?></td>
                                        <td><?php echo $anuncioFinalizado; ?></td>
                                        <td><?php echo $anuncioExpirado; ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
        <?php } ?>
                </div>

                <div class="eight wide column">
                    <?php
                    $msgs = 0;
                    $msgsRespondidas = 0;
                    $msgsNaoRespondidas = 0;

                    foreach ($mensagens as $mensagem) {

                        switch ($mensagem->getStatus()) {
                            case "NOVA":
                                $msgsNaoRespondidas = $msgsNaoRespondidas + 1;
                                break;
                            case "RESPONDIDO":
                                $msgsRespondidas = $msgsRespondidas + 1;
                                break;
                        }
                    }
                    ?>
        <?php if (count($mensagens) > 0) { ?>
                        <div class="ui horizontal segments">       
                            <table class="ui brown celled fixed table">
                                <thead>
                                    <tr>
                                        <th colspan="2"><?php
                                            if (count($mensagens) > 1) {
                                                echo "Você possui " . (count($mensagens)) . " mensagens";
                                            } else {
                                                echo "Você possui 1 mensagem";
                                            }
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="ui center aligned">
                                            <?php
                                            if ($msgsRespondidas > 1) {
                                                echo "Respondidas";
                                            } else
                                                echo "Respondida";
                                            ?>
                                        </th>
                                        <th class="ui center aligned">
                                            <?php
                                            if ($msgsNaoRespondidas > 1) {
                                                echo "Não Respondida";
                                            } else
                                                echo "Não Respondidas";
                                            ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $msgsRespondidas; ?></td>
                                        <td><?php echo $msgsNaoRespondidas; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        <?php } ?>
                </div>
            </div>


            <div class="row">         
                <div class="column">
                    <table class="ui striped brown celled fixed table">
                        <thead>
                            <tr>
                                <th colspan="7">Você possui
                                    <?php
                                    if ($anuncioAtivo > 1) {
                                        echo $anuncioAtivo . " anúncios ativos";
                                    } else {
                                        echo " 1 anúncio ativo";
                                    }
                                    ?>
                                </th>
                            </tr>

                            <tr>

                                <th class="ui center aligned"></th>

                                <th class="ui center aligned"><?php
                                    if ($casaAnuncio > 1) {
                                        echo "Casas";
                                    } else
                                        echo "Casa";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($apAnuncio > 1) {
                                        echo "Apartamentos";
                                    } else
                                        echo "Apartamento";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($apPlantaAnuncio > 1) {
                                        echo "Apartamentos na Planta";
                                    } else
                                        echo "Apartamento na Planta";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($salaAnuncio > 1) {
                                        echo "Salas Comerciais";
                                    } else
                                        echo "Sala Comercial";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($predioAnuncio > 1) {
                                        echo "Prédios Comerciais";
                                    } else
                                        echo "Prédio Comercial";
                                    ?></th>
                                <th class="ui center aligned"><?php
                                    if ($terrenoAnuncio > 1) {
                                        echo "Terrenos";
                                    } else
                                        echo "Terreno";
                                    ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Aluguel</td>
                                <td><?php echo $casaAnuncioAluguel; ?></td>
                                <td><?php echo $apAnuncioAluguel; ?></td>
                                <td><?php echo $apPlantaAnuncioAluguel; ?></td>
                                <td><?php echo $salaAnuncioAluguel; ?></td>
                                <td><?php echo $predioAnuncioAluguel; ?></td>
                                <td><?php echo $terrenoAnuncioAluguel; ?></td>
                            </tr>

                            <tr>
                                <td>Venda</td>
                                <td><?php echo $casaAnuncioVenda; ?></td>
                                <td><?php echo $apAnuncioVenda; ?></td>
                                <td><?php echo $apPlantaAnuncioVenda; ?></td>
                                <td><?php echo $salaAnuncioVenda; ?></td>
                                <td><?php echo $predioAnuncioVenda; ?></td>
                                <td><?php echo $terrenoAnuncioVenda; ?></td>
                            </tr>

                            <tr>
                                <td>Total</td>
                                <td><?php echo $casaAnuncio; ?></td>
                                <td><?php echo $apAnuncio; ?></td>
                                <td><?php echo $apPlantaAnuncio; ?></td>
                                <td><?php echo $salaAnuncio; ?></td>
                                <td><?php echo $predioAnuncio; ?></td>
                                <td><?php echo $terrenoAnuncio; ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>  
            </div> 

            <script>
                graficoBarrasTotal('graficoAnunciosEcharts', 'Número de Anúncios', '#a5673f', <?php echo $casaAnuncio ?>, <?php echo $apAnuncio ?>, <?php echo $apPlantaAnuncio ?>, <?php echo $salaAnuncio ?>, <?php echo $predioAnuncio ?>, <?php echo $terrenoAnuncio ?>);
            </script>

            <div class="row">
                <div class="column">
                    <div id="graficoAnunciosEcharts" 
                         style="height:450px; max-width: 40%; min-width: 90%;width: 850px">
                    </div>
                </div>
            </div>  

        <?php
        }
    }
    ?>

    <div class="row">
        <div class="column">
            <h3 class="ui dividing header"></h3>
        </div>
    </div>

</div> 

<!-- COMPRAR -->
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="shop icon"></i>
            <div class="content">
                Meus Planos
                <div class="sub header">Gerencie seus planos </div>
            </div>
        </h2>
    </div>

    <div class="ui stackable orange inverted container menu">
        <a href="index.php?entidade=UsuarioPlano&acao=listar" class="item">            
            <i class="add icon"></i> Comprar
        </a>
    </div>

    <div class="row">
        <div class="column">
            <?php
            if ($item) {
                if (!$item["usuarioPlano"]) {
                    ?>
                    <div class="ui orange message"><h4 class="ui red header">Você ainda não tem plano. Não perca tempo e COMPRE AGORA!</h4></div>
                    <br/> <img class="ui centered image" src="http://www.prospeccao-de-clientes.com/images/gudrum-pagseguro.gif" /> 
                    <?php
                } else {
                    ?> 

                    <table class="ui striped orange stackable table" id="tabela">
                        <thead>
                            <tr>
                                <th>Plano</th>
                                <th>Descrição</th>
                                <th>Data de Compra</th>
                                <th>Prazo para ativação</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($item["usuarioPlano"] as $usuarioPlano) {
                                echo "<tr>";
                                echo "<td>" . $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias)</td>";
                                echo "<td>" . $usuarioPlano->getPlano()->getDescricao() . "</td>";
                                echo "<td>" . date('d/m/Y H:i:s', strtotime($usuarioPlano->getDataCompra())) . "</td>";
                                if ($usuarioPlano->getStatus() != "ativo") {
                                    echo "<td>" . $usuarioPlano->DataExpiracao($usuarioPlano->getPlano()->getValidadeativacao()) . "</td>";
                                } else {
                                    echo "<td> - </td>";
                                }
                                echo "<td>" . $usuarioPlano->getStatus() . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php
                }
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <h3 class="ui dividing header"></h3>
        </div>
    </div>

</div> 

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="info circle icon"></i>
            <div class="content">
                Ajuda
                <div class="sub header">Precisa de ajuda? </div>
            </div>
        </h2>
    </div>

    <div class="ui stackable pink inverted container menu">
        <a href="index.php?entidade=UsuarioPlano&acao=listar" class="item">            
            <i class="comment outline icon"></i> Fale Conosco
        </a>
        <a href="index.php?entidade=UsuarioPlano&acao=listar" class="item">            
            <i class="book icon"></i> Dúvidas Mais Frequentes
        </a>
    </div>

</div> 

<div class="ui hidden divider"></div>