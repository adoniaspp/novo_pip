function isCnpj(cnpj) {
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    if (cnpj.length == 0) {
        return false;
    }

    cnpj = cnpj.replace(/\D+/g, '');
    digitos_iguais = 1;

    for (i = 0; i < cnpj.length - 1; i++)
        if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    if (digitos_iguais)
        return false;

    tamanho = cnpj.length - 2;
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
        return false;
    }
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    return (resultado == digitos.charAt(1));
}

function isCnpjFormatted(cnpj) {
    var validCNPJ = /\d{2,3}.\d{3}.\d{3}\/\d{4}-\d{2}/;
    return cnpj.match(validCNPJ);
}


function isCpf(cpf) {
    exp = /\.|-/g;
    cpf = cpf.toString().replace(exp, "");
    var digitoDigitado = eval(cpf.charAt(9) + cpf.charAt(10));
    var digitoGerado = 0;
    var soma1 = 0, soma2 = 0;
    var vlr = 11;

    for (i = 0; i < 9; i++) {
        soma1 += eval(cpf.charAt(i) * (vlr - 1));
        soma2 += eval(cpf.charAt(i) * vlr);
        vlr--;
    }

    soma1 = (soma1 % 11) < 2 ? 0 : 11 - (soma1 % 11);
    aux = soma1 * 2;
    soma2 = soma2 + aux;
    soma2 = (soma2 % 11) < 2 ? 0 : 11 - (soma2 % 11);

    if (cpf == "11111111111" || cpf == "22222222222" || cpf ==
            "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf ==
            "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf ==
            "99999999999" || cpf == "00000000000") {
        digitoGerado = null;
    } else {
        digitoGerado = eval(soma1.toString().charAt(0) + soma2.toString().charAt(0));
    }

    if (digitoGerado != digitoDigitado) {
        return false;
    }
    return true;
}
function isCpfFormatted(cpf) {
    var validCPF = /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/;
    return cpf.match(validCPF);
}

function gerarNumerosIntervalos(inicial, final, array) {
    inicial = parseInt(inicial);
    final = parseInt(final);
    for ($i = inicial; $i <= final; $i++) {
        array.push($i);
    }
    return array;
}

(function ($) {
    $.validator.addMethod("cpf", function (value, element, type) {
        if (value == "")
            return true;

        if ((type == 'format' || type == 'both') && !isCpfFormatted(value))
            return false;
        else
            return ((type == 'valid' || type == 'both')) ? isCpf(value) : true;

    }, function (type, element) {
        return (type == 'format' || (type == 'both' && !isCpfFormatted($(element).val()))) ?
                'Formato do CPF não é válido' : 'Digite um CPF válido';
    });
    $.validator.addMethod("cnpj", function (value, element, type) {
        if (value == "")
            return true;

        if ((type == 'format' || type == 'both') && !isCnpjFormatted(value))
            return false;
        else
            return ((type == 'valid' || type == 'both')) ? isCnpj(value) : true;

    }, function (type, element) {
        return (type == 'format' || (type == 'both' && !isCnpjFormatted($(element).val()))) ?
                'Formato do CNPJ não é válido' : 'Digite um CNPJ válido';
    });
    $.validator.addMethod("validaAndar", function (value, element, ordemPlanta) {
        if (value == "") {
            return true;
        }
        //pegar a tabela de plantas
        var tbody = "#dadosPlanta_" + ordemPlanta;
        var linhas = $(tbody).children();
        //se nao tem andares adicionados tudo ok, caso tenha inicia validacao a saber se ja tem algum andar adicionado
        if (linhas.length === 0) {
            return true;
        } else {
            //##VERIFICA SE O ELEMENTO VALIDADO ESTA CONTIDO NAS LINHAS QUE JA EXISTEM
            //cria array auxiliar
            var arrayIntervaloContido = [];
            //para cada linha da tabela alimenta o array, para cada elemento os numeros do intervalo correspondente
            $(linhas).each(function () {
                var inputs;
                inputs = $(this).find("input");
                var andarInicial = inputs[0];
                var andarFinal = inputs[1];
                //gera numeros do intervalo
                arrayIntervaloContido = gerarNumerosIntervalos($(andarInicial).val(), $(andarFinal).val(), arrayIntervaloContido);
            })
            //metodo para remover elementos duplicados do array
            Array.prototype.duplicates = function () {
                return this.filter(function (x, y, k) {
                    return y === k.lastIndexOf(x);
                });
            }
            //remove elementos duplicados
            var andaresAdicionados = arrayIntervaloContido.duplicates();
            //verifica se o valor do elemento validado (andar) estiver contido nos elementos ja adicionados 
            if (andaresAdicionados.indexOf(parseInt(value)) >= 0) {
                return false;
            }

            //##VERIFICA SE O ELEMENTO VALIDADO CONTEM AS LINHAS QUE JA EXISTEM
            //busca o elemento pai com todos os inputs com base o elemento atual
            var elementoPai = $(element).parent().parent().parent();
            //carrega os inputs
            var inputs = $(elementoPai).find("input");
            //cria array auxiliar
            var arrayIntervaloContem = [];
            //gera numeros do intervalo
            arrayIntervaloContem = gerarNumerosIntervalos($(inputs[0]).val(), $(inputs[1]).val(), arrayIntervaloContem);
            //verifica se o intervalo dos elementos validados contem algum andar ja adicionado
            for (i = 0; i < (andaresAdicionados.length); i++) {
                if (arrayIntervaloContem.indexOf(parseInt(andaresAdicionados[i])) >= 0) {
                    return false;
                }
            }
            return true;

        }
    }, function (type, element) {
        return 'Não é permitido adicionar o mesmo andar';
    });
})(jQuery);