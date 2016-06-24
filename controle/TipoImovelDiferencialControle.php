<?php

include_once 'DAO/GenericoDAO.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Diferencial.php';
include_once 'modelo/TipoImovelDiferencial.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/ImovelDiferencialPlanta.php';

class TipoImovelDiferencialControle {

    function buscarDiferencialChk($parametros) {

        $genericoDAO = new GenericoDAO();
        $tipoImovelDiferencial = new TipoImovelDiferencial();

        $diferenciais = $genericoDAO->consultar($tipoImovelDiferencial, true, array("idtipoimovel" => $parametros["sltTipo"]));
        
        foreach ($diferenciais as $diferencial) {
            
            echo "<div class='ui checkbox'>"
            . "<input type='checkbox' name='chkDiferencial[]' value='" . $diferencial->getDiferencial()->getId() . "'>"
            . "<label id='diferencial' style='margin-right: 10px;'>" . $diferencial->getDiferencial()->getDescricao() . "</label> &nbsp;\n
              </div>";
                }
        }
    
    function buscarDiferencialChkPlanta($parametros) {

        $genericoDAO = new GenericoDAO();
        
        $consultasAdHoc = new ConsultasAdHoc();
        
        $tipoImovelDiferencial = new TipoImovelDiferencial();

        $diferenciais = $consultasAdHoc->diferencialPlanta();

        $arrayDiferencial = array();
                
        foreach ($diferenciais as $diferencial) {          
      
                $arrayDiferencial[] = array($diferencial["id"] => $diferencial["descricao"]);

        }
        
         echo json_encode(array("Diferenciais" => $arrayDiferencial, "contador" => $parametros["contador"]));
    }

    function buscarDiferencialChkEdicao($parametros) {

        $genericoDAO = new GenericoDAO();
        $tipoImovelDiferencial = new TipoImovelDiferencial();
        $imovelDiferencial = new ImovelDiferencial();


        $diferenciais = $genericoDAO->consultar($tipoImovelDiferencial, true, array("idtipoimovel" => $parametros["sltTipo"]));
        $idDiferenciais = $genericoDAO->consultar($imovelDiferencial, false, array("idimovel" => $_SESSION["imovel"]["id"]));
        $totalDiferenciais = count($diferenciais);

        foreach ($idDiferenciais as $idDiferencial) {
            $listaIDs[] = $idDiferencial->getIdDiferencial();
        }

        foreach ($diferenciais as $diferencial) {
            echo "<div class='ui checkbox'>"
            . "<input type='checkbox' name='chkDiferencial[]' value='" . $diferencial->getDiferencial()->getId() . "'";
            if (in_array($diferencial->getDiferencial()->getId(), $listaIDs)) {
                echo " checked = 'checked'";
            }
            echo "><label id='diferencial' style='margin-right: 10px;'>" . $diferencial->getDiferencial()->getDescricao() ."</label> &nbsp;</div>";
        } 
    }
    
    function buscarDiferencialPlantaChkEdicao($parametros) {

        $genericoDAO = new GenericoDAO();
        $imovelDiferencialPlanta = new ImovelDiferencialPlanta();
                
        $consultasAdHoc = new ConsultasAdHoc();
        
        $tipoImovelDiferencial = new TipoImovelDiferencial();

        $diferenciais = $consultasAdHoc->diferencialPlanta();
        
        $idDiferenciaisPlanta = $genericoDAO->consultar($imovelDiferencialPlanta, true, array("idplanta" => $parametros["idPlanta"]));

        foreach ($idDiferenciaisPlanta as $idDiferencialPlanta) {
            $listaIDs[] = $idDiferencialPlanta->getIdDiferencial();          
        }
        $arrayDiferencial;
        $arrayChecked = array();
        foreach ($diferenciais as $diferencial) {          
      
                $arrayDiferencial[] = array($diferencial["id"] => $diferencial["descricao"]);
                $arrayChecked[$diferencial["id"]] = in_array($diferencial["id"], $listaIDs);

        }
        
         echo json_encode(array("Diferenciais" => $arrayDiferencial, "contador" => $parametros["contador"], "selecionar" => $arrayChecked));
    }
    
    function buscarDiferencialLista($parametros) {
        $genericoDAO = new GenericoDAO();
        $tipoImovelDiferencial = new TipoImovelDiferencial();
            
            switch ($parametros["sltTipoImovel"]) {
                                case "casa":
                                     $parametros["sltTipoImovel"] = 1; 
                                     break;
                                case "apartamentoplanta":
                                     $parametros["sltTipoImovel"] = 2; 
                                     break;
                                case "apartamento":
                                     $parametros["sltTipoImovel"] = 3; 
                                     break;                               
                                case "salacomercial":
                                     $parametros["sltTipoImovel"] = 4; 
                                     break;
                                case "prediocomercial":
                                     $parametros["sltTipoImovel"] = 5; 
                                     break;
                                case "terreno":
                                     $parametros["sltTipoImovel"] = 6; 
                                     break;
                                }
                                
        
        $diferenciais = $genericoDAO->consultar($tipoImovelDiferencial, true, array("idtipoimovel" => $parametros["sltTipoImovel"]));
        
        foreach ($diferenciais as $diferencial) {
            
            echo "<option value='".$diferencial->getDiferencial()->getId()."' name='sltDiferencial[]'>".$diferencial->getDiferencial()->getDescricao()."</option>";
      
        }
    }

}
