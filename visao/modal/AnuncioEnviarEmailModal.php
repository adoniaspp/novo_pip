<div class="ui standart modal" id="modalEmail">
    <i class="close icon"></i>
    <div class="header">
        Anúncio(s) Selecionado(s): <div id="idAnunciosCabecalho"></div>
    </div>
    
    <div class="ui visible message" id="divMsg">Envie o(s) Anúncio(s) selecionado(s) para o e-mail desejado</div>
    
    <div class="content" id="camposEmail">
        <div class="description">
            <div class="ui piled segment">
                <p id="textoConfirmacao"></p>

                <form class="ui form" id="formEmail" action="index.php" method="post">
                    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                    <input class="emailPDF" type="hidden" id="hdnAcao" name="hdnAcao" value="enviarEmail" />               

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
                        <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random(); return false">
                            <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                        <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
                    </div>

                    <div id="idAnuncios"></div>

                </form>

            </div>
        </div>
    </div>
    <div id="divRetorno"></div>
    <div class="actions">
        <div  id="botaoCancelarEmail" class="ui red deny button">
            Cancelar
        </div>
        <div  id="botaoEnviarEmail" class="ui positive right labeled icon button">
            Enviar
            <i class="checkmark icon"></i>
        </div>
        <div  id="botaoFecharEmail" class="ui red deny button">
            Fechar
        </div>
    </div>
</div>