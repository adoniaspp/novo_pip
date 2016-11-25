<?php

/*
 * Script para exclusão de fotos de anuncios não cadastrados.
 * 
 */

include_once '../DAO/GenericoDAO.php';

class LimpaImagem{

    public static function listaDiretorios() {

        $listaDiretorios = array();
        $listaBanco = array();

        $dir = PIPROOT . "/fotos/imoveis/";
        
        if (is_dir($dir)) {
        if ($diretorioImoveis = opendir($dir)) {
            while (($subPastaImovel = readdir($diretorioImoveis)) !== false) {
                if (($subPastaImovel !== ".") and ($subPastaImovel !== "..")) {
                    array_push($listaDiretorios, $subPastaImovel);
                }
            }
            closedir($diretorioImoveis);
        }
        }
        $genericoDAO = new GenericoDAO();
        $listaImagens = $genericoDAO->consultar(new Imagem(), false);
        foreach ($listaImagens as $imagem) {
            array_push($listaBanco, $imagem->getDiretorio());
        }
        $result = array_diff($listaDiretorios, $listaBanco);

        foreach ($result as $dirExc){
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

}
