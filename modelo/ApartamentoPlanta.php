<?php

class ApartamentoPlanta {
   
    private $id;
    private $idimovel;
    private $identificacao;
    private $andares;
    private $unidadesandar;
    private $totalunidades;
    private $numerotorres;
    
    protected $imovel;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getIdentificacao() {
        return $this->identificacao;
    }

    function getAndares() {
        return $this->andares;
    }

    function getUnidadesandar() {
        return $this->unidadesandar;
    }

    function getTotalunidades() {
        return $this->totalunidades;
    }

    function getNumerotorres() {
        return $this->numerotorres;
    }

    function getImovel() {
        return $this->imovel;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    function setIdentificacao($identificacao) {
        $this->identificacao = $identificacao;
    }

    function setAndares($andares) {
        $this->andares = $andares;
    }

    function setUnidadesandar($unidadesandar) {
        $this->unidadesandar = $unidadesandar;
    }

    function setTotalunidades($totalunidades) {
        $this->totalunidades = $totalunidades;
    }

    function setNumerotorres($numerotorres) {
        $this->numerotorres = $numerotorres;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }
    
    function cadastrar($parametros, $idimovel) {
        $apartamentoPlanta = new ApartamentoPlanta();
        $apartamentoPlanta->setIdimovel($idimovel);
        $apartamentoPlanta->setIdentificacao($parametros["txtIdentificacao"]);
        $apartamentoPlanta->setAndares($parametros["sltAndares"]);
        $apartamentoPlanta->setNumerotorres($parametros["sltNumeroTorres"]);          
        $apartamentoPlanta->setTotalunidades($parametros["txtTotalUnidades"]);
        $apartamentoPlanta->setUnidadesandar($parametros["sltUnidadesAndar"]);
        return $apartamentoPlanta;
        
    }
}
