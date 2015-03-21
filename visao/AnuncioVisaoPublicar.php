<?php
//Sessao::gerarToken();
$item = $this->getItem();
//echo "<pre>";
//print_r($item);die();
if ($item) {
            foreach ($item["imovel"] as $objImovel) {
                $idImovel = $objImovel->getId();
                $tipoImovel = $objImovel->getTipoImovel()->getDescricao();
            }
        }
?>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/js/anuncio.js"></script>
<script>
    cadastrarAnuncio();
    cancelarAnuncio();
</script>
<div class="container">
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="section" href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <a class="section" href="index.php?entidade=Anuncio&acao=listarCadastrar">Anúncios</a>
                <i class="right chevron icon divider"></i>
                <?php if ($item["anuncio"]->getId() != "") { ?>
                    <a class="active section" href="index.php?entidade=Anuncio&acao=listarReativar">Reativar Anúncios</a>
                <?php } else { ?>
                    <a class="active section" href="index.php?entidade=Anuncio&acao=listarCadastrar">Publicar Anúncio</a>
                <?php } ?>

            </div>
        </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui page grid main">
        <div class="row">
            <div class="ui fluid small ordered steps">
                <div id="menuStep1" class="active step">
                    <div class="content">
                        <div class="title">Plano</div>
                    </div>
                </div>
                <div id="menuStep2" class="step">
                    <div class="content">
                        <div class="title">Anúncio</div>
                    </div>
                </div>
                <div id="menuStep3" class="step">
                    <div class="content">
                        <div class="title">Adicionais</div>
                    </div>
                </div>
                <div id="menuStep4" class="step">
                    <div class="content">
                        <div class="title">Confirmação</div>

                    </div>
                </div>
                <div id="menuStep5" class="step">
                    <div class="content">
                        <div class="title">Publicação</div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <div class="ui hidden divider"></div>
        <!--NAVEGAÇÃO-->
    <div class="ui page grid main">
        <div class="ui basic right aligned segment">
            <div class="ui green button" id="btnDetalhesImovel"><i class="home icon"></i> <?php echo ucfirst($tipoImovel)?></div>
            <div class="ui orange button" id="btnAnterior1"><i class="arrow left icon"></i> </div>
            <div class="ui blue button" id="btnProximo1"> <i class="arrow right icon"></i></div>
        </div>
    </div>
            <div class="ui hidden divider"></div>
    <form id="fileupload" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" id="hdnId" name="hdnId" value=""/>
        <input type="hidden" id="hdnIdImovel" name="hdnIdImovel" value="<?php echo $idImovel; ?>" />
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="Cadastrar" />
        <input type="hidden" id="hdnStep" name="hdnStep" value="1" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

        <!--SELECIONE O PLANO-->
        <div class="ui page grid main">
            <div class="column" id="step1" class="">            
                <h3 class="ui dividing header">Escolha o plano a ser utilizado no seu anúncio</h3>
                <div class="ui form segment">
                    <div class="fields">
                        <div class="eight wide required field">
                            <label>Plano</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltPlano" id="sltPlano">
                                <div class="text">Escolha um plano</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">                            
                                    <?php
                                    if ($item && count($item["usuarioPlano"]) > 0) {
                                        foreach ($item["usuarioPlano"] as $usuarioPlano) {
                                            ?>
                                            <div class="item" data-value="<?php echo $usuarioPlano->getId() ?>"><?php echo $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias) - Expira em: " . $usuarioPlano->DataExpiracao($usuarioPlano->getPlano()->getValidadeativacao()); ?></div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="item">Você ainda não possui planos ativos.</div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="eight wide required field">
                            <div class="ui orange dividing header">
                                <i class="add to cart icon"></i>
                                <div class="content">
                                    Comprar planos!
                                    <div class="sub header">  <a href="index.php?entidade=Plano&acao=listar"> Para anunciar você precisa ter planos ativos compre agora! </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--INFORMAÇÕES BÁSICAS-->
        <div class="ui page grid main">        
            <div class="column" id="step2">
                <h3 class="ui dividing header">Informações Básicas</h3>
                <div class="ui form segment">
                    <div class="fields">
                        <div class="four wide required field">
                            <label>Finalidade</label>
                            <div class="ui selection dropdown">
                                <div class="default text">Aluguel ou Venda</div>
                                <i class="dropdown icon"></i>
                                <input name="sltFinalidade" id="sltFinalidade" type="hidden">
                                <div class="menu">
                                    <div class="item" data-value="1">Aluguel</div>
                                    <div class="item" data-value="2">Venda</div>
                                </div>
                            </div>
                        </div>
                        <div class="twelve wide required field">
                            <label>Título do Anúncio</label>
                            <input name="txtTitulo" id="txtTitulo" type="text" placeholder="Informe o Título" maxlength="50">
                        </div>
                    </div>
                    <div class="required field">
                        <label>Descrição</label>
                        <textarea name="txtDescricao" id="txtDescricao" placeholder="Informe uma Descrição do Imóvel" maxlength="150"></textarea>
                    </div>
                    <div class="fields">
                        <div class="four wide required field">
                            <label>Valor (não informar os centavos)</label>
                            <input name="txtValor" id="txtValor" placeholder="Valor do Imóvel" >
                        </div>
                        <h5>&nbsp;</h5>
                        <div class="six wide field">
                            <div class="ui toggle checkbox">
                                <input name="chkMapa" id="chkMapa" type="radio" value="SIM">
                                <label>Exibir o mapa do endereço</label>
                            </div>
                        </div>
                        <div class="six wide field">
                            <div class="ui toggle checkbox">
                                <input name="chkContato" id="chkContato" type="radio" value="SIM">
                                <label>Exibir suas informações de contato</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--INFORMAÇÕES ADICIONAIS-->
        <div class="ui page grid main">        
            <div class="column" id="step3">
                <h3 class="ui dividing header">Informações Adicionais</h3>
                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                <noscript><input type="hidden" name="redirect" value="index.php"></noscript>
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="col-lg-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Adicionar fotos...</span>
                            <input type="file" name="files[]" multiple accept="image/png,image/jpeg,image/gif">
                        </span>
                        <!-- <button type="submit" class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start upload</span>
                        </button> -->
                        <button type="reset" class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancelar o envio de todas</span>
                        </button>
                        <button type="button" class="btn btn-danger delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Excluir fotos selecionadas</span>
                        </button>  
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->
                    <div class="col-lg-5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                        </div>
                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                Adicione nessa etapa as fotos para o anúncio
                <!-- The table listing the files available for upload/download -->
                <div class="row">
                    <div class="col-lg-9">
                        <table role="presentation" class="table table-striped table-condensed table-responsive">
                            <tbody class="files"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <!--CONFIRMAÇÃO-->
        <div class="ui page grid main">        
            <div class="column" id="step4">
                <h3 class="ui dividing header">Confirmação</h3>

            </div>
        </div>
        <!--PUBLICAÇÃO-->
        <div class="ui page grid main">        
            <div class="column" id="step5">
                <h3 class="ui dividing header">Publicação</h3>
                <div class="ui segment" id="divRetorno">
                    <p></p>
                </div>
            </div>
        </div>
    </form>
    <!--NAVEGAÇÃO-->
    <div class="ui page grid main">
        <div class="ui basic center aligned segment">
            <div class="ui orange button" id="btnAnterior2"><i class="arrow left icon"></i> Anterior</div>
            <div class="ui button" id="btnCancelar">Cancelar</div>
            <div class="ui blue button" id="btnProximo2">Próximo <i class="arrow right icon"></i></div>
        </div>
    </div>


</div>
<!-- MODAIS -->
<div class="ui small modal" id="modalCancelar">
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
        <div class="ui red button">
            Não
        </div>
        <div class="ui positive right labeled icon button">
            Sim
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>


<?php
die();
?>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<script src="assets/js/wizard.js"></script>
<script src="assets/js/bootstrap-maxlength.js"></script>
<script src="assets/js/bootstrap-switch.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>
 UPLOAD 
<script src="assets/js/upload/jquery.ui.widget.js"></script>
<script src="assets/js/upload/tmpl.min.js"></script>
<script src="assets/js/upload/load-image.min.js"></script>
<script src="assets/js/upload/canvas-to-blob.min.js"></script>
<script src="assets/js/upload/jquery.iframe-transport.js"></script>
<script src="assets/js/upload/jquery.fileupload.js"></script>
<script src="assets/js/upload/jquery.fileupload-process.js"></script>
<script src="assets/js/upload/jquery.fileupload-image.js"></script>
<script src="assets/js/upload/jquery.fileupload-validate.js"></script>
<script src="assets/js/upload/jquery.fileupload-ui.js"></script>-->

<form id="fileupload" class="form-horizontal" enctype="multipart/form-data">
    <div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) -->
        <?php
        die();
        Sessao::gerarToken();
        $item = $this->getItem();
        if ($item) {
            foreach ($item["imovel"] as $objImovel) {
                $referencia = $objImovel->Referencia();
                $idImovel = $objImovel->getId();
                echo $tipoImovel = $objImovel->buscarTipoImovel($objImovel->getIdTipoImovel());
                $endereco = $objImovel->getEndereco()->enderecoMapa();
                $imovel = $objImovel;
            }
        }
        ?>


        <div class="row">
            <div class="alert alert-warning">Aguarde Processando...</div>
            <div class="well wizard-example">

                <div class="step-content">


                    <div class="step-pane" id="step2">
                        <input type="hidden" id="hdnId" name="hdnId" value=""/>
                        <input type="hidden" id="hdnIdImovel" name="hdnIdImovel" value="<?php echo $idImovel; ?>" />
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="Cadastrar" />
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                        <div class="row">
                            <div class="col-lg-7">
                                <div id="forms" class="panel panel-default">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="sltFinalidade">Finalidade</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                                                <option value="">Informe a Finalidade</option>
                                                <option value="venda" <?php echo ($item["anuncio"]->getFinalidade() == "venda") ? "selected=\"selected\"" : "" ?> >Venda</option>
                                                <option value="aluguel" <?php echo ($item["anuncio"]->getFinalidade() == "aluguel") ? "selected=\"selected\"" : "" ?> >Aluguel</option>
                                            </select></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtTitulo">Título</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" placeholder="Informe o Título" maxlength="50" value="<?php echo $item["anuncio"]->getTituloAnuncio(); ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtDescricao"> Descrição </label>
                                        <div class="col-lg-8">
                                            <textarea maxlength="150" id="txtDescricao" name="txtDescricao" class="form-control" placeholder="Informe uma Descrição do Imóvel"> <?php echo $item["anuncio"]->getDescricaoAnuncio(); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtValor">Valor</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="txtValor" name="txtValor" placeholder="Valor do Imóvel"  value="<?php //echo $item["anuncio"]->getValor();                        ?>"> 
                                        </div>
                                        <span class="col-lg-4 ">(Não informar os centavos)</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-6 control-label" for="chkMapa"> Exibir o mapa do endereço?</label>
                                        <div class="col-lg-5">
                                            <input type="checkbox" name="chkMapa" value="SIM" <?php echo ($item["anuncio"]->getPublicarMapa() == "SIM") ? "checked=\"checked\"" : "" ?> >                                             
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-6 control-label" for="chkContato"> Exibir o telefone para contato?</label>
                                        <div class="col-lg-5">
                                            <input type="checkbox" name="chkContato" value="SIM" <?php echo ($item["anuncio"]->getPublicarContato() == "SIM") ? "checked=\"checked\"" : "" ?> >                                             
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-offset-1 col-lg-9" for="sltCamposVisiveis">Escolha quais informações do imóvel deseja exibir:</label>
                                    </div>
                                    <?php
                                    if ($item["anuncio"]->getId() != "") {
                                        $arrayValoresVisiveis = json_decode($item["anuncio"]->getValorVisivel());
                                    } else {
                                        $arrayValoresVisiveis = array("quarto", "banheiro", "garagem", "academia", "areaservico", "dependenciaempregada", "elevador", "piscina", "quadra", "area", "suite", "andar", "condominio", "cobertura", "sacada");
                                    }
                                    ?>
                                    <div class="form-group">
                                        <div class="col-sm-offset-1 col-sm-4">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Básicas</div>
                                                <div class="panel-body">
                                                    <?php /* if ($imovel->getTipo() != "terreno") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="quarto" <?php echo (in_array("quarto", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Quarto - <?php echo $imovel->getQuarto(); ?>
                                                      </label>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="banheiro" <?php echo (in_array("banheiro", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Banheiro - <?php echo $imovel->getBanheiro(); ?>
                                                      </label>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="garagem" <?php echo (in_array("garagem", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Garagem - <?php echo $imovel->getGaragem(); ?>
                                                      </label>
                                                      <?php
                                                      } else {
                                                      echo "Não se aplica";
                                                      } */
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Adicionais</div>
                                                <div class="panel-body">
                                                    <?php /* if ($imovel->getAcademia() == "SIM") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="academia" <?php echo (in_array("academia", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Academia
                                                      </label>
                                                      <?php } ?>
                                                      <?php if ($imovel->getAreaServico() == "SIM") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="areaservico" <?php echo (in_array("areaservico", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Área de Serviço
                                                      </label>
                                                      <?php } ?>
                                                      <?php if ($imovel->getDependenciaEmpregada() == "SIM") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="dependenciaempregada" <?php echo (in_array("dependenciaempregada", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Dependência de Empregada
                                                      </label>
                                                      <?php } ?>
                                                      <?php if ($imovel->getElevador() == "SIM") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="elevador" <?php echo (in_array("elevador", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Elevador
                                                      </label>
                                                      <?php } ?>
                                                      <?php if ($imovel->getPiscina() == "SIM") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="piscina" <?php echo (in_array("piscina", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Piscina
                                                      </label>
                                                      <?php } ?>
                                                      <?php if ($imovel->getQuadra() == "SIM") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="quadra" <?php echo (in_array("quadra", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Quadra
                                                      </label>
                                                      <?php } ?>
                                                      <?php if ($imovel->getArea() != "") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="area" <?php echo (in_array("area", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Área m<sup>2</sup> - <?php echo $imovel->getArea(); ?>
                                                      </label>
                                                      <?php } ?>
                                                      <?php if ($imovel->getSuite() != "") { ?>
                                                      <label class="checkbox">
                                                      <input type="checkbox" name="sltCamposVisiveis[]" value="suite" <?php echo (in_array("suite", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Suíte - <?php echo $imovel->getSuite(); ?>
                                                      </label>
                                                      <?php } */ ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Apartamento</div>
                                                <div class="panel-body">
                                                    <?php if ($tipoImovel == "apartamento") { ?>
                                                        <?php
                                                        if ($imovel->getAndar() == "" && $imovel->getCondominio() == "" && $imovel->getCobertura() == "NAO" && $imovel->getSacada() == "NAO") {
                                                            echo "Não informado no cadastro do imóvel.";
                                                        } else {
                                                            ?>                                                   
                                                            <?php if ($imovel->getAndar() != "") { ?>
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="sltCamposVisiveis[]" value="andar" <?php echo (in_array("andar", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Andar - <?php echo $imovel->getAndar(); ?>
                                                                </label>
                                                            <?php } ?>                                                
                                                            <?php if ($imovel->getCondominio() != "") { ?>
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="sltCamposVisiveis[]" value=condominio <?php echo (in_array("condominio", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Condomínio - <?php echo $imovel->getCondominio(); ?>
                                                                </label>
                                                            <?php } ?>                                                                                                    
                                                            <?php if ($imovel->getCobertura() == "SIM") { ?>
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="sltCamposVisiveis[]" value="cobertura" <?php echo (in_array("cobertura", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Cobertura
                                                                </label>
                                                            <?php } ?>                                                
                                                            <?php if ($imovel->getSacada() == "SIM") { ?>
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="sltCamposVisiveis[]" value="sacada" <?php echo (in_array("sacada", $arrayValoresVisiveis)) ? "checked=\"checked\"" : "" ?> > Sacada
                                                                </label>
                                                            <?php } ?> 
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "Não se aplica.";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div id="forms" class="panel panel-default">
                                    <div class="panel-heading">Mapa do Endereço Cadastrado</div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="popin">
                                                <div id="map"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="step-pane" id="step3">
                        <!-- Redirect browsers with JavaScript disabled to the origin page -->
                        <noscript><input type="hidden" name="redirect" value="index.php"></noscript>
                        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                        <div class="row fileupload-buttonbar">
                            <div class="col-lg-7">
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Adicionar fotos...</span>
                                    <input type="file" name="files[]" multiple accept="image/png,image/jpeg,image/gif">
                                </span>
                                <!-- <button type="submit" class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start upload</span>
                                </button> -->
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>Cancelar o envio de todas</span>
                                </button>
                                <button type="button" class="btn btn-danger delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Excluir fotos selecionadas</span>
                                </button>                                


                                <!-- The global file processing state -->
                                <span class="fileupload-process"></span>

                            </div>
                            <!-- The global progress state -->
                            <div class="col-lg-5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                        Adicione nessa etapa as fotos para o anúncio
                        <!-- The table listing the files available for upload/download -->
                        <div class="row">
                            <div class="col-lg-9">
                                <table role="presentation" class="table table-striped table-condensed table-responsive">
                                    <tbody class="files"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="step-pane" id="step4">
                        <div class="row">
                            <h4>Confirme os dados informados:</h4>
                            <table class="table table-bordered table-condensed table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th id="colImovelFinalidade">Imóvel</th>
                                        <th>Plano</th>
                                        <th>Título</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Mapa</th>
                                        <th>Contato</th>
                                        <th>Informações Exibidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="colReferencia"><span class="label label-info"><?php echo $referencia; ?></span></td>
                                        <td id="colPlano"></td>
                                        <td id="colTitulo"></td>
                                        <td id="colDescricao"></td>
                                        <td id="colValor"></td>
                                        <td id="colMapa"></td>
                                        <td id="colContato"></td>
                                        <td id="colCampos"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <textarea class="form-control" rows="5"><?php include_once 'assets/txt/termo.php'; ?></textarea>
                        </div>
                        <div class="row text-center text-danger">
                            <p>   Aceito os termos do contrato e reconheço como verdadeiras as informações constantes nesse anuncio e desde logo,
                                responsabiliza-se integralmente pela veracidade e exatidão das informações aqui fornecidas, sob pena de incorrer nas sanções
                                previstas no art. 299 do Decreto Lei 2848/40 (Código Penal). </p>
                        </div>
                    </div>
                    <div class="step-pane" id="step5"></div>
                </div>
                <button id="btnCancelar" type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-ok-circle"></span> Cancelar </button>
                <button id="btnWizardPrev" type="button" class="btn btn-warning btn-prev"> <span class="glyphicon glyphicon-chevron-left"></span> Voltar </button>
                <button id="btnWizardNext" type="button" class="btn btn-primary btn-next" data-last="Fim" > Avançar <span class="glyphicon glyphicon-chevron-right"></span></button>
            </div>
        </div>
    </div>
</form>

<script>
    //    $(document).ready(function() {
    //
    //        $('.alert').hide();
    //        $('#btnWizardPrev').hide();
    //
    //        // Associa o evento do popover ao clicar no link.
    //        $("#popover").popover({
    //            trigger: 'hover',
    //            html: true,
    //            placement: 'auto',
    //            content: $('#div-popover').html()
    //        }).click(function(e) {
    //            e.preventDefault();
    //            // Exibe o popover.
    //            $(this).popover('show');
    //        });
    //
    //        $("#btnCancelar").click(function() {
    //            if (confirm("Deseja cancelar o cadastro do anúncio?")) {
    //<?php if ($item["anuncio"]->getId() != "") { ?>
        //                    location.href = "index.php?entidade=Anuncio&acao=listarReativar";
        //<?php } else { ?>
        //                    location.href = "index.php?entidade=Anuncio&acao=listarCadastrar";
        //<?php } ?>
    //            }
    //        });
    //
    //        $('#MyWizard').on('change', function(e, data) {
    //            if (data.direction === 'next') {
    //                if (data.step === 1) {
    //                    if (!$("#sltPlano").valid())
    //                        return e.preventDefault();
    //                }
    //                if (data.step === 2) {
    //                    if (!($("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()))
    //                        return e.preventDefault();
    //                }
    //                if (data.step === 3) {
    //                    if (typeof ($("input[name^=txtLegenda]").val()) !== "undefined") {
    //                        alert("Você ainda não enviou todas as fotos. \n Clique no botão Enviar");
    //                        return e.preventDefault();
    //                    }
    //                    if (typeof ($("input[name=delete]").val()) !== "undefined") {
    //
    //                        if (typeof ($("input[name=rdbDestaque]:checked").val()) === "undefined") {
    //                            alert("Informe uma Foto para ser Destaque do seu anúncio");
    //                            return e.preventDefault();
    //                        }
    //                    }
    //                }
    //                if (data.step === 4) {
    //                    if (($("#sltPlano").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()))
    //                        $("#fileupload").submit();
    //                }
    //            }
    //        });
    //        $('#MyWizard').on('changed', function(e, data) {
    //            var item = $('#MyWizard').wizard('selectedItem');
    //
    //            if (item.step === 1) {
    //                $('#btnWizardPrev').hide();
    //            } else {
    //                $('#btnWizardPrev').show();
    //            }
    //
    //            if (item.step === 2) {
    //                var endereco = "<?php echo $endereco; ?>";
    //                //######### INICIO DO CEP ########
    //                map = new GMaps({
    //                    div: '#map',
    //                    lat: 0,
    //                    lng: 0
    //                });
    //                GMaps.geocode({
    //                    address: endereco.trim(),
    //                    callback: function(results, status) {
    //                        console.log(map);
    //                        if (status == 'OK') {
    //                            var latlng = results[0].geometry.location;
    //                            map.setCenter(latlng.lat(), latlng.lng());
    //                            map.addMarker({
    //                                lat: latlng.lat(),
    //                                lng: latlng.lng()
    //                            });
    //                        }
    //                    }
    //                });
    //            }
    //            if (item.step === 3) {
    //                $("#colReferencia").click(function() {
    //                    $('#myModal').modal('show');
    //                })
    //                $("#colImovelFinalidade").html('<span class="label label-primary">' + $("#sltFinalidade :selected").text() + '</span>');
    //                $("#colPlano").html($("#sltPlano :selected").text());
    //                $("#colTitulo").html($("#txtTitulo").val());
    //                $("#colDescricao").html($("#txtDescricao").val());
    //                $("#colValor").html($("#txtValor").val());
    //                $("#colMapa").html((typeof ($("input[name=chkMapa]:checked").val()) === "undefined" ? "Não" : "Sim"));
    //                $("#colContato").html((typeof ($("input[name=chkContato]:checked").val()) === "undefined" ? "Não" : "Sim"));
    //                var varCampos = new Array();
    //                $("input[name='sltCamposVisiveis[]']:checked").each(function() {
    //                    //if ($(this).val() != "Todas")
    //                    //  varCampos.push($(this).text());
    //                    varCampos.push($(this).parent().text().trim());
    //                })
    //                if (varCampos.length > 0)
    //                    $("#colCampos").html("&bullet; " + varCampos.join("<br /> &bullet; "));
    //                else
    //                    $("#colCampos").html("Nenhum campo escolhido");
    //
    //            }
    //        });
    //        //$('#MyWizard').on('finished', function(e, data) {
    //        //    console.log('finished');
    //        //});
    //        $('#btnWizardPrev').on('click', function() {
    //            $('#MyWizard').wizard('previous');
    //        });
    //        $('#btnWizardNext').on('click', function() {
    //            $('#MyWizard').wizard('next');
    //        });
    //        //$('#btnWizardStep').on('click', function() {
    //        //  var item = $('#MyWizard').wizard('selectedItem');
    //        //console.log(item.step);
    //        //});
    //        //$('#MyWizard').on('stepclick', function(e, data) {
    //        //    console.log('step' + data.step + ' clicked');
    //        //    if (data.step === 1) {
    //        //        // return e.preventDefault();
    //        //    }
    //        //});
    //        // optionally navigate back to 2nd step
    //        //$('#btnStep2').on('click', function(e, data) {
    //        //    $('[data-target=#step2]').trigger("click");
    //        //});
    //
    //        $('#fileupload').validate({
    //            rules: {
    //                sltPlano: {
    //                    required: true
    //                },
    //                sltFinalidade: {
    //                    required: true
    //                },
    //                txtTitulo: {
    //                    required: true,
    //                    minlength: 5
    //                },
    //                txtDescricao: {
    //                    //required: true,
    //                    minlength: 10
    //                },
    //                txtValor: {
    //                    required: true
    //                },
    //                chkAceite: {
    //                    required: true
    //                }
    //            },
    //            messages: {
    //                chkAceite: {
    //                    required: "Obrigatório"
    //                }
    //            },
    //            highlight: function(element) {
    //                $(element).closest('.form-group').addClass('has-error');
    //            },
    //            unhighlight: function(element) {
    //                $(element).closest('.form-group').removeClass('has-error');
    //            },
    //            errorElement: 'span',
    //            errorClass: 'help-block',
    //            errorPlacement: function(error, element) {
    //                if (element.parent('.input-group').length) {
    //                    error.insertAfter(element.parent());
    //                } else {
    //                    error.insertAfter(element);
    //                }
    //            },
    //            submitHandler: function() {
    //                $.ajax({
    //                    url: "index.php",
    //                    dataType: "json",
    //                    type: "POST",
    //                    data: $('#fileupload').serialize(),
    //                    beforeSend: function() {
    //                        $('.alert').show();
    //                        $('button').attr('disabled', 'disabled');
    //                    },
    //                    success: function(resposta) {
    //                        $(".alert").hide();
    //                        if (resposta.resultado == 1) {
    //                            $("#step5").html('<div class="row text-success">\n\
    //<h2 class="text-center">Obrigado!</h2>\n\
    //<p class="text-center">O cadastro de seu anúncio foi concluído com sucesso. </p>\n\
    //<p class="text-center">Em breve você receberá um e-mail confirmando a publicação do mesmo. </p>\n\n\
    //<p class="text-center"><a href="index.php?entidade=Anuncio&acao=listarCadastrar">Cadastrar outro Anúncio?</a> </p>\n\n\
    //<p class="text-center">Não perca tempo <a href="index.php?entidade=UsuarioPlano&acao=listar">clique aqui</a> e compre mais anúncios! </p>\n\
    //<p class="text-center">Divulgue esse anuncio no Facebook <img src="assets/imagens/facebook.png"></p>\n\
    //</div>');
    //                            $('#btnModalImovel').attr('disabled', 'disabled');
    //                            $('button').attr('disabled', 'disabled');
    //                        } else {
    //                            $("#step5").html('<div class="row text-danger">\n\
    //<h2 class="text-center">Tente novamente mais tarde!</h2>\n\
    //<p class="text-center">Houve um erro no processamento de cadastro. </p>\n\
    //</div>');
    //                            $('button').removeAttr('disabled');
    //                        }
    //                    }
    //                })
    //                return false;
    //            }
    //        })
    //
    ////        $('#sltCamposVisiveis').multiselect({
    ////            buttonClass: 'btn btn-default btn-sm',
    ////            includeSelectAllOption: true
    ////        });
    //
    //        // Initialize the jQuery File Upload widget:
    //        $('#fileupload').fileupload({
    //            dropZone: null,
    //            pasteZone: null,
    //            autoUpload: false,
    //            url: 'index.php?upload=1',
    //            maxNumberOfFiles: 5,
    //            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
    //            imageMaxWidth: 800,
    //            imageMaxHeight: 800,
    //            imageCrop: true,
    //            loadImageFileTypes: /^image\/(gif|jpeg|png)$/,
    //            imageType: 'image/jpg',
    //            imageForceResize: true,
    //            loadImageMaxFileSize: 2
    //        }).on('fileuploadsubmit', function(e, data) {
    //            //data.formData = data.context.find(':input').serializeArray();
    //            data.formData = $("#fileupload").serializeArray();
    //        }).on('fileuploadcompleted', function(e, data) {
    //            $('input[type="radio"]').bootstrapSwitch('destroy');
    //            $('input[type="radio"]').bootstrapSwitch();
    //            $('input[type="radio"]').bootstrapSwitch('setOnLabel', 'Sim');
    //            $('input[type="radio"]').bootstrapSwitch('setOffLabel', 'Não');
    //            $('input[type="radio"]').bootstrapSwitch('setOffClass', 'danger');
    //            $('input[type="radio"]').on('switch-change', function() {
    //                $('input[type="radio"]').bootstrapSwitch('toggleRadioState');
    //            });
    //            console.log(data);
    //        })
    //
    //        // Load existing files:
    //        $('#fileupload').addClass('fileupload-processing');
    //        $.ajax({
    //            url: "index.php",
    //            dataType: 'json',
    //            context: $('#fileupload')[0],
    //            data: {"anuncio": <?php echo ($item["anuncio"]->getId() != "" ? $item["anuncio"]->getId() : "0" ); ?>, "entidade": "Anuncio", "acao": "reativarAnuncioImagem"}
    //        }).always(function() {
    //            $(this).removeClass('fileupload-processing');
    //        }).done(function(result) {
    //            console.log(result);
    //            $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
    //        });
    //
    //    });
</script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td>
    <span class="preview"></span>
    </td>
    <td>
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td>
    <input type="text" id="txtLegenda[{%=file.name%}]" name="txtLegenda[{%=file.name%}]" placeholder="Informe a Legenda" class="form-control" />
    </td>    
    <td>
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
    </div>
    </td>
    <td>
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start" disabled>
    <span class="glyphicon glyphicon-upload"></span>
    Enviar
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel">
    <span class="glyphicon glyphicon-ban-circle"></span>
    Cancelar envio
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td style="vertical-align: middle;">
    <input type="checkbox" name="delete" value="1" class="toggle">
    </td>
    <td style="vertical-align: middle;">
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
    {% } %}
    </span>
    </td>
    <td style="vertical-align: middle;">
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td style="vertical-align: middle;">
    <span class="legenda">{%=file.legenda%}</span>
    </td>
    <td style="vertical-align: middle;">
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td style="vertical-align: middle;">
    {% if (file.deleteUrl) { %}
    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <span class="glyphicon glyphicon-trash"></span>
    Excluir
    </button>
    {% } else { %}
    <button class="btn btn-warning cancel">
    <span class="glyphicon glyphicon-ban-circle"></span>
    Cancelar envio
    </button>
    {% } %}
    </td>
    {% if (file.url) { %}
    <td style="vertical-align: middle;">
    <span class="size"><input type="radio" name="rdbDestaque" value="{%=file.name%}" data-text-label="Foto Destaque?" /></span>
    </td>
    {% } %}
    </tr>
    {% } %}
</script>