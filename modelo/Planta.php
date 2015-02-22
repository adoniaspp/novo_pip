<?php


class Planta {
   
    private $id;
    private $idapartamentoplanta;
    private $idimovel;
    private $ordemplantas;
    private $tituloplanta;
    private $quarto;
    private $banheiro;
    private $suite;
    private $garagem;
    private $area;
    
    function getId() {
        return $this->id;
    }

    function getIdapartamentoplanta() {
        return $this->idapartamentoplanta;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getOrdemplantas() {
        return $this->ordemplantas;
    }

    function getTituloplanta() {
        return $this->tituloplanta;
    }

    function getQuarto() {
        return $this->quarto;
    }

    function getBanheiro() {
        return $this->banheiro;
    }

    function getSuite() {
        return $this->suite;
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

    function setIdapartamentoplanta($idapartamentoplanta) {
        $this->idapartamentoplanta = $idapartamentoplanta;
    }

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    function setOrdemplantas($ordemplantas) {
        $this->ordemplantas = $ordemplantas;
    }

    function setTituloplanta($tituloplanta) {
        $this->tituloplanta = $tituloplanta;
    }

    function setQuarto($quarto) {
        $this->quarto = $quarto;
    }

    function setBanheiro($banheiro) {
        $this->banheiro = $banheiro;
    }

    function setSuite($suite) {
        $this->suite = $suite;
    }

    function setGaragem($garagem) {
        $this->garagem = $garagem;
    }

    function setArea($area) {
        $this->area = $area;
    }

                
    function cadastrar($parametros, $idApartamentoPlanta, $idimovel, $indiceControle) {

        $planta = new Planta();
        $planta->setIdapartamentoplanta($idApartamentoPlanta);
        $planta->setIdimovel($idimovel);
        $planta->setOrdemplantas($indiceControle);
        $planta->setTituloplanta($parametros["txtPlanta"][$indiceControle]);
        $planta->setQuarto($parametros["sltQuarto"][$indiceControle]);
        $planta->setBanheiro($parametros["sltBanheiro"][$indiceControle]);
        $planta->setSuite($parametros["sltSuite"][$indiceControle]);          
        $planta->setGaragem($parametros["sltGaragem"][$indiceControle]);
        $planta->setArea($parametros["txtArea"][$indiceControle]);
        return $planta;
        
    }
    
}
