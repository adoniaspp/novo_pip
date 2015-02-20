<?php


class Terreno {
    
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

        $terreno = new Terreno();
        $terreno->setIdimovel($idImovel);       
        $terreno->setArea($parametros["txtArea"]);
        
        return $terreno;
    }
    
    function editar($parametros, $idTerreno) {
        
        
      /*  echo "<pre>";
        var_dump($parametros);
        echo "</pre>";*/
        
        $terreno = new Terreno();
        $terreno->setId($idTerreno);
        $terreno->setIdimovel($_SESSION["imovel"]["id"]);
        $terreno->setArea($parametros["txtArea"]);
        return $terreno;
    }
    
}
