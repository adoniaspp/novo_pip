<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/libs/lightbox/lightbox.css">
<script src="assets/libs/lightbox/lightbox.min.js"></script>
<script src="assets/js/imagemComparar.js"></script>

<?php
$item = $this->getItem();
?>     

<div class="container">

    <div class="ui three column padded grid">
        <div class="two wide column"></div>
        <div class="ten wide column">
            <table class="ui compact celled definition table" id="tabela">

                <thead>
                    <tr>
                        <th></th>
                        <th>Valor</th>                        
                        <th>Área</th>
                        <th>Quartos</th>
                        <th>Banheiros</th>
                        <th>Garagem</th>
                        <th>Tipo</th>
                        <th>Bairro</th>
                        <th>Condição</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($item as $anuncio) {
                        ?>
                        <tr>
                            <td class="collapsing">

                                <?php echo $anuncio['tituloanuncio'] ?>
                            </td>
                            <td><?php echo 'R$' . $anuncio['valormin'] ?></td>
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

                            <td>
                                <?php
                                if ($anuncio['imagem']) {
                                    foreach ($anuncio['imagem'] as $imagem) {
                                        if ($imagem['destaque'] == 'SIM') {
                                            ?>
                                            <a href="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>" data-lightbox="image-1" data-title="My caption" >
                                                <img style="height:80px; width: 100px;" src="<?php echo PIPURL . '/fotos/imoveis/' . $imagem['diretorio'] . '/' . $imagem['nome'] ?>">
                                            </a>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <a href="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>" data-lightbox="image-1" data-title="My caption" >
                                        <img style="height:80px; width: 100px;" src="<?php echo PIPURL . "/assets/imagens/foto_padrao.png" ?>">
                                    </a>
                                    <?php }
                                ?>
                            </td>
                        </tr>
<?php } ?>

                </tbody>

            </table>       
        </div>

    </div>   

    <br>
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
                {"orderable": false, "targets": [6, 7, 8, 9]}
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