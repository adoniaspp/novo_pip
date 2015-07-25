<?php


class Valor {
    
    private $id;
    private $idanuncio;
    private $idplantaapartamentonovo;
    private $andarinicial;
    private $andarfinal;
    private $valor;
    
    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getIdplantaapartamentonovo() {
        return $this->idplantaapartamentonovo;
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

    function setIdplantaapartamentonovo($idplantaapartamentonovo) {
        $this->idplantaapartamentonovo = $idplantaapartamentonovo;
    }

    function setAndarinicial($andarinicial) {
        $this->andarinicial = $andarinicial;
    }

    function setAndarfinal($andarfinal) {
        $this->andarfinal = $andarfinal;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }
    
}
