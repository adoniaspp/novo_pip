
<div class="ui hidden divider"></div>

<div class="ui center aligned divided equal width grid">
    <div class="teal column">
        <div class="ui list">
            <?php if (Sessao::verificarSessaoUsuario()) { ?>

                <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=meuPIP"> Minha Conta </a> 

            <?php } else { ?>
                <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=form&tipo=login">Minha Conta</a>

            <?php } ?>
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Institucional&acao=comoFunciona">Como Funciona</a>
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Plano&acao=precosAnuncios">Planos dos Anuncios</a>
        </div>
    </div>
    <div class="teal column">
        <div class="ui list">
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Institucional&acao=quemSomos">Quem Somos</a>
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Institucional&acao=mapaSite">Mapa do Site</a>
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Institucional&acao=comoAnunciar">Como Anunciar</a>             
        </div>
    </div>
    <div class="teal column">
        <div class="ui list">       
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Institucional&acao=termosUso">Termos de Uso</a>           
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Institucional&acao=duvidasFrequentes">Dúvidas Frequentes</a>
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=form&tipo=faleconosco">Fale Conosco</a>
        </div>
    </div>
</div>

<div class="ui center aligned divided equal width grid">
    <div class="blue column">
        <div class="ui list">
            <div class="item"><i class="copyright icon"></i>PIP-ONLine - Todos os Direitos Reservados - 2017</div>       
        </div>
    </div>   
</div>
