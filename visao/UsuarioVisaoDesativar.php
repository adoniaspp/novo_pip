
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">

<script src="assets/js/usuario.js"></script>

<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {

        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "order": [[4, "desc"]]
        });

    })

</script>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Usuários Ativos</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div class="ui message">
                Abaixo está a lista de usuários ativos.
            </div>
        </div>
    </div>

</div>

<div class="ui hidden divider"></div>

<?php
Sessao::gerarToken();

$item = $this->getItem();

$totalUsuariosCadastrados = count($item["listaUsuarios"]);

if ($totalUsuariosCadastrados < 1) {
    ?>

    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <div class="ui warning message">
                    <i class="big yellow warning circle icon"></i>
                    Não existe usuários ativos. Clique em voltar para retornar ao MEUPIP
                </div>

                <div class="row">
                    <a href="index.php?entidade=Usuario&acao=meuPIP">
                        <button class="ui orange button">Voltar</button>
                    </a>
                </div> 
            </div>   
        </div>
    </div>    

<?php } else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable?>
    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <table class="ui red stackable table" id="tabela">

                    <thead>
                        <tr>
                            <th>Tipo de Usuário</th>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Login</th>
                            <th>Data Cadastro</th>
                            <th>E-mail</th>  
                            <th>Operações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($item) {
                            foreach ($item["listaUsuarios"] as $usuario) {
                                ?>
                                <tr>
                                    <td>                                                      
                                        <?php
                                        if ($usuario->getTipoUsuario() == "pf") {
                                            echo "Pessoa Física";
                                        } else {
                                            echo "Pessoa Jurídica";
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $usuario->getNome();
                                        ?>
                                    </td>
                                    <td><?php echo $usuario->getCpfcnpj(); ?></td>
                                    <td><?php echo $usuario->getLogin(); ?></td>

                                    <td> <?php echo date('d/m/Y H:i:s', strtotime($usuario->getDataHoraCadastro())); ?> </td>
                                    <td><?php echo $usuario->getEmail(); ?></td>                              
                                    <td> <?php
                                        echo "<a id='btnInativar" . $usuario->getId() . "' class='ui circular inverted icon button'><i class='big red thumbs down icon'></i></a>Inativar";
                                        ?> </td>                                               
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="ui hidden divider"></div>

    <?php
    if ($item) {
        foreach ($item["listaUsuarios"] as $usuario) {
            ?>

            <script>
                inativarUsuario(<?php echo $usuario->getId() ?>);
            </script>

            <!-- MODAL DA EDIÇÃO DO STATUS DO ANÚNCIO-->

            <div class="ui standart modal" id="modalInativar<?php echo $usuario->getId() ?>">
                <i class="close icon"></i>
                <div class="header">
                    Inativar Usuário
                </div>
                <div class="content" id="divInativarUsuario<?php echo $usuario->getId() ?>">

                    <form class="ui form" id="formInativarUsuario<?php echo $usuario->getId() ?>" action="index.php" method="post">
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="inativarUsuario" />  
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                        <input type="hidden" id="hdnUsuario" name="hdnUsuario" value="<?php echo $usuario->getId() ?>" />

                        <div class="content" id="divDescricaoInativar<?php echo $usuario->getId(); ?>">
                            <div class="description">
                                <div class="ui header">Deseja realmente inativar o usuário <?php echo $usuario->getNome() ?> ?</div>
                            </div>
                        </div>

                    </form>

                </div>

                <div id="divRetornoInativar<?php echo $usuario->getId(); ?>"></div>

                <div class="actions">
                    <div id="botaoCancelarInativar<?php echo $usuario->getId(); ?>" class="ui red deny button">
                        Não
                    </div>
                    <div id="botaoInativar<?php echo $usuario->getId(); ?>" class="ui positive right labeled icon button">
                        Sim
                        <i class="checkmark icon"></i>
                    </div>
                    <div  id="botaoFecharInativar<?php echo $usuario->getId(); ?>" class="ui red deny button">
                        Fechar
                    </div>
                </div>

            </div>

            <?php
        }
    }
    ?>

<?php } //fim do else, caso haja anuncios ativos ?> 



