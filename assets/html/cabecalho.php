
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        
        <meta charset="UTF-8">
        <title>PIP - Procure Im&oacute;veis Pai D'Egua</title> 
        <!-- JQUERY --> 
        <script src="<?php echo PIPURL; ?>/assets/libs/jquery/jquery-2.1.3.min.js"></script> 
        <!-- SEMANTIC UI --> 
        <link href="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.css" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo PIPURL; ?>/assets/libs/semantic-ui/semantic.min.js"></script> 

        <script src="assets/js/usuario.js"></script>
        <!-- Template PIP -->
        <link href="<?php echo PIPURL; ?>/assets/css/template-pip.css" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">        
    </head>

<script>
 $(document).ready(function() {
<?php
if (Sessao::verificarSessaoUsuario()) { ?>
     exibirMeuPIP("SIM", "<?php echo ucfirst(strtolower(explode(" ", $_SESSION['nome'])[0])); ?>");
     logout();
<?php } else {?>
    
    exibirMeuPIP("NAO", "");
    
<?php }?>
})  
</script>

        <div class="container">  
            <nav class="ui menu inverted navbar page grid" style="background-color: #ffffff" style="margin-bottom:300px">
                <a href="<?php echo PIPURL; ?>/index.php"> <img src="<?php echo PIPURL; ?>/assets/imagens/logo.png" width="120px"/></a>
               
            <div id="loginCadastro">
                
                <div class="ui menu">
                    <div class="item">
                        <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=login"><div class="ui primary button" id="btnAcessar">LOGIN</div></a>
                    </div>
                    <div class="item">
                        <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=cadastro"<div class="ui button">CADASTRAR-SE</div></a>
                    </div>
            </div>
                    
        </div>
                <!--<label for="CaptchaCode">Retype the characters from the picture:</label>
<?php // Adding BotDetect Captcha to the page 
  /*$SampleCaptcha = new Captcha("SampleCaptcha");
  $SampleCaptcha->UserInputID = "CaptchaCode";
  echo $SampleCaptcha->Html(); */
?>

<input name="CaptchaCode" id="CaptchaCode" type="text" />-->
                
                
            <div id="divUsuario" class="right menu hide" style="margin-left:800px; margin-top: -80px">
                <form>
                           
                    <div class="ui center aligned compact segment" style="margin-bottom: 10px">
                        <div id="divNome" style="margin-bottom: -10px"> </div>
                        <div>
                            <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=meuPIP" class="ui primary button"> <i class="block layout icon"></i> Meu PIP </a>
                            <a id="btnLogout" href="#" class="ui red button"><i class="power icon"></i> Sair</a>  
                        </div>
                    </div>
                        
                        
                </form>            
            </div>
