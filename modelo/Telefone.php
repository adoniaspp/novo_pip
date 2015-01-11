<?php

class Telefone {

    private $id;
    private $tipotelefone;
    private $operadora;
    private $numero;
    private $idusuario;
    
    public function getId() {
        return $this->id;
    }

    public function getTipotelefone() {
        return $this->tipotelefone;
    }

    public function getOperadora() {
        return $this->operadora;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipotelefone($tipotelefone) {
        $this->tipotelefone = $tipotelefone;
    }

    public function setOperadora($operadora) {
        $this->operadora = $operadora;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    function cadastrar($parametros, $idusuario, $indiceTelefone){
        $telefone = new Telefone();
        $telefone->setIdusuario($idusuario);
        $telefone->setTipotelefone($parametros['hdnTipoTelefone'][$indiceTelefone]);
        $telefone->setNumero($parametros['hdnTelefone'][$indiceTelefone]);
        $telefone->setOperadora($parametros['hdnOperadora'][$indiceTelefone]);
        return $telefone;
    }
   
}
