<?php

class ApartamentoPlanta {
   
    private $id;
    private $idimovel;
    private $andares;
    private $unidadesandar;
    private $totalunidades;
    private $numerotorres;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
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

    function setId($id) {
        $this->id = $id;
    }

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
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
     
    function cadastrar($parametros, $idimovel) {
        $apartamentoPlanta = new ApartamentoPlanta();
        $apartamentoPlanta->setIdimovel($idimovel);
        $apartamentoPlanta->setAndares($parametros["sltAndares"]);
        $apartamentoPlanta->setNumerotorres($parametros["sltNumeroTorres"]);          
        $apartamentoPlanta->setTotalunidades($parametros["txtTotalUnidades"]);
        $apartamentoPlanta->setUnidadesandar($parametros["sltUnidadesAndar"]);
        return $apartamentoPlanta;
        
    }
}
