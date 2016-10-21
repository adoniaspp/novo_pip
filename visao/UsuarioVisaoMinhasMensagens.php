<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>

<!-- JS -->
<script src="assets/js/usuario.js"></script>
<script src="assets/js/resposta.js"></script>

<script src="assets/libs/jplist/jplist.core.min.js"></script>
<link href="assets/libs/jplist/jplist.core.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/jplist/jplist.sort-bundle.min.js"></script>
<link href="assets/libs/jplist/jplist.pagination-bundle.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/jplist/jplist.pagination-bundle.min.js"></script>
<script src="assets/libs/jplist/jplist.filter-dropdown-bundle.min.js"></script>


<script>
    esconderResposta();
    ordenarMensagem();
</script>
<?php
Sessao::gerarToken();
?>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui large breadcrumb">
                <div class="ui large breadcrumb">
                    <a class="section" href="index.php">Início</a>
                    <i class="right chevron icon divider"></i>
                    <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section"><i class="list small icon"></i>Minhas Mensagens</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>
                    Veja as mensagens enviadas para seus anúncios e responda-as para o rementente. As respostas 
                    são enviadas diretamente para o e-mail de quem fez a pergunta 
                </p>
            </div>
        </div>
    </div>

</div>

<?php
Sessao::gerarToken();

$item = $this->getItem();
/*
echo "<pre>";
var_dump($item);
echo "</pre>";
*/
$totalMensagem = 0;

foreach ($this->getItem() as $mensagem) {

    if ($mensagem->getId()) {

        $totalMensagem = $totalMensagem + 1;
        
    }
}



if ($totalMensagem < 1 && !is_array($item)) {
   
    ?>

    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <div class="ui warning message">
                    <div class="header">Atenção</div>
                    <ul class="list">
                        Você não possui mensagens. Clique em voltar para retornar ao MEUPIP
                    </ul>
                </div>

                <div class="row">
                    <a href="index.php?entidade=Usuario&acao=meuPIP">
                        <button class="ui orange button">Voltar</button>
                    </a>
                </div> 
            </div>   
        </div>
    </div>    

<?php } else if ($item == 'nenhuma') {

    ?>

    <div class="ui hidden divider"></div>
    <!--
     <div class="ui middle aligned stackable grid container">
             <div class="column">
                 <form id="form" class="ui form" action="index.php" method="post">
                     <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                     <input type="hidden" id="hdnAcao" name="hdnAcao" value="filtrarMensagens" />
     
             <div class="fields">
                 <div class="four wide field">
                     <label>Filtrar</label>
                     <div class="ui selection dropdown">
                         <input type="hidden" name="sltStatusMensagem" id="sltStatusMensagem">
                         <div class="default text">Escolha a opção</div>
                         <i class="dropdown icon"></i>
                         <div class="menu">
                             <div class="item" data-value="todas">Todas as Mensagens</div>
                             <div class="item" data-value="RESPONDIDO">Respondidas</div>
                             <div class="item" data-value="NOVA">Não Respondidas</div>
                         </div>
                     </div>
                 </div>
             </div>
                 
             </form> 
                 
         </div>
     
     </div>
    -
    +-->
    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="column">
                <div class="ui warning message">
                    <div class="header">Atenção</div>
                    <ul class="list">
                        Nenhuma Mensagem
                    </ul>
                </div>
            </div>   
        </div>
    </div>

    <?php
} else /*if ($totalMensagem > 1$item != 'nenhuma')*/ {

    ?>

    <div class="ui hidden divider"></div>
    <!--
     <div class="ui middle aligned stackable grid container">
             <div class="column">
                 <form id="form" class="ui form" action="index.php" method="post">
                     <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                     <input type="hidden" id="hdnAcao" name="hdnAcao" value="filtrarMensagens" />
     
             <div class="fields">
                 <div class="four wide field">
                     <label>Filtrar</label>
                     <div class="ui selection dropdown">
                         <input type="hidden" name="sltStatusMensagem" id="sltStatusMensagem">
                         <div class="default text">Escolha a opção</div>
                         <i class="dropdown icon"></i>
                         <div class="menu">
                             <div class="item" data-value="todas">Todas as Mensagens</div>
                             <div class="item" data-value="RESPONDIDO">Respondidas</div>
                             <div class="item" data-value="NOVA">Não Respondidas</div>
                         </div>
                     </div>
                 </div>
             </div>
                 
             </form> 
                 
         </div>
     
     </div>
    -
    +-->

    <div class="ui middle aligned stackable one column grid container" id="lista">
        <div class="ui column">
            <div class="jplist-panel">
                <div 
                    class="jplist-drop-down" 
                    data-control-type="items-per-page-drop-down" 
                    data-control-name="paging" 
                    data-control-action="paging">
                    <ul>
                        <li><span data-number="4" data-default="true"> 4 mensagens </span></li>
                        <li><span data-number="8"> 8 mensagens </span></li>
                        <li><span data-number="16"> 16 mensagens </span></li>
                        <li><span data-number="all"> Todas as Mensagens </span></li>
                    </ul>
                </div>

                <div 
                    class="jplist-drop-down" 
                    data-control-type="sort-drop-down" 
                    data-control-name="sort" 
                    data-control-action="sort"
                    data-datetime-format="{day}/{month}/{year} {hour}:{min}:{sec}">  

                    <ul>
                        <li><span data-path="default">Organizar Por</span></li>
                        <li><span data-path=".data" data-order="desc" data-type="datetime">Mais Recente</span></li>
                        <li><span data-path=".data" data-order="asc" data-type="datetime">Mais Antiga</span></li>
                    </ul>
                </div>
                <div 
                    class="jplist-drop-down" 
                    data-control-type="filter-drop-down" 
                    data-control-name="category-filter" 
                    data-control-action="filter">
                    <ul>
                        <li><span data-path="default">Filtrar por</span></li>
                        <li><span data-path=".nresposta">Não Respondida(s)</span></li>
                        <li><span data-path=".resposta">Respondida(s)</span></li>                        
                    </ul>
                </div>
              
                <div 
                    class="jplist-label" 
                    data-type="{start} - {end} de {all}"
                    data-control-type="pagination-info" 
                    data-control-name="paging" 
                    data-control-action="paging">
                </div>	
                <div 
                    class="jplist-pagination" 
                    data-control-type="pagination" 
                    data-control-name="paging" 
                    data-control-action="paging">
                </div>


                <!--        <div 
                            class="jplist-drop-down" 
                            data-control-type="sort-drop-down" 
                            data-control-name="sort" 
                            data-control-action="sort"
                            data-datetime-format="{year}-{month}-{day} {hour}:{min}:{sec}">  
                
                            <ul>
                                <li><span data-path="default">Escolha a ordem</span></li>
                                <li><span data-path=".valor" data-order="desc" data-type="number">Maior Preço</span></li>
                                <li><span data-path=".valor" data-order="asc" data-type="number">Menor Preço</span></li>
                                <li><span data-path=".data" data-order="desc" data-type="datetime">Mais Recente</span></li>
                                <li><span data-path=".data" data-order="asc" data-type="datetime">Menos Recente</span></li>
                            </ul>
                        </div>-->
            </div>
        </div>


        <div class="one column list">
            <?php
            foreach ($this->getItem() as $mensagem) {

                switch ($mensagem->getAnuncio()->getImovel()->getIdTipoImovel()) {

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

                <div class="list-item"> 
                    <script>
                        exibirDivResposta(<?php echo $mensagem->getId(); ?>);
                        responderMensagem(<?php echo $mensagem->getId(); ?>);
                        ocultarResposta(<?php echo $mensagem->getId(); ?>);

                        $(document).ready(function () {

                            $("#form<?php echo $mensagem->getId(); ?>").submit(function () {

                                $("#form<?php echo $mensagem->getId(); ?>").validate();
                                $("#txtResposta<?php echo $mensagem->getId(); ?>").rules("add", {
                                    required: true,
                                    minlength: 2,
                                    messages: {
                                        required: "Campo Obrigatório",
                                        minlength: "Digite ao menos 2 caracteres"
                                    }
                                });

                                if (($("#txtResposta<?php echo $mensagem->getId(); ?>").valid())) {
                                    $.ajax({
                                        url: "index.php",
                                        dataType: "json",
                                        type: "POST",
                                        data: $('#form' + <?php echo $mensagem->getId(); ?>).serialize(),
                                        beforeSend: function () {
                                            $("#divRetorno" + <?php echo $mensagem->getId(); ?>).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Processando. Aguarde...</div></div></div>");

                                            $("#divCamposResposta" + <?php echo $mensagem->getId(); ?>).hide();

                                        },
                                        success: function (resposta) {
                                            $("#divRetorno" + <?php echo $mensagem->getId(); ?>).empty();
                                            if (resposta.resultado == 0) {
                                                -$("#divRetorno" + <?php echo $mensagem->getId(); ?>).html('<div class="ui compact red message"><div class="header">Erro ao responder. Tente novamente em alguns minutos - 000.</div></div>');
                                                +$("#divRetorno" + <?php echo $mensagem->getId(); ?>).html("<div class='ui compact red message'><div class='header'><i class='big red remove circle outline icon'></i>Erro ao responder. Tente novamente em alguns minutos - 000.</div></div>");
                                            } else if (resposta.resultado == 1) {
                                                $("#btnResponderMensagem" + <?php echo $mensagem->getId(); ?>).hide();
                                                -$("#divRetorno" + <?php echo $mensagem->getId(); ?>).html('<div class="ui compact green message"><div class="header">Resposta enviada</div></div>');
                                                +$("#divRetorno" + <?php echo $mensagem->getId(); ?>).html("<div class='ui compact green message'><div class='header'><i class='big green check circle outline icon'></i>Resposta enviada com Sucesso</div></div>");
                                            }
                                        }
                                    })
                                }
                                return false;

                            });
                        });

                    </script>    

                    <tr style="border: none !important">
                        <td style="border: none !important; width: 500px"> 

                            <form id="formAnuncio<?php echo $mensagem->getId() ?>" class="ui form" action="index.php" method="post" target="_blank">
                                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                                <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar" />
                                <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $mensagem->getAnuncio()->getId() ?>"/>
                                <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>

                                <div>

                                    <button class="ui labeled icon button">
                                        <i class="zoom icon"></i>
        <?php echo "Detalhes do Anúncio " . $mensagem->getAnuncio()->getIdAnuncio(); ?>
                                    </button>

                                </div>    

                                <br/>

                            </form>

                            <form id="form<?php echo $mensagem->getId() ?>" class="ui form" action="index.php" method="post">
                                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                                <input type="hidden" id="hdnAcao" name="hdnAcao" value="responderMensagem" />
                                <input type="hidden" id="hdnMensagem" name="hdnMensagem" value="<?php echo $mensagem->getId(); ?>" />
                                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

                                <div id="divMensagem<?php echo (string) $mensagem->getId() ?>">                   

                                    <div class="field">

                                        <div class="ui info icon message" style="width: 90%">   
                                            <i class="mail icon"></i>
                                            <div class="content">
                                                <div class="header">Mensagem</div>
        <?php echo $mensagem->getMensagem() ?>
                                            </div>
                                        </div>


        <?php if ($mensagem->getProposta() != 0) { ?>

                                            <script>
                                                formatarValorProposta(<?php echo $mensagem->getId(); ?>);
                                            </script>

                                            <div class="ui positive icon message" style="width: 90%">   
                                                <i class="dollar green icon"></i>
                                                <div class="content">                                           
                                                    <div class="header">Proposta do comprador</div>
                                                    <label id="txtProposta<?php echo $mensagem->getId() ?>" name="txtProposta"><?php echo $mensagem->getProposta() ?></label>
                                                </div>
                                            </div>
        <?php } ?>

                                        <div>
                                            <span hidden="true" class="data" id="spanData<?php echo $mensagem->getId() ?>"> 
        <?php echo $mensagem->getDataHora(); ?> </span>
                                            <label>Enviado em: <?php echo substr($mensagem->getDataHora(), 0, 10) ?> 
                                                às <?php echo substr($mensagem->getDataHora(), 10, -3) ?> por 

                                                <?php
                                                if ($mensagem->getNome() == "") {
                                                    echo "Anônimo";
                                                } else
                                                    echo $mensagem->getNome();
                                                ?>

                                            </label>    
                                        </div>

                                    </div>                                       

                                    <?php
                                    if ($mensagem->getStatus() != "RESPONDIDO") {
                                        ?>

                                        <span class="nresposta" hidden="true" id="spanResposta<?php echo $mensagem->getId(); ?>"><?php echo $mensagem->getStatus() ?></span>

                                        <div id="divCamposResposta<?php echo $mensagem->getId() ?>" style="width: 90%">

                                            <label id="laberResponder<?php echo $mensagem->getId() ?>">
                                                <a href="#<?php echo $mensagem->getId() ?>" id="responder<?php echo $mensagem->getId(); ?>">Responder</a>
                                            </label>

                                            <div class="required field"  id="divResposta<?php echo $mensagem->getId(); ?>">
                                                <label>Digite a resposta</label>
                                                <textarea rows="2" cols="5" name="txtResposta" id="txtResposta<?php echo $mensagem->getId(); ?>" maxlength="200"></textarea>     

                                                <div class="ui hidden divider"></div>       

                                                <div id="divBotoesMensagem">
                                                    <button class="ui blue button" type="submit" id="btnResponderMensagem<?php echo $mensagem->getId() ?>">Responder</button>
                                                    <button class="ui orange button" type="button" id="btnCancelarMensagem<?php echo $mensagem->getId() ?>">Cancelar</button>
                                                </div>    

                                            </div>

                                        </div>     
        <?php } else { ?>  
                                        <span class="resposta" hidden="true" id="spanResposta<?php echo $mensagem->getId(); ?>"><?php echo $mensagem->getStatus() ?></span>
                                        <div id="divMsgRespondida<?php echo $mensagem->getId() ?>">

                                        </div>
                                        <label>Sua resposta:</label>


                                        <i class="forward mail icon"></i>
            <?php echo $mensagem->getRespostaMensagem()[0]->getResposta() ?>

                                        <div class="ui hidden divider"></div>

                                        <label>Respondido em: <?php echo substr($mensagem->getRespostaMensagem()[0]->getDataHora(), 0, 10) ?> 
                                            às <?php echo substr($mensagem->getRespostaMensagem()[0]->getDataHora(), 10, -3) ?>
                                        </label>          

        <?php } ?>  

                                </div>            

                                <div class="ui hidden divider"></div>
                                <div id="divRetorno<?php echo $mensagem->getId() ?>"></div>               
                                <div class="ui hidden divider"></div>

                            </form>

                            <div class="ui divider" style="border-top: 3px solid rgba(34,36,38,.15)"></div>

                </div>


                </td>
                </tr>



    <?php } ?>               
        </div></div> 

<?php } //fim do else, caso haja alguma mensagem  ?> 
