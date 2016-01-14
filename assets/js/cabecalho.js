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
                        location.href = 'index.php';
                    }
                }
            })
        })
    })
}

function timeoutSessao() {
    $.timeoutDialog({
        timeout: 540,//9MINUTOS
        countdown: 60,
        div_modal_alerta: "modalAlertaSessao",
        div_modal_logout: "modalAlertaLogout",
        title: "Sua sessão está prestes a expirar!",
        message: "Você será desconectado em {0} segundos.",
        question: "Você deseja ficar conectado?",
        keep_alive_button_text: "Sim, Mantenha - me conectado",
        sign_out_button_text: "Não, desejo sair",
        keep_alive_url: "index.php",
        logout_url: "index.php",
        logout_redirect_url: "index.php?entidade=Usuario&acao=form&tipo=login",
        restart_on_yes: true,
        dialog_width: 300
    });
}