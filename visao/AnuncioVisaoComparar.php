<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/jquery/bootstrap-maxlength.js"></script>

<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/lightbox/lightbox.css">
<script src="assets/libs/jquery/jquery.price_format.min.js"></script>
<script src="assets/libs/lightbox/lightbox.min.js"></script>
<script src="assets/js/imagemComparar.js"></script>
<script src="assets/js/buscaAnuncio.js"></script>

<?php
$item = $this->getItem();
?>     
<div class="ui middle aligned stackable grid container">
    <div class="row" id="breadcrumb">
        <div class="column">
            <div class="ui large breadcrumb">
                <a class="section" href="index.php">Início</a>
                <i class="right chevron icon divider"></i>
                <a class="active section">Comparar Anúncios</a>
            </div>
        </div>
    </div>
    
    <div class="row">
      <div class="column">  
        <div class="ui positive message">
          Veja abaixo os anúncios escolhidos por você para comparação. Se desejar, clique nos títulos das colunas para ordenar 
        </div> 
      </div>  
    </div>
    
    
    <div>
        <div class="row">
            <div class="column"> 
                Clique para Habilitar/Desabilitar Coluna                
            </div>
        </div>    
    </div>

    
<div class="row">
      <div class="column">    
        <table class="ui celled table">
          <thead>
            <tr>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="0">Tipo</a></th>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="1">Título</a></th>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="2">Valor</a></th>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="3">Área</a></th>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="4">Quarto(s)</a></th>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="5">Banheiro(s)</a></th>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="6">Garagem</a></th>
              <th class="center aligned"><a href="" class="toggle-vis" data-column="7">Bairro</a></th>
            </tr>
          </thead>        
        </table>
    </div>
</div>
    
    
    
</div>   



<div class="ui middle aligned stackable grid container">
    <div class="column">
        <table class="ui blue table" id="tabela">
            <thead>
                <tr>
                    <th>Tipo de Imóvel</th>
                    <th>Título</th>                   
                    <th>Valor (R$)</th>                        
                    <th>Área (m<sup>2</sup>)</th>
                    <th>Quarto(s)</th>
                    <th>Banheiro(s)</th>
                    <th>Garagem</th>                  
                    <th>Bairro</th>
                    <!--<th>Condição</th>-->
                    <!--<th>Foto</th>-->
                    <th>Ver Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($item as $anuncio) {
                    ?>
                <script>
                    $(document).ready(function () {
                    formatarValorComparar(<?php echo $anuncio['idanuncio']?>);
                    })
                </script>
                    <tr>
                        
                        <td>
                            <?php
                            if ($anuncio['tipo'] == 'apartamentoplanta') {
                                echo 'Apartamento na Planta';
                            } else if ($anuncio['tipo'] == 'salacomercial') {
                                echo 'Sala Comercial';
                            } else if ($anuncio['tipo'] == 'prediocomercial') {
                                echo 'Prédio Comercial';
                            }else {
                                echo ucfirst($anuncio['tipo']);
                            }
                            ?>
                        </td>
                        
                        <td class="collapsing">
                            
                            <?php
                                $limite = 20;
                                $titulo = $anuncio['tituloanuncio'];
                                echo (strlen(trim($titulo)) >= $limite) ? trim(substr($titulo, 0, strrpos(substr($titulo, 0, $limite), " "))) . "..." : $titulo;
                                ?>
                        </td>
                        
                        <td id="spanValor<?php echo $anuncio['idanuncio']?>"><?php echo 'R$' . $anuncio['valormin'] ?></td>
                        <td>
                            <?php
                            echo minMax($anuncio, 'area');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo minMax($anuncio, 'quarto');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo minMax($anuncio, 'banheiro');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo minMax($anuncio, 'garagem') . ' vaga(s)';
                            ?>
                        </td>
                        
                        <td><?php echo $anuncio['bairro'] ?></td>
                        <!--<td><?php //echo ucfirst($anuncio['condicao']) ?></td>-->
                        
                        <!--<td>
                            <?php
                            /*if ($anuncio['imagem']) {
                                foreach ($anuncio['imagem'] as $imagem) {
                                    if ($imagem['destaque'] == 'SIM') {*/
                                        ?>
                                        <a href="<?php //echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>" data-lightbox="image-1" data-title="My caption" >
                                            <img style="height:80px; width: 100px;" src="<?php //echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>">
                                        </a>
                                        <?php/*
                                    }
                                }
                            } else {*/
                                ?>
                                <a href="<?php //echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" data-lightbox="image-1" data-title="My caption" >
                                    <img style="height:80px; width: 100px;" src="<?php //echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                                </a>
                                <?php //} ?>
                        </td>-->
                        <td>

                            <form id="form" action="index.php" method="post" target='_blank'>
                            <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                            <input type="hidden" id="hdnAcao" name="hdnAcao" value="detalhar"/>
                            <input type="hidden" id="hdnCodAnuncio" name="hdnCodAnuncio" value="<?php echo $anuncio['idanuncio'] ?>"/>
                            <input type="hidden" id="hdnTipoImovel" name="hdnTipoImovel" value="<?php echo $anuncio['tipo'] ?>"/>

                            <button class="ui labeled icon button">
                                <i class="zoom icon"></i>
                                <?php echo $anuncio['idanuncioformatado']; ?>
                            </button>

                            </form>

                        </td>
                    </tr>
            <?php } ?>

            </tbody>

        </table>       
    </div>
</div>

<div class="ui middle aligned stackable grid container">
    <div class="row">
      <div class="column">  
        <div class="ui message">
          Clique em "Ver Detalhes" para saber mais informações sobre o imóvel
        </div> 
      </div>  
    </div>
</div>
<?php

function minMax($parametros, $coluna) {
    if ($parametros['tipo'] == 'apartamentoplanta') {
        foreach ($parametros['plantas'] as $planta) {
            $conjunto[] = $planta[$coluna];
        }
        return min($conjunto) . ' a ' . max($conjunto);
    } else if ($parametros[$coluna]) {
        return $parametros[$coluna];
    } else {
        return '-';
    }
}
?>

<script>
    $(document).ready(function () {
        var table = $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "searching": false,
            "paging": false,
            "info": false,
            "columnDefs": [
                {"orderable": false, "targets": [8]}
            ]
        });
        $('#tabela tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
            var column = table.column( $(this).attr('data-column') );
            column.visible( ! column.visible() );
        });

    })
</script>