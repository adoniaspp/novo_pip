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
            
            
            $tiposFinalidades = array(array('Venda', 'casa'), array('Venda', 'apartamentoplanta'), 
                array('Venda', 'apartamento'), array('Venda', 'salacomercial'), array('Venda', 'prediocomercial'),
                array('Venda', 'terreno'), array('Aluguel', 'casa'), array('Aluguel', 'apartamentoplanta'), 
                array('Aluguel', 'apartamento'), array('Aluguel', 'salacomercial'), array('Aluguel', 'prediocomercial'),
                array('Aluguel', 'terreno'));
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
               if(count($preferencia["bairro"]) > 0 && count($preferencia["cidade"]) > 0){
                   $parametros["predicados"] = $preferencia;
                   $parametros["atributos"] = "*"; 
                   $parametros["tabela"] = "todos";                   
                   $listaPreferencias[$i] = $consultasAdHoc->buscaAnuncios($parametros);
                   
                   $i++;
               }        
            } 
            
            
            $ctrl1 = count($listaPreferencias);
            for ($i = 0; $i < $ctrl1; $i++){            
            foreach ($listaAnuncio[anuncio] as $anuncio){
                $idanuncio = $anuncio["idanuncio"];
//                if($idanuncio == 5){
//                       echo '<pre>';
//                        print_r($listaPreferencias[$i]['anuncio']);
//                        die();                 
//                }
                //$ctrl2 = count($listaPreferencias[$i]['anuncio']); 
                $chavesPreferencias = array_keys($listaPreferencias[$i]['anuncio']);
                foreach ($chavesPreferencias as $chave){               
                //for ($j = 0; $j < $ctrl2; $j++){ 
                    //$preferenciaAnuncio = $preferencia[idanuncio];                    
                    if($idanuncio == $listaPreferencias[$i]['anuncio'][$chave][idanuncio]){                        
                        //unset($listaPreferencias[$i]['anuncio'][$j]);                                                
                        unset($listaPreferencias[$i]['anuncio'][$chave]);                       
                        //if(count($listaPreferencias[$i]['anuncio']) == 0){
                        if(count($listaPreferencias[$i]['anuncio']) == 0)
                            {
//                            echo '<pre>';
//                        print_r(count($listaPreferencias[$i]['anuncio']));
//                        die();
                            unset($listaPreferencias[$i]);
                        }
                    }
                }   
            }
            }                
//            echo "<pre>";
//            print_r($listaPreferencias);
//            die();
            return $listaPreferencias;
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
