<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>

<script>
 
    $(document).ready(function() {
        
        buscarAnuncioUsuario();
        
        carregarAnuncio();
    })
</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 

    <form class="grid-form" id="form" action="index.php" method="post">
    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="comparar" />
    <style type="text/css">
        <!-- div#btncomparar {position:fixed;top:370px;right:80px} →</style>
    <style type="text/css">
        <!-- div#btnEnviarEmail {position:fixed;top:330px;right:80px} →</style>

    <div id="btncomparar">
        <button type="submit" class="btn" id="btncomparar" value="Comparar">Comparar</button>
    </div>
    <br>


    <div id="btnEnviarEmail">
        <button type="button" id="btnEnviarEmail" class="btn btn-default btn-sm" style="margin-left: 60px" 
                data-toggle="modal" data-target="#divEmailModal" data-modal="<?php echo $anuncio->id; ?>" 
                data-title="<?php echo $anuncio->tituloanuncio; ?>">
            <span class="glyphicon glyphicon-plus-sign"></span> Enviar Email
        </button>
    </div>
    
    <?php 
    
    $item = $this->getItem();
    
    /*echo "<pre>";
    var_dump($item);
    echo "</pre>";*/
    
    $usuario = $item["usuario"][0];
    $cidadeEstado = $item["cidadeEstado"][0];
    $anuncios = $item["anuncio"];
    $diferenciais = $item["diferenciais"];
    
    
    if (count($item['anuncio']) == 1) {
    $linhas = 1;
    $ultimaLinha = 1;
} else {
    $itens = count($item['anuncio']);
    $linhas = round($itens / 3);
    $ultimaLinha = $itens - (($linhas-1) * 3);
}
    
    
    if($usuario->getEndereco()->getNumero() != "" && $usuario->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getNumero().", ".$usuario->getEndereco()->getComplemento();
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() != "" && $usuario->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getNumero();
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() == "" && $usuario->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario->getEndereco()->getLogradouro();                  
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() == "" && $usuario->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getComplemento();
                    }
    
    ?>
    
    
    <div class="ui two column centered page grid">        
    
     <div class="ten wide column">
        
      <div class="ui form segment">
          
        <div class="ui two stackable padded grid">
            
            <div class="twelve wide column">
                
                <div class="fields">
                    
                        <div class="eight wide field">
                            <a class="ui teal ribbon label">Informações <?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "do Vendedor";
                            } else echo "da Empresa"; ?></a>
                            <label>Nome</label>
                       <?php echo strtoupper($usuario->getNome()); ?> <br />
                            <label>Endereço</label>
                      <?php echo $endereco . " - "; ?>
                      <?php echo strtoupper($cidadeEstado->getCidade()->getNome()) . ", " . strtoupper($cidadeEstado->getEstado()->getUf()); ?>
                        </div>
                    
                    <div class="two wide field"></div>
                    <br>
                    <div class="six wide field">
                        <label>Tipo de Pessoa</label>
                       <?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "PESSOA FÍSICA";
                            } else echo "PESSOA JURÍDICA"; ?>
                      
                      <label>Contato(s)</label>
                       <?php
                            if (is_array($usuario->getTelefone())) { //verifica se existe mais de um número de telefone cadastrado para o usuário                                 
                                foreach ($usuario->getTelefone() as $anuncioTelefone) {
                                    ?>  
                                    <?php echo strtoupper($anuncioTelefone->getOperadora()) . " - " . strtoupper($anuncioTelefone->getNumero())."<br />"; ?>				
                                <?php } ?>
                            <?php } else echo strtoupper($usuario->getTelefone()->getOperadora()) . " - " . strtoupper($usuario->getTelefone()->getNumero()); ?>  
                      
                    </div>
                    
                </div>    
                               
                </div>
                <div class="three wide column">
                    <div class="ui horizontal segment">

                        <?php if ($usuario->getFoto() != "") { ?>
                            <img width="120px" height="120px" src="<?php echo PIPURL ?>/fotos/usuarios/<?php echo $usuario->getFoto(); ?>" >

                        <?php } else { ?>
                            <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" class="img-circle" width="120px" height="120px">
                        <?php } ?>

                </div>
             </div>
          </div>
        </div>
      </div>
    </div>
    
    
    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
    
    <h4>Imóveis <?php if($usuario->getTipoUsuario() == "pf"){echo "do Vendedor";} else echo "da Empresa";?></h4>
        
    <table class="table table-hover">

    <tbody>

    <br/>
    
    <div class="ui form inverted blue segment" id="divBusca">
    <div class="ui center aligned column page grid">
        <div class="column">
            <div class="four fields">
                <div class="ui field">
                    <label>Tipo de Imóvel</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltTipoImovel" id="sltTipoImovel">
                        <div class="default text">Informe o Tipo do Imóvel</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Todos os Tipos</div>
                            <div class="item" data-value="casa">Casa</div>
                            <div class="item" data-value="apartamentoplanta">Apartamento na Planta/Novo</div>
                            <div class="item" data-value="apartamento">Apartamento</div>
                            <div class="item" data-value="salacomercial">Sala Cormecial</div>
                            <div class="item" data-value="terreno">Terreno</div>
                        </div>
                    </div>
                </div>
                <div class="ui field">
                    <label>Finalidade</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltFinalidade" id="sltFinalidade">
                        <div class="default text">Todas as Finalidades</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Todas as Finalidade</div>
                            <div class="item" data-value="venda">Venda</div>
                            <div class="item" data-value="aluguel">Aluguel</div>
                        </div>
                    </div>
                </div>
                <div class="ui field">
                    <label>Cidade</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltCidade" id="sltCidade">
                        <div class="default text">Todas as Cidade</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Todas as Cidade</div>
                            <div class="item" data-value="1">Belém</div>
                            <div class="item" data-value="2">Ananindeua</div>
                            <div class="item" data-value="3">Marituba</div>
                        </div>
                    </div>
                </div>
                <div class="ui field">
                    <label>Bairro</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltBairro" id="sltBairro">
                        <div class="default text">Selecione a Cidade</div>
                        <i class="dropdown icon"></i>
                        <div class="menu" id="menuBairro">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui center aligned column page grid padding-reset" id="divCaracteristicas">
        <div class="column">
            <div class="four fields">
                <!--                <div class="field" id="divPreenchimento1"></div>-->
                <div class="field" id="condicao">
                    <label>Condição</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltCondicao" id="sltCondicao">
                        <div class="default text">Informe a Condição</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Qualquer Condição</div>
                            <div class="item" data-value="novo">Novo</div>
                            <div class="item" data-value="usado">Usado</div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Quartos</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltQuartos" id="sltQuartos">
                        <div class="default text">Qualquer Quantidade</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Qualquer Quantidade</div>
                            <div class="item" data-value="1">1</div>
                            <div class="item" data-value="2">2</div>
                            <div class="item" data-value="3">3</div>
                            <div class="item" data-value="4">4</div>
                            <div class="item" data-value="5">Mais de 5</div>
                        </div>
                    </div>
                </div>

                <div class="five wide field" id="divValorVenda">
                    <label>Valor</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltValor" id="sltValor">
                        <div class="default text">Informe o Valor</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class='item' data-value=0>Menos de R$100.000</div>
                            <?php
                            $i = 100000;
                            while ($i < 1000000) {
                                print "<div class='item' data-value=" .
                                        $i . ">Entre R$" . number_format($i, 2, ',', '.') . " e R$" . number_format($i + 100000, 2, ',', '.') . "</div>";
                                $i = $i + 100000;
                            }
                            ?>
                            <div class='item' data-value=1000000>Mais de R$1.000.000</div>
                        </div>
                    </div>
                </div> 
                
                <div class="five wide field" id="divValorAluguel">
                    <label>Valor</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltValor" id="sltValor">
                        <div class="default text">Informe o Valor</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class='item' data-value=0>Menos de R$500</div>
                            <?php
                            $i = 500;
                            while ($i < 10000) {
                                print "<div class='item' data-value=" .
                                        $i . ">Entre R$" . number_format($i, 2, ',', '.') . " e R$" . number_format($i + 500, 2, ',', '.') . "</div>";
                                $i = $i + 500;
                            }
                            ?>
                            <div class='item' data-value=1000000>Mais de R$10.000</div>
                        </div>
                    </div>
                </div> 
                
                <div class="three wide field">
                    <br><br>
                    <div class="ui toggle checkbox">
                        <input type="checkbox" name="checkgaragem" id="checkgaragem">
                        <label>Garagem</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui center aligned column page grid padding-reset">
        <div class="column">
            <div class="field">
                <br>
                <div class="green ui icon button" id="btnBuscarAnuncioUsuario">
                    <input type="hidden" id="hdUsuario" value="<?php echo $usuario->getId() ;?>">
                    <i class="search icon"></i> 
                    PIP
                </div>
            </div>
        </div>
    </div>
</div>
    
    <?php
        if ($anuncios) {
                foreach ($anuncios["anuncio"] as $anuncio) { 
    ?>
    
   
<form id="form" action="index.php" method="post" target='_blank'>
    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar" />
    <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" />
    <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" />

</form>
<div id="load">
    <div class="ui text loader">Loading</div>
</div>     
    
    <!--
    <div class="panel panel-warning col-md-11"  id="<?php //echo $anuncio["idanuncio"];?>" >
    <div class="panel-body">
    <fieldset class="col-md-9">
                        
        <div data-row-span="1">
        <input type="checkbox" id="selecoes_<?php //echo $anuncio["idanuncio"]; ?>" class="option" name="selecoes[]" value=<?php echo $idanuncio["idanuncio"]; ?>> Selecionar Imóvel   
        </div>
            
        <div data-row-span="7">
            <div data-field-span="2">
                <label style="text-align: center">Título</label>
                <?php //echo "<span class='label label-info'>" . strtoupper($anuncio["tituloanuncio"]) . "</span>"; ?>
            </div>

            <div data-field-span="1">
                <label style="text-align: center">Tipo</label>
                <?php //echo "<span class='label label-warning'>" . strtoupper($anuncio["tipo"]) . "</span>"; ?>
            </div>

            <div data-field-span="1">
                <label style="text-align: center">Finalidade</label>
                <?php //echo "<span class='label label-primary'>" . strtoupper($anuncio["finalidade"]) . "</span>"; ?>
            </div>
                    
            <div data-field-span="1">
                <label style="text-align: center">Quarto(s)</label>
                <?php //echo $anuncio["quarto"]; ?>
            </div>
                    
            <div data-field-span="1">
                <label style="text-align: center">Área (em m<sup>2</sup>)</label>
                <?php //echo $anuncio["area"]; ?>
            </div>
                    
            <div data-field-span="1">
                        <label style="text-align: center">Condição</label>
                        <?php //echo strtoupper($anuncio["condicao"]); ?>
                    </div>
                </div>

                <div data-row-span="7">
                    <div data-field-span="3">
                        <label style="text-align: center">Descrição</label>
                        <?php //echo $anuncio["descricaoanuncio"]; ?>
                    </div>
                    <div data-field-span="1">
                        <label style="text-align: center">Valor</label>
                        R$ <?php //echo $anuncio["valormin"]; ?>
                    </div>
                    <div data-field-span="1">
                        <label style="text-align: center">Banheiro(s)</label>
                        <?php //echo $anuncio["banheiro"]; ?>
                    </div>
                    <div data-field-span="1">
                        <label style="text-align: center">Garagem(ns)</label>
                        <?php //echo $anuncio["garagem"]; ?>
                    </div>
                    <div data-field-span="1">
                        <label style="text-align: center">Referência</label>
                        <?php //echo "<span class='label label-info'>" . substr($anuncio->getImovel()->getDatahoracadastro(), 6, -9) . substr($anuncio->getImovel()->getDatahoracadastro(), 3, -14) . str_pad($anuncio->getImovel()->getId(), 5, "0", STR_PAD_LEFT) . "</span>"; ?>
                    </div>
                </div>

                <div data-row-span="7">
                    <div data-field-span="3" style="background-color: #e4fcff">
                        <label style="text-align: center;">Endereço</label>
                        <?php //echo $anuncio["logradouro"] . ", Nº " . $anuncio["numero"]; ?>
                    </div>
                    <div data-field-span="1">
                        <label style="text-align: center">Cidade</label>
                        <?php //echo $anuncio["cidade"]; ?>
                    </div>
                    <div data-field-span="1">
                        <label style="text-align: center">Bairro</label>
                        <?php //echo $anuncio["bairro"]; ?>
                    </div>
                    <div data-field-span="1">
                        <label style="text-align: center">Suite(s)</label>
                        <?php //echo $anuncio["suite"]; ?>
                    </div>

                </div>

            </fieldset>-->
 
              
        <?php } } else echo "<span class='text-info'><strong>Nenhum anuncio cadastrado</strong></span>";?>

            </tbody>
            
        </table>
     
</div>

<div class="ui center aligned column page grid">
</div>
<div class="ui red segment" id="divAnuncios">  
</div>
<!-- Modal Para Abrir a Div do Enviar Anuncios por Email -->
<div class="modal fade" id="divEmailModal" tabindex="-1" role="dialog" aria-labelledby="lblAnuncioModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" id="formEmail">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Enviar Anúncio</h4>
      </div>
      <div class="modal-body">
          <div id="alert" role="alert" class="alert alert-warning">
                      Preencha os dados abaixo para realizar o envio, por e-mail, dos anúncios selecionados. 
                    </div>
                <br>
<!--        <form role="form" id="formEmail">-->
           <div class="form-group">
            <label for="recipient-name" class="control-label">Nome:</label>
            <input type="text" class="form-control" id="txtNome">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">E-mail:</label>
            <input type="text" class="form-control" id="txtEmail" name="txtEmail">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Mensagem:</label>
            <textarea maxlength="200" class="form-control" id="txtMensagem"></textarea>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="btnEnviarEmailAnuncio" class="btn btn-primary">Enviar</button>
      </div>
            </form>
    </div>
  </div>
</div>


<div class="modal fade" id="divAnuncioModal" tabindex="-1" role="dialog" aria-labelledby="lblAnuncioModal" data-modal="" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div id="modal-body" class="modal-body text-center">
                                        </div>
                                    </div>
                                </div>
</div>
    </form>
<script>
    $(document).ready(function() {
    $('[id^=btnAnuncioModal]').click(function() {
            $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
            $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
            $("#modal-body").load("index.php", {hdnEntidade:'Anuncio', hdnAcao:'modal', hdnToken:'<?php //Sessao::gerarToken(); echo $_SESSION["token"]; ?>', hdnModal:$(this).attr('data-modal')});
        })
        
     var NumeroMaximo = 10;
        $("input[id^='selecoes_']").click(function() {
            if ($("input[id^='selecoes_']").filter(':checked').size() > NumeroMaximo) {
                alert('Selecione no máximo ' + NumeroMaximo + ' imóveis para a comparação');
                return false;
            }
        })

        $("#btncomparar").click(function() {
            //alert('teste');
            if ($("input[id^='selecoes_']").filter(':checked').size() <= 1)
            {
                alert('Selecione no mínimo 2 imóveis para a comparação');
                return false;
            }
        })
        
        $("#btnEnviarEmail").click(function() {
            //alert('teste');
            if ($("input[id^='selecoes_']").filter(':checked').size() <= 0)
            {
                alert('Selecione no mínimo 1 imóvel para envio');
                return false;
            }
        })
     
     });

</script>

