<?php

class HistoricoReativacao {

    private $id;
    private $idanuncio;
    private $idusuarioplano;
    private $status;
    private $datacadastro;
    private $dataexpiracaofinalizacao;
    private $datareativacao;
    
    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getIdusuarioplano() {
        return $this->idusuarioplano;
    }

    function getStatus() {
        return $this->status;
    }

    function getDatacadastro() {
        return $this->datacadastro;
    }

    function getDataexpiracaofinalizacao() {
        return $this->dataexpiracaofinalizacao;
    }

    function getDatareativacao() {
        return $this->datareativacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setIdusuarioplano($idusuarioplano) {
        $this->idusuarioplano = $idusuarioplano;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDatacadastro($datacadastro) {
        $this->datacadastro = $datacadastro;
    }

    function setDataexpiracaofinalizacao($dataexpiracaofinalizacao) {
        $this->dataexpiracaofinalizacao = $dataexpiracaofinalizacao;
    }

    function setDatareativacao($datareativacao) {
        $this->datareativacao = $datareativacao;
    }
}