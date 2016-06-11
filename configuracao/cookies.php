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
            $parametros["atributos"] = "*";
            $parametros["tabela"] = "todos";
                        
            $tiposFinalidades = array(array('Venda', 'casa'));
            $i = 0;
            foreach ($tiposFinalidades as $item){  
                $preferencia["bairro"] = array();
                $preferencia["cidade"] = array();
               foreach ($listaAnuncio[anuncio] as $anuncios){
                   if (array_search($item[0], $anuncios) && array_search($item[1], $anuncios)) {
                        array_push($preferencia["bairro"], $anuncios["bairro"]);
                        array_push($preferencia["cidade"], $anuncios["cidade"]);
                        $preferencia["finalidade"] = $item[0];
                        $preferencia["tipo"] = $item[1];                      
                    }
               } 
               if(count($preferencia) > 0){
                   $parametros["predicados"] = $preferencia;
                   $parametros["atributos"] = "*"; 
                   $parametros["tabela"] = "todos";
                   $listaPreferencias[$i] = $consultasAdHoc->buscaAnuncios($parametros);
                   $i++;
               }        
            }
            
            /*Não está eliminando as ocorrências de ids dos cookies do array!!*/
           
            $preferencias = $listaPreferencias[0]['anuncio'];   
            foreach ($listaAnuncio[anuncio] as $anuncio){
                $idanuncio = $anuncio["idanuncio"];
                for ($i = 0; $i < count($listaPreferencias[0]['anuncio']); $i++){
                    if($idanuncio == $preferencias[$i][idanuncio]){ 
                        unset($preferencias[$i]);                                  
                    }
                }   
            }
            return $preferencias;
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
