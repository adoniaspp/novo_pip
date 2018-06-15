var bairros = [
    {cidade: '1', bairro: 'Água Boa'},
    {cidade: '1', bairro: 'Águas Negras'},
    {cidade: '1', bairro: 'Aeroporto'},
    {cidade: '1', bairro: 'Águas Lindas'},
    {cidade: '2', bairro: '40 horas'},
    {cidade: '2', bairro: 'Águas Brancas'},
    {cidade: '2', bairro: 'Atalaia'},
    {cidade: '2', bairro: 'Aurá'},
    {cidade: '3', bairro: 'Uriboca'},
    {cidade: '3', bairro: 'Centro'},
    {cidade: '3', bairro: 'Pedreirinha'},
    {cidade: '3', bairro: 'São José'},
]

function buscarAnuncio() {
    $(document).ready(function () {

        var deviceAgent = navigator.userAgent.toLowerCase();
        var agentID = deviceAgent.match(/(iphone|ipod|ipad|android|blackberry)/);

        if (agentID) {
            var mobile = 'true';
        }

        $("#divCaracteristicas").hide();
        $("#divValor").hide();

        $("input[name=sltCidade]").change(function () {
            var cidade = $(this).val();
            //var options = '';
            //$(bairros).each(function (index, value) {       
            
             if (cidade === '') {
                $("#dropBairro").html(
                '<div class="ui fluid multiple search selection dropdown">' +
                    '<input type="hidden" name="filtroBairro[]" id="filtroBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '</div>' +
                '</div>'
                );
            }
            
            if (cidade === '1') {
                $("#dropBairro").html(
                '<div class="ui fluid multiple search selection dropdown">' +
                    '<input type="hidden" name="filtroBairro[]" id="filtroBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="3"> Aeroporto </div>' +
                    '<div class="item" data-value="1"> Água Boa </div>' +
                    '<div class="item" data-value="7"> Águas Lindas </div>' +
                    '<div class="item" data-value="2"> Águas Negras </div>' +
                    '<div class="item" data-value="9"> Agulha </div>' +
                    '<div class="item" data-value="10"> Ariramba </div>' +
                    '<div class="item" data-value="11"> Atalaia </div>' +
                    '<div class="item" data-value="12"> Aurá </div>' +
                    '<div class="item" data-value="13"> Baía do Sol </div>' +
                    '<div class="item" data-value="14"> Barreiro </div>' +
                    '<div class="item" data-value="15"> Batista Campos </div>' +
                    '<div class="item" data-value="16"> Bengui </div>' +
                    '<div class="item" data-value="17"> Bonfim </div>' +
                    '<div class="item" data-value="18"> Brasília </div>' +
                    '<div class="item" data-value="19"> Cabanagem </div>' +
                    '<div class="item" data-value="20"> Campina </div>' +
                    '<div class="item" data-value="21"> Campina de Icoaraci </div>' +
                    '<div class="item" data-value="22"> Canudos </div>' +
                    '<div class="item" data-value="23"> Carananduba </div>' +
                    '<div class="item" data-value="24"> Caruara </div>' +
                    '<div class="item" data-value="25"> Castanheira </div>' +
                    '<div class="item" data-value="26"> Chapéu Virado </div>' +
                    '<div class="item" data-value="27"> Cidade Velha </div>' +
                    '<div class="item" data-value="29"> Coqueiro </div>' +
                    '<div class="item" data-value="30"> Cremação </div>' +
                    '<div class="item" data-value="31"> Cruzeiro </div>' +
                    '<div class="item" data-value="32"> Curió-Utinga </div>' +
                    '<div class="item" data-value="33"> Farol </div>' +
                    '<div class="item" data-value="34"> Fátima </div>' +
                    '<div class="item" data-value="35"> Guamá </div>' +
                    '<div class="item" data-value="36"> Guanabara </div>' +
                    '<div class="item" data-value="37"> Itaiteua </div>' +
                    '<div class="item" data-value="38"> Jurunas </div>' +
                    '<div class="item" data-value="39"> Mangueirão </div>' +
                    '<div class="item" data-value="40"> Mangueiras </div>' +
                    '<div class="item" data-value="41"> Maracacuera </div>' +
                    '<div class="item" data-value="42"> Maracajá </div>' +
                    '<div class="item" data-value="43"> Maracangalha </div>' +
                    '<div class="item" data-value="44"> Marahu </div>' +
                    '<div class="item" data-value="45"> Marambaia </div>' +
                    '<div class="item" data-value="46"> Marco </div>' +
                    '<div class="item" data-value="47"> Miramar </div>' +
                    '<div class="item" data-value="48"> Murubira </div>' +
                    '<div class="item" data-value="49"> Natal do Murubira </div>' +
                    '<div class="item" data-value="50"> Nazaré </div>' +
                    '<div class="item" data-value="51"> Outros </div>' +
                    '<div class="item" data-value="52"> Paracuri </div>' +
                    '<div class="item" data-value="53"> Paraíso </div>' +
                    '<div class="item" data-value="54"> Parque Guajará </div>' +
                    '<div class="item" data-value="55"> Parque Verde </div>' +
                    '<div class="item" data-value="56"> Pedreira </div>' +
                    '<div class="item" data-value="57"> Ponta Grossa </div>' +
                    '<div class="item" data-value="58"> Porto Arthur  </div>' +
                    '<div class="item" data-value="59"> Praia Grande  </div>' +
                    '<div class="item" data-value="60"> Pratinha  </div>' +
                    '<div class="item" data-value="61"> Reduto  </div>' +
                    '<div class="item" data-value="62"> Sacramenta  </div>' +
                    '<div class="item" data-value="63"> São Brás  </div>' +
                    '<div class="item" data-value="64"> São Clemente  </div>' +
                    '<div class="item" data-value="65"> São Francisco  </div>' +
                    '<div class="item" data-value="66"> São João do Outeiro  </div>' +
                    '<div class="item" data-value="67"> Souza  </div>' +
                    '<div class="item" data-value="68"> Sucurijuquara  </div>' +
                    '<div class="item" data-value="69"> Tapanã  </div>' +
                    '<div class="item" data-value="70"> Telégrafo Sem Fio  </div>' +
                    '<div class="item" data-value="71"> Tenoné  </div>' +
                    '<div class="item" data-value="72"> Terra Firme  </div>' +
                    '<div class="item" data-value="73"> Umarizal  </div>' +
                    '<div class="item" data-value="74"> Una  </div>' +
                    '<div class="item" data-value="75"> Universitário  </div>' +
                    '<div class="item" data-value="76"> Val-de-Cães  </div>' +
                    '<div class="item" data-value="77"> Vila  </div>' +
                    '</div>' +
                '</div>'
                );
            }
            if (cidade === '2') {
                $("#dropBairro").html(
                '<div class="ui fluid multiple search selection dropdown">' +
                    '<input type="hidden" name="filtroBairro[]" id="filtroBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="78"> 40 horas </div>' +
                    '<div class="item" data-value="79"> Águas Brancas </div>' +
                    '<div class="item" data-value="81"> Atalaia </div>' +
                    '<div class="item" data-value="82"> Aurá </div>' +
                    '<div class="item" data-value="83"> Cajuí </div>' +
                    '<div class="item" data-value="84"> Centro </div>' +
                    '<div class="item" data-value="85"> Cidade Nova </div>' +
                    '<div class="item" data-value="86"> Coqueiro </div>' +
                    '<div class="item" data-value="87"> Curuçambá </div>' +
                    '<div class="item" data-value="88"> Distrito Industrial </div>' +
                    '<div class="item" data-value="89"> Dom Bosco </div>' +
                    '<div class="item" data-value="90"> Dona Ana </div>' +
                    '<div class="item" data-value="91"> Guajará </div>' +
                    '<div class="item" data-value="92"> Guanabara </div>' +
                    '<div class="item" data-value="93"> Heliolândia </div>' +
                    '<div class="item" data-value="94"> Icuí </div>' +
                    '<div class="item" data-value="95"> Jaderlândia </div>' +
                    '<div class="item" data-value="96"> Jibóia Branca </div>' +
                    '<div class="item" data-value="97"> Júlia Seffer </div>' +
                    '<div class="item" data-value="98"> Laranjeira </div>' +
                    '<div class="item" data-value="99"> Maguari </div>' +
                    '<div class="item" data-value="100"> Paar </div>' +
                    '<div class="item" data-value="101"> Providência </div>' +
                    '<div class="item" data-value="102"> Samambaia </div>' +
                    '<div class="item" data-value="103"> Santana do Aurá </div>' +                    
                    '</div>' +
                '</div>'
                );
            }
            
            if (cidade === '3') {
                $("#dropBairro").html(
                '<div class="ui fluid multiple search selection dropdown">' +
                    '<input type="hidden" name="filtroBairro[]" id="filtroBairro">' +
                    '<span class="default text">Bairro</span>' +
                    '<i class="dropdown icon"></i>' +
                    '<div class="menu" id="sltBairro">' +
                    '<div class="item" data-value="115"> Almir Gabriel </div>' +
                    '<div class="item" data-value="114"> Beira Rio </div>' +
                    '<div class="item" data-value="116"> Bela Vista </div>' +
                    '<div class="item" data-value="106"> Centro </div>' +
                    '<div class="item" data-value="113"> Decouville </div>' +
                    '<div class="item" data-value="109"> Dom Aristides </div>' +
                    '<div class="item" data-value="112"> Nossa Senhora da Paz </div>' +
                    '<div class="item" data-value="107"> Pedreirinha </div>' +
                    '<div class="item" data-value="117"> Riacho Doce </div>' +
                    '<div class="item" data-value="110"> São Francisco </div>' +
                    '<div class="item" data-value="104"> São João </div>' +
                    '<div class="item" data-value="108"> São José </div>' +
                    '<div class="item" data-value="111"> União </div>' +
                    '<div class="item" data-value="105"> Uriboca </div>' +
                    '</div>' +
                '</div>'
                );
            }
            
            $('.ui.dropdown')
                .dropdown({
                    on: 'hover',
                    message: {
                        noResults: 'Nenhum resultado.'
                    }
                });

//            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidade').val(),
//                    function (resposta) {
//                        $("#sltBairro").html(resposta);
//                    }
//            );
        });

        $("input[name=sltCidadeAvancado]").change(function () {
            $("#sltBairro").dropdown('clear');
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidadeAvancado').val(),
                    function (resposta) {
                        $("#sltBairroAvancado").html(resposta);
                    }
            );
        });

        $("#porCorretor").click(function () {
            $.post('index.php?hdnEntidade=Usuario&hdnAcao=exibirListaUsuario&usuarios=' + $("#sltCorretorAvancado").val(),
                    function (resposta) {
                        $("#sltCorretor").html(resposta);
                    }
            );
        });

        $("#spanValor").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })

        $('.ui.dropdown')
                .dropdown({
                    on: 'hover',
                    message: {
                        noResults: 'Nenhum resultado.'
                    }
                });
        $('.ui.checkbox')
                .checkbox();

        $('.special.cards .image').dimmer({
            on: 'hover'
        });

        /*Criar uma view especifica para tela inicial*/
        $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
            tipoImovel: 'todos',
            valor: '',
            finalidade: '',
            cidade: '',
            bairro: '',
            quarto: '',
            banheiro: '',
            suite: '',
            condicao: '',
            unidadesandar: '',
            area: '',
            paginaInicial: 'true',
            mobile: mobile,
            linha: $('#paginaLinha').val(),
            id: $('#hdUsuario').val(),
            garagem: 'false',
            page: 'index'});

        $("#btnBuscarAnuncioBasico").on('click', function () {
            $("#divOrdenacao").show(); //mostrar a ordenação, caso esteja oculta quando a buscar não retornar nada

            $("#load").addClass('ui active inverted dimmer');
            if ($('#sltTipoImovel').val() == "") {
                tipoimovel = "todos"
            } else {
                tipoimovel = $('#sltTipoImovel').val()
            }
            var deviceAgent = navigator.userAgent.toLowerCase();
            var agentID = deviceAgent.match(/(iphone|ipod|ipad|android|blackberry)/);
            if (agentID) {
                var mobile = 'true';
            }
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: tipoimovel,
                valor: $('#sltValor').val(),
                finalidade: $('#sltFinalidade').val(),
                idcidade: $('#sltCidade').val(),
                idbairro: $('#filtroBairro').val(),
                quarto: $('#sltQuartos').val(),
                banheiro: $('#sltBanheiros').val(),
                suite: $('#sltSuites').val(),
                condicao: $('#sltCondicao').val(),
                unidadesandar: $('#sltUnidadesAndar').val(),
                areaMin: $('#sltAreaMin').val(),
                areaMax: $('#sltAreaMax').val(),
                paginaInicial: 'true',
                mobile: mobile,
                linha: $('#paginaLinha').val(),
                id: $('#hdUsuario').val(),
                diferencial: $('#carregarDiferenciais').val(),
                //           },
                //               garagem: $('#checkgaragem').parent().checkbox('is checked') 
            });
        });

        $("#btnBuscarAnuncioAvancado").on('click', function () {

            $("#load").addClass('ui active inverted dimmer');
            if ($('#sltTipoImovelAvancado').val() == "") {
                tipoimovel = "todos"
            } else {
                tipoimovel = $('#sltTipoImovelAvancado').val()
            }
            ;
            var deviceAgent = navigator.userAgent.toLowerCase();
            var agentID = deviceAgent.match(/(iphone|ipod|ipad|android|blackberry)/);
            if (agentID) {
                var mobile = 'true';
            }
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: tipoimovel,
                valor: $('#sltValor').val(),
                finalidade: $('#sltFinalidadeAvancado').val(),
                idcidade: $('#sltCidadeAvancado').val(),
                idbairro: $('#sltBairroAvancado').val(),
                quarto: $('#sltQuartos').val(),
                banheiro: $('#sltBanheiros').val(),
                suite: $('#sltSuites').val(),
                condicao: $('#sltCondicaoAvancado').val(),
                unidadesandar: $('#sltUnidadesAndar').val(),
                area: $('#sltArea').val(),
                paginaInicial: 'true',
                mobile: mobile,
                linha: $('#paginaLinha').val(),
                id: $('#hdUsuario').val(),
                diferencial: $('#carregarDiferenciais').val(),
                garagem: $('#sltGaragem').val()
                        //},
//                    function () {
//                        $("#load").addClass('ui active inverted dimmer');
//                    });
//            setTimeout(function () {
//                $('#load').removeClass("ui active inverted dimmer");
//            }, 1000);
            });
        });

        $("#btnBuscarAnuncioCorretor").on('click', function () {

            var deviceAgent = navigator.userAgent.toLowerCase();
            var agentID = deviceAgent.match(/(iphone|ipod|ipad|android|blackberry)/);
            if (agentID) {
                var mobile = 'true';
            }

            $("#load").addClass('ui active inverted dimmer');

            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: 'todos',
                valor: '',
                finalidade: '',
                cidade: '',
                bairro: '',
                quarto: '',
                banheiro: '',
                suite: '',
                condicao: '',
                unidadesandar: '',
                area: '',
                paginaInicial: 'true',
                mobile: mobile,
                linha: $('#paginaLinha').val(),
                id: $('#sltCorretorAvancado').val(),
                garagem: 'false',
                page: 'index'
            });
        });

    });
}

function carregarAnuncio() { //valor = quantidade de anuncios

    $(document).ready(function () {

        var deviceAgent = navigator.userAgent.toLowerCase();
        var agentID = deviceAgent.match(/(iphone|ipod|ipad|android|blackberry)/);

        if (agentID) {
            $('.ui.dropdown')
                    .dropdown()
                    ;
            $("#paginador").remove();
            $("#divOrdenacao").removeClass("right");
            $("#divOrdenacao").addClass("center");
            $("#divMenuOrdPag").removeClass("two");
            $("#divMenuOrdPag").addClass("one");

            $("div[id^='spanValor']").priceFormat({
                prefix: 'R$ ',
                centsSeparator: ',',
                centsLimit: 0,
                limit: 8,
                thousandsSeparator: '.'
            })

            ordenarAnuncio();
            exibirEnviarComparar();
            $('#carregarMais').click(function () {
                var linha = Number($('#paginaLinha').val());
                var total = Number($('#hdnTotalAnuncios').val());
                var itensPorLinha = 4;
                linha = linha + itensPorLinha;
//                if (linha <= total) {
                $("#paginaLinha").val(linha);
                $.ajax({
                    url: 'index.php',
                    type: 'post',
                    data: {
                        tipoImovel: 'todos',
                        valor: '',
                        finalidade: '',
                        cidade: '',
                        bairro: '',
                        quarto: '',
                        banheiro: '',
                        suite: '',
                        condicao: '',
                        unidadesandar: '',
                        area: '',
                        linha: linha,
                        paginaInicial: 'false',
                        mobile: 'true',
                        hdnEntidade: 'Anuncio',
                        hdnAcao: 'buscarAnuncio',
                        garagem: 'false',
                        page: 'index'
                    },
                    beforeSend: function () {
                        $("#carregarMais").addClass("disabled loading");
                    },
                    success: function (response) {
                        setTimeout(function () {
                            $(".list-item:last").after(response).show().fadeIn("slow");
                            exibirEnviarComparar();
                            $("div[id^='spanValor']").priceFormat({
                                prefix: 'R$ ',
                                centsSeparator: ',',
                                centsLimit: 0,
                                limit: 8,
                                thousandsSeparator: '.'
                            })

                            var linhanumero = linha + itensPorLinha;
                            if (linhanumero > total) {
                                $("#carregarMais").addClass("disabled");
                            } else {
                                $("#carregarMais").removeClass("disabled loading");
                            }
                        }, 2000);
                    }
                });

//                } else {
//                    $("#carregarMais").addClass("disabled loading");
//                    setTimeout(function () {
//                        $('.list-item:nth-child(4)').nextAll('.list-item').remove();
//                        $("#linha").val(0);
//                        $('.load-more').text("Load more");
//                        $('.load-more').css("background", "#15a9ce");
//                    }, 2000);
//                }
            });
        } else {
            $("#carregarMais").hide();
            $('.ui.dropdown')
                    .dropdown()
                    ;
            paginarAnuncio();
            ordenarAnuncio();

            exibirEnviarComparar();

            $("div[id^='spanValor']").priceFormat({
                prefix: 'R$ ',
                centsSeparator: ',',
                centsLimit: 0,
                limit: 8,
                thousandsSeparator: '.'
            })
        }
    })

}

function ordenarAnuncio() {
    $("#sltOrdenacao").change(function () {
        if ($(this).val() == "mnvalor") {
            var $valor = $('#itemContainer'),
                    $valorli = $valor.children('div');

            $valorli.sort(function (a, b) {
                var an = parseInt(a.getAttribute('data-valor')),
                        bn = parseInt(b.getAttribute('data-valor')),
                        ap = a.getAttribute('ordem'),
                        bp = b.getAttribute('ordem');

                if (an > bn) {
                    return 1;
                }
                if (an < bn) {
                    return -1;
                }
                if (an == bn) {
                    if (ap < bp) {
                        return 1;
                    } else {
                        return -1;
                    }
                }
//                return 0;
            });

        } else if ($(this).val() == "mrvalor") {
            var $valor = $('#itemContainer'),
                    $valorli = $valor.children('div');

            $valorli.sort(function (a, b) {
                var an = parseInt(a.getAttribute('data-valor')),
                        bn = parseInt(b.getAttribute('data-valor')),
                        ap = a.getAttribute('ordem'),
                        bp = b.getAttribute('ordem');

                if (an < bn) {
                    return 1;
                }
                if (an > bn) {
                    return -1;
                }
                if (an == bn) {
                    if (ap < bp) {
                        return 1;
                    } else {
                        return -1;
                    }
                }
                //return 0;
            });
        } else if ($(this).val() == "antigo") {

            var $valor = $('#itemContainer'),
                    $valorli = $valor.children('div');

            $valorli.sort(function (a, b) {

                var an = a.getAttribute('data-cadastro'),
                        bn = b.getAttribute('data-cadastro'),
                        ap = a.getAttribute('ordem'),
                        bp = b.getAttribute('ordem');

                if (an > bn) {
                    return 1;
                }
                if (an < bn) {
                    return -1;
                }
                if (an == bn) {
                    if (ap < bp) {
                        return 1;
                    } else {
                        return -1;
                    }
                }
                //return 0;
            });
        } else if ($(this).val() == "recente") {
            var $valor = $('#itemContainer'),
                    $valorli = $valor.children('div');

            $valorli.sort(function (a, b) {
                var an = a.getAttribute('data-cadastro'),
                        bn = b.getAttribute('data-cadastro'),
                        ap = a.getAttribute('ordem'),
                        bp = b.getAttribute('ordem');

                if (an < bn) {
                    return 1;
                }
                if (an > bn) {
                    return -1;
                }
                if (an == bn) {
                    if (ap < bp) {
                        return 1;
                    } else {
                        return -1;
                    }
                }
                //return 0;
            });
        }

        $valorli.detach().appendTo($valor);
        $("div.holder").jPages("destroy");
        paginarAnuncio();


    });
}

function paginarAnuncio() {

    $("div.holder").jPages({
        containerID: "itemContainer",
        perPage: 8,
        previous: 'Anterior',
        next: 'Próximo',
        first: 'Primeiro',
        last: 'Último'
    });


    $(".holder").addClass("ui pagination menu");
    $(".holder a").addClass("item");
    $(".jp-current").addClass("active");
    $(".holder span").addClass("item");

    $(".holder .item").on('click', function () {
        $("#itemContainer").css("min-height", "460px");
        $(".holder .item").removeClass("active");
        $(this).addClass("active");
        $(".jp-first").removeClass("active");
        $(".jp-previous").removeClass("active");
        $(".jp-next").removeClass("active");
        $(".jp-last").removeClass("active");
    });

    $(".jp-previous").on('click', function () {
        $(".jp-current").removeClass("active");
        if ($(".jp-current").prev().hasClass("jp-hidden")) {
            $(".jp-current").prev().prev().addClass("active");
        } else {
            $(".jp-current").prev().addClass("active");
        }
        $("#itemContainer").css("min-height", "460px");
    })

    $(".jp-next").on('click', function () {
        $(".jp-current").removeClass("active");
        if ($(".jp-current").next().hasClass("jp-hidden")) {
            $(".jp-current").next().next().addClass("active");
        } else {
            $(".jp-current").next().addClass("active");
        }
        $("#itemContainer").css("min-height", "460px");
    })

    $(".jp-last").on('click', function () {
        $(".jp-current").removeClass("active");
        $(this).prev().prev().addClass("active");
        $("#itemContainer").css("min-height", "460px");
    })

    $(".jp-first").on('click', function () {
        $(".jp-current").removeClass("active");
        $(this).next().next().addClass("active");
        $("#itemContainer").css("min-height", "460px");
    })

}

function exibirEnviarComparar() {

    $(document).ready(function () {

        var selecionado = 0;

        $('.ui.checkbox').checkbox({
            beforeChecked: function () { //ao clicar no anuncio, marcar de vermelho                                               
                var NumeroMaximo = 5;
                if ($("input[name^='listaAnuncio']").length >= NumeroMaximo) {
                    alert('Selecione no máximo ' + NumeroMaximo + ' imóveis para a comparação');
                    return false;
                } else {

                    $('#hdnTipoImovel').after('<input type="hidden" name="listaAnuncio[]" id=anuncio_' + $(this).val() + ' value=' + $(this).val() + '>');
                    $(this).closest('.card').attr("class", "red card");
                    selecionado = selecionado + 1;
                    var botaoEmailComparar = ("<div class='ui buttons'><button class='ui button' type='submit' id='btnEmail'>Enviar Por Email</button><div class='or' data-text='ou'></div><button class='ui positive button' type='submit' id='btnComparar'>Comparar</button></div>");
                    if (selecionado == 1) {
                        $("#divBotoes").html(botaoEmailComparar);
                        confirmarEmail();
                        $('#btnComparar').on('click', function () {
                            $("#hdnEntidade").val("Anuncio");
                            $("#hdnAcao").val("comparar");
                            $('#form').submit();
                        })
                    }
                }
            },
            onUnchecked: function () { //ao desmarcar o anuncio, tirar o vermelho
                $('#anuncio_' + $(this).val()).remove();
                $(this).closest('.card').attr("class", "card");
                selecionado = selecionado - 1;
                if (selecionado == 0) {
                    $("#divBotoes").empty();
                }

            }}
        );
    })
}

function carregarAnuncioUsuario() {

    $('.special.cards .image').dimmer({
        on: 'hover'
    });

    $("#spanValor").priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    })

    $('.special.cards .image .button').on('click', function () {
        $("#hdnCodAnuncio").val($(this).siblings().val());
        $("#hdnTipoImovel").val($(this).siblings().next().val());
        $('#form').submit();
    })
}

function confirmarEmail() {
    $(document).ready(function () {

        $('#btnEmail').click(function () {

            $("#divMsg").empty();

            $("#txtNomeEmail").show();
            $("#labelNome").show();

            $('.emailPDF').attr('value', 'enviarEmail'); //alterar o método para enviarEmailPDF 

            $("#divMsg").append("Envie o(s) Anúncio(s) selecionado(s) para o e-mail desejado");

            $('#modalEmail').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formEmail").submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');

            $("#txtMsgEmail").rules("add", {
                required: true
            });

            $("#camposEmail").show();
            $("#botaoEnviarEmail").show();
            $("#botaoCancelarEmail").show();
            $("#botaoFecharEmail").hide();
            $("#divRetorno").empty();

            $("#idAnuncios").empty();
            $("#idAnunciosCabecalho").empty();

            /*var arr = [];
             $("input[type^='checkbox']:checked").each(function ()
             {
             $("#idAnuncios").append("<input type='hidden' name='anunciosSelecionados[]' value='" + $(this).val() + "'>");
             var codigos = $("input[name^='hdnCodAnuncioFormatado']");
             arr.push($(this).parent().parent().parent().find(codigos).val());
             });
             
             //retira a vírgula do último elemento
             var anuncios = arr.join(", ");
             
             $("#idAnunciosCabecalho").append("<div class='ui horizontal list'>\n\
             <div class='item'>\n\
             <div class='content'>" + anuncios + "</div>\n\
             </div>\n\
             </div>");*/
            var arr = [];
            $(("input[name^='listaAnuncio']")).each(function () {
                arr.push($(this).val());
            });
            var anuncios = arr.join(", ");
            ;
            $("#idAnunciosCabecalho").append("<div class='ui horizontal list'>\n\
                                        <div class='item'>\n\
                                        <div class='content'>" + anuncios + "</div>\n\
                         </div>\n\
                         </div>");


        })
    })
}

function formatarValor(valor) {

    $("#spanValor" + valor).priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    })

//    $("#txtTitulo" + valor).maxlength({
//        threshold: 50,
//        warningClass: "ui small green circular label",
//        limitReachedClass: "ui small red circular label",
//        separator: ' de ',
//        preText: 'Voc&ecirc; digitou ',
//        postText: ' caracteres permitidos.',
//        validate: true
//    })
//
//    $("#txtDescricao" + valor).maxlength({
//        threshold: 200,
//        warningClass: "ui small green circular label",
//        limitReachedClass: "ui small red circular label",
//        separator: ' de ',
//        preText: 'Voc&ecirc; digitou ',
//        postText: ' caracteres permitidos.',
//        validate: true
//    })

}

function formatarValorComparar(valor) {

    $("#spanValor" + valor).priceFormat({
        prefix: ' ',
        centsSeparator: ',',
        centsLimit: 0,
        limit: 8,
        thousandsSeparator: '.'
    });

}

function enviarEmail() {
    $(document).ready(function () {

        $("#botaoFecharEmail").hide();

        $('#txtNomeEmail').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtMsgEmail').maxlength({
            alwaysShow: true,
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailEmail').maxlength({
            alwaysShow: true,
            threshold: 100,
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
        $('#formEmail').validate({
            onkeyup: false,
            focusInvalid: true,
            rules: {
                txtEmailEmail: {
                    required: true,
                    email: true
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
                }
            },
            messages: {
                txtEmailEmail: {
                    email: "Informe um email válido"
                },
                captcha_code: {
                    remote: "Código Inválido"
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#formEmail').serialize(),
                    beforeSend: function () {
                        $("#botaoEnviarEmail").hide();
                        $("#botaoCancelarEmail").hide();
                        $("#camposEmail").hide();
                        $("#divRetorno").html("<div><div class='ui active inverted dimmer'><div class='ui text loader'>Enviando Email. Aguarde...</div></div></div>");
                    },
                    success: function (resposta) {
                        $("#divRetorno").empty();
                        $("#botaoCancelarEmail").hide();
                        $("#botaoFecharEmail").show();
                        if (resposta.resultado == 1) {
                            $("#divRetorno").html('<div class="ui positive message">\n\
<i class="big green check circle outline icon"></i>Anúncio(s) enviado(s) com sucesso</div>');

                        } else {
                            $("#divRetorno").html('<div class="ui negative message">\n\
<i class="big red remove circle outline icon"></i>Tente novamente mais tarde. Houve um erro no processamento</div>');
                        }
                    }
                })
                return false;
            }
        })

    });
}

function inserirValidacao() {
    $(document).ready(function () {
        if ($("#hdnFinalidade").val() == "Venda") {

            $("#txtProposta").rules("add", {
                minLenght: 4,
                maxLenght: 7
            });
        }
    });
}

function enviarDenuncia() {
    $(document).ready(function () {

        $("#botaoFecharDenuncia").hide();

        $("#sltTipoDenuncia").dropdown('clear');
        $.post('index.php?hdnEntidade=Denuncia&hdnAcao=buscarTipoDenuncia',
                function (resposta) {
                    $("#retornoTipoDenuncia").html(resposta);
                }
        )

        $('.ui.dropdown')
                .dropdown()
                ;

        $('#txtMsgDenuncia').maxlength({
            alwaysShow: true,
            threshold: 500,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailDenuncia').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#btnDenuncia').click(function () {
            $('#modalDenunciaAnuncio').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formDenunciaAnuncio").submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');
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
            $('#formDenunciaAnuncio').validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    txtEmailDenuncia: {
                        email: true
                    },
                    txtMsgDenuncia: {
                        required: true
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
                    }
                },
                messages: {
                    txtEmailDenuncia: {
                        email: "Informe um email válido"
                    },
                    captcha_code: {
                        remote: "Código Inválido"
                    },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#formDenunciaAnuncio').serialize(),
                        beforeSend: function () {
                            $("#botaoEnviarDenuncia").hide();
                            $("#botaoCancelarDenuncia").hide();
                            $("#camposDenuncia").hide();
                            $("#divRetornoDenuncia").html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Enviando denúncia. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetornoDenuncia").empty();
                            $("#botaoCancelarDenuncia").hide();
                            $("#botaoFecharDenuncia").show();
                            if (resposta.resultado == 1) {
                                $("#divRetornoDenuncia").html("<div class='ui positive message'>\n\
<i class='big green check circle outline icon'></i>Denúncia Enviada com Sucesso</div>");
                                $("#btnDenuncia").attr("disabled", "disabled");

                            } else {
                                $("#divRetornoDenuncia").html("<div class='ui negative message'>\n\
<i class='big red remove circle outline icon'></i>Erro no Envio. Tente novamente em alguns minutos</div>");
                            }
                        }
                    })
                    return false;
                }
            })

        })
    })
}

function enviarDuvidaAnuncio() {
    $(document).ready(function () {

        $("#botaoFecharDuvida").hide();

        $('#txtNomeDuvida').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtMsgDuvida').maxlength({
            alwaysShow: true,
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailDuvida').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#btnDuvida').click(function () {

            $('#modalDuvidaAnuncio').modal({
                closable: true,
                transition: "fade up",
                onDeny: function () {
                },
                onApprove: function () {
                    $("#formDuvidaAnuncio").submit();
                    return false; //deixar o modal fixo
                }
            }).modal('show');

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
            $('#formDuvidaAnuncio').validate({
                onkeyup: false,
                focusInvalid: true,
                rules: {
                    txtEmailDuvida: {
                        required: true,
                        email: true
                    },
                    txtMsgDuvida: {
                        required: true
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
                    }
                },
                messages: {
                    txtEmailDuvida: {
                        email: "Informe um email válido"
                    },
                    captcha_code: {
                        remote: "Código Inválido"
                    },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#formDuvidaAnuncio').serialize(),
                        beforeSend: function () {
                            $("#botaoEnviarDuvida").hide();
                            $("#botaoCancelarDuvida").hide();
                            $("#camposDuvida").hide();
                            $("#divRetorno").html("<div><div class='ui active inverted dimmer'>\n\
                        <div class='ui text loader'>Enviando mensagem. Aguarde...</div></div></div>");
                        },
                        success: function (resposta) {
                            $("#divRetorno").empty();
                            $("#botaoCancelarDuvida").hide();
                            $("#botaoFecharDuvida").show();
                            if (resposta.resultado == 1) {
                                $("#divRetorno").html("<div class='ui positive message'>\n\
<i class='big green check circle outline icon'></i>Mensagem Enviada com Sucesso</div>");
                                $("#btnDuvida").attr("disabled", "disabled");

                            } else {
                                $("#divRetorno").html("<div class='ui negative message'>\n\
<i class='big red remove circle outline icon'></i>Erro no Envio. Tente novamente em alguns minutos</div>");
                            }
                        }
                    })
                    return false;
                }
            })

        })
    })
}


function inserirAnuncioModal() {

    var idAnuncio;

    $('.ui.checkbox')
            .checkbox({
                onChecked: function () {
                    idAnuncio = ("<input type='hidden' name='idAnuncio[]' id='idAnuncio'" + $(this) + ">");
                    $("#divBotoes").append(idAnuncio);
                },
                onUnchecked: function () {
                    // idAnuncio.remove();

                }})

}

function marcarMapa(logradouro, numero, bairro, cidade, estado, tituloAnuncio, valor, finalidade, latitude, longitude, altura, largura, aprox) {

    $(document).ready(function () {

        $("#mapaGmapsBusca").width(altura).height(largura).gmap3();

        if (latitude == "" && longitude == "") {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        center: [-1.38, -48.2],
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {address: logradouro + ", " + numero + ", " + bairro + ", " + cidade + ", " + estado, data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        } else {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        center: [-1.38, -48.2],
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {latLng: [latitude, longitude], data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        }

    });

}

function marcarMapaIndividual(logradouro, numero, bairro, cidade, estado, tituloAnuncio, valor, finalidade, latitude, longitude, altura, largura, aprox) {

    $(document).ready(function () {

        $("#mapaGmapsBusca").width(altura).height(largura).gmap3();

        if (latitude == "" && longitude == "") {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {address: logradouro + ", " + numero + ", " + bairro + ", " + cidade + ", " + estado, data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        } else {

            $("#mapaGmapsBusca").gmap3({
                map: {
                    options: {
                        zoom: aprox,
                        draggable: true
                    }
                },
                marker: {
                    values: [
                        {latLng: [latitude, longitude], data: tituloAnuncio + " - R$ " + valor + "<br>" + "Finalidade: " + finalidade},
                    ],
                    options: {
                        draggable: true
                    },
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                            if (infowindow) {
                                infowindow.close();
                            }
                        }
                    }
                }
            });

        }
        setTimeout(function () {
            $("#mapaGmapsBusca").width("100%").height(300).gmap3({trigger: "resize"});
            $('#mapaGmapsBusca').gmap3('get').setCenter($("#mapaGmapsBusca").gmap3({get: "marker"}).getPosition());
        }, 1000);
    });



}

function marcarMapaPublicarAnuncio(logradouro, numero, bairro, cidade, estado, tituloAnuncio, valor, finalidade, altura, largura, aprox) {

    $(document).ready(function () {

        $("#mapaGmapsBusca").width(altura).height(largura).gmap3();

        $("#mapaGmapsBusca").gmap3({
            map: {
                options: {
                    zoom: aprox,
                    draggable: true
                }
            },
            marker: {
                values: [{
                        address: logradouro + ", " + numero + ", " + bairro + ", " + cidade + "," + estado,
                        data: "Arraste o marcador, caso necessário, para o endereço correto"/*,
                         lat: logradouro + ", " + numero + ", " + bairro + ", "+ cidade + "," + estado,
                         lng: logradouro + ", " + numero + ", " + bairro + ", "+ cidade + "," + estado*/
                    },
                ],
                options: {
                    draggable: true
                },
                events: {
                    mouseover: function (marker, event, context) {
                        var map = $(this).gmap3("get"),
                                infowindow = $(this).gmap3({get: {name: "infowindow"}});
                        if (infowindow) {
                            infowindow.open(map, marker);
                            infowindow.setContent(context.data);
                        } else {
                            $(this).gmap3({
                                infowindow: {
                                    anchor: marker,
                                    options: {content: context.data}
                                }
                            });
                        }
                    },
                    mouseout: function () {
                        var infowindow = $(this).gmap3({get: {name: "infowindow"}});
                        if (infowindow) {
                            infowindow.close();
                        }
                    },
                    dragend: function (map, event) {
                        var myLatLng = event.latLng;
                        var lat = myLatLng.lat();
                        var lng = myLatLng.lng();

                        $("#hdnLatitude").val(lat);
                        $("#hdnLongitude").val(lng);

                        //alert($("#hdnLatitude").val()+$("#hdnLongitude").val());

                    }
                }
            }

        });

    });

}

function carregarDiferencial() {

    $(document).ready(function () {

        $("#sltTipoImovelAvancado").change(function () {

            $.ajax({
                url: "index.php",
                type: "POST",
                data: {
                    hdnEntidade: "TipoImovelDiferencial",
                    hdnAcao: "buscarDiferencialLista",
                    sltTipoImovel: $('#sltTipoImovelAvancado').val()
                },
                success: function (resposta) {

                    $('#carregarDiferenciais').html(resposta);

                }
            })
        })
    })
}

function carregarCarrosselPreferencias() {

    $(document).ready(function () {
        var swiper = new Swiper('.swiper-container', {
//            pagination: '.swiper-pagination',
            slidesPerView: 4,
            paginationClickable: true,
            spaceBetween: 30
        });
//       $('.bxslider').bxSlider({
//        minSlides: 2,
//        maxSlides: 2,
//        slideWidth: 350,
//        slideMargin: 10
//});

//        $('.multiple-items').slick({
//            infinite: true,
//            slidesToShow: 3,
//            slidesToScroll: 3
//        });

//        $('.owl-carousel').owlCarousel({
//            loop: false,
//            nav: true,
////            margin: 39,
//            stagePadding: 24,
//            items: 4,
//            
//            responsive: {
//                0: {
//                    items: 1
//                },
//                600: {
//                    items: 2
//                },
//                1000: {
//                    items: 4
//                }
//            }
//        })
    })
}

function inicio() {

    $(document).ready(function () {

        $('.menu .item').tab();

        $("#porCorretor").hide();
        $("#divValorVenda").hide();
        $("#divValorAluguel").hide();
        $("#divQuarto").hide();
        $("#divCondicaoAvancado").hide();
        $("#divQuarto").hide();
        $("#divBanheiro").hide();
        $("#divSuite").hide();
        $("#divAreaApartamento").hide();
        $("#divAreaCasaTerreno").hide();
        $("#divUnidadesAndar").hide();
        $("#divDiferencial").hide();
        $("#divGaragem").hide();
        $("#divGaragemAvancado").hide();
        $("#divAndares").hide();
        $("#divOutrasCaracteristicas").hide();

        $("#abaBasica").click(function () {
            $("#porCorretor").hide();
            $("#abaBasicaMenu").show();
        });

        $("#abaAvancada").click(function () {
            $("#porCorretor").hide();
            $("#abaBasicaMenu").hide();
            $("#abaAvancadaMenu").show();
        });

        $("#abaCorretor").click(function () {
            $("#porCorretor").show();
            $("#abaBasicaMenu").hide();
            $("#abaAvancadaMenu").hide();
        });

        $("#sltFinalidadeAvancado").change(function () {
            if ($(this).val() == "venda") {
                $("#divValorInicial").hide();
                $("#divValorAluguel").hide();
                $("#divValorVenda").show();


            }
            if ($(this).val() == "aluguel") {
                $("#divValorInicial").hide();
                $("#divValorVenda").hide();
                $("#divValorAluguel").show();

            }

            if ($(this).val() == "") {
                $("#divValorVenda").hide();
                $("#divValorAluguel").hide();
                $("#divValorInicial").show();
            }

        })

        $("#sltTipoImovel").change(function () {

            switch ($(this).val()) {

                case "":
//                    $("#divGaragem").hide();
                    $("#divCondicao").hide();
                    break;

                case "casa":
//                  $("#divGaragem").show();
                    $("#divCondicao").show();
                    break;

                case "apartamentoplanta":
                    //$("#divGaragem").show();
                    $("#divCondicao").hide();
                    break;

                case "apartamento":
                    //$("#divGaragem").show();
                    $("#divCondicao").show();
                    break;

                case "salacomercial":
                    //$("#divGaragem").show();
                    $("#divCondicao").show();
                    break;

                case "prediocomercial":
                    $("#divGaragem").hide();
                    $("#divCondicao").hide();
                    break;

                case "terreno":
                    $("#divGaragem").hide();
                    $("#divCondicao").hide();
                    break;

            }

        })

        $("#sltTipoImovelAvancado").change(function () {

            $('#carregarDiferenciais').dropdown('restore defaults'); //resetar os diferenciais selecionados ao trocar o tipo    

            switch ($(this).val()) {

                case "":

                    $("#divValorVenda").hide();
                    $("#divValorAluguel").hide();
                    $("#divQuarto").hide();
                    $("#divCondicao").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divQuarto").hide();
                    $("#divBanheiro").hide();
                    $("#divSuite").hide();
                    $("#divAreaApartamento").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divDiferencial").hide();
                    $("#divGaragem").hide();
                    $("#divGaragemAvancado").hide();
                    $("#divAndares").hide();
                    $("#divOutrasCaracteristicas").hide();
                    $("#textoEspecifico").hide();
                    $("#tabelaInicioBusca").show();
                    break;

                case "casa":

                    $("#tabelaInicioBusca").hide();
                    $("#divAreaApartamento").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAndares").hide();
                    $("#divQuarto").show();
                    $("#divCondicaoAvancado").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divSuite").show();
                    $("#divAreaApartamento").show();
                    $("#divDiferencial").show();
                    $("#divOutrasCaracteristicas").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico da Casa</div>");
                    break;

                case "apartamento":

                    $("#tabelaInicioBusca").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divAndares").hide();
                    $("#divQuarto").show();
                    $("#divCondicaoAvancado").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divSuite").show();
                    $("#divAreaApartamento").show();
                    $("#divUnidadesAndar").show();
                    $("#divDiferencial").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico do Apartamento</div>");
                    $("#divOutrasCaracteristicas").show();
                    break;

                case "apartamentoplanta":

                    $("#tabelaInicioBusca").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divQuarto").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divSuite").show();
                    $("#divAreaApartamento").show();
                    $("#divUnidadesAndar").show();
                    $("#divDiferencial").show();
                    $("#divAndares").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico do Apartamento na Planta</di>");
                    $("#divOutrasCaracteristicas").show();
                    break;

                case "salacomercial":

                    $("#tabelaInicioBusca").hide();
                    $("#divQuarto").hide();
                    $("#divSuite").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divAreaTerreno").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAndares").hide();
                    $("#divOutrasCaracteristicas").hide();
                    $("#divAreaApartamento").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divDiferencial").hide();
                    $("#divAndares").hide();
                    $("#divAreaApartamento").hide();
                    $("#divCondicaoAvancado").show();
                    $("#divGaragemAvancado").show();
                    $("#divBanheiro").show();
                    $("#divDiferencial").show();
                    $("#textoEspecifico").show();
                    $("#textoEspecifico").html("<div class='ui white large label'>Específico da Sala Comercial</div>");
                    break;

                case "prediocomercial":

                    $("#tabelaInicioBusca").hide();
                    $("#divQuarto").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divSuite").hide();
                    $("#divGaragemAvancado").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAreaCasaTerreno").hide();
                    $("#divAreaApartamento").hide();
                    $("#divAndares").hide();
                    $("#textoEspecifico").hide();
                    $("#divBanheiro").hide();
                    $("#divOutrasCaracteristicas").hide();
//                    $("#divArea").show();
//                    $("#divDiferencial").show();
//                    $("#divOutrasCaracteristicas").show();
                    break;

                case "terreno":

                    $("#tabelaInicioBusca").hide();
                    $("#divQuarto").hide();
                    $("#divCondicaoAvancado").hide();
                    $("#divSuite").hide();
                    $("#divGaragemAvancado").hide();
                    $("#divBanheiro").hide();
                    $("#divUnidadesAndar").hide();
                    $("#divAndares").hide();
                    $("#divAreaApartamento").hide();
                    $("#divAreaCasaTerreno").show();
                    $("#textoEspecifico").hide();
                    $("#divOutrasCaracteristicas").hide();
                    break;
            }

        })

    });
}

function ordemInicio() {

    $(document).ready(function () {

        $("#sltOrdenacao").change(function () {
            $("#load").addClass('ui active inverted dimmer');
            if ($('#hdnOrdTipoImovel').val() == "") {
                tipoimovel = "todos";
            } else {
                tipoimovel = $('#sltTipoImovel').val();
            }
            $('#divAnuncios').load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'buscarAnuncio',
                tipoImovel: tipoimovel,
                valor: $('#hdnOrdValor').val(),
                finalidade: $('#hdnOrdFinalidade').val(),
                idcidade: $('#hdnOrdCidade').val(),
                idbairro: $('#hdnOrdBairro').val(),
                quarto: $('#hdnOrdQuartos').val(),
                condicao: $('#hdnOrdCondicao').val(),
                garagem: $('#hdnOrdGaragem').val(),
                ordem: $(this).val()}, function () {
                $("#load").addClass('ui active inverted dimmer');
            });
            setTimeout(function () {
                $('#load').removeClass("ui active inverted dimmer");
            }, 1000);
        })
    });
}



function validarArea(validacao) {
//    $(document).ready(function () {
//
//        if (validacao) {
//            $.validator.addMethod("verificaArea", function (value, element) {
//                var validacao = false;
//                if ($("#sltAreaMin").val() == "" && $("#sltAreaMax").val() != "") {
//                    validacao = true;
//                }
//                if ($("#sltAreaMax").val() != "" && $("#sltAreaMax").val() == "") {
//                    validacao = true;
//                }
//                return this.optional(element) || validacao;
//            }, 'Informe um valor.');
//
//            $("#sltAreaMin").rules("add", {
//                verificaArea: true
////                required: function (element) {
////                    return $("#chkValor").parent().checkbox('is checked');
////                }
//            });
//            $("#sltAreaMax").rules("add", {
//                verificaArea: true
////                required: function (element) {
////                    return $("#chkValor").parent().checkbox('is checked');
////                }
//            });
//        }
//        
//        if ("#hdnMsgDuvida") {
//                $("#txtMsgEmail").rules("add", {
//                    required: true
//                });
//            }
////if ($("#sltAreaMin").val() != "" && $("#sltAreaMax").val() == ""){
////                    var valor = parseInt($("#txtValor").unmask());
////                    if (!isNaN(valor)) {
////                        if (valor > 100) {
////                            validacao = true;
////                        }
////                    }
////                } else {
////                    validacao = true;
////                }
//    })
}

function enviarDuvidaUsuario() {

    $(document).ready(function () {

        $('#txtNomeDuvida').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtMsgDuvida').maxlength({
            alwaysShow: true,
            threshold: 200,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtTituloDuvida').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $('#txtEmailDuvida').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "ui small green circular label",
            limitReachedClass: "ui small red circular label",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $("#botaoEnviarDuvida").click(function () {
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
                txtEmailDuvida: {
                    email: true,
                    required: true
                },
                txtTituloDuvida: {
                    required: true
                },
                txtMsgDuvida: {
                    required: true
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
            },
            messages: {
                txtEmailDuvida: {
                    email: "Informe um email válido"
                },
                captcha_code: {
                    remote: "Código Inválido"
                },
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

                        $("input[type^='text']").each(function () {
                            $(this).attr("disabled", "disabled");
                        });

                        $("#txtMsgDuvida").attr("disabled", "disabled");

                        $("#botoesDuvidas").hide();

                        $("#duvidaCaptcha").hide();

                        if (resposta.resultado == 1) {
                            $("#divRetorno").html('<div class="ui positive message">\n\
                            <i class="big green check circle outline icon"></i>Dúvida enviada com sucesso. Em breve responderemos a você</div>');

                        } else {
                            $("#divRetorno").html('<div class="ui negative message">\n\
                            <i class="big red remove circle outline icon"></i>Tente novamente mais tarde. Houve um erro no processamento</div>');
                        }
                    }
                })
                return false;

            }
        });


    });
}

