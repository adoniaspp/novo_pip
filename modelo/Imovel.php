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
    protected $anuncio;
    protected $endereco;
    protected $casa;
    protected $apartamento;
    protected $apartamentoplanta;
    protected $salacomercial;
    protected $prediocomercial;
    protected $terreno;
    
    function getId() {
        return $this->id;
    }

    function getIdtipoimovel() {
        return $this->idtipoimovel;
    }

    function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    function getIdusuario() {
        return $this->idusuario;
    }

    function getIdendereco() {
        return $this->idendereco;
    }

    function getCondicao() {
        return $this->condicao;
    }

    function getIdentificacao() {
        return $this->identificacao;
    }

    function getAnuncio() {
        return $this->anuncio;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getCasa() {
        return $this->casa;
    }

    function getApartamento() {
        return $this->apartamento;
    }

    function getApartamentoplanta() {
        return $this->apartamentoplanta;
    }

    function getSalacomercial() {
        return $this->salacomercial;
    }

    function getPrediocomercial() {
        return $this->prediocomercial;
    }

    function getTerreno() {
        return $this->terreno;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdtipoimovel($idtipoimovel) {
        $this->idtipoimovel = $idtipoimovel;
    }

    function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function setIdendereco($idendereco) {
        $this->idendereco = $idendereco;
    }

    function setCondicao($condicao) {
        $this->condicao = $condicao;
    }

    function setIdentificacao($identificacao) {
        $this->identificacao = $identificacao;
    }

    function setAnuncio($anuncio) {
        $this->anuncio = $anuncio;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setCasa($casa) {
        $this->casa = $casa;
    }

    function setApartamento($apartamento) {
        $this->apartamento = $apartamento;
    }

    function setApartamentoplanta($apartamentoplanta) {
        $this->apartamentoplanta = $apartamentoplanta;
    }

    function setSalacomercial($salacomercial) {
        $this->salacomercial = $salacomercial;
    }

    function setPrediocomercial($prediocomercial) {
        $this->prediocomercial = $prediocomercial;
    }

    function setTerreno($terreno) {
        $this->terreno = $terreno;
    }

    public function Referencia() {
        return substr($this->getDatahoracadastro(), 6, -9) . substr($this->getDatahoracadastro(), 3, -14) . str_pad($this->getId(), 5, "0", STR_PAD_LEFT);
    }
    
    function buscarTipoImovel($tipo){
        switch ($tipo) {
                        case "1":
                        return  "<td> CASA </td>";
                        break;
                        case "2":
                        return "<td> APARTAMENTO NA PLANTA </td>";
                        break;
                        case "3":
                        return "<td> APARTAMENTO </td>";
                        break;
                        case "4": 
                        return "<td> SALA COMERCIAL </td>";
                        break;
                        case "5":
                        return "<td> PRÉDIO COMERCIAL </td>";
                        break;
                        case "6":
                        return "<td> TERRENO </td>";
                        break;
                        }
    }
    
    function cadastrar($parametros, $idendereco) {
        $imovel = new Imovel();
        $imovel->setIdtipoimovel($parametros['sltTipo']);  
        $imovel->setDatahoraalteracao("");
        $imovel->setDatahoracadastro(date("Y/m/d H:i:s"));
        $imovel->setIdendereco($idendereco);          
        $imovel->setIdusuario($_SESSION["idusuario"]);       
        
        if($parametros['sltTipo']=="2" || $parametros['sltTipo']=="5" || $parametros['sltTipo']=="6"){ //apartamento na planta, prédio comercial ou terreno não possuem condição
            $imovel->setCondicao("nenhuma");}
            else $imovel->setCondicao($parametros['sltCondicao']);
       
        $imovel->setIdentificacao($parametros['txtIdentificacao']);
        return $imovel;
    }

    function editar($parametros) {
        /*echo "<pre>";
        var_dump($_SESSION);
        echo "</pre>";*/

        $imovel = new Imovel();
        $imovel->setId($_SESSION["imovel"]["id"]);
        $imovel->setIdtipoimovel($parametros['sltTipo']);
        $imovel->setDatahoraalteracao(date("Y/m/d H:i:s"));
        if($parametros['sltTipo']=="2" || $parametros['sltTipo']=="5" || $parametros['sltTipo']=="6"){ //apartamento na planta, prédio comercial ou terreno não possuem condição
            $imovel->setCondicao("nenhuma");}
            else $imovel->setCondicao($parametros['sltCondicao']);
        $imovel->setIdentificacao($parametros['txtIdentificacao']);
        return $imovel;
    }
}

