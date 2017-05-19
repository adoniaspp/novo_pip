<?php
Sessao::gerarToken();
$item = $this->getItem();

if ($item) {
    foreach ($item["imovel"] as $objImovel) {
        $idImovel = $objImovel->getId();
        $tipoImovel = $objImovel->getTipoImovel()->getDescricao();
    }
    $anuncio = $item["anuncio"];
}

$valorAnuncio = (isset($item["novovalor"][0])) ? $item["novovalor"][0]->getNovovalor() : $anuncio->getValormin();
?>
<script src="assets/libs/jquery/jquery.validate.min.js"></script>
<script src="assets/libs/jquery/jquery.mask.min.js"></script>
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/anuncio.js"></script>
<script src="assets/js/buscaAnuncio.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>
<script src="assets/libs/gmaps/gmap3.min.js"></script>
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
    editarAnuncio();
    cancelar('Anuncio', 'listarCadastrar');
<?php if ($tipoImovel == "apartamentoplanta") { ?>
        stepsComPlanta();
        //        validarValor(false);
<?php } else { ?>
        stepsSemPlanta();
        validarValor(true);
<?php } ?>
</script>

<div class="ui column doubling grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <i class="announcement small icon"></i><a href="index.php?entidade=Anuncio&acao=listarAtivo">Anúncios</a>
                <i class="right chevron icon divider"></i>
                <?php //if ($item["anuncio"]->getId() != "") {  ?>
                <a class="active section">Editar Anúncios</a>
                <?php //} else {  ?>
                <!--<a class="active section" href="index.php?entidade=Anuncio&acao=listarCadastrar">Publicar Anúncio</a>-->
                <?php //}  ?>
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
        <div class="ui basic right aligned segment" id="botaoDetalhesImovel">

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
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="Editar" />
    <input type="hidden" id="hdnStep" name="hdnStep" value="1" />
    <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <!--SELECIONE O PLANO-->
            <div class="sixteen wide column" id="step1" class="">            
                <h3 class="ui dividing header">Plano utilizado no seu anúncio</h3>
                <div class="ui form segment">
                    <div class="fields">
                        <div class="eight wide required field">
                            <label>Plano</label>
                            <?php
                            foreach ($item["usuarioPlano"] as $usuarioPlano) {
                                echo $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias) - A publicação expira em: " . $usuarioPlano->DataExpiracao($usuarioPlano->getPlano()->getValidadepublicacao());
                            }
                            ?>
                            <div class="ui selection dropdown" style="display:none">
                                <input type="hidden" name="sltPlano" id="sltPlano" value="<?php echo $usuarioPlano->getId() ?>">
                                <i class="dropdown icon"></i>
                                <?php
                                if ($item && count($item["usuarioPlano"]) > 0) {
                                    ?>
                                    <div class="menu">                            
                                        <?php
                                        foreach ($item["usuarioPlano"] as $usuarioPlano) {
                                            ?>
                                            <div class="item" data-value="<?php echo $usuarioPlano->getId() ?>"><?php echo $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias) - A publicação expira em: " . $usuarioPlano->DataExpiracao($usuarioPlano->getPlano()->getValidadepublicacao()); ?></div>
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
                                <input name="sltFinalidade" id="sltFinalidade" type="hidden" value="<?php echo $anuncio->getFinalidade() ?>">
                                <div class="menu">
                                    <?php
                                    if ($tipoImovel != "apartamentoplanta") {
                                        ?>
                                        <div class="item" data-value="Aluguel">Aluguel</div>
                                    <?php } ?>       
                                    <div class="item" data-value="Venda">Venda</div>
                                </div>
                            </div>
                        </div>
                        <div class="twelve wide required field">
                            <label>Título do Anúncio</label>
                            <input name="txtTitulo" id="txtTitulo" type="text" placeholder="Informe o Título" maxlength="50" value="<?php echo $anuncio->getTituloanuncio() ?>">
                        </div>
                    </div>
                    <div class="required field">
                        <label>Descrição</label>
                        <textarea name="txtDescricao" id="txtDescricao" placeholder="Informe uma Descrição do Imóvel" maxlength="150"><?php echo $anuncio->getDescricaoanuncio() ?></textarea>
                    </div>
                    <div class="three fields">
                        <div class="field" id="divValor">
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
                            <input name="txtValor" id="txtValor" class="txtValor" placeholder="Valor do Imóvel" value="<?php echo $valorAnuncio ?>">
                        </div>
                    </div>
                </div>

                <h3 class="ui dividing header">Verificar Localização do Imóvel</h3>
                <div class="ui form segment">

                    <script>
                        marcarMapaPublicarAnuncio("<?php echo $objImovel->getEndereco()->getLogradouro() ?>", "<?php echo $objImovel->getEndereco()->getNumero() ?>", "<?php echo $objImovel->getEndereco()->getBairro()->getNome() ?>", "<?php echo $objImovel->getEndereco()->getCidade()->getNome() ?>", "<?php echo $objImovel->getEndereco()->getEstado()->getUf() ?>", "<?php echo "" ?>", "<?php echo "" ?>", "<?php echo "" ?>", "100%", "300", 16);
                    </script>

                    <div class="ui negative message">
                        <div class="header">
                            ATENÇÃO
                        </div>
                        Verifique se o endereço cadastrado está correto no mapa. Se não estiver, mova o marcador.
                        Arraste o mapa e/ou aumente o zoom com o mouse, caso queira
                    </div>

                    <div class="fields">

                        <input type="hidden" id="hdnEnderecoMapa" name="hdnEnderecoMapa" 
                               value="<?php echo $objImovel->getEndereco()->getLogradouro() . ", " . $objImovel->getEndereco()->getNumero() . ", " . $objImovel->getEndereco()->getBairro()->getNome() ?>" />
                        <div id="mapaGmapsBusca"></div>
                        <input type="hidden" id="hdnLatitude" name="hdnLatitude" value="" />
                        <input type="hidden" id="hdnLongitude" name="hdnLongitude" value="" />

                    </div>


                    <div class="ui message">
                        <div class="header">
                            Endereço do Imóvel
                        </div>
                        <?php
                        if ($objImovel->getEndereco()->getNumero() != "" && $objImovel->getEndereco()->getComplemento() != "") {
                            $endereco = $objImovel->getEndereco()->getLogradouro() . " - " . $objImovel->getEndereco()->getBairro()->getNome() . ", " . $objImovel->getEndereco()->getNumero() . ", " . $objImovel->getEndereco()->getComplemento();
                        } elseif ($objImovel->getEndereco()->getNumero() != "" && $objImovel->getEndereco()->getComplemento() == "") {
                            $endereco = $objImovel->getEndereco()->getLogradouro() . " - " . $objImovel->getEndereco()->getBairro()->getNome() . ", " . $objImovel->getEndereco()->getNumero();
                        } elseif ($objImovel->getEndereco()->getNumero() == "" && $objImovel->getEndereco()->getComplemento() == "") {
                            $endereco = $objImovel->getEndereco()->getLogradouro() . " - " . $objImovel->getEndereco()->getBairro()->getNome();
                        } elseif ($objImovel->getEndereco()->getNumero() == "" && $objImovel->getEndereco()->getComplemento() != "") {
                            $endereco = $objImovel->getEndereco()->getLogradouro() . " - " . $objImovel->getEndereco()->getBairro()->getNome() . ", " . $objImovel->getEndereco()->getComplemento();
                        }

                        echo $endereco;
                        ?>
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
                    <p class="ui error" style="color: #912D2B;    font-size: 1.14285714em;font-weight: 700;"></p>
                    </td>
                    <td>
                    <input type="text" id="txtLegenda[{%=file.name%}]" name="txtLegenda[{%=file.name%}]" placeholder="Informe a Legenda" maxlength="30" class="ui input legenda"/>
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
                    <div class="ui error message" style="display:block"><div class="header">Ocorreu um erro</div><ul class="list"> <li>{%=file.error%} </li><li>Clique no botão "Excluir"</li></ul></div>
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
                                    <th id="thValor">Valor</th>
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
            <div class="ui middle aligned stackable grid container" id="step6">

                <div class="ui hidden divider"></div>
                <h3 class="ui dividing header" id="divTextoPublicacao">Publicação</h3>

            </div>

        </div>
    </div>
</form>

<div class="ui hidden divider"></div><div class="ui hidden divider"></div>

<div class="ui centered aligned stackable grid container">
    <div id="divRetorno">
        <p></p>
    </div>
</div>

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
include_once "modal/ImovelListagemModal.php";
?>

<script>
    $(document).ready(function () {
<?php if ($valorAnuncio == "") { ?>
            $('#chkValor').parent().checkbox('uncheck');
<?php } ?>
<?php if ($anuncio->getPublicarmapa() == "NAO") { ?>
            $('#chkMapa').parent().checkbox('uncheck');
<?php } ?>
<?php if ($anuncio->getPublicarcontato() == "NAO") { ?>
            $('#chkContato').parent().checkbox('uncheck');
<?php } ?>

<?php
$listaFotos = array();
$destaque;
$foto = array();
if (is_array($anuncio->getImagem())) {
    foreach ($anuncio->getImagem() as $imagem) {
        $foto["name"] = $imagem->getNome();
        $foto["size"] = $imagem->getTamanho();
        $foto["type"] = $imagem->getTipo();
        $foto["legenda"] = $imagem->getLegenda();
        $foto["idImage"] = $imagem->getId();
        $foto["url"] = PIPURL . "fotos/imoveis/" . $imagem->getDiretorio() . "/" . $imagem->getNome();
        $foto["thumbnailUrl"] = PIPURL . "fotos/imoveis/" . $imagem->getDiretorio() . "/thumbnail/" . $imagem->getNome();
        $foto["deleteUrl"] = PIPURL . "index.php?file=" . $imagem->getNome();
        $foto["deleteType"] = "DELETE";
        $foto["id"] = $imagem->getId();
        $listaFotos[] = $foto;
        if ($imagem->getDestaque() == "SIM") {
            $destaque = "$(\"input[name='rdbDestaque'][value='" . $imagem->getNome() . "']\").parent().checkbox('set checked');";
        }
    }
} elseif (is_object($anuncio->getImagem())) {
    $foto["name"] = $anuncio->getImagem()->getNome();
    $foto["size"] = $anuncio->getImagem()->getTamanho();
    $foto["type"] = $anuncio->getImagem()->getTipo();
    $foto["legenda"] = $anuncio->getImagem()->getLegenda();
    $foto["idImage"] = $anuncio->getImagem()->getId();
    $foto["url"] = PIPURL . "fotos/imoveis/" . $anuncio->getImagem()->getDiretorio() . "/" . $anuncio->getImagem()->getNome();
    $foto["thumbnailUrl"] = PIPURL . "fotos/imoveis/" . $anuncio->getImagem()->getDiretorio() . "/thumbnail/" . $anuncio->getImagem()->getNome();
    $foto["deleteUrl"] = PIPURL . "index.php?file=" . $anuncio->getImagem()->getNome();
    $foto["deleteType"] = "DELETE";
    $foto["id"] = $anuncio->getImagem()->getId();
    $listaFotos[] = $foto;
    $destaque = "$(\"input[name='rdbDestaque'][value='" . $anuncio->getImagem()->getNome() . "']\").parent().checkbox('set checked');";
}
echo "var files = " . json_encode($listaFotos) . ";";
echo "var form = $('#fileupload');";
echo "form.fileupload('option', 'done').call(form, $.Event('done'), {result: {files: files}});";
echo $destaque;
?>

    });
</script>