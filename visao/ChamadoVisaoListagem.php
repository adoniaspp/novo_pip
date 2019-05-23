
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.semanticui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">

<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/js/anuncio.js"></script>
<script src="assets/js/chamado.js"></script>

<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {
        
        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );
        
        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "order": [[4, "desc"]],
            "columnDefs": [
                {"orderable": false, "targets": 6}
            ]
        });

    })

</script>

<div class="ui middle aligned stackable grid container">
    <div class="row" id="breadcrumb">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Chamados Cadastrados</a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                Chamados cadastrados pelos usuários
            </div>
        </div>
    </div>
    
</div>
 
<div class="ui hidden divider"></div>

    <?php
    Sessao::gerarToken();
   
    $item = $this->getItem();    

    $totalChamados = count($item["listaChamado"]);
    
    if($totalChamados < 1){      
    ?>
   
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui warning message">
                <i class="big yellow warning circle icon"></i>
                  Nenhum chamado cadastrado
            </div>

            <div class="row">
            <a href="index.php?entidade=Usuario&acao=meuPIP">
            <button class="ui orange button">Voltar</button>
            </a>
            </div> 
        </div>   
    </div>
</div>    

    <?php } else { //caso exista ao menos 1 anuncio chamado, exibir o datatable?>
    <div class="ui middle aligned stackable grid container">
        <div class="row">
    <div class="column">
    <table class="ui red stackable table" id="tabela">
        
        <thead>
            <tr>
                <th>Código</th>
                <th>Usuário</th>
                <th>Tipo</th>
                <th>Assunto</th>
                <th>Mensagem</th>
                <th>Data Cadastro</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($item) {
                
                foreach ($item["listaChamado"] as $chamado) {
                    
                    ?>
                    <tr>
                        <td>                          
                            <?php echo $chamado->getCodigoChamado() ?>
                        </td>
                        <td>                          
                            <?php echo $chamado->getUsuario()->getLogin(); ?>
                        </td>
                        <td><?php echo Chamado::retornarTipo($chamado->getChamadoAssunto()->getIdTipo()) ?></td>
                        <td><?php 
                        
                        $limite = 25;
                        $titulo = $chamado->getChamadoAssunto()->getAssunto();
                        $escreverAssunto = (strlen(trim($titulo)) >= $limite) ? trim(substr($titulo, 0, strrpos(substr($titulo, 0, $limite), " "))) . "..." : $titulo;
                                                
                        echo $escreverAssunto;           
                        
                        ?></td>
                        <td id="tdValor<?php echo $chamado->getId(); ?>">
                            <?php 
                            
                            $limiteMsg = 30;
                            $mensagem = $chamado->getMensagem();
                            $escreverMsg = (strlen(trim($mensagem)) >= $limiteMsg) ? trim(substr($mensagem, 0, strrpos(substr($mensagem, 0, $limiteMsg), " "))) . "..." : $mensagem;
                            
                            echo $escreverMsg;
                            ?>
                 
                        </td>
                        
                        <td> <?php echo date('d/m/Y H:i:s', strtotime($chamado->getDataHoraCadastro())); ?> </td>
                           
                                
                        <td> <?php 
                                if ($chamado->getStatus() == "aberto") {
                                    $statusChamado = "<a class='ui small green header'>Aberto</a>";
                                }

                                if ($chamado->getStatus() == "atendimento") {
                                    $statusChamado = "<a class='ui small yellow header'>Em Atendimento</a>";
                                }

                                if ($chamado->getStatus() == "respondido") {
                                    $statusChamado = "<a class='ui small blue header'>Respondido</a>";
                                }
                                
                                if ($chamado->getStatus() == "cancelado") {
                                    $statusChamado = "<a class='ui small red header'>Cancelado</a>";
                                }
                                
                                if ($chamado->getStatus() == "aguardandousuario") {
                                    $statusChamado = "<a class='ui small header'>Aguardando Usuário</a>";
                                }
                                
                                echo $statusChamado;
                        ?> </td>
                        <td><a class='ui circular inverted icon button' id="btnDetalhesChamado<?php echo $chamado->getId()?>"><i class='ui big green zoom icon'></i></a></td>                        
                    </tr>
                    
                    <!-- MODAL DA RESPOSTA-->
                    
                    <script>
                        visualizarRespostaChamado('<?php echo $chamado->getId()?>');
                    </script>

                    <div class="ui standart modal" id="modalChamado<?php echo $chamado->getId() ?>">

                        <div class="header">
                            Chamado <?php echo $chamado->getCodigoChamado() ?>
                        </div>
                        <div class="content" id="camposAlterarStatus<?php echo $chamado->getId() ?>">

                                    <form class="ui form" id="formChamado<?php echo $chamado->getId() ?>" action="index.php" method="post">
                                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="ChamadoResposta"  />
                                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="responderChamado" />  
                                        <input type="hidden" id="hdnAdmin" name="hdnAdmin" value="SIM" /> 
                                        <input type="hidden" id="hdnAdmin" name="hdnEmailAssunto" value="Resposta Chamado" />
                                        <input type="hidden" id="hdnUsuario" name="hdnUsuario" value="<?php echo $chamado->getUsuario()->getId() ?>" /> 
                                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                                        <input type="hidden" id="hdnChamado" name="hdnChamado" value="<?php echo $chamado->getId() ?>" />

                                        <div id="divModalVisualizar<?php echo $chamado->getId() ?>">

                                        <div class="stackable two column ui grid container">
                                            <div class="column">
                                                <div class="ui segment">
                                                    <a class="header">Tipo de Chamado</a>
                                                    <div class="description"> <?php echo Chamado::retornarTipo($chamado->getChamadoAssunto()->getIdTipo())?></div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="ui segment">
                                                    <a class="header">Assunto</a>
                                                    <div class="description"><?php echo $chamado->getChamadoAssunto()->getAssunto(); ?></div>
                                                </div>
                                            </div>
                                        </div>   

                                        <div class="stackable one column ui grid container">
                                            <div class="column">
                                                <div class="ui segment"><a class="header">Mensagem</a>
                                                    <div class="description"> <?php echo $chamado->getMensagem(); ?></div>
                                                </div>
                                            </div>    
                                        </div>

                                        <div class="stackable two column ui grid container">

                                            <div class="column">
                                                <div class="ui segment"><a class="header">Data do Cadastro - Status</a>
                                                    <div class="description"><?php echo $chamado->getDataHoraCadastro()." - ".$statusChamado; ?>
                                                    </div>
                                                </div>       
                                            </div>

                                            <div class="column">
                                                    <div class="ui segment"><a class="header">Trocar Status</a><br>
                                                        <div class="ui selection dropdown">
                                                            <input type="hidden" name="sltStatusChamadoResposta" id="sltStatusChamadoResposta" value="atendimento">
                                                            <div class="text">Selecione</div>
                                                            <i class="dropdown icon"></i>
                                                            <div class="menu">
                                                                <div class="item" data-value="atendimento">Em Atendimento</div>
                                                                <div class="item" data-value="aguardandousuario">Aguardando Resposta Usuário</div>
                                                                <div class="item" data-value="respondido">Respondido</div>
                                                            </div>
                                                        </div>     
                                                    </div>       
                                            </div>
                                        </div>    
                                            
                                        <div class="stackable one column ui grid container">
                                            <div class="column">
                                                <div class="ui segment"><a class="header">Resposta</a>                                            
                                                    
                                                    <div class="description">
                                                        <textarea rows="5" cols="100" id="txtRespostaChamado" name="txtRespostaChamado" maxlength="1000"></textarea>
                                       
                                                    </div>
                                                </div>       
                                            </div>

                                        </div>    
                                        
                                        <div class="stackable one column ui grid container">
                                            <div class="column">
                                                <div class="ui segment">
                                                      <a class="header">Respostas já cadastradas</a><br>
                                                      <?php 
                                                      $totalResposta = count($chamado->getChamadoResposta());  
                                                      //var_dump($chamado->getChamadoResposta());//echo "respostas: ".$totalResposta;
                                                      if($totalResposta >= 1){
                                                          
                                                            if($totalResposta == 1){
                                                                
                                                                if($chamado->getChamadoResposta()->getAdministracao() == "SIM"){
                                                                            $adminPIP = "PIP Cadastrou";
                                                                        } else $adminPIP = "Usuário Cadastrou";
                                                                
                                                                switch ($chamado->getChamadoResposta()->getStatus()){
                                                                      case "aberto": $respChamado = "<a class='ui small green  header'>Aberto</a>"; break;
                                                                      case "atendimento": $respChamado = "<a class='ui small yellow header'>Em Atendimento</a>"; break;
                                                                      case "aguardandousuario": $respChamado = "<a class='ui small header'>Aguardando Usuário</a>"; break;
                                                                      case "respondido": $respChamado = "<a class='ui small blue header'>Respondido</a>"; break;
                                                                  }  
                                                                  
                                                                echo $adminPIP." - ".$chamado->getChamadoResposta()->getDatahoracadastro()." - ".$respChamado." - ".$chamado->getChamadoResposta()->getResposta()."<br>";
                                                                
                                                            } if($totalResposta > 1){
                                                                
                                                                for($x=0; $x < $totalResposta; $x++){ 
                                                                    
                                                                    if($chamado->getChamadoResposta()[$x]->getAdministracao() == "SIM"){
                                                                            $adminPIP = "PIP Cadastrou";
                                                                        } else $adminPIP = "Usuário Cadastrou";

                                                                  switch ($chamado->getChamadoResposta()[$x]->getStatus()){
                                                                      case "aberto": $respChamado = "<a class='ui small green  header'>Aberto</a>"; break;
                                                                      case "atendimento": $respChamado = "<a class='ui small yellow header'>Em Atendimento</a>"; break;
                                                                      case "aguardandousuario": $respChamado = "<a class='ui small header'>Aguardando Usuário</a>"; break;
                                                                      case "respondido": $respChamado = "<a class='ui small blue header'>Respondido</a>"; break;
                                                                  }  
                                                                  echo $adminPIP." - ".$chamado->getChamadoResposta()[$x]->getDatahoracadastro()." - ".$respChamado." - ".$chamado->getChamadoResposta()[$x]->getResposta()."<br>";
                                                                } 
                                                              }                                                              
                                                            //}                                                       
                                                                                                                  
                                                          } else echo "Nenhuma resposta cadastrada para o chamado"
                                                      
                                                      ?>
                                                </div>
                                            </div>
                                       </div>                                                
                                    </div>                                                                                        
                                </form>
                            </div>
                        <div id="divRetornoResposta<?php echo $chamado->getId(); ?>"></div>

                        <div class="actions">

                            <?php if($chamado->getStatus() != "cancelado"){?>
                            
                            <br>
                            
                             <?php if($chamado->getStatus() != "respondido") { ?>
                            
                            <div  id="botaoResponderChamado<?php echo $chamado->getId(); ?>" class="ui green labeled icon button">
                                <i class='check white icon'></i>Responder Chamado
                            </div>
                            
                             <?php } } ?>

                            <div  id="botaoFecharChamado<?php echo $chamado->getId(); ?>" class="ui red deny button">
                                Fechar
                            </div>
                        </div>


                    </div>
                    
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

<?php } //fim do else, caso haja chamados?> 

