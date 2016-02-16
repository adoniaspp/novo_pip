<?php

include_once 'configuracao/cookies.php';

Cookies::consultarPreferencias();

?>


<script src="assets/js/buscaAnuncio.js"></script>
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>

<script>
    
    inicio();
    ordemInicio();
    buscarAnuncio();
    carregarDiferencial();

</script>

<div class="ui middle aligned stackable grid container">
 
    <div class="column">
        
        <?php
    
        include_once "/visao/modulo/menuBusca.php";

        ?>
        
    </div>

</div>    

<div class="ui hidden divider"></div>

<div id="divOrdenacao" class="ui center aligned basic segment">
    <input type="hidden" id="hdnOrdTipoImovel" name="hdnOrdTipoImovel"/>
    <input type="hidden" id="hdnOrdValor" name="hdnOrdValor"/>
    <input type="hidden" id="hdnOrdFinalidade" name="hdnOrdFinalidade"/>
    <input type="hidden" id="hdnOrdIdcidade" name="hdnOrdIdcidade"/>
    <input type="hidden" id="hdnOrdIdbairro" name="hdnOrdIdbairro"/>
    <input type="hidden" id="hdnOrdQuarto" name="hdnOrdQuarto"/>
    <input type="hidden" id="hdnOrdCondicao" name="hdnOrdCondicao"/>
    <input type="hidden" id="hdnOrdGaragem" name="hdnOrdGaragem"/>   
    <div class="ui selection dropdown">
        <input type="hidden" name="sltOrdenacao" id="sltOrdenacao">
        <div class="default text">Escolha a ordem</div>
        <i class="dropdown icon"></i>
        <div class="menu">
            <div class="item" data-value="preco_maior"><i class="ui chevron up icon"></i>Maior Preço</div>
            <div class="item" data-value="preco_menor"><i class="ui chevron down icon"></i>Menor Preço</div>
            <div class="item" data-value="recente_mais"><i class="ui chevron up icon"></i>Mais Recente</div>
            <div class="item" data-value="recente_menos"><i class="ui chevron down icon"></i>Menos Recente</div>
        </div>
    </div>
</div>

<div class="ui basic segment" id="divAnuncios"></div>

<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<div class="ui center aligned grid">
      <div class="column"><i class="teal big help icon"></i>COMO FUNCIONA</div>
  </div>

<div class="ui center aligned equal width grid">
  <div class="column"><i class="teal big add user icon"></i>1 - FAÇA SEU CADASTRO PARA ANUNCIAR
      <br>
      Cadastre seus dados (Nome, Endereço, Tipo de Pessoa, Telefone, Email, etc) e escolha um login
      para ser sua identificação no PIP On-Line (Ex: www.piponline.com.br/joaosilva1980)
  </div>
  <div class="column"><i class="teal big edit icon"></i>2 - CADASTRE SEU IMÓVEL (Casa, Apartamentos, etc.)
      <br>
      Cadastre as características do imóvel (quartos, banheiros, garagens, área, etc).
  </div>
  <div class="column"><i class="teal big add to cart icon"></i>3 - COMPRE O ANUNCIO
      <br>
      Após cadastrar o imóvel, compre o anuncio para divulgar seu produto, escolhendo o melhor
      para sua necessidade (1 mês de divulgação no site, 2 meses, etc.)
  </div>
</div>  

<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<div class="ui center aligned grid">
  <div class="column"><i class="teal big list icon"></i>VANTAGENS DO PIP-ONLINE</div>
</div>

<div class="ui left aligned equal width grid">
  <div class="column">
      <div class="ui bulleted list">
        <div class="item">Cadastre vários imóveis e escolha quais anunciar </div>
        <div class="item">Enviar anuncios por e-mail</div>
        <div class="item">Envie dúvidas sobre os anuncios</div>
        <div class="item">É vendedor? você tem sua área específica, bastando digitar seu login na barra de endereços</div>
      </div>
  </div>
    <div class="column">
      <div class="ui bulleted list">
        <div class="item">Busca completa, inclusive na área do vendedor</div>
        <div class="item">Reative anuncios expirados, sem necessidade de recadastrar o imóvel</div>
        <div class="item">Compatível com dispositivos móveis (celular e tablet)</div>
        <div class="item">Quer saber mais detalhes sobre mais vantagens? clique AQUI</div>
      </div>  
    </div>
</div>
      
<div class="ui hidden divider"></div>
<div class="ui divider"></div>
<div class="ui hidden divider"></div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>





