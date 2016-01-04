<?php


class NovoValorAnuncio {
   
    private $id;
    private $idanuncio;
    private $novovalor;
    private $datahoracadastro;
    private $datahorainativacao;
    private $status;
 
    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getNovovalor() {
        return $this->novovalor;
    }

    function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    function getDatahorainativacao() {
        return $this->datahorainativacao;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setNovovalor($novovalor) {
        $this->novovalor = $novovalor;
    }

    function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    function setDatahorainativacao($datahorainativacao) {
        $this->datahorainativacao = $datahorainativacao;
    }

    function setStatus($status) {
        $this->status = $status;
    }

        public function cadastrar($parametros){
        
        $novoValor = new NovoValorAnuncio();
        
        $novoValor->setIdanuncio($parametros["hdnAnuncio"]);
        $novoValor->setNovovalor($parametros["txtNovoValor"]);
        $novoValor->setDatahoracadastro(date("Y/m/d H:i:s"));
        $novoValor->setDatahorainativacao("");
        $novoValor->setStatus("ativo");
        
        return $novoValor;
        
    }
    
    public function inativarValor($objeto){
        
        //$objeto->setId($parametros["id"]);
        $objeto->setDatahorainativacao(date("Y/m/d H:i:s"));
        $objeto->setStatus("inativo");
        
        return $objeto;
        
    }
    
}
