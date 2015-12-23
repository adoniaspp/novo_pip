
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/js/dataTables.fixedColumns.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/fixedColumns.dataTables.min.css">
<script src="assets/js/anuncio.js"></script>

<script>
    $(document).ready(function () {

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "columnDefs": [
                {"orderable": false, "targets": 6}
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
                <p>Veja os detalhes do anúncio, clicando no código. 
                Se você conseguiu negociar seu anúncio ou não deseja que ele continue ativo por outro motivo, clique
                em "Finalizar Negócio"
                </p>
            </div>
        </div>
    </div>
    
</div>
 
<div class="ui hidden divider"></div>

    <?php
    Sessao::gerarToken();

    $item = $this->getItem();
    
    $totalAnunciosCadastrados = count($item["listaAnuncio"]);
    
    if($totalAnunciosCadastrados < 1){      
    ?>
    
   
    
    <div class="ui middle aligned stackable grid container">
    
    <div class="column">
        
    <div class="ui info message">
        <div class="header">Mensagem</div>
        <ul class="list">
          <li>Você não possui mais anúncios ativos. Clique em voltar para retornar ao MEUPIP</li>
        </ul>
    </div>


   
    <div class="row">
    <a href="index.php?entidade=Usuario&acao=meuPIP">
    <button class="ui orange button">Voltar</button>
    </a>
    </div>
    
    <div class="row"></div>     
        
    </div>   
    </div>    

    <?php } else { //caso exista ao menos 1 anuncio cadastrado, exibir o datatable?>
    <div class="ui middle aligned stackable grid container">
    <div class="column">
    <table class="ui brown table" id="tabela">
        
        <thead>
            <tr>
                <th>Cód. Anúncio</th>
                <th>Tipo</th>
                <th>Finalidade</th>
                <th>Titulo</th>
                <th>Descrição</th> 
                <th>Valor</th>
                <th>Status</th>
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
                        <form id="form" action="index.php" method="post" target='_blank'>
                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar"/>
                            <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio->getId() ?>"/>
                            <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $tipoImovel ?>"/>
               
                            
                            <button class="ui labeled icon button">
                            <i class="zoom icon"></i>
                            <?php echo $anuncio->getIdAnuncio(); ?>
                            </button>
                        
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
                        <td><?php echo $anuncio->getTituloAnuncio(); ?></td>
                        <td><?php echo $anuncio->getDescricaoAnuncio(); ?></td>
                        <td id="tdValor<?php echo $anuncio->getId(); ?>"><?php echo $anuncio->getValorMin(); ?></td>
                        <td> <?php
                                if ($anuncio->getStatus() == "cadastrado") {
                                    echo "Publicado em " . $anuncio->getDataHoraCadastro();
                                } elseif ($anuncio->getStatus() == "finalizado") {
                                    echo "Finalizado em: " . $anuncio->getHistoricoAluguelVenda()->getDatahora();
                                }
                                ?>
                        </td>

                        <td><?php echo "<a id='btnFinalizar" . $anuncio->getId() . "' class='ui red button'><i class='thumbs up icon'></i>Finalizar Negócio</a>" ?></td>

                    </tr>

                <?php
            }
        }
        ?>
        </tbody>
    </table>

    </div>
</div>

<div class="ui hidden divider"></div>

<?php
    if ($item) {
    foreach ($item["listaAnuncio"] as $anuncio) {
        ?>

<script>
  finalizar(<?php echo $anuncio->getId() ?>);
  formatarValor(<?php echo $anuncio->getId() ?>);
</script>

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
