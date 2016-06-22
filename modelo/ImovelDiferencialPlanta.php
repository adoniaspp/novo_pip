<?php

class ImovelDiferencialPlanta {
    
    private $id;
    private $idplanta;
    private $iddiferencial;
    
    protected $diferencial;
    
    function getId() {
        return $this->id;
    }

    function getIdplanta() {
        return $this->idplanta;
    }

    function getIddiferencial() {
        return $this->iddiferencial;
    }

    function getDiferencial() {
        return $this->diferencial;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdplanta($idplanta) {
        $this->idplanta = $idplanta;
    }

    function setIddiferencial($iddiferencial) {
        $this->iddiferencial = $iddiferencial;
    }

    function setDiferencial($diferencial) {
        $this->diferencial = $diferencial;
    }

    function cadastrar($idPlanta, $parametro) {
        
        $imovelDiferencialPlanta = new ImovelDiferencialPlanta();
        $imovelDiferencialPlanta->setIdplanta($idPlanta);
        $imovelDiferencialPlanta->setIddiferencial($parametro);
        return $imovelDiferencialPlanta;
    }
    
    function excluir($id) {
        
        $ImovelDiferencialPlanta = new ImovelDiferencialPlanta();
        $ImovelDiferencialPlanta->setId($id);
        return $ImovelDiferencialPlanta;

    }
    
}
