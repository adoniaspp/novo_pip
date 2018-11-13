<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/echarts/build/dist/echarts-all.js"></script>
<script src="assets/js/grafico.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {

        $(function () {
            //incluso essa variavel para setar atributos do css depois
            var elemento = $('#divMiniMenu');

            var deviceAgent = navigator.userAgent.toLowerCase();
            var agentID = deviceAgent.match(/(iphone|ipod|ipad|android|blackberry)/);

            if (agentID) {
                $('#divMiniMenu').hide();// caso seja iphone|ipod|ipad|android|blackberry
            } else {
                //alert('você está em um computador');
                $(window).scroll(function () {
                    //distancia que o scroll devera rolar para aparecer o box da div
                    if ($(this).scrollTop() > 0) {
                        //bloco incluso para setar o css
                        elemento.css({
                            'position': 'fixed',
                            'bottom': '30%'
                        });

                        $('#divMiniMenu').fadeIn();
                    }
                });
            }


        });

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

        $('#tabelaChamados').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "order": [4, "desc"],
            "stateSave": true,
            "columnDefs": [
                {"orderable": false, "targets": 6}
            ]
        });
    })
</script>

<style>
    .ui.menu .item:before {
        width: 4px !important;
    }

    #divMiniMenu{
        position: absolute;
        z-index: 9999; /* número máximo é 9999 */
    }


    @media screen and (max-width: 1200px){
        #divMiniMenu {
            display: none;
        }
    }

    .miniMenu1 {
        width: 65px;
        padding: 1em;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-top: #0084B4 3px solid;
        text-align: center;
        font-size: 12px;
    }
    .miniMenu2 {
        width: 65px;
        padding: 1em;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-top: #1fc231 3px solid;
        text-align: center;
        font-size: 12px;
    }
    .miniMenu3 {
        width: 65px;
        padding: 1em;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-top: #794B02 3px solid;
        text-align: center;
        font-size: 12px;
    }
    .miniMenu4 {
        width: 65px;
        padding: 1em;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-top: #FF851B 3px solid;
        text-align: center;
        font-size: 12px;
    }
    .miniMenu5 {
        width: 65px;
        padding: 1em;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-top: #FF2733 3px solid;
        text-align: center;
        font-size: 12px;
    }

</style>
<?php
$item = $this->getItem();

Sessao::gerarToken();

$usuario = $item["usuario"];
$imoveis = $item["imovelCadastrado"];
$mensagens = $item["mensagem"];
$usuarioBairro = $item["usuarioBairro"];
$chamdos = $item["chamados"];
$planosUsu = $item["planosUsuarioGratis"];
$anuncioPendenteAprovacao = $item["anuncioPendente"];
$dadosPlano = $item["dadosPlano"];

foreach ($usuarioBairro as $bairroUsuario) {
    $bUsuario = $bairroUsuario->getNome();
}

$totalAnuncios = 0; //total de anuncios cadastrados
$pendenteAprova = 0; //total de anuncios pendentes de aprovação

foreach ($imoveis as $qtdAnuncios) {
    if ($qtdAnuncios->getAnuncio()) {
        $totalAnuncios = $totalAnuncios + 1;
    }
}

foreach ($anuncioPendenteAprovacao as $pendente){
    if ($pendente->getIdAnuncio()) {
        $pendenteAprova = $pendenteAprova + 1;
    }
}

$totalAnuncios = $totalAnuncios + $pendenteAprova;

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

<div id="divMiniMenu" style="bottom: 30%">
    <div class="miniMenu1"><a href="#linkMeusDados">Dados</a></div>
    <div class="miniMenu2"><a href="#linkImoveis">Imóveis</a></div>
    <div class="miniMenu3"><a href="#linkAnuncios">Anúncios</a></div>
    <div class="miniMenu4"><a href="#linkPlanos">Planos</a></div>
    <div class="miniMenu5"><a href="#linkAjuda">Ajuda</a></div>
</div>

<div id="linkMeusDados"></div>

<h3 class="ui dividing header"></h3>

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

<?php if ($_SESSION['login'] == 'pipdiministrador') { ?>

    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <h2 class="ui header">
                <i class="laptop icon"></i>
                <div class="content">
                    Administração do PIP - Online
                    <div class="sub header">Anúncios</div>
                </div>
            </h2>
        </div>
        <div class="ui stackable red inverted container menu">
            <a href="index.php?entidade=AnuncioAprovacao&acao=listarPendente" class="item">            
                <i class="large edit icon"></i> Aprovar Anúncios           
            </a>
            <a href="index.php?entidade=AnuncioAprovacao&acao=listarNegado" class="item">            
                <i class="large remove icon"></i> Anúncios Negados           
            </a>
            <a href="index.php?entidade=Usuario&acao=listarUsuarios" class="item">            
                <i class="large edit icon"></i> Ativar/Desativar Usuário        
            </a>
            <a href="index.php?entidade=Usuario&acao=listarUsuarioDesativado" class="item">            
                <i class="large remove icon"></i> Usuários Desativados         
            </a>
            <a href="index.php?entidade=Chamado&acao=listarChamados" class="item">            
                <i class="large comment outline icon"></i> Responder Chamado        
            </a>
        </div>

    </div>

<?php } ?>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <h3 class="ui dividing header"></h3>
        </div>
    </div>
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
            <i class="large edit icon"></i> Atualizar Cadastro            
        </a>
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha" class="item"> 
            <i class="large lock icon"></i> Trocar Senha 
        </a>
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarimagem" class="item"> 
            <i class="large file image outline icon"></i>  Alterar <?php echo ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca"); ?>
        </a>
        <a href="index.php?entidade=Usuario&acao=Configuracoes" class="item"> 
            <i class="large configure icon"></i> Configurações
        </a>
        <a href="index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $_SESSION["login"] ?>" class="item" target="_blank"> 
            <i class="large newspaper icon"></i> Visualizar Minha Página
        </a>
    </div>

    <?php
    if ($usuario[0]->getEndereco()->getNumero() != "" && $usuario[0]->getEndereco()->getComplemento() != "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro() . ", " . $usuario[0]->getEndereco()->getNumero() . ", " . $usuario[0]->getEndereco()->getComplemento() . " - " . $bUsuario;
    } elseif ($usuario[0]->getEndereco()->getNumero() != "" && $usuario[0]->getEndereco()->getComplemento() == "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro() . ", " . $usuario[0]->getEndereco()->getNumero() . " - " . $bUsuario;
    } elseif ($usuario[0]->getEndereco()->getNumero() == "" && $usuario[0]->getEndereco()->getComplemento() == "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro() . " - " . $bUsuario;
    } elseif ($usuario[0]->getEndereco()->getNumero() == "" && $usuario[0]->getEndereco()->getComplemento() != "") {
        $endereco = $usuario[0]->getEndereco()->getLogradouro() . ", " . $usuario[0]->getEndereco()->getComplemento() . " - " . $bUsuario;
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
            <div id="linkImoveis"></div>
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
            </div>
        </div>       
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
            <i class="large add icon"></i> Cadastrar Imóvel
        </a>

        <?php
        if ($item) {
            if ($item['imovel']) {
                ?>
                <a href="index.php?entidade=Imovel&acao=listarEditar" class="item"> 
                    <i class="large edit icon"></i> Alterar Imóvel
                </a>
                <a href="index.php?entidade=Imovel&acao=listar" class="item"> 
                    <i class="large list icon"></i> Meus Imóveis
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

                    <table class="ui striped green celled structured fixed table">
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
            <?php if(count($imoveis) >= 10){?>
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
             <?php } //fim do if para verificar se existem mais de 10 imóveis cadastrados?>
            <div id="linkAnuncios"></div>
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
<div class="ui hidden divider"></div><div class="ui hidden divider"></div>
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="announcement icon"></i>
            <div class="content">
                Meus Anúncios
                <div class="sub header">Gerencie seus anúncios. Você pode cadastrar, visualizar, finalizar ou reativar anúncios, além de ler suas mensagens </div>
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
                        <i class="big add icon"></i> Publicar Anúncio
                    </a>
                    <?php if ($item['anuncio']) { ?>
                        <a href="index.php?entidade=Anuncio&acao=listarReativarAluguel" class="item"> 
                            <i class="large refresh icon"></i>  Reativar Anúncios (aluguel)
                        </a>
                        <a href="index.php?entidade=Anuncio&acao=listarAtivo" class="item"> 
                            <i class="large list icon"></i> Anúncios Ativos
                        </a>
                        <a href="index.php?entidade=AnuncioAprovacao&acao=listarPendente" class="item"> 
                            <i class="large warning icon"></i> Pendentes de Aprovação
                        </a>
                        <a href="index.php?entidade=Anuncio&acao=listarFinalizado" class="item"> 
                            <i class="large thumbs outline up icon"></i> Anúncios Não Ativos
                        </a>
                        <a href="index.php?entidade=Usuario&acao=listarMensagem" class="item"> 
                            <i class="large mail outline icon"></i> Mensagens
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
                    $anuncioPendente = 0;

                    $anuncioAtivoAluguel = 0;
                    $anuncioAtivoVenda = 0;

                    $anuncioFinalizadoAluguel = 0;
                    $anuncioFinalizadoVenda = 0;

                    $anuncioExpiradoAluguel = 0;
                    $anuncioExpiradoVenda = 0;

                    $anuncioPendenteAluguel = 0;
                    $anuncioPendenteVenda = 0;

                    foreach ($imoveis as $anuncio) {
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
                    foreach ($imoveis as $anuncio) {
                        $anuncioAprovacao = $anuncio->getAnuncioaprovacao();
                        if ($anuncioAprovacao) {
                            if (!is_array($anuncioAprovacao)) {
                                $anuncioAprovacao = array($anuncioAprovacao);
                            }
                            foreach ($anuncioAprovacao as $aprovacao) {
                                switch ($aprovacao->getStatus()) {
                                    case "pendenteanalise":
                                    case "emanalise":
                                        $anuncioPendente = $anuncioPendente + 1;
                                        if ($aprovacao->getFinalidade() == "Aluguel") {
                                            $anuncioPendenteAluguel = $anuncioPendenteAluguel + 1;
                                        } else {
                                            $anuncioPendenteVenda = $anuncioPendenteVenda + 1;
                                        }
                                        break;
                                }
                            }
                        }
                    }
                    ?>

                    <?php if ($totalAnuncios > 0) { ?>

                        <div class="ui horizontal segments">       
                            <table class="ui striped brown celled structured fixed table">
                                <thead>
                                    <tr>                                   
                                        <th colspan="5">Você possui <?php
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
                                        <th class="ui center aligned"><?php
                                            if ($anuncioPendente > 1) {
                                                echo "Pendentes";
                                            } else
                                                echo "Pendente";
                                            ?></th>                                  
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Aluguel</td>
                                        <td><?php echo $anuncioAtivoAluguel; ?></td>
                                        <td><?php echo $anuncioFinalizadoAluguel; ?></td>
                                        <td><?php echo $anuncioExpiradoAluguel; ?></td>
                                        <td><?php echo $anuncioPendenteAluguel; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Venda</td>
                                        <td><?php echo $anuncioAtivoVenda; ?></td>
                                        <td><?php echo $anuncioFinalizadoVenda; ?></td>
                                        <td><?php echo $anuncioExpiradoVenda; ?></td>
                                        <td><?php echo $anuncioPendenteVenda; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Total</td>
                                        <td><?php echo $anuncioAtivo; ?></td>
                                        <td><?php echo $anuncioFinalizado; ?></td>
                                        <td><?php echo $anuncioExpirado; ?></td>
                                        <td><?php echo $anuncioPendente; ?></td>
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

            <?php if ($anuncioAtivo > 0) { ?>
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
                <?php if ($anuncioAtivo >= 5) { ?>
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
                <?php } //fim do if para verificar se existem ao menos 5 anúncios cadastrados?>
            <?php } ?>            
            <div id="linkPlanos"></div>
            <?php
        }
    }
    ?>

    <div class="row">
        <div class="column">
            <h3 class="ui dividing header"></h3><div class="ui hidden divider"></div><div class="ui hidden divider"></div>
        </div>
    </div>

</div> 



<!-- COMPRAR -->
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="large shop icon"></i>
            <div class="content">
                Meus Planos
                <div class="sub header">Gerencie seus planos </div>
            </div>
        </h2>
    </div>

    <div class="ui stackable orange inverted container menu">
        <a href="index.php?entidade=UsuarioPlano&acao=listar" class="item">            
            <i class="large add icon"></i> Comprar
        </a>
    </div>

    <div class="row">
        <div class="column">
            <?php
     
            if ($item) {

                if($planosUsu && !$item["usuarioPlano"]){ ?>
            
                   <div class="ui orange message"><h4 class="ui red header">Você já utilizou um gratuito e não possui nenhum plano. Não perca tempo e COMPRE AGORA!</h4></div>
               
            <?php } else if 
                
                 (!$planosUsu && !$item["usuarioPlano"]) {
                    ?>
                    <div class="ui orange message"><h4 class="ui red header">Você ainda não tem plano, mas pode utilizar um gratuito. Não perca tempo e COMPRE AGORA!</h4></div>
                    <?php
                } else {
                    ?> 

                    <table class="ui striped orange stackable table" id="tabela">
                        <thead>
                            <tr>
                                <th>Plano</th>
                                <th>Descrição</th>
                                <th>Data de Compra</th>
                                <th>Prazo para Utilização</th>
                                <th>Status do Plano</th>
                                <th>Anúncio Vinculado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            
                            foreach ($dadosPlano as $dPlanos) {
    
                                
                                if ($dPlanos['statusplano'] == "pago" && $dPlanos['gratuito'] == 'NAO') {
                                    $statusPlano = "<h4 class='ui green header'>Pago</h4>";
                                }

                                else if ($dPlanos['statusplano'] == "utilizado" && $dPlanos['gratuito'] == 'NAO') {                                    
                                    $statusPlano = "<h4 class='ui red header'>Utilizado</h4>";
                                }                                

                                else if ($dPlanos['statusplano'] == "pagamento pendente" && $dPlanos['gratuito'] == 'NAO') {
                                    $statusPlano = "<h4 class='ui yellow header'>Pagamento Pendente</h4>";
                                }

                                else if ($dPlanos['statusplano'] == "expirado" && $dPlanos['gratuito'] == 'NAO') {
                                    $statusPlano = "<h4 class='ui red header'>Expirado</h4>";
                                }
                                
                                else if($dPlanos['statusplano'] == "pago" && $dPlanos['gratuito'] == 'SIM'){
                                     $statusPlano = "<h4 class='ui green header'> Gratuito </h4>";;
                                }
                   
                                echo "<tr>";
                                
                                if($dPlanos['gratuito'] == 'SIM'){
                                     echo "<td>" . $dPlanos['titulo'] . " </td>";
                                }
                                else echo "<td>" . $dPlanos['titulo'] . " (" . $dPlanos['validadeativacao'] . " dias)</td>";

                                echo "<td>" . $dPlanos['descricao'] . "</td>";
                                
                                if($dPlanos['gratuito'] == 'SIM'){
                                     echo "<td>" . ' -  '. "</td>";
                                }
                                else echo "<td>" . date('d/m/Y H:i:s', strtotime($dPlanos['datacompra'])) . "</td>";
                                
                                if($dPlanos['gratuito'] == 'SIM'){
                                     echo "<td>" . ' -  '. "</td>";
                                }
                                
                                else if ($dPlanos['statusplano'] == "pagamento pendente" || $dPlanos['statusplano'] == "pago") {
                                    $diasRestantes = FuncoesAuxiliares::diasRestantes($dPlanos['datacompra']);
                                    
                                    if($diasRestantes > 6 && $diasRestantes < 1){
                                        $diasRestantesModulo = "<a class='ui small yellow header'>".$diasRestantes."</a> dias"; 
                                    }
                                    
                                    if($diasRestantes == 1){
                                        $diasRestantesModulo = "<a class='ui small red header'>".$diasRestantes."</a> dia"; 
                                    }
                                    
                                    if($diasRestantes > 5){
                                        $diasRestantesModulo = "<a class='ui small header'>".$diasRestantes."</a> dias"; 
                                    }
                                    
                                    $dateB = date_create_from_format("Y-m-d H:s:i", $dPlanos['datacompra']);
                                    $dateA = $dateB->add(date_interval_create_from_date_string(60 . 'days'));
                                    $dFinalExpiracao = date_format($dateA, "d/m/Y");
                                    
                                    echo "<td>" . $dFinalExpiracao ." - ". $diasRestantesModulo ."</td>";
                                } else {
                                    echo "<td> Já utilizado </td>";
                                }
                                echo "<td>" . $statusPlano . "</td>";  
                                
                                    if (($dPlanos['status']) != '') {//verifica se tem anuncios.

                                            switch ($imovelCadastrado['idtipoimovel']) {

                                                case 1: $tipoImovel = "casa";
                                                    break;
                                                case 2: $tipoImovel = "apartamentoplanta";
                                                    break;
                                                case 3: $tipoImovel = "apartamento";
                                                    break;
                                                case 4: $tipoImovel = "salacomercial";
                                                    break;
                                                case 5: $tipoImovel = "prediocomercial";
                                                    break;
                                                case 6: $tipoImovel = "terreno";
                                                    break;
                                            }
                                    $vinculado = "<form id='form' action='index.php' method='post' target='_blank'>
                                    <input type='hidden' id='hdnEntidade' name='hdnEntidade' value='Anuncio' />
                                    <input type='hidden' id='hdnAcao' name='hdnAcao' value='detalhar'/>
                                    <input type='hidden' id='hdnCodAnuncio' name='hdnCodAnuncio' value='" . $dPlanos['id'] . "'/>
                                    <input type='hidden' id='hdnTipoImovel' name='hdnTipoImovel' value='" . $tipoImovel . "'/>           
                                    <button class='ui labeled icon button'>
                                    <i class='zoom icon'></i>" . $dPlanos['idanuncio'] . "
                                    </button>
                                    <input type='hidden' name='hdnCodAnuncioFormatado[]' value='" . $dPlanos['idanuncio'] . "'/>
                                    </form>"; 
                                    }  
                                    
                                    else {
                                        
                                        if($item["anuncioPendente"]){
                                        
                                            foreach ($item["anuncioPendente"] as $itemPendente){       

                                            if($itemPendente->getIdUsuarioPlano() == $dPlanos['idusuario'] && $itemPendente->getStatus()=="pendenteanalise"){
                                                $vinculado = "<h4 class='ui yellow header'>Pendente de Análise</h4>";
                                            }
                                            else if($itemPendente->getIdUsuarioPlano() == $dPlanos['idusuario'] && $itemPendente->getStatus()=="emanalise"){
                                                $vinculado = "<h4 class='ui yellow header'>Em Análise</h4>";
                                            }

                                          }
                                       }
                                    }
                                    if($dPlanos['statusplano'] == 'expirado' || $dPlanos['statusplano'] == 'finalizado' || $dPlanos['statusplano'] == 'pago'){

                                        $vinculado = "<h4 class='ui red header'>Nenhum anúncio vinculado</h4>";
                                        
                                    }

                                echo "<td>" . $vinculado . "</td>"
                                . "</tr>";
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
                Central de Relacionamento
                <div class="sub header">Ajuda sobre dúvidas, problemas, elogios, sugestões, etc.</div>
            </div>
        </h2>
    </div>

    <div class="ui stackable pink inverted container menu">
        <a href="index.php?entidade=Usuario&acao=AbrirChamado" class="item">            
            <i class="large comment outline icon"></i>Fale Com o PIP Online
        </a>
        <a href="index.php?entidade=Institucional&acao=duvidasFrequentes" class="item">            
            <i class="large book icon"></i> Dúvidas Mais Frequentes
        </a>
    </div>

    <div class="row">
        <div class="column">
            <?php
            if ($item) {
                if (!$item["chamados"]) {
                    ?>
                    <div class="ui orange message"><h4 class="ui red header">Você não possui chamados cadastrados</h4></div>
                    <br/>  
                    <?php
                } else {
                    ?>                 

                    <?php
                    $listagemChamado;
                    foreach ($item["chamados"] as $chamados) {

                        if ($chamados->getStatus() == "aberto") {
                            $statusChamado = "<a class='ui green small header'>Aberto</a>";
                        }

                        if ($chamados->getStatus() == "atendimento") {
                            $statusChamado = "<a class='ui yellow small header'>Em Atendimento</a>";
                        }

                        if ($chamados->getStatus() == "respondido") {
                            $statusChamado = "<a class='ui blue small header'>Respondido</a>";
                        }

                        if ($chamados->getStatus() == "cancelado") {
                            $statusChamado = "<a class='ui red small header'>Cancelado</a>";
                        }

                        if ($chamados->getStatus() == "aguardandousuario") {
                            $statusChamado = "<a class='ui small header'>Aguardando</a>";
                        }

                        if ($chamados->getAssuntoParametrizado() == "NAO") {
                            $titulo = $chamados->getChamadoTitulo()->getTitulo();
                            $chamadoTipo = $chamados->getIdChamadoAssunto();
                        } else {
                            $titulo = $chamados->getChamadoAssunto()->getAssunto();
                            $chamadoTipo = $chamados->getChamadoAssunto()->getIdTipo();
                        }

                        $limite = 25;
                        $escreverAssunto = (strlen(trim($titulo)) >= $limite) ? trim(substr($titulo, 0, strrpos(substr($titulo, 0, $limite), " "))) . "..." : $titulo;

                        $limiteMsg = 30;
                        $mensagem = $chamados->getMensagem();
                        $escreverMsg = (strlen(trim($mensagem)) >= $limiteMsg) ? trim(substr($mensagem, 0, strrpos(substr($mensagem, 0, $limiteMsg), " "))) . "..." : $mensagem;

                        $listagemChamado .= "<tr>";
                        $listagemChamado .= "<td><strong>" . $chamados->getCodigoChamado() . "</strong></td>";
                        $listagemChamado .= "<td>" . Chamado::retornarTipo($chamadoTipo) . "</td>";
                        $listagemChamado .= "<td>" . $escreverAssunto . " </td>";
                        $listagemChamado .= "<td>" . $escreverMsg . "</td>";
                        $listagemChamado .= "<td>" . date('d/m/Y H:i:s', strtotime($chamados->getDataHoraCadastro())) . "</td>";
                        $listagemChamado .= "<td>" . $statusChamado . "</td>";

                        if ($chamados->getStatus() != "cancelado" && $chamados->getStatus() != "respondido") {

                            $listagemChamado .= "<td> <a class='ui circular inverted icon button' id='btnDetalhesChamado" . $chamados->getId() . "' ><i class='ui big green zoom icon'></i></a>Visualizar"
                                    . "<a class='ui circular inverted icon button' id='btnCancelarChamado" . $chamados->getId() . "' ><i class='big red remove circle outline icon'></i></a>Cancelar"
                                    . "</td>";
                        } else {
                            $listagemChamado .= "<td> <a class='ui circular inverted icon button' id='btnDetalhesChamado" . $chamados->getId() . "' ><i class='ui big green zoom icon'></i></a>Visualizar"
                                    . "</td>";
                        }
                        $listagemChamado .= "</tr>";
                        ?>    

                        <script>
                            visualizarModalChamado('<?php echo $chamados->getId() ?>');
                        </script>

                        <div class="ui standart modal" id="modalChamado<?php echo $chamados->getId() ?>">

                            <div class="header">
                                Chamado <?php echo $chamados->getCodigoChamado() ?>
                            </div>
                            <div class="content" id="camposAlterarStatus<?php echo $chamados->getId() ?>">

                                <form class="ui form" id="formChamado<?php echo $chamados->getId() ?>" action="index.php" method="post">
                                    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value=""  />
                                    <input type="hidden" id="hdnAcao" name="hdnAcao" value="" />  
                                    <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                                    <input type="hidden" id="hdnAnuncio" name="hdnChamado" value="<?php echo $chamados->getId() ?>" />
                                    <input type="hidden" id="hdnAdmin" name="hdnAdmin" value="NAO" />
                                    <input type="hidden" id="sltStatusChamadoResposta" name="sltStatusChamadoResposta" value="<?php echo $chamados->getStatus() ?>" />

                                    <div id="divModalVisualizar<?php echo $chamados->getId() ?>">
                                        <?php
                                        if ($chamados->getChamadoTitulo() != null) {
                                            $titulo = $chamados->getChamadoTitulo()->getTitulo();
                                        } else {
                                            $titulo = $chamados->getChamadoAssunto()->getAssunto();
                                        }
                                        ?>
                                        <div class="stackable two column ui grid container">
                                            <div class="column">
                                                <div class="ui segment">
                                                    <a class="header">Tipo de Chamado</a>
                                                    <div class="description"> <?php echo Chamado::retornarTipo($chamadoTipo)//echo Chamado::retornarTipo($chamados->getChamadoAssunto()->getIdTipo())  ?></div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="ui segment">
                                                    <a class="header">Assunto</a>
                                                    <div class="description"><?php echo $titulo; ?></div>
                                                </div>
                                            </div>
                                        </div>   

                                        <div class="stackable one column ui grid container">
                                            <div class="column">
                                                <div class="ui segment"><a class="header">Mensagem</a>
                                                    <div class="description"> <?php echo $chamados->getMensagem(); ?></div>
                                                </div>
                                            </div>    
                                        </div>

                                        <div class="stackable two column ui grid container">

                                            <div class="column">
                                                <div class="ui segment"><a class="header">Data do Cadastro</a>
                                                    <div class="description"><?php echo date('d/m/Y H:i:s', strtotime($chamados->getDataHoraCadastro())); ?>
                                                    </div>
                                                </div>       
                                            </div>

                                            <div class="column">
                                                <div class="ui segment"><a class="header">Status do Chamado</a>
                                                    <div class="description"><?php
                                                        if ($chamados->getStatus() == "aberto") {
                                                            $mensagemPadrao = "Seu chamado será respondido em breve";
                                                        } if ($chamados->getStatus() == "atendimento") {
                                                            $mensagemPadrao = "Seu chamado já está em análise por nossa equipe e em breve será respondido";
                                                        } if ($chamados->getStatus() == "cancelado") {
                                                            $mensagemPadrao = "Você cancelou o chamado em " . $chamados->getDataHoraCancela();
                                                        }if ($chamados->getStatus() == "aguardandousuario") {
                                                            $mensagemPadrao = "Aguardando sua resposta";
                                                        }
                                                        if ($chamados->getStatus() == "respondido") {
                                                            $mensagemPadrao = "Seu chamado foi respondido por nossa equipe";
                                                        }
                                                        echo $statusChamado . " - " . $mensagemPadrao;
                                                        ?>
                                                    </div>
                                                </div>       
                                            </div>
                                        </div>    

                                        <?php if ($chamados->getStatus() == "aberto" || $chamados->getStatus() == "atendimento" || $chamados->getStatus() == "aguardandousuario") { ?>    

                                            <div class="stackable one column ui grid container">
                                                <div class="column">
                                                    <div class="ui segment"><a class="header">Nova Mensagem</a>

                                                        <div class="description">
                                                            <textarea rows="5" cols="100" id="txtRespostaChamado" name="txtRespostaChamado" maxlength="1000"></textarea>
                                                        </div>
                                                    </div>       
                                                </div>

                                            </div>           

                                        <?php } ?>    

                                    </div>    

                                    <div id="divModalMenorCancelar<?php echo $chamados->getId() ?>">

                                        <div class="stackable two column ui grid container">
                                            <div class="header">
                                                <strong style="font-size: 18px">Deseja realmente cancelar o chamado?</strong>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="stackable one column ui grid container">
                                        <div class="column">
                                            <div class="ui segment">
                                                <a class="header">Mensagem(ns) já cadastrada(s)</a><br>
                                                <?php
                                                $totalResposta = count($chamados->getChamadoResposta());

                                                if ($totalResposta >= 1) {

                                                    if ($totalResposta == 1) {

                                                        if ($chamados->getChamadoResposta()->getAdministracao() == "SIM") {
                                                            $adminPIP = "PIP Cadastrou";
                                                        } else
                                                            $adminPIP = "Você Cadastrou";

                                                        switch ($chamados->getChamadoResposta()->getStatus()) {
                                                            case "aberto": $respChamado = "<a class='ui small green header'>Aberto</a>";
                                                                break;
                                                            case "atendimento": $respChamado = "<a class='ui small yellow header'>Em Atendimento</a>";
                                                                break;
                                                            case "aguardandousuario": $respChamado = "<a class='ui small header'>Aguardando Usuário</a>";
                                                                break;
                                                            case "respondido": $respChamado = "<a class='ui small blue header'>Respondido</a>";
                                                                break;
                                                            case "cancelado": $respChamado = "<a class='ui small red header'>Cancelado</a>";
                                                                break;
                                                        }

                                                        echo $adminPIP . " - " . $chamados->getChamadoResposta()->getDatahoracadastro() . " - " . $respChamado . " - " . $chamados->getChamadoResposta()->getResposta() . "<br>";
                                                    } if ($totalResposta > 1) {

                                                        for ($x = 0; $x < $totalResposta; $x++) {

                                                            if ($chamados->getChamadoResposta()[$x]->getAdministracao() == "SIM") {
                                                                $adminPIP = "PIP Cadastrou";
                                                            } else
                                                                $adminPIP = "Você Cadastrou";

                                                            switch ($chamados->getChamadoResposta()[$x]->getStatus()) {
                                                                case "aberto": $respChamado = "<a class='ui small green  header'>Aberto</a>";
                                                                    break;
                                                                case "atendimento": $respChamado = "<a class='ui small yellow header'>Em Atendimento</a>";
                                                                    break;
                                                                case "aguardandousuario": $respChamado = "<a class='ui small header'>Aguardando Usuário</a>";
                                                                    break;
                                                                case "respondido": $respChamado = "<a class='ui small blue header'>Respondido</a>";
                                                                    break;
                                                                case "cancelado": $respChamado = "<a class='ui small red header'>Cancelado</a>";
                                                                    break;
                                                            }
                                                            echo $adminPIP . " - " . $chamados->getChamadoResposta()[$x]->getDatahoracadastro() . " - " . $respChamado . " - " . $chamados->getChamadoResposta()[$x]->getResposta() . "<br>";
                                                        }
                                                    }
                                                    //}                                                       
                                                } else
                                                    echo "Nenhuma resposta cadastrada para o chamado"
                                                    ?>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>

                            <div id="divRetornoNovoStatus<?php echo $chamados->getId(); ?>"></div>

                            <div class="actions">

                                <?php if ($chamados->getStatus() != "cancelado" && $chamados->getStatus() != "respondido") { ?>
                                    <div class="stackable one column ui grid container" id="divAtencaoCancela<?php echo $chamados->getId(); ?>">
                                        <div class="column">                                           
                                            <div class='ui compact yellow icon message'><i class='big warning circle icon'></i>
                                                <p><strong>ATENÇÃO</strong>: Ao clicar em "Cancelar Chamado", seu chamado não será mais analisado pelo PIP Online</p>
                                            </div>                                            


                                        </div>    

                                    </div>
                                    <br>
                                    <div  id="botaoCancelarChamado<?php echo $chamados->getId(); ?>" class="ui red labeled icon button">
                                        <i class='big white remove outline circle icon'></i>Cancelar Chamado
                                    </div>

                                <?php } ?>

                                <?php if ($chamados->getStatus() == "aberto" || $chamados->getStatus() == "atendimento" || $chamados->getStatus() == "aguardandousuario") { ?>

                                    <div  id="botaoResponderNovaMensagem<?php echo $chamados->getId(); ?>" class="ui green labeled icon button">
                                        <i class='big white check icon'></i>Cadastrar
                                    </div>

                                <?php } ?>

                                <div  id="botaoFecharChamado<?php echo $chamados->getId(); ?>" class="ui red deny button">
                                    Fechar
                                </div>
                            </div>


                        </div>    

                        <?php
                    }
                    ?>
                    <table class="ui striped pink stackable table" id="tabelaChamados">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Assunto</th>
                                <th>Mensagem</th>                                
                                <th>Data Cadastro</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $listagemChamado; ?>
                        </tbody>
                    </table>

                    <?php

                }
            }
            ?>
        </div>
    </div>

</div> 
<div id="linkAjuda"></div>
<div class="ui hidden divider"></div>

