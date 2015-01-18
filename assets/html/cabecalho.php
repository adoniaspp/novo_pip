
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

        <script src="<?php echo PIPURL; ?>/assets/js/cabecalho.js"></script> 
        <!-- Template PIP -->
        <link href="<?php echo PIPURL; ?>/assets/css/template-pip.css" rel="stylesheet" type="text/css" /> 		
    </head>

<script>
        esconderMeuPIP();

        $(document).ready(function () {
            digitarLoginSenha();
<?php
if (Sessao::verificarSessaoUsuario()) {
    ?>
                exibirMeuPIP();
                $("#divNome").html("<font color='black'><h4>Seja bem vindo, <?php echo ucfirst(strtolower(explode(" ", $_SESSION['nome'])[0])); ?>  <h4></font>");
    <?php
} else {
    Sessao::gerarToken();
};
?>
            $("#btnAcessar").click(function () {
                autenticarUsuario();
            });
            $("#btnLogout").click(function () {
                logoutUsuario();
            });
        });

</script>

    <body>   
        <div class="container">  
            <nav  class="ui menu inverted navbar page grid" style="background-color: #ffffff" style="margin-bottom:300px">
                <a href="<?php echo PIPURL; ?>/index.php"> <img src="<?php echo PIPURL; ?>/assets/imagens/logo.png" width="120px"/></a>
             
                <div id="divForm" class="right menu hide" style="margin-top: -30px; margin-bottom: 50px">
                    
                    <div class="column padding-reset">                     
                        <h5 id="divTitulo" style=" margin-left: 0px; margin-bottom: 10px;"> Acesse o Meu PIP </h5>
                        <div class="ui left icon input">
                            <input type="text" id="txtLoginIndex" name="txtLoginIndex" placeholder="Login">
                            <i class="user icon"></i>
                        </div>
                        
                        <div class="ui left icon input">
                            
                            <input type="password" id="txtSenhaIndex" name="txtSenhaIndex" placeholder="Senha">
                            <i class="lock icon"></i>
                        </div>

                    
                    
                    <div class="item column padding-reset"><button  type="button" id="btnAcessar" class="ui green button">Acessar</button></div>
                   </div>
                <div class="fields" >
                    <div class="four wide field">
                       <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=esquecisenha" class="ui green label">Ainda não é cadastrado?</a>                      
                       <a href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=esquecisenha" class="ui red label">Não lembra a senha?</a>
                   </div>                
                </div>
              </div>

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


            </nav>
        </div>
