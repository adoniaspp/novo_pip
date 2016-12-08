<?php

/*
 * Script para exclusão de fotos de anuncios não cadastrados.
 * 
 */

define("PIPROOT", dirname(__FILE__));

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
        $sql = "SELECT * FROM Imagem ORDER BY ID DESC";
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
            self::$instance = new PDO('mysql:host=localhost;dbname=pipturbo', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        } return self::$instance;
    }

}

LimpaImagem::listaDiretorios();
