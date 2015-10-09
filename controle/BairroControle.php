<?php

include_once 'modelo/Bairro.php';
include_once 'modelo/Cidade.php';
include_once 'DAO/GenericoDAO.php';

class BairroControle {
   
    function selecionarBairro($parametros){
        
       $bairro = new Bairro();
        
       $genericoDAO = new GenericoDAO();
        
       $listarBairros = $genericoDAO->consultar($bairro, true, array("idcidade" => $parametros["idcidade"]));
       echo "<div class='item' data-value=''>Selecione o Bairro</div>\n ";
       foreach ($listarBairros as $valor){
            echo "<div class='item' data-value=".$valor->getId()."'>".$valor->getNome()."</div>\n ";
       }
        
    }
}
