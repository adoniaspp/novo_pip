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

    public function cadastrar($file,$idanuncio,$destaque) {
        $imagem = new Imagem();
        $imagem->setIdanuncio($idanuncio);
        $imagem->setDiretorio($file->url);
        $imagem->setLegenda($file->legenda);
        $imagem->setDestaque(($destaque == $file->name)?"SIM":"NÃO");
        return $imagem;
    }

    public function miniatura(){
        $posicao = strripos($this->diretorio,"/") ;
        $diretorio = substr($this->diretorio, 0,$posicao);
        $arquivo = substr($this->diretorio, $posicao+1);
        return $diretorio . "/thumbnail/" . $arquivo;
    }
}
