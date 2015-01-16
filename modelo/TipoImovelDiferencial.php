<?php


class TipoImovelDiferencial {
    
    private $idtipoimovel;
    private $iddiferencial;
    
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

}
