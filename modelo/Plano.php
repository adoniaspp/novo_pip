<?php

class Plano {
    
    private $id;
    private $titulo;
    private $descricao;
    private $preco;
    private $tipo; //PF ou PJ
    private $status;
    private $validadeativacao;
    private $validadepublicacao;
    private $maximoimagens;
    
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getPreco() {
        return $this->preco;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getStatus() {
        return $this->status;
    }

    function getValidadeativacao() {
        return $this->validadeativacao;
    }

    function getValidadepublicacao() {
        return $this->validadepublicacao;
    }

    function getMaximoimagens() {
        return $this->maximoimagens;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setPreco($preco) {
        $this->preco = $preco;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setValidadeativacao($validadeativacao) {
        $this->validadeativacao = $validadeativacao;
    }

    function setValidadepublicacao($validadepublicacao) {
        $this->validadepublicacao = $validadepublicacao;
    }

    function setMaximoimagens($maximoimagens) {
        $this->maximoimagens = $maximoimagens;
    }

}
