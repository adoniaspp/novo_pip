<?php

include_once 'modelo/Bairro.php';
include_once 'modelo/Cidade.php';
include_once 'DAO/GenericoDAO.php';

class BairroControle {
   
    function selecionarBairro($parametros){
        
       $bairro = new Bairro();
        
       $genericoDAO = new GenericoDAO();
        
       $listarBairros = $genericoDAO->consultar($bairro, true, array("idcidade" => $parametros["idcidade"]));
       
       usort($listarBairros, function( $a, $b ) { //ordenar por ordem alfabética

           return (strtr(

                $a->getNome(),

                array (

                  'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
                  'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
                  'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
                  'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
                  'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U'
                )
            ) > strtr(

                $b->getNome(),

                array (

                  'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
                  'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
                  'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
                  'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
                  'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U'
                )
            ));
            
       });   
       
       
       foreach ($listarBairros as $valor){

            echo '<div class="item" data-value="'.$valor->getId().'">'.$valor->getNome().'</div>';
            
       }
        
    }
}
