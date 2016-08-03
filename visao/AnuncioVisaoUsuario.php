<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=pt"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>


<script>
     
        inicio();
        buscarAnuncio();
        carregarAnuncioUsuario();      
        enviarEmail();      
        carregarDiferencial();

</script>

<?php 
    
    $item = $this->getItem();
 
    $usuario = $item["usuario"][0];
    $cidadeEstado = $item["cidadeEstado"][0];
    $anuncios = $item["anuncio"];
    $diferenciais = $item["diferenciais"];
    
    if($usuario->getEndereco()->getNumero() != "" && $usuario->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getNumero().", ".$usuario->getEndereco()->getComplemento()." - ".$cidadeEstado->getCidade()->getNome().", ".$cidadeEstado->getEstado()->getUF();
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() != "" && $usuario->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getNumero()." - ".$cidadeEstado->getCidade()->getNome().", ".$cidadeEstado->getEstado()->getUF();
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() == "" && $usuario->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario->getEndereco()->getLogradouro()." - ".$cidadeEstado->getCidade()->getNome().", ".$cidadeEstado->getEstado()->getUF();                  
                    }
                    
                    elseif($usuario->getEndereco()->getNumero() == "" && $usuario->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario->getEndereco()->getLogradouro().", ".$usuario->getEndereco()->getComplemento()." - ".$cidadeEstado->getCidade()->getNome().", ".$cidadeEstado->getEstado()->getUF();
                    }
    
    ?>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="user blue icon"></i>
            <div class="content">
                Vendedor
                <div class="sub header">Informações do Vendedor</div>
            </div>
            
        </h2>
    </div>
 
</div>

<div class="ui middle aligned stackable grid container">
    
    <div class="column">
        <div class="ui horizontal divider">

            <?php if ($usuario->getFoto() != "") { ?>
                
                <div class="ui small rounded image">    
                
                    <img src="<?php echo PIPURL ?>/fotos/usuarios/<?php echo $usuario->getFoto(); ?>">
                    
                </div>    
                    
                    <?php } else { ?>
                        <img src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" class="img-circle" width="220px" height="150px">
                    <?php } ?>
        </div>  
    </div>
</div>    

<div class="stackable two column ui grid container">
    <div class="column">
        <div class="ui segment">
            <a class="header">Usuário do PIP OnLine desde:</a>
            <div class="description"> <?php echo date('d/m/Y', strtotime($usuario->getDataHoraCadastro())) ?></div>
        </div>
    </div>
    
    <div class="column">
        <div class="ui segment">
            <a class="header">Tipo de Pessoa:</a>
            <div class="description"> <?php if ($usuario->getTipoUsuario() == "pf") {
                 echo "Pessoa Física";
                } else echo "Pessoa Jurídica"; ?></div>
        </div>
    </div>
    
    <div class="column">
        <div class="ui segment">
            <a class="header"><?php
                if ($usuario->getTipoUsuario() == "pf") {
                    echo "Nome - Email:";
                } else
                    echo "Empresa - Email:"
                    ?></a>
            <div class="description"><?php echo $usuario->getNome() . " - " . $usuario->getEmail(); ?></div>
        </div>
    </div>
    <div class="column">
        <div class="ui segment"><a class="header">Endereço:</a>
            <div class="description"> <?php echo $endereco; ?></div>
        </div>
    </div>   
    
    <div class="ui hidden divider"></div>
    
</div>




<form class="ui form">    
   
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="volume orange control phone icon"></i>
            <div class="content">
                Telefone(s) do Vendedor
                <div class="sub header">Entre em contato com o vendedor</div>
            </div>
            
        </h2>
    </div> 

</div>     
    
<div class="stackable one column ui grid container">
 
    <div class="column">
        <div class="ui segment"><a class="header">Telefone(s):</a>
            <div class="description">
                <?php
                $quantidade = count($usuario->getTelefone());
                if ($quantidade == 1) {
                    $array = array($usuario->getTelefone());
                } else {
                    $array = $usuario->getTelefone();
                }
                foreach ($array as $telefone) {
                    if ($telefone->getWhatsApp() == "SIM") {
                        $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero() . "  <i class='large green whatsapp icon'></i> ";
                    } else
                        $fones[] = $telefone->getOperadora() . " - " . $telefone->getNumero();
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
    
    <div class="ui hidden divider"></div>
    
    <div class="row">
        <h2 class="ui header">
            <i class="announcement icon"></i>
            <div class="content">
                Anuncio(s) do Vendedor
                <div class="sub header">Veja os anúncios do vendedor</div>
            </div>
            
        </h2>
    </div> 
</div>


<div class="ui middle aligned stackable grid container">
 
    <div class="column">
    
    <?php
    
    include_once "modulo/menuBusca.php";
    
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
include_once "modal/AnuncioEnviarEmailModal.php";
?>