function cadastrarUsuario() {
    $(document).ready(function() {
        /*inicialização da página*/
        $("#linhaPF").hide();
        $("#linhaPJ1").hide();
        $("#linhaPJ2").hide();
        $("#divCEP").hide();
        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });
        $('.ui.checkbox').checkbox();
        /*eventos e acoes*/
        $("#sltTipoUsuario").change(function() {
            if ($(this).val() == "pj") {
                $("#linhaPF").hide();
                $("#linhaPJ1").show();
                $("#linhaPJ2").show();
            } else {
                $("#linhaPF").show();
                $("#linhaPJ1").hide();
                $("#linhaPJ2").hide();
            }
        })
        $("#btnConfirmar").click(function() {
            if ($("#form").valid()) {
                if (typeof ($("input[name^=hdnTipoTelefone]").val()) == "undefined") {
                    alert("Você deve cadastrar pelo menos um telefone para contato.");
                } else
                if ($("#hdnCEP").val() != "") {
                    //chama modal de confirmacao    
                    carregaDadosModal($("div[class='modal-body']"));
                    $('#myModal').modal('show');
                } else {
                    $("#msgCEP").remove();
                    var msgCEP = $("<div>", {id: "msgCEP"});
                    msgCEP.attr('class', 'alert alert-danger').html("Primeiro faça a busca do CEP").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    $("#alertCEP").append(msgCEP);
                }
            }
        });
        var optSenha = {};
        optSenha.ui = {
            container: "#pwd-container",
            showProgressBar: false,
            errorMessages: {
                wordLength: "<font color='red'>A senha é muito pequena</font>",
                wordSimilarToUsername: "<font color='red'>Sua senha não pode ser igual ao seu login</font>"
            },
            verdicts: ["Fraca", "Normal", "Média", "Forte", "Muito Forte"],
            viewports: {
                verdict: ".pwstrength_viewport_verdict",
                errors: ".pwstrength_viewport_errors"
            },
            showErrors: true,
            showVerdictsInsideProgressBar: true
        };
        optSenha.common = {
            minChar: 8,
            usernameField: "#txtLogin"
        };
        $('#txtSenha').pwstrength(optSenha);
        /*validações*/
        $.validator.setDefaults({
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
        $('#form').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                sltTipoUsuario: {
                    required: true
                },
                txtNome: {
                    required: true
                },
                txtCpf: {
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
                },
                txtCnpj: {
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
                },
                txtCpfResponsavel: {
                    required: true,
                    cpf: 'both'
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
                txtResponsavel: {
                    required: true
                },
                txtEmail: {
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
                txtRazaoSocial: {
                    required: true
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
                }
            },
            messages: {
                txtCpf: {
                    required: "Campo obrigatório",
                    remote: "CPF já utilizado"
                },
                txtCnpj: {
                    required: "Campo obrigatório",
                    remote: "CNPJ já utilizado"
                },
                txtEmail: {
                    remote: "Email já utilizado"
                },
                sltTipoUsuario: {
                    required: "Campo obrigatório"
                },
                txtNome: {
                    required: "Campo obrigatório"
                },
                txtLogin: {
                    required: "Campo obrigatório",
                    minlength: "Login deve possuir no mínimo 2 caracteres",
                    remote: "Login já utilizado"
                },
                txtSenha: {
                    required: "Campo obrigatório",
                    minlength: "Senha deve possuir no mínimo 8 caracteres"
                },
                txtConfirmarSenha: {
                    required: "Campo obrigatório",
                    equalTo: "Por Favor digite o mesmo valor novamente"
                },
                txtRazaoSocial: {
                    required: "Campo obrigatório"
                },
                txtResponsavel: {
                    required: "Campo obrigatório"
                },
                txtCEP: {
                    required: "Campo obrigatório"
                },
                txtCpfResponsavel: {
                    required: "Campo obrigatório"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
}

function mascarasFormUsuario() {
    $(document).ready(function() {
        $("#txtCPF").mask("999.999.999-99");
        $("#txtCNPJ").mask("99.999.999/9999-99");
        $("#txtCEP").mask("99.999-999");
        $("#txtCpfResponsavel").mask("999.999.999-99");
    })
}

function acoesCEP() {
    $(document).ready(function() {
        $("#btnCEP").click(function() {
            buscarCep()
        });
        $("#txtCEP").blur(function() {
            buscarCep()
        });
    })
}

function cancelar() {
    $(document).ready(function() {
        $('#btnCancelar').click(function() {
            $('#modalCancelar').modal({
                closable: false,
                transition: "fade up",
                onDeny: function() {
                    return false;
                },
                onApprove: function() {
                    location.href = "index.php?entidade=Usuario&acao=meuPIP";
                }
            }).modal('show');
        })
    })
}

function confirmar() {
    $(document).ready(function() {
        $('#btnRegistrar').click(function() {
            if ($("#form").valid()) {
                if (typeof ($("input[name^=hdnTipoTelefone]").val()) == "undefined") {
                    alert("Você deve cadastrar pelo menos um telefone para contato.");
                } else
                if ($("#hdnCEP").val() != "") {
                    //chama modal de confirmacao    
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
    $div.html("");
    if ($("#sltTipoUsuario").val() === "pf")
    {
        $div.append("Tipo de Pessoa: " + "Física" + "<br />");
        $div.append("Nome: " + $("#txtNome").val() + "<br />");
        $div.append("CPF: " + $("#txtCpf").val() + "<br />");
        $div.append("Login: " + $("#txtLogin").val() + "<br />");
        $div.append("Email: " + $("#txtEmail").val() + "<br />");
        $div.append("Logradouro: " + $("#txtLogradouro").val() + "<br />");
        $div.append("Numero: " + $("#txtNumero").val() + "<br />");
        $div.append("Complemento: " + $("#txtComplemento").val() + "<br />");
        $div.append("Bairro: " + $("#txtBairro").val() + "<br />");
        $div.append("Cidade: " + $("#txtCidade").val() + "<br />");
        $div.append("Estado: " + $("#txtEstado").val() + "<br />");
        $div.append("CEP: " + $("#txtCEP").val() + "<br />");
    } else {
        $div.append("Tipo de Pessoa: " + "Jurídica" + "<br />");
        $div.append("Nome: " + $("#txtNome").val() + "<br />");
        $div.append("CNPJ: " + $("#txtCnpj").val() + "<br />");
        $div.append("Login: " + $("#txtLogin").val() + "<br />");
        $div.append("Email: " + $("#txtEmail").val() + "<br />");
        $div.append("Responsável: " + $("#txtResponsavel").val() + "<br />");
        $div.append("CPF do Responsável: " + $("#txtCpfResponsavel").val() + "<br />");
        $div.append("Razão Social: " + $("#txtRazaoSocial").val() + "<br />");
        $div.append("Logradouro: " + $("#txtLogradouro").val() + "<br />");
        $div.append("Numero: " + $("#txtNumero").val() + "<br />");
        $div.append("Complemento: " + $("#txtComplemento").val() + "<br />");
        $div.append("Bairro: " + $("#txtBairro").val() + "<br />");
        $div.append("Cidade: " + $("#txtCidade").val() + "<br />");
        $div.append("Estado: " + $("#txtEstado").val() + "<br />");
        $div.append("CEP: " + $("#txtCEP").val() + "<br />");
    }
}
