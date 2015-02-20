<?php

class Casa {
    
    private $id;
    private $idimovel;
    private $quarto;
    private $suite;
    private $banheiro;
    private $garagem;
    private $area;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getQuarto() {
        return $this->quarto;
    }

    function getSuite() {
        return $this->suite;
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

    function setId($id) {
        $this->id = $id;
    }

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    function setQuarto($quarto) {
        $this->quarto = $quarto;
    }

    function setSuite($suite) {
        $this->suite = $suite;
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
    
    function cadastrar($parametros, $idimovel) {
        $casa = new Casa();
        $casa->setIdimovel($idimovel);
        $casa->setQuarto($parametros["sltQuarto"]);
        $casa->setBanheiro($parametros["sltBanheiro"]);
        $casa->setSuite($parametros["sltSuite"]);          
        $casa->setGaragem($parametros["sltGaragem"]);
        $casa->setArea($parametros["txtArea"]);
        return $casa;
    }
    
    function editar($parametros, $idCasa) {
        
        
      /*  echo "<pre>";
        var_dump($parametros);
        echo "</pre>";*/
        
        $casa = new Casa();
        $casa->setId($idCasa);
        $casa->setIdimovel($_SESSION["imovel"]["id"]);
        $casa->setQuarto($parametros["sltQuarto"]);
        $casa->setBanheiro($parametros["sltBanheiro"]);
        $casa->setSuite($parametros["sltSuite"]);          
        $casa->setGaragem($parametros["sltGaragem"]);
        $casa->setArea($parametros["txtArea"]);
        return $casa;
    }
    
}
