<?php

class Estado {

    private $id;
    private $uf;
    private $nome;

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

    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function cadastrar($parametros) {
        
        if($parametros['txtEstado'] == ""){
            $estado->setUf("");
        } else $estado->setUf($parametros['txtEstado']);
        
        if($parametros['txtNome'] == ""){
            $estado->setNome("");
        } else $estado->setNome($parametros['txtNome']);

    }

}
