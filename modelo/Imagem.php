<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Imagem
 *
 * @author Simon
 */
class Imagem {

    private $id;
    private $idanuncio;
    private $diretorio;
    private $legenda;
    private $destaque;
    private $nome;
    private $tipo;
    private $tamanho;

    public function getDestaque() {
        return $this->destaque;
    }

    public function setDestaque($destaque) {
        $this->destaque = $destaque;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdanuncio() {
        return $this->idanuncio;
    }

    public function getDiretorio() {
        return $this->diretorio;
    }

    public function getLegenda() {
        return $this->legenda;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    public function setDiretorio($diretorio) {
        $this->diretorio = $diretorio;
    }

    public function setLegenda($legenda) {
        $this->legenda = $legenda;
    }
    
    public function getNome() {
        return $this->nome;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getTamanho() {
        return $this->tamanho;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setTamanho($tamanho) {
        $this->tamanho = $tamanho;
    }

    public function cadastrar($file,$idanuncio,$destaque) {
        $imagem = new Imagem();
        $imagem->setIdanuncio($idanuncio);
        $url = array_reverse(explode("/", $file->url));
        $imagem->setDiretorio($url[1]);
        $imagem->setLegenda($file->legenda);
        $imagem->setDestaque(($destaque == $file->name)?"SIM":"NÃO");
        $imagem->setNome($file->name);
        $imagem->setTipo($file->type);
        $imagem->setTamanho($file->size);
        return $imagem;
    }

    public function miniatura(){
        $posicao = strripos($this->diretorio,"/") ;
        $diretorio = substr($this->diretorio, 0,$posicao);
        $arquivo = substr($this->diretorio, $posicao+1);
        return $diretorio . "/thumbnail/" . $arquivo;
    }
}
