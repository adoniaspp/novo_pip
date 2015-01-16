<?php

class Imovel {

    private $id;
    private $idtipoimovel;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $idusuario;
    private $idendereco;
    private $condicao;
    private $identificacao;
    protected $endereco;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdtipoimovel() {
        return $this->idtipoimovel;
    }

    public function setIdtipoimovel($idtipoimovel) {
        $this->idtipoimovel = $idtipoimovel;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getIdendereco() {
        return $this->idendereco;
    }

    public function setIdendereco($idendereco) {
        $this->idendereco = $idendereco;
    }

    public function getCondicao() {
        return $this->condicao;
    }

    public function setCondicao($condicao) {
        $this->condicao = $condicao;
    }

    public function getIdentificacao() {
        return $this->identificacao;
    }

    public function setIdentificacao($identificacao) {
        $this->identificacao = $identificacao;
    }
    
    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }
    
    public function Referencia() {
        return substr($this->getDatahoracadastro(), 6, -9) . substr($this->getDatahoracadastro(), 3, -14) . str_pad($this->getId(), 5, "0", STR_PAD_LEFT);
    }

    function cadastrar($parametros, $idendereco) {
        $this->setDatahoraalteracao(NULL);
        $this->setDatahoracadastro(date("Y/m/d H:i:s"));
        $this->setIdendereco($idendereco);
        $this->setIdentificacao($parametros['txtIdentificacao']);
        $this->setIdtipoimovel($parametros['sltTipoImovel']);
        $this->setIdusuario($_SESSION["idusuario"]);
        switch ($parametros['sltTipoImovel']) {
            case 1:
            case 2:
            case 3:
                $this->setCondicao($parametros['sltTipoImovel']);
                break;
            default:
                $this->setCondicao(NULL);
                break;
        }
    }

    function editar($parametros) {
        $this->setDatahoraalteracao(date("Y/m/d H:i:s"));
        $this->setDatahoracadastro(NULL);
        $this->setIdendereco($_SESSION["imovel"]["idendereco"]);
        $this->setIdentificacao($parametros['txtIdentificacao']);
        $this->setIdtipoimovel($parametros['sltTipoImovel']);
        $this->setIdusuario($_SESSION["idusuario"]);
        switch ($parametros['sltTipoImovel']) {
            case 1:
            case 2:
            case 3:
                $this->setCondicao($parametros['sltTipoImovel']);
                break;
            default:
                $this->setCondicao(NULL);
                break;
        }
    }
}

