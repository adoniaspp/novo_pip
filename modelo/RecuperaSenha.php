<?php

class RecuperaSenha {
    private $id;
    private $idusuario;
    private $hash;
    private $dataRecuperacao;
    private $dataAlteracao;
    private $status;

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    
    public function getIdusuario() {
        return $this->idusuario;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }
    
    public function getHash() {
        return $this->hash;
    }
    
    public function setDataRecuperacao($dataRecuperacao) {
        $this->dataRecuperacao = $dataRecuperacao;
    }
    
    public function getDataRecuperacao() {
        return $this->dataRecuperacao;
    }
    
    public function setDataAlteracao($dataAlteracao) {
        $this->dataAlteracao = $dataAlteracao;
    }
    
    public function getDataAlteracao() {
        return $this->dataAlteracao;
    }
    
    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function getStatus() {
        return $this->status;
    }
    function cadastrar($idusuario) {
        $recuperasenha = new RecuperaSenha();
        $recuperasenha->setIdusuario($idusuario);
        $recuperasenha->setHash(md5(uniqid(rand(), TRUE)));
        $recuperasenha->setDataRecuperacao(date('d/m/Y H:i:s'));
        $recuperasenha->setDataAlteracao("");
        $recuperasenha->setStatus("ativo");
        return $recuperasenha;
    }
    function editar(){
        $recuperasenha = new RecuperaSenha();
        $recuperasenha->setId($_SESSION["idRecuperaSenha"]);
        $recuperasenha->setDataAlteracao(date('d/m/Y H:i:s'));
        $recuperasenha->setStatus("utilizado");
        return $recuperasenha;
    }
}

