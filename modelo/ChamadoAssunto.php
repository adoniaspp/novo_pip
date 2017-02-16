<?php

class ChamadoAssunto {
    
    private $id;
    private $idtipo;
    private $idassunto;
    private $assunto;
    
    function getId() {
        return $this->id;
    }

    function getIdtipo() {
        return $this->idtipo;
    }

    function getIdassunto() {
        return $this->idassunto;
    }

    function getAssunto() {
        return $this->assunto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdtipo($idtipo) {
        $this->idtipo = $idtipo;
    }

    function setIdassunto($idassunto) {
        $this->idassunto = $idassunto;
    }

    function setAssunto($assunto) {
        $this->assunto = $assunto;
    }
    
}
