function esconderMeuPIP() {
    $(document).ready(function () {
        $("#divUsuario").hide();
    });
}

function digitarLoginSenha(){
    $(document).keypress(function(e) {
                    if (e.which == 13) {
                        if ($('#txtLoginIndex').val().length > 0 && $('#txtSenhaIndex').val().length > 0) {
                            autenticarUsuario();
                        }
                    }
    });
}

function autenticarUsuario() {
    if ($('#txtLoginIndex').val().length < 2 | $('#txtSenhaIndex').val().length < 8) {
        $("#divTitulo").html("<span class='ui small red message'>Usuário e/ou Senha Inválidos</span>");
    } else {

        $.ajax({
            url: "index.php",
            dataType: "json",
            type: "POST",
            data: {
                txtLogin: $('#txtLoginIndex').val(),
                txtSenha: $('#txtSenhaIndex').val(),
                hdnEntidade: "Usuario",
                hdnAcao: "autenticar"
            },
            success: function (resposta) {
                if (resposta.resultado == 1) {
                    var nome = resposta.nome;
                    $('#divForm').hide();
                    $("#divUsuario").fadeIn('slow');
                    $("#divUsuario").attr('class', 'text');
                    $("#divNome").html("<h4>Seja bem vindo " + resposta.nome + "  <h4>");
                    location.href = resposta.redirecionamento;
                }
                if (resposta.resultado == 2) {
                    $("#divTitulo").html("<font color='red'>Usuário ou/e Senha Inválidos</font>");
                }
                if (resposta.resultado == 3) {
                    $("#divTitulo").attr('class', 'text text-danger').html("<font color='red'>Ops... lamentamos o ocorrido..</font>").show();
                }
            }
        })
    }
}

function exibirMeuPIP(){
    $("#divForm").hide();
    $("#divUsuario").show();
    $("#divUsuario").attr('class', 'text');
}

function logoutUsuario() {
    $.ajax({
        url: "index.php",
        dataType: "json",
        type: "POST",
        data: {
            hdnEntidade: "Usuario",
            hdnAcao: "logout"
        },
        success: function (resposta) {
            if (resposta.resultado == 1) {
                $("#divUsuario").hide();
                $('#divForm').show();
                location.href = 'index.php'
            }
        }
    })
}


