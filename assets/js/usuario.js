function cadastrarUsuario() {
    $(document).ready(function() {
        /*inicialização da página*/
        $("#linhaPF").hide();
        $("#linhaPJ1").hide();
        $("#linhaPJ2").hide();
        $("#divCEP").hide();
        $("#tabelaTelefone").hide();
        $('.ui.dropdown')
                .dropdown({
            on: 'hover'
        });
        $('.ui.checkbox').checkbox();
        /*eventos e acoes*/
        $("#sltTipoUsuario").change(function() {
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
        $.validator.addMethod('filesize', function(value, element, param) {
            // param = size (en bytes) 
            // element = element to validate (<input>)
            // value = value of the element (file name)
            return this.optional(element) || (element.files[0].size <= param)
        });
        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function(element, errorClass, validClass) {
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
                txtSenha: {
                    required: true,
                    minlength: 8
                },
                txtConfirmarSenha: {
                    required: true,
                    equalTo: "#txtSenha"
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
                txtCpf: {
                    remote: "CPF já utilizado"
                },
                txtCnpj: {
                    remote: "CNPJ já utilizado"
                },
                txtEmail: {
                    remote: "Email já utilizado",
                    email: "Informe um email válido"
                },
                txtLogin: {
                    minlength: "Login deve possuir no mínimo 2 caracteres",
                    remote: "Login já utilizado"
                },
                txtSenha: {
                    minlength: "Senha deve possuir no mínimo 8 caracteres"
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
                }
            },
            submitHandler: function(form) {
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
    $(document).ready(function() {
        element.parent().parent().remove();
        if ($("input[name='hdnTelefone[]'").length === 0)
            $("#tabelaTelefone").hide();
    })
}

function mascarasFormUsuario() {
    $(document).ready(function() {
        $("#txtCPF").mask('000.000.000-00', {reverse: false});
        $("#txtCNPJ").mask("00.000.000/0000-00");
        $("#txtCEP").mask("00.000-000");
        $("#txtCPFResponsavel").mask('000.000.000-00', {reverse: false});
        $("#txtTel").mask('(00) 0000-0000');
    })
}

function acoesCEP() {
    $(document).ready(function() {
        $("#btnCEP").click(function() {
            buscarCep();
        });
        $("#txtCEP").blur(function() {
            buscarCep();
        });
    })
}

function cancelar(URL) {
    $(document).ready(function() {
        $('#btnCancelar').click(function() {
            $('#modalCancelar').modal({
                closable: false,
                transition: "fade up",
                onDeny: function() {
                    return false;
                },
                onApprove: function() {
                    if (URL === "inicio")
                        location.href = "index.php";
                    if (URL === "meuPIP")
                        location.href = "index.php?entidade=Usuario&acao=meuPIP";
                }
            }).modal('show');
        })
    })
}

function confirmar() {
    $(document).ready(function() {
        $('#btnRegistrar').click(function() {
            validarTelefone();
            if ($("#form").valid()) {
                if (typeof ($("input[name^=hdnTipoTelefone]").val()) == "undefined") {
                    $('#modalTelefone').modal({
                        closable: false,
                        transition: "fade up",
                    }).modal('show');
                } else
                if ($("#hdnCEP").val() != "") {
                    carregaDadosModal($("#textoConfirmacao"));
                    $('#modalConfirmar').modal({
                        closable: false,
                        transition: "fade up",
                        onDeny: function() {
                            return false;
                        },
                        onApprove: function() {
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
    $(document).ready(function() {
        $div.html("");
        if ($("#sltTipoUsuario").val() === "pf")
        {
            $div.append("Tipo de Pessoa: " + "Física" + "<br />");
            $div.append("Nome: " + $("#txtNome").val() + "<br />");
            if (jQuery.type($("#txtCPF").val()) !== "undefined") {
                $div.append("CPF: " + $("#txtCPF").val() + "<br />");
            }
        } else {
            $div.append("Tipo de Pessoa: " + "Jurídica" + "<br />");
            $div.append("Empresa: " + $("#txtNomeEmpresa").val() + "<br />");
            if (jQuery.type($("#txtCNPJ").val()) !== "undefined") {
                $div.append("CNPJ: " + $("#txtCNPJ").val() + "<br />");
            }
            $div.append("Responsável: " + $("#txtResponsavel").val() + "<br />");
            $div.append("CPF do Responsável: " + $("#txtCPFResponsavel").val() + "<br />");
            $div.append("Razão Social: " + $("#txtRazaoSocial").val() + "<br />");
        }
        if (jQuery.type($("#txtLogin").val()) !== "undefined") {
            $div.append("Login: " + $("#txtLogin").val() + "<br />");
        }
        $div.append("Email: " + $("#txtEmail").val() + "<br />");
        $div.append("Logradouro: " + $("#txtLogradouro").val() + "<br />");
        $div.append("Número: " + $("#txtNumero").val() + "<br />");
        $div.append("Complemento: " + $("#txtComplemento").val() + "<br />");
        $div.append("Bairro: " + $("#txtBairro").val() + "<br />");
        $div.append("Cidade: " + $("#txtCidade").val() + "<br />");
        $div.append("Estado: " + $("#txtEstado").val() + "<br />");
        $div.append("CEP: " + $("#txtCEP").val() + "<br />");
    })
}

function buscarCep() {
    var validator = $("#form").validate();
    if (validator.element("#txtCEP")) {
        $.ajax({
            url: "index.php",
            dataType: "json",
            type: "POST",
            data: {
                cep: $('#txtCEP').val(),
                hdnEntidade: "Endereco",
                hdnAcao: "buscarCEP"
            },
            beforeSend: function() {
                $("#msgCEP").html('');
                $("#divCEP").hide(); //oculta campos do DIVCEP
                $("#msgCEP").append(criarAlerta("orange", "...aguarde buscando CEP..."));
                $('#txtCEP').attr('disabled', 'disabled');
                $('#btnCEP').attr('disabled', 'disabled');
                $('#txtEstado').val('');
                $('#txtCidade').val('');
                $('#txtBairro').val('');
                $('#txtLogradouro').val('');
                $('#hdnCEP').val('');
            },
            success: function(resposta) {
                $("#msgCEP").html('');
                if (resposta.resultado == 0) {
                    $("#msgCEP").append(criarAlerta("red", "N&atilde;o localizamos o CEP informado"));
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

function criarAlerta(tipo, mensagem) {
    var divAlerta = $("<div>", {class: "ui " + tipo + " message"});
    divAlerta.append($("<div>", {class: "content"}).html('<div class="header">' + mensagem + '</div>'));
    return divAlerta;
}

$(document).ready(function() {
    var fileExtentionRange = '.jpg .jpeg .png .gif';
    var MAX_SIZE = 30; // MB

    $(document).on('change', '.btn-file :file', function() {
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

    $('.btn-file :file').on('fileselect', function(event, numFiles, label, size) {
        $('#arquivo').attr('name', 'arquivo'); // allow upload.
        var postfix = label.substr(label.lastIndexOf('.'));
        if (fileExtentionRange.indexOf(postfix.toLowerCase()) > -1) {
            if (size > 1024 * 1024 * MAX_SIZE) {
                alert('Tamanho máximo da imagem：<strong>' + MAX_SIZE + '</strong> MB.');
                $('#arquivo').removeAttr('name'); // cancel upload file.
            } else {
                $('#arquivolabel').val(label);
            }
        } else {
            alert('Tipo de arquivo inválido：<br/> <strong>' + fileExtentionRange + '</strong>');
            $('#arquivo').removeAttr('name'); // cancel upload file.
        }
    });
});

function alterarSenha() {
    $(document).ready(function() {
        $("#btnAlterarSenha").click(function() {
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
            errorPlacement: function(error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function(element, errorClass, validClass) {
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
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
}

function trocarImagem() {
    $(document).ready(function() {
        $("#btnAlterarImagem").click(function() {
            if ($("#form").valid()) {
                $("#form").submit();
            }
        });
        $("#btnExcluirImagem").click(function() {
            $('#modalExcluir').modal({
                closable: false,
                transition: "fade up",
                onDeny: function() {
                    return false;
                },
                onApprove: function() {
                    $("#hdnExcluir").val(1);
                    $("#arquivolabel").rules("remove");
                    $("#form").submit();
                }
            }).modal('show');
        });
        $.validator.addMethod('filesize', function(value, element, param) {
            // param = size (en bytes) 
            // element = element to validate (<input>)
            // value = value of the element (file name)
            return this.optional(element) || (element.files[0].size <= param)
        });
        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function(element, errorClass, validClass) {
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
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
}

function esqueciSenha() {
    $(document).ready(function() {
        $("#btnEnviar").click(function() {
            if ($("#form").valid()) {
                $("#form").submit();
            }
        });
        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function(element, errorClass, validClass) {
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
            submitHandler: function(form) {
                form.submit();
            }
        });


    });
}

function alterarUsuario() {
    $(document).ready(function() {
        /*validações*/
        $.validator.setDefaults({
            ignore: [],
            errorClass: 'errorField',
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass("ui red pointing above ui label error").appendTo(element.closest('div.field'));
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest("div.field").addClass("error").removeClass("success");
            },
            unhighlight: function(element, errorClass, validClass) {
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
            submitHandler: function(form) {
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
    $(document).ready(function() {
        $("#btnAdicionarTelefone").click(function() {
            $("#txtTel").rules("add", {
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
            $("#sltTipotelefone").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            if (validarTelefone()) {
                $("#dadosTelefone").append(
                        "<tr><td> <input type=hidden id=hdnTipoTelefone[] name=hdnTipoTelefone[] value=" + $("#sltTipotelefone").val() + ">" + $("#sltTipotelefone").val() + "</td>" +
                        "<td> <input type=hidden id=hdnOperadora[] name=hdnOperadora[] value=" + $("#sltOperadora").val() + ">" + $("#sltOperadora").val() + "</td>" +
                        "<td> <input type=hidden id=hdnTelefone[] name=hdnTelefone[] value=" + $("#txtTel").val() + ">" + $("#txtTel").val() + "</td>" +
                        "<td class='collapsing'><div class='red ui icon button' onclick='excluirTelefone($(this))'><i class='trash icon'></i>Excluir</div></td></tr>");
                $("#txtTel").val("");
                $("#tabelaTelefone").show();
            }
            $("#txtTel").rules("remove");
            $("#sltOperadora").rules("remove");
            $("#sltTipotelefone").rules("remove");
        });
        $("#sltTipotelefone").change(function() {
            $("#txtTel").unmask();
            if ($(this).val() == "Fixo") {
                $("#txtTel").mask('(00) 0000-0000');
            } else {
                $("#txtTel").mask('(00) 00000-0000');
            }
        })
    })
}