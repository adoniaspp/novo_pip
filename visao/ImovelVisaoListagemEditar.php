<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>

<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"><i class="list small icon"></i>Imóveis Cadastrados</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Escolha um imóvel para edição. <strong>ATENÇÃO</strong>: Imóvel com anúncio ativo 
                    não pode ser editado, nem excluído (exclua o anúncio expirado ou finalizado para fazer a edição do imóvel)</p>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="column">
            <table class="ui green stackable table" id="tabela">&nbsp;
                <thead>
                    <tr>
                        <th class="three wide">Tipo</th>
                        <th class="five wide">Descrição</th>
                        <th class="three wide">Data Cadastro</th>
                        <th class="five wide">Operações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    Sessao::gerarToken();
                    foreach ($this->getItem() as $imovel) {
                        ?>
                        <tr>        
                            <?php
                            echo $imovel->buscarTipoImovel($imovel->getIdTipoImovel());

                            if (trim($imovel->getIdentificacao()) == "") {
                                $descricao = "<h4 class='ui red header'>Não Informado</h4>";
                            } else {
                                $descricao = nl2br($imovel->getIdentificacao()); //função nl2br usada para formatar o texto cadastrado na textarea
                            }

                            echo "<td>" . $descricao . "</td>";

                            echo "<td>" . date('d/m/Y H:i:s', strtotime($imovel->getDatahoracadastro())) . "</td>";

                            echo "<td> <a href='#' class='ui circular inverted zoom icon button' id='detalhes" . $imovel->getId() . "' ><i class='big green zoom icon'></i></a>Detalhes";

                            if (count($imovel->getAnuncio()) > 0) {
                                if (verificaAnuncioAtivo($imovel->getAnuncio())) {
                                    $mensagemAnuncio = "&nbsp;&nbsp;<div class='ui small compact negative message'>Possui Anúncio</div> <i class='big green check circle outline icon'></i>";
                                } else {
                                    $mensagemAnuncio = "&nbsp;&nbsp;<div class='ui small compact negative message'>Possui Anúncio</div> <i class='big red remove circle outline icon'></i>";
                                }
                                echo $mensagemAnuncio;
                            } else {
                                echo "<a href=index.php?entidade=Imovel&acao=selecionar&id=" . $imovel->getId() . '&token=' . $_SESSION['token'] . "  id='editar" . $imovel->getId() . "' class='ui circular inverted icon button'><i class='big teal edit icon'></i></a>Editar";
                                echo "<a class='ui circular inverted icon button' onclick='formExcluirImovel(" . $imovel->getId() . ",\"" . $_SESSION['token'] . "\",\"" . $imovel->buscarTipoImovel($imovel->getIdTipoImovel()) . "\")'><i class='big red trash icon'></i></a>Excluir";
                            }

                            echo "</td>";
                        }
                        ?>                    
                    </tr>         
                </tbody>
            </table>
            <div class="row">

                <div class="column">

                    <div class="ui horizontal segments">

                        <div class="ui segment center aligned ">
                            <i class='big green check circle outline icon'></i> Imóvel com Anúncio <strong>Ativo</strong>
                        </div>

                        <div class="ui segment center aligned ">
                            <i class='big red remove circle outline icon'></i>Imóvel com Anúncio <strong>Inativo ou Expirado</strong>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="ui hidden divider"></div> 

<div class="ui first coupled modal">

    <div class="header">
        Confirmar Exclusão do Imóvel
    </div>
    <div class="image content">
        <div class="description"></div>
    </div>
    <div class="actions">
        <form id="form" action="index.php" method="POST">
            <input type="hidden" id="hdnImovel" name="hdnImovel" class="hdnImovel" value="" />
            <input type="hidden" id="hdnToken" name="hdnToken" class="hdnToken" value="" />
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" class="hdnEntidade" value="Imovel" />
            <input type="hidden" id="hdnAcao" name="hdnAcao" class="hdnAcao" value="excluir" />
        </form>
        <div class="ui orange button">Cancelar</div>
        <div class="ui green button" onclick="excluirImovel()">Excluir</div>
    </div>

</div>
<div class="ui small second coupled modal">
    <div class="header">
        Imóvel Excluído
    </div>
    <div class="content">
    </div>
    <div class="actions">
        <div class="ui ok button">
            <i class="checkmark icon"></i>
            Fechar
        </div>
    </div>
</div>

<?php
include_once "modal/ImovelListagemModal.php";

function verificaAnuncioAtivo($listaAnuncios) {
    $temAnuncioAtivo = false;
    if (count($listaAnuncios) > 1) {
        foreach ($listaAnuncios as $anuncio) {
            if ($anuncio->getStatus() == "cadastrado")
                $temAnuncioAtivo = true;
        }
    } else {
        if ($listaAnuncios->getStatus() == "cadastrado")
            $temAnuncioAtivo = true;
    }
    return $temAnuncioAtivo;
}
?>

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
            "order": [[2, "desc"]],
            "columnDefs": [
                {"orderable": false, "targets": 3}
            ]
        });

    })
</script>