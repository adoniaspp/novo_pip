<?php

class MapaImovel {
    
    private $id;
    private $idanuncio;
    private $latitude;
    private $longitude;
    
    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getLatitude() {
        return $this->latitude;
    }

    function getLongitude() {
        return $this->longitude;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    function cadastrar($parametros, $idAnuncio){
        
        $mapaImovel = new MapaImovel();
        
        $mapaImovel->setIdanuncio($idAnuncio);
        $mapaImovel->setLatitude($parametros["hdnLatitude"]);
        $mapaImovel->setLongitude($parametros["hdnLongitude"]);
        
        return $mapaImovel;
                
    }
    
}
