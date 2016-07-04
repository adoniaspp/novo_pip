
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.fixedColumns.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/fixedColumns.dataTables.min.css">
<script src="assets/js/anuncio.js"></script>

<!-- os dois scripts abaixo realizam a formatação de data para ordenação-->
<script src="assets/libs/datatables/js/moment.min.js"></script>
<script src="assets/libs/datatables/js/datetime-moment.js"></script>

<script>
    $(document).ready(function () {
        
        exibirEmailPDFListaAnuncio();
        
        //função que ordena a data, de acordo com o formato
        $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );
        
        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "columnDefs": [
                {"orderable": false, "targets": 0}, {"orderable": false, "targets": 6}, {"orderable": false, "targets": 7}, {"orderable": false, "targets": 8}
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
                <a class="active section">Visualizar Anúncios</a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="column">
            <div class="ui message">
                <p>Veja os detalhes do anúncio clicando no código. 
                Se você conseguiu negociar seu anúncio ou não deseja que ele continue ativo por algum motivo, clique
                em "Finalizar Negócio". Caso queria mudar o valor, clique em "Alterar Valor"
                </p>
            </div>
        </div>
    </div>
    
</div>
 
<div class="ui hidden divider"></div>

    <?php
    Sessao::gerarToken();
   
    $item = $this->getItem();    
/*    
    echo "<pre>";
    var_dump($item);
    echo "</pre>";
*/  
    $totalAnunciosCadastrados = count($item["listaAnuncio"]);
    
    if($totalAnunciosCadastrados < 1){      
    ?>
   
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="column">
            <div class="ui warning message">
                <div class="header">Mensagem</div>
                <ul class="list">
                  Você não possui anúncios ativos. Clique em voltar para retornar ao MEUPIP
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

    <?php } else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable?>
    <div class="ui middle aligned stackable grid container">
    <div class="column">
    <table class="ui brown table" id="tabela">
        
        <thead>
            <tr>
                <th></th>
                <th>Cód. Anúncio</th>
                <th>Tipo</th>
                <th>Finalidade</th>
                <th>Valor</th>
                <th>Publicação</th>
                <th>Expiração</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($item) {
                foreach ($item["listaAnuncio"] as $anuncio) {
                    
                    switch ($anuncio->getImovel()->getIdTipoImovel()){
                                
                                case 1: $tipoImovel = "casa"; break;
                                case 2: $tipoImovel = "apartamentoplanta"; break;
                                case 3: $tipoImovel = "apartamento"; break;
                                case 4: $tipoImovel = "salacomercial"; break;
                                case 5: $tipoImovel = "prediocomercial"; break;
                                case 6: $tipoImovel = "terreno"; break;
                                
                            }
                    
                    ?>
                    <tr>
                        <td> 
                        
                        <div class="ui checkbox">
                                <input type="checkbox" tabindex="0" class="hidden" name="chkAnuncio[]" 
                                       id="chkAnuncio<?php echo $anuncio->getId(); ?>" 
                                        value="<?php echo $anuncio->getId(); ?>">
                                <label></label>
                        </div>
                        
                        </td>
                        <td>                          
                            
                        <form id="form" action="index.php" method="post" target='_blank'>
                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar"/>
                            <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio->getId() ?>"/>
                            <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>
                            
                            
                            
                            <button class="ui labeled icon button">
                            <i class="zoom icon"></i>
                            <?php echo $anuncio->getIdAnuncio(); ?>
                            </button>
                            <input type="hidden" name="hdnCodAnuncioFormatado[]" value="<?php echo $anuncio->getIdAnuncio()?>" />
                        </form>     
                        </td>
                        <td><?php 
                        
                        switch ($anuncio->getImovel()->getIdTipoImovel()){
                                
                                case 1: echo "Casa"; break;
                                case 2: echo "Apartamento na Planta"; break;
                                case 3: echo "Apartamento"; break;
                                case 4: echo "Sala Comercial"; break;
                                case 5: echo "Prédio Comercial"; break;
                                case 6: echo "Terreno"; break;
                                
                            }  
                        
                        ?></td>
                        <td><?php echo $anuncio->getFinalidade(); ?></td>
                        <td id="tdValor<?php echo $anuncio->getId(); ?>">
                            <?php 
                            
                            if($anuncio->getNovoValorAnuncio() != null){
                                                                
                                 foreach($anuncio->getNovoValorAnuncio() as $nValor){

                                    if($nValor->getStatus() == "ativo"){
                                        
                                        echo $nValor->getNovoValor();   
                                        
                                    }                         
                                    
                                 }    
          
                            } else echo $anuncio->getValorMin();  
                          
                            ?>
                 
                        </td>
                        
                        <td> <?php echo date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro())); ?> </td>
                        
                        <td> <?php 
                        $date = date_create($anuncio->getDataHoraCadastro());
                        date_add($date, date_interval_create_from_date_string( $anuncio->getUsuarioPlano()->getPlano()->getvalidadepublicacao().' days'));
                        echo date_format($date, 'd/m/Y');
                        ?> </td>

                        <td><?php echo "<a id='btnFinalizar" . $anuncio->getId() . "' class='ui small red button'>Finalizar Negócio</a>"?></td>
                        <td><?php echo "<a id='btnAlterarValor" . $anuncio->getId() . "' class='ui small blue button'>Alterar Valor</a>" ?></td>
                        <td>
                            <?php 
                        
                            if($anuncio->getNovoValorAnuncio() != null){
                                echo "<a id='btnMostrarValor" . $anuncio->getId() . "' class='ui small green button'>Valores Antigos</a>";
                            }

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
        
        if($anuncio->getNovoValorAnuncio() != null){

            foreach($anuncio->getNovoValorAnuncio() as $valorContador){
             
            ?>
            
            <script>
            formatarValorCampos(<?php echo $valorContador->getId() ?>);
            </script>
            
            <?php

                 if($valorContador->getStatus() == "inativo"){ //traz todos os valores que estão inativos

                     $contador = $contador + 1;
                     
                     $menorId[] = $valorContador->getId(); //insere em um array para depois buscar o menor
                     
                 }           

             } 
             
             $menor = min($menorId); //busca o id mais antigo cadastrado dos inativos. Primeiro valor alterado
             
             foreach($anuncio->getNovoValorAnuncio() as $valorPrimeiro){

                 if ($valorPrimeiro->getId() == $menor) {
                     
                     //primeiro valor alterado para inserir a data da inativação do valor original
                     $primeiroValorAlterado = $valorPrimeiro->getDataHoraCadastro();
                     
                 }

             }
             
             if($contador > 0){
          
                 foreach($anuncio->getNovoValorAnuncio() as $nValor){
                     
                    ?>
            
                    <script>
                    formatarValorUnico(<?php echo $nValor->getId() ?>);
                    </script>

                    <?php
                 
                    if($nValor->getStatus() == "inativo"){
                        
                        echo "<tr><td id='formatarValorJS".$nValor->getId()."'>".$nValor->getNovoValor()."</td><td>".date('d/m/Y H:i:s', strtotime($nValor->getDataHoraCadastro()))."</td><td>".date('d/m/Y H:i:s', strtotime($nValor->getDataHoraInativacao()))."</td></tr>"; 
                                        
                    }
                 }
             }
             
             if($contador == 0){ //caso exista apenas 1 valor trocado, ou seja, ele está ativo
        
                 foreach($anuncio->getNovoValorAnuncio() as $nValor){
                     
                 ?>
            
                 <script>
                 formatarValorUnico(<?php echo $nValor->getId() ?>);
                 </script>
                 
                 <?php                
                     
                     $primeiroValorAlterado = date('d/m/Y H:i:s', strtotime($nValor->getDataHoraCadastro()));
                     
                 }             
                 
             }
            //buscar da tabela anúncio o valor original cadastrado. A data da inativação é quando foi cadastrado o primeiro novo valor                    
            echo "<tr><td id='formatarValorUnicoJS".$nValor->getId()."'>".$anuncio->getValorMin()."</td><td>".date('d/m/Y H:i:s', strtotime($anuncio->getDataHoraCadastro()))."</td><td>".$primeiroValorAlterado."</td></tr>";  

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



<div class="ui standart modal" id="modalAlterarValorAnuncio<?php echo $anuncio->getId() ?>">
    <div class="header">
        Alterar Valor
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
                           
                           if($anuncio->getNovoValorAnuncio() != null){
                                                                
                                 foreach($anuncio->getNovoValorAnuncio() as $nValor){

                                    if($nValor->getStatus() == "ativo"){
                                        
                                        echo $nValor->getNovoValor();   
                                        
                                    }                      
                                     
                                 }                               
                                
                            } else echo $anuncio->getValorMin();  
                           
                           ?>"/>    
                    
                    <div class="ui message">
                        <p>Digite o novo valor para seu anúncio. <strong>ATENÇÃO:</strong> O valor atual será substituido pelo novo
                        </p>
                    </div>
                    
                    <div class="field" id="divValorAtual<?php echo $anuncio->getId(); ?>">
                    
                        <?php if($anuncio->getNovoValorAnuncio() != null){
                                                                
                                 foreach($anuncio->getNovoValorAnuncio() as $nValor){
                                     
                                    if($nValor->getStatus() == "ativo"){
                                        
                                        echo $nValor->getNovoValor();   
                                        
                                    } 
                                 
                                 }                               
                                
                            } else echo $anuncio->getValorMin();   ?>         
                        
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
            Alterar Valor
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
                                      <div class="ui radio checkbox checked">
                                          <input class="hidden" tabindex="0" name="radioSucesso" id="radioSucesso<?php echo $anuncio->getId() ?>" type="radio" value="SIM">
                                        <label>Sim</label>
                                      </div>
                                    </div>
                                    <div class="field">
                                      <div class="ui radio checkbox">
                                          <input class="hidden" tabindex="0" name="radioSucesso"  id="radioSucesso<?php echo $anuncio->getId() ?>" type="radio" value="NAO">
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

<?php } //fim do else, caso haja anuncios ativos?> 

<?php
include_once "/modal/AnuncioEnviarEmailModal.php";
?>