<?php


class ImovelDiferencial {
    
    private $id;
    private $idimovel;
    private $iddiferencial;
    
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getIddiferencial() {
        return $this->iddiferencial;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    function setIddiferencial($iddiferencial) {
        $this->iddiferencial = $iddiferencial;
    }

    function cadastrar($parametros, $idImovel, $indiceControle) {
        
        $ImovelDiferencial = new ImovelDiferencial();
        $ImovelDiferencial->setIdimovel($idImovel);
        $ImovelDiferencial->setIddiferencial($parametros["chkDiferencial"][$indiceControle]);
        return $ImovelDiferencial;
    }
    
}
