<?php


class Apartamento {
    
    private $id;
    private $idimovel;
    private $condicao;
    private $quarto;
    private $suite;
    private $banheiro;
    private $garagem;
    private $area;
    private $sacada;
    private $unidadesandar;
    private $andar;
    private $condominio;
    private $cobertura;
    
    protected $imovel;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getCondicao() {
        return $this->condicao;
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

    function getUnidadesandar() {
        return $this->unidadesandar;
    }

    function getAndar() {
        return $this->andar;
    }

    function getCondominio() {
        return $this->condominio;
    }

    function getCobertura() {
        return $this->cobertura;
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

    function setCondicao($condicao) {
        $this->condicao = $condicao;
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

    function setUnidadesandar($unidadesandar) {
        $this->unidadesandar = $unidadesandar;
    }

    function setAndar($andar) {
        $this->andar = $andar;
    }

    function setCondominio($condominio) {
        $this->condominio = $condominio;
    }

    function setCobertura($cobertura) {
        $this->cobertura = $cobertura;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }
     
    function cadastrar($parametros, $idImovel) {

        $apartamento = new Apartamento();
        $apartamento->setIdimovel($idImovel);
        
        if($parametros["chkCobertura"] == "novo"){
            $apartamento->setCondicao($parametros["sltCondicao"]="NOVO");
        }else $apartamento->setCondicao($parametros["sltCondicao"]="USADO");
        
        $apartamento->setQuarto($parametros["sltQuarto"]);
        $apartamento->setBanheiro($parametros["sltBanheiro"]);
        $apartamento->setSuite($parametros["sltSuite"]);          
        $apartamento->setGaragem($parametros["sltGaragem"]);
        $apartamento->setArea($parametros["txtArea"]);
        $apartamento->setUnidadesandar($parametros["sltUnidadesAndar"]);
        $apartamento->setAndar($parametros["sltAndar"]);
        $apartamento->setCondominio($parametros["txtCondominio"]);
        
        if(!isset($parametros["chkCobertura"])){
            $apartamento->setCobertura($parametros["chkCobertura"]="");
        }else $apartamento->setCobertura($parametros["chkCobertura"]="SIM");
        
        if(!isset($parametros["chkSacada"])){
            $apartamento->setSacada($parametros["chkSacada"]="");
        }else $apartamento->setSacada($parametros["chkSacada"]="SIM");
        
        return $apartamento;
    }

}
