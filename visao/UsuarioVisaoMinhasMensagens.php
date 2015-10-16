<!-- LIBS -->
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<!-- JS -->
<script src="assets/js/usuario.js"></script>
<script src="assets/js/resposta.js"></script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.6/css/jquery.dataTables.css">
<script src="assets/libs/DataTables/js/jquery.dataTables.min.js"></script>

<script>
esconderResposta();
</script>
<?php

Sessao::gerarToken();
            
?>

<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Minhas Mensagens</a>
            </div>
        </div>
    </div>

</div>    
 
   
    <div class="ui page main grid">
    
    
    <div class="row">
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
                   
?>
    
    <script>
        exibirDivResposta(<?php echo $mensagem->getId();?>);
        responderMensagem(<?php echo $mensagem->getId();?>);
        ocultarResposta(<?php echo $mensagem->getId();?>);
    </script>    
    
            <tr style="border: none !important">
                    <td style="border: none !important; width: 500px"> 
            
            <form id="form<?php echo $mensagem->getId()?>" class="ui form" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="responderMensagem" />
                <input type="hidden" id="hdnMensagem" name="hdnMensagem" value="<?php echo $mensagem->getId(); ?>" />
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                
                   
                    
                <div id="divMensagem<?php echo (string)$mensagem->getId()?>">                   
                
                <div class="field">
                        <div>
                            <label>Anuncio <?php echo $mensagem->getIdAnuncio()." - ".$mensagem->getAnuncio()->getTituloAnuncio();?></label>
                        </div>
                        
                    <div class="ui info icon message" style="width: 90%">   
                        <i class="mail icon"></i>
                            <div class="content">
                            <div class="header">Mensagem</div>
                              <?php echo $mensagem->getMensagem()?>
                            </div>
                    </div>
                        
                        <div>
                        <label>Enviado em <?php echo substr($mensagem->getDataHora(), 0, 10)?> 
                              as <?php echo substr($mensagem->getDataHora(), 10, -3)?> por 
                        
                              <?php if ($mensagem->getNome() == ""){echo "Anônimo";} else echo $mensagem->getNome();?>
                              
                        </label>    
                        </div>
                        
                </div>                                       
                    
                    <?php 
                    
                    if ($mensagem->getStatus() != "RESPONDIDO"){
                    
                    ?>
                    
                    <div id="divCamposResposta<?php echo $mensagem->getId()?>" style="width: 90%">
                    
                    <label id="laberResponder<?php echo $mensagem->getId()?>">
                           <a href="#<?php echo $mensagem->getId()?>" id="responder<?php echo $mensagem->getId();?>">Responder</a>
                    </label>
                    
                    <div class="required field"  id="divResposta<?php echo $mensagem->getId();?>">
                        <label>Digite a resposta</label>
                        <textarea rows="2" cols="5" name="txtResposta" id="txtResposta<?php echo $mensagem->getId();?>" maxlength="200"></textarea>     
                        
                         <div class="ui hidden divider"></div>       
                            
                        <div id="divBotoesMensagem">
                        <button class="ui blue button" type="button" id="btnResponderMensagem<?php echo $mensagem->getId()?>">Responder</button>
                        <button class="ui orange button" type="button" id="btnCancelarMensagem<?php echo $mensagem->getId()?>">Cancelar</button>
                        </div>    
                    
                    </div>
                    
                    </div>     
                    <?php } else { ?>  
                    
                    <div id="divMsgRespondida<?php echo $mensagem->getId()?>">
                        
                    </div>
                    <label>Sua resposta:</label>
                    
                    
                        <i class="forward mail icon"></i>
                        <?php echo $mensagem->getRespostaMensagem()[0]->getResposta()?>
                    
                    <div class="ui hidden divider"></div>
                     
                    <label>Respondido em <?php echo substr($mensagem->getRespostaMensagem()[0]->getDataHora(), 0, 10)?> 
                              as <?php echo substr($mensagem->getRespostaMensagem()[0]->getDataHora(), 10, -3)?>
                    </label>          
                    
                    <?php } ?>  
                    
                </div>            
                        
                <div class="ui hidden divider"></div>
                <div id="divRetorno<?php echo $mensagem->getId()?>"></div>               
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
    </div>
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