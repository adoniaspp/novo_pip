function cadastrarUsuario() {
    $(document).ready(function () {
        /*inicialização da página*/
        $("#sltTipoUsuario").val(''); //limpar o valor do tipo de usuario que foi submetido
        $("#linhaPF").hide();
        $("#linhaPJ1").hide();
        $("#linhaPJ2").hide();
        $("#divCEP").hide();
        $("#tabelaTelefone").hide();
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $("#sltTipoUsuario").parent().dropdown('restore defaults');
        $('.ui.checkbox').checkbox();
        /*eventos e acoes*/
        $("#sltTipoUsuario").change(function () {
            $(this).valid();
            if ($(this).val() == "pj") {
                $("#linhaPF").hide();
                $("#txtNome").rules("remove");
                $("#txtCPF").rules("remove");
                $("#linhaPJ1").show();
                $("#linhaPJ2").show();
                $("#txtNomeEmpresa").rules("add", {
                    required: true,
                });
                $("#txtCNPJ").rules("add", {
                    required: true,
                    cnpj: 'both',
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarCnpj",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                });

                $("#txtRazaoSocial").rules("add", {
                    required: true,
                });
                $("#txtResponsavel").rules("add", {
                    required: true,
                });
                $("#txtCPFResponsavel").rules("add", {
                    required: true,
                    cpf: 'both'
                });
            } else {
                $("#linhaPF").show();
                $("#txtNome").rules("add", {
                    required: true,
                });
                $("#txtCPF").rules("add", {
                    required: true,
                    cpf: 'both',
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarCpf",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                });
                $("#linhaPJ1").hide();
                $("#linhaPJ2").hide();
                $("#txtNomeEmpresa").rules("remove");
                $("#txtCNPJ").rules("remove");
                $("#txtRazaoSocial").rules("remove");
                $("#txtResponsavel").rules("remove");
                $("#txtCPFResponsavel").rules("remove");
            }
        })
        /*validações*/
        $.validator.addMethod('filesize', function (value, element, param) {
            // param = size (en bytes) 
            // element = element to validate (<input>)
            // value = value of the element (file name)
            return this.optional(element) || (element.files[0].size <= param)
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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                sltTipoUsuario: {
                    required: true
                },
                txtLogin: {
                    required: true,
                    minlength: 2,
                    maxlength: 25,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarLogin",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                },
                txtEmail: {
                    required: true,
                    email: true,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarEmail",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
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
                },
                txtSenha: {
                    required: true,
                    minlength: 8,
                    maxlength: 20
                },
                txtConfirmarSenha: {
                    required: true,
                    equalTo: "#txtSenha",
                    maxlength: 20
                },
                txtCEP: {
                    required: true
                },
                txtNumero: {
                    required: true
                },
                chkConfirmacao: {
                    required: true
                },
                arquivo: {
                    //required: true,
                    filesize: 2097152,
                    accept: "jpeg|png|gif"
                },
            },
            messages: {
                txtCPF: {
                    remote: "CPF já utilizado"
                },
                txtCNPJ: {
                    remote: "CNPJ já utilizado"
                },
                txtEmail: {
                    remote: "Email já utilizado",
                    email: "Informe um email válido"
                },
                txtLogin: {
                    minlength: "Login deve possuir no mínimo 2 caracteres",
                    maxlength: "Login deve possuir no máximo 25 caracteres",
                    remote: "Login já utilizado"
                },
                txtSenha: {
                    minlength: "Senha deve possuir no mínimo 8 caracteres",
                    maxlength: "Senha deve possuir no máximo 20 caracteres"
                },
                txtConfirmarSenha: {
                    equalTo: "Por Favor digite a senha novamente"
                },
                chkConfirmacao: {
                    required: "A confirmação é obrigatória"
                },
                arquivo: {
                    //required: "Campo obrigatório"
                    filesize: "A imagem deve ser menor que 2MB",
                    accept: "Extensão de Arquivo Inválida"
                },
                captcha_code: {
                    required: "Campo obrigatório",
                    remote: "Código Inválido"
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
}

function validarTelefone() {
    var telefone = $("#txtTel");
    var tipoTelefone = $("#sltOperadora");
    var tipoOperadora = $("#sltTipotelefone");
    return (telefone.valid() & tipoTelefone.valid() & tipoOperadora.valid());
}

function excluirTelefone(element) {
    $(document).ready(function () {
        element.parent().parent().remove();
        if ($("input[name='hdnTelefone[]'").length === 0)
            $("#tabelaTelefone").hide();
    })
}

function mascarasFormUsuario() {
    $(document).ready(function () {
        $("#txtCPF").mask('000.000.000-00', {reverse: false});
        $("#txtCNPJ").mask("00.000.000/0000-00");
        $("#txtCEP").mask("00.000-000");
        $("#txtCPFResponsavel").mask('000.000.000-00', {reverse: false});
        $("#txtTel").mask('(00) 0000-0000');
        
        $('#txtEmail').maxlength({
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtNome').maxlength({
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtNomeEmpresa').maxlength({
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtRazaoSocial').maxlength({
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtResponsavel').maxlength({
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });


        $('#txtLogin').maxlength({
            alwaysShow: true,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtSenha').maxlength({
            alwaysShow: true,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtConfirmarSenha').maxlength({
            alwaysShow: true,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

    })
}

function acoesCEP() {
    $(document).ready(function () {

        $('#txtNumero').maxlength({
            alwaysShow: true,
            threshold: 6,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtComplemento').maxlength({
            alwaysShow: true,
            threshold: 60,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $("#btnCEP").click(function () {
            buscarCep();
        });
        $("#txtCEP").blur(function () {
            buscarCep();
        });
    })
}

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
                    }
                    else
                        location.href = "index.php?entidade=" + entidade + "&acao=" + acao;
                }
            }).modal('show');
        })
    })
}

function confirmar() {
    $(document).ready(function () {

        $('#btnRegistrar').click(function () {
            validarTelefone();
            if ($("#form").valid()) {
                if (typeof ($("input[name^=hdnTipoTelefone]").val()) == "undefined") {
                    $('#modalTelefone').modal({
                        closable: true,
                        transition: "fade up",
                        onDeny: function () {
                            return false;
                        },
                    }).modal('show');
                } else
                if ($("#hdnCEP").val() != "") {
                    carregaDadosModal($("#textoConfirmacao"));
                    $('#modalConfirmar').modal({
                        closable: true,
                        transition: "fade up",
                        onDeny: function () {
                            return true;
                        },
                        onApprove: function () {
                            $("#form").submit();
                        }
                    }).modal('show');
                } else {
                    $("#msgCEP").remove();
                    var msgCEP = $("<div>", {id: "msgCEP"});
                    msgCEP.attr('class', 'alert alert-danger').html("Primeiro faça a busca do CEP").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    $("#alertCEP").append(msgCEP);
                }
            } else {
                $("#form").submit();
            }
        })
    })
}

function carregaDadosModal($div) {
    $(document).ready(function () {
        $div.html("");
        
        if(jQuery.type($("#txtLogin").val()) !== "undefined"){  //é cadastro

            var inseriLogin = "<div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Login:</div>" + $('#txtLogin').val() + "</div>\n\
                                </div>";
        } else inseriLogin = ""; //é edição, ou seja, não deve aparecer o login no modal
        //fim do verificar se é cadastro ou edição do usuário
        
        if ($("#sltTipoUsuario").val() === "pf")
        {
            $div.append("<div class='ui horizontal list'>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Tipo de Pessoa</div>\n\
                                    Física\n\
                                </div></div>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Nome</div>" + $("#txtNome").val() + "</div>\n\
                                </div>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>CPF</div>" + $("#txtCPF").val() + "</div>\n\
                                </div>"+inseriLogin);
            $div.append("</div>");
        } else {
            $div.append("<div class='ui horizontal list'>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Tipo de Pessoa</div>\n\
                                    Jurídica\n\
                                </div></div>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Empresa</div>" + $("#txtNomeEmpresa").val() + "</div>\n\
                                </div>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>CNPJ</div>" + $("#txtCNPJ").val() + "</div>\n\
                                </div>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Responsável</div>\n\
                                    " + $('#txtResponsavel').val() + "\n\
                                </div></div>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>CPF do Responsável</div>\n\
                                    " + $("#txtCPFResponsavel").val() + "</div>\n\
                                </div>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Razão Social</div>\n\
                                    " + $("#txtRazaoSocial").val() + "</div>\n\
                                </div>"+inseriLogin+"\n\
                                </div>");  
        }

        $div.append("<div class='ui dividing header'></div>\n\
                     <div class='ui horizontal list'>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Email</div>" + $("#txtEmail").val() + "</div>\n\
                                </div>\n\
                     </div></div>");

        $div.append("<div class='ui hidden divider'></div>\n\
                        <div class='ui horizontal list'>\n\
                            <div class='item'><div class='content'>\n\
                            <div class='header'>Telefone(s)</div></div>\n\
                    </div></div>");



        var linhas = "";
        for (var valor = 0; valor < $("input[name^='hdnTipoTelefone']").length; valor++) {

            var tipo = $($("input[name^='hdnTipoTelefone']")[valor]).val();
            var operadora = $($("input[name^='hdnOperadora']")[valor]).val();
            var numero = $($("input[name^='hdnTelefone']")[valor]).val();
            var whatsapp = $($("input[name^='hdnWhatsApp']")[valor]).val();

            linhas = linhas + "<tr><td>" + tipo + "</td><td>" + operadora + "</td><td>" + numero + "</td><td>" + whatsapp + "</td></tr>";
        }
        $div.append("<table class='ui table'>\n\
                        <thead><tr>\n\
                        <th>Tipo</th>\n\
                        <th>Operadora</th>\n\
                        <th>Número</th>\n\
                        <th>Nº WhatsApp</th>\n\
                        </tr>\n\
                        </thead>\n\
                    <tbody>" + linhas + "</tbody></table>");

        var endereco;
        if ($("#txtNumero").val() !== "" && $("#txtComplemento").val() !== "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtNumero").val() + ", " + $("#txtComplemento").val() + " - "+$("#txtBairro").val();
        }

        else if ($("#txtNumero").val() !== "" && $("#txtComplemento").val() === "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtNumero").val() + " - "+$("#txtBairro").val();
        }

        else if ($("#txtNumero").val() === "" && $("#txtComplemento").val() === "") {
            endereco = $("#txtLogradouro").val() + " - "+$("#txtBairro").val();
        }

        else if ($("#txtNumero").val() === "" && $("#txtComplemento").val() !== "") {
            endereco = $("#txtLogradouro").val() + ", " + $("#txtComplemento").val() + " - "+$("#txtBairro").val();
        }

        $div.append("<div class='ui dividing header'></div>\n\
                     <div class='ui horizontal list'>\n\
                                <div class='item'>\n\
                                  <div class='content'>\n\
                                    <div class='header'>Endereço</div>" + endereco + "</div>\n\
                     </div></div>");

    })
}

function buscarCep() {
    var validator = $("#form").validate();
    if (validator) {
        $.ajax({
            url: "index.php",
            dataType: "json",
            type: "POST",
            data: {
                cep: $('#txtCEP').val(),
                hdnEntidade: "Endereco",
                hdnAcao: "buscarCEP"
            },
            beforeSend: function () {
                $("#msgCEP").html('');
                $("#divCEP").hide(); //oculta campos do DIVCEP
                $("#msgCEP").append(criarAlerta("orange", "<i class=\"spinner loading icon\"></i>...aguarde buscando CEP..."));
                $('#txtCEP').attr('disabled', 'disabled');
                $('#btnCEP').attr('disabled', 'disabled');
                $('#txtEstado').val('');
                $('#txtCidade').val('');
                $('#txtBairro').val('');
                $('#txtLogradouro').val('');
                $('#hdnCEP').val('');
            },
            success: function (resposta) {
                $("#msgCEP").html('');
                if (resposta.resultado == 0) {
                    $("#msgCEP").append(criarAlerta("red", "<i class=\"red warning sign icon\"></i> N&atilde;o localizamos o CEP informado."));
                } else {
                    $("#divCEP").show(); //mostra campos do DIVCEP
                    $('#txtEstado').val(resposta.uf);
                    $('#txtCidade').val(resposta.cidade);
                    $('#txtBairro').val(resposta.bairro);
                    $('#txtLogradouro').val(resposta.logradouro);
                    $('#hdnCEP').val($('#txtCEP').val());
                    var endereco = 'Brazil, ' + resposta.uf + ', ' + resposta.cidade + ', ' + resposta.bairro + ', ' + resposta.logradouro;
                }
                $('#txtCEP').removeAttr('disabled');
                $('#btnCEP').removeAttr('disabled');
            }
        })
    }
}

function buscarEmail() {

    $(document).ready(function () {

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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtEmail: {
                    required: true,
                    email: true
                }
            },
            messages: {
                txtEmail: {
                    email: "Informe um email válido"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $("#divEnviarEmail").hide(); //esconder o botão de enviar 
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'><div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {
                        $("#divRetorno").empty();

                        if (resposta.resultado == 0) {
                            $("#divRetorno").html('<div class="ui negative message">\n\
                            <i class="big red remove circle outline icon"></i>E-mail informado n&atilde;o encontrado</div>');
                            $("#divEnviarEmail").show();
                        } else if (resposta.resultado == 1) {
                            $("#txtEmail").attr("readonly", "readonly");
                            $("#divRetorno").html('<div class="ui green message">\n\
                            <i class="big green check circle outline icon"></i>As informações para troca da senha foram enviados para o email informado.</div>');
                        } else if (resposta.resultado == 2) {
                            $("#divRetorno").html('<div class="ui negative message">\n\
                            <i class="big red remove circle outline icon"></i>Erro ao processar requisição - 002</div>');
                        }
                        else if (resposta.resultado == 3) {
                            $("#divRetorno").html('<div class="ui negative message">\n\
                            <i class="big red remove circle outline icon"></i>Erro ao enviar email. Tente novamente em alguns minutos.</div>');
                        }
                        else if (resposta.resultado == 4) {
                            $("#divRetorno").html('<div class="ui negative message">\n\
                            <i class="big red remove circle outline icon"></i>Erro ao processar requisição - 004.</div>');
                        } else {
                            $("#divRetorno").html('<div class="ui negative message">\n\
                            <i class="big red remove circle outline icon"></i>Erro ao processar requisição - 005</div>');
                        }
                    }
                })
                return false;
            }
        })

    });

}

function criarAlerta(tipo, mensagem) {
    var divAlerta = $("<div>", {class: "ui " + tipo + " message"});
    divAlerta.append($("<div>", {class: "content"}).html('<div class="header">' + mensagem + '</div>'));
    return divAlerta;
}

$(document).ready(function () {
    var fileExtentionRange = '.jpg .jpeg .png .gif';
    var MAX_SIZE = 3; // MB

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this);
        if (navigator.appVersion.indexOf("MSIE") != -1) { // IE
            var label = input.val();
            input.trigger('fileselect', [1, label, 0]);
        } else {
            var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            var numFiles = input.get(0).files ? input.get(0).files.length : 1;
            var size = input.get(0).files[0].size;
            input.trigger('fileselect', [numFiles, label, size]);
        }
    });

    $('.btn-file :file').on('fileselect', function (event, numFiles, label, size) {
        $('#attachmentName').attr('name', 'attachmentName'); // allow upload.

        var postfix = label.substr(label.lastIndexOf('.'));
        if (fileExtentionRange.indexOf(postfix.toLowerCase()) > -1) {
            if (size > 1024 * 1024 * MAX_SIZE) {
                alert('Tamanho máximo da imagem：' + MAX_SIZE + ' MB');
                //$("#btnAlterarImagem").attr("disabled", "disabled");
                $("#btnAlterarImagem").attr("class", "ui circular disabled inverted icon button");
                $("#uploadPreview").attr("src", "../assets/imagens/foto_padrao.png");
                $('#attachmentName').removeAttr('name'); // cancel upload file.
            } else {
                $('#arquivolabel').val(label);
                //$("#btnAlterarImagem").removeAttr("disabled");
                $("#btnAlterarImagem").attr("class", "ui circular inverted icon button");
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("attachmentName").files[0]);

                oFReader.onload = function (oFREvent) {
                    document.getElementById("uploadPreview").src = oFREvent.target.result;
                };

            }
        } else {
            alert('Tipo de arquivo inválido. São aceitos os tipos：' + fileExtentionRange);
            $("#btnAlterarImagem").attr("disabled", "disabled");
            $("#uploadPreview").attr("src", "../assets/imagens/foto_padrao.png");
            $('#attachmentName').removeAttr('name'); // cancel upload file.
        }

    });

});

function trocarSenha() { //alterar a senha esquecida
    $(document).ready(function () {
        $("#btnAlterarSenha").click(function () {
            if ($("#form").valid()) {
                if (($("input[name^=txtSenhaAtual]").val()) === ($("input[name^=txtSenhaNova]").val())) {
                    $('#modalSenha').modal({
                        transition: "fade up",
                    }).modal('show');
                } else {
                    $("#form").submit();
                }
            }
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
        $.validator.messages.minlength = "Senha deve possuir no mínimo 8 caracteres";
        $('#form').validate({
            rules: {
                txtSenhaAtual: {
                    required: true,
                    minlength: 8
                },
                txtSenhaNova: {
                    required: true,
                    minlength: 8
                },
                txtSenhaConfirmacao: {
                    required: true,
                    minlength: 8,
                    equalTo: "#txtSenhaNova"
                }
            },
            messages: {
                txtSenhaConfirmacao: {
                    equalTo: "Por Favor digite a nova senha novamente"
                }
            },
            submitHandler: function (form) {

                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                            <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {
                        $("#divRetorno").empty();

                        if (resposta.resultado == 0) {
                            $("#divCamposTrocaSenha").hide();
                            $("#divBotoesTrocarSenha").hide();
                            location.href = "index.php?entidade=Usuario&acao=MeuPIP";
                            /*$("#divRetorno").html("<div class='ui negative message'>\n\
                            <i class='big red remove circle outline icon'>\n\
                            </i>Erro ao processar requisição. Tente novamente em alguns minutos - 000");*/
                        } else if (resposta.resultado == 1) {
                            $("#divCamposTrocaSenha").hide();
                            $("#divBotoesTrocarSenha").hide();
                            location.href = "index.php?entidade=Usuario&acao=MeuPIP";
                            /*$("#divRetorno").html('<div class="ui inverted green center aligned segment">\n\
    <p>Senha alterada com sucesso</p>');*/
                        } else if (resposta.resultado == 2) {
                            $("#divRetorno").html("<div class='ui negative message'>\n\
                            <i class='big red remove circle outline icon'>\n\
                            </i>A senha atual está incorreta. Tente novamente.");
                            
                        } else if (resposta.resultado == 3) {
                            location.href = "index.php?entidade=Usuario&acao=MeuPIP";
                            $("#divRetorno").html('<div class="ui inverted red center aligned segment">\n\
    <p>Erro ao processar requisição - 005</p>');
                        }
                    }
                })
                return false;
            }
        });
    });
}

function trocarImagem() {
    $(document).ready(function () {
        
        $("#btnAlterarImagem").click(function () {           
            $('#modalAlterar').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                    $("#form").submit();
                }
            }).modal('show');
        });
        $("#btnExcluirImagem").click(function () {
            $('#modalExcluir').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                    $("#hdnExcluir").val(1);
                    $("#form").submit();
                }
            }).modal('show');
        });
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                arquivolabel: {
                    required: true
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
}

function esqueciSenha() {
    $(document).ready(function () {
        $("#btnEnviar").click(function () {
            if ($("#form").valid()) {
                $("#form").submit();
            }
        });

        $('#txtEmail').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtEmail: {
                    email: true,
                    required: true
                }
            },
            messages: {
                txtEmail: {
                    email: "Informe um email válido"
                }
            },
            submitHandler: function (form) {
                //form.submit();
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {

                        $("#divRetorno").empty();

                        if (resposta.resultado == 1) {
                            $("#divRetorno").html("<div class='ui positive message'>\n\
                            <i class='big green check circle outline icon'></i>Operação Realizada Com Sucesso. Verifique seu email com as instruções para realizar a troca da senha</div>");
                        } else if (resposta.resultado == 0) {
                            $("#divRetorno").html("<div class='ui negative message'>\n\
                            <i class='big red remove circle outline icon'></i>E-mail não encontrado</div>");
                        }
                    }
                })
                return false;
                
            }
        });


    });
}

function alterarSenha() { //alterar a senha esquecida
    $(document).ready(function () {

        $('#modalCancelar').modal({
            closable: false,
            transition: "fade up",
            onDeny: function () {
                return true
            }
        })

        $("#btnAlterar").click(function () {
            if ($("#form").valid()) {
                $("#form").submit();
            }
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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtSenha: {
                    required: true,
                    minlength: 8
                },
                txtSenhaConfirmacao: {
                    required: true,
                    equalTo: "#txtSenha"
                }
            },
            messages: {
                txtSenha: {
                    minlength: "Senha deve possuir no mínimo 8 caracteres"
                },
                txtSenhaConfirmacao: {
                    equalTo: "Por Favor digite a senha novamente"
                }
            },
            submitHandler: function () {

                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $("#divBotoesAlterarSenha").hide();
                        $("#divCamposAlterarSenha").hide();
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'><div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {
                        $("#divRetorno").empty();

                        if (resposta.resultado == 0) {
                            
                            //window.location.href = "http://localhost/UsuarioVisaoMeuPIP.php";
                            location.href = "index.php?entidade=Usuario&tipo=MeuPIP";
                           /* $("#divRetorno").html('<div class="ui inverted red center aligned segment">\n\
                            <p>Erro ao processar requisição. Tente novamente em alguns minutos - 000</p>');
                            $("#divBotoesAlterarSenha").show();
                            $("#divCamposAlterarSenha").show();*/
                        } else if (resposta.resultado == 1) {
                            
                            //window.location.href = "http://localhost/UsuarioVisaoMeuPIP.php";
                            
                            location.href = "index.php?entidade=Usuario&tipo=MeuPIP";
                            /*
                            $("#txtEmail").attr("readonly", "readonly");
                            $("#divRetorno").html('<div class="ui inverted green center aligned segment">\n\
    <p>Senha alterada com sucesso</p>');
                        } else {
                            $("#divRetorno").html('<div class="ui inverted red center aligned segment">\n\
    <p>Erro ao processar requisição - 005</p>');*/
                        }
                    }
                })
                return false;
            }
        });
    });
}

function fazerLogin() {
    $(document).ready(function () {
        $("#divUsuario").hide();
        $("#btnLogin").click(function () {
            if ($("#form").valid()) {
                $("#form").submit();
            }
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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtSenha: {
                    required: true,
                    minlength: 8,
                    maxlength: 20
                },
                txtLogin: {
                    required: true,
                    minlength: 2,
                    maxlength: 25
                }
            },
            messages: {
                txtSenha: {
                    minlength: "Senha deve possuir no mínimo 8 caracteres"
                },
                txtLogin: {
                    minlength: "Login deve possuir no mínimo 2 caracteres"
                }
            },
            submitHandler: function () {

                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {

                        $("#divRetorno").empty();

                        if (resposta.resultado == 1) {
                            $("#divLoginCadastro").hide();
                            $("#divUsuario").show();
                            $("#btnLogin").attr("disabled", "disabled");
                            location.href = resposta.redirecionamento;
                        } else if (resposta.resultado == 2) {
                            $("#divRetorno").html("<div class='ui negative message'>\n\
                            <i class='big red remove circle outline icon'></i>Usuário ou Senha inválido</div>");
                        }
                    }
                })
                return false;
            }
        });
    });
}

function alterarUsuario() {
    $(document).ready(function () {
        $('.ui.checkbox').checkbox();
        $('#modalConfirmar').modal({
            closable: true,
            transition: "fade up",
            onDeny: function () {
                return true;
            },
        })

        /*validações*/
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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtEmail: {
                    required: true,
                    email: true,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarEmail",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                },
                txtCEP: {
                    required: true
                },
                txtNumero: {
                    required: true
                }
            },
            messages: {
                txtEmail: {
                    remote: "Email já utilizado",
                    email: "Informe um email válido"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
        /*inicialização da página*/
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        if ($('#sltTipoUsuario').val() === "pf") {
            $("#linhaPJ1").hide();
            $("#linhaPJ2").hide();
            $("#txtNome").rules("add", {
                required: true,
            });
            $("#txtNomeEmpresa").rules("remove");
            $("#txtRazaoSocial").rules("remove");
            $("#txtResponsavel").rules("remove");
            $("#txtCPFResponsavel").rules("remove");
        } else {
            $("#linhaPF").hide();
            $("#txtNome").rules("remove");
            $("#txtNomeEmpresa").rules("add", {
                required: true,
            });
            $("#txtRazaoSocial").rules("add", {
                required: true,
            });
            $("#txtResponsavel").rules("add", {
                required: true,
            });
            $("#txtCPFResponsavel").rules("add", {
                required: true,
                cpf: 'both'
            });
        }
    });
}

function telefone() {
    $(document).ready(function () {
        $("#btnAdicionarTelefone").click(function () {
            $("#sltTipotelefone").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            $("#sltOperadora").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            if ($("#sltTipotelefone").val() == "Fixo") {
                $("#txtTel").rules("add", {
                    required: true,
                    minlength: 14,
                    messages: {
                        required: "Campo obrigatório",
                        minlength: "Informe todos os números do telefone"
                    }
                });
            } else {
                $("#txtTel").rules("add", {
                    required: true,
                    minlength: 15,
                    messages: {
                        required: "Campo obrigatório",
                        minlength: "Informe todos os números do telefone"
                    }
                });
            }
            if (validarTelefone()) {
                
                if($("#chkWhatsApp").is(":checked")){
                    $("#chkWhatsApp").val("SIM");
                } else 
                        {$("#chkWhatsApp").val("NÃO");}
                
                $("#dadosTelefone").append(
                        "<tr><td> <input type='hidden' id='hdnTipoTelefone[]' name='hdnTipoTelefone[]' value='" + $("#sltTipotelefone").val() + "'>" + $("#sltTipotelefone").val() + "</td>" +
                        "<td> <input type='hidden' id='hdnOperadora[]' name='hdnOperadora[]' value='" + $("#sltOperadora").val() + "'>" + $("#sltOperadora").val() + "</td>" +
                        "<td> <input type='hidden' id='hdnTelefone[]' name='hdnTelefone[]' value='" + $("#txtTel").val() + "'>" + $("#txtTel").val() + "</td>" +
                        "<td> <input type='hidden' id='hdnWhatsApp[]' name='hdnWhatsApp[]' value='" + $("#chkWhatsApp").val() + "'>" + $("#chkWhatsApp").val() + "</td>" +
                        "<td class='collapsing'><div class='red ui icon button' onclick='excluirTelefone($(this))'><i class='trash icon'></i>Excluir</div></td></tr>");
                $("#txtTel").val("");
                $("#chkWhatsApp").attr("checked", false);  
                $("#tabelaTelefone").show();
            }
            $("#txtTel").rules("remove");
            $("#sltOperadora").rules("remove");
            $("#sltTipotelefone").rules("remove");
        });
        $("#sltTipotelefone").change(function () {
            $("#txtTel").unmask();
            if ($(this).val() == "Fixo") {
                $("#txtTel").mask('(00) 0000-0000');
            } else {
                $("#txtTel").mask('(00) 00000-0000');
            }
        })
    })
}

function ordenarMensagem(){
    
    $(document).ready(function () {
        
        $('#lista').jplist({
            itemsBox: '.list',
            itemPath: '.list-item',
            panelPath: '.jplist-panel',

        })
    
        $("#sltStatusMensagem").change(function () {
            
            $('#form').submit();
            
            
        })
    
    })
    
}

function editarConfiguracao() { 
    $(document).ready(function () {
        $("#btnAlterarConfiguracoes").click(function () {
            dadosModalConfiguracoes($("#textoConfirmacao"));
            $('#modalConfiguracoes').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                   $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                            <div class='ui text loader'>Processando. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {
                        $("#divRetorno").empty();
                        if (resposta.resultado == 0) {
                            location.href = "index.php?entidade=Usuario&acao=MeuPIP";
                        } else if (resposta.resultado == 1) {
                            location.href = "index.php?entidade=Usuario&acao=MeuPIP";
                        }
                    }
                })
                }
            }).modal('show');
        });
        
              
    });
}




function dadosModalConfiguracoes($div) {
    $(document).ready(function () {
            
            $div.html("");
            var estiloEndereco;
            var estiloContato;
            var estiloAnuncios;
            var estiloAtivo;
            
            if($("#chkEndereco").is(":checked")){
                    $("#chkEndereco").val("SIM");
                    estiloEndereco = 'green';
                } else 
                        {$("#chkEndereco").val("NÃO"); estiloEndereco = 'red;';}
                        
            if($("#chkContato").is(":checked")){
                    $("#chkContato").val("SIM");
                    estiloContato = 'green';
                } else 
                        {$("#chkContato").val("NÃO"); estiloContato = 'red;';}            
            
            if($("#chkAnuncios").is(":checked")){
                    $("#chkAnuncios").val("SIM");
                    estiloAnuncios = 'green';
                } else 
                        {$("#chkAnuncios").val("NÃO"); estiloAnuncios = 'red;';} 
            
            if($("#chkStatus").is(":checked")){
                    $("#chkStatus").val("SIM");
                    estiloAtivo = 'green';
                } else 
                        {$("#chkStatus").val("NÃO"); estiloAtivo = 'red;';}
            
            $div.append("<div class='ui horizontal list'>\n\
                                <div class='item'>\n\
                                  <div class='content' style= color:"+estiloEndereco+">\n\
                                    <div class='header'>Exibir Meu Endereço</div>" + $("#chkEndereco").val() + "</div>\n\
                                </div>\n\
                                <div class='item'>\n\
                                  <div class='content' style= color:"+estiloContato+">\n\
                                    <div class='header'>Exibir Meu Contato</div>" + $("#chkContato").val() + "</div>\n\
                                </div>\n\
                                <div class='item'>\n\
                                  <div class='content' style= color:"+estiloAnuncios+">\n\
                                    <div class='header'>Exibir Meus Anúncios</div>" + $("#chkAnuncios").val() + "</div>\n\
                                </div>\n\
                                <div class='item'>\n\
                                  <div class='content' style= color:"+estiloAtivo+">\n\
                                    <div class='header'>Habilitar Minha Página</div>" + $("#chkStatus").val() + "</div>\n\
                                </div>");
            $div.append("</div>");

    });
}
