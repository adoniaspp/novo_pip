
<div class="ui hidden divider"></div>

<div class="ui center aligned divided equal width grid">
  <div class="teal column">
        <div class="ui list">
            <?php if (Sessao::verificarSessaoUsuario()) { ?>
            
                <a class="item" href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=meuPIP"> Minha Conta </a> 
            
                   <?php } else { ?>
                <a class="item" href="<?php echo PIPURL; ?>/index.php?entidade=Usuario&acao=form&tipo=login">Minha Conta</a>
            
            <?php } ?>
            <div class="item">Como Funciona?</div>
            <a class="item" href="<?php echo PIPURL; ?>/index.php?entidade=Plano&acao=precosAnuncios">Preços dos Anuncios</a>
            <div class="item">Promoções</div>           
        </div>
  </div>
  <div class="teal column">
        <div class="ui list">
            <div class="item">Quem Somos</div>
            <div class="item">Mapa do Site</div>
            <div class="item">Como Anunciar</div>
            <div class="item">Termos de Uso</div>
            <div class="item">Fale Conosco</div>           
        </div>
  </div>
  <div class="teal column">
        <div class="ui list">
            <div class="item">Institucional</div>       
            <div class="item">Dúvidas Frequentes</div>
        </div>
  </div>
</div>

<div class="ui center aligned divided equal width grid">
 <div class="blue column">
        <div class="ui list">
            <div class="item"><i class="copyright icon"></i>PIP-ONLine - Todos os Direitos Reservados - 2016</div>       
        </div>
  </div>   
</div>