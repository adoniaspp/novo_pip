<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<!-- JS -->
<script src="assets/js/usuario.js"></script>
<script src="assets/js/resposta.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>

<script>
    esconderResposta();    
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
    
    $totalMensagem = 0;
    
    foreach ($this->getItem() as $mensagem) {
        
        if($mensagem->getId()){           
            
            $totalMensagem = $totalMensagem + 1;        
            
        }
            
    }
    
    if($totalMensagem < 1){      
        
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

    <?php } else { //caso exista alguma mensagem?>

<div class="ui hidden divider"></div>
<div class="ui middle aligned stackable grid container">
    <div class="one column">
        <table class="ui brown table" id="tabela">
            <thead>
                <tr style="border: none !important">
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                
                foreach ($this->getItem() as $mensagem) {
                    
                    switch ($mensagem->getAnuncio()->getImovel()->getIdTipoImovel()){

                        case 1: $tipoImovel = "casa"; break;
                        case 2: $tipoImovel = "apartamentoplanta"; break;
                        case 3: $tipoImovel = "apartamento"; break;
                        case 4: $tipoImovel = "salacomercial"; break;
                        case 5: $tipoImovel = "prediocomercial"; break;
                        case 6: $tipoImovel = "terreno"; break;

                    }
                    
                ?>

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
                                            $("#divRetorno" + <?php echo $mensagem->getId(); ?>).html('<div class="ui compact red message"><div class="header">Erro ao responder. Tente novamente em alguns minutos - 000.</div></div>');
                                        } else if (resposta.resultado == 1) {
                                            $("#btnResponderMensagem" + <?php echo $mensagem->getId(); ?>).hide();
                                            $("#divRetorno" + <?php echo $mensagem->getId(); ?>).html('<div class="ui compact green message"><div class="header">Resposta enviada</div></div>');
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
                                    <?php echo "Detalhes do Anuncio ".$mensagem->getAnuncio()->getIdAnuncio(); ?>
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
                                    
                                    
                                    <?php if($mensagem->getProposta() != 0) {?>
                                    
                                    <script>
                                    formatarValorProposta(<?php echo $mensagem->getId(); ?>);
                                    </script>
                                    
                                    <div class="ui positive icon message" style="width: 30%">   
                                        <i class="dollar green icon"></i>
                                        <div class="content">                                           
                                            <div class="header">Proposta do comprador</div>
                                            <label id="txtProposta<?php echo $mensagem->getId() ?>" name="txtProposta"><?php echo $mensagem->getProposta() ?></label>
                                        </div>
                                    </div>
                                    <?php }?>
                                    
                                    <div>
                                        <label>Enviado em <?php echo substr($mensagem->getDataHora(), 0, 10) ?> 
                                            as <?php echo substr($mensagem->getDataHora(), 10, -3) ?> por 

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

                                    <div id="divMsgRespondida<?php echo $mensagem->getId() ?>">

                                    </div>
                                    <label>Sua resposta:</label>


                                    <i class="forward mail icon"></i>
                                    <?php echo $mensagem->getRespostaMensagem()[0]->getResposta() ?>

                                    <div class="ui hidden divider"></div>

                                    <label>Respondido em <?php echo substr($mensagem->getRespostaMensagem()[0]->getDataHora(), 0, 10) ?> 
                                        as <?php echo substr($mensagem->getRespostaMensagem()[0]->getDataHora(), 10, -3) ?>
                                    </label>          

                                <?php } ?>  

                            </div>            

                            <div class="ui hidden divider"></div>
                            <div id="divRetorno<?php echo $mensagem->getId() ?>"></div>               
                            <div class="ui hidden divider"></div>

                        </form>

                        <div class="ui divider"></div>

                    </td>
                </tr>

            <?php } ?>               

            </tbody>
        </table>
    </div>
</div>

<?php } //fim do else, caso haja alguma mensagem ?> 

<script>
    $(document).ready(function () {
        $('#tabela').dataTable({
            "language": {
                "url": "assets/libs/DataTables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "bSort": false,
        });
    })
</script>