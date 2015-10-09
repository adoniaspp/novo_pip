<?php
$item = $this->getItem();
Sessao::gerarToken();
?>
<script>
    $(document).ready(function () {
        $("#btnCancelar").click(function () {
            window.history.back();
        })
    })
</script>
<!-- HTML -->
<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="section" href="index.php?entidade=UsuarioPlano&acao=listar">Comprar Planos</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Confirmação de Compra</a>
            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <form id="form" class="ui form" action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="UsuarioPlano" />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="comprar" />
                <input type="hidden" id="hdnPlano" name="hdnPlano" value="<?php echo $item["confirmacao"]["tokenPlano"]; ?>" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <h3 class="ui dividing header">Você está Comprando:</h3>
                <table class="ui compact celled orange table">
                    <colgroup>
                        <col class="col-xs-3">
                        <col class="col-xs-4">
                        <col class="col-xs-2">
                        <col class="col-xs-2">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Preço (R$)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right"><h4 class="ui header aligned right">Total:</h4></th>
                    <th><?php echo $item["confirmacao"]["totalQtd"]; ?></th>
                    <th><?php echo "R$ " . $item["confirmacao"]["total"]; ?></th>
                    </tr>
                    </tfoot>                    
                    <tbody>                        

                        <?php
                        if ($item["planosSelecionados"]) {
                            foreach ($item["planosSelecionados"] as $plano) {
                                echo "<tr>";
                                echo "<td>" . $plano["titulo"] . "</td>";
                                echo "<td>" . $plano["descricao"] . "</td>";
                                echo "<td>" . $item["confirmacao"]["planos"][$plano["id"]] . "</td>";
                                echo "<td> R$ " . $plano["preco"] . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>  

                    </tbody>
                </table>
                <button class="ui green button" type="button" type="submit" >Confirmar</button>
                <button class="ui red button" id="btnCancelar">Cancelar</button>
            </form>
            <div class="ui hidden divider"></div>
        </div>
    </div>
</div>