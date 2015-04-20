<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>

<script>
    buscarAnuncio();
</script>

<br>
<div class="ui center aligned column page grid">
<!--<div class="column"></div>-->
<div class="ui form inverted blue segment" id="divBusca">
    <div class="ui center aligned column page grid">
        <div class="column">
            <div class="four fields">
                <div class="ui field">
                    <label>Tipo de Imóvel</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltTipoImovel" id="sltTipoImovel">
                        <div class="default text">Informe o Tipo do Imóvel</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Todos os Tipos</div>
                            <div class="item" data-value="casa">Casa</div>
                            <div class="item" data-value="apartamentoplanta">Apartamento na Planta/Novo</div>
                            <div class="item" data-value="apartamento">Apartamento</div>
                            <div class="item" data-value="salacomercial">Sala Cormecial</div>
                            <div class="item" data-value="terreno">Terreno</div>
                        </div>
                    </div>
                </div>
                <div class="ui field">
                    <label>Finalidade</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltFinalidade" id="sltFinalidade">
                        <div class="default text">Todas as Finalidades</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Todas as Finalidade</div>
                            <div class="item" data-value="venda">Venda</div>
                            <div class="item" data-value="aluguel">Aluguel</div>
                        </div>
                    </div>
                </div>
                <div class="ui field">
                    <label>Cidade</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltCidade" id="sltCidade">
                        <div class="default text">Todas as Cidade</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Todas as Cidade</div>
                            <div class="item" data-value="1">Belém</div>
                            <div class="item" data-value="2">Ananindeua</div>
                            <div class="item" data-value="3">Marituba</div>
                        </div>
                    </div>
                </div>
                <div class="ui field">
                    <label>Bairro</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltBairro" id="sltBairro">
                        <div class="default text">Selecione a Cidade</div>
                        <i class="dropdown icon"></i>
                        <div class="menu" id="menuBairro">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui center aligned column page grid padding-reset" id="divCaracteristicas">
        <div class="column">
            <div class="four fields">
                <!--                <div class="field" id="divPreenchimento1"></div>-->
                <div class="field" id="condicao">
                    <label>Condição</label>
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="sltCondicao" id="sltCondicao">
                        <div class="default text">Informe a Condição</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Qualquer Condição</div>
                            <div class="item" data-value="novo">Novo</div>
                            <div class="item" data-value="usado">Usado</div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Quartos</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltQuartos" id="sltQuartos">
                        <div class="default text">Qualquer Quantidade</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="">Qualquer Quantidade</div>
                            <div class="item" data-value="1">1</div>
                            <div class="item" data-value="2">2</div>
                            <div class="item" data-value="3">3</div>
                            <div class="item" data-value="4">4</div>
                            <div class="item" data-value="5">Mais de 5</div>
                        </div>
                    </div>
                </div>

                <div class="five wide field" id="divValorVenda">
                    <label>Valor</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltValor" id="sltValor">
                        <div class="default text">Informe o Valor</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class='item' data-value=0>Menos de R$100.000</div>
                            <?php
                            $i = 100000;
                            while ($i < 1000000) {
                                print "<div class='item' data-value=" .
                                        $i . ">Entre R$" . number_format($i, 2, ',', '.') . " e R$" . number_format($i + 100000, 2, ',', '.') . "</div>";
                                $i = $i + 100000;
                            }
                            ?>
                            <div class='item' data-value=1000000>Mais de R$1.000.000</div>
                        </div>
                    </div>
                </div> 
                
                <div class="five wide field" id="divValorAluguel">
                    <label>Valor</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="sltValor" id="sltValor">
                        <div class="default text">Informe o Valor</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class='item' data-value=0>Menos de R$500</div>
                            <?php
                            $i = 500;
                            while ($i < 10000) {
                                print "<div class='item' data-value=" .
                                        $i . ">Entre R$" . number_format($i, 2, ',', '.') . " e R$" . number_format($i + 500, 2, ',', '.') . "</div>";
                                $i = $i + 500;
                            }
                            ?>
                            <div class='item' data-value=1000000>Mais de R$10.000</div>
                        </div>
                    </div>
                </div> 
                
                <div class="three wide field">
                    <br><br>
                    <div class="ui toggle checkbox">
                        <input type="checkbox" name="checkgaragem" id="checkgaragem">
                        <label>Garagem</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui center aligned column page grid padding-reset">
        <div class="column">
            <div class="field">
                <br>
                <div class="green ui icon button" id="btnBuscarAnuncio">
                    <i class="search icon"></i> 
                    PIP
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="ui center aligned column page grid">
</div>
<div class="ui red segment" id="divAnuncios">  
</div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>


<script src="assets/js/diferencial.js"></script>

<script>

    chamarDiferencial(); //chama a função javascript diferencial.js, para chamar o diferencial de cada Tipo de Imóvel

    $(document).ready(function() {

        $("select[name=sltCidade]").change(function() {
            $('select[name=sltBairro]').html('<option value="">Procurando...</option>');
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidade').val(),
                    function(resposta) {
                        $('select[name=sltBairro]').html(resposta);
                    }

            );
        });
    });

</script>

<script>

    $(document).ready(function() {
        $("select[name=sltCidadeAvancado]").change(function() {
            $('select[name=sltBairroAvancado]').html('<option value="">Procurando...</option>');
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade=' + $('#sltCidadeAvancado').val(),
                    function(resposta) {
                        $('select[name=sltBairroAvancado]').html(resposta);
                    }

            );
        });
    });

</script>

<script>
    $(document).ready(function() {
        $("#divValorVenda").hide(); //oculta a div dos valores de venda 
        $("#divValorAluguel").hide(); //oculta a div dos valores de aluguel

        $("#sltFinalidade").change(function() {
            if ($(this).val() == "venda") {
                $("#divValorInicial").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguel").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVenda").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CPF")
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CPF");
            }
            if ($(this).val() == "aluguel") {
                $("#divValorInicial").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVenda").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguel").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CNPJ");
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CNPJ");
            }

            if ($(this).val() == "") {
                $("#divValorVenda").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguel").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorInicial").fadeIn(); //oculta campos exclusivos do apartamento 
            }

        })
    });
</script>

<script>
    $(document).ready(function() {
        $("#divValorVendaAvancado").hide(); //oculta a div dos valores de venda 
        $("#divValorAluguelAvancado").hide(); //oculta a div dos valores de aluguel

        $("#sltFinalidadeAvancado").change(function() {
            if ($(this).val() == "venda") {
                $("#divValorInicialAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguelAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVendaAvancado").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CPF")
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CPF");
            }
            if ($(this).val() == "aluguel") {
                $("#divValorInicialAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVendaAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguelAvancado").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CNPJ");
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CNPJ");
            }

            if ($(this).val() == "") {
                $("#divValorVendaAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguelAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorInicialAvancado").fadeIn(); //oculta campos exclusivos do apartamento 
            }

        })
    });
</script>