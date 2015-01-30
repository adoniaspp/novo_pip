<script>
    $(document).ready(function() {
<?php
$item = $this->getItem();
switch ($item) {
    case "errobanco":
    case "errotrocasenha":
    case "errolink":
    case "errotoken":
    case "erroemail":
    case "errohashemail":
    case "erroanuncioinativo":
        ?>
                $('#divColuna').attr('class', 'ten wide column');
                var img = $("<i>", {class: "huge warning icon"}, "</i>");
                $('#divimg').append(img).parent().attr('class', 'red row');
        <?php
        break;
    case "sucessotrocarimagem":
    case "sucessoalterarsenha":
    case "sucessocadastrousuario":
    case "sucessocadastroimovel":
    case "sucessocadastroimovel":
    case "sucessoedicaousuario":
    case "sucessoenvioemail":
        ?>
                $('#divColuna').attr('class', 'ten wide column');
                var img = $("<i>", {class: "huge checkmark icon"}, "</i>");
                $('#divimg').append(img).parent().attr('class', 'green row');
        <?php
        break;
    case "sucessoedicaoimovel":
        ?>
                alert("Imóvel Atualizado com Sucesso");
                location.href = "index.php?entidade=Imovel&acao=listarEditar";
        <?php
        break;
}
?>
    });
</script>

<div class="ui page menu grid">
    <div class="ui two column  center aligned  grid"> 
        <div>
            <div class="one wide column" id="divimg"> <br>
            </div>
            <div id="divColuna">
                <?php
                $item = $this->getItem();
                switch ($item) {
                    case "errobanco":
                        ?>
                        <h2>Desculpe, não foi possível realizar a operação!</h2>
                        <h3>Tente novamente em alguns minutos.</h3>
                        <?php
                        break;
                    case "erroemail":
                        ?>
                        <h2>Desculpe, não foi possível realizar a operação!</h2>
                        <h3>Falha no envio de e-mail.</h3>
                        <?php
                        break;
                    case "errotrocasenha":
                        ?>
                        <h2>Desculpe, não foi possível realizar a operação!</h2>
                        <h3>A Senha atual está incorreta.</h3>
                        <?php
                        break;
                    case "errolink":
                        ?>
                        <h2>Esse link é inválido ou já foi utilizado para troca de senha.</h2>
                        <?php
                        break;
                    case "errotoken":
                        ?>
                        <h2>Ops! Não podemos processar sua requisição. <br>Tente novamente.</h2>
                        <?php
                        break;
                    case "errohashemail":
                        ?>
                        <h2>Ops! O link desse anuncio não é válido. <br>Tente novamente.</h2>
                        <?php
                        break;
                    case "erroanuncioinativo":
                        ?>
                        <h2>Ops! Esse anuncio não é mais válido. <br>Obrigado pelo acesso</h2>
                        <?php
                        break;
                    case "errousuarioinativo":
                        ?>
                        <h2>Ops! Esse Usuário não existe. <br>Obrigado pelo acesso</h2>
                        <?php
                        break;
                    case "sucessocadastrousuario":
                        ?>
                        <h2>A sua conta de usuário foi criada com sucesso!</h2>
                        <h3>Digite seu login e sua senha para logar no site. </h3>
                        <?php
                        break;
                    case "sucessotrocarimagem":
                        ?>
                        <h2>A sua <?php echo ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca"); ?> foi alterada com sucesso!</h2>
                        <?php
                        break;
                    case "sucessoalterarsenha":
                        ?>
                        <h2>A sua senha foi alterada com sucesso!</h2>
                        <?php
                        break;
                    case "sucessoedicaousuario":
                        ?>
                        <h2>O cadastro foi atualizado com sucesso!</h2>
                        <?php
                        break;
                    case "sucessoenvioemail":
                        ?>
                        <h2>Em breve você receberá um e-mail para realizar a alteração de sua senha!</h2>
                        <h3>Caso não tenha recebido o e-mail, verifique também a sua caixa de SPAM.</h3>
                        <?php
                        break;
                    case "sucessocadastroimovel":
                        ?>
                        <h2 class="text-center">O imóvel foi cadastrado com sucesso!</h2>
                        <p class="text-center">O que deseja fazer? </p> 
                        <p class="text-center">
                            <a href="index.php?entidade=Anuncio&acao=listarCadastrar">
                                <button type="button" class="btn btn-info">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-plus"></span> Cadastrar Anúncios
                                </button>
                            </a> 

                            <a href="index.php?entidade=Imovel&acao=form">
                                <button type="button" class="btn btn-success">
                                    <span class="glyphicon glyphicon-home"></span>
                                    <span class="glyphicon glyphicon-plus"></span> Cadastrar Outro Imóvel
                                </button></a>                    
                        </p>

                        <?php
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>