<?php


class Valor {
    
    private $id;
    private $idanuncio;
    private $idplanta;
    private $andarinicial;
    private $andarfinal;
    private $valor;
    
    protected $planta;
            
    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getIdplanta() {
        return $this->idplanta;
    }

    function getAndarinicial() {
        return $this->andarinicial;
    }

    function getAndarfinal() {
        return $this->andarfinal;
    }

    function getValor() {
        return $this->valor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setIdplanta($idplanta) {
        $this->idplanta = $idplanta;
    }

    function setAndarinicial($andarinicial) {
        $this->andarinicial = $andarinicial;
    }

    function setAndarfinal($andarfinal) {
        $this->andarfinal = $andarfinal;
    }

    function setValor($valor) {
         $this->valor = $this->limpaValorNumerico($valor);
    }
    
    private function limpaValorNumerico($valor) {
        $valor = str_replace("R$", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        $valor = trim($valor);
        return $valor;
    }
    
    function getPlanta() {
        return $this->planta;
    }

    function setPlanta($planta) {
        $this->planta = $planta;
    }


    
}
