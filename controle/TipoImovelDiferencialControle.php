<?php

include_once 'DAO/GenericoDAO.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Diferencial.php';
include_once 'modelo/TipoImovelDiferencial.php';

class TipoImovelDiferencialControle {
   
    function buscarDiferencialChk($parametros){
       //var_dump($parametros); die();
       $genericoDAO = new GenericoDAO(); 
       $tipoImovelDiferencial = new TipoImovelDiferencial();
       
       $diferenciais = $genericoDAO->consultar($tipoImovelDiferencial, true, array("idtipoimovel" => $parametros["sltTipo"]));      
       
       foreach ($diferenciais as $diferencial){          
          echo "<div class='ui checkbox'>"
              . "<input type='checkbox' name='chkDiferencial[]' value='".$diferencial->getDiferencial()->getId()."'>"
              . "<label>".$diferencial->getDiferencial()->getDescricao()." </label>\n
              </div>" ;             
       }
    }
    
}
