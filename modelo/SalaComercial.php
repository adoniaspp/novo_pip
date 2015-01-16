<?php


class SalaComercial {
    
    private $id;
    private $idimovel;
    private $banheiro;
    private $area;
    private $condominio;
    
    protected $imovel;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getBanheiro() {
        return $this->banheiro;
    }

    function getArea() {
        return $this->area;
    }

    function getCondominio() {
        return $this->condominio;
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

    function setBanheiro($banheiro) {
        $this->banheiro = $banheiro;
    }

    function setArea($area) {
        $this->area = $area;
    }

    function setCondominio($condominio) {
        $this->condominio = $condominio;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }

}
