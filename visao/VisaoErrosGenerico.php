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
    case "erroemailNaoEncontrado":
    case "errosemresultadobusca":
    case "errousuarioouanuncio":
        ?>
        $('#divColuna').append("<div class='ui negative icon message'>\n\
                                 <i class='remove icon'></i>\n\
                                 <div class='content'>\n\
                                     <div class='header'>Atenção</div><div id='divMensagemAtencao'></div>\n\
                                 </div>\n\
                               </div>\n\
                               <div class='ui hidden divider'></div>");        
        <?php
        break;
    case "sucessotrocarimagem":
    case "sucessoalterarsenha":
    case "sucessocadastrousuario":
    case "sucessocadastroimovel":
    case "sucessocadastroimovel":
    case "sucessoedicaousuario":
    case "sucessoedicaoimovel":
    case "sucessoenvioemail":
        ?>  
        $('#divColuna').append("<div class='ui success icon message'>\n\
                                 <i class='checkmark icon'></i>\n\
                                 <div class='content'>\n\
                                     <div class='header'>Sucesso</div><div id='divMensagemSucesso'></div>\n\
                                 </div>\n\
                             </div>");

        <?php
        break;
}
?>
    });
</script>

<div class="ui basic page menu grid">
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
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Desculpe, não foi possível realizar a operação. Tente novamente em alguns minutos.");
                        })
                        </script>
                        <?php
                        break;
                    case "erroemail":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Desculpe, não foi possível realizar a operação. Falha no envio de e-mail");
                        })
                        </script>
                        <?php
                        break;
                    case "errotrocasenha":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Desculpe, não foi possível realizar a operação. A Senha atual está incorreta.");
                        })
                        </script>
                        <?php
                        break;
                    case "errolink":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Esse link é inválido ou já foi utilizado para troca de senha.");
                        })
                        </script>
                        <?php
                        break;
                    case "errotoken":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Ops! Não podemos processar sua requisição. Tente novamente.");
                        })
                        </script>
                        <?php
                        break;
                    case "errohashemail":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Ops! O link desse anuncio não é válido. Tente novamente.");
                        })
                        </script>
                        <?php
                        break;
                    case "erroanuncioinativo":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Ops! Esse anuncio não é mais válido. Obrigado pelo acesso");
                        })
                        </script>
                        <?php
                        break;
                    case "erroemailNaoEncontrado":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("E-mail não encontrado. Faça seu cadastro.");
                        })
                        </script>
                        <?php
                        break;
                    case "errousuarioouanuncio":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Vendedor ou Anúncio não encontrado");
                        })
                        </script>
                        <?php
                        break;
                    case "sucessocadastrousuario":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemSucesso').html("Sua conta de usuário foi criada. \n\
                            Digite seu login e sua senha para logar no site.");
                        })
                        </script>
                        <?php
                        break;
                    case "sucessotrocarimagem":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemSucesso').html("Imagem alterada com sucesso");
                        })
                        </script>                       
                        <?php
                        break;
                    case "sucessoalterarsenha":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemSucesso').html("Senha Alterada com Sucesso");
                        })
                        </script>
                        <?php
                        break;
                    case "sucessoedicaousuario":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemSucesso').html("Alterações Realizadas com Sucesso");
                        })
                        </script>
                        <?php
                        break;
                    case "sucessoenvioemail":
                        ?>
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemSucesso').html("Em breve você receberá um e-mail para realizar a alteração de sua senha\n\
                                Caso não tenha recebido o e-mail, verifique também a sua caixa de SPAM.");
                        })
                        </script>
                        <?php
                        break;
                    case "sucessocadastroimovel":
                        ?>
                        <h2>O imóvel foi cadastrado com sucesso!</h2>
                        <h3>O que deseja fazer? </h3> 
                        <a href="index.php?entidade=Anuncio&acao=listarCadastrar">
                            <button type="button"  class="ui brown button">
                                <i class="announcement icon"></i><i class="add icon"></i> Publicar Anúncios
                            </button>
                        </a> 
                        <a href="index.php?entidade=Imovel&acao=form">
                            <button type="button"  class="ui inverted button">
                                <i class="home icon"></i><i class="add icon"></i> Cadastrar Outro Imóvel
                            </button>
                        </a>         
                        <?php
                        break;
                    case "sucessoedicaoimovel":
                        ?>
                        <h2>O imóvel foi atualizado com sucesso!</h2>
                        <h3>O que deseja fazer? </h3> 
                        <a href="index.php?entidade=Usuario&acao=meuPIP">
                            <button type="button"  class="ui primary button">
                                <i class="block layout icon"></i><i class="add icon"></i> Voltar ao Meu PIP
                            </button>
                        </a> 
                        <a href="index.php?entidade=Imovel&acao=listarEditar">
                            <button type="button"  class="ui inverted button">
                                <i class="home icon"></i><i class="add icon"></i> Editar Outro Imóvel
                            </button>
                        </a>         
                        <?php
                        break;
                    case "errosemresultadobusca":
                        ?>                      
                        <script>
                        $(document).ready(function() {
                        $('#divMensagemAtencao').html("Nenhum Anuncio Encontrado");
                        $("#divOrdenacao").hide();
                        })
                        </script>
                        <?php
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>