
<?php
    Sessao::gerarToken();  
?>
<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Anuncie!</h1>
    </div>
    <!-- Alertas -->
    <div class="alert"></div>
    <!-- Primeira Linha -->        
    <div class="row">
        <div class="col-lg-6">
            <div id="forms" class="panel panel-default">
                <div class="panel-heading">Nossos Planos</div>
                <table class="table table-bordered table-condensed table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Descrição Completa</th>
                            <th>Publicação</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = $this->getItem();
                        if ($item) {
                            foreach ($item as $plano) {
                                echo "<tr>";
                                echo "<td>" . $plano->getTitulo() . "</td>";
                                echo "<td>" . $plano->getDescricao() . "</td>";
                                echo "<td>" . $plano->getValidadepublicacao() . " dias</td>";
                                echo "<td> R$ " . $plano->getPreco() . " </td>";
                                echo "</tr>";
                            }
                        }
                        ?>   
                    </tbody>
                </table>                    
            </div>
        </div>
        <div class="col-lg-6">
            <div id="forms" class="panel panel-default">
                <div class="panel-heading">Fa&ccedil;a seu login </div>
                <!-- form -->
                <form id="form" class="form-horizontal" action="index.php" method="post">
                    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                    <input type="hidden" id="hdnAcao" name="hdnAcao" value="autenticar" />
                    <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtLogin">Login</label>
                        <div class="col-lg-4">
                            <input type="text" id="txtLogin" name="txtLogin" class="form-control" placeholder="Informe o Login">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtSenha">Senha</label>
                        <div class="col-lg-4">
                            <input type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder="Informe a Senha">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                    <button type="button" class="btn btn-warning">Cancelar</button>
                                </div>
                            </div>                
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-5 control-label"><a href="#">Esqueceu sua a senha?</a></label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-5 control-label"><a href="#">Ainda não é cadastrado?</a></label>
                    </div>

                </form>
            </div>
        </div>
    </div>


</div>