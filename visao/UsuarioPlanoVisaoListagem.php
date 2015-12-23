<link href="assets/libs/touchspin/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
<script src="assets/libs/touchspin/jquery.bootstrap-touchspin.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/js/plano.js"></script>
<script>
    listagemPlano();
</script>
<?php
Sessao::gerarToken();
?>
<div class="ui column doubling grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <div class="active section"><i class="shop small icon"></i>Comprar Planos</div>
            </div>
        </div>
    </div>
</div>

<div class="ui middle aligned stackable grid container">
    <div class="row">        
        <div class="column">        
            <form id="form" class="ui form" action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="UsuarioPlano" />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="confirmar" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Comprar Planos</h3>
                <table class="ui compact celled orange table">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Descrição</th>
                            <th width="15%">Ativar em até:</th>
                            <th width="15%">Quantidade</th>
                            <th width="15%">Preço (R$)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="active">
                            <td colspan="3"><h4 class="ui header aligned right">Total:</h4></td>
                            <td><input readonly class="ui input" id="txtTotalQtd" name="txtTotalQtd"/></td>
                            <td><input readonly class="ui input" id="txtTotalPreco" name="txtTotalPreco" /></td>
                        </tr>
                        <tr class="">
                            <td colspan="4"><h4 class="ui header aligned right"></h4></td>
                            <td> <button class="ui orange button" id="btnComprar"><i class="shop icon"></i> Comprar!</button></td>
                        </tr>
                    </tfoot>                    
                    <tbody>                       
                        <?php
                        $item = $this->getItem();
                        if ($item) {
                            foreach ($item["plano"] as $plano) {
                                echo "<tr>";
                                echo "<td>" . $plano->getTitulo() . "</td>";
                                echo "<td>" . $plano->getDescricao() . "</td>";
                                echo "<td>" . $plano->getValidadeativacao() . " dias</td>";
                                echo "<td><input class='ui input' id='spnPlano[" . $plano->getId() . "]' type='text' value='0' name='spnPlano[" . $plano->getId() . "]'></td>";
                                echo "<td><input readonly class='ui input' id='Plano[" . $plano->getId() . "]' type='text' value='" . $plano->getPreco() . "' name='txtPreco[" . $plano->getId() . "]'></td>";
                                echo "</tr>";
                            }
                        }
                        ?>  
                    </tbody>
                </table> 
        </div>
    </div>
    <div class="row">
        <div class="column">
            <img class="ui fluid rounded image centered" alt='Logotipos de meios de pagamento do PagSeguro' src='https://p.simg.uol.com.br/out/pagseguro/i/banners/pagamento/todos_estatico_550_100.gif' title='Este site aceita pagamentos com Visa, MasterCard, Diners, American Express, Hipercard, Aura, Elo, PLENOCard, PersonalCard, BrasilCard, FORTBRASIL, Cabal, Mais!, Avista, Grandcard, Bradesco, Itaú, Banco do Brasil, Banrisul, Banco HSBC, saldo em conta PagSeguro e boleto.' border='0'>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <h3 class="ui dividing header">Meus Planos Comprados</h3>
            <?php
            $item = $this->getItem();
            if ($item) {
                if (!$item["usuarioPlano"]) {
                    ?>
                    <h4 class="ui red header"> Poxa, infelizmente você ainda não tem plano. Não perca tempo e Compre Agora! </h4> 
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
            </form>
        </div>
    </div>
</div>
<div class="ui hidden divider"></div>