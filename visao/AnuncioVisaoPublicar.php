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
<script src="assets/libs/fileupload/cors/jquery.xdr-transport.js"></script>
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
            //console.log("adicionando foto");
            //metodo para testar de qual upload esta vindo a imagem
            //se for apartamento na planta
            if (data.paramName.substring(0, 14) === "attachmentName") {
                //fazer a validacao do arquivo
                //#configuracao de variaveis
                var EXTENSOES_PERMITIDAS = '.jpg .jpeg .png .gif';
                var TAMANHO_MAXIMO = 3; // MB
                var labelArquivo = data.files[0].name;
                var postfix = labelArquivo.substr(labelArquivo.lastIndexOf('.'));
                var ordemPlanta = data.paramName.substring(14, 15);
                var imagemPreview = $("#uploadPreview" + ordemPlanta);
                var tamanhoArquivo = data.files[0].size;
                var FOTO_PADRAO = "<?php echo PIPURL . "assets/imagens/logo.png"; ?>";
                var sucesso;
                sucesso = true;
                //validacao tipo arquivo
                if (EXTENSOES_PERMITIDAS.indexOf(postfix.toLowerCase()) > -1) {
                    //validacao tamanho
                    if (tamanhoArquivo > 1024 * 1024 * TAMANHO_MAXIMO) {
                        alert('Tamanho máximo da imagem:' + TAMANHO_MAXIMO + ' MB');
                        $(imagemPreview).attr("src", FOTO_PADRAO);
                        sucesso = false;
                    } else {
                        //mostrar preview da foto
                        var oFReader = new FileReader();
                        oFReader.readAsDataURL(data.fileInput[0].files[0]);
                        oFReader.onload = function (oFREvent) {
                            $(imagemPreview).attr("src", oFREvent.target.result);
                            var novoFormulario = new FormData();
                            $.each(data.fileInput[0].files, function (i, file) {
                                novoFormulario.append(data.paramName, file);
                            });
                            novoFormulario.append("hdnEntidade", "Anuncio");
                            novoFormulario.append("hdnAcao", "cadastrarAnuncioImagemPlanta");
                            novoFormulario.append("ordem", ordemPlanta);
                            novoFormulario.append("hdnToken", $("#hdnToken").val());

                            $.ajax({
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: novoFormulario,
                                contentType: false,
                                processData: false,
                                cache: false,
                                success: function (resposta) {
                                    //console.log(resposta);
                                    if (resposta.resultado === 1) {
                                        alert("Imagem da planta " + (parseInt(ordemPlanta) + 1) + " foi carregada com sucesso");
                                    } else {
                                        alert(resposta.retorno);
                                        $(imagemPreview).attr("src", FOTO_PADRAO);
                                    }
                                }
                            })
                        }
                    }
                } else {
                    alert('Tipo de arquivo inválido. São aceitos os tipos:' + EXTENSOES_PERMITIDAS);
                    $(imagemPreview).attr("src", FOTO_PADRAO);
                    sucesso = false;
                }
                e.preventDefault();//nao mostrar no template do fileupload

                if (!sucesso) {
                    //falha cria formulario e envia erro
                    var novoFormulario = new FormData();
                    novoFormulario.append("hdnEntidade", "Anuncio");
                    novoFormulario.append("hdnAcao", "apagarImagemPlanta");
                    novoFormulario.append("ordem", ordemPlanta);
                    novoFormulario.append("hdnToken", $("#hdnToken").val());
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        data: novoFormulario,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function () {
                        }
                    });
                }
            } /*else {
             //imagens do anuncio
             console.log("uploading");
             $('.ui.checkbox').checkbox();
             $("p[class='error']").each(function () {
             var error = $(this).html();
             if (error !== "") {
             $(this).html('<div class="ui error message"><div class="header">Ocorreu um erro</div><p>' + error + '</p></div>');
             }
             })
             }*/
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = $("#fileupload").serializeArray();
        }).on('fileuploadalways', function (e, data) {
            //console.log('completou');
            $('.ui.checkbox').checkbox();
            $("p[class='error']").each(function () {
                var error = $(this).html();
                if (error !== "") {
                    //$(this).html('<div class="ui error message"><div class="header">Ocorreu um erro</div><p>' + error + '</p></div>');
                }
            })
        }).on('fileuploadfail', function (e, data) {
            //console.log('cancelando');
            //# metodo para testar de qual upload esta vindo a imagem
            var input = data.fileInput[0];
            //#se for apartamento na planta
            if ($(input).attr("name") == "attachmentName[]") {
                $($('#fileupload  .cancel ')[parseInt(data.context[0].rowIndex) + 1]).click();
            }
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
        timeoutSessao();
    });

</script>

<script>
    cadastrarAnuncio();
    cancelar('Anuncio', 'listarCadastrar');
<?php if ($tipoImovel == "apartamentoplanta") { ?>
        stepsComPlanta();
        validarValor(false);
<?php } else { ?>
        stepsSemPlanta();
        validarValor(true);
<?php } ?>
    $(document).ready(function () {
        $('#chkValor').parent().checkbox('set checked');
        $("#divInformarValor").show();
    })
</script>

<div class="ui column doubling grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <i class="announcement small icon"></i><a href="index.php?entidade=Anuncio&acao=listarCadastrar">Anúncios</a>
                <i class="right chevron icon divider"></i>
                <?php if ($item["anuncio"]->getId() != "") { ?>
                    <a class="active section" href="index.php?entidade=Anuncio&acao=listarReativar">Reativar Anúncios</a>
                <?php } else { ?>
                    <a class="active section" href="index.php?entidade=Anuncio&acao=listarCadastrar">Publicar Anúncio</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="ui fluid small ordered steps">
            <?php if ($tipoImovel == "apartamentoplanta") { ?>
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
                        <div class="title">Plantas</div>
                    </div>
                </div>
                <div id="menuStep4" class="step">
                    <div class="content">
                        <div class="title">Fotos</div>
                    </div>
                </div>
                <div id="menuStep5" class="step">
                    <div class="content">
                        <div class="title">Confirmação</div>
                    </div>
                </div>
                <div id="menuStep6" class="step">
                    <div class="content">
                        <div class="title">Publicação</div>
                    </div>
                </div>
            <?php } else { ?>
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
                <div id="menuStep4" class="step">
                    <div class="content">
                        <div class="title">Fotos</div>
                    </div>
                </div>
                <div id="menuStep5" class="step">
                    <div class="content">
                        <div class="title">Confirmação</div>
                    </div>
                </div>
                <div id="menuStep6" class="step">
                    <div class="content">
                        <div class="title">Publicação</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="ui hidden divider"></div>
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <!--NAVEGAÇÃO-->
        <div class="ui basic right aligned segment">
            <div class="ui animated fade green button" id="detalhes<?php echo $idImovel; ?>">
                <div class="visible content"><i class="home icon"></i> <?php echo ucfirst($tipoImovel) ?></div>
                <div class="hidden content">
                    Ver detalhes
                </div>
            </div>
            <div class="ui animated fade brown button" id="btnAnterior1">
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
</div>

<div class="ui hidden divider"></div>

<form id="fileupload" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" id="hdnId" name="hdnId" value=""/>
    <input type="hidden" id="hdnIdImovel" name="hdnIdImovel" value="<?php echo $idImovel; ?>" />
    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="Cadastrar" />
    <input type="hidden" id="hdnStep" name="hdnStep" value="1" />
    <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <!--SELECIONE O PLANO-->
            <div class="sixteen wide column" id="step1" class="">            
                <h3 class="ui dividing header">Escolha o plano a ser utilizado no seu anúncio</h3>
                <div class="ui form segment">
                    <div class="fields">
                        <div class="eight wide required field">
                            <label>Plano</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="sltPlano" id="sltPlano">
                                <i class="dropdown icon"></i>
                                <?php
                                if ($item && count($item["usuarioPlano"]) > 0) {
                                    ?>
                                    <div class="text">Escolha um plano</div>
                                    <div class="menu">                            
                                        <?php
                                        foreach ($item["usuarioPlano"] as $usuarioPlano) {
                                            ?>
                                            <div class="item" data-value="<?php echo $usuarioPlano->getId() ?>"><?php echo $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias) - Expira em: " . $usuarioPlano->DataExpiracao($usuarioPlano->getPlano()->getValidadeativacao()); ?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="text">Você ainda não possui planos ativos.</div>
                                    <?php
                                }
                                ?>
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

            <!--INFORMAÇÕES BÁSICAS-->
            <div class="sixteen wide column" id="step2">
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
                                <input name="chkValor" id="chkValor" type="checkbox" value="SIM">
                                <label>Deseja informar um valor para o imóvel?</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui toggle checkbox">
                                <input name="chkMapa" id="chkMapa" type="checkbox" value="SIM">
                                <label>Exibir o mapa do endereço?</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui toggle checkbox">
                                <input name="chkContato" id="chkContato" type="checkbox" value="SIM">
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

            <?php
            if ($tipoImovel == "apartamentoplanta") {
                ?>
                <!--PLANTAS-->                 
                <div class="sixteen wide column" id="step3">
                    <h3 class="ui dividing header">Informações Adicionais</h3>
                    <?php include_once 'AnuncioVisaoInformacoesAdicionais.php'; ?>
                </div>
                <?php
            }
            ?>
            <!--FOTOS-->
            <div class="sixteen wide column" id="step4">
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
                        <i class="ui upload icon"></i>Enviar todas
                    </button>
                    <button type="reset" class="ui yellow button cancel">
                        <i class="ui ban icon"></i>Cancelar o envio de todas
                    </button>
                    <button type="button" class="ui red button delete">
                        <i class="ui trash outline icon"></i>Excluir selecionadas
                    </button>
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
                <div class="fileupload-buttonbar"><label class="ui basic black label"><input type="checkbox" class="ui toggle checkbox"><div class="detail">Selecionar Todas</div></label></div>

                <!-- The template to display files available for upload -->
                <script id="template-upload" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
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
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
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
                    <div class="ui error message"><div class="header">Ocorreu um erro</div><p class="error"> {%=file.error%} </p></div>
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

            <!--CONFIRMAÇÃO-->
            <div class="sixteen wide column" id="step5">
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

            <!--PUBLICAÇÃO-->
            <div class="sixteen wide column" id="step6">
                <h3 class="ui dividing header">Publicação</h3>
                <div class="ui segment" id="divRetorno">
                    <p></p>
                </div>
            </div>

        </div>
    </div>
</form>
<div class="ui hidden divider"></div>
<!--NAVEGAÇÃO-->
<div class="ui middle aligned stackable grid container">
    <div class="row">
        <div class="ui basic center aligned segment">
            <div class="ui brown button" id="btnAnterior2"><i class="arrow left icon"></i> Anterior</div>
            <div class="ui orange button" id="btnCancelar">Cancelar</div>
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
        <div class="ui red deny button">
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
