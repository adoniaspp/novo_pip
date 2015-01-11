<?php

class Estado {

    private $id;
    private $uf;

    public function getId() {
        return $this->id;
    }

    public function getUf() {
        return $this->uf;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }
    
     function cadastrar($parametros) {
        $estado = new Estado();
        $estado->setUf($parametros['txtEstado']);
        return $estado;
     }

}
