function cadastrarUsuario() {
    $(document).ready(function() {
        /*inicialização da página*/
        $("#linhaPF").hide();
        $("#linhaPJ1").hide();
        $("#linhaPJ2").hide();
        $("#divCEP").hide();
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
                var options = {
            bootstrap3: true,
            minChar: 8,
            errorMessages: {
                password_too_short: "<font color='red'>A senha é muito pequena</font>",
                same_as_username: "<font color='red'>Sua senha não pode ser igual ao seu login</font>"
            },
            verdicts: ["Fraca", "Normal", "Média", "Forte", "Muito Forte"],
            usernameField: "#txtLogin",
            onLoad: function() {
                $('#messages').text('Start typing password');
            },
            onKeyUp: function(evt) {
                $(evt.target).pwstrength("outputErrorList");
            }
        };
        $('#txtSenha').pwstrength(options);
        /*validações*/
        var validationRules = {
            firstName: {
                identifier: 'email',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter an e-mail'
                    },
                    {
                        type: 'email',
                        prompt: 'Please enter a valid e-mail'
                    }
                ]
            }
        };

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover'
                });

        $('.ui.form')
                .form(validationRules, {
                    on: 'blur'
                });

        $('.ui.checkbox').checkbox();

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
}