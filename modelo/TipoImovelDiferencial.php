<?php


class TipoImovelDiferencial {
    
    private $idtipoimovel;
    private $iddiferencial;
    
    protected $diferencial;
    
    function getIdtipoimovel() {
        return $this->idtipoimovel;
    }

    function getIddiferencial() {
        return $this->iddiferencial;
    }

    function setIdtipoimovel($idtipoimovel) {
        $this->idtipoimovel = $idtipoimovel;
    }

    function setIddiferencial($iddiferencial) {
        $this->iddiferencial = $iddiferencial;
    }
    
    function getDiferencial() {
        return $this->diferencial;
    }

    function setDiferencial($diferencial) {
        $this->diferencial = $diferencial;
    }   
    
}
