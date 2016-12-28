
<div class="ui hidden divider"></div>

<div class="ui center aligned divided equal width grid">
  <div class="teal column">
        <div class="ui list">
            <?php if (Sessao::verificarSessaoUsuario()) { ?>
            
                <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=meuPIP"> Minha Conta </a> 
            
                   <?php } else { ?>
                <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=form&tipo=login">Minha Conta</a>
            
            <?php } ?>
            <div class="item">Como Funciona</div>
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Plano&acao=precosAnuncios">Planos dos Anuncios</a>
            <div class="item">Promoções</div>           
        </div>
  </div>
  <div class="teal column">
        <div class="ui list">
            <div class="item" style="color: white">Quem Somos</div>
            <div class="item" style="color: white">Mapa do Site</div>
            <div class="item" style="color: white">Como Anunciar</div>
            <div class="item" style="color: white">Termos de Uso</div>
            <a class="item" style="color: white" href="<?php echo PIPURL; ?>index.php?entidade=Usuario&acao=faleConosco">Fale Conosco</a>
        </div>
  </div>
  <div class="teal column">
        <div class="ui list">
            <div class="item" style="color: white">Institucional</div>       
            <div class="item" style="color: white">Dúvidas Frequentes</div>
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
