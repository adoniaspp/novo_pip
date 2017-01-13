<?php

include_once 'modelo/Bairro.php';
include_once 'modelo/Cidade.php';
include_once 'DAO/GenericoDAO.php';

class BairroControle {
   
    function selecionarBairro($parametros){
        
       $bairro = new Bairro();
        
       $genericoDAO = new GenericoDAO();
        
       $listarBairros = $genericoDAO->consultar($bairro, true, array("idcidade" => $parametros["idcidade"]));
       
       foreach ($listarBairros as $valor){
            echo '<div class="item" data-value="'.$valor->getId().'">'.$valor->getNome().'</div>';
            //echo "<option value='".$valor->getId()."' name='sltBairro[]'>".$valor->getNome()."</option>";
       }
        
    }
}
