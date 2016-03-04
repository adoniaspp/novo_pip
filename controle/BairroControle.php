<?php

include_once 'modelo/Bairro.php';
include_once 'modelo/Cidade.php';
include_once 'DAO/GenericoDAO.php';

class BairroControle {
   
    function selecionarBairro($parametros){
        
       $bairro = new Bairro();
        
       $genericoDAO = new GenericoDAO();
        
       $listarBairros = $genericoDAO->consultar($bairro, true, array("idcidade" => $parametros["idcidade"]));
       
       sort($listarBairros); //colocar em ordem crescente pelo nome
       
       foreach ($listarBairros as $valor){
            echo "<option value='".$valor->getId()."' name='sltBairro[]'>".$valor->getNome()."</option>";
       }
        
    }
}
