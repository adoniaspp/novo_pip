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
        $estado->setUf($parametros['txtEstado']);
        $estado->setNome($parametros['txtNome']);
    }

}
