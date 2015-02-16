<?php

class PredioComercial {
    
    private $id;
    private $idimovel;
    private $area;
    
    protected $imovel;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getArea() {
        return $this->area;
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

    function setArea($area) {
        $this->area = $area;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }

    function cadastrar($parametros, $idImovel) {

        $predioComercial = new PredioComercial();
        $predioComercial->setIdimovel($idImovel);       
        $predioComercial->setArea($parametros["txtArea"]);
        
        return $predioComercial;
    }
}
