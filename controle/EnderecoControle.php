<?php

include_once 'modelo/Endereco.php';
include_once 'DAO/GenericoDAO.php';

class EnderecoControle {

    function buscarCEP($parametros) {
        require_once 'configuracao/CEP.php';
        $cep = new CEP($parametros['cep']);
        $resultado = $cep->buscar();
        //var_dump($resultado);
        if (is_array($resultado)) {
            $resultado['resultado'] = '1';
            echo json_encode($resultado);
        }
        else
            echo json_encode(array('resultado' => '0', 'error' => $cep->getErro()));
    }

}
