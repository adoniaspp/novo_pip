<?php

class Preferencia{
    
    private $id;
    private $idanuncio;
    
    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }
    
    function cadastrar($parametros){
        $preferencia = new Preferencia();
        $preferencia->setIdanuncio($parametros['anuncio'][0]['idanuncio']);
        return $preferencia; 
    }
}
