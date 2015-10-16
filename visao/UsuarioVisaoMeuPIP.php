<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('.ui.accordion').accordion();

        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "searching": false
        });

    })
</script>
<style>
    .spaced > .button {
        margin-bottom: 1em;
    }
</style>
<?php
$item = $this->getItem();



$usuario   = $item["usuario"];
$imoveis   = $item["imovelCadastrado"];
$mensagens = $item["mensagem"];

/*echo "<pre>";
var_dump($_SESSION);
echo "</pre>"; die();*/

$totalAnuncios = 0; //total de anuncios cadastrados

foreach ($imoveis as $qtdAnuncios){
    
    if($qtdAnuncios->getAnuncio()){
    
    $totalAnuncios = $totalAnuncios + 1;
    
    }
    
}

?>

<!-- HTML -->
<div class="ui column doubling grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <div class="active section"><i class="block layout small icon"></i>Meu PIP</div>
            </div>
        </div>
    </div>
</div>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="user icon"></i>
            <div class="content">
                Meus Dados
                <div class="sub header">Gerencie sua conta no PIP</div>
            </div>
        </h2>
    </div>
    <div class="row">
        <a href="index.php?entidade=Usuario&acao=selecionar"  class="spaced">
            <div type="button"  class="ui blue button">
                <i class="edit icon"></i> Atualizar Cadastro
            </div>
        </a>
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha"  class="spaced"> 
            <div type="button"  class="ui blue button">
                <i class="lock icon"></i> Alterar Senha 
            </div>
        </a> 
        <a href="index.php?entidade=Usuario&acao=form&tipo=trocarimagem" class="spaced">         
            <div type="button" class="ui blue button">
                <i class="file image outline icon"></i>  Alterar <?php echo ($_SESSION["tipopessoa"] == "pf" ? "Imagem" : "Logomarca"); ?>
            </div>
        </a>
        <a href="index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=<?php echo $_SESSION["login"]?>"  class="spaced"> 
            <div type="button"  class="ui blue button">
                <i class="newspaper icon"></i> Visualizar Minha Página
            </div>
        </a>
    </div>
          <?php 
                
                if($usuario[0]->getEndereco()->getNumero() != "" && $usuario[0]->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario[0]->getEndereco()->getLogradouro().", ".$usuario[0]->getEndereco()->getNumero().", ".$usuario[0]->getEndereco()->getComplemento();
                    }
                    
                    elseif($usuario[0]->getEndereco()->getNumero() != "" && $usuario[0]->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario[0]->getEndereco()->getLogradouro().", ".$usuario[0]->getEndereco()->getNumero();
                    }
                    
                    elseif($usuario[0]->getEndereco()->getNumero() == "" && $usuario[0]->getEndereco()->getComplemento() == ""){
                    $endereco = $usuario[0]->getEndereco()->getLogradouro();                  
                    }
                    
                    elseif($usuario[0]->getEndereco()->getNumero() == "" && $usuario[0]->getEndereco()->getComplemento() != ""){
                    $endereco = $usuario[0]->getEndereco()->getLogradouro().", ".$usuario[0]->getEndereco()->getComplemento();
                    }
    
            ?>
        <div class="row">
        <div class="ui relaxed divided list">
            <div class="item">             
              <div class="content">
                <a class="header"><?php if($usuario[0]->getTipoUsuario() == "pf"){echo "Nome - Email:";} else echo "Empresa - Email:"?></a>
                <div class="description"><?php echo $usuario[0]->getNome()." - ".$usuario[0]->getEmail();?></div>
              </div>
            </div>
            <div class="item">
              
              <div class="content">
                <a class="header">Endereço:</a>
                <div class="description"> <?php echo $endereco;?></div>
              </div>
            </div>
            
            <div class="item">

              <div class="content">
                <a class="header">Telefone(s):</a>
                <div class="description">
                    <?php 
                    $quantidade = count($usuario[0]->getTelefone());
                                if ($quantidade == 1) {
                                    $array = array($usuario[0]->getTelefone());
                                } else {
                                    $array = $usuario[0]->getTelefone();
                                }
                                foreach ($array as $telefone) {                                
                                $fones[] = $telefone->getOperadora()." - ".$telefone->getNumero();
                                }
                                
                                $fonesImplode = implode(" | ", $fones); //retirar a barra do último elemento
                                
                                echo $fonesImplode; ?>
                </div>
              </div>
            </div>
            
        </div>
        </div>
    
        <div class="column row">
        <div class="column">
        <h3 class="ui dividing header"></h3>
        </div>
        </div>

</div>

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="home icon"></i>
            <div class="content">
                Meus Imóveis
                <div class="sub header">Gerencie seus imóveis (casas, apartamentos, kit-net, salas comerciais, terrenos) </div>
            </div>
        </h2>
    </div>
    <div class="row">
        <a href="index.php?entidade=Imovel&acao=form" class="spaced">
            <div type="button"  class="ui green button">
                <i class="add icon"></i> Cadastrar Imóvel
            </div>
        </a>         
        <?php
        if ($item) {
            if ($item['imovel']) {
                ?>

                <a href="index.php?entidade=Imovel&acao=listarEditar" class="spaced">
                    <div type="button"  class="ui green button">
                        <i class="edit icon"></i> Alterar Imóvel
                    </div></a> 
                <a href="index.php?entidade=Imovel&acao=listarDados" class="spaced">
                    <div type="button" class="ui green button">
                        <i class="list icon"></i> Visualizar Meus Imóveis
                    </div></a> 
        
            <?php
            }
            ?>
          
        <?php    
        }
        ?> 
    </div>
    
    <?php if ($item['imovel']) { ?>
        
                <div class="row">
                <div class="ui horizontal segments">

                    <?php 
                            $casa       = 0;
                            $ap         = 0;
                            $apPlanta   = 0;
                            $sala       = 0;
                            $predio     = 0;
                            $terreno    = 0;

                            $cadastrado = 0;

                            foreach ($imoveis as $imovel) {
                                switch ($imovel->getIdTipoImovel()) {
                                case 1:
                                     $casa = $casa + 1; 
                                     break;
                                case 2:
                                     $ap = $ap + 1;
                                     break;
                                case 3:
                                     $apPlanta = $apPlanta + 1;
                                     break;
                                case 4:
                                     $sala = $sala + 1;
                                     break;
                                case 5:
                                     $predio = $predio + 1;
                                     break;
                                case 6:
                                     $terreno = $terreno + 1;
                                     break;
                                }

                            }
                    ?>

                    <table class="ui green celled striped table">
                    <thead>
                      <tr><th colspan="3">Você possui <?php if(count($imoveis) > 1){echo count($imoveis)." imóveis cadastrados";} 
                      else {echo " 1 imóvel cadastrado";}?>
                    </tr></thead><tbody>

                      <tr>
                        <td><?php if($casa > 1){echo "Casas";} else echo "Casa";?></td>
                        <td><?php echo $casa;?></td>

                      </tr>
                      <tr>
                        <td><?php if($ap > 1){echo "Apartamentos";} else echo "Apartamento";?></td>
                        <td><?php echo $ap;?></td>

                      </tr>
                      <tr>
                        <td><?php if($apPlanta > 1){echo "Apartamentos na Planta";} else echo "Apartamento na Planta";?></td>
                        <td><?php echo $apPlanta;?></td>

                      </tr>
                      <tr>
                        <td><?php if($sala > 1){echo "Salas Comerciais";} else echo "Sala Comercial";?></td>
                        <td><?php echo $sala;?></td>

                      </tr>
                      <tr>
                        <td><?php if($predio > 1){echo "Prédios Comerciais";} else echo "Prédio Comercial";?></td>
                        <td><?php echo $predio;?></td>

                      </tr>
                      <tr>
                        <td><?php if($terreno > 1){echo "Terrenos";} else echo "Terreno";?></td>
                        <td><?php echo $terreno;?></td>

                      </tr>
                     </tbody>
                    </table>

                    </div>
                </div>
                <?php
            }
            ?>
    
        <div class="column row">
        <div class="column">
        <h3 class="ui dividing header"></h3>
        </div>
        </div>
    
</div> 



<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="announcement icon"></i>
            <div class="content">
                Meus Anúncios
                <div class="sub header">Gerencie seus anúncios. Você pode cadastar, visualizar, reativar ou ler suas mensagens </div>
            </div>
        </h2>
    </div>
    <div class="row">
        <?php
        if ($item) {
            if ($item['imovel']) {
                ?>
                <a href="index.php?entidade=Anuncio&acao=listarCadastrar" class="spaced">
                    <div type="button"  class="ui brown button">
                        <i class="add icon"></i> Publicar Anúncio
                    </div></a>         

                <!--                                            <button type="button"  class="ui purple button">
                                                                <i class="edit icon"></i> Editar Anúncio
                                                            </button>-->
                <?php if ($item['anuncio']) { ?>
                    <a href="index.php?entidade=Anuncio&acao=listarReativar" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="refresh icon"></i>  Reativar Anúncios (aluguel)
                        </div></a>
                    <a href="index.php?entidade=Anuncio&acao=listarAtivo" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="list icon"></i> Visualizar Anúncios Ativos
                        </div></a> 
                    <a href="index.php?entidade=Anuncio&acao=listarFinalizado" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="thumbs outline up icon"></i>  Visualizar Anúncios Finalizados
                        </div></a>
                    <a href="index.php?entidade=Usuario&acao=listarMensagem" class="spaced">
                        <div type="button" class="ui brown button">
                            <i class="mail outline icon"></i>  Visualizar Mensagens
                        </div></a>
               
                <?php } ?>
                <?php
            } else {
                echo '<h4 class="ui red header">Cadastre primeiro um imóvel.</h4>';
            }
        }
        ?>
                
    </div>
    
    <?php if ($item['anuncio']) { ?>
    <div class="row">
            <div class="ui horizontal segments">       

                <?php
                $anuncioAtivo = 0;
                $anuncioFinalizado = 0;
                $anuncioExpirado = 0;

                foreach ($imoveis as $anuncio) {

                    if ($anuncio->getAnuncio()) {

                        switch ($anuncio->getAnuncio()->getStatus()) {
                            case "cadastrado":

                                $anuncioAtivo = $anuncioAtivo + 1;
                                break;
                            case "finalizado":
                                $anuncioFinalizado = $anuncioFinalizado + 1;
                                break;
                            case "expirado":
                                $anuncioExpirado = $anuncioExpirado + 1;
                                break;
                        }
                    }
                }
                ?>

                <table class="ui brown celled striped table">
                    <thead>
                        <tr><th colspan="3">Você possui <?php if ($totalAnuncios > 1) {
                echo $totalAnuncios . " anuncios cadastrados";
            } else {
                echo " 1 anuncio cadastrado";
            }
                ?> </th>
                        </tr></thead><tbody>

                        <tr>
                            <td><?php if ($anuncioAtivo > 1) {
                                echo "Ativos";
                            } else echo "Ativo"; ?></td>
                            <td><?php echo $anuncioAtivo; ?></td>

                        </tr>
                        <tr>
                            <td><?php if ($anuncioFinalizado > 1) {
                                echo "Finalizados";
                            } else echo "Finalizado"; ?></td>
                            <td><?php echo $anuncioFinalizado; ?></td>

                        </tr>
                        <tr>
                            <td><?php if ($anuncioExpirado > 1) {
                                echo "Expirados";
                            } else echo "Expirado"; ?></td>
                            <td><?php echo $anuncioExpirado; ?></td>

                        </tr>

                    </tbody>
                </table>


            </div>

            <div class="ui basic segment">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div> <!-- espaço entre as duas tabelas-->

            <div class="ui horizontal segments">       

                <?php
                $msgs = 0;
                $msgsRespondidas = 0;
                $msgsNaoRespondidas = 0;

                foreach ($mensagens as $mensagem) {

                    switch ($mensagem->getStatus()) {
                        case "NOVA":
                            $msgsNaoRespondidas = $msgsNaoRespondidas + 1;
                            break;
                        case "RESPONDIDO":
                            $msgsRespondidas = $msgsRespondidas + 1;
                            break;
                    }
                }
                ?>

                <table class="ui brown celled striped table">
                    <thead>
                        <tr><th colspan="3"><?php if (count($mensagens) > 1) {
                    echo "Você possui ".(count($mensagens)) . " mensagens";
                } else {
                    echo " Você não possui mensagens";
                }
                ?></th>
                        </tr></thead><tbody>

                        <tr>
                            <td><?php if ($msgsRespondidas > 1) {
                    echo "Respondidas";
                } else echo "Respondida"; ?></td>
                            <td><?php echo $msgsRespondidas; ?></td>

                        </tr>
                        <tr>
                            <td><?php if ($msgsNaoRespondidas > 1) {
                    echo "Não Respondida";
                } else echo "Não Respondidas"; ?></td>
                            <td><?php echo $msgsNaoRespondidas; ?></td>

                        </tr>

                    </tbody>
                </table>


            </div>


        </div>
    
     <?php } ?>
    
    <div class="column row">
        <div class="column">
        <h3 class="ui dividing header"></h3>
        </div>
    </div>
    
</div> 

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="shop icon"></i>
            <div class="content">
                Meus Planos
                <div class="sub header">Gerencie seus planos </div>
            </div>
        </h2>
    </div>
    <div class="row">
        <a href="index.php?entidade=UsuarioPlano&acao=listar" class="spaced">
            <div type="button"  class="ui orange button">
                <i class="add icon"></i> Comprar
            </div>
        </a>         
    </div>
    <div class="row">
        <?php
        if ($item) {
            if (!$item["usuarioPlano"]) {
                ?>
                <h4 class="ui orange header">  Você ainda não tem plano. Não perca tempo e Compre Agora </h4>
                <br/> <img class="ui centered image" src="http://www.prospeccao-de-clientes.com/images/gudrum-pagseguro.gif" /> 
                <?php
            } else {
                ?> 

                <table class="ui orange stackable table" id="tabela">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Descrição</th>
                            <th>Data de Compra</th>
                            <th>Prazo para ativação</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($item["usuarioPlano"] as $usuarioPlano) {
                            echo "<tr>";
                            echo "<td>" . $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias)</td>";
                            echo "<td>" . $usuarioPlano->getPlano()->getDescricao() . "</td>";
                            echo "<td>" . $usuarioPlano->getDataCompra() . "</td>";
                            if ($usuarioPlano->getStatus() != "ativo") {
                                echo "<td>" . $usuarioPlano->DataExpiracao($usuarioPlano->getPlano()->getValidadeativacao()) . "</td>";
                            } else {
                                echo "<td> - </td>";
                            }
                            echo "<td>" . $usuarioPlano->getStatus() . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php
            }
        }
        ?>
    </div>
    
    <div class="column row">
        <div class="column">
        <h3 class="ui dividing header"></h3>
        </div>
    </div>
    
</div> 

<div class="ui middle aligned stackable grid container">
    <div class="row">
        <h2 class="ui header">
            <i class="info circle icon"></i>
            <div class="content">
                Ajuda
                <div class="sub header">Precisa de ajuda? </div>
            </div>
        </h2>
    </div>
    <div class="row">
        <div type="button"  class="ui pink button">
            <i class="comment outline icon"></i> Fale Conosco
        </div>
        <div type="button" class="ui pink button">
            <i class="book icon"></i> Dúvidas Mais Frequentes
        </div>
    </div>
</div> 

<div class="ui hidden divider"></div>