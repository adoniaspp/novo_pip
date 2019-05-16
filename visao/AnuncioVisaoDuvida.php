<script src="assets/libs/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/js/anuncio.js"></script>
<script src="assets/js/buscaAnuncio.js"></script>

<script>
cancelar("", "");
enviarDuvidaAnuncio();
formatarValorForm();
</script>

<?php 

$item = $this->getItem();
$leitura = false;

foreach ($item as $anuncio) {
    $finalidade = $anuncio->getFinalidade();   
    $idAnuncio = $anuncio->getId();   
}

if(isset($_SESSION)){    
    $idUsuario = $_SESSION['idusuario'];  
    $leitura = true;
}

?>

<div class="ui column doubling grid container">
    <div class="column">

        <h3 class="ui dividing header">Envie sua mensagem/proposta</h3>


        <form class="ui form" id="formDuvidaAnuncio" action="index.php" method="post">
            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
            <input type="hidden" id="hdnAcao" name="hdnAcao" value="enviarDuvidaAnuncio" />
            <input type="hidden" id="hdnUsuario" name="hdnUsuario" value="<?php echo $idUsuario ?>" />
            <input type="hidden" id="hdnAnuncio" name="hdnAnuncio" value="<?php echo $idAnuncio ?>" />

            <div class="field">
                <label>Seu Nome</label>
                <input name="txtNomeDuvida" id="txtNomeDuvida" placeholder="Digite seu Nome" type="text" maxlength="50" readonly="<?php echo $leitura ?>" value="<?php if ($leitura){ echo $_SESSION['nome'];}?>">
            </div>
            
            
            <div class="field" <?php if($leitura) { echo "style='display: none'";} ?>>
                <label>E-mail para contato</label>
                <input name="txtEmailDuvida"  id="txtEmailDuvida" placeholder="Digite seu email" type="text" maxlength="50">
            </div>
            
            <div class="field">
                <label>Proposta de <?php
                    if ($finalidade == "Venda") {
                        echo "Compra";
                    } else
                        echo "aluguel"
                    ?> R$ (Digite o valor se quiser fazer uma proposta ao vendedor)</label>
                <input type="hidden" value="<?php echo $item['anuncio'][0]['finalidade'] ?>" id="hdnFinalidade" name="hdnFinalidade">
                <div class="three wide field">
                    <input name="txtProposta" id="txtProposta" type="text" placeholder="Valor da proposta">
                </div>
            </div>

            <div class="field">
                <label>Escreva sua dúvida</label>
                <textarea rows="2" id="txtMsgDuvida" name="txtMsgDuvida" maxlength="200"></textarea>
            </div>

            <div class="five wide field">
                <label>Digite o código abaixo:</label>
                <img id="captcha" src="../assets/libs/captcha/securimage/securimage_show.php" alt="CAPTCHA Image" />
                <a href="#" onclick="document.getElementById('captcha').src = '../assets/libs/captcha/securimage/securimage_show.php?' + Math.random();
                                return false">
                    <img src="../assets/libs/captcha/securimage/images/refresh.png" height="32" width="32" alt="Trocar Imagem" onclick="this.blur()" align="bottom" border="0"></a>
                <input type="text" name="captcha_code" id="captcha_code" maxlength="6" />
            </div>

        </form>
        <div class="ui hidden divider"></div>
        <div id="divRetorno"></div>
        <div class="actions">
            <div  id="btnCancelar" class="ui orange deny button">
                Cancelar
            </div>
            <div  id="botaoEnviarDuvida" class="ui positive right labeled icon button">
                Enviar
                <i class="checkmark icon"></i>
            </div>
        </div>


    </div>
</div>

<!-- MODAIS -->
<div class="ui standart modal" id="modalCancelar">
    <i class="close icon"></i>
    <div class="header">
        Cancelar
    </div>
    <div class="content">
        <div class="description">
            <div class="ui header">Deseja realmente cancelar e perder as informações não gravadas?</div>
        </div>
    </div>
    <div class="actions">
        <div class="ui deny red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>
