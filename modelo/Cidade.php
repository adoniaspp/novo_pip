<?php

class Cidade {

    private $id;
    private $nome;
    private $idestado;
    protected $estado;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getIdestado() {
        return $this->idestado;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setIdestado($idestado) {
        $this->idestado = $idestado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
    
    function cadastrar($parametros, $idestado) {
        $cidade = new Cidade();
        $cidade->setIdestado($idestado);
        $cidade->setNome($parametros['txtCidade']);
        return $cidade;
     }

}
