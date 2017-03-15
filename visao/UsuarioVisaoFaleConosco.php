<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/js/buscaAnuncio.js"></script>

<script>
enviarDuvidaUsuario();
</script>

<div class="ui column doubling grid container">
    <div class="column">
        
        <h3 class="ui dividing header">Tira suas dúvidas sobre o PIP Online</h3>
        <div class="ui message">                
            Entre em contato conosco e tire suas dúvidas sobre o PIP Online. Iremos respondê-lo o mais breve possível 
        </div>
        
        <?php 

        if(!isset($_SESSION["idusuario"])){ //se o usuário não estiver logado, exibir os campos para cadastrado. 

        ?>
        
        <form id="form" class="ui form" action="index.php" method="post">
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
            <input type="hidden" id="hdnAcao" name="hdnAcao" value="faleConosco" />
            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

            <div class="two fields">
                
                <div class="field">
                    <label id="labelNome">Seu Nome</label>
                    <input name="txtNomeDuvida" id="txtNomeDuvida" placeholder="Digite Seu Nome" type="text" maxlength="50">
                </div>
                
                <div class="field">
                    <label>Seu E-mail</label>
                    <input name="txtEmailDuvida"  id="txtEmailDuvida" placeholder="Digite seu email" type="text" maxlength="50">
                </div>
                
            </div>    
      
            <div class="field">
                <label id="labelNome">Título Mensagem</label>
                <input name="txtTituloDuvida" id="txtTituloDuvida" placeholder="Título Email" type="text" maxlength="50">
            </div>
            <div class="field">
                <label>Sua Mensagem</label>
                <textarea rows="2" id="txtMsgDuvida" name="txtMsgDuvida" maxlength="200"></textarea>
            </div>
            

            <div class="five wide field" id="duvidaCaptcha">
                <label>Digite o código abaixo:</label>
                <img id="captcha" src="../assets/libs/captcha/securimage/securimage_show.php" alt="CAPTCHA Image" />    
                <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random();
                                return false">
                    <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
            </div>
            <div class="ui hidden divider"></div>
            <div class="ui stackable two column grid container" id="botoesDuvidas">   
                
                <button class="ui green button" type="button" id="botaoEnviarDuvida">Enviar Dúvida</button>
   
                <div id="botaoCancelarDuvida" >
                <a href="index.php" class="ui orange deny button">            
                     Cancelar
                </a>
                </div>

            </div>
            
            <div class="ui hidden divider"></div>
            <div id="divRetorno"></div>
            
            <br>
        
        </form>
            
<?php 

    } if(isset($_SESSION["idusuario"])){ //se o usuário estiver logado, informar que ele deve cadastrar a duvida na Central de Relacionamento 

?>  
        <div class="sixteen column">
            <div class="ui warning message">
                <i class='big yellow warning circle icon'></i>
                <strong>Caro usuário</strong>, acesse a Central de Relacionamento do MeuPIP para cadastrar sua dúvida.
            </div>
        </div>
    
<?php } ?>        
        
    </div>
</div>