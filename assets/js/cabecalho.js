function exibirMeuPIP(valor, nome) {
    $(document).ready(function () {
        $.timeoutDialog({
            timeout: 20,
            countdown: 10,
            title: "Sua sessão está prestes a expirar!",
            message: "Você será desconectado em {0} segundos.",
            question: "Você deseja ficar conectado?",
            keep_alive_button_text: "Sim, Mantenha - me conectado",
            sign_out_button_text: "Não, desejo sair",
            keep_alive_url: "teste.php",
            logout_url: null,
            logout_redirect_url: "index.php",
            restart_on_yes: true,
            dialog_width: 300
        });

        if (valor == "SIM") {
            $("#loginCadastro").hide();
            $("#divUsuario").show();
            $("#divNome").html("<font color='black'><h4>Seja bem vindo, " + nome + " <h4></font>");
        } else {
            $("#divUsuario").hide();
            $("#loginCadastro").show();
        }
    })
}

function logout() {
    $(document).ready(function () {
        $("#btnLogout").click(function () {
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
                        //$('#divForm').show();
                        location.href = 'index.php'
                    }
                }
            })
        })
    })
}