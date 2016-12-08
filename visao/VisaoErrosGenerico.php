<script>
    $(document).ready(function () {
<?php
$item = $this->getItem();

if(is_array($item)){
    $tipo = $item['tipo'];
} else $tipo = $item;

switch ($tipo) {
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
    case "usuariodesabilitado":
        ?>
                $('#divColuna').append("<div class='ui compact negative message'><div id='divMensagemAtencao'></div></div>");
        <?php
        break;
    case "sucessotrocarimagem":
    case "sucessoalterarsenha":
    case "sucessocadastrousuario":    
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
    
        case $item['tipo'] == "sucessocadastroimovel":
        ?>    
            /*$('#divColuna').append("<div class='ui compact message'>\n\
                      <div id='divMensagemSucessoCompacto'>\n\
                      </div>\n\
                  </div>");*/
        <?php    
        break;
}
?>
    });
</script>

<div class="ui basic page menu grid">
    <div class="ui two column center aligned grid"> 
        <div id="divColuna">
            
            <?php if($item['tipo'] == "sucessocadastroimovel") { ?>
            
            <div class='ui compact message'><div id="divMensagemSucessoCompacto"></div></div>
            
            <?php } ?>
            
            <?php
            $item = $this->getItem();
            switch ($item) {
                case "errobanco":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Desculpe, não foi possível realizar a operação. Tente novamente em alguns minutos.");
                        })
                    </script>
                    <?php
                    break;
                case "erroemail":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Desculpe, não foi possível realizar a operação. Falha no envio de e-mail");
                        })
                    </script>
                    <?php
                    break;
                case "errotrocasenha":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Desculpe, não foi possível realizar a operação. A Senha atual está incorreta.");
                        })
                    </script>
                    <?php
                    break;
                case "errolink":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Esse link é inválido ou já foi utilizado para troca de senha.");
                        })
                    </script>
                    <?php
                    break;
                case "errotoken":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Ops! Não podemos processar sua requisição. Tente novamente.");
                        })
                    </script>
                    <?php
                    break;
                case "errohashemail":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Ops! O link desse anúncio não é válido. Tente novamente.");
                        })
                    </script>
                    <?php
                    break;
                case "erroanuncioinativo":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Ops! Esse anúncio não é mais válido. Obrigado pelo acesso");
                        })
                    </script>
                    <?php
                    break;
                case "erroemailNaoEncontrado":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>E-mail não encontrado. Faça seu cadastro.");
                        })
                    </script>
                    <?php
                    break;
                case "errousuarioouanuncio":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>Vendedor ou Anúncio não encontrado");
                        })
                    </script>
                    <?php
                    break;
                case "usuariodesabilitado":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("<i class='big red remove circle outline icon'></i>ATENÇÃO: O usuário que você está procurando não existe em nossa base ou está desabilitado");
                        })
                    </script>
                    <?php
                    break;
                case "sucessocadastrousuario":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemSucesso').html("Sua conta de usuário foi criada. \n\
                        Clique em 'Login' e digite seu login e sua senha para entrar no site.");
                        })
                    </script>
                    <?php
                    break;
                case "sucessotrocarimagem":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemSucesso').html("Imagem alterada com sucesso");
                        })
                    </script>                       
                    <?php
                    break;
                case "sucessoalterarsenha":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemSucesso').html("Senha Alterada com Sucesso");
                        })
                    </script>
                    <?php
                    break;
                case "sucessoedicaousuario":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemSucesso').html("Alterações Realizadas com Sucesso");
                        })
                    </script>
                    <?php
                    break;
                case "sucessoenvioemail":
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#divMensagemSucesso').html("Em breve você receberá um e-mail para realizar a alteração de sua senha\n\
                            Caso não tenha recebido o e-mail, verifique também a sua caixa de SPAM.");
                        })
                    </script>
                    <?php
                    break;
                    case $item['tipo'] == "sucessocadastroimovel":
                    
                    foreach($item['dados'] as $dadosImovel){
                        
                        $tipoImovelId = $dadosImovel->getTipoImovel()->getId();
                        $tipoImovelDescricao = $dadosImovel->getTipoImovel()->getDescricao();
                        
                        $identificaImovel = $dadosImovel->getIdentificacao();
                        
                        if($tipoImovelId == 1){
                            
                            $quarto   =   $dadosImovel->getCasa()->getQuarto();
                            $banheiro =   $dadosImovel->getCasa()->getBanheiro();
                            $suite    =   $dadosImovel->getCasa()->getSuite();
                            $garagem  =   $dadosImovel->getCasa()->getGaragem();
                            $areaSucesso     =   $dadosImovel->getCasa()->getArea();

                        }   
                        
                        if($tipoImovelId == 3){
                            
                            $quarto   =   $dadosImovel->getApartamento()->getQuarto();
                            $banheiro =   $dadosImovel->getApartamento()->getBanheiro();
                            $suite    =   $dadosImovel->getApartamento()->getSuite();
                            $garagem  =   $dadosImovel->getApartamento()->getGaragem();
                            $areaSucesso     =   $dadosImovel->getApartamento()->getArea();
                        }
                        
                        if($tipoImovelId == 4){
                            
                            $banheiro =   $dadosImovel->getSalaComercial()->getBanheiro();
                            $garagem  =   $dadosImovel->getSalaComercial()->getGaragem();
                            $areaSucesso     =   $dadosImovel->getSalaComercial()->getArea();

                        }
                        
                        if($tipoImovelId == 5){

                            $areaSucesso     =   $dadosImovel->getPredioComercial()->getArea();
                            
                        }
                        
                        if($tipoImovelId == 6){

                            $areaSucesso     =   $dadosImovel->getTerreno()->getArea();
                            
                        }
                        
                        if($areaSucesso ==! null || $areaSucesso > 0){ $areaImovel = "Area: ".$areaSucesso." m<sup>2</sup>";} else $areaImovel = "Área: Não Informada";
                        
                        if ($dadosImovel->getEndereco()->getNumero() != "" && $dadosImovel->getEndereco()->getComplemento() != "") {
                            $endereco = $dadosImovel->getEndereco()->getLogradouro() . ", " . $dadosImovel->getEndereco()->getNumero() . ", " . $dadosImovel->getEndereco()->getComplemento();
                        } elseif ($dadosImovel->getEndereco()->getNumero() != "" && $dadosImovel->getEndereco()->getComplemento() == "") {
                            $endereco = $dadosImovel->getEndereco()->getLogradouro() . ", " . $dadosImovel->getEndereco()->getNumero();
                        } elseif ($dadosImovel->getEndereco()->getNumero() == "" && $dadosImovel->getEndereco()->getComplemento() == "") {
                            $endereco = $dadosImovel->getEndereco()->getLogradouro(). " - " . $bUsuario;
                        } elseif ($dadosImovel->getEndereco()->getNumero() == "" && $dadosImovel->getEndereco()->getComplemento() != "") {
                            $endereco = $dadosImovel->getEndereco()->getLogradouro() . ", " . $dadosImovel->getEndereco()->getComplemento();
                        }
                        
                        
                    }
                    
                    ?>

                    <script>
                        $(document).ready(function () {
                            $('#divMensagemSucessoCompacto').html("<i class='big green check circle outline icon'></i>Imóvel cadastrado com sucesso. Se desejar, escolha\n\
                            uma das opções abaixo");
                        })
                    </script>
                    
                    <div class="ui hidden divider"></div>
                    
                    <div class="stackable two column ui grid container">
                    
                        <div class="column">
                            <div class="ui segment">
                                <a class="header">Endereço</a>
                                <div class="description"> <?php echo $endereco?></div>
                            </div>
                        </div>
                        
                        <div class="column">
                            <div class="ui segment">
                                <a class="header">Cidade - Bairro</a>
                                <div class="description"> <?php echo "".$item['cidade']." - ".$item['bairro']?></div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="stackable one column ui grid container">
                    
                        <div class="column">
                            <div class="ui segment">
                                <a class="header">Características do Imóvel</a>
                                
                                <?php if($tipoImovelDescricao == "apartamentoplanta"){ $tipoImovelDescricao = "apartamento na Planta";} 
                                      if($tipoImovelDescricao == "salacomercial"){ $tipoImovelDescricao = "sala Comercial";} 
                                      if($tipoImovelDescricao == "prediocomercial"){ $tipoImovelDescricao = "predio Comercial";}
                                ?>
                                
                                <div class="description"> <?php echo "Tipo: ".ucfirst($tipoImovelDescricao)?></div>
                                <div class="description"> <?php echo "Identificação do Imóvel: ".$identificaImovel?></div>
                            
                            <?php 
                            
                            if($tipoImovelId == 1 || $tipoImovelId == 3){
                                
                            ?> 

                            <div class="description"> <?php echo "Quarto(s): ".$quarto?></div>

                            <div class="description"> <?php echo "Banheiro(s): ".$banheiro?></div>

                            <div class="description"> <?php echo "Suite(s): ".$suite?></div>

                            <div class="description"> <?php echo "Vaga(s) de Garagem: ".$garagem?></div>  
                            
                            <div class="description"> <?php echo $areaImovel?></div>
                            
                            <?php } ?>
                            
                            <?php
                            
                            if($tipoImovelId == 2){
                                
                            $plantasOrdenadas = $item['dados'][0]->getPlanta();
                            //ordenar as plantas pela Ordem
                            usort($plantasOrdenadas, function( $a, $b ) {
                            //Ordem da planta será usado para comparação
                            return ( $a->getOrdemPlantas() > $b->getOrdemPlantas() );
                            
                            });
                            
                            foreach($plantasOrdenadas as $caracPlanta){
                                                             
                            ?> 
                            
                            <div class="ui hidden divider"></div>
                            
                            <div class="description"> <?php echo "Título da Planta: ".$caracPlanta->getTituloPlanta()?></div>
                            
                            <div class="description"> <?php echo "Quarto(s): ".$caracPlanta->getQuarto()?></div>
                            
                            <div class="description"> <?php echo "Banheiro(s): ".$caracPlanta->getBanheiro()?></div>

                            <div class="description"> <?php echo "Suite(s): ".$caracPlanta->getSuite()?></div>

                            <div class="description"> <?php echo "Vaga(s) de Garagem: ".$caracPlanta->getGaragem()?></div> 
                            
                            <div class="description"> <?php if($caracPlanta->getArea() ==! null || $caracPlanta->getArea() > 0){ echo "Area: ".$caracPlanta->getArea()." m<sup>2</sup>";} else echo "Não Informada";?></div> 
                            
                            <div class="ui hidden divider"></div>
                            
                            
                            
                            <?php } foreach($item['dados'] as $outrosDadosApePlanta){?>
                            
                            <a class="header">Outras Características</a><div class="description"> <?php echo "Andares: ".$outrosDadosApePlanta->getApartamentoPlanta()->getAndares()
                                                            ." - "."Unidades por Andar: ".$outrosDadosApePlanta->getApartamentoPlanta()->getUnidadesAndar()
                                                            ." - "."Total de Unidades: ".$outrosDadosApePlanta->getApartamentoPlanta()->getTotalUnidades()
                                                            ." - "."Número de Torres: ".$outrosDadosApePlanta->getApartamentoPlanta()->getNumeroTorres()
                                                      ?></div>
                            
                            <?php }  } ?>
                            
                            <?php 
                            
                            if($tipoImovelId == 4 || $tipoImovelId == 5){
                            
                            if($tipoImovelId == 4){
                                
                            ?> 
  
                            <div class="description"> <?php echo "Banheiro(s): ".$banheiro?></div>
                            <div class="description"> <?php echo "Vaga(s) de Garagem: ".$garagem?></div>
                            <?php } ?>
                                                        
                            <div class="description"> <?php echo $areaImovel ?></div>
                            
                            <?php } ?>
                            
                            <?php 
                            
                            if($tipoImovelId == 6){ ?>
                                
                            <div class="description"> <?php echo $areaImovel ?></div>
                            
                            <?php } ?>
                            
                            </div>
                        </div>
                        
                    </div>
                    
                    <?php if($item['diferencial'] != null){ ?>
                    
                    <div class="stackable one column ui grid container">
                        <div class="column">
                            <div class="ui segment">
                                <a class="header">Diferenciais</a>
                                <div class="description"> <?php 
                                
                                $diferencialImplode = implode(" , ", $item['diferencial']); //retirar a barra do último elemento

                                echo $diferencialImplode;
                                
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php } ?>
                    
                    <div class="ui hidden divider"></div>
                    
                    <div class="ui middle aligned stackable grid container">
                        <div class="row">
                            <div class="column">                                  

                                <div class="row">

                                    <a href="index.php?entidade=Anuncio&acao=listarCadastrar">
                                        <button type="button"  class="ui brown button">
                                            <i class="announcement icon"></i><i class="add icon"></i> 
                                            Publicar Anúncio
                                        </button>
                                    </a>

                                    <a href="index.php?entidade=Imovel&acao=form">
                                        <button type="button"  class="ui green button">
                                            <i class="add icon"></i>Cadastrar Outro Imóvel
                                        </button>
                                    </a> 

                                    <a href="index.php?entidade=Usuario&acao=MeuPIP">
                                        <button type="button"  class="ui blue button">
                                            <i class="home icon"></i>Retornar ao Meu PIP
                                        </button>
                                    </a>

                                </div>

                            </div>   
                        </div>
                    </div>   

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
                        $(document).ready(function () {
                            $('#divMensagemAtencao').html("Nenhum Anúncio Encontrado");
                            $("#divOrdenacao").hide();
                            $("#divColuna").parent().removeClass().addClass("ui eight wide column").parent().removeClass().addClass("ui grid center aligned");
                            $("#divBotoes").parent().parent().remove();
                        })
                    </script>
                    <?php
                    break;
            }
            ?>
        </div>
    </div>
</div>