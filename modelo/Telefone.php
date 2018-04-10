<?php

class Telefone {

    private $id;
    private $tipotelefone;
    private $operadora;
    private $numero;
    private $whatsapp;
    private $idusuario;

    function getId() {
        return $this->id;
    }

    function getTipotelefone() {
        return $this->tipotelefone;
    }

    function getOperadora() {
        return $this->operadora;
    }

    function getNumero() {
        return $this->numero;
    }

    function getWhatsapp() {
        return $this->whatsapp;
    }

    function getIdusuario() {
        return $this->idusuario;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipotelefone($tipotelefone) {
        $this->tipotelefone = $tipotelefone;
    }

    function setOperadora($operadora) {
        $this->operadora = $operadora;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setWhatsapp($whatsapp) {
        $this->whatsapp = $whatsapp;
    }

    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function cadastrar($parametros, $idusuario, $indiceTelefone) {
        $telefone = new Telefone();
        $telefone->setIdusuario($idusuario);
        $telefone->setTipotelefone($parametros['hdnTipoTelefone'][$indiceTelefone]);
        $telefone->setNumero($parametros['hdnTelefone'][$indiceTelefone]);
        if ($parametros["hdnWhatsApp"][$indiceTelefone] == "SIM") {
            $telefone->setWhatsapp("SIM");
        } else {
            $telefone->setWhatsapp("NÃO");
        }
        $telefone->setOperadora($parametros['hdnOperadora'][$indiceTelefone]);
        return $telefone;
    }

}
