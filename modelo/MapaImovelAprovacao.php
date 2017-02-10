<?php

class MapaImovelAprovacao {
    
    private $id;
    private $idanuncioaprovacao;
    private $latitude;
    private $longitude;
    
    function getId() {
        return $this->id;
    }

    function getIdanuncioaprovacao() {
        return $this->idanuncioaprovacao;
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

    function setIdanuncioaprovacao($idanuncioaprovacao) {
        $this->idanuncioaprovacao = $idanuncioaprovacao;
    }

    function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    function cadastrar($parametros, $idAnuncio){
        $this->setIdanuncioaprovacao($idAnuncio);
        $this->setLatitude($parametros["hdnLatitude"]);
        $this->setLongitude($parametros["hdnLongitude"]);
    }
    
}
