<?php
$item = $this->getItem();
?>
<!-- HTML -->
<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Meu PIP</a>
            </div>
        </div>
    </div>
    <div class="ui page grid">
        <div class="ui basic segment">
            <h2 class="ui header">
                <i class="user icon"></i>
                <div class="content">
                    Meus Dados
                    <div class="sub header">Gerencie sua conta no PIP</div>
                </div>
            </h2>
            <div class="four column row">
                <div class="column">
                    <a href="index.php?entidade=Usuario&acao=selecionar">
                        <button type="button"  class="ui blue button">

                            <i class="edit icon"></i> Atualizar Cadastro
                        </button></a>

                    <a href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha"> 
                        <button type="button"  class="ui blue button">

                            <i class="lock icon"></i> Alterar Senha 
                        </button></a> 

                    <a href="index.php?entidade=Usuario&acao=form&tipo=trocarimagem"> 
                        <button type="button" class="ui blue button">
                            <i class="file image outline icon"></i>  Alterar <?php echo ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca"); ?>
                        </button></a> 
                </div>
            </div> 
        </div>
        <div class="ui dividing header"></div>
        <div class="ui basic segment">
            <h2 class="ui header">
                <i class="home icon"></i>
                <div class="content">
                    Meus Imóveis
                    <div class="sub header">Gerencie seus imóveis (casas, apartamentos, kit-net, salas comerciais, terrenos) </div>
                </div>
            </h2>
            <div class="four column row">
                <div class="column">
                    <a href="index.php?entidade=Imovel&acao=form">
                        <button type="button"  class="ui green button">
                            <i class="add icon"></i> Cadastrar Imóvel
                        </button>
                    </a>         
                    <?php
                    if ($item) {
                        if ($item['imovel']) {
                            ?>

                            <a href="index.php?entidade=Imovel&acao=listarEditar">
                                <button type="button"  class="ui green button">
                                    <i class="edit icon"></i> Alterar Imóvel
                                </button></a> 
                            <a href="index.php?entidade=Imovel&acao=listar">
                                <button type="button" class="ui green button">
                                    <i class="list icon"></i> Visualizar Meus Imóveis
                                </button></a> 
                            <?php
                        }
                    }
                    ?>    
                    <button type="button" class="ui green button">
                        <i class="star icon"></i> Imóveis Favoritos
                    </button>
                </div>
            </div> 
        </div>
        <div class="ui dividing header"></div>
        <div class="ui basic segment">
            <h2 class="ui header">
                <i class="announcement icon"></i>
                <div class="content">
                    Meus Anúncios
                    <div class="sub header">Gerencie seus anúncios. Você pode cadastar, visualizar, reativar ou ler suas mensagens </div>
                </div>
            </h2>
            <div class="four column row">
                <div class="column">
                    <?php
                    if ($item) {
                        if ($item['imovel']) {
                            ?>
                            <a href="index.php?entidade=Anuncio&acao=listarCadastrar">
                                <button type="button"  class="ui purple button">
                                    <i class="add icon"></i> Publicar Anúncio
                                </button></a>         

                            <button type="button"  class="ui purple button">
                                <i class="edit icon"></i> Editar Anúncio
                            </button>
                            <?php if ($item['anuncio']) { ?>
                                <a href="index.php?entidade=Anuncio&acao=listarReativar">
                                    <button type="button" class="ui purple button">
                                        <i class="refresh icon"></i>  Reativar Anúncios (aluguel)
                                    </button></a>
                                <div class="ui hidden divider"></div>
                                <a href="index.php?entidade=Anuncio&acao=listarAtivo">
                                    <button type="button" class="ui purple button">
                                        <i class="list icon"></i> Visualizar Anúncios Ativos
                                    </button></a> 
                                <a href="index.php?entidade=Anuncio&acao=listarFinalizado">
                                    <button type="button" class="ui purple button">
                                        <i class="thumbs outline up icon"></i>  Visualizar Anúncios Finalizados
                                    </button></a>
                                <a href="index.php?entidade=Usuario&acao=listarMensagem">
                                    <button type="button" class="ui purple button">
                                        <i class="mail outline icon"></i>  Visualizar Mensagens
                                    </button></a>
                            <?php } ?>
                            <?php
                        } else {
                            echo '<h4 class="ui red header">Cadastre primeiro um imóvel.</h4>';
                        }
                    }
                    ?>
                </div>
            </div> 
        </div>
        <div class="ui dividing header"></div>
        <div class="ui basic segment">
            <h2 class="ui header">
                <i class="shop icon"></i>
                <div class="content">
                    Meus Planos
                    <div class="sub header">Gerencie seus planos </div>
                </div>
            </h2>
            <div class="four column row">
                <div class="column">
                    <a href="index.php?entidade=UsuarioPlano&acao=listar">
                        <button type="button"  class="ui orange button">
                            <i class="add icon"></i> Comprar
                        </button></a>         
                    <?php
                    if ($item) {
                        if (!$item["usuarioPlano"]) {
                            ?>
                            <h4 class="ui orange header">  Poxa, infelizmente você ainda não tem plano. Não perca tempo e Compre Agora! </h4>
                            <br/> <img class="ui centered image" src="http://www.prospeccao-de-clientes.com/images/gudrum-pagseguro.gif" /> 
                            <?php
                        } else {
                            ?>
                            <table class="ui compact celled blue table">
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
            </div> 
        </div>
        <div class="ui dividing header"></div>
        <div class="ui basic segment">
            <h2 class="ui header">
                <i class="info circle icon"></i>
                <div class="content">
                    Ajuda
                    <div class="sub header">Precisa de ajuda? </div>
                </div>
            </h2>
            <div class="four column row">
                <div class="column">
                    <button type="button"  class="ui pink button">
                        <i class="comment outline icon"></i> Fale Conosco
                    </button>
                    <button type="button" class="ui pink button">
                        <i class="book icon"></i> Dúvidas Mais Frequentes
                    </button>
                </div>
            </div> 
        </div>
    </div>
    <div class="ui dividing header"></div>
</div>