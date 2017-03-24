<?php

class EmailAnuncio {
    private $id;
    private $hash;
    private $idanuncio;
    
    public function getId() {
        return $this->id;
    }

    public function getHash() {
        return $this->hash;
    }

    public function getIdanuncio() {
        return $this->idanuncio;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function cadastrar($idanuncio) {
        $emailanuncio = new EmailAnuncio();        
        $emailanuncio->setHash(md5(uniqid(rand(), TRUE)));
        $emailanuncio->setIdanuncio($idanuncio);
        return $emailanuncio;
    }

}

