<?php

class Denuncia{
    
    private $id;
    private $idanuncio;
    private $idusuario;
    private $idtipodenuncia;
    private $descricao;
    private $datahoracadastro;
    private $emaildenunciante;
    
    function getIdusuario() {
        return $this->idusuario;
    }

    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

        function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getIdtipodenuncia() {
        return $this->idtipodenuncia;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    function getEmaildenunciante() {
        return $this->emaildenunciante;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setIdtipodenuncia($idtipodenuncia) {
        $this->idtipodenuncia = $idtipodenuncia;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    function setEmaildenunciante($emailanunciante) {
        $this->emaildenunciante = $emailanunciante;
    }

    public function criarDenuncia($parametros){
        $denuncia = new Denuncia();
        $denuncia->setIdanuncio($parametros["hdnAnuncio"]);
        $denuncia->setIdusuario($parametros["hdnUsuario"]);
        $denuncia->setIdtipodenuncia($parametros["sltTipoDenuncia"]);
        $denuncia->setDescricao($parametros["txtMsgDenuncia"]);
        $denuncia->setEmaildenunciante($parametros["txtEmailDenuncia"]);
        $denuncia->setDatahoracadastro(date('Y-m-d H:i:s'));        
        return $denuncia;
    }
    
    
}
