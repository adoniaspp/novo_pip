function listagemPlano() {
    $(document).ready(function () {
        $("input[name^='spnPlano']").TouchSpin({buttondown_class: "orange", buttonup_class: "orange"}).change(
                function () {
                    $("#txtTotalPreco").val(PrecoTotal());
                    $("#txtTotalQtd").val(QtdTotal());
                });
        $("#btnComprar").click(function () {
            var plano = 0;
            $("input[name^='spnPlano']").each(function () {
                plano += ($(this).val() != "") ? parseInt($(this).val()) : 0;
            });
            if (parseInt(plano) > 0) {
                $("#form").submit();
            } else {
                alert("Escolha pelo menos um plano");
                return false;
            }
        })
    })
}

function PrecoTotal() {
    var somaP = 0;
    $("input[name^='txtPreco']").each(function () {
        var plano = 'spn' + $(this).attr('id');
        somaP += parseFloat($(this).val()) * parseFloat($("input[name='" + plano + "']").val());
    })
    return somaP.toFixed(2);
}

function QtdTotal() {
    var somaQ = 0;
    $("input[name^='spnPlano']").each(function () {
        somaQ += parseInt($(this).val());
    });
    return somaQ;
}