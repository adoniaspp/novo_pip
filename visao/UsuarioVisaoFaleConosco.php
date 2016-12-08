
<div class="ui column doubling grid container">
    <div class="column">
        <form id="form" class="ui form" action="index.php" method="post">
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
            <input type="hidden" id="hdnAcao" name="hdnAcao" value="faleConosco" />
            <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
            <h3 class="ui dividing header">Preencha os campos abaixo para falar conosco</h3>

            <div class="ui message">
                Veja todos os seus anúncios, edite, exclua e reative-os de forma rápida e fácil, 
                altere seu perfil com segurança, administre suas mensagens recebidas, envie seus anúncios por e-email e muito mais.
            </div>              
            <div class="field">
                <label id="labelNome">Seu Nome</label>
                <input name="txtNomeEmail" id="txtNomeEmail" placeholder="Digite Seu Nome" type="text" maxlength="50">
            </div>
            <div class="field">
                <label>Sua Mensagem</label>
                <textarea rows="2" id="txtMsgEmail" name="txtMsgEmail" maxlength="200"></textarea>
            </div>
            <div class="field">
                <label>E-mail de Destino</label>
                <input name="txtEmailEmail"  id="txtEmailEmail" placeholder="Digite o email" type="text" maxlength="50">
            </div>

            <div class="five wide field">
                <label>Digite o código abaixo:</label>
                <img id="captcha" src="../assets/libs/captcha/securimage/securimage_show.php" alt="CAPTCHA Image" />    
                <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random();
                                return false">
                    <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
            </div>
            <div class="ui hidden divider"></div>
            <div class="ui stackable two column grid container">                
                <div  id="botaoEnviarEmail" class="ui positive right labeled icon button">
                    Enviar
                    <i class="checkmark icon"></i>
                </div>      
                <div id="botaoCancelarEmail" >
                <a href="index.php" class="ui red deny button">            
                     Cancelar
                </a>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>


