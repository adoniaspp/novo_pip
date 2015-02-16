<?php


class Planta {
   
    private $id;
    private $idapartamentoplanta;
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

    function getApartamentoplanta() {
        return $this->apartamentoplanta;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdapartamentoplanta($idapartamentoplanta) {
        $this->idapartamentoplanta = $idapartamentoplanta;
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

    function setApartamentoplanta($apartamentoplanta) {
        $this->apartamentoplanta = $apartamentoplanta;
    }

            
    function cadastrar($parametros, $idApartamentoPlanta, $indiceControle) {

        $planta = new Planta();
        $planta->setIdapartamentoplanta($idApartamentoPlanta);
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
