<script src="assets/js/bootstrap-touchspin.js"></script>
<script>
    $(document).ready(function() {
        $("input[name^='spnPlano']").TouchSpin().change(
                function() {
                    $("#txtTotal").val(Total());
                });
        $("#btnComprar").click(function() {
            var plano = 0;
            $("input[name^='spnPlano']").each(function() {
                plano += ($(this).val() != "") ? parseInt($(this).val()) : 0;
            });

            if (parseInt(plano) > 0) {
                $("#form").submit();
            } else {
                return false;
            }
        })
    })

    function Total() {
        var soma = 0;
        $("input[name^='txtPreco']").each(function() {
            var plano = 'spn' + $(this).attr('id');
            soma += parseFloat($(this).val()) * parseFloat($("input[name='" + plano + "']").val());
        })
        //var num = new Number(soma);
//return num.toPrecision();
        return soma.toFixed(2);
    }

</script>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <li class="active">Comprar Planos</li>
    </ol>
    <!-- Primeira Linha -->        
    <div class="row">
        <div class="col-lg-6">
            <div id="forms" class="panel panel-default">
                <div class="panel-heading">Meus Planos</div>		
                <?php
                $item = $this->getItem();
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
        </div>
        <div class="col-lg-6">
            <div id="forms" class="panel panel-default">
                <div class="panel-heading">Comprar</div>
                <!-- form -->
                <form id="form" class="form-horizontal" method="POST" action="index.php">
                    <table class="table table-bordered table-condensed table-hover table-responsive">
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
                                <td colspan="2" class="text-right"><strong>Total:</strong></td>
                                <td><input readonly class="form-control" id="txtTotal" name="txtTotal" /></td>
                            </tr>
                        </tfoot>                    
                        <tbody>                        

                            <?php
                            Sessao::gerarToken();
                            if ($item) {
                                foreach ($item["plano"] as $plano) {
                                    echo "<tr>";
                                    echo "<td>" . $plano->getTitulo() . "</td>";
                                    echo "<td>" . $plano->getDescricao() . "</td>";
                                    echo "<td><input id='spnPlano[" . $plano->getId() . "]' type='text' value='0' name='spnPlano[" . $plano->getId() . "]'></td>";
                                    echo "<td><input readonly class='form-control' id='Plano[" . $plano->getId() . "]' type='text' value='" . $plano->getPreco() . "' name='txtPreco[" . $plano->getId() . "]'></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>  

                        </tbody>
                    </table>                    

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-6">
                                    <button type="button" id="btnComprar" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Comprar!</button>
                                    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="UsuarioPlano" />
                                    <input type="hidden" id="hdnAcao" name="hdnAcao" value="confirmar" />
                                    <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                                </div>
                            </div>                
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img alt='Logotipos de meios de pagamento do PagSeguro' src='https://p.simg.uol.com.br/out/pagseguro/i/banners/pagamento/todos_estatico_550_100.gif' title='Este site aceita pagamentos com Visa, MasterCard, Diners, American Express, Hipercard, Aura, Elo, PLENOCard, PersonalCard, BrasilCard, FORTBRASIL, Cabal, Mais!, Avista, Grandcard, Bradesco, Itaú, Banco do Brasil, Banrisul, Banco HSBC, saldo em conta PagSeguro e boleto.' border='0'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>