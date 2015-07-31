<link rel="stylesheet" type="text/css" href="assets/libs/datatables/css/jquery.dataTables.min.css">
<script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>

<?php
$item = $this->getItem();
//echo "<pre>";
//        print_r($item[0]);
//        die();
//
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
                        <th>Tipo</th>
                        <th>Bairro</th>
                        <th>Condição</th>
                        <th>Área</th>
                        <th>Quartos</th>
                        <th>Banheiros</th>
                        <th>Garagem</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($item as $anuncio) {
                        ?>
                        <tr>
                            <td class="collapsing">
                                <button class="ui icon button">
                                    <i class="remove icon"> </i> 
                                </button>
                                <?php echo $anuncio['tituloanuncio'] ?>
                            </td>
                            <td><?php echo 'R$' . $anuncio['valormin'] ?></td>
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
                                echo minMax($anuncio, 'area') . 'm<sup>2</sup>';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo minMax($anuncio, 'quarto') . ' quarto(s)';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo minMax($anuncio, 'banheiro') . ' banheiro(s)';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo minMax($anuncio, 'garagem') . ' vaga(s)';
                                ?>
                            </td>
                            <td>
                                NO
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>       
        </div>
        <div class="three wide column"></div>
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
        $('#tabela').DataTable({
            "language": {
                "url": "assets/libs/datatables/js/Portuguese-Brasil.json",
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "stateSave": true,
            "columnDefs": [
                {"orderable": false, "targets": 3}
            ]
        });
    })
</script>