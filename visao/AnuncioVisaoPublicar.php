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
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/anuncio.js"></script>
<!--<script src="assets/js/usuario.js"></script>-->


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="assets/libs/fileupload/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="assets/libs/fileupload/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="assets/libs/fileupload/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="assets/libs/fileupload/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/libs/fileupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/libs/fileupload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="assets/libs/fileupload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="assets/libs/fileupload/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="assets/libs/fileupload/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="assets/libs/fileupload/jquery.fileupload-ui.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        $('#fileupload').fileupload({
            dropZone: null,
            pasteZone: null,
            autoUpload: false,
            url: 'index.php?upload=1',
            maxNumberOfFiles: 5,
            maxFileSize: 3000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
            imageMaxWidth: 800,
            imageMaxHeight: 800,
            imageCrop: true,
            loadImageFileTypes: /^image\/(gif|jpeg|png)$/,
            imageType: 'image/jpg',
            imageForceResize: true,
            loadImageMaxFileSize: 2,
            messages: {
                maxNumberOfFiles: 'Quantidade máxima de fotos atingida (5 fotos)',
                acceptFileTypes: 'Arquivo não permitido. Apenas imagens (gif, jpeg, png)',
                maxFileSize: 'Arquivo muito grande (3 MB)',
                minFileSize: 'Arquivo muito pequeno (0 MB)'
            }
        }).on('fileuploadadd', function (e, data) {
            
            //verificar se o fileInput eh o attachmentName
            //se for faz a logica do preview
            //e chama o preventdefault
            //senao nao faz nada.
            var input = data.fileInput[0];
console.log($(input).attr("name"));
            if($(input).attr("name") == "attachmentName[]"){
                e.preventDefault();
            }
           

//console.log(data);
    // // Prevents the default dragover action of the File Upload widget

        }).on('fileuploadsubmit', function (e, data) {
            data.formData = $("#fileupload").serializeArray();
        }).on('fileuploadcompleted', function (e, data) {
            /*$('input[type="radio"]').bootstrapSwitch('destroy');
             $('input[type="radio"]').bootstrapSwitch();
             $('input[type="radio"]').bootstrapSwitch('setOnLabel', 'Sim');
             $('input[type="radio"]').bootstrapSwitch('setOffLabel', 'Não');
             $('input[type="radio"]').bootstrapSwitch('setOffClass', 'danger');
             $('input[type="radio"]').on('switch-change', function() {
             $('input[type="radio"]').bootstrapSwitch('toggleRadioState');
             });*/
            console.log(data);
            console.log('data');
            $('.ui.checkbox').checkbox();
            $("p[class='error']").each(function () {
                var error = $(this).html();
                if (error != "") {
                    $(this).html('<div class="ui error message"><div class="header">Ocorreu um erro</div><p>' + error + '</p></div>');
                }
            })
        }).on('fileuploadfail', function (e, data) {
            console.log('s');
        })
        /*
         // Load existing files:
         $('#fileupload').addClass('fileupload-processing');
         $.ajax({
         url: "index.php",
         dataType: 'json',
         context: $('#fileupload')[0],
         data: {"anuncio": <?php echo ($item["anuncio"]->getId() != "" ? $item["anuncio"]->getId() : "0" ); ?>, "entidade": "Anuncio", "acao": "reativarAnuncioImagem"}
         }).always(function() {
         $(this).removeClass('fileupload-processing');
         }).done(function(result) {
         console.log(result);
         $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
         });*/
        $('.special.cards .image').dimmer({
            on: 'hover'
        });
    });
</script>

<script>
    cadastrarAnuncio();
    cancelar('Anuncio', 'listarCadastrar');
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
                <div id="menuStep31" class="step">
                    <div class="content">
                        <div class="title">Plantas</div>
                    </div>
                </div>
                <div id="menuStep3" class="step">
                    <div class="content">
                        <div class="title">Fotos</div>
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
            <div class="ui animated fade green button" id="detalhes<?php echo $idImovel; ?>">
                <div class="visible content"><i class="home icon"></i> <?php echo ucfirst($tipoImovel) ?></div>
                <div class="hidden content">
                    Ver detalhes
                </div>
            </div>
            <div class="ui animated fade orange button" id="btnAnterior1">
                <div class="visible content"><i class="arrow left icon"></i></div>
                <div class="hidden content">
                    Anterior
                </div>
            </div>
            <div class="ui animated fade blue button" id="btnProximo1">
                <div class="visible content"><i class="arrow right icon"></i></div>
                <div class="hidden content">
                    Próximo
                </div>
            </div>
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
                                    <div class="sub header">  <a href="index.php?entidade=Plano&acao=listar"> Para anunciar é preciso ter planos ativos! </a></div>
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
                                    <div class="item" data-value="Aluguel">Aluguel</div>
                                    <div class="item" data-value="Venda">Venda</div>
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
                    <div class="three fields">
                        <div class="field">
                            <div class="ui toggle checkbox">
                                <input name="chkValor" id="chkValor" type="radio" value="SIM">
                                <label>Deseja informar um valor para o imóvel?</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui toggle checkbox">
                                <input name="chkMapa" id="chkMapa" type="radio" value="SIM">
                                <label>Exibir o mapa do endereço?</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui toggle checkbox">
                                <input name="chkContato" id="chkContato" type="radio" value="SIM">
                                <label>Exibir suas informações de contato?</label>
                            </div>
                        </div>
                    </div>
                    <div class="one fields" id="divInformarValor">
                        <div class="field">
                            <label>Valor (não informar os centavos)</label>
                            <input name="txtValor" id="txtValor" class="txtValor" placeholder="Valor do Imóvel" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($tipoImovel == "apartamentoplanta") {
            ?>
            <!--PLANTAS-->
            <div class="ui page grid main">        
                <div class="column" id="step31">
                    <h3 class="ui dividing header">Informações Adicionais</h3>
                    <?php include_once 'AnuncioVisaoInformacoesAdicionais.php'; ?>
                </div>
            </div>
            <?php
        }
        ?>

        <!--FOTOS-->
        <div class="ui page grid main">        
            <div class="column" id="step3">
                <h3 class="ui dividing header">Fotos</h3>
                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                <noscript><input type="hidden" name="redirect" value="index.php"></noscript>
                <h4 class="ui header"> Adicione nessa etapa as fotos para o anúncio</h4>
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="fileupload-buttonbar">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <div class="ui action input">
                        <label class="ui green icon labeled button fileinput-button">
                            <i class="ui large add icon"></i>
                            <input type="file" id="arquivo" name="files[]" multiple style="display: none">Adicionar fotos</label>
                    </div>
                    <button type="submit" class="ui blue button start">
                        <i class="ui upload icon"></i>Enviar fotos
                    </button>
                    <button type="reset" class="ui yellow button cancel">
                        <i class="ui ban icon"></i>Cancelar o envio de todas
                    </button>
                    <button type="button" class="ui red button delete">
                        <i class="ui trash outline icon"></i>Excluir fotos selecionadas
                    </button>
                    <input type="checkbox" class="ui toggle checkbox">
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>

                    <!-- The global progress state -->
                    <div class="column fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                        </div>
                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="ui form table"><tbody class="files"></tbody></table>
                <!-- The template to display files available for upload -->
                <script id="template-upload" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { console.log(this); %}
                    <tr class="template-upload fade">
                    <td>
                    <span class="preview"></span>
                    </td>
                    <td>
                    <p class="name">{%=file.name%}</p>
                    <p class="error"></p>
                    </td>
                    <td>
                    <input type="text" id="txtLegenda[{%=file.name%}]" name="txtLegenda[{%=file.name%}]" placeholder="Informe a Legenda" class="ui input legenda"/>
                    </td>    
                    <td>
                    <p class="size">Processing...</p>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    </td>
                    <td>
                    {% if (!i && !o.options.autoUpload) { %}
                    <button class="ui blue button start" disabled>
                    <i class="ui upload icon"></i>Enviar
                    </button>
                    {% } %}
                    {% if (!i) { %}
                    <button class="ui yellow button cancel">
                    <i class="ui ban icon"></i>Cancelar
                    </button>
                    {% } %}
                    </td>
                    </tr>
                    {% } %}
                </script>
                <!-- The template to display files available for download -->
                <script id="template-download" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { console.log(file); %}
                    <tr class="template-download fade">
                    <td style="vertical-align: middle;">
                    <input type="checkbox" name="delete" value="1" class="ui toggle checkbox">
                    </td>
                    <td style="vertical-align: middle;">
                    <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                    <a href="#" title="{%=file.name%}" download="{%=file.name%}"><img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                    </span>
                    </td>
                    <td style="vertical-align: middle;">
                    <p class="name">
                    {% if (file.url) { %}
                    {%=file.name%}
                    {% } else { %}
                    <span>{%=file.name%}</span>
                    {% } %}
                    </p>
                    {% if (file.error) { %}
                    <div class="ui negative message"><div class="ui header">Ocorreu um erro</div> {%=file.error%}</div>
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
                    <button type="button" class="ui red button delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="ui trash outline icon"></i>Excluir
                    </button>
                    {% } else { %}
                    <button type="reset" class="ui yellow button cancel">
                    <i class="ui ban icon"></i>Cancelar
                    </button>
                    {% } %}
                    </td>
                    {% if (file.url) { %}
                    <td style="vertical-align: middle;">
                    <div class="ui toggle checkbox">
                    <input type="radio" name="rdbDestaque" value="{%=file.name%}">
                    <label>Foto Destaque?</label>
                    </div>
                    </td>
                    {% } %}
                    </tr>
                    {% } %}
                </script>

            </div>
        </div> 
        <!--CONFIRMAÇÃO-->
        <div class="ui page grid main">        
            <div class="column" id="step4">
                <h3 class="ui dividing header">Confirmação</h3>
                <div class="ui segment">
                    <div class="ui stackable ">
                        <table class="ui tablet stackable purple table">
                            <thead>
                                <tr>
                                    <th>Plano</th>
                                    <th>Finalidade</th>
                                    <th>Título</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Exibir Mapa?</th>
                                    <th>Exibir Contato?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="center aligned">
                                    <td id="tdPlano"></td>
                                    <td id="tdFinalidade"></td>
                                    <td id="tdTitulo"></td>
                                    <td id="tdDescricao"></td>
                                    <td id="tdValor"></td>
                                    <td id="tdMapa"></td>
                                    <td id="tdContato"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ui form">
                            <textarea readonly="true"><?php include_once 'assets/txt/termo.php'; ?></textarea>
                        </div>
                        <div class="ui warning message ">
                            Aceito os termos do contrato e reconheço como verdadeiras as informações constantes nesse anuncio e desde logo,
                            responsabiliza-se integralmente pela veracidade e exatidão das informações aqui fornecidas, sob pena de incorrer nas sanções
                            previstas no art. 299 do Decreto Lei 2848/40 (Código Penal). 
                        </div>               
                    </div>               
                </div>
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
$this->setItem($item["imovel"]);
include_once "/modal/ImovelListagemModal.php";
?>

<?php
die();
?>


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
                                            <input type="text" class="form-control" id="txtValor" name="txtValor" placeholder="Valor do Imóvel"  value="<?php //echo $item["anuncio"]->getValor();                               ?>"> 
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