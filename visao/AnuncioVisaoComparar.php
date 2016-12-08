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
<div class="ui column doubling grid container">
    <div class="row">
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
        <div class="ui info message">
          Veja abaixo os anúncios escolhidos por você para comparação
        </div> 
      </div>  
    </div>
    
    <div class="row">
        <div class="ten wide column">
            <table class="ui compact celled definition table" id="tabela">

                <thead>
                    <tr>
                        <th></th>
                        <th>Valor (R$)</th>                        
                        <th>Área (m<sup>2</sup>)</th>
                        <th>Quartos</th>
                        <th>Banheiros</th>
                        <th>Garagem</th>
                        <th>Tipo</th>
                        <th>Bairro</th>
                        <th>Condição</th>
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
                            <td class="collapsing">

                                <?php echo $anuncio['tituloanuncio'] ?>
                            </td>
                            <td id="spanValor<?php echo $anuncio['idanuncio']?>"><?php echo 'R$' . $anuncio['valormin'] ?></td>
                            <td>
                                <?php
                                echo minMax($anuncio, 'area') . 'm<sup>2</sup>';
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
                            <td>
                                <?php
                                if ($anuncio['tipo'] == 'apartamentoplanta') {
                                    echo 'Apartamento na Planta';
                                } else if ($anuncio['tipo'] == 'salacomercial') {
                                    echo 'Sala Comercial';
                                } else {
                                    echo ucfirst($anuncio['tipo']);
                                }
                                ?>
                            </td>
                            <td><?php echo $anuncio['bairro'] ?></td>
                            <td><?php echo ucfirst($anuncio['condicao']) ?></td>
                            <!--
                            <td>
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
                {"orderable": false, "targets": [8, 9]}
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


    })
</script>