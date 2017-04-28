<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>

<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">

<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/js/anuncio.js"></script>

<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {
        enviarEmail();
        exibirEmailPDFListaAnuncio();

        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "order": [[5, "desc"]],
            "columnDefs": [
                {"orderable": false, "targets": 0}, {"orderable": false, "targets": 7}
            ]
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
                <a class="active section"></a>
                <div class="active section"><i class="list small icon"></i>Anúncios Ativos</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Veja os detalhes do anúncio clicando no código. 
                    Se você conseguiu negociar seu anúncio ou não deseja que ele continue ativo por algum motivo, clique
                    em <strong>Finalizar Negócio</strong>. Caso queira mudar o valor, clique em <strong>Editar</strong>.
                </p>
            </div>
            <div class="ui message">
                <div class="header">Ao selecionar um ou vários anúncios, você pode:</div>
                <ul class="list">
                    <li>Enviar anúncios para o e-mail do cliente;</li>
                    <li>Enviar anúncios para o e-mail do cliente, dentro de um arquivo .PDF</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div class="ui horizontal segments">

                <div class="ui segment center aligned ">
                    <i class='big red thumbs up icon'></i> Finalizar Anúncio
                </div>

                <div class="ui segment center aligned ">
                    <i class='big blue edit icon'></i>Editar Anúncio
                </div>

                <div class="ui segment center aligned ">
                    <i class='big green money icon'></i>Valores Antigos
                </div>

            </div>           
        </div>
    </div>

</div>

<div class="ui hidden divider"></div>

<?php
Sessao::gerarToken();

$item = $this->getItem();

$totalAnunciosCadastrados = count($item["listaAnuncio"]);

if ($totalAnunciosCadastrados < 1) {
    ?>

    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <div class="ui warning message">
                    <i class="big yellow warning circle icon"></i>
                    Você não possui anúncios ativos. Clique em voltar para retornar ao MEUPIP
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
                    <table class="ui brown stackable table" id="tabela">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Cód. Anúncio</th>
                                <th>Tipo</th>
                                <th>Finalidade</th>
                                <th>Valor</th>
                                <th>Publicação</th>
                                <th>Expiração</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($item) {
                                foreach ($item["listaAnuncio"] as $anuncio) {

                                    switch ($anuncio->getImovel()->getIdTipoImovel()) {

                                        case 1: $tipoImovel = "casa";
                                            break;
                                        case 2: $tipoImovel = "apartamentoplanta";
                                            break;
                                        case 3: $tipoImovel = "apartamento";
                                            break;
                                        case 4: $tipoImovel = "salacomercial";
                                            break;
                                        case 5: $tipoImovel = "prediocomercial";
                                            break;
                                        case 6: $tipoImovel = "terreno";
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td> 

                                            <div class="ui checkbox">
                                                <input type="checkbox" tabindex="0" class="hidden" name="chkAnuncio[]" 
                                                       id="chkAnuncio<?php echo $anuncio->getIdAnuncio(); ?>" 
                                                       value="<?php echo $anuncio->getIdAnuncio(); ?>">
                                                <label></label>
                                            </div>

                                        </td>
                                        <td>                          
                                        <form id="form<?php echo $anuncio->getIdAnuncio(); ?>" action="index.php" method="post" target='_blank'>
                                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar"/>
                                            <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio->getId(); ?>"/>
                                            <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>                                                                               

                                            <button class="ui labeled icon button">
                                                <i class="zoom icon"></i>
                                                <?php echo $anuncio->getIdAnuncio(); ?>
                                            </button>
                                            <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $anuncio->getIdanuncio(); ?>" />
                                        </form>     

                                        </td>
                                        <td><?php
                                            switch ($anuncio->getImovel()->getIdTipoImovel()) {

                                                case 1: echo "Casa";
                                                    break;
                                                case 2: echo "Apartamento na Planta";
                                                    break;
                                                case 3: echo "Apartamento";
                                                    break;
                                                case 4: echo "Sala Comercial";
                                                    break;
                                                case 5: echo "Prédio Comercial";
                                                    break;
                                                case 6: echo "Terreno";
                                                    break;
                                            }
                                            ?></td>
                                        <td><?php echo $anuncio->getFinalidade(); ?></td>
                                        <td id="tdValor<?php echo $anuncio->getId(); ?>">
                                            <?php
                                            if ($anuncio->getNovoValorAnuncio() != null) {

                                                foreach ($anuncio->getNovoValorAnuncio() as $nValor) {

                                                    if ($nValor->getStatus() == "ativo") {

                                                        echo $nValor->getNovoValor();
                                                        break;
                                                    }
                                                }
                                            } else if ($anuncio->getValorMin() !== 0) {
                                                echo $anuncio->getValorMin();
                                            } else
                                                echo "Não Informado";
                                            ?>

                                        </td>

                                        <td> <?php echo date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro())); ?> </td>

                                        <td> <?php
                                            $date = date_create($anuncio->getDataHoraCadastro());
                                            date_add($date, date_interval_create_from_date_string($anuncio->getUsuarioPlano()->getPlano()->getvalidadepublicacao() . ' days'));
                                            echo date_format($date, 'd/m/Y');
                                            ?> </td>

                                        <td><?php echo "<a id='btnFinalizar" . $anuncio->getId() . "' class='ui circular inverted basic icon button'><i class='big red thumbs up icon'></i></a>" ?>

                                            <?php if ($anuncio->getImovel()->getIdTipoImovel() == 2) { //alterar valor se for Planta?>

                                                <?php echo "<a id='btnAlterarValorPlanta" . $anuncio->getId() . "' class='ui circular inverted basic icon button'><i class='big blue edit icon'></i></a>" ?>

                                            <?php } else {//alterar valor se for outro tipo de imóvel?>

                                                <?php echo "<a href='index.php?entidade=Anuncio&acao=form&idAnuncio=" . $anuncio->getId() . "&token=" . $_SESSION['token'] . "'  class='ui circular inverted basic icon button'><i class='big blue edit icon'></i></a>" ?>

                                            <?php } ?>


                                            <?php
                                            if ($anuncio->getNovoValorAnuncio() != null) {
                                                echo "<a id='btnMostrarValor" . $anuncio->getId() . "' class='ui circular inverted basic icon button'><i class='big green money icon'></i></i></a>";
                                            } else
                                                echo "";
                                            ?>

                                        </td>
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

    <div class="ui one column centered grid">
        <div class="four column centered row">
            <div id="divEmailPDF"></div>  
        </div>
    </div>

    <div class="ui hidden divider"></div>

    <?php
    if ($item) {
        foreach ($item["listaAnuncio"] as $anuncio) {
            ?>

            <script>
                alterarValor(<?php echo $anuncio->getId() ?>);
                finalizar(<?php echo $anuncio->getId() ?>);
                formatarValor(<?php echo $anuncio->getId() ?>);

            </script>


            <div class="ui standart modal" id="modalMostrarValorAnuncio<?php echo $anuncio->getId() ?>">
                <div class="header">
                    Valores Antigos
                </div>
                <div class="content" id="camposMostrarValor<?php echo $anuncio->getId() ?>">
                    <div class="description">
                        Valor(es) já cadastrado(s) para este anúncio:
                    </div>

                    <table class='ui table'>
                        <thead>
                            <tr>
                                <th>Valor</th>
                                <th>Data/Hora Cadastro</th>
                                <th>Data/Hora Inativação</th>
                            </tr>
                        </thead>
                        <tbody>   

                            <?php
                            $contador = 0;
                            $menorId = array();

                            if ($anuncio->getNovoValorAnuncio() != null) {

                                foreach ($anuncio->getNovoValorAnuncio() as $valorContador) {
                                    ?>

                                <script>
                                    formatarValorCampos(<?php echo $valorContador->getId() ?>);
                                </script>

                                <?php
                                if ($valorContador->getStatus() == "inativo") { //traz todos os valores que estão inativos
                                    $contador = $contador + 1;

                                    $menorId[] = $valorContador->getId(); //insere em um array para depois buscar o menor
                                }
                            }

                            $menor = min($menorId); //busca o id mais antigo cadastrado dos inativos. Primeiro valor alterado

                            foreach ($anuncio->getNovoValorAnuncio() as $valorPrimeiro) {

                                if ($valorPrimeiro->getId() == $menor) {

                                    //primeiro valor alterado para inserir a data da inativação do valor original
                                    $primeiroValorAlterado = $valorPrimeiro->getDataHoraCadastro();
                                }
                            }

                            if ($contador > 0) {

                                foreach ($anuncio->getNovoValorAnuncio() as $nValor) {
                                    ?>

                                    <script>
                                        formatarValorUnico(<?php echo $nValor->getId() ?>);
                                    </script>

                                    <?php
                                    if ($nValor->getStatus() == "inativo") {

                                        echo "<tr><td id='formatarValorJS" . $nValor->getId() . "'>" . $nValor->getNovoValor() . "</td><td>" . date('d/m/Y H:i:s', strtotime($nValor->getDataHoraCadastro())) . "</td><td>" . date('d/m/Y H:i:s', strtotime($nValor->getDataHoraInativacao())) . "</td></tr>";
                                    }
                                }
                            }

                            if ($contador == 0) { //caso exista apenas 1 valor trocado, ou seja, ele está ativo
                                foreach ($anuncio->getNovoValorAnuncio() as $nValor) {
                                    ?>

                                    <script>
                                        formatarValorUnico(<?php echo $nValor->getId() ?>);
                                    </script>

                                    <?php
                                    $primeiroValorAlterado = date('d/m/Y H:i:s', strtotime($nValor->getDataHoraCadastro()));
                                }
                            }
                            //buscar da tabela anúncio o valor original cadastrado. A data da inativação é quando foi cadastrado o primeiro novo valor                    
                            echo "<tr><td id='formatarValorUnicoJS" . $nValor->getId() . "'>" . $anuncio->getValorMin() . "</td><td>" . date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro())) . "</td><td>" . $primeiroValorAlterado . "</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>

                </div>

                <div class="actions">
                    <div  id="botaoFecharMostrarValor<?php echo $anuncio->getId(); ?>" class="ui red deny button">
                        Fechar
                    </div>
                </div>
            </div>

            <!-- MODAL DA EDIÇÃO DO ANÚNCIO-->

            <div class="ui standart modal" id="modalAlterarValorAnuncio<?php echo $anuncio->getId() ?>">
                <div class="header">
                    Editar Anúncio
                </div>
                <div class="content" id="camposNovoValor<?php echo $anuncio->getId() ?>">
                    <div class="description">

                        <p id="textoConfirmacao"></p>

                        <form class="ui form" id="formAlterarValorAnuncio<?php echo $anuncio->getId() ?>" action="index.php" method="post">
                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="alterarValor" />  
                            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                            <input type="hidden" id="hdnAnuncio" name="hdnAnuncio" value="<?php echo $anuncio->getId() ?>" />
                            <input type="hidden" id="hdnValorAtual<?php echo $anuncio->getId() ?>"
                                   name="hdnValorAtual" 
                                   value="<?php
                                   if ($anuncio->getNovoValorAnuncio() != null) {

                                       foreach ($anuncio->getNovoValorAnuncio() as $nValor) {

                                           if ($nValor->getStatus() == "ativo") {

                                               echo $nValor->getNovoValor();
                                           }
                                       }
                                   } else
                                       echo $anuncio->getValorMin();
                                   ?>"/>    

                            <div class="fields">
                                <div class="twelve wide required field">
                                    <label>Título do Anúncio</label>
                                    <input name="txtTitulo" id="txtTitulo<?php echo $anuncio->getId() ?>" type="text" placeholder="Informe o Título" maxlength="50" value="<?php echo $anuncio->getTituloAnuncio() ?>">
                                </div>
                            </div>
                            <div class="required field">
                                <label>Descrição</label>
                                <textarea name="txtDescricao" id="txtDescricao<?php echo $anuncio->getId() ?>" placeholder="Informe uma Descrição do Imóvel" maxlength="150" ><?php echo $anuncio->getDescricaoAnuncio() ?></textarea>
                            </div>
                            <div class="two fields">
                                <div class="field">
                                    <div class="ui toggle checkbox">
                                        <?php if ($anuncio->getPublicarMapa() == 'SIM') { ?>
                                            <input name="chkMapa" id="chkMapa" type="checkbox" value="SIM" checked="checked">
                                        <?php } else { ?>
                                            <input name="chkMapa" id="chkMapa" type="checkbox" value="SIM">
                                        <?php } ?>

                                        <label>Exibir o mapa do endereço?</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui toggle checkbox">
                                        <?php if ($anuncio->getPublicarContato() == 'SIM') { ?>
                                            <input name="chkContato" id="chkContato" type="checkbox" value="SIM" checked="checked">
                                        <?php } else { ?>
                                            <input name="chkContato" id="chkContato" type="checkbox" value="SIM">
                                        <?php } ?>
                                        <label>Exibir suas informações de contato?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="ui message">
                                <p>Digite o novo valor para seu anúncio. <strong>ATENÇÃO:</strong> O valor atual será substituido pelo novo
                                </p>
                            </div>

                            <div class="field" id="divValorAtual<?php echo $anuncio->getId(); ?>">

                                <?php
                                if ($anuncio->getNovoValorAnuncio() != null) {

                                    foreach ($anuncio->getNovoValorAnuncio() as $nValor) {

                                        if ($nValor->getStatus() == "ativo") {

                                            echo $nValor->getNovoValor();
                                        }
                                    }
                                } else
                                    echo $anuncio->getValorMin();
                                ?>         

                            </div>

                            <div class="three wide field" id="divNovoValor<?php echo $anuncio->getId(); ?>">
                                <label>Novo Valor</label>
                                <input name="txtNovoValor"  id="txtNovoValor<?php echo $anuncio->getId(); ?>" placeholder="Novo Valor" type="text" maxlength="12">
                            </div>


                        </form>

                    </div>
                </div>

                <div id="divRetornoNovoValor<?php echo $anuncio->getId(); ?>"></div>

                <div class="actions">
                    <div  id="botaoCancelaAlterarValor<?php echo $anuncio->getId(); ?>" class="ui orange deny button">
                        Cancelar
                    </div>
                    <div  id="botaoAlterarValor<?php echo $anuncio->getId(); ?>" class="ui positive right labeled icon button">
                        Editar
                        <i class="checkmark icon"></i>
                    </div>
                    <div  id="botaoFecharAlterarValor<?php echo $anuncio->getId(); ?>" class="ui red deny button">
                        Fechar
                    </div>
                </div>
            </div>

            <!-- Modal do Finalizar Negócio-->    
            <div class="ui basic modal" id="modalFinalizar<?php echo $anuncio->getId() ?>">

                <div class="header">
                    ATENÇÃO: Ao Finalizar Negócio, o anúncio não será mais visualizado, deixando de existir!
                </div>
                <div class="content" id="camposFinalizar<?php echo $anuncio->getId() ?>">

                    <div class="ui segment">
                        <p id="textoConfirmacao"></p>

                        <form class="ui form" id="formFinalizar<?php echo $anuncio->getId() ?>" action="index.php" method="post">
                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="finalizar" />  
                            <input type="hidden" id="hdnAnuncio" name="hdnAnuncio" value="<?php echo $anuncio->getId() ?>" />
                            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

                            <div class=" required grouped fields">
                                <label for="sucesso">Sua negociação foi bem sucedida?</label>
                                <div class="field">
                                    <div class="ui radio checkbox ">
                                        <input class="hidden" tabindex="0" name="radioSucesso" id="radioSucessoSim" type="radio" value="SIM" checked="checked">
                                        <label>Sim</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input class="hidden" tabindex="0" name="radioSucesso"  id="radioSucessoNao" type="radio" value="NAO">
                                        <label>Não</label>
                                    </div>
                                </div>                                                                      
                            </div>

                            <div class="field">
                                <label>Se desejar, escreva detalhes da finalização de seu anúncio</label>
                                <textarea rows="2" id="txtFinalizar<?php echo $anuncio->getId() ?>" name="txtFinalizar" maxlength="200"></textarea>
                            </div>

                        </form>

                    </div>

                </div>
                <div id="divRetorno<?php echo $anuncio->getId() ?>"></div>
                <div class="actions">
                    <div  id="botaoCancelarFinalizar<?php echo $anuncio->getId() ?>" class="ui orange deny button">
                        Cancelar
                    </div>
                    <div  id="botaoEnviarFinalizar<?php echo $anuncio->getId() ?>" class="ui positive right labeled icon button">
                        Finalizar Negócio
                        <i class="checkmark icon"></i>
                    </div>
                    <div  id="botaoFecharFinalizar<?php echo $anuncio->getId() ?>" class="ui red deny button">
                        Fechar
                    </div>

                </div>

            </div>
            <?php
        }
    }
    ?>

<?php } //fim do else, caso haja anuncios ativos ?> 

<?php
include_once "modal/AnuncioEnviarEmailModal.php";
?>