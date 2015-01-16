<?php


class Anuncio {
   
    private $id;   
    private $idimovel;
    private $idusuarioplano;
    private $finalidade;
    private $tituloanuncio;
    private $descricaoanuncio;
    private $status;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $datahoradesativacao;
    private $valorvisivel;
    private $publicarmapa;
    private $publicarcontato;
    
    protected $imovel;
    protected $usuarioplano;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getIdusuarioplano() {
        return $this->idusuarioplano;
    }

    function getFinalidade() {
        return $this->finalidade;
    }

    function getTituloanuncio() {
        return $this->tituloanuncio;
    }

    function getDescricaoanuncio() {
        return $this->descricaoanuncio;
    }

    function getStatus() {
        return $this->status;
    }

    function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    function getDatahoradesativacao() {
        return $this->datahoradesativacao;
    }

    function getValorvisivel() {
        return $this->valorvisivel;
    }

    function getPublicarmapa() {
        return $this->publicarmapa;
    }

    function getPublicarcontato() {
        return $this->publicarcontato;
    }

    function getImovel() {
        return $this->imovel;
    }

    function getUsuarioplano() {
        return $this->usuarioplano;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    function setIdusuarioplano($idusuarioplano) {
        $this->idusuarioplano = $idusuarioplano;
    }

    function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }

    function setTituloanuncio($tituloanuncio) {
        $this->tituloanuncio = $tituloanuncio;
    }

    function setDescricaoanuncio($descricaoanuncio) {
        $this->descricaoanuncio = $descricaoanuncio;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    function setDatahoradesativacao($datahoradesativacao) {
        $this->datahoradesativacao = $datahoradesativacao;
    }

    function setValorvisivel($valorvisivel) {
        $this->valorvisivel = $valorvisivel;
    }

    function setPublicarmapa($publicarmapa) {
        $this->publicarmapa = $publicarmapa;
    }

    function setPublicarcontato($publicarcontato) {
        $this->publicarcontato = $publicarcontato;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }

    function setUsuarioplano($usuarioplano) {
        $this->usuarioplano = $usuarioplano;
    }
   
}
