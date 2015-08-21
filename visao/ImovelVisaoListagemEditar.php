<!-- INICIO DO MAPA --> 
<script src="assets/js/imovel.js"></script>
<script src="assets/js/usuario.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>
<script src="assets/js/mask.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>

<div class="ui column doubling grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <div class="active section"><i class="home small icon"></i>Imóveis Cadastrados</div>
            </div>
        </div>
    </div>
</div>

        <table class="ui green stackable table" id="tabela">
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
                            $descricao = $imovel->getIdentificacao();
                        }

                        echo "<td>" . $descricao . "</td>";

                        echo "<td>" . $imovel->getDatahoracadastro() . "</td>";

                        echo "<td> <a href='#' class='ui green button' id='detalhes" . $imovel->getId() . "' ><i class='ui home icon'></i>Detalhes</a>";

                        if (count($imovel->getAnuncio()) > 0 && verificaAnuncioAtivo($imovel->getAnuncio())) {
                            echo '<div class="ui compact positive message"><i class="large icons"><i class="announcement  icon"></i><i class="corner checkmark icon"></i></i> Anúncio Ativo</div>';
                        } else {
                            echo "<a href=index.php?entidade=Imovel&acao=selecionar&id=" . $imovel->getId() . '&token=' . $_SESSION['token'] . "  id='editar" . $imovel->getId() . "' class='ui teal button'><i class='ui edit icon'></i>Editar</a>";
                            if (count($imovel->getAnuncio()) > 0) {
                                echo"<div class='ui compact message'>Imóvel possui anúncio. Não é possível excluir</div>";
                            } else {
                                echo "<a href=index.php?entidade=Imovel&acao=excluir&id=" . $imovel->getId() . '&token=' . $_SESSION['token'] . " id='excluir" . $imovel->getId() . "' class='ui red button'><i class='ui trash icon'></i>Excluir</a>";
                            }
                        }

                        echo "</td>";
                    }
                    ?>                    
                </tr>         
            </tbody>
        </table>
   
</div>
<div class="ui hidden divider"></div>  

<?php
include_once "/modal/ImovelListagemModal.php";

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
        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "columnDefs": [
                {"orderable": false, "targets": 3}
            ]
        });
    })
</script>