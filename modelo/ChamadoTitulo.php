<?php

class ChamadoTitulo {
   
    private $id;
    private $idchamado;
    private $titulo;
    
    function getId() {
        return $this->id;
    }

    function getIdchamado() {
        return $this->idchamado;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdchamado($idchamado) {
        $this->idchamado = $idchamado;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function cadastrar($idChamado, $parametros){
        
        $this->setIdchamado($idChamado);
        $this->setTitulo($parametros['txtAssuntoChamado']);
        
        return $this;
    }
    
}
