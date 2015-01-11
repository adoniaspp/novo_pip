<?php

class Plano {
    
    private $id;
    private $titulo;
    private $descricao;
    private $preco;
    private $status;
    private $validadeativacao;
    private $validadepublicacao;
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getValidadeativacao() {
        return $this->validadeativacao;
    }

    public function getValidadepublicacao() {
        return $this->validadepublicacao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setValidadeativacao($validadeativacao) {
        $this->validadeativacao = $validadeativacao;
    }

    public function setValidadepublicacao($validadepublicacao) {
        $this->validadepublicacao = $validadepublicacao;
    }

}
