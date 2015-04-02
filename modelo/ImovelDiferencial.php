<?php


class ImovelDiferencial {
    
    private $id;
    private $idimovel;
    private $iddiferencial;
    
    protected $diferencial;
            
    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
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

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    function setIddiferencial($iddiferencial) {
        $this->iddiferencial = $iddiferencial;
    }

    function setDiferencial($diferencial) {
        $this->diferencial = $diferencial;
    }

    
    function cadastrar($parametros, $idImovel, $indiceControle) {
        
        $ImovelDiferencial = new ImovelDiferencial();
        $ImovelDiferencial->setIdimovel($idImovel);
        $ImovelDiferencial->setIddiferencial($parametros["chkDiferencial"][$indiceControle]);
        return $ImovelDiferencial;
    }
    
    function excluir($id) {
        
        //echo "ID: ".$id;
        $ImovelDiferencial = new ImovelDiferencial();
        $ImovelDiferencial->setId($id);
        //$ImovelDiferencial->setIdimovel($idImovel);
        //$ImovelDiferencial->setIddiferencial($parametros["chkDiferencial"][$indiceControle]);
        return $ImovelDiferencial;

    }
    
}
