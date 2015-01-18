function cadastrarUsuario() {
    $(document).ready(function() {
        $("#linhaPF").hide();
        $("#linhaPJ1").hide();
        $("#linhaPJ2").hide();

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