<?php

include_once 'modelo/Preferencia.php';
include_once 'DAO/GenericoDAO.php';

class PreferenciaControle{
    function inserir($parametros, $pip = NULL){
        $preferencia = new Preferencia();
        $preferenciaobj = $preferencia->cadastrar($parametros);
        $genericoDAO = new GenericoDAO();
        $selecionarPreferencia = $genericoDAO->cadastrar($preferenciaobj);
        return $selecionarPreferencia;
    }
}

