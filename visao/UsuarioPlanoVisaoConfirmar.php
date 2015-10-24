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
<div class="ui column doubling grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i>
                <a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <i class="shop small icon"></i>
                <a class="section" href="index.php?entidade=UsuarioPlano&acao=listar">Comprar Planos</a>
                <i class="right chevron icon divider"></i>
                <div class="active section"><i class="payment small icon"></i>Confirmação de Compra</div>
            </div>
        </div>
    </div>
</div>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <h3 class="ui dividing header">Você está Comprando:</h3>
            <table class="ui stackable celled orange table">
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
                    <tr class="active">
                        <td colspan="2" class="text-right"><h4 class="ui header aligned right">Total:</h4></td>
                        <td><?php echo $item["confirmacao"]["totalQtd"]; ?></td>
                        <td><?php echo "R$ " . $item["confirmacao"]["total"]; ?></td>
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
            <form id="form" class="ui form" action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="UsuarioPlano" />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="comprar" />
                <input type="hidden" id="hdnPlano" name="hdnPlano" value="<?php echo $item["confirmacao"]["tokenPlano"]; ?>" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <button class="ui green button">Confirmar</button>
                <button class="ui orange button" id="btnCancelar">Cancelar</button>
            </form>
        </div>
    </div>
</div>
<div class="ui hidden divider"></div>