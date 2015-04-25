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
    
    $usuario = $item["usuario"][0];
    $cidadeEstado = $item["cidadeEstado"][0];
    $anuncios = $item["anuncio"];
    
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
    
    <div class="ui two column page grid">
        <div class="ten wide column">
            <div class="ui raised segment">                                
                <a class="ui teal ribbon label">Informações <?php if ($usuario->getTipoUsuario() == "pf") {
                    echo "do Vendedor";
                } else echo "da Empresa"; ?></a>
                <div class='ui horizontal list'>
                    <div class='item'>
                        <div class='content'>
                            <div class='header'>Nome</div>
                        <?php echo strtoupper($usuario->getNome()); ?>
                        </div>
                    </div>
                    <div class='item'>
                        <div class='content'>
                            <div class='header'>Endereço</div>
                                <?php echo $endereco . " - "; ?>
                                <?php echo strtoupper($cidadeEstado->getCidade()->getNome()) . ", " . strtoupper($cidadeEstado->getEstado()->getUf()); ?>
                        </div>
                    </div>
                    <div class='item'>
                        <div class='content'>
                            <div class='header'>Tipo de Pessoa</div>
                            <?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "PESSOA FÍSICA";
                            } else echo "PESSOA JURÍDICA"; ?>
                        </div>
                    </div>
                    <div class='item'>
                        <div class='content'>
                            <div class='header'>Contato(s)</div>
                            <?php
                            if (is_array($usuario->getTelefone())) { //verifica se existe mais de um número de telefone cadastrado para o usuário                                 
                                foreach ($usuario->getTelefone() as $anuncioTelefone) {
                                    ?>  
                                    <?php echo strtoupper($anuncioTelefone->getOperadora()) . " - " . strtoupper($anuncioTelefone->getNumero())."<br />"; ?>				
                                <?php } ?>
                            <?php } else echo strtoupper($usuario->getTelefone()->getOperadora()) . " - " . strtoupper($usuario->getTelefone()->getNumero()); ?>
                        </div>
                    </div> 
                    <div class='item'>
                        <div class='content'>
                        <?php if ($usuario->getFoto() != "") { ?>
                                    <img src="<?php echo PIPURL ?>/fotos/usuarios/<?php echo $usuario->getFoto() ?>" class="img-thumbnail" width="120" height="120" style="margin-left: 60px">

                                <?php } else { ?>
                                    <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" class="img-circle" width="120" height="120" style="margin-left: 60px">
                                <?php } ?>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
 
    </div>
    
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span><h4>Imóveis <?php if($usuario->getTipoUsuario() == "pf"){echo "do Vendedor";} else echo "da Empresa";?></h4>
        
        
        
        <table class="table table-hover">
            <thead>

            </thead>
            <tbody>

            <br/>

            <?php
            //$itensAnuncio = $this->getItem();
            if ($anuncios) {
                foreach ($anuncios as $anuncio) {   
        ?>
            <?php //echo "Finalidade: ". $anuncio->getFinalidade();?>

        <div class="panel panel-warning col-md-11"  id="<?php echo $anuncio->getId();?>" >

        <div class="panel-body">
        
        <fieldset class="col-md-9">
                        
                        <div data-row-span="1">
                        <input type="checkbox" id="selecoes_<?php echo $anuncio->getId(); ?>" class="option" name="selecoes[]" value=<?php echo $anuncio->getId(); ?>> Selecionar Imóvel   
                        </div>
            
                        <div data-row-span="7">
				<div data-field-span="2">
                                    <label style="text-align: center">Título</label>
					<?php echo "<span class='label label-info'>" . strtoupper($anuncio->getTituloAnuncio()) . "</span>"; ?>
				</div>
                            
                                <div data-field-span="1">
					<label style="text-align: center">Tipo</label>
					<?php echo "<span class='label label-warning'>" . strtoupper($anuncio->getImovel()->getTipo()) . "</span>"; ?>
				</div>
                            
				<div data-field-span="1">
					<label style="text-align: center">Finalidade</label>
					<?php echo "<span class='label label-primary'>" . strtoupper($anuncio->getFinalidade()) . "</span>"; ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Quarto(s)</label>
					<?php echo $anuncio->getImovel()->getQuarto(); ?>
				</div>
                                <div data-field-span="1">
                                    <label style="text-align: center">Área (em m<sup>2</sup>)</label>
					<?php echo $anuncio->getImovel()->getArea(); ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Condição</label>
					<?php echo $anuncio->getImovel()->getCondicao();?>
				</div>
			</div>
            
			<div data-row-span="7">
				<div data-field-span="3">
					<label style="text-align: center">Descrição</label>
					<?php echo $anuncio->getImovel()->getDescricao(); ?>
				</div>
				<div data-field-span="1">
					<label style="text-align: center">Valor</label>
					 R$ <?php echo $anuncio->getValor(); ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Banheiro(s)</label>
					<?php echo $anuncio->getImovel()->getBanheiro(); ?>
				</div>
                                 <div data-field-span="1">
					<label style="text-align: center">Garagem(ns)</label>
					<?php echo $anuncio->getImovel()->getGaragem(); ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Referência</label>
					<?php echo "<span class='label label-info'>" . substr($anuncio->getImovel()->getDatahoracadastro(), 6, -9) . substr($anuncio->getImovel()->getDatahoracadastro(), 3, -14) . str_pad($anuncio->getImovel()->getId(), 5, "0", STR_PAD_LEFT) . "</span>"; ?>
				</div>
			</div>
            
                        <div data-row-span="7">
                            <div data-field-span="3" style="background-color: #e4fcff">
					<label style="text-align: center;">Endereço</label>
					<?php echo $anuncio->getImovel()->getEndereco()->getLogradouro() . ", Nº " . $anuncio->getImovel()->getEndereco()->getNumero();?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Cidade</label>
					<?php echo $anuncio->getImovel()->getEndereco()->getCidade()->getNome() ;?>
				</div>
				<div data-field-span="1">
					<label style="text-align: center">Bairro</label>
					<?php echo $anuncio->getImovel()->getEndereco()->getBairro()->getNome(); ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Suite(s)</label>
					<?php echo $anuncio->getImovel()->getSuite(); ?>
				</div>
                                 <div data-field-span="1">
					<label style="text-align: center">Condição</label>
					<?php echo $anuncio->getImovel()->getCondicao(); ?>
				</div>
                                
			</div>

        </fieldset>
            <br/>
            <fieldset class="col-md-2">
                
                <div>
                    <img src="<?php echo $anuncio->getImagem()->getDiretorio(); ?>" height="160" width="160" class="img-thumbnail" style="margin-left: 60px">
                    
                </div>
                
                <br/>
                
                <div>

                    <button type="button" id="btnAnuncioModal" class="btn btn-default btn-sm" data-toggle="modal" data-target="#divAnuncioModal" data-modal="<?php echo $anuncio->getId(); ?>" data-title="<?php echo $anuncio->getTituloAnuncio(); ?>" style="margin-left: 60px">
                        <span class="glyphicon glyphicon-plus-sign"></span> Veja mais detalhes
                    </button>
                  
                </div>
                  
            </fieldset>
            
        </div>
            
        </div>    
            
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
              
        <?php } } else echo "<span class='text-info'><strong>Nenhum anuncio cadastrado</strong></span>";?>

            </tbody>
            
        </table>
     
</div>
</form>


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