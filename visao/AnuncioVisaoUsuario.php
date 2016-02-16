<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=pt"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>


<script>
 
    //$(document).ready(function() {        
        inicio();
        //buscarAnuncioUsuario();
        buscarAnuncio();
        carregarAnuncioUsuario();      
        enviarEmail();      
        carregarDiferencial();
    //})
</script>

<?php 
    
    $item = $this->getItem();
    $usuario = $item["usuario"][0];
    $cidadeEstado = $item["cidadeEstado"][0];
    $anuncios = $item["anuncio"];
    $diferenciais = $item["diferenciais"];
    
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

<form class="ui form">
    
<div class="ui middle aligned stackable grid container">

        <div class="column">
   
            <div class="ui dividing header">
                
                <div class="ui large teal label">Informações do Vendedor</div>
                    
            </div>
            
            <div class="fields">    
            
            <div class="five wide field">

                <?php if ($usuario->getFoto() != "") { ?>
                    <img width="220px" height="120px" src="<?php echo PIPURL ?>/fotos/usuarios/<?php echo $usuario->getFoto(); ?>" style="" >

                    <?php } else { ?>
                        <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" class="img-circle" width="120px" height="120px">
                    <?php } ?>

            </div>    
         
            
            <div class="six wide field">
                <div class="ui header">
                    <input type="hidden" id="hdUsuario" name="hdUsuario" value="<?php echo $usuario->getId();?>" 
                    <label><?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "Nome";
                            } else echo "Empresa"; ?>
                    </label>
                    <br>
                    <div class="content">                                               
                        <div class="sub header">
                            <?php echo strtoupper($usuario->getNome()); ?>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="five wide field">
                <div class="ui header">
                    <label>Tipo de Pessoa</label>
                    <br>
                    <div class="content">                                               
                        <div class="sub header">
                            <?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "Pessoa Física";
                            } else echo "Pessoa Jurídica"; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="nine wide field">
                <div class="ui header">
                    <label><?php if ($usuario->getTipoUsuario() == "pf") {
                                echo "Endereço";
                            } else echo "Localização"; ?>
                    </label>
                    <br>
                    <div class="content">                                               
                        <div class="sub header">
                        <?php echo $endereco . " - "; ?>
                        <?php echo strtoupper($cidadeEstado->getCidade()->getNome()) . ", " . strtoupper($cidadeEstado->getEstado()->getUf()); ?>
                        </div>
                    </div>
                </div>
            </div>  
                
               
                
        </div>
         
           
    
        <div class="ui dividing header">
                
                <div class="ui large orange label">Contato(s)</div>
                    
        </div>
                
        
            <div class="fields">
                
                <div class="eight wide field">
                    
                    
                    <?php
                        $quantidade = count($usuario->getTelefone());
                        if ($quantidade == 1) {
                            $array = array($usuario->getTelefone());
                        } else {
                            $array = $usuario->getTelefone();
                        }
                        foreach ($array as $telefone) {
                            if($telefone->getWhatsApp()=="SIM"){
                                $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero() . "  <i class='large green whatsapp icon'></i> ";
                            }else $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero();
                        }

                        $fonesImplode = implode(" | ", $fones); //retirar a barra do último elemento

                        echo $fonesImplode;
                        ?>
     
                    </div>
                          
            </div>
           
            
    </div>      
    
</div>

</form> 

<div class="ui middle aligned stackable grid container">
 
    <div class="column">

    <div class="ui hidden divider"></div>
    
    <div class="ui dividing header">
                
        <div class="ui large blue label">Anúncio(s) <?php if($usuario->getTipoUsuario() == "pf"){echo "do Vendedor";} else echo "da Empresa";?></div> 
                    
    </div>
    
    <?php
    
    include_once "/modulo/menuBusca.php";
    
    ?>
    
    <div class="ui hidden divider"></div>
    
    <div class="ui segment" id="divAnuncios"></div> <!-- Exibe os resultados dos anuncios-->
       
    </div>
</div>
<script>
  /*  $(document).ready(function() {
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
*/

</script>


<!-- Modal Para Abrir a Div do Enviar Anuncios por Email -->
<?php
include_once "/modal/AnuncioEnviarEmailModal.php";
?>