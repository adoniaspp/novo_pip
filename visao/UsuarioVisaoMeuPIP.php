<?php
$item = $this->getItem();
?>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li class="active">Meu PIP</li>
    </ol>
    <div class="row">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Dados</h3>
            </div>
            <div class="panel-body">
                <a href="index.php?entidade=Usuario&acao=selecionar">
                    <button type="button" class="btn btn-primary">
                        <span class="glyphicon glyphicon-user"></span> 
                        <span class="glyphicon glyphicon-pencil"></span> Atualizar Cadastro
                    </button></a>
                <a href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha"> 
                    <button type="button" class="btn btn-primary">
                        <span class="glyphicon glyphicon-user"></span> 
                        <span class="glyphicon glyphicon-lock"></span> Alterar Senha 
                    </button></a>    
                <a href="index.php?entidade=Usuario&acao=form&tipo=trocarimagem"> 
                    <button type="button" class="btn btn-primary">
                        <span class="glyphicon glyphicon-user"></span> 
                        <span class="glyphicon glyphicon-picture"></span> Alterar <?php echo ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca"); ?>
                    </button></a>    
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Imóveis</h3>
            </div>
            <div class="panel-body">
                <a href="index.php?entidade=Imovel&acao=form">
                    <button type="button" class="btn btn-success">
                        <span class="glyphicon glyphicon-home"></span>
                        <span class="glyphicon glyphicon-plus"></span> Cadastrar Imóvel
                    </button></a>
                <?php
                if ($item) {
                    if ($item['imovel']) {
                        ?>
                        <a href="index.php?entidade=Imovel&acao=listarEditar">
                            <button type="button" class="btn btn-success">
                                <span class="glyphicon glyphicon-home"></span>
                                <span class="glyphicon glyphicon-pencil"></span> Alterar Imóvel
                            </button></a>
                        <a href="index.php?entidade=Imovel&acao=listar">
                            <button type="button" class="btn btn-success">
                                <span class="glyphicon glyphicon-home"></span> 
                                <span class="glyphicon glyphicon-list-alt"></span> Visualizar Meus Imóveis
                            </button></a>
                    <?php }
                }
                ?>                
                <!--
                <button type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-home"></span> 
                    <span class="glyphicon glyphicon-star-empty"></span> Imóveis Favoritos
                </button>
                -->
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Anúncios</h3>
            </div>
            <div class="panel-body">
                <?php
                if ($item) {
                    if ($item['imovel']) {
                        ?>

                        <a href="index.php?entidade=Anuncio&acao=listarCadastrar">
                            <button type="button" class="btn btn-info">
                                <span class="glyphicon glyphicon-bullhorn"></span> 
                                <span class="glyphicon glyphicon-plus"></span> Publicar Anúncio
                            </button></a>
                        <!-- <button type="button" class="btn btn-info">
                             <span class="glyphicon glyphicon-bullhorn"></span> 
                             <span class="glyphicon glyphicon-pencil"></span> Editar Anúncio
                             </button> -->
        <?php if ($item['anuncio']) { ?>
                            <a href="index.php?entidade=Anuncio&acao=listarAtivo">
                                <button type="button" class="btn btn-info">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-list-alt"></span> Visualizar Anúncios Ativos
                                </button></a>
                            <a href="index.php?entidade=Anuncio&acao=listarFinalizado">
                                <button type="button" class="btn btn-info">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-thumbs-up"></span> Visualizar Anúncios Finalizados
                                </button></a>
                            <a href="index.php?entidade=Anuncio&acao=listarReativar">
                                <button type="button" class="btn btn-info">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-refresh"></span> Reativar Anúncios (aluguel)
                                </button></a>
                            <a href="index.php?entidade=Usuario&acao=listarMensagem">
                                <button type="button" class="btn btn-info">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-envelope"></span> Visualizar Mensagens
                                </button></a>

                        <?php } ?>
                        <?php
                    } else {
                        echo '<span class="text-info"><strong>Cadastre primeiro um imóvel.</strong></span>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Planos</h3>
            </div>
            <div class="panel-body">
                <a href="index.php?entidade=UsuarioPlano&acao=listar">
                    <button type="button" class="btn btn-warning">
                        <span class="glyphicon glyphicon-shopping-cart"></span> Comprar
                    </button></a>
            </div>
            <?php
            if ($item) {
                if (!$item["usuarioPlano"]) {
                    ?>
                    <span class="text-danger"><strong>Poxa, infelizmente você ainda não tem plano. Não perca tempo e Compre Agora! </strong> 
                        <br/> <img src="http://www.prospeccao-de-clientes.com/images/gudrum-pagseguro.gif" width="100%"/> 
                    </span>
        <?php
    } else {
        ?>
                    <table class="table table-bordered table-condensed table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Plano</th>
                                <th>Descrição</th>
                                <th>Data de Compra</th>
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
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Precisa de ajuda?</h3>
            </div>
            <div class="panel-body">
                <button type="button" class="btn btn-danger">
                    <span class="glyphicon glyphicon-envelope"></span> Fale Conosco
                </button>
                <button type="button" class="btn btn-danger">
                    <span class="glyphicon glyphicon-info-sign"></span> Dúvidas Mais Frequentes
                </button>
            </div>
        </div>

    </div>

</div>