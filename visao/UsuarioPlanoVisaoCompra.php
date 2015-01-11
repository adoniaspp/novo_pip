<div class="container">
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <li><a href="index.php?entidade=UsuarioPlano&acao=listar">Comprar Planos</a></li>
        <li class="active">Redirecionamento Para o PagSeguro</li>
    </ol>
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