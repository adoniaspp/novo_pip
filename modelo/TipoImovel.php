<?php


class TipoImovel {
    
    private $id;
    private $descricao;
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function retornaDescricaoTipo($parametro){
        
        switch ($parametro){
            case 1: return "casa"; break;
            case 2: return "apartamento"; break;
            case 3: return "apartamentoplanta"; break;
            case 4: return "salacomercial"; break;
            case 5: return "prediocomercial"; break;
            case 6: return "terreno"; break;
        }
        
    }
    
}
