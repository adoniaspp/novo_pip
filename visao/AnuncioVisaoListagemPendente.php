
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">

<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/js/anuncio.js"></script>

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
            "stateSave": true,
            "order": [[4, "desc"]]
            
           <?php
            if ($_SESSION['login'] === 'pipdiministrador') {
                ?>                                
            ,"columnDefs": [
                {"orderable": false, "targets": 7}
            ]
           <?php
            }
            ?>
        });

    })

</script>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <div class="active section"><i class="warning small icon"></i>Anúncios Pendentes de Aprovação</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div class="ui message">
                Abaixo estão seus anúncios pendentes de aprovação. Em breve estarão disponíveis a serem visualizados por outras pessoas.
                Quando seu anúncio for aprovado, você receberá um e-mail. Acompanhe o andamento pelo status.
            </div>
        </div>
    </div>

    <?php if ($_SESSION['login'] != 'pipdiministrador') { ?>

        <div class="row">
            <div class="column">
                <div class="ui horizontal segments">

                    <div class="ui segment center aligned ">
                        <i class='disabled big gray hourglass half icon'></i>Pendente de Análise: Seu anúncio ainda será analisado pela Administração do PIP Online 
                    </div>

                    <div class="ui segment center aligned ">
                        <i class='big blue hourglass half icon'></i>Em Análise: Seu anúncio está em análise pela Administração do PIP Online e, em breve, pode estar disponível para ser visualizado
                    </div>
                </div>           
            </div>
        </div>

    <?php } else { ?>

        <div class="row">
            <div class="column">
                <div class="ui horizontal segments">

                    <div class="ui segment center aligned ">
                        <i class='disabled big gray hourglass half icon'></i>Pendente de Análise: Anúncio ainda não está em análise
                    </div>

                    <div class="ui segment center aligned ">
                        <i class='big blue hourglass half icon'></i>Em Análise: Anúncio sendo avaliado pela Administração
                    </div>
                </div>           
            </div>
        </div>

    <?php } ?>

</div>

<div class="ui hidden divider"></div>

<?php
Sessao::gerarToken();

$item = $this->getItem();

$totalAnunciosCadastrados = count($item["listaAnuncio"]);

if ($totalAnunciosCadastrados < 1) {
    ?>

    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <div class="ui warning message">
                    <i class="big yellow warning circle icon"></i>
                    Você não possui anúncios pendentes de aprovação. Clique em voltar para retornar ao MEUPIP
                </div>

                <div class="row">
                    <a href="index.php?entidade=Usuario&acao=meuPIP">
                        <button class="ui orange button">Voltar</button>
                    </a>
                </div> 
            </div>   
        </div>
    </div>    

<?php } else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable?>
    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <table class="ui red stackable table" id="tabela">

                    <thead>
                        <tr>
                            <th>Cód. Anúncio</th>
                            <th>Tipo</th>
                            <th>Título do Anúncio</th>
                            <th>Finalidade</th>
                            <th>Valor</th>
                            <th>Data de Cadastro</th>
                            <?php
                            if ($_SESSION['login'] === 'pipdiministrador') {
                                echo "<th>Status</th>";
                            }
                            ?>
                            <th><?php
                            if ($_SESSION['login'] != 'pipdiministrador') {
                                echo "Status";
                            } else
                                echo "Opções";
                            ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($item) {
                            foreach ($item["listaAnuncio"] as $anuncio) {

                                switch ($anuncio->getImovel()->getIdTipoImovel()) {

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
                                ?>
                                <tr>
                                    <td>                          

                                        <form id="form<?php echo $anuncio->getId() ?>" action="index.php" method="post" target='_blank'>
                                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="AnuncioAprovacao" />
                                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalharPendente"/>
                                            <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio->getId() ?>"/>
                                            <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>                                                                               

                                            <button class="ui labeled icon button">
                                                <i class="zoom icon"></i>
                                        <?php echo $anuncio->getIdAnuncio(); ?>
                                            </button>
                                            <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $anuncio->getIdAnuncio() ?>" />
                                        </form>     
                                    </td>
                                    <td><?php
                                        switch ($anuncio->getImovel()->getIdTipoImovel()) {

                                            case 1: echo "Casa";
                                                break;
                                            case 2: echo "Apartamento na Planta";
                                                break;
                                            case 3: echo "Apartamento";
                                                break;
                                            case 4: echo "Sala Comercial";
                                                break;
                                            case 5: echo "Prédio Comercial";
                                                break;
                                            case 6: echo "Terreno";
                                                break;
                                        }
                                        ?></td>
                                    <td><?php echo $anuncio->getTituloanuncio(); ?></td>
                                    <td><?php echo $anuncio->getFinalidade(); ?></td>
                                    <td id="tdValor<?php echo $anuncio->getId(); ?>">
            <?php
            echo $anuncio->getValorMin();
            ?>

                                    </td>

                                    <td> <?php echo date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro())); ?> </td>

                                    <?php
                                    if ($_SESSION['login'] == 'pipdiministrador') {
                                        echo "<td> ";
                                        if ($anuncio->getStatus() == "pendenteanalise") {
                                            echo "<i class='disabled big gray hourglass half icon'></i>Pendente de Análise";
                                        } else if ($anuncio->getStatus() == "emanalise") {
                                            echo "<i class='big blue hourglass half icon'></i>Em Análise";
                                        } else if ($anuncio->getStatus() == "aprovacaonegada") {
                                            echo "<i class='big red thumbs down icon'></i>Aprovação Negada";
                                        }
                                        "</td>";
                                    }
                                    ?>        

                                    <td> <?php
                                        if ($_SESSION['login'] != 'pipdiministrador') {
                                            if ($anuncio->getStatus() == "pendenteanalise") {
                                                echo "<i class='disabled big gray hourglass half icon'></i>Pendente de Análise";
                                            } else if ($anuncio->getStatus() == "emanalise") {
                                                echo "<i class='big blue hourglass half icon'></i>Em Análise";
                                            } else if ($anuncio->getStatus() == "aprovacaonegada") {
                                                echo "<i class='big red thumbs down icon'></i>Aprovação Negada";
                                            }
                                        } else {
                                            echo "<a id='btnMudarStatus" . $anuncio->getId() . "' class='ui circular inverted icon button'><i class='big teal edit icon'></i></a>Alterar Status";
                                        }
                                        ?> </td>

                                </tr>

            <?php
        }
    }
    ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="ui hidden divider"></div>

    <?php
    if ($item) {
        foreach ($item["listaAnuncio"] as $anuncio) {
            ?>

            <script>
                formatarValor(<?php echo $anuncio->getId() ?>);
                alterarStatusAnuncio(<?php echo $anuncio->getId() ?>)
            </script>

            <!-- MODAL DA EDIÇÃO DO STATUS DO ANÚNCIO-->

            <div class="ui standart modal" id="modalMudarStatus<?php echo $anuncio->getId() ?>">
                <div class="header">
                    Alterar Status do Anúncio <?php echo $anuncio->getIdAnuncio() ?>
                </div>
                
                        <div class="row">
            <div class="column">
                <div class="ui horizontal segments">
                    <div class="ui segment center aligned ">
                        <i class='big blue hourglass half icon'></i>Em Análise: informar qe o anúncio está sendo analisado
                    </div>

                    <div class="ui segment center aligned ">
                        <i class='big green thumbs up icon'></i>Aprovado: Anúncio aprovado e disponibilizado no sistema
                    </div>


                    <div class="ui segment center aligned ">
                        <i class='big red thumbs down icon'></i>Aprovação Negada: Anúncio não foi aprovado, o plano comprado pelo usuário será reativado
                    </div>

                </div>           
            </div>
        </div>
                
                
                <div class="content" id="camposAlterarStatus<?php echo $anuncio->getId() ?>">

                    <form class="ui form" id="formAlterarStatusAnuncio<?php echo $anuncio->getId() ?>" action="index.php" method="post">
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="AnuncioAprovacao"  />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="alterarStatus" />  
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                        <input type="hidden" id="hdnAnuncio" name="hdnAnuncio" value="<?php echo $anuncio->getId() ?>" />
                        <input type="hidden" id="hdnStatusAtual<?php echo $anuncio->getId() ?>" name="hdnStatusAtual" value="<?php echo $anuncio->getStatus() ?>"/>    
                        <input type="hidden" id="hdnMsgEmailEmAnalise" name="hdnMsgEmailEmAnalise" value="Seu anúncio <?php echo $anuncio->getIdAnuncio() ?> está em análise pela equipe do PIP Online e em alguns momentos pode ser aprovado."/>
                        <input type="hidden" id="hdnMsgEmailAprovado" name="hdnMsgEmailAprovado" value="Parabéns! Seu anúncio <?php echo $anuncio->getIdAnuncio() ?> foi aprovado. Clique no link abaixo para visualizá-lo e obrigado por anunciar no PIP Online."/>
                        <input type="hidden" id="hdnMsgEmailAprovacaoNegada" name="hdnMsgEmailAprovacaoNegada" value="Atenção! A aprovação do anúncio <?php echo $anuncio->getIdAnuncio() ?> foi negada. O plano utilizado estará disponivel novamente em alguns miinutos."/>
                        <input type="hidden" id="hdnEnviadoPor" name="hdnEnviadoPor" value=""/>
                        <input type="hidden" id="hdnUsuario" name="hdnUsuario" value="<?php echo $anuncio->getImovel()->getIdUsuario() ?>"/>
                        <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>
                        <input type="hidden" id="hdnEmailAssunto" name="hdnEmailAssunto" value="Alteração Status - PIP OnLine"/>

                        <div class="four wide required field" id="listaStatus<?php echo $anuncio->getId() ?>">
                            <label>Alterar Status</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltStatusAnuncio" id="sltStatusAnuncio<?php echo $anuncio->getId() ?>">
                                <div class="text">Novo Status do Anúncio</div>
                                <i class="dropdown icon" id="dropDown<?php echo $anuncio->getId() ?>"></i>
                                <div class="menu">
                                    <div class="item" data-value="emanalise">Em Análise</div>
                                    <div class="item" data-value="aprovado">Aprovado</div>
                                    <div class="item" data-value="aprovacaonegada">Aprovação Negada</div>
                                </div>
                            </div>
                        </div>          

                    </form>

                </div>

                <div id="divRetornoNovoStatus<?php echo $anuncio->getId(); ?>"></div>

                <div class="actions">
                    <div  id="botaoCancelaAlterarStatus<?php echo $anuncio->getId(); ?>" class="ui orange deny button">
                        Cancelar
                    </div>
                    <div  id="botaoAlterarStatus<?php echo $anuncio->getId(); ?>" class="ui positive right labeled icon button">
                        Alterar
                        <i class="checkmark icon"></i>
                    </div>
                    <div  id="botaoFecharStatus<?php echo $anuncio->getId(); ?>" class="ui red deny button">
                        Fechar
                    </div>
                </div>
            </div>

            <?php
        }
    }
    ?>

<?php } //fim do else, caso haja anuncios ativos  ?> 

