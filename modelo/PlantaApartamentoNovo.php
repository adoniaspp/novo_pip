<?php

class PlantaApartamentoNovo {
   
    private $id;
    private $idimovel;
    private $quarto;
    private $suite;
    private $banheiro;
    private $garagem;
    private $area;
    private $identificacao;
    private $tituloplanta;
    private $andares;
    private $sacada;
    private $apeandar;
    
    protected $imovel;
    
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

    function getIdentificacao() {
        return $this->identificacao;
    }

    function getTituloplanta() {
        return $this->tituloplanta;
    }

    function getAndares() {
        return $this->andares;
    }

    function getSacada() {
        return $this->sacada;
    }

    function getApeandar() {
        return $this->apeandar;
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

    function setIdentificacao($identificacao) {
        $this->identificacao = $identificacao;
    }

    function setTituloplanta($tituloplanta) {
        $this->tituloplanta = $tituloplanta;
    }

    function setAndares($andares) {
        $this->andares = $andares;
    }

    function setSacada($sacada) {
        $this->sacada = $sacada;
    }

    function setApeandar($apeandar) {
        $this->apeandar = $apeandar;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }
 
}
