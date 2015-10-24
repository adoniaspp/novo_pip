<!-- HTML -->
<div class="ui column doubling grid container">
    <div class="column">
        <div class="ui large breadcrumb">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <i class="block layout small icon"></i>
                <a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a>
                <i class="right chevron icon divider"></i>
                <i class="shop small icon"></i>
                <a class="section" href="index.php?entidade=UsuarioPlano&acao=listar">Comprar Planos</a>
                <i class="right chevron icon divider"></i>
                <div class="active section"><i class="forward mail small icon"></i>Redirecionamento</div>
            </div>
        </div>
    </div>
</div>
    <div class="page-header">
        <h5>Aguarde você será redirecionado para o PagSeguro!</h5>
    </div>
    <a href="index.php?entidade=usuarioplano&acao=listar"> 
        <img src="https://luxealianc.lojablindada.com/media/16-redirecionamento-pagseguro3.jpg" />
    </a>
    <script>
        $(document).ready(function() {
            setTimeout(
                    function()
                    {
                        location.href = "index.php?entidade=UsuarioPlano&acao=listar"
                    }, 5000);

        })
    </script>