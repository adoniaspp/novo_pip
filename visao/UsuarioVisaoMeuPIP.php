<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('.ui.accordion').accordion();

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true
        });

    })
</script>
<style>
    .spaced > .button {
        margin-bottom: 1em;
    }
</style>
<?php
$item = $this->getItem();
?>

<!-- HTML -->
<div class="ui column doubling grid container">
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
    <div class="row">
        <a href="index.php?entidade=Usuario&acao=selecionar"  class="spaced">
            <div type="button"  class="ui blue button">
                <i class="edit icon"></i> Atualizar Cadastro
            </div>
        </a>
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha"  class="spaced"> 
            <div type="button"  class="ui blue button">
                <i class="lock icon"></i> Alterar Senha 
            </div>
        </a> 
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarimagem" class="spaced">         
            <div type="button" class="ui blue button">
                <i class="file image outline icon"></i>  Alterar <?php echo ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca"); ?>
            </div>
        </a>
    </div>
</div> 

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="home icon"></i>
            <div class="content">
                Meus Imóveis
                <div class="sub header">Gerencie seus imóveis (casas, apartamentos, kit-net, salas comerciais, terrenos) </div>
            </div>
        </h2>
    </div>
    <div class="row">
        <a href="index.php?entidade=Imovel&acao=form" class="spaced">
            <div type="button"  class="ui green button">
                <i class="add icon"></i> Cadastrar Imóvel
            </div>
        </a>         
        <?php
        if ($item) {
            if ($item['imovel']) {
                ?>

                <a href="index.php?entidade=Imovel&acao=listarEditar" class="spaced">
                    <div type="button"  class="ui green button">
                        <i class="edit icon"></i> Alterar Imóvel
                    </div></a> 
                <a href="index.php?entidade=Imovel&acao=listarDados" class="spaced">
                    <div type="button" class="ui green button">
                        <i class="list icon"></i> Visualizar Meus Imóveis
                    </div></a> 
                <?php
            }
        }
        ?> 
    </div>
</div> 

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="announcement icon"></i>
            <div class="content">
                Meus Anúncios
                <div class="sub header">Gerencie seus anúncios. Você pode cadastar, visualizar, reativar ou ler suas mensagens </div>
            </div>
        </h2>
    </div>
    <div class="row">
        <?php
        if ($item) {
            if ($item['imovel']) {
                ?>
                <a href="index.php?entidade=Anuncio&acao=listarCadastrar" class="spaced">
                    <div type="button"  class="ui brown button">
                        <i class="add icon"></i> Publicar Anúncio
                    </div></a>         

                <!--                                            <button type="button"  class="ui purple button">
                                                                <i class="edit icon"></i> Editar Anúncio
                                                            </button>-->
                <?php if ($item['anuncio']) { ?>
                    <a href="index.php?entidade=Anuncio&acao=listarReativar" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="refresh icon"></i>  Reativar Anúncios (aluguel)
                        </div></a>
                    <a href="index.php?entidade=Anuncio&acao=listarAtivo" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="list icon"></i> Visualizar Anúncios Ativos
                        </div></a> 
                    <a href="index.php?entidade=Anuncio&acao=listarFinalizado" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="thumbs outline up icon"></i>  Visualizar Anúncios Finalizados
                        </div></a>
                    <a href="index.php?entidade=Usuario&acao=listarMensagem" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="mail outline icon"></i>  Visualizar Mensagens
                        </div></a>
                <?php } ?>
                <?php
            } else {
                echo '<h4 class="ui red header">Cadastre primeiro um imóvel.</h4>';
            }
        }
        ?>
    </div>
</div> 

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
    <div class="row">
        <a href="index.php?entidade=UsuarioPlano&acao=listar" class="spaced">
            <div type="button"  class="ui orange button">
                <i class="add icon"></i> Comprar
            </div>
        </a>         
    </div>
    <div class="row">
        <?php
        if ($item) {
            if (!$item["usuarioPlano"]) {
                ?>
                <h4 class="ui orange header">  Poxa, infelizmente você ainda não tem plano. Não perca tempo e Compre Agora! </h4>
                <br/> <img class="ui centered image" src="http://www.prospeccao-de-clientes.com/images/gudrum-pagseguro.gif" /> 
                <?php
            } else {
                ?> 

                <table class="ui orange stackable table" id="tabela">
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
                            echo "<td>" . $usuarioPlano->getDataCompra() . "</td>";
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
    <div class="row">
        <div type="button"  class="ui pink button">
            <i class="comment outline icon"></i> Fale Conosco
        </div>
        <div type="button" class="ui pink button">
            <i class="book icon"></i> Dúvidas Mais Frequentes
        </div>
    </div>
</div> 

<div class="ui hidden divider"></div>