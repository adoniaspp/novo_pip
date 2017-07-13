<?php


class SalaComercial {
    
    private $id;
    private $idimovel;
    private $banheiro;
    private $garagem;
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

    function getGaragem() {
        return $this->garagem;
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

    function setGaragem($garagem) {
        $this->garagem = $garagem;
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

        function cadastrar($parametros, $idImovel) {

        $salaComercial = new SalaComercial();
        $salaComercial->setIdimovel($idImovel);       
        $salaComercial->setBanheiro($parametros["sltBanheiro"]);   
        $salaComercial->setGaragem($parametros["sltGaragem"]);
        $salaComercial->setArea($parametros["txtArea"]);
        $novoCondominio = str_replace("R$ ", "",$parametros["txtCondominio"]);
        $salaComercial->setCondominio($novoCondominio);
   
        return $salaComercial;
    }
    
    function editar($parametros, $idSalaComercial) {

        $salaComercial = new SalaComercial();
        $salaComercial->setId($idSalaComercial);
        $salaComercial->setIdimovel($_SESSION["imovel"]["id"]);
        $salaComercial->setBanheiro($parametros["sltBanheiro"]);        
        $salaComercial->setGaragem($parametros["sltGaragem"]);
        $salaComercial->setArea($parametros["txtArea"]);
        $novoCondominio = str_replace("R$ ", "",$parametros["txtCondominio"]); 
        $salaComercial->setCondominio($novoCondominio);
        
        return $salaComercial;
    }
    
}
