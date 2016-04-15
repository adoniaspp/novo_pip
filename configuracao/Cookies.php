<?php

include_once 'controle/PreferenciaControle.php';
include_once 'DAO/ConsultasAdHoc.php';

class Cookies {

    public static function consultarPreferencias() {
        $idsanuncio = array();
        if (isset($_COOKIE['pip'])) {
            foreach ($_COOKIE['pip'] as $nome => $valor) {
                array_push($idsanuncio, $valor);
            }  
        $predicados["idanuncio"] = $idsanuncio;
        $consultasAdHoc = new ConsultasAdHoc();
        $parametros["atributos"] = "idanuncio, finalidade, novovalor, valormin, tipo, bairro,"
                . "cidade, estado";
        $parametros["tabela"] = "todos";
        $parametros["predicados"] = $predicados;
        $listaAnuncio = $consultasAdHoc->buscaAnuncios($parametros);
//        echo '<pre>';
//        print_r($listaAnuncio[anuncio]);
//        echo '</pre>';
//        die();
        $parametros["atributos"] = "*";
        $parametros["tabela"] = "todos";
        $predicados = array();
        foreach ($listaAnuncio[anuncio] as $anuncios) {
            $predicados = $predicados + $anuncios;
            foreach ($anuncios as $nome => $valor) {
                $predicados[$nome] = array($valor);
            }
        }
//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';
//        die();
//        $parametros["predicados"] = $predicados;
//        $listaAnuncio = $consultasAdHoc->buscaAnuncios($parametros);
        }
    }

    public static function configurarPreferencias($parametros) {
        $preferencia = new PreferenciaControle();
        if (isset($_COOKIE['pip'])) {
            foreach ($_COOKIE['pip'] as $nome => $valor) {
                if ($valor == $parametros['anuncio'][0]['idanuncio']) {
                    $crtlAnuncio = true;
                }
            }
        } else {
            $crtlAnuncio = false;
        }
        if (!$crtlAnuncio) {
            $codPreferencia = $preferencia->inserir($parametros);
            setcookie('pip[' . $codPreferencia . ']', $parametros['anuncio'][0]['idanuncio']);
        }
    }

}
