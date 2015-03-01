<?php

include_once 'DAO/GenericoDAO.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Diferencial.php';
include_once 'modelo/TipoImovelDiferencial.php';
include_once 'modelo/ImovelDiferencial.php';

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
    
    function buscarDiferencialChkEdicao($parametros){
       //var_dump($parametros); die();
       $genericoDAO = new GenericoDAO(); 
       $tipoImovelDiferencial = new TipoImovelDiferencial();
       $imovelDiferencial = new ImovelDiferencial();
       
       
       $diferenciais = $genericoDAO->consultar($tipoImovelDiferencial, true, array("idtipoimovel" => $parametros["sltTipo"])); 
       $iDiferenciais = $genericoDAO->consultar($imovelDiferencial, false, array("idimovel" => $_SESSION["imovel"]["id"])); 
       
       
       $totalDiferenciais = count($diferenciais); 
       
       foreach ($iDiferenciais as $iDiferencial){
           $ids[] = $iDiferencial->getIdDiferencial();         
       }
           // var_dump($ids);
      
           /* for($x=0 ; $x < count($ids); $x++){
                //echo "ID: ".$ids[$x]." ";
                foreach ($diferenciais as $diferencial){
                    if($ids[$x] == $diferencial->getDiferencial()->getId()){
                    echo "<div class='ui checkbox'>"
                    . "<input type='checkbox' name='chkDiferencial[]' value='".$diferencial->getDiferencial()->getId()."' checked = 'checked'>"
                    . "<label>".$diferencial->getDiferencial()->getDescricao()." </label>\n
                    </div>";
                    
                    }
                }
            }*/
            
            for($x=0 ; $x <= count($diferenciais); $x++){
                foreach ($diferenciais as $diferencial){
                    if($ids[$x] == $diferencial->getDiferencial()->getId() &&(!empty($ids[$x]))){
                    echo "<div class='ui checkbox'>"
                    . "<input type='checkbox' name='chkDiferencial[]' value='".$diferencial->getDiferencial()->getId()."' checked = 'checked'>"
                    . "<label>".$diferencial->getDiferencial()->getDescricao()." </label>\n
                    </div>";
                    
                    }
                   
                }
               
            }
           
         // echo $diferencial->getDiferencial()->getId();
                 
               /*  foreach ($diferenciais as $diferencial){    
                    echo "<div class='ui checkbox'>"
                  . "<input type='checkbox' name='chkDiferencial[]' value='".$diferencial->getDiferencial()->getId()."' checked = 'checked'>"
                  . "<label>".$diferencial->getDiferencial()->getDescricao()." </label>\n
                  </div>" ;  
                 }*/
                 
                
              
                  
               
         /*  if($ids[] == $diferencial->getDiferencial()->getId()){
               echo "<div class='ui checkbox'>"
              . "<input type='checkbox' name='chkDiferencial[]' value='".$diferencial->getDiferencial()->getId()." checked = 'true'>"
              . "<label>".$diferencial->getDiferencial()->getDescricao()." </label>\n
              </div>" ; 
            } else{
               echo "<div class='ui checkbox'>"
              . "<input type='checkbox' name='chkDiferencial[]' value='".$diferencial->getDiferencial()->getId().">"
              . "<label>".$diferencial->getDiferencial()->getDescricao()." </label>\n
              </div>" ;  
            }
           
                */      
       
    }
    
}
