function cancelar(entidade, acao) {
    $(document).ready(function () {

        $('#btnCancelar').click(function () {
            $('#modalCancelar').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                    if (entidade === "" && acao === "") {
                        location.href = "index.php";
                    } else
                        location.href = "index.php?entidade=" + entidade + "&acao=" + acao;
                }
            }).modal('show');
        })
    })
}

function cadastrarAnuncio() {
    $(document).ready(function () {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $('.ui.checkbox')
                .checkbox()
                ;
        $('#chkMapa').parent().checkbox('set checked');
        $('#chkContato').parent().checkbox('set checked');
        $('#txtDescricao').maxlength({
            alwaysShow: true,
            threshold: 150,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtTitulo').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('.txtValor').priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        });
        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest(".error").removeClass("error").addClass("success");
            }
        });
        $.validator.messages.required = 'Campo obrigatório';
        $('#fileupload').validate({
            onkeyup: false,
            focusInvalid: true,
            onfocusout: false,
            rules: {
                sltPlano: {
                    synchronousRemote: {
                    url: "index.php",
                        dataType: "json",
                        type: "post",
                        data: {
                          hdnEntidade: "Anuncio",
                          hdnAcao: "verificarPlanoGratuito",
                          hdnToken: $("#hdnToken").val()
                        }
                 },
                    required: true
                },
                sltFinalidade: {
                    required: true
                },
                txtTitulo: {
                    required: true
                },
                txtDescricao: {
                    required: true
                },
                chkAceite: {
                    required: true
                }
            },
            messages: {
                chkAceite: {
                    required: "A confirmação é obrigatória"
                },
                 sltPlano: {
                     synchronousRemote: "Você já tem um anúncio gratuito e ativo. Você pode utilizar outro plano já adquirido ou comprar um novo plano."
                 }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#fileupload').serialize(),
                    beforeSend: function () {
                        $('button').attr('disabled', 'disabled');
                    },
                    success: function (resposta) {
                        $("div[id^='step']").hide();
                        $("#step6").show();
                        if (resposta.resultado == 1) {
                            $("#divRetorno").html("\
                                <div class='ui two column center aligned grid'>\n\
                                    <div class='ui compact positive message'>\n\
                                            <i class='big green check circle outline icon'></i>Seu anúncio foi cadastrado com sucesso. Aguarde a confirmação da publicação para que ele possa ser visualizado\n\</div>\n\
                                </div>\n\
                                <div class='ui hidden divider'></div>\n\
                                    <div class='ui vertical segment'>\n\
                                         Código do Anúncio: <strong>" + resposta.idanuncio + "</strong> \n\
                                      </div>\n\
                                      <div class='ui vertical segment'>\n\
                                        Se desejar, escolha uma das opções abaixo. Obrigado por publicar seu anúncio em PIP Online <i class='big gray thumbs outline up icon'></i>\n\
                                      </div>\n\
                                    <div class='row'>\n\
                                        <div class='column'>\n\
                                            <div class='ui horizontal segments'>\n\
                                            <div class='ui segment center aligned'><a target='_blank' href='index.php?entidade=AnuncioAprovacao&acao=fimCadastroAnuncio&hdnCodAnuncio=" + resposta.id + "&hdnTipo=" + resposta.tipoImovel + "' class='ui circular inverted icon button'><i class='big brown zoom icon'></i></a>\n\
                                                    Visualizar Anúncio\n\
                                            </div>\n\
                                            <div class='ui segment center aligned'>\n\
                                                <a href='index.php?entidade=Anuncio&acao=listarCadastrar' class='ui circular inverted icon button'><i class='big green announcement icon'></i></a>\n\
                                                        Cadastrar Novo Anúncio\n\
                                            </div>\n\
                                            <div class='ui segment center aligned'>\n\
                                               <a href='index.php?entidade=Usuario&acao=MeuPIP'  class='ui circular inverted icon button'><i class='big blue home icon'></i></a>\n\
                                                       Retornar ao Meu PIP\n\
                                           </div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>");
                            $('#botaoDetalhesImovel').hide();
                            $('#divTextoPublicacao').html("Anúncio Publicado Com Sucesso");

                        } else {
                            $("#divRetorno").html("<div class='ui warning icon message'>\n\
                                 <i class='checkmark icon'></i>\n\
                                 <div class='content'>\n\
                                     <div class='header'>Erro ao Cadastrar</div>Ocorreu um erro ao cadastrar o anúncio. \n\
                                    Tente novamente em alguns minutos</div>\n\
                                 </div>\n\
                             </div>");
                            $('button').removeAttr('disabled');
                        }
                    }
                })
                return false;
            }
        })


// UPLOAD FOTOS
        $('#fileupload').fileupload({
            dropZone: null,
            pasteZone: null,
            autoUpload: false,
            url: 'index.php?upload=1',
            //maxNumberOfFiles: 5,
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
                var FOTO_PADRAO = "assets/imagens/logo.png";
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
            }
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = $("#fileupload").serializeArray();
        }).on('fileuploadalways', function (e, data) {
            $('.ui.checkbox').checkbox();
            $("p[class='error']").each(function () {
                var error = $(this).html();
                if (error !== "") {
                    //$(this).html('<div class="ui error message"><div class="header">Ocorreu um erro</div><p>' + error + '</p></div>');
                }
            })
        }).on('fileuploadfail', function (e, data) {
            //# metodo para testar de qual upload esta vindo a imagem
            var input = data.fileInput[0];
            //#se for apartamento na planta
            if ($(input).attr("name") == "attachmentName[]") {
                $($('#fileupload  .cancel ')[parseInt(data.context[0].rowIndex) + 1]).click();
            }
        });

        $('.special.cards .image').dimmer({
            on: 'hover'
        });
        timeoutSessao();
// FIM UPLOAD FOTOS

    });
}


function editarAnuncio() {
    $(document).ready(function () {
        $('.ui.dropdown').dropdown({ on: 'hover' });
        $('.ui.checkbox').checkbox();
        $('#chkMapa').parent().checkbox('set checked');
        $('#chkContato').parent().checkbox('set checked');
        $('#txtDescricao').maxlength({
            alwaysShow: true,
            threshold: 150,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtTitulo').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('.txtValor').priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        });
        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest(".error").removeClass("error").addClass("success");
            }
        });
        $.validator.messages.required = 'Campo obrigatório';
        $('#fileupload').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                sltPlano: {
                    required: true
                },
                sltFinalidade: {
                    required: true
                },
                txtTitulo: {
                    required: true
                },
                txtDescricao: {
                    required: true
                },
                chkAceite: {
                    required: true
                }
            },
            messages: {
                chkAceite: {
                    required: "A confirmação é obrigatória"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#fileupload').serialize(),
                    beforeSend: function () {
                        $('button').attr('disabled', 'disabled');
                    },
                    success: function (resposta) {
                        $("div[id^='step']").hide();
                        $("#step6").show();
                        if (resposta.resultado == 1) {
                            $("#divRetorno").html("\
                                <div class='ui two column center aligned grid'>\n\
                                    <div class='ui compact positive message'>\n\
                                            <i class='big green check circle outline icon'></i>Edição do anúncio " + resposta.idanuncio + " feita com sucesso. As alterações realizadas estão em análise e em breve serão visualizadas\n\</div>\n\
                                </div>\n\
                                <div class='ui hidden divider'></div>\n\
                                      <div class='ui vertical segment'>\n\
                                        Se desejar, escolha uma das opções abaixo. Obrigado por fazer parte do universo PIP Online <i class='big gray thumbs outline up icon'></i>\n\
                                      </div>\n\
                                    <div class='row'>\n\
                                        <div class='column'>\n\
                                            <div class='ui horizontal segments'>\n\
                                            <div class='ui segment center aligned'><a target='_blank' href='index.php?entidade=AnuncioAprovacao&acao=fimCadastroAnuncio&hdnCodAnuncio=" + resposta.id + "&hdnTipo=" + resposta.tipoImovel + "' class='ui circular inverted icon button'><i class='big brown zoom icon'></i></a>\n\
                                                    Visualizar Anúncio\n\
                                            </div>\n\
                                            <div class='ui segment center aligned'>\n\
                                                <a href='index.php?entidade=Anuncio&acao=listarCadastrar' class='ui circular inverted icon button'><i class='big green announcement icon'></i></a>\n\
                                                    Cadastrar Novo Anúncio\n\
                                            </div>\n\
                                            <div class='ui segment center aligned'>\n\
                                               <a href='index.php?entidade=Usuario&acao=MeuPIP'  class='ui circular inverted icon button'><i class='big blue home icon'></i></a>\n\
                                                    Retornar ao Meu PIP\n\
                                           </div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>");
                            $('#botaoDetalhesImovel').hide();
                            $('#divTextoPublicacao').html("Anúncio editado com sucesso");

                        } else {
                            $("#divRetorno").html("<div class='ui warning icon message'>\n\
                                 <i class='checkmark icon'></i>\n\
                                 <div class='content'>\n\
                                     <div class='header'>Erro ao Cadastrar</div>Ocorreu um erro ao cadastrar o anúncio. \n\
                                    Tente novamente em alguns minutos</div>\n\
                                 </div>\n\
                             </div>");
                            $('button').removeAttr('disabled');
                        }
                    }
                })
                return false;
            }
        })

// UPLOAD FOTOS
        $('#fileupload').fileupload({
            dropZone: null,
            pasteZone: null,
            autoUpload: false,
            url: 'index.php?upload=1',
            maxNumberOfFiles: 3,
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
                var FOTO_PADRAO = "assets/imagens/logo.png";
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
            }
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = $("#fileupload").serializeArray();
        }).on('fileuploadalways', function (e, data) {
            $('.ui.checkbox').checkbox();
            $("p[class='error']").each(function () {
                var error = $(this).html();
                if (error !== "") {
                    //$(this).html('<div class="ui error message"><div class="header">Ocorreu um erro</div><p>' + error + '</p></div>');
                }
            })
        }).on('fileuploadfail', function (e, data) {
            //# metodo para testar de qual upload esta vindo a imagem
            var input = data.fileInput[0];
            //#se for apartamento na planta
            if ($(input).attr("name") == "attachmentName[]") {
                $($('#fileupload  .cancel ')[parseInt(data.context[0].rowIndex) + 1]).click();
            }
        });

        $('.special.cards .image').dimmer({
            on: 'hover'
        });
        timeoutSessao();
// FIM UPLOAD FOTOS

    });
}


function stepsSemPlanta() {
    $(document).ready(function () {
        $("#step1").show();
        $("#step2").hide();
        $("#step3").hide();
        $("#step4").hide();
        $("#step5").hide();
        $("#step6").hide();
        $('#chkValor').parent().checkbox('set checked');
        $("div[id^='btnAnterior']").hide();
        $("#sltPlano").change(function () {
            mudouPlano($(this).val());
            $(this).valid();
        })

        $("#sltFinalidade").change(function () {
            $(this).valid();
        })

        $("#chkValor").change(function () {
            if ($(this).parent().checkbox('is checked')) {
                $("#divInformarValor").show();
            } else {
                $("#divInformarValor").hide();
            }
        })

        $("div[id^='btnProximo']").click(function () {
            if (validarStepSemPlanta()) {
                var atual = parseInt($("#hdnStep").val());
                var proximo;
                if (atual == 2) {
                    proximo = atual + 2;
                } else {
                    proximo = atual + 1;
                }
                $("#step" + atual).hide();
                $("#step" + proximo).show();
                $("#hdnStep").val(proximo);
                $("#menuStep" + atual).removeClass();
                $("#menuStep" + atual).addClass("completed step");
                $("#menuStep" + proximo).addClass("active step");
                if (proximo > 1)
                    $("div[id^='btnAnterior']").show();
                else
                    $("div[id^='btnAnterior']").hide();
                if (proximo > 5) {
                    $("div[id^='btnProximo']").hide();
                    $("div[id^='btnAnterior']").hide();
                    $("#btnCancelar").hide();
                } else
                    $("div[id^='btnProximo']").show();
                $("#mapaGmapsBusca").width("100%").height(300).gmap3({trigger: "resize"});
                $('#mapaGmapsBusca').gmap3('get').setCenter($("#mapaGmapsBusca").gmap3({get: "marker"}).getPosition());
            }
        })

        $("div[id^='btnAnterior']").click(function () {
            var atual = parseInt($("#hdnStep").val());
            var anterior;
            if (atual == 4) {
                anterior = atual - 2;
            } else {
                anterior = atual - 1;
            }
            $("#step" + atual).hide();
            $("#step" + anterior).show();
            $("#hdnStep").val(anterior);
            $("#menuStep" + atual).removeClass();
            $("#menuStep" + atual).addClass("step");
            $("#menuStep" + anterior).removeClass();
            $("#menuStep" + anterior).addClass("active step");
            $("div[id^='btnProximo']").show();
            if (anterior > 1)
                $("div[id^='btnAnterior']").show();
            else
                $("div[id^='btnAnterior']").hide();
            $("#mapaGmapsBusca").width("100%").height(300).gmap3({trigger: "resize"});
            $('#mapaGmapsBusca').gmap3('get').setCenter($("#mapaGmapsBusca").gmap3({get: "marker"}).getPosition());
        })
    })
}

function validarStepSemPlanta() {
    var validacao = false;
    var step = parseInt($("#hdnStep").val());
    switch (step) {
        case 0:
        case 1:
            setTimeout(function(){  }, 3000);
            validacao = $("#sltPlano").valid();
            break;
        case 2:
            validacao = (($("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()));
            break;
        case 4:
            validacao = true;
            if (typeof ($("input[name^=txtLegenda]").val()) !== "undefined" && typeof ($("input[name^=txtLegenda]").attr('disabled')) === "undefined") {
                alert("Você ainda não enviou todas as fotos. \n Clique no botão Enviar");
                validacao = false;
            }
            if (typeof ($("input[name=delete]").val()) !== "undefined") {
                if (typeof ($("input[name=rdbDestaque]:checked").val()) === "undefined") {
                    alert("Informe uma Foto para ser Destaque do seu anúncio");
                    validacao = false;
                }
                if (($("input[name=rdbDestaque]").length) > $("#hdnMaxImagens").val()) {
                    alert("Atenção verifique a quantidade máxima de fotos permitidas para o plano selecionado (" + $("#hdnMaxImagens").val() + " fotos).");
                    validacao = false;
                }
            }

            $("#tdPlano").html($('#sltPlano').parent().find(".selected").html());
            $("#tdImagens").html($('#hdnMaxImagens').val());
            $("#tdFinalidade").html($('#sltFinalidade').parent().find(".selected").html());
            $("#tdTitulo").html($("#txtTitulo").val());
            $("#tdDescricao").html($("#txtDescricao").val());
            $("#tdValor").html(
                    (typeof ($("input[name=chkValor]:checked").val()) === "undefined" ? "Não Informado" : $("#txtValor").val())
                    );
            $("#tdMapa").html((typeof ($("input[name=chkMapa]:checked").val()) === "undefined" ? "Não" : "Sim"));
            $("#tdContato").html((typeof ($("input[name=chkContato]:checked").val()) === "undefined" ? "Não" : "Sim"));

            break;
        case 5:
            validacao = ($("#sltPlano").valid() & $("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid());
            if (validacao) {
                $("#fileupload").submit();
            }
            break;
    }
    return validacao;

}

function stepsComPlanta() {
    $(document).ready(function () {
        $("#step1").show();
        $("#step2").hide();
        $("#step3").hide();
        $("#step4").hide();
        $("#step5").hide();
        $("#step6").hide();
        $("#divValor").hide();
        $("#divInformarValor").hide();
        $("#thValor").hide();
        $("#tdValor").hide();
        $("div[id^='btnAnterior']").hide();
        $("#sltPlano").change(function () {
            mudouPlano($(this).val());
            $(this).valid();
        })

        $("#sltFinalidade").change(function () {
            $(this).valid();
        })
        $("#sltFinalidade").parent().dropdown('set selected', "Venda");

        $("div[id^='btnProximo']").click(function () {
            if (validarStepComPlanta()) {
                var atual = parseInt($("#hdnStep").val());
                var proximo = atual + 1;
                $("#step" + atual).hide();
                $("#step" + proximo).show();
                $("#hdnStep").val(proximo);
                $("#menuStep" + atual).removeClass();
                $("#menuStep" + atual).addClass("completed step");
                $("#menuStep" + proximo).addClass("active step");
                if (proximo > 1)
                    $("div[id^='btnAnterior']").show();
                else
                    $("div[id^='btnAnterior']").hide();
                if (proximo > 5) {
                    $("div[id^='btnProximo']").hide();
                    $("div[id^='btnAnterior']").hide();
                    $("#btnCancelar").hide();
                } else
                    $("div[id^='btnProximo']").show();
                $("#mapaGmapsBusca").width("100%").height(300).gmap3({trigger: "resize"});
                $('#mapaGmapsBusca').gmap3('get').setCenter($("#mapaGmapsBusca").gmap3({get: "marker"}).getPosition());
            }
        })

        $("div[id^='btnAnterior']").click(function () {
            var atual = parseInt($("#hdnStep").val());
            var anterior = atual - 1;
            $("#step" + atual).hide();
            $("#step" + anterior).show();
            $("#hdnStep").val(anterior);
            $("#menuStep" + atual).removeClass();
            $("#menuStep" + atual).addClass("step");
            $("#menuStep" + anterior).removeClass();
            $("#menuStep" + anterior).addClass("active step");
            $("div[id^='btnProximo']").show();
            if (anterior > 1)
                $("div[id^='btnAnterior']").show();
            else
                $("div[id^='btnAnterior']").hide();
            $("#mapaGmapsBusca").width("100%").height(300).gmap3({trigger: "resize"});
            $('#mapaGmapsBusca').gmap3('get').setCenter($("#mapaGmapsBusca").gmap3({get: "marker"}).getPosition());
        })
    })
}

function validarStepComPlanta() {

    var validacao = false;
    var step = parseInt($("#hdnStep").val());
    switch (step) {
        case 0:
        case 1:
            validacao = $("#sltPlano").valid();
            setTimeout(function(){  }, 3000);
            break;
        case 2:
            validacao = (($("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()));
            break;
        case 3:
            validacao = validarTodosAndaresInformados();
            break;
        case 4:
            validacao = true;
            if (typeof ($("input[name^=txtLegenda]").val()) !== "undefined" && typeof ($("input[name^=txtLegenda]").attr('disabled')) === "undefined") {
                alert("Você ainda não enviou todas as fotos. \n Clique no botão Enviar");
                validacao = false;
            }
            if (typeof ($("input[name=delete]").val()) !== "undefined") {
                if (typeof ($("input[name=rdbDestaque]:checked").val()) === "undefined") {
                    alert("Informe uma Foto para ser Destaque do seu anúncio");
                    validacao = false;
                }
                if (($("input[name=rdbDestaque]").length) > $("#hdnMaxImagens").val()) {
                    alert("Atenção verifique a quantidade máxima de fotos permitidas para o plano selecionado (" + $("#hdnMaxImagens").val() + " fotos).");
                    validacao = false;
                }
            }
            $("#tdPlano").html($('#sltPlano').parent().find(".selected").html());
            $("#tdImagens").html($('#hdnMaxImagens').val());
            $("#tdFinalidade").html($('#sltFinalidade').parent().find(".selected").html());
            $("#tdTitulo").html($("#txtTitulo").val());
            $("#tdDescricao").html($("#txtDescricao").val());
            //$("#tdValor").html((typeof ($("input[name=chkValor]:checked").val()) === "undefined" ? "Não Informado" : $("#txtValor").val()));
            $("#tdMapa").html((typeof ($("input[name=chkMapa]:checked").val()) === "undefined" ? "Não" : "Sim"));
            $("#tdContato").html((typeof ($("input[name=chkContato]:checked").val()) === "undefined" ? "Não" : "Sim"));

            break;
        case 5:
            validacao = ($("#sltPlano").valid() & $("#sltFinalidade").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid());
            if (validacao) {
                $("#fileupload").submit();
            }
            break;
    }
    //console.log(validacao);
    return validacao;

}

function validarTodosAndaresInformados() {
    //bool validacao true
    var validacao = true;
    //variavel da qtd total de plantas
    var qtdPlantas = $("#hdnPlantas").val();
    //variavel da qtd total de andares
    var qtdAndares = $("#hdnAndares").val();
    //percorre todas as plantas
    for (i = 0; i <= (qtdPlantas - 1); i++) {
        //para cada planta coletará os andares iniciais e finais a saber se tem todos cadastrados
        var hdnAndarInicial = "hdnAndarInicial" + i + "[]";
        var inicial = $("input[name='" + hdnAndarInicial + "']");
        var hdnAndarFinal = "hdnAndarFinal" + i + "[]";
        var final = $("input[name='" + hdnAndarFinal + "']");
        //verifica se tem andares cadastrados para essa planta
        //se tiver faz a validacao para cada andar
        if (inicial.length > 0) {
            var arrayAndaresIntervaloInicialFinal = [];
            for (j = 0; j < (inicial.length); j++) {
                arrayAndaresIntervaloInicialFinal = gerarNumerosIntervalos($(inicial[j]).val(), $(final[j]).val(), arrayAndaresIntervaloInicialFinal);
            }
            //metodo para remover elementos duplicados do array
            Array.prototype.duplicates = function () {
                return this.filter(function (x, y, k) {
                    return y === k.lastIndexOf(x);
                });
            }
            //remove elementos duplicados
            var andaresAdicionados = arrayAndaresIntervaloInicialFinal.duplicates();
            //verifica se a quantidade de andares eh a mesma
            if (andaresAdicionados.length != qtdAndares) {
                alert("É obrigatório informar todos os valores por andar, se desejar informar valores para uma planta");
                return false;
            }
        }
    }
    return validacao;

}

function planta() {
    $(document).ready(function () {

        $(".sltAndarInicial").change(function () {
            $(this).valid();
        })
        $(".sltAndarFinal").change(function () {
            $(this).valid();
        })

        $(".btnAdicionarValor").click(function () {
            var input = $(this).parent().parent().find("input");
            var sltAndarInicial = input[0];
            var sltAndarFinal = input[1];

            var ordemPlanta = $(this).val();
            $(sltAndarInicial).rules("add", {
                required: true,
                validaAndar: function () {
                    return ordemPlanta
                },
                max: function () {
                    return parseInt($(sltAndarFinal).val());
                },
                messages: {
                    max: "Andar Inicial deve ser Maior ou Igual ao Andar Final"
                }
            });

            $(sltAndarFinal).rules("add", {
                required: true,
                validaAndar: function () {
                    return ordemPlanta
                },
                min: function () {
                    return parseInt($(sltAndarInicial).val());
                },
                messages: {
                    min: "Andar Inicial deve ser Maior ou Igual ao Andar Final"
                }
            });

            var txtValor = input[2];
            $(txtValor).rules("add", {
                required: true
            });
            var validacao = validarPlanta(sltAndarInicial, sltAndarFinal, txtValor);
            if (validacao) {
                var tbody = "#dadosPlanta_" + ordemPlanta;
                $(tbody).append(
                        "<tr><td> <input type='hidden' id='hdnAndarInicial" + ordemPlanta + "[]' name='hdnAndarInicial" + ordemPlanta + "[]' value='" + $(sltAndarInicial).val() + "'>" + $(sltAndarInicial).val() + "</td>" +
                        "<td> <input type='hidden' id='hdnAndarFinal" + ordemPlanta + "[]' name='hdnAndarFinal" + ordemPlanta + "[]' value='" + $(sltAndarFinal).val() + "'>" + $(sltAndarFinal).val() + "</td>" +
                        "<td> <input type='hidden' id='hdnValor" + ordemPlanta + "[]' name='hdnValor" + ordemPlanta + "[]' value='" + $(txtValor).val() + "'>" + $(txtValor).val() + "</td>" +
                        "<td class='collapsing'><div class='red ui icon button' onclick='excluirPlanta($(this))'><i class='trash icon'></i>Excluir</div></td></tr>");
                var tabela = "#tabelaPlanta_" + ordemPlanta;
                $(tabela).show();
            }
            $(sltAndarInicial).rules("remove");
            $(sltAndarFinal).rules("remove");
            $(txtValor).rules("remove");

            if (validacao) {
                $(sltAndarInicial).parent().dropdown('restore defaults');
                $(sltAndarFinal).parent().dropdown('restore defaults');
                $(txtValor).val("");
                sortTable("tabelaPlanta_" + ordemPlanta);
            }
        });
    })
}

function validarPlanta(sltAndarInicial, sltAndarFinal, txtValor) {
    var sucesso = $(sltAndarInicial).valid() & $(sltAndarFinal).valid() & $(txtValor).valid();
    return sucesso;
}

function excluirPlanta(element) {
    $(document).ready(function () {
        var linha = element.parent().parent();
        var pai = linha.parent();
        linha.remove();
        if (pai.find("input").length === 0) {
            pai.parent().hide();
        }
    })
}

function validarValor(validacao) {
    $(document).ready(function () {

        if (validacao) {
            $.validator.addMethod("verificaValor", function (value, element) {
                var validacao = false;
                if ($("#chkValor").parent().checkbox('is checked')) {
                    var valor = parseInt($("#txtValor").unmask());
//                    switch ($('#sltFinalidade').parent().dropdown('get value')) {
//                        case "Aluguel":
                    if (!isNaN(valor)) {
                        if (valor > 100) {
                            validacao = true;
                        }
                    }
//                            break;
//                        case "Venda":
//                            if (!isNaN(valor)) {
//                                if (valor > 1000) {
//                                    validacao = true;
//                                }
//                            }
//                            break;

                } else {
                    validacao = true;
                }
                return this.optional(element) || validacao;
            }, 'Informe um valor mínimo.');

            $("#txtValor").rules("add", {
                verificaValor: true,
                required: function (element) {
                    return $("#chkValor").parent().checkbox('is checked');
                }
            });

            $("#chkValor").change(function () {
                if ($(this).parent().checkbox('is checked')) {
                    $("#divInformarValor").show();
                } else {
                    $("#divInformarValor").hide();
                }
            })
        }

    })
}

function sortTable(name) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(name);
    switching = true;
    /*Make a loop that will continue until
     no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.getElementsByTagName("TR");
        /*Loop through all table rows (except the
         first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
             one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[0].innerHTML;
            xposition = x.indexOf(">");
            xterm = x.slice(xposition + 1);

            y = rows[i + 1].getElementsByTagName("TD")[0].innerHTML;
            yposition = y.indexOf(">");
            yterm = y.slice(yposition + 1);

            //check if the two rows should switch place:
            //if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            if (parseInt(xterm) > parseInt(yterm)) {
                //if so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
             and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}


function validarValorProposta(validacao) {
    $(document).ready(function () {

        if (validacao) {
            $.validator.addMethod("verificaValor", function (value, element) {
                var validacao = false;
                if ($("#txtProposta").val() != "") {
                    var valor = parseInt($("#txtProposta").unmask());
                    switch ($('#hdnFinalidade').val()) {
                        case "Aluguel":
                            if (!isNaN(valor)) {
                                if (valor > 100) {
                                    validacao = true;
                                }
                            }
                            break;
                        case "Venda":
                            if (!isNaN(valor)) {
                                if (valor > 1000) {
                                    validacao = true;
                                }
                            }
                            break;
                    }
                } else {
                    validacao = true;
                }
                return this.optional(element) || validacao;
            }, 'Informe um valor mínimo.');

            $("#txtProposta").rules("add", {
                verificaValor: true,
                required: function (element) {
                    return $("#txtProposta").val();
                }
            });

            $("#txtProposta").val(function () {
                if ($(this).val() != "") {
                    $("#divInformarValor").show();
                } else {
                    $("#divInformarValor").hide();
                }
            })
        }

    })
}

function mudouPlano(plano) {
    $(document).ready(function () {
        var maximo = $("#hdnMaxImagens").val();
        $.ajax({
            url: "index.php",
            dataType: "json",
            type: "POST",
            data: {
                hdnEntidade: "Plano",
                hdnAcao: "maximoDeImagens",
                plano: plano
            },
            success: function (resposta) {
                maximo = resposta.resultado;
                $("#hdnMaxImagens").val(maximo);
                $('#fileupload').fileupload({
                    maxNumberOfFiles: Number(maximo),
                    messages: {
                        maxNumberOfFiles: 'A quantidade máxima de fotos permitidas para o plano selecionado foi atingida (' + maximo + ' fotos) - clique no botão cancelar'
                    }
                })
            }
        })
    })
}

function reativar(botao) {
    $(document).ready(function () {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

        $('#btnReativar' + botao).click(function () {
            $("#btnFecharReativar" + botao).hide();
            $("#sltPlano" + botao).dropdown('restore defaults');
            $('#txtValor' + botao).priceFormat({
                prefix: 'R$ ',
                centsSeparator: ',',
                centsLimit: 0,
                limit: 8,
                thousandsSeparator: '.'
            });

            $("#chkValor" + botao).parent().checkbox('set checked');
            $("#chkValor" + botao).change(function () {
                if ($(this).parent().checkbox('is checked')) {
                    $("#divInformarValor" + botao).show();
                } else {
                    $("#divInformarValor" + botao).hide();
                }
            })

            $('#modalReativar' + botao).modal({
                closable: true,
                transition: "fade up",
                observeChanges: true,
                onDeny: function () {
                    
                },
                onApprove: function () {
                    $("#formReativar" + botao).submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');

            $.validator.setDefaults({
                ignore: [],
                errorClass: 'errorField',
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest("div.field").addClass("error").removeClass("success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest(".error").removeClass("error").addClass("success");
                }
            });
            $.validator.messages.required = 'Campo obrigatório';
            $("#formReativar" + botao).validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    sltPlano: {
                        required: true
                    },
                    txtTitulo: {
                        required: true
                    },
                    txtDescricao: {
                        required: true
                    }
                },
                messages: {
                    sltPlano: {
                        required: "Escolha um Plano"
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $("#formReativar" + botao).serialize(),
                        beforeSend: function () {
                            $("#btnReativarModal" + botao).hide();
                            $("#btnCancelarReativar" + botao).hide();
                            $("#camposAnuncio" + botao).hide();
                            $("#divRetorno" + botao).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetorno" + botao).empty();
                            $("#btnFecharReativar" + botao).show();
                            $("#btnFecharReativar" + botao).click(function () {
                                window.location = "index.php?entidade=Anuncio&acao=listarReativarAluguel";
                            });
                            if (resposta.resultado == 1) {
                                $("#divRetorno" + botao).html("<div class='ui positive message'>\n\
                            <i class='big green check circle outline icon'></i>Anúncio Reativado com Sucesso</div>");

                            } else {
                                $("#divRetorno" + botao).html("<div class='ui negative message'>\n\
                            <i class='big red remove circle outline icon'></i>Erro. Tente novamente em alguns minutos</div>");
                            }
                        }
                    })
                    return false;
                }
            })
        })
    })
}

function formatarDetalhe() {
    $(document).ready(function () {
        $('.ui.accordion').accordion();

        $("#divValor").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })
        $("#txtProposta").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 12,
            thousandsSeparator: '.'
        })
        $("#divValorCondominio").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 12,
            thousandsSeparator: '.'
        })
    })
}

function formatarValor(vetor) {

    $('.ui.checkbox')
            .checkbox();

    $("#tdValor" + vetor).priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    })

}

function formatarValorCampos(vetor) {
    $(document).ready(function () {
        $("#formatarValorJS" + vetor).priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

    })
}

function formatarValorUnico(valor) {
    $(document).ready(function () {
        $("#formatarValorUnicoJS" + valor).priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

    })
}

function exibirEmailPDFListaAnuncio() {

    $(document).ready(function () {

        var selecionado = 0;

        $("input[name^='chkAnuncio']").parent().checkbox({
            beforeChecked: function () { //ao clicar no anuncio, marcar de vermelho   
                var NumeroMaximo = 5;
                if ($("input[name^='listaAnuncio']").length >= NumeroMaximo) {
                    //console.log(selecionado);
                    alert('Selecione no máximo ' + NumeroMaximo + ' anúncios');
                    return false;
                } else {
                    $('#form').after('<input type="hidden" name="listaAnuncio[]" id=anuncio_' + $(this).val() + ' value=' + $(this).val() + '>');
                    selecionado = selecionado + 1;
                    var botaoEmailPDF = ("<div class='ui buttons'>\n\
                        <button class='ui button' id='btnEmail'>Enviar Por Email</button>\n\
                            <div class='or' data-text='ou'></div>\n\
                        <button class='ui positive button' id='btnEmailPDF'>Enviar Por Email - PDF</button>\n\
                        </div>");
                    if (selecionado == 1) {
                        $("#divEmailPDF").append(botaoEmailPDF);
                        confirmarEmail();
                        confirmarEmailPDF();
                    }
                }
            },
            onUnchecked: function () { //ao desmarcar o anuncio
                $('#anuncio_' + $(this).val()).remove();
                selecionado = selecionado - 1;
                if (selecionado == 0) {
                    $("#divEmailPDF").empty();
                }

            }}
        );

    })

    /*$(document).ready(function () {
     
     var selecionado = 0;
     
     $("input[name^='chkAnuncio']").parent().checkbox({
     beforeChecked: function () { //ao clicar no anuncio, marcar de vermelho   
     
     var NumeroMaximo = 5;
     if (selecionado == NumeroMaximo) {
     alert('Selecione no máximo ' + NumeroMaximo + ' anúncios');
     return false;
     } else {
     $('#hdsHidden').append('<input type="hidden" name="listaAnuncio[]" id=anuncio_' + $(this).val() + ' value=' + $(this).val() + '>');
     selecionado = selecionado + 1;
     var botaoEmailPDF = ("<div class='ui buttons'>\n\
     <button class='ui button' id='btnEmail'>Enviar Por Email</button>\n\
     <div class='or' data-text='ou'></div>\n\
     <button class='ui positive button' id='btnEmailPDF'>Enviar Por Email - PDF</button>\n\
     </div>");
     if (selecionado == 1) {
     $("#divEmailPDF").html(botaoEmailPDF);
     confirmarEmail();
     confirmarEmailPDF();
     }
     }
     },
     onUnchecked: function () { //ao desmarcar o anuncio
     $('#anuncio_' + $(this).val()).remove();
     selecionado = selecionado - 1;
     if (selecionado == 0) {
     $("#divEmailPDF").empty();
     }
     
     }}
     
     );
     
     })*/

}

function confirmarEmailPDF() {
    $(document).ready(function () {

        $('#btnEmailPDF').click(function () {

            $("#divMsg").empty();

            $("#txtNomeEmail").hide();
            $("#labelNome").hide();

            $('.emailPDF').attr('value', 'enviarEmailPDF'); //alterar o método para enviarEmailPDF 

            $("#divMsg").append("Preencha os campos abaixo para enviar para o email desejado os anúncios selecidados em PDF");

            $('#modalEmail').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formEmail").submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');

            $.validator.setDefaults({
                ignore: [],
                errorClass: 'errorField',
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest("div.field").addClass("error").removeClass("success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest(".error").removeClass("error").addClass("success");
                }
            });

            $.validator.messages.required = 'Campo obrigatório';
            $('#formEmail').validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    txtEmailEmail: {
                        required: true,
                        email: true
                    },
                    txtMsgEmail: {
                        required: true
                    },
                    captcha_code: {
                        required: true,
                        remote:
                                {
                                    url: "index.php",
                                    dataType: "json",
                                    type: "POST",
                                    data: {
                                        hdnEntidade: "Usuario",
                                        hdnAcao: "validarCaptcha"
                                    }
                                }
                    }
                },
                messages: {
                    txtEmailEmail: {
                        email: "Informe um email válido"
                    },
                    captcha_code: {
                        remote: "Código Inválido"
                    },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#formEmail').serialize(),
                        beforeSend: function () {
                            $("#botaoEnviarEmail").hide();
                            $("#botaoCancelarEmail").hide();
                            $("#camposEmail").hide();
                            $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Enviando. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetorno").empty();
                            $("#botaoCancelarEmail").hide();
                            $("#botaoFecharEmail").show();
                            if (resposta.resultado == 1) {
                                $("#divRetorno").html('<div class="ui positive message">\n\
                        <i class="big green check circle outline icon"></i>Sucesso. Email enviado com sucesso</div>');

                            } else {
                                $("#divRetorno").html('<div class="ui negative message">\n\
                        <i class="big red remove circle outline icon"></i>Erro ao enviar. Tente novamente em alguns minutos</div>');
                            }
                        }
                    })
                    return false;
                }
            })

            /*if ("#hdnMsgDuvida") {
             $("#txtMsgEmail").rules("add", {
             required: true
             });
             }*/
            $("#camposEmail").show();
            $("#botaoEnviarEmail").show();
            $("#botaoCancelarEmail").show();
            $("#botaoFecharEmail").hide();
            $("#divRetorno").empty();

            $("#idAnuncios").empty();
            $("#idAnunciosCabecalho").empty();

            var arr = [];
            $("#idAnuncios").append($("input[name^='listaAnuncio']"));
            $(("input[name^='listaAnuncio']")).each(function () {
                arr.push($(this).val());
            });
            var anuncios = arr.join(", ");
            ;
            $("#idAnunciosCabecalho").append("<div class='ui horizontal list'>\n\
                                        <div class='item'>\n\
                                        <div class='content'>" + anuncios + "</div>\n\
                         </div>\n\
                         </div>");

            /*
             var arr = [];
             $("input[type^='checkbox']:checked").each(function ()
             {
             $("#idAnuncios").append("<input type='hidden' name='anunciosSelecionados[]' value='" + $(this).val() + "'>");
             var codigos = $( "input[name^='hdnCodAnuncioFormatado']" );
             
             if(codigos != ""){
             arr.push($(this).parent().parent().parent().find(codigos).val());
             }      
             
             });
             
             //retira a vírgula do último elemento
             
             var anuncios = arr.join(", ");
             
             
             $("#idAnunciosCabecalho").append("<div class='ui horizontal list'>\n\
             <div class='item'>\n\
             <div class='content'>" + anuncios + "</div>\n\
             </div>\n\
             </div>");   */
        })
    })
}

function finalizar(botao) {
    $(document).ready(function () {

        $('.ui .radio .checkbox').checkbox();

        $("#botaoFecharFinalizar" + botao).hide();

        $('#btnFinalizar' + botao).click(function () {

            $('#txtFinalizar' + botao).maxlength({
                alwaysShow: true,
                threshold: 100,
                warningClass: "ui small green circular label",
                limitReachedClass: "ui small red circular label",
                separator: ' de ',
                preText: 'Voc&ecirc; digitou ',
                postText: ' caracteres permitidos.',
                validate: true
            });

            $('#modalFinalizar' + botao).modal({
                closable: false,
                transition: "fade up",
                onVisible: function () {
                    $("#radioSucessoSim:visible").change(function () {
                        $(this).valid();
                    })
                },
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formFinalizar" + botao).submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');

            $.validator.setDefaults({
                ignore: [],
                errorClass: 'errorField',
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest("div.field").addClass("error").removeClass("success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest(".error").removeClass("error").addClass("success");
                }
            });

            $.validator.messages.required = 'Campo obrigatório';
            $('#formFinalizar' + botao).validate({
                focusInvalid: true,
                rules: {
                    radioSucesso: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#formFinalizar' + botao).serialize(),
                        beforeSend: function () {
                            $("#botaoFecharFinalizar" + botao).hide();
                            $("#botaoCancelarFinalizar" + botao).hide();
                            $("#camposFinalizar" + botao).hide();
                            $("#divRetorno" + botao).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetorno" + botao).empty();
                            $("#botaoCancelarFinalizar" + botao).hide();
                            $("#botaoEnviarFinalizar" + botao).hide();
                            $("#botaoFecharFinalizar" + botao).show();
                            //ao clicar no botão de fechar, o conteúdo será atualizado para retirar o último negócio finalizado
                            $("#botaoFecharFinalizar" + botao).click(function () {
                                window.location = "index.php?entidade=Anuncio&acao=listarAtivo";
                            });

                            if (resposta.resultado == 1) {
                                $("#divRetorno" + botao).html("<div class='ui positive message'>\n\
                        <i class='big green check circle outline icon'></i>Anúncio Finalizado. Obrigado por fazer negócio no PIP OnLine</div>");

                            } else {
                                $("#divRetorno" + botao).html("<div class='ui negative message'>\n\
                        <i class='big red remove circle outline icon'></i>Erro ao finalizar anúncio. Tente novamente em alguns minutos.</div>");
                            }
                        }
                    })
                    return false;
                }
            })

        })
    })
}

function alterarValor(valor) {

    $('#btnMostrarValor' + valor).click(function () {

        $('#modalMostrarValorAnuncio' + valor).modal({
            closable: true,
            transition: "fade up"
        }).modal('show');

    })

    $('#btnAlterarValor' + valor).click(function () {

        $('#botaoFecharAlterarValor' + valor).hide();

        $("#divValorAtual" + valor).priceFormat({
            prefix: 'Valor Atual: R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

        $("#hdnValorAtual" + valor).priceFormat({
            prefix: '',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

        $("#txtNovoValor" + valor).priceFormat({
            prefix: '',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

        $("#txtTitulo" + valor).maxlength({
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        })

        $("#txtDescricao" + valor).maxlength({
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        })

        $('#modalAlterarValorAnuncio' + valor).modal({
            closable: false,
            transition: "fade up",
            onDeny: function () {
            },
            onApprove: function () {
                $("#formAlterarValorAnuncio" + valor).submit();
                return false; //deixar o modal fixo
            }
        }).modal('show');

        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest(".error").removeClass("error").addClass("success");
            }
        });

        //método adicionado para verificar se o novo valor é igual ao valor atual
        $.validator.addMethod("valorDiferente", function (value, element) {
            var valorAntigo = $('#hdnValorAtual' + valor).val();
            var valorNovo = $('#txtNovoValor' + valor).val();
            return valorAntigo != valorNovo
        },
                "O Novo Valor não pode ser igual ao Valor Atual");

        $.validator.messages.required = 'Campo obrigatório';

        $('#formAlterarValorAnuncio' + valor).validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtNovoValor: {
                    //required: true,
                    minlength: 3,
                    valorDiferente: true
                }
            },
            messages: {
                txtNovoValor: {
                    minlength: "Digite ao menos 3 números"
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#formAlterarValorAnuncio' + valor).serialize(),
                    beforeSend: function () {
                        $("#camposNovoValor" + valor).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Editando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {

                        $("#camposNovoValor" + valor).html("");
                        $("#botaoCancelaAlterarValor" + valor).hide();
                        $("#botaoAlterarValor" + valor).hide();
                        $("#botaoFecharAlterarValor" + valor).show();

                        if (resposta.resultado == 1) {
                            $("#divRetornoNovoValor" + valor).html("<div class='ui positive message'>\n\
                                    <i class='big green check circle outline icon'></i>Edição Realizada Com Sucesso\n\
                                </div>");

                            $("#botaoFecharAlterarValor" + valor).click(function () {
                                window.location.reload();
                            })

                        }

                        if (resposta.resultado == 2) {
                            $("#divRetornoNovoValor" + valor).html("<div class='ui negative message'>\n\
                                    <div class='content'><div class='header'>Erro</div>Ocorreu um erro ao \n\
                                    cadastrar. Tente novamente em alguns minutos (Cód. 002)\n\
                                </div></div>");

                            $("#botaoFecharAlterarValor" + valor).click(function () {
                                window.location.reload();
                            })
                        }

                        if (resposta.resultado == 3) { //caso o usuário não esteja logado

                            location.href = "index.php?entidade=Usuario&acao=form&tipo=login";

                        }

                        if (resposta.resultado == 0) {
                            $("#divRetornoNovoValor" + valor).html("<div class='ui negative message'>\n\
                                    <div class='content'><div class='header'>Erro</div>\n\
                                Ocorreu um erro ao cadastrar. Tente novamente em alguns minutos\n\
                                </div></div>");
                            $("#botaoFecharAlterarValor" + valor).click(function () {
                                window.location.reload();
                            })
                        }
                    }
                })
                return false;
            }
        })

    })

}

function escreverTextoEspecificoDetalhe(tipoAnuncio) {
    $(document).ready(function () {

        switch (tipoAnuncio) {

            case "apartamento":
                $("#textoEspecifico").html("Específico do Apartamento");
                break;
            case "casa":
                $("#textoEspecifico").html("Específico da Casa");
                break;
            case "apartamentoplanta":
                $("#textoEspecifico").html("Específico do Apartamento na Planta");
                break;
            case "salacomercial":
                $("#textoEspecifico").html("Específico da Sala Comercial");
                break;
            case "prediocomercial":
                $("#textoEspecifico").html("Específico do Prédio Comercial");
                break;
            case "terreno":
                $("#textoEspecifico").html("Específico do Terremo");
                break;
        }
    })
}

function alterarStatusAnuncio(valor) {

    $(document).ready(function () {
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

        $("#sltStatusAnuncio" + valor).change(function () {
            $(this).valid();
        })

        $("input[name^='sltStatusAnuncio']").parent().dropdown({
            on: 'hover'
        })

        $('#btnMudarStatus' + valor).click(function () {
            $("#botaoFecharStatus" + valor).hide();

            $('#modalMudarStatus' + valor).modal({
                closable: true,
                transition: "fade up",
                observeChanges: true,
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formAlterarStatusAnuncio" + valor).submit();
                    return false; //deixar o modal fixo
                },
            }).modal('show');

            $.validator.setDefaults({
                ignore: [],
                errorClass: 'errorField',
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest("div.field").addClass("error").removeClass("success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest(".error").removeClass("error").addClass("success");
                }
            });

            $.validator.messages.required = 'Campo obrigatório';

            $("#formAlterarStatusAnuncio" + valor).validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    sltStatusAnuncio: {
                        required: true
                    },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $("#formAlterarStatusAnuncio" + valor).serialize(),
                        beforeSend: function () {
                            $("#botaoAlterarStatus" + valor).hide();
                            $("#botaoCancelaAlterarStatus" + valor).hide();
                            $("#camposAlterarStatus" + valor).hide();
                            $("#divRetornoNovoStatus" + valor).html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetornoNovoStatus" + valor).empty();
                            $("#botaoFecharStatus" + valor).show();
                            $("#botaoFecharStatus" + valor).click(function () {
                                window.location = "index.php?entidade=AnuncioAprovacao&acao=listarPendente";
                            });
                            if (resposta.resultado == 1) {
                                $("#divRetornoNovoStatus" + valor).html("<div class='ui positive message'>\n\
                            <i class='big green check circle outline icon'></i>Status Alterado com Sucesso</div>");

                            } else {
                                $("#divRetornoNovoStatus" + valor).html("<div class='ui negative message'>\n\
                            <i class='big red remove circle outline icon'></i>Erro. Tente novamente em alguns minutos</div>");
                            }
                        }
                    })
                    return false;
                }
            })

        })

    })

    /*
     $('#btnMudarStatus' + valor).click(function () {
     
     $('#botaoFecharStatus' + valor).hide();
     
     $('#modalMudarStatus' + valor).modal({
     closable: false,
     transition: "fade up",
     onDeny: function () {
     },
     onApprove: function () {
     $("#formAlterarStatusAnuncio" + valor).submit();
     return false; //deixar o modal fixo
     }
     }).modal('show');
     
     $.validator.setDefaults({
     ignore: [],
     errorClass: 'errorField',
     errorElement: 'div',
     errorPlacement: function (error, element) {
     error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
     },
     highlight: function (element, errorClass, validClass) {
     $(element).closest("div.field").addClass("error").removeClass("success");
     },
     unhighlight: function (element, errorClass, validClass) {
     $(element).closest(".error").removeClass("error").addClass("success");
     }
     });
     
     $.validator.messages.required = 'Campo obrigatório';
     
     $('#formAlterarValorAnuncio' + valor).validate({
     onkeyup: false,
     focusInvalid: true,
     
     rules:{
     sltStatusAnuncio: {
     required: true
     },
     },
     
     submitHandler: function (form) {
     $.ajax({
     url: "index.php",
     dataType: "json",
     type: "POST",
     data: $('#formAlterarStatusAnuncio' + valor).serialize(),
     beforeSend: function () {
     $("#camposAlterarStatus" + valor).html("<div><div class='ui active inverted dimmer'>\n\
     <div class='ui text loader'>Editando. Aguarde...</div></div></div>");
     },/*
     success: function (resposta) {
     
     $("#camposAlterarStatus" + valor).html("");
     $("#listaStatus" + valor).hide();
     $("#botaoCancelaAlterarStatus" + valor).hide();
     $("#botaoAlterarStatus" + valor).show();
     
     if (resposta.resultado == 1) {
     $("#divRetornoNovoStatus" + valor).html("<div class='ui positive message'>\n\
     <i class='big green check circle outline icon'></i>Status Alterado Com Sucesso\n\
     </div>");
     
     $("#botaoFecharAlterarValor" + valor).click(function () {
     window.location.reload();
     })
     
     }
     
     if (resposta.resultado == 2) {
     $("#divRetornoNovoStatus" + valor).html("<div class='ui negative message'>\n\
     <div class='content'><div class='header'>Erro</div>Ocorreu um erro ao \n\
     alterar o status. Tente novamente em alguns minutos (Cód. 002)\n\
     </div></div>");
     
     $("#botaoFecharAlterarValor" + valor).click(function () {
     window.location.reload();
     })
     }
     
     if (resposta.resultado == 3) { //caso o usuário não esteja logado
     
     location.href = "index.php?entidade=Usuario&acao=form&tipo=login";
     
     }
     
     if (resposta.resultado == 0) {
     $("#divRetornoNovoStatus" + valor).html("<div class='ui negative message'>\n\
     <div class='content'><div class='header'>Erro</div>\n\
     Ocorreu um erro ao alterar o status. Tente novamente em alguns minutos\n\
     </div></div>");
     $("#botaoFecharStatus" + valor).click(function () {
     window.location.reload();
     })
     }
     }
     })
     return false;
     }
     })
     })*/
}

