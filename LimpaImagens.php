<?php

/*
 * Script para exclusão de fotos de anuncios não cadastrados.
 * 
 */

define("PIPROOT", dirname(__FILE__));


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



class LimpaImagem {

    public static $instance;

    public static function listaDiretorios() {

        $listaDiretorios = array();
        $listaBanco = array();

        $dir = PIPROOT . "/fotos/imoveis/";

        if (is_dir($dir)) {
            if ($diretorioImoveis = opendir($dir)) {
                while (($subPastaImovel = readdir($diretorioImoveis)) !== false) {
                    if (($subPastaImovel !== ".") and ( $subPastaImovel !== "..")) {
                        array_push($listaDiretorios, $subPastaImovel);
                    }
                }
                closedir($diretorioImoveis);
            }
        }
        $conexao = LimpaImagem::getInstance();
        $sql = "SELECT * FROM imagem ORDER BY ID DESC";
        $statement = $conexao->prepare($sql);
        $statement->execute();
        $listaImagens = $statement->fetchAll(PDO::FETCH_CLASS, "Imagem");

        foreach ($listaImagens as $imagem) {
            array_push($listaBanco, $imagem->getDiretorio());
        }
        $result = array_diff($listaDiretorios, $listaBanco);

        foreach ($result as $dirExc) {
            LimpaImagem::excluiDir($dir . $dirExc);
        }
    }

    public static function excluiDir($dir) {
        echo $dir."<br>";
        if ($dd = opendir($dir)) {
            while (false !== ($arq = readdir($dd))) {
                if ($arq != "." && $arq != "..") {
                    $path = "$dir/$arq";
                    if (is_dir($path)) {
                        self::excluiDir($path);
                    } elseif (is_file($path)) {
                        unlink($path);
                    }
                }
            }
            closedir($dd);
        }
        rmdir($dir);
    }

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new PDO('mysql:host=179.188.16.95;dbname=pipbeta', 'pipbeta', 'osestudantes1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        } return self::$instance;
    }

}

LimpaImagem::listaDiretorios();
