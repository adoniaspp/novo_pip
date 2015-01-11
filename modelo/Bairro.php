<?php

class Bairro {

    private $id;
    private $idcidade;
    private $nome;
    protected $cidade;

    public function getId() {
        return $this->id;
    }

    public function getIdcidade() {
        return $this->idcidade;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdcidade($idcidade) {
        $this->idcidade = $idcidade;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function cadastrar($parametros, $idcidade) {
        $bairro = new Bairro();
        $bairro->setIdcidade($idcidade);
        $bairro->setNome($parametros['txtBairro']);
        return $bairro;
     }
    
}
