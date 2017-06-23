<?php


class ValorAprovacao {
    
    private $id;
    private $idanuncioaprovacao;
    private $idplanta;
    private $andarinicial;
    private $andarfinal;
    private $valor;
    
    function getId() {
        return $this->id;
    }

    function getIdanuncioaprovacao() {
        return $this->idanuncioaprovacao;
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

    function setIdanuncioaprovacao($idanuncioaprovacao) {
        $this->idanuncioaprovacao = $idanuncioaprovacao;
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
    
}
