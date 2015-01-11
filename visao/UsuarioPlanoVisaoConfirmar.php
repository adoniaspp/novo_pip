<?php
$item = $this->getItem();
Sessao::gerarToken();

//echo "<pre>";print_r($item["confirmacao"]); die();
?>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <li><a href="index.php?entidade=UsuarioPlano&acao=listar">Comprar Planos</a></li>
        <li class="active">Confirmação de Compra</li>
    </ol>
    <div class="page-header">
        <h5>Você está Comprando: </h5>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div id="forms" class="panel panel-default">
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
                                <td><?php echo "R$ ". $item["confirmacao"]["total"]; ?></td>
                            </tr>
                        </tfoot>                    
                        <tbody>                        

                            <?php
                            if ($item["planosSelecionados"]) {
                                foreach ($item["planosSelecionados"] as $plano) {
                                    echo "<tr>";
                                    echo "<td>" . $plano["titulo"] . "</td>";
                                echo "<td>" . $plano["descricao"] . "</td>";
                                    echo "<td>". $item["confirmacao"]["planos"][$plano["id"]] ."</td>";
                                    echo "<td> R$ ". $plano["preco"] ."</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>  

                        </tbody>
                    </table>
                
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <div class="col-lg-offset-1">
                    <form id="form" class="form-horizontal" method="POST" action="index.php">

                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="UsuarioPlano" />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="comprar" />
                        <input type="hidden" id="hdnPlano" name="hdnPlano" value="<?php echo $item["confirmacao"]["tokenPlano"]; ?>" />
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                    <button type="submit" class="btn btn-success">Confirmar</button> 
                     <button id="btnCancelar" type="button" class="btn btn-danger">Cancelar</button>
                    </form>                            
                    
                    <?php 
                    ##BOTOES PAGSEGURO
                    /*
                        <form action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post">
<input type="hidden" name="code" value="455EFBC727279E1334AC0F82758B6371" />
<input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/99x61-comprar-laranja-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post">
<input type="hidden" name="itemCode" value="90D074F6E4E4D620049EFF8626A76E83" />
<input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/99x61-comprar-laranja-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
                      
                     */
                    ?>
                        
                       
                </div>    
            </div>    
        </div>    
    </div>    
</div>    

<script>
    $(document).ready(function() {
        $("#btnCancelar").click(function() {
            window.history.back();
        })
    })
</script>