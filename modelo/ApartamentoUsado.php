<?php


class ApartamentoUsado {
    
    private $id;
    private $idimovel;
    private $quarto;
    private $suite;
    private $banheiro;
    private $garagem;
    private $area;
    private $sacada;
    private $andares;
    private $andar;
    private $cobertura;
    
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

    function getSacada() {
        return $this->sacada;
    }

    function getAndar() {
        return $this->andar;
    }

    function getCobertura() {
        return $this->cobertura;
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

    function setSacada($sacada) {
        $this->sacada = $sacada;
    }

    function setAndar($andar) {
        $this->andar = $andar;
    }
    function getAndares() {
        return $this->andares;
    }

    function setAndares($andares) {
        $this->andares = $andares;
    }

    function setCobertura($cobertura) {
        $this->cobertura = $cobertura;
    }
    
    function getImovel() {
        return $this->imovel;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }
    
    function cadastrar($parametros, $idImovel) {
        /*echo "<pre>";
        print_r($parametros);
        die();*/
        $apeusado = new ApartamentoUsado();
        $apeusado->setIdimovel($idImovel);
        $apeusado->setQuarto($parametros["sltQuarto"]);
        $apeusado->setBanheiro($parametros["sltBanheiro"]);
        $apeusado->setSuite($parametros["sltSuite"]);          
        $apeusado->setGaragem($parametros["sltGaragem"]);
        $apeusado->setArea($parametros["txtArea"]);
        $apeusado->setAndares($parametros["sltAndares"]);
        $apeusado->setAndar($parametros["sltAndar"]);
        
        if(!isset($parametros["chkCobertura"])){
            $apeusado->setCobertura($parametros["chkCobertura"]="");
        }else $apeusado->setCobertura($parametros["chkCobertura"]="SIM");
        
        if(!isset($parametros["chkSacada"])){
            $apeusado->setSacada($parametros["chkSacada"]="");
        }else $apeusado->setSacada($parametros["chkSacada"]="SIM");
        
        return $apeusado;
    }

}
