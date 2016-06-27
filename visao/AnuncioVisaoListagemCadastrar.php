<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>

<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {
        
        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );
        
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

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"><i class="announcement small icon"></i>Publicar Anúncios</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Escolha um imóvel cadastrado para publicar seu anúncio ou clique em "Detalhes" para ver detalhes do imóvel</p>
            </div>
        </div>
    </div>

    <?php
    
    $item = $this->getItem();

    if($item == null){
    
    ?>    
        
    
            <div class="row">
                <div class="column">
                    <div class="ui warning message">
                        <div class="header">Atenção</div>
                        <ul class="list">
                          Você não possui imóveis cadastrados ou eles já estão com anúncios ativo. Clique em voltar para retornar ao MEUPIP
                        </ul>
                    </div>

                    <div class="row">
                    <a href="index.php?entidade=Usuario&acao=meuPIP">
                    <button class="ui orange button">Voltar</button>
                    </a>
                    </div>

                </div>   
            </div>
       
    
    <?php
    echo "</div>"; } else { //caso haja algum imóvel sem anúncio ativo
    ?>
    
    <div class="row">
        <div class="column">
            <table class="ui brown stackable table" id="tabela">
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
                            echo "<td>" . date('d/m/Y H:i:s', strtotime($imovel->getDatahoracadastro())) . "</td>";
                            echo "<td><a href='#' class='ui green button' id='detalhes" . $imovel->getId() . "' ><i class='ui home icon'></i>Detalhes</div>";
                            if (count($imovel->getAnuncio()) > 0 && verificaAnuncioAtivo($imovel->getAnuncio())) {
                                echo '<div class="ui compact positive message"><i class="large icons"><i class="announcement  icon"></i><i class="corner checkmark icon"></i></i> Anúncio Ativo</div>';
                            } else {
                                echo"<a href='index.php?entidade=Anuncio&acao=form&idImovel=" . $imovel->getId() . "&token=" . $_SESSION['token'] . "' class='btn btn-info'><div class='ui brown button'><i class='announcement  icon'></i>Publicar Anúncio</div></a>";
                            }
                            echo "</td>";
                        }
                        ?>                                       
                    </tr>         
                </tbody>
            </table>
        </div>
    </div>
    
</div>

<div class="ui hidden divider"></div>  



<?php

} //fim do else, caso exista algum imóvel a ser publicado

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